<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = ['id','updated_at'];

    public function admin(){
        return $this->belongsTo('App\Admin');
    }

    public function orders(){
        return $this->belongsToMany(Order::class,'orders_products')->withPivot(['qty','price','rmk']);
    }
}
