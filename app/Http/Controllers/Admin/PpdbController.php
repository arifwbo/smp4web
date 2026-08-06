<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ppdb;
use App\Services\MediaService;
use App\Support\ActivityLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class PpdbController extends Controller
{
    public function __construct(private MediaService $mediaService)
    {
    }

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
        $validated = $this->validatedData($request);
        $data = Arr::only($validated, ['judul', 'konten', 'status']);

        $attachments = $this->prepareAttachments($request);
        $links = $this->prepareLinks($request);

        $this->syncResourceFields($data, $attachments, $links);

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
        $validated = $this->validatedData($request);
        $data = Arr::only($validated, ['judul', 'konten', 'status']);

        $attachments = $this->prepareAttachments($request, $ppdb);
        $links = $this->prepareLinks($request, $ppdb);

        $this->syncResourceFields($data, $attachments, $links);

        $ppdb->update($data);

        ActivityLogger::log('ppdb.updated', 'Memperbarui info PPDB: ' . $ppdb->judul);

        return redirect()->route('admin.ppdb.index')->with('success', 'Informasi PPDB berhasil diperbarui.');
    }

    public function destroy(Ppdb $ppdb)
    {
        $this->purgeAllAttachments($ppdb);
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
            'existing_attachments' => ['sometimes', 'array'],
            'existing_attachments.*.label' => ['nullable', 'string', 'max:255'],
            'existing_attachments.*.path' => ['nullable', 'string'],
            'existing_attachments.*.delete' => ['nullable', 'boolean'],
            'lampiran_labels' => ['sometimes', 'array'],
            'lampiran_labels.*' => ['nullable', 'string', 'max:255'],
            'lampiran_files' => ['sometimes', 'array'],
            'lampiran_files.*' => ['nullable', 'file', 'mimes:pdf', 'max:5120'],
            'existing_links' => ['sometimes', 'array'],
            'existing_links.*.label' => ['nullable', 'string', 'max:255'],
            'existing_links.*.url' => ['nullable', 'url'],
            'existing_links.*.delete' => ['nullable', 'boolean'],
            'link_labels' => ['sometimes', 'array'],
            'link_labels.*' => ['nullable', 'string', 'max:255'],
            'link_urls' => ['sometimes', 'array'],
            'link_urls.*' => ['nullable', 'url'],
        ]);
    }

    private function prepareAttachments(Request $request, ?Ppdb $ppdb = null): array
    {
        $attachments = [];
        $existingItems = $ppdb?->lampiran_items ?? [];
        $existingPayload = $request->input('existing_attachments', []);

        foreach ($existingItems as $index => $item) {
            $payload = $existingPayload[$index] ?? null;

            if (! empty($payload['delete'])) {
                $this->mediaService->delete($item['path'] ?? null);
                continue;
            }

            $attachments[] = [
                'label' => $payload['label'] ?? ($item['label'] ?? 'Lampiran ' . ($index + 1)),
                'path' => $item['path'] ?? null,
            ];
        }

        $newLabels = $request->input('lampiran_labels', []);
        $newFiles = $request->file('lampiran_files', []);

        foreach ($newFiles as $idx => $file) {
            if (! $file) {
                continue;
            }

            $label = $newLabels[$idx] ?? 'Lampiran ' . (count($attachments) + 1);
            $path = $this->mediaService->storeFile($file, 'ppdb');

            $attachments[] = [
                'label' => $label,
                'path' => $path,
            ];
        }

        return array_values(array_filter($attachments, fn ($item) => ! empty($item['path'])));
    }

    private function prepareLinks(Request $request, ?Ppdb $ppdb = null): array
    {
        $links = [];
        $existingItems = $ppdb?->link_items ?? [];
        $existingPayload = $request->input('existing_links', []);

        foreach ($existingItems as $index => $item) {
            $payload = $existingPayload[$index] ?? null;

            if (! empty($payload['delete'])) {
                continue;
            }

            $url = $payload['url'] ?? ($item['url'] ?? null);

            if (! $url) {
                continue;
            }

            $links[] = [
                'label' => $payload['label'] ?? ($item['label'] ?? 'Tautan ' . ($index + 1)),
                'url' => $url,
            ];
        }

        $newLabels = $request->input('link_labels', []);
        $newUrls = $request->input('link_urls', []);

        foreach ($newUrls as $idx => $url) {
            if (! $url) {
                continue;
            }

            $label = $newLabels[$idx] ?? 'Tautan ' . (count($links) + 1);
            $links[] = [
                'label' => $label,
                'url' => $url,
            ];
        }

        return array_values($links);
    }

    private function syncResourceFields(array &$data, array $attachments, array $links): void
    {
        $data['lampiran_items'] = $attachments;
        $data['link_items'] = $links;
        $data['lampiran_path'] = $attachments[0]['path'] ?? null;
        $data['link_daftar'] = $links[0]['url'] ?? null;
    }

    private function purgeAllAttachments(Ppdb $ppdb): void
    {
        foreach ($ppdb->lampiran_items ?? [] as $item) {
            $this->mediaService->delete($item['path'] ?? null);
        }

        $this->mediaService->delete($ppdb->lampiran_path);
    }
}
