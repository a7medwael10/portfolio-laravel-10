<?php

namespace App\Http\Controllers;

use App\Support\MediaAsset;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class MediaImageController extends Controller
{
    public function __invoke(string $path): BinaryFileResponse
    {
        foreach (MediaAsset::candidates($path) as $candidate) {
            $realPath = realpath($candidate);

            if ($realPath === false || ! is_file($realPath)) {
                continue;
            }

            $mimeType = mime_content_type($realPath);

            if (! is_string($mimeType) || ! str_starts_with($mimeType, 'image/')) {
                continue;
            }

            return response()->file($realPath, [
                'Cache-Control' => 'public, max-age=604800',
                'Content-Type' => $mimeType,
                'X-Content-Type-Options' => 'nosniff',
            ]);
        }

        abort(404);
    }
}
