<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Refund extends Model
{
    protected $fillable = ['order_id', 'sold_by', 'amount', 'product_id', 'reason', 'adminMessage', 'statusare', 'created_at', 'updated_at', 'image', 'user_name', 'user_id'];
    public $timestamps = false;
    
    public function userrefund(){
    	 return $this->belongsTo('App\Models\User','sold_by','id');
 	}
}
