<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    use HasFactory;

    protected $fillable = ['degree', 'institution', 'institution_url', 'location', 'field_of_study', 'start_date', 'end_date', 'grade', 'description', 'is_visible'];
    
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'description' => 'array',
        'is_visible' => 'boolean',
    ];
}
