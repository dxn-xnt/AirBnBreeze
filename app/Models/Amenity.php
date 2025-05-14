<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Amenity extends Model
{
    protected $table = 'amenities';
    protected $primaryKey = 'amn_id';
    protected $fillable = [
        'amn_name',
        'amn_type',
        'amn_icon'
    ];
    public $timestamps = false;
}
