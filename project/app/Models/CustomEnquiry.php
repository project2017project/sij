<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomEnquiry extends Model
{
	protected $table = 'custom_enquiry';
	protected $fillable = ['name','phonenumber','email','address','metal','productCategory','hueofmetal','gemstonepreference','tentativebudget','datadealing','hueofmetal','linkoftheitem'];
	public $timestamps = false;
    public function insert()
    {
        return $this->belongsTo('App\Models\CustomEnquiry')->withDefault(function ($data) {
			foreach($data->getFillable() as $dt){
				$data[$dt] = __('Deleted');
			}
		});
    }

     public function enquirygalleries()
    {
        return $this->hasMany('App\Models\enquirygallery');
    }
    
}
