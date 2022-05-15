<?php

namespace App\Http\Controllers\Admin;

use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use InvalidArgumentException;
use Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\Order;
use App\Models\Blog;
use App\Models\User;
use App\Models\Product;
use App\Models\Counter;

class RecordController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $pending = Order::where('status','=','pending')->get();
        $processing = Order::where('status','=','processing')->get();
        $completed = Order::where('status','=','completed')->get();
        $days = "";
        $sales = "";
        for($i = 0; $i < 30; $i++) {
            $days .= "'".date("d M", strtotime('-'. $i .' days'))."',";

            $sales .=  "'".Order::where('status','=','completed')->whereDate('created_at', '=', date("Y-m-d", strtotime('-'. $i .' days')))->count()."',";
        }
        $users = User::all();
        $products = Product::all();
        $blogs = Blog::all();
        $pproducts = Product::orderBy('id','desc')->take(5)->get();
        $rorders = Order::orderBy('id','desc')->take(5)->get();
        $poproducts = Product::orderBy('views','desc')->take(5)->get();
        $rusers = User::orderBy('id','desc')->take(5)->get();
        $referrals = Counter::where('type','referral')->orderBy('total_count','desc')->take(5)->get();
        $browsers = Counter::where('type','browser')->orderBy('total_count','desc')->take(5)->get();

        $activation_notify = "";


        return view('admin.dashboard',compact('pending','activation_notify','processing','completed','products','users','blogs','days','sales','pproducts','rorders','poproducts','rusers','referrals','browsers'));
    }
   
	public function record(Request $request)
    {
       
        $startdate =  $request->startdate;
        $enddate = $request->enddate;
        $start = strtotime($startdate);
        $end = strtotime($enddate);
        $daysrange = "";
        $allcustomers ="";$allorders ="";
        $days_between = ceil(abs($end - $start) / 86400);

        


        $pending = Order::where('status','=','pending')->get();
        $processing = Order::where('status','=','processing')->get();
        $completed = Order::where('status','=','completed')->get();
        $days = "";$days30 = "";$daysyear = "";
        $sales = "";$sales30 = "";$salesyear = "";
        $month = date('m');
        $Currentmonthday= date('d');

        $lastmonthdays = date("t", mktime(0,0,0, date("n") - 1));
        for($i = $month-1; $i > -1; $i--) {
            $daysyear .= "'".date("M", strtotime('-'. $i .' months'))."',";

            $salesyear .=  "'".Order::where('status','=','completed')->whereDate('created_at', '=', date("Y-m-d", strtotime('-'. $i .' days')))->count()."',";
        }
        for($i = 0; $i < $Currentmonthday; $i++) {
            $days .= "'".date("d M", strtotime('-'. $i .' days'))."',";

            $sales .=  "'".Order::where('status','=','completed')->whereDate('created_at', '=', date("Y-m-d", strtotime('-'. $i .' days')))->count()."',";
        }
		for($j = $lastmonthdays-1; $j > -1 ; $j--) {
            $days30 .= "'".date("d M", strtotime('-'. $j-$Currentmonthday .' days'))."',";

            $sales30 .=  "'".Order::where('status','=','completed')->whereDate('created_at', '=', date("Y-m-d", strtotime('-'. $j-$Currentmonthday .' days')))->count()."',";
        }
        $days7='';
        $sales7 ='';
        for($j = 0; $j < 7 ; $j++) {
            $days7 .= "'".date("d M", strtotime('-'. $j .' days'))."',";

            $sales7 .=  "'".Order::where('status','=','completed')
                                    ->whereDate('created_at', '=', date("Y-m-d", strtotime('-'. $j .' days')))
                                    ->count()."',";
        }
       
      
        $users = User::all();
        $products = Product::all();
        $blogs = Blog::all();
        $pproducts = Product::orderBy('id','desc')->take(5)->get();
        $rorders = Order::orderBy('id','desc')->take(5)->get();
        $poproducts = Product::orderBy('views','desc')->take(5)->get();
        $rusers = User::orderBy('id','desc')->take(5)->get();
        $referrals = Counter::where('type','referral')->orderBy('total_count','desc')->take(5)->get();
        $browsers = Counter::where('type','browser')->orderBy('total_count','desc')->take(5)->get();

        $activation_notify = "";

        $allorders =  Order::whereBetween('created_at',[$startdate,$enddate])->count();
        $allcustomers =  Order::whereBetween('created_at',[$startdate,$enddate])->count();
        $pay_amount =  Order::whereBetween('created_at',[$startdate,$enddate])->sum('pay_amount');
        $admin_fee =  Order::whereBetween('created_at',[$startdate,$enddate])->sum('admin_fee');
        $totalQty =  Order::whereBetween('created_at',[$startdate,$enddate])->sum('totalQty');
        $shipping_cost =  Order::whereBetween('created_at',[$startdate,$enddate])->sum('shipping_cost');
        $coupon_discount =  Order::whereBetween('created_at',[$startdate,$enddate])->sum('coupon_discount');
        $salesrange='';$daysrange='';
        for($i = 0; $i < $days_between; $i++) {
            $daysrange .= "'".date("d M", strtotime('-'. $i .' days'))."',";

            $salesrange .=  "'".Order::where('status','=','completed')->whereDate('created_at', '=', date("Y-m-d", strtotime('-'. $i .' days')))->count()."',";
        }

        return view('admin.record',compact('start','end','pending','activation_notify','processing','completed','products','users','blogs','days','days30','days7','daysyear','sales','sales30','sales7','salesyear','pproducts','rorders','poproducts','rusers','referrals','browsers','allorders','allcustomers','pay_amount','startdate','enddate','days_between','admin_fee','totalQty','shipping_cost','coupon_discount','daysrange','salesrange'));
    }

    public function profile()
    {
        $data = Auth::guard('admin')->user();
        return view('admin.profile',compact('data'));
    }

    public function profileupdate(Request $request)
    {
        //--- Validation Section

        $rules =
        [
            'photo' => 'mimes:jpeg,jpg,png,svg',
            'email' => 'unique:admins,email,'.Auth::guard('admin')->user()->id
        ];


        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
          return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }
        //--- Validation Section Ends
        $input = $request->all();
        $data = Auth::guard('admin')->user();
            if ($file = $request->file('photo'))
            {
                $name = time().$file->getClientOriginalName();
                $file->move('assets/images/admins/',$name);
                if($data->photo != null)
                {
                    if (file_exists(public_path().'/assets/images/admins/'.$data->photo)) {
                        unlink(public_path().'/assets/images/admins/'.$data->photo);
                    }
                }
            $input['photo'] = $name;
            }
        $data->update($input);
        $msg = 'Successfully updated your profile';
        return response()->json($msg);
    }

    public function passwordreset()
    {
        $data = Auth::guard('admin')->user();
        return view('admin.password',compact('data'));
    }

    public function changepass(Request $request)
    {
        $admin = Auth::guard('admin')->user();
        if ($request->cpass){
            if (Hash::check($request->cpass, $admin->password)){
                if ($request->newpass == $request->renewpass){
                    $input['password'] = Hash::make($request->newpass);
                }else{
                    return response()->json(array('errors' => [ 0 => 'Confirm password does not match.' ]));
                }
            }else{
                return response()->json(array('errors' => [ 0 => 'Current password Does not match.' ]));
            }
        }
        $admin->update($input);
        $msg = 'Successfully change your passwprd';
        return response()->json($msg);
    }



    public function generate_bkup()
    {
        $bkuplink = "";
        $chk = file_get_contents('backup.txt');
        if ($chk != ""){
            $bkuplink = url($chk);
        }
        return view('admin.movetoserver',compact('bkuplink','chk'));
    }


    public function clear_bkup()
    {
        $destination  = public_path().'/install';
        $bkuplink = "";
        $chk = file_get_contents('backup.txt');
        if ($chk != ""){
            unlink(public_path($chk));
        }

        if (is_dir($destination)) {
            $this->deleteDir($destination);
        }
        $handle = fopen('backup.txt','w+');
        fwrite($handle,"");
        fclose($handle);
        //return "No Backup File Generated.";
        return redirect()->back()->with('success','Backup file Deleted Successfully!');
    }

    function setUp($mtFile,$goFileData){
        $fpa = fopen(public_path().$mtFile, 'w');
        fwrite($fpa, $goFileData);
        fclose($fpa);
    }

    public function movescript(){
        ini_set('max_execution_time', 3000);

        $destination  = public_path().'/install';
        $chk = file_get_contents('backup.txt');
        if ($chk != ""){
            unlink(public_path($chk));
        }

        if (is_dir($destination)) {
            $this->deleteDir($destination);
        }

        $src = base_path().'/vendor/update';
        $this->recurse_copy($src,$destination);
        $files = public_path();
        $bkupname = 'GeniusCart-By-GeniusOcean-'.date('Y-m-d').'.zip';

        $zipper = new \Chumper\Zipper\Zipper;

        $zipper->make($bkupname)->add($files);

        $zipper->remove($bkupname);

        $zipper->close();

        $handle = fopen('backup.txt','w+');
        fwrite($handle,$bkupname);
        fclose($handle);

        if (is_dir($destination)) {
            $this->deleteDir($destination);
        }
        return response()->json(['status' => 'success','backupfile' => url($bkupname),'filename' => $bkupname],200);
    }

    public function recurse_copy($src,$dst) {
        $dir = opendir($src);
        @mkdir($dst);
        while(false !== ( $file = readdir($dir)) ) {
            if (( $file != '.' ) && ( $file != '..' )) {
                if ( is_dir($src . '/' . $file) ) {
                    $this->recurse_copy($src . '/' . $file,$dst . '/' . $file);
                }
                else {
                    copy($src . '/' . $file,$dst . '/' . $file);
                }
            }
        }
        closedir($dir);
    }

    public function deleteDir($dirPath) {
        if (! is_dir($dirPath)) {
            throw new InvalidArgumentException("$dirPath must be a directory");
        }
        if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
            $dirPath .= '/';
        }
        $files = glob($dirPath . '*', GLOB_MARK);
        foreach ($files as $file) {
            if (is_dir($file)) {
                self::deleteDir($file);
            } else {
                unlink($file);
            }
        }
        rmdir($dirPath);
    }



}
