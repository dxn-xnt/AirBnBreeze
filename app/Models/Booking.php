<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $table = 'booking';
    protected $primaryKey = 'book_id';
    protected $fillable = [
        'book_check_in',
        'book_check_out',
        'book_total_price',
        'book_status',
        'book_date_created',
        'book_notes',
        'book_adult_count',
        'book_child_count',
        'prop_id',
        'user_guest_id'
    ];
    public function property(){
        return $this->belongsTo(Property::class,'prop_id');
    }
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
}
