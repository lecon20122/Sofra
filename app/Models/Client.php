<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;




class Client extends Authenticatable
{
    use Notifiable;

    protected $table = 'clients';
    public $timestamps = true;

    protected $dates = ['deleted_at'];
    protected $fillable = array('name', 'pin_code', 'email', 'password', 'phone', 'address', 'district_id');

    public function district()
    {
        return $this->belongsTo('App\Models\District');
    }

    public function orders()
    {
        return $this->hasMany('App\Models\Order');
    }

    public function notification()
    {
        return $this->morphMany('App\Models\Notification', 'notificationable');
    }
    public function tokens()
    {
        return $this->morphMany('App\Models\Token', 'notificationable');
    }

    public function reviews()
    {
        return $this->hasMany('App\Models\Review');
    }


    //Mutator for the Password - Hashing the password
    public function setPasswordAttribute($pass)
    {
        $this->attributes['password'] = Hash::make($pass);
    }
    public function getAuthPassword()
    {
        return $this->password;
    }

    /**
     * Get all of the tags for the post.
     */
    public function notifications()
    {
        return $this->morphToMany(Notification::class, 'taggable');
    }

}
