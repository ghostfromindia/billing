<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class exchange extends Model
{
	  use SoftDeletes;
	protected $dates = ['deleted_at'];
    protected $table = 'exchange';
    public function product(){
    	return $this->hasOne('App\product', 'code', 'code');
    }
}
