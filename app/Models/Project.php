<?php

namespace App\Models;

use App\Enums\ProjectType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'slug', 'description', 'type', 'experience_id', 'main_image', 'github_url', 'live_url', 'is_visible'];

    protected $casts = [
        'type' => ProjectType::class,
        'is_visible' => 'boolean',
    ];

    protected $appends = ['main_image_url'];

    public function getMainImageUrlAttribute(): ?string
    {
        return $this->uploadUrl($this->main_image);
    }

    public function images()
    {
        return $this->hasMany(ProjectImage::class);
    }

    public function skills()
    {
        return $this->belongsToMany(Skill::class);
    }

    public function experience()
    {
        return $this->belongsTo(Experience::class);
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
