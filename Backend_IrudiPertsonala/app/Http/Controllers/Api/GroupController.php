<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Group;

class GroupController extends Controller
{

    // GET /api/group
    public function index()
    {
        $todos = Group::all();
        return response()->json($todos, 200);
    }

    // POST /api/group
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $group = Group::create($validated);
        return response()->json($group, 201);
    }

    // GET /api/group/{id}
    public function show(string $id)
    {
        $todo = Group::findOrFail($id);
        return response()->json($todo, 200);
    }


    public function update(Request $request, string $id)
    {
        $todo = Group::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $todo->update($validated);
        return response()->json($todo, 200);
    }

    // DELETE /api/group/{id}
    public function destroy(string $id)
    {
        $todo = Group::find($id);

        if (!$todo) {
            return response()->json([
                'message' => 'Taldea ez da axistitzen'
            ], 404);
        }

        $todo->delete();

        return response()->json([
            'message' => 'Group-a ezabatuta.'
        ], 202);
    }

}