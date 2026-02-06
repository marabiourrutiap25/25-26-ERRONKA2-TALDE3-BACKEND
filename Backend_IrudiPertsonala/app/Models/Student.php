<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $fillable = [
        'name',
        'surnames',
        'group_id',
    ];

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

    protected static function booted()
    {
        // SoftDelete Student -> SoftDelete Shift
        static::deleting(function ($student) {
            if ($student->isForceDeleting()) {
                $student->shift()->forceDelete();
            } else {
                $student->shift()->delete();
            }
        });

        static::restoring(function ($student) {
            $student->shift()->withTrashed()->restore();
        });
    }
}
