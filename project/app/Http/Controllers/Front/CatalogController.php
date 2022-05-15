<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Childcategory;
use App\Models\Comment;
use App\Models\Currency;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductClick;
use App\Models\Rating;
use App\Models\Refund;
use App\Models\Reply;
use App\Models\Report;
use App\Models\Subcategory;
use App\Models\SearchResult;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Session;
use Illuminate\Support\Facades\Input;
use Validator;


class CatalogController extends Controller
{
  public function categories(){
    return view('front.categories');
  }

  public function category(Request $request, $slug=null, $slug1=null, $slug2=null){
	  
    $product_data = Product::where('status','=',1)->get();
	$total_stock = 0;
	if($product_data){
	foreach ($product_data as $key => $product_val) {
		$total_stock = $product_val->stock;
		if(!empty($product_val->size_qty)){
			foreach($product_val->size_qty as $skey => $skeydata){
			$total_stock += $product_val->size_qty[$skey];
			}
		}
		$product_up = Product::where('id','=',$product_val->id)->update(['sum_stock' => $total_stock]);
	}
	}
	
    if (Session::has('currency')){
      $curr = Currency::find(Session::get('currency'));
    }else{
      $curr = Currency::where('is_default','=',1)->first();
    }
    $cat = null;
    $subcat = null;
    $childcat = null;
    $minprice = $request->min;
    $maxprice = $request->max;
    $sort = $request->sort;
    $sorttext = $request->sorttext;
    $search = $request->search;
    $minprice = round(($minprice / $curr->value),2);
    $maxprice = round(($maxprice / $curr->value),2);

    if (!empty($slug)) {
      $cat = Category::where('slug', $slug)->firstOrFail();
      $data['cat'] = $cat;
	  $data['slug'] = $slug;
	  $data['slug1'] = '';
	  $data['slug2'] = '';
    }
    if (!empty($slug1)) {
      $subcat = Subcategory::where('slug', $slug1)->firstOrFail();
      $data['subcat'] = $subcat;
	  $data['slug'] = '';
	  $data['slug1'] = $slug1;
	  $data['slug2'] = '';
    }
    if (!empty($slug2)) {
      $childcat = Childcategory::where('slug', $slug2)->firstOrFail();
      $data['childcat'] = $childcat;
	  $data['slug'] = '';
	  $data['slug1'] = '';
	  $data['slug2'] = $slug2;
    }
    $search = new SearchResult;
    $search->search_name = $request->search;
    $search->date = Carbon::now();
    $search->save();

    if(!empty($search->search_name)){
      $prods = Product::when($search, function ($query, $search) {
        return $query->where('name', 'like', '%' . $search->search_name . '%')->orWhere('sku', 'like', $search->search_name . '%');
        })

      ->when($sort, function ($query, $sort) {
        if ($sort=='date_desc') {
          return $query->orderBy('id', 'DESC');
        }
        elseif($sort=='date_asc') {
          return $query->orderBy('id', 'ASC');
        }
        elseif($sort=='price_desc') {
          return $query->orderBy('minPrice', 'DESC');
        }
        elseif($sort=='price_asc') {
          return $query->orderBy('minPrice', 'ASC');
        }elseif($sort=='popular_product') {
          return $query->orderBy('popular_count', 'DESC');
        }
      })
      ->when(empty($sort), function ($query, $sort) {
        return $query->orderBy('id', 'DESC');
      });
    }else{


      $prods = Product::when($cat, function ($query, $cat) {
        return $query->whereRaw("find_in_set($cat->id,category_id)");
        //return $query->where('category_multi_id', $cat->id);
      })
      ->when($sorttext, function ($query, $sorttext) {
                                        return $query->Where('name', 'like', '%' . $sorttext . '%')->orWhere('sku', 'like', '%' . $sorttext . '%');
                                  })
      ->when($subcat, function ($query, $subcat) {
        return $query->whereRaw("find_in_set($subcat->id,subcategory_id)");
        //return $query->where('subcategory_multi_id', $subcat->id);
      })
      ->when($childcat, function ($query, $childcat) {
        return $query->whereRaw("find_in_set($childcat->id,childcategory_id)");
        //return $query->where('childcategory_multi_id', $childcat->id);
      })
                                //   ->when($search, function ($query, $search) {
                                //       return $query->whereRaw('MATCH (name) AGAINST (? IN BOOLEAN MODE)' , array($search));
                                //   })
      ->when($minprice, function($query, $minprice) {
        return $query->where('price', '>=', $minprice);
      })
      ->when($maxprice, function($query, $maxprice) {
        return $query->where('price', '<=', $maxprice);
      })
      ->when($sort, function ($query, $sort) {
        if ($sort=='date_desc') {
          return $query->orderBy('id', 'DESC');
        }
        elseif($sort=='date_asc') {
          return $query->orderBy('id', 'ASC');
        }
        elseif($sort=='price_desc') {
          return $query->orderBy('minPrice', 'DESC');
        }
        elseif($sort=='price_asc') {
          return $query->orderBy('minPrice', 'ASC');
        }elseif($sort=='popular_product') {
          return $query->orderBy('popular_count', 'DESC');
        }
      })
      ->when(empty($sort), function ($query, $sort) {
        return $query->orderBy('id', 'DESC');
      });
    }

    $prods = $prods->where(function ($query) use ($cat, $subcat, $childcat, $request) {
      $flag = 0;

      if (!empty($cat)) {
        foreach ($cat->attributes as $key => $attribute) {
          $inname = $attribute->input_name;
          $chFilters = $request["$inname"];
          if (!empty($chFilters)) {
            $flag = 1;
            foreach ($chFilters as $key => $chFilter) {
              if ($key == 0) {
                $query->where('attributes', 'like', '%'.'"'.$chFilter.'"'.'%');
              } else {
                $query->orWhere('attributes', 'like', '%'.'"'.$chFilter.'"'.'%');
              }

            }
          }
        }
      }


      if (!empty($subcat)) {
        foreach ($subcat->attributes as $attribute) {
          $inname = $attribute->input_name;
          $chFilters = $request["$inname"];
          if (!empty($chFilters)) {
            $flag = 1;
            foreach ($chFilters as $key => $chFilter) {
              if ($key == 0 && $flag == 0) {
                $query->where('attributes', 'like', '%'.'"'.$chFilter.'"'.'%');
              } else {
                $query->orWhere('attributes', 'like', '%'.'"'.$chFilter.'"'.'%');
              }

            }
          }

        }
      }


      if (!empty($childcat)) {
        foreach ($childcat->attributes as $attribute) {
          $inname = $attribute->input_name;
          $chFilters = $request["$inname"];
          if (!empty($chFilters)) {
            $flag = 1;
            foreach ($chFilters as $key => $chFilter) {
              if ($key == 0 && $flag == 0) {
                $query->where('attributes', 'like', '%'.'"'.$chFilter.'"'.'%');
              } else {
                $query->orWhere('attributes', 'like', '%'.'"'.$chFilter.'"'.'%');
              }

            }
          }

        }
      }
    });

    
/*    $prods = $prods->where('sum_stock','>=','1');    */	
    $prods = $prods->where('status', 1)->get();
    $prods = (new Collection(Product::filterProducts($prods)))->where('sum_stock','>=',1)->paginate(18);

    $data['prods'] = $prods;

    if($request->ajax()) {

      $data['ajax_check'] = 1;

      return view('includes.product.filtered-products', $data);
    }
    return view('front.category', $data);
  }


  public function getsubs(Request $request) {
    $category = Category::where('slug', $request->category)->firstOrFail();
    $subcategories = Subcategory::where('category_id', $category->id)->get();
    return $subcategories;
  }


    // -------------------------------- PRODUCT DETAILS SECTION ----------------------------------------

  public function report(Request $request)
  {

        //--- Validation Section
    $rules = [
     'note' => 'max:400',
   ];
   $customs = [
     'note.max' => 'Note Must Be Less Than 400 Characters.',
   ];
   $validator = Validator::make(Input::all(), $rules, $customs);
   if ($validator->fails()) {
    return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
  }
        //--- Validation Section Ends

        //--- Logic Section
  $data = new Report;
  $input = $request->all();
  $data->fill($input)->save();
        //--- Logic Section Ends

        //--- Redirect Section
  $msg = 'New Data Added Successfully.';
  return response()->json($msg);
        //--- Redirect Section Ends

}

public function product($slug)
{
  
								 
  $this->code_image();
  $productt = Product::where('slug','=',$slug)->firstOrFail();
  if($productt->status == 0){
    return response()->view('errors.404')->setStatusCode(404); 
  }
  $productt->views+=1;
  $productt->update();
  if (Session::has('currency'))
  {
    $curr = Currency::find(Session::get('currency'));
  }else{
    $curr = Currency::where('is_default','=',1)->first();
  }
  $product_click =  new ProductClick;
  $product_click->product_id = $productt->id;
  $product_click->date = Carbon::now()->format('Y-m-d');
  $product_click->save();

  if($productt->user_id != 0)
  {
    $vendors = Product::where('status','=',1)->where('user_id','=',$productt->user_id)->take(8)->get();
  }else{
    $vendors = Product::where('status','=',1)->where('user_id','=',0)->take(8)->get();
  }
  return view('front.product',compact('productt','curr','vendors'));

}


    // Capcha Code Image
private function  code_image()
{
  $actual_path = str_replace('project','',base_path());
  $image = imagecreatetruecolor(200, 50);
  $background_color = imagecolorallocate($image, 255, 255, 255);
  imagefilledrectangle($image,0,0,200,50,$background_color);

  $pixel = imagecolorallocate($image, 0,0,255);
  for($i=0;$i<500;$i++)
  {
    imagesetpixel($image,rand()%200,rand()%50,$pixel);
  }

  $font = $actual_path.'assets/front/fonts/NotoSans-Bold.ttf';
  $allowed_letters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
  $length = strlen($allowed_letters);
  $letter = $allowed_letters[rand(0, $length-1)];
  $word='';
        //$text_color = imagecolorallocate($image, 8, 186, 239);
  $text_color = imagecolorallocate($image, 0, 0, 0);
        $cap_length=6;// No. of character in image
        for ($i = 0; $i< $cap_length;$i++)
        {
          $letter = $allowed_letters[rand(0, $length-1)];
          imagettftext($image, 25, 1, 35+($i*25), 35, $text_color, $font, $letter);
          $word.=$letter;
        }
        $pixels = imagecolorallocate($image, 8, 186, 239);
        for($i=0;$i<500;$i++)
        {
          imagesetpixel($image,rand()%200,rand()%50,$pixels);
        }
        session(['captcha_string' => $word]);
        imagepng($image, $actual_path."assets/images/capcha_code.png");
      }

      public function quick($id)
      {
        $product = Product::findOrFail($id);
        if (Session::has('currency'))
        {
          $curr = Currency::find(Session::get('currency'));
        }
        else
        {
          $curr = Currency::where('is_default','=',1)->first();
        }
        return view('load.quick',compact('product','curr'));

      }

      public function affProductRedirect($slug)
      {
        $product = Product::where('slug','=',$slug)->first();
//        $product->views+=1;
//        $product->update();


        return redirect($product->affiliate_link);

      }
    // -------------------------------- PRODUCT DETAILS SECTION ENDS----------------------------------------



    // -------------------------------- PRODUCT COMMENT SECTION ----------------------------------------

      public function comment(Request $request)
      {
        $comment = new Comment;
        $input = $request->all();
        $comment->fill($input)->save();
        $comments = Comment::where('product_id','=',$request->product_id)->get()->count();
        $data[0] = $comment->user->photo ? url('assets/images/users/'.$comment->user->photo):url('assets/images/noimage.png');
        $data[1] = $comment->user->name;
        $data[2] = $comment->created_at->diffForHumans();
        $data[3] = $comment->text;
        $data[4] = $comments;
        $data[5] = route('product.comment.delete',$comment->id);
        $data[6] = route('product.comment.edit',$comment->id);
        $data[7] = route('product.reply',$comment->id);
        $data[8] = $comment->user->id;
        return response()->json($data);
      }

      public function commentedit(Request $request,$id)
      {
        $comment =Comment::findOrFail($id);
        $comment->text = $request->text;
        $comment->update();
        return response()->json($comment->text);
      }

      public function commentdelete($id)
      {
        $comment =Comment::findOrFail($id);
        if($comment->replies->count() > 0)
        {
          foreach ($comment->replies as $reply) {
            $reply->delete();
          }
        }
        $comment->delete();
      }

    // -------------------------------- PRODUCT COMMENT SECTION ENDS ----------------------------------------

    // -------------------------------- PRODUCT REPLY SECTION ----------------------------------------

      public function reply(Request $request,$id)
      {
        $reply = new Reply;
        $input = $request->all();
        $input['comment_id'] = $id;
        $reply->fill($input)->save();
        $data[0] = $reply->user->photo ? url('assets/images/users/'.$reply->user->photo):url('assets/images/noimage.png');
        $data[1] = $reply->user->name;
        $data[2] = $reply->created_at->diffForHumans();
        $data[3] = $reply->text;
        $data[4] = route('product.reply.delete',$reply->id);
        $data[5] = route('product.reply.edit',$reply->id);
        return response()->json($data);
      }

      public function replyedit(Request $request,$id)
      {
        $reply = Reply::findOrFail($id);
        $reply->text = $request->text;
        $reply->update();
        return response()->json($reply->text);
      }

      public function replydelete($id)
      {
        $reply =Reply::findOrFail($id);
        $reply->delete();
      }

    // -------------------------------- PRODUCT REPLY SECTION ENDS----------------------------------------

      public function refundsubmit(Request $request)
      {
            //echo $request->file('refundimage');die;
          //22 135 ds 211/1/₹80/Test User
        $user_id=$request->user_id;
        $ordreId =  $request->OrderId;
        $messge =  $request->review;
        $idqtypricename= explode('/', $request->idqtypricename);

        $product_id =  $idqtypricename[0];
        $qty =  $idqtypricename[1];
        $product_price = $idqtypricename[2];
        $vendorName =  $idqtypricename[3];


        $ck = 0;
        $orders = Order::where('user_id','=',$user_id)->where('status','=','completed')->get();

        foreach($orders as $order)
        {
          $cart = unserialize(bzdecompress(utf8_decode($order->cart)));
          foreach($cart->items as $product)
          {
            if($product_id == $product['item']['id'])
            {
              $ck = 1;
              break;
            }
          }
        }
        if($ck == 1)
        {
          $user = Auth::guard('web')->user();
          $prev = Refund::where('order_id','=',$ordreId)->where('user_id','=',$user->id)->get();
          if(count($prev) > 0)
          {
            return response()->json(array('errors' => [ 0 => 'You Have Already Submitted.' ]));
          }
          $Refund = new Refund;
          $Refund->fill($request->all());
          if ($file = $request->file('refundimage')){
            $name = time().$file->getClientOriginalName();
            $file->move('assets/images/refund',$name);

            $Refund['image'] = $name;
          }
          $Refund['order_id']       = $ordreId;
          $Refund['sold_by']        = $vendorName;
          $Refund['amount']         = $product_price;
          $Refund['product_id']     = $product_id;
          $Refund['reason']         = $messge;
          $Refund['user_name']      = $user->name;
          $Refund['user_id']        = $user->id;
          $Refund['created_at']     = date('Y-m-d H:i:s');
          $Refund['updated_at']     = date('Y-m-d H:i:s');
          $Refund['qty']            = $qty;
          $Refund['statusare']      = $request->statusare;
          $Refund->save();
          $data[0] = 'Your Refund Request Submitted Successfully.';

          return response()->json($data);
        }
        else{
          return response()->json(array('errors' => [ 0 => 'This Product is not delivered yet.' ]));
        }
      }
    // ------------------ Rating SECTION --------------------

      public function reviewsubmit(Request $request)
      {
        $ck = 0;
        $orders = Order::where('user_id','=',$request->user_id)->where('status','=','completed')->get();

        foreach($orders as $order)
        {
          $cart = unserialize(bzdecompress(utf8_decode($order->cart)));
          foreach($cart->items as $product)
          {
            if($request->product_id == $product['item']['id'])
            {
              $ck = 1;
              break;
            }
          }
        }
        if($ck == 1)
        {
          $user = Auth::guard('web')->user();
          $prev = Rating::where('product_id','=',$request->product_id)->where('user_id','=',$user->id)->get();
          if(count($prev) > 0)
          {
            return response()->json(array('errors' => [ 0 => 'You Have Reviewed Already.' ]));
          }
          $Rating = new Rating;
          $Rating->fill($request->all());
          if ($file = $request->file('photo')){
            $name = time().$file->getClientOriginalName();
            $file->move('assets/images/review',$name);

            $Rating['image'] = $name;
          }
          $Rating['review_date'] = date('Y-m-d H:i:s');
          $Rating->save();
          $data[0] = 'Your Rating Submitted Successfully.';
          $data[1] = Rating::rating($request->product_id);
          return response()->json($data);
        }
        else{
          return response()->json(array('errors' => [ 0 => 'Buy This Product First' ]));
        }
      }


      public function reviews($id){
        $productt = Product::find($id);
        return view('load.reviews',compact('productt','id'));

      }

    // ------------------ Rating SECTION ENDS --------------------
    }
