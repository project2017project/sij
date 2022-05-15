<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use App\Models\ManageShipping;
use Datatables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Validator;

class ManageShippingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    
    //*** GET Request
    public function index()
    {
		
		$manageshippings = ManageShipping::orderBy('id')->get();
        return view('admin.manageshipping.index',compact('manageshippings'));        
    }

    //*** POST Request
    public function update(Request $request)
    {
		//$sign = Currency::where('is_default','=',1)->first();
		$count = $request->sh_tot;
		for($i=0;$i<=$count-1;$i++){			
			//$shiping_rate = (request->sh_rate[$i] / $sign->value);			
                ManageShipping::where('id',$request->sh_id[$i])->update(['shiping_value' => $request->sh_value[$i],'shiping_rate' => $request->sh_rate[$i]]);
       }             

        //--- Redirect Section     
        $msg = 'Data Updated Successfully.';
        return response()->json($msg);      
        //--- Redirect Section Ends            
    }
}
