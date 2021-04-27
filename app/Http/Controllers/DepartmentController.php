<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dept = Department::orderBy('id', 'DESC')->get();
        return response()->json($dept);
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
           'department_name' => 'required|string|max:255|unique:departments'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        $dept = new Department();
        $dept->department_name = $request->department_name;
        $dept->slug = strtolower(str_replace(' ', '-', $request->department_name));
        if ($dept->save()) {
            return response()->json($dept, 201);
        }
        return response()->json(['error' => 'Failed!'], 400);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function show(Department $department)
    {
        $department = Department::find($department->id)->get();
        return response()->json($department);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function edit(Department $department)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Department $department)
    {
        $validator = Validator::make($request->all(), [
            'department_name' => 'required|string|max:255'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        $dept = Department::find($department->id);
        $dept->department_name = $request->department_name;
        $dept->slug = strtolower(str_replace(' ', '-', $request->department_name));
        if ($dept->update()) {
            return response()->json($dept);
        }
        return response()->json(['error' => 'Failed!'], 400);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function destroy(Department $department)
    {
        $dept = Department::find($department->id);
        if ($dept->delete()) {
            return response()->json($dept);
        }
        return response()->json(['error' => 'Failed!'], 400);
    }

    public function search($keyword)
    {
        $dept = Department::where('department_name', 'like', '%'.$keyword.'%')->get();
        return response()->json($dept);
    }
}
