<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'company', 'company_url', 'work_location', 'start_date', 'end_date', 'description', 'is_visible'];
    
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'description' => 'array',
        'is_visible' => 'boolean',
    ];
}
