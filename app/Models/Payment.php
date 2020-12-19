<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model 
{

    protected $table = 'payments';
    public $timestamps = true;

    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = array('restaurant_sales', 'price', 'reminder', 'restaurant_id', 'notes');

    public function restaurant()
    {
        return $this->belongsTo('App\Models\Restaurant');
    }

}