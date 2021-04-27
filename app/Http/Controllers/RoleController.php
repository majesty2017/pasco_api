<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $role = Role::orderBy('id', 'DESC')->get();
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
           'role_name' => 'required|string|max:255|unique:roles'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        $role = new Role();
        $role->role_name = $request->role_name;
        $role->slug = strtolower(str_replace(' ', '-', $request->role_name));
        if ($role->save()) {
            return response()->json($role, 201);
        }
        return response()->json(['error' => 'Failed!'], 400);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        $role = Role::find($role->id)->get();
        return response()->json($role);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        $validator = Validator::make($request->all(), [
            'role_name' => 'required|string|max:255|unique:roles'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        $role = Role::find($role->id);
        $role->role_name = $request->role_name;
        $role->slug = strtolower(str_replace(' ', '-', $request->role_name));
        if ($role->update()) {
            return response()->json($role);
        }
        return response()->json(['error' => 'Failed!'], 400);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        $role = Role::find($role->id);
        if ($role->delete()) {
            return response()->json($role);
        }
        return response()->json(['error' => 'Failed!'], 400);
    }

    public function search($keyword)
    {
        $role = Role::where('role_name', 'like', '%'.$keyword.'%');
        return response()->json($role);
    }
}
