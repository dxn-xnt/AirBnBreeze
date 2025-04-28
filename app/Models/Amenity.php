<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Amenity extends Model
{
    protected $table = 'amenity';
    protected $primaryKey = 'amn_id';
    protected $fillable = [
        'amn_name'
    ];
    public $timestamps = false;
}
