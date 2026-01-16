<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ConsumablesCategorie extends Model
{
    public function consumable(): HasMany
    {
        return $this->HasMany(Consumable::class);
    }
}
