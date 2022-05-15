<?php

namespace App\Http\Controllers\Vendor;

use Datatables;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Generalsetting;
use App\Models\Subcategory;
use App\Models\VendorOrder;
use App\Models\Verification;
use App\Models\Withdraw;
use App\Models\Currency;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Input;
use Session;
use Validator;

class VendorController extends Controller
{

    public $lang;
    public function __construct()
    {

        $this->middleware('auth');

            if (Session::has('language')) 
            {
                $data = DB::table('languages')->find(Session::get('language'));
                $data_results = file_get_contents(public_path().'/assets/languages/'.$data->file);
                $this->lang = json_decode($data_results);
            }
            else
            {
                $data = DB::table('languages')->where('is_default','=',1)->first();
                $data_results = file_get_contents(public_path().'/assets/languages/'.$data->file);
                $this->lang = json_decode($data_results);
                
            } 
    }

    //*** GET Request
    public function index()
    {
        $user = Auth::user();  
        $pending = VendorOrder::where('user_id','=',$user->id)->where('status','=','pending')->get(); 
         
        $processing = VendorOrder::where('user_id','=',$user->id)->where('status','=','processing')->get(); 
        $completed = VendorOrder::where('user_id','=',$user->id)->where('status','=','completed')->get(); 
        return view('vendor.index',compact('user','pending','processing','completed'));
    }

    public function profileupdate(Request $request)
    {
        //--- Validation Section
        $rules = [
               'shop_image'  => 'mimes:jpeg,jpg,png,svg',
                ];

        $validator = Validator::make(Input::all(), $rules);
        
        if ($validator->fails()) {
          return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }
        //--- Validation Section Ends

          
        $data = Auth::user();    
        $input['owner_name'] = $request->owner_name;
        if ($file = $request->file('shop_image')) 
         {      
            $name = time().$file->getClientOriginalName();
            $file->move('assets/images/vendorbanner',$name);           
            $input['shop_image'] = $name;
        }
        
        if ($file = $request->file('shop_logo')) 
         {      
            $name = time().$file->getClientOriginalName();
            $file->move('assets/images/users/',$name);           
            $input['shop_logo'] = $name;
        }

        $data->update($input);
        $msg = 'Successfully updated your profile';
        return response()->json($msg); 
    }

    // Spcial Settings All post requests will be done in this method
    public function socialupdate(Request $request)
    {
        //--- Logic Section
        $input = $request->all(); 
        $data = Auth::user();   
        if ($request->f_check == ""){
            $input['f_check'] = 0;
        }
        if ($request->t_check == ""){
            $input['t_check'] = 0;
        }

        if ($request->g_check == ""){
            $input['g_check'] = 0;
        }

        if ($request->l_check == ""){
            $input['l_check'] = 0;
        }
        $data->update($input);
        //--- Logic Section Ends
        //--- Redirect Section        
        $msg = 'Data Updated Successfully.';
        return response()->json($msg);      
        //--- Redirect Section Ends                

    }

    //*** GET Request
    public function profile()
    {
        $data = Auth::user();  
        return view('vendor.profile',compact('data'));
    }

    //*** GET Request
    public function ship()
    {
        $gs = Generalsetting::find(1);
        if($gs->vendor_ship_info == 0) {
            return redirect()->back();
        }
        $data = Auth::user();  
        return view('vendor.ship',compact('data'));
    }

    //*** GET Request
    public function banner()
    {
        $data = Auth::user();  
        return view('vendor.banner',compact('data'));
    }

    //*** GET Request
    public function social()
    {
        $data = Auth::user();  
        return view('vendor.social',compact('data'));
    }

    //*** GET Request
    public function subcatload($id)
    {
        $cat = Category::findOrFail($id);
        return view('load.subcategory',compact('cat'));
    }

    //*** GET Request
    public function childcatload($id)
    {
        $subcat = Subcategory::findOrFail($id);
        return view('load.childcategory',compact('subcat'));
    }

    //*** GET Request
    public function verify()
    {
        $data = Auth::user();  
        if($data->checkStatus())
        {
            return redirect()->back();
        }
        return view('vendor.verify',compact('data'));
    }

    //*** GET Request
    public function warningVerify($id)
    {
        $verify = Verification::findOrFail($id);
        $data = Auth::user();  
        return view('vendor.verify',compact('data','verify'));
    }

    //*** POST Request
    public function verifysubmit(Request $request)
    {
        //--- Validation Section
        $rules = [
          'attachments.*'  => 'mimes:jpeg,jpg,png,svg,pdf,doc,docs|max:10000'
           ];
        $customs = [
            'attachments.*.mimes' => 'Only jpeg, jpg, png and svg images are allowed',
            'attachments.*.max' => 'Sorry! Maximum allowed size for an image is 10MB',
                   ];

        $validator = Validator::make(Input::all(), $rules,$customs);
        
        if ($validator->fails()) {
          return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }
        //--- Validation Section Ends

        $data = new Verification();
        $input = $request->all();

        $input['attachments'] = '';
        $i = 0;
                if ($files = $request->file('attachments')){
                    foreach ($files as  $key => $file){
                        $name = time().$file->getClientOriginalName();
                        if($i == count($files) - 1){
                            $input['attachments'] .= $name;
                        }
                        else {
                            $input['attachments'] .= $name.',';
                        }
                        $file->move('assets/images/attachments',$name);

                    $i++;
                    }
                }
        $input['status'] = 'Pending';        
        $input['user_id'] = Auth::user()->id;
        if($request->verify_id != '0')
        {
            $verify = Verification::findOrFail($request->verify_id);
            $input['admin_warning'] = 0;
            $verify->update($input);
        }
        else{

            $data->fill($input)->save();
        }

        //--- Redirect Section        
        $msg = '<div class="text-center"><i class="fas fa-check-circle fa-4x"></i><br><h3>'.$this->lang->lang804.'</h3></div>';
        return response()->json($msg);      
        //--- Redirect Section Ends     
    }
	 public function withdrawdatatables()
        {
		 $user = Auth::user();
         $statuswwithdraw = (!empty($_GET["statuswwithdraw"])) ? ($_GET["statuswwithdraw"]) : '';
		
       $query = Withdraw::where('type','=','vendor');
	   $query->where('user_id','=',$user->id);
       if(!empty($statuswwithdraw)){
          $query->where('status','=',$statuswwithdraw);
		  $datas = $query->orderBy('id','desc')->get();	
					
        }else{
            $datas = Withdraw::where('type','=','vendor')->where('user_id','=',$user->id)->orderBy('id','desc')->get();   
        }
       return Datatables::of($datas)
                                ->addColumn('name', function(Withdraw $data) {
                                    $name = $data->user->name;
                                    return '<a href="' . route('admin-vendor-show',$data->user->id) . '" target="_blank">'. $name .'</a>';
                                }) 
                                ->addColumn('id', function(Withdraw $data) {
                                    $id = $data->id;
                                    return '#'.$id;
                                })
                                ->addColumn('email', function(Withdraw $data) {
                                    $email = $data->user->email;
                                    return $email;
                                })
                                /*->addColumn('shop_name', function(Withdraw $data) {
                                    $shopname = $data->user->shop_name;
                                    return $shopname;
                                })*/
                                ->addColumn('phone', function(Withdraw $data) {
                                    $phone = $data->user->phone;
                                    return $phone;
                                }) 
                                ->editColumn('status', function(Withdraw $data) {
                                    $status = ucfirst($data->status);
                                    return $status;
                                }) 
                                ->editColumn('amount', function(Withdraw $data) {
                                    $sign = Currency::where('is_default','=',1)->first();
                                    $amount = $sign->sign.round($data->amount * $sign->original_val , 2);
                                    return $amount;
                                }) 
                                ->addColumn('action', function(Withdraw $data) {                                    
									$action = '<div class="action-list">
									<a href="' . route('vendor-withdraw-shows',$data->id) . '" 
									class="view details-width"> <i class="fas fa-eye"></i> Details</a>';                                  
                                    $action .= '</div>';
                                    return $action;
                                }) 
                                ->rawColumns(['name','action'])
                                ->toJson(); //--- Returning Json Data To Client Side
        }
		
		 //*** GET Request
        public function withdraws()
        {
            return view('vendor.withdraw.withdraws');
        }  
		//*** GET Request       
        public function withdrawdetails($id)
        {
            $sign = Currency::where('is_default','=',1)->first();
            $withdraw = Withdraw::findOrFail($id);
            return view('vendor.withdraw.withdraw-details',compact('withdraw','sign'));
        }

public function withdrawpendinglist($status){

    $user = Auth::user();	 
	//$datas = Withdraw::where('type','=','vendor')->where('user_id','=',$user->id)->where('status','pending')->orderBy('id','desc')->get();
	$datas = Withdraw::where('type','=','vendor')->where('user_id','=',$user->id)->orderBy('id','desc')->get();
	$fileName = 'withdraw.csv';	
		
	$headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        $columns = array('Withdraw ID', 'Order Id', 'Amount', 'SGST', 'CGST', 'IGST', 'TCS', 'Net Payable','Payment Method', 'Date');
       	$j=1;
		$callback = function() use($datas, $columns,$j) {
         $file = fopen('php://output', 'w');
         fputcsv($file, $columns);		 
            foreach ($datas as $data) {
			
				
              $row['Withdraw ID']  = $data->id;
			  $row['Order Id']    = $data->group_order_id; 
				/*$users_name = User::all()->where('is_vendor','2')->where('id',$data->user_id)->pluck('shop_name')->implode(',');
                $row['Vendor Name']    = $users_name;*/
				$row['Amount']    = $data->withdrawal_amount; 
				$row['SGST']    = $data->sgst; 
				$row['CGST']    = $data->cgst; 
				$row['IGST']    = $data->igst; 
				$row['TCS']    = $data->tcs; 
				$row['Net Payable']    = $data->amount; 
				$row['Payment Method']    = $data->method; 
				$row['Date']    = date('d-M-Y',strtotime($data->created_at)); 
                fputcsv($file, array($row['Withdraw ID'],$row['Order Id'],$row['Amount'],$row['SGST'],$row['CGST'],$row['IGST'],$row['TCS'],$row['Net Payable'],$row['Payment Method'],$row['Date']));
				$j++;
		
			}
            fclose($file);
        };
		

        return response()->stream($callback, 200, $headers);
	}		
	

}
