<?php

use App\Models\Equipment;
use App\Models\EquipmentCategory;

// Get All
test('Get all Equipments erantzun egokia bueltatzen du', function () {
    $estructura = [
        'success',
        'data' => [
            '*' => ['id', 'label', 'name', 'description', 'brand', 'equipment_category_id', 'created_at', 'updated_at', 'deleted_at']
        ]
    ];

    $category = EquipmentCategory::factory()->create();

    Equipment::factory()->count(3)->create([
        'equipment_category_id' => $category->id,
    ]);

    $response = $this->getJson('api/equipment');
    $response->assertStatus(200);
    $response->assertJson([
        'success' => true,
    ]);
    $response->assertJsonCount(3, 'data');
    $response->assertJsonStructure($estructura);
});
