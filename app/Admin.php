<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $guarded = ['id','updated_at'];

    public function products(){
        return $this->hasMany('App\Product');
    }

    public function orders(){
        return $this->hasMany('App\Order');
    }

    public function users(){
        return $this->hasMany('App\User');
    }
}
