<?php

use App\Http\Controllers\CourseController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\YearController;
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

Route::apiResource('departments', DepartmentController::class);

Route::get('/departments/search/{keyword}', [DepartmentController::class, 'search']);

Route::apiResource('years', YearController::class);

Route::get('/years/search/{keyword}', [YearController::class, 'search']);

Route::apiResource('roles', RoleController::class);

Route::get('/roles/search/{keyword}', [RoleController::class, 'search']);

Route::apiResource('questions', QuestionController::class);

Route::get('/questions/search/{year}/{course}', [QuestionController::class, 'search']);

Route::get('/questions/download/{filename}/', [QuestionController::class, 'download']);

//Route::get('/courses', [CourseController::class, 'index']);
//
//Route::post('/courses', [CourseController::class, 'store']);

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
