<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class ClientController extends Controller
{
    /**
     * Reglas de validación reutilizables
     */
    private function validationRules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'surnames' => 'required|string|max:255',
            'telephone' => 'nullable|string|max:255',
            'email' => 'nullable|string|max:255',
            'home_client' => 'required|boolean',
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clients = Client::all();
        return response()->json([
            'success' => true,
            'data' => $clients
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

        Client::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Bezeroa sortu egin da',
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $client = Client::find($id);

        if (!$client) {
            return response()->json([
                'success' => false,
                'message' => 'Bezero id-a ez da aurkitu'
            ], Response::HTTP_NOT_FOUND);
        } else {
            return response()->json([
                'success' => true,
                'data' => $client
            ], Response::HTTP_OK);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $client = Client::find($id);

        if (!$client) {
            return response()->json([
                'success' => false,
                'message' => 'Bezeroen id-a ez da aurkitu'
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

            $client->update($validated);

            return response()->json([
                'success' => true,
                'message' => 'Bezeroa eguneratu da',
            ], Response::HTTP_OK);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $client = Client::find($id);
        if (!$client) {
            return response()->json([
                'success' => false,
                'data' => 'Bezeroen id-a ez da aurkitu'
            ], Response::HTTP_NOT_FOUND);
        } else {
            $client->delete();
            return response()->json([
                'success' => true,
                'data' => 'Bezeroa ezabatuta'
            ], Response::HTTP_OK);
        }
    }
    public function deleted()
    {
        return response()->json([
            'success' => true,
            'data' => Client::onlyTrashed()->get()
        ], Response::HTTP_OK);
    }
    public function deletedShow(string $id)
    {
        $client = Client::onlyTrashed()->find($id);

        if (!$client) {
            return response()->json([
                'success' => false,
                'message' => 'Bezeroa ez da aurkitu (soft deleted)'
            ], Response::HTTP_NOT_FOUND);
        }

        return response()->json([
            'success' => true,
            'data' => $client
        ], Response::HTTP_OK);
    }

}
