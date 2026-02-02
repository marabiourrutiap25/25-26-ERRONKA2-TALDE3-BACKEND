<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
class Schedule extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'day',
        'start_date',
        'end_date',
        'start_time',
        'end_time',
        'group_id',
    ];
    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class);
    }
}
