<?php

use App\Models\Consumable;
use App\Models\ConsumableCategory;

use function Pest\Laravel\postJson;

// Get All
test('Get all Consumables erantzun egokia bueltatzen du', function () {
    $estructura = [
        'success',
        'data' => [
            '*' => [
                'id', 'name', 'description', 'batch', 'brand', 'stock',
                'min_stock', 'expiration_date', 'consumable_category_id',
                'created_at', 'updated_at', 'deleted_at'
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

// Get All soft-deleted
test('Get all Consumables soft-delete egindakoak erantzun egokia bueltatzen du', function () {
    $estructura = [
        'success',
        'data' => [
            '*' => [
                'id', 'name', 'description', 'batch', 'brand', 'stock',
                'min_stock', 'expiration_date', 'consumable_category_id',
                'created_at', 'updated_at', 'deleted_at'
            ]
        ]
    ];

    $category = ConsumableCategory::factory()->create();
    $consumables = Consumable::factory()->count(3)->create([
        'consumable_category_id' => $category->id
    ]);

    $consumables->each->delete();

    $response = $this->getJson('api/consumables-deleted');
    $response->assertStatus(200);
    $response->assertJson([
        'success' => true,
    ]);
    $response->assertJsonCount(3, 'data');
    $response->assertJsonStructure($estructura);
});

// Get one ongi
test('Get one Consumable erantzun egokia bueltatzen du', function () {
    $estructura = [
        'success',
        'data' => [
            'id', 'name', 'description', 'batch', 'brand', 'stock',
            'min_stock', 'expiration_date', 'consumable_category_id',
            'created_at', 'updated_at', 'deleted_at'
        ]
    ];

    $category = ConsumableCategory::factory()->create();
    $consumable = Consumable::factory()->create([
        'consumable_category_id' => $category->id
    ]);

    $response = $this->getJson("api/consumables/{$consumable->id}");
    $response->assertStatus(200);
    $response->assertJson([
        'success' => true,
    ]);
    $response->assertJsonStructure($estructura);
    $response->assertJsonPath('data.id', $consumable->id);
});

// Get one existitzen ez duena
test('Get one Consumable existitzen ez duena', function () {
    $response = $this->getJson('api/consumables/99999');
    $response->assertStatus(404);
    $response->assertExactJson([
        "success" => false,
        "errors" => "Konsumiblearen id-a ez da aurkitu"
    ]);
});

// Get one soft delete
test('Get one Consumable soft delete eginda dagoena', function () {
    $estructura = [
        'success',
        'data' => [
            'id', 'name', 'description', 'batch', 'brand', 'stock',
            'min_stock', 'expiration_date', 'consumable_category_id',
            'created_at', 'updated_at', 'deleted_at'
        ]
    ];

    $category = ConsumableCategory::factory()->create();
    $consumable = Consumable::factory()->create([
        'consumable_category_id' => $category->id
    ]);

    $consumable->delete();

    $response = $this->getJson("api/consumables-deleted/{$consumable->id}");
    $response->assertStatus(200);
    $response->assertJson([
        'success' => true,
    ]);
    $response->assertJsonStructure($estructura);
});

// Post ongi
test('Post Consumable erantzun egokia bueltatzen du', function () {
    $category = ConsumableCategory::factory()->create();

    $response = postJson('api/consumables', [
        "name" => "Gloves",
        "description" => "Latex gloves",
        "batch" => "B123",
        "brand" => "MedBrand",
        "stock" => 100,
        "min_stock" => 10,
        "expiration_date" => "2026-12-31",
        "consumable_category_id" => $category->id
    ]);

    $response->assertStatus(201);
    $response->assertExactJson([
        "success" => true,
        "message" => "Konsumiblea sortu egin da"
    ]);
});

// Post txarto
test('Post Consumable erantzun okerra bueltatzen du, datu falta', function () {
    $response = postJson('api/consumables', [
        "name" => "Gloves"
    ]);

    $response->assertStatus(422);
    $response->assertExactJson([
        "success" => false,
        "errors" => "Datuak faltatzen dira."
    ]);
});

// Put ongi
test('Put Consumable erantzun egokia bueltatzen du', function () {
    $category = ConsumableCategory::factory()->create();
    $consumable = Consumable::factory()->create([
        'consumable_category_id' => $category->id
    ]);

    $updated = [
        "name" => "Masks",
        "description" => "Surgical masks",
        "batch" => "M456",
        "brand" => "HealthPro",
        "stock" => 200,
        "min_stock" => 20,
        "expiration_date" => "2027-06-30",
        "consumable_category_id" => $category->id
    ];

    $response = $this->putJson("api/consumables/{$consumable->id}", $updated);
    $response->assertStatus(200);
    $response->assertExactJson([
        'success' => true,
        'message' => 'Konsumiblea eguneratu da',
    ]);

    $consumableAldatuta = $this->getJson("api/consumables/{$consumable->id}");
    $consumableAldatuta->assertJson([
        'success' => true,
        'data' => $updated
    ]);
});

// Put txarto datuak falta
test('Put Consumable erantzun okerra bueltatzen du, datuak faltatzen dira', function () {
    $category = ConsumableCategory::factory()->create();
    $consumable = Consumable::factory()->create([
        'consumable_category_id' => $category->id
    ]);

    $response = $this->putJson("api/consumables/{$consumable->id}", [
        "name" => "Masks"
    ]);

    $response->assertStatus(422);
    $response->assertExactJson([
        'success' => false,
        'errors' => 'Datuak faltatzen dira.',
    ]);
});

// Put txarto existitzen ez den id-a
test('Put Consumable erantzun okerra bueltatzen du, id-a ez da existitzen', function () {
    $category = ConsumableCategory::factory()->create();

    $response = $this->putJson("api/consumables/99999", [
        "name" => "Masks",
        "description" => "Surgical masks",
        "batch" => "M456",
        "brand" => "HealthPro",
        "stock" => 200,
        "min_stock" => 20,
        "expiration_date" => "2027-06-30",
        "consumable_category_id" => $category->id
    ]);

    $response->assertStatus(404);
    $response->assertExactJson([
        'success' => false,
        'errors' => 'Konsumiblearen id-a ez da aurkitu'
    ]);
});

// Delete ongi
test('Delete Consumable erantzun egokia bueltatzen du', function () {
    $category = ConsumableCategory::factory()->create();
    $consumable = Consumable::factory()->create([
        'consumable_category_id' => $category->id
    ]);

    $response = $this->deleteJson("api/consumables/{$consumable->id}");
    $response->assertStatus(200);
    $response->assertExactJson([
        'success' => true,
        'message' => 'Konsumiblea ezabatuta'
    ]);
});

// Delete txarto
test('Delete Consumable existitzen ez duena edo soft-delete eginda dago', function () {
    $category = ConsumableCategory::factory()->create();
    $consumable = Consumable::factory()->create([
        'consumable_category_id' => $category->id
    ]);
    $this->deleteJson("api/consumables/{$consumable->id}");

    $response = $this->deleteJson("api/consumables/{$consumable->id}");
    $response->assertStatus(404);
    $response->assertExactJson([
        "success" => false,
        "errors" => "Konsumiblearen id-a ez da aurkitu"
    ]);
});
