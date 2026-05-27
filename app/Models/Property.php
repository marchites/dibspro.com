<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    //
    protected $fillable = [
        'title',
        'slug',
        'price',
        'location',
        'city',
        'type',
        'listing_type',
        'bedroom',
        'bathroom',
        'land_size',
        'building_size',
        'phone',
        'description',
        'address',
        'latitude',
        'longitude',
        'is_featured'
    ];

    public function images()
    {
        return $this->hasMany(PropertyImage::class);
    }
}
