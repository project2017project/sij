<?php

namespace App\Http\Controllers\Admin;

use Datatables;
use App\Classes\GeniusMailer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Generalsetting;
use App\Models\Withdraw;
use App\Models\Currency;
use App\Models\UserSubscription;
use Illuminate\Support\Facades\Input;
use App\Models\Order;
use App\Models\VendorOrder;
use App\Models\OrderTrack;
use App\Models\Notification;
use App\Models\Pagesetting;
use App\Models\Product;
use App\Models\Admin;
use App\Models\RaiseDispute;
use App\Models\DebitNote;
use App\Models\CreditNote;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use DB;
use Validator;
use Auth;
use PDF;
use Config;

class VendorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
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

	    //*** JSON Request
	    public function datatables()
	    {
	        $datas = User::where('is_vendor','=',2)->orWhere('is_vendor','=',1)->orderBy('id','desc')->get();
	         //--- Integrating This Collection Into Datatables
	         return Datatables::of($datas)
                                ->addColumn('status', function(User $data) {
                                    $class = $data->is_vendor == 2 ? 'drop-success' : 'drop-danger';
                                    $s = $data->is_vendor == 2 ? 'selected' : '';
                                    $ns = $data->is_vendor == 1 ? 'selected' : '';
                                    return '<div class="action-list"><select class="process select vendor-droplinks '.$class.'">'.
                                            '<option value="'. route('admin-vendor-st',['id1' => $data->id, 'id2' => 2]).'" '.$s.'>Activated</option>'.
                                            '<option value="'. route('admin-vendor-st',['id1' => $data->id, 'id2' => 1]).'" '.$ns.'>Deactivated</option></select></div>';
                                }) 
	                            ->addColumn('action', function(User $data) {
	                                return '<div class="godropdown"><button class="go-dropdown-toggle"> Actions<i class="fas fa-chevron-down"></i></button><div class="action-list"><a target="_blank" href="' . route('admin-vendor-secret',$data->id) . '" > <i class="fas fa-user"></i> Secret Login</a><a href="javascript:;" data-href="' . route('admin-vendor-verify',$data->id) . '" class="verify" data-toggle="modal" data-target="#verify-modal"> <i class="fas fa-question"></i> Ask For Verification</a><a href="' . route('admin-vendor-show',$data->id) . '" > <i class="fas fa-eye"></i> Details</a><a href="' . route('admin-vendor-edit',$data->id) . '"> <i class="fas fa-edit"></i> Edit</a><a href="javascript:;" class="send" data-email="'. $data->email .'" data-toggle="modal" data-target="#vendorform"><i class="fas fa-envelope"></i> Send Email</a><a href="javascript:;" data-href="' . route('admin-vendor-changepwd',$data->id) . '" class="cpwd" data-toggle="modal" data-target="#cpassword-modal"> <i class="fas fa-eye"></i> Change password</a><a href="javascript:;" data-href="' . route('admin-vendor-delete',$data->id) . '" data-toggle="modal" data-target="#confirm-delete" class="delete"><i class="fas fa-trash-alt"></i> Delete</a></div></div>';
	                            }) 
	                            ->rawColumns(['status','action'])
	                            ->toJson(); //--- Returning Json Data To Client Side
	    }

	//*** GET Request
    public function index()
    {
        return view('admin.vendor.index');
    }
	
	//*** GET Request
    public function register()
    {
        return view('admin.vendor.register');
    }
	 public function addvendor(Request $request)
    {

    	$gs = Generalsetting::findOrFail(1);   


        //--- Validation Section

        $rules = [
		        'email'   => 'required|email|unique:users',
		        'password' => 'required|confirmed'
                ];
        $validator = Validator::make(Input::all(), $rules);
        
        if ($validator->fails()) {
          return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }
        //--- Validation Section Ends

	        $user = new User;
	        $input = $request->all();        
	        $input['password'] = bcrypt($request['password']);
	        $token = md5(time().$request->name.$request->email);
	        $input['verification_link'] = $token;
	        $input['affilate_code'] = md5($request->name.$request->email);

	          if(!empty($request->vendor))
	          {
					//--- Validation Section
					$rules = [
						'shop_name' => 'unique:users',
						'shop_number'  => 'max:10'
							];
					$customs = [
						'shop_name.unique' => 'This Shop Name has already been taken.',
						'shop_number.max'  => 'Shop Number Must Be Less Then 10 Digit.'
					];

					$validator = Validator::make(Input::all(), $rules, $customs);
					if ($validator->fails()) {
					return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
					}
					$input['is_vendor'] = 1;

			  }
			  
			$user->fill($input)->save();
	        if($gs->is_verification_email == 1)
	        {
	        $to = $request->email;
	        $subject = 'Verify your email address.';
	        $msg = "Dear Customer,<br> We noticed that you need to verify your email address. <a href=".url('user/register/verify/'.$token).">Simply click here to verify. </a>";
	        //Sending Email To Customer
	        if($gs->is_smtp == 1)
	        {
	        $data = [
	            'to' => $to,
	            'subject' => $subject,
	            'body' => $msg,
	        ];

	        $mailer = new GeniusMailer();
	        $mailer->sendCustomMail($data);
	        }
	        else
	        {
	        $headers = "From: ".$gs->from_name."<".$gs->from_email.">";
	        mail($to,$subject,$msg,$headers);
	        }
          	return response()->json('We need to verify your email address. We have sent an email to '.$to.' to verify your email address. Please click link in that email to continue.');
	        }
	        else {

            $user->email_verified = 'Yes';
            $user->update();
	        $notification = new Notification;
	        $notification->user_id = $user->id;
	        $notification->save();
            Auth::guard('web')->login($user); 
			$msg = "Verification Added Successfully."; ;
            return response()->json($msg);			
          	//return return response()->json(['success'=>true,'url'=> route('admin-vendor-register')]);
	        }

    }

    //*** GET Request
    public function color()
    {
        return view('admin.generalsetting.vendor_color');
    }


    //*** GET Request
    public function subsdatatables()
    {
         $datas = UserSubscription::where('status','=',1)->orderBy('id','desc')->get();
         //--- Integrating This Collection Into Datatables
         return Datatables::of($datas)
                            ->addColumn('name', function(UserSubscription $data) {
                                $name = isset($data->user->owner_name) ? $data->user->owner_name : 'Removed';
                                return  $name;
                            })

                            ->editColumn('txnid', function(UserSubscription $data) {
                                $txnid = $data->txnid == null ? 'Free' : $data->txnid;
                                return $txnid;
                            }) 
                            ->editColumn('created_at', function(UserSubscription $data) {
                                $date = $data->created_at->diffForHumans();
                                return $date;
                            }) 
                            ->addColumn('action', function(UserSubscription $data) {
                                return '<div class="action-list"><a data-href="' . route('admin-vendor-sub',$data->id) . '" class="view details-width" data-toggle="modal" data-target="#modal1"> <i class="fas fa-eye"></i>Details</a></div>';
                            }) 
                            ->rawColumns(['action'])
                            ->toJson(); //--- Returning Json Data To Client Side


    }


	//*** GET Request
    public function subs()
    {

        return view('admin.vendor.subscriptions');
    }

	//*** GET Request
    public function sub($id)
    {
        $subs = UserSubscription::findOrFail($id);
        return view('admin.vendor.subscription-details',compact('subs'));
    }

	//*** GET Request
  	public function status($id1,$id2)
    {
        $user = User::findOrFail($id1);
        $user->is_vendor = $id2;
        $user->update();
        //--- Redirect Section        
        $msg[0] = 'Status Updated Successfully.';
        return response()->json($msg);      
        //--- Redirect Section Ends    

    }

	//*** GET Request
    public function edit($id)
    {
        $data = User::findOrFail($id);
        return view('admin.vendor.edit',compact('data'));
    }



	//*** GET Request
    public function verify($id)
    {
        $data = User::findOrFail($id);
        return view('admin.vendor.verification',compact('data'));
    }
	//*** GET Request
	public function changepwd($id)
    {
        $data = User::findOrFail($id);
        return view('admin.vendor.changepwd',compact('data'));
    }
	
	 public function changepass(Request $request, $id)
    {
		
        $user = User::findOrFail($id);
        
                if ($request->newpass == $request->renewpass){
                    $input['password'] = Hash::make($request->newpass);
                }else{
                    return response()->json(array('errors' => [ 0 => 'Confirm password does not match.' ]));
                }
            
        $user->update($input);
        $msg = 'Successfully change your passwprd';
        return response()->json($msg);
    }

	//*** POST Request
    public function verifySubmit(Request $request, $id)
    {
        $settings = Generalsetting::find(1);
        $user = User::findOrFail($id);
        $user->verifies()->create(['admin_warning' => 1, 'warning_reason' => $request->details]);

                    if($settings->is_smtp == 1)
                    {
                    $data = [
                        'to' => $user->email,
                        'type' => "vendor_verification",
                        'cname' => $user->name,
                        'oamount' => "",
                        'aname' => "",
                        'aemail' => "",
                        'onumber' => "",
                    ];
                    $mailer = new GeniusMailer();
                    $mailer->sendAutoMail($data);        
                    }
                    else
                    {
                    $headers = "From: ".$settings->from_name."<".$settings->from_email.">";
                    mail($user->email,'Request for verification.','You are requested verify your account. Please send us photo of your passport.Thank You.',$headers);
                    }

        $msg = 'Verification Request Sent Successfully.';
        return response()->json($msg);   
    }


	//*** POST Request
    public function update(Request $request, $id)
    {
	    //--- Validation Section
	        $rules = [
                'shop_name'   => 'unique:users,shop_name,'.$id,
                 ];
            $customs = [
                'shop_name.unique' => 'Shop Name "'.$request->shop_name.'" has already been taken. Please choose another name.'
            ];

         $validator = Validator::make(Input::all(), $rules,$customs);
         
         if ($validator->fails()) {
           return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
         }
         //--- Validation Section Ends

        $user = User::findOrFail($id);
        $data = $request->all();
        $user->update($data);
        $msg = 'Vendor Information Updated Successfully.'.'<a href="'.route("admin-vendor-index").'">View Vendor Lists</a>';
        return response()->json($msg);   
    }

	//*** GET Request
    public function show($id)
    {
        $data = User::findOrFail($id);
        return view('admin.vendor.show',compact('data'));
    }
    

    //*** GET Request
    public function secret($id)
    {
        Auth::guard('web')->logout();
        $data = User::findOrFail($id);
        Auth::guard('web')->login($data); 
        return redirect()->route('vendor-dashboard');
    }
    

	//*** GET Request
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->is_vendor = 0;
            $user->is_vendor = 0;
            $user->shop_name = null;
            $user->shop_details= null;
            $user->owner_name = null;
            $user->shop_number = null;
            $user->shop_address = null;
            $user->reg_number = null;
            $user->shop_message = null;
        $user->update();
        if($user->notivications->count() > 0)
        {
            foreach ($user->notivications as $gal) {
                $gal->delete();
            }
        }
            //--- Redirect Section     
            $msg = 'Vendor Deleted Successfully.';
            return response()->json($msg);      
            //--- Redirect Section Ends    
    }
		 //*** JSON Request
        public function adminapprovelistdatatables()
        {
		$svendor = (!empty($_GET["svendor"])) ? ($_GET["svendor"]) : ('');
        $startdateis = (!empty($_GET["startdateis"])) ? ($_GET["startdateis"]) : (''); 
        $enddateis = (!empty($_GET["enddateis"])) ? ($_GET["enddateis"]) : ('');
		$orderstatus = (!empty($_GET["orderstatus"])) ? ($_GET["orderstatus"]) : ('');
             //$datas = VendorOrder::where('admin_approve','=','completed')->orwhere('admin_approve','=','approved')->orderBy('id','desc')->get();
			 $query = VendorOrder::select('*');
            if(!empty($svendor))
                $query->where('user_id','=',$svendor);
            if(!empty($startdateis))
                $query->whereDate('created_at','>=',$startdateis);
            if(!empty($enddateis))
                $query->whereDate('created_at','<=',$enddateis);
			if(!empty($orderstatus))
                $query->where('status','=',$orderstatus);  
            if(!empty($svendor) || !empty($startdateis) || !empty($enddateis) || !empty($orderstatus ))	{
				$datas=$query->where('admin_approve','=','completed')->orderBy('id','desc')->get();
			}else{
				$datas=$query->where('admin_approve','=','completed')->orwhere('admin_approve','=','approved')->orderBy('id','desc')->get();
            }
           //--- Integrating This Collection Into Datatables
             return Datatables::of($datas)
                                ->addColumn('name', function(VendorOrder $data) {
                                    $name = $data->user->shop_name;
                                    return '<a href="' . route('admin-vendor-show',$data->user->id) . '" target="_blank">'. $name .'</a>';
                                }) 
                                 ->addColumn('OrderId', function(VendorOrder $data) {
                                   $order_id = '<a href="'.route('admin-order-show',$data->order_id).'">'.$data->order_id.'</a>';
                                return $order_id;
                                }) 
                                ->addColumn('price', function(VendorOrder $data) {
                                    $price = $data->price;
									$currency_sign = Order::find($data->order_id);
                                    return '₹'. round($price,2);
                                }) 
								->addColumn('action', function(VendorOrder $data) {
									$order_id = $data->order_id;
									$user_id =$data->user->id;
									$raisedispute = RaiseDispute::where('vendor_id','=',$user_id)->where('order_id','=',$order_id)->where('status','=','open')->orderBy('id','desc')->first();
                                    if($raisedispute){
										
										$action = '<div class="action-list">';                                    
										$action .='<p>RaiseDispute</p>';									
                                        $action .= '</div>';									
                                    return $action;
									}else{
									$action = '<div class="action-list">';
                                    if($data->admin_approve == "approved") {
										$action .='<p>Approved</p>';
									}else{
                                    $action .= '<a data-href="' . route('admin-vendor-adminapprove-accept',$data->id) . '" 
									data-toggle="modal" data-target="#confirm-delete"> <i class="fas fa-check"></i> Pending Approval</a>';
                                    }
                                    $action .= '</div>';
									
                                    return $action;
									}
                                }) 
                                ->addColumn('orderdate', function(VendorOrder $data) {
                                    $orderdate = date('d-M-Y',strtotime($data->created_at));
									
                                    return  $orderdate;
                                }) 
                                ->addColumn('shippingdate', function(VendorOrder $data) {
                                    $vendor = $data->user_id;
                                    $orderid = $data->order_id;
									$vid = $data->id;
                                    $shipdate = $order_track = OrderTrack::all()->where('vid',$vid)->where('vendor_id',$vendor)->where('order_id',$orderid)->pluck('created_at');
                                    
                                    foreach ($shipdate as $dates => $date) {
                                    	$shippingdate = date('d-M-Y',strtotime($date));
                                    	return $shippingdate;
                                     }
                                }) 
                                ->addColumn('trackinginfo', function(VendorOrder $data) {
                                  $vendor = $data->user_id;
                                      $orderid = $data->order_id;
									$vid = $data->id;
                                    $order_track = OrderTrack::all()->where('vid',$vid)->where('vendor_id',$vendor)->where('order_id',$orderid)->pluck('text', 'title', 'companyname'); 
                                    $order_track_url=array();
									foreach ($order_track as $title => $text) {
                                    	$order_track_url = '<b>Tracking Url : </b><a href="' . $text . '" target="_blank">'.$text.'</a><br><b>Tracking Code</b> : '.$title.'';
                                    	
                                     }
                                     
                                     $trackd = $order_track_url;
                                    /*$order_track_url = '<a href="#">dsad</a>';*/
									 return $trackd;
                                    
                                    
                                }) 
                                ->rawColumns(['name','OrderId','price','action','trackinginfo'])
                                ->toJson(); //--- Returning Json Data To Client Side
        }

        //*** GET Request
        public function adminapprovelist()
        {
		$users = User::all()->where('is_vendor','2');        
        return view('admin.vendor.adminapprovelist',compact('users'));
        
        }
		 //*** GET Request   
        public function adminapprove($id)
        {
			
            $email=env('ADMIN_EMAIL');		 
            $admindata = Admin::where('email',$email)->first();
            VendorOrder::where('id',$id)->update(['admin_approve' => 'approved']);
			$vendorOrder = VendorOrder::find($id);
			$order = Order::find($vendorOrder->order_id);			
			$tot_ct = VendorOrder::where('order_id','=',$vendorOrder->order_id)->count('id');
			$ap_ct =  VendorOrder::where('order_id','=',$vendorOrder->order_id)->where('admin_approve','=','approved')->count('id');
			if($tot_ct==$ap_ct){
				Order::where('id',$vendorOrder->order_id)->update(['status' => 'completed']);				
			}
			$gs = Generalsetting::findOrFail(1);
			$order_id= $vendorOrder->order_id;
			$cart = unserialize(bzdecompress(utf8_decode($order->cart)));
            $user_info= User::findOrFail($vendorOrder->user_id);
            $email=env('ADMIN_EMAIL');		 
$admindata = Admin::where('email',$email)->first(); 
$admin_em = Pagesetting::find(1)->contact_email;	
			$to = 'vendor@southindiajewels.co.in';	
			/*$to = $user_info->email;*/
            $subject = 'Your South India Jewels order '.$order->order_number.' is now complete';
            $admin_subject = '[South India Jewels]: order #'.$order->order_number.' is now complete';
 
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
                                          <h1 style="font-size:30px;font-weight:300;line-height:150%;margin:0;text-align:left;color:#ffffff"><span class="il"></span> <span class="il">Order</span>: #'.$order_id.'</h1>
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
                                                         <p style="margin:0 0 16px">Your order #'.$order_id.'is delivered successfully and marked completed.</p>
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
                                          <h1 style="font-size:30px;font-weight:300;line-height:150%;margin:0;text-align:left;color:#ffffff"><span class="il"></span> <span class="il">Order</span>: #'.$order_id.'</h1>
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
                                                         <p style="margin:0 0 16px">Your order #'.$order_id.'is delivered successfully and marked completed.</p>
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
                                                         $admin_msg .='<tr>
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




$vendor_subject = '[South India Jewels] Store Order ('.$order->order_number.') - '.date('M d, Y',strtotime($order->created_at)).'is completed';
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
                                          <h1 style="font-size:30px;font-weight:300;line-height:150%;margin:0;text-align:left;color:#ffffff"><span class="il"></span> <span class="il">Order</span>: #'.$order_id.'</h1>
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
                                                         <p style="margin:0 0 16px">Hi,</p>
                                                         <p style="margin:0 0 16px">Your Store order #'.$order_id.'is delivered successfully and marked completed.</p>
                                                         <h2 style="color:#111111;display:block;font-size:18px;font-weight:bold;line-height:130%;margin:0 0 18px;text-align:left">
                                                            <a href="https://shop.southindiajewels.com/demo/wp-admin/post.php?post=10439&amp;action=edit" style="font-weight:normal;text-decoration:underline;color:#111111" target="_blank">[<span class="il">Order</span> #'.$order_id.']</a> ('.date('M d,Y',strtotime($order->created_at)).')
                                                         </h2>
                                                       
                                                         <div style="display:none;font-size:0;max-height:0;line-height:0;padding:0"></div>
                                                    
                                                         <p style="margin:0 0 16px">Thanks for using shop.southindiajewels.com! </p>
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
             
        }
					}else{
						mail($to, $subject, $msg, $headers);					mail($admin_em, $admin_subject, $admin_msg, $headers);	

					}
  
                /* if($gs->is_smtp == 1){
                    $maildata = [
                        'to' => $order->customer_email,
                        'subject' => 'Your order '.$order->order_number.' Accepted Successfully.',
                        'body' => "Hello ".$order->customer_name.","."\n Thank you for shopping with us. We are looking forward to your next visit.",
                    ];
    
                    $mailer = new GeniusMailer();
                    $mailer->sendCustomMail($maildata);                
                }else{
                   $to = $order->customer_email;				  
                    $subject = 'Your order '.$order->order_number.'  Accepted Successfully.';
                   $msg = "Hello ".$order->customer_name.","."\n Thank you for shopping with us. We are looking forward to your next visit.";
                     $headers = "From: ".$gs->from_name."<".$gs->from_email.">";
                   mail($to,$subject,$msg,$headers);                
                 }*/
            //--- Redirect Section     
            $rec_msg = 'Order Accepted Successfully.';
            return response()->json($rec_msg);      
            //--- Redirect Section Ends   
        }
        //*** JSON Request
        public function withdrawdatatables()
        {
             $statuswwithdraw = (!empty($_GET["statuswwithdraw"])) ? ($_GET["statuswwithdraw"]) : '';
		
       $query = Withdraw::where('type','=','vendor');
       if(!empty($statuswwithdraw)){
          $query->where('status','=',$statuswwithdraw);
		  $datas = $query->orderBy('id','desc')->get();	
					
        }else{
            $datas = Withdraw::where('type','=','vendor')->orderBy('id','desc')->get();   
        }
       
       
            /* $datas = Withdraw::where('type','=','vendor')->orderBy('id','desc')->get();*/
             //--- Integrating This Collection Into Datatables
             return Datatables::of($datas)
                                ->addColumn('name', function(Withdraw $data) {
                                    $name = $data->user->name;
                                    return '<a href="' . route('admin-vendor-show',$data->user->id) . '" target="_blank">'. $name .'</a>';
                                }) 
                                ->addColumn('id', function(Withdraw $data) {
                                    $id = $data->id;
                                    return $id;
                                })
                                ->addColumn('email', function(Withdraw $data) {
                                    $email = $data->user->email;
                                    return $email;
                                })
                                ->addColumn('shop_name', function(Withdraw $data) {
                                    $shopname = $data->user->shop_name;
                                    return $shopname;
                                })
								->addColumn('phone', function(Withdraw $data) {
                                    $phone = $data->user->phone;
                                    return $phone;
                                }) 
                                ->addColumn('commission', function(Withdraw $data) {
                                    $amount = $data->amount;
									$commission = $data->fee;
                                    return round($commission,2);
                                }) 
                                ->editColumn('status', function(Withdraw $data) {
                                    $status = ucfirst($data->status);
                                    return $status;
                                }) 
                                ->editColumn('amount', function(Withdraw $data) {
                                    $sign = Currency::where('is_default','=',1)->first();
                                    $amount = $sign->sign.round($data->amount * $sign->original_val , 2);
                                    
                                    	$alldata = $data->amount;								
										
            
            $debitdata = $data->total_debit_amount;
        
            
            $creditdata = $data->total_credit_amount;
            
            $availabledata = $alldata + $creditdata - $debitdata;
                                    
                                    
                                    return $availabledata;
                                }) 
                                ->addColumn('action', function(Withdraw $data) {
                                    /*$action = '<div class="action-list">
									<a data-href="' . route('admin-vendor-withdraw-show',$data->id) . '" 
									class="view details-width" data-toggle="modal" data-target="#modal1"> <i class="fas fa-eye"></i> Details</a> <a href="' . route('admin-vendor-withdrawslip',$data->id) . '">  Withdraw Slip</a>';*/
									$action = '<div class="action-list">
									<a href="' . route('admin-vendor-withdraw-show',$data->id) . '" 
									class="view details-width"> <i class="fas fa-eye"></i> Details</a> <a href="' . route('admin-vendor-withdrawslip',$data->id) . '">  Withdraw Slip</a><a href="' . route('admin-vendor-withdrawexcel',$data->id) . '">  Withdraw Slip Excel</a>';
                                    if($data->status == "pending") {
                                    /*$action .= '<a data-href="' . route('admin-vendor-withdraw-accept',$data->id) . '" 
									data-toggle="modal" data-target="#confirm-delete"> <i class="fas fa-check"></i> Accept</a>
									<a data-href="' . route('admin-order-rejected',$data->id) . '" 
									class="rejectwithdraw" data-toggle="modal" data-target="#modal1"> <i class="fas fa-trash-alt"></i> Reject</a>
									';*/
									$action .= '<a href="' . route('admin-vendor-withdraw-accepts',$data->id) . '" 
									> <i class="fas fa-check"></i> Accept</a>
									<a data-href="' . route('admin-order-rejected',$data->id) . '" 
									class="rejectwithdraw" data-toggle="modal" data-target="#modal1"> <i class="fas fa-trash-alt"></i> Reject</a>
									';
                                    }
                                    $action .= '</div>';
                                    return $action;
                                }) 
                                ->rawColumns(['name','action'])
                                ->toJson(); //--- Returning Json Data To Client Side
        }
        
        
        
        
    public function withdrawpendinglist($status){	
	 
	$datas = Withdraw::where('type','=','vendor')->where('status','pending')->orderBy('id','desc')->get();
	$fileName = 'withdraw.csv';	
		
	$headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        $columns = array('Withdraw ID', 'Order Id', 'Vendor Name', 'Amount','Commission', 'SGST', 'CGST', 'IGST', 'TCS', 'Debit Note', 'Credit Note', 'Net Payable','Payment Method', 'Date');
       	$j=1;
		$callback = function() use($datas, $columns,$j) {
         $file = fopen('php://output', 'w');
         fputcsv($file, $columns);		 
            foreach ($datas as $data) {
			
				
              $row['Withdraw ID']  = $data->id;
			  $row['Order Id']    = $data->group_order_id; 
				$users_name = User::all()->where('is_vendor','2')->where('id',$data->user_id)->pluck('shop_name')->implode(',');
                $row['Vendor Name']    = $users_name;
				$row['Amount']    = $data->withdrawal_amount;
                $commission = 0;
				if(@$data->withdrawal_amount){
				$row['Amount']    = $data->withdrawal_amount;
				$commission = round($data->fee, 2);
				}else{
					$row['Amount']    ='';
					$commission = 0;
				}
				
                $row['Commission']    = $commission; 				
				$row['SGST']    = $data->sgst; 
				$row['CGST']    = $data->cgst; 
				$row['IGST']    = $data->igst; 
				$row['TCS']    = $data->tcs; 
				$row['Debit Note']    = $data->total_debit_amount; 
				$row['Credit Note']    = $data->total_credit_amount; 
				$row['Net Payable']    = ($data->amount - $data->total_debit_amount) + $data->total_credit_amount; 
				$row['Payment Method']    = $data->method; 
				$row['Date']    = date('d-M-Y',strtotime($data->created_at)); 
                fputcsv($file, array($row['Withdraw ID'],$row['Order Id'],$row['Vendor Name'],$row['Amount'],$row['Commission'],$row['SGST'],$row['CGST'],$row['IGST'],$row['TCS'],$row['Debit Note'],$row['Credit Note'],$row['Net Payable'],$row['Payment Method'],$row['Date']));
				$j++;
		
			}
            fclose($file);
        };
		

        return response()->stream($callback, 200, $headers);
	}
        
        
        
        
        

        //*** GET Request
        public function withdraws()
        {
            return view('admin.vendor.withdraws');
        }

        //*** GET Request       
        public function withdrawdetails($id)
        {
            $sign = Currency::where('is_default','=',1)->first();
            $withdraw = Withdraw::findOrFail($id);
            return view('admin.vendor.withdraw-details',compact('withdraw','sign'));
        }

        //*** GET Request   
        public function accept(Request $request, $id)
        {
			
			$settle_status=$request->settle;
			$settle_note=$request->note;
			$settle_amount=$request->amount;
			$screenshot=array();
        if($files=$request->file('screenshot')){
            foreach($files as $file){
            $name=$file->getClientOriginalName();
            $file->move('assets/images/screenshot',$name);
            $screenshot[]=$name;
            }
            }
			$screenshot_data = implode(",",$screenshot);
            $withdraw = Withdraw::findOrFail($id);
			
			$vendorid= $withdraw->user_id;
			$debit_arr=array();
			$credit_arr=array();
			$debit_data=DebitNote::where('vendor_id',$vendorid)->where('status','=',0)->orderBy('id','asc')->get();
			foreach($debit_data as $debit_vals){
				$debit_arr[]=$debit_vals->id;
			}
			$debit_val= implode(",",$debit_arr);			
			$credit_data=CreditNote::where('vendor_id',$vendorid)->where('status','=',0)->orderBy('id','asc')->get();
			foreach($credit_data as $credit_vals){
				$credit_arr[]=$credit_vals->id;
			}
			$credit_val= implode(",",$credit_arr);
			
			
			$total_debit_amount=DebitNote::where('vendor_id',$vendorid)->where('status','=',0)->sum('amount');
			$total_credit_amount=CreditNote::where('vendor_id',$vendorid)->where('status','=',0)->sum('amount');
           
             $group_order_id=explode(",",$withdraw->group_order_id);
            VendorOrder::whereIn('order_id',$group_order_id)->where('user_id',$vendorid)->update(['vendor_request_status' => 'completed']);
            
            
            $data['status'] = "completed";
            $withdraw->update($data);
            
            $group_order_id=explode(",",$withdraw->group_order_id);
            VendorOrder::whereIn('order_id',$group_order_id)->where('user_id',$vendorid)->update(['vendor_request_status' => 'completed']);
			
			//Withdraw::where('id',$id)->update(['settle' => $settle_status,'note' => $settle_note,'settle_amount' => $settle_amount,'screen_shot' => $screenshot_data,'total_debit_amount' => $total_debit_amount,'total_credit_amount' => $total_credit_amount]);
			
			Withdraw::where('id',$id)->update(['settle' => $settle_status,'note' => $settle_note,'settle_amount' => $settle_amount,'screen_shot' => $screenshot_data]);
			
			DB::table('credit_notes')->where(['vendor_id' => $vendorid,'status' => 0])->update(['status' => $settle_status,'withdraw_id' => $id,'withdraw_status' => 1]);
            DB::table('debit_notes')->where(['vendor_id' => $vendorid,'status' => 0])->update(['status' => $settle_status,'withdraw_id' => $id,'withdraw_status' => 1]);
            //--- Redirect Section  
            return response()->json(array('redirect_url' => route('admin-vendor-withdraw-index'))); 			
            /*$msg = 'Withdraw Accepted Successfully.';
            return response()->json($msg); */     
            //--- Redirect Section Ends   
        }
		 public function accepts($id)
        {
            $sign = Currency::where('is_default','=',1)->first();
            $withdraw = Withdraw::findOrFail($id);		
            $gs = Generalsetting::findOrFail(1);
            $subject = 'Your South India Jewels Withdraw Successfull '.$withdraw->id.' request for DebitNote';
			// To send HTML mail, the Content-type header must be set
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
 
// Create email headers
$headers .= 'From: '.$gs->from_email."\r\n".
    'Reply-To: '.$gs->from_email."\r\n" .
    'X-Mailer: PHP/' . phpversion();

$vendor_em = 'vendor@southindiajewels.co.in';
//$vendor_em = $user_info->email;
$vendor_subject = 'Withdraw Request #'.$withdraw->id.' For Your South India Jewels order ';
 
// Compose a simple HTML email message
     $vendor_msg = 'Withdraw Request Successfull';
     mail($vendor_em, $vendor_subject, $vendor_msg, $headers);
            return view('admin.vendor.accepts',compact('withdraw','sign'));
        }
		public function rejected($id)
    {
        $data = Withdraw::findOrFail($id);		 
        return view('admin.vendor.withdraws-reject',compact('data'));
    }

        //*** GET Request   
        public function reject(Request $request,$id)
        {

            $withdraw = Withdraw::findOrFail($id);
            $account = User::findOrFail($withdraw->user->id);
            $account->affilate_income = $account->affilate_income + $withdraw->amount + $withdraw->fee;
            $account->update();
            $data['status'] = "rejected";
			$data['comment'] = $request->comment;			
            $withdraw->update($data);
            
            $group_order_id=explode(",",$withdraw->group_order_id);
            VendorOrder::whereIn('order_id',$group_order_id)->where('user_id',$withdraw->user->id)->update(['vendor_request_status' => 'rejected']);
			DB::table('credit_notes')->where(['vendor_id' => $withdraw->user->id,'status' => 0])->update(['withdraw_status' => 0]);
            DB::table('debit_notes')->where(['vendor_id' => $withdraw->user->id,'status' => 0])->update(['withdraw_status' => 0]);
            //--- Redirect Section     
            $msg = 'Withdraw Rejected Successfully.';
            
             $gs = Generalsetting::findOrFail(1);
            $subject = 'Your South India Jewels Withdraw Rejected '.$withdraw->id.' request for DebitNote';
			// To send HTML mail, the Content-type header must be set
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
 
// Create email headers
$headers .= 'From: '.$gs->from_email."\r\n".
    'Reply-To: '.$gs->from_email."\r\n" .
    'X-Mailer: PHP/' . phpversion();

$vendor_em = 'vendor@southindiajewels.co.in';
//$vendor_em = $user_info->email;
$vendor_subject = 'Withdraw Request #'.$withdraw->id.' For Your South India Jewels order ';
 
// Compose a simple HTML email message
     $vendor_msg = 'Withdraw Request Rejected';
     mail($vendor_em, $vendor_subject, $vendor_msg, $headers);
        
            return response()->json($msg);      
            //--- Redirect Section Ends   
        }
		
		public function withdrawslip($id){
        $withdraws = Withdraw::findOrFail($id);         
        $fileName = 'withdrawslip'.$withdraws->id.'.pdf';
		//$fileName = 'withdrawslip.pdf';
		$email=env('ADMIN_EMAIL');		 
        $admindata = Admin::where('email',$email)->first();
        $pdf = PDF::loadView('admin.vendor.withdrawslip', compact('withdraws','admindata'))->save($fileName);
        
        
       /* $gs = Generalsetting::findOrFail(1);
            $subject = 'Your South India Jewels Withdraw Successfull '.$withdraws->id.' request for DebitNote';
			// To send HTML mail, the Content-type header must be set
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
 
// Create email headers
$headers .= 'From: '.$gs->from_email."\r\n".
    'Reply-To: '.$gs->from_email."\r\n" .
    'X-Mailer: PHP/' . phpversion();

$vendor_em = 'vendor@southindiajewels.co.in';
//$vendor_em = $user_info->email;
$vendor_subject = 'Withdraw Request #'.$withdraws->id.' For Your South India Jewels order ';
 
// Compose a simple HTML email message
     $vendor_msg = 'Withdraw Request Rejected';
     mail($vendor_em, $vendor_subject, $vendor_msg, $headers);*/
        
        
        return $pdf->stream($fileName);
    }
	
	 public function withdrawexcel($id){	
	 $datas = Withdraw::where('type','=','vendor')->where('id','=',$id)->orderBy('id','desc')->get(); 
	 $fileName = 'withdraw_slip.csv';	
		
	$headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

      $columns = array('SL No', 'Order Id', 'Vendor Name', 'Price', 'Commission', 'SGST', 'CGST', 'IGST', 'TCS', 'Net Payment','Payment Method','Debit Note Id','Credit Note Id','Debit Note Amount','Credit Note Amount','Net Payable', 'Date');
	   
       	$j=1;
		$callback = function() use($datas, $columns,$j) {
         $file = fopen('php://output', 'w');
         fputcsv($file, $columns);		 
            foreach ($datas as $data) {
			
				
              $row['SL No']  = $j;
			  $row['Order Id']    = $data->group_order_id; 
				$users_name = User::all()->where('is_vendor','2')->where('id',$data->user_id)->pluck('shop_name')->implode(',');
                if(@$users_name){
				$row['Vendor Name']    = $users_name;
				}else{
					$row['Vendor Name']    = '';
				}
				$commission = 0;
				if(@$data->withdrawal_amount){
				$row['Price']    = $data->withdrawal_amount;
				$commission = $data->withdrawal_amount*15/100;
				}else{
					$row['Price']    ='';
					$commission = 0;
				}
				
                $row['Commission']    = $commission;	
                 if(@$data->sgst){
				$row['SGST']    = $data->sgst;
				}else{
					$row['SGST']    = '';
				}	
                 if(@$data->cgst){
				$row['CGST']    = $data->cgst;
				}else{
					$row['CGST']    = '';
				}
                 if(@$data->igst){
				$row['IGST']    = $data->igst;
				}else{
					$row['IGST']    = '';
				}				
				 
				 if(@$data->tcs){
				$row['TCS']    = $data->tcs;
				}else{
					$row['TCS']    = '';
				}
				 if(@$data->amount){
				$row['Net Payment']    = $data->amount;
				}else{
					$row['Net Payment']    = 0;
				}
				 if(@$data->method){
				$row['Payment Method']    = $data->method;
				}else{
					$row['Payment Method']    = '';
				}
				 if(@$data->created_at){
				$row['Date']    = date('d-M-Y',strtotime($data->created_at)); 
				}else{
					$row['Date']    = '';
				}
				
				if(@$data->debit_note_id){
				$row['Debit Note Id']    = $data->debit_note_id;
				}else{
					$row['Debit Note Id']    = '';
				}
				
				 if(@$data->credit_note_id){
				$row['Credit Note Id']    = $data->credit_note_id;
				}else{
					$row['Credit Note Id']    = '';
				}
				
				 if(@$data->total_debit_amount){
				$row['Debit Note Amount']    = $data->total_debit_amount;
				}else{
					$row['Debit Note Amount']    = 0;
				}
				
				 if(@$data->total_credit_amount){
				$row['Credit Note Amount']    = $data->total_credit_amount;
				}else{
					$row['Credit Note Amount']    = 0;
				}
				
				$row['Net Payable']=$row['Net Payment']+$row['Credit Note Amount']-$row['Debit Note Amount'];
				
				
				
                fputcsv($file, array($row['SL No'],$row['Order Id'],$row['Vendor Name'],$row['Price'],$row['Commission'],$row['SGST'],$row['CGST'],$row['IGST'],$row['TCS'],$row['Net Payment'],$row['Payment Method'],$row['Debit Note Id'],$row['Credit Note Id'],$row['Debit Note Amount'],$row['Credit Note Amount'],$row['Net Payable'],$row['Date']));
				$j++;
		
			}
            fclose($file);
        };
		

        return response()->stream($callback, 200, $headers);
	}
}
