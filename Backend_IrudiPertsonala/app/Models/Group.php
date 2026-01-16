<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Group extends Model
{
    public function student(): HasMany
    {
        return $this->hasMany(Student::class);
    }
    public function schedule(): HasMany
    {
        return $this->hasMany(Schedules::class);
    }
}
