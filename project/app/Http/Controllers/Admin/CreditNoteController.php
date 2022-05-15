<?php

namespace App\Http\Controllers\Admin;

use App\Classes\GeniusMailer;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Admin;
use App\Models\User;
use App\Models\VendorOrder;
use App\Models\Product;
use App\Models\CreditNote;
use App\Models\Generalsetting;
use App\Models\Pagesetting;
use App\Models\Notification;
use Razorpay\Api\Api;
use DB;
use Datatables;
use Auth;
use Validator;
use Config;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;

class CreditNoteController extends Controller
{
    public function __construct()
    {
         $this->middleware('auth:admin');
		$data = Generalsetting::findOrFail(1);
        $this->keyId = $data->razorpay_key;
        $this->keySecret = $data->razorpay_secret;
        $this->displayCurrency = 'INR';
        $this->api = new Api($this->keyId, $this->keySecret);
		 if($data->header_email == 'smtp') {
            $mail_driver = 'smtp';
        }
        else{
            if($data->header_email == 'sendmail') {
                $mail_driver = 'sendmail';
            }
            else {
                $mail_driver = 'smtp';
            }
        }
        Config::set('mail.driver', $mail_driver);
        Config::set('mail.host', $data->smtp_host);
        Config::set('mail.port', $data->smtp_port);
        Config::set('mail.encryption', $data->email_encryption);
        Config::set('mail.username', $data->smtp_user);
        Config::set('mail.password', $data->smtp_pass);
    } 
	
	
    public function index(){
		$users = User::all()->where('is_vendor','2');
        return view('admin.creditnote.index',compact('users'));
    } 
	 public function load($id)
    {
        $order = Order::whereRaw("find_in_set($id , vendor_id_list)")->orderBy('id','desc')->get();
        return view('admin.creditnote.order',compact('order'));
    }
	 public function pload($id)
    {
        $product = Product::where('id','=',$id)->orderBy('id','desc')->get();
        return view('admin.creditnote.product',compact('product'));
    }
	
	public function store(Request $request)
    {

    	$rules = [
		        'vendor_id'   => 'required',
		        'order_id' => 'required',								
                ];
        $validator = Validator::make(Input::all(), $rules);
        
        if ($validator->fails()) {
          return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }
            $CreditNote = new CreditNote;
	        $input = $request->all();
            $order_id = $request->order_id;
            $vendor_id = $request->vendor_id;			
	         return response()->json(array('redirect_url' => route('admin-add-creditnote',['orderid'=>$order_id,'vendorid'=>$vendor_id])));	 

    }
	public function add($orderid,$vendorid)
    {
		$vdata = VendorOrder::where('order_id','=',$orderid)->where('user_id','=',$vendorid)->orderBy('id','desc')->get();
		$vendordata = User::where('id','=',$vendorid)->orderBy('id','desc')->get();
		return view('admin.creditnote.add',compact('vdata','vendordata','orderid','vendorid'));
	}
	
	public function addstore(Request $request)
    {

    	$rules = [
		        'product_id'   => 'required',		        
				'product_name' => 'required',
				'product_sku' => 'required',
				'amount' => 'required',
				//'quantity' => 'required',
				'prreason' => 'required'				
                ];
        $validator = Validator::make(Input::all(), $rules);
        
        if ($validator->fails()) {
          return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }
            $CreditNote = new CreditNote;
	        $input = $request->all();
            $data_vorder = VendorOrder::where(['user_id' => $request->vendor_id,'order_id' => $request->order_id,'product_id' => $request->product_id])->first();
            if($request->prreason=='others'){
				$input['reason'] = $request->reason;
			}else{
				$input['reason'] = $request->prreason;
			}			
			$input['vid'] = $data_vorder->id;
            $screenshot=array();
        if($files=$request->file('screenshot')){
            foreach($files as $file){
            $name=$file->getClientOriginalName();
            $file->move('assets/images/screenshot',$name);
            $screenshot[]=$name;
            }
            }
            $amounts = round($request->amount , 2);
            if($amounts>=1) { 			
			$input['status'] = 0;			
			$input['amount'] = $amounts;
            $input['screen_shot'] = implode(",",$screenshot);			
			$CreditNote->fill($input)->save();
            $m_id=$CreditNote->id;
            $order_id=$CreditNote->order_id;
			$user_id=$CreditNote->vendor_id;
			$product_id=$CreditNote->product_id;
			$product_quantity=$CreditNote->quantity;
			$product_amount=$CreditNote->amount;
			$product_data = Product::findOrFail($product_id);
			$newmsg = 'Credit Note Request Created Reason is ' . $CreditNote->reason;
            $newmsg .= '<br> Product Name : ' . $product_data->name.'( '.$product_data->sku.' )';			
			$notification = new Notification;
			$notification->order_id = $order_id;			
			$notification->vendor_id = $user_id;
			$notification->product_id = $product_id;
			$notification->vid = $CreditNote->vid;
			$notification->message = htmlentities($newmsg);
			$notification->save();
			
			$gs = Generalsetting::findOrFail(1);
			$order = Order::findOrFail($order_id);
			$order_number = $order->order_number;	
			$cart = unserialize(bzdecompress(utf8_decode($order->cart)));			
			$to = $order->customer_email;			
            $subject = 'Your South India Jewels order '.$order->order_number.' request for CreditNote';
			// To send HTML mail, the Content-type header must be set
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
 
// Create email headers
$headers .= 'From: '.$gs->from_email."\r\n".
    'Reply-To: '.$gs->from_email."\r\n" .
    'X-Mailer: PHP/' . phpversion();
	
$user_info= User::findOrFail($user_id);
$vendor_em = 'vendor@southindiajewels.co.in';
//$vendor_em = $user_info->email;
$vendor_subject = 'CreditNote Request For Your South India Jewels order '.$order->order_number.'';
 
// Compose a simple HTML email message
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
                                          <h1 style="font-size:30px;font-weight:300;line-height:150%;margin:0;text-align:left;color:#ffffff"><span class="il"></span> <span class="il">Request CreditNote Order</span>: #'.$order_number.'</h1>
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
                                                         <p style="margin:0 0 16px">Hi '.$user_info->name.',</p>
                                                         <p style="margin:0 0 16px">We have reuested the credit note for your order #'.$order_number.'. It will be credited in 5-7 business working days.</p>
                                                         <h2 style="color:#111111;display:block;font-size:18px;font-weight:bold;line-height:130%;margin:0 0 18px;text-align:left">
                                                            <a href="https://shop.southindiajewels.com/demo/wp-admin/post.php?post=10439&amp;action=edit" style="font-weight:normal;text-decoration:underline;color:#111111" target="_blank">[<span class="il">Order</span> #'.$order_number.']</a> ('.date('M d,Y',strtotime($order->created_at)).')
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
                              $product_count=$product_quantity;
                              foreach($cart->items as $prod)
        {
			if($product_id==$prod['item']['id']){
            $ProductDetails = Product::findOrFail($prod['item']['id']);
            $usersid = User::findOrFail($prod['item']['user_id']);
            $product_imag=$prod['item']['photo'] ? filter_var($prod['item']['photo'], FILTER_VALIDATE_URL) ?$prod['item']['photo']:asset('assets/images/products/'.$prod['item']['photo']):asset('assets/images/noimage.png') ;
        
            $product_tot_price += round($prod['item']['price'] *$prod['qty'] * $order->currency_value , 2);
                           $vendor_msg .='<tr>
                                                                     <td  style="color:#717a7a;border:1px solid #e4e4e4;padding:12px;text-align:left;vertical-align:middle;"><a href="#" target="_blank">
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
                                                                     $vendor_msg .='<td  style="color:#717a7a;border:1px solid #e4e4e4;padding:12px;text-align:left;vertical-align:middle;" width="60">'.$product_quantity.'</td><td style="color:#717a7a;border:1px solid #e4e4e4;padding:12px;text-align:left;vertical-align:middle;">'.$order->currency_sign.''.$product_amount.'</td>
                                                                  
                              </tr>';
} 
		}
                            
                             
                             $vendor_msg .='</tbody>
                                                               <tfoot>
                                                                  <tr>
                                                                     <th scope="row" colspan="2" style="color:#717a7a;border:1px solid #e4e4e4;vertical-align:middle;padding:12px;text-align:left;border-top-width:4px">Subtotal ('.$product_quantity.' items):</th>
                                                                     <td style="color:#717a7a;border:1px solid #e4e4e4;vertical-align:middle;padding:12px;text-align:left;border-top-width:4px"><span><span>'.$order->currency_sign.'</span>'.$product_amount.'</span></td>
                                                                  </tr>';                                                            
                                                                  
                                                                 
                                                                  
                                                         
                                                         @$ship_cost = @$order->shipping_cost + @$order->packing_cost;
                                                         if(@$ship_cost){
                                                         $vendor_msg .='<tr>
                                                            <th scope="row" colspan="2" style="color:#717a7a;border:1px solid #e4e4e4;vertical-align:middle;padding:12px;text-align:left">Shipping:</th>
                                                             <td style="color:#717a7a;border:1px solid #e4e4e4;vertical-align:middle;padding:12px;text-align:left"></td>
                                                         </tr>';
                                                         }else{
                                                             $vendor_msg .='<tr>
                                                            <th scope="row" colspan="2" style="color:#717a7a;border:1px solid #e4e4e4;vertical-align:middle;padding:12px;text-align:left">Shipping:</th>
                                                            <td style="color:#717a7a;border:1px solid #e4e4e4;vertical-align:middle;padding:12px;text-align:left">Free shipping</td>
                                                         </tr>';
                                                         }
                                                                  $vendor_msg .='
                                                                  <tr>
                                                                     <th scope="row" colspan="2" style="color:#717a7a;border:1px solid #e4e4e4;vertical-align:middle;padding:12px;text-align:left">Payment method:</th>
                                                                     <td style="color:#717a7a;border:1px solid #e4e4e4;vertical-align:middle;padding:12px;text-align:left">'.$order->method.'</td>
                                                                  </tr>
                                                                  <tr>
                                                                     <th scope="row" colspan="2" style="color:#717a7a;border:1px solid #e4e4e4;vertical-align:middle;padding:12px;text-align:left">Total:</th>
                                                                     <td style="color:#717a7a;border:1px solid #e4e4e4;vertical-align:middle;padding:12px;text-align:left"><span><span>'.$order->currency_sign.'</span> '.$product_amount.'</span></td>
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
                                                                        '.$order->customer_name.'<br>'.$order->customer_address.', '.$order->customer_city.'<br>'.$order->customer_state.', '.$order->customer_country.' '.$order->customer_zip.'<br><a href="tel:'.$order->customer_phone.'" style="color:#111111;font-weight:normal;text-decoration:underline" target="_blank">'.$order->customer_phone.'</a>                                                 <br><a href="mailto:'.$order->customer_email.'" target="_blank">'.$order->customer_email.'</a>                          
                                                                     </address>
                                                                  </td>
                                                                  <td valign="top" width="50%" style="text-align:left;padding:0">
                                                                     <h2 style="color:#111111;display:block;font-family:&quot;Helvetica Neue&quot;,Helvetica,Roboto,Arial,sans-serif;font-size:18px;font-weight:bold;line-height:130%;margin:0 0 18px;text-align:left">Shipping address</h2>
                                                                     <address style="padding:12px;color:#717a7a;border:1px solid #e4e4e4"> '.$order->customer_name.'<br>'.$order->customer_address.', '.$order->customer_city.'<br>'.$order->customer_state.', '.$order->customer_country.' '.$order->customer_zip.'</address>
                                                                  </td>
                                                               </tr>
                                                            </tbody>
                                                         </table>
                                                         <p style="margin:0 0 16px">Thanks for shopping with us.</p>
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
   
mail($vendor_em, $vendor_subject, $vendor_msg, $headers);
	

 
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
                                          <h1 style="font-size:30px;font-weight:300;line-height:150%;margin:0;text-align:left;color:#ffffff"><span class="il"></span> <span class="il">Request CreditNote Order</span>: #'.$order_number.'</h1>
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
                                                         <p style="margin:0 0 16px">We have reuested the credit note for your order #'.$order_number.'. It will be credited in 5-7 business working days.</p>
                                                         <h2 style="color:#111111;display:block;font-size:18px;font-weight:bold;line-height:130%;margin:0 0 18px;text-align:left">
                                                            <a href="https://shop.southindiajewels.com/demo/wp-admin/post.php?post=10439&amp;action=edit" style="font-weight:normal;text-decoration:underline;color:#111111" target="_blank">[<span class="il">Order</span> #'.$order_number.']</a> ('.date('M d,Y',strtotime($order->created_at)).')
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
                              $product_count=$product_quantity;
                              foreach($cart->items as $prod)
        {
			if($product_id==$prod['item']['id']){
            $ProductDetails = Product::findOrFail($prod['item']['id']);
            $usersid = User::findOrFail($prod['item']['user_id']);
            $product_imag=$prod['item']['photo'] ? filter_var($prod['item']['photo'], FILTER_VALIDATE_URL) ?$prod['item']['photo']:asset('assets/images/products/'.$prod['item']['photo']):asset('assets/images/noimage.png') ;
        
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
                                                                     $msg .='<td  style="color:#717a7a;border:1px solid #e4e4e4;padding:12px;text-align:left;vertical-align:middle;" width="60">'.$product_quantity.'</td><td style="color:#717a7a;border:1px solid #e4e4e4;padding:12px;text-align:left;vertical-align:middle;">'.$order->currency_sign.''.$product_amount.'</td>
                                                                  
                              </tr>';
} 
		}
                            
                             
                             $msg .='</tbody>
                                                               <tfoot>
                                                                  <tr>
                                                                     <th scope="row" colspan="2" style="color:#717a7a;border:1px solid #e4e4e4;vertical-align:middle;padding:12px;text-align:left;border-top-width:4px">Subtotal ('.$product_quantity.' items):</th>
                                                                     <td style="color:#717a7a;border:1px solid #e4e4e4;vertical-align:middle;padding:12px;text-align:left;border-top-width:4px"><span><span>'.$order->currency_sign.'</span>'.$product_amount.'</span></td>
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
                                                                     <td style="color:#717a7a;border:1px solid #e4e4e4;vertical-align:middle;padding:12px;text-align:left"><span><span>'.$order->currency_sign.'</span> '.$product_amount.'</span></td>
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
                                                                        '.$order->customer_name.'<br>'.$order->customer_address.', '.$order->customer_city.'<br>'.$order->customer_state.', '.$order->customer_country.' '.$order->customer_zip.'<br><a href="tel:'.$order->customer_phone.'" style="color:#111111;font-weight:normal;text-decoration:underline" target="_blank">'.$order->customer_phone.'</a>                                                 <br><a href="mailto:'.$order->customer_email.'" target="_blank">'.$order->customer_email.'</a>                          
                                                                     </address>
                                                                  </td>
                                                                  <td valign="top" width="50%" style="text-align:left;padding:0">
                                                                     <h2 style="color:#111111;display:block;font-family:&quot;Helvetica Neue&quot;,Helvetica,Roboto,Arial,sans-serif;font-size:18px;font-weight:bold;line-height:130%;margin:0 0 18px;text-align:left">Shipping address</h2>
                                                                     <address style="padding:12px;color:#717a7a;border:1px solid #e4e4e4"> '.$order->customer_name.'<br>'.$order->customer_address.', '.$order->customer_city.'<br>'.$order->customer_state.', '.$order->customer_country.' '.$order->customer_zip.'</address>
                                                                  </td>
                                                               </tr>
                                                            </tbody>
                                                         </table>
                                                         <p style="margin:0 0 16px">Thanks for shopping with us.</p>
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
				
      
        //mail($to, $subject, $msg, $headers);
					}else{
						//mail($to, $subject, $msg, $headers);						

					}  	        
			return response()->json(array('redirect_url' => route('admin-creditnote-show',$CreditNote->id)));
			}else{
				return response()->json(array('errors' => 'Amount is less than 1'));
			}

    }
	
	public function opencredit()
    {
		return view('admin.creditnote.open');
	}
	
	public function opencredit_datatables()
    {
         
		$datas = CreditNote::where('status','=',0)->orderBy('id','desc')->get();        

         //--- Integrating This Collection Into Datatables
         return Datatables::of($datas)
		                      ->editColumn('id',function(CreditNote $data){
                                $id = $data->id;
                                return  $id;
                            }) 	
		                     ->editColumn('vendor_id',function(CreditNote $data){
                                $users = User::find($data->vendor_id);
                                return  $users->name;
                            }) 
                            ->editColumn('order_id',function(CreditNote $data){
                                $order_id = '<a href="'.route('admin-order-show',$data->order_id).'">'.$data->order_id.'</a>';
                                return $order_id; 
                            }) 
                           ->editColumn('product_name',function(CreditNote $data){
                                $product_name = $data->product_name;
                                return  $product_name;
                            })  
                          ->editColumn('product_sku',function(CreditNote $data){
                                $product_sku = $data->product_sku;
                                return  $product_sku;
                            }) 
							->editColumn('amount',function(CreditNote $data){
                                $amount = $data->amount;
                                return  $amount;
                            }) 
							/*->editColumn('quantity',function(CreditNote $data){
                                $quantity = $data->quantity;
                                return  $quantity;
                            }) */
							->editColumn('withdraw_data',function(CreditNote $data){
                                $withdraw_data = $data->withdraw_id;
                                return  $withdraw_data;
                            }) 	
                           ->editColumn('created_at', function(CreditNote $data) {
								return $data->created_at;
                            }) 
                       ->editColumn('action', function(CreditNote $data) {								
								$action = '<div class="godropdown"><button class="go-dropdown-toggle"> Actions<i class="fas fa-chevron-down"></i></button>
                                <div class="action-list"><a href="'.route('admin-creditnote-show',$data->id).'"><i class="fa fa-eye"></i>Details</a>
									 </div>
                                </div>';
								return $action;
							
                            })							
                            							
                            ->rawColumns(['order_id','product_name','product_sku','created_at','action'])
                            ->toJson(); 
    }
	
	public function resolved()
    {
		return view('admin.creditnote.resolved');
	}
	public function resolved_datatables()
    {
         
		$datas = CreditNote::where('status','=',1)->orderBy('id','desc')->get();        

         //--- Integrating This Collection Into Datatables
         return Datatables::of($datas)
		                      ->editColumn('id',function(CreditNote $data){
                                $id = $data->id;
                                return  $id;
                            }) 	
		                     ->editColumn('vendor_id',function(CreditNote $data){
                                $users = User::find($data->vendor_id);
                                return  $users->name;
                            }) 
                            ->editColumn('order_id',function(CreditNote $data){
                                $order_id = '<a href="'.route('admin-order-show',$data->order_id).'">'.$data->order_id.'</a>';
                                return $order_id; 
                            }) 
                           ->editColumn('product_name',function(CreditNote $data){
                                $product_name = $data->product_name;
                                return  $product_name;
                            })  
                          ->editColumn('product_sku',function(CreditNote $data){
                                $product_sku = $data->product_sku;
                                return  $product_sku;
                            }) 
							->editColumn('amount',function(CreditNote $data){
                                $amount = $data->amount;
                                return  $amount;
                            }) 
							/*->editColumn('quantity',function(CreditNote $data){
                                $quantity = $data->quantity;
                                return  $quantity;
                            })*/
                           ->editColumn('withdraw_data',function(CreditNote $data){
                                $withdraw_data = $data->withdraw_id;
                                return  $withdraw_data;
                            }) 							
                           ->editColumn('created_at', function(CreditNote $data) {
								return $data->created_at;
                            }) 							
                            							
                             ->editColumn('action', function(CreditNote $data) {								
								$action = '<div class="godropdown"><button class="go-dropdown-toggle"> Actions<i class="fas fa-chevron-down"></i></button>
                                <div class="action-list"><a href="'.route('admin-creditnote-cancelled',$data->id).'"><i class="fa fa-eye"></i>Details</a>
									 </div>
                                </div>';
								return $action;
							
                            })							
                            							
                            ->rawColumns(['order_id','product_name','product_sku','created_at','action'])
                            ->toJson();
    }
	
	public function decline()
    {
		return view('admin.creditnote.decline');
	}
	public function decline_datatables()
    {
         
		$datas = CreditNote::where('status','=',2)->orderBy('id','desc')->get();        

         //--- Integrating This Collection Into Datatables
         return Datatables::of($datas)
		                      ->editColumn('id',function(CreditNote $data){
                                $id = $data->id;
                                return  $id;
                            }) 	
		                     ->editColumn('vendor_id',function(CreditNote $data){
                                $users = User::find($data->vendor_id);
                                return  $users->name;
                            }) 
                            ->editColumn('order_id',function(CreditNote $data){
                                $order_id = '<a href="'.route('admin-order-show',$data->order_id).'">'.$data->order_id.'</a>';
                                return $order_id; 
                            }) 
                           ->editColumn('product_name',function(CreditNote $data){
                                $product_name = $data->product_name;
                                return  $product_name;
                            })  
                          ->editColumn('product_sku',function(CreditNote $data){
                                $product_sku = $data->product_sku;
                                return  $product_sku;
                            }) 
							->editColumn('amount',function(CreditNote $data){
                                $amount = $data->amount;
                                return  $amount;
                            }) 
							/*->editColumn('quantity',function(CreditNote $data){
                                $quantity = $data->quantity;
                                return  $quantity;
                            }) */
							->editColumn('withdraw_data',function(CreditNote $data){
                                $withdraw_data = $data->withdraw_id;
                                return  $withdraw_data;
                            }) 
                           ->editColumn('created_at', function(CreditNote $data) {
								return $data->created_at;
                            }) 							
                            							
                            ->rawColumns(['order_id','product_name','product_sku','created_at'])
                            ->toJson(); 
    }
	
	public function show($id)
    {
		$data = CreditNote::where('id','=',$id)->first();
		return view('admin.creditnote.details',compact('data'));
		
	}
	public function cancelled($id)
    {
		$data = CreditNote::where('id','=',$id)->first();
		return view('admin.creditnote.canceldetails',compact('data'));
		
	}
public function rstatus(Request $request, $id)
    {
		
		$creditnote = CreditNote::find($id);
        $creditnote->status = 1;
        $creditnote->update();
		$oid=$creditnote->order_id;
	    $vid=$creditnote->vendor_id;
	    $product_id=$creditnote->product_id;
		$product_data = Product::findOrFail($product_id);
		$newmsg = 'Credit Note Request is Cancel ';
        $newmsg .= '<br> Product Name : ' . $product_data->name.'( '.$product_data->sku.' )';		
			$notification = new Notification;
			$notification->order_id = $oid;			
			$notification->vendor_id = $vid;
			$notification->product_id = $product_id;
			$notification->vid = $creditnote->vid;
			$notification->message = htmlentities($newmsg);
			$notification->save();
		$msg = 'Status Updated Successfully';
        return response()->json($msg);
		
	}
	public function cancelstatus(Request $request, $id)
    {
		$email=env('ADMIN_EMAIL');		 
        $admindata = Admin::where('email',$email)->first();
		$creditnote = CreditNote::find($id);
		$oid=$creditnote->order_id;
	    $vid=$creditnote->vendor_id;
	    $product_id=$creditnote->product_id;
        $product_quantity=$creditnote->quantity;
        $product_reason=$creditnote->reason;
        $creditnote->status = 2;
        $creditnote->update();
		$product_data = Product::findOrFail($product_id);
		$newmsg = 'Credit Note Request is Cancel ';
        $newmsg .= '<br> Product Name : ' . $product_data->name.'( '.$product_data->sku.' )'; 		
			$notification = new Notification;
			$notification->order_id = $oid;			
			$notification->vendor_id = $vid;
			$notification->product_id = $product_id;
			$notification->vid = $creditnote->vid;
			$notification->message = htmlentities($newmsg);
			$notification->save();
			
		$gs = Generalsetting::findOrFail(1);
		$order_id= $oid;
		
		$order = Order::findOrFail($oid);
		$order_number = $order->order_number;	
			$cart = unserialize(bzdecompress(utf8_decode($order->cart)));			
			$to = $order->customer_email;	
            $subject = 'Your South India Jewels Order '.$order->order_number.' Credit Note Cancel';
 
// To send HTML mail, the Content-type header must be set
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
 
// Create email headers
$headers .= 'From: '.$gs->from_email."\r\n".
    'Reply-To: '.$gs->from_email."\r\n" .
    'X-Mailer: PHP/' . phpversion();
	$idarray = explode(',', $order->vendor_id_list);
                                $idcount = count(array_unique($idarray));
                                for($i=0;$i<=$idcount-1;$i++){
                                    $id = $idarray[$i];
                                    $user_data[] = User::all()->where('is_vendor','2')->where('id',$id)->pluck('id')->implode('');    
                                }	
foreach($user_data as $user_per) {	
	
$user_info= User::findOrFail($user_per);
//echo $user_info->id;
$vendor_em = 'vendor@southindiajewels.co.in';
//$vendor_em = $user_info->email;
$vendor_subject = 'Credit Note For Your South India Jewels Order '.$order->order_number.'is Cancel';

 
// Compose a simple HTML email message
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
                                          <h1 style="font-size:30px;font-weight:300;line-height:150%;margin:0;text-align:left;color:#ffffff"><span class="il"></span> <span class="il">Cancel Order</span>: #'.$order_number.'</h1>
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
                                                         <p style="margin:0 0 16px">Hi '.$user_info->name.',</p>
                                                         <p style="margin:0 0 16px">We have initiated the exchange for your order #'.$order_number.'.</p>
                                                         <h2 style="color:#111111;display:block;font-size:18px;font-weight:bold;line-height:130%;margin:0 0 18px;text-align:left">
                                                            <a href="https://shop.southindiajewels.com/demo/wp-admin/post.php?post=10439&amp;action=edit" style="font-weight:normal;text-decoration:underline;color:#111111" target="_blank">[<span class="il">Order</span> #'.$order_number.']</a> ('.date('M d,Y',strtotime($order->created_at)).')
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
                              $product_count=$product_quantity;
                              foreach($cart->items as $prod)
        {
			if($product_id==$prod['item']['id']){
            $ProductDetails = Product::findOrFail($prod['item']['id']);
            $usersid = User::findOrFail($prod['item']['user_id']);
            $product_imag=$prod['item']['photo'] ? filter_var($prod['item']['photo'], FILTER_VALIDATE_URL) ?$prod['item']['photo']:asset('assets/images/products/'.$prod['item']['photo']):asset('assets/images/noimage.png') ;
        
            $product_tot_price += round($prod['item']['price'] *$prod['qty'] * $order->currency_value , 2);
                           $vendor_msg .='<tr>
                                                                     <td  style="color:#717a7a;border:1px solid #e4e4e4;padding:12px;text-align:left;vertical-align:middle;"><a href="#" target="_blank">
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
                                                                     $vendor_msg .='<td  style="color:#717a7a;border:1px solid #e4e4e4;padding:12px;text-align:left;vertical-align:middle;" width="60">'.$prod['qty'].'</td><td style="color:#717a7a;border:1px solid #e4e4e4;padding:12px;text-align:left;vertical-align:middle;">'.$order->currency_sign.''.round($prod['item']['price'] * $order->currency_value , 2).'</td>
                                                                  
                              </tr>';
} 
		}
                            
                             
                             $vendor_msg .='</tbody>
                                                               <tfoot>
                                                                  <tr>
                                                                     <th scope="row" colspan="2" style="color:#717a7a;border:1px solid #e4e4e4;vertical-align:middle;padding:12px;text-align:left;border-top-width:4px">Subtotal ('.$product_count.' items):</th>
                                                                     <td style="color:#717a7a;border:1px solid #e4e4e4;vertical-align:middle;padding:12px;text-align:left;border-top-width:4px"><span><span>'.$order->currency_sign.'</span>'.$product_tot_price.'</span></td>
                                                                  </tr>';
                                                                  
                                                          														 
                                                         $vendor_msg .='<tr>
                                                            <th scope="row" colspan="2" style="color:#717a7a;border:1px solid #e4e4e4;vertical-align:middle;padding:12px;text-align:left;border-top-width:4px">Order Status :</th>
                                                            <td style="color:#717a7a;border:1px solid #e4e4e4;vertical-align:middle;padding:12px;text-align:left;border-top-width:4px"><span><span>Cancel</td>
                                                         </tr>';
														
                                                                  
                                                         
                                                         @$ship_cost = @$order->shipping_cost + @$order->packing_cost;
                                                         if(@$ship_cost){
                                                         $vendor_msg .='<tr>
                                                            <th scope="row" colspan="2" style="color:#717a7a;border:1px solid #e4e4e4;vertical-align:middle;padding:12px;text-align:left">Shipping:</th>
                                                             <td style="color:#717a7a;border:1px solid #e4e4e4;vertical-align:middle;padding:12px;text-align:left"></td>
                                                         </tr>';
                                                         }else{
                                                             $vendor_msg .='<tr>
                                                            <th scope="row" colspan="2" style="color:#717a7a;border:1px solid #e4e4e4;vertical-align:middle;padding:12px;text-align:left">Shipping:</th>
                                                            <td style="color:#717a7a;border:1px solid #e4e4e4;vertical-align:middle;padding:12px;text-align:left">Free shipping</td>
                                                         </tr>';
                                                         }
                                                                  $vendor_msg .='
                                                                  <tr>
                                                                     <th scope="row" colspan="2" style="color:#717a7a;border:1px solid #e4e4e4;vertical-align:middle;padding:12px;text-align:left">Payment method:</th>
                                                                     <td style="color:#717a7a;border:1px solid #e4e4e4;vertical-align:middle;padding:12px;text-align:left">'.$order->method.'</td>
                                                                  </tr>
                                                                  <tr>
                                                                     <th scope="row" colspan="2" style="color:#717a7a;border:1px solid #e4e4e4;vertical-align:middle;padding:12px;text-align:left">Total:</th>
                                                                     <td style="color:#717a7a;border:1px solid #e4e4e4;vertical-align:middle;padding:12px;text-align:left"><span><span>'.$order->currency_sign.'</span> '.round($product_tot_price * $order->currency_value , 2).'</span></td>
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
                                                                        '.$order->customer_name.'<br>'.$order->customer_address.', '.$order->customer_city.'<br>'.$order->customer_state.', '.$order->customer_country.' '.$order->customer_zip.'<br><a href="tel:'.$order->customer_phone.'" style="color:#111111;font-weight:normal;text-decoration:underline" target="_blank">'.$order->customer_phone.'</a>                                                 <br><a href="mailto:'.$order->customer_email.'" target="_blank">'.$order->customer_email.'</a>                          
                                                                     </address>
                                                                  </td>
                                                                  <td valign="top" width="50%" style="text-align:left;padding:0">
                                                                     <h2 style="color:#111111;display:block;font-family:&quot;Helvetica Neue&quot;,Helvetica,Roboto,Arial,sans-serif;font-size:18px;font-weight:bold;line-height:130%;margin:0 0 18px;text-align:left">Shipping address</h2>
                                                                     <address style="padding:12px;color:#717a7a;border:1px solid #e4e4e4"> '.$order->customer_name.'<br>'.$order->customer_address.', '.$order->customer_city.'<br>'.$order->customer_state.', '.$order->customer_country.' '.$order->customer_zip.'</address>
                                                                  </td>
                                                               </tr>
                                                            </tbody>
                                                         </table>
                                                         <p style="margin:0 0 16px">Thanks for shopping with us.</p>
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
   
mail($vendor_em, $vendor_subject, $vendor_msg, $headers);
	
}	
 
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
                                          <h1 style="font-size:30px;font-weight:300;line-height:150%;margin:0;text-align:left;color:#ffffff"><span class="il"></span> <span class="il">Cancel Order</span>: #'.$order_number.'</h1>
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
                                                         <p style="margin:0 0 16px">We have initiated the cancel for your order #'.$order_number.'.</p>
                                                         <h2 style="color:#111111;display:block;font-size:18px;font-weight:bold;line-height:130%;margin:0 0 18px;text-align:left">
                                                            <a href="https://shop.southindiajewels.com/demo/wp-admin/post.php?post=10439&amp;action=edit" style="font-weight:normal;text-decoration:underline;color:#111111" target="_blank">[<span class="il">Order</span> #'.$order_number.']</a> ('.date('M d,Y',strtotime($order->created_at)).')
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
                              $product_count=$product_quantity;
                              foreach($cart->items as $prod)
        {
			if($product_id==$prod['item']['id']){
            $ProductDetails = Product::findOrFail($prod['item']['id']);
            $usersid = User::findOrFail($prod['item']['user_id']);
            $product_imag=$prod['item']['photo'] ? filter_var($prod['item']['photo'], FILTER_VALIDATE_URL) ?$prod['item']['photo']:asset('assets/images/products/'.$prod['item']['photo']):asset('assets/images/noimage.png') ;
        
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
		}
                            
                             
                             $msg .='</tbody>
                                                               <tfoot>
                                                                  <tr>
                                                                     <th scope="row" colspan="2" style="color:#717a7a;border:1px solid #e4e4e4;vertical-align:middle;padding:12px;text-align:left;border-top-width:4px">Subtotal ('.$product_count.' items):</th>
                                                                     <td style="color:#717a7a;border:1px solid #e4e4e4;vertical-align:middle;padding:12px;text-align:left;border-top-width:4px"><span><span>'.$order->currency_sign.'</span>'.$product_tot_price.'</span></td>
                                                                  </tr>';
                                                                  
                                                          
                                                          $msg .='<tr>
                                                            <th scope="row" colspan="2" style="color:#717a7a;border:1px solid #e4e4e4;vertical-align:middle;padding:12px;text-align:left;border-top-width:4px">Order Status :</th>
                                                            <td style="color:#717a7a;border:1px solid #e4e4e4;vertical-align:middle;padding:12px;text-align:left;border-top-width:4px"><span><span>Cancel</td>
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
                                                                     <td style="color:#717a7a;border:1px solid #e4e4e4;vertical-align:middle;padding:12px;text-align:left"><span><span>'.$order->currency_sign.'</span> '.round($product_tot_price * $order->currency_value , 2).'</span></td>
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
                                                                        '.$order->customer_name.'<br>'.$order->customer_address.', '.$order->customer_city.'<br>'.$order->customer_state.', '.$order->customer_country.' '.$order->customer_zip.'<br><a href="tel:'.$order->customer_phone.'" style="color:#111111;font-weight:normal;text-decoration:underline" target="_blank">'.$order->customer_phone.'</a>                                                 <br><a href="mailto:'.$order->customer_email.'" target="_blank">'.$order->customer_email.'</a>                          
                                                                     </address>
                                                                  </td>
                                                                  <td valign="top" width="50%" style="text-align:left;padding:0">
                                                                     <h2 style="color:#111111;display:block;font-family:&quot;Helvetica Neue&quot;,Helvetica,Roboto,Arial,sans-serif;font-size:18px;font-weight:bold;line-height:130%;margin:0 0 18px;text-align:left">Shipping address</h2>
                                                                     <address style="padding:12px;color:#717a7a;border:1px solid #e4e4e4"> '.$order->customer_name.'<br>'.$order->customer_address.', '.$order->customer_city.'<br>'.$order->customer_state.', '.$order->customer_country.' '.$order->customer_zip.'</address>
                                                                  </td>
                                                               </tr>
                                                            </tbody>
                                                         </table>
                                                         <p style="margin:0 0 16px">Thanks for shopping with us.</p>
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

   if($gs->is_smtp == 1)
                    {
      
        //mail($to, $subject, $msg, $headers);
					}else{
		//mail($to, $subject, $msg, $headers);						

					} 
		$msg = 'Status Updated Successfully';
        return response()->json($msg);
		
	}
	
	public function export($status){    		 
	 
	$datas = CreditNote::orderBy('id','desc')->get();	
	$fileName = 'credit.csv';	
		
	$headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        $columns = array('Order No','Order Date','Vendor Name','Product Name', 'Product Sku','Amount', 'Quantity', 'Payment Status', 'Withdraw ID', 'Credit Date');
       	$j=1;
		$callback = function() use($datas, $columns,$j) {
         $file = fopen('php://output', 'w');
         fputcsv($file, $columns);		 
            foreach ($datas as $data) {
			
				$dats = VendorOrder::find($data->vid);
                $row['Order No']  = $dats->order_number;
				if(@$dats->created_at){				
				 $row['Order Date']    = $dats->created_at;
				}else{
					 $row['Order Date']    = '';
				}                 				
				$users_name = User::all()->where('is_vendor','2')->where('id',$data->vendor_id)->pluck('shop_name')->implode(',');
                $row['Vendor Name']    = $users_name; 
				$productdata = Product::where('id',$data->product_id)->first();
				$row['Product Name']    = $productdata->name; 
				$row['Product Sku']    = $productdata->sku; 
				$row['Amount']    = $data->amount; 
				$row['Quantity']    = $data->quantity; 				
				 if(@$data->status==1){				
				$row['Payment Status']    = 'Paid';
				}else{
					$row['Payment Status']    = 'Unpaid';
				}
				 if(@$data->withdraw_id){				
				$row['Withdraw ID']    = $data->withdraw_id;
				}else{
					$row['Withdraw ID']    = '';
				}
               
                if(@$data->created_at){				
				$row['Credit Date']    = $data->created_at;
				}else{
					$row['Credit Date']    = '';
				}				
                fputcsv($file, array($row['Order No'],$row['Order Date'],$row['Vendor Name'],$row['Product Name'],$row['Product Sku'],$row['Amount'],$row['Quantity'],$row['Payment Status'],$row['Withdraw ID'],$row['Credit Date']));
				$j++;
		
			}
            fclose($file);
        };
		

        return response()->stream($callback, 200, $headers);
	}

 public function adddocument(Request $request, $id)
{
$document=array();
if($files=$request->file('document')){
foreach($files as $file){
$name=$file->getClientOriginalName();
$file->move('assets/images/document',$name);
$document[]=$name;
}
}
if($document) {
$dispute = CreditNote::find($id);
$dispute->document = implode(",",$document);
$dispute->update();
 return response()->json(array('redirect_url' => route('admin-creditnote-show',['id'=>$id])));
}else{
	return response()->json(array('errors' => 'Please Upload Document'));
}
}	

public function allcreditExcelFile(Request $request){
	$all_datas = CreditNote::orderBy('id','desc')->get();
	$fileName = 'credit_all.csv';	
		
	$headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );
		
		$columns = array('SL No','Vendor Name','Order Id','Product Name','Product SKU','Total Amount','Reason','Withdraw ID','Crdit Date');
		
		$j=1;			
		$callback = function() use($all_datas, $columns,$j) {
        $file = fopen('php://output', 'w');
         fputcsv($file, $columns);		 
            foreach ($all_datas as $all_data) {	
              $users = User::find($all_data->vendor_id);
			  $order_id = $all_data->order_id;
              $product_name = $all_data->product_name;
              $product_sku = $all_data->product_sku;
              $amount = $all_data->amount;
			  $reason = $all_data->reason;			  
              $withdraw_id = $all_data->withdraw_id;
              $created_at =$all_data->created_at; 			  
              $row['SL No']  = $j;
			  $row['Vendor Name']    = $users->name;
			  $row['Order Id']    = $order_id;
			  $row['Product Name']    = $product_name;
			  $row['Product SKU']    = $product_sku;
			  $row['Total Amount']    = $amount; 
			  $row['Reason']    =   $reason;
			  $row['Withdraw ID']    = $withdraw_id;
			  $row['Crdit Date']    = $created_at;			  
			  fputcsv($file, array($row['SL No'],$row['Vendor Name'],$row['Order Id'],$row['Product Name'],$row['Product SKU'],$row['Total Amount'], $row['Reason'],$row['Withdraw ID'],$row['Crdit Date'] ));
				$j++;
			}			
            fclose($file);
        };	

        return response()->stream($callback, 200, $headers);
	
	}
	
}

