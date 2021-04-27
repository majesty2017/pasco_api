<?php

use App\Http\Controllers\CourseController;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::apiResource('courses', CourseController::class);

Route::get('/courses/search/{keyword}', [CourseController::class, 'search']);

//Route::get('/courses', [CourseController::class, 'index']);
//
//Route::post('/courses', [CourseController::class, 'store']);

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
