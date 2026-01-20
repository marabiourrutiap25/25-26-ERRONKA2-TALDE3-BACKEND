<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;

class StudentController extends Controller
{
    // GET /api/student
    public function index()
    {
        $students = Student::all();

        return response()->json($students, 200);
    }

    // POST /api/student
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'surnames' => 'required|string|max:255',
            'group_id' => 'required|exists:groups,id',
        ]);

        $student = Student::create($validated);

        return response()->json($student, 201);
    }

    // GET /api/student/{id}
    public function show(string $id)
    {
        $student = Student::find($id);

        if (!$student) {
            return response()->json([
                'message' => 'Ikaslea ez da existitzen'
            ], 404);
        }

        return response()->json($student, 200);
    }

    // PUT /api/student/{id}
    public function update(Request $request, string $id)
    {
        $student = Student::find($id);

        if (!$student) {
            return response()->json([
                'message' => 'Ikaslea ez da existitzen'
            ], 404);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'surnames' => 'required|string|max:255',
            'group_id' => 'required|exists:groups,id',
        ]);

        $student->update($validated);

        return response()->json($student, 200);
    }

    // DELETE /api/student/{id}
    public function destroy(string $id)
    {
        $student = Student::find($id);

        if (!$student) {
            return response()->json([
                'message' => 'Ikaslea ez da existitzen'
            ], 404);
        }

        $student->delete();

        return response()->json([
            'message' => 'Ikaslea ezabatuta.'
        ], 202);
    }
}
