<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
    public function category()
    {
        return $this->belongsTo('App\Category', 'cat_id');
    }

    public function orders()
    {
        return $this->hasMany('App\Order', 'service_id');
    }

    public function votes()
    {
        return $this->hasMany('App\Vote', 'service_id');
    }

    public function views()
    {
        return $this->hasMany('App\View', 'service_id');
    }

    public function wishlist()
    {
        return $this->hasMany('App\Wishlist', 'service_id');
    }


}
