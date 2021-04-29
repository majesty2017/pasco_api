<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $q = Question::orderBy('id', 'DESC')->with('department')->with('year')->with('course')->get();
        return response()->json($q);
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
//        $v = Validator::make($request->all(), [
//           'files' => 'required|mimes: jpg,jpeg,png,svg,doc,docx,pdf',
//        ]);
//        if ($v->fails()) {
//            return response()->json($v);
//        }
        $question = new Question();
        $question->department_id = $request->department_id;
        $question->year_id = $request->year_id;
        $question->course_id = $request->course_id;

        if ($request->hasFile('files')) {
            $file = $request->file('files');
            $ext = $file->getClientOriginalExtension();
            $filename = time().'.'.$ext;
            $file->move('uploads/questions', $filename);
            $question->files = $filename;
        }
        if ($question->save()) {
            return response()->json($question, 201);
        }
        return response()->json(['error', 'Failed']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function show(Question $question)
    {
        $question = Question::find($question->id);
        return response()->json($question);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function edit(Question $question)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Question $question)
    {
//        $v = Validator::make($request->all(), [
//            'files' => 'required|mimes: jpg,jpeg,png,svg,doc,docx,pdf',
//        ]);
//        if ($v->fails()) {
//            return response()->json($v);
//        }
        $question = Question::find($question->id);
        $question->department_id = $request->department_id;
        $question->year_id = $request->year_id;
        $question->course_id = $request->course_id;

        if ($request->hasFile('files')) {
            $file = $request->file('files');
            $ext = $file->getClientOriginalExtension();
            $filename = time().'.'.$ext;
            $file->move('uploads/questions', $filename);
            $question->files = $filename;
        }
        if ($question->update()) {
            return response()->json($question);
        }
        return response()->json(['error', 'Failed']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Question  $question
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question)
    {
        $question = Question::find($question->id);
        if ($question->delete()) {
            return response()->json($question);
        }
        return response()->json(['error', 'Failed']);
    }

    public function search($year = null, $department_id = null)
    {
        $question = Question::where('department_id', $department_id)->where('year_id', $year)->with('year')->with('course')->get();
        return response()->json($question);
    }

    public function download($filename)
    {
        return response()->download(public_path('uploads/questions/'.$filename));
    }
}
