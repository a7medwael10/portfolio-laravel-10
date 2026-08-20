<?php

namespace App\Filament\Forms\Components;

use App\Services\UploadService;
use Filament\Forms\Components\FileUpload;
use Illuminate\Http\UploadedFile;
use RuntimeException;

class ServiceImageUpload
{
    public static function make(string $name, ?string $label = null, ?string $directory = null): FileUpload
    {
        $component = FileUpload::make($name)
            ->image()
            ->maxSize((int) config('upload.max_size', 2048))
            ->saveUploadedFileUsing(static function (UploadedFile $file) use ($directory): string {
                return app(UploadService::class)->upload(
                    self::movableUpload($file),
                    $directory,
                );
            })
            ->getUploadedFileUsing(static function (string $file): ?array {
                return [
                    'name' => basename(parse_url($file, PHP_URL_PATH) ?: $file),
                    'size' => 0,
                    'type' => null,
                    'url' => self::urlForStoredUpload($file),
                ];
            })
            ->deleteUploadedFileUsing(static function (string $file): void {
                app(UploadService::class)->delete($file);
            });

        if ($label !== null) {
            $component->label($label);
        }

        return $component;
    }

    protected static function movableUpload(UploadedFile $file): UploadedFile
    {
        $path = $file->getRealPath();

        if ($path === false) {
            throw new RuntimeException('The temporary upload path could not be resolved.');
        }

        return new UploadedFile(
            $path,
            $file->getClientOriginalName(),
            $file->getMimeType(),
            UPLOAD_ERR_OK,
            true,
        );
    }

    protected static function urlForStoredUpload(string $file): string
    {
        $path = ltrim($file, '/');

        if (str_contains($path, '://')) {
            if (filter_var($path, FILTER_VALIDATE_URL)) {
                return $path;
            }
            // Malformed, if starts with 'storage/'
            if (str_starts_with($path, 'storage/')) {
                $potentialUrl = substr($path, 8);
                if (filter_var($potentialUrl, FILTER_VALIDATE_URL)) {
                    return $potentialUrl;
                }
            }
        }

        // Remove leading storage/
        if (str_starts_with($path, 'storage/')) {
            $path = substr($path, 8);
        }

        // Check if exists in public
        if (file_exists(public_path($path))) {
            return asset($path);
        }

        // Else, assume it's in storage
        return asset('storage/'.$path);
    }
}
