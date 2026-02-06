<?php

use App\Models\ConsumableCategory;

use function Pest\Laravel\postJson;

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

// Get All soft-deleted
test('Get all ConsumableCategories soft-delete egindakoak erantzun egokia bueltatzen du', function () {
    $estructura = [
        'success',
        'data' => [
            '*' => ['id', 'name', 'created_at', 'updated_at', 'deleted_at']
        ]
    ];

    $categories = ConsumableCategory::factory()->count(3)->create();
    $categories->each->delete();

    $response = $this->getJson('api/consumable-categories-deleted');
    $response->assertStatus(200);
    $response->assertJson([
        'success' => true,
    ]);
    $response->assertJsonCount(3, 'data');
    $response->assertJsonStructure($estructura);
});

// Get one ongi
test('Get one ConsumableCategory erantzun egokia bueltatzen du', function () {
    $estructura = [
        'success',
        'data' => ['id', 'name', 'created_at', 'updated_at', 'deleted_at']
    ];

    $category = ConsumableCategory::factory()->create();

    $response = $this->getJson("api/consumable-categories/{$category->id}");
    $response->assertStatus(200);
    $response->assertJson([
        'success' => true,
    ]);
    $response->assertJsonStructure($estructura);
    $response->assertJsonPath('data.id', $category->id);
});

// Get one existitzen ez duena
test('Get one ConsumableCategory existitzen ez duena', function () {
    $response = $this->getJson('api/consumable-categories/99999');
    $response->assertStatus(404);
    $response->assertExactJson([
        "success" => false,
        "errors" => "Kategoriaren id-a ez da aurkitu"
    ]);
});

// Get one soft delete
test('Get one ConsumableCategory soft delete eginda dagoena', function () {
    $estructura = [
        'success',
        'data' => ['id', 'name', 'created_at', 'updated_at', 'deleted_at']
    ];

    $category = ConsumableCategory::factory()->create();
    $category->delete();

    $response = $this->getJson("api/consumable-categories-deleted/{$category->id}");
    $response->assertStatus(200);
    $response->assertJson([
        'success' => true,
    ]);
    $response->assertJsonStructure($estructura);
});

// Post ongi
test('Post ConsumableCategory erantzun egokia bueltatzen du', function () {
    $response = postJson('api/consumable-categories', [
        "name" => "Gauzes"
    ]);

    $response->assertStatus(201);
    $response->assertExactJson([
        "success" => true,
        "message" => "Kategoria sortu egin da"
    ]);
});

// Post txarto
test('Post ConsumableCategory erantzun okerra bueltatzen du, datu falta', function () {
    $response = postJson('api/consumable-categories', []);

    $response->assertStatus(422);
    $response->assertExactJson([
        "success" => false,
        "errors" => "Datuak faltatzen dira."
    ]);
});

// Put ongi
test('Put ConsumableCategory erantzun egokia bueltatzen du', function () {
    $category = ConsumableCategory::factory()->create();

    $updated = [
        "name" => "Bandages"
    ];

    $response = $this->putJson("api/consumable-categories/{$category->id}", $updated);
    $response->assertStatus(200);
    $response->assertExactJson([
        'success' => true,
        'message' => 'Kategoria eguneratu da',
    ]);

    $categoryAldatuta = $this->getJson("api/consumable-categories/{$category->id}");
    $categoryAldatuta->assertJson([
        'success' => true,
        'data' => $updated
    ]);
});

// Put txarto datuak falta
test('Put ConsumableCategory erantzun okerra bueltatzen du, datuak faltatzen dira', function () {
    $category = ConsumableCategory::factory()->create();

    $response = $this->putJson("api/consumable-categories/{$category->id}", []);
    $response->assertStatus(422);
    $response->assertExactJson([
        'success' => false,
        'errors' => 'Datuak faltatzen dira.',
    ]);
});

// Put txarto existitzen ez den id-a
test('Put ConsumableCategory erantzun okerra bueltatzen du, id-a ez da existitzen', function () {
    $response = $this->putJson("api/consumable-categories/99999", [
        "name" => "Bandages"
    ]);

    $response->assertStatus(404);
    $response->assertExactJson([
        'success' => false,
        'errors' => 'Kategoriaren id-a ez da aurkitu'
    ]);
});

// Delete ongi
test('Delete ConsumableCategory erantzun egokia bueltatzen du', function () {
    $category = ConsumableCategory::factory()->create();

    $response = $this->deleteJson("api/consumable-categories/{$category->id}");
    $response->assertStatus(200);
    $response->assertExactJson([
        'success' => true,
        'message' => 'Kategoria ezabatuta'
    ]);
});

// Delete txarto
test('Delete ConsumableCategory existitzen ez duena edo soft-delete eginda dago', function () {
    $category = ConsumableCategory::factory()->create();
    $this->deleteJson("api/consumable-categories/{$category->id}");

    $response = $this->deleteJson("api/consumable-categories/{$category->id}");
    $response->assertStatus(404);
    $response->assertExactJson([
        "success" => false,
        "errors" => "Kategoriaren id-a ez da aurkitu"
    ]);
});
