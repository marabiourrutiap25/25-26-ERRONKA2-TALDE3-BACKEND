<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\ConsumableCategory;
use Illuminate\Validation\ValidationException;

class ConsumableCategoryController extends Controller
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

    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => ConsumableCategory::all()
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

        ConsumableCategory::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Kategoria sortu egin da'
        ], Response::HTTP_CREATED);
    }

    public function show(string $id)
    {
        $category = ConsumableCategory::find($id);

        if (!$category) {
            return response()->json([
                'success' => false,
                'errors' => 'Kategoriaren id-a ez da aurkitu'
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'success' => true,
            'data' => $category
        ], Response::HTTP_OK);
    }

    public function update(Request $request, string $id)
    {
        $category = ConsumableCategory::find($id);

        if (!$category) {
            return response()->json([
                'success' => false,
                'errors' => 'Kategoriaren id-a ez da aurkitu'
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

        $category->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Kategoria eguneratu da'
        ], Response::HTTP_OK);
    }

    public function destroy(string $id)
    {
        $category = ConsumableCategory::find($id);

        if (!$category) {
            return response()->json([
                'success' => false,
                'errors' => 'Kategoriaren id-a ez da aurkitu'
            ], Response::HTTP_NOT_FOUND);
        }

        $category->delete();

        return response()->json([
            'success' => true,
            'message' => 'Kategoria ezabatuta'
        ], Response::HTTP_OK);
    }
    public function deleted()
    {
        return response()->json([
            'success' => true,
            'data' => ConsumableCategory::onlyTrashed()->get()
        ], Response::HTTP_OK);
    }

    public function deletedShow(string $id)
    {
        $category = ConsumableCategory::onlyTrashed()->find($id);

        if (!$category) {
            return response()->json([
                'success' => false,
                'errors' => 'Kategoria ez da aurkitu (soft deleted)'
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'success' => true,
            'data' => $category
        ], Response::HTTP_OK);
    }
}