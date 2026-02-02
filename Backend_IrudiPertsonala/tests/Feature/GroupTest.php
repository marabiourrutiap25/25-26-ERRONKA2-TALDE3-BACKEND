<?php

use App\Models\Group;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

test('Get all Groups erantzun egokia bueltatzen du', function () {
    $estructura = [
        'success',
        'data' => [
            '*' => ['id', 'name', 'created_at', 'updated_at', 'deleted_at']
        ]
    ];

    $user = User::factory()->create();
    Sanctum::actingAs($user);

    Group::factory()->count(3)->create();

    $response = $this->getJson('api/groups');
    $response->assertStatus(200);
    $response->assertJson([
        'success' => true,
    ]);
    $response->assertJsonCount(3, 'data');
    $response->assertJsonStructure($estructura);
});
