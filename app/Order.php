<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = ['id','updated_at'];

    public function admin(){
        return $this->belongsTo('App\Admin');
    }

    public function user(){
        return $this->belongsTo('App\User');
    }
}
