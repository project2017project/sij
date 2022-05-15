<?php

namespace App\Http\Controllers\Front;
use App\Classes\GeniusMailer;
use App\Models\Order;
use App\Models\OrderTrack;
use App\Models\Cart;
use App\Models\Coupon;
use App\Models\Currency;
use App\Models\Generalsetting;
use App\Models\Notification;
use App\Models\Product;
use App\Models\User;
use App\Models\VendorOrder;
use App\Models\UserNotification;
use App\Models\Admin;
use Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use PDF;


class PaymentController extends Controller
{
	public function __construct()
    {
        
        $rdata = Generalsetting::findOrFail(1);       
		
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

 public function store(Request $request){
	 $rdata = Generalsetting::findOrFail(1); 
     if (!Session::has('cart')) {
        return redirect()->route('front.cart')->with('success',"You don't have any product to checkout.");
     }

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
     $settings = Generalsetting::findOrFail(1);
     $order = new Order;
     $paypal_email = $settings->paypal_business;
     $return_url = action('Front\PaymentController@payreturn');
     $cancel_url = action('Front\PaymentController@paycancle');
     $notify_url = action('Front\PaymentController@notify');

     $item_name = $settings->title." Order";
     //$item_number = str_random(4).time();
	 //$item_number = str_random(4).time();
        $order_data = Order::orderBy('id','desc')->get();
        //$ord_no = 'order'.Auth()->id();
        $ord_no = 'SIJ'.rand(100,1000);
        $ord_gen =@$order_data[0]->id+1;
        $item_number =$ord_no.$ord_gen;
     $item_amount = $request->total;

     $querystring = '';

     // Firstly Append paypal account to querystring
     $querystring .= "?business=".urlencode($paypal_email)."&";

     // Append amount& currency (£) to quersytring so it cannot be edited in html

     //The item name and amount can be brought in dynamically by querying the $_POST['item_number'] variable.
     $querystring .= "item_name=".urlencode($item_name)."&";
     $querystring .= "amount=".urlencode($item_amount)."&";
     $querystring .= "item_number=".urlencode($item_number)."&";

    $querystring .= "cmd=".urlencode(stripslashes($request->cmd))."&";
    $querystring .= "bn=".urlencode(stripslashes($request->bn))."&";
    $querystring .= "lc=".urlencode(stripslashes($request->lc))."&";
    $querystring .= "currency_code=".urlencode(stripslashes($request->currency_code))."&";

     // Append paypal return addresses
     $querystring .= "return=".urlencode(stripslashes($return_url))."&";
     $querystring .= "cancel_return=".urlencode(stripslashes($cancel_url))."&";
     $querystring .= "notify_url=".urlencode($notify_url)."&";

     $querystring .= "custom=".$request->user_id;
    // Redirect to paypal IPN

                    $order['user_id'] = $request->user_id;
                    $order['vendor_id_list'] = implode(',', $vendor_list);
        $order['product_name_qty'] = implode(',', $product_name_qty);
		$order['product_id_list'] = implode(',', $product_id_qty);
		$order['product_item_list'] = implode(',', $product_item_qty);
                    $order['cart'] = utf8_encode(bzcompress(serialize($cart), 9));
                    $order['totalQty'] = $request->totalQty;
                    $order['pay_amount'] = round($item_amount / $curr->value, 2);
                    $order['method'] = $request->method;
                    $order['customer_email'] = $request->email;
                    $order['customer_name'] = $request->name;
                    $order['customer_phone'] = $request->phone;
                    $order['order_number'] = $item_number;
                    $order['shipping'] = $request->shipping;
                    $order['pickup_location'] = $request->pickup_location;
                    $order['customer_address'] = $request->address;
                    $order['customer_country'] = $request->customer_country;
                    $order['customer_city'] = $request->city;
                    $order['customer_zip'] = $request->zip;
                    $order['shipping_email'] = $request->shipping_email;
                    $order['shipping_name'] = $request->shipping_name;
                    $order['shipping_phone'] = $request->shipping_phone;
                    $order['shipping_address'] = $request->shipping_address;
                    $order['shipping_country'] = $request->shipping_country;
                    $order['shipping_city'] = $request->shipping_city;
                    $order['shipping_zip'] = $request->shipping_zip;
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
					
					$tcs = 1;
		
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

        $order['vendor_shipping_id'] = $request->vendor_shipping_id;
        $order['vendor_packing_id'] = $request->vendor_packing_id;

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
                    Session::put('temporder',$order);
                    Session::put('tempcart',$cart);



     

     return redirect('https://www.paypal.com/cgi-bin/webscr'.$querystring);

 }


     public function paycancle(){
        $this->code_image();
         return redirect()->route('front.checkout')->with('unsuccess','Payment Cancelled.');
     }

     public function payreturn(){
        $this->code_image();
        if(Session::has('tempcart')){
        $oldCart = Session::get('tempcart');
        $tempcart = new Cart($oldCart);
        $order = Session::get('temporder');
        }
        else{
            $tempcart = '';
            return redirect()->back();
        }

         return view('front.success',compact('tempcart','order'));
     }



public function notify(Request $request){

    $raw_post_data = file_get_contents('php://input');
    $raw_post_array = explode('&', $raw_post_data);
    $myPost = array();
    foreach ($raw_post_array as $keyval) {
        $keyval = explode ('=', $keyval);
        if (count($keyval) == 2)
            $myPost[$keyval[0]] = urldecode($keyval[1]);
    }
    //return $myPost;


    // Read the post from PayPal system and add 'cmd'
    $req = 'cmd=_notify-validate';
    if(function_exists('get_magic_quotes_gpc')) {
        $get_magic_quotes_exists = true;
    }
    foreach ($myPost as $key => $value) {
        if($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1) {
            $value = urlencode(stripslashes($value));
        } else {
            $value = urlencode($value);
        }
        $req .= "&$key=$value";
    }

    /*
     * Post IPN data back to PayPal to validate the IPN data is genuine
     * Without this step anyone can fake IPN data
     */
    $paypalURL = "https://www.paypal.com/cgi-bin/webscr";
    $ch = curl_init($paypalURL);
    if ($ch == FALSE) {
        return FALSE;
    }
    curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
    curl_setopt($ch, CURLOPT_SSLVERSION, 6);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
    curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);

// Set TCP timeout to 30 seconds
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close', 'User-Agent: company-name'));
    $res = curl_exec($ch);

    /*
     * Inspect IPN validation result and act accordingly
     * Split response headers and payload, a better way for strcmp
     */
    $tokens = explode("\r\n\r\n", trim($res));
    $res = trim(end($tokens));
    if (strcmp($res, "VERIFIED") == 0 || strcasecmp($res, "VERIFIED") == 0) {

        $order = Order::where('user_id',$_POST['custom'])
            ->where('order_number',$_POST['item_number'])->first();
        $data['txnid'] = $_POST['txn_id'];
        $data['payment_status'] = $_POST['payment_status'];
		$vorder = VendorOrder::where( 'order_number', $order_id );
		$vdata['status'] = 'processing';
         if($order->dp == 1)
                {
                    $data['status'] = 'completed';
                }else{
					$data['status'] = 'processing';
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
		
		$gs = Generalsetting::find(1);
		
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
                                                      <h1 style="color : #ffffff">Thanks for your order</h1>
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
                                                      <p style="color: #333333">Just to let you know — we have received your order #'.$order_id.', and it is now being processed:</p>
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
                                                                     <td><span style="font-size:13px">NAME</span></td>
                                                                     <td style="text-align: center" width="60"><span style="font-size:13px"><span style="line-height: 100%">QTY</span></span></td>
                                                                     <td style="text-align: center" width="100"><span style="font-size:13px"><span style="line-height: 100%">PRICE</span></span></td>
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
                              </tr>
                              <tr>
                                 <td class="es-p5t es-p10b es-p20r es-p20l" align="left">
                                    
                                             <table style="width : 100%;" cellspacing="0" cellpadding="0" align="right">
                                                <tr>
                                                   <td width="362" align="left">
                                                      <table width="100%" cellspacing="0" cellpadding="0" role="presentation">
                                                         <tr>
                                                            <td align="left">
                                                              
                                                               <table style="width: 100%" class="cke_show_border" cellspacing="1" cellpadding="1" border="0" role="presentation">
                                                                  <tr>
                                                                     <td><a href="#" target="_blank">
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
                                                                     $msg .='<td style="text-align: center" width="60">'.$prod['qty'].'</td><td style="text-align: center" width="100">'.$order->currency_sign.''.round($prod['item']['price'] * $order->currency_value , 2).'</td>
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
                             
		} 
                            
                             
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
                              </tr>
                              <tr>
                                 <td class="es-p5t es-p30b es-p40r es-p20l" align="left">
                                    <table width="100%" cellspacing="0" cellpadding="0">
                                       <tr>
                                          <td width="540" valign="top" align="center">
                                             <table width="100%" cellspacing="0" cellpadding="0" role="presentation">
                                                <tr>
                                                   <td align="right">
                                                      <table style="width: 500px" class="cke_show_border" cellspacing="1" cellpadding="1" border="0" align="right" role="presentation">
                                                         <tr>
                                                            <td style="text-align: right;font-size: 14px;line-height: 27px">Subtotal ('.$product_count.' items):</td>
                                                            <td style="text-align: right;font-size: 14px;line-height: 27px">'.$order->currency_sign.''.$product_tot_price.'</td>
                                                         </tr>';
														 
														 @$ship_cost = @$order->shipping_cost + @$order->packing_cost;
														 if(@$ship_cost){
                                                         $msg .='<tr>
                                                            <td style="text-align: right;font-size: 14px;line-height: 27px">Flat-rate Shipping:</td>
                                                            <td style="text-align: right;font-size: 14px;line-height: 27px;color: #d48344"><strong></strong></td>
                                                         </tr>';
														 }else{
														     $msg .='<tr>
                                                            <td style="text-align: right;font-size: 14px;line-height: 27px">Shipping:</td>
                                                            <td style="text-align: right;font-size: 14px;line-height: 27px;color: #000000">Free Shipping</td>
                                                         </tr>';
														 }
														 if(@$order->tax){
                                                         $msg .='<tr>
                                                            <td style="text-align: right;font-size: 14px;line-height: 27px">Discount:</td>
                                                            <td style="text-align: right;font-size: 14px;line-height: 27px">$0.00</td>
                                                         </tr>';
														 }
                                                         $msg .='<tr>
                                                            <td style="text-align: right;font-size: 14px;line-height: 27px">Payment Method:</td>
                                                            <td style="text-align: right;font-size: 14px;line-height: 27px;color: #000000">'.$order->method.'</td>
                                                         </tr><tr>
                                                            <td style="text-align: right;font-size: 14px;line-height: 27px"><strong>Order Total:</strong></td>
                                                            <td style="text-align: right;font-size: 14px;line-height: 27px;color: #d48344"><strong>'.$order->currency_sign.''.round($order->pay_amount * $order->currency_value , 2).'</strong></td>
                                                         </tr>
                                                      </table>
                                                      <p style="line-height: 150%"><br></p>
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
                                                               <p>Thanks for using shop.southindiajewels.com! Your order will be shipped in 3 to 5 business days.</p>
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
   
      $admin_msg = '<!doctype html>
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
    $admin_msg .= '<body><div class="es-wrapper-color">';
   
				  $admin_msg .= '<div class="divwrap600"><table cellpadding="0" cellspacing="0" class="es-header" align="center">
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
				  
				  
	$admin_msg .= '<table class="es-content" cellspacing="0" cellpadding="0" align="center">
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
                                                      <h1 style="color : #ffffff">Thanks for your order</h1>
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
                                                      <p style="color: #333333">You’ve received the following order from '.$order->customer_name.',</p>
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
$admin_msg .= '<table class="es-content" cellspacing="0" cellpadding="0" align="center">
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
   $admin_msg .= '<table class="es-content" cellspacing="0" cellpadding="0" align="center">
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
                                                                     <td><span style="font-size:13px">NAME</span></td>
                                                                     <td style="text-align: center" width="60"><span style="font-size:13px"><span style="line-height: 100%">QTY</span></span></td>
                                                                     <td style="text-align: center" width="100"><span style="font-size:13px"><span style="line-height: 100%">PRICE</span></span></td>
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
                              </tr>
                              <tr>
                                 <td class="es-p5t es-p10b es-p20r es-p20l" align="left">
                                    
                                             <table style="width : 100%;" cellspacing="0" cellpadding="0" align="right">
                                                <tr>
                                                   <td width="362" align="left">
                                                      <table width="100%" cellspacing="0" cellpadding="0" role="presentation">
                                                         <tr>
                                                            <td align="left">
                                                              
                                                               <table style="width: 100%" class="cke_show_border" cellspacing="1" cellpadding="1" border="0" role="presentation">
                                                                  <tr>
                                                                     <td><a href="#" target="_blank">
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

                                                                    $admin_msg .='<td style="text-align: center" width="60">'.$prod['qty'].'</td>
                                                                     <td style="text-align: center" width="100">'.$order->currency_sign.''.round($prod['item']['price'] * $order->currency_value , 2).'</td>
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
                             
		} 
                            
                             
                             $admin_msg .='<tr>
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
                              </tr>
                              <tr>
                                 <td class="es-p5t es-p30b es-p40r es-p20l" align="left">
                                    <table width="100%" cellspacing="0" cellpadding="0">
                                       <tr>
                                          <td width="540" valign="top" align="center">
                                             <table width="100%" cellspacing="0" cellpadding="0" role="presentation">
                                                <tr>
                                                   <td align="right">
                                                      <table style="width: 500px" class="cke_show_border" cellspacing="1" cellpadding="1" border="0" align="right" role="presentation">
                                                         <tr>
                                                            <td style="text-align: right;font-size: 14px;line-height: 27px">Subtotal ('.$product_count.' items):</td>
                                                            <td style="text-align: right;font-size: 14px;line-height: 27px">'.$order->currency_sign.''.$product_tot_price.'</td>
                                                         </tr>';
														 
														 @$ship_cost = @$order->shipping_cost + @$order->packing_cost;
														 if(@$ship_cost){
                                                         $admin_msg .='<tr>
                                                            <td style="text-align: right;font-size: 14px;line-height: 27px">Flat-rate Shipping:</td>
                                                            <td style="text-align: right;font-size: 14px;line-height: 27px;color: #d48344"><strong></strong></td>
                                                         </tr>';
														 }else{
														     $admin_msg .='<tr>
                                                            <td style="text-align: right;font-size: 14px;line-height: 27px">Shipping:</td>
                                                            <td style="text-align: right;font-size: 14px;line-height: 27px;color: #000000">Free Shipping</td>
                                                         </tr>';
														 }
														 if(@$order->tax){
                                                         $admin_msg .='<tr>
                                                            <td style="text-align: right;font-size: 14px;line-height: 27px">Discount:</td>
                                                            <td style="text-align: right;font-size: 14px;line-height: 27px">$0.00</td>
                                                         </tr>';
														 }
                                                         $admin_msg .='<tr>
                                                            <td style="text-align: right;font-size: 14px;line-height: 27px">Payment Method:</td>
                                                            <td style="text-align: right;font-size: 14px;line-height: 27px;color: #000000">'.$order->method.'</td>
                                                         </tr><tr>
                                                            <td style="text-align: right;font-size: 14px;line-height: 27px"><strong>Order Total:</strong></td>
                                                            <td style="text-align: right;font-size: 14px;line-height: 27px;color: #d48344"><strong>'.$order->currency_sign.''.round($order->pay_amount * $order->currency_value , 2).'</strong></td>
                                                         </tr>
                                                      </table>
                                                      <p style="line-height: 150%"><br></p>
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
   $admin_msg .= '<table cellpadding="0" cellspacing="0" class="es-footer" align="center">
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
                                                               <p>Congratulations on the sale.</p>
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
   $admin_msg .= '</td></tr></table>';
   $admin_msg .= '<table class="es-wrapper" width="100%" cellspacing="0" cellpadding="0"><tr><td valign="top"><table cellpadding="0" cellspacing="0" class="es-content" align="center"><tr><td class="es-adaptive" align="center"><tr><td class="es-p15t es-p15b es-p20r es-p20l" align="center">   
                                    <p>South India Jewels</p>
                                 </td>
                              </tr>
                           </table>
                        </td>
                     </tr>
                  </table></div></div></body>';
   $admin_msg .= '</html>';
   
   $user_data = array();
                    foreach($cart->items as $prod)
        {
                            $user_data[] = $prod['item']['user_id'];
                    }
	foreach($user_data as $user_per) {	
	
   $user_info= User::findOrFail($user_per);   
   $vendor_subject = '[South India Jewels] New Store Order ('.$order->order_number.') - '.date('M d, Y',strtotime($order->created_at));
   $vendor_em = 'vendor@southindiajewels.co.in';    
  //$vendor_em = $user_info->email;
   
   
   $vendor_msg = '<!doctype html>
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
   
    $vendor_msg .= '<body><div class="es-wrapper-color">';
   
				  $vendor_msg .= '<div class="divwrap600"><table cellpadding="0" cellspacing="0" class="es-header" align="center">
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
				  
				  
	$vendor_msg .= '<table class="es-content" cellspacing="0" cellpadding="0" align="center">
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
                                                      <h1 style="color : #ffffff">Thanks for your order</h1>
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
                                                      <p style="color: #333333">A new order  was received from Mayank Goyal. Order details is as follows: ,</p>
                                                   </td>
                                                </tr>
                                                <tr>
                                                   <td class="es-p5t es-p5b es-p40r es-p40l" align="left">
                                                      <p style="color: #333333">Just to let you know — we have received your order #'.$order_id.', and it is now being processed:</p>
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
$vendor_msg .= '<table class="es-content" cellspacing="0" cellpadding="0" align="center">
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
   $vendor_msg .= '<table class="es-content" cellspacing="0" cellpadding="0" align="center">
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
                                                                     <td><span style="font-size:13px">NAME</span></td>
                                                                     <td style="text-align: center" width="60"><span style="font-size:13px"><span style="line-height: 100%">QTY</span></span></td>
                                                                     <td style="text-align: center" width="100"><span style="font-size:13px"><span style="line-height: 100%">PRICE</span></span></td>
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
                              $product_tot_price=0;
							  $product_imag='';
							  //$product_count=count($cart->items);
							  $admin_product_counts=0;
							  $admin_product_count=array();
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
                              </tr>
                              <tr>
                                 <td class="es-p5t es-p10b es-p20r es-p20l" align="left">
                                    
                                             <table style="width : 100%;" cellspacing="0" cellpadding="0" align="right">
                                                <tr>
                                                   <td width="362" align="left">
                                                      <table width="100%" cellspacing="0" cellpadding="0" role="presentation">
                                                         <tr>
                                                            <td align="left">
                                                              
                                                                <table style="width: 100%" class="cke_show_border" cellspacing="1" cellpadding="1" border="0" role="presentation">
                                                                  <tr>
                                                                     <td><a href="#" target="_blank">
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
                                                                    $vendor_msg .='<td style="text-align: center" width="60">'.$prod['qty'].'</td>
                                                                     <td style="text-align: center" width="100">'.$order->currency_sign.''.round($prod['item']['price'] * $prod['qty'] * $order->currency_value , 2).'</td>
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
		}
                             
		} 
                            
                             
                             $vendor_msg .='<tr>
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
                              </tr>
                              <tr>
                                 <td class="es-p5t es-p30b es-p40r es-p20l" align="left">
                                    <table width="100%" cellspacing="0" cellpadding="0">
                                       <tr>
                                          <td width="540" valign="top" align="center">
                                             <table width="100%" cellspacing="0" cellpadding="0" role="presentation">
                                                <tr>
                                                   <td align="right">
                                                      <table style="width: 500px" class="cke_show_border" cellspacing="1" cellpadding="1" border="0" align="right" role="presentation">
                                                         <tr>
                                                            <td style="text-align: right;font-size: 14px;line-height: 27px">Subtotal ('.$admin_product_count.' items):</td>
                                                            <td style="text-align: right;font-size: 14px;line-height: 27px">'.$order->currency_sign.''.$product_tot_price.'</td>
                                                         </tr>';
														 
														 /*@$ship_cost = @$order->shipping_cost + @$order->packing_cost;
														 if(@$ship_cost){
                                                         $vendor_msg .='<tr>
                                                            <td style="text-align: right;font-size: 14px;line-height: 27px">Flat-rate Shipping:</td>
                                                            <td style="text-align: right;font-size: 14px;line-height: 27px;color: #d48344"><strong></strong></td>
                                                         </tr>';
														 }else{
														     $vendor_msg .='<tr>
                                                            <td style="text-align: right;font-size: 14px;line-height: 27px">Shipping:</td>
                                                            <td style="text-align: right;font-size: 14px;line-height: 27px;color: #000000">Free Shipping</td>
                                                         </tr>';
														 }
														 if(@$order->tax){
                                                         $vendor_msg .='<tr>
                                                            <td style="text-align: right;font-size: 14px;line-height: 27px">Discount:</td>
                                                            <td style="text-align: right;font-size: 14px;line-height: 27px">$0.00</td>
                                                         </tr>';
														 }*/
                                                         $vendor_msg .='
                                                            <td style="text-align: right;font-size: 14px;line-height: 27px"><strong>Order Total:</strong></td>
                                                            <td style="text-align: right;font-size: 14px;line-height: 27px;color: #d48344"><strong>'.$order->currency_sign.''.$product_tot_price.'</strong></td>
                                                         </tr>
                                                      </table>
                                                      <p style="line-height: 150%"><br></p>
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
   $vendor_msg .= '<table cellpadding="0" cellspacing="0" class="es-footer" align="center">
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
                                                               <p></p>
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
   $vendor_msg .= '</td></tr></table>';
   $vendor_msg .= '<table class="es-wrapper" width="100%" cellspacing="0" cellpadding="0"><tr><td valign="top"><table cellpadding="0" cellspacing="0" class="es-content" align="center"><tr><td class="es-adaptive" align="center"><tr><td class="es-p15t es-p15b es-p20r es-p20l" align="center">   
                                    <p>South India Jewels</p>
                                 </td>
                              </tr>
                           </table>
                        </td>
                     </tr>
                  </table></div></div></body>';
   $vendor_msg .= '</html>';
   
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
   
   //mail($vendor_em, $vendor_subject, $vendor_msg, $headers);
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
        Session::forget('cart');
    }else{
        $payment = Order::where('user_id',$_POST['custom'])
            ->where('order_number',$_POST['item_number'])->first();
        VendorOrder::where('order','=',$payment->id)->delete();
        $payment->delete();

        Session::forget('cart');

    }

}


    // Capcha Code Image
    private function  code_image()
    {
        $actual_path = str_replace('project','',base_path());
        $image = imagecreatetruecolor(200, 50);
        $background_color = imagecolorallocate($image, 255, 255, 255);
        imagefilledrectangle($image,0,0,200,50,$background_color);

        $pixel = imagecolorallocate($image, 0,0,255);
        for($i=0;$i<500;$i++)
        {
            imagesetpixel($image,rand()%200,rand()%50,$pixel);
        }

        $font = $actual_path.'assets/front/fonts/NotoSans-Bold.ttf';
        $allowed_letters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        $length = strlen($allowed_letters);
        $letter = $allowed_letters[rand(0, $length-1)];
        $word='';
        //$text_color = imagecolorallocate($image, 8, 186, 239);
        $text_color = imagecolorallocate($image, 0, 0, 0);
        $cap_length=6;// No. of character in image
        for ($i = 0; $i< $cap_length;$i++)
        {
            $letter = $allowed_letters[rand(0, $length-1)];
            imagettftext($image, 25, 1, 35+($i*25), 35, $text_color, $font, $letter);
            $word.=$letter;
        }
        $pixels = imagecolorallocate($image, 8, 186, 239);
        for($i=0;$i<500;$i++)
        {
            imagesetpixel($image,rand()%200,rand()%50,$pixels);
        }
        session(['captcha_string' => $word]);
        imagepng($image, $actual_path."assets/images/capcha_code.png");
    }

}
