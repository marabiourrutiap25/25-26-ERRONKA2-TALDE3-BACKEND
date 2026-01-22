<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\EquipmentCategorie;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class EquipmentCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $equipmentCategories = EquipmentCategorie::all();
        return response()->json([
                'success' => true,
                'data' => $equipmentCategories
            ], Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $equipmentCategory = EquipmentCategorie::create($validated);

        return response()->json([
                'success' => true,
                'message' => 'Ekipamendu Kategoria sortu egin da'
            ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $equipmentCategory = EquipmentCategorie::find($id);

        if (!$equipmentCategory){
            return response()->json([
                'success' => false,
                'message' => 'Ekipamendu Kategorien id-a ez da aurkitu'
            ], Response::HTTP_NOT_FOUND); 
        } else {
            return response()->json([
                    'success' => true,
                    'data' => $equipmentCategory
                ], Response::HTTP_OK); 
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $equipmentCategory= EquipmentCategorie::find($id);

        if (!$equipmentCategory){
            return response()->json([
                'success' => false,
                'message' => 'Ekipamendu Kategorien id-a ez da aurkitu'
            ], Response::HTTP_NOT_FOUND); 
        } else {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
            ]);

            $equipmentCategory->update($validated);

            return response()->json([
                    'success' => true,
                    'message' => 'Ekipamendu Kategoria eguneratu da',
                ], Response::HTTP_OK); 
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $equipmentCategory = EquipmentCategorie::find($id);
        if (!$equipmentCategory){
            return response()->json([
                'success' => false,
                'data' => 'Ekipamendu Kategorien id-a ez da aurkitu'
            ], Response::HTTP_NOT_FOUND); 
        } else {
            $equipmentCategory->delete();
            return response()->json([
                    'success' => true,
                    'data' => 'Ekipamendu Kategoria ezabatuta'
                ], Response::HTTP_OK); 
        }
    }
}
