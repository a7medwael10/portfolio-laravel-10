<?php

namespace App\Services\Uploads;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;

class PublicUploadDriver implements UploadDriver
{
    public function upload(UploadedFile $file, string $directory, string $filename): string
    {
        $directory = trim($directory, '/');
        $targetDirectory = rtrim(config('upload.drivers.public.path', public_path()), DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR.$directory;

        File::ensureDirectoryExists($targetDirectory);

        $file->move($targetDirectory, $filename);

        return asset($directory.'/'.$filename);
    }

    public function delete(string $pathOrUrl): bool
    {
        $relativePath = ltrim(parse_url($pathOrUrl, PHP_URL_PATH) ?: $pathOrUrl, '/');
        $filePath = rtrim(config('upload.drivers.public.path', public_path()), DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR.$relativePath;

        if (! File::exists($filePath)) {
            return false;
        }

        return File::delete($filePath);
    }
}
