<?php

namespace App\Http\Controllers\Front;

use App\Models\Cart;
use App\Models\User;
use App\Models\Order;
use App\Models\Coupon;
use App\Models\Product;
use App\Models\Currency;
use App\Models\OrderTrack;
use App\Models\VendorOrder;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Classes\GeniusMailer;
use App\Models\Generalsetting;
use App\Models\UserNotification;
use App\Models\Admin;
use App\Http\Controllers\Controller;
use App\Models\Pagesetting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use PDF;
use Config;

class CcavenueController extends Controller
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
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
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
                return redirect()->back()->with('unsuccess','Please Select INR Currency For CC Avenue.');
            }
        $settings = Generalsetting::findOrFail(1);
        $order = new Order;
        $success_url = action('Front\PaymentController@payreturn');
        $item_name = $settings->title." Order";
        //$item_number = str_random(4).time();
        $order_data = Order::orderBy('id','desc')->get();
        //$ord_no = 'order'.Auth()->id();
        $ord_no = 'SIJ'.rand(100,1000);
        $ord_gen =@$order_data[0]->id+1;
        $item_number =$ord_no.$ord_gen;
        $item_amount = $request->total;

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
                    $order['user_id'] = $request->user_id;
                    $order['vendor_id_list'] = implode(',', $vendor_list);
        $order['product_name_qty'] = implode(',', $product_name_qty);
		$order['product_id_list'] = implode(',', $product_id_qty);
		$order['product_item_list'] = implode(',', $product_item_qty);
                    $order['cart'] = utf8_encode(bzcompress(serialize($cart), 9));
                    $order['totalQty'] = $request->totalQty;
                    $order['pay_amount'] = round($item_amount / $curr->value, 2);
                    $order['method'] = "CC Avenue";
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
					$order['admin_fee'] = round($request->total / $curr->value, 2)*$settings->percentage_commission/100;


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
                    if($order['dp'] == 1)
                    {
                        $order['status'] = 'completed';
                    }

                    if (Session::has('affilate'))
                    {
                        $val = $request->total / 100;
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
							$vorder->admin_fee = round($prod['price'] / $curr->value, 2)*$settings->percentage_commission/100;                            
                            //$vencomission = round($prod['price']*15/100, 2);
							$vencomission = round($prod['price'] / $curr->value, 2)*$settings->percentage_commission/100;
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
                    $mailer->sendAutoOrderMail($data,$order->id);
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
                        $mailer->sendCustomMail($data);
                    }
                    else
                    {
                    $to = Pagesetting::find(1)->contact_email;
                    $subject = "New Order Recieved!!";
                    $msg = "Hello Admin!\nYour store has recieved a new order.\nOrder Number is ".$order->order_number.".Please login to your panel to check. \nThank you.";
                        $headers = "From: ".$gs->from_name."<".$gs->from_email.">";
                    mail($to,$subject,$msg,$headers);
                    }*/



                    Session::put('temporder',$order);
                    Session::put('tempcart',$cart);

                    

            Session::forget('already');
            Session::forget('coupon');
            Session::forget('coupon_total');
            Session::forget('coupon_total1');
            Session::forget('coupon_percentage');

                  //  return redirect($success_url);
                    
	    $data_for_request = $this->handlePaytmRequest( $item_number, $item_amount );
	    $paytm_txn_url = 'https://secure.ccavenue.com/transaction/transaction.do?command=initiateTransaction';
	    $paramList = $data_for_request['paramList'];
	    $checkSum = $data_for_request['checkSum'];
	    return view( 'front.ccavenue-merchant-form', compact( 'paytm_txn_url', 'paramList', 'checkSum' ) );
    }

	public function handlePaytmRequest( $order_id, $amount ) {
        $gs = Generalsetting::first();
        $od = Order::where( 'order_number', $order_id )->first();
		// Load all functions of encdec_paytm.php and config-paytm.php
		$this->getAllEncdecFunc();
		// $this->getConfigPaytmSettings();
		$checkSum = "";
		$paramList = array();
		// Create an array having all required parameters for creating checksum.
		$paramList["tid"] = '';
		$paramList["merchant_id"] = $gs->ccavenue_merchant;
		$paramList["order_id"] = $order_id;
		$paramList["billing_name"] = $od->customer_name;
		$paramList['billing_email'] = $od->customer_email;
       $paramList['billing_tel'] = $od->customer_phone;
       $paramList['billing_address'] = $od->customer_address;
       $paramList['billing_country'] = $od->customer_country;
        $paramList['billing_state'] = $od->customer_state;
       $paramList['billing_city'] = $od->customer_city;
       $paramList['billing_zip'] = $od->customer_zip;
		$paramList["currency"] = 'INR';
		$paramList["amount"] = $amount;
		$paramList["redirect_url"] = route('ccavenue.notify');
		$paramList["cancel_url"] = route('ccavenue.notify');
		$paramList["language"] = 'EN';
		$ccavenue_merchant_key = $gs->ccavenue_secret;
		//Here checksum string will return by getChecksumFromArray() function.
		$checkSum = getChecksumFromArray( $paramList, $ccavenue_merchant_key );
		return array(
			'checkSum' => $checkSum,
			'paramList' => $paramList
		);
	}


	function getAllEncdecFunc() {
	
        	function encrypt_e($input, $ky) {
			$key   = hextobin(md5($ky));;
			$iv = pack("C*", 0x00, 0x01, 0x02, 0x03, 0x04, 0x05, 0x06, 0x07, 0x08, 0x09, 0x0a, 0x0b, 0x0c, 0x0d, 0x0e, 0x0f);
			$openMode = openssl_encrypt ( $input , "AES-128-CBC" , $key, OPENSSL_RAW_DATA, $iv );
			$data = bin2hex($openMode);
			return $data;
		}
		function decrypt_e($crypt, $ky) {
			$key   = hextobin(md5($ky));
			$iv = pack("C*", 0x00, 0x01, 0x02, 0x03, 0x04, 0x05, 0x06, 0x07, 0x08, 0x09, 0x0a, 0x0b, 0x0c, 0x0d, 0x0e, 0x0f);
			$encryptedText = hextobin($data);
			$data = openssl_decrypt($encryptedText, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $iv);
			return $data;
		}
		
		function hextobin($hexString) 
         { 
        	$length = strlen($hexString); 
        	$binString="";   
        	$count=0; 
        	while($count<$length) 
        	{       
        	    $subString =substr($hexString,$count,2);           
        	    $packedString = pack("H*",$subString); 
        	    if ($count==0)
        	    {
        			$binString=$packedString;
        	    } 
        	    
        	    else 
        	    {
        			$binString.=$packedString;
        	    } 
        	    
        	    $count+=2; 
        	} 
                return $binString; 
          } 
		
		function pkcs5_pad_e($text, $blocksize) {
			$pad = $blocksize - (strlen($text) % $blocksize);
			return $text . str_repeat(chr($pad), $pad);
		}
		function pkcs5_unpad_e($text) {
			$pad = ord($text{strlen($text) - 1});
			if ($pad > strlen($text))
				return false;
			return substr($text, 0, -1 * $pad);
		}
		function generateSalt_e($length) {
			$random = "";
			srand((double) microtime() * 1000000);
			$data = "AbcDE123IJKLMN67QRSTUVWXYZ";
			$data .= "aBCdefghijklmn123opq45rs67tuv89wxyz";
			$data .= "0FGH45OP89";
			for ($i = 0; $i < $length; $i++) {
				$random .= substr($data, (rand() % (strlen($data))), 1);
			}
			return $random;
		}
		function checkString_e($value) {
			if ($value == 'null')
				$value = '';
			return $value;
		}
		function getChecksumFromArray($arrayList, $key, $sort=1) {
			if ($sort != 0) {
				ksort($arrayList);
			}
			$str = getArray2Str($arrayList);
			$salt = generateSalt_e(4);
			$finalString = $str . "|" . $salt;
			$hash = hash("sha256", $finalString);
			$hashString = $hash . $salt;
			$checksum = encrypt_e($hashString, $key);
			return $checksum;
		}
		function getChecksumFromString($str, $key) {
			$salt = generateSalt_e(4);
			$finalString = $str . "|" . $salt;
			$hash = hash("sha256", $finalString);
			$hashString = $hash . $salt;
			$checksum = encrypt_e($hashString, $key);
			return $checksum;
		}
		function verifychecksum_e($arrayList, $key, $checksumvalue) {
			$arrayList = removeCheckSumParam($arrayList);
			ksort($arrayList);
			$str = getArray2StrForVerify($arrayList);
			$paytm_hash = decrypt_e($checksumvalue, $key);
			$salt = substr($paytm_hash, -4);
			$finalString = $str . "|" . $salt;
			$website_hash = hash("sha256", $finalString);
			$website_hash .= $salt;
			$validFlag = "FALSE";
			if ($website_hash == $paytm_hash) {
				$validFlag = "TRUE";
			} else {
				$validFlag = "FALSE";
			}
			return $validFlag;
		}
		function verifychecksum_eFromStr($str, $key, $checksumvalue) {
			$paytm_hash = decrypt_e($checksumvalue, $key);
			$salt = substr($paytm_hash, -4);
			$finalString = $str . "|" . $salt;
			$website_hash = hash("sha256", $finalString);
			$website_hash .= $salt;
			$validFlag = "FALSE";
			if ($website_hash == $paytm_hash) {
				$validFlag = "TRUE";
			} else {
				$validFlag = "FALSE";
			}
			return $validFlag;
		}
		function getArray2Str($arrayList) {
			$findme   = 'REFUND';
			$findmepipe = '|';
			$paramStr = "";
			$flag = 1;
			foreach ($arrayList as $key => $value) {
				$pos = strpos($value, $findme);
				$pospipe = strpos($value, $findmepipe);
				if ($pos !== false || $pospipe !== false)
				{
					continue;
				}
				if ($flag) {
					$paramStr .= checkString_e($value);
					$flag = 0;
				} else {
					$paramStr .= "|" . checkString_e($value);
				}
			}
			return $paramStr;
		}
		function getArray2StrForVerify($arrayList) {
			$paramStr = "";
			$flag = 1;
			foreach ($arrayList as $key => $value) {
				if ($flag) {
					$paramStr .= checkString_e($value);
					$flag = 0;
				} else {
					$paramStr .= "|" . checkString_e($value);
				}
			}
			return $paramStr;
		}
		function redirect2PG($paramList, $key) {
			$hashString = getchecksumFromArray($paramList, $key);
			$checksum = encrypt_e($hashString, $key);
		}
		function removeCheckSumParam($arrayList) {
			if (isset($arrayList["CHECKSUMHASH"])) {
				unset($arrayList["CHECKSUMHASH"]);
			}
			return $arrayList;
		}
		function getTxnStatus($requestParamList) {
			return callAPI(PAYTM_STATUS_QUERY_URL, $requestParamList);
		}
		function getTxnStatusNew($requestParamList) {
			return callNewAPI(PAYTM_STATUS_QUERY_NEW_URL, $requestParamList);
		}
		function initiateTxnRefund($requestParamList) {
			$CHECKSUM = getRefundChecksumFromArray($requestParamList,PAYTM_MERCHANT_KEY,0);
			$requestParamList["CHECKSUM"] = $CHECKSUM;
			return callAPI(PAYTM_REFUND_URL, $requestParamList);
		}
		function callAPI($apiURL, $requestParamList) {
			$jsonResponse = "";
			$responseParamList = array();
			$JsonData =json_encode($requestParamList);
			$postData = 'JsonData='.urlencode($JsonData);
			$ch = curl_init($apiURL);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);
			curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
					'Content-Type: application/json',
					'Content-Length: ' . strlen($postData))
			);
			$jsonResponse = curl_exec($ch);
			$responseParamList = json_decode($jsonResponse,true);
			return $responseParamList;
		}
		function callNewAPI($apiURL, $requestParamList) {
			$jsonResponse = "";
			$responseParamList = array();
			$JsonData =json_encode($requestParamList);
			$postData = 'JsonData='.urlencode($JsonData);
			$ch = curl_init($apiURL);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);
			curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
					'Content-Type: application/json',
					'Content-Length: ' . strlen($postData))
			);
			$jsonResponse = curl_exec($ch);
			$responseParamList = json_decode($jsonResponse,true);
			return $responseParamList;
		}
		function getRefundChecksumFromArray($arrayList, $key, $sort=1) {
			if ($sort != 0) {
				ksort($arrayList);
			}
			$str = getRefundArray2Str($arrayList);
			$salt = generateSalt_e(4);
			$finalString = $str . "|" . $salt;
			$hash = hash("sha256", $finalString);
			$hashString = $hash . $salt;
			$checksum = encrypt_e($hashString, $key);
			return $checksum;
		}
		function getRefundArray2Str($arrayList) {
			$findmepipe = '|';
			$paramStr = "";
			$flag = 1;
			foreach ($arrayList as $key => $value) {
				$pospipe = strpos($value, $findmepipe);
				if ($pospipe !== false)
				{
					continue;
				}
				if ($flag) {
					$paramStr .= checkString_e($value);
					$flag = 0;
				} else {
					$paramStr .= "|" . checkString_e($value);
				}
			}
			return $paramStr;
		}
		function callRefundAPI($refundApiURL, $requestParamList) {
			$jsonResponse = "";
			$responseParamList = array();
			$JsonData =json_encode($requestParamList);
			$postData = 'JsonData='.urlencode($JsonData);
			$ch = curl_init($apiURL);
			curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);
			curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);
			curl_setopt($ch, CURLOPT_URL, $refundApiURL);
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$headers = array();
			$headers[] = 'Content-Type: application/json';
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			$jsonResponse = curl_exec($ch);
			$responseParamList = json_decode($jsonResponse,true);
			return $responseParamList;
		}
	}
	/**
	 * Config Paytm Settings from config_paytm.php file of paytm kit
	 */
	function getConfigPaytmSettings() {
        $gs = Generalsetting::first();
    
        if ($gs->paytm_mode == 'sandbox') {
          define('PAYTM_ENVIRONMENT', 'TEST'); // PROD
        } elseif ($gs->paytm_mode == 'live') {
          define('PAYTM_ENVIRONMENT', 'PROD'); // PROD
        }

		define('PAYTM_MERCHANT_KEY', $gs->paytm_secret); //Change this constant's value with Merchant key downloaded from portal
		define('PAYTM_MERCHANT_MID', $gs->paytm_merchant); //Change this constant's value with MID (Merchant ID) received from Paytm
		define('PAYTM_MERCHANT_WEBSITE', $gs->paytm_website); //Change this constant's value with Website name received from Paytm
		$PAYTM_STATUS_QUERY_NEW_URL='https://securegw-stage.paytm.in/merchant-status/getTxnStatus';
		$PAYTM_TXN_URL='https://securegw-stage.paytm.in/theia/processTransaction';
		if (PAYTM_ENVIRONMENT == 'PROD') {
			$PAYTM_STATUS_QUERY_NEW_URL='https://securegw.paytm.in/merchant-status/getTxnStatus';
			$PAYTM_TXN_URL='https://securegw.paytm.in/theia/processTransaction';
		}
		define('PAYTM_REFUND_URL', '');
		define('PAYTM_STATUS_QUERY_URL', $PAYTM_STATUS_QUERY_NEW_URL);
		define('PAYTM_STATUS_QUERY_NEW_URL', $PAYTM_STATUS_QUERY_NEW_URL);
		define('PAYTM_TXN_URL', $PAYTM_TXN_URL);
    }

	public function ccavenueCallback( Request $request ) {
	    
	    
	    function ccencrypt($plainText,$key)
{
	$key = hextobin(md5($key));
	$initVector = pack("C*", 0x00, 0x01, 0x02, 0x03, 0x04, 0x05, 0x06, 0x07, 0x08, 0x09, 0x0a, 0x0b, 0x0c, 0x0d, 0x0e, 0x0f);
	$openMode = openssl_encrypt($plainText, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $initVector);
	$encryptedText = bin2hex($openMode);
	return $encryptedText;
}

/*
* @param1 : Encrypted String
* @param2 : Working key provided by CCAvenue
* @return : Plain String
*/
function ccdecrypt($encryptedText,$key)
{
	$key = hextobin(md5($key));
	$initVector = pack("C*", 0x00, 0x01, 0x02, 0x03, 0x04, 0x05, 0x06, 0x07, 0x08, 0x09, 0x0a, 0x0b, 0x0c, 0x0d, 0x0e, 0x0f);
	$encryptedText = hextobin($encryptedText);
	$decryptedText = openssl_decrypt($encryptedText, 'AES-128-CBC', $key, OPENSSL_RAW_DATA, $initVector);
	return $decryptedText;
}

function hextobin($hexString) 
 { 
	$length = strlen($hexString); 
	$binString="";   
	$count=0; 
	while($count<$length) 
	{       
	    $subString =substr($hexString,$count,2);           
	    $packedString = pack("H*",$subString); 
	    if ($count==0)
	    {
			$binString=$packedString;
	    } 
	    
	    else 
	    {
			$binString.=$packedString;
	    } 
	    
	    $count+=2; 
	} 
        return $binString; 
  } 
          
          $workingKey='61391D897E1101835C8B3E4078108CD5';		//Working Key should be provided here.
          $encResponse=$_POST["encResp"];			//This is the response sent by the CCAvenue Server
        	$rcvdString=ccdecrypt($encResponse,$workingKey);		//Crypto Decryption used as per the specified working key.
        	$order_status="";
        	$decryptValues=explode('&', $rcvdString);
        	$dataSize=sizeof($decryptValues);
        	
        	
        	
        	
        		for($i = 0; $i < $dataSize; $i++) 
                	{
                		$information=explode('=',$decryptValues[$i]);
                		if($i==3)	$order_status=$information[1];
                	}
                	
                	
                	for($i = 0; $i < $dataSize; $i++) 
                	{
                		$information=explode('=',$decryptValues[$i]);
                		if($i==0)	$orderid=$information[1];
                	}
                	
                	for($i = 0; $i < $dataSize; $i++) 
                	{
                		$information=explode('=',$decryptValues[$i]);
                		if($i==1)	$txnid=$information[1];
                	}
                	
                	for($i = 0; $i < $dataSize; $i++) 
                	{
                		$information=explode('=',$decryptValues[$i]);
                		if($i==5)	$paymode=$information[1];
                	}
                	
                	for($i = 0; $i < $dataSize; $i++) 
                	{
                		$information=explode('=',$decryptValues[$i]);
                		if($i==6)	$cardname=$information[1];
                	}
                	
                	

		if ($order_status==="Success") {
		    
		    $gs = Generalsetting::find(1);
			$transaction_id = $txnid;
			
			$order_id = $orderid;
			
			$paymodes = $paymode;
			$cardnames = $cardname;
			
			
			
            $order = Order::where( 'order_number', $order_id )->first();

             $vorder = VendorOrder::where( 'order_number', $order_id );
			$vdata['status'] = 'processing';
            if (isset($order)) {
                $data['txnid'] = $transaction_id;
                $data['od_card_type'] = $paymodes;
                $data['od_card_name'] = $cardnames;
                $data['payment_status'] = 'Completed';
                if($order->dp == 1)
                {
                    $data['status'] = 'completed';
               }else{
					$data['status'] = 'processing';
				}
				$vorder->update($vdata);
                $order->update($data);
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

                Session::put('temporder',$order);
                Session::forget('cart');
            }
            return redirect()->route('payment.return');

		//} else if( 'Failure' === $request['STATUS'] ){
		} else if ($order_status==="Failure") {
$transaction_id = $txnid;
$order_id = $orderid;
$paymodes = $paymode;
$cardnames = $cardname;
$order = Order::where( 'order_number', $order_id )->first();
$vorder = VendorOrder::where( 'order_number', $order_id );
$vdata['status'] = 'failure';
if (isset($order)) {
$data['txnid'] = $transaction_id;
$data['od_card_type'] = $paymodes;
$data['od_card_name'] = $cardnames;
$data['payment_status'] = 'failure';
$data['status'] = 'failure';
$vorder->update($vdata);
$order->update($data);
}
            //return view( 'payment-failed' );
            Session::forget('cart');
            return redirect(route('payment.cancle'));
		}
    }

}
