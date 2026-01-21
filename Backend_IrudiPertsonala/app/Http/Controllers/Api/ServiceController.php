<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $services = Service::all();
        return response()->json([
                'success' => true,
                'data' => $services
            ], Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'home_price' => 'required|numeric|min:0',
            'duration' => 'nullable|integer|min:0',
            'service_categories_id' => 'required|integer|exists:service_categories,id',
        ]);

        $equipment = Service::create($validated);

        return response()->json([
                'success' => true,
                'message' => 'Zerbitzua sortu egin da',
            ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $service = Service::find($id);

        if (!$service){
            return response()->json([
                'success' => false,
                'message' => 'Zerbitzuaren id-a ez da aurkitu'
            ], Response::HTTP_NOT_FOUND); 
        } else {
            return response()->json([
                    'success' => true,
                    'data' => $service
                ], Response::HTTP_OK); 
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $service= Service::find($id);

        if (!$service){
            return response()->json([
                'success' => false,
                'message' => 'Ekipamenduen id-a ez da aurkitu'
            ], Response::HTTP_NOT_FOUND); 
        } else {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'price' => 'required|numeric|min:0',
                'home_price' => 'required|numeric|min:0',
                'duration' => 'nullable|integer|min:0',
                'service_categories_id' => 'required|integer|exists:service_categories,id',
            ]);

            $service->update($validated);

            return response()->json([
                    'success' => true,
                    'message' => 'Zerbitzua eguneratu da',
                ], Response::HTTP_OK); 
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $service = Service::find($id);
        if (!$service){
            return response()->json([
                'success' => false,
                'data' => 'Zerbitzuaren id-a ez da aurkitu'
            ], Response::HTTP_NOT_FOUND); 
        } else {
            $service->delete();
            return response()->json([
                    'success' => true,
                    'data' => 'Zerbitzua ezabatuta'
                ], Response::HTTP_OK); 
        }
    }
}
