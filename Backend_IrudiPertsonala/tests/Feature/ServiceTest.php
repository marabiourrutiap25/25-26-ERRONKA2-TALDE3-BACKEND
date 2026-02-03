<?php

use App\Models\Service;
use App\Models\ServiceCategory;

// Get All
test('Get all Services erantzun egokia bueltatzen du', function () {
    $estructura = [
        'success',
        'data' => [
            '*' => ['id', 'name', 'price', 'home_price', 'duration', 'service_category_id', 'created_at', 'updated_at', 'deleted_at']
        ]
    ];

    $category = ServiceCategory::factory()->create();

    Service::factory()->count(3)->create([
        'service_category_id' => $category->id,
    ]);

    $response = $this->getJson('api/services');
    $response->assertStatus(200);
    $response->assertJson([
        'success' => true,
    ]);
    $response->assertJsonCount(3, 'data');
    $response->assertJsonStructure($estructura);
});
