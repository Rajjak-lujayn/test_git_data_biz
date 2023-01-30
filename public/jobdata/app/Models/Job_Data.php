<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job_Data extends Model
{
    use HasFactory;
    protected $table = 'job_data';

     /**
     * @param  array                                          $columns
     * @param  \Illuminate\Contracts\Support\Arrayable|array  $values
     *
     * @return \Illuminate\Database\Query\Builder
     */
    public static function whereInMultiple(array $columns, $values)
    {
        $values = array_map(function (array $value) {
            return "('".implode($value, "', '")."')"; 
        }, $values);

        return static::query()->whereRaw(
            '('.implode($columns, ', ').') in ('.implode($values, ', ').')'
        );
    }
}
