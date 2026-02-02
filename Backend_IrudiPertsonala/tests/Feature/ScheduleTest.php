<?php

use App\Models\Schedule;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

test('Get all Schedules erantzun egokia bueltatzen du', function () {
    $egitura = [
        'success',
        'data' => [
            '*' => ['id', 'day', 'start_date', 'end_date', 'start_time', 'end_time', 'group_id', 'created_at', 'updated_at', 'deleted_at']
        ]
    ];

    $user = User::factory()->create();
    Sanctum::actingAs($user);

    Schedule::factory()->count(3)->create();

    $response = $this->getJson('api/schedules');
    $response->assertStatus(200);
    $response->assertJson([
        'success' => true,
    ]);
    $response->assertJsonCount(3, 'data');
    $response->assertJsonStructure($egitura);
});