<?php

namespace App\Models;

use App\Policies\CoursesPolicy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Attributes\UsePolicy;
use Illuminate\Database\Eloquent\Model;

#[UsePolicy(CoursesPolicy::class)]
class Course extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'description', 'price', 'instructor_id'];

    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }

    public function instructor()
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function students()
    {
        return $this->belongsToMany(User::class, 'enrollments')
            ->withPivot('status', 'enrolled_at' , 'completed_at')
            ->withTimestamps();
    }
}
