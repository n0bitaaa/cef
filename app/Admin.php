<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Cache;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use Notifiable;
    
    protected $guarded = 'admin';

    protected $fillable = ['name','code','password'];

    public function products(){
        return $this->hasMany('App\Product');
    }

    public function orders(){
        return $this->hasMany('App\Order');
    }

    public function users(){
        return $this->hasMany('App\User');
    }

    public function isOnline(){
        return Cache::has('admin-is-online-'.$this->id);
    }
}
