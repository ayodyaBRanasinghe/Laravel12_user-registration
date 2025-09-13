<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\NewEmployeeController;
use App\Http\Controllers\ResearchController;

Route::prefix('employees')->group(function () {
    Route::get('/', [EmployeeController::class, 'index']);
    Route::post('/', [EmployeeController::class, 'store']);
    Route::get('/{id}', [EmployeeController::class, 'show']);
    Route::put('/{id}', [EmployeeController::class, 'update']);
    Route::delete('/{id}', [EmployeeController::class, 'destroy']);
});

Route::apiResource('products', ProductController::class);

Route::apiResource('new-employees', NewEmployeeController::class);

Route::apiResource('research', ResearchController::class);

