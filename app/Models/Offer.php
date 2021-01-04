<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{

    protected $table = 'offers';
    public $timestamps = false;
    protected $fillable = array('name', 'short_describtion', 'image', 'start_date', 'end_date');
    protected $casts = [
        'start_date' => 'datetime:Y-m-d',
        'end_date' => 'datetime:Y-m-d',
    ];

    public function restaurant()
    {
        return $this->belongsTo('App\Models\Restaurant');
    }

}
