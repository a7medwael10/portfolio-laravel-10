<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    use HasFactory;

    protected $fillable = ['category_id', 'name', 'is_visible'];
    
    protected $casts = [
        'is_visible' => 'boolean',
    ];
    
    public function category()
    {
        return $this->belongsTo(SkillCategory::class, 'category_id');
    }
    
    public function projects()
    {
        return $this->belongsToMany(Project::class);
    }
}
