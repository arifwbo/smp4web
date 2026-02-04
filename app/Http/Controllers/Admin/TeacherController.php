<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use App\Support\ActivityLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TeacherController extends Controller
{
    public function index()
    {
        $teachers = Teacher::latest()->paginate(10);
        return view('admin.teachers.index', compact('teachers'));
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
            'file' => ['required', 'file', 'mimes:csv,txt'],
        ]);

        $file = $request->file('file');
        $handle = fopen($file->getRealPath(), 'r');

        if (! $handle) {
            return redirect()->route('admin.teachers.index')->with('error', 'File tidak dapat dibaca.');
        }

        $header = null;
        $imported = 0;
        $skipped = 0;
        $requiredColumns = ['nama', 'jenis'];

        while (($row = fgetcsv($handle, 0, ',')) !== false) {
            if (! $header) {
                $header = collect($row)
                    ->map(fn ($value) => strtolower(trim($value)))
                    ->filter()
                    ->values()
                    ->toArray();

                $missing = array_diff($requiredColumns, $header);
                if (! empty($missing)) {
                    fclose($handle);
                    return redirect()->route('admin.teachers.index')->with('error', 'Kolom wajib (nama, jenis) tidak ditemukan pada baris header.');
                }
                continue;
            }

            if (count(array_filter($row)) === 0) {
                continue;
            }

            $data = [];
            foreach ($header as $index => $column) {
                $data[$column] = trim($row[$index] ?? '');
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

        fclose($handle);

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
}
