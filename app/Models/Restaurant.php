<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class Restaurant extends Authenticatable
{

    protected $table = 'restaurants';
    public $timestamps = false;

    use SoftDeletes, Notifiable;

    protected $dates = ['deleted_at'];
    protected $fillable = array('name', 'pin_code', 'email', 'phone', 'password', 'image', 'is_active', 'district_id', 'category_id', 'min_order', 'delivery_fees', 'contact_phone', 'contact_whatsapp');

    public function district()
    {
        return $this->belongsTo('App\Models\District');
    }

    public function categories()
    {
        return $this->belongsToMany('App\Models\Category');
    }

    public function products()
    {
        return $this->hasMany('App\Models\Product');
    }

    public function orders()
    {
        return $this->hasMany('App\Models\Order');
    }

    public function notification()
    {
        return $this->morphMany('App\Models\Notification', 'notificationable');
    }

    public function payments()
    {
        return $this->hasMany('App\Models\Payment');
    }

    public function offers()
    {
        return $this->hasMany('App\Models\Offer');
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
    // //Mutator for the Api-tokken - Adding Api Token
    // public function setApiTokenAttribute($pass){

    //     $this->attributes['api_token'] = Str::random(60);

    // }

    public function getAuthPassword()
    {
        return $this->password;
    }
}
