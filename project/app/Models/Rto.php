<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rto extends Model
{
	protected $fillable = ['vid','vendor_id','user_id','order_id','product_id','product_name','product_sku','amount','quantity','type','reason','courier_partner','tracking_code','tracking_url','screen_shot','status'];
}
