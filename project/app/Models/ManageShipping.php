<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ManageShipping extends Model
{
    protected $fillable = ['shiping_value', 'shiping_rate'];

    public $timestamps = false;

}