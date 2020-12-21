<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{

    protected $table = 'products';
    public $timestamps = true;

    use SoftDeletes , HasFactory;

    protected $dates = ['deleted_at'];
    protected $fillable = array('name', 'short_describtion', 'image', 'price', 'offer', 'ready_in' , 'restaurant_id');

    public function restaurant()
    {
        return $this->belongsTo('App\Models\Restaurant');
    }

    public function orders()
    {
        return $this->belongsToMany('App\Models\Order');
    }

}
