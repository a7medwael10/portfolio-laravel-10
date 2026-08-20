<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectImage extends Model
{
    use HasFactory;

    protected $fillable = ['project_id', 'image_path', 'is_main'];

    protected $appends = ['image_url'];

    public function getImageUrlAttribute(): ?string
    {
        return $this->uploadUrl($this->image_path);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    protected function uploadUrl(?string $path): ?string
    {
        if (blank($path)) {
            return null;
        }

        $path = ltrim($path, '/');

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
