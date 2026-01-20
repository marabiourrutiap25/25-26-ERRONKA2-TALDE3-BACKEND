<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Shift;

class ShiftController extends Controller
{
    // GET /api/shift
    public function index()
    {
        $shifts = Shift::all();

        return response()->json($shifts, 200);
    }

    // POST /api/shift
    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|string|in:A,B,C',
            'data' => 'required|date',
            'student_id' => 'required|exists:students,id',
        ]);

        $shift = Shift::create($validated);

        return response()->json($shift, 201);
    }

    // GET /api/shift/{id}
    public function show(string $id)
    {
        $shift = Shift::find($id);

        if (!$shift) {
            return response()->json([
                'message' => 'Txanda ez da existitzen'
            ], 404);
        }

        return response()->json($shift, 200);
    }

    // PUT /api/shift/{id}
    public function update(Request $request, string $id)
    {
        $shift = Shift::find($id);

        if (!$shift) {
            return response()->json([
                'message' => 'Txanda ez da existitzen'
            ], 404);
        }

        $validated = $request->validate([
            'type' => 'required|string|in:A,B,C',
            'data' => 'required|date',
            'student_id' => 'required|exists:students,id',
        ]);

        $shift->update($validated);

        return response()->json($shift, 200);
    }

    // DELETE /api/shift/{id}
    public function destroy(string $id)
    {
        $shift = Shift::find($id);

        if (!$shift) {
            return response()->json([
                'message' => 'Txanda ez da existitzen'
            ], 404);
        }

        $shift->delete();

        return response()->json([
            'message' => 'Txanda ezabatuta.'
        ], 202);
    }
}
