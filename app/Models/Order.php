<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{

    protected $table = 'orders';
    public $timestamps = true;

    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = array('client_id','address', 'restaurant_id','payment_type_id', 'total', 'price', 'net', 'cost' ,  'delivery_fees', 'commission', 'notes', 'state');

    public function restaurant()
    {
        return $this->belongsTo('App\Models\Restaurant');
    }

    public function client()
    {
        return $this->belongsTo('App\Models\Client' , 'client_id');
    }

    public function products()
    {
        return $this->belongsToMany('App\Models\Product')->withPivot('qty', 'price', 'notes');
    }
    public function payments_types()
    {
        return $this->hasMany(PaymentTypes::class);
    }



}
