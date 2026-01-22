<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Schedules;
use Illuminate\Validation\ValidationException;

class ScheduleController extends Controller
{
    /**
     * Reglas de validación reutilizables
     */
    private function validationRules(): array
    {
        return [
            'day' => 'required|integer|between:1,7',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'start_time' => 'required|date_format:H:i:s',
            'end_time' => 'required|date_format:H:i:s|after:start_time',
            'group_id' => 'required|exists:groups,id',
        ];
    }

    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => Schedules::all()
        ], Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate($this->validationRules());
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors' => 'Datuak faltatzen dira.',
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        Schedules::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Ordutegia sortu egin da'
        ], Response::HTTP_CREATED);
    }

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

    public function update(Request $request, string $id)
    {
        $schedule = Schedules::find($id);

        if (!$schedule) {
            return response()->json([
                'success' => false,
                'message' => 'Ordutegiaren id-a ez da aurkitu'
            ], Response::HTTP_NOT_FOUND);
        }

        try {
            $validated = $request->validate($this->validationRules());
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors' => 'Datuak faltatzen dira.',
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $schedule->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Ordutegia eguneratu da',
        ], Response::HTTP_OK);
    }

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
