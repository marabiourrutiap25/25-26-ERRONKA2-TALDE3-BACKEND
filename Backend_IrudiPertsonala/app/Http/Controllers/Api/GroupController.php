<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Group;

class GroupController extends Controller
{

    public function index()
    {
        $groups = Group::all();
        return response()->json([
            'success' => true,
            'data' => $groups
        ], Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $group = Group::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Taldea sortu egin da'
        ], Response::HTTP_CREATED);
    }

    public function show(string $id)
    {
        $group = Group::find($id);

        if (!$group){
            return response()->json([
                'success' => false,
                'message' => 'Taldearen id-a ez da aurkitu'
            ], Response::HTTP_NOT_FOUND); 
        } else {
            return response()->json([
                'success' => true,
                'data' => $group
            ], Response::HTTP_OK); 
        }
    }

    public function update(Request $request, string $id)
    {
        $group = Group::find($id);

        if (!$group){
            return response()->json([
                'success' => false,
                'message' => 'Taldearen id-a ez da aurkitu'
            ], Response::HTTP_NOT_FOUND); 
        } else {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
            ]);

            $group->update($validated);

            return response()->json([
                'success' => true,
                'message' => 'Taldea eguneratu da',
            ], Response::HTTP_OK); 
        }
    }

    public function destroy(string $id)
    {
        $group = Group::find($id);
        if (!$group){
            return response()->json([
                'success' => false,
                'data' => 'Taldearen id-a ez da aurkitu'
            ], Response::HTTP_NOT_FOUND); 
        } else {
            $group->delete();
            return response()->json([
                'success' => true,
                'data' => 'Taldea ezabatuta'
            ], Response::HTTP_OK); 
        }
    }
}
