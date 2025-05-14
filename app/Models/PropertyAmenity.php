<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyAmenity extends Model
{
    use HasFactory;

    protected $table = 'property_amenities';

    protected $fillable = [
        'prop_id',
        'amn_id'
    ];

    // Define relationship to Property
    public function property()
    {
        return $this->belongsTo(Property::class, 'prop_id');
    }
}
