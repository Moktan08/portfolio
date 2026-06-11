<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    // Add this property to allow Laravel to save these fields
    protected $fillable = [
        'title',
        'description',
        'image_path',
        'project_url',
    ];
}