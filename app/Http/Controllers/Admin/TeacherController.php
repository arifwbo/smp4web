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
}
