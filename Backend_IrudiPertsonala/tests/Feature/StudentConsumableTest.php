<?php

use App\Models\StudentConsumable;
use App\Models\Student;
use App\Models\Consumable;

use function Pest\Laravel\postJson;

// Get All
test('Get all StudentConsumables erantzun egokia bueltatzen du', function () {
    $estructura = [
        'success',
        'data' => [
            '*' => ['id', 'student_id', 'consumable_id', 'date', 'quantity', 'created_at', 'updated_at', 'deleted_at']
        ]
    ];

    $student = Student::factory()->create();
    $consumable = Consumable::factory()->create();

    StudentConsumable::factory()->count(3)->create([
        'student_id' => $student->id,
        'consumable_id' => $consumable->id,
    ]);

    $response = $this->getJson('api/student-consumables');
    $response->assertStatus(200);
    $response->assertJson(['success' => true]);
    $response->assertJsonCount(3, 'data');
    $response->assertJsonStructure($estructura);
});

// Get All soft-deleted
test('Get all StudentConsumables soft-delete egindakoak erantzun egokia bueltatzen du', function () {
    $estructura = [
        'success',
        'data' => [
            '*' => ['id', 'student_id', 'consumable_id', 'date', 'quantity', 'created_at', 'updated_at', 'deleted_at']
        ]
    ];

    $student = Student::factory()->create();
    $consumable = Consumable::factory()->create();

    $entries = StudentConsumable::factory()->count(3)->create([
        'student_id' => $student->id,
        'consumable_id' => $consumable->id,
    ]);

    $entries->each->delete();

    $response = $this->getJson('api/student-consumables-deleted');
    $response->assertStatus(200);
    $response->assertJson(['success' => true]);
    $response->assertJsonCount(3, 'data');
    $response->assertJsonStructure($estructura);
});

// Get one ongi
test('Get one StudentConsumable erantzun egokia bueltatzen du', function () {
    $estructura = [
        'success',
        'data' => ['id', 'student_id', 'consumable_id', 'date', 'quantity', 'created_at', 'updated_at', 'deleted_at']
    ];

    $student = Student::factory()->create();
    $consumable = Consumable::factory()->create();

    $entry = StudentConsumable::factory()->create([
        'student_id' => $student->id,
        'consumable_id' => $consumable->id,
    ]);

    $response = $this->getJson("api/student-consumables/{$entry->id}");
    $response->assertStatus(200);
    $response->assertJson(['success' => true]);
    $response->assertJsonStructure($estructura);
    $response->assertJsonPath('data.id', $entry->id);
});

// Get one existitzen ez duena
test('Get one StudentConsumable existitzen ez duena', function () {
    $response = $this->getJson('api/student-consumables/99999');
    $response->assertStatus(404);
    $response->assertExactJson([
        'success' => false,
        'errors' => 'StudentConsumable id-a ez da aurkitu'
    ]);
});

// Get one soft delete
test('Get one StudentConsumable soft delete eginda dagoena', function () {
    $estructura = [
        'success',
        'data' => ['id', 'student_id', 'consumable_id', 'date', 'quantity', 'created_at', 'updated_at', 'deleted_at']
    ];

    $student = Student::factory()->create();
    $consumable = Consumable::factory()->create();

    $entry = StudentConsumable::factory()->create([
        'student_id' => $student->id,
        'consumable_id' => $consumable->id,
    ]);

    $entry->delete();

    $response = $this->getJson("api/student-consumables-deleted/{$entry->id}");
    $response->assertStatus(200);
    $response->assertJson(['success' => true]);
    $response->assertJsonStructure($estructura);
});

// Post ongi
test('Post StudentConsumable erantzun egokia bueltatzen du', function () {
    $student = Student::factory()->create();
    $consumable = Consumable::factory()->create();

    $response = postJson('api/student-consumables', [
        'student_id' => $student->id,
        'consumable_id' => $consumable->id,
        'date' => now()->format('Y-m-d'),
        'quantity' => 5
    ]);

    $response->assertStatus(201);
    $response->assertExactJson([
        'success' => true,
        'message' => 'Mugimendua sortu egin da'
    ]);
});

// Post txarto (datu falta)
test('Post StudentConsumable erantzun okerra bueltatzen du, datuak faltatzen dira', function () {
    $response = postJson('api/student-consumables', [
        'student_id' => 1
    ]);

    $response->assertStatus(422);
    $response->assertExactJson([
        'success' => false,
        'errors' => 'Datuak faltatzen dira.'
    ]);
});

// Put ongi
test('Put StudentConsumable erantzun egokia bueltatzen du', function () {
    $student = Student::factory()->create();
    $consumable = Consumable::factory()->create();

    $entry = StudentConsumable::factory()->create([
        'student_id' => $student->id,
        'consumable_id' => $consumable->id,
    ]);

    $updated = [
        'student_id' => $student->id,
        'consumable_id' => $consumable->id,
        'date' => now()->addDay()->format('Y-m-d'),
        'quantity' => 10
    ];

    $response = $this->putJson("api/student-consumables/{$entry->id}", $updated);
    $response->assertStatus(200);
    $response->assertExactJson([
        'success' => true,
        'message' => 'StudentConsumable eguneratu da'
    ]);

    $entryAldatuta = $this->getJson("api/student-consumables/{$entry->id}");
    $entryAldatuta->assertJson([
        'success' => true,
        'data' => $updated
    ]);
});

// Put txarto (datu falta)
test('Put StudentConsumable erantzun okerra bueltatzen du, datuak faltatzen dira', function () {
    $student = Student::factory()->create();
    $consumable = Consumable::factory()->create();

    $entry = StudentConsumable::factory()->create([
        'student_id' => $student->id,
        'consumable_id' => $consumable->id,
    ]);

    $response = $this->putJson("api/student-consumables/{$entry->id}", [
        'student_id' => $student->id
    ]);

    $response->assertStatus(422);
    $response->assertExactJson([
        'success' => false,
        'errors' => 'Datuak faltatzen dira.'
    ]);
});

// Put txarto (id ez da existitzen)
test('Put StudentConsumable erantzun okerra bueltatzen du, id-a ez da existitzen', function () {
    $student = Student::factory()->create();
    $consumable = Consumable::factory()->create();

    $response = $this->putJson('api/student-consumables/99999', [
        'student_id' => $student->id,
        'consumable_id' => $consumable->id,
        'date' => now()->format('Y-m-d'),
        'quantity' => 5
    ]);

    $response->assertStatus(404);
    $response->assertExactJson([
        'success' => false,
        'errors' => 'StudentConsumable id-a ez da aurkitu'
    ]);
});

// Delete ongi
test('Delete StudentConsumable erantzun egokia bueltatzen du', function () {
    $student = Student::factory()->create();
    $consumable = Consumable::factory()->create();

    $entry = StudentConsumable::factory()->create([
        'student_id' => $student->id,
        'consumable_id' => $consumable->id,
    ]);

    $response = $this->deleteJson("api/student-consumables/{$entry->id}");
    $response->assertStatus(200);
    $response->assertExactJson([
        'success' => true,
        'message' => 'StudentConsumable ezabatuta'
    ]);
});

// Delete txarto
test('Delete StudentConsumable existitzen ez duena edo soft-delete eginda dago', function () {
    $student = Student::factory()->create();
    $consumable = Consumable::factory()->create();

    $entry = StudentConsumable::factory()->create([
        'student_id' => $student->id,
        'consumable_id' => $consumable->id,
    ]);

    $this->deleteJson("api/student-consumables/{$entry->id}");

    $response = $this->deleteJson("api/student-consumables/{$entry->id}");
    $response->assertStatus(404);
    $response->assertExactJson([
        'success' => false,
        'errors' => 'StudentConsumable id-a ez da aurkitu'
    ]);
});
