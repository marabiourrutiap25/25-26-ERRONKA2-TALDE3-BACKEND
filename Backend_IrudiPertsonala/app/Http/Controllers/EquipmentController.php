<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class EquipmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $equipments = Equipment::all();
        return response()->json([
                'success' => true,
                'data' => $equipments
            ], Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'label' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'brand' => 'nullable|string|max:255',
            'equipment_categories_id' => 'required|integer',
        ]);

        $equipment = Equipment::create($validated);

        return response()->json([
                'success' => true,
                'message' => 'Ekipamendua sortu egin da'
            ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $equipment = Equipment::find($id);

        if (!$equipment){
            return response()->json([
                'success' => false,
                'message' => 'Ekipamenduen id-a ez da aurkitu'
            ], Response::HTTP_NOT_FOUND); 
        } else {
            return response()->json([
                    'success' => true,
                    'data' => $equipment
                ], Response::HTTP_OK); 
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $equipment= Equipment::find($id);

        if (!$equipment){
            return response()->json([
                'success' => false,
                'message' => 'Ekipamenduen id-a ez da aurkitu'
            ], Response::HTTP_NOT_FOUND); 
        } else {
            $validated = $request->validate([
                'label' => 'required|string|max:255',
                'name' => 'required|string|max:255',
                'description' => 'nullable|string|max:255',
                'brand' => 'nullable|string|max:255',
                'equipment_categories_id' => 'required|integer',
            ]);

            $equipment->update($validated);

            return response()->json([
                    'success' => true,
                    'message' => 'Ekipamendua eguneratu da',
                    'data' => $equipment
                ], Response::HTTP_OK); 
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $equipment = Equipment::find($id);
        if (!$equipment){
            return response()->json([
                'success' => false,
                'data' => 'Ekipamenduen id-a ez da aurkitu'
            ], Response::HTTP_NOT_FOUND); 
        } else {
            $equipment->delete();
            return response()->json([
                    'success' => true,
                    'data' => 'Ekipamendua ezabatuta'
                ], Response::HTTP_OK); 
        }
    }
}
