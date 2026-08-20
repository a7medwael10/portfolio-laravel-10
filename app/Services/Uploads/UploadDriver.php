<?php

namespace App\Services\Uploads;

use Illuminate\Http\UploadedFile;

interface UploadDriver
{
    public function upload(UploadedFile $file, string $directory, string $filename): string;

    public function delete(string $pathOrUrl): bool;
}
