<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Schedules;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $schedules = Schedules::all();
        return response()->json([
            'success' => true,
            'data' => $schedules
        ], Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'day' => 'required|integer|between:1,7',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'start_time' => 'required|date_format:H:i:s',
            'end_time' => 'required|date_format:H:i:s|after:start_time',
            'group_id' => 'required|exists:groups,id',
        ]);

        $schedule = Schedules::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Ordutegia sortu egin da'
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $schedule = Schedules::find($id);

        if (!$schedule) {
            return response()->json([
                'success' => false,
                'message' => 'Ordutegiaren id-a ez da aurkitu'
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'success' => true,
            'data' => $schedule
        ], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $schedule = Schedules::find($id);

        if (!$schedule) {
            return response()->json([
                'success' => false,
                'message' => 'Ordutegiaren id-a ez da aurkitu'
            ], Response::HTTP_NOT_FOUND);
        }

        $validated = $request->validate([
            'day' => 'required|integer|between:1,7',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'start_time' => 'required|date_format:H:i:s',
            'end_time' => 'required|date_format:H:i:s|after:start_time',
            'group_id' => 'required|exists:groups,id',
        ]);

        $schedule->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Ordutegia eguneratu da',
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $schedule = Schedules::find($id);

        if (!$schedule) {
            return response()->json([
                'success' => false,
                'data' => 'Ordutegiaren id-a ez da aurkitu'
            ], Response::HTTP_NOT_FOUND);
        }

        $schedule->delete();

        return response()->json([
            'success' => true,
            'data' => 'Ordutegia ezabatuta'
        ], Response::HTTP_OK);
    }
}
