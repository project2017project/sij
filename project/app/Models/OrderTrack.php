<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderTrack extends Model
{
    //

	protected $fillable = ['order_id', 'title','text','companyname','vendor_id','vid','pid'];

    public function order()
    {
        return $this->belongsTo('App\Models\Order','order_id')->withDefault(function ($data) {
			foreach($data->getFillable() as $dt){
				$data[$dt] = __('Deleted');
			}
		});
    }
    public function userName(){
    	 return $this->belongsTo('App\Models\User','vendor_id','id');
 	}
    public function cartDetails(){


        return $this->belongsTo('App\Models\Order','order_id','id')->withDefault(function ($data) {
            foreach($data->getFillable() as $dt){
                $data[$dt] = $dt;
            }
        });

    }


}
