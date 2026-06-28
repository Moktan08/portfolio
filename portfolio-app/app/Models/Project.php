<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'title',
        'description',
        'images',
        'project_url',
    ];

    protected $casts = [
        'images' => 'array',
    ];
}