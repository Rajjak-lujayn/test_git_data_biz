<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Listing_file_name extends Model
{
    use HasFactory;


    protected $fillable = [
		'id',
		'file_name',
		'count',
	];

    // public function Listing(){
    //     return $this->hasMany(Listing::class);
    // }
}
