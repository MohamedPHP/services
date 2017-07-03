<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    protected $table = 'wishlist';

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function owner()
    {
        return $this->belongsTo('App\User', 'own_user');
    }

    public function service()
    {
        return $this->belongsTo('App\Service', 'service_id');
    }
}
