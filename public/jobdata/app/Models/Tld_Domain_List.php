<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tld_Domain_List extends Model
{
    use HasFactory;
    
    protected $table = 'tld_domain_list';

    protected $fillable = [
        'domain_name',
    ];
}
