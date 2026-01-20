<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Group;
use App\Http\Controllers\Api\Consumable;
use App\Http\Controllers\Api\ConsumableCategori;
use App\Http\Controllers\Api\Schedule;
use App\Http\Controllers\Api\Shift;
use App\Http\Controllers\Api\Student;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('todos', Group::class);
Route::apiResource('todos', Consumable::class);
Route::apiResource('todos', ConsumableCategori::class);
Route::apiResource('todos', Schedule::class);
Route::apiResource('todos', Student::class);
Route::apiResource('todos', Shift::class);