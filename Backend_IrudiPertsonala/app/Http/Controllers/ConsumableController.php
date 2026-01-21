<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Consumable;

class ConsumableController extends Controller
{
    // GET /api/consumable
    public function index()
    {
        $consumables = Consumable::all();

        return response()->json($consumables, 200);
    }

    // POST /api/consumable
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

        return response()->json($consumable, 201);
    }

    // GET /api/consumable/{id}
    public function show(string $id)
    {
        $consumable = Consumable::find($id);

        if (!$consumable) {
            return response()->json([
                'message' => 'Konsumiblea ez da existitzen'
            ], 404);
        }

        return response()->json($consumable, 200);
    }

    // PUT /api/consumable/{id}
    public function update(Request $request, string $id)
    {
        $consumable = Consumable::find($id);

        if (!$consumable) {
            return response()->json([
                'message' => 'Konsumiblea ez da existitzen'
            ], 404);
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

        return response()->json($consumable, 200);
    }

    // DELETE /api/consumable/{id}
    public function destroy(string $id)
    {
        $consumable = Consumable::find($id);

        if (!$consumable) {
            return response()->json([
                'message' => 'Konsumiblea ez da existitzen'
            ], 404);
        }

        $consumable->delete();

        return response()->json([
            'message' => 'Konsumiblea ezabatuta.'
        ], 202);
    }
}
