<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = ['code', 'type', 'price','gift_voucher','email_address', 'times', 'start_date','end_date','user_used_count','order_id','cart_total_limit'];
    public $timestamps = false;
}
