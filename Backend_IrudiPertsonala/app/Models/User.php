<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'username',
        'email',
        'password',
        'rol',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}

/*
 php artisan tinker

 use App\Models\User;
use Illuminate\Support\Facades\Hash;

User::create([
    'username' => 'a',
    'email' => 'a@example.com',
    'rol' => 'admin',
    'password' => Hash::make('a')
]);

 **/