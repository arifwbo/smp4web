<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Facility;
use App\Support\ActivityLogger;
use Illuminate\Http\Request;

class FacilityController extends Controller
{
    public function index()
    {
        $facilities = Facility::latest()->paginate(10);
        return view('admin.facilities.index', compact('facilities'));
    }

    public function create()
    {
        return view('admin.facilities.create', ['facility' => new Facility()]);
    }

    public function store(Request $request)
    {
        $data = $this->validatedData($request);
        $facility = Facility::create($data);

        ActivityLogger::log('facility.created', 'Menambahkan fasilitas: ' . $facility->nama);

        return redirect()->route('admin.facilities.index')->with('success', 'Fasilitas berhasil ditambahkan.');
    }

    public function edit(Facility $facility)
    {
        return view('admin.facilities.edit', compact('facility'));
    }

    public function update(Request $request, Facility $facility)
    {
        $data = $this->validatedData($request);
        $facility->update($data);

        ActivityLogger::log('facility.updated', 'Memperbarui fasilitas: ' . $facility->nama);

        return redirect()->route('admin.facilities.index')->with('success', 'Fasilitas berhasil diperbarui.');
    }

    public function destroy(Facility $facility)
    {
        $facility->delete();

        ActivityLogger::log('facility.deleted', 'Menghapus fasilitas: ' . $facility->nama);

        return redirect()->route('admin.facilities.index')->with('success', 'Fasilitas berhasil dihapus.');
    }

    private function validatedData(Request $request): array
    {
        return $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'string'],
        ]);
    }
}
