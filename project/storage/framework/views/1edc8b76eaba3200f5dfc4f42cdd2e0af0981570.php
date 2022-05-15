<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
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
</head>
<body>
    
    
    
    
     <div class="invoice-box">
        <table cellpadding="0" cellspacing="0">
            <tr class="top">
                <td colspan="2">
                    <table>
                        <tr>
                            <td class="title">
                                <span class="t-invoice"><?php echo e(__('INVOICE')); ?></span><br><br>
                                <span class="invoice-number"><?php echo e(__('Invoice')); ?></span> #:
                                <span class="invoice-id"><?php echo e(sprintf("%'.08d", $order->id)); ?></span><br>
                                <span class="t-invoice-due"> <?php echo e(__('Order Number')); ?></span>:
                                <span class="invoice-due"><?php echo e($order->order_number); ?></span>
                                <br>
                                <span class="t-invoice-created"><?php echo e(__('Date')); ?></span>:
                                <span class="invoice-created"><?php echo e(date('d-M-Y',strtotime($order->created_at))); ?></span><br>
                                <span class="t-invoice-due"> <?php echo e(__('Payment Method')); ?></span>:
                                <span class="invoice-due"><?php echo e($order->method); ?></span>
                                <br>
                               
                            </td>
                            
                            <td>
                                <span id="company-name"> <b><?php echo e(__('South India Jewels')); ?></b></span><br>
                                <!--<span>No.200 B Sundaram Pillai Nagar,</span> <br />
                                <span>Vaithyanathan Mudali Street, Tondiarpet</span> <br />
                                <span>Chennai,Tamil Nadu, India, 600081</span> <br />-->
                                <span>GST : 33AEBPV8614C1ZO</span>
                              
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
                                <span id="client-name"><?php echo e($order->customer_name); ?></span><br>
                                <span id="client-co"></span>
                                <span id="client-address"><?php echo e($order->customer_address); ?></span><br>
                                <span id="client-town"><?php echo e($order->customer_city); ?><?php echo e(__(',')); ?><?php echo e($order->customer_state); ?><?php echo e(__(',')); ?><?php echo e($order->customer_zip); ?></span><br>
                                <span id="client-country"><?php echo e($order->customer_country); ?></span><br>
                                <span>Landmark : <?php echo e($order->customer_landmark); ?></span><br>
                                <span>Phone : <?php echo e($order->customer_phone); ?></span> <br />
                                 <span>Email : <?php echo e($order->customer_email); ?></span>
                            </td>
                            
                            <td class="information-client">
                                <span class="t-invoice-to"><?php echo e(__('Shipping Address')); ?></span><br>
                                <span id="client-name"><?php echo e($order->shipping_name == null ? $order->customer_name : $order->shipping_name); ?></span><br>
                                <span id="client-co"></span>
                                <span id="client-address"><?php echo e($order->shipping_address == null ? $order->customer_address : $order->shipping_address); ?></span><br>
                                <span id="client-town"><?php echo e($order->shipping_city == null ? $order->customer_city : $order->shipping_city); ?><?php echo e(__(',')); ?><?php echo e($order->shipping_state == null ? $order->customer_state : $order->shipping_state); ?><?php echo e(__(',')); ?><?php echo e($order->shipping_zip == null ? $order->customer_zip : $order->shipping_zip); ?></span><br>
                                <span id="client-country"><?php echo e($order->shipping_country == null ? $order->customer_country : $order->shipping_country); ?></span><br>
                                <span>Landmark : <?php echo e($order->shipping_landmark == null ? $order->customer_landmark : $order->shipping_landmark); ?></span><br />
                                <span>Phone : <?php echo e($order->shipping_phone == null ? $order->customer_phone : $order->shipping_phone); ?></span><br />
                                <span>Email : <?php echo e($order->shipping_email == null ? $order->customer_email : $order->shipping_email); ?></span>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>	
		
		
		
		<?php if('Tamil Nadu' == ($order->shipping_state == null ? $order->customer_state : $order->shipping_state)): ?>
		 <table class="invoice-payment" cellpadding="0" cellspacing="0">
            <tr class="heading">
                <td>
                    <span class="t-payment-method"><?php echo e(__('Product Details')); ?></span>
                </td>
                <td>
                    <span class="t-payment-method"><?php echo e(__('Product Price')); ?></span>
                </td>
                <td>
                    <table class="intn_sale-tax">
                        <tbody>
                            <tr>
                                <td>
                                    <span class="t-payment-method"><?php echo e(__('SGST 1.5%')); ?></span>
                                </td>
                                <td>
                                    <span class="t-payment-method"><?php echo e(__('CGST 1.5%')); ?></span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
                <td>
                    <span class="t-payment-method"> <?php echo e(__('Product Price')); ?> <em><?php echo e(__('(Inclusive of all taxes)')); ?></em> </span>
                </td>
            </tr>
            <?php
                                        $subtotal = 0;
                                        $tax = 0;
                                        ?>
                                        <?php $__currentLoopData = $cart->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<?php if($product['item']['user_id'] != 0): ?>
                                                <?php
                                                $user = App\Models\User::find($product['item']['user_id']);
                                                $productsku = App\Models\Product::find($product['item']['id']);
                                                ?>
												<?php endif; ?>
            <tr class="details">
                <td>
                    <span class="t-payment-method"><?php echo e($product['item']['name']); ?> x <?php echo e($product['qty']); ?> <?php echo e($product['item']['measure']); ?> </span> <br> 
                    <span><?php echo e('SKU : '.$productsku->sku); ?></span><?php if(!empty($product['size'])): ?> <br />
					<span>                                            
<p><b>Option : </b> <?php echo e(str_replace('-',' ',$product['size'])); ?> </p>
</span><?php endif; ?> <?php if(!empty($product['keys'])): ?><br />
					<span>
                                            <?php $__currentLoopData = array_combine(explode(',', $product['keys']), explode(',', $product['values'])); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <p><b><?php echo e(ucwords(str_replace('_', ' ', $key))); ?> : </b> <?php echo e($value); ?> 
                                            <?php 
											$pr_at = $product['item']['attributes'];
	                                        $pr_arr = json_decode($pr_at, true);
											?>
											<b> prices : </b><?php echo e($pr_arr [$key]['prices'][0]); ?></p>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </span> <?php endif; ?> <br />
                    <span><?php echo e('Sold By :'. $user->name); ?></span>
                </td>
                <td>
				 <?php
                                            $product_prices = round($product['price'], 2);
											$product_cal =3/100;
											$main_product_cal= $product_cal+1;
											$product_price= $product_prices/$main_product_cal;										
                                            ?>
                    <span class="t-payment-method"><?php echo e(App\Models\Currency::where('sign',$order->currency_sign)->first()->name); ?> <?php echo e(round($product_price * $order->currency_value , 2)); ?></span>
                </td>
                <td>
                    <table class="intn_sale-tax">
                        <tbody>
                            <tr>
                                <td>
								<?php
                                            $sgst = $product_price*1.5/100;
                                            ?>
                                    <span class="t-payment-method"><?php echo e(App\Models\Currency::where('sign',$order->currency_sign)->first()->name); ?> <?php echo e(round($sgst * $order->currency_value , 2)); ?></span>
                                </td>
                                <td>
								<?php
                                            $cgst = $product_price*1.5/100;
                                            ?>
                                    <span class="t-payment-method"><?php echo e(App\Models\Currency::where('sign',$order->currency_sign)->first()->name); ?> <?php echo e(round($cgst * $order->currency_value , 2)); ?></span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
				<?php
                                            $ship_cost = $order->shipping_cost + $order->packing_cost;
                                            ?>
                <td>
                    <span class="t-payment-method">  <?php
                                            $total = $product_price + $sgst + $cgst;
                                            ?> 
											<?php echo e(App\Models\Currency::where('sign',$order->currency_sign)->first()->name); ?> <?php echo e(round($total * $order->currency_value, 2)); ?>

											 <?php
                                            $subtotal += round($total * $order->currency_value, 2);
                                            ?> 
											
											</span>
                </td>
            </tr>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

          </table>
          
          
          
          <?php else: ?>
			   <table class="invoice-payment" cellpadding="0" cellspacing="0">
            <tr class="heading">
                <td>
                    <span class="t-payment-method"><?php echo e(__('Product Details')); ?></span>
                </td>
                <td>
                    <span class="t-payment-method"><?php echo e(__('Product Price')); ?></span>
                </td>
                <td>
                    <span class="t-payment-method"><?php echo e(__('Tax Type : IGST 3%')); ?> </span>
                </td>
                <td>
                    <span class="t-payment-method"> <?php echo e(__('Product Price')); ?> <em><?php echo e(__('(Inclusive of all taxes)')); ?></em> </span>
                </td>
            </tr>
			<?php
                                        $subtotal = 0;
                                        $tax = 0;
                                        ?>
                                        <?php $__currentLoopData = $cart->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<?php if($product['item']['user_id'] != 0): ?>
                                                <?php
                                                $user = App\Models\User::find($product['item']['user_id']);
                                                $productsku = App\Models\Product::find($product['item']['id']);
                                                ?>
												<?php endif; ?>
            
            <tr class="details">
                <td>
                    <span class="t-payment-method"><?php echo e($product['item']['name']); ?> x <?php echo e($product['qty']); ?> <?php echo e($product['item']['measure']); ?> </span> <br> 
                    <span><?php echo e('SKU : '.$productsku->sku); ?></span> <br />
					<span><?php if(!empty($product['size'])): ?>                                            
<p><b>Option : </b> <?php echo e(str_replace('-',' ',$product['size'])); ?> </p>
<?php endif; ?></span> <br />
					<span><?php if(!empty($product['keys'])): ?>
                                            <?php $__currentLoopData = array_combine(explode(',', $product['keys']), explode(',', $product['values'])); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <p><b><?php echo e(ucwords(str_replace('_', ' ', $key))); ?> : </b> <?php echo e($value); ?> 
                                           <?php 
											$pr_at = $product['item']['attributes'];
	                                        $pr_arr = json_decode($pr_at, true);
											?>
											<b> prices : </b><?php echo e($pr_arr [$key]['prices'][0]); ?></p>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php endif; ?></span> <br />
                    <span><?php echo e('Sold By :'. $user->name); ?></span>
                </td>
                <td>
				 <?php
                                            $product_prices = round($product['price'], 2);
											$product_cal =3/100;
											$main_product_cal= $product_cal+1;
											$product_price= $product_prices/$main_product_cal;
											?>
                    <span class="t-payment-method"><?php echo e(App\Models\Currency::where('sign',$order->currency_sign)->first()->name); ?> <?php echo e(round($product_price * $order->currency_value , 2)); ?></span>
                </td>
                <td>
				<?php
                                            $igst = $product_price*3/100;
                                            ?>
                    <span class="t-payment-method"><?php echo e(App\Models\Currency::where('sign',$order->currency_sign)->first()->name); ?> <?php echo e(round($igst * $order->currency_value , 2)); ?> </span>
                </td>
				<?php
                                            $ship_cost = $order->shipping_cost + $order->packing_cost;
                                            ?>
                <td>
                    <span class="t-payment-method"> <?php
                                            $total = $product_price + $igst;
                                            ?> 
											<?php echo e(App\Models\Currency::where('sign',$order->currency_sign)->first()->name); ?> <?php echo e(round($total * $order->currency_value, 2)); ?> 
											 <?php
                                            $subtotal += round($total * $order->currency_value, 2);
                                            ?> 
											</span>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                      
        </table>
			  <?php endif; ?>
          
           <?php 
											$subtotal = $subtotal + $ship_cost;
											?> 
        <table class="invoice-items" cellpadding="0" cellspacing="0">   
         <tr class="">
                <td><span class=""><?php echo e(__('Shipping Cost :')); ?></span></td>
                <td><span class=""><?php echo e(App\Models\Currency::where('sign',$order->currency_sign)->first()->name); ?> <?php echo e(round($ship_cost, 2)); ?></span></td>
            </tr>		
            <tr class="heading">
                <td><span class="t-item"><?php echo e(__('Subtotal :')); ?></span></td>
                <td><span class="t-price"><?php echo e(App\Models\Currency::where('sign',$order->currency_sign)->first()->name); ?> <?php echo e(round($subtotal, 2)); ?></span></td>
            </tr>
        </table>
        
        <div class="invoice-summary">
            <div class="invoice-total"><?php echo e(__('Thank You For Your Purchase')); ?></div> <br>
            <span><?php echo e(__('If you have any questions about this invoice, Please contact - info@southindiajewels.com')); ?></span>
        </div>
		
		</div>
    
    
    
    
    
 


</body>
</html>
