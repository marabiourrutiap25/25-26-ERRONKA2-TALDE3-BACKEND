<?php

use App\Models\EquipmentCategory;

use function Pest\Laravel\postJson;

// Get All
test('Get all EquipmentCategories erantzun egokia bueltatzen du', function () {
    $estructura = [
        'success',
        'data' => [
            '*' => ['id', 'name', 'created_at', 'updated_at', 'deleted_at']
        ]
    ];

    EquipmentCategory::factory()->count(3)->create();

    $response = $this->getJson('api/equipment-categories');
    $response->assertStatus(200);
    $response->assertJson([
        'success' => true,
    ]);
    $response->assertJsonCount(3, 'data');
    $response->assertJsonStructure($estructura);
});

// Get All soft-deleted
test('Get all EquipmentCategories soft-delete egindakoak erantzun egokia bueltatzen du', function () {
    $estructura = [
        'success',
        'data' => [
            '*' => ['id', 'name', 'created_at', 'updated_at', 'deleted_at']
        ]
    ];

    $categories = EquipmentCategory::factory()->count(3)->create();
    $categories->each->delete();

    $response = $this->getJson('api/equipment-categories-deleted');
    $response->assertStatus(200);
    $response->assertJson([
        'success' => true,
    ]);
    $response->assertJsonCount(3, 'data');
    $response->assertJsonStructure($estructura);
});

// Get one ongi
test('Get one EquipmentCategory erantzun egokia bueltatzen du', function () {
    $estructura = [
        'success',
        'data' => ['id', 'name', 'created_at', 'updated_at', 'deleted_at']
    ];

    $category = EquipmentCategory::factory()->create();

    $response = $this->getJson("api/equipment-categories/{$category->id}");
    $response->assertStatus(200);
    $response->assertJson([
        'success' => true,
    ]);
    $response->assertJsonStructure($estructura);
    $response->assertJsonPath('data.id', $category->id);
});

// Get one existitzen ez duena
test('Get one EquipmentCategory existitzen ez duena', function () {
    $response = $this->getJson('api/equipment-categories/99999');
    $response->assertStatus(404);
    $response->assertExactJson([
        'success' => false,
        'errors' => 'Ekipamendu Kategorien id-a ez da aurkitu'
    ]);
});

// Get one soft delete
test('Get one EquipmentCategory soft delete eginda dagoena', function () {
    $estructura = [
        'success',
        'data' => ['id', 'name', 'created_at', 'updated_at', 'deleted_at']
    ];

    $category = EquipmentCategory::factory()->create();
    $category->delete();

    $response = $this->getJson("api/equipment-categories-deleted/{$category->id}");
    $response->assertStatus(200);
    $response->assertJson([
        'success' => true,
    ]);
    $response->assertJsonStructure($estructura);
});

// Post ongi
test('Post EquipmentCategory erantzun egokia bueltatzen du', function () {
    $response = postJson('api/equipment-categories', [
        'name' => 'Diagnostics'
    ]);

    $response->assertStatus(201);
    $response->assertExactJson([
        'success' => true,
        'message' => 'Ekipamendu Kategoria sortu egin da'
    ]);
});

// Post txarto
test('Post EquipmentCategory erantzun okerra bueltatzen du, datu falta', function () {
    $response = postJson('api/equipment-categories', []);

    $response->assertStatus(422);
    $response->assertExactJson([
        'success' => false,
        'errors' => 'Datuak faltatzen dira.'
    ]);
});

// Put ongi
test('Put EquipmentCategory erantzun egokia bueltatzen du', function () {
    $category = EquipmentCategory::factory()->create();

    $updated = [
        'name' => 'Imaging'
    ];

    $response = $this->putJson("api/equipment-categories/{$category->id}", $updated);
    $response->assertStatus(200);
    $response->assertExactJson([
        'success' => true,
        'message' => 'Ekipamendu Kategoria eguneratu da'
    ]);

    $categoryAldatuta = $this->getJson("api/equipment-categories/{$category->id}");
    $categoryAldatuta->assertJson([
        'success' => true,
        'data' => $updated
    ]);
});

// Put txarto datuak falta
test('Put EquipmentCategory erantzun okerra bueltatzen du, datuak faltatzen dira', function () {
    $category = EquipmentCategory::factory()->create();

    $response = $this->putJson("api/equipment-categories/{$category->id}", []);
    $response->assertStatus(422);
    $response->assertExactJson([
        'success' => false,
        'errors' => 'Datuak faltatzen dira.'
    ]);
});

// Put txarto existitzen ez den id-a
test('Put EquipmentCategory erantzun okerra bueltatzen du, id-a ez da existitzen', function () {
    $response = $this->putJson("api/equipment-categories/99999", [
        'name' => 'Surgery'
    ]);
    $response->assertStatus(404);
    $response->assertExactJson([
        'success' => false,
        'errors' => 'Ekipamendu Kategorien id-a ez da aurkitu'
    ]);
});

// Delete ongi
test('Delete EquipmentCategory erantzun egokia bueltatzen du', function () {
    $category = EquipmentCategory::factory()->create();

    $response = $this->deleteJson("api/equipment-categories/{$category->id}");
    $response->assertStatus(200);
    $response->assertExactJson([
        'success' => true,
        'data' => 'Ekipamendu Kategoria ezabatuta'
    ]);
});

// Delete txarto
test('Delete EquipmentCategory existitzen ez duena edo soft-delete eginda dago', function () {
    $category = EquipmentCategory::factory()->create();
    $this->deleteJson("api/equipment-categories/{$category->id}");

    $response = $this->deleteJson("api/equipment-categories/{$category->id}");
    $response->assertStatus(404);
    $response->assertExactJson([
        'success' => false,
        'errors' => 'Ekipamendu Kategorien id-a ez da aurkitu'
    ]);
});
