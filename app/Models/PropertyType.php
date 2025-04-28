<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PropertyType extends Model
{
    protected $table = 'property_type';
    protected $primaryKey = 'prop_id';
    protected $fillable = [
        'type_id'
    ];
    public function property(){
        return $this->belongsTo(Property::class,'prop_id');
    }
    public function type(){
        return $this->belongsTo(Type::class,'type_id');
    }
    public $timestamps = false;
}
