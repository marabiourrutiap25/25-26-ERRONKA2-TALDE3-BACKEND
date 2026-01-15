<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Equipment extends Model
{
    public function equipmentCategories(): BelongsTo
    {
        return $this->belongsTo(EquipmentCategorie::class);
    }

    public function student(): BelongsToMany
    {
        return $this->belongsToMany(Student::class);
    }
}
