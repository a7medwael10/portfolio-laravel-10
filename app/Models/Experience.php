<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'title_ar', 'company', 'company_ar', 'company_url', 'work_location', 'work_location_ar', 'start_date', 'end_date', 'description', 'description_ar', 'is_visible'];
    
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'description' => 'array',
        'description_ar' => 'array',
        'is_visible' => 'boolean',
    ];
}
