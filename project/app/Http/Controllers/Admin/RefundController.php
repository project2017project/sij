<?php

namespace App\Http\Controllers\Admin;

use App\Classes\GeniusMailer;
use App\Http\Controllers\Controller;
use App\Models\Generalsetting;
use App\Models\Order;
use App\Models\Refund;
use App\Models\Product;
use App\Models\OrderTrack;
use App\Models\User;
use App\Models\VendorOrder;
use App\Models\Notification;
use Datatables;
use PDF;
use Illuminate\Http\Request;
use DB;

class RefundController extends Controller{
    public function __construct(){
        $this->middleware('auth:admin');
    }
    public function datatables()
    {
        
          $statusare = (!empty($_GET["statusare"])) ? ($_GET["statusare"]) : ('');
         
		  $svendor = (!empty($_GET["svendor"])) ? ($_GET["svendor"]) : ('');
       
		if(!empty($statusare) || !empty($svendor)){	
		
								
			$query =  Refund::orderBy('id','desc');										
					if(!empty($statusare))
						$query->where('statusare',$statusare);						
					if(!empty($svendor))
						$query->where('sold_by',$svendor);	
			$datas = $query->get();		
					
					
        }else{
            $datas = Refund::get(); 
        }
		 
		return Datatables::of($datas)
				->editColumn('id', function(Refund $data) {$id = $data->id;return $id;})
				->editColumn('orderId', function(Refund $data) {$order_id = $data->order_id;return $order_id;})
				->editColumn('soldby', function(Refund $data) {$sold_by = $data->userrefund->shop_name;return $sold_by;})
				->editColumn('amount', function(Refund $data) {$amount = $data->amount;return $amount;})					
				->editColumn('image', function(Refund $data) {$url= asset('assets/images/refund/'.$data->image); $image = "<img src='".$url."'>";return $image;})
				->editColumn('product_id', function(Refund $data) {
						$product_id = $data->product_id;
						$productName = Product::where('id','=',$product_id)->first();						
						return $productName->name;
					})
				->editColumn('adminMessage', function(Refund $data) {
					
					if(!empty($data->adminMessage)){
						$adminMessage = $data->adminMessage;
					}else{
						$adminMessage = "No Comments Yet.";
					}
					return $adminMessage;
				})
				->editColumn('reason', function(Refund $data) {$reason = $data->reason;return $reason;})
				->editColumn('statusare', function(Refund $data) {
						return $data->statusare;
					})
				->addColumn('action', function(Refund $data) {
						if($data->statusare!='requested'){
							$action='';
						}else{
								$action = '<div class="action-list"><a data-href="' . route('admin-refund-addnote',$data->id) . '" class="addnote" data-toggle="modal" data-target="#modal3">Add Message</a>
						</div>';
							}

                        return $action;
					})
				->editColumn('created_at', function(Refund $data) {$created_at = $data->created_at;return $created_at;})
				->editColumn('customerName', function(Refund $data) {$user_name = $data->user_name;return $user_name;})
				->rawColumns(['id','orderId','sold_by','amount','reason','customerName','created_at','statusare','product_id','image','action','adminMessage'])
				->toJson(); 
    }
    public function index()
    {
    	$users = User::all()->where('is_vendor','2');
        return view('admin.refund.index',compact('users'));
    }
	//*** GET Request
    public function status($id1,$id2)
    {
        $data = Refund::findOrFail($id1);
        $data->status = $id2;
        $data->update();
    }
	//*** GET Request
    public function addnote($id)
    {
            $data = Refund::findOrFail($id);
            return view('admin.refund.addnote',compact('data'));
    }
	
	//*** POST Request
    public function addnotesubmit(Request $request, $id)
    {
		//-- Logic Section
        $data = Refund::findOrFail($id);
        $input = $request->all();       
        if($request->adminMessage == ""){
        	$input['adminMessage'] = null;
        }
        $data->update($input);
        $msg = 'Message add Successfully.';
        return response()->json($msg);
        
	}
}