<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function services()
    {
        return $this->hasMany('App\Service', 'user_id');
    }

    public function myOrders()
    { // اوردرات المستخدم
        return $this->hasMany('App\Order', 'user_order');
    }

    public function getMyServiceOrder()
    { // الاوردرات الي حدثت لخدماتي
        return $this->hasMany('App\Order', 'user_id');
    }

    public function sendedMessages()
    {
        return $this->hasMany('App\Message', 'user_message_you');
    }

    public function receivedMessages()
    {
        return $this->hasMany('App\Message', 'user_id');
    }

    public function sendedNotifications()
    {
        return $this->hasMany('App\Notification', 'user_notify_you');
    }

    public function receivedNotification()
    {
        return $this->hasMany('App\Notification', 'user_id');
    }

    public function votes()
    {
        return $this->hasMany('App\Vote', 'user_id');
    }

}
