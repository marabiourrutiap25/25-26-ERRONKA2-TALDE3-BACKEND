<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\StudentConsumable;
use Illuminate\Validation\ValidationException;

class StudentConsumableController extends Controller
{
    /**
     * Reglas de validación reutilizables
     */
    private function validationRules(): array
    {
        return [
            'student_id' => 'required|exists:students,id',
            'consumable_id' => 'required|exists:consumables,id',
            'date' => 'required|date',
            'quantity' => 'nullable|integer|min:1',
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => StudentConsumable::all()
        ], Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
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

        StudentConsumable::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'StudentConsumable sortu egin da'
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $studentConsumable = StudentConsumable::find($id);

        if (!$studentConsumable) {
            return response()->json([
                'success' => false,
                'message' => 'StudentConsumable id-a ez da aurkitu'
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'success' => true,
            'data' => $studentConsumable
        ], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $studentConsumable = StudentConsumable::find($id);

        if (!$studentConsumable) {
            return response()->json([
                'success' => false,
                'message' => 'StudentConsumable id-a ez da aurkitu'
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

        $studentConsumable->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'StudentConsumable eguneratu da'
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $studentConsumable = StudentConsumable::find($id);

        if (!$studentConsumable) {
            return response()->json([
                'success' => false,
                'data' => 'StudentConsumable id-a ez da aurkitu'
            ], Response::HTTP_NOT_FOUND);
        }

        $studentConsumable->delete();

        return response()->json([
            'success' => true,
            'data' => 'StudentConsumable ezabatuta'
        ], Response::HTTP_OK);
    }
    // Métodos soft delete
    public function deleted()
    {
        return response()->json([
            'success' => true,
            'data' => StudentConsumable::onlyTrashed()->get()
        ], Response::HTTP_OK);
    }

    public function deletedShow(string $id)
    {
        $studentConsumable = StudentConsumable::onlyTrashed()->find($id);

        if (!$studentConsumable) {
            return response()->json([
                'success' => false,
                'message' => 'StudentConsumable ez da aurkitu (soft deleted)'
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'success' => true,
            'data' => $studentConsumable
        ], Response::HTTP_OK);
    }

}
