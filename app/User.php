<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable;

class User extends Model implements Authenticatable
{
    use \Illuminate\Auth\Authenticatable;

    public function providers()
    {
    	return $this->hasMany('App\Provider');
    }
    public function products()
    {
    	return $this->hasMany('App\Product');
    }

    public function payment()
    {
    	return $this->hasOne('App\Payment');
    }
    public function purchases()
    {
        return $this->hasMany('App\Purchase');
    }    
}
