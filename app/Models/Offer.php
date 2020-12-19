<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{

    protected $table = 'offers';
    public $timestamps = false;
    protected $fillable = array('name', 'short_describtion', 'image', 'start_date', 'end_date');

    public function restaurant()
    {
        return $this->belongsTo('App\Models\Restaurant');
    }

}
