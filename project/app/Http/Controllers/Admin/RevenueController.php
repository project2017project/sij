<?php

namespace App\Http\Controllers\Admin;

use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use InvalidArgumentException;
use Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\Order;
use App\Models\VendorOrder;
use App\Models\Blog;
use App\Models\User;
use App\Models\Product;
use App\Models\Counter;

class RevenueController extends Controller
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
			
		$allorders =  Order::where('status','!=','pending')->where('status','!=','declined')->whereBetween('created_at',[$startdate,$enddate])->count();        
        $pay_amount =  Order::where('status','!=','pending')->where('status','!=','declined')->whereBetween('created_at',[$startdate,$enddate])->sum('pay_amount');
		$shipping_cost =  Order::where('status','!=','pending')->where('status','!=','declined')->whereBetween('created_at',[$startdate,$enddate])->sum('shipping_cost');
		$admin_fee =  Order::where('status','!=','pending')->where('status','!=','declined')->whereBetween('created_at',[$startdate,$enddate])->sum('admin_fee');
		$refund_fee =  VendorOrder::where('status','=','completed')->whereBetween('created_at',[$startdate,$enddate])->sum('product_item_price');
		
		$pending_orders =  Order::where('status','=','pending')->whereBetween('created_at',[$startdate,$enddate])->count();        
        $pending_amount =  Order::where('status','=','pending')->whereBetween('created_at',[$startdate,$enddate])->sum('pay_amount');
		
		$processing_orders =  Order::where('status','=','processing')->whereBetween('created_at',[$startdate,$enddate])->count();        
        $processing_amount =  Order::where('status','=','processing')->whereBetween('created_at',[$startdate,$enddate])->sum('pay_amount');
		
		$declined_orders =  Order::where('status','=','declined')->whereBetween('created_at',[$startdate,$enddate])->count();        
        $declined_amount =  Order::where('status','=','declined')->whereBetween('created_at',[$startdate,$enddate])->sum('pay_amount');
		
		$od_orders =  Order::where('status','=','on delivery')->whereBetween('created_at',[$startdate,$enddate])->count();        
        $od_amount =  Order::where('status','=','on delivery')->whereBetween('created_at',[$startdate,$enddate])->sum('pay_amount');
		
		$completed_orders =  Order::where('status','=','completed')->whereBetween('created_at',[$startdate,$enddate])->count();        
        $completed_amount =  Order::where('status','=','completed')->whereBetween('created_at',[$startdate,$enddate])->sum('pay_amount');
		
		$all_orders =  Order::where('status','!=','pending')->where('status','!=','declined')->whereBetween('created_at',[$startdate,$enddate])->orderBy('id','desc')->get();
              
		}else{
			
		$allorders =  Order::where('status','!=','pending')->where('status','!=','declined')->whereRaw("find_in_set($vendor_id , vendor_id_list)")->whereBetween('created_at',[$startdate,$enddate])->count();        
        $pay_amount =  Order::where('status','!=','pending')->where('status','!=','declined')->whereRaw("find_in_set($vendor_id , vendor_id_list)")->whereBetween('created_at',[$startdate,$enddate])->sum('pay_amount');
		//$shipping_cost =  Order::where('status','!=','pending')->where('status','!=','declined')->whereRaw("find_in_set($vendor_id , vendor_id_list)")->whereBetween('created_at',[$startdate,$enddate])->sum('shipping_cost');
		$shipping_cost =0;
		$admin_fee =  Order::where('status','!=','pending')->where('status','!=','declined')->whereRaw("find_in_set($vendor_id , vendor_id_list)")->whereBetween('created_at',[$startdate,$enddate])->sum('admin_fee');
		$refund_fee =  VendorOrder::where('status','=','completed')->where('user_id','=',$vendor_id)->whereBetween('created_at',[$startdate,$enddate])->sum('product_item_price');
		
		$pending_orders =  Order::whereRaw("find_in_set($vendor_id , vendor_id_list)")->where('status','=','pending')->whereBetween('created_at',[$startdate,$enddate])->count();        
        $pending_amount =  Order::whereRaw("find_in_set($vendor_id , vendor_id_list)")->where('status','=','pending')->whereBetween('created_at',[$startdate,$enddate])->sum('pay_amount');
		
		$processing_orders =  Order::whereRaw("find_in_set($vendor_id , vendor_id_list)")->where('status','=','processing')->whereBetween('created_at',[$startdate,$enddate])->count();        
        $processing_amount =  Order::whereRaw("find_in_set($vendor_id , vendor_id_list)")->where('status','=','processing')->whereBetween('created_at',[$startdate,$enddate])->sum('pay_amount');
		
		$declined_orders =  Order::whereRaw("find_in_set($vendor_id , vendor_id_list)")->where('status','=','declined')->whereBetween('created_at',[$startdate,$enddate])->count();        
        $declined_amount =  Order::whereRaw("find_in_set($vendor_id , vendor_id_list)")->where('status','=','declined')->whereBetween('created_at',[$startdate,$enddate])->sum('pay_amount');
		
		$od_orders =  Order::whereRaw("find_in_set($vendor_id , vendor_id_list)")->where('status','=','on delivery')->whereBetween('created_at',[$startdate,$enddate])->count();        
        $od_amount =  Order::whereRaw("find_in_set($vendor_id , vendor_id_list)")->where('status','=','on delivery')->whereBetween('created_at',[$startdate,$enddate])->sum('pay_amount');
		
		$completed_orders =  Order::whereRaw("find_in_set($vendor_id , vendor_id_list)")->where('status','=','completed')->whereBetween('created_at',[$startdate,$enddate])->count();        
        $completed_amount =  Order::whereRaw("find_in_set($vendor_id , vendor_id_list)")->where('status','=','completed')->whereBetween('created_at',[$startdate,$enddate])->sum('pay_amount');
		
		$all_orders =  Order::where('status','!=','pending')->where('status','!=','declined')->whereRaw("find_in_set($vendor_id , vendor_id_list)")->whereBetween('created_at',[$startdate,$enddate])->orderBy('id','desc')->get();
        	
		}
		
		
		return view('admin.revenue',compact('users','days_between','vendor_id','activation_notify','allorders','pay_amount','shipping_cost','admin_fee','refund_fee','pending_orders','pending_amount','processing_orders','processing_amount','declined_orders','declined_amount','od_orders','od_amount','completed_orders','completed_amount','startdate','enddate','all_orders'));
    }   
	  
}
