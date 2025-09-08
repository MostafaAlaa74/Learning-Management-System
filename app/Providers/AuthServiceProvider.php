<?php

namespace App\Providers;

use App\Models\Course;
use App\Models\Lesson;
use App\Policies\CoursesPolicy;
use App\Policies\LessonPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Course::class => CoursesPolicy::class,
        Lesson::class => LessonPolicy::class
    ];

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->registerPolicies(); 
    }
}