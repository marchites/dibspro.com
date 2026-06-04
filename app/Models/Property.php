<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\PropertyView;
use App\Models\PropertyClick;

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

    public function views()
    {
        return $this->hasMany(PropertyView::class);
    }

    public function clicks()
    {
        return $this->hasMany(PropertyClick::class);
    }
}
