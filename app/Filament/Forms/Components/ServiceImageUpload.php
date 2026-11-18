<?php

namespace App\Filament\Forms\Components;

use App\Services\UploadService;
use App\Support\MediaAsset;
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
        return MediaAsset::url($file) ?? '';
    }
}
