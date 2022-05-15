<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderTrack;
use App\Models\Notification;
use App\Models\Generalsetting;
use Illuminate\Support\Facades\Input;
use Validator;


use App\Classes\GeniusMailer;


class OrderTrackController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }


   //*** GET Request
    public function index($id)
    {
        $order = Order::findOrFail($id);
        return view('admin.order.track',compact('order'));
    }

   //*** GET Request
    public function load($id)
    {
        $order = Order::findOrFail($id);
        return view('admin.order.track-load',compact('order'));
    }


    public function add()
    {


        //--- Logic Section

        $title = $_GET['title'];

        $ck = OrderTrack::where('order_id','=',$_GET['id'])->where('title','=',$title)->first();
        if($ck){
            $ck->order_id = $_GET['id'];
            $ck->title = $_GET['title'];
            $ck->text = $_GET['text'];
            $ck->companyname = $_GET['companyname'];
            $ck->update();  
        }
        else {
            $data = new OrderTrack;
            $data->order_id = $_GET['id'];
            $data->title = $_GET['title'];
            $data->text = $_GET['text'];
            $data->companyname = $_GET['companyname'];
            $data->save();            
        }


        //--- Logic Section Ends


    }


    //*** POST Request
    public function store(Request $request){      
        $id= $request->order_id;
        $dataorder = Order::where('id','=',$request->order_id)->first();
        
        $updateStatus = Order::findOrFail($id);
        $updateStatus->status = 'on delivery';
        $updateStatus->update();
        
        $msg ='Your Order has been shipped.';
       
        if(!empty($request->title)){
            $msg .='<br> Code : '. $request->title;
        }else{
            $msg .='';
        }
        if(!empty($request->companyname)){    
            $msg .='<br>  Company Name : '. $request->companyname;
        }else{
            $msg .='';
        }
        if(!empty($request->text)){    
            $msg .='<br>  URL : <a href='.$request->text.' target="_BLANK">'. $request->text.'</a>';
        }else{
            $msg .='';
        }
    
        $notification = new Notification;
        $notification->order_id = $id;
        $notification->message = htmlentities($msg);
        $notification->save();

         /*$gs = Generalsetting::findOrFail(1);
        if($gs->is_smtp == 1){
            $messagesent = $dataorder->customer_name.'/'.$request->title.'/'.$request->companyname.'/'.$request->text;
            $maildata = [
                 'to' => $dataorder->customer_email,
                 'subject' => 'Your order '.$dataorder->order_number.' is Shipped!',
                 'body' => "Hello ".$messagesent.","."\n Thank you for shopping with us. We are looking forward to your next visit.",
             ];

             $mailer = new GeniusMailer();
          $mailer->sendCustomMail($maildata);                
        }else{
           $to = $dataorder->customer_email;
            $subject = 'Your order '.$dataorder->order_number.' is Confirmed!';
           $msg = "Hello ".$dataorder->customer_name.","."\n Thank you for shopping with us. We are looking forward to your next visit.";
             $headers = "From: ".$gs->from_name."<".$gs->from_email.">";
           mail($to,$subject,$msg,$headers);                
         }*/
       
        $title = $request->title;
        $ck = OrderTrack::where('order_id','=',$request->order_id)->where('title','=',$title)->first();
        if($ck) {
            $ck->order_id = $request->order_id;
            $ck->title = $request->title;
            $ck->text = $request->text;
            $ck->companyname = $request->companyname;
            $ck->update();
$order_track = DB::table('order_tracks')->orderBy('id', 'DESC')->first();
			$gs = Generalsetting::findOrFail(1);
        if($gs->is_smtp == 1){
            $messagesent = $dataorder->customer_name.'/'.$request->title.'/'.$request->companyname.'/'.$request->text;
            $maildata = [
                 'to' => $dataorder->customer_email,
                 'subject' => 'Your order '.$dataorder->order_number.' is Shipped!',
                 'body' => "Hi ".$dataorder->customer_name.","."\n Your recent order on South India Jewels has been shipped. Your order details are shown below for your reference:Your order was shipped via DTDC India
                                   Tracking number is ".$order_track->id." Thanks for using ".url('/')."! Your order will be shipped in 3 to 5 business days. You can track your order here after the product is shipped https://shop.southindiajewels.com/orders-tracking/.
                                   Customer Care Numbers : +91 9150724959, +91 6385114590",
             ];

             $mailer = new GeniusMailer();
          $mailer->sendCustomMail($maildata);                
        }else{
           $to = $dataorder->customer_email;
            $subject = 'Your order '.$dataorder->order_number.' is Confirmed!';
           $msg = "Hi ".$dataorder->customer_name.","."\n Your recent order on South India Jewels has been shipped. Your order details are shown below for your reference:Your order was shipped via DTDC India
                                   Tracking number is ".$order_track->id." Thanks for using ".url('/')."! Your order will be shipped in 3 to 5 business days. You can track your order here after the product is shipped https://shop.southindiajewels.com/orders-tracking/.
                                   Customer Care Numbers : +91 9150724959, +91 6385114590";
             $headers = "From: ".$gs->from_name."<".$gs->from_email.">";
           mail($to,$subject,$msg,$headers);                
         }
			

            $msg = 'Data Updated Successfully if.';
            return response()->json($msg); 
        }else {
            $data = new OrderTrack;
            $input = $request->all();
            $data->fill($input)->save();  
            $msg = 'New Data Added Successfully else.';            
        }
        return response()->json($msg);      
    }


    //*** POST Request
    public function update(Request $request, $id)
    {
        //--- Validation Section
        $rules = ['title' => 'unique:order_tracks,title,'.$id];
        $customs = ['title.unique' => 'This title has already been taken.', ];
        $validator = Validator::make(Input::all(), $rules, $customs);
        if ($validator->fails()) {
          return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }
        //--- Validation Section Ends

        //--- Logic Section
        $data = OrderTrack::findOrFail($id);
        
        
        $input = $request->all();
        
        
        $data->update($input);
        //--- Logic Section Ends

        //--- Redirect Section          
        $msg = 'Data Updated Successfully2.';
        return response()->json($msg);    
        //--- Redirect Section Ends  

    }

    //*** GET Request
    public function delete($id)
    {
        $data = OrderTrack::findOrFail($id);
        $data->delete();
        //--- Redirect Section     
        $msg = 'Track Detail Deleted Successfully.';
        return response()->json($msg);      
        //--- Redirect Section Ends   
    }

}
