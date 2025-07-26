<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
//use App\Http\Controllers\StudentController;
use App\Http\Controllers\EmployeeController;

/*Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/test', function () {
    return response()->json(['message' => 'API is working!']);

});

//Route::apiResource('students', StudentController::class); */
Route::apiResource('employees', EmployeeController::class);