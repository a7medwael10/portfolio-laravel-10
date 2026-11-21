<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    use HasFactory;

    protected $fillable = ['degree', 'degree_ar', 'institution', 'institution_ar', 'institution_url', 'location', 'location_ar', 'field_of_study', 'field_of_study_ar', 'start_date', 'end_date', 'grade', 'grade_ar', 'description', 'description_ar', 'is_visible'];
    
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'description' => 'array',
        'description_ar' => 'array',
        'is_visible' => 'boolean',
    ];
}
