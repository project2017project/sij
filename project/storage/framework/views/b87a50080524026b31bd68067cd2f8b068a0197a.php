<?php $__env->startSection('styles'); ?>
<style type="text/css">.order-table-wrap table#example2 {margin: 10px auto;}</style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="content-area">
    <div class="mr-breadcrumb">
        <div class="row">
            <div class="col-lg-12">
                <h4 class="heading"><?php echo e(__('Order Details')); ?> <a class="add-btn" href="javascript:history.back();"><i class="fas fa-arrow-left"></i> <?php echo e(__('Back')); ?></a></h4>
                <ul class="links">
                    <li><a href="<?php echo e(route('admin.dashboard')); ?>"><?php echo e(__('Dashboard')); ?> </a></li>
                    <li><a href="javascript:;"><?php echo e(__('Orders')); ?></a></li>
                    <li><a href="javascript:;"><?php echo e(__('Order Details')); ?></a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="order-table-wrap">
        <?php echo $__env->make('includes.admin.form-both', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <div class="row">
            <div class="col-lg-6">
                <div class="special-box"><div class="heading-area"><h4 class="title"><?php echo e(__('Order Details')); ?></h4></div>
                    <div class="table-responsive-sm">
                        <table  class="table">
                            <tbody>
                                <tr><th class="45%" width="45%"><?php echo e(__('Order ID')); ?></th><td width="10%">:</td><td class="45%" width="45%"><?php echo e($order->order_number); ?></td></tr>
                               <!-- <tr><th width="45%"><?php echo e(__('Total Product')); ?></th><td width="10%">:</td><td width="45%"><?php echo e($order->totalQty); ?></td></tr>-->
                                <?php if($order->shipping_cost != 0): ?>
                                <?php 
                                $price = round(($order->shipping_cost / $order->currency_value),2);
                                ?>
                                <?php if(DB::table('shippings')->where('price','=',$price)->count() > 0): ?>
                                <tr><th width="45%"><?php echo e(DB::table('shippings')->where('price','=',$price)->first()->title); ?></th><td width="10%">:</td>
                                    <td width="45%"><?php echo e($order->currency_sign); ?><?php echo e(round($order->shipping_cost, 2)); ?></td></tr>
                                <?php endif; ?>
                                <?php endif; ?>
                                <?php if($order->packing_cost != 0): ?>
                                <?php 
                                $pprice = round(($order->packing_cost / $order->currency_value),2);
                                ?>
                                <?php if(DB::table('packages')->where('price','=',$pprice)->count() > 0): ?>
                                <tr><th width="45%"><?php echo e(DB::table('packages')->where('price','=',$pprice)->first()->title); ?></th><td width="10%">:</td>
                                    <td width="45%"><?php echo e($order->currency_sign); ?><?php echo e(round($order->packing_cost, 2)); ?></td></tr>
                                <?php endif; ?>
                                <?php endif; ?>
                                <tr><th width="45%"><?php echo e(__('Total Cost')); ?></th><td width="10%">:</td>
                                    <td width="45%"><?php echo e($order->currency_sign); ?><?php echo e(round($order->pay_amount * $order->currency_value , 2)); ?></td></tr>
									<?php if($order->currency_sign != '₹'): ?>
                                <tr><th width="45%"><?php echo e(__('INR Rate')); ?></th><td width="10%">:</td>
                                    <td width="45%"><?php echo e($order->inr_currency_sign); ?><?php echo e(round($order->pay_amount , 2)); ?></td></tr>
                               <!-- <tr><th width="45%"><?php echo e(__('USD To INR Payment')); ?></th><td width="10%">:</td>
                                    <td width="45%"><?php echo e($order->currency_sign); ?><?php echo e(round($order->pay_amount * $order->currency_value *$order->currency_orginal_val , 2)); ?></td></tr>-->
                                <!--<tr><th width="45%"><?php echo e(__('International Shiping Charge')); ?></th><td width="10%">:</td>
                                    <td width="45%"><?php echo e($order->currency_sign); ?><?php echo e(round($order->pay_amount-($order->pay_amount * $order->currency_value *$order->currency_orginal_val), 2)); ?></td></tr>-->
									<?php endif; ?>
                                <tr><th width="45%"><?php echo e(__('Ordered Date')); ?></th><td width="10%">:</td>
                                    <td width="45%"><?php echo e(date('d-M-Y H:i:s a',strtotime($order->created_at))); ?></td></tr>
                                <tr><th width="45%"><?php echo e(__('Payment Method')); ?></th><td width="10%">:</td><td width="45%"><?php echo e($order->method); ?></td></tr>
                                <?php if($order->method != "Cash On Delivery"): ?>
                                <?php if($order->method=="Stripe"): ?>
                                <tr><th width="45%"><?php echo e($order->method); ?> <?php echo e(__('Charge ID')); ?></th><td width="10%">:</td><td width="45%"><?php echo e($order->charge_id); ?></td></tr>                        
                                <?php endif; ?>
                                <tr><th width="45%"><?php echo e($order->method); ?> <?php echo e(__('Transaction ID')); ?></th><td width="10%">:</td><td width="45%"><?php echo e($order->txnid); ?></td></tr>                         
                                <?php endif; ?>
                                <tr><th width="45%"><?php echo e(__('Payment Status')); ?></th><th width="10%">:</th>
                                    <td width="45%"><?php echo $order->payment_status == 'Pending' ? "<span class='badge badge-danger'>Unpaid</span>":"<span class='badge badge-success'>Paid</span>"; ?></td>
                                </tr>  
                                <?php if(!empty($order->order_note)): ?>
                                <tr><th width="45%"><?php echo e(__('Order Note')); ?></th><th width="10%">:</th><td width="45%"><?php echo e($order->order_note); ?></td></tr>  
                                <?php endif; ?>
								<?php 
								$alldata = App\Models\VendorOrder::where('order_id','=',$order->id)->where('other_status','=','exchange')->orderBy('id','desc')->first();
                                ?>
								<?php if($alldata['other_status']): ?>
									<tr><th width="45%"><?php echo e(__('Exchange Status')); ?></th><th width="10%">:</th><td width="45%"><?php echo e($alldata['other_status']); ?></td></tr>
								<?php endif; ?>
								
									
                            </tbody>
                        </table>
                    </div>
                    <div class="footer-area">
                        <a href="<?php echo e(route('admin-order-invoice',$order->id)); ?>" class="mybtn1"><i class="fas fa-eye"></i> <?php echo e(__('View Invoice')); ?></a>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="special-box">
                    <div class="heading-area"><h4 class="title"><?php echo e(__('Billing Details')); ?></h4></div>
                    <div class="table-responsive-sm">
                        <table class="table">
                            <tbody>
                                <tr><th width="45%"><?php echo e(__('Name')); ?></th><th width="10%">:</th><td width="45%"><?php echo e($order->customer_name); ?></td></tr>
                                <tr><th width="45%"><?php echo e(__('Email')); ?></th><th width="10%">:</th><td width="45%"><?php echo e($order->customer_email); ?></td></tr>
                                <tr><th width="45%"><?php echo e(__('Phone')); ?></th><th width="10%">:</th><td width="45%"><?php echo e($order->customer_phone); ?></td></tr>
                                <tr><th width="45%"><?php echo e(__('Landmark')); ?></th><th width="10%">:</th><td width="45%"><?php echo e($order->customer_landmark); ?></td></tr>
								<tr><th width="45%"><?php echo e(__('Address')); ?></th><th width="10%">:</th><td width="45%"><?php echo e($order->customer_address); ?></td></tr>
                                <tr><th width="45%"><?php echo e(__('Country')); ?></th><th width="10%">:</th><td width="45%"><?php echo e($order->customer_country); ?></td></tr>
                                <tr><th width="45%"><?php echo e(__('City')); ?></th><th width="10%">:</th><td width="45%"><?php echo e($order->customer_city); ?></td></tr>
								<tr><th width="45%"><?php echo e(__('State')); ?></th><th width="10%">:</th><td width="45%"><?php echo e($order->customer_state); ?></td></tr>
                                <tr><th width="45%"><?php echo e(__('Postal Code')); ?></th><th width="10%">:</th><td width="45%"><?php echo e($order->customer_zip); ?></td></tr>
                                <?php if($order->coupon_code != null): ?>
                                <tr><th width="45%"><?php echo e(__('Coupon Code')); ?></th><th width="10%">:</th><td width="45%"><?php echo e($order->coupon_code); ?></td></tr>
                                <?php endif; ?>
                                <?php if($order->coupon_discount != null): ?>
                                <tr><th width="45%"><?php echo e(__('Coupon Discount')); ?></th><th width="10%">:</th>
                                    <?php if($gs->currency_format == 0): ?>
                                    <td width="45%"><?php echo e($order->currency_sign); ?><?php echo e($order->coupon_discount); ?></td>
                                    <?php else: ?> 
                                    <td width="45%"><?php echo e($order->coupon_discount); ?><?php echo e($order->currency_sign); ?></td>
                                    <?php endif; ?>
                                </tr>
                                <?php endif; ?>
                                <?php if($order->affilate_user != null): ?>
                                <tr><th width="45%"><?php echo e(__('Affilate User')); ?></th><th width="10%">:</th><td width="45%"><?php echo e($order->affilate_user); ?></td></tr>
                                <?php endif; ?>
                                <?php if($order->affilate_charge != null): ?>
                                <tr><th width="45%"><?php echo e(__('Affilate Charge')); ?></th><th width="10%">:</th>
                                    <?php if($gs->currency_format == 0): ?>
                                    <td width="45%"><?php echo e($order->currency_sign); ?><?php echo e($order->affilate_charge); ?></td>
                                    <?php else: ?> 
                                    <td width="45%"><?php echo e($order->affilate_charge); ?><?php echo e($order->currency_sign); ?></td>
                                    <?php endif; ?>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
						
                    </div>
                    <div class="footer-area">
                          <a data-href="<?php echo e(route('admin-order-editbilling',$order->id)); ?>" class="mybtn1 updatedata" data-toggle="modal" data-target="#modal1"><i class="fas fa-pen"></i> <?php echo e(__('Edit Billing Address')); ?></a>
                       </div>
                </div>

            </div>
            <?php if($order->dp == 0): ?>
            <div class="col-lg-6">
                <div class="special-box">
                    <div class="heading-area"><h4 class="title"><?php echo e(__('Shipping Details')); ?></h4></div>
                    <div class="table-responsive-sm">
                        <table class="table">
                            <tbody>
                                <?php if($order->shipping == "pickup"): ?>
                                <tr><th width="45%"><strong><?php echo e(__('Pickup Location')); ?></strong></th><th width="10%">:</th><td width="45%"><?php echo e($order->pickup_location); ?></td></tr>
                                <?php else: ?>
                                <tr><th width="45%"><strong><?php echo e(__('Name')); ?></strong></th><th width="10%">:</th><td><?php echo e($order->shipping_name == null ? $order->customer_name : $order->shipping_name); ?></td></tr>
                                <tr><th width="45%"><strong><?php echo e(__('Email')); ?></strong></th><th width="10%">:</th><td width="45%"><?php echo e($order->shipping_email == null ? $order->customer_email : $order->shipping_email); ?></td></tr>
                                <tr><th width="45%"><strong><?php echo e(__('Phone')); ?></strong></th><th width="10%">:</th><td width="45%"><?php echo e($order->shipping_phone == null ? $order->customer_phone : $order->shipping_phone); ?></td></tr>
                                <tr><th width="45%"><strong><?php echo e(__('Landmark')); ?></strong></th><th width="10%">:</th><td width="45%"><?php echo e($order->shipping_landmark == null ? $order->customer_landmark : $order->shipping_landmark); ?></td></tr>
								<tr><th width="45%"><strong><?php echo e(__('Address')); ?></strong></th><th width="10%">:</th><td width="45%"><?php echo e($order->shipping_address == null ? $order->customer_address : $order->shipping_address); ?></td></tr>
                                <tr><th width="45%"><strong><?php echo e(__('Country')); ?></strong></th><th width="10%">:</th><td width="45%"><?php echo e($order->shipping_country == null ? $order->customer_country : $order->shipping_country); ?></td></tr>
                                <tr><th width="45%"><strong><?php echo e(__('City')); ?></strong></th><th width="10%">:</th><td width="45%"><?php echo e($order->shipping_city == null ? $order->customer_city : $order->shipping_city); ?></td></tr>
								<tr><th width="45%"><strong><?php echo e(__('State')); ?></strong></th><th width="10%">:</th><td width="45%"><?php echo e($order->shipping_state == null ? $order->customer_state : $order->shipping_state); ?></td></tr>
                                <tr><th width="45%"><strong><?php echo e(__('Postal Code')); ?></strong></th><th width="10%">:</th><td width="45%"><?php echo e($order->shipping_zip == null ? $order->customer_zip : $order->shipping_zip); ?></td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
						
                    </div>
                    <div class="footer-area">
						<a data-href="<?php echo e(route('admin-order-editshipping',$order->id)); ?>" class="mybtn1 updatedata" data-toggle="modal" data-target="#modal1"><i class="fas fa-pen"></i> <?php echo e(__('Edit Shipping Address')); ?></a>
                         </div>
                </div>
            </div>

            <?php endif; ?>
            <div class="col-lg-6">
                <div class="special-box">
                    <div class="heading-area"><h4 class="title"><?php echo e(__('Order Actions')); ?></h4></div>
                    <div class="table-responsive-sm">
                        <a href="javascript:;" data-href="<?php echo e(route('admin-order-edit',$order->id)); ?> " class="btn btn-success delivery" data-toggle="modal" data-target="#modal1"><i class="fas fa-file"></i> Order & Payment Status</a>
					<!--	<?php if($order->txnid): ?>
						<a href="javascript:;" data-href="<?php echo e(route('admin-order-tidgenerate',$order->id)); ?> " class="btn btn-success delivery" data-toggle="modal" data-target="#modaltans"><i class="fas fa-hands-helping"></i> Generate Transcation id</a>
					<?php endif; ?>-->
                        <a href="javascript:;" data-href="<?php echo e(route('admin-order-track',$order->id)); ?>" class="btn btn-info track" data-toggle="modal" data-target="#modal1"><i class="fas fa-truck"></i> Track Order</a>
						<?php if($order->method=='Razorpay'): ?>
						<!--a href="javascript:;" data-href="<?php echo e(route('admin-order-razorrefund',$order->id)); ?> " class="btn btn-danger refundorderd" data-toggle="modal" data-target="#modal1"><i class="fas fa-retweet"></i> Refund Online</a-->
					<!--a href="javascript:;" data-href="<?php echo e(route('admin-order-razormanualrefund',$order->id)); ?> " class="btn btn-danger refundorderd" data-toggle="modal" data-target="#modal1"><i class="fas fa-retweet"></i> Refund Offline</a-->
						<?php else: ?>
						<!--a href="javascript:;" data-href="<?php echo e(route('admin-order-refunds',$order->id)); ?> " class="btn btn-danger refundorderd" data-toggle="modal" data-target="#modal1"><i class="fas fa-retweet"></i> Refund </a-->
						<?php endif; ?>
						
                        
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 order-details-table">
                <div class="mr-table">
                    <h4 class="title"><?php echo e(__('Products Ordered')); ?></h4>
                    <div class="table-responsiv">
                        <table id="example2" class="table table-hover dt-responsive" cellspacing="0" width="100%">
                            <thead>
								<tr>
									<th ><?php echo e(__('SKU')); ?></th>
									<th ><?php echo e(__('Image')); ?></th>
									<th ><?php echo e(__('Vendor Name')); ?></th>
									<th><?php echo e(__('Product Title')); ?></th>
									<th><?php echo e(__('Refund/Exchange')); ?></th>
									<th ><?php echo e(__('Details')); ?></th>
									<th><?php echo e(__('Total Price')); ?></th>
								</tr>
							</thead>

                            <tbody>
                            <?php $__currentLoopData = $cart->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						
										<?php
                                        $vendorName = App\Models\User::find($product['item']['user_id']);
                                        ?>
									
                                        <?php
                                        $ProductDetails = App\Models\Product::find($product['item']['id']);
                                        ?>
										
                                <tr>
                                    <td><input type="hidden" value="<?php echo e($key); ?>"><?php echo e($ProductDetails->sku); ?>  </td>
									 <td><img src="<?php echo e($product['item']['photo'] ? filter_var($product['item']['photo'], FILTER_VALIDATE_URL) ?$product['item']['photo']:asset('assets/images/products/'.$product['item']['photo']):asset('assets/images/noimage.png')); ?>" alt="<?php echo e($product['item']['photo']); ?>"> </td>
                                    <td><input type="hidden" value="<?php echo e($key); ?>"><?php echo e($vendorName->shop_name); ?></td>

                                    <td>
                                        <input type="hidden" value="<?php echo e($product['license']); ?>">            
                                        <?php if($product['item']['user_id'] != 0): ?>
                                        <?php
                                        $user = App\Models\User::find($product['item']['user_id']);
                                        ?>
                                        <?php if(isset($user)): ?>
                                      <a target="_blank" href="<?php echo e(route('front.product', $product['item']['slug'])); ?>"><?php echo e(mb_strlen($product['item']['name'],'utf-8') > 130 ? mb_substr($product['item']['name'],0,130,'utf-8').'...' : $product['item']['name']); ?></a>
                                        <?php else: ?>
                                        <a target="_blank" href="<?php echo e(route('front.product', $product['item']['slug'])); ?>"><?php echo e(mb_strlen($product['item']['name'],'utf-8') > 130 ? mb_substr($product['item']['name'],0,130,'utf-8').'...' : $product['item']['name']); ?></a>
                                        <?php endif; ?>
                                        <?php else: ?> 
            
                                            <a target="_blank" href="<?php echo e(route('front.product', $product['item']['slug'])); ?>"><?php echo e(mb_strlen($product['item']['name'],'utf-8') > 130 ? mb_substr($product['item']['name'],0,130,'utf-8').'...' : $product['item']['name']); ?></a>
                                    
                                        <?php endif; ?>
            
            
                                        <?php if($product['license'] != ''): ?>
                                            <a href="javascript:;" data-toggle="modal" data-target="#confirm-delete" class="btn btn-info product-btn" id="license" style="padding: 5px 12px;"><i class="fa fa-eye"></i> <?php echo e(__('View License')); ?></a>
                                        <?php endif; ?>
            
                                    </td>
                                    
                                    
                                    
                                    
                                    
                                    
                                    <td>
                                        <?php if($product['item']['user_id'] != 0): ?>
                                        <?php
                                        $user = App\Models\VendorOrder::where('order_id','=',$order->id)->where('user_id','=',$product['item']['user_id'])->where('product_id','=',$product['item']['id'])->first();
                                        ?>
                                      
                                           <!-- <?php if($user->ref_status == '1'): ?>-->
                                           <!-- <span class="badge badge-danger">Refunded</span>-->
                                           <!--<?php endif; ?>-->
                                           
                                           
                                           <?php if($user->product_item_price > '0'): ?>
                                                                                       <?php if($user->price == $user->product_item_price): ?>
                                            <span class="badge badge-danger">Refunded</span>
                                           <?php endif; ?>
                                           
                                                                                                                                  <?php if($user->price != $user->product_item_price): ?>
                                            <span class="badge badge-danger">Partial Refunded</span>
                                           <?php endif; ?>
                                           
                                           <?php endif; ?>
                                           
                                           <?php endif; ?>
                                           
                                           
                                            <?php
                                        $exchange = App\Models\Exchange::where('order_id','=',$order->id)->where('vendor_id','=',$product['item']['user_id'])->where('product_id','=',$product['item']['id'])->orderBy('created_at', 'desc')->first();
                                        ?>
                                    
                                    <?php if($exchange): ?>
                                    
                                  
                                           
                                         <?php if($exchange->status == 'shipped'): ?>
                                            <span class="badge badge-primary"><?php echo e(ucwords($exchange->status)); ?> Exchange</span>
                                           
                                            <?php elseif($exchange->status == 'pending'): ?>
                                            <span class="badge badge-warning"><?php echo e(ucwords($exchange->status)); ?> Exchange</span>
                                           
                                           <?php elseif($exchange->status == 'notdelivered'): ?>
                                            <span class="badge badge-danger"><?php echo e(ucwords($exchange->status)); ?> Exchange</span>
                                           
                                          
                                    
                                        <?php elseif($exchange->status == 'delivered'): ?>
                                         <span class="badge badge-success"><?php echo e(ucwords($exchange->status)); ?> Exchange</span>
                                           
                                            
                                            
                                           <?php endif; ?>   
                                           
                                    
                                    
                                    <?php endif; ?>
                                    
                                    
                                    
                                    
                                   
                                   
                                    <?php
                                        $exchange_by_coupon = App\Models\VendorOrder::where('order_id','=',$order->id)->where('user_id','=',$product['item']['user_id'])->where('product_id','=',$product['item']['id'])->first();
                                        ?>
                                    
                                    <?php if($exchange_by_coupon): ?>
                                    
                                  
                                           
                                         <?php if($exchange_by_coupon->exchange_by_coupon == '1'): ?>
                                            <span class="badge badge-primary">REFUND VIA Coupan</span>
                                            
                                                                                <?php endif; ?>
                                                                                                                                                                <?php endif; ?>
                                   
                                      
                                           
                                           </td>
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    <td>
                                        <?php if($product['size']): ?>
                                       <p>
                                           <strong> <?php if(!empty($product['item']['variation_title'])): ?><?php echo e($product['item']['variation_title']); ?> <?php else: ?> <?php echo e($langg->lang312); ?> <?php endif; ?> :</strong> <?php echo e(str_replace('-',' ',$product['size'])); ?>

                                       </p>
                                       <?php endif; ?>
                                       <?php if($product['color']): ?>
                                        <p>
                                                <strong><?php echo e(__('color')); ?> :</strong> <span
                                                style="width: 40px; height: 20px; display: block; background: #<?php echo e($product['color']); ?>;"></span>
                                        </p>
                                        <?php endif; ?>
                                        <p>
                                                <strong><?php echo e(__('Price')); ?> :</strong> <?php echo e($order->currency_sign); ?><?php echo e(round($product['item']['price'] * $order->currency_value , 2)); ?>

                                        </p>
                                       <p>
                                            <strong><?php echo e(__('Qty')); ?> :</strong> <?php echo e($product['qty']); ?> <?php echo e($product['item']['measure']); ?>

                                       </p>
                                       
                                       <?php
                                       $refundqty = App\Models\VendorOrder::where('order_id','=',$order->id)->where('user_id','=',$product['item']['user_id'])->where('product_id','=',$product['item']['id'])->first();
                                        ?>
                                       
                                       <?php if(!empty($refundqty->product_item_qty)): ?>
                                       <p class="text-danger">
                                            <strong><?php echo e(__(' Refund Qty')); ?> :</strong> <?php echo e($refundqty->product_item_qty); ?>

                                       </p>
                                       <?php endif; ?>
                                            <?php if(!empty($product['keys'])): ?>
                                            <?php $__currentLoopData = array_combine(explode(',', $product['keys']), explode(',', $product['values'])); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <p><b><?php echo e(ucwords(str_replace('_', ' ', $key))); ?> : </b> <?php echo e($value); ?> </p>
                                            <?php 
											$pr_at = $product['item']['attributes'];
	                                        $pr_arr = json_decode($pr_at, true);
											?>
											<b>+  <?php echo e($order->currency_sign); ?></b><?php echo e($pr_arr [$key]['prices'][0]); ?></p>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php endif; ?>
                                    </td>
                                    <td><p><?php echo e($order->currency_sign); ?><?php echo e(round($product['price'] * $order->currency_value , 2)); ?></p>
                                     <?php if(!empty($refundqty->product_item_price)): ?>
                                    <p class="text-danger"> <strong>Refund Amount : </strong> <?php echo e($order->currency_sign); ?><?php echo e(round($refundqty->product_item_price * $order->currency_value , 2)); ?></p>
                                    <?php endif; ?>
                                    </td>
                                    
                                    <td>
                                        <?php if($product['item']['user_id'] != 0): ?>
                                        <?php
                                        $user = App\Models\VendorOrder::where('order_id','=',$order->id)->where('user_id','=',$product['item']['user_id'])->where('product_id','=',$product['item']['id'])->first();
                                        ?>
                                        <?php if($order->dp == 1 && $order->payment_status == 'Completed'): ?>
                                        <span class="badge badge-success"><?php echo e($langg->lang542); ?></span>
                                        <?php elseif($order->status == 'failure'): ?>
                                            <span class="badge badge-warning"><?php echo e(ucwords($order->status)); ?></span>
                                        <?php else: ?>
                                            <?php if($user->status == 'pending'): ?>
                                            <span class="badge badge-warning"><?php echo e(ucwords($user->status)); ?></span>
                                            <?php elseif($user->status == 'processing'): ?>
                                            <span class="badge badge-info"><?php echo e(ucwords($user->status)); ?></span>
                                           <?php elseif($user->status == 'on delivery'): ?>
                                            <span class="badge badge-primary"><?php echo e(ucwords($user->status)); ?></span>
                                           <?php elseif($user->status == 'completed'): ?>
                                            <span class="badge badge-success"><?php echo e(ucwords($user->status)); ?></span>
                                           <?php elseif($user->status == 'declined'): ?>
                                            <span class="badge badge-danger"><?php echo e(ucwords($user->status)); ?></span>
                                           <?php endif; ?>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                    </td>

                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-lg-12 text-center mt-2">
                <a class="btn sendEmail send" href="javascript:;" class="send" data-email="<?php echo e($order->customer_email); ?>" data-toggle="modal" data-target="#vendorform">
                    <i class="fa fa-send"></i> <?php echo e(__('Send Email')); ?>

                </a>
                <a class="btn sendEmail send" href="javascript:;" class="send" data-email="<?php echo e($order->customer_email); ?>" data-toggle="modal" data-target="#customnotificationform"><i class="fa fa-send"></i>Add Note</a>
            </div>
        </div>

        <div class="row">
        	<div class="col-lg-12 order-details-table">
        		<div class="mr-table">
        			<h4 class="title"><?php echo e(__('Shipping Items By Vendors')); ?></h4>
        			<div class="table-responsiv">
        				<table id="example2" class="table table-hover dt-responsive" cellspacing="0" width="100%">
        					<thead>
        						<tr>
        							
        							
        							<th><?php echo e(__('Vendor Name')); ?></th>
        							<th><?php echo e(__('Product Name')); ?></th>
                                   
        							<th><?php echo e(__('Shipping Company')); ?></th>
        							<th><?php echo e(__('Tracking Code')); ?></th>
        							<th><?php echo e(__('Tracking Url')); ?></th>
        							<th><?php echo e(__('Date')); ?></th>
        						</tr>
        					</thead>
        					<tbody>
                                <?php if(!empty($shippingDetails)): ?>
                                <?php $__currentLoopData = $shippingDetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ship): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                
                                <?php if(!empty($ship->vendor_id)): ?>
        						<tr>
        							<td>
                                       
                                        <?php echo e($ship->userName->shop_name); ?></td>  

        							<td>

                                        <?php $__currentLoopData = $cart->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>                                        
                                        <?php if($product['item']['user_id']===$ship->vendor_id && $product['item']['id']===$ship->pid ): ?>
                                        <a target="_blank" href="<?php echo e(route('front.product', $product['item']['slug'])); ?>"><?php echo e(mb_strlen($product['item']['name'],'utf-8') > 30 ? mb_substr($product['item']['name'],0,30,'utf-8').'...' : $product['item']['name']); ?></a> X <?php echo e($product['qty']); ?>,
                                        <?php endif; ?>

                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </td>
        							
        							<td><?php echo e($ship->companyname); ?></td>
        							<td><a href="<?php echo e($ship->title); ?>" target="_blank"><?php echo e($ship->title); ?></a> </td>
        							<td><?php echo e($ship->text); ?></td>
        							<td><?php echo e(date('d-M-Y',strtotime($ship->created_at))); ?></td>                                   
                                    
        						</tr>
                                <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php else: ?>
                                <tr>
                                    <td colspan="6">No Shipping Details Found</td>
                                </tr>
                                <?php endif; ?>




        					</tbody>
        				</table>
        			</div>
        		</div>
        	</div>        	
        </div>
        <!--<div class="row">
            <div class="col-lg-12 order-details-table">
                <div class="mr-table">
                    <h4 class="title"><?php echo e(__('Shipping Details By Admin')); ?></h4>
                    <div class="table-responsiv">
                        <table id="example2" class="table table-hover dt-responsive" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    
                                    
                                   
                                    <th><?php echo e(__('Product Name')); ?></th>
                                   
                                    <th><?php echo e(__('Shipping Type')); ?></th>
                                    <th><?php echo e(__('Date')); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($shippingDetails)): ?>
                                <?php $__currentLoopData = $shippingDetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ship): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                
                                <?php if(empty($ship->vendor_id)): ?>
                                <tr>
                                    

                                    <td>

                                        <?php $__currentLoopData = $cart->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>                                        
                                       
                                        <a target="_blank" href="<?php echo e(route('front.product', $product['item']['slug'])); ?>"><?php echo e(mb_strlen($product['item']['name'],'utf-8') > 30 ? mb_substr($product['item']['name'],0,30,'utf-8').'...' : $product['item']['name']); ?></a> X <?php echo e($product['qty']); ?>,
                                     

                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </td>
                                    
                                    <td><?php echo e($ship->companyname); ?>/<?php echo e($ship->title); ?>/<?php echo e($ship->text); ?></td>
                                    <td><?php echo e($ship->created_at); ?></td>                                   
                                    
                                </tr>
                                <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php else: ?>
                                <tr>
                                    <td colspan="6">No Shipping Details Found</td>
                                </tr>
                                <?php endif; ?>




                            </tbody>
                        </table>
                    </div>
                </div>
            </div>          
        </div>-->

        <!--div class="row" style="margin-top : 30px;">
            <div class="col-lg-6">
                <div class="special-box">
                    <div class="heading-area"><h4 class="title"><?php echo e(__('Order Account')); ?></h4></div>
                    <div class="table-responsive-sm">
                        <table class="table">
                            <tbody>                           
                                <tr>
                                	<th width="45%"><strong><?php echo e(__('Discounts')); ?>:</strong></th>
                                	<th width="10%">:</th><td width="45%"><?php echo e($order->coupon_discount); ?></td>
                                </tr>
                                <tr>
                                	<th width="45%"><strong><?php echo e(__('Shipping Cost')); ?>:</strong></th>
                                	<th width="10%">:</th><td><?php echo e($order->currency_sign); ?><?php echo e($order->shipping_cost); ?></td>
                                </tr>
                                <tr>
                                	<th width="45%"><strong><?php echo e(__('Order Total')); ?>:</strong></th>
                                	<th width="10%">:</th><td width="45%"><?php echo e($order->currency_sign); ?><?php echo e($order->pay_amount); ?></td>
                                </tr-->
                                <!--tr>
                                	<th width="45%"><strong><?php echo e(__('Vendor’s Earnings')); ?>:</strong></th>
                                	<th width="10%">:</th><td width="45%"><?php echo e($order->pay_amount-$order->admin_fee); ?></td>
                                </tr>
                                <tr>
                                	<th width="45%"><strong><?php echo e(__('Admin Fee')); ?>:</strong></th>
                                	<th width="10%">:</th><td width="45%"><?php echo e($order->admin_fee); ?></td>
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
                    <h4 class="title"><?php echo e(__('Notification')); ?></h4>
                    <div class="table-responsiv">
                        <table id="example2" class="table table-hover dt-responsive" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <tr>
                                        <th ><?php echo e(__('Message')); ?></th>
                                        <th><?php echo e(__('Date')); ?></th>
                                    </tr>
                                </tr>
                            </thead>
                            <tbody>
                                
                                 <?php
                                 $tArray[]='0';
                                foreach ($notification as $k => $v) {
                                  $tArray[$k] = $v['id'];
                                }
                                $min_value = min($tArray);
                              
                                ?>
                                <?php $__currentLoopData = $notification; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $msg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td>
                                       
                                        
                                        <?php echo html_entity_decode($msg->message);?>
                                        <?php if($min_value == $msg->id): ?>
											<?php echo e(__('You Have a new order')); ?>

                                            <br>
                                            <?php echo e(__('Payment Status')); ?> : <?php echo $order->payment_status == 'Pending' ? "<span class='badge badge-danger'>Unpaid</span>":"<span class='badge badge-success'>Paid</span>"; ?>

                                            <br>
                                            <?php if($order->method != "Cash On Delivery"): ?>
                                            <?php if($order->method=="Stripe"): ?>
                                             <?php echo e($order->method); ?> <?php echo e(__('Charge ID')); ?> : <?php echo e($order->charge_id); ?>

                                            <?php endif; ?>
                                            <?php echo e($order->method); ?> <?php echo e(__('Transaction ID')); ?> : <?php echo e($order->txnid); ?>             
                                            <?php endif; ?>
                                        <?php else: ?>
                                        <?php endif; ?>
                                  
                                    </td>
                                    <td><?php echo e($msg->created_at); ?></td>
                                </tr>
                                
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
     



<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="modal1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">

    <div class="modal-header d-block text-center">
        <h4 class="modal-title d-inline-block"><?php echo e(__('License Key')); ?></h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
    </div>

                <div class="modal-body">
                    <p class="text-center"><?php echo e(__('The Licenes Key is')); ?> :  <span id="key"></span> <a href="javascript:;" id="license-edit"><?php echo e(__('Edit License')); ?></a><a href="javascript:;" id="license-cancel" class="showbox"><?php echo e(__('Cancel')); ?></a></p>
                    <form method="POST" action="<?php echo e(route('admin-order-license',$order->id)); ?>" id="edit-license" style="display: none;">
                        <?php echo e(csrf_field()); ?>

                        <input type="hidden" name="license_key" id="license-key" value="">
                        <div class="form-group text-center">
                    <input type="text" name="license" placeholder="<?php echo e(__('Enter New License Key')); ?>" style="width: 40%; border: none;" required=""><input type="submit" name="submit" class="btn btn-primary" style="border-radius: 0; padding: 2px; margin-bottom: 2px;">
                        </div>
                    </form>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><?php echo e(__('Close')); ?></button>
                </div>
            </div>
        </div>
    </div>





<div class="sub-categori">
    <div class="modal" id="vendorform" tabindex="-1" role="dialog" aria-labelledby="vendorformLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="vendorformLabel"><?php echo e(__('Send Email')); ?></h5>
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
                                    <?php echo e(csrf_field()); ?>

                                    <ul>
                                        <li>
                                            <input type="email" class="input-field eml-val" id="eml" name="to" placeholder="<?php echo e(__('Email')); ?> *" value="" required="">
                                        </li>
                                        <li>
                                            <input type="text" class="input-field" id="subj" name="subject" placeholder="<?php echo e(__('Subject')); ?> *" required="">
                                        </li>
                                        <li>
                                            <textarea class="input-field textarea" name="message" id="msg" placeholder="<?php echo e(__('Your Message')); ?> *" required=""></textarea>
                                        </li>
										<li><input type="hidden" class="input-field" id="orderid" name="orderid"  value="<?php echo e($order->id); ?>"></li>
                                            <li><input type="hidden" class="input-field" id="vendorid" name="vendorid"  value=""></li>
                                    </ul>
                                    <button class="submit-btn" id="emlsub" type="submit"><?php echo e(__('Send Email')); ?></button>
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



<div class="sub-categori">
    <div class="modal" id="customnotificationform" tabindex="-1" role="dialog" aria-labelledby="vendorformLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    
                    <h5 class="modal-title" id="vendorformLabel">Add Note</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid p-0">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="contact-form">
                                    <form id="addnotevendor">
                                        <?php echo e(csrf_field()); ?>

                                        <ul>
                                            <li><input type="hidden" class="input-field" id="orderid" name="orderid"  value="<?php echo e($order->id); ?>"></li>
                                            <li><input type="hidden" class="input-field" id="vendorid" name="vendorid"  value=""></li>
                                            <li><textarea class="input-field textarea" name="message" id="msg" placeholder="<?php echo e($langg->lang582); ?> *" required=""></textarea></li>
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



<div class="modal fade" id="confirm-delete2" tabindex="-1" role="dialog" aria-labelledby="modal1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="submit-loader">
            <img  src="<?php echo e(asset('assets/images/'.$gs->admin_loader)); ?>" alt="">
        </div>
    <div class="modal-header d-block text-center">
        <h4 class="modal-title d-inline-block"><?php echo e(__('Update Status')); ?></h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
    </div>

      <!-- Modal body -->
      <div class="modal-body">
        <p class="text-center"><?php echo e(__("You are about to update the order's status.")); ?></p>
        <p class="text-center"><?php echo e(__('Do you want to proceed?')); ?></p>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer justify-content-center">
            <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo e(__('Cancel')); ?></button>
            <a class="btn btn-success btn-ok order-btn"><?php echo e(__('Proceed')); ?></a>
      </div>

    </div>
  </div>
</div>


<div class="modal fade" id="modal1" tabindex="-1" role="dialog" aria-labelledby="modal1" aria-hidden="true">                        
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="submit-loader"><img  src="<?php echo e(asset('assets/images/'.$gs->admin_loader)); ?>" alt=""></div>
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer"><button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo e(__('Close')); ?></button></div>
        </div>
    </div>
</div>

<div class="modal fade" id="modaltans" tabindex="-1" role="dialog" aria-labelledby="modal1" aria-hidden="true">                        
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="submit-loader"><img  src="<?php echo e(asset('assets/images/'.$gs->admin_loader)); ?>" alt=""></div>
            <div class="modal-header">
                <h5 class="modal-title">Add Transcation ID</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
			<form id="geniusformdata" action="<?php echo e(route('admin-order-tidupdate',$order->id)); ?>" method="POST" enctype="multipart/form-data">
                        <?php echo e(csrf_field()); ?>

                        <div class="row">
                          <div class="col-lg-4">
                            <div class="left-area">
                                <h4 class="heading"><?php echo e(__('Transaction Id')); ?> *</h4>                                
                            </div>
                          </div>
                          <div class="col-lg-7">
						  <input type ="text" name="tansid" placeholder="<?php echo e(__('Enter Transaction Id')); ?>" required>                            
                          </div>
                        </div>



                        <br>
                        <div class="row">
                          <div class="col-lg-4">
                            <div class="left-area">
                              
                            </div>
                          </div>
                          <div class="col-lg-7">
                            <button class="addProductSubmit-btn" type="submit"><?php echo e(__('Save')); ?></button>
                          </div>
                        </div>
                      </form></div>
            <div class="modal-footer"><button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo e(__('Close')); ?></button></div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>


<?php $__env->startSection('scripts'); ?>

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
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>