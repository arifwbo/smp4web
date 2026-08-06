<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ApplicationLink;
use App\Services\MediaService;
use App\Support\ActivityLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ApplicationLinkController extends Controller
{
    public function __construct(private MediaService $mediaService)
    {
    }

    public function index()
    {
        $applications = ApplicationLink::orderBy('sort_order')->orderBy('title')->paginate(12);

        return view('admin.application-links.index', compact('applications'));
    }

    public function create()
    {
        return view('admin.application-links.create', [
            'application' => new ApplicationLink(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validatedData($request);

        if ($request->hasFile('image')) {
            $data['image_path'] = $this->mediaService->storeImage($request->file('image'), 'application-links');
        }

        $application = ApplicationLink::create($data);

        ActivityLogger::logModelChange('application_link.created', 'Menambahkan portal: ' . $application->title, $application);

        return redirect()->route('admin.application-links.index')->with('success', 'Portal aplikasi berhasil ditambahkan.');
    }

    public function edit(ApplicationLink $application_link)
    {
        return view('admin.application-links.edit', [
            'application' => $application_link,
        ]);
    }

    public function update(Request $request, ApplicationLink $application_link)
    {
        $data = $this->validatedData($request);

        if ($request->hasFile('image')) {
            $this->mediaService->delete($application_link->image_path);
            $data['image_path'] = $this->mediaService->storeImage($request->file('image'), 'application-links');
        }

        $before = $application_link->replicate();
        $application_link->update($data);

        ActivityLogger::log('application_link.updated', 'Memperbarui portal: ' . $application_link->title, null, $before->toArray(), $application_link->fresh()->toArray());

        return redirect()->route('admin.application-links.index')->with('success', 'Portal aplikasi berhasil diperbarui.');
    }

    public function destroy(ApplicationLink $application_link)
    {
        $before = $application_link->toArray();
        $this->mediaService->delete($application_link->image_path);
        $application_link->delete();

        ActivityLogger::log('application_link.deleted', 'Menghapus portal: ' . $application_link->title, null, $before, null);

        return redirect()->route('admin.application-links.index')->with('success', 'Portal aplikasi berhasil dihapus.');
    }

    private function validatedData(Request $request): array
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:120'],
            'description' => ['nullable', 'string', 'max:500'],
            'link_url' => ['required', 'url'],
            'button_label' => ['nullable', 'string', 'max:60'],
            'accent_color' => ['nullable', 'string', 'max:20', 'regex:/^#?[0-9a-fA-F]{3,6}$/'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:999'],
            'is_active' => ['nullable', 'boolean'],
            'image' => ['nullable', 'image', 'max:2048'],
        ], [
            'accent_color.regex' => 'Gunakan format hex, contoh: #0F172A.',
        ]);

        $data['is_active'] = $request->boolean('is_active', true);
        $data['button_label'] = $data['button_label'] ?? 'Buka Aplikasi';
        $data['accent_color'] = $data['accent_color'] ? (Str::startsWith($data['accent_color'], '#') ? $data['accent_color'] : '#' . $data['accent_color']) : null;
        $data['sort_order'] = $data['sort_order'] ?? 0;

        return $data;
    }
}
