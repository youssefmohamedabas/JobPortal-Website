<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;
    public function jobType(){
        return $this->belongsTo(JobType::class);
    }
    public function categoryType(){
        return $this->belongsTo(Category::class);
    }
    public function applications(){
        return $this->hasMany(jobapplication::class);
    }
    public function isSavedByUser($userId) {
        return Savejob::where('user_id', $userId)->where('job_id', $this->id)->exists();
    }
    
}