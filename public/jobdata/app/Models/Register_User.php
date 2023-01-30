<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Register_User extends Model
{
    use HasFactory;

    protected $table = 'register_users';

    protected $fillable = [
        'email',
        'varified'
    ];
}
