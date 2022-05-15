<?php

namespace App\Http\Controllers\Admin;
use App\Classes\GeniusMailer;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Admin;
use App\Models\User;
use App\Models\Coupon;
use Carbon\Carbon;
use App\Models\Generalsetting;
use App\Models\Notification;
use App\Models\Pagesetting;
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

class AdminCouponController extends Controller
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
		$orders = Order::all();
        return view('admin.couponcode.index',compact('orders'));
    } 
	 public function cload($id)
    {
        $order = Order::where('id','=',$id)->orderBy('id','desc')->get();
        return view('admin.couponcode.order',compact('order'));
    }
	 
	
	public function store(Request $request)
    {

    	$rules = [
		        'order_id'   => 'required',		        
				'code' => 'required',
				'email_address' => 'required',
				'price' => 'required'								
                ];
        $validator = Validator::make(Input::all(), $rules);
        
        if ($validator->fails()) {
          return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }
            $couponcode = new Coupon;
	        $input = $request->all();						
			$input['status'] = 1;
            $sdate = date('Y-m-d');
            $edate = date('Y-m-d', strtotime("+6 months", strtotime($sdate)));
            $input['start_date'] =$sdate;
			$input['end_date'] = $edate;			
			$couponcode->fill($input)->save();	
            
            $newmsg = 'Coupon Code Created';
        if(!empty($couponcode->code)){
            $newmsg .='<br> Code : '. $couponcode->code;
        }else{
            $newmsg .='';
        }
        if(!empty($couponcode->price)){    
            $newmsg .='<br>  Amount : '. $couponcode->price;
        }else{
            $newmsg .='';
        }
        			
			$notification = new Notification;
			$notification->order_id = $couponcode->order_id;			
			$notification->message = htmlentities($newmsg);
			$notification->save(); 			
			$msg = "Coupon Code Added Successfully."; ;
            return response()->json($msg);
			

    }
	
	public function alllist()
    {
		return view('admin.couponcode.alllist');
	}
	
	public function alllist_datatables()
    {
         
		$datas = Coupon::where('status','=',1)->orderBy('id','desc')->get();        

         //--- Integrating This Collection Into Datatables
         return Datatables::of($datas)
		                      ->editColumn('id',function(Coupon $data){
                                $id = $data->id;
                                return  $id;
                            })
							->editColumn('order_id',function(Coupon $data){
                                $order_id = $data->order_id;
								if($order_id){
                                return  $order_id;
								}else{
									return  '-';
								}
                            }) 
							->editColumn('email_address',function(Coupon $data){
                                $email_address = $data->email_address;
                                return  $email_address;
                            })
							 ->editColumn('price',function(Coupon $data){
                                $price = $data->price;
                                return  $price;
                            })
                            ->editColumn('code',function(Coupon $data){
                                $code = $data->code;
                                return  $code;
                            })
							 ->editColumn('start_date',function(Coupon $data){
                                $start_date = $data->start_date;
                                return  $start_date;
                            })
							 ->editColumn('end_date',function(Coupon $data){
                                $end_date = $data->end_date;
                                return  $end_date;
                            })
							 ->editColumn('action', function(Coupon $data) {								
								/*$action = '<a href="'. route('admin-approval-update',$data->id) .'" >Approve</a> <a href="'. route('admin-reject-update',$data->id) .'" >Reject</a> ';*/
								$action = '<a href="javascript:;" data-href="'. route('admin-approval-loads',$data->id) .'" class="approval-accept" data-toggle="modal" data-target="#modalapprove">Approve</a> <a href="javascript:;" data-href="'. route('admin-reject-loads',$data->id) .'" class="approval-reject" data-toggle="modal" data-target="#modalreject">Reject</a>';
								return $action;
							
                            })	
							
                            ->rawColumns(['action'])
                            ->toJson(); 
    }

public function approvallist()
    {
		return view('admin.couponcode.approvallist');
	}
	
	public function approvallist_datatables()
    {
         
		$datas = Coupon::where('status','=',2)->orderBy('id','desc')->get();        

         //--- Integrating This Collection Into Datatables
         return Datatables::of($datas)
		                      ->editColumn('id',function(Coupon $data){
                                $id = $data->id;
                                return  $id;
                            })
							->editColumn('order_id',function(Coupon $data){
                                $order_id = $data->order_id;
                                return  $order_id;
                            }) 
							->editColumn('email_address',function(Coupon $data){
                                $email_address = $data->email_address;
                                return  $email_address;
                            })
							 ->editColumn('price',function(Coupon $data){
                                $price = $data->price;
                                return  $price;
                            })
                            ->editColumn('code',function(Coupon $data){
                                $code = $data->code;
                                return  $code;
                            })
                            ->editColumn('start_date',function(Coupon $data){
                                $start_date = $data->start_date;
                                return  $start_date;
                            })
							 ->editColumn('end_date',function(Coupon $data){
                                $end_date = $data->end_date;
                                return  $end_date;
                            })							
                            ->rawColumns(['action'])
                            ->toJson(); 
    }

public function rejectlist()
    {
		return view('admin.couponcode.rejectlist');
	}
	
	public function rejectlist_datatables()
    {
         
		$datas = Coupon::where('status','=',3)->orderBy('id','desc')->get();        

         //--- Integrating This Collection Into Datatables
         return Datatables::of($datas)
		                      ->editColumn('id',function(Coupon $data){
                                $id = $data->id;
                                return  $id;
                            })
							->editColumn('order_id',function(Coupon $data){
                                $order_id = $data->order_id;
                                return  $order_id;
                            }) 
							->editColumn('email_address',function(Coupon $data){
                                $email_address = $data->email_address;
                                return  $email_address;
                            })
							 ->editColumn('price',function(Coupon $data){
                                $price = $data->price;
                                return  $price;
                            })
                            ->editColumn('code',function(Coupon $data){
                                $code = $data->code;
                                return  $code;
                            })
                             ->editColumn('start_date',function(Coupon $data){
                                $start_date = $data->start_date;
                                return  $start_date;
                            })
							 ->editColumn('end_date',function(Coupon $data){
                                $end_date = $data->end_date;
                                return  $end_date;
                            })							
                            ->rawColumns(['action'])
                            ->toJson(); 
    }		
	
	public function app_loads($id)
    {
		$data = Coupon::where('id','=',$id)->first();
		return view('admin.couponcode.load',compact('data'));
		
	}
	public function rej_loads($id)
    {
		$data = Coupon::where('id','=',$id)->first();
		return view('admin.couponcode.rejectload',compact('data'));
		
	}
public function approval($id)
    {
		$config = Generalsetting::findOrFail(1);
		$coupon_code = Coupon::find($id);
        $coupon_code->status = 2;
        $coupon_code->update();
		$newmsg = 'Coupon Code'.$coupon_code->code.' is Approved';
        if(!empty($coupon_code->code)){
            $newmsg .='<br> Code : '. $coupon_code->code;
        }else{
            $newmsg .='';
        }
        if(!empty($coupon_code->price)){    
            $newmsg .='<br>  Amount : '. $coupon_code->price;
        }else{
            $newmsg .='';
        }       
        			
			$notification = new Notification;
			$notification->order_id = $coupon_code->order_id;			
			$notification->message = htmlentities($newmsg);
			$notification->save(); 	
		$to = $coupon_code->email_address;
        $subject = 'Your Coupon Code is Approved';
        $msg = 'Your Coupon Code'.$coupon_code->code.' is Approved';
        $headers = "From: ".$config->from_name."<".$config->from_email.">";
        mail($to,$subject,$msg,$headers);
        $msg = 'Status Updated Successfully';
        return response()->json($msg);		
        //return Redirect::route('admin-coupon-approvallist')->with('sucess', 'Status Updated Successfully');
		
	}	
	
	public function reject($id)
    {
        $config = Generalsetting::findOrFail(1);
		$coupon_code = Coupon::find($id);
        $coupon_code->status = 3;
        $coupon_code->update();
		
		$newmsg = 'Coupon Code'.$coupon_code->code.' is Rejected';
        if(!empty($coupon_code->code)){
            $newmsg .='<br> Code : '. $coupon_code->code;
        }else{
            $newmsg .='';
        }
        if(!empty($coupon_code->price)){    
            $newmsg .='<br>  Amount : '. $coupon_code->price;
        }else{
            $newmsg .='';
        }
        			
			$notification = new Notification;
			$notification->order_id = $coupon_code->order_id;			
			$notification->message = htmlentities($newmsg);
			$notification->save(); 	
		
		$to = $coupon_code->email_address;
        $subject = 'Your Coupon Code is Rejected';
        $msg = 'Your Coupon Code'.$coupon_code->code.' is Rejected';
        $headers = "From: ".$config->from_name."<".$config->from_email.">";
        mail($to,$subject,$msg,$headers);
		$msg = 'Status Updated Successfully';
        return response()->json($msg);
        //return Redirect::route('admin-coupon-rejectlist')->with('sucess', 'Status Updated Successfully');
		
	}

public function allcouponcode($status){		 
	$datas = Coupon::orderBy('id','desc')->get();
	$fileName = 'all_coupon.csv';	
		
	$headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );
        
        $coupon_amount=0;
        $coupon_code='-';

        $columns = array('SL No', 'Coupon Code', 'Order Id', 'Status', 'Issue Date', 'Expire Date', 'Coupon Used Order Id','Coupan Amount','Coupan Used Date','Order Amount','Net Amount');
			$j=1;
			
		$callback = function() use($datas,$columns,$j) {
         $file = fopen('php://output', 'w');
         fputcsv($file, $columns);		 
            foreach ($datas as $data) {
				$order_data =Order::where('id','=',$data->order_id)->first();
                $row['SL No']  = $j;
                $row['Coupon Code']  = $data->code;
                $row['Order Id']  = $data->order_id;
                if(@$order_data->coupon_code){
					$status= 'used';
				}else{
					$status= 'unused';
				}				
                $row['Status']  = $status;
                $row['Issue Date']  = $data->start_date;
                $row['Expire Date']  = $data->end_date;
				if(@$order_data->id){
                $row['Coupon Used Order Id']  = $order_data->id;
				}else{
					$row['Coupon Used Order Id']  = '';
				}
                $row['Coupan Amount']  = $data->price;
				if(@$order_data->created_at){
                $row['Coupan Used Date']  = date('d-M-Y',strtotime($order_data->created_at));
				}else{
					$row['Coupan Used Date']  = '';
				}
				if(@$order_data->pay_amount){
                $row['Order Amount']  = $order_data->pay_amount;
				}else{
					 $row['Order Amount']  = '';
				}
				if(@$order_data->pay_amount){
                $row['Net Amount']  = $order_data->pay_amount- $data->price;
 				}else{
					 $row['Net Amount']  = '';
				}
                 fputcsv($file, array($row['SL No'] , $row['Coupon Code'],$row['Order Id'],$row['Status'], $row['Issue Date'],$row['Expire Date'],$row['Coupon Used Order Id'],$row['Coupan Amount'], $row['Coupan Used Date'],$row['Order Amount'],$row['Net Amount']));
				$j++;			
			}
            fclose($file);
        };
		

        return response()->stream($callback, 200, $headers);
	}	
public function usedcouponcode($status){

$datas = Order::where('coupon_code','!=','')->orderBy('id','desc')->get();
//echo '<pre>';print_r($datas);die;
	$fileName = 'used_coupon.csv';	
		
	$headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );
        
        $coupon_amount=0;
        $coupon_code='-';

        $columns = array('SL No', 'Coupon Code', 'Order Id', 'Issue Date', 'Expire Date', 'Coupon Used Order Id','Coupan Amount','Coupan Used Date','Order Amount','Net Amount');
			$j=1;
			
		$callback = function() use($datas,$columns,$j) {
         $file = fopen('php://output', 'w');
         fputcsv($file, $columns);		 
            foreach ($datas as $data) {
				$coupon_data =Coupon::where('code','=',$data->coupon_code)->first();
				if($coupon_data) {
                $row['SL No']  = $j;
				if(@$coupon_data->code){
                $row['Coupon Code']  = $coupon_data->code;
				}else{
				$row['Coupon Code']  = '';	
				}
				if(@$coupon_data->order_id){
                $row['Order Id']  = $coupon_data->order_id;
				}else{
				$row['Order Id']  = '';	
				}
				if(@$coupon_data->start_date){
               	$row['Issue Date']  = $coupon_data->start_date;
				}else{
				$row['Issue Date']  = '';	
				}
				if(@$coupon_data->end_date){
               	$row['Expire Date']  = $coupon_data->end_date;
				}else{
				$row['Expire Date']  = '';	
				}                
				if(@$data->id){
                $row['Coupon Used Order Id']  = $data->id;
				}else{
					$row['Coupon Used Order Id']  = '';
				}
				if(@$coupon_data->price){
               	$row['Coupan Amount']  = $coupon_data->price;
				}else{
				$row['Coupan Amount']  = '';	
				} 
               
				if(@$data->created_at){
                $row['Coupan Used Date']  = date('d-M-Y',strtotime($data->created_at));
				}else{
					$row['Coupan Used Date']  =0;
				}
				if(@$data->pay_amount){
                $row['Order Amount']  = $data->pay_amount;
				}else{
					 $row['Order Amount']  = '';
				}
				if(@$data->pay_amount){
                $row['Net Amount']  = $data->pay_amount- $row['Coupan Amount'];
 				}else{
					 $row['Net Amount']  = '';
				}
                 fputcsv($file, array($row['SL No'] , $row['Coupon Code'],$row['Order Id'], $row['Issue Date'],$row['Expire Date'],$row['Coupon Used Order Id'],$row['Coupan Amount'], $row['Coupan Used Date'],$row['Order Amount'],$row['Net Amount']));
				$j++;
            } 				
			}
            fclose($file);
        };
		

        return response()->stream($callback, 200, $headers);

}
public function unusedcouponcode($status){

    $datas = Order::orderBy('id','desc')->get();
	$fileName = 'unused_coupon.csv';	
		
	$headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );
        
        $coupon_amount=0;
        $coupon_code='-';

        $columns = array('SL No', 'Coupon Code', 'Order Id', 'Issue Date', 'Expire Date', 'Coupon Used Order Id','Coupan Amount','Coupan Used Date','Order Amount','Net Amount');
			$j=1;
			
		$callback = function() use($datas,$columns,$j) {
         $file = fopen('php://output', 'w');
         fputcsv($file, $columns);		 
            foreach ($datas as $data) {
				$coupon_data =Coupon::where('code','!=',$data->coupon_code)->where('order_id','=',$data->id)->first();
				if($coupon_data) {
                $row['SL No']  = $j;
				if(@$coupon_data->code){
                $row['Coupon Code']  = $coupon_data->code;
				}else{
				$row['Coupon Code']  = '';	
				}
				if(@$coupon_data->order_id){
                $row['Order Id']  = $coupon_data->order_id;
				}else{
				$row['Order Id']  = '';	
				}
				if(@$coupon_data->start_date){
               	$row['Issue Date']  = $coupon_data->start_date;
				}else{
				$row['Issue Date']  = '';	
				}
				if(@$coupon_data->end_date){
               	$row['Expire Date']  = $coupon_data->end_date;
				}else{
				$row['Expire Date']  = '';	
				}                
				if(@$data->id){
                $row['Coupon Used Order Id']  = $data->id;
				}else{
					$row['Coupon Used Order Id']  = '';
				}
				if(@$coupon_data->price){
               	$row['Coupan Amount']  = $coupon_data->price;
				}else{
				$row['Coupan Amount']  = '';	
				} 
               
				if(@$data->created_at){
                $row['Coupan Used Date']  = date('d-M-Y',strtotime($data->created_at));
				}else{
					$row['Coupan Used Date']  =0;
				}
				if(@$data->pay_amount){
                $row['Order Amount']  = $data->pay_amount;
				}else{
					 $row['Order Amount']  = '';
				}
				if(@$data->pay_amount){
                $row['Net Amount']  = $data->pay_amount- $row['Coupan Amount'];
 				}else{
					 $row['Net Amount']  = '';
				}
                 fputcsv($file, array($row['SL No'] , $row['Coupon Code'],$row['Order Id'], $row['Issue Date'],$row['Expire Date'],$row['Coupon Used Order Id'],$row['Coupan Amount'], $row['Coupan Used Date'],$row['Order Amount'],$row['Net Amount']));
				$j++;
            }				
			}
            fclose($file);
        };
		

        return response()->stream($callback, 200, $headers);	

}
public function expiredcouponcode($status){	

    $current_date_time = Carbon::now()->toDateTimeString();
    //$datas = Order::where('coupon_code','!=','')->where('created_at','<',$current_date_time)->orderBy('id','desc')->get();
    $datas = Coupon::orderBy('id','desc')->where('end_date','<',$current_date_time)->get();	
	$fileName = 'expired_coupon.csv';	
		
	$headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );
        
        $coupon_amount=0;
        $coupon_code='-';

        $columns = array('SL No', 'Coupon Code', 'Order Id', 'Issue Date', 'Expire Date', 'Coupon Used Order Id','Coupan Amount','Coupan Used Date','Order Amount','Net Amount');
			$j=1;
			
		$callback = function() use($datas,$columns,$j) {
         $file = fopen('php://output', 'w');
         fputcsv($file, $columns);		 
            foreach ($datas as $data) {
				$order_data =Order::where('coupon_code','=',$data->code)->first();
				if(@$order_data->id){
                $row['SL No']  = $j;
                $row['Coupon Code']  = $data->code;
                $row['Order Id']  = $data->order_id;
                $row['Issue Date']  = $data->start_date;
                $row['Expire Date']  = $data->end_date;
				if(@$order_data->id){
                $row['Coupon Used Order Id']  = $order_data->id;
				}else{
					$row['Coupon Used Order Id']  = '';
				}
                $row['Coupan Amount']  = $data->price;
				if(@$order_data->created_at){
                $row['Coupan Used Date']  = date('d-M-Y',strtotime($order_data->created_at));
				}else{
					$row['Coupan Used Date']  = '';
				}
				if(@$order_data->pay_amount){
                $row['Order Amount']  = $order_data->pay_amount;
				}else{
					 $row['Order Amount']  = '';
				}
				if(@$order_data->pay_amount){
                $row['Net Amount']  = $order_data->pay_amount- $data->price;
 				}else{
					 $row['Net Amount']  = '';
				}
                 fputcsv($file, array($row['SL No'] , $row['Coupon Code'],$row['Order Id'], $row['Issue Date'],$row['Expire Date'],$row['Coupon Used Order Id'],$row['Coupan Amount'], $row['Coupan Used Date'],$row['Order Amount'],$row['Net Amount']));
				$j++;
				}				
			}
            fclose($file);
        };
		

        return response()->stream($callback, 200, $headers);

}
	
	}

