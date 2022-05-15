<?php $__env->startSection('styles'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

<div class="content-area">
    <div class="mr-breadcrumb">
        <div class="row">
            <div class="col-lg-12">
                <h4 class="heading"><?php echo e($langg->lang549); ?> <a class="add-btn" href="<?php echo e(route('vendor-vorders-newindex')); ?>"><i class="fas fa-arrow-left"></i> <?php echo e($langg->lang550); ?></a></h4>
                <ul class="links">
                    <li><a href="<?php echo e(route('vendor-dashboard')); ?>"><?php echo e($langg->lang441); ?> </a></li>
                    <li><a href="javascript:;"><?php echo e($langg->lang443); ?></a></li><li><a href="javascript:;"><?php echo e($langg->lang549); ?></a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="order-table-wrap">
        <?php echo $__env->make('includes.admin.form-both', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>		
		<?php echo $__env->make('includes.form-success', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <div class="row">
            <div class="col-lg-6">
                <div class="special-box">
                    <div class="heading-area"><h4 class="title"><?php echo e($langg->lang549); ?></h4></div>
                    <div class="table-responsive-sm">
                        <table class="table">
                            <tbody>
                                <tr><th class="45%" width="45%"><?php echo e($langg->lang551); ?></th><td width="10%">:</td><td class="45%" width="45%"><?php echo e($order->order_number); ?></td></tr>
                               
                                
                                <tr><th width="45%"><?php echo e($langg->lang552); ?></th><td width="10%">:</td><td width="45%"><?php echo e(count($order->vendororders()->where('user_id','=',$user->id)->get())); ?></td></tr>

                                <?php if(Auth::user()->id == $order->vendor_shipping_id): ?>
                                <?php if($order->shipping_cost != 0): ?>
                                <?php 
                                $price = round($order->shipping_cost,2);
                                ?>
                                <?php if(DB::table('shippings')->where('price','=',$price)->count() > 0): ?>
                                <tr>
                                    <th width="45%"><?php echo e(DB::table('shippings')->where('price','=',$price)->first()->title); ?></th>
                                    <td width="10%">:</td>
                                    <td width="45%"><?php echo e($order->inr_currency_sign); ?><?php echo e(round($order->shipping_cost, 2)); ?></td>
                                </tr>
                                <?php endif; ?>
                                <?php endif; ?>
                                <?php endif; ?>
                                
                                <?php if(Auth::user()->id == $order->vendor_packing_id): ?>
                                <?php if($order->packing_cost != 0): ?>
                                <?php 
                                $pprice = round(($order->packing_cost),2);
                                ?>
                                <?php if(DB::table('packages')->where('price','=',$pprice)->count() > 0): ?>
                                <tr>
                                    <th width="45%"><?php echo e(DB::table('packages')->where('price','=',$pprice)->first()->title); ?></th>
                                    <td width="10%">:</td>
                                    <td width="45%"><?php echo e($order->inr_currency_sign); ?><?php echo e(round($order->packing_cost, 2)); ?></td>
                                </tr>
                                <?php endif; ?>
                                <?php endif; ?>
                                <?php endif; ?>

                                <tr>
                                    <th width="45%"><?php echo e($langg->lang553); ?></th>
                                    <td width="10%">:</td>
                                    <?php 
                                    
                                    $price = number_format($order->vendororders()->where('user_id','=',$user->id)->sum('price'),2);
                                    
                                      if($user->shipping_cost != 0){
                                          $price = $price  + round($user->shipping_cost , 2);
                                        }
                                    
                                      if($order->tax != 0){
                                        $tax = ($price / 100) * $order->tax;
                                        $price  += $tax;
                                        }   
                                    ?>
                                    <td width="45%"><?php echo e($order->inr_currency_sign); ?><?php echo e(round($price , 2)); ?></td>
                                </tr>
                                <tr>
                                    <th width="45%"><?php echo e($langg->lang554); ?></th><td width="10%">:</td>
                                    <td width="45%"><?php echo e(date('d-M-Y H:i:s a',strtotime($order->created_at))); ?></td>
                                </tr>


                                <tr>
                                    <th width="45%"><?php echo e($langg->lang795); ?></th><td width="10%">:</td>
                                    <td width="45%"><?php echo e($order->method); ?></td>
                                </tr>

                                <?php if($order->method != "Cash On Delivery"): ?>
                                <?php if($order->method=="Stripe"): ?>
                                <tr>
                                    <th width="45%"><?php echo e($order->method); ?> <?php echo e($langg->lang796); ?></th><td width="10%">:</td>
                                    <td width="45%"><?php echo e($order->charge_id); ?></td>
                                </tr>                        
                                <?php endif; ?>
                                <tr>
                                    <th width="45%"><?php echo e($order->method); ?> <?php echo e($langg->lang797); ?></th><td width="10%">:</td>
                                    <td width="45%"><?php echo e($order->txnid); ?></td>
                                </tr>                         
                                <?php endif; ?>

                                <tr>
                                    <th width="45%"><?php echo e($langg->lang798); ?></th><th width="10%">:</th>
                                    <td width="45%"><?php echo $order->payment_status == 'Pending' ? "<span class='badge badge-danger'>". $langg->lang799 ."</span>":"<span class='badge badge-success'>". $langg->lang800 ."</span>"; ?></td>
                                </tr>   
                                <?php if(!empty($order->order_note)): ?>
                                <tr><th width="45%"><?php echo e($langg->lang801); ?></th><th width="10%">:</th><td width="45%"><?php echo e($order->order_note); ?></td></tr> 
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="footer-area">
                        <!--View invoice-->
                        <a href="<?php echo e(route('vendor-order-invoice',$order->order_number)); ?>" class="mybtn1"><i class="fas fa-eye"></i><?php echo e($langg->lang555); ?></a>
                        </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="special-box">
                    <!--Billing Details-->
                    <div class="heading-area"><h4 class="title"><?php echo e($langg->lang556); ?></h4></div>
                    <div class="table-responsive-sm">
                        <table class="table">
                            <tbody>
                                <tr><th width="45%"><?php echo e($langg->lang557); ?></th><th width="10%">:</th><td width="45%"><?php echo e($order->customer_name); ?></td></tr>
                                <tr><th width="45%"><?php echo e($langg->lang558); ?></th><th width="10%">:</th><td width="45%"><?php echo e($order->customer_email); ?></td></tr>
                                <tr><th width="45%"><?php echo e($langg->lang559); ?></th><th width="10%">:</th><td width="45%"><?php echo e($order->customer_phone); ?></td></tr>
                                <tr><th width="45%"><?php echo e($langg->lang560); ?></th><th width="10%">:</th><td width="45%"><?php echo e($order->customer_address); ?></td></tr>
                                <tr><th width="45%"><?php echo e($langg->lang561); ?></th><th width="10%">:</th><td width="45%"><?php echo e($order->customer_country); ?></td></tr>
                                <tr><th width="45%"><?php echo e($langg->lang562); ?></th><th width="10%">:</th><td width="45%"><?php echo e($order->customer_city); ?></td></tr>
                                <tr><th width="45%">State</th><th width="10%">:</th><td width="45%"><?php echo e($order->customer_state); ?></td></tr>
                                <tr><th width="45%"><?php echo e($langg->lang563); ?></th><th width="10%">:</th><td width="45%"><?php echo e($order->customer_zip); ?></td></tr>
                                <tr><th width="45%">Landmark</th><th width="10%">:</th><td width="45%"><?php echo e($order->customer_landmark); ?></td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <?php if($order->dp == 0): ?>
            <div class="col-lg-6">
                <div class="special-box">
                    <!--Shipping Details-->
                    <div class="heading-area"><h4 class="title"><?php echo e($langg->lang564); ?></h4></div>
                    <div class="table-responsive-sm">
                        <table class="table">
                            <tbody>
                            <?php if($order->shipping == "pickup"): ?>
                                <tr><th width="45%"><strong><?php echo e($langg->lang565); ?>:</strong></th><th width="10%">:</th><td width="45%"><?php echo e($order->pickup_location); ?></td></tr>
                            <?php else: ?>
                                <tr><th width="45%"><strong><?php echo e($langg->lang557); ?></strong></th><th width="10%">:</th><td><?php echo e($order->shipping_name == null ? $order->customer_name : $order->shipping_name); ?></td></tr>
                                <tr><th width="45%"><strong><?php echo e($langg->lang558); ?></strong></th><th width="10%">:</th><td width="45%"><?php echo e($order->shipping_email == null ? $order->customer_email : $order->shipping_email); ?></td></tr>
                                <tr><th width="45%"><strong><?php echo e($langg->lang559); ?></strong></th><th width="10%">:</th>
                                    <td width="45%"><?php echo e($order->shipping_phone == null ? $order->customer_phone : $order->shipping_phone); ?></td></tr>
                                <tr><th width="45%"><strong><?php echo e($langg->lang560); ?></strong></th><th width="10%">:</th>
                                    <td width="45%"><?php echo e($order->shipping_address == null ? $order->customer_address : $order->shipping_address); ?></td></tr>
                                <tr><th width="45%"><strong><?php echo e($langg->lang561); ?></strong></th><th width="10%">:</th>
                                    <td width="45%"><?php echo e($order->shipping_country == null ? $order->customer_country : $order->shipping_country); ?></td></tr>
                                <tr><th width="45%"><strong><?php echo e($langg->lang562); ?></strong></th><th width="10%">:</th>
                                    <td width="45%"><?php echo e($order->shipping_city == null ? $order->customer_city : $order->shipping_city); ?></td></tr>
                                    <tr><th width="45%"><strong>State</strong></th><th width="10%">:</th>
                                    <td width="45%"><?php echo e($order->shipping_state == null ? $order->customer_state : $order->shipping_state); ?></td></tr>
                                <tr><th width="45%"><strong><?php echo e($langg->lang563); ?></strong></th><th width="10%">:</th>
                                    <td width="45%"><?php echo e($order->shipping_zip == null ? $order->customer_zip : $order->shipping_zip); ?></td></tr>
                                    <tr><th width="45%"><strong>landmark</strong></th><th width="10%">:</th>
                                    <td width="45%"><?php echo e($order->shipping_landmark == null ? $order->customer_landmark : $order->shipping_landmark); ?></td></tr>
                            <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <?php endif; ?>
            <?php if(!empty($order->shipping_country)): ?>
            <?php if($order->shipping_country == 'India'): ?>
            <?php else: ?>
			<div class="col-lg-6">
                <div class="special-box">
                    <!--Billing Details-->
                    <div class="heading-area"><h4 class="title"><?php echo e(__('Domectic Shipping Addess')); ?></h4></div>
                    <div class="table-responsive-sm">
                        <table class="table">
                            <tbody>
                                <tr><th width="45%"><?php echo e(__('Shop Name')); ?></th><th width="10%">:</th><td width="45%"><?php echo e($admin->shop_name); ?></td></tr>
                                <tr><th width="45%"><?php echo e($langg->lang558); ?></th><th width="10%">:</th><td width="45%"><?php echo e($admin->email); ?></td></tr>
                                <tr><th width="45%"><?php echo e($langg->lang559); ?></th><th width="10%">:</th><td width="45%"><?php echo e($admin->phone); ?></td></tr>
                                <tr><th width="45%"><?php echo e($langg->lang560); ?></th><th width="10%">:</th><td width="45%"><?php echo e($admin->address); ?></td></tr>
                                <tr><th width="45%"><?php echo e($langg->lang561); ?></th><th width="10%">:</th><td width="45%"><?php echo e($admin->admin_country); ?></td></tr>
                                <tr><th width="45%"><?php echo e($langg->lang562); ?></th><th width="10%">:</th><td width="45%"><?php echo e($admin->city); ?></td></tr>
                                <tr><th width="45%"><?php echo e($langg->lang563); ?></th><th width="10%">:</th><td width="45%"><?php echo e($admin->admin_state); ?></td></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <?php endif; ?>
             <?php endif; ?>
            
        </div>
        <div class="row">
            <div class="col-lg-12 order-details-table">
                <div class="mr-table">
                    <!--Products Ordered-->
<div class="text-right" style="display:inline-block; width:100%; padding:30px 20px;"><a href="javascript:void(0)" class="add-btn btn-md"> <span data-toggle="modal" data-target="#product-all" class="">Add Shipping In Bulk<span></span></span></a></div>
                    <h4 class="title"><?php echo e($langg->lang566); ?></h4>
                    <div class="table-responsiv">
					<form id="prodbulkform" class="form-horizontal" action="<?php echo e(route('vendor-ordertracks',$order->id)); ?>" method="POST" enctype="multipart/form-data">      
						    <?php echo e(csrf_field()); ?>

                        <table id="example2" class="table table-hover dt-responsive" cellspacing="0" width="100%">
                            <thead>
                                <tr><th><input type="checkbox" id="checkAll">SKU</th><th>Image</th>  <th><?php echo e($langg->lang568); ?></th><th><?php echo e($langg->lang569); ?></th>
                                <th><?php echo e($langg->lang570); ?></th><th><?php echo e($langg->lang539); ?></th><th><?php echo e($langg->lang574); ?></th><th>Shipping Details</th><th>Status</th><th>Refund/Exchange</th></tr>
                            </thead>
                            <tbody>
							
                                <?php $__currentLoopData = $cart->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                
                                
									
                             <?php
                                $vorder_data = App\Models\VendorOrder::where('user_id',$user->id)->where('order_id',$order->id)->where('product_id',$product['item']['id'])->first();
                                ?>
								<?php
												$return_status=$vorder_data['refund_status'];
												$mp_price=$vorder_data['price'];
												$return_price=$vorder_data['product_item_price'];
												?>
								
												<?php
                                        $ProductDetails = App\Models\Product::find($product['item']['id']);
                                        ?>										
                                <?php if($mp_price!= $return_price ): ?>      
                                <?php if($product['item']['user_id'] != 0): ?>
                                <?php if($product['item']['user_id'] == $user->id): ?>
                                <tr>
                                    <td><input type="hidden" value="<?php echo e($key); ?>"><input type="checkbox" class="vproducts"  name="checkedid[]" value="<?php echo e($product['item']['id']); ?>" > <script>jQuery('.vproducts').click(function () {jQuery(this).siblings('input').prop('checked', this.checked);});</script><?php echo e($ProductDetails->sku); ?>  </td>
                                    
                                    <td><img src="<?php echo e($product['item']['photo'] ? filter_var($product['item']['photo'], FILTER_VALIDATE_URL) ?$product['item']['photo']:asset('assets/images/products/'.$product['item']['photo']):asset('assets/images/noimage.png')); ?>" alt="<?php echo e($product['item']['photo']); ?>"> </td>
                                    







                                 

                                    
                                    
                                    
                                    
                                    
                                    
                                    <td>
                                        <?php if($product['item']['user_id'] != 0): ?>
                                        <?php
                                        $user = App\Models\User::find($product['item']['user_id']);
                                        ?>
                                        <?php if(isset($user)): ?>
                                        <a target="_blank" href="<?php echo e(route('admin-vendor-show',$user->id)); ?>"><?php echo e($user->shop_name); ?></a>
                                        <?php else: ?>
                                        <?php echo e($langg->lang575); ?>

                                        <?php endif; ?>
                                        <?php endif; ?>
            
                                    </td>
                                    <td>
                                        <?php if($product['item']['user_id'] != 0): ?>
                                        <?php
                                        $user = App\Models\VendorOrder::where('order_id','=',$order->id)->where('user_id','=',$product['item']['user_id'])->where('product_id','=',$product['item']['id'])->first();
                                        ?>
                                        <?php if($order->dp == 1 && $order->payment_status == 'Completed'): ?>
                                        <span class="badge badge-success"><?php echo e($langg->lang542); ?></span>
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
                                    
                                    
                                    
                                     
                                     
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    <td>
                                        <input type="hidden" value="<?php echo e($product['license']); ?>">
                                        <?php if($product['item']['user_id'] != 0): ?>
                                        <?php
                                        $user = App\Models\User::find($product['item']['user_id']);
                                        ?>
                                        <?php if(isset($user)): ?>
                                        <a target="_blank" href="<?php echo e(route('front.product', $product['item']['slug'])); ?>"><?php echo e(mb_strlen($product['item']['name'],'utf-8') > 1000 ? mb_substr($product['item']['name'],0,1000,'utf-8').'...' : $product['item']['name']); ?></a>
                                        <?php else: ?>
                                        <a href="javascript:;"><?php echo e(mb_strlen($product['item']['name'],'utf-8') > 30 ? mb_substr($product['item']['name'],0,1000,'utf-8').'...' : $product['item']['name']); ?></a>
                                        <?php endif; ?>
                                        <?php endif; ?>
                                        <?php if($product['license'] != ''): ?>
                                        <a href="javascript:;" data-toggle="modal" data-target="#confirm-delete" class="btn btn-info product-btn" id="license" style="padding: 5px 12px;"><i class="fa fa-eye"></i> View License</a>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if($product['size']): ?>
                                        <p><strong><?php if(!empty($product['item']['variation_title'])): ?><?php echo e($product['item']['variation_title']); ?> <?php else: ?> <?php echo e($langg->lang312); ?> <?php endif; ?> :</strong> <?php echo e(str_replace('-',' ',$product['size'])); ?></p>
                                        <?php endif; ?>
                                        <?php if($product['color']): ?>
                                        <p><strong><?php echo e($langg->lang313); ?> :</strong> <span style="width: 40px; height: 20px; display: block; background: #<?php echo e($product['color']); ?>;"></span></p>
                                        <?php endif; ?>
                                        <p><strong><?php echo e($langg->lang754); ?> :</strong> <?php echo e($order->inr_currency_sign); ?><?php echo e(round($product['item']['price'] , 2)); ?></p>
                                        
                                        <?php
                                       $refundqty = App\Models\VendorOrder::where('order_id','=',$order->id)->where('user_id','=',$product['item']['user_id'])->where('product_id','=',$product['item']['id'])->first();
                                        ?>
                                        
                                        
                                         <?php if(!empty($refundqty->product_item_price)): ?>
                                    <p class="text-danger"> <strong>Refund Amount : </strong> <?php echo e($order->currency_sign); ?><?php echo e(round($refundqty->product_item_price * $order->currency_value , 2)); ?></p>
                                    <?php endif; ?>
                                        
                                        
                                        
                                        <p><strong><?php echo e($langg->lang311); ?> :</strong> <?php echo e($product['qty']); ?> <?php echo e($product['item']['measure']); ?></p>
                                        
                                        
                                       
                                       <?php if(!empty($refundqty->product_item_qty)): ?>
                                       <p class="text-danger">
                                            <strong><?php echo e(__(' Refund Qty')); ?> :</strong> <?php echo e($refundqty->product_item_qty); ?>

                                       </p>
                                       <?php endif; ?>
                                        
                                        
                                        
                                        <?php if(!empty($product['keys'])): ?>
                                        <?php $__currentLoopData = array_combine(explode(',', $product['keys']), explode(',', $product['values'])); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <p><b><?php echo e(ucwords(str_replace('_', ' ', $key))); ?> : </b> <?php echo e($value); ?>

                                        <?php 
											$pr_at = $product['item']['attributes'];
	                                        $pr_arr = json_decode($pr_at, true);
											?>
											<b> + <?php echo e($order->currency_sign); ?> </b><?php echo e($pr_arr [$key]['prices'][0]); ?></p>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo e($order->inr_currency_sign); ?><?php echo e(round($product['price'] , 2)); ?></td>
									<?php
                                        $voders = App\Models\VendorOrder::where('order_id','=',$order->id)->where('user_id','=',$product['item']['user_id'])->where('product_id','=',$product['item']['id'])->first();
                                    ?>
									<td> <a href="javascript:;" data-href="<?php echo e(route('vendor-order-track',$voders->id)); ?>" class="mybtn1 track" data-toggle="modal" data-target="#modal1"><i class="fas fa-truck"></i> Shipping Details</a></td>
									<td>
									<select class="vendor-btn <?php echo e($voders->status); ?>">                                        
                                        <option value="<?php echo e(route('vendor-order-status',['slug' => $voders->id, 'status' => 'processing'])); ?>" <?php echo e($voders->status == "processing" ? 'selected' : ''); ?>><?php echo e($langg->lang541); ?></option>
                                        <option value="<?php echo e(route('vendor-order-status',['slug' => $voders->id, 'status' => 'completed'])); ?>" <?php echo e($voders->status == "completed" ? 'selected' : ''); ?>><?php echo e($langg->lang542); ?></option>
                                        <option value="<?php echo e(route('vendor-order-status',['slug' => $voders->id, 'status' => 'on delivery'])); ?>" <?php echo e($voders->status == "on delivery" ? 'selected' : ''); ?>>Shipped</option>
                                    </select></td>
                                    
                                    
                                    
                                    
                                    
                                       <td>

                                           
                                           <?php if($voders->product_item_price > '0'): ?>
                                                                                       <?php if($voders->price == $voders->product_item_price): ?>
                                            <span class="badge badge-danger">Refunded</span>
                                           <?php endif; ?>
                                           
                                                                                                                                  <?php if($voders->price != $voders->product_item_price): ?>
                                            <span class="badge badge-danger">Partial Refunded</span>
                                           <?php endif; ?>
                                           
                                           <?php endif; ?>
                                           
                                           
                                            <?php
                                        $exchange = App\Models\Exchange::where('order_id','=',$order->id)->where('vendor_id','=',$product['item']['user_id'])->where('product_id','=',$product['item']['id'])->first();
                                        ?>
                                    
                                    <?php if($exchange): ?>
                                    
                                  
                                           
                                         <?php if($exchange->status == 'shipped'): ?>
                                            <span class="badge badge-primary"><?php echo e(ucwords($exchange->status)); ?> Exchange</span>
                                           
                                            <?php elseif($exchange->status == 'pending'): ?>
                                            <span class="badge badge-danger"><?php echo e(ucwords($exchange->status)); ?> Exchange</span>
                                           
                                           <?php elseif($exchange->status == 'notdelivered'): ?>
                                            <span class="badge badge-warning"><?php echo e(ucwords($exchange->status)); ?> Exchange</span>
                                           
                                          
                                    
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
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                </tr>
                                <?php endif; ?>
								<?php endif; ?>
                                <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
						
						<div class="modal fade" id="product-all" tabindex="-1" role="dialog" aria-labelledby="modal1" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="submit-loader">
                                            <img src="http://shop.webngigs.com/assets/images/1564224329loading3.gif" alt="">
                                        </div>
                                        <div class="modal-header d-block text-center">
                                            <h4 class="modal-title d-inline-block">SHIPPING DETAILS</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                        </div>
                                        <div class="modal-body">            <?php echo $__env->make('includes.vendor.form-both', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>                                                     					
                    <input type="hidden" name="order_id" value="<?php echo e($order->id); ?>">
                    <input type="hidden" name="vendor_id" value="<?php echo e($user->id); ?>">
					<?php
						$orderid=$order->id;
                        $vdetails = App\Models\VendorOrder::all()->where('order_id',$orderid)->where('user_id',$user->id);										
                        ?>
						 <?php  
                                              if($vdetails) {
                                              foreach($vdetails as $item){
                                                 
                                                if($item->status) {
                                                       $status= $item->status;
                                                 }
                                              }
                                           }
                                          
                                         ?>
						
					 <input type="hidden" name="status" value="<?php echo e($status); ?>">
                    <div class="row">
                        <div class="col-lg-12">
                         <input type="text" class="input-field" id="companyname" name="companyname" placeholder="<?php echo e(__('Courier Name')); ?>" required="">                           
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <input type="text" class="input-field" id="track-title" name="title" placeholder="<?php echo e(__('Tracking Code')); ?>" required="">
                    </div>

                   </div>
                    <div class="row">
                        <div class="col-lg-12">
                         <input type="text" class="input-field" id="track-details" name="text" placeholder="<?php echo e(__('Tracking URL')); ?>" required="">          
                        </div>
                    </div>
                                   
                                        </div>
                                        <div class="modal-footer justify-content-center">
                                            <p align="center"><button type="submit" id="track-btn" class="prodbulkform-btn btn btn-success referesh-btn" name="save">ADD</button></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
						</form>

                    </div>
                </div>
            </div>
            <div class="col-lg-12 text-center mt-2">
                <!--a class="btn sendEmail send" href="javascript:;" class="send" data-email="<?php echo e($order->customer_email); ?>" data-toggle="modal" data-target="#vendorform"><i class="fa fa-send"></i> <?php echo e($langg->lang576); ?></a-->
                <a class="btn sendEmail send" href="javascript:;" class="send" data-email="<?php echo e($order->customer_email); ?>" data-toggle="modal" data-target="#customnotificationform"><i class="fa fa-send"></i>Add Note</a>
            </div>
        </div>
		<div class="row">
            <div class="col-lg-12 order-details-table">
                <div class="mr-table">
                    <!--Products Ordered-->

                    <h4 class="title">Refunded Ordered</h4>
                    <div class="table-responsiv">
					<form>      
						    <?php echo e(csrf_field()); ?>

                        <table id="example2" class="table table-hover dt-responsive" cellspacing="0" width="100%">
                            <thead>
                                <tr><th>SKU</th><th>Image</th><th><?php echo e($langg->lang568); ?></th><th><?php echo e($langg->lang569); ?></th><th><?php echo e($langg->lang570); ?></th><th><?php echo e($langg->lang539); ?></th><th><?php echo e($langg->lang574); ?></th><th>Refund/Exchange</th></tr>
                            </thead>
                            <tbody>
							
                                <?php $__currentLoopData = $cart->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                
                                
									
                             <?php
                                $vorder_data = App\Models\VendorOrder::where('user_id',$user->id)->where('order_id',$order->id)->where('product_id',$product['item']['id'])->first();
                                ?>
								<?php
												$return_status=$vorder_data['refund_status'];
												$mp_price=$vorder_data['price'];
												$return_price=$vorder_data['product_item_price'];
												?>
								
												<?php
                                        $ProductDetails = App\Models\Product::find($product['item']['id']);
                                        ?>
										
                                <?php if($mp_price == $return_price): ?>      
                                <?php if($product['item']['user_id'] != 0): ?>
                                <?php if($product['item']['user_id'] == $user->id): ?>
                                <tr>
                                    <td><input type="hidden" value="<?php echo e($key); ?>"><?php echo e($ProductDetails->sku); ?>  </td>
                                    
                                    <td><img src="<?php echo e($product['item']['photo'] ? filter_var($product['item']['photo'], FILTER_VALIDATE_URL) ?$product['item']['photo']:asset('assets/images/products/'.$product['item']['photo']):asset('assets/images/noimage.png')); ?>" alt="<?php echo e($product['item']['photo']); ?>"> </td>
                                    
                                    <td>
                                        <?php if($product['item']['user_id'] != 0): ?>
                                        <?php
                                        $user = App\Models\User::find($product['item']['user_id']);
                                        ?>
                                        <?php if(isset($user)): ?>
                                        <a target="_blank" href="<?php echo e(route('admin-vendor-show',$user->id)); ?>"><?php echo e($user->shop_name); ?></a>
                                        <?php else: ?>
                                        <?php echo e($langg->lang575); ?>

                                        <?php endif; ?>
                                        <?php endif; ?>
            
                                    </td>
                                    <td>
                                        <?php if($product['item']['user_id'] != 0): ?>
                                        <?php
                                        $user = App\Models\VendorOrder::where('order_id','=',$order->id)->where('user_id','=',$product['item']['user_id'])->where('product_id','=',$product['item']['id'])->first();
                                        ?>
                                        <?php if($order->dp == 1 && $order->payment_status == 'Completed'): ?>
                                        <span class="badge badge-success"><?php echo e($langg->lang542); ?></span>
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
                                    <td>
                                        <input type="hidden" value="<?php echo e($product['license']); ?>">
                                        <?php if($product['item']['user_id'] != 0): ?>
                                        <?php
                                        $user = App\Models\User::find($product['item']['user_id']);
                                        ?>
                                        <?php if(isset($user)): ?>
                                        <a target="_blank" href="<?php echo e(route('front.product', $product['item']['slug'])); ?>"><?php echo e(mb_strlen($product['item']['name'],'utf-8') > 1000 ? mb_substr($product['item']['name'],0,1000,'utf-8').'...' : $product['item']['name']); ?></a>
                                        <?php else: ?>
                                        <a href="javascript:;"><?php echo e(mb_strlen($product['item']['name'],'utf-8') > 30 ? mb_substr($product['item']['name'],0,1000,'utf-8').'...' : $product['item']['name']); ?></a>
                                        <?php endif; ?>
                                        <?php endif; ?>
                                        <?php if($product['license'] != ''): ?>
                                        <a href="javascript:;" data-toggle="modal" data-target="#confirm-delete" class="btn btn-info product-btn" id="license" style="padding: 5px 12px;"><i class="fa fa-eye"></i> View License</a>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if($product['size']): ?>
                                        <p><strong><?php if(!empty($product['item']['variation_title'])): ?><?php echo e($product['item']['variation_title']); ?> <?php else: ?> <?php echo e($langg->lang312); ?> <?php endif; ?> :</strong> <?php echo e(str_replace('-',' ',$product['size'])); ?></p>
                                        <?php endif; ?>
                                        <?php if($product['color']): ?>
                                        <p><strong><?php echo e($langg->lang313); ?> :</strong> <span style="width: 40px; height: 20px; display: block; background: #<?php echo e($product['color']); ?>;"></span></p>
                                        <?php endif; ?>
                                        <p><strong><?php echo e($langg->lang754); ?> :</strong> <?php echo e($order->inr_currency_sign); ?><?php echo e(round($product['item']['price'] , 2)); ?></p>
                                        
                                        <?php
                                       $refundqty = App\Models\VendorOrder::where('order_id','=',$order->id)->where('user_id','=',$product['item']['user_id'])->where('product_id','=',$product['item']['id'])->first();
                                        ?>
                                        
                                        
                                         <?php if(!empty($refundqty->product_item_price)): ?>
                                    <p class="text-danger"> <strong>Refund Amount : </strong> <?php echo e($order->currency_sign); ?><?php echo e(round($refundqty->product_item_price * $order->currency_value , 2)); ?></p>
                                    <?php endif; ?>
                                        
                                        
                                        
                                        <p><strong><?php echo e($langg->lang311); ?> :</strong> <?php echo e($product['qty']); ?> <?php echo e($product['item']['measure']); ?></p>
                                        
                                        
                                       
                                       <?php if(!empty($refundqty->product_item_qty)): ?>
                                       <p class="text-danger">
                                            <strong><?php echo e(__(' Refund Qty')); ?> :</strong> <?php echo e($refundqty->product_item_qty); ?>

                                       </p>
                                       <?php endif; ?>
                                        
                                        
                                        
                                        <?php if(!empty($product['keys'])): ?>
                                        <?php $__currentLoopData = array_combine(explode(',', $product['keys']), explode(',', $product['values'])); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <p><b><?php echo e(ucwords(str_replace('_', ' ', $key))); ?> : </b> <?php echo e($value); ?>

                                        <?php 
											$pr_at = $product['item']['attributes'];
	                                        $pr_arr = json_decode($pr_at, true);
											?>
											<b> + <?php echo e($order->currency_sign); ?> </b><?php echo e($pr_arr [$key]['prices'][0]); ?></p>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                    </td>
                                    <td><?php echo e($order->inr_currency_sign); ?><?php echo e(round($product['price'] , 2)); ?></td>
									<?php
                                        $voders = App\Models\VendorOrder::where('order_id','=',$order->id)->where('user_id','=',$product['item']['user_id'])->where('product_id','=',$product['item']['id'])->first();
                                    ?>
									<td>

                                           
                                           <?php if($voders->product_item_price > '0'): ?>
                                                                                       <?php if($voders->price == $voders->product_item_price): ?>
                                            <span class="badge badge-danger">Refunded</span>
                                           <?php endif; ?>
                                           
                                                                                                                                  <?php if($voders->price != $voders->product_item_price): ?>
                                            <span class="badge badge-danger">Partial Refunded</span>
                                           <?php endif; ?>
                                           
                                           <?php endif; ?>
                                           
                                           
                                            <?php
                                        $exchange = App\Models\Exchange::where('order_id','=',$order->id)->where('vendor_id','=',$product['item']['user_id'])->where('product_id','=',$product['item']['id'])->first();
                                        ?>
                                    
                                    <?php if($exchange): ?>
                                    
                                  
                                           
                                         <?php if($exchange->status == 'shipped'): ?>
                                            <span class="badge badge-primary"><?php echo e(ucwords($exchange->status)); ?> Exchange</span>
                                           
                                            <?php elseif($exchange->status == 'pending'): ?>
                                            <span class="badge badge-danger"><?php echo e(ucwords($exchange->status)); ?> Exchange</span>
                                           
                                           <?php elseif($exchange->status == 'notdelivered'): ?>
                                            <span class="badge badge-warning"><?php echo e(ucwords($exchange->status)); ?> Exchange</span>
                                           
                                          
                                    
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
										   
										   
										   
										   
									
								
                                </tr>
                                <?php endif; ?>
								<?php endif; ?>
                                <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
						
						
						</form>

                    </div>
                </div>
            </div>
           
        </div>
        <div class="row">
            <div class="col-lg-12 order-details-table">
                <div class="mr-table">
                    <h4 class="title"><?php echo e(__('Notification')); ?></h4>
                    <div class="table-responsiv">
                        <table id="example2" class="table table-hover dt-responsive" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th ><?php echo e(__('Message')); ?></th>
                                    <th><?php echo e(__('Date')); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $tArray[]='0';
                                foreach ($vendernotification as $k => $v) {
                                  $tArray[$k] = $v['id'];
                                }
                                $min_value = min($tArray);
                                ?>
                                <?php $__currentLoopData = $vendernotification; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $msg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td>
                                        <?php echo html_entity_decode($msg->message);?>
                                        <?php if($min_value == $msg->id): ?>
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
                <h4 class="modal-title d-inline-block"><?php echo e($langg->lang577); ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <p class="text-center"><?php echo e($langg->lang578); ?> :<span id="key"></span> 
                <a href="javascript:;" id="license-edit"><?php echo e($langg->lang577); ?></a>
                <a href="javascript:;" id="license-cancel" class="showbox"><?php echo e($langg->lang584); ?></a></p>
                <form method="POST" action="<?php echo e(route('vendor-order-license',$order->order_number)); ?>" id="edit-license" style="display: none;">
                    <?php echo e(csrf_field()); ?>

                    <input type="hidden" name="license_key" id="license-key" value="">
                    <div class="form-group text-center">
                        <input type="text" name="<?php echo e($langg->lang585); ?>" placeholder="<?php echo e($langg->lang579); ?>" style="width: 40%; border: none;" required="">
                        <input type="submit" name="submit" value="Save License" class="btn btn-primary" style="border-radius: 0; padding: 2px; margin-bottom: 2px;">
                    </div>
                </form>
            </div>
            <div class="modal-footer justify-content-center"><button type="button" class="btn btn-danger" data-dismiss="modal"><?php echo e($langg->lang580); ?></button></div>
        </div>
    </div>
</div>



<div class="sub-categori">
    <div class="modal" id="vendorform" tabindex="-1" role="dialog" aria-labelledby="vendorformLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    
                    <h5 class="modal-title" id="vendorformLabel"><?php echo e($langg->lang576); ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid p-0">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="contact-form">
                                    <form id="emailreply">
                                        <?php echo e(csrf_field()); ?>

                                        <ul>
                                            <li><input type="email" class="input-field eml-val" id="eml" name="to" placeholder="<?php echo e($langg->lang583); ?> *" value="" required=""></li>
                                            <li><input type="text" class="input-field" id="subj" name="subject" placeholder="<?php echo e($langg->lang581); ?> *" required=""></li>
                                            <li><textarea class="input-field textarea" name="message" id="msg" placeholder="<?php echo e($langg->lang582); ?> *" required=""></textarea></li>
                                        </ul>
                                        <button class="submit-btn" id="emlsub" type="submit"><?php echo e($langg->lang576); ?></button>
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
                                            <li><input type="hidden" class="input-field" id="vendorid" name="vendorid"  value="<?php echo e($user->id); ?>"></li>
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



<div class="modal fade" id="modal1" tabindex="-1" role="dialog" aria-labelledby="modal1" aria-hidden="true">
                        
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="submit-loader">
                    <img  src="<?php echo e(asset('assets/images/'.$gs->admin_loader)); ?>" alt="">
            </div>
            <div class="modal-header">
            <h5 class="modal-title"></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo e(__('Close')); ?></button>
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
        <h4 class="modal-title d-inline-block"><?php echo e($langg->lang544); ?></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

      <!-- Modal body -->
      <div class="modal-body">
        <p class="text-center"><?php echo e($langg->lang545); ?></p>
        <p class="text-center"><?php echo e($langg->lang546); ?></p>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer justify-content-center">
            <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo e($langg->lang547); ?></button>
            <a class="btn btn-success btn-ok order-btn"><?php echo e($langg->lang548); ?></a>
      </div>

    </div>
  </div>
</div>


<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
<script type="text/javascript">
$('.vendor-btn').on('change',function(){
          $('#confirm-delete2').modal('show');
          $('#confirm-delete2').find('.btn-ok').attr('href', $(this).val());

});
    $('#example2').dataTable( {
        "ordering": false,
        'lengthChange': false,
        'searching'   : false,
        'ordering'    : false,
        'info'        : false,
        'autoWidth'   : false,
        'responsive'  : true
    });
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
                    for(var error in data.errors){
                        $.notify('<li>'+ data.errors[error] +'</li>','error');
                    }
                }else{
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
            url: mainurl+'/vendor/order/addnote',
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
$("#checkAll").click(function () {$('input:checkbox').not(this).prop('checked', this.checked);});  
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.vendor', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>