<?php

use App\Models\Consumable;
use App\Models\ConsumableCategory;

// Get All
test('Get all Consumables erantzun egokia bueltatzen du', function () {
    $estructura = [
        'success',
        'data' => [
            '*' => [
                'id',
                'name',
                'description',
                'batch',
                'brand',
                'stock',
                'min_stock',
                'expiration_date',
                'consumable_category_id',
                'created_at',
                'updated_at',
                'deleted_at'
            ]
        ]
    ];

    $category = ConsumableCategory::factory()->create();

    Consumable::factory()->count(3)->create([
        'consumable_category_id' => $category->id
    ]);

    $response = $this->getJson('api/consumables');
    $response->assertStatus(200);
    $response->assertJson([
        'success' => true,
    ]);
    $response->assertJsonCount(3, 'data');
    $response->assertJsonStructure($estructura);
});
