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
        $groups = Group::all();

        return response()->json($groups, 200);
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
        $group = Group::find($id);

        if (!$group) {
            return response()->json([
                'message' => 'Taldea ez da existitzen'
            ], 404);
        }

        return response()->json($group, 200);
    }

    // PUT /api/group/{id}
    public function update(Request $request, string $id)
    {
        $group = Group::find($id);

        if (!$group) {
            return response()->json([
                'message' => 'Taldea ez da existitzen'
            ], 404);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $group->update($validated);

        return response()->json($group, 200);
    }

    // DELETE /api/group/{id}
    public function destroy(string $id)
    {
        $group = Group::find($id);

        if (!$group) {
            return response()->json([
                'message' => 'Taldea ez da existitzen'
            ], 404);
        }

        $group->delete();

        return response()->json([
            'message' => 'Taldea ezabatuta.'
        ], 202);
    }
}
