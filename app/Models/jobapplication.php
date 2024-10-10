<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class jobapplication extends Model
{protected $table = 'application_jobs';  // If the table is not named 'jobapplications'

    use HasFactory;
    public function job()
    {
        return $this->belongsTo(Job::class);
    }
}