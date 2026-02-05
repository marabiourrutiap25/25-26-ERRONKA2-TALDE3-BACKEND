<?php

use App\Models\Student;
use App\Models\Group;

use function Pest\Laravel\postJson;

// Get All
test('Get all Students erantzun egokia bueltatzen du', function () {
    $estructura = [
        'success',
        'data' => [
            '*' => ['id', 'name', 'surnames', 'group_id', 'created_at', 'updated_at', 'deleted_at']
        ]
    ];

    $group = Group::factory()->create();

    Student::factory()->count(3)->create([
        'group_id' => $group->id
    ]);

    $response = $this->getJson('api/students');
    $response->assertStatus(200);
    $response->assertJson([
        'success' => true,
    ]);
    $response->assertJsonCount(3, 'data');
    $response->assertJsonStructure($estructura);
});

// Get one ongi
test('Get one Student erantzun egokia bueltatzen du', function () {
    $estructura = [
        'success',
        'data' => ['id', 'name', 'surnames', 'group_id', 'created_at', 'updated_at', 'deleted_at']
    ];

    $group = Group::factory()->create();
    $student = Student::factory()->create([
        'group_id' => $group->id
    ]);

    $response = $this->getJson("api/students/{$student->id}");
    $response->assertStatus(200);
    $response->assertJson([
        'success' => true,
    ]);
    $response->assertJsonStructure($estructura);
    $response->assertJsonPath('data.id', $student->id);
});

// Get one existitzen ez duena
test('Get one Student existitzen ez duena', function () {
    $response = $this->getJson('api/students/99999');
    $response->assertStatus(404);
    $response->assertExactJson([
        'success' => false,
        'errors' => 'Ikaslearen id-a ez da aurkitu'
    ]);
});

// Post ongi
test('Post Student erantzun egokia bueltatzen du', function () {
    $group = Group::factory()->create();

    $response = postJson('api/students', [
        'name' => 'Jon',
        'surnames' => 'Doe',
        'group_id' => $group->id
    ]);

    $response->assertStatus(201);
    $response->assertExactJson([
        'success' => true,
        'message' => 'Ikaslea sortu egin da'
    ]);
});

// Post txarto
test('Post Student erantzun okerra bueltatzen du, datu falta', function () {
    $response = postJson('api/students', [
        'name' => 'Jon'
    ]);

    $response->assertStatus(422);
    $response->assertExactJson([
        'success' => false,
        'errors' => 'Datuak faltatzen dira.'
    ]);
});

// Put ongi
test('Put Student erantzun egokia bueltatzen du', function () {
    $group = Group::factory()->create();
    $student = Student::factory()->create([
        'group_id' => $group->id
    ]);

    $updated = [
        'name' => 'Ane',
        'surnames' => 'Doe',
        'group_id' => $group->id
    ];

    $response = $this->putJson("api/students/{$student->id}", $updated);
    $response->assertStatus(200);
    $response->assertExactJson([
        'success' => true,
        'message' => 'Ikaslea eguneratu da'
    ]);

    $studentAldatuta = $this->getJson("api/students/{$student->id}");
    $studentAldatuta->assertJson([
        'success' => true,
        'data' => $updated
    ]);
});

// Put txarto datuak falta
test('Put Student erantzun okerra bueltatzen du, datuak faltatzen dira', function () {
    $group = Group::factory()->create();
    $student = Student::factory()->create([
        'group_id' => $group->id
    ]);

    $response = $this->putJson("api/students/{$student->id}", [
        'name' => 'Ane'
    ]);

    $response->assertStatus(422);
    $response->assertExactJson([
        'success' => false,
        'errors' => 'Datuak faltatzen dira.'
    ]);
});

// Put txarto existitzen ez den id-a
test('Put Student erantzun okerra bueltatzen du, id-a ez da existitzen', function () {
    $group = Group::factory()->create();

    $response = $this->putJson("api/students/99999", [
        'name' => 'Ane',
        'surnames' => 'Doe',
        'group_id' => $group->id
    ]);

    $response->assertStatus(404);
    $response->assertExactJson([
        'success' => false,
        'errors' => 'Ikaslearen id-a ez da aurkitu'
    ]);
});

// Delete ongi
test('Delete Student erantzun egokia bueltatzen du', function () {
    $group = Group::factory()->create();
    $student = Student::factory()->create([
        'group_id' => $group->id
    ]);

    $response = $this->deleteJson("api/students/{$student->id}");
    $response->assertStatus(200);
    $response->assertExactJson([
        'success' => true,
        'message' => 'Ikaslea ezabatuta'
    ]);
});

// Delete txarto
test('Delete Student existitzen ez duena', function () {
    $response = $this->deleteJson("api/students/99999");
    $response->assertStatus(404);
    $response->assertExactJson([
        'success' => false,
        'errors' => 'Ikaslearen id-a ez da aurkitu'
    ]);
});
