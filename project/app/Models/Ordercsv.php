<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ordercsv extends Model
{

    public static function countOrder($id)
    {
        return Ordercsv::where('id','=',$id)->get()->count();
    }

}
