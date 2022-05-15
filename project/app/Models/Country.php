<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $fillable = ['name','sortname','phonecode'];
    public $timestamps = false;

    public function state()
    {
    	return $this->hasMany('App\Models\State');
    }

}
