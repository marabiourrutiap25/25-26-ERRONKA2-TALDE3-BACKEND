<?php

use App\Models\Schedule;
use App\Models\Group;

use function Pest\Laravel\postJson;

// Get All
test('Get all Schedules erantzun egokia bueltatzen du', function () {
    $estructura = [
        'success',
        'data' => [
            '*' => ['id', 'day', 'start_date', 'end_date', 'start_time', 'end_time', 'group_id', 'created_at', 'updated_at', 'deleted_at']
        ]
    ];

    Schedule::factory()->count(3)->create();

    $response = $this->getJson('api/schedules');
    $response->assertStatus(200);
    $response->assertJson([
        'success' => true,
    ]);
    $response->assertJsonCount(3, 'data');
    $response->assertJsonStructure($estructura);
});

// Get All soft-deleted
test('Get all Schedules soft-delete egindakoak erantzun egokia bueltatzen du', function () {
    $estructura = [
        'success',
        'data' => [
            '*' => ['id', 'day', 'start_date', 'end_date', 'start_time', 'end_time', 'group_id', 'created_at', 'updated_at', 'deleted_at']
        ]
    ];

    $schedules = Schedule::factory()->count(3)->create();

    $schedules->each->delete();

    $response = $this->getJson('api/schedules-deleted');
    $response->assertStatus(200);
    $response->assertJson([
        'success' => true,
    ]);
    $response->assertJsonCount(3, 'data');
    $response->assertJsonStructure($estructura);
});

// Get one ongi
test('Get one Schedule erantzun egokia bueltatzen du', function () {
    $estructura = [
        'success',
        'data' => ['id', 'day', 'start_date', 'end_date', 'start_time', 'end_time', 'group_id', 'created_at', 'updated_at', 'deleted_at']
    ];

    $schedule = Schedule::factory()->create();

    $response = $this->getJson("api/schedules/{$schedule->id}");
    $response->assertStatus(200);

    $response->assertJson([
        'success' => true,
    ]);
    $response->assertJsonStructure($estructura);
    $response->assertJsonPath('data.id', $schedule->id);
});

// Get one existitzen ez duena
test('Get one Schedule existitzen ez duena', function () {
    $response = $this->getJson('api/schedules/99999');
    $response->assertStatus(404);
    $response->assertExactJson([
        "success" => false,
        "errors" => "Ordutegiaren id-a ez da aurkitu"
    ]);
});

// Get one soft delete
test('Get one Schedule soft delete eginda dagoena ', function () {
    $estructura = [
        'success',
        'data' => ['id', 'day', 'start_date', 'end_date', 'start_time', 'end_time', 'group_id', 'created_at', 'updated_at', 'deleted_at']
    ];

    $schedule = Schedule::factory()->create();

    $schedule->delete();

    $response = $this->getJson("api/schedules-deleted/{$schedule->id}");
    $response->assertStatus(200);
    $response->assertJson([
        'success' => true,
    ]);
    $response->assertJsonStructure($estructura);
});

// Post ongi
test('Post Schedule erantzun egokia bueltatzen du', function () {
    $group = Group::factory()->create();

    $response = postJson('api/schedules', [
        "day" => 1,
        "start_date" => "2026-02-01",
        "end_date" => "2026-02-10",
        "start_time" => "09:49:09",
        "end_time" => "10:49:09",
        "group_id" => $group->id
    ]);

    $response->assertStatus(201);

    $response->assertExactJson([
        "success" => true,
        "message" => "Ordutegia sortu egin da"
    ]);
});

// Post txarto
test('Post Schedule erantzun okerra bueltatzen du, datu falta', function () {
    $response = postJson('api/schedules', [
        "day" => 1,
        "start_date" => "2026-02-01",
        "end_date" => "2026-02-10",
        "start_time" => "09:49:09",
        "end_time" => "10:49:09"
    ]);

    $response->assertStatus(422);

    $response->assertExactJson([
        "success" => false,
        "errors" => "Datuak faltatzen dira."
    ]);
});

// Put ongi
test('Put Schedule erantzun egokia bueltatzen du', function () {
    $schedule = Schedule::factory()->create([
        'day' => "7"
    ]);

    $scheduleUpdated = [
        "day" => 1,
        "start_date" => "2026-02-01",
        "end_date" => "2026-02-10",
        "start_time" => "09:00:00",
        "end_time" => "10:00:00",
        "group_id" => $schedule->group_id
    ];

    $response = $this->putJson("api/schedules/{$schedule->id}", $scheduleUpdated);

    $response->assertStatus(200);
    $response->assertExactJson([
        'success' => true,
        'message' => 'Ordutegia eguneratu da',
    ]);

    $scheduleAldatuta = $this->getJson("api/schedules/{$schedule->id}");
    $scheduleAldatuta->assertJson([
        'success' => true,
        'data' => $scheduleUpdated
    ]);
});

// Put txarto datuak falta
test('Put Schedule erantzun okerra bueltatzen du, datuak faltatzen dira', function () {
    $schedule = Schedule::factory()->create();

    $scheduleUpdated = [
        "day" => 1,
    ];

    $response = $this->putJson("api/schedules/{$schedule->id}", $scheduleUpdated);

    $response->assertStatus(422);
    $response->assertExactJson([
        'success' => false,
        'errors' => 'Datuak faltatzen dira.',
    ]);
});

// Put txarto existitzen ez den id-a
test('Put Schedule erantzun okerra bueltatzen du, id-a ez du existitzen', function () {
    $schedule = Schedule::factory()->create();

    $scheduleUpdated = [
        "day" => 1,
        "start_date" => "2026-02-01",
        "end_date" => "2026-02-10",
        "start_time" => "09:00:00",
        "end_time" => "10:00:00",
        "group_id" => $schedule->group_id
    ];

    $response = $this->putJson("api/schedules/99999", $scheduleUpdated);

    $response->assertStatus(404);
    $response->assertExactJson([
        'success' => false,
        'errors' => 'Ordutegiaren id-a ez da aurkitu'
    ]);
});

// Delete ongi
test('Delete Schedule erantzun egokia bueltatzen du', function () {
    $schedule = Schedule::factory()->create();

    $response = $this->deleteJson("api/schedules/{$schedule->id}");
    $response->assertStatus(200);

    $response->assertExactJson([
        'success' => true,
        'message' => 'Ordutegia ezabatuta'
    ]);
});

// Delete txarto (ez du existitzen/soft-delete badago eginda)
test('Delete Schedule existitzen ez duena edo soft-delete eginda dago', function () {
    $schedule = Schedule::factory()->create();
    $this->deleteJson("api/schedules/{$schedule->id}");

    $response = $this->deleteJson("api/schedules/{$schedule->id}");
    $response->assertStatus(404);
    $response->assertExactJson([
        "success" => false,
        "errors" => "Ordutegiaren id-a ez da aurkitu"
    ]);
});