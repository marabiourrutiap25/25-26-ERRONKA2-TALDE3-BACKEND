<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ConsumableCategorie extends Model
{
    protected $fillable = ['name'];
    public function consumable(): HasMany
    {
        return $this->HasMany(Consumable::class);
    }
}
