<?php

use App\Http\Controllers\Api\ConsumableCategoriController;
use App\Http\Controllers\Api\ConsumableController;
use App\Http\Controllers\Api\GroupController;
use App\Http\Controllers\Api\ScheduleController;
use App\Http\Controllers\Api\ShiftController;
use App\Http\Controllers\Api\StudentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('group', GroupController::class);
Route::apiResource('consumable', ConsumableController::class);
Route::apiResource('comsumablecategori', ConsumableCategoriController::class);
Route::apiResource('schedule', ScheduleController::class);
Route::apiResource('student', StudentController::class);
Route::apiResource('shift', ShiftController::class);