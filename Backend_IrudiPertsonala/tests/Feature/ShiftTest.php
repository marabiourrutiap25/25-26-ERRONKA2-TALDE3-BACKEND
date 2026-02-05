<?php

use App\Models\Shift;
use App\Models\Student;

use function Pest\Laravel\postJson;

// Get All
test('Get all Shifts erantzun egokia bueltatzen du', function () {
    $estructura = [
        'success',
        'data' => [
            '*' => ['id', 'type', 'data', 'student_id', 'created_at', 'updated_at', 'deleted_at']
        ]
    ];

    $student = Student::factory()->create();

    Shift::factory()->count(3)->create([
        'student_id' => $student->id
    ]);

    $response = $this->getJson('api/shifts');
    $response->assertStatus(200);
    $response->assertJson([
        'success' => true,
    ]);
    $response->assertJsonCount(3, 'data');
    $response->assertJsonStructure($estructura);
});

// Get All soft-deleted
test('Get all Shifts soft-delete egindakoak erantzun egokia bueltatzen du', function () {
    $estructura = [
        'success',
        'data' => [
            '*' => ['id', 'type', 'data', 'student_id', 'created_at', 'updated_at', 'deleted_at']
        ]
    ];

    $student = Student::factory()->create();
    $shifts = Shift::factory()->count(3)->create([
        'student_id' => $student->id
    ]);
    $shifts->each->delete();

    $response = $this->getJson('api/shifts-deleted');
    $response->assertStatus(200);
    $response->assertJson([
        'success' => true,
    ]);
    $response->assertJsonCount(3, 'data');
    $response->assertJsonStructure($estructura);
});

// Get one ongi
test('Get one Shift erantzun egokia bueltatzen du', function () {
    $estructura = [
        'success',
        'data' => ['id', 'type', 'data', 'student_id', 'created_at', 'updated_at', 'deleted_at']
    ];

    $student = Student::factory()->create();
    $shift = Shift::factory()->create([
        'student_id' => $student->id
    ]);

    $response = $this->getJson("api/shifts/{$shift->id}");
    $response->assertStatus(200);
    $response->assertJson([
        'success' => true,
    ]);
    $response->assertJsonStructure($estructura);
    $response->assertJsonPath('data.id', $shift->id);
});

// Get one existitzen ez duena
test('Get one Shift existitzen ez duena', function () {
    $response = $this->getJson('api/shifts/99999');
    $response->assertStatus(404);
    $response->assertExactJson([
        'success' => false,
        'errors' => 'Txandaren id-a ez da aurkitu'
    ]);
});

// Get one soft delete
test('Get one Shift soft delete eginda dagoena', function () {
    $estructura = [
        'success',
        'data' => ['id', 'type', 'data', 'student_id', 'created_at', 'updated_at', 'deleted_at']
    ];

    $student = Student::factory()->create();
    $shift = Shift::factory()->create([
        'student_id' => $student->id
    ]);
    $shift->delete();

    $response = $this->getJson("api/shifts-deleted/{$shift->id}");
    $response->assertStatus(200);
    $response->assertJson([
        'success' => true,
    ]);
    $response->assertJsonStructure($estructura);
});

// Post ongi
test('Post Shift erantzun egokia bueltatzen du', function () {
    $student = Student::factory()->create();

    $response = postJson('api/shifts', [
        'type' => 'A',
        'data' => '2026-02-05',
        'student_id' => $student->id
    ]);

    $response->assertStatus(201);
    $response->assertExactJson([
        'success' => true,
        'message' => 'Txanda sortu egin da'
    ]);
});

// Post txarto
test('Post Shift erantzun okerra bueltatzen du, datu falta', function () {
    $response = postJson('api/shifts', [
        'type' => 'A'
    ]);

    $response->assertStatus(422);
    $response->assertExactJson([
        'success' => false,
        'errors' => 'Datuak faltatzen dira.'
    ]);
});

// Put ongi
test('Put Shift erantzun egokia bueltatzen du', function () {
    $student = Student::factory()->create();
    $shift = Shift::factory()->create([
        'student_id' => $student->id
    ]);

    $updated = [
        'type' => 'B',
        'data' => '2026-02-10',
        'student_id' => $student->id
    ];

    $response = $this->putJson("api/shifts/{$shift->id}", $updated);
    $response->assertStatus(200);
    $response->assertExactJson([
        'success' => true,
        'message' => 'Txanda eguneratu da'
    ]);

    $shiftAldatuta = $this->getJson("api/shifts/{$shift->id}");
    $shiftAldatuta->assertJson([
        'success' => true,
        'data' => $updated
    ]);
});

// Put txarto datuak falta
test('Put Shift erantzun okerra bueltatzen du, datuak faltatzen dira', function () {
    $student = Student::factory()->create();
    $shift = Shift::factory()->create([
        'student_id' => $student->id
    ]);

    $response = $this->putJson("api/shifts/{$shift->id}", [
        'type' => 'C'
    ]);
    $response->assertStatus(422);
    $response->assertExactJson([
        'success' => false,
        'errors' => 'Datuak faltatzen dira.'
    ]);
});

// Put txarto existitzen ez den id-a
test('Put Shift erantzun okerra bueltatzen du, id-a ez da existitzen', function () {
    $student = Student::factory()->create();

    $response = $this->putJson('api/shifts/99999', [
        'type' => 'B',
        'data' => '2026-02-15',
        'student_id' => $student->id
    ]);
    $response->assertStatus(404);
    $response->assertExactJson([
        'success' => false,
        'errors' => 'Txandaren id-a ez da aurkitu'
    ]);
});

// Delete ongi
test('Delete Shift erantzun egokia bueltatzen du', function () {
    $student = Student::factory()->create();
    $shift = Shift::factory()->create([
        'student_id' => $student->id
    ]);

    $response = $this->deleteJson("api/shifts/{$shift->id}");
    $response->assertStatus(200);
    $response->assertExactJson([
        'success' => true,
        'message' => 'Txanda ezabatuta'
    ]);
});

// Delete txarto
test('Delete Shift existitzen ez duena edo soft-delete eginda dago', function () {
    $student = Student::factory()->create();
    $shift = Shift::factory()->create([
        'student_id' => $student->id
    ]);
    $this->deleteJson("api/shifts/{$shift->id}");

    $response = $this->deleteJson("api/shifts/{$shift->id}");
    $response->assertStatus(404);
    $response->assertExactJson([
        'success' => false,
        'errors' => 'Txandaren id-a ez da aurkitu'
    ]);
});
