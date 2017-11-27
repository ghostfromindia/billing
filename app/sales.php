<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class sales extends Model
{
	  use SoftDeletes;
    protected $table = 'sales';
    protected $dates = ['deleted_at'];    
    public function product(){
    	return $this->hasOne('App\product', 'code', 'code');
    }
}
