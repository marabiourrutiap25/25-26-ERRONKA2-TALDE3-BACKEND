<?php

use App\Models\Equipment;
use App\Models\EquipmentCategory;

use function Pest\Laravel\postJson;

// Get All
test('Get all Equipments erantzun egokia bueltatzen du', function () {
    $estructura = [
        'success',
        'data' => [
            '*' => ['id', 'label', 'name', 'description', 'brand', 'equipment_category_id', 'created_at', 'updated_at', 'deleted_at']
        ]
    ];

    $category = EquipmentCategory::factory()->create();

    Equipment::factory()->count(3)->create([
        'equipment_category_id' => $category->id,
    ]);

    $response = $this->getJson('api/equipment');
    $response->assertStatus(200);
    $response->assertJson([
        'success' => true,
    ]);
    $response->assertJsonCount(3, 'data');
    $response->assertJsonStructure($estructura);
});

// Get All soft-deleted
test('Get all Equipments soft-delete egindakoak erantzun egokia bueltatzen du', function () {
    $estructura = [
        'success',
        'data' => [
            '*' => ['id', 'label', 'name', 'description', 'brand', 'equipment_category_id', 'created_at', 'updated_at', 'deleted_at']
        ]
    ];

    $category = EquipmentCategory::factory()->create();
    $equipments = Equipment::factory()->count(3)->create([
        'equipment_category_id' => $category->id,
    ]);
    $equipments->each->delete();

    $response = $this->getJson('api/equipment-deleted');
    $response->assertStatus(200);
    $response->assertJson([
        'success' => true,
    ]);
    $response->assertJsonCount(3, 'data');
    $response->assertJsonStructure($estructura);
});

// Get one ongi
test('Get one Equipment erantzun egokia bueltatzen du', function () {
    $estructura = [
        'success',
        'data' => ['id', 'label', 'name', 'description', 'brand', 'equipment_category_id', 'created_at', 'updated_at', 'deleted_at']
    ];

    $category = EquipmentCategory::factory()->create();
    $equipment = Equipment::factory()->create([
        'equipment_category_id' => $category->id,
    ]);

    $response = $this->getJson("api/equipment/{$equipment->id}");
    $response->assertStatus(200);
    $response->assertJson([
        'success' => true,
    ]);
    $response->assertJsonStructure($estructura);
    $response->assertJsonPath('data.id', $equipment->id);
});

// Get one existitzen ez duena
test('Get one Equipment existitzen ez duena', function () {
    $response = $this->getJson('api/equipment/99999');
    $response->assertStatus(404);
    $response->assertExactJson([
        'success' => false,
        'errors' => 'Ekipamenduen id-a ez da aurkitu'
    ]);
});

// Get one soft delete
test('Get one Equipment soft delete eginda dagoena', function () {
    $estructura = [
        'success',
        'data' => ['id', 'label', 'name', 'description', 'brand', 'equipment_category_id', 'created_at', 'updated_at', 'deleted_at']
    ];

    $category = EquipmentCategory::factory()->create();
    $equipment = Equipment::factory()->create([
        'equipment_category_id' => $category->id,
    ]);
    $equipment->delete();

    $response = $this->getJson("api/equipment-deleted/{$equipment->id}");
    $response->assertStatus(200);
    $response->assertJson([
        'success' => true,
    ]);
    $response->assertJsonStructure($estructura);
});

// Post ongi
test('Post Equipment erantzun egokia bueltatzen du', function () {
    $category = EquipmentCategory::factory()->create();

    $response = postJson('api/equipment', [
        'label' => 'EQ-001',
        'name' => 'Ultrasound',
        'description' => 'Portable ultrasound device',
        'brand' => 'MedTech',
        'equipment_category_id' => $category->id
    ]);

    $response->assertStatus(201);
    $response->assertExactJson([
        'success' => true,
        'message' => 'Ekipamendua sortu egin da'
    ]);
});

// Post txarto
test('Post Equipment erantzun okerra bueltatzen du, datu falta', function () {
    $response = postJson('api/equipment', [
        'label' => 'EQ-001'
    ]);

    $response->assertStatus(422);
    $response->assertExactJson([
        'success' => false,
        'errors' => 'Datuak faltatzen dira.'
    ]);
});

// Put ongi
test('Put Equipment erantzun egokia bueltatzen du', function () {
    $category = EquipmentCategory::factory()->create();
    $equipment = Equipment::factory()->create([
        'equipment_category_id' => $category->id,
    ]);

    $updated = [
        'label' => 'EQ-002',
        'name' => 'MRI',
        'description' => 'MRI scanner',
        'brand' => 'ImagiTech',
        'equipment_category_id' => $category->id
    ];

    $response = $this->putJson("api/equipment/{$equipment->id}", $updated);
    $response->assertStatus(200);
    $response->assertExactJson([
        'success' => true,
        'message' => 'Ekipamendua eguneratu da'
    ]);

    $equipmentAldatuta = $this->getJson("api/equipment/{$equipment->id}");
    $equipmentAldatuta->assertJson([
        'success' => true,
        'data' => $updated
    ]);
});

// Put txarto datuak falta
test('Put Equipment erantzun okerra bueltatzen du, datuak faltatzen dira', function () {
    $category = EquipmentCategory::factory()->create();
    $equipment = Equipment::factory()->create([
        'equipment_category_id' => $category->id,
    ]);

    $response = $this->putJson("api/equipment/{$equipment->id}", [
        'label' => 'EQ-003'
    ]);
    $response->assertStatus(422);
    $response->assertExactJson([
        'success' => false,
        'errors' => 'Datuak faltatzen dira.'
    ]);
});

// Put txarto existitzen ez den id-a
test('Put Equipment erantzun okerra bueltatzen du, id-a ez da existitzen', function () {
    $category = EquipmentCategory::factory()->create();

    $response = $this->putJson('api/equipment/99999', [
        'label' => 'EQ-004',
        'name' => 'X-Ray',
        'description' => 'X-ray machine',
        'brand' => 'RadiTech',
        'equipment_category_id' => $category->id
    ]);
    $response->assertStatus(404);
    $response->assertExactJson([
        'success' => false,
        'errors' => 'Ekipamenduen id-a ez da aurkitu'
    ]);
});

// Delete ongi
test('Delete Equipment erantzun egokia bueltatzen du', function () {
    $category = EquipmentCategory::factory()->create();
    $equipment = Equipment::factory()->create([
        'equipment_category_id' => $category->id,
    ]);

    $response = $this->deleteJson("api/equipment/{$equipment->id}");
    $response->assertStatus(200);
    $response->assertExactJson([
        'success' => true,
        'message' => 'Ekipamendua ezabatuta'
    ]);
});

// Delete txarto
test('Delete Equipment existitzen ez duena edo soft-delete eginda dago', function () {
    $category = EquipmentCategory::factory()->create();
    $equipment = Equipment::factory()->create([
        'equipment_category_id' => $category->id,
    ]);
    $this->deleteJson("api/equipment/{$equipment->id}");

    $response = $this->deleteJson("api/equipment/{$equipment->id}");
    $response->assertStatus(404);
    $response->assertExactJson([
        'success' => false,
        'errors' => 'Ekipamenduen id-a ez da aurkitu'
    ]);
});
