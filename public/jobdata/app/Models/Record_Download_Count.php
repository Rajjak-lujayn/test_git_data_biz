<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Record_Download_Count extends Model
{
    use HasFactory;

    protected $table = 'record_download_count';

    protected $fillable = [
        'user_email',
        'today_count',
        'month_count',
        'all_time_count',
    ];
}
