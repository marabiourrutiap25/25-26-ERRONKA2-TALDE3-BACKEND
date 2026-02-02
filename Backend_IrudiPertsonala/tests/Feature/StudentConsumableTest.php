<?php

use App\Models\StudentConsumable;
use App\Models\Student;
use App\Models\Consumable;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

test('Get all StudentConsumables erantzun egokia bueltatzen du', function () {
    $estructura = [
        'success',
        'data' => [
            '*' => ['id', 'student_id', 'consumable_id', 'date', 'quantity', 'created_at', 'updated_at', 'deleted_at']
        ]
    ];

    $user = User::factory()->create();
    Sanctum::actingAs($user);

    $student = Student::factory()->create();
    $consumable = Consumable::factory()->create();

    StudentConsumable::factory()->count(3)->create([
        'student_id' => $student->id,
        'consumable_id' => $consumable->id,
    ]);

    $response = $this->getJson('api/student-consumables');
    $response->assertStatus(200);
    $response->assertJson([
        'success' => true,
    ]);
    $response->assertJsonCount(3, 'data');
    $response->assertJsonStructure($estructura);
});
