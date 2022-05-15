<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dispute extends Model
{
	protected $fillable = ['vid','vendor_id','user_id','order_id','product_id','product_name','product_sku','status'];
}
