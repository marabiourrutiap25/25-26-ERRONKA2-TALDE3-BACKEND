<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Equipment extends Model
{
    protected $fillable = [
        'label',
        'name',
        'description',
        'brand',
        'equipment_categories_id',
    ];
    public function equipmentCategories(): BelongsTo
    {
        return $this->belongsTo(EquipmentCategory::class);
    }

    public function student(): BelongsToMany
    {
        return $this->belongsToMany(Student::class);
    }
}
