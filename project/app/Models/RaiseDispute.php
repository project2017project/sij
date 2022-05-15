<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RaiseDispute extends Model
{
	protected $fillable = ['vid','vendor_id','user_id','order_id','product_id','product_name','product_sku','amount','quantity','reason','tracking_code','tracking_url','tracking_partner','screen_shot','document','status','refund_status'];
}
