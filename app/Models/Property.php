<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    protected $table = 'property';
    protected $primaryKey = 'prop_id';
    protected $fillable = [
        'prop_title',
        'prop_description',
        'prop_price_per_night',
        'prop_max_guest',
        'prop_room_count',
        'prop_bathroom_count',
        'prop_status',
        'prop_address',
        'prop_date_created',
        'user_host_id'
    ];
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
}
