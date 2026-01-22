<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
class Consumable extends Model
{
    protected $fillable = [
        'name',
        'description',
        'batch',
        'brand',
        'stock',
        'min_stock',
        'expiration_date',
        'consumables_category_id',
    ];
    public function consumablescategorie(): BelongsTo
    {
        return $this->BelongsTo(ConsumableCategory::class);
    }

    public function studentconsumable(): HasMany
    {
        return $this->hasMany(StudentConsumable::class);
    }
}
