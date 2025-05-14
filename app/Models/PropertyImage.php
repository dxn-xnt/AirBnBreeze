<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyImage extends Model
{
    use HasFactory;

    protected $table = 'property_images';

    protected $fillable = [
        'prop_id',
        'img_url',
    ];

    // Define relationship to Property
    public function property()
    {
        return $this->belongsTo(Property::class, 'prop_id');
    }
}
