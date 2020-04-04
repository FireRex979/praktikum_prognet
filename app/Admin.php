<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    protected $table='admins';

    protected $fillable = [
        'name', 'username', 'password','profile_image','phone',
    ];
}
