<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notify extends Model
{
    protected $fillable = ['email','createdon','updateon','product_id'];
    public $timestamps = false;

     public function getproductname()
    {
        return \App\Models\Product::where('product_id','=',$this->id)->with(['product'])->whereHas('product', function($query) {
                    $query->where('status', '=', 1);
                 })->count();
    }
}
