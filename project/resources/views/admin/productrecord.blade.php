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
                <h5 class="card-header">Revenue Reports</h5>
                <div class="row row-cards-one">
                    <div class="col-md-12 col-lg-12 col-xl-12">
                 <ul class="tabs">		
		
		<li class="tab-link" data-tab="tab-1"></li>
		
	</ul>	
	
	<div  id="tab-1" class="tab-content current" >
		<div class="row row-cards-one">

        <div class="col-md-12 col-lg-12 col-xl-12">
            <form id="contactform" action="{{route('admin.productrecord.submit')}}" method="POST">
                {{csrf_field()}}
				<select name="vendor" id="vendor">
                                    <option value=''>all</option>
									@php
$sel= ''

@endphp
                                    @foreach($users as $userid)
									 @if($vendor_id==$userid->id)
																	@php
$sel= 'selected';
@endphp
@else
	@php
$sel= '';	
@endphp
									 
										 @endif
                                    <option value="{{$userid->id}}" {{$sel}}>{{$userid->shop_name}}</option>
                                    @endforeach                                        
                                </select> 
                <input type="date" name="startdate">
                <input type="date" name="enddate">
                <input type="submit" name="submit">
				<?php $enddates =date('Y-m-d', strtotime("-1 day", strtotime($enddate)));;?>
				@if($startdate && $enddates)
                Start Date : {{$startdate}} End Date : {{$enddates}}
			@endif
            </form>
            
                <div class="row row-cards-one">

                    @if(!empty($days_between-1))                  
        
        <div class="col-md-6 col-xl-3">
            <div class="card c-info-box-area">
                <div class="c-info-box box1">
                    <p>{{ App\Models\Currency::where('is_default','=','1')->get()->first()->sign }}
					{{ round($pay_amount - $refund_fee,2)}}
					</p>
                </div>
                <div class="c-info-box-content">
                    <h6 class="title">{{ __('Net Sales') }}</h6>
                    
                </div>
            </div>
        </div>		 
 
<div class="col-md-6 col-xl-3">
            <div class="card c-info-box-area">
                <div class="c-info-box box2">
                    <p>
					{{ $allorders }}
					</p>
                </div>
                <div class="c-info-box-content">
                    <h6 class="title">{{ __('Orders') }}</h6>
                    
                </div>
            </div>
        </div>
		
		<div class="col-md-6 col-xl-3">
            <div class="card c-info-box-area">
                <div class="c-info-box box2">
                    <p>
					{{ $totalQty }}
					</p>
                </div>
                <div class="c-info-box-content">
                    <h6 class="title">{{ __('Item sold') }}</h6>
                    
                </div>
            </div>
        </div>
		<div class="">
		<div class="">
                    <h6 class="title">{{ __('Product Details') }}</h6>
                    
         </div>
		<table id="geniustable" class="table table-hover dt-responsive" cellspacing="0" style="background : #ffffff;" width="100%">
		@if($product_list)
								<thead>
									<tr>
				                        <th>{{ __("Product Name") }}</th><th>{{ __("SKU") }}</th>
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