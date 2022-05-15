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
    text-align: left;
}


.invoice-box table tr td:nth-child(3) {
    text-align: left;
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
    font-size: 9px;
    width: 25%;
    text-align: left;
    vertical-align: middle;
}


.invoice-box table tr.heading td .intn_sale-tax td{
    width: 50%;
    border-bottom: none;
    text-align: left;
}


.invoice-box table tr td .intn_sale-tax td{
    width: 50%;
    border-bottom: none;
    text-align: left;
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
    font-size: 9px;
    line-height: 18px;
}

.comisson_table td{
    font-size: 9px;
    text-align : left;
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
 <div class="invoice-box">
        <table cellpadding="0" cellspacing="0">
            <tr class="top">
                <td>
                    <table>
                        <tr>
                                                      
                            <td>
                                <span id="company-name"> <b>{{ __('South India Jewels') }}</b></span><br>
                                <span id="company-address">{{ $admindata->address}}</span><br>
                                <span id="company-town">{{ $admindata->city }}{{  __(',') }}{{ $admindata->admin_state }}{{  __(',') }}{{ $admindata->zip_code }}</span><br>
                                <span id="company-country">{{ $admindata->admin_country}}</span><br>
                                <span id="company-country">{{'GST : '.$admindata->gst_number}}</span><br>
                                <br>
                            </td>
                        </tr>
                    </table>
                </td>
                
                 <td>
                    <table>
                        <tr>
                                                      
                            <td>
                                <span id="company-name"> <b>INVOICE :</b> {{substr(preg_replace('/\s+/', '', $user->name), 0, 3)}} {{ date('ym', strtotime($startdate)) }}</span><br>
                                
                                <span id="company-name"> <b>Date :</b> {{ date('d/m/Y', strtotime($enddate)) }}</span><br>
                               
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
								<span id="client-name">{{ $user->name}}</span><br>
                                <span id="client-co"></span>
                                <span id="client-address">{{ $user->address }}</span><br>
                                <span id="client-town">{{ $user->city }}{{  __(',') }}{{ $user->state }}{{  __(',') }}{{ $user->zip }}</span><br>
                                <span id="client-country">{{ $user->country }}</span><br>                                
                                <span>Phone : {{$user->phone}}</span> <br />
                                 <span>Email : {{$user->email}}</span> <br />
                                  <span id="client-country">{{'GST : '.$user->reg_number}}</span><br>
                                 
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            
             
        </table>	
		
		
		
		
		@if($admindata->admin_state == $user->state)
			@if($pay_amount)
            
        <table class="invoice-payment" cellpadding="0" cellspacing="0" style="font-size : 9px;">
            <tr class="heading">
                <td width="20%">
                    <span class="t-payment-method">{{ __('Description') }} </span>
                </td>
                <td width="10%">
                    <span class="t-payment-method">{{ __('Total Sales') }}</span>
                </td>
				<td width="10%">
                    <span class="t-payment-method">{{ __('Total commision') }}</span>
                </td>
                <td width="18%">
                    <table class="intn_sale-tax">
                        <tbody>
                            <tr>
                               
                                <td width="5%">
                                    <span class="t-payment-method">{{ __('SGST 9%') }}</span>
                                </td>
                                <td width="5%">
                                    <span class="t-payment-method">{{ __('CGST 9%') }}</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
                
                 <td width="10%">
                    <span class="t-payment-method">{{ __('Gross Amount') }}</span>
                </td>
                
                 
                
                @if($user->reg_number)
									<td width="6%">
                                    <span class="t-payment-method">{{ __('TCS 1%') }}</span>
                                </td>
								@endif
								
								<td width="8%">
                    <span class="t-payment-method">{{ __('Total Tax Amount') }}</span>
                </td>
								
								
								<td width="8%">
								     <span class="t-payment-method">{{ __('Amount (INR)') }}</span>
								</td>
                
            </tr>
           
             <tr class="details">   
              <td>
                                    {{ __('Marketing Service From') }} {{ date('d/m/Y', strtotime($startdate)) }}  to {{ date('d/m/Y', strtotime($enddate)) }}
                                </td>
				<td>
				<span class="t-payment-method">{{ App\Models\Currency::where('is_default','=','1')->get()->first()->name }} {{ round($pay_amount,2) }}</span>                   
                </td>
                
                
                
                
				<td>
				    
				    @php
				    $admincomission = $pay_amount*15/100; 
				    @endphp
				<span class="t-payment-method">{{ App\Models\Currency::where('is_default','=','1')->get()->first()->name }} {{ round($admincomission,2) }}</span>                 
                
				</td>
				
				
				   <td>
                    <table class="intn_sale-tax">
                        <tbody>
                            <tr>
                               
                                <td>
                                     @php
				    $sgst = $admincomission*9/100; 
				    $cgst = $admincomission*9/100;
				    @endphp
                                    <span class="t-payment-method">{{ App\Models\Currency::where('is_default','=','1')->get()->first()->name }} {{ round($admincomission*9/100,2) }}</span>
                                </td>
                                <td>
                                    <span class="t-payment-method">{{ App\Models\Currency::where('is_default','=','1')->get()->first()->name }} {{ round($admincomission*9/100,2) }}</span>
                                </td>
							
                            </tr>
                        </tbody>
                    </table>
                </td>
                
                	<td>
                	    @php
				    $grossamount = $pay_amount - $admincomission - $sgst - $cgst; 
				    @endphp
				<span class="t-payment-method">{{ App\Models\Currency::where('is_default','=','1')->get()->first()->name }} {{ round($grossamount,2) }}</span>                   
                </td>
				    
				
				
					@if($user->reg_number)
									<td>
									     @php
				    $tcs = $grossamount*1/100; 
				    @endphp
                                    <span class="t-payment-method">{{ App\Models\Currency::where('is_default','=','1')->get()->first()->name }} {{ round($tcs,2) }}</span>
                                </td>
								@endif
				
				
				 <td>
				     	@if($user->reg_number)
				      @php
				    $totaltax = $sgst + $cgst + $tcs; 
				    @endphp
				    @else 
				     @php
				    $totaltax = $sgst + $cgst;
				    @endphp
				    @endif
                    <span class="t-payment-method">{{ App\Models\Currency::where('is_default','=','1')->get()->first()->name }} {{ round($totaltax,2) }}</span>
                </td>
                
                
                 <td>
				     	@if($user->reg_number)
				      @php
				    $totalcom = $admincomission + $sgst + $cgst + $tcs; 
				    @endphp
				    @else 
				    @php
				    $totalcom = $admincomission + $sgst + $cgst;
				    @endphp
				    @endif
                    <span class="t-payment-method">{{ App\Models\Currency::where('is_default','=','1')->get()->first()->name }} {{ round($totalcom,2) }}</span>
                </td>
				
               
            </tr>
			

          </table>
		  @endif
		  @else
			  @if($pay_amount)
			   <table class="invoice-payment" cellpadding="0" cellspacing="0">
            <tr class="heading">
                <td>
                    <span class="t-payment-method">{{ __('Total amount') }}</span>
                </td>
                <td>
                    <span class="t-payment-method">{{ __('Total refund') }}</span>
                </td>
				<td>
                    <span class="t-payment-method">{{ __('Total commision') }}</span>
                </td>
                <td>
                    <span class="t-payment-method">{{ __('Tax Type : IGST 18%') }} </span>
                </td>
                
            </tr>
			
            
            <tr class="details">
               <td>
				<span class="t-payment-method">{{ App\Models\Currency::where('is_default','=','1')->get()->first()->name }} {{ round($pay_amount,2) }}</span>                   
                </td>
				<td>
				<span class="t-payment-method">{{ App\Models\Currency::where('is_default','=','1')->get()->first()->name }} {{ round($refund_fee,2) }}</span>                   
                </td>
				<td>
				<span class="t-payment-method">{{ App\Models\Currency::where('is_default','=','1')->get()->first()->name }} {{ round($pay_amount*15/100,2) }}</span>                 
                
				</td>
                <td>
				<span class="t-payment-method">{{ App\Models\Currency::where('is_default','=','1')->get()->first()->name }} {{ round(($pay_amount*15/100)*18/100,2) }}</span>                   
                </td>
            </tr>
            
                      
        </table>
		@endif
			  @endif
        
        <div class="invoice-summary">
            <div class="invoice-total">{{ __('Thank You For Your Business') }}</div> <br>
            <span>{{ __('If you have any questions about this invoice, Please contact - southindiajewels@gmail.com') }}</span>
        </div>
    </div>

</body>
</html>
