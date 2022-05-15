<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    protected $fillable = ['country_id','name'];
    public $timestamps = false;

    
    public function country()
    {
    	return $this->belongsTo('App\Models\Country')->withDefault(function ($data) {
			foreach($data->getFillable() as $dt){
				$data[$dt] = __('Deleted');
			}
		});
    }


}
