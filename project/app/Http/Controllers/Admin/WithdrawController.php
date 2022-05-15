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
use Auth;
use App\Models\Currency;
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
        $admin = Admin::where('email',$email)->first();                
        $user = Auth::user();
        $order = Order::find($group_order_id);		
        $fees = (($withdrawcharge->percentage_commission / 100) * $amount) + $charge;
		$sgst = NULL;
		$cgst = NULL;
		$tcs=NULL;
		$igst=NULL;
		if($admin->admin_state == ($order->shipping_state == null ? $order->customer_state : $order->shipping_state)){
			$sgst = $fees*1.5/100;
			$cgst = $fees*1.5/100;
			$tcs=NULL;
			if($user->reg_number){
		       $tcs = $fees*1/100;
	        }
			$fee= $fees + $sgst + $cgst + $tcs;
			
		}else{
			$igst = $fees*3/100;
			$fee= $fees + $igst;
		}
		
        $finalamount = $amount - $fee;  

        VendorOrder::whereIn('order_id',$request->check)->update(['vendor_request_status' => 'requested']);
                
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
        $newwithdraw['type'] = 'vendor';
        $newwithdraw->save();
		
		$gs = Generalsetting::findOrFail(1);
                 if($gs->is_smtp == 1){
                    $maildata = [
                        'to' => $order->customer_email,
                        'subject' => 'Your order '.$order->order_number.' for withdraw Sucessful!!',
                        'body' => "Hello ".$order->customer_name.","."\n Thank you for shopping with us. We are looking forward to your next visit.",
                    ];
    
                    $mailer = new GeniusMailer();
                    $mailer->sendCustomMail($maildata);                
                }else{
                   $to = $order->customer_email;				  
                    $subject = 'Your order '.$order->order_number.'  for withdraw Sucessful!!';
                   $msg = "Hello ".$order->customer_name.","."\n Thank you for shopping with us. We are looking forward to your next visit.";
                     $headers = "From: ".$gs->from_name."<".$gs->from_email.">";
                   mail($to,$subject,$msg,$headers);                
                 }
				 
                 if($gs->is_smtp == 1){
                    $maildata = [
                        'to' => Pagesetting::find(1)->contact_email,
                        'subject' => 'Order '.$order->order_number.' for withdraw Sucessful!!',
                        'body' => "Hello Admin Withdraw Order Sucessful.",
                    ];
    
                    $mailer = new GeniusMailer();
                    $mailer->sendCustomMail($maildata);                
                }else{
                   $to = Pagesetting::find(1)->contact_email;				  
                   $subject = 'Order '.$order->order_number.'  for withdraw Sucessful!!';
                   $msg = "Hello Admin Withdraw Order Sucessful.";
                     $headers = "From: ".$gs->from_name."<".$gs->from_email.">";
                   mail($to,$subject,$msg,$headers);                
                 }

        
    }
}
