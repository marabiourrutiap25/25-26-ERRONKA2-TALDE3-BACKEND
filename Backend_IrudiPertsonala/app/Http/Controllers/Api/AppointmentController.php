<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $appointments = Appointment::all();
        return response()->json([
                'success' => true,
                'data' => $appointments
            ], Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'seat' => 'required|integer',
            'date' => 'required|date_format:H:i:s',
            'start_time' => 'required|date_format:H:i:s',
            'end_time' => 'required|date_format:H:i:s|after:start_time',
            'comments' => 'required|string',
            'student_id' => 'required|exists:students,id',
            'client_id' => 'required|exists:clients,id',
        ]);

        $appointment = Appointment::create($validated);

        return response()->json([
                'success' => true,
                'message' => 'Zerbitzu Kategoria sortu egin da'
            ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $appointment = Appointment::find($id);

        if (!$appointment){
            return response()->json([
                'success' => false,
                'message' => 'Hitzorduen id-a ez da aurkitu'
            ], Response::HTTP_NOT_FOUND); 
        } else {
            return response()->json([
                    'success' => true,
                    'data' => $appointment
                ], Response::HTTP_OK); 
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $appointment= Appointment::find($id);

        if (!$appointment){
            return response()->json([
                'success' => false,
                'message' => 'Hitzorduen id-a ez da aurkitu'
            ], Response::HTTP_NOT_FOUND); 
        } else {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
            ]);

            $appointment->update($validated);

            return response()->json([
                    'success' => true,
                    'message' => 'Hitzordua eguneratu da',
                ], Response::HTTP_OK); 
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $appointment = Appointment::find($id);
        if (!$appointment){
            return response()->json([
                'success' => false,
                'data' => 'Hitzorduen id-a ez da aurkitu'
            ], Response::HTTP_NOT_FOUND); 
        } else {
            $appointment->delete();
            return response()->json([
                    'success' => true,
                    'data' => 'Hitzordua ezabatuta'
                ], Response::HTTP_OK); 
        }
    }
}
