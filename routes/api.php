<?php

use App\Http\Controllers\CourseController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\UserController;
use GuzzleHttp\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
    // Course Routes
    Route::apiResource('courses', CourseController::class);
    // Lesson Routes
    Route::apiResource('lessons', LessonController::class);
    // Enrollment Routes
    Route::apiResource('enrollments', EnrollmentController::class);

    Route::apiResource('courses.lessons', LessonController::class)->shallow();
    // Nested route to get lessons of a specific course 
    /**
     *  GET|HEAD        api/courses/{course}/lessons .... courses.lessons.index › LessonController@index  
        POST            api/courses/{course}/lessons .... courses.lessons.store › LessonController@store
     */
});

Route::get('/courses/search/{keyword}', [CourseController::class, 'search']);

Route::patch('/users/{user}/change-password', [UserController::class, 'changePassword']);
// Auth Routes
Route::prefix('auth')->group(function () {
    Route::post('/register', [UserController::class, 'register']);
    Route::post('/login', [UserController::class, 'login']);
    Route::post('/logout', [UserController::class, 'logout'])->middleware('auth:sanctum');
});
