<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\ConsumablesCategorie;

class ConsumableCategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = ConsumablesCategorie::all();
        return response()->json([
            'success' => true,
            'data' => $categories
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

        $category = ConsumablesCategorie::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Kategoria sortu egin da'
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category = ConsumablesCategorie::find($id);

        if (!$category) {
            return response()->json([
                'success' => false,
                'message' => 'Kategoriaren id-a ez da aurkitu'
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'success' => true,
            'data' => $category
        ], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $category = ConsumablesCategorie::find($id);

        if (!$category) {
            return response()->json([
                'success' => false,
                'message' => 'Kategoriaren id-a ez da aurkitu'
            ], Response::HTTP_NOT_FOUND);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category->update(attributes: $validated);

        return response()->json([
            'success' => true,
            'message' => 'Kategoria eguneratu da',
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = ConsumablesCategorie::find($id);

        if (!$category) {
            return response()->json([
                'success' => false,
                'data' => 'Kategoriaren id-a ez da aurkitu'
            ], Response::HTTP_NOT_FOUND);
        }

        $category->delete();

        return response()->json([
            'success' => true,
            'data' => 'Kategoria ezabatuta'
        ], Response::HTTP_OK);
    }
}
