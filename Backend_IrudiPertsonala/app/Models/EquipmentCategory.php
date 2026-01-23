<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class EquipmentCategory extends Model
{
    use SoftDeletes;
    protected $fillable = ['name'];
    public function equipment(): HasMany
    {
        return $this->hasMany(Equipment::class);
    }
}
