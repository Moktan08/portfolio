<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Project;
use App\Models\Education;
use App\Models\Experience;
use App\Models\Skill;
use App\Models\Profile;
use App\Models\Hero;

// Endpoints must live out in the open here to get prefixing automatically
Route::get('/projects', function () {
    return Project::all();
});

Route::get('/education', function () {
    return Education::all();
});

Route::get('/experiences', function () {
    return Experience::all();
});

Route::get('/skills', function () {
    return Skill::all();
});

Route::get('/profile', function () {
    return \App\Models\Profile::first() ?? ['bio' => '']; 
});

Route::get('/hero', function () {
    return Hero::first() ?? [
        'title' => 'Software Engineer',
        'tagline' => 'Passionate about continuous learning and applying technical expertise to build scalable, data-driven real-world architectures.'
    ];
});