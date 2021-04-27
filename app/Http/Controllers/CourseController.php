<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $courses = Course::orderBy('id', 'DESC')->get();
        return response()->json($courses);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
           'course_name' => 'required|unique:courses|string|max:255'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        $course = new Course();
        $course->course_name = $request->course_name;
        $course->slug = strtolower(str_replace(' ', '-', $request->course_name));
        if ($course->save()) {
            return response()->json($course, 201);
        }
        return response()->json(['error' => 'Failed!'], 400);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $course = Course::find($id);
        return response()->json($course);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function edit(Course $course)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Course $course)
    {
        $validator = Validator::make($request->all(), [
            'course_name' => 'required|string|max:255'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        $course = Course::find($request->id) ?? Course::find($course->id);
        $course->course_name = $request->course_name;
        $course->slug = strtolower(str_replace(' ', '-', $request->course_name));
        if ($course->update()) {
            return response()->json($course, 200);
        }
        return response()->json(['error' => 'Failed!'], 400);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function destroy(Course $course)
    {
        $course = Course::find($course->id);
        if ($course->delete()) {
            return response()->json($course, 200);
        }
        return response()->json(['error' => 'Failed!'], 400);
    }

    public function search($keyword)
    {
        $coourse = Course::where('course_name', 'like', '%'.$keyword.'%')->get();
        return response()->json($coourse);
    }
}
