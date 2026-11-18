<?php

namespace App\Models;

use App\Models\Concerns\DeletesReplacedMedia;
use App\Support\MediaAsset;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectImage extends Model
{
    use DeletesReplacedMedia, HasFactory;

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

    protected function mediaAttributes(): array
    {
        return ['image_path'];
    }

    protected function uploadUrl(?string $path): ?string
    {
        return MediaAsset::url($path);
    }
}
