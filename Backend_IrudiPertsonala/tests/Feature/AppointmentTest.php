<?php

use App\Models\Appointment;

use App\Models\Client;
use App\Models\Student;
use function Pest\Laravel\postJson;

// Get All
test('Get all Appointments erantzun egokia bueltatzen du', function () {
    $estructura = [
        'success',
        'data' => [
            '*' => [
                'id', 'seat', 'date', 'start_time', 'end_time',
                'comments', 'student_id', 'client_id',
                'created_at', 'updated_at', 'deleted_at'
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

// Get All soft-deleted
test('Get all Appointments soft-delete egindakoak erantzun egokia bueltatzen du', function () {
    $estructura = [
        'success',
        'data' => [
            '*' => [
                'id', 'seat', 'date', 'start_time', 'end_time',
                'comments', 'student_id', 'client_id',
                'created_at', 'updated_at', 'deleted_at'
            ]
        ]
    ];

    $appointments = Appointment::factory()->count(3)->create();
    $appointments->each->delete();

    $response = $this->getJson('api/appointments-deleted');
    $response->assertStatus(200);
    $response->assertJson([
        'success' => true,
    ]);
    $response->assertJsonCount(3, 'data');
    $response->assertJsonStructure($estructura);
});

// Get one ongi
test('Get one Appointment erantzun egokia bueltatzen du', function () {
    $estructura = [
        'success',
        'data' => [
            'id', 'seat', 'date', 'start_time', 'end_time',
            'comments', 'student_id', 'client_id',
            'created_at', 'updated_at', 'deleted_at'
        ]
    ];

    $appointment = Appointment::factory()->create();

    $response = $this->getJson("api/appointments/{$appointment->id}");
    $response->assertStatus(200);
    $response->assertJson([
        'success' => true,
    ]);
    $response->assertJsonStructure($estructura);
    $response->assertJsonPath('data.id', $appointment->id);
});

// Get one existitzen ez duena
test('Get one Appointment existitzen ez duena', function () {
    $response = $this->getJson('api/appointments/99999');
    $response->assertStatus(404);
    $response->assertExactJson([
        'success' => false,
        'errors' => 'Hitzorduen id-a ez da aurkitu'
    ]);
});

// Get one soft delete
test('Get one Appointment soft delete eginda dagoena', function () {
    $estructura = [
        'success',
        'data' => [
            'id', 'seat', 'date', 'start_time', 'end_time',
            'comments', 'student_id', 'client_id',
            'created_at', 'updated_at', 'deleted_at'
        ]
    ];

    $appointment = Appointment::factory()->create();
    $appointment->delete();

    $response = $this->getJson("api/appointments-deleted/{$appointment->id}");
    $response->assertStatus(200);
    $response->assertJson([
        'success' => true,
    ]);
    $response->assertJsonStructure($estructura);
});

// Post ongi
test('Post Appointment erantzun egokia bueltatzen du', function () {
    $student = Student::factory()->create();
    $client = Client::factory()->create();

    $response = postJson('api/appointments', [
        'seat' => 5,
        'date' => '2026-02-10',
        'start_time' => '09:00:00',
        'end_time' => '10:00:00',
        'comments' => 'Comentario de prueba',
        'student_id' => $student->id,
        'client_id' => $client->id
    ]);

    $response->assertStatus(201);
    $response->assertExactJson([
        'success' => true,
        'message' => 'Hitzordua sortu egin da'
    ]);
});
// Post txarto
test('Post Appointment erantzun okerra bueltatzen du, datu falta', function () {
    $response = postJson('api/appointments', [
        'seat' => 5
    ]);

    $response->assertStatus(422);
    $response->assertExactJson([
        'success' => false,
        'errors' => 'Datuak faltatzen dira.'
    ]);
});

// Put ongi
test('Put Appointment erantzun egokia bueltatzen du', function () {
    $appointment = Appointment::factory()->create();

    $updated = [
        'seat' => 10,
        'date' => '2026-02-11',
        'start_time' => '11:00:00',
        'end_time' => '12:00:00',
        'comments' => 'Actualizado',
        'student_id' => $appointment->student_id,
        'client_id' => $appointment->client_id
    ];

    $response = $this->putJson("api/appointments/{$appointment->id}", $updated);
    $response->assertStatus(200);
    $response->assertExactJson([
        'success' => true,
        'message' => 'Hitzordua eguneratu da'
    ]);

    $appointmentUpdated = $this->getJson("api/appointments/{$appointment->id}");
    $appointmentUpdated->assertJson([
        'success' => true,
        'data' => $updated
    ]);
});

// Put txarto datuak falta
test('Put Appointment erantzun okerra bueltatzen du, datuak faltatzen dira', function () {
    $appointment = Appointment::factory()->create();

    $response = $this->putJson("api/appointments/{$appointment->id}", [
        'seat' => 10
    ]);
    $response->assertStatus(422);
    $response->assertExactJson([
        'success' => false,
        'errors' => 'Datuak faltatzen dira.'
    ]);
});

// Put txarto existitzen ez den id-a
test('Put Appointment erantzun okerra bueltatzen du, id-a ez da existitzen', function () {
    $response = $this->putJson("api/appointments/99999", [
        'seat' => 10,
        'date' => '2026-02-11',
        'start_time' => '11:00:00',
        'end_time' => '12:00:00',
        'comments' => 'Actualizado',
        'student_id' => 1,
        'client_id' => 1
    ]);

    $response->assertStatus(404);
    $response->assertExactJson([
        'success' => false,
        'errors' => 'Hitzorduen id-a ez da aurkitu'
    ]);
});

// Delete ongi
test('Delete Appointment erantzun egokia bueltatzen du', function () {
    $appointment = Appointment::factory()->create();

    $response = $this->deleteJson("api/appointments/{$appointment->id}");
    $response->assertStatus(200);
    $response->assertExactJson([
        'success' => true,
        'message' => 'Hitzordua ezabatuta'
    ]);
});

// Delete txarto
test('Delete Appointment existitzen ez duena edo soft-delete eginda dago', function () {
    $appointment = Appointment::factory()->create();
    $this->deleteJson("api/appointments/{$appointment->id}");

    $response = $this->deleteJson("api/appointments/{$appointment->id}");
    $response->assertStatus(404);
    $response->assertExactJson([
        'success' => false,
        'errors' => 'Hitzorduen id-a ez da aurkitu'
    ]);
});
