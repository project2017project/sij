<?php $__env->startSection('content'); ?>
<div class="content-area">
    <div class="mr-breadcrumb">
        <div class="row">
            <div class="col-lg-12">
                <h4 class="heading"><?php echo e(__('Order Invoice')); ?> <a class="add-btn" href="javascript:history.back();"><i
                            class="fas fa-arrow-left"></i> <?php echo e(__('Back')); ?></a></h4>
                <ul class="links">
                    <li>
                        <a href="<?php echo e(route('admin.dashboard')); ?>"><?php echo e(__('Dashboard')); ?> </a>
                    </li>
                    <li>
                        <a href="javascript:;"><?php echo e(__('Orders')); ?></a>
                    </li>
                    <li>
                        <a href="javascript:;"><?php echo e(__('Invoice')); ?></a>
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
                                <!--<span id="company-address"><?php echo e($admindata->address); ?></span><br>
                                <span id="company-town"><?php echo e($admindata->city); ?><?php echo e(__(',')); ?><?php echo e($admindata->admin_state); ?><?php echo e(__(',')); ?><?php echo e($admindata->zip_code); ?></span><br>
                                <span id="company-country"><?php echo e($admindata->admin_country); ?></span><br>-->
                                <span id="company-country"><?php echo e('GST : '.$admindata->gst_number); ?></span><br>
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
		
		<?php if($admindata->admin_state == ($order->shipping_state == null ? $order->customer_state : $order->shipping_state)): ?>
            
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
                    <span><?php echo e('SKU : '.$productsku->sku); ?></span> <?php if(!empty($product['size'])): ?>  <br />
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
                    <span class="t-payment-method"><?php echo e($order->currency_sign); ?> <?php echo e(round($product_price * $order->currency_value , 2)); ?></span>
                </td>
                <td>
                    <table class="intn_sale-tax">
                        <tbody>
                            <tr>
                                <td>
								<?php
                                            $sgst = $product_price*1.5/100;
                                            ?>
                                    <span class="t-payment-method"><?php echo e($order->currency_sign); ?> <?php echo e(round($sgst * $order->currency_value , 2)); ?></span>
                                </td>
                                <td>
								<?php
                                            $cgst = $product_price*1.5/100;
                                            ?>
                                    <span class="t-payment-method"><?php echo e($order->currency_sign); ?> <?php echo e(round($cgst * $order->currency_value , 2)); ?></span>
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
											<?php echo e($order->currency_sign); ?><?php echo e(round($total * $order->currency_value, 2)); ?>

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
		<?php	$subtotal = 0;
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
                    <span class="t-payment-method"><?php echo e($order->currency_sign); ?> <?php echo e(round($product_price * $order->currency_value , 2)); ?></span>
                </td>
                <td>
				<?php
                                            $igst = $product_price*3/100;
                                            ?>
                    <span class="t-payment-method"><?php echo e($order->currency_sign); ?> <?php echo e(round($igst * $order->currency_value , 2)); ?> </span>
                </td>
				<?php
                                            $ship_cost = $order->shipping_cost + $order->packing_cost;
                                            ?>
                <td>
                    <span class="t-payment-method"> <?php
                                            $total = $product_price + $igst;
                                            ?> 
											<?php echo e($order->currency_sign); ?><?php echo e(round($total * $order->currency_value, 2)); ?> 
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
                <td><span class="t-price"><?php echo e($order->currency_sign); ?><?php echo e(round($subtotal, 2)); ?></span></td>
            </tr>
        </table>
        
        <div class="invoice-summary">
            <div class="invoice-total"><?php echo e(__('Thank You For Your Purchase')); ?></div> <br>
            <span><?php echo e(__('If you have any questions about this invoice, Please contact - info@southindiajewels.com')); ?></span>
        </div>
    </div>
   
</div>
<!-- Main Content Area End -->
</div>
</div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>