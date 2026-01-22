<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Consumable;
use Illuminate\Validation\ValidationException;

class ConsumableController extends Controller
{
    /**
     * Reglas de validación reutilizables
     */
    private function validationRules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'batch' => 'nullable|string|max:255',
            'brand' => 'nullable|string|max:255',
            'stock' => 'required|integer|min:0',
            'min_stock' => 'nullable|integer|min:0',
            'expiration_date' => 'nullable|date',
            'consumables_category_id' => 'required|exists:consumables_categories,id',
        ];
    }

    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => Consumable::all()
        ], Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate($this->validationRules());
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors' => 'Datuak faltatzen dira.'
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        Consumable::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Konsumiblea sortu egin da'
        ], Response::HTTP_CREATED);
    }

    public function show(string $id)
    {
        $consumable = Consumable::find($id);

        if (!$consumable) {
            return response()->json([
                'success' => false,
                'message' => 'Konsumiblearen id-a ez da aurkitu'
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'success' => true,
            'data' => $consumable
        ], Response::HTTP_OK);
    }

    public function update(Request $request, string $id)
    {
        $consumable = Consumable::find($id);

        if (!$consumable) {
            return response()->json([
                'success' => false,
                'message' => 'Konsumiblearen id-a ez da aurkitu'
            ], Response::HTTP_NOT_FOUND);
        }

        try {
            $validated = $request->validate($this->validationRules());
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors' => 'Datuak faltatzen dira.'
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $consumable->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Konsumiblea eguneratu da'
        ], Response::HTTP_OK);
    }

    public function destroy(string $id)
    {
        $consumable = Consumable::find($id);

        if (!$consumable) {
            return response()->json([
                'success' => false,
                'data' => 'Konsumiblearen id-a ez da aurkitu'
            ], Response::HTTP_NOT_FOUND);
        }

        $consumable->delete();

        return response()->json([
            'success' => true,
            'data' => 'Konsumiblea ezabatuta'
        ], Response::HTTP_OK);
    }
}
