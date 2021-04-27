<?php

namespace App\Http\Controllers;

use App\Models\Year;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class YearController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $yr = Year::orderBy('id', 'DESC')->get();
        return response()->json($yr);
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
           'year_date' => 'required|numeric|unique:years'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        $yr = new Year();
        $yr->year_date = $request->year_date;
        if ($yr->save()) {
            return response()->json($yr, 201);
        }
        return response()->json(['error' => 'Failed!']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Year  $year
     * @return \Illuminate\Http\Response
     */
    public function show(Year $year)
    {
        $yr = Year::find($year->id)->get();
        return response()->json($yr);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Year  $year
     * @return \Illuminate\Http\Response
     */
    public function edit(Year $year)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Year  $year
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Year $year)
    {
        $validator = Validator::make($request->all(), [
            'year_date' => 'required|numeric'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        $yr = Year::find($year->id);
        $yr->year_date = $request->year_date;
        if ($yr->update()) {
            return response()->json($yr, 201);
        }
        return response()->json(['error' => 'Failed!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Year  $year
     * @return \Illuminate\Http\Response
     */
    public function destroy(Year $year)
    {
        $yr = Year::find($year->id);
        if ($yr->delete()) {
            return response()->json($yr, 201);
        }
        return response()->json(['error' => 'Failed!']);
    }

    public function search($keyword)
    {
        $yr = Year::where('year_date', 'like', '%'.$keyword.'%')->get();
        return response()->json($yr);
    }
}
