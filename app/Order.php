<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public function comments()
    {
        return $this->hasMany('App\Comment', 'order_id');
    }

    public function service()
    {
        return $this->belongsTo('App\Service', 'service_id');
    }

    public function userOrders()
    { // اوردرات المستخدم الي بيعملها
        return $this->belongsTo('App\User', 'user_order');
    }

    public function getServiceOwner()
    { // صاحب الخدمة 
        return $this->belongsTo('App\User', 'user_id');
    }


}
