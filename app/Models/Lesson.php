<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Lesson extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'course_id', 'video_URL' , 'assignments_path', 'presentations_path'];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
