<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;


    /**
     * user type manager
     */
    const USERTYPE_MANAGER = 'manager';
    const USERTYPE_ADMIN = 'admin';
    const USERTYPE_USER = 'user';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'full_name', 'email', 'password', 'usertype', 'manager'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'date:Y-m-d'
    ];



    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }


    public static function randManager()
    {
        return self::where('usertype', 'manager')->inRandomOrder()->first();
    }

    public function getClients()
    {
        return $this->where('manager', $this->id)->with(['orders.service.category'])->get();
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function activeOrders()
    {
        return $this->orders()->where('paid_status', 'active');
    }

    public function clients()
    {
        return $this->hasMany('App\User', 'manager');
    }

    public function manager()
    {
        return $this->belongsTo('App\User', 'manager');
    }
}
