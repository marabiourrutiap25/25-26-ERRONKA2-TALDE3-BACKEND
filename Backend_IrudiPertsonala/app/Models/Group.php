<?php namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Group extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['name'];

    public function student(): HasMany
    {
        return $this->hasMany(Student::class);
    }

    public function schedule(): HasMany
    {
        return $this->hasMany(Schedule::class);
    }

    protected static function booted()
    {
        static::deleting(function ($group) {
            // Soft delete de schedules
            $group->schedule()->delete();

            // Poner a null el group_id de los students relacionados
            $group->student()->update(['group_id' => null]);
        });
    }
}
