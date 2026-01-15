<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Equipment extends Model
{
    public function equipmentCategories(): BelongsToMany
    {
        return $this->belongsToMany(EquipmentCategorie::class);
    }
}
