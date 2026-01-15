<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Client extends Model
{
    public function appointment(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }
}
