<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageOptimizer
{
    /**
     * Simpan gambar teroptimasi (resize + hapus metadata EXIF) ke storage publik.
     *
     * @return string path relatif (mis. "posts/abc123.jpg")
     */
    public static function optimize(UploadedFile $file, string $dir, int $maxWidth = 1280, int $quality = 82): string
    {
        $ext = match ($file->getClientOriginalExtension()) {
            'png' => 'png',
            'webp' => 'webp',
            default => 'jpg',
        };

        $name = $dir.'/'.Str::random(24).'.'.$ext;
        $disk = Storage::disk('public');

        $image = imagecreatefromstring($file->getContent());

        if ($image === false) {
            $disk->put($name, $file->getContent());

            return $name;
        }

        $width = imagesx($image);
        $height = imagesy($image);

        if ($width > $maxWidth) {
            $ratio = $maxWidth / $width;
            $newWidth = $maxWidth;
            $newHeight = (int) round($height * $ratio);

            $resized = imagecreatetruecolor($newWidth, $newHeight);

            if ($ext === 'png') {
                imagealphablending($resized, false);
                imagesavealpha($resized, true);
            }

            imagecopyresampled($resized, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
            imagedestroy($image);
            $image = $resized;
        }

        ob_start();

        if ($ext === 'png') {
            imagepng($image);
        } elseif ($ext === 'webp') {
            imagewebp($image, null, $quality);
        } else {
            imagejpeg($image, null, $quality);
        }

        $contents = ob_get_clean();
        imagedestroy($image);

        $disk->put($name, $contents);

        return $name;
    }
}
