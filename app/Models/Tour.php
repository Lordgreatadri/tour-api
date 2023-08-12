<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tour extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'trave_id',
        'name',
        'starting_date',
        'ending_date',
        'price'
    ];

    // create attibute for the price as to store integer value in db and format and return float to the frontend
    public function price() : Attributes 
    {
        return Attributes::make(
            get: fn ($value) => $value / 100,
            set: fn ($value) => $value * 100
        );
    }
}
