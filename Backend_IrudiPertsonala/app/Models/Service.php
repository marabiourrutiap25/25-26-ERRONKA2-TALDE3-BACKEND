<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Service extends Model
{

    protected $fillable = [
        'name',
        'price',
        'home_price',
        'duration',
        'service_category_id',
    ];
    public function serviceCategories(): BelongsTo
    {
        return $this->belongsTo(ServiceCategory::class);
    }

    public function appointments(): BelongsToMany
    {
        return $this->belongsToMany(Appointment::class);
    }
}
