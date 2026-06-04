<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PropertyClick extends Model
{
    //
     protected $fillable = [
        'property_id',
        'type',
        'ip_address'
    ];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}
