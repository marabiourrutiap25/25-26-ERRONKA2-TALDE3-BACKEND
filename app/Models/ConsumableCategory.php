<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ConsumableCategory extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['name'];

    public function consumable(): HasMany
    {
        return $this->hasMany(Consumable::class);
    }

    protected static function booted()
    {
        static::deleting(function ($category) {
            if ($category->isForceDeleting()) {
                // hard delete → dejar a null
                $category->consumable()->update([
                    'consumable_category_id' => null
                ]);
            } else {
                // soft delete → dejar a null
                $category->consumable()->update([
                    'consumable_category_id' => null
                ]);
            }
        });
    }
}
