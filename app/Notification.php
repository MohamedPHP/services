<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    public function getSender()
    {
        return $this->belongsTo('App\User', 'user_notify_you');
    }

    public function getReceiver()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}
