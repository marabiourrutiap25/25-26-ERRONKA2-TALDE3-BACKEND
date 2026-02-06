<?php

use App\Models\StudentEquipment;
use App\Models\Student;
use App\Models\Equipment;

use function Pest\Laravel\postJson;

// Get All
test('Get all StudentEquipments erantzun egokia bueltatzen du', function () {
    $estructura = [
        'success',
        'data' => [
            '*' => ['id', 'student_id', 'equipment_id', 'start_datetime', 'end_datetime', 'created_at', 'updated_at', 'deleted_at']
        ]
    ];

    $student = Student::factory()->create();
    $equipment = Equipment::factory()->create();

    StudentEquipment::factory()->count(3)->create([
        'student_id' => $student->id,
        'equipment_id' => $equipment->id,
    ]);

    $response = $this->getJson('api/student-equipment');
    $response->assertStatus(200);
    $response->assertJson([
        'success' => true,
    ]);
    $response->assertJsonCount(3, 'data');
    $response->assertJsonStructure($estructura);
});

// Get All soft-deleted
test('Get all StudentEquipments soft-delete egindakoak erantzun egokia bueltatzen du', function () {
    $estructura = [
        'success',
        'data' => [
            '*' => ['id', 'student_id', 'equipment_id', 'start_datetime', 'end_datetime', 'created_at', 'updated_at', 'deleted_at']
        ]
    ];

    $student = Student::factory()->create();
    $equipment = Equipment::factory()->create();

    $items = StudentEquipment::factory()->count(3)->create([
        'student_id' => $student->id,
        'equipment_id' => $equipment->id,
    ]);

    $items->each->delete();

    $response = $this->getJson('api/student-equipment-deleted');
    $response->assertStatus(200);
    $response->assertJson([
        'success' => true,
    ]);
    $response->assertJsonCount(3, 'data');
    $response->assertJsonStructure($estructura);
});

// Get one ongi
test('Get one StudentEquipment erantzun egokia bueltatzen du', function () {
    $estructura = [
        'success',
        'data' => ['id', 'student_id', 'equipment_id', 'start_datetime', 'end_datetime', 'created_at', 'updated_at', 'deleted_at']
    ];

    $student = Student::factory()->create();
    $equipment = Equipment::factory()->create();

    $item = StudentEquipment::factory()->create([
        'student_id' => $student->id,
        'equipment_id' => $equipment->id,
    ]);

    $response = $this->getJson("api/student-equipment/{$item->id}");
    $response->assertStatus(200);
    $response->assertJson([
        'success' => true,
    ]);
    $response->assertJsonStructure($estructura);
    $response->assertJsonPath('data.id', $item->id);
});

// Get one existitzen ez duena
test('Get one StudentEquipment existitzen ez duena', function () {
    $response = $this->getJson('api/student-equipment/99999');
    $response->assertStatus(404);
    $response->assertExactJson([
        'success' => false,
        'errors' => 'StudentEquipment id-a ez da aurkitu'
    ]);
});

// Get one soft delete
test('Get one StudentEquipment soft delete eginda dagoena', function () {
    $estructura = [
        'success',
        'data' => ['id', 'student_id', 'equipment_id', 'start_datetime', 'end_datetime', 'created_at', 'updated_at', 'deleted_at']
    ];

    $student = Student::factory()->create();
    $equipment = Equipment::factory()->create();

    $item = StudentEquipment::factory()->create([
        'student_id' => $student->id,
        'equipment_id' => $equipment->id,
    ]);

    $item->delete();

    $response = $this->getJson("api/student-equipment-deleted/{$item->id}");
    $response->assertStatus(200);
    $response->assertJson([
        'success' => true,
    ]);
    $response->assertJsonStructure($estructura);
});

// Post ongi
test('Post StudentEquipment erantzun egokia bueltatzen du', function () {
    $student = Student::factory()->create();
    $equipment = Equipment::factory()->create();

    $response = postJson('api/student-equipment', [
        'student_id' => $student->id,
        'equipment_id' => $equipment->id,
        'start_datetime' => '2026-02-05 09:00:00',
        'end_datetime' => '2026-02-05 11:00:00'
    ]);

    $response->assertStatus(201);
    $response->assertExactJson([
        'success' => true,
        'message' => 'StudentEquipment sortu egin da'
    ]);
});

// Post txarto
test('Post StudentEquipment erantzun okerra bueltatzen du, datu falta', function () {
    $response = postJson('api/student-equipment', [
        'student_id' => 1
    ]);

    $response->assertStatus(422);
    $response->assertExactJson([
        'success' => false,
        'errors' => 'Datuak faltatzen dira.'
    ]);
});

// Put ongi
test('Put StudentEquipment erantzun egokia bueltatzen du', function () {
    $student = Student::factory()->create();
    $equipment = Equipment::factory()->create();

    $item = StudentEquipment::factory()->create([
        'student_id' => $student->id,
        'equipment_id' => $equipment->id,
    ]);

    $updated = [
        'student_id' => $student->id,
        'equipment_id' => $equipment->id,
        'start_datetime' => '2026-02-05 10:00:00',
        'end_datetime' => '2026-02-05 12:00:00'
    ];

    $response = $this->putJson("api/student-equipment/{$item->id}", $updated);
    $response->assertStatus(200);
    $response->assertExactJson([
        'success' => true,
        'message' => 'StudentEquipment eguneratu da'
    ]);

    $itemAldatuta = $this->getJson("api/student-equipment/{$item->id}");
    $itemAldatuta->assertJson([
        'success' => true,
        'data' => $updated
    ]);
});

// Put txarto datuak falta
test('Put StudentEquipment erantzun okerra bueltatzen du, datuak faltatzen dira', function () {
    $student = Student::factory()->create();
    $equipment = Equipment::factory()->create();

    $item = StudentEquipment::factory()->create([
        'student_id' => $student->id,
        'equipment_id' => $equipment->id,
    ]);

    $response = $this->putJson("api/student-equipment/{$item->id}", [
        'student_id' => $student->id
    ]);

    $response->assertStatus(422);
    $response->assertExactJson([
        'success' => false,
        'errors' => 'Datuak faltatzen dira.'
    ]);
});

// Put txarto existitzen ez den id-a
test('Put StudentEquipment erantzun okerra bueltatzen du, id-a ez da existitzen', function () {
    $student = Student::factory()->create();
    $equipment = Equipment::factory()->create();

    $updated = [
        'student_id' => $student->id,
        'equipment_id' => $equipment->id,
        'start_datetime' => '2026-02-05 10:00:00',
        'end_datetime' => '2026-02-05 12:00:00'
    ];

    $response = $this->putJson("api/student-equipment/99999", $updated);
    $response->assertStatus(404);
    $response->assertExactJson([
        'success' => false,
        'errors' => 'StudentEquipment id-a ez da aurkitu'
    ]);
});

// Delete ongi
test('Delete StudentEquipment erantzun egokia bueltatzen du', function () {
    $student = Student::factory()->create();
    $equipment = Equipment::factory()->create();

    $item = StudentEquipment::factory()->create([
        'student_id' => $student->id,
        'equipment_id' => $equipment->id,
    ]);

    $response = $this->deleteJson("api/student-equipment/{$item->id}");
    $response->assertStatus(200);
    $response->assertExactJson([
        'success' => true,
        'message' => 'StudentEquipment ezabatuta'
    ]);
});

// Delete txarto
test('Delete StudentEquipment existitzen ez duena edo soft-delete eginda dago', function () {
    $student = Student::factory()->create();
    $equipment = Equipment::factory()->create();

    $item = StudentEquipment::factory()->create([
        'student_id' => $student->id,
        'equipment_id' => $equipment->id,
    ]);

    $this->deleteJson("api/student-equipment/{$item->id}");

    $response = $this->deleteJson("api/student-equipment/{$item->id}");
    $response->assertStatus(404);
    $response->assertExactJson([
        'success' => false,
        'errors' => 'StudentEquipment id-a ez da aurkitu'
    ]);
});
