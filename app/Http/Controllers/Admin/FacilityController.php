<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Facility;
use App\Services\MediaService;
use App\Support\ActivityLogger;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class FacilityController extends Controller
{
    public function __construct(private MediaService $mediaService)
    {
    }

    public function index()
    {
        $facilities = Facility::latest()->paginate(12);
        return view('admin.facilities.index', compact('facilities'));
    }

    public function create()
    {
        return view('admin.facilities.create', [
            'facility' => new Facility(),
            'categories' => Facility::categoryMeta(),
            'conditions' => Facility::conditionMeta(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validatedData($request);

        if ($request->hasFile('foto')) {
            $data['foto_path'] = $this->mediaService->storeImage($request->file('foto'), 'facilities');
        }

        $facility = Facility::create($data);

        ActivityLogger::log('facility.created', 'Menambahkan fasilitas: ' . $facility->nama);

        return redirect()->route('admin.facilities.index')->with('success', 'Fasilitas berhasil ditambahkan.');
    }

    public function edit(Facility $facility)
    {
        return view('admin.facilities.edit', [
            'facility' => $facility,
            'categories' => Facility::categoryMeta(),
            'conditions' => Facility::conditionMeta(),
        ]);
    }

    public function update(Request $request, Facility $facility)
    {
        $data = $this->validatedData($request);

        if ($request->hasFile('foto')) {
            $this->mediaService->delete($facility->foto_path);
            $data['foto_path'] = $this->mediaService->storeImage($request->file('foto'), 'facilities');
        }

        $facility->update($data);

        ActivityLogger::log('facility.updated', 'Memperbarui fasilitas: ' . $facility->nama);

        return redirect()->route('admin.facilities.index')->with('success', 'Fasilitas berhasil diperbarui.');
    }

    public function destroy(Facility $facility)
    {
        $this->mediaService->delete($facility->foto_path);
        $facility->delete();

        ActivityLogger::log('facility.deleted', 'Menghapus fasilitas: ' . $facility->nama);

        return redirect()->route('admin.facilities.index')->with('success', 'Fasilitas berhasil dihapus.');
    }

    private function validatedData(Request $request): array
    {
        $categoryKeys = array_keys(Facility::categoryMeta());
        $conditionKeys = array_keys(Facility::conditionMeta());

        $data = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'kategori' => ['required', Rule::in($categoryKeys)],
            'deskripsi' => ['nullable', 'string'],
            'jumlah' => ['nullable', 'integer', 'min:0', 'max:500'],
            'kondisi' => ['required', Rule::in($conditionKeys)],
            'status_publish' => ['nullable', 'boolean'],
            'foto' => ['nullable', 'image', 'max:2048'],
        ]);

        $data['status_publish'] = $request->boolean('status_publish', true);

        return $data;
    }
}
