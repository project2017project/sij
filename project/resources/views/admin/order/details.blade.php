@extends('layouts.admin')
@section('styles')
<style type="text/css">.order-table-wrap table#example2 {margin: 10px auto;}</style>
@endsection
@section('content')
<div class="content-area">
    <div class="mr-breadcrumb">
        <div class="row">
            <div class="col-lg-12">
                <h4 class="heading">{{ __('Order Details') }} <a class="add-btn" href="javascript:history.back();"><i class="fas fa-arrow-left"></i> {{ __('Back') }}</a></h4>
                <ul class="links">
                    <li><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }} </a></li>
                    <li><a href="javascript:;">{{ __('Orders') }}</a></li>
                    <li><a href="javascript:;">{{ __('Order Details') }}</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="order-table-wrap">
        @include('includes.admin.form-both')
        <div class="row">
            <div class="col-lg-6">
                <div class="special-box"><div class="heading-area"><h4 class="title">{{ __('Order Details') }}</h4></div>
                    <div class="table-responsive-sm">
                        <table  class="table">
                            <tbody>
                                <tr><th class="45%" width="45%">{{ __('Order ID') }}</th><td width="10%">:</td><td class="45%" width="45%">{{$order->order_number}}</td></tr>
                               <!-- <tr><th width="45%">{{ __('Total Product') }}</th><td width="10%">:</td><td width="45%">{{$order->totalQty}}</td></tr>-->
                                @if($order->shipping_cost != 0)
                                @php 
                                $price = round(($order->shipping_cost / $order->currency_value),2);
                                @endphp
                                @if(DB::table('shippings')->where('price','=',$price)->count() > 0)
                                <tr><th width="45%">{{ DB::table('shippings')->where('price','=',$price)->first()->title }}</th><td width="10%">:</td>
                                    <td width="45%">{{ $order->currency_sign }}{{ round($order->shipping_cost, 2) }}</td></tr>
                                @endif
                                @endif
                                @if($order->packing_cost != 0)
                                @php 
                                $pprice = round(($order->packing_cost / $order->currency_value),2);
                                @endphp
                                @if(DB::table('packages')->where('price','=',$pprice)->count() > 0)
                                <tr><th width="45%">{{ DB::table('packages')->where('price','=',$pprice)->first()->title }}</th><td width="10%">:</td>
                                    <td width="45%">{{ $order->currency_sign }}{{ round($order->packing_cost, 2) }}</td></tr>
                                @endif
                                @endif
                                <tr><th width="45%">{{ __('Total Cost') }}</th><td width="10%">:</td>
                                    <td width="45%">{{$order->currency_sign}}{{ round($order->pay_amount * $order->currency_value , 2) }}</td></tr>
									@if($order->currency_sign != '???')
                                <tr><th width="45%">{{ __('INR Rate') }}</th><td width="10%">:</td>
                                    <td width="45%">{{ $order->inr_currency_sign }}{{ round($order->pay_amount , 2) }}</td></tr>
                               <!-- <tr><th width="45%">{{ __('USD To INR Payment') }}</th><td width="10%">:</td>
                                    <td width="45%">{{$order->currency_sign}}{{ round($order->pay_amount * $order->currency_value *$order->currency_orginal_val , 2) }}</td></tr>-->
                                <!--<tr><th width="45%">{{ __('International Shiping Charge') }}</th><td width="10%">:</td>
                                    <td width="45%">{{$order->currency_sign}}{{ round($order->pay_amount-($order->pay_amount * $order->currency_value *$order->currency_orginal_val), 2) }}</td></tr>-->
									@endif
                                <tr><th width="45%">{{ __('Ordered Date') }}</th><td width="10%">:</td>
                                    <td width="45%">{{date('d-M-Y H:i:s a',strtotime($order->created_at))}}</td></tr>
                                <tr><th width="45%">{{ __('Payment Method') }}</th><td width="10%">:</td><td width="45%">{{$order->method}}</td></tr>
                                @if($order->method != "Cash On Delivery")
                                @if($order->method=="Stripe")
                                <tr><th width="45%">{{$order->method}} {{ __('Charge ID') }}</th><td width="10%">:</td><td width="45%">{{$order->charge_id}}</td></tr>                        
                                @endif
                                <tr><th width="45%">{{$order->method}} {{ __('Transaction ID') }}</th><td width="10%">:</td><td width="45%">{{$order->txnid}}</td></tr>                         
                                @endif
                                <tr><th width="45%">{{ __('Payment Status') }}</th><th width="10%">:</th>
                                    <td width="45%">{!! $order->payment_status == 'Pending' ? "<span class='badge badge-danger'>Unpaid</span>":"<span class='badge badge-success'>Paid</span>" !!}</td>
                                </tr>  
                                @if(!empty($order->order_note))
                                <tr><th width="45%">{{ __('Order Note') }}</th><th width="10%">:</th><td width="45%">{{$order->order_note}}</td></tr>  
                                @endif
								@php 
								$alldata = App\Models\VendorOrder::where('order_id','=',$order->id)->where('other_status','=','exchange')->orderBy('id','desc')->first();
                                @endphp
								@if($alldata['other_status'])
									<tr><th width="45%">{{ __('Exchange Status') }}</th><th width="10%">:</th><td width="45%">{{$alldata['other_status']}}</td></tr>
								@endif
								
									
                            </tbody>
                        </table>
                    </div>
                    <div class="footer-area">
                        <a href="{{ route('admin-order-invoice',$order->id) }}" class="mybtn1"><i class="fas fa-eye"></i> {{ __('View Invoice') }}</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="special-box">
                    <div class="heading-area"><h4 class="title">{{ __('Billing Details') }}</h4></div>
                    <div class="table-responsive-sm">
                        <table class="table">
                            <tbody>
                                <tr><th width="45%">{{ __('Name') }}</th><th width="10%">:</th><td width="45%">{{$order->customer_name}}</td></tr>
                                <tr><th width="45%">{{ __('Email') }}</th><th width="10%">:</th><td width="45%">{{$order->customer_email}}</td></tr>
                                <tr><th width="45%">{{ __('Phone') }}</th><th width="10%">:</th><td width="45%">{{$order->customer_phone}}</td></tr>
                                <tr><th width="45%">{{ __('Landmark') }}</th><th width="10%">:</th><td width="45%">{{$order->customer_landmark}}</td></tr>
								<tr><th width="45%">{{ __('Address') }}</th><th width="10%">:</th><td width="45%">{{$order->customer_address}}</td></tr>
                                <tr><th width="45%">{{ __('Country') }}</th><th width="10%">:</th><td width="45%">{{$order->customer_country}}</td></tr>
                                <tr><th width="45%">{{ __('City') }}</th><th width="10%">:</th><td width="45%">{{$order->customer_city}}</td></tr>
								<tr><th width="45%">{{ __('State') }}</th><th width="10%">:</th><td width="45%">{{$order->customer_state}}</td></tr>
                                <tr><th width="45%">{{ __('Postal Code') }}</th><th width="10%">:</th><td width="45%">{{$order->customer_zip}}</td></tr>
                                @if($order->coupon_code != null)
                                <tr><th width="45%">{{ __('Coupon Code') }}</th><th width="10%">:</th><td width="45%">{{$order->coupon_code}}</td></tr>
                                @endif
                                @if($order->coupon_discount != null)
                                <tr><th width="45%">{{ __('Coupon Discount') }}</th><th width="10%">:</th>
                                    @if($gs->currency_format == 0)
                                    <td width="45%">{{ $order->currency_sign }}{{ $order->coupon_discount }}</td>
                                    @else 
                                    <td width="45%">{{ $order->coupon_discount }}{{ $order->currency_sign }}</td>
                                    @endif
                                </tr>
                                @endif
                                @if($order->affilate_user != null)
                                <tr><th width="45%">{{ __('Affilate User') }}</th><th width="10%">:</th><td width="45%">{{$order->affilate_user}}</td></tr>
                                @endif
                                @if($order->affilate_charge != null)
                                <tr><th width="45%">{{ __('Affilate Charge') }}</th><th width="10%">:</th>
                                    @if($gs->currency_format == 0)
                                    <td width="45%">{{ $order->currency_sign }}{{$order->affilate_charge}}</td>
                                    @else 
                                    <td width="45%">{{$order->affilate_charge}}{{ $order->currency_sign }}</td>
                                    @endif
                                </tr>
                                @endif
                            </tbody>
                        </table>
						
                    </div>
                    <div class="footer-area">
                          <a data-href="{{ route('admin-order-editbilling',$order->id) }}" class="mybtn1 updatedata" data-toggle="modal" data-target="#modal1"><i class="fas fa-pen"></i> {{ __('Edit Billing Address') }}</a>
                       </div>
                </div>

            </div>
            @if($order->dp == 0)
            <div class="col-lg-6">
                <div class="special-box">
                    <div class="heading-area"><h4 class="title">{{ __('Shipping Details') }}</h4></div>
                    <div class="table-responsive-sm">
                        <table class="table">
                            <tbody>
                                @if($order->shipping == "pickup")
                                <tr><th width="45%"><strong>{{ __('Pickup Location') }}</strong></th><th width="10%">:</th><td width="45%">{{$order->pickup_location}}</td></tr>
                                @else
                                <tr><th width="45%"><strong>{{ __('Name') }}</strong></th><th width="10%">:</th><td>{{$order->shipping_name == null ? $order->customer_name : $order->shipping_name}}</td></tr>
                                <tr><th width="45%"><strong>{{ __('Email') }}</strong></th><th width="10%">:</th><td width="45%">{{$order->shipping_email == null ? $order->customer_email : $order->shipping_email}}</td></tr>
                                <tr><th width="45%"><strong>{{ __('Phone') }}</strong></th><th width="10%">:</th><td width="45%">{{$order->shipping_phone == null ? $order->customer_phone : $order->shipping_phone}}</td></tr>
                                <tr><th width="45%"><strong>{{ __('Landmark') }}</strong></th><th width="10%">:</th><td width="45%">{{$order->shipping_landmark == null ? $order->customer_landmark : $order->shipping_landmark}}</td></tr>
								<tr><th width="45%"><strong>{{ __('Address') }}</strong></th><th width="10%">:</th><td width="45%">{{$order->shipping_address == null ? $order->customer_address : $order->shipping_address}}</td></tr>
                                <tr><th width="45%"><strong>{{ __('Country') }}</strong></th><th width="10%">:</th><td width="45%">{{$order->shipping_country == null ? $order->customer_country : $order->shipping_country}}</td></tr>
                                <tr><th width="45%"><strong>{{ __('City') }}</strong></th><th width="10%">:</th><td width="45%">{{$order->shipping_city == null ? $order->customer_city : $order->shipping_city}}</td></tr>
								<tr><th width="45%"><strong>{{ __('State') }}</strong></th><th width="10%">:</th><td width="45%">{{$order->shipping_state == null ? $order->customer_state : $order->shipping_state}}</td></tr>
                                <tr><th width="45%"><strong>{{ __('Postal Code') }}</strong></th><th width="10%">:</th><td width="45%">{{$order->shipping_zip == null ? $order->customer_zip : $order->shipping_zip}}</td></tr>
                                @endif
                            </tbody>
                        </table>
						
                    </div>
                    <div class="footer-area">
						<a data-href="{{ route('admin-order-editshipping',$order->id) }}" class="mybtn1 updatedata" data-toggle="modal" data-target="#modal1"><i class="fas fa-pen"></i> {{ __('Edit Shipping Address') }}</a>
                         </div>
                </div>
            </div>

            @endif
            <div class="col-lg-6">
                <div class="special-box">
                    <div class="heading-area"><h4 class="title">{{ __('Order Actions') }}</h4></div>
                    <div class="table-responsive-sm">
                        <a href="javascript:;" data-href="{{route('admin-order-edit',$order->id)}} " class="btn btn-success delivery" data-toggle="modal" data-target="#modal1"><i class="fas fa-file"></i> Order & Payment Status</a>
					<!--	@if($order->txnid)
						<a href="javascript:;" data-href="{{route('admin-order-tidgenerate',$order->id)}} " class="btn btn-success delivery" data-toggle="modal" data-target="#modaltans"><i class="fas fa-hands-helping"></i> Generate Transcation id</a>
					@endif-->
                        <a href="javascript:;" data-href="{{route('admin-order-track',$order->id)}}" class="btn btn-info track" data-toggle="modal" data-target="#modal1"><i class="fas fa-truck"></i> Track Order</a>
						@if($order->method=='Razorpay')
						<!--a href="javascript:;" data-href="{{route('admin-order-razorrefund',$order->id)}} " class="btn btn-danger refundorderd" data-toggle="modal" data-target="#modal1"><i class="fas fa-retweet"></i> Refund Online</a-->
					<!--a href="javascript:;" data-href="{{route('admin-order-razormanualrefund',$order->id)}} " class="btn btn-danger refundorderd" data-toggle="modal" data-target="#modal1"><i class="fas fa-retweet"></i> Refund Offline</a-->
						@else
						<!--a href="javascript:;" data-href="{{route('admin-order-refunds',$order->id)}} " class="btn btn-danger refundorderd" data-toggle="modal" data-target="#modal1"><i class="fas fa-retweet"></i> Refund </a-->
						@endif
						
                        
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 order-details-table">
                <div class="mr-table">
                    <h4 class="title">{{ __('Products Ordered') }}</h4>
                    <div class="table-responsiv">
                        <table id="example2" class="table table-hover dt-responsive" cellspacing="0" width="100%">
                            <thead>
								<tr>
									<th >{{ __('SKU') }}</th>
									<th >{{ __('Image') }}</th>
									<th >{{ __('Vendor Name') }}</th>
									<th>{{ __('Product Title') }}</th>
									<th>{{ __('Refund/Exchange') }}</th>
									<th >{{ __('Details') }}</th>
									<th>{{ __('Total Price') }}</th>
								</tr>
							</thead>

                            <tbody>
                            @foreach($cart->items as $key => $product)
						
										@php
                                        $vendorName = App\Models\User::find($product['item']['user_id']);
                                        @endphp
									
                                        @php
                                        $ProductDetails = App\Models\Product::find($product['item']['id']);
                                        @endphp
										
                                <tr>
                                    <td><input type="hidden" value="{{$key}}">{{ $ProductDetails->sku }}  </td>
									 <td><img src="{{ $product['item']['photo'] ? filter_var($product['item']['photo'], FILTER_VALIDATE_URL) ?$product['item']['photo']:asset('assets/images/products/'.$product['item']['photo']):asset('assets/images/noimage.png') }}" alt="{{$product['item']['photo']}}"> </td>
                                    <td><input type="hidden" value="{{$key}}">{{$vendorName->shop_name}}</td>

                                    <td>
                                        <input type="hidden" value="{{ $product['license'] }}">            
                                        @if($product['item']['user_id'] != 0)
                                        @php
                                        $user = App\Models\User::find($product['item']['user_id']);
                                        @endphp
                                        @if(isset($user))
                                      <a target="_blank" href="{{ route('front.product', $product['item']['slug']) }}">{{mb_strlen($product['item']['name'],'utf-8') > 130 ? mb_substr($product['item']['name'],0,130,'utf-8').'...' : $product['item']['name']}}</a>
                                        @else
                                        <a target="_blank" href="{{ route('front.product', $product['item']['slug']) }}">{{mb_strlen($product['item']['name'],'utf-8') > 130 ? mb_substr($product['item']['name'],0,130,'utf-8').'...' : $product['item']['name']}}</a>
                                        @endif
                                        @else 
            
                                            <a target="_blank" href="{{ route('front.product', $product['item']['slug']) }}">{{mb_strlen($product['item']['name'],'utf-8') > 130 ? mb_substr($product['item']['name'],0,130,'utf-8').'...' : $product['item']['name']}}</a>
                                    
                                        @endif
            
            
                                        @if($product['license'] != '')
                                            <a href="javascript:;" data-toggle="modal" data-target="#confirm-delete" class="btn btn-info product-btn" id="license" style="padding: 5px 12px;"><i class="fa fa-eye"></i> {{ __('View License') }}</a>
                                        @endif
            
                                    </td>
                                    
                                    
                                    
                                    
                                    
                                    
                                    <td>
                                        @if($product['item']['user_id'] != 0)
                                        @php
                                        $user = App\Models\VendorOrder::where('order_id','=',$order->id)->where('user_id','=',$product['item']['user_id'])->where('product_id','=',$product['item']['id'])->first();
                                        @endphp
                                      
                                           <!-- @if($user->ref_status == '1')-->
                                           <!-- <span class="badge badge-danger">Refunded</span>-->
                                           <!--@endif-->
                                           
                                           
                                           @if($user->product_item_price > '0')
                                                                                       @if($user->price == $user->product_item_price)
                                            <span class="badge badge-danger">Refunded</span>
                                           @endif
                                           
                                                                                                                                  @if($user->price != $user->product_item_price)
                                            <span class="badge badge-danger">Partial Refunded</span>
                                           @endif
                                           
                                           @endif
                                           
                                           @endif
                                           
                                           
                                            @php
                                        $exchange = App\Models\Exchange::where('order_id','=',$order->id)->where('vendor_id','=',$product['item']['user_id'])->where('product_id','=',$product['item']['id'])->orderBy('created_at', 'desc')->first();
                                        @endphp
                                    
                                    @if($exchange)
                                    
                                  
                                           
                                         @if($exchange->status == 'shipped')
                                            <span class="badge badge-primary">{{ucwords($exchange->status)}} Exchange</span>
                                           
                                            @elseif($exchange->status == 'pending')
                                            <span class="badge badge-warning">{{ucwords($exchange->status)}} Exchange</span>
                                           
                                           @elseif($exchange->status == 'notdelivered')
                                            <span class="badge badge-danger">{{ucwords($exchange->status)}} Exchange</span>
                                           
                                          
                                    
                                        @elseif($exchange->status == 'delivered')
                                         <span class="badge badge-success">{{ucwords($exchange->status)}} Exchange</span>
                                           
                                            
                                            
                                           @endif   
                                           
                                    
                                    
                                    @endif
                                    
                                    
                                    
                                    
                                   
                                   
                                    @php
                                        $exchange_by_coupon = App\Models\VendorOrder::where('order_id','=',$order->id)->where('user_id','=',$product['item']['user_id'])->where('product_id','=',$product['item']['id'])->first();
                                        @endphp
                                    
                                    @if($exchange_by_coupon)
                                    
                                  
                                           
                                         @if($exchange_by_coupon->exchange_by_coupon == '1')
                                            <span class="badge badge-primary">REFUND VIA Coupan</span>
                                            
                                                                                @endif
                                                                                                                                                                @endif
                                   
                                      
                                           
                                           </td>
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    <td>
                                        @if($product['size'])
                                       <p>
                                           <strong> @if(!empty($product['item']['variation_title'])){{ $product['item']['variation_title'] }} @else {{ $langg->lang312 }} @endif :</strong> {{str_replace('-',' ',$product['size'])}}
                                       </p>
                                       @endif
                                       @if($product['color'])
                                        <p>
                                                <strong>{{ __('color') }} :</strong> <span
                                                style="width: 40px; height: 20px; display: block; background: #{{$product['color']}};"></span>
                                        </p>
                                        @endif
                                        <p>
                                                <strong>{{ __('Price') }} :</strong> {{$order->currency_sign}}{{ round($product['item']['price'] * $order->currency_value , 2) }}
                                        </p>
                                       <p>
                                            <strong>{{ __('Qty') }} :</strong> {{$product['qty']}} {{ $product['item']['measure'] }}
                                       </p>
                                       
                                       @php
                                       $refundqty = App\Models\VendorOrder::where('order_id','=',$order->id)->where('user_id','=',$product['item']['user_id'])->where('product_id','=',$product['item']['id'])->first();
                                        @endphp
                                       
                                       @if(!empty($refundqty->product_item_qty))
                                       <p class="text-danger">
                                            <strong>{{ __(' Refund Qty') }} :</strong> {{ $refundqty->product_item_qty}}
                                       </p>
                                       @endif
                                            @if(!empty($product['keys']))
                                            @foreach( array_combine(explode(',', $product['keys']), explode(',', $product['values']))  as $key => $value)
                                            <p><b>{{ ucwords(str_replace('_', ' ', $key))  }} : </b> {{ $value }} </p>
                                            @php 
											$pr_at = $product['item']['attributes'];
	                                        $pr_arr = json_decode($pr_at, true);
											@endphp
											<b>+  {{$order->currency_sign}}</b>{{ $pr_arr [$key]['prices'][0] }}</p>
                                            @endforeach
                                            @endif
                                    </td>
                                    <td><p>{{$order->currency_sign}}{{ round($product['price'] * $order->currency_value , 2) }}</p>
                                     @if(!empty($refundqty->product_item_price))
                                    <p class="text-danger"> <strong>Refund Amount : </strong> {{$order->currency_sign}}{{ round($refundqty->product_item_price * $order->currency_value , 2) }}</p>
                                    @endif
                                    </td>
                                    
                                    <td>
                                        @if($product['item']['user_id'] != 0)
                                        @php
                                        $user = App\Models\VendorOrder::where('order_id','=',$order->id)->where('user_id','=',$product['item']['user_id'])->where('product_id','=',$product['item']['id'])->first();
                                        @endphp
                                        @if($order->dp == 1 && $order->payment_status == 'Completed')
                                        <span class="badge badge-success">{{ $langg->lang542 }}</span>
                                        @elseif($order->status == 'failure')
                                            <span class="badge badge-warning">{{ucwords($order->status)}}</span>
                                        @else
                                            @if($user->status == 'pending')
                                            <span class="badge badge-warning">{{ucwords($user->status)}}</span>
                                            @elseif($user->status == 'processing')
                                            <span class="badge badge-info">{{ucwords($user->status)}}</span>
                                           @elseif($user->status == 'on delivery')
                                            <span class="badge badge-primary">{{ucwords($user->status)}}</span>
                                           @elseif($user->status == 'completed')
                                            <span class="badge badge-success">{{ucwords($user->status)}}</span>
                                           @elseif($user->status == 'declined')
                                            <span class="badge badge-danger">{{ucwords($user->status)}}</span>
                                           @endif
                                        @endif
                                    @endif
                                    </td>

                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 text-center mt-2">
                <a class="btn sendEmail send" href="javascript:;" class="send" data-email="{{ $order->customer_email }}" data-toggle="modal" data-target="#vendorform">
                    <i class="fa fa-send"></i> {{ __('Send Email') }}
                </a>
                <a class="btn sendEmail send" href="javascript:;" class="send" data-email="{{ $order->customer_email }}" data-toggle="modal" data-target="#customnotificationform"><i class="fa fa-send"></i>Add Note</a>
            </div>
        </div>

        <div class="row">
        	<div class="col-lg-12 order-details-table">
        		<div class="mr-table">
        			<h4 class="title">{{__('Shipping Items By Vendors')}}</h4>
        			<div class="table-responsiv">
        				<table id="example2" class="table table-hover dt-responsive" cellspacing="0" width="100%">
        					<thead>
        						<tr>
        							
        							
        							<th>{{__('Vendor Name')}}</th>
        							<th>{{__('Product Name')}}</th>
                                   
        							<th>{{__('Shipping Company')}}</th>
        							<th>{{__('Tracking Code')}}</th>
        							<th>{{__('Tracking Url')}}</th>
        							<th>{{ __('Date') }}</th>
        						</tr>
        					</thead>
        					<tbody>
                                @if(!empty($shippingDetails))
                                @foreach($shippingDetails as $ship)
                                
                                @if(!empty($ship->vendor_id))
        						<tr>
        							<td>
                                       
                                        {{$ship->userName->shop_name}}</td>  

        							<td>

                                        @foreach($cart->items as $key => $product)                                        
                                        @if($product['item']['user_id']===$ship->vendor_id && $product['item']['id']===$ship->pid )
                                        <a target="_blank" href="{{ route('front.product', $product['item']['slug']) }}">{{mb_strlen($product['item']['name'],'utf-8') > 30 ? mb_substr($product['item']['name'],0,30,'utf-8').'...' : $product['item']['name']}}</a> X {{$product['qty']}},
                                        @endif

                                        @endforeach
                                    </td>
        							
        							<td>{{$ship->companyname}}</td>
        							<td><a href="{{$ship->title}}" target="_blank">{{$ship->title}}</a> </td>
        							<td>{{$ship->text}}</td>
        							<td>{{date('d-M-Y',strtotime($ship->created_at))}}</td>                                   
                                    
        						</tr>
                                @endif
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="6">No Shipping Details Found</td>
                                </tr>
                                @endif




        					</tbody>
        				</table>
        			</div>
        		</div>
        	</div>        	
        </div>
        <!--<div class="row">
            <div class="col-lg-12 order-details-table">
                <div class="mr-table">
                    <h4 class="title">{{__('Shipping Details By Admin')}}</h4>
                    <div class="table-responsiv">
                        <table id="example2" class="table table-hover dt-responsive" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    
                                    
                                   
                                    <th>{{__('Product Name')}}</th>
                                   
                                    <th>{{__('Shipping Type')}}</th>
                                    <th>{{ __('Date') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(!empty($shippingDetails))
                                @foreach($shippingDetails as $ship)
                                
                                @if(empty($ship->vendor_id))
                                <tr>
                                    

                                    <td>

                                        @foreach($cart->items as $key => $product)                                        
                                       
                                        <a target="_blank" href="{{ route('front.product', $product['item']['slug']) }}">{{mb_strlen($product['item']['name'],'utf-8') > 30 ? mb_substr($product['item']['name'],0,30,'utf-8').'...' : $product['item']['name']}}</a> X {{$product['qty']}},
                                     

                                        @endforeach
                                    </td>
                                    
                                    <td>{{$ship->companyname}}/{{$ship->title}}/{{$ship->text}}</td>
                                    <td>{{$ship->created_at}}</td>                                   
                                    
                                </tr>
                                @endif
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="6">No Shipping Details Found</td>
                                </tr>
                                @endif




                            </tbody>
                        </table>
                    </div>
                </div>
            </div>          
        </div>-->

        <!--div class="row" style="margin-top : 30px;">
            <div class="col-lg-6">
                <div class="special-box">
                    <div class="heading-area"><h4 class="title">{{ __('Order Account') }}</h4></div>
                    <div class="table-responsive-sm">
                        <table class="table">
                            <tbody>                           
                                <tr>
                                	<th width="45%"><strong>{{ __('Discounts') }}:</strong></th>
                                	<th width="10%">:</th><td width="45%">{{$order->coupon_discount}}</td>
                                </tr>
                                <tr>
                                	<th width="45%"><strong>{{ __('Shipping Cost') }}:</strong></th>
                                	<th width="10%">:</th><td>{{$order->currency_sign}}{{$order->shipping_cost}}</td>
                                </tr>
                                <tr>
                                	<th width="45%"><strong>{{ __('Order Total') }}:</strong></th>
                                	<th width="10%">:</th><td width="45%">{{$order->currency_sign}}{{$order->pay_amount}}</td>
                                </tr-->
                                <!--tr>
                                	<th width="45%"><strong>{{ __('Vendor???s Earnings') }}:</strong></th>
                                	<th width="10%">:</th><td width="45%">{{$order->pay_amount-$order->admin_fee}}</td>
                                </tr>
                                <tr>
                                	<th width="45%"><strong>{{ __('Admin Fee') }}:</strong></th>
                                	<th width="10%">:</th><td width="45%">{{$order->admin_fee}}</td>
                                </tr-->
                                
                            <!--/tbody>
                        </table>
                    </div>
                </div>
            </div>

            
        </div-->

        
        
        <div class="row">
            <div class="col-lg-12 order-details-table">
                <div class="mr-table">
                    <h4 class="title">{{ __('Notification') }}</h4>
                    <div class="table-responsiv">
                        <table id="example2" class="table table-hover dt-responsive" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <tr>
                                        <th >{{ __('Message') }}</th>
                                        <th>{{ __('Date') }}</th>
                                    </tr>
                                </tr>
                            </thead>
                            <tbody>
                                
                                 @php
                                 $tArray[]='0';
                                foreach ($notification as $k => $v) {
                                  $tArray[$k] = $v['id'];
                                }
                                $min_value = min($tArray);
                              
                                @endphp
                                @foreach($notification as $msg)
                                <tr>
                                    <td>
                                       
                                        
                                        <?php echo html_entity_decode($msg->message);?>
                                        @if($min_value == $msg->id)
											{{ __('You Have a new order') }}
                                            <br>
                                            {{ __('Payment Status') }} : {!! $order->payment_status == 'Pending' ? "<span class='badge badge-danger'>Unpaid</span>":"<span class='badge badge-success'>Paid</span>" !!}
                                            <br>
                                            @if($order->method != "Cash On Delivery")
                                            @if($order->method=="Stripe")
                                             {{$order->method}} {{ __('Charge ID') }} : {{$order->charge_id}}
                                            @endif
                                            {{$order->method}} {{ __('Transaction ID') }} : {{$order->txnid}}             
                                            @endif
                                        @else
                                        @endif
                                  
                                    </td>
                                    <td>{{$msg->created_at}}</td>
                                </tr>
                                
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
     

{{-- LICENSE MODAL --}}

<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="modal1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">

    <div class="modal-header d-block text-center">
        <h4 class="modal-title d-inline-block">{{ __('License Key') }}</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
    </div>

                <div class="modal-body">
                    <p class="text-center">{{ __('The Licenes Key is') }} :  <span id="key"></span> <a href="javascript:;" id="license-edit">{{ __('Edit License') }}</a><a href="javascript:;" id="license-cancel" class="showbox">{{ __('Cancel') }}</a></p>
                    <form method="POST" action="{{route('admin-order-license',$order->id)}}" id="edit-license" style="display: none;">
                        {{csrf_field()}}
                        <input type="hidden" name="license_key" id="license-key" value="">
                        <div class="form-group text-center">
                    <input type="text" name="license" placeholder="{{ __('Enter New License Key') }}" style="width: 40%; border: none;" required=""><input type="submit" name="submit" class="btn btn-primary" style="border-radius: 0; padding: 2px; margin-bottom: 2px;">
                        </div>
                    </form>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">{{ __('Close') }}</button>
                </div>
            </div>
        </div>
    </div>


{{-- LICENSE MODAL ENDS --}}

{{-- MESSAGE MODAL --}}
<div class="sub-categori">
    <div class="modal" id="vendorform" tabindex="-1" role="dialog" aria-labelledby="vendorformLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="vendorformLabel">{{ __('Send Email') }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                </div>
            <div class="modal-body">
                <div class="container-fluid p-0">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="contact-form">
                                <form id="emailreply">
                                    {{csrf_field()}}
                                    <ul>
                                        <li>
                                            <input type="email" class="input-field eml-val" id="eml" name="to" placeholder="{{ __('Email') }} *" value="" required="">
                                        </li>
                                        <li>
                                            <input type="text" class="input-field" id="subj" name="subject" placeholder="{{ __('Subject') }} *" required="">
                                        </li>
                                        <li>
                                            <textarea class="input-field textarea" name="message" id="msg" placeholder="{{ __('Your Message') }} *" required=""></textarea>
                                        </li>
										<li><input type="hidden" class="input-field" id="orderid" name="orderid"  value="{{ $order->id }}"></li>
                                            <li><input type="hidden" class="input-field" id="vendorid" name="vendorid"  value=""></li>
                                    </ul>
                                    <button class="submit-btn" id="emlsub" type="submit">{{ __('Send Email') }}</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>
</div>

{{-- MESSAGE MODAL ENDS --}}
{{-- Custom MESSAGE MODAL --}}
<div class="sub-categori">
    <div class="modal" id="customnotificationform" tabindex="-1" role="dialog" aria-labelledby="vendorformLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    {{-- Custom Notifiaction --}}
                    <h5 class="modal-title" id="vendorformLabel">Add Note</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid p-0">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="contact-form">
                                    <form id="addnotevendor">
                                        {{csrf_field()}}
                                        <ul>
                                            <li><input type="hidden" class="input-field" id="orderid" name="orderid"  value="{{ $order->id }}"></li>
                                            <li><input type="hidden" class="input-field" id="vendorid" name="vendorid"  value=""></li>
                                            <li><textarea class="input-field textarea" name="message" id="msg" placeholder="{{ $langg->lang582 }} *" required=""></textarea></li>
                                        </ul>
                                        <button class="submit-btn" id="emlsub" type="submit">Add Note</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- Custom MESSAGE MODAL ENDS --}}
{{-- ORDER MODAL --}}

<div class="modal fade" id="confirm-delete2" tabindex="-1" role="dialog" aria-labelledby="modal1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="submit-loader">
            <img  src="{{asset('assets/images/'.$gs->admin_loader)}}" alt="">
        </div>
    <div class="modal-header d-block text-center">
        <h4 class="modal-title d-inline-block">{{ __('Update Status') }}</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
    </div>

      <!-- Modal body -->
      <div class="modal-body">
        <p class="text-center">{{ __("You are about to update the order's status.") }}</p>
        <p class="text-center">{{ __('Do you want to proceed?') }}</p>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer justify-content-center">
            <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('Cancel') }}</button>
            <a class="btn btn-success btn-ok order-btn">{{ __('Proceed') }}</a>
      </div>

    </div>
  </div>
</div>

{{-- ORDER MODAL ENDS --}}
<div class="modal fade" id="modal1" tabindex="-1" role="dialog" aria-labelledby="modal1" aria-hidden="true">                        
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="submit-loader"><img  src="{{asset('assets/images/'.$gs->admin_loader)}}" alt=""></div>
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer"><button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button></div>
        </div>
    </div>
</div>

<div class="modal fade" id="modaltans" tabindex="-1" role="dialog" aria-labelledby="modal1" aria-hidden="true">                        
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="submit-loader"><img  src="{{asset('assets/images/'.$gs->admin_loader)}}" alt=""></div>
            <div class="modal-header">
                <h5 class="modal-title">Add Transcation ID</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
			<form id="geniusformdata" action="{{route('admin-order-tidupdate',$order->id)}}" method="POST" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="row">
                          <div class="col-lg-4">
                            <div class="left-area">
                                <h4 class="heading">{{ __('Transaction Id') }} *</h4>                                
                            </div>
                          </div>
                          <div class="col-lg-7">
						  <input type ="text" name="tansid" placeholder="{{ __('Enter Transaction Id') }}" required>                            
                          </div>
                        </div>



                        <br>
                        <div class="row">
                          <div class="col-lg-4">
                            <div class="left-area">
                              
                            </div>
                          </div>
                          <div class="col-lg-7">
                            <button class="addProductSubmit-btn" type="submit">{{ __('Save') }}</button>
                          </div>
                        </div>
                      </form></div>
            <div class="modal-footer"><button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button></div>
        </div>
    </div>
</div>

@endsection


@section('scripts')

<script type="text/javascript">
$('#example2').DataTable( {
  "ordering": false,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : false,
      'info'        : false,
      'autoWidth'   : false,
      'responsive'  : true
} );
</script>

    <script type="text/javascript">
        $(document).on('click','#license' , function(e){
            var id = $(this).parent().find('input[type=hidden]').val();
            var key = $(this).parent().parent().find('input[type=hidden]').val();
            $('#key').html(id);  
            $('#license-key').val(key);    
    });
        $(document).on('click','#license-edit' , function(e){
            $(this).hide();
            $('#edit-license').show();
            $('#license-cancel').show();
        });
        $(document).on('click','#license-cancel' , function(e){
            $(this).hide();
            $('#edit-license').hide();
            $('#license-edit').show();
        });

        $(document).on('submit','#edit-license' , function(e){
            e.preventDefault();
          $('button#license-btn').prop('disabled',true);
              $.ajax({
               method:"POST",
               url:$(this).prop('action'),
               data:new FormData(this),
               dataType:'JSON',
               contentType: false,
               cache: false,
               processData: false,
               success:function(data)
               {
                  if ((data.errors)) {
                    for(var error in data.errors)
                    {
                        $.notify('<li>'+ data.errors[error] +'</li>','error');
                    }
                  }
                  else
                  {
                    $.notify(data,'success');
                    $('button#license-btn').prop('disabled',false);
                    $('#confirm-delete').modal('toggle');

                   }
               }
                });
        });
           // Custome Notification SECTION

    $(document).on("submit", "#addnotevendor" , function(){
        
        var token = $(this).find('input[name=_token]').val();
        var message =  $(this).find('textarea[name=message]').val();
        var orderid = $(this).find('input[name=orderid]').val();
        var vendorid = $(this).find('input[name=vendorid]').val();
        $.ajax({
            type: 'post',
            url: mainurl+'/admin/order/addnote',
            data: {
                '_token': token,
                'orderid'   : orderid,
                'vendorid'  : vendorid,
                'message'   : message
            },
              success: function( data) {
                  
                $('#msg').prop('disabled', false);
                $('#msg').val('');
                $('#emlsub').prop('disabled', false);
                if(data == 0)
                    $.notify("Oops Something Goes Wrong !!","error");
                else
                    $.notify("Add Note Successfully !!","success");
                    $('.close').click();
            }
        });
        return false;
        
    
    });
// Custome Notification SECTION ENDS
    </script>
<script type="text/javascript">

    var table = $('#geniustable');
</script>
@endsection