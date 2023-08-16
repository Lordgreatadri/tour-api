<?php

namespace App\Models\Unity;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyUpdate extends Model
{
    use HasFactory;

    protected $connection = 'mysql_fourth';

    public $table = "daily_updates"; 

    protected $guarded = [];
}
