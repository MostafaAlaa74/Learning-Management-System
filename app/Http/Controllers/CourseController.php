<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCourseRequest;
use App\Http\Requests\UpdateCourseRequest;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\RateLimiter;

class CourseController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $perPage = request()->get('per_page', 10); // Get per_page from request or default to 15
        $courses = Course::paginate($perPage);

        return response()->json($courses, 200);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCourseRequest $request)
    {
        $limiterKey = 'store-Course-' . auth()->user()->id;
        $maxAttempts = 5;

        if (RateLimiter::tooManyAttempts($limiterKey, $maxAttempts)) {
            return response()->json(['message' => 'Too many requests. Please try again later.'], 429);
        }
        RateLimiter::hit($limiterKey, 60); // Decay time of 60 seconds

        $this->authorize('create', Course::class);
        

        $DataValidated = $request->validated();
        Course::create(
            [
                'title' => $DataValidated['title'],
                'description' => $DataValidated['description'],
                'price' => $DataValidated['price'],
                'instructor_id' => $request['instructor_id'],
            ]
        );

        return response()->json(
            [
                'message' => 'Course Stored Successfuly',
                'Course Details' => $DataValidated
            ],
            201
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course)
    {
        return response()->json($course, 200);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCourseRequest $request, Course $course)
    {
        $this->authorize('update', $course);
        $DataValidated = $request->validated();
        
        $course->update([
            'title' => $DataValidated['title'] ?? $course->title,
            'description' => $DataValidated['description'] ?? $course->description,
            'price' => $DataValidated['price'] ?? $course->price,
            'intructor_id' => $request['intructor_id'] ?? $course->intructor_id
        ]);

        return response()->json(
            [
                'message' => 'Course Updated Successfuly',
                'Course Details' => $DataValidated
            ],
            200
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        $this->authorize('delete', $course);
        $course->delete();

        return response()->json(
            [
                'message' => 'Course Deleted Successfuly',
            ],
            200
        );
    }

    public function search($keyword)
    {
        $courses = Course::where('title', 'LIKE', "%$keyword%")
            ->orWhere('description', 'LIKE', "%$keyword%")
            ->get();

        return response()->json($courses, 200);
    }
}
