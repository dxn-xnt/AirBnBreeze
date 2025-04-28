<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PropertyAmenity extends Model
{
    protected $table = 'property_amenity';
    protected $primaryKey = 'prop_id';
    protected $fillable = [
        'amn_id'
    ];
    public function amenity(){
        return $this->belongsTo(Amenity::class,'amn_id');
    }
    public $timestamps = false;
}
