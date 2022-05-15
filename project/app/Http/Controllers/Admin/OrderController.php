<?php

namespace App\Http\Controllers\Admin;

use App\Classes\GeniusMailer;
use App\Http\Controllers\Controller;
use App\Models\Generalsetting;
use App\Models\Order;
use App\Models\Admin;
use App\Models\OrderTrack;
use App\Models\User;
use App\Models\VendorOrder;
use App\Models\Notification;
use App\Models\Ordercsv;
use App\Models\Product;
use App\Models\Coupon;
use App\Models\Pagesetting;
use DB;
use Datatables;
use PDF;
use Auth;
use Config;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;


class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
		$data = Generalsetting::findOrFail(1);
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

    //*** JSON Request
    public function datatables($status){
        $svendor = (!empty($_GET["svendor"])) ? ($_GET["svendor"]) : ('');
        $startdateis = (!empty($_GET["startdateis"])) ? ($_GET["startdateis"]) : (''); 
        $enddateis = (!empty($_GET["enddateis"])) ? ($_GET["enddateis"]) : ('');
        $query = Order::select('*');
            if(!empty($svendor))
                $query->whereRaw("find_in_set($svendor , vendor_id_list)");
            if(!empty($startdateis))
                $query->whereDate('created_at','>=',$startdateis);
            if(!empty($enddateis))
                $query->whereDate('created_at','<=',$enddateis);                
        $datas=$query->orderBy('id','desc')->get();
         
         //--- Integrating This Collection Into Datatables
         return Datatables::of($datas)
                            ->editColumn('id', function(Order $data) {
                                $id = '<a href="'.route('admin-order-show',$data->id).'">'.$data->order_number.'</a>';
                                return $id;
                            })
                            ->editColumn('number', function(Order $data) {
								$checkbox= "<input type='checkbox' class='order-sts'  name='ordercheckedid[]' value='$data->id'  > <script>jQuery('.order-sts').click(function () {jQuery(this).siblings('input').prop('checked', this.checked);});</script>";
                                $number = $data->id;
                                return $checkbox.$number;
                            })
                            ->editColumn('pay_amount', function(Order $data) {
                                return $data->currency_sign . round($data->pay_amount * $data->currency_value , 2);
                            })                            
                            ->editColumn('vendor_name', function(Order $data) {
                                $idarray = explode(',', $data->vendor_id_list);
                                $idcount = count(array_unique($idarray));
                                for($i=0;$i<=$idcount-1;$i++){
                                    $id = $idarray[$i];
                                    $users[] = User::all()->where('is_vendor','2')->where('id',$id)->pluck('shop_name')->implode('');    
                                }

                                foreach ($users as $key => $value) {
                                         $listname[] = $value;
                                } 
                                
                                $childcategorylist = implode(',', $listname);
                                
                                return  $childcategorylist;
                            })
                            
                             ->editColumn('status', function(Order $data) {
                                $orderstatus =  $data->status;
                                $refundstatus =  $data->refund;
                                if($orderstatus == 'failure'){
                                    return '<span class="badge badge-warning">'.$orderstatus.'</span>';
                                }elseif($orderstatus == 'pending'){
                                    return '<span class="badge badge-warning">'.$orderstatus.'</span>';
                                }
                                elseif($orderstatus == 'processing'){
                                    return '<span class="badge badge-info">'.$orderstatus.'</span>';
                                }
                                
                                elseif($orderstatus == 'on delivery'){
                                    return '<span class="badge badge-primary">'.'Shipped'.'</span>';
                                }
                                elseif($orderstatus == 'declined'){
                                    return '<span class="badge badge-danger">'.'Failed'.'</span>';
                                }
                                elseif($orderstatus == 'completed'and $refundstatus != '1'){
                                    return '<span class="badge badge-success">'.$orderstatus.'</span>';
                                }
                                elseif($orderstatus == 'completed' and $refundstatus == '1'){
                                    return '<span class="badge badge-danger">Refunded</span>';
                                }
                                
                                else {
                                    return '-';
                                }
                                
                            }) 
							
                            ->editColumn('payment_status', function(Order $data) {
                                $paystatus =  $data->payment_status;
                                if($paystatus == 'Completed'){
                                    return '<span class="badge badge-success"> Paid </span>';
                                }
                                else {
                                    return '<span class="badge badge-danger"> Unpaid </span>';
                                }
                                
                            })
                            ->editColumn('refund_status', function(Order $data) {
                                $id =  $data->id;
								$pay_amount =  VendorOrder::where('order_id','=',$id)->sum('price');
								$refund_amount =  VendorOrder::where('order_id','=',$id)->sum('product_item_price');
								if($refund_amount){
                                if($pay_amount == $refund_amount){
                                    return '<span class="badge badge-success"> Refund </span>';
                                }
                                else {
                                    return '<span class="badge badge-danger"> Partial Refund </span>';
                                }
								}else{
									return '-';
								}
                                
                            })
                           ->editColumn('exchange_status', function(Order $data) {
                                $id =  $data->id;
								$other_data =  VendorOrder::where('order_id','=',$id)->where('other_status','=','exchange')->orderBy('id','desc')->first();
                               $other_datas =  VendorOrder::where('order_id','=',$id)->where('other_status','=','exchanges')->orderBy('id','desc')->first();								
								if($other_data || $other_datas ){
                               if($other_data['other_status']){
                                    return '<span class="badge badge-success"> Exchange </span>';
                                } 
                                if($other_datas['other_status']){
                                    return '<span class="badge badge-success"> Notdelivered Exchange </span>';
                                }								
								}else{
									return '-';
								}
                                
                            })  							
							
                            ->addColumn('action', function(Order $data) {
								$orderstatus =  $data->status;
								 $paystatus =  $data->payment_status;
                                if($paystatus == 'Completed'){
                                    $unpaid_status = '';
                                }
                                else {
                                    $unpaid_status = '<a href="javascript:;" data-href="'. route('admin-order-unpaidstatus',$data->id) .'" class="delivery" data-toggle="modal" data-target="#modal1">
                                <i class="fas fa-dollar-sign"></i> Update Unpaid Status</a>';
                                }
                                $orders = '<a href="javascript:;" data-href="'. route('admin-order-edit',$data->id) .'" class="delivery" data-toggle="modal" data-target="#modal1">
                                <i class="fas fa-dollar-sign"></i> Delivery Status</a>';

                                $orderitems = '<a href="javascript:;" data-href="'. route('admin-order-show-items',$data->id) .'" class="delivery" data-toggle="modal" data-target="#modal1">

                                <i class="fas fa-dollar-sign"></i> Items</a>'; 
                                 if($orderstatus == 'completed'){
                                    $refund = '<a href="javascript:;" data-href="'. route('admin-order-refund',$data->id) .'" class="order-refund" data-toggle="modal" data-target="#refundpopup">

                                <i class="fas fa-dollar-sign"></i> Refund</a>';
                                } else{
                                    $refund = '';
                                }                                  
                                
                                return '<div class="godropdown"><button class="go-dropdown-toggle"> Actions<i class="fas fa-chevron-down"></i></button>
                                <div class="action-list">
                                <a href="' . route('admin-order-show',$data->id) . '" > <i class="fas fa-eye"></i> Details</a>
                                <a href="javascript:;" class="send" data-email="'. $data->customer_email .'" data-toggle="modal" data-target="#vendorform">
                                <i class="fas fa-envelope"></i> Send</a>
                                <a href="javascript:;" data-href="'. route('admin-order-track',$data->id) .'" class="track" data-toggle="modal" data-target="#modal1">
                                <i class="fas fa-truck"></i> Track Order</a>'.$orders.$refund.$unpaid_status.'								
                                <a href="' . route('admin-generate-invoice',$data->id) . '"><i class="fas fa-envelope"></i>Generate Invoice</a>
                                <a href="' . route('admin-packaging-slip',$data->id) . '"><i class="fas fa-envelope"></i>Generate Package Slip</a></div></div>';
                            }) 
                            
                            ->rawColumns(['id','number','action','status','Prductlist','vendor_name','payment_status','refund_status','exchange_status'])
                            ->toJson(); //--- Returning Json Data To Client Side
    }
	
	 //*** JSON Request
    public function pendingdatatables($status){		
         $svendor = (!empty($_GET["svendor"])) ? ($_GET["svendor"]) : ('');
        $startdateis = (!empty($_GET["startdateis"])) ? ($_GET["startdateis"]) : (''); 
        $enddateis = (!empty($_GET["enddateis"])) ? ($_GET["enddateis"]) : ('');


        $query = Order::select('*');
            if(!empty($svendor))
                $query->whereRaw("find_in_set($svendor , vendor_id_list)");
            if(!empty($startdateis))
                $query->whereDate('created_at','>=',$startdateis);
            if(!empty($enddateis))
                $query->whereDate('created_at','<=',$enddateis);
            if(!empty($status))
				$query->where('status','=',$status);               			
        $datas=$query->orderBy('id','desc')->get();
         
         //--- Integrating This Collection Into Datatables
         return Datatables::of($datas)
                            ->editColumn('id', function(Order $data) {
                                $id = '<a href="'.route('admin-order-show',$data->id).'">'.$data->order_number.'</a>';
                                return $id;
                            })
                            ->editColumn('number', function(Order $data) {
								$checkbox= "<input type='checkbox' class='order-sts'  name='ordercheckedid[]' value='$data->id'  > <script>jQuery('.order-sts').click(function () {jQuery(this).siblings('input').prop('checked', this.checked);});</script>";
                                $number = '<a href="'.route('admin-order-show',$data->id).'">'.$data->order_number.'</a>';
                                return $number;
                            })
                            ->editColumn('pay_amount', function(Order $data) {
                                return $data->currency_sign . round($data->pay_amount * $data->currency_value , 2);
                            })                           
                            ->editColumn('vendor_name', function(Order $data) {
                                $idarray = explode(',', $data->vendor_id_list);
                                $idcount = count(array_unique($idarray));
                                for($i=0;$i<=$idcount-1;$i++){
                                    $id = $idarray[$i];
                                    $users[] = User::all()->where('is_vendor','2')->where('id',$id)->pluck('shop_name')->implode('');    
                                }

                                foreach ($users as $key => $value) {
                                         $listname[] = $value;
                                } 
                                
                                $childcategorylist = implode(',', $listname);
                                
                                return  $childcategorylist;
                            })
                            
                            ->editColumn('payment_status', function(Order $data) {
                                $paystatus =  $data->payment_status;
                                if($paystatus == 'Completed'){
                                    return '<span class="badge badge-success"> Paid </span>';
                                }
                                else {
                                    return '<span class="badge badge-danger"> Unpaid </span>';
                                }
                                
                            })
                            
                            ->addColumn('action', function(Order $data) {
								$orderstatus =  $data->status;
                                $orders = '<a href="javascript:;" data-href="'. route('admin-order-edit',$data->id) .'" class="delivery" data-toggle="modal" data-target="#modal1">
                                <i class="fas fa-dollar-sign"></i> Delivery Status</a>';

                                $orderitems = '<a href="javascript:;" data-href="'. route('admin-order-show-items',$data->id) .'" class="delivery" data-toggle="modal" data-target="#modal1">

                                <i class="fas fa-dollar-sign"></i> Items</a>'; 
                                 if($orderstatus == 'completed'){
                                    $refund = '<a href="javascript:;" data-href="'. route('admin-order-refund',$data->id) .'" class="order-refund" data-toggle="modal" data-target="#refundpopup">

                                <i class="fas fa-dollar-sign"></i> Refund</a>';
                                } else{
                                    $refund = '';
                                }
                                  
                                
                                return '<div class="godropdown"><button class="go-dropdown-toggle"> Actions<i class="fas fa-chevron-down"></i></button>
                                <div class="action-list">
                                <a href="' . route('admin-order-show',$data->id) . '" > <i class="fas fa-eye"></i> Details</a>
                                <a href="javascript:;" class="send" data-email="'. $data->customer_email .'" data-toggle="modal" data-target="#vendorform">
                                <i class="fas fa-envelope"></i> Send</a>
                                <a href="javascript:;" data-href="'. route('admin-order-track',$data->id) .'" class="track" data-toggle="modal" data-target="#modal1">
                                <i class="fas fa-truck"></i> Track Order</a>'.$orders.$refund.'
                                <a href="' . route('admin-generate-invoice',$data->id) . '"><i class="fas fa-envelope"></i>Generate Invoice</a>
                                <a href="' . route('admin-packaging-slip',$data->id) . '"><i class="fas fa-envelope"></i>Generate Package Slip</a></div></div>';
                            }) 
                            
                            ->rawColumns(['id','number','action','status','Prductlist','vendor_name','payment_status'])
                            ->toJson(); 
    }
	
	 //*** JSON Request
    public function processingdatatables($status){
		$svendor = (!empty($_GET["svendor"])) ? ($_GET["svendor"]) : ('');
        $startdateis = (!empty($_GET["startdateis"])) ? ($_GET["startdateis"]) : (''); 
        $enddateis = (!empty($_GET["enddateis"])) ? ($_GET["enddateis"]) : ('');

        $query = Order::select('*');
            if(!empty($svendor))
                $query->whereRaw("find_in_set($svendor , vendor_id_list)");
            if(!empty($startdateis))
                $query->whereDate('created_at','>=',$startdateis);
            if(!empty($enddateis))
                $query->whereDate('created_at','<=',$enddateis);
            if(!empty($status))
				$query->where('status','=',$status);  			
        $datas=$query->orderBy('id','desc')->get();
         
         //--- Integrating This Collection Into Datatables
         return Datatables::of($datas)
                            ->editColumn('id', function(Order $data) {
                                $id = '<a href="'.route('admin-order-show',$data->order_id).'">'.$data->order_number.'</a>';
                                return $id;
                            })
                            ->editColumn('number', function(Order $data) {
								$checkbox= "<input type='checkbox' class='order-sts'  name='ordercheckedid[]' value='$data->id'  > <script>jQuery('.order-sts').click(function () {jQuery(this).siblings('input').prop('checked', this.checked);});</script>";
                                $number = '<a href="'.route('admin-order-show',$data->id).'">'.$data->order_number.'</a>';
                                return $number;
                            })
                            ->editColumn('pay_amount', function(Order $data) {
                                return $data->currency_sign . round($data->pay_amount * $data->currency_value , 2);
                            })                           
                            ->editColumn('vendor_name', function(Order $data) {
                                $idarray = explode(',', $data->vendor_id_list);
                                $idcount = count(array_unique($idarray));
                                for($i=0;$i<=$idcount-1;$i++){
                                    $id = $idarray[$i];
                                    $users[] = User::all()->where('is_vendor','2')->where('id',$id)->pluck('shop_name')->implode('');    
                                }

                                foreach ($users as $key => $value) {
                                         $listname[] = $value;
                                } 
                                
                                $childcategorylist = implode(',', $listname);
                                
                                return  $childcategorylist;
                            })
                            
                            ->editColumn('payment_status', function(Order $data) {
                                $paystatus =  $data->payment_status;
                                if($paystatus == 'Completed'){
                                    return '<span class="badge badge-success"> Paid </span>';
                                }
                                else {
                                    return '<span class="badge badge-danger"> Unpaid </span>';
                                }
                                
                            })
                            
                            ->addColumn('action', function(Order $data) {
								$orderstatus =  $data->status;
                                $orders = '<a href="javascript:;" data-href="'. route('admin-order-edit',$data->id) .'" class="delivery" data-toggle="modal" data-target="#modal1">
                                <i class="fas fa-dollar-sign"></i> Delivery Status</a>';

                                $orderitems = '<a href="javascript:;" data-href="'. route('admin-order-show-items',$data->id) .'" class="delivery" data-toggle="modal" data-target="#modal1">

                                <i class="fas fa-dollar-sign"></i> Items</a>'; 
                                 if($orderstatus == 'completed'){
                                    $refund = '<a href="javascript:;" data-href="'. route('admin-order-refund',$data->id) .'" class="order-refund" data-toggle="modal" data-target="#refundpopup">

                                <i class="fas fa-dollar-sign"></i> Refund</a>';
                                } else{
                                    $refund = '';
                                }
                                  
                                
                                return '<div class="godropdown"><button class="go-dropdown-toggle"> Actions<i class="fas fa-chevron-down"></i></button>
                                <div class="action-list">
                                <a href="' . route('admin-order-show',$data->id) . '" > <i class="fas fa-eye"></i> Details</a>
                                <a href="javascript:;" class="send" data-email="'. $data->customer_email .'" data-toggle="modal" data-target="#vendorform">
                                <i class="fas fa-envelope"></i> Send</a>
                                <a href="javascript:;" data-href="'. route('admin-order-track',$data->id) .'" class="track" data-toggle="modal" data-target="#modal1">
                                <i class="fas fa-truck"></i> Track Order</a>'.$orders.$refund.'
                                <a href="' . route('admin-generate-invoice',$data->id) . '"><i class="fas fa-envelope"></i>Generate Invoice</a>
                                <a href="' . route('admin-packaging-slip',$data->id) . '"><i class="fas fa-envelope"></i>Generate Package Slip</a></div></div>';
                            }) 
                            
                            ->rawColumns(['id','number','action','status','Prductlist','vendor_name','payment_status'])
                            ->toJson(); 
    }
	
	//*** JSON Request
    public function shippingdatatables($status){
		
        $svendor = (!empty($_GET["svendor"])) ? ($_GET["svendor"]) : ('');
        $startdateis = (!empty($_GET["startdateis"])) ? ($_GET["startdateis"]) : (''); 
        $enddateis = (!empty($_GET["enddateis"])) ? ($_GET["enddateis"]) : ('');


        $query = Order::select('*');
            if(!empty($svendor))
                $query->whereRaw("find_in_set($svendor , vendor_id_list)");
            if(!empty($startdateis))
                $query->whereDate('created_at','>=',$startdateis);
            if(!empty($enddateis))
                $query->whereDate('created_at','<=',$enddateis);
            if(!empty($status))
				$query->where('status','=',$status); 			
        $datas=$query->orderBy('id','desc')->get();
         
         //--- Integrating This Collection Into Datatables
         return Datatables::of($datas)
                            ->editColumn('id', function(Order $data) {
                                $id = '<a href="'.route('admin-order-show',$data->order_id).'">'.$data->order_number.'</a>';
                                return $id;
                            })
                            ->editColumn('number', function(Order $data) {
								$checkbox= "<input type='checkbox' class='order-sts'  name='ordercheckedid[]' value='$data->id'  > <script>jQuery('.order-sts').click(function () {jQuery(this).siblings('input').prop('checked', this.checked);});</script>";
                                $number = '<a href="'.route('admin-order-show',$data->id).'">'.$data->order_number.'</a>';
                                return $number;
                            })
                            ->editColumn('pay_amount', function(Order $data) {
                                return $data->currency_sign . round($data->pay_amount * $data->currency_value , 2);
                            })                           
                            ->editColumn('vendor_name', function(Order $data) {
                                $idarray = explode(',', $data->vendor_id_list);
                                $idcount = count(array_unique($idarray));
                                for($i=0;$i<=$idcount-1;$i++){
                                    $id = $idarray[$i];
                                    $users[] = User::all()->where('is_vendor','2')->where('id',$id)->pluck('shop_name')->implode('');    
                                }

                                foreach ($users as $key => $value) {
                                         $listname[] = $value;
                                } 
                                
                                $childcategorylist = implode(',', $listname);
                                
                                return  $childcategorylist;
                            })                            
                             
                            ->editColumn('payment_status', function(Order $data) {
                                $paystatus =  $data->payment_status;
                                if($paystatus == 'Completed'){
                                    return '<span class="badge badge-success"> Paid </span>';
                                }
                                else {
                                    return '<span class="badge badge-danger"> Unpaid </span>';
                                }
                                
                            })
                            
                            ->addColumn('action', function(Order $data) {
								$orderstatus =  $data->status;
                                $orders = '<a href="javascript:;" data-href="'. route('admin-order-edit',$data->order_id) .'" class="delivery" data-toggle="modal" data-target="#modal1">
                                <i class="fas fa-dollar-sign"></i> Delivery Status</a>';

                                $orderitems = '<a href="javascript:;" data-href="'. route('admin-order-show-items',$data->id) .'" class="delivery" data-toggle="modal" data-target="#modal1">

                                <i class="fas fa-dollar-sign"></i> Items</a>'; 
                                 if($orderstatus == 'completed'){
                                    $refund = '<a href="javascript:;" data-href="'. route('admin-order-refund',$data->id) .'" class="order-refund" data-toggle="modal" data-target="#refundpopup">

                                <i class="fas fa-dollar-sign"></i> Refund</a>';
                                } else{
                                    $refund = '';
                                }
                                  
                                
                                return '<div class="godropdown"><button class="go-dropdown-toggle"> Actions<i class="fas fa-chevron-down"></i></button>
                                <div class="action-list">
                                <a href="' . route('admin-order-show',$data->id) . '" > <i class="fas fa-eye"></i> Details</a>
                                <a href="javascript:;" class="send" data-email="'. $data->customer_email .'" data-toggle="modal" data-target="#vendorform">
                                <i class="fas fa-envelope"></i> Send</a>
                                <a href="javascript:;" data-href="'. route('admin-order-track',$data->id) .'" class="track" data-toggle="modal" data-target="#modal1">
                                <i class="fas fa-truck"></i> Track Order</a>'.$orders.$refund.'
                                <a href="' . route('admin-generate-invoice',$data->id) . '"><i class="fas fa-envelope"></i>Generate Invoice</a>
                                <a href="' . route('admin-packaging-slip',$data->id) . '"><i class="fas fa-envelope"></i>Generate Package Slip</a></div></div>';
                            }) 
                            
                            ->rawColumns(['id','number','action','status','Prductlist','vendor_name','payment_status'])
                            ->toJson(); 
    }
	
	//*** JSON Request
    public function completeddatatables($status){
		
        $svendor = (!empty($_GET["svendor"])) ? ($_GET["svendor"]) : ('');
        $startdateis = (!empty($_GET["startdateis"])) ? ($_GET["startdateis"]) : (''); 
        $enddateis = (!empty($_GET["enddateis"])) ? ($_GET["enddateis"]) : ('');


        $query = Order::select('*');
            if(!empty($svendor))
                $query->whereRaw("find_in_set($svendor , vendor_id_list)");
            if(!empty($startdateis))
                $query->whereDate('created_at','>=',$startdateis);
            if(!empty($enddateis))
                $query->whereDate('created_at','<=',$enddateis);
            if(!empty($status))
				$query->where('status','=',$status); 			
        $datas=$query->orderBy('id','desc')->get();
         
         //--- Integrating This Collection Into Datatables
         return Datatables::of($datas)
                            ->editColumn('id', function(Order $data) {
                                $id = '<a href="'.route('admin-order-show',$data->order_id).'">'.$data->order_number.'</a>';
                                return $id;
                            })
                            ->editColumn('number', function(Order $data) {
								$checkbox= "<input type='checkbox' class='order-sts'  name='ordercheckedid[]' value='$data->id'  > <script>jQuery('.order-sts').click(function () {jQuery(this).siblings('input').prop('checked', this.checked);});</script>";
                                $number = '<a href="'.route('admin-order-show',$data->id).'">'.$data->order_number.'</a>';
                                return $number;
                            })
                            ->editColumn('pay_amount', function(Order $data) {
                                return $data->currency_sign . round($data->pay_amount * $data->currency_value , 2);
                            })                           
                            ->editColumn('vendor_name', function(Order $data) {
                                $idarray = explode(',', $data->vendor_id_list);
                                $idcount = count(array_unique($idarray));
                                for($i=0;$i<=$idcount-1;$i++){
                                    $id = $idarray[$i];
                                    $users[] = User::all()->where('is_vendor','2')->where('id',$id)->pluck('shop_name')->implode('');    
                                }

                                foreach ($users as $key => $value) {
                                         $listname[] = $value;
                                } 
                                
                                $childcategorylist = implode(',', $listname);
                                
                                return  $childcategorylist;
                            })
                            
                             ->editColumn('payment_status', function(Order $data) {
                                $paystatus =  $data->payment_status;
                                if($paystatus == 'Completed'){
                                    return '<span class="badge badge-success"> Paid </span>';
                                }
                                else {
                                    return '<span class="badge badge-danger"> Unpaid </span>';
                                }
                                
                            })
                            
                            ->addColumn('action', function(Order $data) {
								$orderstatus =  $data->status;
                                $orders = '<a href="javascript:;" data-href="'. route('admin-order-edit',$data->id) .'" class="delivery" data-toggle="modal" data-target="#modal1">
                                <i class="fas fa-dollar-sign"></i> Delivery Status</a>';

                                $orderitems = '<a href="javascript:;" data-href="'. route('admin-order-show-items',$data->id) .'" class="delivery" data-toggle="modal" data-target="#modal1">

                                <i class="fas fa-dollar-sign"></i> Items</a>';
                                  
                                
                                return '<div class="godropdown"><button class="go-dropdown-toggle"> Actions<i class="fas fa-chevron-down"></i></button>
                                <div class="action-list">
                                <a href="' . route('admin-order-show',$data->id) . '" > <i class="fas fa-eye"></i> Details</a>
                                <a href="javascript:;" class="send" data-email="'. $data->customer_email .'" data-toggle="modal" data-target="#vendorform">
                                <i class="fas fa-envelope"></i> Send</a>
                                <a href="javascript:;" data-href="'. route('admin-order-track',$data->id) .'" class="track" data-toggle="modal" data-target="#modal1">
                                <i class="fas fa-truck"></i> Track Order</a>'.$orders.'
                                <a href="' . route('admin-generate-invoice',$data->id) . '"><i class="fas fa-envelope"></i>Generate Invoice</a>
                                <a href="' . route('admin-packaging-slip',$data->id) . '"><i class="fas fa-envelope"></i>Generate Package Slip</a></div></div>';
                            }) 
                            
                            ->rawColumns(['id','number','action','status','Prductlist','vendor_name','payment_status'])
                            ->toJson(); 
    }
	
	//*** JSON Request
    public function declineddatatables($status ){
		$svendor = (!empty($_GET["svendor"])) ? ($_GET["svendor"]) : ('');
        $startdateis = (!empty($_GET["startdateis"])) ? ($_GET["startdateis"]) : (''); 
        $enddateis = (!empty($_GET["enddateis"])) ? ($_GET["enddateis"]) : ('');


        $query = Order::select('*');
            if(!empty($svendor))
                $query->whereRaw("find_in_set($svendor , vendor_id_list)");
            if(!empty($startdateis))
                $query->whereDate('created_at','>=',$startdateis);
            if(!empty($enddateis))
                $query->whereDate('created_at','<=',$enddateis);
            if(!empty($status))
				$query->where('status','=',$status); 			
        $datas=$query->orderBy('id','desc')->get();
         
         //--- Integrating This Collection Into Datatables
         return Datatables::of($datas)
                            ->editColumn('id', function(Order $data) {
                                $id = '<a href="'.route('admin-order-show',$data->order_id).'">'.$data->order_number.'</a>';
                                return $id;
                            })
                            ->editColumn('number', function(Order $data) {
								$checkbox= "<input type='checkbox' class='order-sts'  name='ordercheckedid[]' value='$data->id'  > <script>jQuery('.order-sts').click(function () {jQuery(this).siblings('input').prop('checked', this.checked);});</script>";
                                $number = '<a href="'.route('admin-order-show',$data->id).'">'.$data->order_number.'</a>';
                                return $number;
                            })
                            ->editColumn('pay_amount', function(Order $data) {
                                return $data->currency_sign . round($data->pay_amount * $data->currency_value , 2);
                            })                           
                            ->editColumn('vendor_name', function(Order $data) {
                                $idarray = explode(',', $data->vendor_id_list);
                                $idcount = count(array_unique($idarray));
                                for($i=0;$i<=$idcount-1;$i++){
                                    $id = $idarray[$i];
                                    $users[] = User::all()->where('is_vendor','2')->where('id',$id)->pluck('shop_name')->implode('');    
                                }

                                foreach ($users as $key => $value) {
                                         $listname[] = $value;
                                } 
                                
                                $childcategorylist = implode(',', $listname);
                                
                                return  $childcategorylist;
                            })
                            
                                                     
                            ->editColumn('payment_status', function(Order $data) {
                                $paystatus =  $data->payment_status;
                                if($paystatus == 'Completed'){
                                    return '<span class="badge badge-success"> Paid </span>';
                                }
                                else {
                                    return '<span class="badge badge-danger"> Unpaid </span>';
                                }
                                
                            })
                            
                            ->addColumn('action', function(Order $data) {
								$orderstatus =  $data->status;
                                $orders = '<a href="javascript:;" data-href="'. route('admin-order-edit',$data->id) .'" class="delivery" data-toggle="modal" data-target="#modal1">
                                <i class="fas fa-dollar-sign"></i> Delivery Status</a>';

                                $orderitems = '<a href="javascript:;" data-href="'. route('admin-order-show-items',$data->id) .'" class="delivery" data-toggle="modal" data-target="#modal1">

                                <i class="fas fa-dollar-sign"></i> Items</a>'; 
                                 if($orderstatus == 'completed'){
                                    $refund = '<a href="javascript:;" data-href="'. route('admin-order-refund',$data->id) .'" class="order-refund" data-toggle="modal" data-target="#refundpopup">

                                <i class="fas fa-dollar-sign"></i> Refund</a>';
                                } else{
                                    $refund = '';
                                }
                                  
                                
                                return '<div class="godropdown"><button class="go-dropdown-toggle"> Actions<i class="fas fa-chevron-down"></i></button>
                                <div class="action-list">
                                <a href="' . route('admin-order-show',$data->id) . '" > <i class="fas fa-eye"></i> Details</a>
                                <a href="javascript:;" class="send" data-email="'. $data->customer_email .'" data-toggle="modal" data-target="#vendorform">
                                <i class="fas fa-envelope"></i> Send</a>
                                <a href="javascript:;" data-href="'. route('admin-order-track',$data->id) .'" class="track" data-toggle="modal" data-target="#modal1">
                                <i class="fas fa-truck"></i> Track Order</a>'.$orders.$refund.'
                                <a href="' . route('admin-generate-invoice',$data->id) . '"><i class="fas fa-envelope"></i>Generate Invoice</a>
                                <a href="' . route('admin-packaging-slip',$data->id) . '"><i class="fas fa-envelope"></i>Generate Package Slip</a></div></div>';
                            }) 
                            
                            ->rawColumns(['id','number','action','status','Prductlist','vendor_name','payment_status'])
                            ->toJson(); 
    }
	
	
	//*** JSON Request
    public function refunddatatables($status){
        
		$svendor = (!empty($_GET["svendor"])) ? ($_GET["svendor"]) : (''); 
        $startdateis = (!empty($_GET["startdateis"])) ? ($_GET["startdateis"]) : (''); 
        $enddateis = (!empty($_GET["enddateis"])) ? ($_GET["enddateis"]) : ('');

       
        $datas = VendorOrder::orderBy('id','desc')->get();		
		
		$query = VendorOrder::select('*');
            if(!empty($svendor))
                $query->where('user_id','=',$svendor);
            if(!empty($startdateis))
                $query->whereDate('created_at','>=',$startdateis);
            if(!empty($enddateis))
                $query->whereDate('created_at','<=',$enddateis);			
           		
          $datas=$query->where('status','!=','pending')->where('status','!=','declined')->where('product_item_price','!=','')->orderBy('id','desc')->get();
		
         
         //--- Integrating This Collection Into Datatables
         return Datatables::of($datas)
                            
							->editColumn('number', function(VendorOrder $data) {
                                $number = '<a href="'.route('admin-order-show',$data->order_id).'">#'.$data->order_number.'</a>';
                                return $number;
                            })							
							->editColumn('customer_name', function(VendorOrder $data) {
								$order_data = Order::find($data->order_id);
                                return $order_data->customer_name;
                            })
							->editColumn('vendor_name', function(VendorOrder $data) {
								$order_data = Order::find($data->order_id);
                                $idarray = explode(',', $order_data->vendor_id_list);
                                $idcount = count(array_unique($idarray));
                                for($i=0;$i<=$idcount-1;$i++){
                                    $id = $idarray[$i];
                                    $users[] = User::all()->where('is_vendor','2')->where('id',$id)->pluck('shop_name')->implode('');    
                                }

                                foreach ($users as $key => $value) {
                                         $listname[] = $value;
                                } 
                                
                                $childcategorylist = implode(',', $listname);
                                
                                return  $childcategorylist;
                            })
							->editColumn('totalQty', function(VendorOrder $data) {
								//$order_data = Order::find($data->order_id);
							    //$totalQty =  $order_data->totalQty;
								$totalQty =  $data->qty;
                                return $totalQty;
                            })	
							
							->editColumn('payment_status', function(VendorOrder $data) {
								$order_data = Order::find($data->order_id);
                                $paystatus =  $order_data->payment_status;
                                if($paystatus == 'Completed'){
                                    return '<span class="badge badge-success"> Paid </span>';
                                }
                                else {
                                    return '<span class="badge badge-danger"> Unpaid </span>';
                                }
                                
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
							    $status.= '<option value="'.route('vendor-order-status',['slug' => $data->order_number, 'status' => 'processing']).'" '.$processing.' >Processing</option>';
								$status.= '<option value="'.route('vendor-order-status',['slug' => $data->order_number, 'status' => 'completed']).'" '.$completed.' >Completed</option>';
							    $status.= '<option value="'.route('vendor-order-status',['slug' => $data->order_number, 'status' => 'on delivery']).'" '.$delivery.' >On Delivery</option>';
                                $status.= '</select>';
								$status.= "<script>jQuery('.vendor-btn').on('change',function(){ jQuery('#confirm-delete2').modal('show'); jQuery('#confirm-delete2').find('.btn-ok').attr('href', jQuery(this).val()); }); </script>";
								return $status;
							
                            })
							
							->addColumn('action', function(VendorOrder $data) {
								$order_data = Order::find($data->order_id);
								$orderstatus =  $order_data->status;
                                $orders = '<a href="javascript:;" data-href="'. route('admin-order-edit',$order_data->id) .'" class="delivery" data-toggle="modal" data-target="#modal1">
                                <i class="fas fa-dollar-sign"></i> Delivery Status</a>';

                                $orderitems = '<a href="javascript:;" data-href="'. route('admin-order-show-items',$order_data->id) .'" class="delivery" data-toggle="modal" data-target="#modal1">

                                <i class="fas fa-dollar-sign"></i> Items</a>'; 
                                 if($orderstatus == 'completed'){
                                    $refund = '<a href="javascript:;" data-href="'. route('admin-order-refund',$order_data->id) .'" class="order-refund" data-toggle="modal" data-target="#refundpopup">

                                <i class="fas fa-dollar-sign"></i> Refund</a>';
                                } else{
                                    $refund = '';
                                }
                                  
                                
                                return '<div class="godropdown"><button class="go-dropdown-toggle"> Actions<i class="fas fa-chevron-down"></i></button>
                                <div class="action-list">
                                <a href="' . route('admin-order-show',$order_data->id) . '" > <i class="fas fa-eye"></i> Details</a>
                                <a href="javascript:;" class="send" data-email="'. $order_data->customer_email .'" data-toggle="modal" data-target="#vendorform">
                                <i class="fas fa-envelope"></i> Send</a>
                                <a href="javascript:;" data-href="'. route('admin-order-track',$order_data->id) .'" class="track" data-toggle="modal" data-target="#modal1">
                                <i class="fas fa-truck"></i> Track Order</a>'.$orders.$refund.'
                                <a href="' . route('admin-generate-invoice',$order_data->id) . '"><i class="fas fa-envelope"></i>Generate Invoice</a>
                                <a href="' . route('admin-packaging-slip',$order_data->id) . '"><i class="fas fa-envelope"></i>Generate Package Slip</a></div></div>';
                            }) 
                            
                            ->rawColumns(['id','number','action','status','Prductlist','vendor_name','payment_status'])
                            ->toJson(); //--- Returning Json Data To Client Side
    }
	
	
    public function index(){
		$all__count =  Order::all()->count('id');
		$pending__count =  Order::where('status','=','pending')->count('id');        
        $processing__count =  Order::where('status','=','processing')->count('id');        
        $declined__count =  Order::where('status','=','declined')->count('id');        
        $od__count =  Order::where('status','=','on delivery')->count('id');       
        $completed_count =  Order::where('status','=','completed')->count('id');
		$refund_count =  VendorOrder::where('status','!=','pending')->where('status','!=','declined')->where('product_item_price','!=','')->count();
        $users = User::all()->where('is_vendor','2');
        return view('admin.order.index',compact('users','all__count','pending__count','processing__count','declined__count','od__count','completed_count','refund_count'));
    }

    public function edit($id){
        $data = Order::find($id);
        return view('admin.order.delivery',compact('data'));
    }
	 public function unpaidstatus($id){
        $data = Order::find($id);
        return view('admin.order.unpaidstatus',compact('data'));
    }
	public function tidgenerate($id){
        
    }
	public function tidupdate(Request $request, $id){
		   $data = Order::findOrFail($id);
            $input['txnid'] =  $request->tansid;
            $data->update($input);
            $msg = 'Status Updated Successfully.';
            return response()->json($msg); 
    }

    //*** POST Request
    public function update(Request $request, $id){
		$email=env('ADMIN_EMAIL');		 
        $admindata = Admin::where('email',$email)->first();
        if($request->deliveryStatus == 2){
    
            $notification = new Notification;
            $notification->order_id = $id;
            
            if(!empty($request->track_text)){
                $newmsg = 'Message : ' . $request->track_text;    
            }else{
                $newmsg = '';
            }
            
            $notification->message = htmlentities($newmsg);
            $notification->save();
        }
        
        $data = Order::findOrFail($id);
        $input = $request->all();
        if ($data->status == "completed"){
            $input['status'] = "completed";
            $data->update($input);
            $msg = 'Status Updated Successfully.';
            return response()->json($msg);  
             
            
            
        }else{
            $notification = new Notification;
            $notification->order_id = $id;
            
            if($request->paymentStatus == 1){
                $msgn="Payment Status Changed To : " . $request->payment_status ;
            }elseif($request->deliveryStatus == 2){
                
                if ($input['status'] == "on delivery"){
                    $msgn="Order has been Shipped. ";
                }
                if ($input['status'] == "pending"){
                    $msgn="Order has been Pending. ";
                    
                }
                
                if ($input['status'] == "processing"){                
                    $msgn="Order has been processing. ";
                }
                if ($input['status'] == "declined"){                
                   
                    $msgn="Order has been Declined. ";
                
                }
                if ($input['status'] == "completed"){
                    $msgn="Order has been delivered and mark completed. ";
                }
                
            }
            if(!empty($request->track_text)){
                $newmsg = $msgn . '<br> Message : ' . $request->track_text;    
            }else{
                $newmsg = $msgn;
            }
            
            $notification->message = htmlentities($newmsg);
            $notification->save();
            
             
             
            if ($input['status'] == "processing"){
                foreach($data->vendororders as $vorder){
                    $uprice = User::findOrFail($vorder->user_id);
                    $uprice->current_balance = $uprice->current_balance + $vorder->price;
                    $uprice->update();
                }
    
                $gs = Generalsetting::findOrFail(1);
		$order_id= $id;
		$order_number= Order::where( 'order_number', $order_id )->first();
		$order = Order::findOrFail($id);
		
			$cart = unserialize(bzdecompress(utf8_decode($order->cart)));			
			$to = $order->customer_email;
            $subject = 'Your South India Jewels order '.$order->order_number.' is now processing';
 
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
                                          <h1 style="font-size:30px;font-weight:300;line-height:150%;margin:0;text-align:left;color:#ffffff"><span class="il"></span> <span class="il">Order</span>: #'.$order_number.'</h1>
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
                                                         <p style="margin:0 0 16px">We have processed your order #'.$order_number.',</p>
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
  
   if($gs->is_smtp == 1)
                    {
$objDemo = new \stdClass();
        $objDemo->to = $to;
        $objDemo->from = $gs->from_email;
        $objDemo->title = $gs->from_name;
        $objDemo->subject =$subject ;
        $id= $order->id;
		$rdata = [
            'email_body' => $msg
        ];
		
				
        try{
            Mail::send('admin.email.mailbody',$rdata, function ($message) use ($objDemo,$id) {
                $message->from($objDemo->from,$objDemo->title);
                $message->to($objDemo->to);
                $message->subject($objDemo->subject);
                $order = Order::findOrFail($id);
                $cart = unserialize(bzdecompress(utf8_decode($order->cart)));
                $fileName = public_path('assets/temp_files/').str_random(4).time().'.pdf';
                $pdf = PDF::loadView('print.order', compact('order', 'cart'))->save($fileName);
                $message->attach($fileName);
            });			

        }
        catch (Exception $e){
             
        }
					}else{
						mail($to, $subject, $msg, $headers);						

					}
                
            }
            
            if ($input['status'] == "completed"){
    
                foreach($data->vendororders as $vorder)
                {
                    $uprice = User::findOrFail($vorder->user_id);
                    $uprice->current_balance = $uprice->current_balance + $vorder->price;
                    $uprice->update();
                }
    
               $gs = Generalsetting::findOrFail(1);
		$order_id= $id;
		$order_number= Order::where( 'order_number', $order_id )->first();
		$order = Order::findOrFail($id);
		
			$cart = unserialize(bzdecompress(utf8_decode($order->cart)));			
			$to = $order->customer_email;
            $subject = 'Your South India Jewels order '.$order->order_number.' is now complete';
 
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
                                          <h1 style="font-size:30px;font-weight:300;line-height:150%;margin:0;text-align:left;color:#ffffff"><span class="il"></span> <span class="il">Order</span>: #'.$order_number.'</h1>
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
                                                         <p style="margin:0 0 16px">Your order #'.$order_number.'is delivered successfully and marked completed.</p>
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
   
   if($gs->is_smtp == 1)
                    {
$objDemo = new \stdClass();
        $objDemo->to = $to;
        $objDemo->from = $gs->from_email;
        $objDemo->title = $gs->from_name;
        $objDemo->subject =$subject ;
        $id= $order->id;
		$rdata = [
            'email_body' => $msg
        ];
		
				
        try{
            Mail::send('admin.email.mailbody',$rdata, function ($message) use ($objDemo,$id) {
                $message->from($objDemo->from,$objDemo->title);
                $message->to($objDemo->to);
                $message->subject($objDemo->subject);
                $order = Order::findOrFail($id);
                $cart = unserialize(bzdecompress(utf8_decode($order->cart)));
                $fileName = public_path('assets/temp_files/').str_random(4).time().'.pdf';
                $pdf = PDF::loadView('print.order', compact('order', 'cart'))->save($fileName);
                $message->attach($fileName);
            });			

        }
        catch (Exception $e){
             
        }
					}else{
						mail($to, $subject, $msg, $headers);						

					}
                
                
            }
            if ($input['status'] == "declined"){
               $gs = Generalsetting::findOrFail(1);
		$order_id= $id;
		$order_number= Order::where( 'order_number', $order_id )->first();
		$order = Order::findOrFail($id);
		
			$cart = unserialize(bzdecompress(utf8_decode($order->cart)));			
			$to = $order->customer_email;
            $subject = 'Your South India Jewels order '.$order->order_number.' is now decline';
 
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
                                          <h1 style="font-size:30px;font-weight:300;line-height:150%;margin:0;text-align:left;color:#ffffff"><span class="il"></span> <span class="il">Order</span>: #'.$order_number.'</h1>
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
                                                         <p style="margin:0 0 16px">Sorry we are unable to process your order #'.$order_number.'. If any amount is deducted from your bank account will be reverted in 7 working days.</p>
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
   if($gs->is_smtp == 1)
                    {
$objDemo = new \stdClass();
        $objDemo->to = $to;
        $objDemo->from = $gs->from_email;
        $objDemo->title = $gs->from_name;
        $objDemo->subject =$subject ;
        $id= $order->id;
		$rdata = [
            'email_body' => $msg
        ];
		
				
        try{
            Mail::send('admin.email.mailbody',$rdata, function ($message) use ($objDemo,$id) {
                $message->from($objDemo->from,$objDemo->title);
                $message->to($objDemo->to);
                $message->subject($objDemo->subject);
                $order = Order::findOrFail($id);
                $cart = unserialize(bzdecompress(utf8_decode($order->cart)));
                $fileName = public_path('assets/temp_files/').str_random(4).time().'.pdf';
                $pdf = PDF::loadView('print.order', compact('order', 'cart'))->save($fileName);
                $message->attach($fileName);
            });			

        }
        catch (Exception $e){
             
        }
					}else{
						mail($to, $subject, $msg, $headers);						

					}
                
               
    
            }

            $data->update($input);

            if($request->track_text)
            {
                    $title = ucwords($request->status);
                    $ck = OrderTrack::where('order_id','=',$id)->where('title','=',$title)->first();
                    if($ck){
                        $ck->order_id = $id;
                        $ck->title = $title;
                        $ck->text = $request->track_text;
                        $ck->update();
$order_track = DB::table('order_tracks')->orderBy('id', 'DESC')->first();						
$gs = Generalsetting::findOrFail(1);
		$order_id= $id;
		$order_number= Order::where( 'order_number', $order_id )->first();
		$order = Order::findOrFail($id);
		
			$cart = unserialize(bzdecompress(utf8_decode($order->cart)));			
			$to = $order->customer_email;
            $subject = 'Your South India Jewels order '.$order->order_number.' is now complete';
 
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
                                          <h1 style="font-size:30px;font-weight:300;line-height:150%;margin:0;text-align:left;color:#ffffff"><span class="il"></span> <span class="il">Order</span>: #'.$order_number.'</h1>
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
                                                         <p style="margin:0 0 16px">your order #'.$order_number.' is Shipped,</p>
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
   if($gs->is_smtp == 1)
                    {
$objDemo = new \stdClass();
        $objDemo->to = $to;
        $objDemo->from = $gs->from_email;
        $objDemo->title = $gs->from_name;
        $objDemo->subject =$subject ;
        $id= $order->id;
		$rdata = [
            'email_body' => $msg
        ];
		
				
        try{
            Mail::send('admin.email.mailbody',$rdata, function ($message) use ($objDemo,$id) {
                $message->from($objDemo->from,$objDemo->title);
                $message->to($objDemo->to);
                $message->subject($objDemo->subject);
                $order = Order::findOrFail($id);
                $cart = unserialize(bzdecompress(utf8_decode($order->cart)));
                $fileName = public_path('assets/temp_files/').str_random(4).time().'.pdf';
                $pdf = PDF::loadView('print.order', compact('order', 'cart'))->save($fileName);
                $message->attach($fileName);
            });			

        }
        catch (Exception $e){
             
        }
					}else{
						mail($to, $subject, $msg, $headers);						

					}						
                    }
                    else {
                        $data = new OrderTrack;
                        $data->order_id = $id;
                        $data->title = $title;
                        $data->text = $request->track_text;
                        $data->save();            
                    }		
    
    
            }		
			

        $order = VendorOrder::where('order_id','=',$id)->update(['status' => $input['status']]);

         //--- Redirect Section          
         $msg = 'Status Updated Successfully.';
         return response()->json($msg);    
         //--- Redirect Section Ends    
    
            }

        //--- Redirect Section          
        $msg = 'Status Updated Successfully.';
        return response()->json($msg);    
        //--- Redirect Section Ends  

    }
	
	 //*** POST Request
    public function unpaidstock(Request $request, $id){
              
        $data = Order::findOrFail($id);		
        $input = $request->all();
		
		if ($input['payment_status'] == "Completed"){
		$input['status'] = "processing";
		$cart = unserialize(bzdecompress(utf8_decode($data->cart)));		
                  foreach($cart->items as $prod)
              {
                    $x = (string)$prod['size_qty'];
            if(!empty($x))
            {  
                $product = Product::findOrFail($prod['item']['id']);                
               echo $x = @$product->size_qty[$prod['size_key']] - $prod['qty'];
                $temp = $product->size_qty;
                $temp[$prod['size_key']] = $x;
                $temp1 = implode(',', $temp);
                $product->size_qty =  $temp1;				
                //$product->update();               
            } 
			  }
            foreach($cart->items as $prod)
        {
            $x = (string)$prod['stock'];
            if($x != null)
            {

                $product = Product::findOrFail($prod['item']['id']);
                $product->stock =  $product->stock- $prod['qty'];
                $product->update();  
                if($product->stock <= 5)
                {
                    $notification = new Notification;
                    $notification->product_id = $product->id;
                    $notification->save();                    
                }              
            }
        }			  
       
        foreach($data->vendororders as $vorder){
                    $uprice = User::findOrFail($vorder->user_id);
                    $uprice->current_balance = $uprice->current_balance + $vorder->price;
                    $uprice->update();
                }		  
        $data->update($input);
		$status="processing";
		DB::table('vendor_orders')->where(['order_id' => $id])->update(['status' => $status]);		
        $msg = 'Status Updated Successfully.';
        return response()->json($msg);
		} else{
			$err = 'Status not update,Please select paid';
			return response()->json(array('errors' => $err));
		}   

    }

    public function pending(){
		$users = User::all()->where('is_vendor','2');
        return view('admin.order.pending',compact('users'));       
    }

    public function shipping(){
		$users = User::all()->where('is_vendor','2');
        return view('admin.order.shipping',compact('users'));
        
    }
    public function processing(){
		$users = User::all()->where('is_vendor','2');
        return view('admin.order.processing',compact('users'));        
    }
    public function completed()
    {
		$users = User::all()->where('is_vendor','2');
        return view('admin.order.completed',compact('users'));        
    }
    public function declined()
    {
		$users = User::all()->where('is_vendor','2');
        return view('admin.order.declined',compact('users')); 
        
    }
	
	 public function refundod()
    {
        $users = User::all()->where('is_vendor','2');
        $orders = VendorOrder::orderBy('id','desc')->get()->groupBy('order_number');
        return view('admin.order.refundod',compact('users','orders'));
    }
    public function show($id){
        if(!Order::where('id',$id)->exists()){
            return redirect()->route('admin.dashboard')->with('unsuccess',__('Sorry the page does not exist.'));
        }
        $notification       = Notification::where('order_id','=',$id)->orderBy('id','desc')->where('message','!=','')->get();
        $shippingDetails    = OrderTrack::where('order_id','=',$id)
                                        ->orderByDesc('id')                                        
                                        ->get();
        $order = Order::findOrFail($id);
        $cart = unserialize(bzdecompress(utf8_decode($order->cart)));
        return view('admin.order.details',compact('order','cart','notification','shippingDetails'));
    }
    public function showitems($id)
    {
        if(!Order::where('id',$id)->exists()){
            return redirect()->route('admin.dashboard')->with('unsuccess',__('Sorry the page does not exist.'));
        }
        $notification = Notification::where('order_id','=',$id)->orderBy('id','desc')->get();
        $order = Order::findOrFail($id);
        $cart = unserialize(bzdecompress(utf8_decode($order->cart)));
        return view('admin.order.detailsitems',compact('order','cart','notification'));
    }
    
    //*** GET Request
  	public function refund($id)
    {
        $order = Order::findOrFail($id);
        $order->refund = 1;
        $order->update();
        //--- Redirect Section        
        $msg = 'Status Updated Successfully.';
        return response()->json($msg);      
        //--- Redirect Section Ends    

    }
    
    public function invoice($id)
    {
        $order = Order::findOrFail($id);
		 /*$adminselect = Admin::findOrFail(1);
        $admindata = $adminselect->where('id','=','1')->first();*/
        $email=env('ADMIN_EMAIL');		 
        $admindata = Admin::where('email',$email)->first();
		$cart = unserialize(bzdecompress(utf8_decode($order->cart)));
        return view('admin.order.invoice',compact('order','admindata','cart'));
    }
	public function editbilling($id)
    {
        $order = Order::findOrFail($id);		 
        return view('admin.order.editbilling',compact('order'));
    }
	public function editshipping($id)
    {
        $order = Order::findOrFail($id);		 
        return view('admin.order.editshipping',compact('order'));
    }
	 //*** POST Request
    public function updatebilling(Request $request,$id)
    {
		$data = Order::findOrFail($id);
        $input = $request->all();
        $data->update($input);           
        $msg = 'Data Updated Successfully.';
        return response()->json($msg);	
	}
	 public function updateshipping(Request $request, $id)
    {
		 
        $data = Order::findOrFail($id);
        $input = $request->all();
        $data->update($input);           
        $msg = 'Data Updated Successfully.';
        return response()->json($msg);
	}


    public function generateinvoice($id){
        $order = Order::findOrFail($id);
		 /*$adminselect = Admin::findOrFail(1);
        $admindata = $adminselect->where('id','=','1')->first();*/
        $email=env('ADMIN_EMAIL');		 
        $admindata = Admin::where('email',$email)->first();
        $cart = unserialize(bzdecompress(utf8_decode($order->cart)));
        //echo "<pre>";print_r($cart);die;
        $fileName = 'invoice_'.$order->order_number.'.pdf';
        $pdf = PDF::loadView('print.storeinvoice', compact('order','admindata', 'cart'))->save($fileName);
       // return $pdf->download($fileName);
        return $pdf->stream($fileName);
    }

    public function packagingslip($id){
        $order = Order::findOrFail($id);
		/*$adminselect = Admin::findOrFail(1);
        $admindata = $adminselect->where('id','=','1')->first();*/
        $email=env('ADMIN_EMAIL');		 
        $admindata = Admin::where('email',$email)->first();     
        $cart = unserialize(bzdecompress(utf8_decode($order->cart)));
        $fileName = 'packingslip'.$order->order_number.'.pdf';
        $pdf = PDF::loadView('print.packagingslip', compact('order','admindata', 'cart'))->save($fileName);
        //return $pdf->download($fileName);
        return $pdf->stream($fileName);
    }
    public function emailsub(Request $request)
    {
		$gs = Generalsetting::findOrFail(1);
        if($gs->is_smtp == 1)
        {
            $data = 0;
            $datas = [
                    'to' => $request->to,
                    'subject' => $request->subject,
                    'body' => $request->message,
            ];

            $mailer = new GeniusMailer();
            $mail = $mailer->sendCustomMail($datas);
            if($mail) {
                $data = 1;
            }
        }
        else
        {
            $data = 0;
            $headers = "From: ".$gs->from_name."<".$gs->from_email.">";
            $mail = mail($request->to,$request->subject,$request->message,$headers);
            if($mail) {
                $data = 1;
            }
        }

        return response()->json($data);
    }
    public function customaddnote(Request $request)
    {
        $newmsg =$request->message;
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
public function ordersave(Request $request){
		$nooforder =  $request->nooforder;
		Ordercsv::where('order_name', 'order-csv')
       ->update([
           'nooforder' => $nooforder
        ]);
		return redirect()->action('Admin\OrderController@index');		
		
	}
    public function printpage($id)
    {
        $order = Order::findOrFail($id);
        $cart = unserialize(bzdecompress(utf8_decode($order->cart)));
        return view('admin.order.print',compact('order','cart'));
    }

    public function license(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $cart = unserialize(bzdecompress(utf8_decode($order->cart)));
        $cart->items[$request->license_key]['license'] = $request->license;
        $order->cart = utf8_encode(bzcompress(serialize($cart), 9));
        $order->update();       
        $msg = 'Successfully Changed The License Key.';
        return response()->json($msg);
    }
	
	public function statusupdate(Request $request){ 
	    if(is_array($request->ordercheckedid))
    	$count = count($request->ordercheckedid);
    	$status = $request->status;
    	if(isset($status) && !empty($status) && isset($count) && !empty($count)){
    	for($i=0;$i<=$count-1;$i++){		
    		Order::where('id',$request->ordercheckedid[$i])->update(['status' => $status]);
    		if($i==$count-1){
    		$msg = 'Status update Successfully.';
            return response()->json($msg);
    		}
    		
    	}
    	
    	} else {
    
            $msg = 'Please select orders first for Bulk Edit.';
        return response()->json($msg); 
    	}
        	
    }
	 
	public function downloadExcelFile($status){	
	 $ordercsv = Ordercsv::findOrFail(1);
	 $nooforder=$ordercsv->nooforder;
	 $v_datas = VendorOrder::where('status','completed')->orderBy('id','desc')->get();
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

 public function downloadprocessExcel($status){	
	 $ordercsv = Ordercsv::findOrFail(1);
	 $nooforder=$ordercsv->nooforder;
	 $v_datas = VendorOrder::where('status','processing')->orderBy('id','desc')->get();
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
	
public function downloadShipFile($status){	
	 $ordercsv = Ordercsv::findOrFail(1);
	 $nooforder=$ordercsv->nooforder;
	 $v_datas = VendorOrder::where('status','on delivery')->orderBy('id','desc')->get();
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
	
	public function allorderExcelFile($status){	
	 $ordercsv = Ordercsv::findOrFail(1);
	 $nooforder=$ordercsv->nooforder;
	 $v_datas = VendorOrder::orderBy('id','desc')->where('status','!=','pending')->where('status','!=','declined')->get();
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
	
	public function ordertracks()
    {
        $users = User::all()->where('is_vendor','2');
        $orders = VendorOrder::orderBy('id','desc')->get()->groupBy('order_number');
        return view('admin.order.ordertracks',compact('users','orders'));
    }
	public function ordertrackExcel(Request $request,$vendorid){
		
	$svendor = (!empty($request->svendor)) ? ($request->svendor) : ('');
	if($svendor) {
	$ot_datas = OrderTrack::where('vendor_id','=',$svendor)->orderBy('id','desc')->get();
	$fileName = 'order_track.csv';	
		
	$headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );     
        

        $columns = array('SL No', 'Order Number', 'Vendor Name', 'Order Date', 'Product Name', 'Product SKU', 'Tracking Code','Tracking Url','Company Name','Tracking Date');
		
		$j=1;			
		$callback = function() use($ot_datas, $columns,$j) {
        $file = fopen('php://output', 'w');
         fputcsv($file, $columns);		 
            foreach ($ot_datas as $ot_data) {
				$data =	Order::find($ot_data->order_id);
                $row['SL No']  = $j;				
				$row['Order Number']    = $data->order_number; 			
				$users_name = User::all()->where('is_vendor','2')->where('id',$ot_data->vendor_id)->pluck('shop_name')->implode(',');
                $row['Vendor Name']    = $users_name;
				$row['Order Date']    = date('d-M-Y',strtotime($data->created_at)); 
			    if(@$ot_data->pid){
					$productnames = Product::all()->where('id',$ot_data->pid)->pluck('name');
                    $productname = str_replace( array( '["', '"]'), ' ', $productnames);
                    $productsku = Product::all()->where('id',$ot_data->pid)->pluck('sku');
                    $productskus = str_replace( array( '["', '"]'), ' ', $productsku);
				}else{
					$productname ='';
					$productskus = '';
				}
                
                $row['Product Name']    = $productname;
                $row['Product SKU']    = $productskus;
                $row['Tracking Code']    = $ot_data->title;
                $row['Tracking Url']    = $ot_data->text; 
                $row['Company Name']    = $ot_data->companyname;
                $row['Tracking Date']    = date('d-M-Y',strtotime($ot_data->created_at));  				
            			
                 fputcsv($file, array($row['SL No'] , $row['Order Number'],$row['Vendor Name'],$row['Order Date'],$row['Product Name'],$row['Product SKU'],$row['Tracking Code'],$row['Tracking Url'],$row['Company Name'],$row['Tracking Date']));
				$j++;
				
           
			}
			
            fclose($file);
        };
		

        return response()->stream($callback, 200, $headers);
	}
	}
	

}