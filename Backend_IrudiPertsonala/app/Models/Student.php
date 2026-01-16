<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Student extends Model
{
    public function studentconsumable(): HasMany
    {
        return $this->hasMany(StudentConsumable::class);
    }

    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class);
    }

    public function shift(): HasMany
    {
        return $this->hasMany(Shift::class);
    }


    public function appointment(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }

    public function equipment(): BelongsToMany
    {
        return $this->belongsToMany(Equipment::class);
    }
}
