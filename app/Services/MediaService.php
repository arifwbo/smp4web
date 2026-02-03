<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MediaService
{
    public function storeImage(UploadedFile $file, string $collection): string
    {
        $folder = 'media/' . trim($collection, '/') . '/' . now()->format('Y/m');
        $filename = Str::uuid()->toString() . '.' . $file->getClientOriginalExtension();

        return $file->storeAs($folder, $filename, 'public');
    }

    public function delete(?string $path): void
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }

    public function generateFavicon(string $relativePath, int $size = 64): ?string
    {
        $disk = Storage::disk('public');

        if (! $disk->exists($relativePath)) {
            return null;
        }

        $imageData = $disk->get($relativePath);
        $source = $this->createImageResource($imageData);

        if (! $source) {
            return null;
        }

        $size = max(16, min(256, $size));
        $canvas = imagecreatetruecolor($size, $size);
        imagesavealpha($canvas, true);
        $transparent = imagecolorallocatealpha($canvas, 0, 0, 0, 127);
        imagefill($canvas, 0, 0, $transparent);
        imagecopyresampled($canvas, $source, 0, 0, 0, 0, $size, $size, imagesx($source), imagesy($source));

        ob_start();
        imagepng($canvas);
        $pngData = ob_get_clean();
        imagedestroy($source);
        imagedestroy($canvas);

        $icoData = pack('vvv', 0, 1, 1);
        $icoData .= pack('CCCCvvVV', $size === 256 ? 0 : $size, $size === 256 ? 0 : $size, 0, 0, 1, 32, strlen($pngData), 6 + 16);
        $icoData .= $pngData;

        $faviconPath = 'branding/favicon.ico';
        $disk->put($faviconPath, $icoData);

        return $faviconPath;
    }

    private function createImageResource(string $imageData)
    {
        $error = null;

        set_error_handler(function ($severity, $message) use (&$error) {
            $error = $message;

            return true;
        });

        try {
            $resource = imagecreatefromstring($imageData);
        } finally {
            restore_error_handler();
        }

        if ($error) {
            Log::warning('Favicon generation warning: ' . $error);
        }

        return $resource ?: null;
    }
}
