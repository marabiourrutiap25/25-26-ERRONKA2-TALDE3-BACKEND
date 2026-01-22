<?php

use App\Http\Controllers\Api\AppointmentController;
use App\Http\Controllers\Api\ClientController;
use App\Http\Controllers\Api\ConsumableCategoryController;
use App\Http\Controllers\Api\ConsumableController;
use App\Http\Controllers\Api\GroupController;
use App\Http\Controllers\Api\ScheduleController;
use App\Http\Controllers\Api\ServiceCategoryController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\ShiftController;
use App\Http\Controllers\Api\StudentController;
use App\Http\Controllers\EquipmentCategoryController;
use App\Http\Controllers\EquipmentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('group', GroupController::class);
Route::apiResource('consumable', ConsumableController::class);
Route::apiResource('consumable-category', ConsumableCategoryController::class);
Route::apiResource('schedule', ScheduleController::class);
Route::apiResource('student', StudentController::class);
Route::apiResource('shift', ShiftController::class);
Route::apiResource('equipment', EquipmentController::class);
Route::apiResource('equipment-category', EquipmentCategoryController::class);
Route::apiResource('appointment', AppointmentController::class);
Route::apiResource('client', ClientController::class);
Route::apiResource('service', ServiceController::class);
Route::apiResource('service-category', ServiceCategoryController::class);