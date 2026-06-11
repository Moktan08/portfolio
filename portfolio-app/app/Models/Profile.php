<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    // Bypasses mass assignment restriction guards
    protected $guarded = [];   
}
