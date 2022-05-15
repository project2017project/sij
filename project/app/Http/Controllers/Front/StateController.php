<?php

namespace App\Http\Controllers\Front;

use Datatables;
use App\Models\Country;
use App\Models\State;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Validator;

class StateController extends Controller
{
    public function load($id)
    {
        $cat = State::where('country_id',$id)->get();
        return view('load.state',compact('cat'));
    }

   
}
