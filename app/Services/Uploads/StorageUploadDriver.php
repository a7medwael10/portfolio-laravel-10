<?php

namespace App\Services\Uploads;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class StorageUploadDriver implements UploadDriver
{
    public function upload(UploadedFile $file, string $directory, string $filename): string
    {
        $directory = trim($directory, '/');
        $targetDirectory = public_path($directory);

        if (!file_exists($targetDirectory)) {
            mkdir($targetDirectory, 0755, true);
        }

        $file->move($targetDirectory, $filename);

        return asset($directory.'/'.$filename);
    }

    public function delete(string $pathOrUrl): bool
    {
        $relativePath = ltrim(parse_url($pathOrUrl, PHP_URL_PATH) ?: $pathOrUrl, '/');
        $filePath = public_path($relativePath);

        if (!file_exists($filePath)) {
            return false;
        }

        return unlink($filePath);
    }
}
