<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FormerPrincipal;
use App\Services\MediaService;
use App\Support\ActivityLogger;
use Illuminate\Http\Request;

class FormerPrincipalController extends Controller
{
    public function __construct(private MediaService $media)
    {
    }

    public function index()
    {
        $principals = FormerPrincipal::orderBy('sort_order')->orderByDesc('id')->get();

        return view('admin.former-principals.index', compact('principals'));
    }

    public function create()
    {
        return view('admin.former-principals.create');
    }

    public function store(Request $request)
    {
        $data = $this->validatedData($request);

        if ($request->hasFile('photo')) {
            $data['photo_path'] = $this->media->storeImage($request->file('photo'), 'former-principals');
        }

        unset($data['photo']);

        $principal = FormerPrincipal::create($data);

        ActivityLogger::log('principal.created', 'Menambahkan data kepala sekolah terdahulu: ' . $principal->name);

        return redirect()->route('admin.former-principals.index')->with('success', 'Data berhasil ditambahkan.');
    }

    public function edit(FormerPrincipal $formerPrincipal)
    {
        return view('admin.former-principals.edit', ['principal' => $formerPrincipal]);
    }

    public function update(Request $request, FormerPrincipal $formerPrincipal)
    {
        $data = $this->validatedData($request, false);

        if ($request->hasFile('photo')) {
            $this->media->delete($formerPrincipal->photo_path);
            $data['photo_path'] = $this->media->storeImage($request->file('photo'), 'former-principals');
        }

        unset($data['photo']);

        $formerPrincipal->update($data);

        ActivityLogger::log('principal.updated', 'Memperbarui data kepala sekolah terdahulu: ' . $formerPrincipal->name);

        return redirect()->route('admin.former-principals.index')->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy(FormerPrincipal $formerPrincipal)
    {
        $this->media->delete($formerPrincipal->photo_path);
        $formerPrincipal->delete();

        ActivityLogger::log('principal.deleted', 'Menghapus data kepala sekolah terdahulu: ' . $formerPrincipal->name);

        return redirect()->route('admin.former-principals.index')->with('success', 'Data berhasil dihapus.');
    }

    private function validatedData(Request $request, bool $isCreate = true): array
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'period' => ['nullable', 'string', 'max:100'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:999'],
            'description' => ['nullable', 'string'],
            'photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
        ];

        if ($isCreate) {
            $rules['photo'][0] = 'nullable';
        }

        $data = $request->validate($rules);
        $data['sort_order'] = $data['sort_order'] ?? ((FormerPrincipal::max('sort_order') ?? 0) + 1);

        return $data;
    }
}
