<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;

class User_Meta extends Model
{
    use HasFactory;
    protected $table = 'user_meta';
    
    // public static function setMeta($key,$value){
    //     $user = Auth::user();
    //     DB::insert(`insert into $this->table (userId, key, value) values (?, ?, ?)`, [$user->id,$key, $value]);
    // }

    // public static function getMeta($key){
    //     $user = Auth::user();
    //     $responce = DB::table($this->table)->where("key", "=" ,$key)->where("userId","=",$user->id);
    //     return $responce;
    // }

    protected $fillable = [
        'userEmail',
        'key',
        'value',
    ];
    // protected $attributes = [
    //     'userId' => 1,
    // ];
}
