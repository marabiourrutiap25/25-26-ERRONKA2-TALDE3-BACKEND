<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Group;
use Illuminate\Validation\ValidationException;

class GroupController extends Controller
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
            'data' => Group::all()
        ], Response::HTTP_OK);
    }

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

        Group::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Taldea sortu egin da'
        ], Response::HTTP_CREATED);
    }

    public function show(string $id)
    {
        $group = Group::find($id);

        if (!$group) {
            return response()->json([
                'success' => false,
                'errors' => 'Taldearen id-a ez da aurkitu'
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'success' => true,
            'data' => $group
        ], Response::HTTP_OK);
    }

    public function update(Request $request, string $id)
    {
        $group = Group::find($id);

        if (!$group) {
            return response()->json([
                'success' => false,
                'errors' => 'Taldearen id-a ez da aurkitu'
            ], Response::HTTP_NOT_FOUND);
        }

        try {
            $validated = $request->validate($this->validationRules());
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'errors' => 'Datuak faltatzen dira.',
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $group->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Taldea eguneratu da',
        ], Response::HTTP_OK);
    }

    public function destroy(string $id)
    {
        $group = Group::find($id);

        if (!$group) {
            return response()->json([
                'success' => false,
                'errors' => 'Taldearen id-a ez da aurkitu'
            ], Response::HTTP_NOT_FOUND);
        }

        $group->delete();

        return response()->json([
            'success' => true,
            'message' => 'Taldea ezabatuta'
        ], Response::HTTP_OK);
    }

    // GPT-ado:
    public function deleted()
    {
        return response()->json([
            'success' => true,
            'data' => Group::onlyTrashed()->get()
        ], Response::HTTP_OK);
    }
    public function deletedShow(string $id)
    {
        $group = Group::onlyTrashed()->find($id);

        if (!$group) {
            return response()->json([
                'success' => false,
                'errors' => 'Taldea ez da aurkitu (soft deleted)'
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'success' => true,
            'data' => $group
        ], Response::HTTP_OK);
    }

}
