<?php

namespace App\Http\Controllers\Admin;
use Datatables;
use App\Models\Notify;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Classes\GeniusMailer;
use App\Models\Generalsetting;
class NotifyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    //*** JSON Request
    public function datatables()
    {
         $datas = Notify::orderBy('id')->get();

         //--- Integrating This Collection Into Datatables
         return Datatables::of($datas)
                            ->addColumn('sl', function(Notify $data) {
                                $id = 1;
                                return $id++;
                            })
                            
                            ->editColumn('product',function(Notify $data){
                                $pname = Product::where('id','=',$data->product_id)->first();
                                $product = $pname->name;
                                return  $product;
                            })
                            ->addColumn('status', function(Notify $data) {
                                $ids = $data->status;
                                if($ids == '0'){
                                    $id='No Sent';
                                }else{
                                    $id="   Sent";    
                                }
                                return $id;
                            })
                            ->rawColumns(['sl','productname','status'])
                            ->toJson();//--- Returning Json Data To Client Side
    }

    //*** GET Request
    public function index()
    {
        return view('admin.notify.index');
    }
    //*** GET Request
    public function download()
    {
        //  Code for generating csv file
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=notify.csv');
        $output = fopen('php://output', 'w');
        fputcsv($output, array('Notify Emails'));
        $result = Notify::all();
        foreach ($result as $row){
            fputcsv($output, $row->toArray());
        }
        fclose($output);
    }
    public function sentnofication(){


        $result = Notify::select('notifies.id as notifiesid','notifies.status as notifiesStatus','notifies.email as sentemail','products.stock as productstock','products.name as productname','products.slug as productslug','products.thumbnail as productphoto')->leftjoin('products','products.id','=','notifies.product_id')->where('notifies.status','=','0')->where('products.stock','!=','0')->get();
        $count = count($result);
        if($count > 0){           
            foreach ($result as $row){
                $url = url("/item/");
                $imageurl = url("/assets/images/thumbnails/");
                $productphoto=$row->productphoto;
                $imageviewurl = $imageurl."/".$productphoto;
                $message ="Product Name ".$row->productname." Product URL : ".$url."/".$row->productslug."Product Image :<img src=".$imageviewurl.">".$imageviewurl;
                $to = $row->sentemail;
                $subject = "Product In Stock Now";
                $from = 'admin@southindiajewels.com';
                $msg = "Email: ".$from."<br>Message: ".$message;
                $gs = Generalsetting::findOrFail(1);
                if($gs->is_smtp == 1){
                    $datas = [
                        'to' => $to,
                        'subject' => $subject,
                        'body' => $msg,
                    ];
                    $mailer = new GeniusMailer();
                    $mailer->sendCustomMail($datas);
                }

                $upate = Notify::where('id', '=', $row->notifiesid)
                            ->update(array('status' => 1));

            }
        }else{
            echo "NO Record Found";
        }        
    }
}
