<?php

use App\Http\Controllers\AuthController;
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

//Route::get('/courses', [CourseController::class, 'index']);
//
//Route::post('/courses', [CourseController::class, 'store']);

// Protected routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::apiResource('roles', RoleController::class);

    Route::post('courses', [CourseController::class, 'store']);
    Route::put('courses/{id}', [CourseController::class, 'update']);
    Route::delete('courses/{id}', [CourseController::class, 'destroy']);

    Route::post('departments', [DepartmentController::class, 'store']);
    Route::put('departments', [DepartmentController::class, 'update']);
    Route::delete('departments', [DepartmentController::class, 'destroy']);

    Route::post('years', [YearController::class, 'store']);
    Route::put('years/{id}', [YearController::class, 'update']);
    Route::delete('years/{id}', [YearController::class, 'destroy']);

    Route::post('questions', [QuestionController::class, 'store']);
    Route::put('questions/{id}', [QuestionController::class, 'update']);
    Route::delete('questions/{id}', [QuestionController::class, 'destroy']);
});

// public routes

Route::post('register', [AuthController::class, 'register']);

Route::post('login', [AuthController::class, 'login']);

Route::any('courses', [CourseController::class, 'index']);

Route::any('departments', [DepartmentController::class, 'index']);

Route::any('years', [YearController::class, 'index']);

Route::any('questions', [QuestionController::class, 'index']);

Route::any('/courses/search/{keyword}', [CourseController::class, 'search']);

Route::any('/departments/search/{keyword}', [DepartmentController::class, 'search']);

Route::any('/years/search/{keyword}', [YearController::class, 'search']);

Route::any('/roles/search/{keyword}', [RoleController::class, 'search']);

Route::any('/questions/search/{year}/{course}', [QuestionController::class, 'search']);

Route::any('/questions/download/{filename}/', [QuestionController::class, 'download']);


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
