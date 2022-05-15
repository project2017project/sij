<!DOCTYPE html><html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"/></head>
<body>
    <style>
	@page { margin: 20px; size: auto; }

@media print {
    body {
        margin: 0.5cm;
        -webkit-print-color-adjust: exact;
    }
}

@media only screen and (max-width: 600px) {
    .invoice-box table tr.top table td {
        width: 100%;
        display: block;
        text-align: center;
    }
    
    .invoice-box table tr.information table td {
        width: 100%;
        display: block;
        text-align: center;
    }
}

.invoice-box {
    max-width: 800px;
    margin: auto;
    padding: 0px;
    font-size: 16px;
    line-height: 24px;
    font-family: 'Roboto', sans-serif;
    color: #555;
}

.invoice-box .information #company-name {
    font-weight: bold;
}

.invoice-box .information #client-name {
    font-weight: bold;
}

.invoice-box table {
    width: 100%;
    text-align: left;
}

.invoice-box table td {
    padding: 5px;
    vertical-align: top;
}

.invoice-box table tr td:nth-child(2) {
    text-align: right;
}


.invoice-box table tr td:nth-child(3) {
    text-align: right;
}


.invoice-box table tr td:nth-child(4) {
    text-align: right;
}

.invoice-box table tr.details td {
    padding-bottom: 10px;
    padding-top: 10px;
}

.invoice-box table tr.top table td.title .t-invoice {
    font-size: 35px;
    line-height: 35px;
    color: #333;
    text-transform: uppercase;
    font-weight: 300;
    font-family: 'Roboto', sans-serif;
}

.invoice-box table tr.information table td {
    padding-bottom: 40px;
}

.invoice-box table tr.information span:nth-child(1) {
    font-weight: bold;
    font-size: 11pt;
    text-transform: uppercase;
}

.invoice-box table tr.heading td {
    background: #eee;
    border-bottom: 1px solid #ddd;
    font-weight: bold;
}

.invoice-box table tr.details td {
    padding-bottom: 20px;
}

.invoice-box table tr.item td{
    border-bottom: 1px solid #eee;
}

.invoice-box table tr.item:last-child td {
    border-bottom: none;
}

.invoice-box .invoice-summary {
    border-top: none;
    text-align: left;
    display: inline-block;
    padding: 5pt;
    width: 100%;
    padding-top: 30px;
}

.invoice-box .invoice-summary .invoice-total {
    font-weight: bold;
}

.invoice-box .invoice-summary .invoice-final {
    font-weight: 300;
    padding-top: 8pt;
}

.invoice-box .invoice-summary .invoice-exchange {
    font-weight: 300;
    font-size: 12px;
}


.invoice-box table tr.heading td{
    font-size: 13px;
    width: 25%;
    text-align: right;
    vertical-align: middle;
}


.invoice-box table tr.heading td .intn_sale-tax td{
    width: 50%;
    border-bottom: none;
    text-align: center;
}


.invoice-box table tr td .intn_sale-tax td{
    width: 50%;
    border-bottom: none;
    text-align: center;
    vertical-align: top;
    padding-top: 0;
    padding-bottom: 0;
}


.invoice-box table tr.heading td:nth-child(1) {
    text-align: left;
}

.invoice-box table tr.heading td em{
    font-size: 10px;
    display: inline-block;
    width: 100%;
}

.invoice-box table tr.details td{
    border-bottom: 1px solid #eeeeee;
    font-size: 13px;
    line-height: 18px;
}

.comisson_table td{
    font-size: 13px;
}

.comission_heading td{
    background: #000;
    color: #ffffff;
}

.comisson_table_details td{
    border: 1px solid #eeeeee;
    border-collapse: collapse;
}
	</style>
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
                                <span class="invoice-created">{{ date('d-M-Y',strtotime($order->created_at)) }}</span>
                                <br>
                               
                            </td>
                            
                            <td>
                                <span id="company-name"> <b>{{ __('South India Jewels') }}</b></span><br>
                             
                                <span id="company-country">{{'GST : '.$admindata->gst_number}}</span><br>
                                <br>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            @foreach($cart->items as $product)
										@if($product['item']['user_id'] != 0)
										@if($product['item']['user_id'] == $user->id)
											$user = App\Models\User::find($product['item']['user_id']);
											@endif
										    @endif
											@endforeach

            <tr class="information">
                <td colspan="2">
                    <table>
                        <tr>
                            <td class="information-company">
                                <span class="t-invoice-from">Sold By</span><br>
                                <span id="client-name">{{$user->name}}</span><br>
                                <span id="client-co"></span>
                                <span id="client-address">{{$user->address}}</span><br>
                                <span id="client-town">{{ $user->country }}{{  __(',') }}{{ $user->state }}{{  __(',') }}{{ $user->zip }}</span><br>
                                <span id="client-country">{{'GST : '.$user->reg_number}}</span><br>
                            </td>
                            
                            <td class="information-client">
                              
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
            @if($admindata->admin_state == $user->state)
        <table class="comisson_table" cellpadding="0" cellspacing="0">
            <tr class="comission_heading">
                <td>
                    <span class="t-payment-method">{{ __('Product Details') }}</span>
                </td>
                <td>
                    <span class="t-payment-method">{{ __('Product Price') }}</span>
                </td>
                <td>
                    <span class="t-payment-method">{{ __('Comission') }}</span>
                </td>
            
                                <td>
                                    <span class="t-payment-method">{{ __('SGST 9%') }}</span>
                                </td>
                                <td>
                                    <span class="t-payment-method">{{ __('CGST 9%') }}</span>
                                </td>
                        
                <td>
                    <span class="t-payment-method">{{ __('Gross Payment') }}</span>
                </td>
                <td>
                    <span class="t-payment-method">{{ __('TCS 1%') }}</span>
                </td>
                <td>
                    <span class="t-payment-method">{{ __('Net Amount') }}</span>
                </td>
            </tr>
			
			 @php
                                        $subtotal = 0;$data = 0;
                                        $tax = 0;
                                        $amoutchek = 0;
                                        @endphp
                                        @foreach($cart->items as $product)
										@if($product['item']['user_id'] != 0)
										@if($product['item']['user_id'] == $user->id)
            
            <tr class="comisson_table_details">
			@if($product['item']['user_id'] != 0)
                                                @php
                                                $user = App\Models\User::find($product['item']['user_id']);
                                                $productsku = App\Models\Product::find($product['item']['id']);
                                                @endphp
												@if(isset($user))
                <td>
                    <span class="t-payment-method">{{$product['item']['name']}} x {{$product['qty']}} {{ $product['item']['measure'] }} </span> <br> 
                    <span>{{'SKU : '.$productsku->sku}}</span>
				@if(!empty($product['size']))   <br />	<span>                                            
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
                                            </span>@endif
                </td>
				@endif
                <td>
				@php
                                            $product_price = round($product['price'], 2);											
                                            @endphp
                    <span class="t-payment-method">{{ App\Models\Currency::where('sign',$order->inr_currency_sign)->first()->name }} {{ round($product_price, 2) }}</span>
                </td>
                <td>
				@php
                                            $commission = round($product_price*15/100, 2);
                                            @endphp 
                    <span class="t-payment-method">{{ App\Models\Currency::where('sign',$order->inr_currency_sign)->first()->name }} {{ round($commission, 2) }}</span>
                </td>
              
                                <td>
								@php
                                            $sgst = $commission*9/100;
                                            @endphp 
                                    <span class="t-payment-method">{{ App\Models\Currency::where('sign',$order->inr_currency_sign)->first()->name }} {{ round($sgst, 2) }}</span>
                                </td>
                                <td>
								@php
                                            $cgst = $commission*9/100;
                                            @endphp 
                                    <span class="t-payment-method">{{ App\Models\Currency::where('sign',$order->inr_currency_sign)->first()->name }} {{ round($cgst, 2) }}</span>
                                </td>
                       
                <td>
				@php
                                            $gross_payment = $product_price-$commission-$sgst-$cgst;
                                            @endphp 
                    <span class="t-payment-method"> {{ App\Models\Currency::where('sign',$order->inr_currency_sign)->first()->name }} {{ round($gross_payment, 2) }} </span>
                </td>
                <td>
				@if($user->reg_number)
				@php
                                            $tcs_payment = $gross_payment*1/100;
                                            @endphp 
											 @else
												 @php
                                            $tcs_payment = 0;
                                            @endphp 
	 @endif
                    <span class="t-payment-method"> {{ App\Models\Currency::where('sign',$order->inr_currency_sign)->first()->name }} {{ round($tcs_payment, 2) }}  </span>
                </td>
                <td>
				@php
                                            $net_payment = $gross_payment-$tcs_payment;
                                            @endphp
                    <span class="t-payment-method"> {{ App\Models\Currency::where('sign',$order->inr_currency_sign)->first()->name }} {{ round($net_payment, 2) }}  </span>
                </td>
            </tr>
			@endif
			@endif
			@endif
          @endforeach

            

            
        </table>

 @else
	  <table class="comisson_table" cellpadding="0" cellspacing="0">
            <tr class="comission_heading">
                <td>
                    <span class="t-payment-method">{{ __('Product Details') }}</span>
                </td>
                <td>
                    <span class="t-payment-method">{{ __('Product Price') }}</span>
                </td>
                <td>
                    <span class="t-payment-method">{{ __('Comission') }}</span>
                </td>
            
                                <td>
                                    <span class="t-payment-method">{{ __('IGST 18%') }}</span>
                                </td>
                        
               <td>
                    <span class="t-payment-method">{{ __('Gross Payment') }}</span>
                </td>
                <td>
                    <span class="t-payment-method">{{ __('TCS 1%') }}</span>
                </td>
                <td>
                    <span class="t-payment-method">{{ __('Net Amount') }}</span>
                </td>
            </tr>
             @php
                                        $subtotal = 0;$data = 0;
                                        $tax = 0;
                                        $amoutchek = 0;
                                        @endphp
                                        @foreach($cart->items as $product)
										@if($product['item']['user_id'] != 0)
										@if($product['item']['user_id'] == $user->id)
            <tr class="comisson_table_details">
                @if($product['item']['user_id'] != 0)
                                                @php
                                                $user = App\Models\User::find($product['item']['user_id']);
                                                $productsku = App\Models\Product::find($product['item']['id']);
                                                @endphp
												@if(isset($user))
                <td>
                    <span class="t-payment-method">{{$product['item']['name']}} x {{$product['qty']}} {{ $product['item']['measure'] }} </span> <br> 
                    <span>{{'SKU : '.$productsku->sku}}</span>
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
                                            @endif</span>
                </td>
				@endif
                <td>
				@php
                                            $product_price = round($product['price'], 2);											
                                            @endphp
                    <span class="t-payment-method">{{ App\Models\Currency::where('sign',$order->inr_currency_sign)->first()->name }} {{ round($product_price, 2) }}</span>
                </td>
                 <td>
				@php
                                            $commission = round($product_price*15/100, 2);
                                            @endphp 
                    <span class="t-payment-method">{{ App\Models\Currency::where('sign',$order->inr_currency_sign)->first()->name }} {{ round($commission, 2) }}</span>
                </td>
              
                               <td>
								@php
                                            $igst = $commission*18/100;
                                            @endphp 
                                    <span class="t-payment-method">{{ App\Models\Currency::where('sign',$order->inr_currency_sign)->first()->name }} {{ round($igst, 2) }}</span>
                                </td>
                       
                <td>
				@php
                                            $gross_payment = $product_price-$commission-$igst;
                                            @endphp 
                    <span class="t-payment-method"> {{ App\Models\Currency::where('sign',$order->inr_currency_sign)->first()->name }} {{ round($gross_payment, 2) }} </span>
                </td>
                <td>
				 @php
                                            $tcs_payment = 0;
                                            @endphp 
                    <span class="t-payment-method"> N/A </span>
                </td>
                <td>
				@php
                                            $net_payment = $gross_payment-$tcs_payment;
                                            @endphp
                    <span class="t-payment-method"> {{ App\Models\Currency::where('sign',$order->inr_currency_sign)->first()->name }} {{ round($net_payment, 2) }}  </span>
                </td>
            </tr>
			@endif
			@endif
			@endif
          @endforeach          

            
        </table>

	 @endif
        
        <div class="invoice-summary">
            <div class="invoice-total">{{ __('Thank You For Your Purchase') }}</div> <br>
            <span>{{ __('If you have any questions about this invoice, Please contact - info@southindiajewels.com') }}</span>
        </div>
    </div>
	
		
</body>
</html>