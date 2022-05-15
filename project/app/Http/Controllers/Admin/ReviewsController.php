<?php

namespace App\Http\Controllers\Admin;

use Datatables;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Rating;

class ReviewsController extends Controller
{
	public function __construct()
	    {
	        $this->middleware('auth:admin');
	    }

	    //*** JSON Request
	    public function datatables()
	    {
	         $datas = Rating::orderBy('id')->get();
	         //--- Integrating This Collection Into Datatables
	         return Datatables::of($datas)
	                            ->addColumn('product', function(Rating $data) {
	                                $name = mb_strlen(strip_tags($data->product->name),'utf-8') > 50 ? mb_substr(strip_tags($data->product->name),0,50,'utf-8').'...' : strip_tags($data->product->name);
	                                $product = '<a href="'.route('front.product',$data->product->slug).'" target="_blank">'.$name.'</a>';
	                                return $product;
	                            })
	                            ->addColumn('username', function(Rating $data) {
	                                $name = $data->user->name;
	                                return $name;
	                            })
	                            ->addColumn('userreview', function(Rating $data) {
	                                $text = mb_strlen(strip_tags($data->review),'utf-8') > 250 ? mb_substr(strip_tags($data->review),0,250,'utf-8').'...' : strip_tags($data->review);
	                                return $text;
	                            })
								->addColumn('userrating', function(Rating $data) {
	                                $name = $data->rating;
	                                return $name;
	                            })
									->addColumn('userstatus', function(Rating $data) {
                                $class = $data->admin_approve == 1 ? 'drop-success' : 'drop-danger';
                                $s = $data->admin_approve == 1 ? 'selected' : '';
                                $ns = $data->admin_approve == 0 ? 'selected' : '';
                                return '<div class="action-list"><select class="process select droplinks '.$class.'"><option data-val="1" value="'. route('admin-reviews-status',['id1' => $data->id, 'id2' => 1]).'" '.$s.'>Approved</option><<option data-val="0" value="'. route('admin-reviews-status',['id1' => $data->id, 'id2' => 0]).'" '.$ns.'>Rejected</option>/select></div>';
                            })
								
							
	                            ->addColumn('action', function(Rating $data) {
	                                return '<div class="action-list"><a href="' . route('admin-reviews-show',$data->id) . '" class="view details-width" > <i class="fas fa-eye"></i>View</a><a href="javascript:;" data-href="' . route('admin-reviews-delete',$data->id) . '" data-toggle="modal" data-target="#confirm-delete" class="delete"><i class="fas fa-trash-alt"></i></a></div>';
	                            }) 
	                            ->rawColumns(['product','userstatus','action'])
	                            ->toJson(); //--- Returning Json Data To Client Side
	    }
	    //*** GET Request
	    public function index()
	    {
	        return view('admin.reviews.index');
	    }

	     //*** GET Request Show
	    public function show($id)
	    {
	        $data = Rating::findOrFail($id);
	        return view('admin.reviews.show',compact('data'));
	    }
		
		 //*** GET Request Status
        public function status($id1,$id2)
       {
        $data = Rating::findOrFail($id1);
        $data->admin_approve = $id2;
        $data->update();
      }


	    //*** GET Request Delete
		public function destroy($id)
		{
		    $reviews = Rating::findOrFail($id);
		    $reviews->delete();
		    //--- Redirect Section     
		    $msg = 'Data Deleted Successfully.';
		    return response()->json($msg);      
		    //--- Redirect Section Ends    
		}
}
