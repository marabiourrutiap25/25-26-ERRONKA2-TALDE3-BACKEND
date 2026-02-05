<?php

use App\Models\Client;

use function Pest\Laravel\postJson;

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

// Get All soft-deleted
test('Get all Clients soft-delete egindakoak erantzun egokia bueltatzen du', function () {
    $estructura = [
        'success',
        'data' => [
            '*' => ['id', 'name', 'surnames', 'telephone', 'email', 'home_client', 'created_at', 'updated_at', 'deleted_at']
        ]
    ];

    $clients = Client::factory()->count(3)->create();
    $clients->each->delete();

    $response = $this->getJson('api/clients-deleted');
    $response->assertStatus(200);
    $response->assertJson([
        'success' => true,
    ]);
    $response->assertJsonCount(3, 'data');
    $response->assertJsonStructure($estructura);
});

// Get one ongi
test('Get one Client erantzun egokia bueltatzen du', function () {
    $estructura = [
        'success',
        'data' => ['id', 'name', 'surnames', 'telephone', 'email', 'home_client', 'created_at', 'updated_at', 'deleted_at']
    ];

    $client = Client::factory()->create();

    $response = $this->getJson("api/clients/{$client->id}");
    $response->assertStatus(200);
    $response->assertJson([
        'success' => true,
    ]);
    $response->assertJsonStructure($estructura);
    $response->assertJsonPath('data.id', $client->id);
});

// Get one existitzen ez duena
test('Get one Client existitzen ez duena', function () {
    $response = $this->getJson('api/clients/99999');
    $response->assertStatus(404);
    $response->assertExactJson([
        "success" => false,
        "errors" => "Bezero id-a ez da aurkitu"
    ]);
});

// Get one soft delete
test('Get one Client soft delete eginda dagoena', function () {
    $estructura = [
        'success',
        'data' => ['id', 'name', 'surnames', 'telephone', 'email', 'home_client', 'created_at', 'updated_at', 'deleted_at']
    ];

    $client = Client::factory()->create();
    $client->delete();

    $response = $this->getJson("api/clients-deleted/{$client->id}");
    $response->assertStatus(200);
    $response->assertJson([
        'success' => true,
    ]);
    $response->assertJsonStructure($estructura);
});

// Post ongi
test('Post Client erantzun egokia bueltatzen du', function () {
    $response = postJson('api/clients', [
        "name" => "Jon",
        "surnames" => "Doe",
        "telephone" => "600123123",
        "email" => "jon@doe.com",
        "home_client" => true
    ]);

    $response->assertStatus(201);
    $response->assertExactJson([
        "success" => true,
        "message" => "Bezeroa sortu egin da"
    ]);
});

// Post txarto
test('Post Client erantzun okerra bueltatzen du, datu falta', function () {
    $response = postJson('api/clients', [
        "name" => "Jon"
    ]);

    $response->assertStatus(422);
    $response->assertExactJson([
        "success" => false,
        "errors" => "Datuak faltatzen dira."
    ]);
});

// Put ongi
test('Put Client erantzun egokia bueltatzen du', function () {
    $client = Client::factory()->create();

    $clientUpdated = [
        "name" => "Ane",
        "surnames" => "Doe",
        "telephone" => "611111111",
        "email" => "ane@doe.com",
        "home_client" => false
    ];

    $response = $this->putJson("api/clients/{$client->id}", $clientUpdated);

    $response->assertStatus(200);
    $response->assertExactJson([
        'success' => true,
        'message' => 'Bezeroa eguneratu da',
    ]);

    $clientAldatuta = $this->getJson("api/clients/{$client->id}");
    $clientAldatuta->assertJson([
        'success' => true,
        'data' => $clientUpdated
    ]);
});

// Put txarto datuak falta
test('Put Client erantzun okerra bueltatzen du, datuak faltatzen dira', function () {
    $client = Client::factory()->create();

    $response = $this->putJson("api/clients/{$client->id}", [
        "name" => "Ane"
    ]);

    $response->assertStatus(422);
    $response->assertExactJson([
        'success' => false,
        'errors' => 'Datuak faltatzen dira.',
    ]);
});

// Put txarto existitzen ez den id-a
test('Put Client erantzun okerra bueltatzen du, id-a ez da existitzen', function () {
    $response = $this->putJson("api/clients/99999", [
        "name" => "Ane",
        "surnames" => "Doe",
        "telephone" => "611111111",
        "email" => "ane@doe.com",
        "home_client" => false
    ]);

    $response->assertStatus(404);
    $response->assertExactJson([
        'success' => false,
        'errors' => 'Bezeroaren id-a ez da aurkitu'
    ]);
});

// Delete ongi
test('Delete Client erantzun egokia bueltatzen du', function () {
    $client = Client::factory()->create();

    $response = $this->deleteJson("api/clients/{$client->id}");
    $response->assertStatus(200);
    $response->assertExactJson([
        'success' => true,
        'message' => 'Bezeroa ezabatuta'
    ]);
});

// Delete txarto
test('Delete Client existitzen ez duena edo soft-delete eginda dago', function () {
    $client = Client::factory()->create();
    $this->deleteJson("api/clients/{$client->id}");

    $response = $this->deleteJson("api/clients/{$client->id}");
    $response->assertStatus(404);
    $response->assertExactJson([
        "success" => false,
        "errors" => "Bezeroaren id-a ez da aurkitu"
    ]);
});
