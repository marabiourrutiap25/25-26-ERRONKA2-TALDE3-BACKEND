<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Client extends Model
{
    protected $fillable = [
        'name',
        'surnames',
        'telephone',
        'email',
        'home_client',
    ];
    public function appointment(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }
}
