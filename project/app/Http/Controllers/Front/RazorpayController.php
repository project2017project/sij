<?php

namespace App\Http\Controllers\Front;

use App\Models\Cart;
use App\Models\User;
use App\Models\Order;
use Razorpay\Api\Api;
use App\Models\Coupon;
use App\Models\Product;
use App\Models\Currency;
use App\Models\OrderTrack;
use App\Models\VendorOrder;
use App\Models\Notification;
use App\Models\Admin;
use Illuminate\Http\Request;
use App\Classes\GeniusMailer;
use App\Models\Generalsetting;
use App\Models\UserNotification;
use App\Http\Controllers\Controller;
use App\Models\Pagesetting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use PDF;
use Config;

class RazorpayController extends Controller
{

    public function __construct()
    {
        
        $rdata = Generalsetting::findOrFail(1);
        $this->keyId = $rdata->razorpay_key;
        $this->keySecret = $rdata->razorpay_secret;
        $this->displayCurrency = 'INR';

        $this->api = new Api($this->keyId, $this->keySecret);
		
		 if($rdata->header_email == 'smtp') {
            $mail_driver = 'smtp';
        }
        else{
            if($rdata->header_email == 'sendmail') {
                $mail_driver = 'sendmail';
            }
            else {
                $mail_driver = 'smtp';
            }
        }
        Config::set('mail.driver', $mail_driver);
        Config::set('mail.host', $rdata->smtp_host);
        Config::set('mail.port', $rdata->smtp_port);
        Config::set('mail.encryption', $rdata->email_encryption);
        Config::set('mail.username', $rdata->smtp_user);
        Config::set('mail.password', $rdata->smtp_pass);
    }

    public function store(Request $request)
    {
        	$tcs = 1;
	$rdata = Generalsetting::findOrFail(1);	
        if($request->pass_check) {
            $users = User::where('email','=',$request->personal_email)->get();
            if(count($users) == 0) {
                if ($request->personal_pass == $request->personal_confirm){
                    $user = new User;
                    $user->name = $request->personal_name; 
                    $user->email = $request->personal_email;   
                    $user->password = bcrypt($request->personal_pass);
                    $token = md5(time().$request->personal_name.$request->personal_email);
                    $user->verification_link = $token;
                    $user->affilate_code = md5($request->name.$request->email);
                    $user->email_verified = 'Yes';
                    $user->save();
                    Auth::guard('web')->login($user);                     
                }else{
                    return redirect()->back()->with('unsuccess',"Confirm Password Doesn't Match.");     
                }
            }
            else {
                return redirect()->back()->with('unsuccess',"This Email Already Exist.");  
            }
        }

        if (!Session::has('cart')) {
            return redirect()->route('front.cart')->with('success',"You don't have any product to checkout.");
        }

        $oldCart = Session::get('cart');
        $cart = new Cart($oldCart);
            if (Session::has('currency')) 
            {
              $curr = Currency::find(Session::get('currency'));
            }
            else
            {
                $curr = Currency::where('is_default','=',1)->first();
            }

            if($curr->name != "INR")
            {
                return redirect()->back()->with('unsuccess','Please Select INR Currency For Rozerpay.');
            }
        $settings = Generalsetting::findOrFail(1);
        $order = new Order;
        $success_url = action('Front\PaymentController@payreturn');
        $item_name = $settings->title." Order";
        //$item_number = str_random(4).time();
		//$item_number = str_random(4).time();
        $order_data = Order::orderBy('id','desc')->get();
        //$ord_no = 'order'.Auth()->id();
        $ord_no = 'SIJ'.rand(100,1000);
        $ord_gen =@$order_data[0]->id+1;
        $item_number =$ord_no.$ord_gen;
        $item_amount = $request->total;
        $notify_url = action('Front\RazorpayController@razorCallback');
        $cancel_url = action('Front\PaymentController@paycancle');

        foreach($cart->items as $key => $prod)
        {
            $vendor_list[] = $prod['item']['user_id'];
            $product_name_qty[]= $prod['item']['name'] .' x '. $prod['qty'];
			$product_id_qty[]= $prod['item']['name'];
			$product_item_qty[]= $prod['item']['qty'];
            if(!empty($prod['item']['license']) && !empty($prod['item']['license_qty']))
            {
                    foreach($prod['item']['license_qty']as $ttl => $dtl)
                    {
                        if($dtl != 0)
                        {
                            $dtl--;
                            $produc = Product::findOrFail($prod['item']['id']);
                            $temp = $produc->license_qty;
                            $temp[$ttl] = $dtl;
                            $final = implode(',', $temp);
                            $produc->license_qty = $final;
                            $produc->update();
                            $temp =  $produc->license;
                            $license = $temp[$ttl];
                            $oldCart = Session::has('cart') ? Session::get('cart') : null;
                            $cart = new Cart($oldCart);
                            $cart->updateLicense($prod['item']['id'],$license);  
                            Session::put('cart',$cart);
                            break;
                        }                    
                    }
            }
        }



        $orderData = [
            'receipt'         => $item_number,
            'amount'          => $item_amount * 100, // 2000 rupees in paise
            'currency'        => 'INR',
            'payment_capture' => 1 // auto capture
        ];
        
        $razorpayOrder = $this->api->order->create($orderData);
        
        $razorpayOrderId = $razorpayOrder['id'];
        
        session(['razorpay_order_id'=> $razorpayOrderId]);
        



                    $order['user_id'] = $request->user_id;
                    $order['vendor_id_list'] = implode(',', $vendor_list);
        $order['product_name_qty'] = implode(',', $product_name_qty);
		$order['product_id_list'] = implode(',', $product_id_qty);
		$order['product_item_list'] = implode(',', $product_item_qty);
                    $order['cart'] = utf8_encode(bzcompress(serialize($cart), 9));
                    $order['totalQty'] = $request->totalQty;
                    $order['pay_amount'] = round($item_amount / $curr->value, 2);
                    $order['method'] = "Razorpay";
                    $order['customer_email'] = $request->email;
                    $order['customer_name'] = $request->name;
                    $order['customer_phone'] = $request->phone;
                    $order['order_number'] = $item_number;
                    $order['shipping'] = $request->shipping;
                    $order['pickup_location'] = $request->pickup_location;
                    $order['customer_address'] = $request->address;
                    $order['customer_country'] = $request->customer_country;
					$order['customer_state'] = $request->customer_state;
                    $order['customer_city'] = $request->city;
                    $order['customer_zip'] = $request->zip;
					$order['customer_landmark'] = $request->customer_landmark;
                    $order['shipping_email'] = $request->shipping_email;
                    $order['shipping_name'] = $request->shipping_name;
                    $order['shipping_phone'] = $request->shipping_phone;
                    $order['shipping_address'] = $request->shipping_address;
                    $order['shipping_country'] = $request->shipping_country;
					$order['shipping_state'] = $request->shipping_state;
                    $order['shipping_city'] = $request->shipping_city;
                    $order['shipping_zip'] = $request->shipping_zip;
					$order['shipping_landmark'] = $request->shipping_landmark;
                    $order['order_note'] = $request->order_notes;
                    $order['coupon_code'] = $request->coupon_code;
                    $order['coupon_discount'] = $request->coupon_discount;
                    $order['payment_status'] = "pending";
                    $order['status'] = 'failure';
                    $order['currency_sign'] = $curr->sign;
                    $order['currency_value'] = $curr->value;
					$order['currency_orginal_val'] = $curr->original_val;
					$order['inr_currency_sign'] = '₹';
                    $order['shipping_cost'] = $request->shipping_cost;
                    $order['packing_cost'] = $request->packing_cost;
                    $order['tax'] = $request->tax;
                    $order['dp'] = $request->dp;
                    $order['vendor_shipping_id'] = $request->vendor_shipping_id;
                    $order['vendor_packing_id'] = $request->vendor_packing_id;
					$order['admin_fee'] = round($request->total / $curr->value, 2)*$rdata->percentage_commission/100;
					
					if($order['shipping_state'] != '' && $order['shipping_state'] == 'Tamil Nadu')
					{
					    
					$tax_prices = round($item_amount / $curr->value, 2);
					$tax_cal =3/100;
					$main_tax_cal= $tax_cal+1;
					$product_tax= $tax_prices/$main_tax_cal;    
					    
					$order['sgst'] = round($product_tax*1.5/100, 2);;
			        $order['cgst'] = round($product_tax*1.5/100, 2);;
			        
					}
					
					
					if($order['shipping_state'] != '' && $order['shipping_state'] != 'Tamil Nadu')
					{
					    
					$tax_prices = round($item_amount / $curr->value, 2);
					$tax_cal =3/100;
					$main_tax_cal= $tax_cal+1;
					$product_tax= $tax_prices/$main_tax_cal;    
					    
					$order['igst'] = round($product_tax*3/100, 2);
			        
					}
					
					
					if($order['shipping_state'] == '' && $order['customer_state'] == 'Tamil Nadu')
					{
					    
					$tax_prices = round($item_amount / $curr->value, 2);
					$tax_cal =3/100;
					$main_tax_cal= $tax_cal+1;
					$product_tax= $tax_prices/$main_tax_cal;    
					    
					$order['sgst'] = round($product_tax*1.5/100, 2);;
			        $order['cgst'] = round($product_tax*1.5/100, 2);;
			        
					}
					
					
					if($order['shipping_state'] == '' && $order['customer_state'] != 'Tamil Nadu')
					{
					    
					$tax_prices = round($item_amount / $curr->value, 2);
					$tax_cal =3/100;
					$main_tax_cal= $tax_cal+1;
					$product_tax= $tax_prices/$main_tax_cal;    
					    
					$order['igst'] = round($product_tax*3/100, 2);
			        
					}
					
					
					
					
					
				
			        $order['tcs'] = $tcs;
                    
                    if($order['dp'] == 1)
                    {
                        $order['status'] = 'completed';
                    }

                    if (Session::has('affilate')) 
                    {
                        $val = $request->total / $curr->value;
                        $val = $val / 100;
                        $sub = $val * $settings->affilate_charge;
                        $user = User::findOrFail(Session::get('affilate'));
                        $user->affilate_income += $sub;
                        $user->update();
                        $order['affilate_user'] = $user->name;
                        $order['affilate_charge'] = $sub;
                    }
                            $order->save();

                    if($order->dp == 1){
                        $track = new OrderTrack;
                        $track->title = 'Completed';
                        $track->text = 'Your order has completed successfully.';
                        $track->order_id = $order->id;
                        $track->save();
                    }
                    else {
                        $track = new OrderTrack;
                        $track->title = 'Pending';
                        $track->text = 'You have successfully placed your order.';
                        $track->order_id = $order->id;
                        $track->save();
                    }

                    
                    $notification = new Notification;
                    $notification->order_id = $order->id;
                    $notification->save();
                    if($request->coupon_id != "")
                    {
                       $coupon = Coupon::findOrFail($request->coupon_id);
                       $coupon->used++;
                       if($coupon->times != null)
                       {
                            $i = (int)$coupon->times;
                            $i--;
                            $coupon->times = (string)$i;
                       }
                        $coupon->update();

                    }
                  
                    $notf = null;
                           
						 
                    foreach($cart->items as $prod)
                    {
                        if($prod['item']['user_id'] != 0)
                        {
                            $vorder =  new VendorOrder;
                            $vorder->order_id = $order->id;
                            $venid = $prod['item']['user_id'];
                            $venstate = User::all()->where('is_vendor','2')->where('id',$venid)->pluck('state')->implode(',');
                            $vengst = User::all()->where('is_vendor','2')->where('id',$venid)->pluck('reg_number')->implode(',');
                            $vorder->user_id = $prod['item']['user_id'];
							$vorder->product_id =$prod['item']['id'];
                            $notf[] = $prod['item']['user_id'];
                            $vorder->qty = $prod['qty'];
                            $vorder->price = $prod['price'];
							$venproductprice = $prod['price'];
							$users_data = User::find($prod['item']['user_id']);
							$user_commission= $users_data->percentage_commission;
							if($user_commission){
								$vorder->admin_fee = round($prod['price'] / $curr->value, 2)*$user_commission/100;
								$vencomission = round($prod['price'] / $curr->value, 2)*$user_commission/100;
							}else{
                            //$vorder->admin_fee = round($prod['price']*15/100, 2);							
							$vorder->admin_fee = round($prod['price'] / $curr->value, 2)*$rdata->percentage_commission/100;                            
                            //$vencomission = round($prod['price']*15/100, 2);
							$vencomission = round($prod['price'] / $curr->value, 2)*$rdata->percentage_commission/100;
							}
                            if($venstate == 'Tamil Nadu'){
            				    $vsgst = round($vencomission*9/100, 2);
            				    $vcgst = round($vencomission*9/100, 2);
            				    $vigst = NULL;
            				    
            				    $vengrosspayment = $venproductprice - $vencomission - $vsgst - $vcgst;
            				   
            				   if($vengst == NULL){
            				       $vtcs = '';
            				   }else{
            				      $vtcs = round($vengrosspayment*1/100, 2);
            				   }
            				    
            				} else{
            				    $vsgst = NULL;
            				    $vcgst = NULL;
            				    $vigst = round($vencomission*18/100, 2);
            				    $vtcs = NULL;
            				}
            				
            				$vorder->sgst = $vsgst;
            				$vorder->cgst = $vcgst;
            				$vorder->igst = $vigst;
            				$vorder->tcs = $vtcs;
                            
                            
                            
                            
                            $vorder->order_number = $order->order_number; 
                            $uservendor = User::findOrFail($prod['item']['user_id']);
                            $vendorstate = $uservendor->state;
                            
                           /* $vdata['sgst'] = $vendorstate;
                			$vdata['cgst'] = 1;
                			$vdata['igst'] = 1;
                			$vdata['tcs'] = 1;*/
                            $vorder->save();
                            
                        }

                    }

                    if(!empty($notf))
                    {
                        $users = array_unique($notf);
                        foreach ($users as $user) {
                            $notification = new UserNotification;
                            $notification->user_id = $user;
                            $notification->order_number = $order->order_number;
                            $notification->save();    
                        }
                    }

                    /*$gs = Generalsetting::find(1);

                    //Sending Email To Buyer

                    if($gs->is_smtp == 1)
                    {
                    $data = [
                        'to' => $request->email,
                        'type' => "new_order",
                        'cname' => $request->name,
                        'oamount' => "",
                        'aname' => "",
                        'aemail' => "",
                        'wtitle' => "",
                        'onumber' => $order->order_number,
                    ];

                    $mailer = new GeniusMailer();
                    $mailer->sendAutoOrdermail($data,$order->id);            
                    }
                    else
                    {
                        $to = $request->email;
                        $subject = "Your Order Placed!!";
                        $msg = "Hello ".$request->name."!\nYou have placed a new order.\nYour order number is ".$order->order_number.".Please wait for your delivery. \nThank you.";
                            $headers = "From: ".$gs->from_name."<".$gs->from_email.">";
                        mail($to,$subject,$msg,$headers);            
                    }
                    //Sending Email To Admin
                    if($gs->is_smtp == 1)
                    {
                        $data = [
                            'to' => Pagesetting::find(1)->contact_email,
                            'subject' => "New Order Recieved!!",
                            'body' => "Hello Admin!<br>Your store has received a new order.<br>Order Number is ".$order->order_number.".Please login to your panel to check. <br>Thank you.",
                        ];

                        $mailer = new GeniusMailer();
                        $mailer->sendCustommail($data);            
                    }
                    else
                    {
                    $to = Pagesetting::find(1)->contact_email;
                    $subject = "New Order Recieved!!";
                    $msg = "Hello Admin!\nYour store has recieved a new order.\nOrder Number is ".$order->order_number.".Please login to your panel to check. \nThank you.";
                        $headers = "From: ".$gs->from_name."<".$gs->from_email.">";
                    mail($to,$subject,$msg,$headers);
                    }*/

                    Session::put('tempcart',$cart);
                    //Session::forget('cart');
                    

                    $displayAmount = $amount = $orderData['amount'];
                    
                    if ($this->displayCurrency !== 'INR')
                    {
                        $url = "https://api.fixer.io/latest?symbols=$this->displayCurrency&base=INR";
                        $exchange = json_decode(file_get_contents($url), true);
                    
                        $displayAmount = $exchange['rates'][$this->displayCurrency] * $amount / 100;
                    }
                    
                    $checkout = 'automatic';
                    
                    if (isset($_GET['checkout']) and in_array($_GET['checkout'], ['automatic', 'manual'], true))
                    {
                        $checkout = $_GET['checkout'];
                    }
                    
                    $data = [
                        "key"               => $this->keyId,
                        "amount"            => $amount,
                        "name"              => $item_name,
                        "description"       => $item_name,
                        "prefill"           => [
							"name"              => $request->name,
							"email"             => $request->email,
							"contact"           => $request->phone,
                        ],
                        "notes"             => [
							"address"           => $request->address,
							"merchant_order_id" => $item_number,
                        ],
                        "theme"             => [
							"color"             => "{{$settings->colors}}"
                        ],
                        "order_id"          => $razorpayOrderId,
                    ];
                    
                    if ($this->displayCurrency !== 'INR')
                    {
                        $data['display_currency']  = $this->displayCurrency;
                        $data['display_amount']    = $displayAmount;
                    }
                    
                    $json = json_encode($data);
                    $displayCurrency = $this->displayCurrency;
                    
        return view( 'front.razorpay-checkout', compact( 'data','displayCurrency','json','notify_url' ) );
        
    }

    
	public function razorCallback( Request $request ) {
		
	    
	   // print_r($request);die;

	$tcs = 1;
        $success = true;

        $error = "Payment Failed";
        
        if (empty($_POST['razorpay_payment_id']) === false)
        {
            //$api = new Api($keyId, $keySecret);
        
            try
            {
                // Please note that the razorpay order ID must
                // come from a trusted source (session here, but
                // could be database or something else)
                $attributes = array(
                    'razorpay_order_id' => session('razorpay_order_id'),
                    'razorpay_payment_id' => $_POST['razorpay_payment_id'],
                    'razorpay_signature' => $_POST['razorpay_signature']
                );
        
                $this->api->utility->verifyPaymentSignature($attributes);
            }
            catch(SignatureVerificationError $e)
            {
                $success = false;
                $error = 'Razorpay Error : ' . $e->getMessage();
            }
        }
        $arr =array();
        if ($success === true)
        {
			$gs = Generalsetting::find(1);
            
            $razorpayOrder = $this->api->order->fetch(session('razorpay_order_id'));
        
            $order_id = $razorpayOrder['receipt'];
            $transaction_id = $_POST['razorpay_payment_id'];			
		    $arr[] =  $this->api->payment->fetch($transaction_id);
			
            $order = Order::where( 'order_number', $order_id )->first();
			
			$vorder = VendorOrder::where( 'order_number', $order_id );
			$vdata['status'] = 'processing';
			
            
            if (isset($order)) {
                $data['txnid'] = $transaction_id;
                $data['payment_status'] = 'Completed';
                if($order->dp == 1)
         
	 {
                    $data['status'] = 'completed';
                }else{
					$data['status'] = 'processing';
				}			
				$data['od_card_type'] = $arr[0]->method;
				if($arr[0]->bank){
                $data['od_card_name'] = $arr[0]->bank;
			}else if($arr[0]->wallet){
				$data['od_card_name'] = $arr[0]->wallet;
			}else if($arr[0]->vpa){
				$data['od_card_name'] = $arr[0]->vpa;
			}
                $order->update($data);
				$vorder->update($vdata);
				 $Cart_data = Session::get('tempcart');
                  $cart = new Cart($Cart_data);
                  
                 foreach($cart->items as $prod)
              {
                   $x = (string)$prod['size_qty'];
            if(!empty($x))
            {
                $product = Product::findOrFail($prod['item']['id']);
                $x = (int)$x;
                $x = $x - $prod['qty'];
                $temp = $product->size_qty;
                $temp[$prod['size_key']] = $x;
                $temp1 = implode(',', $temp);
				$popular_count = $product->popular_count+1;
                $product->popular_count =  $popular_count;
                $product->size_qty =  $temp1;
                $product->update();               
            }
        }


        foreach($cart->items as $prod)
        {
            $x = (string)$prod['stock'];
            if($x != null)
            {

                $product = Product::findOrFail($prod['item']['id']);
				$x = (int)$x;
                $x = $x+1 - $prod['qty'];
                $popular_count = $product->popular_count+1;
                $product->popular_count =  $popular_count;				
                $product->stock =  $x;
                $product->update();  
                if($product->stock <= 5)
                {
                    $notification = new Notification;
                    $notification->product_id = $product->id;
                    $notification->save();                    
                }              
            }
        }
	
$email=env('ADMIN_EMAIL');		 
$admindata = Admin::where('email',$email)->first(); 
$admin_em = Pagesetting::find(1)->contact_email;	 
$to = $order->customer_email;
$subject = 'Your order '.$order->order_number.' has been confirmed';
$admin_subject = '[South India Jewels]: New order #'.$order->order_number;

 
// To send HTML mail, the Content-type header must be set
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
 
// Create email headers
$headers .= 'From: '.$gs->from_email."\r\n".
    'Reply-To: '.$gs->from_email."\r\n" .
    'X-Mailer: PHP/' . phpversion();
 
// Compose a simple HTML email message

$msg = '<div marginwidth="0" marginheight="0" style="padding:0">
   <div dir="ltr" style="background-color:#f5f5f5;margin:0;padding:70px 0;width:100%">
      <font color="#888888">
      </font>
      <table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%">
         <tbody>
            <tr>
               <td align="center" valign="top">
                  <div>
                     <p style="margin-top:0"><img src="https://pwokes.stripocdn.email/content/guids/CABINET_f3702042fc6f59954d9f14937bd051c9/images/26811626242635311.png" width="200px" alt="South India Jewels" style="border:none;display:inline-block;font-size:14px;font-weight:bold;height:auto;outline:none;text-decoration:none;text-transform:capitalize;vertical-align:middle;max-width:100%;margin-left:0;margin-right:0" class="CToWUd"></p>
                  </div>
                  <font color="#888888">
                  </font><font color="#888888">
                  </font>
                  <table border="0" cellpadding="0" cellspacing="0" width="600" style="background-color:#fdfdfd;border:1px solid #dcdcdc;border-radius:3px">
                     <tbody>
                        <tr>
                           <td align="center" valign="top">
                              <table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color:#111111;color:#ffffff;border-bottom:0;font-weight:bold;line-height:100%;vertical-align:middle;border-radius:3px 3px 0 0">
                                 <tbody>
                                    <tr>
                                       <td style="padding:36px 48px;display:block">
                                          <h1 style="font-size:30px;font-weight:300;line-height:150%;margin:0;text-align:left;color:#ffffff"><span class="il">New</span> <span class="il">Order</span>: #'.$order_id.'</h1>
                                       </td>
                                    </tr>
                                 </tbody>
                              </table>
                           </td>
                        </tr>
                        <tr>
                           <td align="center" valign="top">
                              <font color="#888888">
                              </font><font color="#888888">
                              </font>
                              <table border="0" cellpadding="0" cellspacing="0" width="600">
                                 <tbody>
                                    <tr>
                                       <td valign="top" style="background-color:#fdfdfd">
                                          <font color="#888888">
                                          </font><font color="#888888">
                                          </font>
                                          <table border="0" cellpadding="20" cellspacing="0" width="100%">
                                             <tbody>
                                                <tr>
                                                   <td valign="top" style="padding:48px 48px 32px">
                                                      <div style="color:#717a7a;font-size:14px;line-height:150%;text-align:left">
                                                         <p style="margin:0 0 16px">Hi '.$order->customer_name.',</p>
                                                         <p style="margin:0 0 16px">Thanks for shop on SIJ— we have received your order #'.$order_id.', and it is now being processed.</p>
                                                         <h2 style="color:#111111;display:block;font-size:18px;font-weight:bold;line-height:130%;margin:0 0 18px;text-align:left">
                                                            <a href="https://shop.southindiajewels.com/demo/wp-admin/post.php?post=10439&amp;action=edit" style="font-weight:normal;text-decoration:underline;color:#111111" target="_blank">[<span class="il">Order</span> #'.$order_id.']</a> ('.date('M d,Y',strtotime($order->created_at)).')
                                                         </h2>
                                                         <div style="margin-bottom:40px">
                                                            <table cellspacing="0" cellpadding="6" border="1" style="color:#717a7a;border:1px solid #e4e4e4;vertical-align:middle;width:100%;">
                                                               <thead>
                                                                  <tr>
                                                                     <th scope="col" style="color:#717a7a;border:1px solid #e4e4e4;vertical-align:middle;padding:12px;text-align:left">Product</th>
                                                                     <th scope="col" style="color:#717a7a;border:1px solid #e4e4e4;vertical-align:middle;padding:12px;text-align:left">Quantity</th>
                                                                     <th scope="col" style="color:#717a7a;border:1px solid #e4e4e4;vertical-align:middle;padding:12px;text-align:left">Price</th>
                                                                  </tr>
                                                               </thead>
                                                               <tbody>';
                              $product_tot_price=0;
							  $product_imag='';
							  //$product_count=count($cart->items);
							  $product_count=0;
							  foreach($cart->items as $prod)
        {
			$ProductDetails = Product::findOrFail($prod['item']['id']);
			$usersid = User::findOrFail($prod['item']['user_id']);
			$product_imag=$prod['item']['photo'] ? filter_var($prod['item']['photo'], FILTER_VALIDATE_URL) ?$prod['item']['photo']:asset('assets/images/products/'.$prod['item']['photo']):asset('assets/images/noimage.png') ;
		    $product_count +=$prod['qty'];
			$product_tot_price += round($prod['item']['price'] *$prod['qty'] * $order->currency_value , 2);
                           $msg .='<tr>
                                                                     <td  style="color:#717a7a;border:1px solid #e4e4e4;padding:12px;text-align:left;vertical-align:middle;"><a href="#" target="_blank">
                                                                  <img src="'.$product_imag.'" alt="'.$prod['item']['name'].'" class="adapt-img" title="'.$prod['item']['name'].'" width="50" layout="responsive">
                                                               </a><br />'.$prod['item']['name'].'<br /> Sold By : '.$usersid->shop_name.'';
																	 if(!empty($prod['keys'])){
  foreach( array_combine(explode(',', $prod['keys']), explode(',', $prod['values']))  as $key => $value) {
   $msg .='<br />'.ucwords(str_replace('_', ' ', $key)).'   '.$value.'</td>';
  }
}
if($prod['size']){
	 $msg .='<br /><strong>Option :</strong>'.str_replace('-',' ',$prod['size']).'   </td>';
}
                                                                     $msg .='<td  style="color:#717a7a;border:1px solid #e4e4e4;padding:12px;text-align:left;vertical-align:middle;" width="60">'.$prod['qty'].'</td><td style="color:#717a7a;border:1px solid #e4e4e4;padding:12px;text-align:left;vertical-align:middle;">'.$order->currency_sign.''.round($prod['item']['price'] * $order->currency_value , 2).'</td>
                                                                  
                              </tr>';
} 
                            
                             
                             $msg .='</tbody>
                                                               <tfoot>
                                                                  <tr>
                                                                     <th scope="row" colspan="2" style="color:#717a7a;border:1px solid #e4e4e4;vertical-align:middle;padding:12px;text-align:left;border-top-width:4px">Subtotal ('.$product_count.' items):</th>
                                                                     <td style="color:#717a7a;border:1px solid #e4e4e4;vertical-align:middle;padding:12px;text-align:left;border-top-width:4px"><span><span>'.$order->currency_sign.'</span>'.$product_tot_price.'</span></td>
                                                                  </tr>';
														 
														 @$ship_cost = @$order->shipping_cost + @$order->packing_cost;
														 if(@$ship_cost){
                                                         $msg .='<tr>
                                                            <th scope="row" colspan="2" style="color:#717a7a;border:1px solid #e4e4e4;vertical-align:middle;padding:12px;text-align:left">Shipping:</th>
                                                             <td style="color:#717a7a;border:1px solid #e4e4e4;vertical-align:middle;padding:12px;text-align:left"></td>
                                                         </tr>';
														 }else{
														     $msg .='<tr>
                                                            <th scope="row" colspan="2" style="color:#717a7a;border:1px solid #e4e4e4;vertical-align:middle;padding:12px;text-align:left">Shipping:</th>
                                                            <td style="color:#717a7a;border:1px solid #e4e4e4;vertical-align:middle;padding:12px;text-align:left">Free shipping</td>
                                                         </tr>';
														 }
                                                                  $msg .='
                                                                  <tr>
                                                                     <th scope="row" colspan="2" style="color:#717a7a;border:1px solid #e4e4e4;vertical-align:middle;padding:12px;text-align:left">Payment method:</th>
                                                                     <td style="color:#717a7a;border:1px solid #e4e4e4;vertical-align:middle;padding:12px;text-align:left">'.$order->method.'</td>
                                                                  </tr>
                                                                  <tr>
                                                                     <th scope="row" colspan="2" style="color:#717a7a;border:1px solid #e4e4e4;vertical-align:middle;padding:12px;text-align:left">Total:</th>
                                                                     <td style="color:#717a7a;border:1px solid #e4e4e4;vertical-align:middle;padding:12px;text-align:left"><span><span>'.$order->currency_sign.'</span> '.round($order->pay_amount * $order->currency_value , 2).'</span></td>
                                                                  </tr>
                                                               </tfoot>
                                                            </table>
                                                         </div>
                                                         <div style="display:none;font-size:0;max-height:0;line-height:0;padding:0"></div>
                                                         <table cellspacing="0" cellpadding="0" border="0" style="width:100%;vertical-align:top;margin-bottom:40px;padding:0">
                                                            <tbody>
                                                               <tr>
                                                                  <td valign="top" width="50%" style="text-align:left;border:0;padding:0">
                                                                     <h2 style="color:#111111;display:block;font-family:&quot;Helvetica Neue&quot;,Helvetica,Roboto,Arial,sans-serif;font-size:18px;font-weight:bold;line-height:130%;margin:0 0 18px;text-align:left">Billing address</h2>
                                                                     <address style="padding:12px;color:#717a7a;border:1px solid #e4e4e4">
                                                                        '.$order->customer_name.'<br>'.$order->customer_address.', '.$order->customer_city.'<br>'.$order->customer_state.', '.$order->customer_country.' '.$order->customer_zip.'<br><a href="tel:'.$order->customer_phone.'" style="color:#111111;font-weight:normal;text-decoration:underline" target="_blank">'.$order->customer_phone.'</a>													<br><a href="mailto:'.$order->customer_email.'" target="_blank">'.$order->customer_email.'</a>							
                                                                     </address>
                                                                  </td>
                                                                  <td valign="top" width="50%" style="text-align:left;padding:0">
                                                                     <h2 style="color:#111111;display:block;font-family:&quot;Helvetica Neue&quot;,Helvetica,Roboto,Arial,sans-serif;font-size:18px;font-weight:bold;line-height:130%;margin:0 0 18px;text-align:left">Shipping address</h2>
                                                                     <address style="padding:12px;color:#717a7a;border:1px solid #e4e4e4"> '.$order->customer_name.'<br>'.$order->customer_address.', '.$order->customer_city.'<br>'.$order->customer_state.', '.$order->customer_country.' '.$order->customer_zip.'</address>
                                                                  </td>
                                                               </tr>
                                                            </tbody>
                                                         </table>
                                                         <p style="margin:0 0 16px">Thanks for using shop.southindiajewels.com! Your order will be shipped in 3 to 5 business days.</p>
                                                         <font color="#888888">
                                                         </font>
                                                      </div>
                                                      <font color="#888888">
                                                      </font>
                                                   </td>
                                                </tr>
                                             </tbody>
                                          </table>
                                          <font color="#888888">
                                          </font>
                                       </td>
                                    </tr>
                                 </tbody>
                              </table>
                              <font color="#888888">
                              </font>
                           </td>
                        </tr>
                     </tbody>
                  </table>
                  <font color="#888888">
                  </font>
               </td>
            </tr>
            <tr>
               <td align="center" valign="top">
                  <table border="0" cellpadding="10" cellspacing="0" width="600">
                     <tbody>
                        <tr>
                           <td valign="top" style="padding:0;border-radius:6px">
                              <table border="0" cellpadding="10" cellspacing="0" width="100%">
                                 <tbody>
                                    <tr>
                                       <td colspan="2" valign="middle" style="border-radius:6px;border:0;color:#949b9b;font-family:&quot;Helvetica Neue&quot;,Helvetica,Roboto,Arial,sans-serif;font-size:12px;line-height:150%;text-align:center;padding:24px 0">
                                          <p style="margin:0 0 16px"><span class="il">South</span> <span class="il">India</span> <span class="il">Jewels</span></p>
                                       </td>
                                    </tr>
                                 </tbody>
                              </table>
                           </td>
                        </tr>
                     </tbody>
                  </table>
               </td>
            </tr>
         </tbody>
      </table>
      <div class="yj6qo"></div>
      <div class="adL">
      </div>
   </div>
   <div class="adL">
   </div>
</div>';






$admin_msg = '<div marginwidth="0" marginheight="0" style="padding:0">
   <div dir="ltr" style="background-color:#f5f5f5;margin:0;padding:70px 0;width:100%">
      <font color="#888888">
      </font>
      <table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%">
         <tbody>
            <tr>
               <td align="center" valign="top">
                  <div>
                     <p style="margin-top:0"><img src="https://pwokes.stripocdn.email/content/guids/CABINET_f3702042fc6f59954d9f14937bd051c9/images/26811626242635311.png" width="200px" alt="South India Jewels" style="border:none;display:inline-block;font-size:14px;font-weight:bold;height:auto;outline:none;text-decoration:none;text-transform:capitalize;vertical-align:middle;max-width:100%;margin-left:0;margin-right:0" class="CToWUd"></p>
                  </div>
                  <font color="#888888">
                  </font><font color="#888888">
                  </font>
                  <table border="0" cellpadding="0" cellspacing="0" width="600" style="background-color:#fdfdfd;border:1px solid #dcdcdc;border-radius:3px">
                     <tbody>
                        <tr>
                           <td align="center" valign="top">
                              <table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color:#111111;color:#ffffff;border-bottom:0;font-weight:bold;line-height:100%;vertical-align:middle;border-radius:3px 3px 0 0">
                                 <tbody>
                                    <tr>
                                       <td style="padding:36px 48px;display:block">
                                          <h1 style="font-size:30px;font-weight:300;line-height:150%;margin:0;text-align:left;color:#ffffff"><span class="il">New</span> <span class="il">Order</span>: #'.$order_id.'</h1>
                                       </td>
                                    </tr>
                                 </tbody>
                              </table>
                           </td>
                        </tr>
                        <tr>
                           <td align="center" valign="top">
                              <font color="#888888">
                              </font><font color="#888888">
                              </font>
                              <table border="0" cellpadding="0" cellspacing="0" width="600">
                                 <tbody>
                                    <tr>
                                       <td valign="top" style="background-color:#fdfdfd">
                                          <font color="#888888">
                                          </font><font color="#888888">
                                          </font>
                                          <table border="0" cellpadding="20" cellspacing="0" width="100%">
                                             <tbody>
                                                <tr>
                                                   <td valign="top" style="padding:48px 48px 32px">
                                                      <div style="color:#717a7a;font-size:14px;line-height:150%;text-align:left">
                                                         <p style="margin:0 0 16px">You’ve received the following order from '.$order->customer_name.':</p>
                                                        
                                                         <h2 style="color:#111111;display:block;font-size:18px;font-weight:bold;line-height:130%;margin:0 0 18px;text-align:left">
                                                            <a href="https://shop.southindiajewels.com/demo/wp-admin/post.php?post=10439&amp;action=edit" style="font-weight:normal;text-decoration:underline;color:#111111" target="_blank">[<span class="il">Order</span> #'.$order_id.']</a> ('.date('M d,Y',strtotime($order->created_at)).')
                                                         </h2>
                                                         <div style="margin-bottom:40px">
                                                            <table cellspacing="0" cellpadding="6" border="1" style="color:#717a7a;border:1px solid #e4e4e4;vertical-align:middle;width:100%;">
                                                               <thead>
                                                                  <tr>
                                                                     <th scope="col" style="color:#717a7a;border:1px solid #e4e4e4;vertical-align:middle;padding:12px;text-align:left">Product</th>
                                                                     <th scope="col" style="color:#717a7a;border:1px solid #e4e4e4;vertical-align:middle;padding:12px;text-align:left">Quantity</th>
                                                                     <th scope="col" style="color:#717a7a;border:1px solid #e4e4e4;vertical-align:middle;padding:12px;text-align:left">Price</th>
                                                                  </tr>
                                                               </thead>
                                                               <tbody>';
                              $product_tot_price=0;
							  $product_imag='';
							  //$product_count=count($cart->items);
							  $product_count=0;
							  foreach($cart->items as $prod)
        {
			$ProductDetails = Product::findOrFail($prod['item']['id']);
			$usersid = User::findOrFail($prod['item']['user_id']);
			$product_imag=$prod['item']['photo'] ? filter_var($prod['item']['photo'], FILTER_VALIDATE_URL) ?$prod['item']['photo']:asset('assets/images/products/'.$prod['item']['photo']):asset('assets/images/noimage.png') ;
		    $product_count +=$prod['qty'];
			$product_tot_price += round($prod['item']['price'] *$prod['qty'] * $order->currency_value , 2);
                           $admin_msg .='<tr>
                                                                     <td  style="color:#717a7a;border:1px solid #e4e4e4;padding:12px;text-align:left;vertical-align:middle;"><a href="#" target="_blank">
                                                                  <img src="'.$product_imag.'" alt="'.$prod['item']['name'].'" class="adapt-img" title="'.$prod['item']['name'].'" width="50" layout="responsive">
                                                               </a><br />'.$prod['item']['name'].'<br /> Sold By : '.$usersid->shop_name.'';
																	 if(!empty($prod['keys'])){
  foreach( array_combine(explode(',', $prod['keys']), explode(',', $prod['values']))  as $key => $value) {
   $admin_msg .='<br />'.ucwords(str_replace('_', ' ', $key)).'   '.$value.'</td>';
  }
}
if($prod['size']){
	 $admin_msg .='<br /><strong>Option :</strong>'.str_replace('-',' ',$prod['size']).'   </td>';
}
                                                                     $admin_msg .='<td  style="color:#717a7a;border:1px solid #e4e4e4;padding:12px;text-align:left;vertical-align:middle;" width="60">'.$prod['qty'].'</td><td style="color:#717a7a;border:1px solid #e4e4e4;padding:12px;text-align:left;vertical-align:middle;">'.$order->currency_sign.''.round($prod['item']['price'] * $order->currency_value , 2).'</td>
                                                                  
                              </tr>';
} 
                            
                             
                             $admin_msg .='</tbody>
                                                               <tfoot>
                                                                  <tr>
                                                                     <th scope="row" colspan="2" style="color:#717a7a;border:1px solid #e4e4e4;vertical-align:middle;padding:12px;text-align:left;border-top-width:4px">Subtotal ('.$product_count.' items):</th>
                                                                     <td style="color:#717a7a;border:1px solid #e4e4e4;vertical-align:middle;padding:12px;text-align:left;border-top-width:4px"><span><span>'.$order->currency_sign.'</span>'.$product_tot_price.'</span></td>
                                                                  </tr>';
														 
														 @$ship_cost = @$order->shipping_cost + @$order->packing_cost;
														 if(@$ship_cost){
                                                         $msg .='<tr>
                                                            <th scope="row" colspan="2" style="color:#717a7a;border:1px solid #e4e4e4;vertical-align:middle;padding:12px;text-align:left">Shipping:</th>
                                                             <td style="color:#717a7a;border:1px solid #e4e4e4;vertical-align:middle;padding:12px;text-align:left"></td>
                                                         </tr>';
														 }else{
														     $admin_msg .='<tr>
                                                            <th scope="row" colspan="2" style="color:#717a7a;border:1px solid #e4e4e4;vertical-align:middle;padding:12px;text-align:left">Shipping:</th>
                                                            <td style="color:#717a7a;border:1px solid #e4e4e4;vertical-align:middle;padding:12px;text-align:left">Free shipping</td>
                                                         </tr>';
														 }
                                                                  $admin_msg .='
                                                                  <tr>
                                                                     <th scope="row" colspan="2" style="color:#717a7a;border:1px solid #e4e4e4;vertical-align:middle;padding:12px;text-align:left">Payment method:</th>
                                                                     <td style="color:#717a7a;border:1px solid #e4e4e4;vertical-align:middle;padding:12px;text-align:left">'.$order->method.'</td>
                                                                  </tr>
                                                                  <tr>
                                                                     <th scope="row" colspan="2" style="color:#717a7a;border:1px solid #e4e4e4;vertical-align:middle;padding:12px;text-align:left">Total:</th>
                                                                     <td style="color:#717a7a;border:1px solid #e4e4e4;vertical-align:middle;padding:12px;text-align:left"><span><span>'.$order->currency_sign.'</span> '.round($order->pay_amount * $order->currency_value , 2).'</span></td>
                                                                  </tr>
                                                               </tfoot>
                                                            </table>
                                                         </div>
                                                         <div style="display:none;font-size:0;max-height:0;line-height:0;padding:0"></div>
                                                         <table cellspacing="0" cellpadding="0" border="0" style="width:100%;vertical-align:top;margin-bottom:40px;padding:0">
                                                            <tbody>
                                                               <tr>
                                                                  <td valign="top" width="50%" style="text-align:left;border:0;padding:0">
                                                                     <h2 style="color:#111111;display:block;font-family:&quot;Helvetica Neue&quot;,Helvetica,Roboto,Arial,sans-serif;font-size:18px;font-weight:bold;line-height:130%;margin:0 0 18px;text-align:left">Billing address</h2>
                                                                     <address style="padding:12px;color:#717a7a;border:1px solid #e4e4e4">
                                                                        '.$order->customer_name.'<br>'.$order->customer_address.', '.$order->customer_city.'<br>'.$order->customer_state.', '.$order->customer_country.' '.$order->customer_zip.'<br><a href="tel:'.$order->customer_phone.'" style="color:#111111;font-weight:normal;text-decoration:underline" target="_blank">'.$order->customer_phone.'</a>													<br><a href="mailto:'.$order->customer_email.'" target="_blank">'.$order->customer_email.'</a>							
                                                                     </address>
                                                                  </td>
                                                                  <td valign="top" width="50%" style="text-align:left;padding:0">
                                                                     <h2 style="color:#111111;display:block;font-family:&quot;Helvetica Neue&quot;,Helvetica,Roboto,Arial,sans-serif;font-size:18px;font-weight:bold;line-height:130%;margin:0 0 18px;text-align:left">Shipping address</h2>
                                                                     <address style="padding:12px;color:#717a7a;border:1px solid #e4e4e4"> '.$order->customer_name.'<br>'.$order->customer_address.', '.$order->customer_city.'<br>'.$order->customer_state.', '.$order->customer_country.' '.$order->customer_zip.'</address>
                                                                  </td>
                                                               </tr>
                                                            </tbody>
                                                         </table>
                                                         <p style="margin:0 0 16px">Congratulations on the sale.</p>
                                                         <font color="#888888">
                                                         </font>
                                                      </div>
                                                      <font color="#888888">
                                                      </font>
                                                   </td>
                                                </tr>
                                             </tbody>
                                          </table>
                                          <font color="#888888">
                                          </font>
                                       </td>
                                    </tr>
                                 </tbody>
                              </table>
                              <font color="#888888">
                              </font>
                           </td>
                        </tr>
                     </tbody>
                  </table>
                  <font color="#888888">
                  </font>
               </td>
            </tr>
            <tr>
               <td align="center" valign="top">
                  <table border="0" cellpadding="10" cellspacing="0" width="600">
                     <tbody>
                        <tr>
                           <td valign="top" style="padding:0;border-radius:6px">
                              <table border="0" cellpadding="10" cellspacing="0" width="100%">
                                 <tbody>
                                    <tr>
                                       <td colspan="2" valign="middle" style="border-radius:6px;border:0;color:#949b9b;font-family:&quot;Helvetica Neue&quot;,Helvetica,Roboto,Arial,sans-serif;font-size:12px;line-height:150%;text-align:center;padding:24px 0">
                                          <p style="margin:0 0 16px"><span class="il">South</span> <span class="il">India</span> <span class="il">Jewels</span></p>
                                       </td>
                                    </tr>
                                 </tbody>
                              </table>
                           </td>
                        </tr>
                     </tbody>
                  </table>
               </td>
            </tr>
         </tbody>
      </table>
      <div class="yj6qo"></div>
      <div class="adL">
      </div>
   </div>
   <div class="adL">
   </div>
</div>';
   
 
    
   
   $user_data = array();
                    foreach($cart->items as $prod)
        {
                            $user_data[] = $prod['item']['user_id'];
                    }
                   $user_data = array_unique($user_data);
                   $user_data = array_values($user_data);
                    
	foreach($user_data as $user_per) {	
	
   $user_info= User::findOrFail($user_per);   
   $vendor_subject = '[South India Jewels] New Store Order ('.$order->order_number.') - '.date('M d, Y',strtotime($order->created_at));
   $vendor_em = 'vendor@southindiajewels.co.in';   
  //$vendor_em = $user_info->email;
  
  
  
  
  
  $vendor_msg = '<div marginwidth="0" marginheight="0" style="padding:0">
   <div dir="ltr" style="background-color:#f5f5f5;margin:0;padding:70px 0;width:100%">
      <font color="#888888">
      </font>
      <table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%">
         <tbody>
            <tr>
               <td align="center" valign="top">
                  <div>
                     <p style="margin-top:0"><img src="https://pwokes.stripocdn.email/content/guids/CABINET_f3702042fc6f59954d9f14937bd051c9/images/26811626242635311.png" width="200px" alt="South India Jewels" style="border:none;display:inline-block;font-size:14px;font-weight:bold;height:auto;outline:none;text-decoration:none;text-transform:capitalize;vertical-align:middle;max-width:100%;margin-left:0;margin-right:0" class="CToWUd"></p>
                  </div>
                  <font color="#888888">
                  </font><font color="#888888">
                  </font>
                  <table border="0" cellpadding="0" cellspacing="0" width="600" style="background-color:#fdfdfd;border:1px solid #dcdcdc;border-radius:3px">
                     <tbody>
                        <tr>
                           <td align="center" valign="top">
                              <table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color:#111111;color:#ffffff;border-bottom:0;font-weight:bold;line-height:100%;vertical-align:middle;border-radius:3px 3px 0 0">
                                 <tbody>
                                    <tr>
                                       <td style="padding:36px 48px;display:block">
                                          <h1 style="font-size:30px;font-weight:300;line-height:150%;margin:0;text-align:left;color:#ffffff"><span class="il">New</span> <span class="il">Order</span>: #'.$order_id.'</h1>
                                       </td>
                                    </tr>
                                 </tbody>
                              </table>
                           </td>
                        </tr>
                        <tr>
                           <td align="center" valign="top">
                              <font color="#888888">
                              </font><font color="#888888">
                              </font>
                              <table border="0" cellpadding="0" cellspacing="0" width="600">
                                 <tbody>
                                    <tr>
                                       <td valign="top" style="background-color:#fdfdfd">
                                          <font color="#888888">
                                          </font><font color="#888888">
                                          </font>
                                          <table border="0" cellpadding="20" cellspacing="0" width="100%">
                                             <tbody>
                                                <tr>
                                                   <td valign="top" style="padding:48px 48px 32px">
                                                      <div style="color:#717a7a;font-size:14px;line-height:150%;text-align:left">
                                                         <p style="margin:0 0 16px">A new order was received from '.$order->customer_name.'. Order details is as follows:</p>
                                                        
                                                         <h2 style="color:#111111;display:block;font-size:18px;font-weight:bold;line-height:130%;margin:0 0 18px;text-align:left">
                                                            <a href="https://shop.southindiajewels.com/demo/wp-admin/post.php?post=10439&amp;action=edit" style="font-weight:normal;text-decoration:underline;color:#111111" target="_blank">[<span class="il">Order</span> #'.$order_id.']</a> ('.date('M d,Y',strtotime($order->created_at)).')
                                                         </h2>
                                                         <div style="margin-bottom:40px">
                                                            <table cellspacing="0" cellpadding="6" border="1" style="color:#717a7a;border:1px solid #e4e4e4;vertical-align:middle;width:100%;">
                                                               <thead>
                                                                  <tr>
                                                                     <th scope="col" style="color:#717a7a;border:1px solid #e4e4e4;vertical-align:middle;padding:12px;text-align:left">Product</th>
                                                                     <th scope="col" style="color:#717a7a;border:1px solid #e4e4e4;vertical-align:middle;padding:12px;text-align:left">Quantity</th>
                                                                     <th scope="col" style="color:#717a7a;border:1px solid #e4e4e4;vertical-align:middle;padding:12px;text-align:left">Price</th>
                                                                  </tr>
                                                               </thead>
                                                               <tbody>';
                                                               
                                                               
                                                               $product_tot_price=0;
							  $product_imag='';
							   $admin_product_counts=0;
							  $admin_product_count=array();
							  //$product_count=count($cart->items);
							  foreach($cart->items as $prod)
        {
			$product_user_id=$prod['item']['user_id'];
			if($product_user_id==$user_per){
			$ProductDetails = Product::findOrFail($prod['item']['id']);
            $admin_product_counts +=$prod['qty'];
            $admin_product_count[$user_per]=$admin_product_counts;			
			$usersid = User::findOrFail($prod['item']['user_id']);
			$product_imag=$prod['item']['photo'] ? filter_var($prod['item']['photo'], FILTER_VALIDATE_URL) ?$prod['item']['photo']:asset('assets/images/products/'.$prod['item']['photo']):asset('assets/images/noimage.png') ;
		
			$product_tot_price  += round($prod['item']['price'] *$prod['qty'] * $order->currency_value , 2);
                           $vendor_msg .='<tr>
                                                                     <td style="color:#717a7a;border:1px solid #e4e4e4;padding:12px;text-align:left;vertical-align:middle;"><a href="#" target="_blank">
                                                                    <img src="'.$product_imag.'" alt="'.$prod['item']['name'].'" class="adapt-img" title="'.$prod['item']['name'].'" width="50" layout="responsive">
                                                               </a><br />'.$prod['item']['name'].'<br /> Sold By : '.$usersid->shop_name.'';
																	 if(!empty($prod['keys'])){
  foreach( array_combine(explode(',', $prod['keys']), explode(',', $prod['values']))  as $key => $value) {
   $vendor_msg .='<br />'.ucwords(str_replace('_', ' ', $key)).'   '.$value.'</td>';
  }
}
if($prod['size']){
	 $vendor_msg .='<br /><strong>Option :</strong>'.str_replace('-',' ',$prod['size']).'   </td>';
	 }
                                                                    $vendor_msg .='<td  style="color:#717a7a;border:1px solid #e4e4e4;padding:12px;text-align:left;vertical-align:middle;" width="60">'.$prod['qty'].'</td>
                                                                    
                                                                     <td style="color:#717a7a;border:1px solid #e4e4e4;padding:12px;text-align:left;vertical-align:middle;">'.$order->currency_sign.''.round($prod['item']['price'] * $prod['qty'] * $order->currency_value , 2).'</td>
                                                                 
                              </tr>';
		}
                             
		} 
                            
                      
                             
                             $vendor_msg .='</tbody>
                                                               <tfoot>
                                                                  <tr>
                                                                     <th scope="row" colspan="2" style="color:#717a7a;border:1px solid #e4e4e4;vertical-align:middle;padding:12px;text-align:left;border-top-width:4px">Subtotal :</th>
                                                                     <td style="color:#717a7a;border:1px solid #e4e4e4;vertical-align:middle;padding:12px;text-align:left;border-top-width:4px"><span><span>'.$order->currency_sign.'</span>'.$product_tot_price.'</span></td>
                                                                  </tr>';
														 
													$vendor_msg .='
                                                                  <tr>
                                                                     <th scope="row" colspan="2" style="color:#717a7a;border:1px solid #e4e4e4;vertical-align:middle;padding:12px;text-align:left">Payment method:</th>
                                                                     <td style="color:#717a7a;border:1px solid #e4e4e4;vertical-align:middle;padding:12px;text-align:left">'.$order->method.'</td>
                                                                  </tr>
                                                                  <tr>
                                                                     <th scope="row" colspan="2" style="color:#717a7a;border:1px solid #e4e4e4;vertical-align:middle;padding:12px;text-align:left">Total:</th>
                                                                     <td style="color:#717a7a;border:1px solid #e4e4e4;vertical-align:middle;padding:12px;text-align:left"><span><span>'.$order->currency_sign.'</span> '.$product_tot_price.'</span></td>
                                                                  </tr>
                                                               </tfoot>
                                                            </table>
                                                         </div>
                                                         <div style="display:none;font-size:0;max-height:0;line-height:0;padding:0"></div>
                                                         <table cellspacing="0" cellpadding="0" border="0" style="width:100%;vertical-align:top;margin-bottom:40px;padding:0">
                                                            <tbody>
                                                               <tr>
                                                                  <td valign="top" width="50%" style="text-align:left;border:0;padding:0">
                                                                     <h2 style="color:#111111;display:block;font-family:&quot;Helvetica Neue&quot;,Helvetica,Roboto,Arial,sans-serif;font-size:18px;font-weight:bold;line-height:130%;margin:0 0 18px;text-align:left">Billing address</h2>
                                                                     <address style="padding:12px;color:#717a7a;border:1px solid #e4e4e4">
                                                                        '.$order->customer_name.'<br>'.$order->customer_address.', '.$order->customer_city.'<br>'.$order->customer_state.', '.$order->customer_country.' '.$order->customer_zip.'<br><a href="tel:'.$order->customer_phone.'" style="color:#111111;font-weight:normal;text-decoration:underline" target="_blank">'.$order->customer_phone.'</a>													<br><a href="mailto:'.$order->customer_email.'" target="_blank">'.$order->customer_email.'</a>							
                                                                     </address>
                                                                  </td>
                                                                  <td valign="top" width="50%" style="text-align:left;padding:0">
                                                                     <h2 style="color:#111111;display:block;font-family:&quot;Helvetica Neue&quot;,Helvetica,Roboto,Arial,sans-serif;font-size:18px;font-weight:bold;line-height:130%;margin:0 0 18px;text-align:left">Shipping address</h2>
                                                                     <address style="padding:12px;color:#717a7a;border:1px solid #e4e4e4"> '.$order->customer_name.'<br>'.$order->customer_address.', '.$order->customer_city.'<br>'.$order->customer_state.', '.$order->customer_country.' '.$order->customer_zip.'</address>
                                                                  </td>
                                                               </tr>
                                                            </tbody>
                                                         </table>
                                                         <p style="margin:0 0 16px">Congratulations on the sale.</p>
                                                         <font color="#888888">
                                                         </font>
                                                      </div>
                                                      <font color="#888888">
                                                      </font>
                                                   </td>
                                                </tr>
                                             </tbody>
                                          </table>
                                          <font color="#888888">
                                          </font>
                                       </td>
                                    </tr>
                                 </tbody>
                              </table>
                              <font color="#888888">
                              </font>
                           </td>
                        </tr>
                     </tbody>
                  </table>
                  <font color="#888888">
                  </font>
               </td>
            </tr>
            <tr>
               <td align="center" valign="top">
                  <table border="0" cellpadding="10" cellspacing="0" width="600">
                     <tbody>
                        <tr>
                           <td valign="top" style="padding:0;border-radius:6px">
                              <table border="0" cellpadding="10" cellspacing="0" width="100%">
                                 <tbody>
                                    <tr>
                                       <td colspan="2" valign="middle" style="border-radius:6px;border:0;color:#949b9b;font-family:&quot;Helvetica Neue&quot;,Helvetica,Roboto,Arial,sans-serif;font-size:12px;line-height:150%;text-align:center;padding:24px 0">
                                          <p style="margin:0 0 16px"><span class="il">South</span> <span class="il">India</span> <span class="il">Jewels</span></p>
                                       </td>
                                    </tr>
                                 </tbody>
                              </table>
                           </td>
                        </tr>
                     </tbody>
                  </table>
               </td>
            </tr>
         </tbody>
      </table>
      <div class="yj6qo"></div>
      <div class="adL">
      </div>
   </div>
   <div class="adL">
   </div>
</div>'; 
  $vendorDemo = new \stdClass();
        $vendorDemo->to = $vendor_em;
        $vendorDemo->from = $gs->from_email;
        $vendorDemo->title = $gs->from_name;
        $vendorDemo->subject =$vendor_subject ;
        $vid= $order->id;
		$vendordata = [
            'email_body' => $vendor_msg
        ];
		
		 Mail::send('admin.email.mailbody',$vendordata, function ($vendormessage) use ($vendorDemo,$vid) {
                $vendormessage->from($vendorDemo->from,$vendorDemo->title);
                $vendormessage->to($vendorDemo->to);
                $vendormessage->subject($vendorDemo->subject);
                $order = Order::findOrFail($vid);
                $cart = unserialize(bzdecompress(utf8_decode($order->cart)));
                $fileName = public_path('assets/temp_files/').str_random(4).time().'.pdf';
                $pdf = PDF::loadView('print.order', compact('order', 'cart'))->save($fileName);
                $vendormessage->attach($fileName);
            });
   
  // mail($vendor_em, $vendor_subject, $vendor_msg, $headers);
	}
	
	 $cust_msg= 'Dear Customer,<br /><br />
Thanks for shopping on South India Jewels.<br /><br />
This is to confirm that your order is received and is in the processing stage.
As a result of the second wave of the pandemic, few states are under lock down and courier partners are allowing the delivery of only Essential items.<br /><br />
As much as we want to deliver every single order at the earliest, we are adhering to all the government guidelines and servicing in accordance with those.<br /><br />
The orders placed are under process and cannot be canceled. We request you to be patient as you may experience delayed deliveries.<br /><br />
Once the order is shipped, you will be notified via email. Then you can track the order on this link https://shop.southindiajewels.com/orders-tracking/.
Kindly get in touch with us if the order has not been delivered within 15 working days since the date of shipment.<br /><br />
For returns/exchange, please check our policy here https://shop.southindiajewels.com/returns-exchanges/<br /><br />
If you like to reach us for any issues/concerns/feedback on your order, please drop an email to info@southindiajewels.com or call us at +91 9150724959.<br /><br />
PS – Due to COVID-19, there might be delays in case we face issues with shipping to your destination. So please kindly be patient till we deliver your orders.<br /><br />
Regards,<br /><br />
South India Jewels Team<br /><br /><br />';

mail($to, $subject, $cust_msg, $headers);

if($gs->is_smtp == 1)
                    {
$objDemo = new \stdClass();
        $objDemo->to = $to;
        $objDemo->from = $gs->from_email;
        $objDemo->title = $gs->from_name;
        $objDemo->subject =$subject ;
        $id= $order->id;
		$data = [
            'email_body' => $msg
        ];
		
		$adminDemo = new \stdClass();
        $adminDemo->to = $admin_em;
        $adminDemo->from = $gs->from_email;
        $adminDemo->title = $gs->from_name;
        $adminDemo->subject =$admin_subject ;
        $oid= $order->id;
		$admindata = [
            'email_body' => $admin_msg
        ];
		
		
		
        try{
            Mail::send('admin.email.mailbody',$data, function ($message) use ($objDemo,$id) {
                $message->from($objDemo->from,$objDemo->title);
                $message->to($objDemo->to);
                $message->subject($objDemo->subject);
                $order = Order::findOrFail($id);
                $cart = unserialize(bzdecompress(utf8_decode($order->cart)));
                $fileName = public_path('assets/temp_files/').str_random(4).time().'.pdf';
                $pdf = PDF::loadView('print.order', compact('order', 'cart'))->save($fileName);
                $message->attach($fileName);
            });
			
			 Mail::send('admin.email.mailbody',$admindata, function ($adminmessage) use ($adminDemo,$oid) {
                $adminmessage->from($adminDemo->from,$adminDemo->title);
                $adminmessage->to($adminDemo->to);
                $adminmessage->subject($adminDemo->subject);
                $order = Order::findOrFail($oid);
                $cart = unserialize(bzdecompress(utf8_decode($order->cart)));
                $fileName = public_path('assets/temp_files/').str_random(4).time().'.pdf';
                $pdf = PDF::loadView('print.order', compact('order', 'cart'))->save($fileName);
                $adminmessage->attach($fileName);
            });

        }
        catch (Exception $e){
             //die($e->getMessage());
        }
					}else{
						mail($to, $subject, $msg, $headers);
						mail($admin_em, $admin_subject, $admin_msg, $headers);
						

					}
					
			
                   
                $notification = new Notification;
                $notification->order_id = $order->id;
                $notification->save();

                    Session::put('temporder',$order);

            }
			Session::forget('cart');
            return redirect()->route('payment.return');

        }
        else
        {
            
            return redirect(route('front.checkout'));
        }
        
    }
    

}
