<?php

use App\Models\Student;
use App\Models\Group;

test('Get all Students erantzun egokia bueltatzen du', function () {
    $estructura = [
        'success',
        'data' => [
            '*' => ['id', 'name', 'surnames', 'group_id', 'created_at', 'updated_at', 'deleted_at']
        ]
    ];

    $group = Group::factory()->create();

    Student::factory()->count(3)->create([
        'group_id' => $group->id
    ]);

    $response = $this->getJson('api/students');
    $response->assertStatus(200);
    $response->assertJson([
        'success' => true,
    ]);
    $response->assertJsonCount(3, 'data');
    $response->assertJsonStructure($estructura);
});
