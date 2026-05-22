<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'm_users';
    public $timestamps = true;

    protected $fillable = ['name', 'email', 'password', 'phone'];
    protected $hidden = ['password'];
}
