<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exchange extends Model
{
	protected $fillable = ['vid','vendor_id','user_id','order_id','product_id','product_name','product_sku','amount','quantity','reason','courier_partner','tracking_code','tracking_url','screen_shot','document','status'];
}
