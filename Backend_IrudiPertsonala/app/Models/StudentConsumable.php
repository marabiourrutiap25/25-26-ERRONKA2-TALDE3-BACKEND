<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentConsumable extends Model
{
    public function consumable(): BelongsTo
    {
        return $this->BelongsTo(Consumable::class);
    }
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }
}
