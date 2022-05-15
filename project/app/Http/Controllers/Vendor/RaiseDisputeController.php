<?php
namespace App\Http\Controllers\Vendor;

use App\Classes\GeniusMailer;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Admin;
use App\Models\User;
use App\Models\VendorOrder;
use App\Models\Product;
use App\Models\RaiseDispute;
use DB;
use Datatables;
use Auth;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;


class RaiseDisputeController extends Controller
{
   	public function __construct()
    {
        $this->middleware('auth');
    }
	
	//*** JSON Request
    public function datatables($status){
        $user = Auth::user();
		$status = (!empty($_GET["status"])) ? ($_GET["status"]) : ('');
       
        $datas = RaiseDispute::where('vendor_id','=',$user->id)->orderBy('id','desc')->get();
			
		$query = RaiseDispute::select('*');
            if(!empty($user))
                $query->where('vendor_id','=',$user->id);
            if(!empty($status))
                $query->where('status','=',$status);           			
        $datas=$query->where('status','=','resolved')->orderBy('id','desc')->get();
		
         
         //--- Integrating This Collection Into Datatables
         return Datatables::of($datas)
                            
							 ->editColumn('id',function(RaiseDispute $data){
                                $id = $data->id;
                                return  $id;
                            }) 	             
                            	
                            
							->editColumn('vendor_name', function(RaiseDispute $data) {
								$users = User::find($data->vendor_id);
                                return $users->name;
                            })
                            ->editColumn('order_data', function(RaiseDispute $data) {
								$order_data = Order::find($data->order_id);                                
								$order_id = '<a href="'.route('vendor-order-vshow',$order_data->order_number).'">'.$data->order_id.'</a>';
                                return $order_id; 
                            })
                            
							->editColumn('product_name', function(RaiseDispute $data) {
							    return $data->product_name;
                            })
                            ->editColumn('product_sku', function(RaiseDispute $data) {
							    return $data->product_sku;
                            })	
                            ->editColumn('amount', function(RaiseDispute $data) {
							    return $data->amount;
                            })
                            ->editColumn('quantity', function(RaiseDispute $data) {
							    return $data->quantity;
                            })
                            ->editColumn('status', function(RaiseDispute $data) {
								return $data->status;							
                            })			
							
							
							 ->editColumn('created_at', function(RaiseDispute $data) {
								return $data->created_at;
                            }) 
                       ->editColumn('action', function(RaiseDispute $data) {								
								$action = '<div class="godropdown"><button class="go-dropdown-toggle"> Actions<i class="fas fa-chevron-down"></i></button>
                                <div class="action-list"><a href="'.route('vendor-raise-show',$data->id).'"><i class="fa fa-eye"></i>Details</a>
									 </div>
                                </div>';
								return $action;
							
                            })	
                            
                            ->rawColumns(['order_data','product_name','product_sku','created_at','action'])
                            ->toJson(); 
    }

    public function index()
    {
        $user = Auth::user();
        $raisedispute = RaiseDispute::where('vendor_id','=',$user->id)->orderBy('id','desc')->get();
		$pending__count = RaiseDispute::where('vendor_id','=',$user->id)->where('status','=','open')->orderBy('id','desc')->count('id');
		return view('vendor.raisedispute.index',compact('user','raisedispute','pending__count'));
    }
	public function show($id)
    {
		$data = RaiseDispute::where('id','=',$id)->first();
		return view('vendor.raisedispute.details',compact('data'));
		
	}
	
	 public function export($status){    		 
	 
	$user = Auth::user(); 
	$datas = VendorOrder::where('user_id','=',$user->id)->where('ref_status','=',1)->orderBy('id','desc')->get();	
	$fileName = 'refundorder.csv';	
		
	$headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        $columns = array('Order No','Order Date','Vendor Name','Product Name', 'Product Sku','Amount', 'Quantity', 'Refund Quantity', 'Refund Amount', 'Refund Date');
       	$j=1;
		$callback = function() use($datas, $columns,$j) {
         $file = fopen('php://output', 'w');
         fputcsv($file, $columns);		 
            foreach ($datas as $data) {
			
				
                $row['Order No']  = $data->order_number;
				if(@$data->created_at){				
				 $row['Order Date']    = $data->created_at;
				}else{
					 $row['Order Date']    = '';
				}			    				
				$users_name = User::all()->where('is_vendor','2')->where('id',$data->user_id)->pluck('shop_name')->implode(',');
                $row['Vendor Name']    = $users_name; 
				$productdata = Product::where('id',$data->product_id)->first();
				$row['Product Name']    = $productdata->name; 
				$row['Product Sku']    = $productdata->sku; 
				$row['Amount']    = $data->price; 
				$row['Quantity']    = $data->qty; 
				$row['Refund Quantity']    = $data->product_item_qty; 
				$row['Refund Amount']    = $data->product_item_price;
                $refund_date = RaiseDispute::where('order_id',$data->order_id)->where('vendor_id',$data->user_id)->where('product_id',$data->product_id)->first();
                if(@$refund_date->created_at){				
				$row['Refund Date']    = $refund_date->created_at;
				}else{
					$row['Refund Date']    = '';
				}				
                fputcsv($file, array($row['Order No'],$row['Order Date'],$row['Vendor Name'],$row['Product Name'],$row['Product Sku'],$row['Amount'],$row['Quantity'],$row['Refund Quantity'],$row['Refund Amount'],$row['Refund Date']));
				$j++;
		
			}
            fclose($file);
        };
		

        return response()->stream($callback, 200, $headers);
	}
	

}