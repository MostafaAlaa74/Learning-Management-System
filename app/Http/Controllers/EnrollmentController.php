<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEnrollmentrequest;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Enrollment::all(), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEnrollmentrequest $request)
    {
        if(Enrollment::where('user_id', $request->user_id)->where('course_id', $request->course_id)->exists()){
            return response()->json(['message' => 'User already enrolled in this course'], 400);
        }
        // Check if there is error massages
        if($request->errors()){
            return response()->json(['errors' => $request->errors()], 422);
        }
        $validated = $request->validated();

        $enrollment = Enrollment::create($validated);

        return response()->json($enrollment, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Enrollment $enrollment)
    {
        return response()->json(
            [
                'user_name' => $enrollment->user->name ,
                'course_title' => $enrollment->course->title,
                'status' => $enrollment->status,
                'enrolled_at' => $enrollment->enrolled_at,
            ]
            , 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Enrollment $enrollment)
    {
        $enrollment->markAsCompleted();
        return response()->json(['message' => 'Enrollment marked as completed'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Enrollment $enrollment)
    {
        $enrollment->CancellEnrollment();
        return response()->json(['message' => 'Enrollment cancelled'], 200);
    }
}
