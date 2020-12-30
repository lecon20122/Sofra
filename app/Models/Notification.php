<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{

    protected $table = 'notifications';
    public $timestamps = true;
    protected $fillable = array('title', 'notificationable_id', 'notificationable_type');

      /**
     * Get all of the posts that are assigned this tag.
     */
    public function notificationable()
    {
        return $this->morphTo();
    }


}
