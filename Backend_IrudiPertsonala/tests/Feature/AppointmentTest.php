<?php

use App\Models\Appointment;

test('Get all Appointments erantzun egokia bueltatzen du', function () {
    $estructura = [
        'success',
        'data' => [
            '*' => [
                'id',
                'seat',
                'date',
                'start_time',
                'end_time',
                'comments',
                'student_id',
                'client_id',
                'created_at',
                'updated_at',
                'deleted_at'
            ]
        ]
    ];

    Appointment::factory()->count(3)->create();

    $response = $this->getJson('api/appointments');
    $response->assertStatus(200);
    $response->assertJson([
        'success' => true,
    ]);
    $response->assertJsonCount(3, 'data');
    $response->assertJsonStructure($estructura);
});
