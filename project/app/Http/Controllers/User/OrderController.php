<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Models\Order;
use App\Models\OrderTrack;
use App\Models\Product;
use App\Models\PaymentGateway;
use App\Models\Rating;
use App\Models\Refund;
use App\Models\Exchange;
use App\Models\RaiseDispute;

class OrderController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function orders()
    {
        $user = Auth::guard('web')->user();
        $orders = Order::where('user_id','=',$user->id)->orderBy('id','desc')->get();
        return view('user.order.index',compact('user','orders'));
    }
   public function refunds()
    {
        $user = Auth::guard('web')->user();
        $refund = RaiseDispute::where('user_id','=',$user->id)->where('status','=','resolved')->orderBy('id','desc')->get();		
        return view('user.refunds.index',compact('user','refund'));
    }
	public function exchange()
    {
        $user = Auth::guard('web')->user();
        $exchange =  Exchange::where('user_id','=',$user->id)->where('status','=','resolved')->orderBy('id','desc')->get();
        return view('user.exchange.index',compact('user','exchange'));
    }
    public function ordertrack()
    {
        $user = Auth::guard('web')->user();
        return view('user.order-track',compact('user'));
    }

    public function trackload($id)
    {
        $order = Order::where('order_number','=',$id)->first();
        $datas = array('Pending','Processing','On Delivery','Completed');
        return view('load.track-load',compact('order','datas'));

    }

    public function trackload2($id)
    {
        $order = OrderTrack::where('order_id','=',$id)->first();
        //$datas = array('Pending','Processing','On Delivery','Completed');
        return view('load.track-load2',compact('order'));

    }


    public function order($id)
    {
        
        $user = Auth::guard('web')->user();

        $order = Order::findOrfail($id);
        $cart = unserialize(bzdecompress(utf8_decode($order->cart)));

        foreach($cart->items as $product){
            $product_id= $product['item']['id'];
        }
        
     
        $prev = Rating::where('product_id','=',$product_id)->where('user_id','=',$user->id)->get();
        $refundcreated = Refund::where('order_id','=',$id)->where('user_id','=',$user->id)->get();
        return view('user.order.details',compact('user','order','cart','prev','refundcreated'));
    }
	public function userrefund($id)
    {
		$user = Auth::guard('web')->user();
		$data = RaiseDispute::where('id','=',$id)->first();
		return view('user.refunds.details',compact('user','data'));
		
	}
	public function userexchanges($id)
    {
		$user = Auth::guard('web')->user();
		$data = Exchange::where('id','=',$id)->first();
		return view('user.exchange.details',compact('user','data'));
		
	}

    public function orderdownload($slug,$id)
    {
        $user = Auth::guard('web')->user();
        $order = Order::where('order_number','=',$slug)->first();
        $prod = Product::findOrFail($id);
        if(!isset($order) || $prod->type == 'Physical' || $order->user_id != $user->id)
        {
            return redirect()->back();
        }
        return response()->download(public_path('assets/files/'.$prod->file));
    }

    public function orderprint($id)
    {
        $user = Auth::guard('web')->user();
        $order = Order::findOrfail($id);
        $cart = unserialize(bzdecompress(utf8_decode($order->cart)));
        return view('user.order.print',compact('user','order','cart'));
    }

    public function trans()
    {
        $id = $_GET['id'];
        $trans = $_GET['tin'];
        $order = Order::findOrFail($id);
        $order->txnid = $trans;
        $order->update();
        $data = $order->txnid;
        return response()->json($data);            
    }  

}
