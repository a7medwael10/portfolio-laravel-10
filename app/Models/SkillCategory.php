<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SkillCategory extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'is_visible'];
    
    protected $casts = [
        'is_visible' => 'boolean',
    ];
    
    public function skills()
    {
        return $this->hasMany(Skill::class, 'category_id');
    }
}
