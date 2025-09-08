<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    protected $fillable = ['user_id', 'course_id' , 'status', 'enrolled_at' , 'completed_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }


    /**
     * Check if enrollment is active.
     */
    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    /**
     * Check if enrollment is completed.
     */
    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    public function markAsCompleted()
    {
        $this->status = 'completed';
        $this->completed_at = now();
        $this->save();
    }
    public function CancellEnrollment()
    {
        $this->status = 'cancelled';
        $this->save();
    }
}
