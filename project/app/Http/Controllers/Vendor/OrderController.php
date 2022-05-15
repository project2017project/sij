<?php

namespace App\Http\Controllers\Vendor;

use Illuminate\Http\Request;
use App\Classes\GeniusMailer;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use Auth;
use App\Models\Order;
use App\Models\VendorOrder;
use App\Models\Ordercsv;
use App\Models\OrderTrack;
use App\Models\Coupon;
use App\Models\Notification;
use App\Models\User;
use App\Models\Product;
use App\Models\Generalsetting;
use PDF;
use Datatables;
class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
	
	//*** JSON Request
    public function datatables($status){
        $user = Auth::user();
		$orderstatus = (!empty($_GET["orderstatus"])) ? ($_GET["orderstatus"]) : (''); 
        $startdateis = (!empty($_GET["startdateis"])) ? ($_GET["startdateis"]) : (''); 
        $enddateis = (!empty($_GET["enddateis"])) ? ($_GET["enddateis"]) : ('');

       
        $datas = VendorOrder::where('user_id','=',$user->id)->orderBy('id','desc')->get();
		//$datas = VendorOrder::where('user_id','=',$user->id)->where('status','=','completed')->orderBy('id','desc')->get();
		
		$query = VendorOrder::select('*');
            if(!empty($user))
                $query->where('user_id','=',$user->id);
            if(!empty($startdateis))
                $query->whereDate('created_at','>=',$startdateis);
            if(!empty($enddateis))
                $query->whereDate('created_at','<=',$enddateis);
			if(!empty($orderstatus))
                $query->where('status','=',$orderstatus);
           /*if(empty($orderstatus))
                $query->where('status','=','completed');*/			
          $datas=$query->where('status','!=','pending')->orderBy('id','desc')->get();
		
         
         //--- Integrating This Collection Into Datatables
         return Datatables::of($datas)
                            
							->editColumn('id', function(VendorOrder $data) {
                                $number = '<a href="'.route('vendor-order-invoice',$data->order_number).'">#'.$data->order_id.'</a>';
                                return $number;
                            })	
                            
                            ->editColumn('number', function(VendorOrder $data) {
                                $number = '<a href="'.route('vendor-order-invoice',$data->order_number).'">#'.$data->order_number.'</a>';
                                return $number;
                            })	
                            
							->editColumn('customer_name', function(VendorOrder $data) {
								$order_data = Order::find($data->order_id);
                                return $order_data->customer_name;
                            })
                            ->editColumn('billing_address', function(VendorOrder $data) {
								$order_data = Order::find($data->order_id);
                                return $order_data->customer_name . ',' . $order_data->customer_address . ',' . $order_data->customer_city . ',<br />' . $order_data->customer_state . ',' . $order_data->customer_country . ',' . $order_data->customer_zip . ',<br />' . $order_data->customer_landmark . ',' . $order_data->customer_phone ;
                            })
                            ->editColumn('shipping_address', function(VendorOrder $data) {
								$order_data = Order::find($data->order_id);
								$shipping_name = $order_data->shipping_name == null ? $order_data->customer_name : $order_data->shipping_name;
								$shipping_address = $order_data->shipping_address == null ? $order_data->customer_address : $order_data->shipping_address;
								$shipping_city = $order_data->shipping_city == null ? $order_data->customer_city : $order_data->shipping_city;
								$shipping_state = $order_data->shipping_state == null ? $order_data->customer_state : $order_data->shipping_state;
								$shipping_country = $order_data->shipping_country == null ? $order_data->customer_country : $order_data->shipping_country;
								$shipping_zip = $order_data->shipping_zip == null ? $order_data->customer_zip : $order_data->shipping_zip;
								$shipping_landmark = $order_data->shipping_landmark == null ? $order_data->customer_landmark : $order_data->shipping_landmark;
								$shipping_phone = $order_data->shipping_phone == null ? $order_data->customer_phone : $order_data->shipping_phone;
                                return   $shipping_name . ',' . $shipping_address . ',' . $shipping_city . ',<br />' . $shipping_state . ',' . $shipping_country . ',' . $shipping_zip . ',<br />' . $shipping_landmark . ',' . $order_data->shipping_phone ;
                            })
							->editColumn('totalQty', function(VendorOrder $data) {
							    $product_data = Product::find($data->product_id);
							    $purchase_item = '<span class="text-success"><b>'.$data->qty. 'Item'.'</b></span> <br />';
                                return $purchase_item . $product_data->name . '<br /> ('.$product_data->sku .')' ;
                            })							
							->editColumn('pay_amount', function(VendorOrder $data) {
							    $order_data = Order::find($data->order_id);
                                return $order_data->inr_currency_sign.$data->price;
                            })
							->editColumn('created_at', function(VendorOrder $data) {
								return $data->created_at;
                            })
							->editColumn('status', function(VendorOrder $data) {
								$pending= $data->status == "pending" ? 'selected' : '';
								$processing= $data->status == "processing" ? 'selected' : '';
								$completed= $data->status == "completed" ? 'selected' : '';
								$declined= $data->status == "declined" ? 'selected' : '';
								$delivery= $data->status == "on delivery" ? 'selected' : '';
								$status = '<select class="vendor-btn '.$data->status.'">';								
							//	$status.= '<option value="'.route('vendor-order-status',['slug' => $data->id, 'status' => 'pending']).'" '.$pending.' >Pending</option>';
								$status.= '<option value="'.route('vendor-order-status',['slug' => $data->id, 'status' => 'processing']).'" '.$processing.' >Processing</option>';
								$status.= '<option value="'.route('vendor-order-status',['slug' => $data->id, 'status' => 'completed']).'" '.$completed.' >Completed</option>';
							//	$status.= '<option value="'.route('vendor-order-status',['slug' => $data->id, 'status' => 'declined']).'"  '.$declined.'>Declined</option>';
								$status.= '<option value="'.route('vendor-order-status',['slug' => $data->id, 'status' => 'on delivery']).'" '.$delivery.' >Shipped</option>';
                                $status.= '</select>';
								$status.= "<script>jQuery('.vendor-btn').on('change',function(){ jQuery('#confirm-delete2').modal('show'); jQuery('#confirm-delete2').find('.btn-ok').attr('href', jQuery(this).val()); }); </script>";
								return $status;
							
                            })
							
							->editColumn('action', function(VendorOrder $data) {								
								$action = '<div class="godropdown"><button class="go-dropdown-toggle"> Actions<i class="fas fa-chevron-down"></i></button>
                                <div class="action-list">
                                     <a href="'.route('vendor-order-show',$data->id).'"><i class="fa fa-eye"></i>Details</a>
                                      <a href="javascript:;" data-href="'.route('vendor-order-track',$data->id).'" class="track" data-toggle="modal" data-target="#modal1"><i class="fas fa-truck"></i> Shipping Details</a>
                                    <a href="'.route('vendor-generate-invoice',$data->order_number).'"><i class="fa fa-eye"></i> Invoice</a>
                                    <a href="'.route('vendor-packingslip-invoice',$data->order_number).'"><i class="fa fa-eye"></i> Packing Slip</a>
                                    <a href="'.route('vendor-tax-invoice',$data->order_number).'"><i class="fa fa-eye"></i> Tax Invoice</a>
                                   
                                    
                                </div>
                                </div>';
								return $action;
							
                            })
                            
                            ->rawColumns(['id','number', 'billing_address', 'shipping_address', 'totalQty','action','status'])
                            ->toJson(); //--- Returning Json Data To Client Side
    }

    public function index()
    {
        $user = Auth::user();
        $orders = VendorOrder::where('user_id','=',$user->id)->orderBy('id','desc')->get()->groupBy('order_number');
        return view('vendor.order.index',compact('user','orders'));
    }
	public function newindex()
    {
        $user = Auth::user();		
        $orders = VendorOrder::where('user_id','=',$user->id)->orderBy('id','desc')->get()->groupBy('order_number');
        return view('vendor.order.newindex',compact('user','orders'));
    }
	public function vprocessing()
    {
        $user = Auth::user();		
        $orders = VendorOrder::where('user_id','=',$user->id)->where('status','=','processing')->orderBy('id','desc')->get()->groupBy('order_number');
        return view('vendor.order.vprocessing',compact('user','orders'));
    }
	public function vcompleted()
    {
        $user = Auth::user();		
        $orders = VendorOrder::where('user_id','=',$user->id)->where('status','=','completed')->orderBy('id','desc')->get()->groupBy('order_number');
        return view('vendor.order.vcompleted',compact('user','orders'));
    }
	public function vshipping()
    {
        $user = Auth::user();		
        $orders = VendorOrder::where('user_id','=',$user->id)->where('status','=','on delivery')->orderBy('id','desc')->get()->groupBy('order_number');
        return view('vendor.order.vshipping',compact('user','orders'));
    }

    public function withdraworderlist()
    {
		$email=env('ADMIN_EMAIL');		 
        $admin = Admin::where('email',$email)->first();              
        $user = Auth::user();
        $orders = VendorOrder::where('user_id','=',$user->id)
									->where('admin_approve','=','approved')									
									->whereIn('vendor_request_status',['NotRaised','rejected'])
									
									->where('product_item_price','=',NULL)
									//->where('vendor_request_status','=','NotRaised')
									//->orwhere('vendor_request_status','=','rejected')
									->orderBy('id','desc')->get()->groupBy('order_number');
        return view('vendor.order.withdraworder',compact('admin','user','orders'));
    }   

    public function show($id)
    {
    
        $user = Auth::user();
		$vorder = VendorOrder::where('id','=',$id)->first();
        $order = Order::where('order_number','=',$vorder->order_number)->first();        
        $email=env('ADMIN_EMAIL');		 
        $admin = Admin::where('email',$email)->first();        
        $cart = unserialize(bzdecompress(utf8_decode($order->cart)));
        $vendernotification = Notification::where('order_id','=',$order->id)->where('vendor_id','=',$user->id)->orderBy('id','desc')->get();
        return view('vendor.order.details',compact('admin','user','order','vorder','cart','vendernotification'));
    }
	
	public function vshow($slug)
    {
    
        $user = Auth::user();
        $order = Order::where('order_number','=',$slug)->first();        
        $email=env('ADMIN_EMAIL');		 
        $admin = Admin::where('email',$email)->first();        
        $cart = unserialize(bzdecompress(utf8_decode($order->cart)));
        $vendernotification = Notification::where('order_id','=',$order->id)->where('vendor_id','=',$user->id)->orderBy('id','desc')->get();
        return view('vendor.order.vdetails',compact('admin','user','order','cart','vendernotification'));
    }

    public function license(Request $request, $slug)
    {
        $order = Order::where('order_number','=',$slug)->first();
        $cart = unserialize(bzdecompress(utf8_decode($order->cart)));
        $cart->items[$request->license_key]['license'] = $request->license;
        $order->cart = utf8_encode(bzcompress(serialize($cart), 9));
        $order->update();         
        $msg = 'Successfully Changed The License Key.';
        return response()->json($msg);
    }



    public function invoice($slug)
    {
		$email=env('ADMIN_EMAIL');		 
        $admindata = Admin::where('email',$email)->first();
        $user = Auth::user();
        $order = Order::where('order_number','=',$slug)->first();
        $cart = unserialize(bzdecompress(utf8_decode($order->cart)));
        return view('vendor.order.invoice',compact('user','order','admindata','cart'));
    }
	 public function generateinvoice($slug)
    {
        $user = Auth::user();
        $order = Order::where('order_number','=',$slug)->first();
        /*$adminselect = Admin::findOrFail(1);
        $admindata = $adminselect->where('id','=','1')->first();*/
        $email=env('ADMIN_EMAIL');		 
        $admindata = Admin::where('email',$email)->first(); 
        $cart = unserialize(bzdecompress(utf8_decode($order->cart)));
      		
		$fileName = 'Vendor_invoice_'.$order->order_number.'.pdf';
        $pdf = PDF::loadView('print.vendorstoreinvoice', compact('user','order','admindata','cart'))->save($fileName);
       // return $pdf->download($fileName);
        return $pdf->stream($fileName);
    }
    public function generatetaxinvoice($slug)
    {
        $user = Auth::user();
        $order = Order::where('order_number','=',$slug)->first();
		/*$adminselect = Admin::findOrFail(1);
        $admindata = $adminselect->where('id','=','1')->first();*/
        $email=env('ADMIN_EMAIL');		 
        $admindata = Admin::where('email',$email)->first(); 
        $cart = unserialize(bzdecompress(utf8_decode($order->cart)));
      		
		$fileName = 'Vendor_invoice_'.$order->order_number.'.pdf';
        $pdf = PDF::loadView('print.vendortaxinvoice', compact('user','order','admindata','cart'))->save($fileName);
       // return $pdf->download($fileName);
        return $pdf->stream($fileName);
    }
	 public function packingslipinvoice($slug)
    {
        $user = Auth::user();
        /*$adminselect = Admin::findOrFail(1);
        $admindata = $adminselect->where('id','=','1')->first();*/
        $email=env('ADMIN_EMAIL');		 
        $admindata = Admin::where('email',$email)->first(); 
        $order = Order::where('order_number','=',$slug)->first();
        $cart = unserialize(bzdecompress(utf8_decode($order->cart)));
      	$fileName = 'vendor_packingslip_'.$order->order_number.'.pdf';
        $pdf = PDF::loadView('print.vendorpackagingslip', compact('user', 'admindata' ,'order','cart'))->save($fileName);
       // return $pdf->download($fileName);
        return $pdf->stream($fileName);
    }

    public function printpage($slug)
    {
        $user = Auth::user();
        $order = Order::where('order_number','=',$slug)->first();
        $cart = unserialize(bzdecompress(utf8_decode($order->cart)));
        return view('vendor.order.print',compact('user','order','cart'));
    }
	
	public function status($id,$status)
    {
		$ref_count =0;
		$ex_count =0;
        $user = Auth::user();
        $mainorders = VendorOrder::where('id','=',$id)->first();
		$slug = $mainorders->order_number;
		$all_main_count = VendorOrder::where('order_number','=',$slug)->where('user_id','=',$user->id)->count('id');
		$ref_count = VendorOrder::where('order_number','=',$slug)->where('user_id','=',$user->id)->where('ref_status','=',1)->count('id');$ex_count = VendorOrder::where('order_number','=',$slug)->where('user_id','=',$user->id)->where('ex_status','=',1)->count('id');	
		$main_count = $all_main_count - $ref_count - $ex_count;
		$main_counts = VendorOrder::where('order_number','=',$slug)->where('user_id','=',$user->id)->where('status','=','on delivery')->where('ref_status','=',0)->where('ex_status','=',0)->count('id');	
		if($main_count==$main_counts){			
		
		$mainorder = VendorOrder::where('order_number','=',$slug)->where('user_id','=',$user->id)->where('ref_status','=',0)->where('ex_status','=',0)->first();
		
		$data = Generalsetting::findOrFail(1);
        $order = Order::where('order_number','=',$slug)->first();
        $cart = unserialize(bzdecompress(utf8_decode($order->cart)));
        
		$email=env('ADMIN_EMAIL');		 
        $admin = Admin::where('email',$email)->first();
		
				 //$admin_fees = round($mainorder->price*15/100,2);
				 $admin_fees = $mainorder->admin_fee;
		$sgst = NULL;
		$cgst = NULL;
		$tcs=NULL;
		$igst=NULL;
		if($user->state == ($order->shipping_state == null ? $order->customer_state : $order->shipping_state)){
			$sgst = round($admin_fees*9/100,2);
			$cgst = round($admin_fees*9/100,2);
			$tcs=NULL;
			if($user->reg_number){
		       $tcs = round($admin_fees*1/100,2);
	        }
			
			
		}else{
			$igst = round($admin_fees*18/100,2);
			
		}
        
        foreach($cart->items as $key => $product){
            if($product['item']['user_id'] == $user->id){
                $user = User::find($product['item']['user_id']);
                if(isset($user)){
                   $productName[]= '<br>Product Name :'.$product['item']['name'].' Quantity : '.$product['qty']; 
                }
            }
        }
        
            $productList = implode(',',$productName);    
        
        
        
        if ($mainorder->status == "completed"){
            return redirect()->back()->with('success','This Order is Already Completed');
        } else if($status == "processing"){
               return redirect()->back()->with('success','This Order is not on delivery');    
            }elseif($status == "declined"){
               return redirect()->back()->with('success','This Order is not on delivery');   
            }elseif($status == "pending"){
               return redirect()->back()->with('success','This Order is not on delivery');  
            } elseif($status == "completed" && $mainorder->status != "on delivery"){
                return redirect()->back()->with('success','This Order is not on delivery'); 
            } elseif($status == "on delivery"){
                return redirect()->back()->with('success','This Order is not on delivery'); 
            }  else  if ($mainorder->status == "on delivery" && $status == "completed"){
            
            $notification = new Notification;
            $notification->order_id = $mainorder->order_id;
            $notification->vendor_id = $user->id;
            if($status == "processing"){
                $notification->message = "Order is processing by '".$user->name."' and  '".$productList."' ";    
            }elseif($status == "declined"){
                $notification->message = "Order is Declined by '".$user->name."' and '".$productList."' ";   
            }elseif($status == "pending"){
                $notification->message = "Order is Pending by '".$user->name."' and '".$productList."' ";   
            }elseif($status == "completed"){
                $notification->message = "Order is completed by '".$user->name."' and '".$productList."' ";   
            }else{
                $notification->message = "";  
            }
            
            $notification->save();
			$admin_status='';
			if($data->withdraw_approve==1){
				$admin_status='approved';
			} else{
				$admin_status=$status;
			}
			
			$gs = Generalsetting::findOrFail(1);
                /* if($gs->is_smtp == 1){
                    $maildata = [
                        'to' => $order->customer_email,
                        'subject' => 'Your order '.$order->order_number.' is Completed!',
                        'body' => "Hello ".$order->customer_name.","."\n Thank you for shopping with us. We are looking forward to your next visit.",
                    ];
    
                    $mailer = new GeniusMailer();
                    $mailer->sendCustomMail($maildata);                
                }else{
                   $to = $order->customer_email;				 
                    $subject = 'Your order '.$order->order_number.' is Completed!';
                   $msg = "Hello ".$order->customer_name.","."\n Thank you for shopping with us. We are looking forward to your next visit.";
                     $headers = "From: ".$gs->from_name."<".$gs->from_email.">";
                   mail($to,$subject,$msg,$headers);                
                 }*/
				 
				 if($gs->withdraw_approve) {
					 
				 } else {
		   $email=env('ADMIN_EMAIL');		 
           $admindata = Admin::where('email',$email)->first(); 
           $admin_em = Pagesetting::find(1)->contact_email;				 
           $admin_subject = 'Your order '.$order->order_number.' is Completed!';
           $admin_msg = "Hello Admin \n Order ".$order->order_number." is Completed!";
           $admin_headers = "From: ".$gs->from_name."<".$gs->from_email.">";
           mail($to,$admin_subject,$admin_msg,$admin_headers);
		   
           $to = $order->customer_email;				 
           $subject = 'Your order '.$order->order_number.' is Completed!';
           $msg = "Hello ".$order->customer_name.","."\n Thank you for shopping with us. We are looking forward to your next visit.";
           $headers = "From: ".$gs->from_name."<".$gs->from_email.">";
           mail($to,$subject,$msg,$headers); 
			}
				 
				 
            /*$subject = 'Your South India Jewels Withdraw Requested';
			$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$headers .= 'From: '.$gs->from_email."\r\n".
    'Reply-To: '.$gs->from_email."\r\n" .
    'X-Mailer: PHP/' . phpversion();

$vendor_em = 'payments@southindiajewels.co.in';
//$vendor_em = $user_info->email;
$vendor_subject = 'Withdraw Request  For Your South India Jewels order ';

     $vendor_msg = 'Withdraw Request Request Received';
     mail($vendor_em, $vendor_subject, $vendor_msg, $headers);*/
        
		

            $order = VendorOrder::where('order_number','=',$slug)->where('user_id','=',$user->id)->where('status','=','on delivery')->where('ref_status','=',0)->where('ex_status','=',0)->update(['status' => $status,'admin_approve' => $admin_status]);
			
			$all_od_count = VendorOrder::where('order_number','=',$slug)->count('id');
			$comp_od_count = VendorOrder::where('order_number','=',$slug)->where('status','=','completed')->count('id');
			if($all_od_count==$comp_od_count){
				$order = Order::where('order_number','=',$slug)->update(['status' => 'completed']);
			}
           return redirect()->back()->with('success','Order Status Updated Successfully');
		   //return redirect()->route('vendor-order-index')->with('success','Order Status Updated Successfully');
        }
		}else{			
			return redirect()->back()->with('success','Please Shipped other related item of this order');
			//return redirect()->route('vendor-order-index')->with('success','Please Shipped other related item of this order');
		}
    }
  
	
	 public function customaddnote(Request $request)
    {
		$user = Auth::user();
        $newmsg1 =$request->message;
		$newmsg2 =  'Vendor Name : '.$user->name;
		$newmsg = $newmsg1.'<br>'.$newmsg2;
        $orderid =$request->orderid;
        $userid =$request->vendorid;
        $notification = new Notification;
        $notification->order_id = $orderid;
        $notification->vendor_id = $userid;
        $notification->message = htmlentities($newmsg);
        $notification->save();
        $data = 1;
        return response()->json($data);
    }
	
	public function allorderExcelFile($status){	
	$user = Auth::user();
	 $ordercsv = Ordercsv::findOrFail(1);
	 $nooforder=$ordercsv->nooforder;
	 $v_datas = VendorOrder::where('user_id','=',$user->id)->where('status','!=','pending')->where('status','!=','declined')->orderBy('id','desc')->get();
	$fileName = 'all_order.csv';	
		
	$headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );
        
        $coupon_amount=0;
        $coupon_code='-';

        $columns = array('SL No', 'Order Date', 'Order Id', 'Vendor Name', 'Product Name', 'No Of Item', 'Order Value','Coupan Amount','Coupan Code','Customer Payment','Payment Gateway', 'Payment Method', 'Payment Type', 'Payment Gateway Charges', 'Tax', 'Net Bank Charges', 'Payment recd after deduction', 'Shipping Charge', 'Commission','SGST', 'CGST', 'IGST', 'Gross Payment', 'TCS', 'TCS', 'Payment to Vendor', 'Exchange', 'Refund', 'Status');
			$j=1;
			
		$callback = function() use($v_datas, $columns,$j,$nooforder,$coupon_amount,$coupon_code) {
         $file = fopen('php://output', 'w');
         fputcsv($file, $columns);		 
            foreach ($v_datas as $v_data) {
				$datas =	Order::where('id','=',$v_data->order_id)->get();
				if($j<=$nooforder){
            foreach ($datas as $data) {
				
                $row['SL No']  = $j;			
				$row['Order Date']    = date('d-M-Y',strtotime($data->created_at)); 
				$row['Order Id']    = $data->id; 			
				$users_name = User::all()->where('is_vendor','2')->where('id',$v_data->user_id)->pluck('shop_name')->implode(',');
                $row['Vendor Name']    = $users_name;
			if($v_data->product_id){
					$productnames = Product::all()->where('id',$v_data->product_id)->pluck('name');
                    $productname = str_replace( array( '["', '"]'), ' ', $productnames);
                      $productsku = Product::all()->where('id',$v_data->product_id)->pluck('sku');
                      $productskus = str_replace( array( '["', '"]'), ' ', $productsku);
				}else{
					$productname ='';
					$productskus = '';
				} 
				$coupon_data =	Coupon::where('order_id','=',$data->id)->where('status','=',2)->orderBy('id','desc')->first();
				if(@$coupon_data->price){
				    $coupon_amount=$coupon_data->price;
				}else{
				     $coupon_amount=0;
				}
				if(@$coupon_data->code){
				    $coupon_code=$coupon_data->code;
				}else{
				     $coupon_code='-';
				}
			    $row['Product Name']    = $productskus. '-' .$productname;
				$row['No Of Item']    = $v_data->qty;
				$product_price=$v_data->price-$coupon_amount;
				$row['Order Value']    = $product_price;
				$row['Coupan Amount']    = $coupon_amount;
				$row['Coupan Code']    = $coupon_code;
				$row['Customer Payment']    = $product_price; 
				$row['Payment Gateway']    = $data->method ;
				
				if($data->method =='Ccavenue'){
					if($data->od_card_type =='Net Banking'){
					    if($data->od_card_name =='HDFC Bank'){
					        $bankCharges = 	round($product_price*1.55/100, 2);
					    } elseif ($data->od_card_name =='ICICI Bank'){
					        $bankCharges = 	round($product_price*1.55/100, 2);
					    } else {
					        $bankCharges = round($product_price*1.30/100, 2);
					    }
					} elseif($data->od_card_type =='Wallet'){
					    $bankCharges = round($product_price*1.75/100, 2);
					}elseif($data->od_card_type =='Debit Card'){
					    $bankCharges = round($product_price*0.80/100, 2);
					}
					elseif($data->od_card_type =='Credit Card'){
					    $bankCharges = round($product_price*1.75/100, 2);
					}
					elseif($data->od_card_type =='Diners'){
					    $bankCharges = round($product_price*1.75/100, 2);
					} else{
					    $bankCharges = '0';   
					}
				} else{
				    $bankCharges = '0';  
				}
				
				
				
				$row['Payment Method']    = $data->od_card_type ;
				$row['Payment Type']    = $data->od_card_name ;
				if($data->method=='Ccavenue'){
					round($payment_charge=$product_price*2/100, 2);
				}elseif($data->method=='paypal'){
					round($payment_charge=$product_price*3.08/100, 2);
				}elseif($data->method=='Razorpay'){
					round($payment_charges1=$product_price*2/100, 2);
					round($payment_charges2=$payment_charges1*18/100, 2);
					round($payment_charge=$payment_charges1+$payment_charges2, 2);
				}else{
					$payment_charge=0;
				}
				$row['Payment Gateway Charges']    = $bankCharges;
				$tax= round($bankCharges*(18/100), 2) ;
				$row['Tax']    = $tax; 
				$netbank_charge=$bankCharges+$tax;
				$row['Net Bank Charges']    = $netbank_charge;				
				$row['Payment recd after deduction']    = $product_price-$netbank_charge;
				$row['Shipping Charge']    = 0;
				$commission= round($product_price*15/100, 2);
				$row['Commission']    = $commission;
				$users_state = User::all()->where('is_vendor','2')->where('id',$v_data->user_id)->pluck('state')->implode(',');
				
				$usersgst = User::all()->where('is_vendor','2')->where('id',$v_data->user_id)->pluck('reg_number')->implode(',');
				
				if($users_state == 'Tamil Nadu'){
				    $sgst = round($commission*9/100, 2);
				    $cgst = round($commission*9/100, 2);
				    $igst = '';
				    
				   $grosspayment = $product_price - $commission - $sgst - $cgst;
				   
				   if($usersgst == NULL){
				       $tcs = '';
				       $netpayvendor = $grosspayment;
				   }else{
				      $tcs = round($grosspayment*0.5/100, 2);
				      $netpayvendor = $grosspayment - $tcs - $tcs;
				   }
				    
				} else{
				    $sgst = '';
				    $cgst = '';
				    $igst = round($commission*18/100, 2);
				    $tcs = '';
				    $grosspayment = $product_price - $commission - $igst;
				    $netpayvendor = $grosspayment;
				}
				
				
				
				$row['SCST-9%']    = $sgst;
				$row['CGST-9%']    = $cgst;
				$row['IGST-18%']    = $igst;
				
				$row['Gross Payment']    = $grosspayment;
				
				$row['TCS']    = $tcs;
				
				$row['TCS1']    = $tcs;
				
				if($v_data->ex_status){
				$row['Exchange']    = 'Exchange';	
				}else{
				$row['Exchange']    = '';	
				}
				if($v_data->refund_status){
				$row['Refund']    = 'Refund';	
				}else{
				$row['Refund']    = '';	
				}
								
				$row['Status']    = $v_data->status; 
				
				$row['Payment Of Vendor']    = $netpayvendor;			
                 fputcsv($file, array($row['SL No'] , $row['Order Date'],$row['Order Id'],$row['Vendor Name'],$row['Product Name'],$row['No Of Item'],$row['Order Value'],$row['Coupan Amount'],$row['Coupan Code'],$row['Customer Payment'],$row['Payment Gateway'],$row['Payment Method'],$row['Payment Type'],$row['Payment Gateway Charges'],$row['Tax'],$row['Net Bank Charges'],$row['Payment recd after deduction'],$row['Shipping Charge'],$row['Commission'],$row['SCST-9%'],$row['CGST-9%'],$row['IGST-18%'],$row['Gross Payment'],$row['TCS'],$row['TCS1'],$row['Payment Of Vendor'],$row['Exchange'],$row['Refund'], $row['Status']));
				$j++;
				
            }
			}
			}
            fclose($file);
        };
		

        return response()->stream($callback, 200, $headers);
	}
	
	public function downloadExcelFile($status){
     $user = Auth::user();		
	 $ordercsv = Ordercsv::findOrFail(1);
	 $nooforder=$ordercsv->nooforder;
	 $v_datas = VendorOrder::where('user_id','=',$user->id)->where('status','completed')->orderBy('id','desc')->get();
	$fileName = 'complete_order.csv';	
		
	$headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        $columns = array('SL No', 'Order Date', 'Order Id', 'Vendor Name', 'Product Name', 'No Of Item', 'Order Value','Payment Method', 'Payment Gateway Charges', 'Tax', 'Net Bank Charges', 'Payment', 'Shipping Charge', 'Commission', 'Profit', 'Payment Of Vendor','Exchange','Refund','Status');
			$j=1;
			
		$callback = function() use($v_datas, $columns,$j,$nooforder) {
         $file = fopen('php://output', 'w');
         fputcsv($file, $columns);		 
            foreach ($v_datas as $v_data) {
				$datas =	Order::where('id','=',$v_data->order_id)->get();
				if($j<=$nooforder){
            foreach ($datas as $data) {
				
                $row['SL No']  = $j;			
				$row['Order Date']    = date('d-M-Y H:i:s a',strtotime($data->created_at)); 
				$row['Order Id']    = $data->id; 			
				$users_name = User::all()->where('is_vendor','2')->where('id',$v_data->user_id)->pluck('shop_name')->implode(',');
                $row['Vendor Name']    = $users_name;
			if($v_data->product_id){
					$productnames = Product::all()->where('id',$v_data->product_id)->pluck('name');
                    $productname = str_replace( array( '["', '"]'), ' ', $productnames);	
				}else{
					$productname ='';
				}                			
			    $row['Product Name']    = $productname;
				$row['No Of Item']    = $v_data->qty;
				$product_price=$data->pay_amount * $data->currency_value;
				$row['Order Value']    = $product_price; 
				$row['Payment Method']    = $data->method ;				
				if($data->method=='Ccavenue'){
					$payment_charge=$product_price*2/100;
				}elseif($data->method=='paypal'){
					$payment_charge=$product_price*3.08/100;
				}elseif($data->method=='Razorpay'){
					$payment_charges1=$product_price*2/100;
					$payment_charges2=$payment_charges1*18/100;
					$payment_charge=$payment_charges1+$payment_charges2;
				}else{
					$payment_charge=0;
				}
				$row['Payment Gateway Charges']    = $payment_charge;
				$tax=0;
				$row['Tax']    = $tax; 
				$netbank_charge=$payment_charge+$tax;
				$row['Net Bank Charges']    = $netbank_charge;				
				$row['Payment']    = $product_price-$netbank_charge;
				$row['Shipping Charge']    = 0;
				$commission=$data->admin_fee;
				$row['Commission']    = $commission;
				$row['Profit']    = $commission-$netbank_charge;
				$row['Payment Of Vendor']    = $product_price-$commission;
                
                if($v_data->ex_status){
				$row['Exchange']    = 'Exchange';	
				}else{
				$row['Exchange']    = '';	
				}
				if($v_data->refund_status){
				$row['Refund']    = 'Refund';	
				}else{
				$row['Refund']    = '';	
				}
				//$row['Status']    = $data->payment_status;
				$row['Status']    = $v_data->status;				
                 fputcsv($file, array($row['SL No'] , $row['Order Date'],$row['Order Id'],$row['Vendor Name'],$row['Product Name'],$row['No Of Item'],$row['Order Value'],$row['Payment Method'],$row['Payment Gateway Charges'],$row['Tax'],$row['Net Bank Charges'],$row['Payment'],$row['Shipping Charge'],$row['Commission'],$row['Profit'],$row['Payment Of Vendor'],$row['Exchange'],$row['Refund'],$row['Status']));
				$j++;
				
            }
			}
			}
            fclose($file);
        };
		

        return response()->stream($callback, 200, $headers);
	}
	
	public function downloadShipFile($status){	
	$user = Auth::user();
	 $ordercsv = Ordercsv::findOrFail(1);
	 $nooforder=$ordercsv->nooforder;
	 $v_datas = VendorOrder::where('user_id','=',$user->id)->where('status','on delivery')->orderBy('id','desc')->get();
	$fileName = 'ship_order.csv';	
		
	$headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        $columns = array('SL No', 'Order Date', 'Order Id', 'Vendor Name', 'Product Name', 'No Of Item', 'Order Value','Payment Method', 'Payment Gateway Charges', 'Tax', 'Net Bank Charges', 'Payment', 'Shipping Charge', 'Commission', 'Profit', 'Payment Of Vendor','Tracking Url','Tracking Code','Tracking Company Name','Exchange','Refund','Status');
			$j=1;
			
		$callback = function() use($v_datas, $columns,$j,$nooforder) {
         $file = fopen('php://output', 'w');
         fputcsv($file, $columns);		 
            foreach ($v_datas as $v_data) {
				$datas =	Order::where('id','=',$v_data->order_id)->get();				
				if($j<=$nooforder){
            foreach ($datas as $data) {
				
                $row['SL No']  = $j;			
				$row['Order Date']    = date('d-M-Y H:i:s a',strtotime($data->created_at)); 
				$row['Order Id']    = $data->id; 			
				$users_name = User::all()->where('is_vendor','2')->where('id',$v_data->user_id)->pluck('shop_name')->implode(',');
                $row['Vendor Name']    = $users_name;
				if($v_data->product_id){
					$productnames = Product::all()->where('id',$v_data->product_id)->pluck('name');
                    $productname = str_replace( array( '["', '"]'), ' ', $productnames);
                    $productsku = Product::all()->where('id',$v_data->product_id)->pluck('sku');
				}else{
					$productname ='';
					$productsku ='';
				}                			
			    $row['Product Name']    = $productsku . '-'. $productname;
				$row['No Of Item']    = $v_data->qty;
				$product_price=$data->pay_amount * $data->currency_value;
				$row['Order Value']    = $product_price;				
				$row['Payment Method']    = $data->method ;
				
				if($data->method=='Ccavenue'){
					$payment_charge=$product_price*2/100;
				}elseif($data->method=='paypal'){
					$payment_charge=$product_price*3.08/100;
				}elseif($data->method=='Razorpay'){
					$payment_charges1=$product_price*2/100;
					$payment_charges2=$payment_charges1*18/100;
					$payment_charge=$payment_charges1+$payment_charges2;
				}else{
					$payment_charge=0;
				}
				$row['Payment Gateway Charges']    = $payment_charge;
				$tax=0;
				$row['Tax']    = $tax; 
				$netbank_charge=$payment_charge+$tax;
				$row['Net Bank Charges']    = $netbank_charge;				
				$row['Payment']    = $product_price-$netbank_charge;
				$row['Shipping Charge']    = 0;
				$commission=$data->admin_fee;
				$row['Commission']    = $commission;
				$row['Profit']    = $commission-$netbank_charge;
				$row['Payment Of Vendor']    = $product_price-$commission;
				
				$OrderTracks =	OrderTrack::where('order_id','=',$data->id)->orderBy('id','desc')->get();
				foreach ($OrderTracks as $OrderT) {
                $row['Tracking Url']    = $OrderT->text;
                $row['Tracking Code']    = $OrderT->title;
                $row['Tracking Company Name']    = $OrderT->companyname;
				}
				if($v_data->ex_status){
				$row['Exchange']    = 'Exchange';	
				}else{
				$row['Exchange']    = '';	
				}
				if($v_data->refund_status){
				$row['Refund']    = 'Refund';	
				}else{
				$row['Refund']    = '';	
				}
				//$row['Status']    = $data->payment_status;
				$row['Status']    = $v_data->status;				
                 fputcsv($file, array($row['SL No'] , $row['Order Date'],$row['Order Id'],$row['Vendor Name'],$row['Product Name'],$row['No Of Item'],$row['Order Value'],$row['Payment Method'],$row['Payment Gateway Charges'],$row['Tax'],$row['Net Bank Charges'],$row['Payment'],$row['Shipping Charge'],$row['Commission'],$row['Profit'],$row['Payment Of Vendor'],$row['Tracking Url'],$row['Tracking Code'],$row['Tracking Company Name'],$row['Exchange'],$row['Refund'],$row['Status']));
				$j++;
				
            }
			}
			}
            fclose($file);
        };
		

        return response()->stream($callback, 200, $headers);
	}
	
	public function downloadprocessExcel($status){	
	$user = Auth::user();
	 $ordercsv = Ordercsv::findOrFail(1);
	 $nooforder=$ordercsv->nooforder;
	 $v_datas = VendorOrder::where('user_id','=',$user->id)->where('status','processing')->orderBy('id','desc')->get();
	 $fileName = 'process_order.csv';	
		
	$headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        $columns = array('SL No', 'Order Date', 'Order Id', 'Vendor Name', 'Product Name', 'No Of Item', 'Order Value','Payment Method', 'Payment Gateway Charges', 'Tax', 'Net Bank Charges', 'Payment', 'Shipping Charge', 'Commission', 'Profit', 'Payment Of Vendor','Status');
			$j=1;
			
		$callback = function() use($v_datas, $columns,$j,$nooforder) {
         $file = fopen('php://output', 'w');
         fputcsv($file, $columns);		 
            foreach ($v_datas as $v_data) {
				$datas =	Order::where('id','=',$v_data->order_id)->get();
				if($j<=$nooforder){
            foreach ($datas as $data) {
				
                $row['SL No']  = $j;			
				$row['Order Date']    = date('d-M-Y H:i:s a',strtotime($data->created_at)); 
				$row['Order Id']    = $data->id; 			
				$users_name = User::all()->where('is_vendor','2')->where('id',$v_data->user_id)->pluck('shop_name')->implode(',');
                $row['Vendor Name']    = $users_name;
				if($v_data->product_id){
					$productnames = Product::all()->where('id',$v_data->product_id)->pluck('name');
                    $productname = str_replace( array( '["', '"]'), ' ', $productnames);	
				}else{
					$productname ='';
				}                			
			    $row['Product Name']    = $productname;
				$row['No Of Item']    = $v_data->qty;
				$product_price=$data->pay_amount * $data->currency_value;
				$row['Order Value']    = $product_price; 
				$row['Payment Method']    = $data->method ;
				
				if($data->method=='Ccavenue'){
					$payment_charge=$product_price*2/100;
				}elseif($data->method=='paypal'){
					$payment_charge=$product_price*3.08/100;
				}elseif($data->method=='Razorpay'){
					$payment_charges1=$product_price*2/100;
					$payment_charges2=$payment_charges1*18/100;
					$payment_charge=$payment_charges1+$payment_charges2;
				}else{
					$payment_charge=0;
				}
				$row['Payment Gateway Charges']    = $payment_charge;
				$tax=0;
				$row['Tax']    = $tax; 
				$netbank_charge=$payment_charge+$tax;
				$row['Net Bank Charges']    = $netbank_charge;				
				$row['Payment']    = $product_price-$netbank_charge;
				$row['Shipping Charge']    = 0;
				$commission=$data->admin_fee;
				$row['Commission']    = $commission;
				$row['Profit']    = $commission-$netbank_charge;
				$row['Payment Of Vendor']    = $product_price-$commission;
                if($v_data->ex_status){
				$row['Exchange']    = 'Exchange';	
				}else{
				$row['Exchange']    = '';	
				}
				if($v_data->refund_status){
				$row['Refund']    = 'Refund';	
				}else{
				$row['Refund']    = '';	
				}
				//$row['Status']    = $data->payment_status;
				$row['Status']    = $v_data->status;				
                 fputcsv($file, array($row['SL No'] , $row['Order Date'],$row['Order Id'],$row['Vendor Name'],$row['Product Name'],$row['No Of Item'],$row['Order Value'],$row['Payment Method'],$row['Payment Gateway Charges'],$row['Tax'],$row['Net Bank Charges'],$row['Payment'],$row['Shipping Charge'],$row['Commission'],$row['Profit'],$row['Payment Of Vendor'],$row['Exchange'],$row['Refund'],$row['Status']));
				$j++;
				
            }
			}
			}
            fclose($file);
        };
		

        return response()->stream($callback, 200, $headers);
	}


}
