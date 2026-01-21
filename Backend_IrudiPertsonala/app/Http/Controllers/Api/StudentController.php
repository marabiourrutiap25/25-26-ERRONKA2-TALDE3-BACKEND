<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Student;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $students = Student::all();
        return response()->json([
            'success' => true,
            'data' => $students
        ], Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'surnames' => 'required|string|max:255',
            'group_id' => 'required|exists:groups,id',
        ]);

        $student = Student::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Ikaslea sortu egin da'
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
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

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $student = Student::find($id);

        if (!$student) {
            return response()->json([
                'success' => false,
                'message' => 'Ikaslearen id-a ez da aurkitu'
            ], Response::HTTP_NOT_FOUND);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'surnames' => 'required|string|max:255',
            'group_id' => 'required|exists:groups,id',
        ]);

        $student->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Ikaslea eguneratu da',
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
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
