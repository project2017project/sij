@extends('layouts.vendor')

@section('content')
<div class="content-area">
    @include('includes.form-success')

    @if($activation_notify != "")
    <div class="alert alert-danger validation">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                aria-hidden="true">×</span></button>
        <h3 class="text-center">{!! $activation_notify !!}</h3>
    </div>
    @endif
    
    @if(Session::has('cache'))

    <div class="alert alert-success validation">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span></button>
        <h3 class="text-center">{{ Session::get("cache") }}</h3>
    </div>


  @endif   
  @php
  $user = Auth::user();
  @endphp
    <div class="row row-cards-one">

        <div class="col-md-12 col-lg-12 col-xl-12">
            <div class="card">
                <h5 class="card-header">{{ __('Total Sales in This Month') }}}</h5>
                <div class="row row-cards-one">
                    <div class="col-md-6 col-xl-3">
                        <div class="card c-info-box-area">
                            <div class="c-info-box box4">
                                 <p>{{ App\Models\Currency::where('is_default','=','1')->get()->first()->sign }}
                                    {{ App\Models\Order::where('status','=','completed')
									->where( 'user_id', '>',$user->id)
                                    ->where( 'created_at', '>', Carbon\Carbon::now()->subDays(30))
                                    ->get()->sum('pay_amount') }}</p>
                            </div>
                            <div class="c-info-box-content">
                                <h6 class="title">{{ __('Gross Sales') }}</h6>
                                <p class="text">{{ __('Last 30 Days') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-3">
                        <div class="card c-info-box-area">
                            <div class="c-info-box box4">
                                 <p>{{ App\Models\Currency::where('is_default','=','1')->get()->first()->sign }}
                                    {{ round(App\Models\Order::where('status','=','completed')
									                    ->where( 'user_id', '>',$user->id)
                                                        ->where( 'created_at', '>', Carbon\Carbon::now()->subDays(30))
                                                        ->get()
                                                        ->sum('pay_amount')/date('z'),2)                                     }}</p>
                            </div>
                            <div class="c-info-box-content">
                                <h6 class="title">{{ __('Average Gross Sales') }}</h6>
                                <p class="text">{{ __('Last 30 Days') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-3">
                        <div class="card c-info-box-area">
                            <div class="c-info-box box4">
                                 <p>{{ App\Models\Currency::where('is_default','=','1')->get()->first()->sign }}
                                    {{ App\Models\Order::where('status','=','completed')
									                    ->where( 'user_id', '>',$user->id)
                                                        ->where( 'created_at', '>', Carbon\Carbon::now()->subDays(30))
                                                        ->get()
                                                        ->sum('pay_amount') -
                                        App\Models\VendorOrder::where('status','=','completed')
										                ->where( 'user_id', '>',$user->id)
                                                        ->where( 'created_at', '>', Carbon\Carbon::now()->subDays(30))
                                                        ->get()
                                                        ->sum('admin_fee') 
                                    }}
                                </p>
                            </div>
                            <div class="c-info-box-content">
                                <h6 class="title">{{ __('Net Sales') }}</h6>
                                <p class="text">{{ __('Last 30 Days') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-3">
                        <div class="card c-info-box-area">
                            <div class="c-info-box box4">
                                 <p>{{ App\Models\Currency::where('is_default','=','1')->get()->first()->sign }}
                                    {{ round((App\Models\Order::where('status','=','completed')
									                     ->where( 'user_id', '>',$user->id)
                                                        ->where( 'created_at', '>', Carbon\Carbon::now()->subDays(30))
                                                        ->get()
                                                        ->sum('pay_amount') -
                                        App\Models\VendorOrder::where('status','=','completed')
										                ->where( 'user_id', '>',$user->id)
                                                        ->where( 'created_at', '>', Carbon\Carbon::now()->subDays(30))
                                                        ->get()
                                                        ->sum('admin_fee') )/date('z'),2) 
                                    }}
                                </p>
                            </div>
                            <div class="c-info-box-content">
                                <h6 class="title">{{ __('Average Net Sales') }}</h6>
                                <p class="text">{{ __('Last 30 Days') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-3">
                        <div class="card c-info-box-area">
                            <div class="c-info-box box1">
                                <p>{{ App\Models\Order::where('status','!=','Pending')->where( 'user_id', '>',$user->id)->where('status','!=','declined')->where( 'created_at', '>', Carbon\Carbon::now()->subDays(30))->get()->count() }}</p>
                            </div>
                            <div class="c-info-box-content">
                                <h6 class="title">{{ __('New Orders') }}</h6>
                                <p class="text">{{ __('Last 30 Days') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-3">
                        <div class="card c-info-box-area">
                            <div class="c-info-box box2">
                                <p>{{ App\Models\Order::where('status','!=','Pending')->where( 'user_id', '>',$user->id)->where('status','!=','declined')->where( 'created_at', '>', Carbon\Carbon::now()->subDays(30))->get()->sum('totalQty') }}</p>
                            </div>
                            <div class="c-info-box-content">
                                <h6 class="title">{{ __('Total Items') }}</h6>
                                <p class="text">{{ __('Last 30 days') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-3">
                        <div class="card c-info-box-area">
                            <div class="c-info-box box3">
                                <p>{{ App\Models\Currency::where('is_default','=','1')->get()->first()->sign }}{{ App\Models\Refund::where('statusare','=','accept')
								    ->where( 'user_id', '>',$user->id)
                                    ->whereYear( 'created_at', '=', Carbon\Carbon::now()->subDays(30))->get()->sum('amount') }}</p>
                            </div>
                            <div class="c-info-box-content">
                                <h6 class="title">{{ __('Refund Amount') }}</h6>
                                <p class="text">{{ __('Last 30 days') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-3">
                        <div class="card c-info-box-area">
                            <div class="c-info-box box3">
                                <p>{{ App\Models\Currency::where('is_default','=','1')->get()->first()->sign }}
                                    {{ App\Models\Order::where('status','=','completed')
									->where( 'user_id', '>',$user->id)
                                    ->whereYear( 'created_at', '=', Carbon\Carbon::now()->subDays(30))->get()->sum('shipping_cost')  }}</p>
                            </div>
                            <div class="c-info-box-content">
                                <h6 class="title">{{ __('Shipping Cost') }}</h6>
                                <p class="text">{{ __('Last 30 days') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-3">
                        <div class="card c-info-box-area">
                            <div class="c-info-box box3">
                                <p>{{ App\Models\Currency::where('is_default','=','1')->get()->first()->sign }}
                                    {{ App\Models\Order::where('status','=','completed')
									->where( 'user_id', '>',$user->id)
                                    ->whereYear( 'created_at', '=', Carbon\Carbon::now()->subDays(30))->get()->sum('coupon_discount')  }}</p>
                            </div>
                            <div class="c-info-box-content">
                                <h6 class="title">{{ __('Coupon Discount') }}</h6>
                                <p class="text">{{ __('Last 30 days') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-3">
                        <div class="card c-info-box-area">
                            <div class="c-info-box box3">
                                <p>{{ App\Models\Currency::where('is_default','=','1')->get()->first()->sign }}
                                    {{ App\Models\VendorOrder::where('status','=','completed')->where( 'user_id', '>',$user->id)->where( 'created_at', '>', Carbon\Carbon::now()->subDays(30))->get()->sum('admin_fee')  }}</p>
                            </div>
                            <div class="c-info-box-content">
                                <h6 class="title">{{ __('Admin Fees') }}</h6>
                                <p class="text">{{ __('Last 30 days') }}</p>
                            </div>
                        </div>
                    </div>       
                </div>
            </div>
        </div>
    </div>
    <div class="row row-cards-one">

        <div class="col-md-12 col-lg-12 col-xl-12">
            <div class="card">
                <h5 class="card-header">{{ __('Total Sales in 7 days') }}</h5>
                 <div class="row row-cards-one">
                    <div class="col-md-6 col-xl-3">
                        <div class="card c-info-box-area">
                            <div class="c-info-box box4">
                                 <p>{{ App\Models\Currency::where('is_default','=','1')->get()->first()->sign }}
                                    {{ App\Models\Order::where('status','=','completed')->where( 'user_id', '>',$user->id)->where( 'created_at', '>', Carbon\Carbon::now()->subDays(7))->get()->sum('pay_amount') }}</p>
                            </div>
                            <div class="c-info-box-content">
                                <h6 class="title">{{ __('Gross Sales') }}</h6>
                                <p class="text">{{ __('Last 7 days') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-3">
                        <div class="card c-info-box-area">
                            <div class="c-info-box box4">
                                 <p>{{ App\Models\Currency::where('is_default','=','1')->get()->first()->sign }}
                                    {{ round(App\Models\Order::where('status','=','completed')
									                    ->where( 'user_id', '>',$user->id)
                                                        ->where( 'created_at', '>', Carbon\Carbon::now()->subDays(7))
                                                        ->get()
                                                        ->sum('pay_amount')/date('z'),2) 
                                    }}
                                </p>
                            </div>
                            <div class="c-info-box-content">
                                <h6 class="title">{{ __('Average Gross Sales') }}</h6>
                                <p class="text">{{ __('Last 7 days') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-3">
                        <div class="card c-info-box-area">
                            <div class="c-info-box box4">
                                 <p>{{ App\Models\Currency::where('is_default','=','1')->get()->first()->sign }}
                                    {{ App\Models\Order::where('status','=','completed')
									                    ->where( 'user_id', '>',$user->id)  
                                                        ->where( 'created_at', '>', Carbon\Carbon::now()->subDays(7))
                                                        ->get()
                                                        ->sum('pay_amount') -
                                        App\Models\VendorOrder::where('status','=','completed')
										                ->where( 'user_id', '>',$user->id)
                                                        ->where( 'created_at', '>', Carbon\Carbon::now()->subDays(7))
                                                        ->get()
                                                        ->sum('admin_fee') 
                                    }}
                                </p>
                            </div>
                            <div class="c-info-box-content">
                                <h6 class="title">{{ __('Net Sales') }}</h6>
                                <p class="text">{{ __('Last 7 Days') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-3">
                        <div class="card c-info-box-area">
                            <div class="c-info-box box4">
                                 <p>{{ App\Models\Currency::where('is_default','=','1')->get()->first()->sign }}
                                    {{ round((App\Models\Order::where('status','=','completed')
									                    ->where( 'user_id', '>',$user->id) 
                                                        ->where( 'created_at', '>', Carbon\Carbon::now()->subDays(7))
                                                        ->get()
                                                        ->sum('pay_amount') -
                                        App\Models\VendorOrder::where('status','=','completed')
										                ->where( 'user_id', '>',$user->id) 
                                                        ->where( 'created_at', '>', Carbon\Carbon::now()->subDays(7))
                                                        ->get()
                                                        ->sum('admin_fee') )/date('z'),2) 
                                    }}
                                </p>
                            </div>
                            <div class="c-info-box-content">
                                <h6 class="title">{{ __('Average Net Sales') }}</h6>
                                <p class="text">{{ __('Last 7 Days') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-3">
                        <div class="card c-info-box-area">
                            <div class="c-info-box box1">
                                <p>{{ App\Models\Order::where('status','!=','Pending')->where( 'user_id', '>',$user->id)->where('status','!=','declined')->where( 'created_at', '>', Carbon\Carbon::now()->subDays(7))->get()->count() }}</p>
                            </div>
                            <div class="c-info-box-content">
                                <h6 class="title">{{ __('New Orders') }}</h6>
                                <p class="text">{{ __('Last 7 Days') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-3">
                        <div class="card c-info-box-area">
                            <div class="c-info-box box2">
                                <p>{{ App\Models\Order::where('status','!=','Pending')->where( 'user_id', '>',$user->id)->where('status','!=','declined')->where( 'created_at', '>', Carbon\Carbon::now()->subDays(7))->get()->sum('totalQty') }}</p>
                            </div>
                            <div class="c-info-box-content">
                                <h6 class="title">{{ __('Total Items') }}</h6>
                                <p class="text">{{ __('Last 7 days') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-3">
                        <div class="card c-info-box-area">
                            <div class="c-info-box box3">
                                <p>{{ App\Models\Currency::where('is_default','=','1')->get()->first()->sign }}
                                    {{ App\Models\Refund::where('statusare','=','accept')
									->where( 'user_id', '>',$user->id)
                                    ->whereYear( 'created_at', '=', Carbon\Carbon::now()->subDays(7))->get()->sum('amount') }}</p>
                            </div>
                            <div class="c-info-box-content">
                                <h6 class="title">{{ __('Refund Amount') }}</h6>
                                <p class="text">{{ __('Last 7 days') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-3">
                        <div class="card c-info-box-area">
                            <div class="c-info-box box3">
                                <p>{{ App\Models\Currency::where('is_default','=','1')->get()->first()->sign }}
                                    {{ App\Models\Order::where('status','=','completed')
									->where( 'user_id', '>',$user->id)
                                    ->whereYear( 'created_at', '=', Carbon\Carbon::now()->subDays(7))->get()->sum('shipping_cost')  }}</p>
                            </div>
                            <div class="c-info-box-content">
                                <h6 class="title">{{ __('Shipping Cost') }}</h6>
                                <p class="text">{{ __('Last 7 days') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-3">
                        <div class="card c-info-box-area">
                            <div class="c-info-box box3">
                                <p>{{ App\Models\Currency::where('is_default','=','1')->get()->first()->sign }}
                                    {{ App\Models\Order::where('status','=','completed')
									->where( 'user_id', '>',$user->id)
                                    ->whereYear( 'created_at', '=', Carbon\Carbon::now()->subDays(7))->get()->sum('coupon_discount')  }}</p>
                            </div>
                            <div class="c-info-box-content">
                                <h6 class="title">{{ __('Coupon Discount') }}</h6>
                                <p class="text">{{ __('Last 7 days') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-3">
                        <div class="card c-info-box-area">
                            <div class="c-info-box box3">
                                <p>{{ App\Models\Currency::where('is_default','=','1')->get()->first()->sign }}
                                    {{ App\Models\VendorOrder::where('status','=','completed')->where( 'user_id', '>',$user->id)->where( 'created_at', '>', Carbon\Carbon::now()->subDays(7))->get()->sum('admin_fee')  }}</p>
                            </div>
                            <div class="c-info-box-content">
                                <h6 class="title">{{ __('Admin Fees') }}</h6>
                                <p class="text">{{ __('Last 7 days') }}</p>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>

   
  

<div class="row row-cards-one">

        <div class="col-md-12 col-lg-12 col-xl-12">
            <div class="card">
                <h5 class="card-header">{{ __('Statics For Current Year') }}</h5>
                 <div class="row row-cards-one">
                    <div class="col-md-6 col-xl-3">
                        <div class="card c-info-box-area">
                            <div class="c-info-box box4">
                                 <p>{{ App\Models\Currency::where('is_default','=','1')->get()->first()->sign }}
                                    {{ App\Models\Order::where('status','=','completed')
									                    ->where( 'user_id', '>',$user->id)
                                                        ->whereYear( 'created_at', '=', Carbon\Carbon::now()->year)
                                                        ->get()
                                                        ->sum('pay_amount') 
                                    }}
                                </p>
                            </div>
                            <div class="c-info-box-content">
                                <h6 class="title">{{ __('Gross Sales') }}</h6>
                                <p class="text">{{ __('Current Year') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-3">
                        <div class="card c-info-box-area">
                            <div class="c-info-box box4">
                                 <p>{{ App\Models\Currency::where('is_default','=','1')->get()->first()->sign }}
                                    {{ round(App\Models\Order::where('status','=','completed')
									                    ->where( 'user_id', '>',$user->id)
                                                        ->whereYear( 'created_at', '=', Carbon\Carbon::now()->year)
                                                        ->get()
                                                        ->sum('pay_amount')/date('z'),2) 
                                    }}
                                </p>
                            </div>
                            <div class="c-info-box-content">
                                <h6 class="title">{{ __('Average Gross Sales') }}</h6>
                                <p class="text">{{ __('Current Year') }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-xl-3">
                        <div class="card c-info-box-area">
                            <div class="c-info-box box4">
                                 <p>{{ App\Models\Currency::where('is_default','=','1')->get()->first()->sign }}
                                    {{ App\Models\Order::where('status','=','completed')
									                    ->where( 'user_id', '>',$user->id) 
                                                        ->whereYear( 'created_at', '=', Carbon\Carbon::now()->year)
                                                        ->get()
                                                        ->sum('pay_amount') -
                                        App\Models\VendorOrder::where('status','=','completed')
										                ->where( 'user_id', '>',$user->id)
                                                        ->whereYear( 'created_at', '=', Carbon\Carbon::now()->year)
                                                        ->get()
                                                        ->sum('admin_fee') 
                                    }}
                                </p>
                            </div>
                            <div class="c-info-box-content">
                                <h6 class="title">{{ __('Net Sales') }}</h6>
                                <p class="text">{{ __('Current Year') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-3">
                        <div class="card c-info-box-area">
                            <div class="c-info-box box4">
                                 <p>{{ App\Models\Currency::where('is_default','=','1')->get()->first()->sign }}
                                    {{ round((App\Models\Order::where('status','=','completed')
									                    ->where( 'user_id', '>',$user->id)
                                                        ->whereYear( 'created_at', '=', Carbon\Carbon::now()->year)
                                                        ->get()
                                                        ->sum('pay_amount') -
                                        App\Models\VendorOrder::where('status','=','completed')
										                ->where( 'user_id', '>',$user->id)
                                                        ->whereYear( 'created_at', '=', Carbon\Carbon::now()->year)
                                                        ->get()
                                                        ->sum('admin_fee') )/date('z'),2) 
                                    }}
                                </p>
                            </div>
                            <div class="c-info-box-content">
                                <h6 class="title">{{ __('Average Net Sales') }}</h6>
                                <p class="text">{{ __('Current Year') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-3">
                        <div class="card c-info-box-area">
                            <div class="c-info-box box1">
                                <p>{{ App\Models\Order::where('status','=','completed')
								     ->where( 'user_id', '>',$user->id)
                                    ->whereYear( 'created_at', '=', Carbon\Carbon::now()->year)->get()->count() }}</p>
                            </div>
                            <div class="c-info-box-content">
                                <h6 class="title">{{ __('New Orders') }}</h6>
                                <p class="text">{{ __('Current Year') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-3">
                        <div class="card c-info-box-area">
                            <div class="c-info-box box2">
                                <p>{{ App\Models\Order::where('status','=','completed')
								    ->where( 'user_id', '>',$user->id)
                                    ->whereYear( 'created_at', '=', Carbon\Carbon::now()->year)->get()->sum('totalQty') }}</p>
                            </div>
                            <div class="c-info-box-content">
                                <h6 class="title">{{ __('Total Items') }}</h6>
                                <p class="text">{{ __('Current Year') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-3">
                        <div class="card c-info-box-area">
                            <div class="c-info-box box3">
                                <p>{{ App\Models\Currency::where('is_default','=','1')->get()->first()->sign }}{{ App\Models\Refund::where('statusare','=','accept')
								    ->where( 'user_id', '>',$user->id)
                                    ->whereYear( 'created_at', '=', Carbon\Carbon::now()->year)->get()->sum('amount') }}</p></p>
                            </div>
                            <div class="c-info-box-content">
                                <h6 class="title">{{ __('Refund Amount') }}</h6>
                                <p class="text">{{ __('Current Year') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-3">
                        <div class="card c-info-box-area">
                            <div class="c-info-box box3">
                                <p>{{ App\Models\Currency::where('is_default','=','1')->get()->first()->sign }}
                                    {{ App\Models\Order::where('status','=','completed')
									->where( 'user_id', '>',$user->id)
                                    ->whereYear( 'created_at', '=', Carbon\Carbon::now()->year)->get()->sum('shipping_cost')  }}</p>
                            </div>
                            <div class="c-info-box-content">
                                <h6 class="title">{{ __('Shipping Cost') }}</h6>
                                <p class="text">{{ __('Current Year') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-3">
                        <div class="card c-info-box-area">
                            <div class="c-info-box box3">
                                <p>{{ App\Models\Currency::where('is_default','=','1')->get()->first()->sign }}
                                    {{ App\Models\Order::where('status','=','completed')
									->where( 'user_id', '>',$user->id)
                                    ->whereYear( 'created_at', '=', Carbon\Carbon::now()->year)->get()->sum('coupon_discount')  }}</p>
                            </div>
                            <div class="c-info-box-content">
                                <h6 class="title">{{ __('Coupon Discount') }}</h6>
                                <p class="text">{{ __('Current Year') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-3">
                        <div class="card c-info-box-area">
                            <div class="c-info-box box3">
                                <p>{{ App\Models\Currency::where('is_default','=','1')->get()->first()->sign }}
                                    {{ App\Models\VendorOrder::where('status','=','completed')
									->where( 'user_id', '>',$user->id)
                                    ->whereYear( 'created_at', '=', Carbon\Carbon::now()->year)->get()->sum('admin_fee')  }}</p>
                            </div>
                            <div class="c-info-box-content">
                                <h6 class="title">{{ __('Admin Fees') }}</h6>
                                <p class="text">{{ __('Current Year') }}</p>
                            </div>
                        </div>
                    </div>
        
                </div>
            </div>
        </div>
    </div>
    <div class="row row-cards-one">

        <div class="col-md-12 col-lg-12 col-xl-12">
            <div class="card">
                <h5 class="card-header">{{ __('Total Sales in This Month') }}</h5>
                <div class="card-body">

                    <canvas id="lineChart"></canvas>

                </div>
            </div>

        </div>

    </div>
    <div class="row row-cards-one">

        <div class="col-md-12 col-lg-12 col-xl-12">
            <div class="card">
                <h5 class="card-header">{{ __('Total Sales in Last Month') }}</h5>
                <div class="card-body">

                    <canvas id="lineChart2"></canvas>

                </div>
            </div>

        </div>

    </div>
     <div class="row row-cards-one">

        <div class="col-md-12 col-lg-12 col-xl-12">
            <div class="card">
                <h5 class="card-header">{{ __('Total Sales in Current Year') }}</h5>
                <div class="card-body">

                    <canvas id="lineChartyear"></canvas>

                </div>
            </div>

        </div>

    </div>
     <div class="row row-cards-one">

        <div class="col-md-12 col-lg-12 col-xl-12">
            <div class="card">
                <h5 class="card-header">{{ __('Total Sales in Last 7 days') }}</h5>
                <div class="card-body">

                    <canvas id="lineChart7"></canvas>

                </div>
            </div>

        </div>

    </div>

    <div class="row row-cards-one">

        <div class="col-md-12 col-lg-12 col-xl-12">
            <form id="contactform" action="{{route('vendor.records.submit')}}" method="POST">
                {{csrf_field()}}
                <input type="date" name="startdate">
                <input type="date" name="enddate">
                <input type="submit" name="submit">
            </form>
            
            <div class="card">
                <h5 class="card-header">{{ __('Records in Range') }}</h5>
                Start Date : {{$startdate}} End Date : {{$enddate}}
                <div class="row row-cards-one">

                    @if(!empty($days_between))
                    <div class="col-md-6 col-xl-3">
            <div class="card c-info-box-area">
                <div class="c-info-box box4">
                     <p>{{ App\Models\Currency::where('is_default','=','1')->get()->first()->sign }}
                        {{ $pay_amount}}
                    </p>
                </div>
                <div class="c-info-box-content">
                    <h6 class="title">{{ __('Gross Sales') }}</h6>
                    
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="card c-info-box-area">
                <div class="c-info-box box4">
                     <p>{{ App\Models\Currency::where('is_default','=','1')->get()->first()->sign }}
                        {{ round($pay_amount/$days_between,2) }}
                    </p>
                </div>
                <div class="c-info-box-content">
                    <h6 class="title">{{ __('Average Gross Sales') }}</h6>
                    
                </div>
            </div>
        </div>
         <div class="col-md-6 col-xl-3">
            <div class="card c-info-box-area">
                <div class="c-info-box box4">
                     <p>{{ App\Models\Currency::where('is_default','=','1')->get()->first()->sign }}
                        {{ $pay_amount - $admin_fee}}
                    </p>
                </div>
                <div class="c-info-box-content">
                    <h6 class="title">{{ __('Net Sales') }}</h6>
                    
                </div>
            </div>
        </div>
         <div class="col-md-6 col-xl-3">
            <div class="card c-info-box-area">
                <div class="c-info-box box4">
                     <p>{{ App\Models\Currency::where('is_default','=','1')->get()->first()->sign }}
                        {{ round(($pay_amount -$admin_fee )/$days_between,2) }}
                    </p>
                </div>
                <div class="c-info-box-content">
                    <h6 class="title">{{ __('Average Net Sales') }}</h6>
                    
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="card c-info-box-area">
                <div class="c-info-box box1">
                    <p>{{ $allorders }}</p>
                </div>
                <div class="c-info-box-content">
                    <h6 class="title">{{ __('Total Orders') }}</h6>
                    
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="card c-info-box-area">
                <div class="c-info-box box2">
                    <p>{{ $totalQty }}</p>
                </div>
                <div class="c-info-box-content">
                    <h6 class="title">{{ __('Total Items') }}</h6>
                    
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="card c-info-box-area">
                <div class="c-info-box box3">
                    <p>NTD</p>
                </div>
                <div class="c-info-box-content">
                    <h6 class="title">{{ __('Refund Amount') }}</h6>
                    
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="card c-info-box-area">
                <div class="c-info-box box3">
                    <p>{{ App\Models\Currency::where('is_default','=','1')->get()->first()->sign }}
                        {{ $shipping_cost  }}</p>
                </div>
                <div class="c-info-box-content">
                    <h6 class="title">{{ __('Shipping Cost') }}</h6>
                    
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="card c-info-box-area">
                <div class="c-info-box box3">
                    <p>{{ App\Models\Currency::where('is_default','=','1')->get()->first()->sign }}
                        {{ $coupon_discount }}</p>
                </div>
                <div class="c-info-box-content">
                    <h6 class="title">{{ __('Coupon Discount') }}</h6>
                    <p class="text">{{ __('Current Year') }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="card c-info-box-area">
                <div class="c-info-box box3">
                    <p>{{ App\Models\Currency::where('is_default','=','1')->get()->first()->sign }}
                        {{ $admin_fee  }}</p>
                </div>
                <div class="c-info-box-content">
                    <h6 class="title">{{ __('Admin Fees') }}</h6>
                    
                </div>
            </div>
        </div>
        @else
        <p>please Select Range</p>
     
        @endif
        
                </div>
            </div>

        </div>

    </div>

    @if(!empty($days_between))
    <div class="row row-cards-one">

        <div class="col-md-12 col-lg-12 col-xl-12">
            <div class="card">
                <h5 class="card-header">{{ __('Range Record') }}</h5>
                <div class="card-body">

                    <canvas id="lineChartrange"></canvas>

                </div>
            </div>

        </div>

    </div>
    @endif
</div>

@endsection

@section('scripts')

<script language="JavaScript">
    displayLineChart();
    displayLineChart2();
    displayLineChartyear();
    displayLineChart7();
    displayLineChartrangerecord();

function displayLineChartrangerecord() {
        var data = {
            labels: [
            {!!$daysrange!!}
            ],
           
            datasets: [{
                label: "Prime and Fibonacci",
                fillColor: "#3dbcff",
                strokeColor: "#0099ff",
                pointColor: "rgba(220,220,220,1)",
                pointStrokeColor: "#fff",
                pointHighlightFill: "#fff",
                pointHighlightStroke: "rgba(220,220,220,1)",
                data: [
                {!!$salesrange!!}
                ]
            }]
        };

        var ctx = document.getElementById("lineChartrange").getContext("2d");
        var options = {
            responsive: true,
            showXLabels: 10 
        };
        var lineChart = new Chart(ctx).Line(data, options);
    }
    function displayLineChart7() {
        var data = {
            labels: [
            {!!$days7!!}
            ],
            datasets: [{
                label: "Prime and Fibonacci",
                fillColor: "#3dbcff",
                strokeColor: "#0099ff",
                pointColor: "rgba(220,220,220,1)",
                pointStrokeColor: "#fff",
                pointHighlightFill: "#fff",
                pointHighlightStroke: "rgba(220,220,220,1)",
                data: [
                {!!$sales7!!}
                ]
            }]
        };
        var ctx = document.getElementById("lineChart7").getContext("2d");
        var options = {
            responsive: true
        };
        var lineChart = new Chart(ctx).Line(data, options);
    }
      function displayLineChartyear() {
        var data = {
            labels: [
            {!!$daysyear!!}
            ],
            datasets: [{
                label: "Prime and Fibonacci",
                fillColor: "#3dbcff",
                strokeColor: "#0099ff",
                pointColor: "rgba(220,220,220,1)",
                pointStrokeColor: "#fff",
                pointHighlightFill: "#fff",
                pointHighlightStroke: "rgba(220,220,220,1)",
                data: [
                {!!$salesyear!!}
                ]
            }]
        };
        var ctx = document.getElementById("lineChartyear").getContext("2d");
        var options = {
            responsive: true
        };
        var lineChart = new Chart(ctx).Line(data, options);
    }
    function displayLineChart() {
        var data = {
            labels: [
            {!!$days!!}
            ],
            datasets: [{
                label: "Prime and Fibonacci",
                fillColor: "#3dbcff",
                strokeColor: "#0099ff",
                pointColor: "rgba(220,220,220,1)",
                pointStrokeColor: "#fff",
                pointHighlightFill: "#fff",
                pointHighlightStroke: "rgba(220,220,220,1)",
                data: [
                {!!$sales!!}
                ]
            }]
        };
        var ctx = document.getElementById("lineChart").getContext("2d");
        var options = {
            responsive: true
        };
        var lineChart = new Chart(ctx).Line(data, options);
    }
     function displayLineChart2() {
        var data = {
            labels: [
            {!!$days30!!}
            ],
            datasets: [{
                label: "Prime and Fibonacci",
                fillColor: "#3dbcff",
                strokeColor: "#0099ff",
                pointColor: "rgba(220,220,220,1)",
                pointStrokeColor: "#fff",
                pointHighlightFill: "#fff",
                pointHighlightStroke: "rgba(220,220,220,1)",
                data: [
                {!!$sales30!!}
                ]
            }]
        };
        var ctx = document.getElementById("lineChart2").getContext("2d");
        var options = {
            responsive: true
        };
        var lineChart = new Chart(ctx).Line(data, options);
    }


    
</script>

<script type="text/javascript">
    $('#poproducts').dataTable( {
      "ordering": false,
          'lengthChange': false,
          'searching'   : false,
          'ordering'    : false,
          'info'        : false,
          'autoWidth'   : false,
          'responsive'  : true,
          'paging'  : false
    } );
    </script>


<script type="text/javascript">
    $('#pproducts').dataTable( {
      "ordering": false,
      'lengthChange': false,
          'searching'   : false,
          'ordering'    : false,
          'info'        : false,
          'autoWidth'   : false,
          'responsive'  : true,
          'paging'  : false
    } );
    </script>

<script type="text/javascript">
        var chart1 = new CanvasJS.Chart("chartContainer-topReference",
            {
                exportEnabled: true,
                animationEnabled: true,

                legend: {
                    cursor: "pointer",
                    horizontalAlign: "right",
                    verticalAlign: "center",
                    fontSize: 16,
                    padding: {
                        top: 20,
                        bottom: 2,
                        right: 20,
                    },
                },
                data: [
                    {
                        type: "pie",
                        showInLegend: true,
                        legendText: "",
                        toolTipContent: "{name}: <strong>{#percent%} (#percent%)</strong>",
                        indexLabel: "#percent%",
                        indexLabelFontColor: "white",
                        indexLabelPlacement: "inside",
                        dataPoints: [
                                @foreach($referrals as $browser)
                                    {y:{{$browser->total_count}}, name: "{{$browser->referral}}"},
                                @endforeach
                        ]
                    }
                ]
            });
        chart1.render();

        var chart = new CanvasJS.Chart("chartContainer-os",
            {
                exportEnabled: true,
                animationEnabled: true,
                legend: {
                    cursor: "pointer",
                    horizontalAlign: "right",
                    verticalAlign: "center",
                    fontSize: 16,
                    padding: {
                        top: 20,
                        bottom: 2,
                        right: 20,
                    },
                },
                data: [
                    {
                        type: "pie",
                        showInLegend: true,
                        legendText: "",
                        toolTipContent: "{name}: <strong>{#percent%} (#percent%)</strong>",
                        indexLabel: "#percent%",
                        indexLabelFontColor: "white",
                        indexLabelPlacement: "inside",
                        dataPoints: [
                            @foreach($browsers as $browser)
                                {y:{{$browser->total_count}}, name: "{{$browser->referral}}"},
                            @endforeach
                        ]
                    }
                ]
            });
        chart.render();    
</script>

@endsection