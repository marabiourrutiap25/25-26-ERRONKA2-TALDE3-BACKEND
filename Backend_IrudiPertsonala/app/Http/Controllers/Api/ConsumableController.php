<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Consumable;

class ConsumableController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $consumables = Consumable::all();
        return response()->json([
            'success' => true,
            'data' => $consumables
        ], Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'batch' => 'nullable|string|max:255',
            'brand' => 'nullable|string|max:255',
            'stock' => 'required|integer|min:0',
            'min_stock' => 'nullable|integer|min:0',
            'expiration_date' => 'nullable|date',
            'consumables_categorie_id' => 'required|exists:consumables_categories,id',
        ]);

        $consumable = Consumable::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Konsumiblea sortu egin da'
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
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

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $consumable = Consumable::find($id);

        if (!$consumable) {
            return response()->json([
                'success' => false,
                'message' => 'Konsumiblearen id-a ez da aurkitu'
            ], Response::HTTP_NOT_FOUND);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'batch' => 'nullable|string|max:255',
            'brand' => 'nullable|string|max:255',
            'stock' => 'required|integer|min:0',
            'min_stock' => 'nullable|integer|min:0',
            'expiration_date' => 'nullable|date',
            'consumables_categorie_id' => 'required|exists:consumables_categories,id',
        ]);

        $consumable->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Konsumiblea eguneratu da',
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
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
