<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $table = 'review';
    protected $primaryKey = 'book_id';
    protected $fillable = [
        'rev_rate',
        'rev_comment',
        'rev_date_created'
    ];
    public function booking(){
        return $this->belongsTo(Booking::class,'book_id');
    }
}
