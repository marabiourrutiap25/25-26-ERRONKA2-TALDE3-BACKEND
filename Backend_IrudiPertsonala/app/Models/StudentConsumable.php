<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentConsumable extends Model
{

    protected $fillable = [
        'student_id',
        'consumable_id',
        'date',
        'quantity',
    ];
    public function consumable(): BelongsTo
    {
        return $this->BelongsTo(Consumable::class);
    }
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }
}
