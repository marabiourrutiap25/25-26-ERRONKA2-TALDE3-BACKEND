<?php

use App\Models\Group;

use function Pest\Laravel\postJson;

// Get All
test('Get all Groups erantzun egokia bueltatzen du', function () {
    $estructura = [
        'success',
        'data' => [
            '*' => ['id', 'name', 'created_at', 'updated_at', 'deleted_at']
        ]
    ];

    Group::factory()->count(3)->create();

    $response = $this->getJson('api/groups');
    $response->assertStatus(200);
    $response->assertJson([
        'success' => true
    ]);
    $response->assertJsonCount(3, 'data');
    $response->assertJsonStructure($estructura);
});

// Get All soft-deleted
test('Get all Groups soft-delete egindakoak erantzun egokia bueltatzen du', function () {
    $estructura = [
        'success',
        'data' => [
            '*' => ['id', 'name', 'created_at', 'updated_at', 'deleted_at']
        ]
    ];

    $groups = Group::factory()->count(3)->create();
    $groups->each->delete();

    $response = $this->getJson('api/groups-deleted');
    $response->assertStatus(200);
    $response->assertJson([
        'success' => true
    ]);
    $response->assertJsonCount(3, 'data');
    $response->assertJsonStructure($estructura);
});

// Get one ongi
test('Get one Group erantzun egokia bueltatzen du', function () {
    $estructura = [
        'success',
        'data' => ['id', 'name', 'created_at', 'updated_at', 'deleted_at']
    ];

    $group = Group::factory()->create();

    $response = $this->getJson("api/groups/{$group->id}");
    $response->assertStatus(200);
    $response->assertJson([
        'success' => true
    ]);
    $response->assertJsonStructure($estructura);
    $response->assertJsonPath('data.id', $group->id);
});

// Get one existitzen ez duena
test('Get one Group existitzen ez duena', function () {
    $response = $this->getJson('api/groups/99999');
    $response->assertStatus(404);
    $response->assertExactJson([
        'success' => false,
        'errors' => 'Taldearen id-a ez da aurkitu'
    ]);
});

// Get one soft delete
test('Get one Group soft delete eginda dagoena', function () {
    $group = Group::factory()->create();
    $group->delete();

    $estructura = [
        'success',
        'data' => ['id', 'name', 'created_at', 'updated_at', 'deleted_at']
    ];

    $response = $this->getJson("api/groups-deleted/{$group->id}");
    $response->assertStatus(200);
    $response->assertJson([
        'success' => true
    ]);
    $response->assertJsonStructure($estructura);
});

// Post ongi
test('Post Group erantzun egokia bueltatzen du', function () {
    $response = postJson('api/groups', [
        'name' => 'Grupo A'
    ]);

    $response->assertStatus(201);
    $response->assertExactJson([
        'success' => true,
        'message' => 'Taldea sortu egin da'
    ]);
});

// Post txarto
test('Post Group erantzun okerra bueltatzen du, datu falta', function () {
    $response = postJson('api/groups', []);

    $response->assertStatus(422);
    $response->assertExactJson([
        'success' => false,
        'errors' => 'Datuak faltatzen dira.'
    ]);
});

// Put ongi
test('Put Group erantzun egokia bueltatzen du', function () {
    $group = Group::factory()->create();

    $updated = ['name' => 'Grupo B'];

    $response = $this->putJson("api/groups/{$group->id}", $updated);
    $response->assertStatus(200);
    $response->assertExactJson([
        'success' => true,
        'message' => 'Taldea eguneratu da'
    ]);

    $groupAldatuta = $this->getJson("api/groups/{$group->id}");
    $groupAldatuta->assertJson([
        'success' => true,
        'data' => $updated
    ]);
});

// Put txarto datuak falta
test('Put Group erantzun okerra bueltatzen du, datuak faltatzen dira', function () {
    $group = Group::factory()->create();

    $response = $this->putJson("api/groups/{$group->id}", []);
    $response->assertStatus(422);
    $response->assertExactJson([
        'success' => false,
        'errors' => 'Datuak faltatzen dira.'
    ]);
});

// Put txarto existitzen ez den id-a
test('Put Group erantzun okerra bueltatzen du, id-a ez da existitzen', function () {
    $response = $this->putJson("api/groups/99999", ['name' => 'Grupo X']);
    $response->assertStatus(404);
    $response->assertExactJson([
        'success' => false,
        'errors' => 'Taldearen id-a ez da aurkitu'
    ]);
});

// Delete ongi
test('Delete Group erantzun egokia bueltatzen du', function () {
    $group = Group::factory()->create();

    $response = $this->deleteJson("api/groups/{$group->id}");
    $response->assertStatus(200);
    $response->assertExactJson([
        'success' => true,
        'message' => 'Taldea ezabatuta'
    ]);
});

// Delete txarto
test('Delete Group existitzen ez duena edo soft-delete eginda dago', function () {
    $group = Group::factory()->create();
    $this->deleteJson("api/groups/{$group->id}");

    $response = $this->deleteJson("api/groups/{$group->id}");
    $response->assertStatus(404);
    $response->assertExactJson([
        'success' => false,
        'errors' => 'Taldearen id-a ez da aurkitu'
    ]);
});
