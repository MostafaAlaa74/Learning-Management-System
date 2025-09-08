<?php

namespace App\Policies;

use App\Models\Course;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CoursesPolicy
{
    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Only instructors or admins can create courses
        return $user->role === 'instructor' || $user->role === 'admin';
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Course $course): bool
    {
        // Only the course instructor or admin can update
        return $user->id === $course->instructor_id || $user->role === 'admin';
    }
    public function delete(User $user, Course $course): bool
    {
        // Only the course instructor or admin can update
        return $user->id === $course->instructor_id || $user->role === 'admin';
    }

    // Add other methods as needed...
}
