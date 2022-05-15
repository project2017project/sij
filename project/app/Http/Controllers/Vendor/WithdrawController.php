<?php

namespace App\Http\Controllers\Vendor;

use App\Classes\GeniusMailer;
use App\Models\User;
use App\Models\Withdraw;
use App\Models\Order;
use App\Models\VendorOrder;
use App\Models\Generalsetting;
use App\Models\Admin;
use App\Models\Pagesetting;
use App\Models\Product;
use Auth;
use DB;
use App\Models\Currency;
use App\Models\DebitNote;
use App\Models\CreditNote;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WithdrawController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

  	public function index()
    {
        $withdraws = Withdraw::where('user_id','=',Auth::guard('web')
            ->user()->id)
            ->where('type','=','vendor')
			->where('status','=','requested')
            ->orderBy('id','desc')->get();
        $sign = Currency::where('is_default','=',1)->first();        
        return view('vendor.withdraw.index',compact('withdraws','sign'));
    }
	
	public function withdrawadminapprovelist()
        {
			$withdraws = VendorOrder::where('user_id','=',Auth::guard('web')->user()->id)
                                ->where('admin_approve','=','completed')
                               // ->orwhere('admin_approve','!=','approved')
                                ->orderBy('id','desc')->get();
            return view('vendor.withdraw.windrawpendinglist',compact('withdraws'));
        }
	
	public function pending()
    {
         $email=env('ADMIN_EMAIL');		 
         $admin = Admin::where('email',$email)->first();     
    
        $user = Auth::user();        
        $withdraws = Withdraw::where('user_id','=',Auth::guard('web')
            ->user()->id)
            ->where('type','=','vendor')
			->where('status','=','pending')
            ->orderBy('id','desc')->get();
        $sign = Currency::where('is_default','=',1)->first();        
        return view('vendor.withdraw.pending',compact('withdraws','admin','user','sign'));
    }
	public function completed()
    {
		$email=env('ADMIN_EMAIL');		 
        $admin = Admin::where('email',$email)->first();        
        $user = Auth::user();
        $withdraws = Withdraw::where('user_id','=',Auth::guard('web')
            ->user()->id)
            ->where('type','=','vendor')
			->where('status','=','completed')
            ->orderBy('id','desc')->get();
        $sign = Currency::where('is_default','=',1)->first();        
        return view('vendor.withdraw.completed',compact('withdraws','admin','user','sign'));
    }
	public function rejected()
    {
        $withdraws = Withdraw::where('user_id','=',Auth::guard('web')
            ->user()->id)
            ->where('type','=','vendor')
			->where('status','=','rejected')
            ->orderBy('id','desc')->get();
        $sign = Currency::where('is_default','=',1)->first();        
        return view('vendor.withdraw.rejected',compact('withdraws','sign'));
    }


    public function create()
    {
        $sign = Currency::where('is_default','=',1)->first();
        return view('vendor.withdraw.create' ,compact('sign'));
    }


    public function store(Request $request)
    {

        $from = User::findOrFail(Auth::guard('web')->user()->id);
        $curr = Currency::where('is_default','=',1)->first(); 
        $withdrawcharge = Generalsetting::findOrFail(1);
        $charge = $withdrawcharge->withdraw_fee;

        if($request->amount > 0){

            $amount = $request->amount;
            $amount = round(($amount / $curr->value),2);
            if ($from->current_balance >= $amount){
                $fee = (($withdrawcharge->withdraw_charge / 100) * $amount) + $charge;
                $finalamount = $amount - $fee;
                $finalamount = number_format((float)$finalamount,2,'.','');

                $from->current_balance = $from->current_balance - $amount;
                $from->update();

                $newwithdraw = new Withdraw();
                $newwithdraw['user_id'] = Auth::user()->id;
                $newwithdraw['method'] = $request->methods;
                $newwithdraw['acc_email'] = $request->acc_email;
                $newwithdraw['iban'] = $request->iban;
                $newwithdraw['country'] = $request->acc_country;
                $newwithdraw['acc_name'] = $request->acc_name;
                $newwithdraw['address'] = $request->address;
                $newwithdraw['swift'] = $request->swift;
                $newwithdraw['reference'] = $request->reference;
                $newwithdraw['amount'] = $finalamount;
                $newwithdraw['fee'] = $fee;
                $newwithdraw['type'] = 'vendor';
                $newwithdraw->save();

                return response()->json('Withdraw Request Sent Successfully.'); 

            }else{
                 return response()->json(array('errors' => [ 0 => 'Insufficient Balance.' ])); 
            }
        }
            return response()->json(array('errors' => [ 0 => 'Please enter a valid amount.' ])); 

    }

    public function withdraworder(Request $request){   
	
         
        $group_order_id = implode(', ', $request->check); 
        $amount = array_sum($request->withdrawal_amount); 
        $withdrawal_amount = array_sum($request->withdrawal_amount); 
        $withdrawcharge = Generalsetting::findOrFail(1);
        $charge = $withdrawcharge->withdraw_fee;
		$email=env('ADMIN_EMAIL');         
        $admindata = Admin::where('email',$email)->first();		
        $user = Auth::user();
        $order = Order::find($group_order_id);		
        $usedid = Auth::user()->id;
        $venstate = User::all()->where('is_vendor','2')->where('id',$usedid)->pluck('state')->implode(',');
        $vengst = User::all()->where('is_vendor','2')->where('id',$usedid)->pluck('reg_number')->implode(',');
		$users_data = User::find($usedid);
		$user_commission= $users_data->percentage_commission;
		if($user_commission){
        $fees = round(($user_commission / 100) * $amount, 2);
		}else{
			$fees = round(($withdrawcharge->percentage_commission / 100) * $amount, 2);
		}
		$sgst = NULL;
		$cgst = NULL;
		$tcs=NULL;
		$igst=NULL;
		$fee= $fees;
		if($admindata->admin_state == $venstate){
		    
			$sgst = round($fees*9/100, 2);
			$cgst = round($fees*9/100, 2);
			$igst = NULL;
			 $vengrosspayment = $withdrawal_amount - $fees - $sgst - $cgst;
			
			$tcs=NULL;
			
			
			
			
			if($vengst == NULL){
            				       $tcs=NULL;
            				       $finalamount = $vengrosspayment;  
            				   }else{
            				      $tcs = round($vengrosspayment*1/100, 2);
            				      $finalamount = $vengrosspayment - $tcs;  
            				   }
            				   
			
			
		}else{
			$igst = round($fees*18/100, 2);
			$finalamount = $withdrawal_amount - $fees - $igst;  
		}
		
		$debit_arr=array();
			$credit_arr=array();
			$debit_data=DebitNote::where('vendor_id', Auth::user()->id)->where('status','=',0)->orderBy('id','asc')->get();
			foreach($debit_data as $debit_vals){
				$debit_arr[]=$debit_vals->id;
			}
			$debit_val= implode(",",$debit_arr);			
			$credit_data=CreditNote::where('vendor_id', Auth::user()->id)->where('status','=',0)->orderBy('id','asc')->get();
			foreach($credit_data as $credit_vals){
				$credit_arr[]=$credit_vals->id;
			}
			$credit_val= implode(",",$credit_arr);
	
		$total_debit_amount=DebitNote::where('vendor_id',Auth::user()->id)->where('status','=',0)->sum('amount');
        $total_credit_amount=CreditNote::where('vendor_id',Auth::user()->id)->where('status','=',0)->sum('amount');

        VendorOrder::whereIn('order_id',$request->check)->where('user_id', Auth::user()->id)->update(['vendor_request_status' => 'requested']);
		
		DB::table('credit_notes')->where(['vendor_id' => Auth::user()->id,'status' => 0])->update(['withdraw_status' => 1]);
        DB::table('debit_notes')->where(['vendor_id' => Auth::user()->id,'status' => 0])->update(['withdraw_status' => 1]);
                
        $newwithdraw = new Withdraw();
        $newwithdraw['user_id'] = Auth::user()->id;  
        $newwithdraw['group_order_id'] = $group_order_id;   
        $newwithdraw['withdrawal_amount'] =    $withdrawal_amount;
        $newwithdraw['amount'] =    $finalamount;       
		$newwithdraw['sgst'] = $sgst;
		$newwithdraw['cgst'] = $cgst;
		$newwithdraw['igst'] = $igst;
		$newwithdraw['tcs'] = $tcs;
        $newwithdraw['fee'] = $fees;
		$newwithdraw['debit_note_id'] = $debit_val;
        $newwithdraw['credit_note_id'] = $credit_val;
		$newwithdraw['total_debit_amount'] = round($total_debit_amount,2);
        $newwithdraw['total_credit_amount'] = round($total_credit_amount,2);
        $newwithdraw['comment'] = '';
        $newwithdraw['type'] = 'vendor';
        $newwithdraw->save();
		
		$withdrawid='#'.$newwithdraw->id;
		$withdraw_arr = Withdraw::find($withdrawid);
		$withdraw_id=$withdraw_arr->id;
		$withdraw_wtamount=$withdraw_arr->withdrawal_amount;
		$withdraw_sgst=$withdraw_arr->sgst;
		$withdraw_cgst=$withdraw_arr->cgst;
		$withdraw_igst=$withdraw_arr->igst;
		$withdraw_tcs=$withdraw_arr->tcs;
		$withdraw_amount=$withdraw_arr->withdrawal_amount;
		$admin_fees=$withdraw_arr->fee;
		
		$all_order_id = explode(', ', $group_order_id); 
		$admin_em = Pagesetting::find(1)->contact_email;
		foreach($all_order_id as $orderids){
	
	    
		$gs = Generalsetting::findOrFail(1);		
		$order_id= $orderids;
		$order = Order::findOrFail($order_id);
		
			$cart = unserialize(bzdecompress(utf8_decode($order->cart)));			
			//$to = $order->customer_email;			
			$to = 'payments@southindiajewels.co.in';
            $subject = 'Withdrawal Request Received for Order'.$order->order_number.'';
 
// To send HTML mail, the Content-type header must be set
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
 
// Create email headers
$headers .= 'From: '.$gs->from_email."\r\n".
    'Reply-To: '.$gs->from_email."\r\n" .
    'X-Mailer: PHP/' . phpversion();
 
// Compose a simple HTML email message
          $msg = '<!doctype html>
<html>
   <head>
      <meta charset="utf-8">
     
      <style amp-custom>
      	.es-desk-hidden {
	display: none;
	float: left;
	overflow: hidden;
	width: 0;
	max-height: 0;
	line-height: 0;
}

s {
	text-decoration: line-through;
}

body {
	width: 100%;
	font-family: arial, "helvetica neue", helvetica, sans-serif;
}

table {
	border-collapse: collapse;
	border-spacing: 0px;
}

table td,
html,
body,
.es-wrapper {
	padding: 0;
	Margin: 0;
}

.es-content,
.es-header,
.es-footer {
	table-layout: fixed;
	width: 100%;
}

p,
hr {
	Margin: 0;
}

h1,
h2,
h3,
h4,
h5 {
	Margin: 0;
	line-height: 120%;
	font-family: "trebuchet ms", helvetica, sans-serif;
}

.es-left {
	float: left;
}

.es-right {
	float: right;
}

.es-p5 {
	padding: 5px;
}

.es-p5t {
	padding-top: 5px;
}

.es-p5b {
	padding-bottom: 5px;
}

.es-p5l {
	padding-left: 5px;
}

.es-p5r {
	padding-right: 5px;
}

.es-p10 {
	padding: 10px;
}

.es-p10t {
	padding-top: 10px;
}

.es-p10b {
	padding-bottom: 10px;
}

.es-p10l {
	padding-left: 10px;
}

.es-p10r {
	padding-right: 10px;
}

.es-p15 {
	padding: 15px;
}

.es-p15t {
	padding-top: 15px;
}

.es-p15b {
	padding-bottom: 15px;
}

.es-p15l {
	padding-left: 15px;
}

.es-p15r {
	padding-right: 15px;
}

.es-p20 {
	padding: 20px;
}

.es-p20t {
	padding-top: 20px;
}

.es-p20b {
	padding-bottom: 20px;
}

.es-p20l {
	padding-left: 20px;
}

.es-p20r {
	padding-right: 20px;
}

.es-p25 {
	padding: 25px;
}

.es-p25t {
	padding-top: 25px;
}

.es-p25b {
	padding-bottom: 25px;
}

.es-p25l {
	padding-left: 25px;
}

.es-p25r {
	padding-right: 25px;
}

.es-p30 {
	padding: 30px;
}

.es-p30t {
	padding-top: 30px;
}

.es-p30b {
	padding-bottom: 30px;
}

.es-p30l {
	padding-left: 30px;
}

.es-p30r {
	padding-right: 30px;
}

.es-p35 {
	padding: 35px;
}

.es-p35t {
	padding-top: 35px;
}

.es-p35b {
	padding-bottom: 35px;
}

.es-p35l {
	padding-left: 35px;
}

.es-p35r {
	padding-right: 35px;
}

.es-p40 {
	padding: 40px;
}

.es-p40t {
	padding-top: 40px;
}

.es-p40b {
	padding-bottom: 40px;
}

.es-p40l {
	padding-left: 40px;
}

.es-p40r {
	padding-right: 40px;
}

.es-menu td {
	border: 0;
}

a {
	text-decoration: underline;
}

p,
ul li,
ol li {
	font-family: arial, "helvetica neue", helvetica, sans-serif;
	line-height: 150%;
}

ul li,
ol li {
	Margin-bottom: 15px;
}

.es-menu td a {
	text-decoration: none;
	display: block;
}

.es-menu amp-img,
.es-button amp-img {
	vertical-align: middle;
}

.es-wrapper {
	width: 100%;
	height: 100%;
}

.es-wrapper-color {
	background-color: #EFEFEF;
}

.es-header {
	background-color: transparent;
}

.es-header-body {
	background-color: #FEF5E4;
}

.es-header-body p,
.es-header-body ul li,
.es-header-body ol li {
	color: #999999;
	font-size: 14px;
}

.es-header-body a {
	color: #999999;
	font-size: 14px;
}

.es-content-body {
	background-color: #FFFFFF;
}

.es-content-body p,
.es-content-body ul li,
.es-content-body ol li {
	color: #333333;
	font-size: 14px;
}

.es-content-body a {
	color: #D48344;
	font-size: 14px;
}

.es-footer {
	background-color: transparent;
}

.es-footer-body {
	background-color: #FEF5E4;
}

.es-footer-body p,
.es-footer-body ul li,
.es-footer-body ol li {
	color: #333333;
	font-size: 14px;
}

.es-footer-body a {
	color: #333333;
	font-size: 14px;
}

.es-infoblock,
.es-infoblock p,
.es-infoblock ul li,
.es-infoblock ol li {
	line-height: 120%;
	font-size: 12px;
	color: #CCCCCC;
}

.es-infoblock a {
	font-size: 12px;
	color: #CCCCCC;
}

h1 {
	font-size: 30px;
	font-style: normal;
	font-weight: normal;
	color: #333333;
}

h2 {
	font-size: 28px;
	font-style: normal;
	font-weight: normal;
	color: #333333;
}

h3 {
	font-size: 24px;
	font-style: normal;
	font-weight: normal;
	color: #333333;
}

.es-header-body h1 a,
.es-content-body h1 a,
.es-footer-body h1 a {
	font-size: 30px;
}

.es-header-body h2 a,
.es-content-body h2 a,
.es-footer-body h2 a {
	font-size: 28px;
}

.es-header-body h3 a,
.es-content-body h3 a,
.es-footer-body h3 a {
	font-size: 24px;
}

a.es-button,
button.es-button {
	border-style: solid;
	border-color: #D48344;
	border-width: 10px 20px 10px 20px;
	display: inline-block;
	background: #D48344;
	border-radius: 0px;
	font-size: 16px;
	font-family: arial, "helvetica neue", helvetica, sans-serif;
	font-weight: normal;
	font-style: normal;
	line-height: 120%;
	color: #FFFFFF;
	width: auto;
	text-align: center;
}

.es-button-border {
	border-style: solid solid solid solid;
	border-color: #D48344 #D48344 #D48344 #D48344;
	background: #2CB543;
	border-width: 0px 0px 0px 0px;
	display: inline-block;
	border-radius: 0px;
	width: auto;
}

@media only screen and (max-width:600px) {
	.es-content table,
	.es-header table,
	.es-footer table,
	.es-content,
	.es-footer,
	.es-header {
		width: 100%;
		max-width: 100%;
	}
.divwrap600{
    width : 100%;
    max-width : 600px;
    padding : 0 1px;
}


.es-content-body > tbody > tr > td > .es-right, .es-content-body > tbody > tr > td > .es-left{

	width: 50%;

}

}</style>
   </head>';
   $msg .= '<body><div class="es-wrapper-color">';
   
				  $msg .= '<div class="divwrap600"><table cellpadding="0" cellspacing="0" class="es-header" align="center">
                     <tr>
                        <td align="center">
                           <table class="es-header-body" style="background-color: #fef5e4; margin-top : 25px;" width="600" cellspacing="0" cellpadding="0" bgcolor="#fef5e4" align="center">
                              <tr>
                                 <td class="es-p5t es-p5b es-p15r es-p15l" align="left" bgcolor="#ffffff" style="background-color: #ffffff">
                                    <table cellspacing="0" cellpadding="0" width="100%">
                                       <tr>
                                          <td class="es-m-p0r" width="570" valign="top" align="center">
                                             <table width="100%" cellspacing="0" cellpadding="0" role="presentation">
                                                <tr>
                                                   <td align="center" class="es-p15" style="font-size: 0px">
                                                      <img class="adapt-img" src="https://pwokes.stripocdn.email/content/guids/CABINET_f3702042fc6f59954d9f14937bd051c9/images/26811626242635311.png" alt style="display: block" width="200" height="52" layout="responsive">
                                                   </td>
                                                </tr>
                                             </table>
                                          </td>
                                       </tr>
                                    </table>
                                 </td>
                              </tr>
                           </table>
                        </td>
                     </tr>
                  </table>';
				  
				  
	$msg .= '<table class="es-content" cellspacing="0" cellpadding="0" align="center">
                     <tr>
                        <td align="center">
                           <table class="es-content-body" width="600" cellspacing="0" cellpadding="0" bgcolor="#ffffff" align="center">
                              <tr>
                                 <td class="es-p10t es-p10b es-p20r es-p20l" align="left" bgcolor="#000000" style="background-color: #000000">
                                    <table width="100%" cellspacing="0" cellpadding="0">
                                       <tr>
                                          <td width="560" valign="top" align="center">
                                             <table style="border-radius: 0px;border-collapse: separate" width="100%" cellspacing="0" cellpadding="0" role="presentation">
                                                <tr style="background : #000000;">
                                                   <td class="es-p10t es-p15b" align="center">
                                                      <h1 style="color : #ffffff">withdraw Sucessful!!</h1>
                                                   </td>
                                                </tr>
                                             </table>
                                          </td>
                                       </tr>
                                    </table>
                                 </td>
                              </tr>
                              <tr>
                                 <td class="es-p40t es-p40b es-p20r es-p20l" align="left" bgcolor="#ffffff" style="background-color: #ffffff">
                                    <table width="100%" cellspacing="0" cellpadding="0">
                                       <tr>
                                          <td width="560" valign="top" align="center">
                                             <table style="border-radius: 0px;border-collapse: separate" width="100%" cellspacing="0" cellpadding="0" role="presentation">
                                                <tr>
                                                   <td class="es-p5t es-p5b es-p40r es-p40l" align="left">
                                                      <p style="color: #333333">Hi '.$order->customer_name.',</p>
                                                   </td>
                                                </tr>
                                                <tr>
                                                   <td class="es-p5t es-p5b es-p40r es-p40l" align="left">
                                                      <p style="color: #333333">Your order '.$order->order_number.' for withdraw Sucessful!!</p>
                                                   </td>
                                                </tr>
                                             </table>
                                          </td>
                                       </tr>
                                    </table>
                                 </td>
                              </tr>
                           </table>
                        </td>
                     </tr>
                  </table>';	
$msg .= '<table class="es-content" cellspacing="0" cellpadding="0" align="center">
                     <tr>
                        <td align="center">
                           <table class="es-content-body" width="600" cellspacing="0" cellpadding="0" bgcolor="#ffffff" align="center">
                              <tr>
                                 <td class="es-p20t es-p30b es-p20r es-p20l" align="left">
                                    
                                             <table class="es-left" cellspacing="0" cellpadding="0" style="width: 100%; " align="left">
                                                <tr>
                                                   <td class="es-m-p20b" width="280" align="left">
                                                      <table style="background-color: #fef9ef;border-color: #efefef;border-collapse: separate;border-width: 1px 0px 1px 1px;border-style: solid" width="100%" cellspacing="0" cellpadding="0" bgcolor="#fef9ef" role="presentation">
                                                         <tr>
                                                            <td class="es-p20b es-p20r es-p20l" align="left" bgcolor="#000000">
                                                               <table style="width: 100%; color: #ffffff" class="cke_show_border" cellspacing="1" cellpadding="1" border="0" align="left" role="presentation">
                                                               <tr>
                                                            <td class="es-p20t es-p10b es-p20r" align="left" bgcolor="#000000">
                                                               <h4 style="color: #ffffff">SUMMARY:</h4>
                                                            </td>
                                                         </tr>
                                                                  <tr>
                                                                     <td "es-p20t es-p10b es-p20r es-p20l" align="left" style="font-size: 14px;line-height: 21px">Order #: '.$order_id.'</td>
                                                                    
                                                                  </tr>
                                                                  <tr>
                                                                     <td "es-p20t es-p10b es-p20r es-p20l" align="left" style="font-size: 14px;line-height: 21px">Order Date: '.date('M d,Y',strtotime($order->created_at)).'</td>
                                                                   
                                                                  </tr>
                                                               </table>
                                                               <p style="line-height: 150%;color: #ffffff"><br></p>
                                                            </td>
                                                         </tr>
                                                      </table>
                                                   </td>
                                                </tr>
                                             </table>
                                           
                                 </td>
                              </tr>
                           </table>
                        </td>
                     </tr>
                     
                     
                     <tr>
                        <td align="center">
                           <table class="es-content-body" width="600" cellspacing="0" cellpadding="0" bgcolor="#ffffff" align="center">
                              <tr>
                                 <td class="es-p20t es-p30b es-p20r es-p20l" align="left">
                                    
                                              <table class="es-right" cellspacing="0" cellpadding="0" align="left">
                                                <tr>
                                                   <td width="280" align="left">
                                                      <table style="background-color: #fef9ef;border-collapse: separate;border-width: 1px;border-style: solid;border-color: #efefef" width="100%" cellspacing="0" cellpadding="0" bgcolor="#fef9ef" role="presentation">
                                                         <tr>
                                                            <td class="es-p20t es-p10b es-p20r es-p20l" align="left" bgcolor="#ffffff">
                                                               <h4 style="color: #000000">BILLING ADDRESS:</h4>
                                                            </td>
                                                         </tr>
                                                         <tr>
                                                            <td class="es-p20b es-p20r es-p20l" align="left" bgcolor="#ffffff">
                                                               <p style="color: #000000">'.$order->customer_name.'</p>
                                                               <p style="color: #000000">'.$order->customer_address.'</p>
                                                               <p style="color: #000000">'.$order->customer_city.'</p>
                                                                <p style="color: #000000">'.$order->customer_state.'</p>
                                                                
                                                                 <p style="color: #000000">'.$order->customer_country.'</p>
                                                                 
                                                                  <p style="color: #000000">'.$order->customer_zip.'</p>
                                                                  
                                                                  <p style="color: #000000">'.$order->customer_phone.'</p>
                                                                  
                                                            </td>
                                                         </tr>
                                                      </table>
                                                   </td>
                                                </tr>
                                             </table>
                                             
                                             <table class="es-right" cellspacing="0" cellpadding="0" align="right">
                                                <tr>
                                                   <td width="280" align="left">
                                                      <table style="background-color: #fef9ef;border-collapse: separate;border-width: 1px;border-style: solid;border-color: #efefef" width="100%" cellspacing="0" cellpadding="0" bgcolor="#fef9ef" role="presentation">
                                                         <tr>
                                                            <td class="es-p20t es-p10b es-p20r es-p20l" align="left" bgcolor="#ffffff">
                                                               <h4 style="color: #000000">SHIPPING ADDRESS:</h4>
                                                            </td>
                                                         </tr>
                                                         <tr>
                                                           <td class="es-p20b es-p20r es-p20l" align="left" bgcolor="#ffffff">
                                                               <p style="color: #000000">'.$order->customer_name.'</p>
                                                               <p style="color: #000000">'.$order->customer_address.'</p>
                                                               <p style="color: #000000">'.$order->customer_city.'</p>
                                                                <p style="color: #000000">'.$order->customer_state.'</p>
                                                                
                                                                 <p style="color: #000000">'.$order->customer_country.'</p>
                                                                 
                                                                  <p style="color: #000000">'.$order->customer_zip.'</p>
                                                                  <p style="color: #000000">'.$order->customer_email.'</p>
                                                                  
                                                                  <p style="color: #000000">'.$order->customer_phone.'</p>
                                                                  
                                                            </td>
                                                         </tr>
                                                      </table>
                                                   </td>
                                                </tr>
                                             </table>
                                           
                                 </td>
                              </tr>
                           </table>
                        </td>
                     </tr>
                     
                     
                    
                     
                  </table>';	
   $msg .= '<table class="es-content" cellspacing="0" cellpadding="0" align="center">
                     <tr>
                        <td align="center">
                           <table class="es-content-body" width="600" cellspacing="0" cellpadding="0" bgcolor="#ffffff" align="center">
                              <tr>
                                 <td class="es-p10t es-p10b es-p20r es-p20l" align="left">
                                    
                                           
                                             
                                             <table style="width:100%" cellspacing="0" cellpadding="0" align="right">
                                                <tr>
                                                   <td width="270" align="left">
                                                      <table width="100%" cellspacing="0" cellpadding="0" role="presentation">
                                                         <tr>
                                                            <td align="left">
                                                               <table style="width: 100%" class="cke_show_border" cellspacing="1" cellpadding="1" border="0" role="presentation">
                                                                  <tr>
                                                                     <td><span style="font-size:13px">SGST</span></td>
                                                                      <td><span style="font-size:13px">CGST</span></td>
																	   <td><span style="font-size:13px">IGST</span></td>
																	    <td><span style="font-size:13px">TCS</span></td>
																		<td><span style="font-size:13px">Admin Fees</span></td>
                                                                  </tr>
                                                               </table>
                                                            </td>
                                                         </tr>
                                                      </table>
                                                   </td>
                                                </tr>
                                             </table>
                                           
                                 </td>
                              </tr>';
                                      
                             
                             $msg .='<tr>
                                 <td class="es-p20r es-p20l" align="left">
                                    <table width="100%" cellspacing="0" cellpadding="0">
                                       <tr>
                                          <td width="560" valign="top" align="center">
                                             <table width="100%" cellspacing="0" cellpadding="0" role="presentation">
                                                <tr>
                                                   <td class="es-p10b" align="center" style="font-size:0">
                                                      <table width="100%" cellspacing="0" cellpadding="0" border="0" role="presentation">
                                                         <tr>
                                                            <td style="border-bottom: 1px solid #efefef;background: rgba(0, 0, 0, 0) none repeat scroll 0% 0%;height: 1px;width: 100%;margin: 0px"></td>
                                                         </tr>
                                                      </table>
                                                   </td>
                                                </tr>
                                             </table>
                                          </td>
                                       </tr>
                                    </table>
                                 </td>
                              </tr>';
														 
														
														 										 
														
														 $msg .='                                                   
                                 
                           </table>
                        </td>
                     </tr>
                  </table>';
   $msg .= '<table cellpadding="0" cellspacing="0" class="es-footer" align="center">
                     <tr>
                        <td align="center">
                           <table class="es-footer-body" style="background-color : #f9f9f9;" width="600" cellspacing="0" cellpadding="0" align="center">
                              <tr>
                                 <td class="es-p20" align="left">
                                    
                                             <table class="es-left" cellspacing="0" cellpadding="0" align="left">
                                                <tr>
                                                   <td class="es-m-p0r es-m-p20b" width="178" valign="top" align="center">
                                                      <table width="100%" cellspacing="0" cellpadding="0" role="presentation">
                                                         <tr>
                                                            <td class="es-m-txt-c es-p15t es-p10b" align="left" style="font-size: 0px">
                                                               <img src="https://pwokes.stripocdn.email/content/guids/CABINET_f3702042fc6f59954d9f14937bd051c9/images/26811626242635311.png" alt="Petshop logo" title="Petshop logo" width="138" style="display: block" height="36">
                                                            </td>
                                                         </tr>
                                                         <tr>
                                                            <td class="es-p5t es-m-txt-c" align="left">
                                                               <p><a target="_blank" href="tel:'.$admindata->phone.'">'.$admindata->phone.'</a><br><a target="_blank" href="mailto:'.$admindata->email.'">'.$admindata->email.'</a></p>
                                                            </td>
                                                         </tr>
                                                      </table>
                                                   </td>
                                                </tr>
                                             </table>
                                           
                                             <table cellspacing="0" cellpadding="0" align="right">
                                                <tr>
                                                   <td width="362" align="left">
                                                      <table width="100%" cellspacing="0" cellpadding="0" role="presentation">
                                                         <tr>
                                                            <td class="es-p15t es-p20b es-m-txt-c" align="left">
                                                               <p style="line-height: 150%"><span style="font-size: 20px;line-height: 30px">Information</span></p>
                                                            </td>
                                                         </tr>
                                                         <tr>
                                                            <td class="es-m-txt-c" align="left">
                                                               <p>Thanks for shopping with us.</p>
                                                            </td>
                                                         </tr>
                                                        
                                                      </table>
                                                   </td>
                                                </tr>
                                             </table>
                                             
                                 </td>
                              </tr>
                           </table>
                        </td>
                     </tr>
                  </table>';				  
   $msg .= '</td></tr></table>';
   $msg .= '<table class="es-wrapper" width="100%" cellspacing="0" cellpadding="0"><tr><td valign="top"><table cellpadding="0" cellspacing="0" class="es-content" align="center"><tr><td class="es-adaptive" align="center"><tr><td class="es-p15t es-p15b es-p20r es-p20l" align="center">   
                                    <p>South India Jewels</p>
                                 </td>
                              </tr>
                           </table>
                        </td>
                     </tr>
                  </table></div></div></body>';
   $msg .= '</html>';
   
   mail($to, $subject, $msg, $headers);
   
   if($gs->is_smtp == 1)
                    {		
        mail($to, $subject, $msg, $headers);
					}else{
						mail($to, $subject, $msg, $headers);						

					}
		}
               
        
    }
}
