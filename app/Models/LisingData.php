<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ListingData extends Model
{

    protected $table = 'listing';

    protected $fillable = ['FirstName', 'LastName', 'Title'];

}
?>