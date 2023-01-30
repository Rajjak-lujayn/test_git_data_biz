<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListingView extends Model
{
    use HasFactory;
    protected $table = 'listing';

    protected $fillable = ['FirstName', 'LastName', 'Title'];
}
