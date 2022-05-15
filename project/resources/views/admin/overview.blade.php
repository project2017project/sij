@extends('layouts.admin')

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
  
  
  
  
  
    <style>
      .tabs_cts ul.tabs{
			margin: 0px;
			padding: 0px;
			list-style: none;
		}
		.tabs_cts ul.tabs li{
			background: none;
			color: #222;
			display: inline-block;
			padding: 10px 15px;
			cursor: pointer;
		}

		.tabs_cts ul.tabs li.current{
			background: #ededed;
			color: #222;
		}

		.tabs_cts .tab-content{
			display: inherit;
			background: #ededed;
			padding: 15px;
			position : absolute;
			visibility : hidden;
			opacity : 0;
			 margin : 0 25px;
		}

		.tabs_cts .tab-content.current{
			display: inherit;
			position : initial;
			visibility : visible;
			opacity : 1;
			margin : 0;
		}
		.tabs-rev-ct{
		    position : relative;
		}
		.tabs-rev-ct .c-info-box-area{
		    margin-bottom : 30px;
		}
  </style>
  
  
  <div class="row row-cards-one tabs_cts">

        <div class="col-md-12 col-lg-12 col-xl-12 tabs-rev-ct">
            <div class="card">
                <h5 class="card-header">Overview Reports</h5>
                <div class="row row-cards-one">
                    <div class="col-md-12 col-lg-12 col-xl-12">
                 <ul class="tabs">
		<li class="tab-link current" data-tab="tab-1">This Month</li>
		
		<li class="tab-link" data-tab="tab-2">7 Days</li>
		<li class="tab-link" data-tab="tab-3">Today</li>
		<li class="tab-link" data-tab="tab-4">Yesterday</li>
		<li class="tab-link" data-tab="tab-5">Current Year</li>
		<li class="tab-link" data-tab="tab-6">Custom Date Range</li>
		
	</ul>

	<div  id="tab-1" class="tab-content current" >
	     
     <canvas id="lineChart"></canvas>
     
      <div class="row row-cards-one">
                            <div class="col-md-6 col-xl-3">
                                <div class="card c-info-box-area">
                                    <div class="c-info-box box4">
                                       <p>{{ App\Models\Currency::where('is_default','=','1')->get()->first()->sign }}
                                        {{ App\Models\Order::where('status','=','completed')
										->where('payment_status','=','completed')
                                        ->where( 'created_at', '>', Carbon\Carbon::now()->subDays(30))
                                        ->get()->sum('pay_amount') }}</p>
                                    </div>
                                    <div class="c-info-box-content">
                                        <h6 class="title">{{ __('Total Sales') }}</h6>
                                        <p class="text">{{ __('Last 30 Days') }}</p>
                                    </div>
                                </div>
                            </div>                           
                            <div class="col-md-6 col-xl-3">
                                <div class="card c-info-box-area">
                                    <div class="c-info-box box4">
                                       <p>{{ App\Models\Currency::where('is_default','=','1')->get()->first()->sign }}
                                        {{ App\Models\Order::where('status','=','completed')
										->where('payment_status','=','completed')
                                        ->where( 'created_at', '>', Carbon\Carbon::now()->subDays(30))
                                        ->get()
                                        ->sum('pay_amount') -
                                        App\Models\VendorOrder::where('status','=','completed')
                                        ->where( 'created_at', '>', Carbon\Carbon::now()->subDays(30))
                                        ->get()
                                        ->sum('product_item_price') 
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
                    <div class="c-info-box box1">
                        <p>{{ App\Models\Order::where('status','!=','Pending')->where('status','!=','declined')->where( 'created_at', '>', Carbon\Carbon::now()->subDays(30))->get()->count() }}</p>
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
                        <p>{{ App\Models\VendorOrder::where('status','!=','Pending')->where('status','!=','declined')->where( 'created_at', '>', Carbon\Carbon::now()->subDays(30))->get()->sum('qty') }}</p>
                    </div>
                    <div class="c-info-box-content">
                        <h6 class="title">{{ __('Total Items Sold') }}</h6>
                        <p class="text">{{ __('Last 30 days') }}</p>
                    </div>
                </div>
            </div>
			<div class="col-md-6 col-xl-3">
                <div class="card c-info-box-area">
                    <div class="c-info-box box2">
                        <p>{{ App\Models\Order::where('status','!=','Pending')->where('status','!=','declined')->where( 'created_at', '>', Carbon\Carbon::now()->subDays(30))->get()->sum('totalQty') }}</p>
                    </div>
                    <div class="c-info-box-content">
                        <h6 class="title">{{ __('Items Sold') }}</h6>
                        <p class="text">{{ __('Last 30 days') }}</p>
                    </div>
                </div>
            </div>
			                       @php 
										$product_list = App\Models\VendorOrder::select('product_id', DB::raw('SUM(qty) as count'), DB::raw('COUNT(order_id) as ordercount'), DB::raw('SUM(price) as prices'))
                                                        ->groupBy('product_id')
						                                ->where('status','!=','pending')
						                                ->where('status','!=','declined')
						                                ->where( 'created_at', '>', Carbon\Carbon::now()->subDays(30))
                                                        ->orderBy('count', 'desc')
                                                        ->take(5)														
                                                        ->get();                     									
									@endphp
									
									</div>
									<div class="row">
									
								<div class="row mr-table">
		<div class="col-sm-12">
                    <h6 class="title">{{ __('Product Details') }}</h6>
                    
         </div>
		<table id="geniustable" class="table table-hover dt-responsive" cellspacing="0" width="100%" style="background : #ffffff;">
		@if($product_list)
								<thead>
									<tr>
				                        <th>{{ __("Title") }}</th><th>{{ __("SKU") }}</th>
				                        <th>{{ __("Stock") }}</th><th>{{ __("Total sales") }}</th><th>{{ __("Total sales Amount") }}</th><th>{{ __("Category") }}</th><th>{{ __("Orders") }}</th>				                       
										
									</tr>									
									@foreach($product_list as $key => $product_lists)
									@if($product_lists->product_id)
									@php
                                        $ProductDetails = App\Models\Product::find($product_lists->product_id);
                                        @endphp
										@php 
										$category_all = App\Models\Category::where('id','=',$ProductDetails['category_id'])->get();
								        $category_name='';                            									
										@endphp
										
										@php 
										$subcat_all = App\Models\Subcategory::where('id','=',$ProductDetails['subcategory_id'])->get();
								        $subcat_name='';                           									
										@endphp
										
										@php 
										$childcat_all = App\Models\Childcategory::where('id','=',$ProductDetails['childcategory_id'])->get();
								        $childcat_name='';                           									
										@endphp
										
										 @foreach ($category_all as $key => $value) 
										 @php
                                          $category_name=$value->name;
                                         @endphp                                            
                                          @endforeach

                                    @foreach ($subcat_all as $key => $value) 
										 @php
                                          $subcat_name=$value->name;
                                         @endphp                                            
                                          @endforeach	

                                      @foreach ($childcat_all as $key => $value) 
										 @php
                                          $childcat_name=$value->name;
                                         @endphp                                            
                                          @endforeach	
                                @if($category_name && $subcat_name && $childcat_name)
									@php 
								$all_cat=$category_name.'->'.$subcat_name.'->'.$childcat_name;
								@endphp 
								@elseif($category_name && $subcat_name )
								@php
								$all_cat=$category_name.'->'.$subcat_name;
								@endphp 
								@elseif($category_name)
								@php
									$all_cat=$category_name;
									@endphp 
								@endif									  
										
										@if($ProductDetails['name'])
											 @php
$total_stock = 0;
@endphp	
@if($ProductDetails['stock'] || $ProductDetails['size_qty'])
	@php
$total_stock = $ProductDetails['stock'];
@endphp
@if(!empty($ProductDetails['size_qty']))
 @foreach($ProductDetails['size_qty'] as $skey => $skeydata)
@php
$total_stock += $ProductDetails['size_qty'][$skey];
@endphp 

 @endforeach
 @endif 
@endif  	
									<tr>
				                        <td>{{ $ProductDetails['name'] }}</td><td>{{ $ProductDetails['sku'] }}</td>
				                        <td>{{ $total_stock }}</td><td>{{ $product_lists->count }}</td><td>{{ $product_lists->prices }}</td><td>{{ $all_cat }}</td><td>{{ $product_lists->ordercount }}</td>				                        
										
									</tr>
									@endif
									@endif
									@endforeach
								</thead>
								@endif
							</table>
							</div>
           
                              
                        </div>
  
	</div>
	
	
	<div id="tab-2" class="tab-content">
	     <canvas id="lineChart7"></canvas>
	   <div class="row row-cards-one">
                            <div class="col-md-6 col-xl-3">
                                <div class="card c-info-box-area">
                                    <div class="c-info-box box4">
                                       <p>{{ App\Models\Currency::where('is_default','=','1')->get()->first()->sign }}
                                        {{ App\Models\Order::where('status','=','completed')->where('payment_status','=','completed')->where( 'created_at', '>', Carbon\Carbon::now()->subDays(7))->get()->sum('pay_amount') }}</p>
                                    </div>
                                    <div class="c-info-box-content">
                                        <h6 class="title">{{ __('Total Sales') }}</h6>
                                        <p class="text">{{ __('Last 7 days') }}</p>
                                    </div>
                                </div>
                            </div>
                           
                    <div class="col-md-6 col-xl-3">
                        <div class="card c-info-box-area">
                            <div class="c-info-box box4">
                               <p>{{ App\Models\Currency::where('is_default','=','1')->get()->first()->sign }}
                                {{ App\Models\Order::where('status','=','completed')
								->where('payment_status','=','completed')
                                ->where( 'created_at', '>', Carbon\Carbon::now()->subDays(7))
                                ->get()
                                ->sum('pay_amount') -
                                App\Models\VendorOrder::where('status','=','completed')
                                ->where( 'created_at', '>', Carbon\Carbon::now()->subDays(7))
                                ->get()
                                ->sum('product_item_price') 
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
            <div class="c-info-box box1">
                <p>{{ App\Models\Order::where('status','!=','Pending')->where('status','!=','declined')->where( 'created_at', '>', Carbon\Carbon::now()->subDays(7))->get()->count() }}</p>
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
                <p>{{ App\Models\VendorOrder::where('status','!=','Pending')->where('status','!=','declined')->where( 'created_at', '>', Carbon\Carbon::now()->subDays(7))->get()->sum('qty') }}</p>
            </div>
            <div class="c-info-box-content">
                <h6 class="title">{{ __('Total Items Sold') }}</h6>
                <p class="text">{{ __('Last 7 days') }}</p>
            </div>
        </div>
    </div>
	 <div class="col-md-6 col-xl-3">
        <div class="card c-info-box-area">
            <div class="c-info-box box2">
                <p>{{ App\Models\Order::where('status','!=','Pending')->where('status','!=','declined')->where( 'created_at', '>', Carbon\Carbon::now()->subDays(7))->get()->sum('totalQty') }}</p>
            </div>
            <div class="c-info-box-content">
                <h6 class="title">{{ __('Items Sold') }}</h6>
                <p class="text">{{ __('Last 7 days') }}</p>
            </div>
        </div>
    </div>
	
	        @php 
										$product_list = App\Models\VendorOrder::select('product_id', DB::raw('SUM(qty) as count'), DB::raw('COUNT(order_id) as ordercount'), DB::raw('SUM(price) as prices'))
                                                        ->groupBy('product_id')
						                                ->where('status','!=','pending')
						                                ->where('status','!=','declined')
						                                ->where( 'created_at', '>', Carbon\Carbon::now()->subDays(7))
                                                        ->orderBy('count', 'desc')
                                                        ->take(5)														
                                                        ->get();                     									
									@endphp
									
									<div class="">
		<div class="">
                    <h6 class="title">{{ __('Product Details') }}</h6>
                    
         </div>
		<table id="geniustable" class="table table-hover dt-responsive" cellspacing="0" width="100%">
		@if($product_list)
								<thead>
									<tr>
				                        <th>{{ __("Title") }}</th><th>{{ __("SKU") }}</th>
				                        <th>{{ __("Stock") }}</th><th>{{ __("Total sales") }}</th><th>{{ __("Total sales Amount") }}</th><th>{{ __("Category") }}</th><th>{{ __("Orders") }}</th>				                       
										
									</tr>									
									@foreach($product_list as $key => $product_lists)
									@if($product_lists->product_id)
									@php
                                        $ProductDetails = App\Models\Product::find($product_lists->product_id);
                                        @endphp
										@php 
										$category_all = App\Models\Category::where('id','=',$ProductDetails['category_id'])->get();
								        $category_name='';                            									
										@endphp
										
										@php 
										$subcat_all = App\Models\Subcategory::where('id','=',$ProductDetails['subcategory_id'])->get();
								        $subcat_name='';                           									
										@endphp
										
										@php 
										$childcat_all = App\Models\Childcategory::where('id','=',$ProductDetails['childcategory_id'])->get();
								        $childcat_name='';                           									
										@endphp
										
										 @foreach ($category_all as $key => $value) 
										 @php
                                          $category_name=$value->name;
                                         @endphp                                            
                                          @endforeach

                                    @foreach ($subcat_all as $key => $value) 
										 @php
                                          $subcat_name=$value->name;
                                         @endphp                                            
                                          @endforeach	

                                      @foreach ($childcat_all as $key => $value) 
										 @php
                                          $childcat_name=$value->name;
                                         @endphp                                            
                                          @endforeach	
                                @if($category_name && $subcat_name && $childcat_name)
									@php 
								$all_cat=$category_name.'->'.$subcat_name.'->'.$childcat_name;
								@endphp 
								@elseif($category_name && $subcat_name )
								@php
								$all_cat=$category_name.'->'.$subcat_name;
								@endphp 
								@elseif($category_name)
								@php
									$all_cat=$category_name;
									@endphp 
								@endif									  
										
										@if($ProductDetails['name'])
											 @php
$total_stock = 0;
@endphp	
@if($ProductDetails['stock'] || $ProductDetails['size_qty'])
	@php
$total_stock = $ProductDetails['stock'];
@endphp
@if(!empty($ProductDetails['size_qty']))
 @foreach($ProductDetails['size_qty'] as $skey => $skeydata)
@php
$total_stock += $ProductDetails['size_qty'][$skey];
@endphp 

 @endforeach
 @endif 
@endif  	
									<tr>
				                        <td>{{ $ProductDetails['name'] }}</td><td>{{ $ProductDetails['sku'] }}</td>
				                        <td>{{ $total_stock }}</td><td>{{ $product_lists->count }}</td><td>{{ $product_lists->prices }}</td><td>{{ $all_cat }}</td><td>{{ $product_lists->ordercount }}</td>				                        
										
									</tr>
									@endif
									@endif
									@endforeach
								</thead>
								@endif
							</table>
							</div>
    
            
                
                    
                </div>
	</div>
	
	<div id="tab-3" class="tab-content">
	     <canvas id="lineCharttoday"></canvas>
	   <div class="row row-cards-one">
                            <div class="col-md-6 col-xl-3">
                                <div class="card c-info-box-area">
                                    <div class="c-info-box box4">
                                       <p>{{ App\Models\Currency::where('is_default','=','1')->get()->first()->sign }}
                                        {{ App\Models\Order::where('status','=','completed')->where('payment_status','=','completed')->where( 'created_at', '>', Carbon\Carbon::now()->subDays(1))->get()->sum('pay_amount') }}</p>
                                    </div>
                                    <div class="c-info-box-content">
                                        <h6 class="title">{{ __('Total Sales') }}</h6>
                                        <p class="text">{{ __('Today') }}</p>
                                    </div>
                                </div>
                            </div>
                           
                    <div class="col-md-6 col-xl-3">
                        <div class="card c-info-box-area">
                            <div class="c-info-box box4">
                               <p>{{ App\Models\Currency::where('is_default','=','1')->get()->first()->sign }}
                                {{ App\Models\Order::where('status','=','completed')
								->where('payment_status','=','completed')
                                ->where( 'created_at', '>', Carbon\Carbon::now()->subDays(1))
                                ->get()
                                ->sum('pay_amount') -
                                App\Models\VendorOrder::where('status','=','completed')
                                ->where( 'created_at', '>', Carbon\Carbon::now()->subDays(1))
                                ->get()
                                ->sum('product_item_price') 
                            }}
                        </p>
                    </div>
                    <div class="c-info-box-content">
                        <h6 class="title">{{ __('Net Sales') }}</h6>
                        <p class="text">{{ __('Today') }}</p>
                    </div>
                </div>
            </div>
            
    <div class="col-md-6 col-xl-3">
        <div class="card c-info-box-area">
            <div class="c-info-box box1">
                <p>{{ App\Models\Order::where('status','!=','Pending')->where('status','!=','declined')->where( 'created_at', '>', Carbon\Carbon::now()->subDays(1))->get()->count() }}</p>
            </div>
            <div class="c-info-box-content">
                <h6 class="title">{{ __('New Orders') }}</h6>
                <p class="text">{{ __('Today') }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card c-info-box-area">
            <div class="c-info-box box2">
                <p>{{ App\Models\VendorOrder::where('status','!=','Pending')->where('status','!=','declined')->where( 'created_at', '>', Carbon\Carbon::now()->subDays(1))->get()->sum('qty') }}</p>
            </div>
            <div class="c-info-box-content">
                <h6 class="title">{{ __('Total Items Sold') }}</h6>
                <p class="text">{{ __('Today') }}</p>
            </div>
        </div>
    </div>
	 <div class="col-md-6 col-xl-3">
        <div class="card c-info-box-area">
            <div class="c-info-box box2">
                <p>{{ App\Models\Order::where('status','!=','Pending')->where('status','!=','declined')->where( 'created_at', '>', Carbon\Carbon::now()->subDays(1))->get()->sum('totalQty') }}</p>
            </div>
            <div class="c-info-box-content">
                <h6 class="title">{{ __('Items Sold') }}</h6>
                <p class="text">{{ __('Today') }}</p>
            </div>
        </div>
    </div>
	
	        @php 
										$product_list = App\Models\VendorOrder::select('product_id', DB::raw('SUM(qty) as count'), DB::raw('COUNT(order_id) as ordercount'), DB::raw('SUM(price) as prices'))
                                                        ->groupBy('product_id')
						                                ->where('status','!=','pending')
						                                ->where('status','!=','declined')
						                                ->where( 'created_at', '>', Carbon\Carbon::now()->subDays(1))
                                                        ->orderBy('count', 'desc')
                                                        ->take(5)														
                                                        ->get();                     									
									@endphp
									
									<div class="">
		<div class="">
                    <h6 class="title">{{ __('Product Details') }}</h6>
                    
         </div>
		<table id="geniustable" class="table table-hover dt-responsive" cellspacing="0" width="100%">
		@if($product_list)
								<thead>
									<tr>
				                        <th>{{ __("Title") }}</th><th>{{ __("SKU") }}</th>
				                        <th>{{ __("Stock") }}</th><th>{{ __("Total sales") }}</th><th>{{ __("Total sales Amount") }}</th><th>{{ __("Category") }}</th><th>{{ __("Orders") }}</th>				                       
										
									</tr>									
									@foreach($product_list as $key => $product_lists)
									@if($product_lists->product_id)
									@php
                                        $ProductDetails = App\Models\Product::find($product_lists->product_id);
                                        @endphp
										@php 
										$category_all = App\Models\Category::where('id','=',$ProductDetails['category_id'])->get();
								        $category_name='';                            									
										@endphp
										
										@php 
										$subcat_all = App\Models\Subcategory::where('id','=',$ProductDetails['subcategory_id'])->get();
								        $subcat_name='';                           									
										@endphp
										
										@php 
										$childcat_all = App\Models\Childcategory::where('id','=',$ProductDetails['childcategory_id'])->get();
								        $childcat_name='';                           									
										@endphp
										
										 @foreach ($category_all as $key => $value) 
										 @php
                                          $category_name=$value->name;
                                         @endphp                                            
                                          @endforeach

                                    @foreach ($subcat_all as $key => $value) 
										 @php
                                          $subcat_name=$value->name;
                                         @endphp                                            
                                          @endforeach	

                                      @foreach ($childcat_all as $key => $value) 
										 @php
                                          $childcat_name=$value->name;
                                         @endphp                                            
                                          @endforeach	
                                @if($category_name && $subcat_name && $childcat_name)
									@php 
								$all_cat=$category_name.'->'.$subcat_name.'->'.$childcat_name;
								@endphp 
								@elseif($category_name && $subcat_name )
								@php
								$all_cat=$category_name.'->'.$subcat_name;
								@endphp 
								@elseif($category_name)
								@php
									$all_cat=$category_name;
									@endphp 
								@endif									  
										
										@if($ProductDetails['name'])
											 @php
$total_stock = 0;
@endphp	
@if($ProductDetails['stock'] || $ProductDetails['size_qty'])
	@php
$total_stock = $ProductDetails['stock'];
@endphp
@if(!empty($ProductDetails['size_qty']))
 @foreach($ProductDetails['size_qty'] as $skey => $skeydata)
@php
$total_stock += $ProductDetails['size_qty'][$skey];
@endphp 

 @endforeach
 @endif 
@endif  	
									<tr>
				                        <td>{{ $ProductDetails['name'] }}</td><td>{{ $ProductDetails['sku'] }}</td>
				                        <td>{{ $total_stock }}</td><td>{{ $product_lists->count }}</td><td>{{ $product_lists->prices }}</td><td>{{ $all_cat }}</td><td>{{ $product_lists->ordercount }}</td>				                        
										
									</tr>
									@endif
									@endif
									@endforeach
								</thead>
								@endif
							</table>
							</div>
    
            
                
                    
                </div>
	</div>
	
	<div id="tab-4" class="tab-content">
	     <canvas id="lineChartyesterday"></canvas>
	   <div class="row row-cards-one">
                            <div class="col-md-6 col-xl-3">
                                <div class="card c-info-box-area">
                                    <div class="c-info-box box4">
                                       <p>{{ App\Models\Currency::where('is_default','=','1')->get()->first()->sign }}
                                        {{ App\Models\Order::where('status','=','completed')->where('payment_status','=','completed')->where( 'created_at', '>', Carbon\Carbon::now()->subDays(2))->get()->sum('pay_amount') }}</p>
                                    </div>
                                    <div class="c-info-box-content">
                                        <h6 class="title">{{ __('Total Sales') }}</h6>
                                        <p class="text">{{ __('Yesterday') }}</p>
                                    </div>
                                </div>
                            </div>
                           
                    <div class="col-md-6 col-xl-3">
                        <div class="card c-info-box-area">
                            <div class="c-info-box box4">
                               <p>{{ App\Models\Currency::where('is_default','=','1')->get()->first()->sign }}
                                {{ App\Models\Order::where('status','=','completed')
								->where('payment_status','=','completed')
                                ->where( 'created_at', '>', Carbon\Carbon::now()->subDays(2))
                                ->get()
                                ->sum('pay_amount') -
                                App\Models\VendorOrder::where('status','=','completed')
                                ->where( 'created_at', '>', Carbon\Carbon::now()->subDays(2))
                                ->get()
                                ->sum('product_item_price') 
                            }}
                        </p>
                    </div>
                    <div class="c-info-box-content">
                        <h6 class="title">{{ __('Net Sales') }}</h6>
                        <p class="text">{{ __('Yesterday') }}</p>
                    </div>
                </div>
            </div>
            
    <div class="col-md-6 col-xl-3">
        <div class="card c-info-box-area">
            <div class="c-info-box box1">
                <p>{{ App\Models\Order::where('status','!=','Pending')->where('status','!=','declined')->where( 'created_at', '>', Carbon\Carbon::now()->subDays(2))->get()->count() }}</p>
            </div>
            <div class="c-info-box-content">
                <h6 class="title">{{ __('New Orders') }}</h6>
                <p class="text">{{ __('Yesterday') }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card c-info-box-area">
            <div class="c-info-box box2">
                <p>{{ App\Models\VendorOrder::where('status','!=','Pending')->where('status','!=','declined')->where( 'created_at', '>', Carbon\Carbon::now()->subDays(2))->get()->sum('qty') }}</p>
            </div>
            <div class="c-info-box-content">
                <h6 class="title">{{ __('Total Items Sold') }}</h6>
                <p class="text">{{ __('Yesterday') }}</p>
            </div>
        </div>
    </div>
	 <div class="col-md-6 col-xl-3">
        <div class="card c-info-box-area">
            <div class="c-info-box box2">
                <p>{{ App\Models\Order::where('status','!=','Pending')->where('status','!=','declined')->where( 'created_at', '>', Carbon\Carbon::now()->subDays(2))->get()->sum('totalQty') }}</p>
            </div>
            <div class="c-info-box-content">
                <h6 class="title">{{ __('Items Sold') }}</h6>
                <p class="text">{{ __('Yesterday') }}</p>
            </div>
        </div>
    </div>
    
	        @php 
										$product_list = App\Models\VendorOrder::select('product_id', DB::raw('SUM(qty) as count'), DB::raw('COUNT(order_id) as ordercount'), DB::raw('SUM(price) as prices'))
                                                        ->groupBy('product_id')
						                                ->where('status','!=','pending')
						                                ->where('status','!=','declined')
						                                ->where( 'created_at', '>', Carbon\Carbon::now()->subDays(2))
                                                        ->orderBy('count', 'desc')
                                                        ->take(5)														
                                                        ->get();                     									
									@endphp
									
									<div class="">
		<div class="">
                    <h6 class="title">{{ __('Product Details') }}</h6>
                    
         </div>
		<table id="geniustable" class="table table-hover dt-responsive" cellspacing="0" width="100%">
		@if($product_list)
								<thead>
									<tr>
				                        <th>{{ __("Title") }}</th><th>{{ __("SKU") }}</th>
				                        <th>{{ __("Stock") }}</th><th>{{ __("Total sales") }}</th><th>{{ __("Total sales Amount") }}</th><th>{{ __("Category") }}</th><th>{{ __("Orders") }}</th>				                       
										
									</tr>									
									@foreach($product_list as $key => $product_lists)
									@if($product_lists->product_id)
									@php
                                        $ProductDetails = App\Models\Product::find($product_lists->product_id);
                                        @endphp
										@php 
										$category_all = App\Models\Category::where('id','=',$ProductDetails['category_id'])->get();
								        $category_name='';                            									
										@endphp
										
										@php 
										$subcat_all = App\Models\Subcategory::where('id','=',$ProductDetails['subcategory_id'])->get();
								        $subcat_name='';                           									
										@endphp
										
										@php 
										$childcat_all = App\Models\Childcategory::where('id','=',$ProductDetails['childcategory_id'])->get();
								        $childcat_name='';                           									
										@endphp
										
										 @foreach ($category_all as $key => $value) 
										 @php
                                          $category_name=$value->name;
                                         @endphp                                            
                                          @endforeach

                                    @foreach ($subcat_all as $key => $value) 
										 @php
                                          $subcat_name=$value->name;
                                         @endphp                                            
                                          @endforeach	

                                      @foreach ($childcat_all as $key => $value) 
										 @php
                                          $childcat_name=$value->name;
                                         @endphp                                            
                                          @endforeach	
                                @if($category_name && $subcat_name && $childcat_name)
									@php 
								$all_cat=$category_name.'->'.$subcat_name.'->'.$childcat_name;
								@endphp 
								@elseif($category_name && $subcat_name )
								@php
								$all_cat=$category_name.'->'.$subcat_name;
								@endphp 
								@elseif($category_name)
								@php
									$all_cat=$category_name;
									@endphp 
								@endif									  
										
										@if($ProductDetails['name'])
											 @php
$total_stock = 0;
@endphp	
@if($ProductDetails['stock'] || $ProductDetails['size_qty'])
	@php
$total_stock = $ProductDetails['stock'];
@endphp
@if(!empty($ProductDetails['size_qty']))
 @foreach($ProductDetails['size_qty'] as $skey => $skeydata)
@php
$total_stock += $ProductDetails['size_qty'][$skey];
@endphp 

 @endforeach
 @endif 
@endif  	
									<tr>
				                        <td>{{ $ProductDetails['name'] }}</td><td>{{ $ProductDetails['sku'] }}</td>
				                        <td>{{ $total_stock }}</td><td>{{ $product_lists->count }}</td><td>{{ $product_lists->prices }}</td><td>{{ $all_cat }}</td><td>{{ $product_lists->ordercount }}</td>				                        
										
									</tr>
									@endif
									@endif
									@endforeach
								</thead>
								@endif
							</table>
							</div>
            
                
                    
                </div>
	</div>
	
	
	<div id="tab-5" class="tab-content">
	
	 <canvas id="lineChartyear"></canvas>
	
	<div class="row row-cards-one">
                    <div class="col-md-6 col-xl-3">
                        <div class="card c-info-box-area">
                            <div class="c-info-box box4">
                                 <p>{{ App\Models\Currency::where('is_default','=','1')->get()->first()->sign }}
                                    {{ App\Models\Order::where('status','=','completed')
									                    ->where('payment_status','=','completed')
                                                        ->whereYear( 'created_at', '=', Carbon\Carbon::now()->year)
                                                        ->get()
                                                        ->sum('pay_amount') 
                                    }}
                                </p>
                            </div>
                            <div class="c-info-box-content">
                                <h6 class="title">{{ __('Total Sales') }}</h6>
                                <p class="text">{{ __('Current Year') }}</p>
                            </div>
                        </div>
                    </div>                   

                    <div class="col-md-6 col-xl-3">
                        <div class="card c-info-box-area">
                            <div class="c-info-box box4">
                                 <p>{{ App\Models\Currency::where('is_default','=','1')->get()->first()->sign }}
                                    {{ App\Models\Order::where('status','=','completed')
									                    ->where('payment_status','=','completed')
                                                        ->whereYear( 'created_at', '=', Carbon\Carbon::now()->year)
                                                        ->get()
                                                        ->sum('pay_amount') -
                                        App\Models\VendorOrder::where('status','=','completed')
                                                        ->whereYear( 'created_at', '=', Carbon\Carbon::now()->year)
                                                        ->get()
                                                        ->sum('product_item_price') 
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
                            <div class="c-info-box box1">
                                <p>{{ App\Models\Order::where('status','=','completed')
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
                                <p>{{ App\Models\VendorOrder::where('status','=','completed')
                                    ->whereYear( 'created_at', '=', Carbon\Carbon::now()->year)->get()->sum('qty') }}</p>
                            </div>
                            <div class="c-info-box-content">
                                <h6 class="title">{{ __('Total Items Sold') }}</h6>
                                <p class="text">{{ __('Current Year') }}</p>
                            </div>
                        </div>
                    </div> 

                     <div class="col-md-6 col-xl-3">
                        <div class="card c-info-box-area">
                            <div class="c-info-box box2">
                                <p>{{ App\Models\Order::where('status','=','completed')
                                    ->whereYear( 'created_at', '=', Carbon\Carbon::now()->year)->get()->sum('totalQty') }}</p>
                            </div>
                            <div class="c-info-box-content">
                                <h6 class="title">{{ __('Items Sold') }}</h6>
                                <p class="text">{{ __('Current Year') }}</p>
                            </div>
                        </div>
                    </div> 	
 @php 
										$product_list = App\Models\VendorOrder::select('product_id', DB::raw('SUM(qty) as count'), DB::raw('COUNT(order_id) as ordercount'), DB::raw('SUM(price) as prices'))
                                                        ->groupBy('product_id')
						                                ->where('status','!=','pending')
						                                ->where('status','!=','declined')
						                                ->where( 'created_at', '>',  Carbon\Carbon::now()->year)
                                                        ->orderBy('count', 'desc')
                                                        ->take(5)														
                                                        ->get();                     									
									@endphp
									
									<div class="">
		<div class="">
                    <h6 class="title">{{ __('Product Details') }}</h6>
                    
         </div>
		<table id="geniustable" class="table table-hover dt-responsive" cellspacing="0" width="100%">
		@if($product_list)
								<thead>
									<tr>
				                        <th>{{ __("Title") }}</th><th>{{ __("SKU") }}</th>
				                        <th>{{ __("Stock") }}</th><th>{{ __("Total sales") }}</th><th>{{ __("Total sales Amount") }}</th><th>{{ __("Category") }}</th><th>{{ __("Orders") }}</th>				                       
										
									</tr>									
									@foreach($product_list as $key => $product_lists)
									@if($product_lists->product_id)
									@php
                                        $ProductDetails = App\Models\Product::find($product_lists->product_id);
                                        @endphp
										@php 
										$category_all = App\Models\Category::where('id','=',$ProductDetails['category_id'])->get();
								        $category_name='';                            									
										@endphp
										
										@php 
										$subcat_all = App\Models\Subcategory::where('id','=',$ProductDetails['subcategory_id'])->get();
								        $subcat_name='';                           									
										@endphp
										
										@php 
										$childcat_all = App\Models\Childcategory::where('id','=',$ProductDetails['childcategory_id'])->get();
								        $childcat_name='';                           									
										@endphp
										
										 @foreach ($category_all as $key => $value) 
										 @php
                                          $category_name=$value->name;
                                         @endphp                                            
                                          @endforeach

                                    @foreach ($subcat_all as $key => $value) 
										 @php
                                          $subcat_name=$value->name;
                                         @endphp                                            
                                          @endforeach	

                                      @foreach ($childcat_all as $key => $value) 
										 @php
                                          $childcat_name=$value->name;
                                         @endphp                                            
                                          @endforeach	
                                @if($category_name && $subcat_name && $childcat_name)
									@php 
								$all_cat=$category_name.'->'.$subcat_name.'->'.$childcat_name;
								@endphp 
								@elseif($category_name && $subcat_name )
								@php
								$all_cat=$category_name.'->'.$subcat_name;
								@endphp 
								@elseif($category_name)
								@php
									$all_cat=$category_name;
									@endphp 
								@endif									  
										
										@if($ProductDetails['name'])
											 @php
$total_stock = 0;
@endphp	
@if($ProductDetails['stock'] || $ProductDetails['size_qty'])
	@php
$total_stock = $ProductDetails['stock'];
@endphp
@if(!empty($ProductDetails['size_qty']))
 @foreach($ProductDetails['size_qty'] as $skey => $skeydata)
@php
$total_stock += $ProductDetails['size_qty'][$skey];
@endphp 

 @endforeach
 @endif 
@endif  	
									<tr>
				                        <td>{{ $ProductDetails['name'] }}</td><td>{{ $ProductDetails['sku'] }}</td>
				                        <td>{{ $total_stock }}</td><td>{{ $product_lists->count }}</td><td>{{ $product_lists->prices }}</td><td>{{ $all_cat }}</td><td>{{ $product_lists->ordercount }}</td>				                        
										
									</tr>
									@endif
									@endif
									@endforeach
								</thead>
								@endif
							</table>
							</div>					
                         
                </div>	
	</div>
	
	
	<div id="tab-6" class="tab-content">
		<div class="row row-cards-one">

        <div class="col-md-12 col-lg-12 col-xl-12">
            <form id="contactform" action="{{route('admin.overview.submit')}}" method="POST">
                {{csrf_field()}}
                <input type="date" name="startdate">
                <input type="date" name="enddate">
                <input type="submit" name="submit">
            </form>
            <?php $enddates =date('Y-m-d', strtotime("-1 day", strtotime($enddate)));;?>
               @if($startdate && $enddates)
                Start Date : {{$startdate}} End Date : {{$enddates}}
			@endif
                <div class="row row-cards-one">

                    @if(!empty($days_between-1))
                    <div class="col-md-6 col-xl-3">
            <div class="card c-info-box-area">
                <div class="c-info-box box4">
                     <p>{{ App\Models\Currency::where('is_default','=','1')->get()->first()->sign }}
                        {{ $pay_amount}}
                    </p>
                </div>
                <div class="c-info-box-content">
                    <h6 class="title">{{ __('Total Sales') }}</h6>
                    
                </div>
            </div>
        </div>
        
         <div class="col-md-6 col-xl-3">
            <div class="card c-info-box-area">
                <div class="c-info-box box4">
                     <p>{{ App\Models\Currency::where('is_default','=','1')->get()->first()->sign }}
                        {{ $pay_amount - $refund_fee}}
                    </p>
                </div>
                <div class="c-info-box-content">
                    <h6 class="title">{{ __('Net Sales') }}</h6>
                    
                </div>
            </div>
        </div>
       
        <div class="col-md-6 col-xl-3">
            <div class="card c-info-box-area">
                <div class="c-info-box box1">
                    <p>{{ $allorders }}</p>
                </div>
                <div class="c-info-box-content">
                    <h6 class="title">{{ __('New Orders') }}</h6>
                    
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="card c-info-box-area">
                <div class="c-info-box box2">
                    <p>{{ $qty_data }}</p>
                </div>
                <div class="c-info-box-content">
                    <h6 class="title">{{ __('Total Items Sold') }}</h6>
                    
                </div>
            </div>
        </div>
		<div class="col-md-6 col-xl-3">
            <div class="card c-info-box-area">
                <div class="c-info-box box2">
                    <p>{{ $totalQty }}</p>
                </div>
                <div class="c-info-box-content">
                    <h6 class="title">{{ __('Items Sold') }}</h6>
                    
                </div>
            </div>
        </div>
		<div class="">
		<div class="">
                    <h6 class="title">{{ __('Product Details') }}</h6>
                    
         </div>
		<table id="geniustable" class="table table-hover dt-responsive" cellspacing="0" width="100%">
		@if($product_list)
								<thead>
									<tr>
				                        <th>{{ __("Title") }}</th><th>{{ __("SKU") }}</th>
				                        <th>{{ __("Stock") }}</th><th>{{ __("Total sales") }}</th><th>{{ __("Total sales Amount") }}</th><th>{{ __("Category") }}</th><th>{{ __("Orders") }}</th>				                       
										
									</tr>									
									@foreach($product_list as $key => $product_lists)
									@if($product_lists->product_id)
									@php
                                        $ProductDetails = App\Models\Product::find($product_lists->product_id);
                                        @endphp
										@php 
										$category_all = App\Models\Category::where('id','=',$ProductDetails['category_id'])->get();
								        $category_name='';                            									
										@endphp
										
										@php 
										$subcat_all = App\Models\Subcategory::where('id','=',$ProductDetails['subcategory_id'])->get();
								        $subcat_name='';                           									
										@endphp
										
										@php 
										$childcat_all = App\Models\Childcategory::where('id','=',$ProductDetails['childcategory_id'])->get();
								        $childcat_name='';                           									
										@endphp
										
										 @foreach ($category_all as $key => $value) 
										 @php
                                          $category_name=$value->name;
                                         @endphp                                            
                                          @endforeach

                                    @foreach ($subcat_all as $key => $value) 
										 @php
                                          $subcat_name=$value->name;
                                         @endphp                                            
                                          @endforeach	

                                      @foreach ($childcat_all as $key => $value) 
										 @php
                                          $childcat_name=$value->name;
                                         @endphp                                            
                                          @endforeach	
                                @if($category_name && $subcat_name && $childcat_name)
									@php 
								$all_cat=$category_name.'->'.$subcat_name.'->'.$childcat_name;
								@endphp 
								@elseif($category_name && $subcat_name )
								@php
								$all_cat=$category_name.'->'.$subcat_name;
								@endphp 
								@elseif($category_name)
								@php
									$all_cat=$category_name;
									@endphp 
								@endif									  
										
										@if($ProductDetails['name'])
											 @php
$total_stock = 0;
@endphp	
@if($ProductDetails['stock'] || $ProductDetails['size_qty'])
	@php
$total_stock = $ProductDetails['stock'];
@endphp
@if(!empty($ProductDetails['size_qty']))
 @foreach($ProductDetails['size_qty'] as $skey => $skeydata)
@php
$total_stock += $ProductDetails['size_qty'][$skey];
@endphp 

 @endforeach
 @endif 
@endif  	
									<tr>
				                        <td>{{ $ProductDetails['name'] }}</td><td>{{ $ProductDetails['sku'] }}</td>
				                        <td>{{ $total_stock }}</td><td>{{ $product_lists->count }}</td><td>{{ $product_lists->prices }}</td><td>{{ $all_cat }}</td><td>{{ $product_lists->ordercount }}</td>				                        
										
									</tr>
									@endif
									@endif
									@endforeach
								</thead>
								@endif
							</table>
							</div>
        
        @else
        <p>Please Select Range</p>
     
        @endif
        
                </div>
           

        </div>

    </div>
	</div>
	
	
	
  </div>
                </div>
                </div>
                </div>
                </div>
  
   
</div>

@endsection

@section('scripts')

<script language="JavaScript">
    displayLineChart();
    displayLineChartyear();
    displayLineChart7();
	displayLineChartyes();
	displayLineCharttoday();

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
	 function displayLineChartyes() {
        var data = {
            labels: [
            {!!$days_yes!!}
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
                {!!$sales_yes!!}
                ]
            }]
        };
        var ctx = document.getElementById("lineChartyesterday").getContext("2d");
        var options = {
            responsive: true
        };
        var lineChart = new Chart(ctx).Line(data, options);
    }
	 function displayLineCharttoday() {
        var data = {
            labels: [
            {!!$days_today!!}
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
                {!!$sales_today!!}
                ]
            }]
        };
        var ctx = document.getElementById("lineCharttoday").getContext("2d");
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

<script>
                    $(document).ready(function(){
	
	$('ul.tabs li').click(function(){
		var tab_id = $(this).attr('data-tab');

		$('ul.tabs li').removeClass('current');
		$('.tab-content').removeClass('current');

		$(this).addClass('current');
		$("#"+tab_id).addClass('current');
	})

})
                </script>

@endsection