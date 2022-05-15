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
use App\Models\Blog;
use App\Models\User;
use App\Models\Product;
use App\Models\Counter;

class RecordsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

     
	public function records(Request $request)
    {
       
        $startdate =  $request->startdate;
        $enddate = $request->enddate;
        $start = strtotime($startdate);
        $end = strtotime($enddate);
        $daysrange = "";
        $allcustomers ="";$allorders ="";
        $days_between = ceil(abs($end - $start) / 86400);

        $user = Auth::user();


        $pending = Order::where('status','=','pending')->where('user_id','=',$user->id)->get();
        $processing = Order::where('status','=','processing')->where('user_id','=',$user->id)->get();
        $completed = Order::where('status','=','completed')->where('user_id','=',$user->id)->get();
        $days = "";$days30 = "";$daysyear = "";
        $sales = "";$sales30 = "";$salesyear = "";
        $month = date('m');
        $Currentmonthday= date('d');

        $lastmonthdays = date("t", mktime(0,0,0, date("n") - 1));
        for($i = $month-1; $i > -1; $i--) {
            $daysyear .= "'".date("M", strtotime('-'. $i .' months'))."',";

            $salesyear .=  "'".Order::where('status','=','completed')->where('user_id','=',$user->id)->whereDate('created_at', '=', date("Y-m-d", strtotime('-'. $i .' days')))->count()."',";
        }
        for($i = 0; $i < $Currentmonthday; $i++) {
            $days .= "'".date("d M", strtotime('-'. $i .' days'))."',";

            $sales .=  "'".Order::where('status','=','completed')->where('user_id','=',$user->id)->whereDate('created_at', '=', date("Y-m-d", strtotime('-'. $i .' days')))->count()."',";
        }
		for($j = $lastmonthdays-1; $j > -1 ; $j--) {
            $days30 .= "'".date("d M", strtotime('-'. $j-$Currentmonthday .' days'))."',";

            $sales30 .=  "'".Order::where('status','=','completed')->where('user_id','=',$user->id)->whereDate('created_at', '=', date("Y-m-d", strtotime('-'. $j-$Currentmonthday .' days')))->count()."',";
        }
        $days7='';
        $sales7 ='';
        for($j = 0; $j < 7 ; $j++) {
            $days7 .= "'".date("d M", strtotime('-'. $j .' days'))."',";

            $sales7 .=  "'".Order::where('status','=','completed')
			                        ->where('user_id','=',$user->id)
                                    ->whereDate('created_at', '=', date("Y-m-d", strtotime('-'. $j .' days')))
                                    ->count()."',";
        }
       
      
        $users = User::where('id','=',$user->id);
        $products = Product::where('id','=',$user->id);
        $blogs = Blog::where('id','=',$user->id);
        $pproducts = Product::where('user_id','=',$user->id)->orderBy('id','desc')->take(5)->get();
        $rorders = Order::where('user_id','=',$user->id)->orderBy('id','desc')->take(5)->get();
        $poproducts = Product::where('user_id','=',$user->id)->orderBy('views','desc')->take(5)->get();
        $rusers = User::where('id','=',$user->id)->orderBy('id','desc')->take(5)->get();
        $referrals = Counter::where('type','referral')->orderBy('total_count','desc')->take(5)->get();
        $browsers = Counter::where('type','browser')->orderBy('total_count','desc')->take(5)->get();

        $activation_notify = "";

        $allorders =  Order::where('user_id','=',$user->id)->whereBetween('created_at',[$startdate,$enddate])->count();
        $allcustomers =  Order::where('user_id','=',$user->id)->whereBetween('created_at',[$startdate,$enddate])->count();
        $pay_amount =  Order::where('user_id','=',$user->id)->whereBetween('created_at',[$startdate,$enddate])->sum('pay_amount');
        $admin_fee =  VendorOrder::where('user_id','=',$user->id)->whereBetween('created_at',[$startdate,$enddate])->sum('admin_fee');
        $totalQty =  Order::where('user_id','=',$user->id)->whereBetween('created_at',[$startdate,$enddate])->sum('totalQty');
        $shipping_cost =  Order::where('user_id','=',$user->id)->whereBetween('created_at',[$startdate,$enddate])->sum('shipping_cost');
        $coupon_discount =  Order::where('user_id','=',$user->id)->whereBetween('created_at',[$startdate,$enddate])->sum('coupon_discount');
        $salesrange='';$daysrange='';
        for($i = 0; $i < $days_between; $i++) {
            $daysrange .= "'".date("d M", strtotime('-'. $i .' days'))."',";

            $salesrange .=  "'".Order::where('user_id','=',$user->id)->where('status','=','completed')->whereDate('created_at', '=', date("Y-m-d", strtotime('-'. $i .' days')))->count()."',";
        }

        return view('vendor.records',compact('start','end','pending','activation_notify','processing','completed','products','users','blogs','days','days30','days7','daysyear','sales','sales30','sales7','salesyear','pproducts','rorders','poproducts','rusers','referrals','browsers','allorders','allcustomers','pay_amount','startdate','enddate','days_between','admin_fee','totalQty','shipping_cost','coupon_discount','daysrange','salesrange'));
    }
}
