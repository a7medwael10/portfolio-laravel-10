<?php

namespace App\Services\Uploads;

use App\Support\MediaAsset;
use Illuminate\Http\UploadedFile;

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

        return $directory.'/'.$filename;
    }

    public function delete(string $pathOrUrl): bool
    {
        $relativePath = MediaAsset::path($pathOrUrl);

        if ($relativePath === null) {
            return false;
        }

        $filePath = public_path($relativePath);

        if (!file_exists($filePath)) {
            return false;
        }

        return unlink($filePath);
    }
}
