<?php
namespace App\Http\Controllers\Vendor;

use App\Classes\GeniusMailer;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Admin;
use App\Models\User;
use App\Models\VendorOrder;
use App\Models\Product;
use App\Models\DebitNote;
use DB;
use Datatables;
use Auth;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;


class DebitNoteController extends Controller
{
   	public function __construct()
    {
        $this->middleware('auth');
    }
	
	//*** JSON Request
    public function datatables($status){
        $user = Auth::user();
		$status = (!empty($_GET["status"])) ? ($_GET["status"]) : ('');
       
        $datas = DebitNote::where('vendor_id','=',$user->id)->orderBy('id','desc')->get();
			
		$query = DebitNote::select('*');
            if(!empty($user))
                $query->where('vendor_id','=',$user->id);
            if(!empty($status))
                $query->where('status','=',$status);           			
        $datas=$query->orderBy('id','desc')->get();
		
         
         //--- Integrating This Collection Into Datatables
         return Datatables::of($datas)
                            
							 ->editColumn('id',function(DebitNote $data){
                                $id = $data->id;
                                return  $id;
                            }) 	             
                            	
                            
							->editColumn('vendor_name', function(DebitNote $data) {
								$users = User::find($data->vendor_id);
                                return $users->name;
                            })
                            ->editColumn('order_data', function(DebitNote $data) {
								$order_data = Order::find($data->order_id);                                
								$order_id = '<a href="'.route('vendor-order-vshow',$order_data->order_number).'">'.$data->order_id.'</a>';
                                return $order_id;  
                            })
                            
							->editColumn('product_name', function(DebitNote $data) {
							    return $data->product_name;
                            })
                            ->editColumn('product_sku', function(DebitNote $data) {
							    return $data->product_sku;
                            })	
                            ->editColumn('amount', function(DebitNote $data) {
							    return $data->amount;
                            })
                            ->editColumn('quantity', function(DebitNote $data) {
							    return $data->quantity;
                            })
							->editColumn('withdraw_data',function(DebitNote $data){
                                $withdraw_data = $data->withdraw_id;
                                return  $withdraw_data;
                            }) 	
                            ->editColumn('status', function(DebitNote $data) {
								return $data->status;							
                            })			
							
							
							 ->editColumn('created_at', function(DebitNote $data) {
								return $data->created_at;
                            }) 
                       ->editColumn('action', function(DebitNote $data) {								
								$action = '<div class="godropdown"><button class="go-dropdown-toggle"> Actions<i class="fas fa-chevron-down"></i></button>
                                <div class="action-list"><a href="'.route('vendor-debit-show',$data->id).'"><i class="fa fa-eye"></i>Details</a>
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
        $debitnote = DebitNote::where('vendor_id','=',$user->id)->orderBy('id','desc')->get();
		$pending__count = DebitNote::where('vendor_id','=',$user->id)->where('status','=',0)->orderBy('id','desc')->count('id');
        return view('vendor.debitnote.index',compact('user','debitnote','pending__count'));
    }
	public function show($id)
    {
		$data = DebitNote::where('id','=',$id)->first();
		return view('vendor.debitnote.details',compact('data'));
		
	}
	
	public function export($status){ 
      	
	$user = Auth::user(); 
	$datas = DebitNote::where('vendor_id','=',$user->id)->orderBy('id','desc')->get();	
	$fileName = 'debit.csv';	
		
	$headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        $columns = array('Order No','Order Date','Vendor Name','Product Name', 'Product Sku','Amount', 'Quantity', 'Payment Status', 'Withdraw ID', 'Debit Date');
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
				$row['Debit Date']    = $data->created_at;
				}else{
					$row['Debit Date']    = '';
				}				
                fputcsv($file, array($row['Order No'],$row['Order Date'],$row['Vendor Name'],$row['Product Name'],$row['Product Sku'],$row['Amount'],$row['Quantity'],$row['Payment Status'],$row['Withdraw ID'],$row['Debit Date']));
				$j++;
		
			}
            fclose($file);
        };
		

        return response()->stream($callback, 200, $headers);
	}	
	

}