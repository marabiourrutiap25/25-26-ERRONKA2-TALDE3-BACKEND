<?php

use App\Models\ConsumableCategory;

// Get All
test('Get all ConsumableCategories erantzun egokia bueltatzen du', function () {
    $estructura = [
        'success',
        'data' => [
            '*' => ['id', 'name', 'created_at', 'updated_at', 'deleted_at']
        ]
    ];

    ConsumableCategory::factory()->count(3)->create();

    $response = $this->getJson('api/consumable-categories');
    $response->assertStatus(200);
    $response->assertJson([
        'success' => true,
    ]);
    $response->assertJsonCount(3, 'data');
    $response->assertJsonStructure($estructura);
});
