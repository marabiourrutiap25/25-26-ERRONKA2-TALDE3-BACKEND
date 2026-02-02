<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class EquipmentCategory extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $fillable = ['name'];

    public function equipment(): HasMany
    {
        return $this->hasMany(Equipment::class);
    }

    protected static function booted()
    {
        static::deleting(function ($category) {
            $category->equipment()->update([
                'equipment_category_id' => null
            ]);
        });
    }
}
