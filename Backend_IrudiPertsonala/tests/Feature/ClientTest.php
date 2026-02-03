<?php

use App\Models\Client;

// Get All
test('Get all Clients erantzun egokia bueltatzen du', function () {
    $estructura = [
        'success',
        'data' => [
            '*' => ['id', 'name', 'surnames', 'telephone', 'email', 'home_client', 'created_at', 'updated_at', 'deleted_at']
        ]
    ];

    Client::factory()->count(3)->create();

    $response = $this->getJson('api/clients');
    $response->assertStatus(200);
    $response->assertJson([
        'success' => true,
    ]);
    $response->assertJsonCount(3, 'data');
    $response->assertJsonStructure($estructura);
});
