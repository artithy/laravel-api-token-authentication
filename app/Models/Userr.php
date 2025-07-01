<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Userr extends Model
{
    protected $table = 'user';

    protected $fillable = [
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
    ];
}
