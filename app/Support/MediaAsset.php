<?php

namespace App\Support;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class MediaAsset
{
    /**
     * @var array<int, string>
     */
    private const ALLOWED_DIRECTORIES = [
        'avatars/',
        'projects/',
        'uploads/projects/',
    ];

    public static function url(?string $value): ?string
    {
        if (blank($value)) {
            return null;
        }

        $path = self::path($value);

        if ($path !== null) {
            return route('media.image', ['path' => $path]);
        }

        return filter_var($value, FILTER_VALIDATE_URL) ? $value : null;
    }

    public static function path(?string $value): ?string
    {
        if (blank($value)) {
            return null;
        }

        $path = parse_url($value, PHP_URL_PATH) ?: $value;
        $path = rawurldecode(str_replace('\\', '/', $path));
        $path = ltrim($path, '/');

        foreach (['media/images/', 'storage/'] as $prefix) {
            if (Str::startsWith($path, $prefix)) {
                $path = Str::after($path, $prefix);
            }
        }

        if ($path === '' || str_contains($path, "\0")) {
            return null;
        }

        $segments = explode('/', $path);

        if (in_array('..', $segments, true) || in_array('.', $segments, true)) {
            return null;
        }

        foreach (self::ALLOWED_DIRECTORIES as $directory) {
            if (Str::startsWith($path, $directory)) {
                return $path;
            }
        }

        return null;
    }

    /**
     * @return array<int, string>
     */
    public static function candidates(string $path): array
    {
        $path = self::path($path);

        if ($path === null) {
            return [];
        }

        return array_values(array_unique([
            public_path($path),
            public_path('storage/'.$path),
            storage_path('app/public/'.$path),
        ]));
    }

    public static function delete(?string $value): bool
    {
        $deleted = false;

        foreach (self::candidates((string) $value) as $candidate) {
            if (File::isFile($candidate)) {
                $deleted = File::delete($candidate) || $deleted;
            }
        }

        return $deleted;
    }
}
