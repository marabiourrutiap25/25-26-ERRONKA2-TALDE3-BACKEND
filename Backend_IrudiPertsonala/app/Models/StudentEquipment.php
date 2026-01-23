<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
class StudentEquipment extends Model
{
    use SoftDeletes;
    protected $table = 'student_equipments';

    protected $fillable = [
        'student_id',
        'equipment_id',
        'start_datetime',
        'end_datetime',
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function equipment(): BelongsTo
    {
        return $this->belongsTo(Equipment::class);
    }
}
