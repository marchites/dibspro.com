<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PropertyView extends Model
{
    //
     protected $fillable = [
        'property_id',
        'ip_address',
        'user_agent'
    ];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}
