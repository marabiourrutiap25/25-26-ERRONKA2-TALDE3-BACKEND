<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use SoftDeletes;

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

    /**
     * Booted method para eventos de Eloquent
     */
    protected static function booted()
    {
        // Cuando se soft delete un Client, se soft deletean sus Appointments
        static::deleting(function ($client) {
            if ($client->isForceDeleting()) {
                // Si se hace force delete, eliminar permanentemente
                $client->appointment()->forceDelete();
            } else {
                // Soft delete
                $client->appointment()->delete();
            }
        });

        // Restaurar las citas si el cliente se restaura
        static::restoring(function ($client) {
            $client->appointment()->withTrashed()->restore();
        });
    }
}
