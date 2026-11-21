<?php

namespace App\Models;

use App\Models\Concerns\DeletesReplacedMedia;
use App\Support\MediaAsset;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use DeletesReplacedMedia, HasFactory;

    protected $fillable = ['name', 'name_ar', 'title', 'title_ar', 'bio', 'bio_ar', 'about_text', 'about_text_ar', 'avatar', 'hero_image', 'email', 'phone', 'github_url', 'linkedin_url', 'location', 'location_ar', 'cv'];

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
        if (blank($this->cv)) {
            return null;
        }

        if (filter_var($this->cv, FILTER_VALIDATE_URL)) {
            return $this->cv;
        }

        $path = ltrim($this->cv, '/');
        $path = str_starts_with($path, 'storage/') ? substr($path, 8) : $path;

        return asset('storage/'.$path);
    }

    protected function mediaAttributes(): array
    {
        return ['avatar', 'hero_image'];
    }

    protected function uploadUrl(?string $path): ?string
    {
        return MediaAsset::url($path);
    }
}
