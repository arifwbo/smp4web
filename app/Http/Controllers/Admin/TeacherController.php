<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use App\Support\ActivityLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;

class TeacherController extends Controller
{
    public function index(Request $request)
    {
        $query = Teacher::query();

        if ($search = $request->query('q')) {
            $query->where(function ($builder) use ($search) {
                $builder->where('nama', 'like', "%{$search}%")
                    ->orWhere('nip', 'like', "%{$search}%")
                    ->orWhere('jabatan', 'like', "%{$search}%");
            });
        }

        $sort = $request->query('sort', 'latest');
        switch ($sort) {
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'name_asc':
                $query->orderBy('nama', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('nama', 'desc');
                break;
            case 'jenis':
                $query->orderBy('jenis')->orderBy('nama');
                break;
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        $teachers = $query->paginate(10)->withQueryString();

        return view('admin.teachers.index', [
            'teachers' => $teachers,
            'search' => $search,
            'sort' => $sort,
        ]);
    }

    public function create()
    {
        return view('admin.teachers.create', ['teacher' => new Teacher()]);
    }

    public function store(Request $request)
    {
        $data = $this->validatedData($request);

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('teachers', 'public');
        }

        $teacher = Teacher::create($data);

        ActivityLogger::log('teacher.created', 'Menambahkan guru: ' . $teacher->nama);

        return redirect()->route('admin.teachers.index')->with('success', 'Guru berhasil ditambahkan.');
    }

    public function edit(Teacher $teacher)
    {
        return view('admin.teachers.edit', compact('teacher'));
    }

    public function update(Request $request, Teacher $teacher)
    {
        $data = $this->validatedData($request);

        if ($request->hasFile('foto')) {
            if ($teacher->foto) {
                Storage::disk('public')->delete($teacher->foto);
            }
            $data['foto'] = $request->file('foto')->store('teachers', 'public');
        }

        $teacher->update($data);

        ActivityLogger::log('teacher.updated', 'Memperbarui guru: ' . $teacher->nama);

        return redirect()->route('admin.teachers.index')->with('success', 'Guru berhasil diperbarui.');
    }

    public function destroy(Teacher $teacher)
    {
        if ($teacher->foto) {
            Storage::disk('public')->delete($teacher->foto);
        }

        $teacher->delete();

        ActivityLogger::log('teacher.deleted', 'Menghapus guru: ' . $teacher->nama);

        return redirect()->route('admin.teachers.index')->with('success', 'Guru berhasil dihapus.');
    }

    public function bulkDestroy(Request $request)
    {
        $data = $request->validate([
            'ids' => ['required', 'array'],
            'ids.*' => ['integer', 'exists:teachers,id'],
        ]);

        $teachers = Teacher::whereIn('id', $data['ids'])->get();
        $deleted = 0;

        foreach ($teachers as $teacher) {
            if ($teacher->foto) {
                Storage::disk('public')->delete($teacher->foto);
            }

            $teacher->delete();
            $deleted++;
        }

        if ($deleted > 0) {
            ActivityLogger::log('teacher.bulk_deleted', "Menghapus {$deleted} guru/tendik secara massal");
        }

        return redirect()->route('admin.teachers.index')->with('success', "{$deleted} data berhasil dihapus.");
    }

    private function validatedData(Request $request): array
    {
        return $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'nip' => ['nullable', 'string', 'max:50'],
            'jabatan' => ['nullable', 'string', 'max:255'],
            'jenis' => ['required', 'in:pendidik,tendik'],
            'foto' => ['nullable', 'image', 'max:2048'],
        ]);
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => ['required', 'file', 'mimetypes:text/csv,text/plain,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'mimes:csv,txt,xlsx'],
        ]);

        $file = $request->file('file');
        $extension = strtolower($file->getClientOriginalExtension() ?: $file->extension());

        $rows = $this->extractRows($file->getRealPath(), $extension);

        if ($rows->isEmpty()) {
            return redirect()->route('admin.teachers.index')->with('error', 'File tidak dapat dibaca atau kosong.');
        }

        $header = null;
        $imported = 0;
        $skipped = 0;
        $requiredColumns = ['nama', 'jenis'];

        foreach ($rows as $row) {
            if (! $header) {
                $header = collect($row)
                    ->map(fn ($value) => strtolower(trim((string) $value)))
                    ->filter()
                    ->values()
                    ->toArray();

                $missing = array_diff($requiredColumns, $header);
                if (! empty($missing)) {
                    return redirect()->route('admin.teachers.index')->with('error', 'Kolom wajib (nama, jenis) tidak ditemukan pada baris header.');
                }
                continue;
            }

            if (count(array_filter($row, fn ($value) => $value !== null && trim((string) $value) !== '')) === 0) {
                continue;
            }

            $data = [];
            foreach ($header as $index => $column) {
                $data[$column] = isset($row[$index]) ? trim((string) $row[$index]) : '';
            }

            $payload = [
                'nama' => $data['nama'] ?? '',
                'nip' => $data['nip'] ?? null,
                'jabatan' => $data['jabatan'] ?? null,
                'jenis' => strtolower($data['jenis'] ?? ''),
            ];

            if ($payload['nama'] === '' || ! in_array($payload['jenis'], ['pendidik', 'tendik'], true)) {
                $skipped++;
                continue;
            }

            $payload['nip'] = $payload['nip'] !== '' ? $payload['nip'] : null;
            $payload['jabatan'] = $payload['jabatan'] !== '' ? $payload['jabatan'] : null;

            $criteria = $payload['nip']
                ? ['nip' => $payload['nip']]
                : ['nama' => $payload['nama'], 'jenis' => $payload['jenis']];

            Teacher::updateOrCreate($criteria, $payload);
            $imported++;
        }

        if ($imported > 0) {
            ActivityLogger::log('teacher.imported', "Import massal guru/tendik: {$imported} baris.");
        }

        $message = $imported > 0
            ? "{$imported} data berhasil diimpor."
            : 'Tidak ada data yang diimpor.';
        if ($skipped) {
            $message .= " {$skipped} baris dilewati karena tidak valid.";
        }

        return redirect()->route('admin.teachers.index')->with('success', $message);
    }

    private function extractRows(string $path, string $extension)
    {
        try {
            if ($extension === 'xlsx') {
                return $this->extractSpreadsheetRows($path);
            }

            return $this->extractCsvRows($path);
        } catch (\Throwable $exception) {
            report($exception);
            return collect();
        }
    }

    private function extractCsvRows(string $path)
    {
        $rows = collect();
        $handle = fopen($path, 'r');

        if (! $handle) {
            return collect();
        }

        while (($row = fgetcsv($handle, 0, ',')) !== false) {
            $rows->push($row);
        }

        fclose($handle);

        return $rows;
    }

    private function extractSpreadsheetRows(string $path)
    {
        $spreadsheet = IOFactory::load($path);
        $worksheet = $spreadsheet->getActiveSheet();

        return collect($worksheet->toArray(null, true, true, true))
            ->map(fn ($row) => array_values($row));
    }
}
