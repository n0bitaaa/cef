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

    public function products(){
        return $this->belongsToMany(Product::class,'orders_products')->withPivot(['qty','price','rmk']);
    }
}
