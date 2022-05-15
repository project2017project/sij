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


class BribalController extends Controller
{

   public function index(Request $request)
    
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
     
									 
	$prods = Product::where('status', 1);
	$prods = $prods->where('bribal','=',1);
	$prods = $prods->where('sum_stock','!=','')->get();	
	$vprods = (new Collection(Product::filterProducts($prods)))->paginate(12);
	$data['prods'] = $vprods;
     return view('front.bribal', $data);
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
