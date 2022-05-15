<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Childcategory;
use App\Models\Currency;
use App\Models\Gallery;
use App\Models\Product;
use App\Models\Subcategory;
use App\Models\Attribute;
use App\Models\AttributeOption;
use Auth;
use DB;
use Datatables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Image;
use Session;
use Validator;

class ProductController extends Controller
{
    public $global_language;

    public function __construct()
    {
        $this->middleware('auth');

            if (Session::has('language'))
            {
                $data = DB::table('languages')->find(Session::get('language'));
                $data_results = file_get_contents(public_path().'/assets/languages/'.$data->file);
                $this->vendor_language = json_decode($data_results);
            }
            else
            {
                $data = DB::table('languages')->where('is_default','=',1)->first();
                $data_results = file_get_contents(public_path().'/assets/languages/'.$data->file);
                $this->vendor_language = json_decode($data_results);

            }

    }

    //*** JSON Request
    public function datatables()
    {
		$user = Auth::user();
         $category = (!empty($_GET["category"])) ? ($_GET["category"]) : ('');
          $subcat = (!empty($_GET["subcat"])) ? ($_GET["subcat"]) : ('');
          $childcat = (!empty($_GET["childcat"])) ? ($_GET["childcat"]) : ('');
		 // $svendor = (!empty($_GET["svendor"])) ? ($_GET["svendor"]) : ('');
       
		if(!empty($category) || !empty($svendor)){	
		
								
			$query = Product::where('product_type','=','normal');
					if(!empty($category))
						$query->whereRaw("find_in_set($category , category_id)");					
					if(!empty($subcat))
						$query->whereRaw("find_in_set($subcat , subcategory_id)");	
					if(!empty($childcat))
						$query->whereRaw("find_in_set($childcat , childcategory_id)");					
					if(!empty($user))
						$query->where('user_id','=',$user->id);			
			$datas = $query->orderBy('id','desc')->get();		
					
					
        }else{
            $datas = Product::where('product_type','=','normal')->where('user_id','=',$user->id)->orderBy('id','desc')->get();    
        }
         //--- Integrating This Collection Into Datatables
         return Datatables::of($datas)
                            ->editColumn('name', function(Product $data) { 
                                $name = '<a href="'.route('front.product', $data->slug).'" target="_blank">'.$data->name.'</a>';  
                                return  $name;
                            })
                            ->editColumn('image',function(Product $data){
                                $pricecheckbox= "<input type='checkbox' style='position:absolute;opacity:0;visibility:hidden;' name='pricebox[]' value='$data->price'  >";
                                $checkbox= "<input type='checkbox' class='salewithprice'  name='checkedid[]' value='$data->id'  > <script>jQuery('.salewithprice').click(function () {jQuery(this).siblings('input').prop('checked', this.checked);});</script>";
                                $url= asset('assets/images/thumbnails/'.$data->thumbnail);  
                                $productimage = "<img src=".$url.">";
                                return $checkbox.$pricecheckbox.'<a href="'.route('front.product', $data->slug).'" target="_blank">'.$productimage.'</a>';
                            })
                            ->editColumn('sku',function(Product $data){
                                $sku = $data->type == 'Physical' ?'<span>  <a href="'.route('front.product', $data->slug).'" target="_blank">'.$data->sku.'</a></span>' : '';
                                return  $sku;
                            })
							 ->editColumn('category',function(Product $data){
								 
								 $category_id = $data->category_id;
							     $subcategory_id = $data->subcategory_id;                              
                                 $childcategory_id = $data->childcategory_id;
								 
								 $category_all = Category::where('id','=',$category_id)->get();
								 $category_name='';
								 foreach ($category_all as $key => $value) {
                                        $category_name=$value->name;
                                }
								
								$subcat_all = Subcategory::where('id','=',$subcategory_id)->get();
								 $subcat_name='';
								 foreach ($subcat_all as $key => $value) {
                                        $subcat_name=$value->name;
                                }
								
								$childcat_all = Childcategory::where('id','=',$childcategory_id)->get();
								 $childcat_name='';
								 foreach ($childcat_all as $key => $value) {
                                        $childcat_name=$value->name;
                                }
								if($category_name && $subcat_name && $childcat_name){
									$all_cat=$category_name.'->'.$subcat_name.'->'.$childcat_name;
								}elseif($category_name && $subcat_name ){
								$all_cat=$category_name.'->'.$subcat_name;
								}elseif($category_name){
									$all_cat=$category_name;
								}
								
								 
								 return  $all_cat;

                                //Main Category Start
                                /*$category_list = explode(',',$data->category_multi_id);  
                                $child_category_list = explode(',', $data->subcategory_multi_id);                              
                                $count = count($category_list);
                                $child_count = count($child_category_list);
                                                            	

                               

                                 for($i=0;$i<=$count-1;$i++){
                                   
                                    $pid = $category_list[$i];
                                    if(!empty($data->subcategory_multi_id)){
                                        $sub_category_list = explode(',',$data->subcategory_multi_id);
                                    }else{
                                        $sub_category_list =explode(',','');
                                    }
                                    if(!empty($data->childcategory_multi_id)){
                                        $child_category_list = explode(',',$data->childcategory_multi_id);
                                    }else{
                                        $child_category_list =explode(',','');
                                    }
                                    
								
								$query =DB::table('categories as cat')
                                                                 ->select('cat.name AS MainCat','subcat.name AS SubCat','childcat.name AS ChildCat')
                                                                 ->leftjoin('subcategories AS subcat','cat.id','=','subcat.category_id')
                                                                 ->leftjoin('childcategories AS childcat','subcat.id','=','childcat.subcategory_id');
								
                                                                $query->where('cat.id','=',$pid); 	
										 $childcategorylist[] = $query->orderBy('cat.id','desc')->get();
                                   
                                }
                                foreach ($childcategorylist as $key => $value) {
                                         $listname[] = $value;
                                } 
                                
                                $childcategorylist = implode(',', $listname);
                                
                                return  $childcategorylist;*/
                            })
							 ->editColumn('views',function(Product $data){
                                $views = $data->views;
                                return  $views;
                            })
                            ->editColumn('date',function(Product $data){
                                $created_at = date('d-m-Y', strtotime($data->created_at));
                                $updated_at = '<br/>'.date('d-m-Y', strtotime($data->updated_at));
                                return  $updated_at;
                            })
							->editColumn('vendor',function(Product $data){
								$vendor = $data->user_id != 0 ? ( count($data->user->products) > 0 ? '<span> <a href="'.route('admin-vendor-show',$data->user_id).'" target="_blank">'.$data->user->shop_name.'</a></span>' : '' ) : '';
								return  $vendor;
							})
                            ->editColumn('price', function(Product $data) {
                               /* $sign = Currency::where('is_default','=',1)->first();
                                $price = round($data->price * $sign->value , 2);
                                $price = '<span class="text-success"><b>'.$sign->sign.$price.'</b></span>' ;
                                $price_reg = round($data->previous_price * $sign->value , 2);
                                if(empty($data->previous_price)){
                                    $price_reg='';
                                }else{
                                    $price_reg = '<br /> <del class="text-danger" >'.$sign->sign.$price_reg.'<del>' ;
                                }
                                return  $price.$price_reg;*/
                                 $sign = Currency::where('is_default','=',1)->first();
                                
                                
                                 if(!empty($data->size)){
                                    $price = min($data->size_price);
                                    $pricemax =max($data->size_price);
                                    $final= '<span class="text-success"><b>'.$sign->sign.$price.' - '.$sign->sign.$pricemax.'</b></span>';   
                                    
                                    
                                    return $final;
                                }
                                else{
                                
                                
                              
                                $price = round($data->price * $sign->value , 2);
                                $price = '<span class="text-success"><b>'.$sign->sign.$price.'</b></span>' ;
                                
                               
                                
                                                        
                                $price_reg = round($data->previous_price * $sign->value , 2);
                                if(empty($data->previous_price)){
                                    $price_reg='';
                                }else{
                                    $price_reg = '<br /> <del class="text-danger" >'.$sign->sign.$price_reg.'<del>' ;
                                }
                                return  $price.$price_reg;
                                }
                            })
                            
                            ->editColumn('stock', function(Product $data) {
                                
                                if(!empty($data->size)){
                                
                                $stck = $data->size_qty;
                                if($stck == "0")
                                return "Out Of Stock";
                                elseif($stck == null)
                                return "0";
                                else
                                return $data->size_qty;
                                
                                } else {
                                    $stck = (string)$data->stock;
                                if($stck == "0")
                                return "Out Of Stock";
                                elseif($stck == null)
                                return "0";
                                else
                                return $data->stock;
                                }
                              
                               /* $stck = (string)$data->stock;
                                if($stck == "0")
                                return "Out Of Stock";
                                elseif($stck == null)
                                return "0";
                                else
                                return $data->stock;*/
                            })
                            /*->addColumn('status', function(Product $data) {
                                $class = $data->status == 1 ? 'drop-success' : 'drop-danger';
                                $s = $data->status == 1 ? 'selected' : '';
                                $ns = $data->status == 0 ? 'selected' : '';
                                return '<div class="action-list"><select class="process select droplinks '.$class.'"><option data-val="1" value="'. route('vendor-prod-status',['id1' => $data->id, 'id2' => 1]).'" '.$s.'>Activated</option><<option data-val="0" value="'. route('vendor-prod-status',['id1' => $data->id, 'id2' => 0]).'" '.$ns.'>Deactivated</option>/select></div>';
                            })*/
                            ->addColumn('status', function(Product $data) {
                                $data= "-";
                                return $data;
                            })
                            ->addColumn('action', function(Product $data) {
                                return '<div class="godropdown">
								<button class="go-dropdown-toggle"> Actions<i class="fas fa-chevron-down"></i></button>
								<div class="action-list">
								<a href="' . route('vendor-prod-edit',$data->id) . '"> <i class="fas fa-edit"></i> Edit</a>
								<a href="javascript" class="set-gallery" data-toggle="modal" data-target="#setgallery">
								<input type="hidden" value="'.$data->id.'"><i class="fas fa-eye"></i> View Gallery</a>
								</div></div>';
                            })
                            ->rawColumns(['name','image','vendor','price', 'date', 'sku', 'status', 'action','views','category'])
                            ->toJson(); //--- Returning Json Data To Client Side
    }
	
	 public function simple_datatables()
    {
	    $user = Auth::user();
        $datas = Product::where('product_type','=','normal')->where('user_id','=',$user->id)->whereNull('size')->orderBy('id','desc')->get();

         //--- Integrating This Collection Into Datatables
         return Datatables::of($datas)
                            ->editColumn('name', function(Product $data) { 
                                $name = '<a href="'.route('front.product', $data->slug).'" target="_blank">'.$data->name.'</a>';  
                                return  $name;
                            })
                            ->editColumn('image',function(Product $data){
                                $pricecheckbox= "<input type='checkbox' style='position:absolute;opacity:0;visibility:hidden;' name='pricebox[]' value='$data->price'  >";
                                $checkbox= "<input type='checkbox' class='salewithprice'  name='checkedid[]' value='$data->id'  > <script>jQuery('.salewithprice').click(function () {jQuery(this).siblings('input').prop('checked', this.checked);});</script>";
                                $url= asset('assets/images/thumbnails/'.$data->thumbnail);  
                                $productimage = "<img src=".$url.">";
                                return $checkbox.$pricecheckbox.'<a href="'.route('front.product', $data->slug).'" target="_blank">'.$productimage.'</a>';
                            })
                            ->editColumn('sku',function(Product $data){
                                $sku = $data->type == 'Physical' ?'<span>  <a href="'.route('front.product', $data->slug).'" target="_blank">'.$data->sku.'</a></span>' : '';
                                return  $sku;
                            })
							 ->editColumn('category',function(Product $data){
								 
								 $category_id = $data->category_id;
							     $subcategory_id = $data->subcategory_id;                              
                                 $childcategory_id = $data->childcategory_id;
								 
								 $category_all = Category::where('id','=',$category_id)->get();
								 $category_name='';
								 foreach ($category_all as $key => $value) {
                                        $category_name=$value->name;
                                }
								
								$subcat_all = Subcategory::where('id','=',$subcategory_id)->get();
								 $subcat_name='';
								 foreach ($subcat_all as $key => $value) {
                                        $subcat_name=$value->name;
                                }
								
								$childcat_all = Childcategory::where('id','=',$childcategory_id)->get();
								 $childcat_name='';
								 foreach ($childcat_all as $key => $value) {
                                        $childcat_name=$value->name;
                                }
								if($category_name && $subcat_name && $childcat_name){
									$all_cat=$category_name.'->'.$subcat_name.'->'.$childcat_name;
								}elseif($category_name && $subcat_name ){
								$all_cat=$category_name.'->'.$subcat_name;
								}elseif($category_name){
									$all_cat=$category_name;
								}								
								 
								 return  $all_cat;
                            })
							 ->editColumn('views',function(Product $data){
                                $views = $data->views;
                                return  $views;
                            })
                            ->editColumn('date',function(Product $data){
                                $created_at = date('d-m-Y', strtotime($data->created_at));
                                $updated_at = '<br/>'.date('d-m-Y', strtotime($data->updated_at));
                                return  $updated_at;
                            })
							->editColumn('vendor',function(Product $data){
								$vendor = $data->user_id != 0 ? ( count($data->user->products) > 0 ? '<span> <a href="'.route('admin-vendor-show',$data->user_id).'" target="_blank">'.$data->user->shop_name.'</a></span>' : '' ) : '';
								return  $vendor;
							})
                            ->editColumn('price', function(Product $data) {
                                /*$sign = Currency::where('is_default','=',1)->first();
                                $price = round($data->price * $sign->value , 2);
                                $price = '<span class="text-success"><b>'.$sign->sign.$price.'</b></span>' ;
                                $price_reg = round($data->previous_price * $sign->value , 2);
                                if(empty($data->previous_price)){
                                    $price_reg='';
                                }else{
                                    $price_reg = '<br /> <del class="text-danger" >'.$sign->sign.$price_reg.'<del>' ;
                                }
                                return  $price.$price_reg;*/
                                
                                  $sign = Currency::where('is_default','=',1)->first();
                                
                                
                                 if(!empty($data->size)){
                                    $price = min($data->size_price);
                                    $pricemax =max($data->size_price);
                                    $final= '<span class="text-success"><b>'.$sign->sign.$price.' - '.$sign->sign.$pricemax.'</b></span>';   
                                    
                                    
                                    return $final;
                                }
                                else{
                                
                                
                              
                                $price = round($data->price * $sign->value , 2);
                                $price = '<span class="text-success"><b>'.$sign->sign.$price.'</b></span>' ;
                                
                               
                                
                                                        
                                $price_reg = round($data->previous_price * $sign->value , 2);
                                if(empty($data->previous_price)){
                                    $price_reg='';
                                }else{
                                    $price_reg = '<br /> <del class="text-danger" >'.$sign->sign.$price_reg.'<del>' ;
                                }
                                return  $price.$price_reg;
                                }
                                
                            })
                            
                            ->editColumn('stock', function(Product $data) {
                                /*$stck = (string)$data->stock;
                                if($stck == "0")
                                return "Out Of Stock";
                                elseif($stck == null)
                                return "Unlimited";
                                else
                                return $data->stock;*/
                                
                                
                                if(!empty($data->size)){
                                
                                $stck = $data->size_qty;
                                if($stck == "0")
                                return "Out Of Stock";
                                elseif($stck == null)
                                return "0";
                                else
                                return $data->size_qty;
                                
                                } else {
                                    $stck = (string)$data->stock;
                                if($stck == "0")
                                return "Out Of Stock";
                                elseif($stck == null)
                                return "0";
                                else
                                return $data->stock;
                                }
                             
                            })
                            /*->addColumn('status', function(Product $data) {
                                $class = $data->status == 1 ? 'drop-success' : 'drop-danger';
                                $s = $data->status == 1 ? 'selected' : '';
                                $ns = $data->status == 0 ? 'selected' : '';
                                return '<div class="action-list"><select class="process select droplinks '.$class.'"><option data-val="1" value="'. route('admin-prod-status',['id1' => $data->id, 'id2' => 1]).'" '.$s.'>Activated</option><<option data-val="0" value="'. route('admin-prod-status',['id1' => $data->id, 'id2' => 0]).'" '.$ns.'>Deactivated</option>/select></div>';
                            })   */
                            ->addColumn('status', function(Product $data) {
                                $data= "-";
                                return $data;
                            })
                            ->rawColumns(['name','image','vendor','price', 'date', 'sku', 'status'])
                            ->toJson(); //--- Returning Json Data To Client Side
    }
	


    //*** JSON Request
    public function catalogdatatables()
    {
         $user = Auth::user();
         $datas =  Product::where('product_type','normal')->where('status','=',1)->where('is_catalog','=',1)->orderBy('id','desc')->get();

         //--- Integrating This Collection Into Datatables
         return Datatables::of($datas)
                            ->editColumn('name', function(Product $data) {
                                $name = strlen(strip_tags($data->name)) > 50 ? substr(strip_tags($data->name),0,50).'...' : strip_tags($data->name);
                                $id = '<small>Product ID: <a href="'.route('front.product', $data->slug).'" target="_blank">'.sprintf("%'.08d",$data->id).'</a></small>';
                                return  $name.'<br>'.$id;
                            })
                            ->editColumn('price', function(Product $data) {
                               /* $sign = Currency::where('is_default','=',1)->first();
                                $price = $sign->sign.$data->price;
                                return  $price;*/
                                 $sign = Currency::where('is_default','=',1)->first();
                                
                                
                                 if(!empty($data->size)){
                                    $price = min($data->size_price);
                                    $pricemax =max($data->size_price);
                                    $final= '<span class="text-success"><b>'.$sign->sign.$price.' - '.$sign->sign.$pricemax.'</b></span>';   
                                    
                                    
                                    return $final;
                                }
                                else{
                                
                                
                              
                                $price = round($data->price * $sign->value , 2);
                                $price = '<span class="text-success"><b>'.$sign->sign.$price.'</b></span>' ;
                                
                               
                                
                                                        
                                $price_reg = round($data->previous_price * $sign->value , 2);
                                if(empty($data->previous_price)){
                                    $price_reg='';
                                }else{
                                    $price_reg = '<br /> <del class="text-danger" >'.$sign->sign.$price_reg.'<del>' ;
                                }
                                return  $price.$price_reg;
                                }
                            })
                            ->addColumn('action', function(Product $data) {
                                $user = Auth::user();
                                $ck = $user->products()->where('catalog_id','=',$data->id)->count() > 0;
                                $catalog = $ck ? '<a href="javascript:;"> Added To Catalog</a>' : '<a href="' . route('vendor-prod-catalog-edit',$data->id) . '"><i class="fas fa-plus"></i> Add To Catalog</a>';
                                return '<div class="action-list">'. $catalog .'</div>';
                            })
                            ->rawColumns(['name', 'status', 'action'])
                            ->toJson(); //--- Returning Json Data To Client Side
    }
    
    //*** JSON Request
	 public function vproductupdatedatatables()
    {
		$user = Auth::user();
        $datas = Product::where('product_type','=','normal')->where('user_id','=',$user->id)->where('stock','!=','null')->orderBy('id','desc')->get();

         //--- Integrating This Collection Into Datatables
         return Datatables::of($datas)
                            ->editColumn('name', function(Product $data) {
                                
                                $name = mb_strlen(strip_tags($data->name),'utf-8') > 50 ? mb_substr(strip_tags($data->name),0,50,'utf-8').'...' : strip_tags($data->name);
                                $id = '<small>ID: <a href="'.route('front.product', $data->slug).'" target="_blank">'.sprintf("%'.08d",$data->id).'</a></small>';
                                $id2 = $data->user_id != 0 ? ( count($data->user->products) > 0 ? '<small class="ml-2"> VENDOR: <a href="'.route('admin-vendor-show',$data->user_id).'" target="_blank">'.$data->user->shop_name.'</a></small>' : '' ) : '';

                                $id3 = $data->type == 'Physical' ?'<small class="ml-2"> SKU: <a href="'.route('front.product', $data->slug).'" target="_blank">'.$data->sku.'</a>' : '';

                                return  $name.'<br>'.$id.$id3.$id2;
                            })
                            ->editColumn('price', function(Product $data) {
                                $sign = Currency::where('is_default','=',1)->first();
                                $price = round($data->price * $sign->value , 2);
                                $price = $sign->sign.$price ;
                                return  $price;
                            })
                            ->editColumn('regular', function(Product $data) {
                                $sign = Currency::where('is_default','=',1)->first();
                                $price_reg = round($data->previous_price * $sign->value , 2);
                                $price_reg = $sign->sign.$price_reg ;
                                return  $price_reg;
                            })
                            ->editColumn('update_by', function(Product $data) {
                                return  $data->update_by;
                            })
                            ->editColumn('stock', function(Product $data) {
                                $stock= "<input type='checkbox' class='salewithprice'  name='checkedid[]' value='$data->id'  ><input type='checkbox' class='stockcheckfield'  name='stockselected[]' value='$data->stock'  ><input type='text' name='stock[]' value='$data->stock' id='$data->id'><script>jQuery('#$data->id').keyup(function() {var txtVal = this.value; jQuery(this).siblings('input.stockcheckfield').attr('value', txtVal); jQuery(this).siblings('input').attr('checked', true); });</script>";
                                $stck = (string)$data->stock;
                                if($stck == "0")
                                return $stock;
                                elseif($stck == null)
                                return "To Update stock of this product please edit";
                                else
                                return $stock;
                            })
                            
                            ->addColumn('status', function(Product $data) {
                                $class = $data->status == 1 ? 'drop-success' : 'drop-danger';
                                $s = $data->status == 1 ? 'selected' : '';
                                $ns = $data->status == 0 ? 'selected' : '';
                                return '<div class="action-list"><select class="process select droplinks '.$class.'"><option data-val="1" value="'. route('vendor-prod-status',['id1' => $data->id, 'id2' => 1]).'" '.$s.'>Activated</option><<option data-val="0" value="'. route('admin-prod-status',['id1' => $data->id, 'id2' => 0]).'" '.$ns.'>Deactivated</option>/select></div>';
                            })
                           ->addColumn('action', function(Product $data) {
                                return '<div class="godropdown">
								<button class="go-dropdown-toggle"> Actions<i class="fas fa-chevron-down"></i></button>
								<div class="action-list">
								<a href="' . route('vendor-prod-edit',$data->id) . '"> <i class="fas fa-edit"></i> Edit</a>
								<a href="javascript" class="set-gallery" data-toggle="modal" data-target="#setgallery">
								<input type="hidden" value="'.$data->id.'"><i class="fas fa-eye"></i> View Gallery</a>
								</div></div>';
                            })
                            ->rawColumns(['name','stock', 'status', 'action','update_by'])
                            ->toJson(); //--- Returning Json Data To Client Side
    }
    

    //*** GET Request
  
	
	 public function index()
    {
        $cats = Category::all();
		$users = Auth::user();		
		//print_r($users);die;
        return view('vendor.product.index',compact('cats','users'));
    }
	
	 //*** GET Request simpleproduct	
	 public function simpleproduct()
    {
        $cats = Category::all();
		$users = Auth::user();		
		return view('vendor.product.simpleproduct',compact('cats','users'));
    }

 //*** GET Request
    public function vproductupdate()
    {
        return view('vendor.product.vproductupdate');
    }
    //*** GET Request
    public function catalogs()
    {
        return view('vendor.product.catalogs');
    }

    //*** GET Request
    public function types()
    {
        return view('vendor.product.types');
    }

    //*** GET Request
    public function createPhysical()
    {
        $cats = Category::all();
        $sign = Currency::where('is_default','=',1)->first();
        return view('vendor.product.create.physical',compact('cats','sign'));
    }

    //*** GET Request
    public function createDigital()
    {
        $cats = Category::all();
        $sign = Currency::where('is_default','=',1)->first();
        return view('vendor.product.create.digital',compact('cats','sign'));
    }

    //*** GET Request
    public function createLicense()
    {
        $cats = Category::all();
        $sign = Currency::where('is_default','=',1)->first();
        return view('vendor.product.create.license',compact('cats','sign'));
    }

    //*** GET Request
    public function status($id1,$id2)
    {
        $data = Product::findOrFail($id1);
        $data->status = $id2;
        $data->update();
    }

    //*** POST Request
    public function uploadUpdate(Request $request,$id)
    {
        //--- Validation Section
        $rules = [
          'image' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
          return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }

        $data = Product::findOrFail($id);

        //--- Validation Section Ends
        $image = $request->image;
        list($type, $image) = explode(';', $image);
        list(, $image)      = explode(',', $image);
        $image = base64_decode($image);
        $image_name = time().str_random(8).'.png';
        $path = 'assets/images/products/'.$image_name;
        file_put_contents($path, $image);
                if($data->photo != null)
                {
                    if (file_exists(public_path().'/assets/images/products/'.$data->photo)) {
                        unlink(public_path().'/assets/images/products/'.$data->photo);
                    }
                }
                        $input['photo'] = $image_name;
         $data->update($input);
                if($data->thumbnail != null)
                {
                    if (file_exists(public_path().'/assets/images/thumbnails/'.$data->thumbnail)) {
                        unlink(public_path().'/assets/images/thumbnails/'.$data->thumbnail);
                    }
                }



        $background = Image::canvas(300, 300);
        $resizedImage = Image::make(public_path().'/assets/images/products/'.$data->photo)->resize(300, 300, function ($c) {
            $c->aspectRatio();
            $c->upsize();
        });
        // insert resized image centered into background
        $background->insert($resizedImage, 'center');
        // save or do whatever you like
        $thumbnail = time().str_random(8).'.jpg';
        $background->save(public_path().'/assets/images/thumbnails/'.$thumbnail);



        $data->thumbnail  = $thumbnail;
        $data->update();
        return response()->json(['status'=>true,'file_name' => $image_name]);
    }


    //*** POST Request
    public function import(){

        $cats = Category::all();
        $sign = Currency::where('is_default','=',1)->first();
        return view('vendor.product.productcsv',compact('cats','sign'));
    }

    public function importSubmit(Request $request)
    {

        $user = Auth::user();
        $package = $user->subscribes()->orderBy('id','desc')->first();
        $prods = $user->products()->orderBy('id','desc')->get()->count();
        if($prods < $package->allowed_products || $package->allowed_products == 0) {
        $log = "";
        //--- Validation Section
        $rules = [
            'csvfile'      => 'required|mimes:csv,txt',
        ];

        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }

        $filename = '';
        if ($file = $request->file('csvfile'))
        {
            $filename = time().'-'.$file->getClientOriginalName();
            $file->move('assets/temp_files',$filename);
        }

        //$filename = $request->file('csvfile')->getClientOriginalName();
        //return response()->json($filename);
        $datas = "";

        $file = fopen(public_path('assets/temp_files/'.$filename),"r");
        $i = 1;
        while (($line = fgetcsv($file)) !== FALSE) {

            if($i != 1)
            {

            if (!Product::where('sku',$line[0])->exists()){

                //--- Validation Section Ends

                //--- Logic Section
                $data = new Product;
                $sign = Currency::where('is_default','=',1)->first();

                $input['type'] = 'Physical';
                $input['sku'] = $line[0];

                $input['category_id'] = "";
                $input['subcategory_id'] = "";
                $input['childcategory_id'] = "";

                $mcat = Category::where(DB::raw('lower(name)'), strtolower($line[1]));
                //$mcat = Category::where("name", $line[1]);

                if($mcat->exists()){
                    $input['category_id'] = $mcat->first()->id;

                    if($line[2] != ""){
                        $scat = Subcategory::where(DB::raw('lower(name)'), strtolower($line[2]));

                        if($scat->exists()) {
                            $input['subcategory_id'] = $scat->first()->id;
                        }
                    }
                    if($line[3] != ""){
                        $chcat = Childcategory::where(DB::raw('lower(name)'), strtolower($line[3]));

                        if($chcat->exists()) {
                            $input['childcategory_id'] = $chcat->first()->id;
                        }
                    }



                $input['photo'] = $line[5];
                $input['name'] = $line[4];
                $input['details'] = $line[6];
//                $input['category_id'] = $request->category_id;
//                $input['subcategory_id'] = $request->subcategory_id;
//                $input['childcategory_id'] = $request->childcategory_id;
                $input['color'] = $line[13];
                $input['price'] = $line[7];
                $input['previous_price'] = $line[8];
                $input['stock'] = $line[9];
                $input['size'] = $line[10];
                $input['size_qty'] = $line[11];
                $input['size_price'] = $line[12];
                $input['youtube'] = $line[15];
                $input['policy'] = $line[16];
                $input['meta_tag'] = $line[17];
                $input['meta_description'] = $line[18];
                $input['tags'] = $line[14];
                $input['product_type'] = $line[19];
                $input['affiliate_link'] = $line[20];



                // Conert Price According to Currency
                $input['price'] = ($input['price'] / $sign->value);
                $input['previous_price'] = ($input['previous_price'] / $sign->value);
                $input['user_id'] = $user->id;
                // Save Data
                $data->fill($input)->save();

                // Set SLug
                $prod = Product::find($data->id);
                $prod->slug = str_slug($data->name,'-').'-'.strtolower($data->sku);
                // Set Thumbnail
                


                $background = Image::canvas(300, 300);
                $resizedImage = Image::make($line[5])->resize(300, 300, function ($c) {
                    $c->aspectRatio();
                    $c->upsize();
                });
                // insert resized image centered into background
                $background->insert($resizedImage, 'center');
                // save or do whatever you like
                $thumbnail = time().str_random(8).'.jpg';
                $background->save(public_path().'/assets/images/thumbnails/'.$thumbnail);




                $prod->thumbnail  = $thumbnail;
                $prod->update();


                }else{
                    $log .= "<br>Row No: ".$i." - No Category Found!<br>";
                }

            }else{
                $log .= "<br>Row No: ".$i." - Duplicate Product Code!<br>";
            }

            }

            $i++;

        }
        fclose($file);


        //--- Redirect Section
        $msg = 'Bulk Product File Imported Successfully.<a href="'.route('admin-prod-index').'">View Product Lists.</a>'.$log;
        return response()->json($msg);



        }
        else
        {
            //--- Redirect Section
            return response()->json(array('errors' => [ 0 => 'You Can\'t Add More Products.']));

            //--- Redirect Section Ends
        }
    }



    //*** POST Request
    public function store(Request $request)
    {

        $user = Auth::user();
        $package = $user->subscribes()->orderBy('id','desc')->first();
        $prods = $user->products()->orderBy('id','desc')->get()->count();

        if($prods < $package->allowed_products || $package->allowed_products == 0)
        {

        //--- Validation Section
        $rules = [
               'photo'      => 'required|mimes:jpeg,jpg,png,svg',
               'file'       => 'mimes:zip'
                ];

        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
          return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }
        //--- Validation Section Ends

        //--- Logic Section
            $data = new Product;
            $sign = Currency::where('is_default','=',1)->first();
            $input = $request->all();
            // Check File
            if ($file = $request->file('file'))
            {
                $name = time().$file->getClientOriginalName();
                $file->move('assets/files',$name);
                $input['file'] = $name;
            }

            if ($file = $request->file('photo')) 
            {      
               $name = time().$file->getClientOriginalName();
               $file->move('assets/images/products',$name);           
               $input['photo'] = $name;
           } 

            // Check Physical
            if($request->type == "Physical")
            {

                    //--- Validation Section
                    $rules = ['sku'      => 'min:8|unique:products'];

                    $validator = Validator::make(Input::all(), $rules);

                    if ($validator->fails()) {
                        return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
                    }
                    //--- Validation Section Ends


            // Check Condition
            if ($request->product_condition_check == ""){
                $input['product_condition'] = 0;
            }

            // Check Shipping Time
            if ($request->shipping_time_check == ""){
                $input['ship'] = null;
            }

            // Check Size
            if(empty($request->size_check ))
            {
                $input['size'] = null;
                $input['size_qty'] = null;
                $input['size_price'] = null;
            }
            else{
                    if(in_array(null, $request->size) || in_array(null, $request->size_qty))
                    {
                        $input['size'] = null;
                        $input['size_qty'] = null;
                        $input['size_price'] = null;
                    }
                    else
                    {
                        $input['size'] = implode(',', $request->size);
                        $input['size_qty'] = implode(',', $request->size_qty);
                        $input['size_price'] = implode(',', $request->size_price);
                    }
            }

            // Check Whole Sale
            if(empty($request->whole_check ))
            {
                $input['whole_sell_qty'] = null;
                $input['whole_sell_discount'] = null;
            }
            else{
                if(in_array(null, $request->whole_sell_qty) || in_array(null, $request->whole_sell_discount))
                {
                $input['whole_sell_qty'] = null;
                $input['whole_sell_discount'] = null;
                }
                else
                {
                    $input['whole_sell_qty'] = implode(',', $request->whole_sell_qty);
                    $input['whole_sell_discount'] = implode(',', $request->whole_sell_discount);
                }
            }


            // Check Color
            if(empty($request->color_check))
            {
                $input['color'] = null;
            }
            else{
                $input['color'] = implode(',', $request->color);
            }

            // Check Measurement
            if ($request->mesasure_check == "")
             {
                $input['measure'] = null;
             }

            }

            // Check Seo
        if (empty($request->seo_check))
         {
            $input['meta_tag'] = null;
            $input['meta_description'] = null;
         }
         else {
        if (!empty($request->meta_tag))
         {
            $input['meta_tag'] = implode(',', $request->meta_tag);
         }
         }

             // Check License

            if($request->type == "License")
            {

                if(in_array(null, $request->license) || in_array(null, $request->license_qty))
                {
                    $input['license'] = null;
                    $input['license_qty'] = null;
                }
                else
                {
                    $input['license'] = implode(',,', $request->license);
                    $input['license_qty'] = implode(',', $request->license_qty);
                }

            }

             // Check Features
            if(in_array(null, $request->features) || in_array(null, $request->colors))
            {
                $input['features'] = null;
                $input['colors'] = null;
            }
            else
            {
                $input['features'] = implode(',', str_replace(',',' ',$request->features));
                $input['colors'] = implode(',', str_replace(',',' ',$request->colors));
            }

            //tags
            if (!empty($request->tags))
             {
                $input['tags'] = implode(',', $request->tags);
             }

            // Conert Price According to Currency
             $input['price'] = ($input['price'] / $sign->value);
             $input['previous_price'] = ($input['previous_price'] / $sign->value);
         	 $input['user_id'] = Auth::user()->id;

           // store filtering attributes for physical product
           $attrArr = [];
           if (!empty($request->category_id)) {
             $catAttrs = Attribute::where('attributable_id', $request->category_id)->where('attributable_type', 'App\Models\Category')->get();
             if (!empty($catAttrs)) {
               foreach ($catAttrs as $key => $catAttr) {
                 $in_name = $catAttr->input_name;
                 if ($request->has("$in_name")) {
                   $attrArr["$in_name"]["values"] = $request["$in_name"];
                   $attrArr["$in_name"]["prices"] = $request["$in_name"."_price"];
                   if ($catAttr->details_status) {
                     $attrArr["$in_name"]["details_status"] = 1;
                   } else {
                     $attrArr["$in_name"]["details_status"] = 0;
                   }
                 }
               }
             }
           }

           if (!empty($request->subcategory_id)) {
             $subAttrs = Attribute::where('attributable_id', $request->subcategory_id)->where('attributable_type', 'App\Models\Subcategory')->get();
             if (!empty($subAttrs)) {
               foreach ($subAttrs as $key => $subAttr) {
                 $in_name = $subAttr->input_name;
                 if ($request->has("$in_name")) {
                   $attrArr["$in_name"]["values"] = $request["$in_name"];
                   $attrArr["$in_name"]["prices"] = $request["$in_name"."_price"];
                   if ($subAttr->details_status) {
                     $attrArr["$in_name"]["details_status"] = 1;
                   } else {
                     $attrArr["$in_name"]["details_status"] = 0;
                   }
                 }
               }
             }
           }
           if (!empty($request->childcategory_id)) {
             $childAttrs = Attribute::where('attributable_id', $request->childcategory_id)->where('attributable_type', 'App\Models\Childcategory')->get();
             if (!empty($childAttrs)) {
               foreach ($childAttrs as $key => $childAttr) {
                 $in_name = $childAttr->input_name;
                 if ($request->has("$in_name")) {
                   $attrArr["$in_name"]["values"] = $request["$in_name"];
                   $attrArr["$in_name"]["prices"] = $request["$in_name"."_price"];
                   if ($childAttr->details_status) {
                     $attrArr["$in_name"]["details_status"] = 1;
                   } else {
                     $attrArr["$in_name"]["details_status"] = 0;
                   }
                 }
               }
             }
           }



           if (empty($attrArr)) {
             $input['attributes'] = NULL;
           } else {
             $jsonAttr = json_encode($attrArr);
             $input['attributes'] = $jsonAttr;
           }

            // Save Data
                $data->fill($input)->save();

            // Set SLug

                $prod = Product::find($data->id);
                if($prod->type != 'Physical'){
                    $prod->slug = str_slug($data->name,'-').'-'.strtolower(str_random(3).$data->id.str_random(3));
                }
                else {
                    $prod->slug = str_slug($data->name,'-').'-'.strtolower($data->sku);
                }
                // Set Photo
                $resizedImage = Image::make(public_path().'/assets/images/products/'.$prod->photo)->resize(800, null, function ($c) {
                    $c->aspectRatio();
                });
                $photo = time().str_random(8).'.jpg';
                $resizedImage->save(public_path().'/assets/images/products/'.$photo);


                // Set Thumbnail
                $background = Image::canvas(300, 300);
                $resizedImage = Image::make(public_path().'/assets/images/products/'.$prod->photo)->resize(300, 300, function ($c) {
                    $c->aspectRatio();
                    $c->upsize();
                });
                // insert resized image centered into background
                $background->insert($resizedImage, 'center');
                // save or do whatever you like
                $thumbnail = time().str_random(8).'.jpg';
                $background->save(public_path().'/assets/images/thumbnails/'.$thumbnail);


                $prod->thumbnail  = $thumbnail;
                $prod->photo  = $photo;
                $prod->update();

            // Add To Gallery If any
                $lastid = $data->id;
                if ($files = $request->file('gallery')){
                    foreach ($files as  $key => $file){
                        if(in_array($key, $request->galval))
                        {
                    $gallery = new Gallery;
                    $name = time().$file->getClientOriginalName();
                    $img = Image::make($file->getRealPath())->resize(800, null, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                    $thumbnail = time().str_random(8).'.jpg';
                    $img->save(public_path().'/assets/images/galleries/'.$name);
                    $gallery['photo'] = $name;
                    $gallery['product_id'] = $lastid;
                    $gallery->save();
                        }
                    }
                }
        //logic Section Ends

        //--- Redirect Section
        $msg = 'New Product Added Successfully.<a href="'.route('vendor-prod-index').'">View Product Lists.</a>';
        return response()->json($msg);
        //--- Redirect Section Ends
        }
        else
        {
        //--- Redirect Section
        return response()->json(array('errors' => [ 0 => 'You Can\'t Add More Product.']));

        //--- Redirect Section Ends
        }

    }

    //*** GET Request
    public function edit($id)
    {
        $cats = Category::all();
        $data = Product::findOrFail($id);
        $sign = Currency::where('is_default','=',1)->first();


        if($data->type == 'Digital')
            return view('vendor.product.edit.digital',compact('cats','data','sign'));
        elseif($data->type == 'License')
            return view('vendor.product.edit.license',compact('cats','data','sign'));
        else
            return view('vendor.product.edit.physical',compact('cats','data','sign'));
    }


    //*** GET Request CATALOG
    public function catalogedit($id)
    {
        $cats = Category::all();
        $data = Product::findOrFail($id);
        $sign = Currency::where('is_default','=',1)->first();


        if($data->type == 'Digital')
            return view('vendor.product.edit.catalog.digital',compact('cats','data','sign'));
        elseif($data->type == 'License')
            return view('vendor.product.edit.catalog.license',compact('cats','data','sign'));
        else
            return view('vendor.product.edit.catalog.physical',compact('cats','data','sign'));
    }

    //*** POST Request
    public function update(Request $request, $id)
    {
		
		 $data = Product::findOrFail($id);
        $sign = Currency::where('is_default','=',1)->first();
        //$input = $request->all();
		if(empty($request->size_qty ))
                        {
                           $input['size_qty'] = null;
                         }
                        else{
                                if(in_array(null, $request->size_qty))
                                {
                                    $input['size_qty'] = null;                                    
                                }
                                else
                                {
                                    $input['size_qty'] = implode(',', $request->size_qty);                                   
                                }
                        }
               if($request->stock) {
                  $input['stock'] = $request->stock;  
               }        
						
			$data->update($input);			

        //--- Redirect Section
        $msg = 'Product Updated Successfully.<a href="'.route('vendor-prod-index').'">View Product Lists.</a>';
        return response()->json($msg);
        //--- Redirect Section Ends
    }

    //*** POST Request CATALOG
    public function catalogupdate(Request $request, $id)
    {
        $user = Auth::user();
        $package = $user->subscribes()->orderBy('id','desc')->first();
        $prods = $user->products()->orderBy('id','desc')->get()->count();

        if($prods < $package->allowed_products || $package->allowed_products == 0)
        {

        //--- Validation Section
        $rules = [
            'photo'      => 'mimes:jpeg,jpg,png,svg',
            'file'       => 'mimes:zip'
             ];

        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {
          return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }
        //--- Validation Section Ends



        
        //--- Logic Section
            $data = new Product;
            $sign = Currency::where('is_default','=',1)->first();
            $input = $request->all();
            // Check File

            if ($file = $request->file('file'))
            {
                $name = time().$file->getClientOriginalName();
                $file->move('assets/files',$name);
                $input['file'] = $name;
            }

            $image_name = '';
            if($request->is_photo == '1')
            {
                if ($file = $request->file('photo')) 
                {      
                   $name = time().$file->getClientOriginalName();
                   $file->move('assets/images/products',$name);           
                   $image_name = $name;
                } 

            }
            else {
             $image_name = $request->image_name;
            }

            $input['photo'] = $image_name;

            // Check Physical
            if($request->type == "Physical")
            {

                    //--- Validation Section
                    $rules = ['sku'      => 'min:8|unique:products'];

                    $validator = Validator::make(Input::all(), $rules);

                    if ($validator->fails()) {
                        return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
                    }
                    //--- Validation Section Ends


            // Check Condition
            if ($request->product_condition_check == ""){
                $input['product_condition'] = 0;
            }

            // Check Shipping Time
            if ($request->shipping_time_check == ""){
                $input['ship'] = null;
            }

            // Check Size
            if(empty($request->size_check ))
            {
                $input['size'] = null;
                $input['size_qty'] = null;
                $input['size_price'] = null;

            }
            else{
                    if(in_array(null, $request->size) || in_array(null, $request->size_qty))
                    {                  
                        $input['size'] = null;
                        $input['size_qty'] = null;
                        $input['size_price'] = null;
                    }
                    else
                    {

                        $input['size'] = implode(',', $request->size);
                        $input['size_qty'] = implode(',', $request->size_qty);
                        $input['size_price'] = implode(',', $request->size_price);
                    }
            }

            // Check Whole Sale
            if(empty($request->whole_check ))
            {
                $input['whole_sell_qty'] = null;
                $input['whole_sell_discount'] = null;
            }
            else{
                if(in_array(null, $request->whole_sell_qty) || in_array(null, $request->whole_sell_discount))
                {
                $input['whole_sell_qty'] = null;
                $input['whole_sell_discount'] = null;
                }
                else
                {
                    $input['whole_sell_qty'] = implode(',', $request->whole_sell_qty);
                    $input['whole_sell_discount'] = implode(',', $request->whole_sell_discount);
                }
            }


            // Check Color
            if(empty($request->color_check))
            {
                $input['color'] = null;
            }
            else{
                $input['color'] = implode(',', $request->color);
            }

            // Check Measurement
            if ($request->mesasure_check == "")
             {
                $input['measure'] = null;
             }

            }

            // Check Seo
        if (empty($request->seo_check))
         {
            $input['meta_tag'] = null;
            $input['meta_description'] = null;
         }
         else {
        if (!empty($request->meta_tag))
         {
            $input['meta_tag'] = implode(',', $request->meta_tag);
         }
         }

             // Check License

            if($request->type == "License")
            {

                if(in_array(null, $request->license) || in_array(null, $request->license_qty))
                {
                    $input['license'] = null;
                    $input['license_qty'] = null;
                }
                else
                {
                    $input['license'] = implode(',,', $request->license);
                    $input['license_qty'] = implode(',', $request->license_qty);
                }

            }

             // Check Features
            if(in_array(null, $request->features) || in_array(null, $request->colors))
            {
                $input['features'] = null;
                $input['colors'] = null;
            }
            else
            {
                $input['features'] = implode(',', str_replace(',',' ',$request->features));
                $input['colors'] = implode(',', str_replace(',',' ',$request->colors));
            }

            //tags
            if (!empty($request->tags))
             {
                $input['tags'] = implode(',', $request->tags);
             }

            // Conert Price According to Currency
             $input['price'] = ($input['price'] / $sign->value);
             $input['previous_price'] = ($input['previous_price'] / $sign->value);
             $input['user_id'] = Auth::user()->id;

             // store filtering attributes for physical product
             $attrArr = [];
             if (!empty($request->category_id)) {
               $catAttrs = Attribute::where('attributable_id', $request->category_id)->where('attributable_type', 'App\Models\Category')->get();
               if (!empty($catAttrs)) {
                 foreach ($catAttrs as $key => $catAttr) {
                   $in_name = $catAttr->input_name;
                   if ($request->has("$in_name")) {
                     $attrArr["$in_name"]["values"] = $request["$in_name"];
                     $attrArr["$in_name"]["prices"] = $request["$in_name"."_price"];
                     if ($catAttr->details_status) {
                       $attrArr["$in_name"]["details_status"] = 1;
                     } else {
                       $attrArr["$in_name"]["details_status"] = 0;
                     }
                   }
                 }
               }
             }

             if (!empty($request->subcategory_id)) {
               $subAttrs = Attribute::where('attributable_id', $request->subcategory_id)->where('attributable_type', 'App\Models\Subcategory')->get();
               if (!empty($subAttrs)) {
                 foreach ($subAttrs as $key => $subAttr) {
                   $in_name = $subAttr->input_name;
                   if ($request->has("$in_name")) {
                     $attrArr["$in_name"]["values"] = $request["$in_name"];
                     $attrArr["$in_name"]["prices"] = $request["$in_name"."_price"];
                     if ($subAttr->details_status) {
                       $attrArr["$in_name"]["details_status"] = 1;
                     } else {
                       $attrArr["$in_name"]["details_status"] = 0;
                     }
                   }
                 }
               }
             }
             if (!empty($request->childcategory_id)) {
               $childAttrs = Attribute::where('attributable_id', $request->childcategory_id)->where('attributable_type', 'App\Models\Childcategory')->get();
               if (!empty($childAttrs)) {
                 foreach ($childAttrs as $key => $childAttr) {
                   $in_name = $childAttr->input_name;
                   if ($request->has("$in_name")) {
                     $attrArr["$in_name"]["values"] = $request["$in_name"];
                     $attrArr["$in_name"]["prices"] = $request["$in_name"."_price"];
                     if ($childAttr->details_status) {
                       $attrArr["$in_name"]["details_status"] = 1;
                     } else {
                       $attrArr["$in_name"]["details_status"] = 0;
                     }
                   }
                 }
               }
             }



             if (empty($attrArr)) {
               $input['attributes'] = NULL;
             } else {
               $jsonAttr = json_encode($attrArr);
               $input['attributes'] = $jsonAttr;
             }

            // Save Data
                $data->fill($input)->save();

            // Set SLug

                $prod = Product::find($data->id);
                if($prod->type != 'Physical'){
                    $prod->slug = str_slug($data->name,'-').'-'.strtolower(str_random(3).$data->id.str_random(3));
                }
                else {
                    $prod->slug = str_slug($data->name,'-').'-'.strtolower($data->sku);
                }
                $photo = $prod->photo;

                // Set Photo
                $resizedImage = Image::make(public_path().'/assets/images/products/'.$prod->photo)->resize(800, null, function ($c) {
                    $c->aspectRatio();
                });
                $photo = time().str_random(8).'.jpg';
                $resizedImage->save(public_path().'/assets/images/products/'.$photo);
                

                
                // Set Thumbnail

                 $background = Image::canvas(300, 300);
                 $resizedImage = Image::make(public_path().'/assets/images/products/'.$prod->photo)->resize(300, 300, function ($c) {
                     $c->aspectRatio();
                     $c->upsize();
                 });
                 // insert resized image centered into background
                 $background->insert($resizedImage, 'center');
                 // save or do whatever you like
                 $thumbnail = time().str_random(8).'.jpg';
                 $background->save(public_path().'/assets/images/thumbnails/'.$thumbnail);

                 
                $prod->thumbnail  = $thumbnail;
                $prod->photo  = $photo;
                $prod->update();

            // Add To Gallery If any
                $lastid = $data->id;
                if ($files = $request->file('gallery')){
                    foreach ($files as  $key => $file){
                        if(in_array($key, $request->galval))
                        {
                    $gallery = new Gallery;
                    $name = time().$file->getClientOriginalName();
                    $img = Image::make($file->getRealPath())->resize(800, null, function ($constraint) {
                        $constraint->aspectRatio();
                    });

    

                    $thumbnail = time().str_random(8).'.jpg';
                    $img->save(public_path().'/assets/images/galleries/'.$name);
                    $gallery['photo'] = $name;
                    $gallery['product_id'] = $lastid;
                    $gallery->save();
                        }
                    }
                }
        //logic Section Ends

        //--- Redirect Section
        $msg = 'New Product Added Successfully.<a href="'.route('vendor-prod-index').'">View Product Lists.</a>';
        return response()->json($msg);
        //--- Redirect Section Ends
        }
        else
        {
          //--- Redirect Section
          return response()->json(array('errors' => [ 0 => 'You Can\'t Add More Product.']));

          //--- Redirect Section Ends
        }
    }


    //*** GET Request
    public function destroy($id)
    {

        $data = Product::findOrFail($id);
        if($data->galleries->count() > 0)
        {
            foreach ($data->galleries as $gal) {
                    if (file_exists(public_path().'/assets/images/galleries/'.$gal->photo)) {
                        unlink(public_path().'/assets/images/galleries/'.$gal->photo);
                    }
                $gal->delete();
            }

        }

        if($data->ratings->count() > 0)
        {
            foreach ($data->ratings  as $gal) {
                $gal->delete();
            }
        }
        if($data->wishlists->count() > 0)
        {
            foreach ($data->wishlists as $gal) {
                $gal->delete();
            }
        }
        if($data->clicks->count() > 0)
        {
            foreach ($data->clicks as $gal) {
                $gal->delete();
            }
        }
        if($data->comments->count() > 0)
        {
            foreach ($data->comments as $gal) {
            if($gal->replies->count() > 0)
            {
                foreach ($gal->replies as $key) {
                    $key->delete();
                }
            }
                $gal->delete();
            }
        }

        if (!filter_var($data->photo,FILTER_VALIDATE_URL)){
            if (file_exists(public_path().'/assets/images/products/'.$data->photo)) {
                unlink(public_path().'/assets/images/products/'.$data->photo);
            }
        }

        if (file_exists(public_path().'/assets/images/thumbnails/'.$data->thumbnail) && $data->thumbnail != "") {
            unlink(public_path().'/assets/images/thumbnails/'.$data->thumbnail);
        }
        if($data->file != null){
            if (file_exists(public_path().'/assets/files/'.$data->file)) {
                unlink(public_path().'/assets/files/'.$data->file);
            }
        }
        $data->delete();
        //--- Redirect Section
        $msg = 'Product Deleted Successfully.';
        return response()->json($msg);
        //--- Redirect Section Ends

// PRODUCT DELETE ENDS
    }

    public function getAttributes(Request $request) {
      $model = '';
      if ($request->type == 'category') {
        $model = 'App\Models\Category';
      } elseif ($request->type == 'subcategory') {
        $model = 'App\Models\Subcategory';
      } elseif ($request->type == 'childcategory') {
        $model = 'App\Models\Childcategory';
      }

      $attributes = Attribute::where('attributable_id', $request->id)->where('attributable_type', $model)->get();
      $attrOptions = [];
      foreach ($attributes as $key => $attribute) {
        $options = AttributeOption::where('attribute_id', $attribute->id)->get();
        $attrOptions[] = ['attribute' => $attribute, 'options' => $options];
      }
      return response()->json($attrOptions);
    }
     public function vpriceupdate(Request $request){  
       // if(!empty($request->checkedid)){
            $count = count($request->checkedid);
            if($request->valuetype=='newprice'){
                $newprice =  $request->pricevalue;
            }
            if($request->valuetype=='addonprice'){
                $addonprice =  $request->pricevalue;
            }
            if($request->valuetype=='addonpercentprice'){
                $addonpercentprice =  $request->pricevalue;
            }
            if($request->valuetype=='reduceonpercentprice'){
                $reduceonpercentprice =  $request->pricevalue;
            }
            if($request->valuetype=='reducefixedprice'){
                $reducefixedprice =  $request->pricevalue;
            }
            
            // if(!empty($request->newprice)){
            //     $newprice =  $request->newprice;
            // }
            // if(!empty($request->addonprice)){
            //     $addonprice =  $request->addonprice;
            // }
            // if(!empty($request->addonpercentprice)){
            //     $addonpercentprice =  $request->addonpercentprice;
            // }
            // if(!empty($request->reduceonpercentprice)){
            //     $reduceonpercentprice =  $request->reduceonpercentprice;
            // }
            // if(!empty($request->reducefixedprice)){
            //     $reducefixedprice =  $request->reducefixedprice;
            // }
             
             
            if($request->gender=='s'){
                for($i=0;$i<=$count-1;$i++){
                    if(!empty($newprice)){
                        $updateprice = ($newprice);
                    }
                    
                    if(!empty($addonprice)){
                        $updateprice = ($request->pricebox[$i]+$addonprice);
                    }
                    if(!empty($addonpercentprice)){
                        $updateprice = ($request->pricebox[$i]+ ($request->pricebox[$i]*$addonpercentprice/100));
                    }
                    if(!empty($reduceonpercentprice)){
                        $updateprice = ($request->pricebox[$i]- ($request->pricebox[$i]*$reduceonpercentprice/100));
                    }
                    if(!empty($reducefixedprice)){
                        $updateprice = ($request->pricebox[$i]-$reducefixedprice);
                    }
                    
                    Product::where('id',$request->checkedid[$i])->update(['price' => $updateprice]);
                }
            }
            if($request->gender=='r'){
                for($i=0;$i<=$count-1;$i++){
                    if(!empty($newprice)){
                        $updateprice = ($newprice);
                    }
                    
                    if(!empty($addonprice)){
                        $updateprice = ($request->pricebox[$i]+$addonprice);
                    }
                    if(!empty($addonpercentprice)){
                        $updateprice = ($request->pricebox[$i]+ ($request->pricebox[$i]*$addonpercentprice/100));
                    }
                    if(!empty($reduceonpercentprice)){
                        $updateprice = ($request->pricebox[$i]- ($request->pricebox[$i]*$reduceonpercentprice/100));
                    }
                    if(!empty($reducefixedprice)){
                        $updateprice = ($request->pricebox[$i]-$reducefixedprice);
                    }
                    
                    Product::where('id',$request->checkedid[$i])->update(['previous_price' => $updateprice]);
                }
            }
            if($request->stock=='instock'){
                for($i=0;$i<=$count-1;$i++){
                Product::where('id',$request->checkedid[$i])->update(['stock' => null]);
                }
            }
            if($request->stock=='outofstock'){
                for($i=0;$i<=$count-1;$i++){
                Product::where('id',$request->checkedid[$i])->update(['stock' => '0']);
                }
            }
            if($request->stock=='stockupdate'){
                for($i=0;$i<=$count-1;$i++){
                    Product::where('id',$request->checkedid[$i])->update(['stock' => $request->staticstock]);
                }
            }
        // }else{
        //   echo "please select Any Product";  
        // }
    }
     public function vbulkstockupdate(Request $request){  
            
          $count = count($request->checkedid);
            for($i=0;$i<=$count-1;$i++){
                
                Product::where('id',$request->checkedid[$i])->update(['stock' => $request->stockselected[$i]]);
            }
     }
}