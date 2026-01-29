<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Equipment extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'label',
        'name',
        'description',
        'brand',
        'equipment_category_id',
    ];

    public function equipmentCategory(): BelongsTo
    {
        return $this->belongsTo(EquipmentCategory::class);
    }

    public function student(): BelongsToMany
    {
        return $this->belongsToMany(Student::class);
    }
}
