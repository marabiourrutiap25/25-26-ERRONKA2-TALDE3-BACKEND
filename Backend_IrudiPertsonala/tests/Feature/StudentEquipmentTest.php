<?php

use App\Models\StudentEquipment;
use App\Models\Student;
use App\Models\Equipment;

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
