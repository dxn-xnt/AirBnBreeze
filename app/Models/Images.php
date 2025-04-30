<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Images extends Model
{
    protected $table = 'property_images';
    protected $primaryKey = 'prop_id';
    protected $fillable = [
        'img_url',
    ];
    public function property(){
        return $this->belongsTo(Property::class,'prop_id');
    }
}
