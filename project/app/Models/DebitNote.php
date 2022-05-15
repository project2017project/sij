<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DebitNote extends Model
{
	protected $fillable = ['vid','vendor_id','order_id','product_id','product_name','product_sku','amount','adminfee','sgst','cgst','igst','tcs','amt_before_tax','others_amt','remarks','quantity','reason','screen_shot','document','status','withdraw_id','is_payment'];
}
