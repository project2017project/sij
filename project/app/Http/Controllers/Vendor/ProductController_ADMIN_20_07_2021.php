<?php

namespace App\Http\Controllers\Admin;

use App\Models\Childcategory;
use App\Models\Subcategory;
use Datatables;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\Currency;
use App\Models\Gallery;
use App\Models\Attribute;
use App\Models\AttributeOption;
use App\Models\Notify;
use App\Models\Generalsetting;
use App\Classes\GeniusMailer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Validator;
use Image;
use DB;
use Auth;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    //*** JSON Request
    public function datatables()
    {
          $category = (!empty($_GET["category"])) ? ($_GET["category"]) : ('');
          $subcat = (!empty($_GET["subcat"])) ? ($_GET["subcat"]) : ('');
          $childcat = (!empty($_GET["childcat"])) ? ($_GET["childcat"]) : ('');
		  $svendor = (!empty($_GET["svendor"])) ? ($_GET["svendor"]) : ('');
		  $highlight = (!empty($_GET["highlight"])) ? ($_GET["highlight"]) : ('');
		 
		  $colloction = '';
		  $designer = '';
		  $bribal = '';
		  $chokars = '';
		  $others = '';
		   if($highlight=='colloction'){
			 $colloction = 1; 
		  }
		   else if($highlight=='designer'){
			 $designer = 1; 
		  }
		   else if($highlight=='bribal'){
			 $bribal = 1; 
		  }
		   else if($highlight=='chokars'){
			 $chokars = 1; 
		  }
		   else if($highlight=='others'){
			 $others = 1; 
		  }		  
       
		if(!empty($category) || !empty($svendor)){	
		
								
			$query = Product::where('product_type','=','normal');
					if(!empty($category))
						$query->whereRaw("find_in_set($category , category_id)");					
					if(!empty($subcat))
						$query->whereRaw("find_in_set($subcat , subcategory_id)");	
					if(!empty($childcat))
						$query->whereRaw("find_in_set($childcat , childcategory_id)");
                       if(!empty($colloction))
						$query->whereRaw("find_in_set($colloction , colloction)");
                       else if(!empty($designer))
						$query->whereRaw("find_in_set($designer , designer)");
                        else if(!empty($bribal))
						$query->whereRaw("find_in_set($bribal , bribal)");
                        else if(!empty($chokars))
						$query->whereRaw("find_in_set($chokars , chokars)");
                     else if(!empty($others))
						$query->whereRaw("find_in_set($others , others)");					
					if(!empty($svendor))
						$query->where('user_id','=',$svendor);			
			$datas = $query->orderBy('id','desc')->get();		
					
					
        }else{
            $datas = Product::where('product_type','=','normal')->orderBy('id','desc')->get();    
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
                                $stck = (string)$data->stock;
                                if($stck == "0")
                                return "Out Of Stock";
                                elseif($stck == null)
                                return "Unlimited";
                                else
                                return $data->stock;
                            })
                            ->addColumn('status', function(Product $data) {
                                $class = $data->status == 1 ? 'drop-success' : 'drop-danger';
                                $s = $data->status == 1 ? 'selected' : '';
                                $ns = $data->status == 0 ? 'selected' : '';
                                return '<div class="action-list"><select class="process select droplinks '.$class.'"><option data-val="1" value="'. route('admin-prod-status',['id1' => $data->id, 'id2' => 1]).'" '.$s.'>Activated</option><<option data-val="0" value="'. route('admin-prod-status',['id1' => $data->id, 'id2' => 0]).'" '.$ns.'>Deactivated</option>/select></div>';
                            })
                            ->addColumn('action', function(Product $data) {
                                $catalog = $data->type == 'Physical' ? ($data->is_catalog == 1 ? '<a href="javascript:;" data-href="' . route('admin-prod-catalog',['id1' => $data->id, 'id2' => 0]) . '" data-toggle="modal" data-target="#catalog-modal" class="delete"><i class="fas fa-trash-alt"></i> Remove Catalog</a>' : '<a href="javascript:;" data-href="'. route('admin-prod-catalog',['id1' => $data->id, 'id2' => 1]) .'" data-toggle="modal" data-target="#catalog-modal"> <i class="fas fa-plus"></i> Add To Catalog</a>') : '';
                                return '<div class="godropdown">
								<button class="go-dropdown-toggle"> Actions<i class="fas fa-chevron-down"></i></button>
								<div class="action-list">
								<a href="' . route('admin-prod-edit',$data->id) . '"> <i class="fas fa-edit"></i> Edit</a>
								<a href="javascript" class="set-gallery" data-toggle="modal" data-target="#setgallery">
								<input type="hidden" value="'.$data->id.'"><i class="fas fa-eye"></i> View Gallery</a>
								<a data-href="' . route('admin-prod-feature',$data->id) . '" class="feature" data-toggle="modal" data-target="#modal2"><i class="fas fa-star"></i> Highlight</a>
								<a data-href="' . route('admin-prod-quickedit',$data->id) . '" class="quickeditl" data-toggle="modal" data-target="#modal3"><i class="fas fa-star"></i> Quick Edit</a>
								<a href="javascript:;" data-href="' . route('admin-prod-delete',$data->id) . '" data-toggle="modal" data-target="#confirm-delete" class="delete">
								<i class="fas fa-trash-alt"></i> Delete</a></div></div>';
                            })
                            ->rawColumns(['name','image','vendor','price', 'date', 'sku', 'status', 'action','views','category'])
                            ->toJson(); //--- Returning Json Data To Client Side
    }
	
	
	  public function simple_datatables()
    {
        $datas = Product::where('product_type','=','normal')->whereNull('size')->orderBy('id','desc')->get();

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
                                $sign = Currency::where('is_default','=',1)->first();
                                $price = round($data->price * $sign->value , 2);
                                $price = '<span class="text-success"><b>'.$sign->sign.$price.'</b></span>' ;
                                $price_reg = round($data->previous_price * $sign->value , 2);
                                if(empty($data->previous_price)){
                                    $price_reg='';
                                }else{
                                    $price_reg = '<br /> <del class="text-danger" >'.$sign->sign.$price_reg.'<del>' ;
                                }
                                return  $price.$price_reg;
                            })
                            
                            ->editColumn('stock', function(Product $data) {
                                $stck = (string)$data->stock;
                                if($stck == "0")
                                return "Out Of Stock";
                                elseif($stck == null)
                                return "Unlimited";
                                else
                                return $data->stock;
                            })
                            ->addColumn('status', function(Product $data) {
                                $class = $data->status == 1 ? 'drop-success' : 'drop-danger';
                                $s = $data->status == 1 ? 'selected' : '';
                                $ns = $data->status == 0 ? 'selected' : '';
                                return '<div class="action-list"><select class="process select droplinks '.$class.'"><option data-val="1" value="'. route('admin-prod-status',['id1' => $data->id, 'id2' => 1]).'" '.$s.'>Activated</option><<option data-val="0" value="'. route('admin-prod-status',['id1' => $data->id, 'id2' => 0]).'" '.$ns.'>Deactivated</option>/select></div>';
                            })                           
                            ->rawColumns(['name','image','vendor','price', 'date', 'sku', 'status'])
                            ->toJson(); //--- Returning Json Data To Client Side
    }

    //*** JSON Request
    public function deactivedatatables()
    {
         $datas = Product::where('status','=',0)->orderBy('id','desc')->get();

         //--- Integrating This Collection Into Datatables
         return Datatables::of($datas)
                            ->editColumn('name', function(Product $data) {
                                $name = mb_strlen(strip_tags($data->name),'utf-8') > 50 ? mb_substr(strip_tags($data->name),0,50,'utf-8').'...' : strip_tags($data->name);
                                $id = '<small>ID: <a href="'.route('front.product', $data->slug).'" target="_blank">'.sprintf("%'.08d",$data->id).'</a></small>';
                                $id2 = $data->user_id != 0 ? ( count($data->user->products) > 0 ? '<small class="ml-2"> VENDOR: <a href="'.route('admin-vendor-show',$data->user_id).'" target="_blank">'.$data->user->shop_name.'</a></small>' : '' ) : '';

                                $id3 = $data->type == 'Physical' ?'<small class="ml-2"> <a href="'.route('front.product', $data->slug).'" target="_blank">'.$data->sku.'</a>' : '';

                                return  $name.'<br>'.$id.$id3.$id2;
                            })
                            ->editColumn('price', function(Product $data) {
                                $sign = Currency::where('is_default','=',1)->first();
                                $price = round($data->price * $sign->value , 2);
                                $price = $sign->sign.$price ;
                                return  $price;
                            })
                            
                            ->editColumn('stock', function(Product $data) {
                                $stck = (string)$data->stock;
                                if($stck == "0")
                                return "Out Of Stock";
                                elseif($stck == null)
                                return "Unlimited";
                                else
                                return $data->stock;
                            })
                            ->addColumn('status', function(Product $data) {
                                $class = $data->status == 1 ? 'drop-success' : 'drop-danger';
                                $s = $data->status == 1 ? 'selected' : '';
                                $ns = $data->status == 0 ? 'selected' : '';
                                return '<div class="action-list"><select class="process select droplinks '.$class.'"><option data-val="1" value="'. route('admin-prod-status',['id1' => $data->id, 'id2' => 1]).'" '.$s.'>Activated</option><<option data-val="0" value="'. route('admin-prod-status',['id1' => $data->id, 'id2' => 0]).'" '.$ns.'>Deactivated</option>/select></div>';
                            })
                            ->addColumn('action', function(Product $data) {
                                $catalog = $data->type == 'Physical' ? ($data->is_catalog == 1 ? '<a href="javascript:;" data-href="' . route('admin-prod-catalog',['id1' => $data->id, 'id2' => 0]) . '" data-toggle="modal" data-target="#catalog-modal" class="delete"><i class="fas fa-trash-alt"></i> Remove Catalog</a>' : '<a href="javascript:;" data-href="'. route('admin-prod-catalog',['id1' => $data->id, 'id2' => 1]) .'" data-toggle="modal" data-target="#catalog-modal"> <i class="fas fa-plus"></i> Add To Catalog</a>') : '';
                                return '<div class="godropdown"><button class="go-dropdown-toggle"> Actions<i class="fas fa-chevron-down"></i></button><div class="action-list"><a href="' . route('admin-prod-edit',$data->id) . '"> <i class="fas fa-edit"></i> Edit</a><a href="javascript" class="set-gallery" data-toggle="modal" data-target="#setgallery"><input type="hidden" value="'.$data->id.'"><i class="fas fa-eye"></i> View Gallery</a>'.$catalog.'<a data-href="' . route('admin-prod-feature',$data->id) . '" class="feature" data-toggle="modal" data-target="#modal2"> <i class="fas fa-star"></i> Highlight</a><a href="javascript:;" data-href="' . route('admin-prod-delete',$data->id) . '" data-toggle="modal" data-target="#confirm-delete" class="delete"><i class="fas fa-trash-alt"></i> Delete</a></div></div>';
                            })
                            ->rawColumns(['name', 'status', 'action'])
                            ->toJson(); //--- Returning Json Data To Client Side
    }


    //*** JSON Request
    public function catalogdatatables()
    {
         $datas = Product::where('is_catalog','=',1)->orderBy('id','desc')->get();

         //--- Integrating This Collection Into Datatables
         return Datatables::of($datas)
                            ->editColumn('name', function(Product $data) {
                                $name = mb_strlen(strip_tags($data->name),'utf-8') > 50 ? mb_substr(strip_tags($data->name),0,50,'utf-8').'...' : strip_tags($data->name);
                                $id = '<small>ID: <a href="'.route('front.product', $data->slug).'" target="_blank">'.sprintf("%'.08d",$data->id).'</a></small>';

                                $id3 = $data->type == 'Physical' ?'<small class="ml-2"> <a href="'.route('front.product', $data->slug).'" target="_blank">'.$data->sku.'</a>' : '';

                                return  $name.'<br>'.$id.$id3;
                            })
                            ->editColumn('price', function(Product $data) {
                                $sign = Currency::where('is_default','=',1)->first();
                                $price = round($data->price * $sign->value , 2);
                                $price = $sign->sign.$price ;
                                return  $price;
                            })
                            ->editColumn('stock', function(Product $data) {
                                $stck = (string)$data->stock;
                                if($stck == "0")
                                return "Out Of Stock";
                                elseif($stck == null)
                                return "Unlimited";
                                else
                                return $data->stock;
                            })
                            ->addColumn('status', function(Product $data) {
                                $class = $data->status == 1 ? 'drop-success' : 'drop-danger';
                                $s = $data->status == 1 ? 'selected' : '';
                                $ns = $data->status == 0 ? 'selected' : '';
                                return '<div class="action-list"><select class="process select droplinks '.$class.'"><option data-val="1" value="'. route('admin-prod-status',['id1' => $data->id, 'id2' => 1]).'" '.$s.'>Activated</option><<option data-val="0" value="'. route('admin-prod-status',['id1' => $data->id, 'id2' => 0]).'" '.$ns.'>Deactivated</option>/select></div>';
                            })
                            ->addColumn('action', function(Product $data) {
                                return '<div class="godropdown"><button class="go-dropdown-toggle"> Actions<i class="fas fa-chevron-down"></i></button><div class="action-list"><a href="' . route('admin-prod-edit',$data->id) . '"> <i class="fas fa-edit"></i> Edit</a><a href="javascript" class="set-gallery" data-toggle="modal" data-target="#setgallery"><input type="hidden" value="'.$data->id.'"><i class="fas fa-eye"></i> View Gallery</a><a data-href="' . route('admin-prod-feature',$data->id) . '" class="feature" data-toggle="modal" data-target="#modal2"> <i class="fas fa-star"></i> Highlight</a><a href="javascript:;" data-href="' . route('admin-prod-catalog',['id1' => $data->id, 'id2' => 0]) . '" data-toggle="modal" data-target="#confirm-delete" class="delete"><i class="fas fa-trash-alt"></i> Remove Catalog</a></div></div>';
                            })
                            ->rawColumns(['name', 'status', 'action'])
                            ->toJson(); //--- Returning Json Data To Client Side
    }
     //*** JSON Request
    public function productupdatedatatables()
    {
        $datas = Product::where('product_type','=','normal')->where('stock','!=','null')->orderBy('id','desc')->get();

         //--- Integrating This Collection Into Datatables
         return Datatables::of($datas)
                            ->editColumn('name', function(Product $data) {
                                
                                $name = mb_strlen(strip_tags($data->name),'utf-8') > 50 ? mb_substr(strip_tags($data->name),0,50,'utf-8').'...' : strip_tags($data->name);
                                $id = '<small>ID: <a href="'.route('front.product', $data->slug).'" target="_blank">'.sprintf("%'.08d",$data->id).'</a></small>';
                                $id2 = $data->user_id != 0 ? ( count($data->user->products) > 0 ? '<small class="ml-2"> VENDOR: <a href="'.route('admin-vendor-show',$data->user_id).'" target="_blank">'.$data->user->shop_name.'</a></small>' : '' ) : '';

                                $id3 = $data->type == 'Physical' ?'<small class="ml-2"> <a href="'.route('front.product', $data->slug).'" target="_blank">'.$data->sku.'</a>' : '';

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
                                return '<div class="action-list"><select class="process select droplinks '.$class.'"><option data-val="1" value="'. route('admin-prod-status',['id1' => $data->id, 'id2' => 1]).'" '.$s.'>Activated</option><<option data-val="0" value="'. route('admin-prod-status',['id1' => $data->id, 'id2' => 0]).'" '.$ns.'>Deactivated</option>/select></div>';
                            })
                            ->addColumn('action', function(Product $data) {
                                $catalog = $data->type == 'Physical' ? ($data->is_catalog == 1 ? '<a href="javascript:;" data-href="' . route('admin-prod-catalog',['id1' => $data->id, 'id2' => 0]) . '" data-toggle="modal" data-target="#catalog-modal" class="delete"><i class="fas fa-trash-alt"></i> Remove Catalog</a>' : '<a href="javascript:;" data-href="'. route('admin-prod-catalog',['id1' => $data->id, 'id2' => 1]) .'" data-toggle="modal" data-target="#catalog-modal"> <i class="fas fa-plus"></i> Add To Catalog</a>') : '';
                                return '<div class="godropdown"><button class="go-dropdown-toggle"> Actions<i class="fas fa-chevron-down"></i></button><div class="action-list"><a href="' . route('admin-prod-edit',$data->id) . '"> <i class="fas fa-edit"></i> Edit</a><a href="javascript" class="set-gallery" data-toggle="modal" data-target="#setgallery"><input type="hidden" value="'.$data->id.'"><i class="fas fa-eye"></i> View Gallery</a><a data-href="' . route('admin-prod-feature',$data->id) . '" class="feature" data-toggle="modal" data-target="#modal2"> <i class="fas fa-star"></i> Highlight</a><a href="javascript:;" data-href="' . route('admin-prod-delete',$data->id) . '" data-toggle="modal" data-target="#confirm-delete" class="delete"><i class="fas fa-trash-alt"></i> Delete</a></div></div>';
                            })
                            ->rawColumns(['name','stock', 'status', 'action','update_by'])
                            ->toJson(); //--- Returning Json Data To Client Side
    }
    //*** GET Request
    public function index()
    {
        $cats = Category::all();
		$users = User::all()->where('is_vendor','2');
        return view('admin.product.index',compact('cats','users'));
    }
	
	 //*** GET Request simpleproduct
    public function simpleproduct()
    {
        $cats = Category::all();
		$users = User::all()->where('is_vendor','2');
        return view('admin.product.simpleproduct',compact('cats','users'));
    }
	
    //*** GET Request
    public function productupdate()
    {
        return view('admin.product.productupdate');
    }

    //*** GET Request
    public function deactive()
    {
        return view('admin.product.deactive');
    }

    //*** GET Request
    public function catalogs()
    {
        return view('admin.product.catalog');
    }

    //*** GET Request
    public function types()
    {
        return view('admin.product.types');
    }

    //*** GET Request
    public function createPhysical()
    {
        $vendors = User::where('is_vendor','=',2)->get();
        $cats = Category::all();
        $sign = Currency::where('is_default','=',1)->first();
        return view('admin.product.create.physical',compact('cats','sign','vendors'));
    }

    //*** GET Request
    public function createDigital()
    {
        $cats = Category::all();
        $sign = Currency::where('is_default','=',1)->first();
        return view('admin.product.create.digital',compact('cats','sign'));
    }

    //*** GET Request
    public function createLicense()
    {
        $cats = Category::all();
        $sign = Currency::where('is_default','=',1)->first();
        return view('admin.product.create.license',compact('cats','sign'));
    }

    //*** GET Request
    public function status($id1,$id2)
    {
        $data = Product::findOrFail($id1);
        $data->status = $id2;
        $data->update();
    }

    //*** GET Request
    public function catalog($id1,$id2)
    {
        $data = Product::findOrFail($id1);
        $data->is_catalog = $id2;
        $data->update();
        if($id2 == 1) {
            $msg = "Product added to catalog successfully.";
        }
        else {
            $msg = "Product removed from catalog successfully.";
        }

        return response()->json($msg);

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

        $img = Image::make(public_path().'/assets/images/products/'.$data->photo)->fit(270, 360);
        $thumbnail = time().str_random(8).'.jpg';
        $img->save(public_path().'/assets/images/thumbnails/'.$thumbnail);
        $data->thumbnail  = $thumbnail;
        $data->update();
        return response()->json(['status'=>true,'file_name' => $image_name]);
    }

    //*** POST Request
    //*** POST Request
    public function store(Request $request)
    {

        //--- Validation Section
        $rules = [
            'photo'      => 'required',
			//'size_image'      => 'required',
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
        if ($file = $request->file('file')) {
            $name = time().$file->getClientOriginalName();
            $file->move('assets/files',$name);
            $input['file'] = $name;
        }
		
		
        $image = $request->photo;
        list($type, $image) = explode(';', $image);
        list(, $image)      = explode(',', $image);
        $image = base64_decode($image);
        $image_name = time().str_random(8).'.png';
        $path = 'assets/images/products/'.$image_name;
        file_put_contents($path, $image);
        $input['photo'] = $image_name;

        // Check Physical
        if($request->type == "Physical"){
            
            if(!empty($input['category_multi_id'])){
                $input['category_multi_id'] =  implode(',', (array) $request->get('category_multi_id'));
            }else{
                $input['category_multi_id'] =  NULL;
            }
            if(!empty($input['subcategory_multi_id'])){
                $input['subcategory_multi_id'] =  implode(',', (array) $request->get('subcategory_multi_id'));
            }else{
                $input['subcategory_multi_id'] =  NULL;
            }
            if(!empty($input['childcategory_multi_id'])){
                $input['childcategory_multi_id'] =  implode(',', (array) $request->get('childcategory_multi_id'));
            }else{
                $input['childcategory_multi_id'] =  NULL;
            }
           
           
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
            $input['user_id'] = $request->user_id;
            // Check Size
			
			
            if(empty($request->size_check ))
            {
                $input['size'] = null;
                $input['size_qty'] = null;
                $input['size_price'] = null;
				$input['size_pre_price'] = null;
				$input['size_image'] = null;
            }
            else{
                if(in_array(null, $request->size) || in_array(null, $request->size_qty))
                {
                    $input['size'] = null;
                    $input['size_qty'] = null;
                    $input['size_price'] = null;
					$input['size_pre_price'] = null;
					$input['size_image'] = null;
                }
                else
                {
					

                    $input['size'] = implode(',', $request->size);
                    $input['size_qty'] = implode(',', $request->size_qty);
                    $input['size_price'] = implode(',', $request->size_price);
					$input['size_pre_price'] = implode(',', $request->size_pre_price);
					
					$images = $request->file('size_image');
					
                  if ($request->hasFile('size_image')) {
                    foreach ($images as $item){         
			          $imageName = time().$item->getClientOriginalName(); 
                      $item->move('assets/images/products/',$imageName);					  
                      $arr[] = $imageName;
                      }
					  $input['size_image'] =  implode(',', $arr);                     
                    } else {
                        $input['size_image'] = '';
                    }

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
		if($request->features || $request->colors){
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
		}

        //tags
        if (!empty($request->tags))
        {
            $input['tags'] = implode(',', $request->tags);
        }



        // Conert Price According to Currency
        $input['price'] = ($input['price'] / $sign->value);
        $input['previous_price'] = ($input['previous_price'] / $sign->value);
		
       if (empty($request->draft)){
            $input['status'] = 1;
           
         }else {
            $input['status'] = 0;
        }


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

        // Set Thumbnail
        $img = Image::make(public_path().'/assets/images/products/'.$prod->photo)->fit(270, 360);
        $thumbnail = time().str_random(8).'.jpg';
        $img->save(public_path().'/assets/images/thumbnails/'.$thumbnail);
        $prod->thumbnail  = $thumbnail;
        $prod->update();
        $image = '/assets/images/products/'.$prod->photo;
        // Add To Gallery If any
        $lastid = $data->id;
        if ($files = $request->file('gallery')){
            foreach ($files as  $key => $file){
                if(in_array($key, $request->galval))
                {
                    $gallery = new Gallery;
                    $name = time().$file->getClientOriginalName();
                    $file->move('assets/images/galleries',$name);
                    $gallery['photo'] = $name;
                    $gallery['product_id'] = $lastid;
                    $gallery->save();
                }
            }
        }
        //logic Section Ends

        $gs = Generalsetting::findOrFail(1);
        if($gs->is_webpushr == 1){
            $key = $gs->webpushrKey;
            $token = $gs->webpushrAuthToken;
        $url = $request->getSchemeAndHttpHost();
        $end_point = 'https://api.webpushr.com/v1/notification/send/all';
        $http_header = array( 
                                "Content-Type: Application/Json", 
                                $key, 
                                $token
                            );
        $req_data = array('title'=>"New Product Alert",'message'=>$data->name, 'target_url' =>'/item/'.$prod->slug,'image'=>$url.'/'.$image,'icon'=>$url.'/'.$image
        );
     
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER, $http_header);
        curl_setopt($ch, CURLOPT_URL, $end_point );
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($req_data) );
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
        $response = curl_exec($ch);
        ob_start();
        $msg = 'New Product Added Successfully.<a href="'.route('admin-prod-index').'">View Product Lists.</a>';
        return response()->json($msg);
        
        ob_end_flush();
        ob_flush();
        flush();
        echo $response;
        }else{
            $msg = 'New Product Added Successfully.<a href="'.route('admin-prod-index').'">View Product Lists.</a>';
        return response()->json($msg);
        }
    }

    //*** POST Request
    public function import(){

        $cats = Category::all();
        $sign = Currency::where('is_default','=',1)->first();
        return view('admin.product.productcsv',compact('cats','sign'));
    }

    public function importSubmit(Request $request)
    {
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

                            $input['photo']             = $line[5];
                            $input['attributes']        = $line[16];
                            $input['price']             = $line[7];
                          if($request->subcategory_id){
								$input['subcategory_id']    = $request->subcategory_id;
							}
                           
						   if($request->childcategory_id){
								 $input['childcategory_id']  = $request->childcategory_id;
							}
                            $input['name']              = $line[4];
                            $input['size']              = $line[10];
                            $input['size_qty']          = $line[11];
                            $input['size_price']        = $line[12];
                             $input['meta_tag']          = $line[14];
                                $input['meta_description']  = $line[15];
                              $input['details']           = $line[17];
                               // $input['category_id']       = $request->category_id;
                            $input['previous_price']    = $line[8];
                            $input['stock']             = $line[9];
                            
                            $input['tags']              = $line[13];
							$input['user_id']           = $line[18];
							$input['size_pre_price']           = $line[19];
							$input['size_image']           = $line[20];
							$input['short_details']           = $line[21];
							$input['youtube']           = $line[22];
							$input['slug']           = $line[23];
							$input['other_image']           = $line[24];
							$input['status']           = $line[25];
                            


                                // Conert Price According to Currency
                                $input['price'] = ($input['price'] / $sign->value);
                                $input['previous_price'] = ($input['previous_price'] / $sign->value);

                                // Save Data
                                $data->fill($input)->save();

                                // Set SLug
                                $prod = Product::find($data->id);
                                 if(empty($line[23])){
									$prod->slug = str_slug($data->name,'-').'-'.strtolower($data->sku); 
								 }
                                

                                // Set Thumbnail


                                $img = Image::make($line[5])->fit(270, 360);
                                $thumbnail = time().str_random(8).'.jpg';
                                $img->save(public_path().'/assets/images/thumbnails/'.$thumbnail);
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


    //*** GET Request
    public function edit($id)
    {
        if(!Product::where('id',$id)->exists())
        {
            return redirect()->route('admin.dashboard')->with('unsuccess',__('Sorry the page does not exist.'));
        }
        $vendors = User::where('is_vendor','=',2)->get();
        $cats = Category::all();
        $data = Product::findOrFail($id);
        $sign = Currency::where('is_default','=',1)->first();


        if($data->type == 'Digital')
            return view('admin.product.edit.digital',compact('cats','data','sign','vendors'));
        elseif($data->type == 'License')
            return view('admin.product.edit.license',compact('cats','data','sign','vendors'));
        else
            return view('admin.product.edit.physical',compact('cats','data','sign','vendors'));
    }

    //*** POST Request on product update
    public function update(Request $request, $id){	
	
        $notify=1;
        
        if(!empty($request->size_qty)){
            $qty = array_sum($request->size_qty);
            if($qty>0){
                $notify = 0;       
            }    
        }else{
            if($request->stock > 0){
                $notify = 0;
            }
        }
        
        
        
        /*if($notify == 0){
            $productCheck = Notify::where('product_id','=',$id)->get();
                if(!empty($productCheck)){
                    foreach($productCheck as $notifyuser){
                         
                        $message ="Product Name in stock ";
                        $to = $notifyuser->email;
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
        
                        $upate = Notify::where('id', '=', $notifyuser->id)
                                    ->update(array('status' => 1));
                    }
                }
        }*/
        
        $rules = ['file' => 'mimes:zip'];
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()){ return response()->json(array('errors' => $validator->getMessageBag()->toArray()));}
        $data = Product::findOrFail($id);
        $sign = Currency::where('is_default','=',1)->first();
        $input = $request->all();
        if($request->type_check == 1){
            $input['link'] = null;
        }else{
            if($data->file!=null){
                if (file_exists(public_path().'/assets/files/'.$data->file)) {
                    unlink(public_path().'/assets/files/'.$data->file);
                }
            }
            $input['file'] = null;
        }
        if($data->type == "Physical"){
            if(!empty($input['category_multi_id'])){
                $input['category_multi_id'] =  implode(',', (array) $request->get('category_multi_id'));
            }else{
                $input['category_multi_id'] =  NULL;
            }
            if(!empty($input['subcategory_multi_id'])){
                $input['subcategory_multi_id'] =  implode(',', (array) $request->get('subcategory_multi_id'));
            }else{
                $input['subcategory_multi_id'] =  NULL;
            }
            if(!empty($input['childcategory_multi_id'])){
                $input['childcategory_multi_id'] =  implode(',', (array) $request->get('childcategory_multi_id'));
            }else{
                $input['childcategory_multi_id'] =  NULL;
            }
            $rules = ['sku' => 'min:8|unique:products,sku,'.$id];
            $validator = Validator::make(Input::all(), $rules);
            if ($validator->fails()) { return response()->json(array('errors' => $validator->getMessageBag()->toArray()));}
            if ($request->product_condition_check == ""){     $input['product_condition'] = 0;  }
            if ($request->shipping_time_check == ""){$input['ship'] = null;}
            if(empty($request->size_check )){
                $input['size'] = null;
                $input['size_qty'] = null;
                $input['size_price'] = null;
				$input['size_pre_price'] = null;
            }else{
                if(in_array(null, $request->size) || in_array(null, $request->size_qty) || in_array(null, $request->size_price)){
                    $input['size'] = null;
                    $input['size_qty'] = null;
                    $input['size_price'] = null;
					$input['size_pre_price'] = null;
                }else{
					if($request->size){
						$input['size'] = implode(',', $request->size);
					}
                    if($request->size_qty){
                    $input['size_qty'] = implode(',', $request->size_qty);
					}
					if($request->size_price){
                    $input['size_price'] = implode(',', $request->size_price);
					}
					if($request->size_pre_price){
					$input['size_pre_price'] = implode(',', $request->size_pre_price);
					}
					
					
					
					$images = $request->file('size_image');
		            $productdata = Product::findOrFail($id);
		            $data_image=array();
		            $data_image=explode(',',$productdata->size_image);
		
					if($images) {
                  if ($request->hasFile('size_image')) {
                    foreach ($images as  $key => $item){         
			          $imageName = time().$item->getClientOriginalName(); 
                      $item->move('assets/images/products/',$imageName);					  
                      $arr[$key] = $imageName;
                      }					                      
                    } else {                        
                    }
					
					$product_array=array_replace_recursive($data_image, $arr);
					$input['size_image'] = implode(',', $product_array);
					}
					
					
                }
            }
            if(empty($request->whole_check )){
                $input['whole_sell_qty'] = null;
                $input['whole_sell_discount'] = null;
            }else{
                if(in_array(null, $request->whole_sell_qty) || in_array(null, $request->whole_sell_discount)){
                    $input['whole_sell_qty'] = null;
                    $input['whole_sell_discount'] = null;
                }else{
                    $input['whole_sell_qty'] = implode(',', $request->whole_sell_qty);
                    $input['whole_sell_discount'] = implode(',', $request->whole_sell_discount);
                }
            }
            if(empty($request->color_check )){
                $input['color'] = null;
            }else{
                if (!empty($request->color)){$input['color'] = implode(',', $request->color);}
                if (empty($request->color)){$input['color'] = null;}
            }

            if ($request->measure_check == ""){
                $input['measure'] = null;
            }
                     
        }

        if (empty($request->seo_check)){
            $input['meta_tag'] = null;
            $input['meta_description'] = null;
         }else {
            if (!empty($request->meta_tag)){
                $input['meta_tag'] = implode(',', $request->meta_tag);
            }
        }

        if($data->type == "License"){
            if(!in_array(null, $request->license) && !in_array(null, $request->license_qty)){
                $input['license'] = implode(',,', $request->license);
                $input['license_qty'] = implode(',', $request->license_qty);
            }else{
                if(in_array(null, $request->license) || in_array(null, $request->license_qty)){
                    $input['license'] = null;
                    $input['license_qty'] = null;
                }else{
                    $license = explode(',,', $prod->license);
                    $license_qty = explode(',', $prod->license_qty);
                    $input['license'] = implode(',,', $license);
                    $input['license_qty'] = implode(',', $license_qty);
                }
            }
        }
        
		if($request->features && $request->colors){
        if(!in_array(null, $request->features) && !in_array(null, $request->colors)){
                $input['features'] = implode(',', str_replace(',',' ',$request->features));
                $input['colors'] = implode(',', str_replace(',',' ',$request->colors));
        }else{
            if(in_array(null, $request->features) || in_array(null, $request->colors)){
                $input['features'] = null;
                $input['colors'] = null;
            }else{
                $features = explode(',', $data->features);
                $colors = explode(',', $data->colors);
                $input['features'] = implode(',', $features);
                $input['colors'] = implode(',', $colors);
            }
        }
		}

        if (!empty($request->tags)){$input['tags'] = implode(',', $request->tags);}
        if (empty($request->tags)){$input['tags'] = null;}
        $input['price'] = $input['price'] / $sign->value;
        $input['previous_price'] = $input['previous_price'] / $sign->value;

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
        $input['user_id'] = $request->user_id;
        $data->update($input);
        $prod = Product::find($data->id);
        $prod->slug = str_slug($data->name,'-').'-'.strtolower($data->sku);
        $prod->update();
        $msg = 'Product Updated Successfully.<a href="'.route('admin-prod-index').'">View Product Lists.</a>';
        return response()->json($msg);
    }


    //*** GET Request
    public function feature($id)
    {
            $data = Product::findOrFail($id);
            return view('admin.product.highlight',compact('data'));
    }
	
	//*** GET Request
    public function quickedit($id)
    {
            $data = Product::findOrFail($id);
            return view('admin.product.quickedit',compact('data'));
    }
	
	//*** POST Request
    public function quickeditsubmit(Request $request, $id)
    {
		//-- Logic Section
        $data = Product::findOrFail($id);
        $input = $request->all();
        if($request->name == ""){$input['name'] = 0;}
        if($request->price == ""){$input['price'] = 0;}
        if($request->previous_price == ""){$input['previous_price'] = 0;}
        if($request->sku == ""){$input['sku'] = 0;}
        if($request->stock == ""){$input['stock'] = null;}
        $data->update($input);
        $msg = 'Product Updated Successfully.';
        return response()->json($msg);
        
	}

    //*** POST Request
    public function featuresubmit(Request $request, $id)
    {
        //-- Logic Section
        $data = Product::findOrFail($id);
        $input = $request->all();
        if($request->featured == ""){$input['featured'] = 0;}
        if($request->hot == ""){$input['hot'] = 0;}
        if($request->best == ""){$input['best'] = 0;}
        if($request->top == ""){$input['top'] = 0;}
        if($request->latest == ""){$input['latest'] = 0;}
        if($request->big == ""){$input['big'] = 0;}
        if($request->trending == ""){$input['trending'] = 0;}
        if($request->sale == ""){$input['sale'] = 0;}
        if($request->is_discount == ""){$input['is_discount'] = 0;$input['discount_date'] = null;}
		if($request->colloction == ""){$input['colloction'] = 0;}
		if($request->designer == ""){$input['designer'] = 0;}
		if($request->chokars == ""){$input['chokars'] = 0;}
		if($request->bribal == ""){$input['bribal'] = 0;}
		if($request->others == ""){$input['others'] = 0;}
		
        $data->update($input);
        //-- Logic Section Ends

        //--- Redirect Section
        $msg = 'Highlight Updated Successfully.';
        return response()->json($msg);
        //--- Redirect Section Ends
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

        if($data->reports->count() > 0)
        {
            foreach ($data->reports as $gal) {
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
    
    public function priceupdate(Request $request){  
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
                    
                    Product::where('id',$request->checkedid[$i])->where('size_qty','=',null)->update(['price' => $updateprice]);
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
                    
                    Product::where('id',$request->checkedid[$i])->where('size_qty','=',null)->update(['previous_price' => $updateprice]);
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
                    Product::where('id',$request->checkedid[$i])->where('size_qty','=',null)->update(['stock' => $request->staticstock]);
                }
            }
        // }else{
        //   echo "please select Any Product";  
        // }
    }
     public function bulkstockupdate(Request $request){  
        $user =  Auth::user()->id;
          $count = count($request->checkedid);
            for($i=0;$i<=$count-1;$i++){
                Product::where('id',$request->checkedid[$i])->update(['stock' => $request->stockselected[$i],'update_by'=>$user]);
            }
     }
    
}
