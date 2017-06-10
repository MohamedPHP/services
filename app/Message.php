<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    public function getSender()
    {
        return $this->belongsTo('App\User', 'user_message_you');
    }

    public function getReceiver()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

}
