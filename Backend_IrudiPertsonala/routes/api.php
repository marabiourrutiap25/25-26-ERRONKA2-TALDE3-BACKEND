<?php

use App\Http\Controllers\Api\AppointmentController;
use App\Http\Controllers\Api\AppointmentServiceController;
use App\Http\Controllers\Api\ClientController;
use App\Http\Controllers\Api\ConsumableCategoryController;
use App\Http\Controllers\Api\ConsumableController;
use App\Http\Controllers\Api\GroupController;
use App\Http\Controllers\Api\ScheduleController;
use App\Http\Controllers\Api\ServiceCategoryController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\ShiftController;
use App\Http\Controllers\Api\StudentConsumableController;
use App\Http\Controllers\Api\StudentController;
use App\Http\Controllers\Api\EquipmentController;
use App\Http\Controllers\Api\EquipmentCategoryController;
use App\Http\Controllers\Api\StudentEquipmentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('groups', GroupController::class);
Route::apiResource('consumables', ConsumableController::class);
Route::apiResource('consumable-categories', ConsumableCategoryController::class);
Route::apiResource('schedules', ScheduleController::class);
Route::apiResource('students', StudentController::class);
Route::apiResource('shifts', ShiftController::class);
Route::apiResource('equipment', EquipmentController::class);
Route::apiResource('equipment-categories', EquipmentCategoryController::class);
Route::apiResource('appointments', AppointmentController::class);
Route::apiResource('clients', ClientController::class);
Route::apiResource('services', ServiceController::class);
Route::apiResource('service-categories', ServiceCategoryController::class);
Route::apiResource('student-consumables', StudentConsumableController::class);
Route::apiResource('appointment-services', AppointmentServiceController::class);
Route::apiResource('student-equipment', StudentEquipmentController::class);

// Soft deletes
Route::get('groups-deleted', [GroupController::class, 'deleted']);
Route::get('groups-deleted/{id}', [GroupController::class, 'deletedShow']);

Route::get('appointments-deleted', [AppointmentController::class, 'deleted']);
Route::get('appointments-deleted/{id}', [AppointmentController::class, 'deletedShow']);

Route::get('appointment-services-deleted', [AppointmentServiceController::class, 'deleted']);
Route::get('appointment-services-deleted/{id}', [AppointmentServiceController::class, 'deletedShow']);

Route::get('clients-deleted', [ClientController::class, 'deleted']);
Route::get('clients-deleted/{id}', [ClientController::class, 'deletedShow']);

Route::get('consumable-categories-deleted', [ConsumableCategoryController::class, 'deleted']);
Route::get('consumable-categories-deleted/{id}', [ConsumableCategoryController::class, 'deletedShow']);

Route::get('consumables-deleted', [ConsumableController::class, 'deleted']);
Route::get('consumables-deleted/{id}', [ConsumableController::class, 'deletedShow']);

Route::get('equipment-categories-deleted', [EquipmentCategoryController::class, 'deleted']);
Route::get('equipment-categories-deleted/{id}', [EquipmentCategoryController::class, 'deletedShow']);

Route::get('equipment-deleted', [EquipmentController::class, 'deleted']);
Route::get('equipment-deleted/{id}', [EquipmentController::class, 'deletedShow']);

Route::get('schedules-deleted', [ScheduleController::class, 'deleted']);
Route::get('schedules-deleted/{id}', [ScheduleController::class, 'deletedShow']);

Route::get('service-categories-deleted', [ServiceCategoryController::class, 'deleted']);
Route::get('service-categories-deleted/{id}', [ServiceCategoryController::class, 'deletedShow']);

Route::get('services-deleted', [ServiceController::class, 'deleted']);
Route::get('services-deleted/{id}', [ServiceController::class, 'deletedShow']);

Route::get('student-consumables-deleted', [StudentConsumableController::class, 'deleted']);
Route::get('student-consumables-deleted/{id}', [StudentConsumableController::class, 'deletedShow']);

Route::get('student-equipment-deleted', [StudentEquipmentController::class, 'deleted']);
Route::get('student-equipment-deleted/{id}', [StudentEquipmentController::class, 'deletedShow']);

Route::get('shifts-deleted', [ShiftController::class, 'deleted']);
Route::get('shifts-deleted/{id}', [ShiftController::class, 'deletedShow']);
