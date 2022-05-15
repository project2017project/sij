@extends('layouts.admin')

@section('content')
<div class="content-area">
    <div class="mr-breadcrumb">
        <div class="row">
            <div class="col-lg-12">
                <h4 class="heading">{{ __('Order Invoice') }} <a class="add-btn" href="javascript:history.back();"><i
                            class="fas fa-arrow-left"></i> {{ __('Back') }}</a></h4>
                <ul class="links">
                    <li>
                        <a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }} </a>
                    </li>
                    <li>
                        <a href="javascript:;">{{ __('Orders') }}</a>
                    </li>
                    <li>
                        <a href="javascript:;">{{ __('Invoice') }}</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
	 <div class="invoice-box">
        <table cellpadding="0" cellspacing="0">
            <tr class="top">
                <td colspan="2">
                    <table>
                        <tr>
                            <td class="title">
                                <span class="t-invoice">{{ __('INVOICE') }}</span><br><br>
                                <span class="invoice-number">{{ __('Invoice') }}</span> #:
                                <span class="invoice-id">{{ sprintf("%'.08d", $order->id) }}</span><br>
                                <span class="t-invoice-due"> {{ __('Order Number') }}</span>:
                                <span class="invoice-due">{{ $order->order_number }}</span>
                                <br>
                                <span class="t-invoice-created">{{ __('Date') }}</span>:
                                <span class="invoice-created">{{ date('d-M-Y',strtotime($order->created_at)) }}</span><br>
                                <span class="t-invoice-due"> {{ __('Payment Method') }}</span>:
                                <span class="invoice-due">{{$order->method}}</span>
                                <br>
                               
                            </td>
                            
                            <td>
                                <span id="company-name"> <b>{{ __('South India Jewels') }}</b></span><br>
                                <!--<span id="company-address">{{ $admindata->address}}</span><br>
                                <span id="company-town">{{ $admindata->city }}{{  __(',') }}{{ $admindata->admin_state }}{{  __(',') }}{{ $admindata->zip_code }}</span><br>
                                <span id="company-country">{{ $admindata->admin_country}}</span><br>-->
                                <span id="company-country">{{'GST : '.$admindata->gst_number}}</span><br>
                                <br>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            
            <tr class="information">
                <td colspan="2">
                    <table>
                        <tr>
                            <td class="information-company">
                                <span class="t-invoice-from">{{ __('Billing Address') }}</span><br>
                                <span id="client-name">{{ $order->customer_name}}</span><br>
                                <span id="client-co"></span>
                                <span id="client-address">{{ $order->customer_address }}</span><br>
                                <span id="client-town">{{ $order->customer_city }}{{  __(',') }}{{ $order->customer_state }}{{  __(',') }}{{ $order->customer_zip }}</span><br>
                                <span id="client-country">{{ $order->customer_country }}</span><br>
                                <span>Landmark : {{$order->customer_landmark}}</span><br>
                                <span>Phone : {{$order->customer_phone}}</span> <br />
                                 <span>Email : {{$order->customer_email}}</span>
                            </td>
                            
                            <td class="information-client">
                                <span class="t-invoice-to">{{ __('Shipping Address') }}</span><br>
                                <span id="client-name">{{ $order->shipping_name == null ? $order->customer_name : $order->shipping_name}}</span><br>
                                <span id="client-co"></span>
                                <span id="client-address">{{ $order->shipping_address == null ? $order->customer_address : $order->shipping_address }}</span><br>
                                <span id="client-town">{{ $order->shipping_city == null ? $order->customer_city : $order->shipping_city }}{{  __(',') }}{{ $order->shipping_state == null ? $order->customer_state : $order->shipping_state }}{{  __(',') }}{{ $order->shipping_zip == null ? $order->customer_zip : $order->shipping_zip }}</span><br>
                                <span id="client-country">{{ $order->shipping_country == null ? $order->customer_country : $order->shipping_country }}</span><br>
                                <span>Landmark : {{$order->shipping_landmark == null ? $order->customer_landmark : $order->shipping_landmark}}</span><br />
                                <span>Phone : {{$order->shipping_phone == null ? $order->customer_phone : $order->shipping_phone}}</span><br />
                                <span>Email : {{$order->shipping_email == null ? $order->customer_email : $order->shipping_email}}</span>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>	
		
		@if($admindata->admin_state == ($order->shipping_state == null ? $order->customer_state : $order->shipping_state))
            
        <table class="invoice-payment" cellpadding="0" cellspacing="0">
            <tr class="heading">
                <td>
                    <span class="t-payment-method">{{ __('Product Details') }}</span>
                </td>
                <td>
                    <span class="t-payment-method">{{ __('Product Price') }}</span>
                </td>
                <td>
                    <table class="intn_sale-tax">
                        <tbody>
                            <tr>
                                <td>
                                    <span class="t-payment-method">{{ __('SGST 1.5%') }}</span>
                                </td>
                                <td>
                                    <span class="t-payment-method">{{ __('CGST 1.5%') }}</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
                <td>
                    <span class="t-payment-method"> {{ __('Product Price') }} <em>{{ __('(Inclusive of all taxes)') }}</em> </span>
                </td>
            </tr>
            @php
                                        $subtotal = 0;
                                        $tax = 0;
                                        @endphp
                                        @foreach($cart->items as $product)
										@if($product['item']['user_id'] != 0)
                                                @php
                                                $user = App\Models\User::find($product['item']['user_id']);
                                                $productsku = App\Models\Product::find($product['item']['id']);
                                                @endphp
												@endif
            <tr class="details">
                <td>
                    <span class="t-payment-method">{{ $product['item']['name']}} x {{$product['qty']}} {{ $product['item']['measure'] }} </span> <br> 
                    <span>{{'SKU : '.$productsku->sku}}</span> @if(!empty($product['size']))  <br />
					<span>                                          
<p><b>Option : </b> {{str_replace('-',' ',$product['size'])}} </p>
</span>@endif @if(!empty($product['keys']))<br />
					<span>
                                            @foreach( array_combine(explode(',', $product['keys']), explode(',', $product['values']))  as $key => $value)
                                            <p><b>{{ ucwords(str_replace('_', ' ', $key))  }} : </b> {{ $value }} 
											@php 
											$pr_at = $product['item']['attributes'];
	                                        $pr_arr = json_decode($pr_at, true);
											@endphp
											<b> prices : </b>{{ $pr_arr [$key]['prices'][0] }}</p>
                                            @endforeach
                                            </span> @endif <br />
                    <span>{{'Sold By :'. $user->name}}</span>
                </td>
                <td>
				                            @php
                                            $product_prices = round($product['price'], 2);
											$product_cal =3/100;
											$main_product_cal= $product_cal+1;
											$product_price= $product_prices/$main_product_cal;
                                            @endphp
                    <span class="t-payment-method">{{$order->currency_sign}} {{ round($product_price * $order->currency_value , 2) }}</span>
                </td>
                <td>
                    <table class="intn_sale-tax">
                        <tbody>
                            <tr>
                                <td>
								@php
                                            $sgst = $product_price*1.5/100;
                                            @endphp
                                    <span class="t-payment-method">{{$order->currency_sign}} {{ round($sgst * $order->currency_value , 2) }}</span>
                                </td>
                                <td>
								@php
                                            $cgst = $product_price*1.5/100;
                                            @endphp
                                    <span class="t-payment-method">{{$order->currency_sign}} {{ round($cgst * $order->currency_value , 2) }}</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
				@php
                                            $ship_cost = $order->shipping_cost + $order->packing_cost;
                                            @endphp
                <td>
                    <span class="t-payment-method">  @php
                                            $total = $product_price + $sgst + $cgst;
                                            @endphp 
											{{$order->currency_sign}}{{ round($total * $order->currency_value, 2) }}
											 @php
                                            $subtotal += round($total * $order->currency_value, 2);
                                            @endphp 
											
											</span>
                </td>
            </tr>
			@endforeach

          </table>
		  @else
			   <table class="invoice-payment" cellpadding="0" cellspacing="0">
            <tr class="heading">
                <td>
                    <span class="t-payment-method">{{ __('Product Details') }}</span>
                </td>
                <td>
                    <span class="t-payment-method">{{ __('Product Price') }}</span>
                </td>
                <td>
                    <span class="t-payment-method">{{ __('Tax Type : IGST 3%') }} </span>
                </td>
                <td>
                    <span class="t-payment-method"> {{ __('Product Price') }} <em>{{ __('(Inclusive of all taxes)') }}</em> </span>
                </td>
            </tr>
		@php	$subtotal = 0;
                                        $tax = 0;
                                        @endphp
                                        @foreach($cart->items as $product)
										@if($product['item']['user_id'] != 0)
                                                @php
                                                $user = App\Models\User::find($product['item']['user_id']);
                                                $productsku = App\Models\Product::find($product['item']['id']);
                                                @endphp
												@endif
            
            <tr class="details">
                <td>
                    <span class="t-payment-method">{{ $product['item']['name']}} x {{$product['qty']}} {{ $product['item']['measure'] }} </span> <br> 
                    <span>{{'SKU : '.$productsku->sku}}</span> <br />
					<span>@if(!empty($product['size']))                                            
<p><b>Option : </b> {{str_replace('-',' ',$product['size'])}} </p>
@endif</span> <br />
					<span>@if(!empty($product['keys']))
                                            @foreach( array_combine(explode(',', $product['keys']), explode(',', $product['values']))  as $key => $value)
                                            <p><b>{{ ucwords(str_replace('_', ' ', $key))  }} : </b> {{ $value }} 
											@php 
											$pr_at = $product['item']['attributes'];
	                                        $pr_arr = json_decode($pr_at, true);
											@endphp
											<b> prices : </b>{{ $pr_arr [$key]['prices'][0] }}</p>
                                            @endforeach
                                            @endif</span> <br />
                    <span>{{'Sold By :'. $user->name}}</span>
                </td>
                <td>
				 @php
                                            $product_prices = round($product['price'], 2);
											$product_cal =3/100;
											$main_product_cal= $product_cal+1;
											$product_price= $product_prices/$main_product_cal;											
                                            @endphp
                    <span class="t-payment-method">{{$order->currency_sign}} {{ round($product_price * $order->currency_value , 2) }}</span>
                </td>
                <td>
				@php
                                            $igst = $product_price*3/100;
                                            @endphp
                    <span class="t-payment-method">{{$order->currency_sign}} {{ round($igst * $order->currency_value , 2) }} </span>
                </td>
				@php
                                            $ship_cost = $order->shipping_cost + $order->packing_cost;
                                            @endphp
                <td>
                    <span class="t-payment-method"> @php
                                            $total = $product_price + $igst;
                                            @endphp 
											{{$order->currency_sign}}{{ round($total * $order->currency_value, 2) }} 
											 @php
                                            $subtotal += round($total * $order->currency_value, 2);
                                            @endphp 											
											</span>
                </td>
            </tr>
            @endforeach
                      
        </table>
			  @endif
                                          @php 
											$subtotal = $subtotal + $ship_cost;
											@endphp 
        <table class="invoice-items" cellpadding="0" cellspacing="0">
<tr class="">
                <td><span class="">{{ __('Shipping Cost :') }}</span></td>
                <td><span class="">{{ App\Models\Currency::where('sign',$order->currency_sign)->first()->name }} {{ round($ship_cost, 2) }}</span></td>
            </tr>		
            <tr class="heading">
                <td><span class="t-item">{{ __('Subtotal :') }}</span></td>
                <td><span class="t-price">{{$order->currency_sign}}{{ round($subtotal, 2) }}</span></td>
            </tr>
        </table>
        
        <div class="invoice-summary">
            <div class="invoice-total">{{ __('Thank You For Your Purchase') }}</div> <br>
            <span>{{ __('If you have any questions about this invoice, Please contact - info@southindiajewels.com') }}</span>
        </div>
    </div>
   
</div>
<!-- Main Content Area End -->
</div>
</div>
</div>

@endsection