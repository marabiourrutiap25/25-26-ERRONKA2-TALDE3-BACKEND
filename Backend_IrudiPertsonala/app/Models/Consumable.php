<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
class Consumable extends Model
{
    public function consumablescategorie(): BelongsTo
    {
        return $this->BelongsTo(ConsumablesCategorie::class);
    }

    public function studentconsumable(): HasMany
    {
        return $this->hasMany(StudentConsumable::class);
    }
}
