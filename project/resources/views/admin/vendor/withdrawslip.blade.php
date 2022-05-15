<!DOCTYPE html><html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"/></head>
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
    font-size: 8pt;
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
    display: block;
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
<body>
@php
$users_name = App\Models\User::all()->where('is_vendor','2')->where('id',$withdraws->user_id)->pluck('shop_name')->implode(',');
@endphp
 <div class="invoice-box">
        <table cellpadding="0" cellspacing="0">
            <tr class="top">
                <td colspan="2">
                    <table>
                        <tr>
                            <td class="title">
                                <span class="t-invoice">{{ __('WITHDRAW SLIP') }}</span><br><br>
								<span class="invoice-number">{{ __('Vendor Name') }}</span> :
                                <span class="invoice-id">{{ $users_name }}</span><br>
                                <span class="invoice-number">{{ __('Invoice') }}</span> #:
                                <span class="invoice-id">{{ sprintf("%'.08d", $withdraws->id) }}</span><br> 
                                <span class="t-invoice-created">{{ __('Date') }}</span>:
                                <span class="invoice-created">{{ date('d-M-Y',strtotime($withdraws->created_at)) }}</span><br>                                
                               
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
            
        </table>	
		
		<p style="text-align : center; font-size : 12px; margin-bottom : 0;"> (Amount In INR) </p>
            
        <table class="invoice-payment" cellpadding="0" cellspacing="0">
            <tr  style="background:#eeeeee; font-size : 13px;">
                <td>
                    <span class="t-payment-method">{{ __('Order ID') }}</span>
                </td>
                <td>
                    <span class="t-payment-method">{{ __('Price') }}</span>
                </td>
				<td>
                    <span class="t-payment-method">{{ __('Commission') }}</span>
                </td>
                <td>
                    <span style="text-align: left;">{{ __('IGST') }}</span>
                </td>
               
                <td>
                    <span style="text-align: left;">{{ __('SGST') }}</span>
                </td>
                <td>
                    <span style="text-align: left;">{{ __('CGST') }}</span>
                </td>
                
                <td>
                    <span style="text-align: left;">{{ __('TCS') }}</span>
                </td>
                <td>
                    <span class="t-payment-method">{{ __('Net Payment') }}</span>
                </td>                
            </tr>	
            @php
			$tsprice = 0;
			$tscommission = 0;
			$tsigst = 0;
			$tssgst = 0;			
			$tscgst = 0;
			$tstcs = 0;
			$tsnet_pay = 0;
			@endphp				
			           
			@php
			$order_all = explode(',',$withdraws->group_order_id);
			@endphp
			@foreach($order_all as $order_det)
			@php                                                
            $price = App\Models\VendorOrder::where('order_id','=',$order_det)->where('user_id','=',$withdraws->user_id)->sum('price');
			$tcsm = App\Models\VendorOrder::where('order_id','=',$order_det)->where('user_id','=',$withdraws->user_id)->sum('tcs');
            
            
            $ordernumber_withdraw = App\Models\Order::where('id','=',$order_det)->first();
            
            $ordernum = $ordernumber_withdraw->order_number;
            
            @endphp
			@php                                                
            $commission = $price*15/100;
             $sgstm = round($commission*9/100 , 2);
			 
									        $cgstm = round($commission*9/100 , 2);
											$igstm = round($commission*18/100 , 2);
											$tcsm =  $tcsm;
            @endphp
            
            @php       
            
            $vendororder = App\Models\VendorOrder::where('order_id','=',$order_det)->where('user_id','=',$withdraws->user_id)->where('status','=','completed')->first();
            
            if(!empty($vendororder->sgst)){
             $sgst = $sgstm;
            } else {
               $sgst = 0;
            }
            
            
            if(!empty($vendororder->cgst)){
             $cgst = $cgstm;
            } else {
               $cgst = 0;
            }
            
            if(!empty($vendororder->igst)){
             $igst = $igstm;
            } else {
               $igst = 0;
            }
            
            if(!empty($vendororder->tcs)){
             $tcs = $tcsm;
            } else {
               $tcs = 0;
            }
            
            $commission = $price*15/100;
            @endphp
            
            
			@php                          
			
			
			if(!empty($vendororder->sgst)){
			if(!empty($vendororder->tcs)){
             $net_pay = $price-$commission-$sgst-$cgst-$tcs;
            } else {
            $net_pay = $price-$commission-$sgst-$cgst;
            }
            } elseif (!empty($vendororder->igst)){
               if(!empty($vendororder->tcs)){
             $net_pay = $price-$commission-$igst-$tcs;
            } else {
            $net_pay = $price-$commission-$igst;
            }
            } else {
               $net_pay = $price-$commission;
            }
			
			
            
            @endphp
			@php
			$tsprice += $price;
			$tscommission += $commission;
			$tsigst += $igst;
			$tssgst += $sgst;			
			$tscgst += $cgst;
			$tstcs += $tcs;
			$tsnet_pay += $net_pay;
			@endphp
            <tr class="details">
                <td>
                    <span class="t-payment-method">{{ $ordernum }}</span> <br> 
                    
                </td>
				<td>
                    <span class="t-payment-method">{{ $price }}</span> <br> 
                    
                </td>
				<td>
                    <span class="t-payment-method">{{ $commission }}</span> <br>
                </td>
                
                <td>
                    <span style="text-align: left;">{{ $igst }}</span> <br>
                </td>
                
                <td>
                    <span style="text-align: left;">{{ $sgst }}</span> <br>
                </td>
                <td>
                    <span style="text-align: left;">{{ $cgst }}</span> <br>
                </td>
                
                <td>
                    <span style="text-align: left;">{{ $tcs }}</span> <br>
                </td>
				<td>
                    <span class="t-payment-method">{{ $net_pay }}</span> <br> 
                    
                </td>

			</tr>
			@endforeach	
			<tr class="details">
                <td>
                    <span class="t-payment-method"><b>Total</b></span> <br> 
                    
                </td>
				<td>
                    <span class="t-payment-method">{{ $tsprice }}</span> <br> 
                    
                </td>
				<td>
                    <span class="t-payment-method">{{ $tscommission }}</span> <br>
                </td>
                
                <td>
                    <span style="text-align: left;">{{ $tsigst }}</span> <br>
                </td>
                
                <td>
                    <span style="text-align: left;">{{ $tssgst }}</span> <br>
                </td>
                <td>
                    <span style="text-align: left;">{{ $tscgst }}</span> <br>
                </td>
                
                <td>
                    <span style="text-align: left;">{{ $tstcs }}</span> <br>
                </td>
				<td>
                    <span class="t-payment-method">{{ $tsnet_pay }}</span> <br> 
                    
                </td>

			</tr>
			
			<tr class="details">
			    <td colspan="7" style="text-align : right;">+ Credit Note</td>
			    <td style="text-align: left;">{{$withdraws->total_credit_amount}}</td>
			</tr>
			
			<tr class="details">
			    <td colspan="7" style="text-align : right;">- Debit Note</td>
			    <td style="text-align: left;">{{$withdraws->total_debit_amount}}</td>
			</tr>
			
						@php
			$alldata = $withdraws->amount;								
										
            
            $debitdata = $withdraws->total_debit_amount;
        
            
            $creditdata = $withdraws->total_credit_amount;
            
            @endphp
@php
$availabledata = $alldata + $creditdata - $debitdata;
@endphp 
			
			<tr class="details">
			    <td colspan="7" style="text-align : right;">Net Payable</td>
			    <td style="text-align: left;">{{$availabledata}}</td>
			</tr>
			

          </table>		 
			  
			  		   
        
        <div class="invoice-summary">
            <div class="invoice-total">{{ __('Thank You For Your Purchase') }}</div> <br>
            <span>{{ __('Contact us - info@southindiajewels.com') }}</span>
        </div>
    </div>

</body>
</html>
