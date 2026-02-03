<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ppdb;
use App\Support\ActivityLogger;
use Illuminate\Http\Request;

class PpdbController extends Controller
{
    public function index()
    {
        $ppdbs = Ppdb::latest()->paginate(10);
        return view('admin.ppdb.index', compact('ppdbs'));
    }

    public function create()
    {
        return view('admin.ppdb.create', ['ppdb' => new Ppdb()]);
    }

    public function store(Request $request)
    {
        $data = $this->validatedData($request);
        $ppdb = Ppdb::create($data);

        ActivityLogger::log('ppdb.created', 'Menambahkan info PPDB: ' . $ppdb->judul);

        return redirect()->route('admin.ppdb.index')->with('success', 'Informasi PPDB berhasil ditambahkan.');
    }

    public function edit(Ppdb $ppdb)
    {
        return view('admin.ppdb.edit', compact('ppdb'));
    }

    public function update(Request $request, Ppdb $ppdb)
    {
        $data = $this->validatedData($request);
        $ppdb->update($data);

        ActivityLogger::log('ppdb.updated', 'Memperbarui info PPDB: ' . $ppdb->judul);

        return redirect()->route('admin.ppdb.index')->with('success', 'Informasi PPDB berhasil diperbarui.');
    }

    public function destroy(Ppdb $ppdb)
    {
        $ppdb->delete();

        ActivityLogger::log('ppdb.deleted', 'Menghapus info PPDB: ' . $ppdb->judul);

        return redirect()->route('admin.ppdb.index')->with('success', 'Informasi PPDB berhasil dihapus.');
    }

    private function validatedData(Request $request): array
    {
        return $request->validate([
            'judul' => ['required', 'string', 'max:255'],
            'konten' => ['nullable', 'string'],
            'status' => ['required', 'in:buka,tutup'],
            'link_daftar' => ['nullable', 'url'],
        ]);
    }
}
