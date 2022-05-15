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
                <h5 class="card-header">Order Reports</h5>
                <div class="row row-cards-one">
                    <div class="col-md-12 col-lg-12 col-xl-12">
                 <ul class="tabs">		
		
		<li class="tab-link" data-tab="tab-1"></li>
		
	</ul>	
	
	<div  id="tab-1" class="tab-content current" >
		<div class="row row-cards-one">

        <div class="col-md-12 col-lg-12 col-xl-12">
            <form id="contactform" action="{{route('admin.orderrecord.submit')}}" method="POST">
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
                <div class="c-info-box box4">
                     <p>
                        {{ $allorders}}
                    </p>
                </div>
                <div class="c-info-box-content">
                    <h6 class="title">{{ __('Total Orders') }}</h6>
                    
                </div>
            </div>
        </div>
        
         <div class="col-md-6 col-xl-3">
            <div class="card c-info-box-area">
                <div class="c-info-box box4">
                     <p>{{ App\Models\Currency::where('is_default','=','1')->get()->first()->sign }}
                        {{ round($pay_amount, 2)}}
                    </p>
                </div>
                <div class="c-info-box-content">
                    <h6 class="title">{{ __('Total Orders Amount') }}</h6>
                    
                </div>
            </div>
        </div>  
<div class="col-md-6 col-xl-3">
            <div class="card c-info-box-area">
                <div class="c-info-box box1">
                    <p>{{ $pending_orders}}</p>
                </div>
                <div class="c-info-box-content">
                    <h6 class="title">{{ __('Pending Orders') }}</h6>
                    
                </div>
            </div>
        </div>	
		<div class="col-md-6 col-xl-3">
            <div class="card c-info-box-area">
                <div class="c-info-box box1">
                    <p>{{ App\Models\Currency::where('is_default','=','1')->get()->first()->sign }}
					{{ round($pending_amount, 2)}}
					</p>
                </div>
                <div class="c-info-box-content">
                    <h6 class="title">{{ __('Pending Orders Amount') }}</h6>
                    
                </div>
            </div>
        </div>
		 <div class="col-md-6 col-xl-3">
            <div class="card c-info-box-area">
                <div class="c-info-box box2">
                    <p>{{ $processing_orders}}</p>
                </div>
                <div class="c-info-box-content">
                    <h6 class="title">{{ __('Processing Orders') }}</h6>
                    
                </div>
            </div>
        </div>
 <div class="col-md-6 col-xl-3">
            <div class="card c-info-box-area">
                <div class="c-info-box box2">
                    <p>{{ App\Models\Currency::where('is_default','=','1')->get()->first()->sign }}
					{{ round($processing_amount, 2)}}
					</p>
                </div>
                <div class="c-info-box-content">
                    <h6 class="title">{{ __('Processing Orders Amount') }}</h6>
                    
                </div>
            </div>
        </div>	

         <div class="col-md-6 col-xl-3">
            <div class="card c-info-box-area">
                <div class="c-info-box box3">
                    <p>{{ $declined_orders}}</p>
                </div>
                <div class="c-info-box-content">
                    <h6 class="title">{{ __('Declined Orders') }}</h6>
                    
                </div>
            </div>
        </div>
 <div class="col-md-6 col-xl-3">
            <div class="card c-info-box-area">
                <div class="c-info-box box3">
                    <p>{{ App\Models\Currency::where('is_default','=','1')->get()->first()->sign }}
					{{ round($declined_amount, 2)}}
					</p>
                </div>
                <div class="c-info-box-content">
                    <h6 class="title">{{ __('Declined Orders Amount') }}</h6>
                    
                </div>
            </div>
        </div>			
<div class="col-md-6 col-xl-3">
            <div class="card c-info-box-area">
                <div class="c-info-box box1">
                    <p>{{ $od_orders}}</p>
                </div>
                <div class="c-info-box-content">
                    <h6 class="title">{{ __('Shipped Orders') }}</h6>
                    
                </div>
            </div>
        </div>	
		<div class="col-md-6 col-xl-3">
            <div class="card c-info-box-area">
                <div class="c-info-box box1">
                    <p>{{ App\Models\Currency::where('is_default','=','1')->get()->first()->sign }}
					{{ round($od_amount, 2)}}
					</p>
                </div>
                <div class="c-info-box-content">
                    <h6 class="title">{{ __('Shipped Orders Amount') }}</h6>
                    
                </div>
            </div>
        </div>
           <div class="col-md-6 col-xl-3">
            <div class="card c-info-box-area">
                <div class="c-info-box box2">
                    <p>{{ $completed_orders}}</p>
                </div>
                <div class="c-info-box-content">
                    <h6 class="title">{{ __('Completed Orders') }}</h6>
                    
                </div>
            </div>
        </div>
 <div class="col-md-6 col-xl-3">
            <div class="card c-info-box-area">
                <div class="c-info-box box2">
                    <p>{{ App\Models\Currency::where('is_default','=','1')->get()->first()->sign }}
					{{ round($completed_amount, 2) }}
					</p>
                </div>
                <div class="c-info-box-content">
                    <h6 class="title">{{ __('Completed Orders Amount') }}</h6>
                    
                </div>
            </div>
        </div>		

<div class="col-md-6 col-xl-3">
            <div class="card c-info-box-area">
                <div class="c-info-box box1">
                    <p>{{ App\Models\Currency::where('is_default','=','1')->get()->first()->sign }}
					{{ round($refund_fee, 2)}}
					</p>
                </div>
                <div class="c-info-box-content">
                    <h6 class="title">{{ __('Refund Amount') }}</h6>
                    
                </div>
            </div>
        </div>	
        
                </div>
				<div class="row">
<div class="col-sm-12">
<div class="">
<h6 class="title">{{ __('Order List') }} <button id="download-button"> EXPORT </button></h6>                    
</div>
		
							@if($all_orders)
							<table id="geniustable" class="table table-hover dt-responsive" style="background : #ffffff;" cellspacing="0" width="100%">
							<thead>
								<tr>
									<th>{{ __('Order Number') }}</th>
									<th>{{ __('Customer Name') }}</th>									
									<th>{{ __('Product Name') }}</th>
									<th>{{ __('Product SKU') }}</th>
									<th>{{ __('Quantity') }}</th>
									<th>{{ __('Gross Sale (INR)') }}</th>																		
                                    <th>{{ __('Order Date') }}</th>									
									<th>{{ __('Status') }}</th>
									</tr>
									@foreach($all_orders as $key => $all_order)
									@php
                                        $OrderDetails = App\Models\Order::find($all_order['order_id']);
                                        @endphp
										@php
                                        $ProductDetails = App\Models\Product::find($all_order['product_id']);
                                        @endphp
										@php
                                        $price = $OrderDetails['inr_currency_sign'].$all_order['price']
                                        @endphp										
									<tr>
				                        <td><a href="{{ route('admin-order-show',$all_order['order_id'])}}">{{ $all_order['order_number'] }} <a></td>
                                        <td>{{ $OrderDetails['customer_name'] }}</td>
                                        <td>{{ $ProductDetails['name'] }}</td>
										<td>{{ $ProductDetails['sku'] }}</td>
										<td>{{ $all_order['qty'] }}</td>
                                        <td>{{ $all_order['price']}}</td>
                                        <td>{{ $all_order['created_at'] }}</td>
                                        <td>{{ $all_order['status'] }}</td>
                                         										
										
									</tr>
								
								@endforeach
							</thead>
							@endif
						</table>
						<iframe id="txtArea1" style="display:none"></iframe>
						
						<script>
						    function htmlToCSV(html, filename) {
	var data = [];
	var rows = document.querySelectorAll("table tr");
			
	for (var i = 0; i < rows.length; i++) {
		var row = [], cols = rows[i].querySelectorAll("td, th");
				
		for (var j = 0; j < cols.length; j++) {
		        row.push(cols[j].innerText);
                 }
		        
		data.push(row.join(",")); 		
	}

	downloadCSVFile(data.join("\n"), filename);
}

function downloadCSVFile(csv, filename) {
	var csv_file, download_link;

	csv_file = new Blob([csv], {type: "text/csv"});

	download_link = document.createElement("a");

	download_link.download = filename;

	download_link.href = window.URL.createObjectURL(csv_file);

	download_link.style.display = "none";

	document.body.appendChild(download_link);

	download_link.click();
}


document.getElementById("download-button").addEventListener("click", function () {
	var html = document.querySelector("table").outerHTML;
	htmlToCSV(html, "reports.csv");
});

						</script>
						
						
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