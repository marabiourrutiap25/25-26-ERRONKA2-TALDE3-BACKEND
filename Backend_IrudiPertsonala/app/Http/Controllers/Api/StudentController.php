<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Student;
use Illuminate\Validation\ValidationException;

class StudentController extends Controller
{
    /**
     * Reglas de validación reutilizables
     */
    private function validationRules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'surnames' => 'required|string|max:255',
            'group_id' => 'required|exists:groups,id',
        ];
    }

    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => Student::all()
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

        Student::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Ikaslea sortu egin da'
        ], Response::HTTP_CREATED);
    }

    public function show(string $id)
    {
        $student = Student::find($id);

        if (!$student) {
            return response()->json([
                'success' => false,
                'message' => 'Ikaslearen id-a ez da aurkitu'
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'success' => true,
            'data' => $student
        ], Response::HTTP_OK);
    }

    public function update(Request $request, string $id)
    {
        $student = Student::find($id);

        if (!$student) {
            return response()->json([
                'success' => false,
                'message' => 'Ikaslearen id-a ez da aurkitu'
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

        $student->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Ikaslea eguneratu da',
        ], Response::HTTP_OK);
    }

    public function destroy(string $id)
    {
        $student = Student::find($id);

        if (!$student) {
            return response()->json([
                'success' => false,
                'data' => 'Ikaslearen id-a ez da aurkitu'
            ], Response::HTTP_NOT_FOUND);
        }

        $student->delete();

        return response()->json([
            'success' => true,
            'data' => 'Ikaslea ezabatuta'
        ], Response::HTTP_OK);
    }
}
