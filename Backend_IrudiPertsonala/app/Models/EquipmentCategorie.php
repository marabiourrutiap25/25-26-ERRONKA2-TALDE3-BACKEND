<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EquipmentCategorie extends Model
{
    public function equipment(): HasMany
    {
        return $this->hasMany(Equipment::class);
    }
}
