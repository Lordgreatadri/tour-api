<?php

namespace App\Models;

use App\Models\Tour;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Casts\Attributes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use League\CommonMark\Extension\Attributes\Node\Attributes;

class Travel extends Model
{
    use HasFactory, Sluggable, HasUuids;

    protected $table = "travels";
    protected $fillable = [
        'is_public',
        'slug',
        'name',
        'description',
        'number_of_days'
    ];


    public function tours() : HasMany {
        return $this->hasMany(Tour::class);
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    public function numberOfNights() : Attributes {
        return Attributes::make(
            get: fn($value, $attributes) => $attributes['number_of_days'] - 1
        );
    }

    // or you man also use the below syntax istead
    public function getNumberOfNightsAttributes() {
        return $this->number_of_days - 1;
    }
}
