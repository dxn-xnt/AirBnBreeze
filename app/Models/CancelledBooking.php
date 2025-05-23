<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CancelledBooking extends Model
{
    protected $table = 'cancelled_booking';
    protected $primaryKey = 'book_id';
    protected $fillable = [
        'cancel_reason',
        'cancel_by_user',
    ];

    public $timestamps = false;

    public function booking()
    {
        return $this->belongsTo(Booking::class, 'book_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'cancel_by_user');
    }
}
