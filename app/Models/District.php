<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class District extends Model
{



    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = array('name', 'city_id');

    public function clients()
    {
        return $this->hasMany('App\Models\Client');
    }

    public function city()
    {
        return $this->belongsTo('App\Models\City');
    }

    public function restaurants()
    {
        return $this->hasMany('App\Models\Restaurant');
    }

}
