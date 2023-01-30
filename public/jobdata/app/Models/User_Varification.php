<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User_Varification extends Model
{
    use HasFactory;

    protected $table = 'user_varification';

    protected $fillable = [
        'email',
        'key'
    ];
}
