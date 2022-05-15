<?php

namespace App\Http\Controllers\Front;

use App\Classes\GeniusMailer;
use App\Models\User;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\Product;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Childcategory;
use App\Models\Generalsetting;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;


class VendorController extends Controller
{

    public function index(Request $request, $slug=null, $slug1=null, $slug2=null, $slug3=null)
    {
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
        $this->code_image();
        // $sort = "";
        $minprice = $request->min;
        $maxprice = $request->max;
        $sort = $request->sort;
		$sorttext = $request->sorttext;
        $string = str_replace('-',' ', $slug);
        $vendor = User::where('shop_name','=',$string)->firstOrFail();
        $data['vendor'] = $vendor;
        $data['services'] = DB::table('services')->where('user_id','=',$vendor->id)->get();
        $cat = null;
        $subcat = null;
        $childcat = null;
	
	if (!empty($slug1)) {
      $cat = Category::where('slug', $slug1)->firstOrFail();
      $data['cat'] = $cat;
    }
    if (!empty($slug2)) {
      $subcat = Subcategory::where('slug', $slug2)->firstOrFail();
      $data['subcat'] = $subcat;
    }
    if (!empty($slug3)) {
      $childcat = Childcategory::where('slug', $slug3)->firstOrFail();
      $data['childcat'] = $childcat;
    }

        // Search By Price
        $prods = Product::when($cat, function ($query, $cat) {
        return $query->whereRaw("find_in_set($cat->id,category_id)");        
      })
	  ->when($subcat, function ($query, $subcat) {
        return $query->whereRaw("find_in_set($subcat->id,subcategory_id)");       
      })
      ->when($childcat, function ($query, $childcat) {
        return $query->whereRaw("find_in_set($childcat->id,childcategory_id)");        
      })
	  ->when($minprice, function($query, $minprice) {
                                      return $query->where('price', '>=', $minprice);
                                    })
                                    ->when($maxprice, function($query, $maxprice) {
                                      return $query->where('price', '<=', $maxprice);
                                    })
									->when($sorttext, function ($query, $sorttext) {
                                        return $query->Where('name', 'like', '%' . $sorttext . '%');
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
	$prods = $prods->where('status', 1);	
	$prods = $prods->where('user_id', $vendor->id);
	$prods = $prods->where('sum_stock','!=','')->get();
    
	

        $vprods = (new Collection(Product::filterProducts($prods)))->where('sum_stock','>=',1)->paginate(16);
        $data['vprods'] = $vprods;

if($request->ajax()) {

      $data['ajax_check'] = 1;

      return view('includes.product.filtered-vproducts', $data);
    }
        return view('front.vendor', $data);
    }

    //Send email to user
    public function vendorcontact(Request $request)
    {
        $user = User::findOrFail($request->user_id);
        $vendor = User::findOrFail($request->vendor_id);
        $gs = Generalsetting::findOrFail(1);
            $subject = $request->subject;
            $to = $vendor->email;
            $name = $request->name;
            $from = $request->email;
            $msg = "Name: ".$name."\nEmail: ".$from."\nMessage: ".$request->message;
        if($gs->is_smtp)
        {
            $data = [
                'to' => $to,
                'subject' => $subject,
                'body' => $msg,
            ];

            $mailer = new GeniusMailer();
            $mailer->sendCustomMail($data);
        }
        else{
            $headers = "From: ".$gs->from_name."<".$gs->from_email.">";
            mail($to,$subject,$msg,$headers);
        }


    $conv = Conversation::where('sent_user','=',$user->id)->where('subject','=',$subject)->first();
        if(isset($conv)){
            $msg = new Message();
            $msg->conversation_id = $conv->id;
            $msg->message = $request->message;
            $msg->sent_user = $user->id;
            $msg->save();
        }
        else{
            $message = new Conversation();
            $message->subject = $subject;
            $message->sent_user= $request->user_id;
            $message->recieved_user = $request->vendor_id;
            $message->message = $request->message;
            $message->save();
            $msg = new Message();
            $msg->conversation_id = $message->id;
            $msg->message = $request->message;
            $msg->sent_user = $request->user_id;;
            $msg->save();

        }
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


}
