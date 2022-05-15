<?php

namespace App\Http\Controllers\Admin;

use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use InvalidArgumentException;
use Validator;
use DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Order;
use App\Models\VendorOrder;
use App\Models\Blog;
use App\Models\User;
use App\Models\Product;
use App\Models\Counter;

class ProductrecordController extends Controller
{
 public function __construct()
    {
        $this->middleware('auth:admin');
    }
	
	public function record(Request $request)
    {
								 
	    $users = User::all()->where('is_vendor','2');
		if($request->vendor){
			$vendor_id =  $request->vendor;
		}else{
			$vendor_id =  '';
		}
		
        $startdate =  $request->startdate;
        $enddate = $request->enddate;
		$enddate =date('Y-m-d', strtotime("+1 day", strtotime($enddate)));
        $start = strtotime($startdate);
        $end = strtotime($enddate);        
        $days_between = ceil(abs($end - $start) / 86400); 
		
        $activation_notify = '';		
		if($vendor_id==''){
			$product_list =VendorOrder::select('product_id', DB::raw('SUM(qty) as count'), DB::raw('COUNT(order_id) as ordercount'), DB::raw('SUM(price) as prices'))
                        ->groupBy('product_id')
						->where('status','!=','pending')
						->where('status','!=','declined')
						->whereBetween('created_at',[$startdate,$enddate])
                        ->orderBy('count', 'desc')                         
                         ->get();			
		$allorders =  VendorOrder::where('status','!=','pending')->where('status','!=','declined')->whereBetween('created_at',[$startdate,$enddate])->distinct()->count('order_id');        
        $pay_amount =  VendorOrder::where('status','!=','pending')->where('status','!=','declined')->whereBetween('created_at',[$startdate,$enddate])->sum('price');		
		$refund_fee =  VendorOrder::where('status','=','completed')->whereBetween('created_at',[$startdate,$enddate])->sum('product_item_price');
        $totalQty =  VendorOrder::where('status','!=','pending')->where('status','!=','declined')->whereBetween('created_at',[$startdate,$enddate])->sum('qty');		
              
		} else {
			$product_list =VendorOrder::select('product_id', DB::raw('SUM(qty) as count'), DB::raw('COUNT(order_id) as ordercount'), DB::raw('SUM(price) as prices'))
			            ->where('user_id','=',$vendor_id) 
                        ->groupBy('product_id')
						->where('status','!=','pending')
						->where('status','!=','declined')
						->whereBetween('created_at',[$startdate,$enddate])
                        ->orderBy('count', 'desc')                         
                         ->get();	
		$allorders =  VendorOrder::where('status','!=','pending')->where('status','!=','declined')->where('user_id','=',$vendor_id)->whereBetween('created_at',[$startdate,$enddate])->distinct()->count('order_id');        
        $pay_amount = VendorOrder::where('status','!=','pending')->where('status','!=','declined')->where('user_id','=',$vendor_id)->whereBetween('created_at',[$startdate,$enddate])->sum('price');
		$refund_fee = VendorOrder::where('status','=','completed')->where('user_id','=',$vendor_id)->whereBetween('created_at',[$startdate,$enddate])->sum('product_item_price');
		$totalQty =   VendorOrder::where('status','!=','pending')->where('status','!=','declined')->where('user_id','=',$vendor_id)->whereBetween('created_at',[$startdate,$enddate])->sum('qty');
		
		}		
		
		return view('admin.productrecord',compact('product_list','users','days_between','vendor_id','activation_notify','allorders','pay_amount','totalQty','refund_fee','startdate','enddate'));
    } 	     

}
