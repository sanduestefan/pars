<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $guarded = ['id'];

    public function users()
    {
        return $this->belongsToMany('App\User', 'user_item')
//            ->withPivot('user_item')
            ->withTimestamps();
    }
}
