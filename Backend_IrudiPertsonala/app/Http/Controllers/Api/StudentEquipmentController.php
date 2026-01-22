<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\StudentEquipment;
use Illuminate\Validation\ValidationException;

class StudentEquipmentController extends Controller
{
    private function validationRules(): array
    {
        return [
            'student_id' => 'required|exists:students,id',
            'equipment_id' => 'required|exists:equipment,id',
            'start_datetime' => 'required|date',
            'end_datetime' => 'required|date|after:start_datetime',
        ];
    }

    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => StudentEquipment::all()
        ], Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate($this->validationRules());
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors' => 'Datuak faltatzen dira.'
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        StudentEquipment::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'StudentEquipment sortu egin da'
        ], Response::HTTP_CREATED);
    }

    public function show(string $id)
    {
        $studentEquipment = StudentEquipment::find($id);

        if (!$studentEquipment) {
            return response()->json([
                'success' => false,
                'message' => 'StudentEquipment id-a ez da aurkitu'
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'success' => true,
            'data' => $studentEquipment
        ], Response::HTTP_OK);
    }

    public function update(Request $request, string $id)
    {
        $studentEquipment = StudentEquipment::find($id);

        if (!$studentEquipment) {
            return response()->json([
                'success' => false,
                'message' => 'StudentEquipment id-a ez da aurkitu'
            ], Response::HTTP_NOT_FOUND);
        }

        try {
            $validated = $request->validate($this->validationRules());
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors' => 'Datuak faltatzen dira.'
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $studentEquipment->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'StudentEquipment eguneratu da'
        ], Response::HTTP_OK);
    }

    public function destroy(string $id)
    {
        $studentEquipment = StudentEquipment::find($id);

        if (!$studentEquipment) {
            return response()->json([
                'success' => false,
                'data' => 'StudentEquipment id-a ez da aurkitu'
            ], Response::HTTP_NOT_FOUND);
        }

        $studentEquipment->delete();

        return response()->json([
            'success' => true,
            'data' => 'StudentEquipment ezabatuta'
        ], Response::HTTP_OK);
    }
}
