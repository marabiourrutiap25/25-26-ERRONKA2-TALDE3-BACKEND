<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Equipment;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class EquipmentController extends Controller
{
    /**
     * Reglas de validación reutilizables
     */
    private function validationRules(): array
    {
        return [
            'label' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'brand' => 'nullable|string|max:255',
            'equipment_category_id' => 'required|integer|exists:equipment_categories,id',
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $equipment = Equipment::all();
        return response()->json([
            'success' => true,
            'data' => $equipment
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
                'errors' => 'Datuak faltatzen dira.',
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        Equipment::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Ekipamendua sortu egin da',
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $equipment = Equipment::find($id);

        if (!$equipment) {
            return response()->json([
                'success' => false,
                'errors' => 'Ekipamenduen id-a ez da aurkitu'
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
        $equipment = Equipment::find($id);

        if (!$equipment) {
            return response()->json([
                'success' => false,
                'errors' => 'Ekipamenduen id-a ez da aurkitu'
            ], Response::HTTP_NOT_FOUND);
        } else {
            try {
                $validated = $request->validate($this->validationRules());
            } catch (ValidationException $e) {
                return response()->json([
                    'success' => false,
                    'errors' => 'Datuak faltatzen dira.',
                ], Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            $equipment->update($validated);

            return response()->json([
                'success' => true,
                'message' => 'Ekipamendua eguneratu da',
            ], Response::HTTP_OK);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $equipment = Equipment::find($id);
        if (!$equipment) {
            return response()->json([
                'success' => false,
                'errors' => 'Ekipamenduen id-a ez da aurkitu'
            ], Response::HTTP_NOT_FOUND);
        } else {
            $equipment->delete();
            return response()->json([
                'success' => true,
                'message' => 'Ekipamendua ezabatuta'
            ], Response::HTTP_OK);
        }
    }
    public function deleted()
    {
        return response()->json([
            'success' => true,
            'data' => Equipment::onlyTrashed()->get()
        ], Response::HTTP_OK);
    }

    public function deletedShow(string $id)
    {
        $equipment = Equipment::onlyTrashed()->find($id);

        if (!$equipment) {
            return response()->json([
                'success' => false,
                'errors' => 'Ekipamendua ez da aurkitu (soft deleted)'
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'success' => true,
            'data' => $equipment
        ], Response::HTTP_OK);
    }



}
