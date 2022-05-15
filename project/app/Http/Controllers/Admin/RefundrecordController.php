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

class RefundrecordController extends Controller
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
			
		$allorders =  VendorOrder::where('status','!=','pending')->where('status','!=','declined')->where('product_item_price','!=','')->whereBetween('created_at',[$startdate,$enddate])->distinct()->count('order_id');        
        $pay_amount =  VendorOrder::where('status','!=','pending')->where('status','!=','declined')->where('product_item_price','!=','')->whereBetween('created_at',[$startdate,$enddate])->sum('price');		
		$refund_fee =  VendorOrder::where('status','=','completed')->where('product_item_price','!=','')->whereBetween('created_at',[$startdate,$enddate])->sum('product_item_price');
		
		$pending_orders =  VendorOrder::where('status','=','pending')->where('product_item_price','!=','')->whereBetween('created_at',[$startdate,$enddate])->distinct()->count('order_id');        
        $pending_amount =  VendorOrder::where('status','=','pending')->where('product_item_price','!=','')->whereBetween('created_at',[$startdate,$enddate])->sum('price');
		
		$processing_orders =  VendorOrder::where('status','=','processing')->where('product_item_price','!=','')->whereBetween('created_at',[$startdate,$enddate])->distinct()->count('order_id');        
        $processing_amount =  VendorOrder::where('status','=','processing')->where('product_item_price','!=','')->whereBetween('created_at',[$startdate,$enddate])->sum('price');
		
		$declined_orders =  VendorOrder::where('status','=','declined')->where('product_item_price','!=','')->whereBetween('created_at',[$startdate,$enddate])->distinct()->count('order_id');        
        $declined_amount =  VendorOrder::where('status','=','declined')->where('product_item_price','!=','')->whereBetween('created_at',[$startdate,$enddate])->sum('price');
		
		$od_orders =  VendorOrder::where('status','=','on delivery')->where('product_item_price','!=','')->whereBetween('created_at',[$startdate,$enddate])->distinct()->count('order_id');       
        $od_amount =  VendorOrder::where('status','=','on delivery')->where('product_item_price','!=','')->whereBetween('created_at',[$startdate,$enddate])->sum('price');
		
		$completed_orders =  VendorOrder::where('status','=','completed')->where('product_item_price','!=','')->whereBetween('created_at',[$startdate,$enddate])->distinct()->count('order_id');        
        $completed_amount =  VendorOrder::where('status','=','completed')->where('product_item_price','!=','')->whereBetween('created_at',[$startdate,$enddate])->sum('price');
        
        $all_orders =  VendorOrder::where('status','!=','pending')->where('status','!=','declined')->where('product_item_price','!=','')->whereBetween('created_at',[$startdate,$enddate])->orderBy('id','desc')->get();        		
				
			 
		}else{
			
		$allorders =  VendorOrder::where('status','=','completed')->where('user_id','=',$vendor_id)->where('product_item_price','!=','')->whereBetween('created_at',[$startdate,$enddate])->distinct()->count('order_id');        
        $pay_amount =  VendorOrder::where('status','=','completed')->where('user_id','=',$vendor_id)->where('product_item_price','!=','')->whereBetween('created_at',[$startdate,$enddate])->sum('price');
		$refund_fee =  VendorOrder::where('status','=','completed')->where('user_id','=',$vendor_id)->where('product_item_price','!=','')->whereBetween('created_at',[$startdate,$enddate])->sum('product_item_price');
		
		$pending_orders =  VendorOrder::where('user_id','=',$vendor_id)->where('status','=','pending')->where('product_item_price','!=','')->whereBetween('created_at',[$startdate,$enddate])->distinct()->count('order_id');        
        $pending_amount =  VendorOrder::where('user_id','=',$vendor_id)->where('status','=','pending')->where('product_item_price','!=','')->whereBetween('created_at',[$startdate,$enddate])->sum('price');
		
		$processing_orders =  VendorOrder::where('user_id','=',$vendor_id)->where('status','=','processing')->where('product_item_price','!=','')->whereBetween('created_at',[$startdate,$enddate])->distinct()->count('order_id');        
        $processing_amount =  VendorOrder::where('user_id','=',$vendor_id)->where('status','=','processing')->where('product_item_price','!=','')->whereBetween('created_at',[$startdate,$enddate])->sum('price');
		
		$declined_orders =  VendorOrder::where('user_id','=',$vendor_id)->where('status','=','declined')->where('product_item_price','!=','')->whereBetween('created_at',[$startdate,$enddate])->distinct()->count('order_id');        
        $declined_amount =  VendorOrder::where('user_id','=',$vendor_id)->where('status','=','declined')->where('product_item_price','!=','')->whereBetween('created_at',[$startdate,$enddate])->sum('price');
		
		$od_orders =  VendorOrder::where('user_id','=',$vendor_id)->where('status','=','on delivery')->where('product_item_price','!=','')->whereBetween('created_at',[$startdate,$enddate])->distinct()->count('order_id');        
        $od_amount =  VendorOrder::where('user_id','=',$vendor_id)->where('status','=','on delivery')->where('product_item_price','!=','')->whereBetween('created_at',[$startdate,$enddate])->sum('price');
		
		$completed_orders =  VendorOrder::where('user_id','=',$vendor_id)->where('status','=','completed')->where('product_item_price','!=','')->whereBetween('created_at',[$startdate,$enddate])->distinct()->count('order_id');        
        $completed_amount =  VendorOrder::where('user_id','=',$vendor_id)->where('status','=','completed')->where('product_item_price','!=','')->whereBetween('created_at',[$startdate,$enddate])->sum('price');
        	
	    $all_orders =  VendorOrder::where('user_id','=',$vendor_id)->where('status','!=','pending')->where('status','!=','declined')->where('product_item_price','!=','')->whereBetween('created_at',[$startdate,$enddate])->orderBy('id','desc')->get();        		
		}
		
		
		return view('admin.refundrecord',compact('users','days_between','vendor_id','activation_notify','allorders','pay_amount','refund_fee','pending_orders','pending_amount','processing_orders','processing_amount','declined_orders','declined_amount','od_orders','od_amount','completed_orders','completed_amount','startdate','enddate','all_orders'));
    }   
}
