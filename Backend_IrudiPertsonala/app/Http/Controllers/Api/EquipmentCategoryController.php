<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\EquipmentCategorie;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class EquipmentCategoryController extends Controller
{
    /**
     * Reglas de validación reutilizables
     */
    private function validationRules(): array
    {
        return [
            'name' => 'required|string|max:255',
        ];
    }

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
        try {
            $validated = $request->validate($this->validationRules());
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors'  => 'Datuak faltatzen dira.',
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        EquipmentCategorie::create($validated);

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

        if (!$equipmentCategory) {
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
        $equipmentCategory = EquipmentCategorie::find($id);

        if (!$equipmentCategory) {
            return response()->json([
                'success' => false,
                'message' => 'Ekipamendu Kategorien id-a ez da aurkitu'
            ], Response::HTTP_NOT_FOUND);
        } else {
            try {
                $validated = $request->validate($this->validationRules());
            } catch (ValidationException $e) {
                return response()->json([
                    'success' => false,
                    'errors'  => 'Datuak faltatzen dira.',
                ], Response::HTTP_UNPROCESSABLE_ENTITY);
            }

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
        if (!$equipmentCategory) {
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
