@extends('layouts.vendor') 
@section('styles')
<style type="text/css">.input-field { padding: 15px 20px; }</style>
@endsection
@section('content')  
<input type="hidden" id="headerdata" value="{{ __('ORDER') }}">
<div class="content-area">
	<div class="mr-breadcrumb">
		<div class="row">
			<div class="col-lg-12">
				<h4 class="heading">{{ __('All Orders') }}</h4>
				<ul class="links">
					<li><a href="{{ route('vendor-dashboard') }}">{{ __('Dashboard') }} </a></li>
					<li><a href="javascript:;">{{ __('Orders') }}</a></li>
					<li><a href="{{ route('vendor-order-index') }}">{{ __('All Orders') }}</a></li>
				</ul>
			</div>
		</div>
	</div>
	<div class="product-area">
		<div class="row">
			<div class="col-lg-12">
				<div class="mr-table allproduct">					
					<div class="table-responsiv">
						
							
						<table id="myTable" class="table table-hover dt-responsive" cellspacing="0" width="100%">
							<thead>
								<tr>
									<th>{{ __('Order Number') }}</th>
									<th>{{ __('Customer Name') }}</th>  
									<th>{{ __('Billing Address') }}</th>
									<th>{{ __('Shipping Address') }}</th>
									<th>{{ __('Purchased') }}</th>
									<th>{{ __('Gross Sale') }}</th>																		
                                    <th>{{ __('Order Date') }}</th>	
									<th>{{ __('Refund') }}</th>
									<th>{{ __('Exchange') }}</th>
									<th>{{ __('Options') }}</th>
								</tr>
								</thead>
								<tbody>
								    
									@foreach($orders as $orderr) 
								@php 
								$qty = $orderr->sum('qty');
								$price = $orderr->sum('price');
								  
								@endphp
								@foreach($orderr as $order)

							
										  
                                      
                                      @php
									  
                                        $order_data = App\Models\Order::find($order->order_id);
										
                                      @endphp
								@php
									  $pay_amount =  App\Models\VendorOrder::where('order_id','=',$order->order_id)->where('user_id','=',$user->id)->sum('price');
								      $refund_amount =  App\Models\VendorOrder::where('order_id','=',$order->order_id)->where('user_id','=',$user->id)->sum('product_item_price');
								@endphp
										<tr>
							
											<td> <a href="{{route('vendor-order-invoice',$order->order_number)}}">#{{ $order->order->order_number}}</a></td>
											<td>{{$order_data->customer_name}}</td>
											<td>{{$order_data->customer_name}}, {{$order_data->customer_address}}, {{$order_data->customer_city}}, {{$order_data->customer_state}}, {{$order_data->customer_country}}, {{$order_data->customer_zip}}</td>
											<td>{{$order_data->shipping_name == null ? $order_data->customer_name : $order_data->shipping_name}}, {{$order_data->shipping_address == null ? $order_data->customer_address : $order_data->shipping_address}}, {{$order_data->shipping_city == null ? $order_data->customer_city : $order_data->shipping_city}}, {{$order_data->shipping_state == null ? $order_data->customer_state : $order_data->shipping_state}}, {{$order_data->shipping_country == null ? $order_data->customer_country : $order_data->shipping_country}}, {{$order_data->shipping_zip == null ? $order_data->customer_zip : $order_data->shipping_zip}}</td>
											
											
											
											<td>
											    
											  
											  
											  @foreach($orderr as $productsve)
											  
											   @php
									  
                                        $product_data = App\Models\Product::find($productsve->product_id);
										
                                      @endphp
                                      
                                         @if($productsve->other_status=='exchanges')
											 <span class="badge badge-success">Notdelivered Exchange</span>
										 @elseif($productsve->other_status)
										  <span class="badge badge-success">{{$productsve->other_status}}</span>
											 @else
                                        <span class="badge badge-success">{{$productsve->status}}</span>
									    @endif
                                       <span class="text-success"><b>{{$productsve->qty. 'Item'}}</b></span> <br />{{$product_data->name}}({{ $product_data->sku }})<br /><br />
                                        
                                        
                                        @endforeach 
											</td>
											
											
											
											<td>{{$order->order->inr_currency_sign}}{{round($price , 2)}}</td>
											<td>{{$order_data->created_at}}</td>
										<!--	<td>
											@foreach($orderr as $oddata)
											<span class="text-success"><b>{{$oddata->status}}</b></span> <br /><br />
											@endforeach</td>-->
											@if($refund_amount)
											@if($pay_amount == $refund_amount)
												<td><span class="badge badge-danger">Refund</span></td>
												@else
													<td><span class="badge badge-danger">Partial Refund</span></td>
													@endif
													@else
													<td>-</td>
													@endif
													@php 
								$alldata = App\Models\VendorOrder::where('order_id','=',$order->order_id)->where('user_id','=',$order->user_id)->where('other_status','=','exchange')->orderBy('id','desc')->first();
								$alldatas = App\Models\VendorOrder::where('order_id','=',$order->order_id)->where('user_id','=',$order->user_id)->where('other_status','=','exchanges')->orderBy('id','desc')->first();
                                @endphp
								@if($alldata['other_status'])
									<td><span class="badge badge-danger">{{$alldata['other_status']}}</span></td>
								@elseif($alldatas['other_status'])
								<td><span class="badge badge-danger">Notdelivered Exchange</span></td>
								@else
													<td>-</td>
								@endif
											@php
											
											$action = '';
											
											@endphp
											
											
											<td><div class="godropdown"><button class="go-dropdown-toggle"> Actions<i class="fas fa-chevron-down"></i></button>
                                <div class="action-list">
                                     
                                     <a href="{{route('vendor-order-vshow',$order->order_number)}}" class="btn btn-primary product-btn"><i class="fa fa-eye"></i> {{ $langg->lang539 }}</a> 
                                     
                                    <a href="{{route('vendor-generate-invoice',$order->order_number)}}"><i class="fa fa-eye"></i> Invoice</a>
                                    <a href="{{route('vendor-packingslip-invoice',$order->order_number)}}"><i class="fa fa-eye"></i> Packing Slip</a>
                                    <a href="{{route('vendor-tax-invoice',$order->order_number)}}"><i class="fa fa-eye"></i> Tax Invoice</a>
                                   
                                    
                                </div>
                                </div></td>
											
										
											
											
											</td>
										 </tr>
								@break
								@endforeach
								@endforeach    
								    
								    
								    
								    
							<!--	
								@foreach($orders as $orderr) 
								@php 
								$qty = $orderr->sum('qty');
								$price = $orderr->sum('price');
								  
								@endphp
								@foreach($orderr as $order)
                                      @php
									  
                                        $order_data = App\Models\Order::find($order->order_id);
										
                                      @endphp
								<tr>
									<td><a href="{{route('vendor-order-invoice',$order->order_number)}}">{{ $order->order->order_number}}</a></td>
									<td>{{$order_data->customer_name}}</td>  
									<td>{{$order_data->customer_address}}</td>
									<td>{{$order_data->shipping_address}}</td>
									<td>{{$order_data->qty}}</td>
									<td>{{$order_data->price}}</td>																		
                                    <td>{{$order_data->created_at}}</td>									
									<td>{{$order_data->status}}</td>
									<td>Action</td>
									</tr>
									@endforeach
								@endforeach-->
								
								</tbody>
								<?php //echo '<pre>';print_r($orders);?>
							
						</table>
	
				</div>
				</div>
			</div>
		</div>
		<div class="panel panel-info" style="margin-top : 60px; min-width : 50%;">
    <div class="panel-heading" style="font-size: 18px; font-weight :600; ">Order Export</div>
    <div class="panel-body">
        <div class="row">
                <!--div class="col-xs-12 col-sm-12 col-md-6">  
         		<form id="contactform" action="{{route('admin.ordersave.submit')}}" method="POST">
                {{csrf_field()}}
                
                <div class="input-group mb-3" style="min-width : 250px;">
               <input type="text" class="form-control" name="nooforder" id="nooforder" placeholder="No of order download" required>
               <div class="input-group-append">
			   <input type="submit" name="submit" value="Save" class="btn btn-outline-info">
			   </div>
			   </div>
            </form>
        
		
      </div-->
      
	  <div class="col-xs-12 col-sm-12 col-md-2"> 
      <a href="{{ route('ven-all-excel-file',['status'=>'none']) }}" class="btn btn-info" >ALL</a>
      </div>
      <div class="col-xs-12 col-sm-12 col-md-2"> 
      <a href="{{ route('ven-excel-file',['status'=>'none']) }}" class="btn btn-info" >Completed CSV</a>
      </div>
	  <div class="col-xs-12 col-sm-12 col-md-2"> 
      <a href="{{ route('ven-shipping-excel-file',['status'=>'none']) }}" class="btn btn-info" >Shipping CSV</a>
      </div>
	  <div class="col-xs-12 col-sm-12 col-md-2"> 
      <a href="{{ route('ven-process-excel-file',['status'=>'none']) }}" class="btn btn-info" >Processing CSV</a>
      </div>
                        </div>
    </div>
  </div>
	</div>
</div>

@endsection    

@section('scripts')

{{-- DATA TABLE --}}

<script type="text/javascript">
		  $(document).ready( function () {
    $('#myTable').DataTable({
        "aaSorting": [],
        "ordering": false
    });
} );
</script>
{{-- DATA TABLE --}}
@endsection   