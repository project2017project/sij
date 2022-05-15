<?php

namespace App\Http\Controllers\Admin;

use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use InvalidArgumentException;
use Validator;
use DB;
use PDF;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;
use App\Models\Order;
use App\Models\VendorOrder;
use App\Models\Blog;
use App\Models\User;
use App\Models\Product;
use App\Models\Counter;

class AnalticController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:admin');
    }
   
   public function record(Request $request)
    {
		$email=env('ADMIN_EMAIL');		 
        $admindata = Admin::where('email',$email)->first();						 
	    $users = User::all()->where('is_vendor','2');
		if($request->vendor){
			$vendor_id =  $request->vendor;
			$user = User::findOrFail($vendor_id);
		}else{
			$vendor_id =  '';
			$user = User::all()->where('is_vendor','2');
		}
		
		
        $startdate =  $request->startdate;
        $enddate = $request->enddate;
		$enddate =date('Y-m-d', strtotime("+1 day", strtotime($enddate)));
        $start = strtotime($startdate);
        $end = strtotime($enddate);        
        $days_between = ceil(abs($end - $start) / 86400); 
		
        $activation_notify = '';		
		if($vendor_id==''){
		$all_orders =  VendorOrder::where('status','!=','pending')->where('status','!=','declined')->whereBetween('created_at',[$startdate,$enddate])->orderBy('id','desc')->get();				
		$pay_amount =  VendorOrder::where('status','!=','pending')->where('status','!=','declined')->whereBetween('created_at',[$startdate,$enddate])->sum('price');		
		$refund_fee =  VendorOrder::where('status','=','completed')->whereBetween('created_at',[$startdate,$enddate])->sum('product_item_price');
        $admin_fee =  Order::where('status','!=','pending')->where('status','!=','declined')->whereBetween('created_at',[$startdate,$enddate])->sum('admin_fee');		
              
		} else {	
        $all_orders = VendorOrder::where('status','!=','pending')->where('status','!=','declined')->where('user_id','=',$vendor_id)->whereBetween('created_at',[$startdate,$enddate])->orderBy('id','desc')->get();		
		$pay_amount = VendorOrder::where('status','!=','pending')->where('status','!=','declined')->where('user_id','=',$vendor_id)->whereBetween('created_at',[$startdate,$enddate])->sum('price');
		$refund_fee = VendorOrder::where('status','=','completed')->where('user_id','=',$vendor_id)->whereBetween('created_at',[$startdate,$enddate])->sum('product_item_price');
		$admin_fee =  Order::where('status','!=','pending')->where('status','!=','declined')->whereBetween('created_at',[$startdate,$enddate])->sum('admin_fee');
		
		}		
		
		return view('admin.analtic',compact('vendor_id','activation_notify','days_between','all_orders','pay_amount', 'refund_fee', 'admin_fee','admindata','user','users','startdate','enddate'));		
    } 


 public function reports(Request $request)
    {
			
        $email=env('ADMIN_EMAIL');		 
        $admindata = Admin::where('email',$email)->first();			
	   
		if($request->vendor){
			$vendor_id =  $request->vendor;
		}else{
			$vendor_id =  '';
		}
		
		
		
        $startdate =  $request->startdate;
        $enddate = $request->enddate;
        $start = strtotime($startdate);
        $end = strtotime($enddate);        
        $days_between = ceil(abs($end - $start) / 86400); 
		
        $activation_notify = '';		
		if($vendor_id==''){
		    $startdate =  $request->startdate;
        $enddate = $request->enddate;
		$user = User::all()->where('is_vendor','2');			
		$pay_amount =  VendorOrder::where('status','!=','pending')->where('status','!=','declined')->whereBetween('created_at',[$startdate,$enddate])->sum('price');		
		$refund_fee =  VendorOrder::where('status','=','completed')->whereBetween('created_at',[$startdate,$enddate])->sum('product_item_price');
        $admin_fee =  Order::where('status','!=','pending')->where('status','!=','declined')->whereBetween('created_at',[$startdate,$enddate])->sum('admin_fee');		
              
		} else {
		    $startdate =  $request->startdate;
        $enddate = $request->enddate;
         $user = User::findOrFail($vendor_id);		
		$pay_amount = VendorOrder::where('status','!=','pending')->where('status','!=','declined')->where('user_id','=',$vendor_id)->whereBetween('created_at',[$startdate,$enddate])->sum('price');
		$refund_fee = VendorOrder::where('status','=','completed')->where('user_id','=',$vendor_id)->whereBetween('created_at',[$startdate,$enddate])->sum('product_item_price');
		$admin_fee =  Order::where('status','!=','pending')->where('status','!=','declined')->whereBetween('created_at',[$startdate,$enddate])->sum('admin_fee');
		
		}
		$fileName = 'commissionreport_'.$vendor_id.'.pdf';
        $pdf = PDF::loadView('admin.commisionreport', compact('pay_amount', 'refund_fee', 'admin_fee','admindata','user', 'startdate', 'enddate'))->save($fileName);
		
		return $pdf->stream($fileName);
    } 	
	
}
