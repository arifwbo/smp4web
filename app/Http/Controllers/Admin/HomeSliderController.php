<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomeSlider;
use App\Services\MediaService;
use App\Support\ActivityLogger;
use Illuminate\Http\Request;

class HomeSliderController extends Controller
{
    public function __construct(private MediaService $mediaService)
    {
    }

    public function index()
    {
        $sliders = HomeSlider::orderBy('sort_order')->get();

        return view('admin.home-sliders.index', compact('sliders'));
    }

    public function create()
    {
        return view('admin.home-sliders.create');
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request, true);

        $imageFile = $request->file('image');
        $data['image_path'] = $this->mediaService->storeImage($imageFile, 'home-sliders');
        unset($data['image']);
        $data['sort_order'] = $data['sort_order'] ?? ((HomeSlider::max('sort_order') ?? 0) + 1);
        $data['is_active'] = $request->boolean('is_active', true);

        HomeSlider::create($data);

        ActivityLogger::log('slider.created', 'Menambahkan slider beranda baru');

        cache()->forget('home_sliders');

        return redirect()->route('admin.home-sliders.index')->with('success', 'Slider berhasil ditambahkan.');
    }

    public function edit(HomeSlider $homeSlider)
    {
        return view('admin.home-sliders.edit', ['slider' => $homeSlider]);
    }

    public function update(Request $request, HomeSlider $homeSlider)
    {
        $data = $this->validateData($request, false);

        if ($request->hasFile('image')) {
            $this->mediaService->delete($homeSlider->image_path);
            $data['image_path'] = $this->mediaService->storeImage($request->file('image'), 'home-sliders');
        }

        unset($data['image']);
        $data['is_active'] = $request->boolean('is_active');
        $homeSlider->update($data);

        ActivityLogger::log('slider.updated', 'Memperbarui slider beranda #' . $homeSlider->id);

        cache()->forget('home_sliders');

        return redirect()->route('admin.home-sliders.index')->with('success', 'Slider berhasil diperbarui.');
    }

    public function destroy(HomeSlider $homeSlider)
    {
        $this->mediaService->delete($homeSlider->image_path);
        $homeSlider->delete();

        ActivityLogger::log('slider.deleted', 'Menghapus slider beranda #' . $homeSlider->id);

        cache()->forget('home_sliders');

        return redirect()->route('admin.home-sliders.index')->with('success', 'Slider berhasil dihapus.');
    }

    private function validateData(Request $request, bool $isCreate): array
    {
        $rules = [
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'button_label' => 'nullable|string|max:100',
            'button_link' => 'nullable|url|max:255',
            'sort_order' => 'nullable|integer|min:0|max:999',
            'is_active' => 'nullable|boolean',
        ];

        $imageRule = 'image|mimes:jpg,jpeg,png,webp|max:4096|dimensions:min_width=1600,min_height=900';
        $rules['image'] = $isCreate ? 'required|' . $imageRule : 'nullable|' . $imageRule;

        $messages = [
            'image.dimensions' => 'Minimal ukuran gambar 1600x900 piksel (disarankan 1920x1080).',
        ];

        return $request->validate($rules, $messages);
    }
}
