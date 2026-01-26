<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Shift;
use Illuminate\Validation\ValidationException;

class ShiftController extends Controller
{
    /**
     * Reglas de validación reutilizables
     */
    private function validationRules(): array
    {
        return [
            'type' => 'required|string|in:A,B,C',
            'data' => 'required|date',
            'student_id' => 'required|exists:students,id',
        ];
    }

    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => Shift::all()
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

        Shift::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Txanda sortu egin da'
        ], Response::HTTP_CREATED);
    }

    public function show(string $id)
    {
        $shift = Shift::find($id);

        if (!$shift) {
            return response()->json([
                'success' => false,
                'message' => 'Txandaren id-a ez da aurkitu'
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'success' => true,
            'data' => $shift
        ], Response::HTTP_OK);
    }

    public function update(Request $request, string $id)
    {
        $shift = Shift::find($id);

        if (!$shift) {
            return response()->json([
                'success' => false,
                'message' => 'Txandaren id-a ez da aurkitu'
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

        $shift->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Txanda eguneratu da',
        ], Response::HTTP_OK);
    }

    public function destroy(string $id)
    {
        $shift = Shift::find($id);

        if (!$shift) {
            return response()->json([
                'success' => false,
                'data' => 'Txandaren id-a ez da aurkitu'
            ], Response::HTTP_NOT_FOUND);
        }

        $shift->delete();

        return response()->json([
            'success' => true,
            'data' => 'Txanda ezabatuta'
        ], Response::HTTP_OK);
    }
    // Métodos soft delete
    public function deleted()
    {
        return response()->json([
            'success' => true,
            'data' => Shift::onlyTrashed()->get()
        ], Response::HTTP_OK);
    }

    public function deletedShow(string $id)
    {
        $shift = Shift::onlyTrashed()->find($id);

        if (!$shift) {
            return response()->json([
                'success' => false,
                'message' => 'Txanda ez da aurkitu (soft deleted)'
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'success' => true,
            'data' => $shift
        ], Response::HTTP_OK);
    }

}
