<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ServiceCategorie extends Model
{
    public function service(): HasMany
    {
        return $this->hasMany(Service::class);
    }
}
