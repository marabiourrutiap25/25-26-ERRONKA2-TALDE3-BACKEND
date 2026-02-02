<?php

use App\Models\Shift;
use App\Models\Student;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

test('Get all Shifts erantzun egokia bueltatzen du', function () {
    $estructura = [
        'success',
        'data' => [
            '*' => ['id', 'type', 'data', 'student_id', 'created_at', 'updated_at', 'deleted_at']
        ]
    ];

    $user = User::factory()->create();
    Sanctum::actingAs($user);

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
