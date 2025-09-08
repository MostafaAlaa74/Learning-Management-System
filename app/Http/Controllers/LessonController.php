<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLessonRequest;
use App\Http\Requests\UpdateLessonRequest;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\RateLimiter;

class LessonController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index(Course $course)
    {
        // This A way to get lessons of specific course using route model binding
        // and the relationship defined in the Course model

        // $perPage = request()->get('per_page', 15); // Get per_page from request or default to 15
        // $lessons = Lesson::where('course_id', $course)->paginate($perPage);
        // return response()->json([
        //     'status' => 'success',
        //     'data' => $lessons
        // ], 200);

        // Another way to get lessons of specific course using the relationship defined in the Course model
        // and paginate the results
        return response()->json([
            'status' => 'success',
            'data' => $course->lessons()->paginate(10)
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLessonRequest $request, Course $course)
    {
        $limiterKey = 'store-lesson-' . auth()->user()->id;
        $maxAttempts = 5;

        if (RateLimiter::tooManyAttempts($limiterKey, $maxAttempts)) {
            return response()->json(['message' => 'Too many requests. Please try again later.'], 429);
        }
        RateLimiter::hit($limiterKey, 60); // Decay time of 60 seconds
        $this->authorize('create', [Lesson::class, $course->id]);
        
        $validated = $request->validated();

        // Handle file upload
        if ($request->hasFile('video') || $request->hasFile('assignments') || $request->hasFile('presentations')) {
            $videoPath = $request->file('video')->store('courses/' . $course->id . '/lessons/videos', 'public');
            $assignmentsPath = $request->file('assignments')->store('courses/' . $course->id . '/lessons/assignments', 'public');
            $presentationsPath = $request->file('presentations')->store('courses/' . $course->id . '/lessons/presentations', 'public');
        }

        $lesson = $course->lessons()->create([
            'title' => $validated['title'],
            'course_id' => $course->id,
            'assignments_path' => $assignmentsPath ?? null,
            'presentations_path' => $presentationsPath ?? null,
            'video_URL' => $videoPath,
        ]);

        return response()->json([
            'status' => 'success',
            'data' => $lesson
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Lesson $lesson)
    {
        return response()->json($lesson, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLessonRequest $request, Lesson $lesson)
    {
        $this->authorize('update', $lesson);
        
        $validated = $request->validated();
        if ($request->hasFile('video')) {
            $path = $request->file('video')->store('videos', 'public');
        }
        $lesson->update(
            [
                'title' => $validated['title'] ?? $lesson->title,
                'course_id' => $validated['course_id'] ?? $lesson->course_id,
                'video_URL' => $path ?? $lesson->video_URL
            ]
        );

        return response()->json([
            'status' => 'success',
            'data' => $lesson
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lesson $lesson)
    {
        $this->authorize('delete', $lesson);
        $lesson->delete();
        return response()->json(['message' => 'The Lesson Deleted Succesfully'], 200);
    }
}
