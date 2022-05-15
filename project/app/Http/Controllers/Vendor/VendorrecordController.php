<?php

namespace App\Http\Controllers\Vendor;

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

class VendorrecordController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
	public function record(Request $request)
    {
       
	    $user = Auth::user();
		$vendor_id = $user->id;
		
        $startdate =  $request->startdate;
        $enddate = $request->enddate;
        $enddate =date('Y-m-d', strtotime("+1 day", strtotime($enddate)));
        $start = strtotime($startdate);
        $end = strtotime($enddate);        
        $days_between = ceil(abs($end - $start) / 86400); 
		
        $activation_notify = '';		
			
		$allorders =  VendorOrder::where('status','!=','pending')->where('status','!=','declined')->where('user_id','=',$vendor_id)->whereBetween('created_at',[$startdate,$enddate])->distinct()->count('order_id');        
        $pay_amount =  VendorOrder::where('status','!=','pending')->where('status','!=','declined')->where('user_id','=',$vendor_id)->whereBetween('created_at',[$startdate,$enddate])->sum('price');
		$refund_fee =  VendorOrder::where('status','=','completed')->where('user_id','=',$vendor_id)->whereBetween('created_at',[$startdate,$enddate])->sum('product_item_price');
		
		$pending_orders =  VendorOrder::where('user_id','=',$vendor_id)->where('status','=','pending')->whereBetween('created_at',[$startdate,$enddate])->distinct()->count('order_id');        
        $pending_amount =  VendorOrder::where('user_id','=',$vendor_id)->where('status','=','pending')->whereBetween('created_at',[$startdate,$enddate])->sum('price');
		
		$processing_orders =  VendorOrder::where('user_id','=',$vendor_id)->where('status','=','processing')->whereBetween('created_at',[$startdate,$enddate])->distinct()->count('order_id');        
        $processing_amount =  VendorOrder::where('user_id','=',$vendor_id)->where('status','=','processing')->whereBetween('created_at',[$startdate,$enddate])->sum('price');
		
		$declined_orders =  VendorOrder::where('user_id','=',$vendor_id)->where('status','=','declined')->whereBetween('created_at',[$startdate,$enddate])->distinct()->count('order_id');        
        $declined_amount =  VendorOrder::where('user_id','=',$vendor_id)->where('status','=','declined')->whereBetween('created_at',[$startdate,$enddate])->sum('price');
		
		$od_orders =  VendorOrder::where('user_id','=',$vendor_id)->where('status','=','on delivery')->whereBetween('created_at',[$startdate,$enddate])->distinct()->count('order_id');        
        $od_amount =  VendorOrder::where('user_id','=',$vendor_id)->where('status','=','on delivery')->whereBetween('created_at',[$startdate,$enddate])->sum('price');
		
		$completed_orders =  VendorOrder::where('user_id','=',$vendor_id)->where('status','=','completed')->whereBetween('created_at',[$startdate,$enddate])->distinct()->count('order_id');        
        $completed_amount =  VendorOrder::where('user_id','=',$vendor_id)->where('status','=','completed')->whereBetween('created_at',[$startdate,$enddate])->sum('price');
        
		$all_orders = VendorOrder::where('status','!=','pending')->where('status','!=','declined')->where('user_id','=',$vendor_id)->whereBetween('created_at',[$startdate,$enddate])->orderBy('id','desc')->get();  		
			
		return view('vendor.vendorecord',compact('days_between','vendor_id','activation_notify','allorders','pay_amount','refund_fee','pending_orders','pending_amount','processing_orders','processing_amount','declined_orders','declined_amount','od_orders','od_amount','completed_orders','completed_amount','startdate','enddate','all_orders'));
    }  


public function exportreport($startdate,$enddate)
    {
       
	    $user = Auth::user();
		$vendor_id = $user->id;
		
        $startdate =  $startdate;        
		$enddates = $enddate;
		$enddate =date('Y-m-d', strtotime("+1 day", strtotime($enddate)));
        $start = strtotime($startdate);
        $end = strtotime($enddate);      
        $days_between = ceil(abs($end - $start) / 86400); 
		
        $activation_notify = '';		
			
		$allorders =  VendorOrder::where('status','!=','pending')->where('status','!=','declined')->where('user_id','=',$vendor_id)->whereBetween('created_at',[$startdate,$enddate])->distinct()->count('order_id');        
        $pay_amount =  VendorOrder::where('status','!=','pending')->where('status','!=','declined')->where('user_id','=',$vendor_id)->whereBetween('created_at',[$startdate,$enddate])->sum('price');
		$refund_fee =  VendorOrder::where('status','=','completed')->where('user_id','=',$vendor_id)->whereBetween('created_at',[$startdate,$enddate])->sum('product_item_price');
		
		$pending_orders =  VendorOrder::where('user_id','=',$vendor_id)->where('status','=','pending')->whereBetween('created_at',[$startdate,$enddate])->distinct()->count('order_id');        
        $pending_amount =  VendorOrder::where('user_id','=',$vendor_id)->where('status','=','pending')->whereBetween('created_at',[$startdate,$enddate])->sum('price');
		
		$processing_orders =  VendorOrder::where('user_id','=',$vendor_id)->where('status','=','processing')->whereBetween('created_at',[$startdate,$enddate])->distinct()->count('order_id');        
        $processing_amount =  VendorOrder::where('user_id','=',$vendor_id)->where('status','=','processing')->whereBetween('created_at',[$startdate,$enddate])->sum('price');
		
		$declined_orders =  VendorOrder::where('user_id','=',$vendor_id)->where('status','=','declined')->whereBetween('created_at',[$startdate,$enddate])->distinct()->count('order_id');        
        $declined_amount =  VendorOrder::where('user_id','=',$vendor_id)->where('status','=','declined')->whereBetween('created_at',[$startdate,$enddate])->sum('price');
		
		$od_orders =  VendorOrder::where('user_id','=',$vendor_id)->where('status','=','on delivery')->whereBetween('created_at',[$startdate,$enddate])->distinct()->count('order_id');        
        $od_amount =  VendorOrder::where('user_id','=',$vendor_id)->where('status','=','on delivery')->whereBetween('created_at',[$startdate,$enddate])->sum('price');
		
		$completed_orders =  VendorOrder::where('user_id','=',$vendor_id)->where('status','=','completed')->whereBetween('created_at',[$startdate,$enddate])->distinct()->count('order_id');        
        $completed_amount =  VendorOrder::where('user_id','=',$vendor_id)->where('status','=','completed')->whereBetween('created_at',[$startdate,$enddate])->sum('price');
        
        $fileName = 'data_analytics_report.csv';		
	    $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );
		$columns = array('Start Date', 'End Date','No Of Orders', 'No Of Orders Amount', 'Processing Orders', 'Processing Orders Amount', 'Shipped Orders', 'Shipped Orders Amount','Completed Orders','Completed Orders Amount', 'Refund Amount');
		$enddate =date('Y-m-d', strtotime("-1 day", strtotime($enddate)));
	    $callback = function() use ($startdate,$enddate,$allorders, $columns,$pay_amount,$processing_orders,$processing_amount,$od_orders,$od_amount,$completed_orders,$completed_amount,$refund_fee)
    {
	   $file = fopen('php://output', 'w');
	  fputcsv($file, $columns); 
		   
		  $row['Start Date'] =$startdate;
		  $row['End Date'] =$enddate;
		  $row['No Of Orders'] =$allorders;
		  $row['No Of Orders Amount'] = round($pay_amount, 2).' INR ';
		  $row['Processing Orders'] =$processing_orders;
		  $row['Processing Orders Amount'] = round($processing_amount, 2).' INR ';
		  $row['Shipped Orders'] =$od_orders;
		  $row['Shipped Orders Amount'] = round($od_amount, 2).' INR ';;
		  $row['Completed Orders'] =$completed_orders;
		  $row['Completed Orders Amount'] = round($completed_amount, 2).' INR ';
		  $row['Refund Amount'] = round($refund_fee, 2).' INR ';
      fputcsv($file, array($row['Start Date'],$row['End Date'],$row['No Of Orders'],$row['No Of Orders Amount'],$row['Processing Orders'],$row['Processing Orders Amount'],$row['Shipped Orders'],$row['Shipped Orders Amount'],$row['Completed Orders'],$row['Completed Orders Amount'],$row['Refund Amount']));
	  fclose($file);
	  };
	   return response()->stream($callback, 200, $headers);
					   
    }   	
}
