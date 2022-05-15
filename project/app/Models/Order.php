<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
	protected $fillable = ['customer_state','shipping_state','user_id', 'cart', 'method','shipping', 'pickup_location', 'totalQty', 'pay_amount', 'txnid', 'charge_id', 'order_number', 'payment_status', 'customer_email', 'customer_name', 'customer_phone', 'customer_address', 'customer_city', 'customer_zip','customer_landmark','shipping_name', 'shipping_email', 'shipping_phone', 'shipping_address', 'shipping_city', 'shipping_zip','shipping_landmark','od_card_type','od_card_name', 'order_note', 'status'];

    public function vendororders()
    {
        return $this->hasMany('App\Models\VendorOrder');
    }

    public function tracks()
    {
        return $this->hasMany('App\Models\OrderTrack','order_id');
    }

}
