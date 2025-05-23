<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $table = 'notification';
    protected $primaryKey = 'notif_id';
    protected $fillable = [
        'notif_type',
        'notif_message',
        'notif_is_read',
        'notif_sender_id',
        'notif_receiver_id',
        'prop_id',
        'created_at',
    ];
    public function property(){
        return $this->belongsTo(Property::class,'prop_id');
    }
    public function sender()
    {
        return $this->belongsTo(User::class, 'notif_sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'notif_receiver_id');
    }
}
