<?php

namespace App\Models;

use App\Enums\ProjectType;
use App\Models\Concerns\DeletesReplacedMedia;
use App\Support\MediaAsset;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use DeletesReplacedMedia, HasFactory;

    protected $fillable = ['title', 'title_ar', 'slug', 'description', 'description_ar', 'type', 'experience_id', 'main_image', 'github_url', 'live_url', 'is_visible'];

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

    protected static function booted(): void
    {
        static::deleting(function (Project $project): void {
            $project->images()->get()->each->delete();
        });
    }

    protected function mediaAttributes(): array
    {
        return ['main_image'];
    }

    protected function uploadUrl(?string $path): ?string
    {
        return MediaAsset::url($path);
    }
}
