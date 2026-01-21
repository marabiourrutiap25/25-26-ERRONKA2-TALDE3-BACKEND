<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Shift;

class ShiftController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $shifts = Shift::all();
        return response()->json([
            'success' => true,
            'data' => $shifts
        ], Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|string|in:A,B,C',
            'data' => 'required|date',
            'student_id' => 'required|exists:students,id',
        ]);

        $shift = Shift::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Txanda sortu egin da'
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
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

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $shift = Shift::find($id);

        if (!$shift) {
            return response()->json([
                'success' => false,
                'message' => 'Txandaren id-a ez da aurkitu'
            ], Response::HTTP_NOT_FOUND);
        }

        $validated = $request->validate([
            'type' => 'required|string|in:A,B,C',
            'data' => 'required|date',
            'student_id' => 'required|exists:students,id',
        ]);

        $shift->update(attributes: $validated);

        return response()->json([
            'success' => true,
            'message' => 'Txanda eguneratu da',
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
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
}
