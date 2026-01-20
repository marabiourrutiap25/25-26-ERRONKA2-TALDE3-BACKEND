<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Schedules;

class ScheduleController extends Controller
{
    // GET /api/schedule
    public function index()
    {
        $schedules = Schedules::all();

        return response()->json($schedules, 200);
    }

    // POST /api/schedule
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

        return response()->json($schedule, 201);
    }

    // GET /api/schedule/{id}
    public function show(string $id)
    {
        $schedule = Schedules::find($id);

        if (!$schedule) {
            return response()->json([
                'message' => 'Ordutegia ez da existitzen'
            ], 404);
        }

        return response()->json($schedule, 200);
    }

    // PUT /api/schedule/{id}
    public function update(Request $request, string $id)
    {
        $schedule = Schedules::find($id);

        if (!$schedule) {
            return response()->json([
                'message' => 'Ordutegia ez da existitzen'
            ], 404);
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

        return response()->json($schedule, 200);
    }

    // DELETE /api/schedule/{id}
    public function destroy(string $id)
    {
        $schedule = Schedules::find($id);

        if (!$schedule) {
            return response()->json([
                'message' => 'Ordutegia ez da existitzen'
            ], 404);
        }

        $schedule->delete();

        return response()->json([
            'message' => 'Ordutegia ezabatuta.'
        ], 202);
    }
}
