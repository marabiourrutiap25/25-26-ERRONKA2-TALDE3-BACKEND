<?php

use App\Models\ServiceCategory;

use function Pest\Laravel\postJson;

// Get All
test('Get all ServiceCategories erantzun egokia bueltatzen du', function () {
    $estructura = [
        'success',
        'data' => [
            '*' => ['id', 'name', 'created_at', 'updated_at', 'deleted_at']
        ]
    ];

    ServiceCategory::factory()->count(3)->create();

    $response = $this->getJson('api/service-categories');
    $response->assertStatus(200);
    $response->assertJson([
        'success' => true,
    ]);
    $response->assertJsonCount(3, 'data');
    $response->assertJsonStructure($estructura);
});

// Get All soft-deleted
test('Get all ServiceCategories soft-delete egindakoak erantzun egokia bueltatzen du', function () {
    $estructura = [
        'success',
        'data' => [
            '*' => ['id', 'name', 'created_at', 'updated_at', 'deleted_at']
        ]
    ];

    $categories = ServiceCategory::factory()->count(3)->create();
    $categories->each->delete();

    $response = $this->getJson('api/service-categories-deleted');
    $response->assertStatus(200);
    $response->assertJson([
        'success' => true,
    ]);
    $response->assertJsonCount(3, 'data');
    $response->assertJsonStructure($estructura);
});

// Get one ongi
test('Get one ServiceCategory erantzun egokia bueltatzen du', function () {
    $estructura = [
        'success',
        'data' => ['id', 'name', 'created_at', 'updated_at', 'deleted_at']
    ];

    $category = ServiceCategory::factory()->create();

    $response = $this->getJson("api/service-categories/{$category->id}");
    $response->assertStatus(200);
    $response->assertJson([
        'success' => true,
    ]);
    $response->assertJsonStructure($estructura);
    $response->assertJsonPath('data.id', $category->id);
});

// Get one existitzen ez duena
test('Get one ServiceCategory existitzen ez duena', function () {
    $response = $this->getJson('api/service-categories/99999');
    $response->assertStatus(404);
    $response->assertExactJson([
        'success' => false,
        'message' => 'Zerbitzu Kategorien id-a ez da aurkitu'
    ]);
});

// Get one soft delete
test('Get one ServiceCategory soft delete eginda dagoena', function () {
    $estructura = [
        'success',
        'data' => ['id', 'name', 'created_at', 'updated_at', 'deleted_at']
    ];

    $category = ServiceCategory::factory()->create();
    $category->delete();

    $response = $this->getJson("api/service-categories-deleted/{$category->id}");
    $response->assertStatus(200);
    $response->assertJson([
        'success' => true,
    ]);
    $response->assertJsonStructure($estructura);
});

// Post ongi
test('Post ServiceCategory erantzun egokia bueltatzen du', function () {
    $response = postJson('api/service-categories', [
        'name' => 'Consultation'
    ]);

    $response->assertStatus(201);
    $response->assertExactJson([
        'success' => true,
        'message' => 'Zerbitzu Kategoria sortu egin da'
    ]);
});

// Post txarto
test('Post ServiceCategory erantzun okerra bueltatzen du, datu falta', function () {
    $response = postJson('api/service-categories', []);

    $response->assertStatus(422);
    $response->assertExactJson([
        'success' => false,
        'errors' => 'Datuak faltatzen dira.'
    ]);
});

// Put ongi
test('Put ServiceCategory erantzun egokia bueltatzen du', function () {
    $category = ServiceCategory::factory()->create();

    $updated = [
        'name' => 'Therapy'
    ];

    $response = $this->putJson("api/service-categories/{$category->id}", $updated);
    $response->assertStatus(200);
    $response->assertExactJson([
        'success' => true,
        'message' => 'Zerbitzu Kategoria eguneratu da'
    ]);

    $categoryAldatuta = $this->getJson("api/service-categories/{$category->id}");
    $categoryAldatuta->assertJson([
        'success' => true,
        'data' => $updated
    ]);
});

// Put txarto datuak falta
test('Put ServiceCategory erantzun okerra bueltatzen du, datuak faltatzen dira', function () {
    $category = ServiceCategory::factory()->create();

    $response = $this->putJson("api/service-categories/{$category->id}", []);
    $response->assertStatus(422);
    $response->assertExactJson([
        'success' => false,
        'errors' => 'Datuak faltatzen dira.'
    ]);
});

// Put txarto existitzen ez den id-a
test('Put ServiceCategory erantzun okerra bueltatzen du, id-a ez da existitzen', function () {
    $response = $this->putJson("api/service-categories/99999", [
        'name' => 'Therapy'
    ]);
    $response->assertStatus(404);
    $response->assertExactJson([
        'success' => false,
        'message' => 'Zerbitzu Kategorien id-a ez da aurkitu'
    ]);
});

// Delete ongi
test('Delete ServiceCategory erantzun egokia bueltatzen du', function () {
    $category = ServiceCategory::factory()->create();

    $response = $this->deleteJson("api/service-categories/{$category->id}");
    $response->assertStatus(200);
    $response->assertExactJson([
        'success' => true,
        'data' => 'Zerbitzu Kategoria ezabatuta'
    ]);
});

// Delete txarto
test('Delete ServiceCategory existitzen ez duena edo soft-delete eginda dago', function () {
    $category = ServiceCategory::factory()->create();
    $this->deleteJson("api/service-categories/{$category->id}");

    $response = $this->deleteJson("api/service-categories/{$category->id}");
    $response->assertStatus(404);
    $response->assertExactJson([
        'success' => false,
        'data' => 'Zerbitzu Kategorien id-a ez da aurkitu'
    ]);
});
