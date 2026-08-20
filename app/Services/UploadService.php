<?php

namespace App\Services;

use App\Services\Uploads\PublicUploadDriver;
use App\Services\Uploads\StorageUploadDriver;
use App\Services\Uploads\UploadDriver;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use InvalidArgumentException;
use RuntimeException;
use Throwable;

class UploadService
{
    public function upload(UploadedFile $file, ?string $directory = null, ?int $maxSize = null): string
    {
        $directory = trim($directory ?: config('upload.default_directory', 'avatars'), '/');

        $this->validate($file, $maxSize);

        try {
            return $this->driver()->upload($file, $directory, $this->filename($file));
        } catch (Throwable $exception) {
            report($exception);

            throw new RuntimeException('The file could not be uploaded. Please try again.', 0, $exception);
        }
    }

    public function delete(?string $pathOrUrl): bool
    {
        if (blank($pathOrUrl)) {
            return false;
        }

        try {
            return $this->driver()->delete($pathOrUrl);
        } catch (Throwable $exception) {
            report($exception);

            return false;
        }
    }

    protected function validate(UploadedFile $file, ?int $maxSize = null): void
    {
        if (! $file->isValid()) {
            throw new InvalidArgumentException('The uploaded file is invalid.');
        }

        if (! str_starts_with((string) $file->getMimeType(), 'image/')) {
            throw new InvalidArgumentException('Only image uploads are allowed.');
        }

        $maxSize ??= (int) config('upload.max_size', 2048);

        if ($maxSize > 0 && ($file->getSize() / 1024) > $maxSize) {
            throw new InvalidArgumentException("The image must not be larger than {$maxSize} KB.");
        }
    }

    protected function filename(UploadedFile $file): string
    {
        $extension = $file->guessExtension() ?: $file->getClientOriginalExtension() ?: 'jpg';

        return Str::uuid().'.'.$extension;
    }

    protected function driver(): UploadDriver
    {
        return match (config('upload.driver', 'public')) {
            'public' => app(PublicUploadDriver::class),
            'storage' => app(StorageUploadDriver::class),
            default => throw new InvalidArgumentException('Unsupported upload driver configured.'),
        };
    }
}
