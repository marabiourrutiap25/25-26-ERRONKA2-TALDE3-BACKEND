<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
class Shift extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'type',
        'data',
        'student_id',
    ];
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

}
