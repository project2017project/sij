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

class OverviewController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:admin');
    }
   
	public function record(Request $request)
    {
		$startdate =  $request->startdate;
        $enddate = $request->enddate;
		$enddate =date('Y-m-d', strtotime("+1 day", strtotime($enddate)));
        $start = strtotime($startdate);
        $end = strtotime($enddate);
        $daysrange = "";
        $allcustomers ="";$allorders ="";
        $days_between = ceil(abs($end - $start) / 86400);        
        
        $days = "";$days30 = "";$daysyear = "";
        $sales = "";$sales30 = "";$salesyear = "";
        $month = date('m');
        $Currentmonthday= date('d');

        $lastmonthdays = date("t", mktime(0,0,0, date("n") - 1));
        for($i = $month-1; $i > -1; $i--) {
            $daysyear .= "'".date("M", strtotime('-'. $i .' months'))."',";

            $salesyear .=  "'".Order::where('status','=','completed')->where('payment_status','=','completed')->whereDate('created_at', '=', date("Y-m-d", strtotime('-'. $i .' days')))->count()."',";
        }
        for($i = 0; $i < $Currentmonthday; $i++) {
            $days .= "'".date("d M", strtotime('-'. $i .' days'))."',";

            $sales .=  "'".Order::where('status','=','completed')->where('payment_status','=','completed')->whereDate('created_at', '=', date("Y-m-d", strtotime('-'. $i .' days')))->count()."',";
        }
		for($j = $lastmonthdays-1; $j > -1 ; $j--) {
            $days30 .= "'".date("d M", strtotime('-'. ($j-$Currentmonthday) .' days'))."',";

            $sales30 .=  "'".Order::where('status','=','completed')->where('payment_status','=','completed')->whereDate('created_at', '=', date("Y-m-d", strtotime('-'. ($j-$Currentmonthday) .' days')))->count()."',";
        }
        $days7='';
        $sales7 ='';
        for($j = 0; $j < 7 ; $j++) {
            $days7 .= "'".date("d M", strtotime('-'. $j .' days'))."',";

            $sales7 .=  "'".Order::where('status','=','completed')
			                        ->where('payment_status','=','completed')
                                    ->whereDate('created_at', '=', date("Y-m-d", strtotime('-'. $j .' days')))
                                    ->count()."',";
        }
		
		$days_yes='';
        $sales_yes ='';
        for($j = 0; $j < 2 ; $j++) {
            $days_yes .= "'".date("d M", strtotime('-'. $j .' days'))."',";

            $sales_yes .=  "'".Order::where('status','=','completed')
			                        ->where('payment_status','=','completed')
                                    ->whereDate('created_at', '=', date("Y-m-d", strtotime('-'. $j .' days')))
                                    ->count()."',";
        }
		
		$days_today='';
        $sales_today ='';
        for($j = 0; $j < 1 ; $j++) {
            $days_today .= "'".date("d M", strtotime('-'. $j .' days'))."',";

            $sales_today .=  "'".Order::where('status','=','completed')
			                        ->where('payment_status','=','completed')
                                    ->whereDate('created_at', '=', date("Y-m-d", strtotime('-'. $j .' days')))
                                    ->count()."',";
        }
       
      
       
        $referrals = Counter::where('type','referral')->orderBy('total_count','desc')->take(5)->get();
        $browsers = Counter::where('type','browser')->orderBy('total_count','desc')->take(5)->get();

        $activation_notify = "";
		
		$product_list =VendorOrder::select('product_id', DB::raw('SUM(qty) as count'), DB::raw('COUNT(order_id) as ordercount'), DB::raw('SUM(price) as prices'))
                        ->groupBy('product_id')
						->where('status','!=','pending')
						->where('status','!=','declined')
						->whereBetween('created_at',[$startdate,$enddate])
                        ->orderBy('count', 'desc')
                        ->take(5)						
                        ->get();		

        $allorders =  Order::where('status','=','completed')->where('payment_status','=','completed')->whereBetween('created_at',[$startdate,$enddate])->count();        
        $pay_amount =  Order::where('status','=','completed')->where('payment_status','=','completed')->whereBetween('created_at',[$startdate,$enddate])->sum('pay_amount');
        $refund_fee =  VendorOrder::where('status','=','completed')->whereBetween('created_at',[$startdate,$enddate])->sum('product_item_price');
		$qty_data =  VendorOrder::where('status','=','completed')->whereBetween('created_at',[$startdate,$enddate])->sum('qty');        
        $totalQty =  Order::where('status','=','completed')->where('payment_status','=','completed')->whereBetween('created_at',[$startdate,$enddate])->sum('totalQty');        
        $salesrange='';$daysrange='';
        for($i = 0; $i < $days_between; $i++) {
            $daysrange .= "'".date("d M", strtotime('-'. $i .' days'))."',";

            $salesrange .=  "'".Order::where('status','=','completed')->where('payment_status','=','completed')->whereDate('created_at', '=', date("Y-m-d", strtotime('-'. $i .' days')))->count()."',";
        }

        return view('admin.overview',compact('start','end','activation_notify','days','days30','days7','days_yes','days_today','daysyear','sales','sales30','sales7','sales_yes','sales_today','salesyear','referrals','browsers','product_list','allorders','pay_amount','startdate','enddate','days_between','refund_fee','qty_data','totalQty','daysrange','salesrange'));
    }
}
