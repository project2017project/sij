<!DOCTYPE html><html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"/></head>
<style>
	@page  { margin: 20px; size: auto; }

@media  print {
    body {
        margin: 0.5cm;
        -webkit-print-color-adjust: exact;
    }
}

@media  only screen and (max-width: 600px) {
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
                                <span id="company-name"> <b><?php echo e(__('South India Jewels')); ?></b></span><br>
                                <span id="company-address"><?php echo e($admindata->address); ?></span><br>
                                <span id="company-town"><?php echo e($admindata->city); ?><?php echo e(__(',')); ?><?php echo e($admindata->admin_state); ?><?php echo e(__(',')); ?><?php echo e($admindata->zip_code); ?></span><br>
                                <span id="company-country"><?php echo e($admindata->admin_country); ?></span><br>
                                <span id="company-country"><?php echo e('GST : '.$admindata->gst_number); ?></span><br>
                                <br>
                            </td>
                        </tr>
                    </table>
                </td>
                
                 <td>
                    <table>
                        <tr>
                                                      
                            <td>
                                <span id="company-name"> <b>INVOICE :</b> <?php echo e(substr(preg_replace('/\s+/', '', $user->name), 0, 3)); ?> <?php echo e(date('ym', strtotime($startdate))); ?></span><br>
                                
                                <span id="company-name"> <b>Date :</b> <?php echo e(date('d/m/Y', strtotime($enddate))); ?></span><br>
                               
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
                                <span class="t-invoice-from"><?php echo e(__('Billing Address')); ?></span><br>
								<span id="client-name"><?php echo e($user->name); ?></span><br>
                                <span id="client-co"></span>
                                <span id="client-address"><?php echo e($user->address); ?></span><br>
                                <span id="client-town"><?php echo e($user->city); ?><?php echo e(__(',')); ?><?php echo e($user->state); ?><?php echo e(__(',')); ?><?php echo e($user->zip); ?></span><br>
                                <span id="client-country"><?php echo e($user->country); ?></span><br>                                
                                <span>Phone : <?php echo e($user->phone); ?></span> <br />
                                 <span>Email : <?php echo e($user->email); ?></span> <br />
                                  <span id="client-country"><?php echo e('GST : '.$user->reg_number); ?></span><br>
                                 
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            
             
        </table>	
		
		
		
		
		<?php if($admindata->admin_state == $user->state): ?>
			<?php if($pay_amount): ?>
            
        <table class="invoice-payment" cellpadding="0" cellspacing="0" style="font-size : 9px;">
            <tr class="heading">
                <td width="20%">
                    <span class="t-payment-method"><?php echo e(__('Description')); ?> </span>
                </td>
                <td width="10%">
                    <span class="t-payment-method"><?php echo e(__('Total Sales')); ?></span>
                </td>
				<td width="10%">
                    <span class="t-payment-method"><?php echo e(__('Total commision')); ?></span>
                </td>
                <td width="18%">
                    <table class="intn_sale-tax">
                        <tbody>
                            <tr>
                               
                                <td width="5%">
                                    <span class="t-payment-method"><?php echo e(__('SGST 9%')); ?></span>
                                </td>
                                <td width="5%">
                                    <span class="t-payment-method"><?php echo e(__('CGST 9%')); ?></span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
                
                 <td width="10%">
                    <span class="t-payment-method"><?php echo e(__('Gross Amount')); ?></span>
                </td>
                
                 
                
                <?php if($user->reg_number): ?>
									<td width="6%">
                                    <span class="t-payment-method"><?php echo e(__('TCS 1%')); ?></span>
                                </td>
								<?php endif; ?>
								
								<td width="8%">
                    <span class="t-payment-method"><?php echo e(__('Total Tax Amount')); ?></span>
                </td>
								
								
								<td width="8%">
								     <span class="t-payment-method"><?php echo e(__('Amount (INR)')); ?></span>
								</td>
                
            </tr>
           
             <tr class="details">   
              <td>
                                    <?php echo e(__('Marketing Service From')); ?> <?php echo e(date('d/m/Y', strtotime($startdate))); ?>  to <?php echo e(date('d/m/Y', strtotime($enddate))); ?>

                                </td>
				<td>
				<span class="t-payment-method"><?php echo e(App\Models\Currency::where('is_default','=','1')->get()->first()->name); ?> <?php echo e(round($pay_amount,2)); ?></span>                   
                </td>
                
                
                
                
				<td>
				    
				    <?php
				    $admincomission = $pay_amount*15/100; 
				    ?>
				<span class="t-payment-method"><?php echo e(App\Models\Currency::where('is_default','=','1')->get()->first()->name); ?> <?php echo e(round($admincomission,2)); ?></span>                 
                
				</td>
				
				
				   <td>
                    <table class="intn_sale-tax">
                        <tbody>
                            <tr>
                               
                                <td>
                                     <?php
				    $sgst = $admincomission*9/100; 
				    $cgst = $admincomission*9/100;
				    ?>
                                    <span class="t-payment-method"><?php echo e(App\Models\Currency::where('is_default','=','1')->get()->first()->name); ?> <?php echo e(round($admincomission*9/100,2)); ?></span>
                                </td>
                                <td>
                                    <span class="t-payment-method"><?php echo e(App\Models\Currency::where('is_default','=','1')->get()->first()->name); ?> <?php echo e(round($admincomission*9/100,2)); ?></span>
                                </td>
							
                            </tr>
                        </tbody>
                    </table>
                </td>
                
                	<td>
                	    <?php
				    $grossamount = $pay_amount - $admincomission - $sgst - $cgst; 
				    ?>
				<span class="t-payment-method"><?php echo e(App\Models\Currency::where('is_default','=','1')->get()->first()->name); ?> <?php echo e(round($grossamount,2)); ?></span>                   
                </td>
				    
				
				
					<?php if($user->reg_number): ?>
									<td>
									     <?php
				    $tcs = $grossamount*1/100; 
				    ?>
                                    <span class="t-payment-method"><?php echo e(App\Models\Currency::where('is_default','=','1')->get()->first()->name); ?> <?php echo e(round($tcs,2)); ?></span>
                                </td>
								<?php endif; ?>
				
				
				 <td>
				     	<?php if($user->reg_number): ?>
				      <?php
				    $totaltax = $sgst + $cgst + $tcs; 
				    ?>
				    <?php else: ?> 
				     <?php
				    $totaltax = $sgst + $cgst;
				    ?>
				    <?php endif; ?>
                    <span class="t-payment-method"><?php echo e(App\Models\Currency::where('is_default','=','1')->get()->first()->name); ?> <?php echo e(round($totaltax,2)); ?></span>
                </td>
                
                
                 <td>
				     	<?php if($user->reg_number): ?>
				      <?php
				    $totalcom = $admincomission + $sgst + $cgst + $tcs; 
				    ?>
				    <?php else: ?> 
				    <?php
				    $totalcom = $admincomission + $sgst + $cgst;
				    ?>
				    <?php endif; ?>
                    <span class="t-payment-method"><?php echo e(App\Models\Currency::where('is_default','=','1')->get()->first()->name); ?> <?php echo e(round($totalcom,2)); ?></span>
                </td>
				
               
            </tr>
			

          </table>
		  <?php endif; ?>
		  <?php else: ?>
			  <?php if($pay_amount): ?>
			   <table class="invoice-payment" cellpadding="0" cellspacing="0">
            <tr class="heading">
                <td>
                    <span class="t-payment-method"><?php echo e(__('Total amount')); ?></span>
                </td>
                <td>
                    <span class="t-payment-method"><?php echo e(__('Total refund')); ?></span>
                </td>
				<td>
                    <span class="t-payment-method"><?php echo e(__('Total commision')); ?></span>
                </td>
                <td>
                    <span class="t-payment-method"><?php echo e(__('Tax Type : IGST 18%')); ?> </span>
                </td>
                
            </tr>
			
            
            <tr class="details">
               <td>
				<span class="t-payment-method"><?php echo e(App\Models\Currency::where('is_default','=','1')->get()->first()->name); ?> <?php echo e(round($pay_amount,2)); ?></span>                   
                </td>
				<td>
				<span class="t-payment-method"><?php echo e(App\Models\Currency::where('is_default','=','1')->get()->first()->name); ?> <?php echo e(round($refund_fee,2)); ?></span>                   
                </td>
				<td>
				<span class="t-payment-method"><?php echo e(App\Models\Currency::where('is_default','=','1')->get()->first()->name); ?> <?php echo e(round($pay_amount*15/100,2)); ?></span>                 
                
				</td>
                <td>
				<span class="t-payment-method"><?php echo e(App\Models\Currency::where('is_default','=','1')->get()->first()->name); ?> <?php echo e(round(($pay_amount*15/100)*18/100,2)); ?></span>                   
                </td>
            </tr>
            
                      
        </table>
		<?php endif; ?>
			  <?php endif; ?>
        
        <div class="invoice-summary">
            <div class="invoice-total"><?php echo e(__('Thank You For Your Business')); ?></div> <br>
            <span><?php echo e(__('If you have any questions about this invoice, Please contact - southindiajewels@gmail.com')); ?></span>
        </div>
    </div>

</body>
</html>
