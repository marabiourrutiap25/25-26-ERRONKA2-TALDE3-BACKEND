<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ConsumablesCategorie;

class ConsumableCategoriController extends Controller
{
    // GET /api/consumable-categori
    public function index()
    {
        $categories = ConsumablesCategorie::all();

        return response()->json($categories, 200);
    }

    // POST /api/consumable-categori
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category = ConsumablesCategorie::create($validated);

        return response()->json($category, 201);
    }

    // GET /api/consumable-categori/{id}
    public function show(string $id)
    {
        $category = ConsumablesCategorie::find($id);

        if (!$category) {
            return response()->json([
                'message' => 'Kategoria ez da existitzen'
            ], 404);
        }

        return response()->json($category, 200);
    }

    // PUT /api/consumable-categori/{id}
    public function update(Request $request, string $id)
    {
        $category = ConsumablesCategorie::find($id);

        if (!$category) {
            return response()->json([
                'message' => 'Kategoria ez da existitzen'
            ], 404);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category->update($validated);

        return response()->json($category, 200);
    }

    // DELETE /api/consumable-categori/{id}
    public function destroy(string $id)
    {
        $category = ConsumablesCategorie::find($id);

        if (!$category) {
            return response()->json([
                'message' => 'Kategoria ez da existitzen'
            ], 404);
        }

        $category->delete();

        return response()->json([
            'message' => 'Kategoria ezabatuta.'
        ], 202);
    }
}
