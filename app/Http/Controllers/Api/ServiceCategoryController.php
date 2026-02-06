<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ServiceCategory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class ServiceCategoryController extends Controller
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
        $serviceCategories = ServiceCategory::all();
        return response()->json([
            'success' => true,
            'data' => $serviceCategories
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

        ServiceCategory::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Zerbitzu Kategoria sortu egin da'
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $serviceCategory = ServiceCategory::find($id);

        if (!$serviceCategory) {
            return response()->json([
                'success' => false,
                'message' => 'Zerbitzu Kategorien id-a ez da aurkitu'
            ], Response::HTTP_NOT_FOUND);
        } else {
            return response()->json([
                'success' => true,
                'data' => $serviceCategory
            ], Response::HTTP_OK);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $serviceCategory = ServiceCategory::find($id);

        if (!$serviceCategory) {
            return response()->json([
                'success' => false,
                'message' => 'Zerbitzu Kategorien id-a ez da aurkitu'
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

            $serviceCategory->update($validated);

            return response()->json([
                'success' => true,
                'message' => 'Zerbitzu Kategoria eguneratu da',
            ], Response::HTTP_OK);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $serviceCategory = ServiceCategory::find($id);
        if (!$serviceCategory) {
            return response()->json([
                'success' => false,
                'data' => 'Zerbitzu Kategorien id-a ez da aurkitu'
            ], Response::HTTP_NOT_FOUND);
        } else {
            $serviceCategory->delete();
            return response()->json([
                'success' => true,
                'data' => 'Zerbitzu Kategoria ezabatuta'
            ], Response::HTTP_OK);
        }
    }
    public function deleted()
    {
        return response()->json([
            'success' => true,
            'data' => ServiceCategory::onlyTrashed()->get()
        ], Response::HTTP_OK);
    }

    public function deletedShow(string $id)
    {
        $category = ServiceCategory::onlyTrashed()->find($id);

        if (!$category) {
            return response()->json([
                'success' => false,
                'message' => 'Zerbitzu Kategoria ez da aurkitu (soft deleted)'
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'success' => true,
            'data' => $category
        ], Response::HTTP_OK);
    }

}
