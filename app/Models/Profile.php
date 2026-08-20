<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'title', 'bio', 'about_text', 'avatar', 'hero_image', 'email', 'phone', 'github_url', 'linkedin_url', 'location', 'cv'];

    protected $appends = ['avatar_url', 'hero_image_url', 'cv_url'];

    public function getAvatarUrlAttribute()
    {
        return $this->uploadUrl($this->avatar);
    }

    public function getHeroImageUrlAttribute()
    {
        return $this->uploadUrl($this->hero_image);
    }

    public function getCvUrlAttribute()
    {
        return $this->uploadUrl($this->cv);
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
