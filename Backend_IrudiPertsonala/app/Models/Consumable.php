<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
class Consumable extends Model
{
    use SoftDeletes;
    use HasFactory;
    
    protected $fillable = [
        'name',
        'description',
        'batch',
        'brand',
        'stock',
        'min_stock',
        'expiration_date',
        'consumable_category_id',
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
