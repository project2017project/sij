<?php $__env->startSection('content'); ?>




<div class="add-product-content1">
    <div class="row">
        <div class="col-lg-12">
            <div class="product-description">
                <div class="body-area">
                    <div class="gocover" style="background: url(<?php echo e(asset('assets/images/'.$gs->admin_loader)); ?>) no-repeat scroll center center rgba(45, 45, 45, 0.5);"></div>
                 <h4 class="title"><?php echo e(__('Refund For Products')); ?></h4>
                <div class="row">
				
            <div class="col-lg-12 order-details-table">
			<form id="refundform" action="<?php echo e(route('admin-refundmanualamt-store')); ?>" method="POST" enctype="multipart/form-data">
			<?php echo e(csrf_field()); ?>

			 <?php echo $__env->make('includes.admin.form-both', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                <div class="mr-table">
                   
                    <div class="table-responsiv">
					
                        <table id="example2" class="table table-hover dt-responsive" cellspacing="0" width="100%">
                            <thead>
								<tr>
								    <th ><?php echo e(__('Image')); ?></th>
								    <th ><?php echo e(__('Details')); ?></th>
									<th ><?php echo e(__('Cost')); ?></th>
									<th ><?php echo e(__('Qty')); ?></th>
									<th><?php echo e(__('Total')); ?></th>
									<th><?php echo e(__('Reason')); ?></th>
								</tr>
							</thead>

                            <tbody>
							<?php
                            $count = count($cart->items);
							$i=1;
                            ?>
							<input type="hidden" id="pr_count" class="pr_count" name="pr_count" value="<?php echo e($count); ?>">
                             <?php $sum_price = array(); ?>
                            <?php $__currentLoopData = $cart->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						
										<?php
                                        $vendorName = App\Models\User::find($product['item']['user_id']);
                                        ?>
									
                                        <?php
                                        $ProductDetails = App\Models\Product::find($product['item']['id']);
                                        ?>
										
										<?php
										$orderid=$order->id;
                                        $vdetails = App\Models\VendorOrder::all()->where('order_id',$orderid)->where('product_id',$product['item']['id']);										
                                        ?>										
                                         <?php  
                                              if($vdetails) {
                                              foreach($vdetails as $item){
                                                 
                                                if($item->product_item_price) {
                                                       $sum_price[$product['item']['id']]= $item->product_item_price;
                                                 }
                                              }
                                           }
                                          
                                         ?>																		

                                <tr>    
                                     <input type="hidden" id="rproduct_id" name="rproduct_id<?php echo e($i); ?>" value="<?php echo e($product['item']['id']); ?>">                                
                                    <td><img src="<?php echo e($product['item']['photo'] ? filter_var($product['item']['photo'], FILTER_VALIDATE_URL) ?$product['item']['photo']:asset('assets/images/products/'.$product['item']['photo']):asset('assets/images/noimage.png')); ?>" alt="<?php echo e($product['item']['photo']); ?>"> </td>
                                    
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
                                        
                                        <br />
                                        
                                        <strong>SKU : </strong> <?php echo e($ProductDetails->sku); ?>

                                        
                                        <br /> 
                                        
                                         <?php if($product['size']): ?>
                                       <p>
                                            <strong><?php echo e(__('Option')); ?> :</strong> <?php echo e(str_replace('-',' ',$product['size'])); ?>

                                       </p>
                                       <?php endif; ?>
                                       <?php if($product['color']): ?>
                                        <p>
                                                <strong><?php echo e(__('color')); ?> :</strong> <span
                                                style="width: 40px; height: 20px; display: block; background: #<?php echo e($product['color']); ?>;"></span>
                                        </p>
                                        <?php endif; ?>
                                       
                                            <?php if(!empty($product['keys'])): ?>
                                            <?php $__currentLoopData = array_combine(explode(',', $product['keys']), explode(',', $product['values'])); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <p><b><?php echo e(ucwords(str_replace('_', ' ', $key))); ?> : </b> <?php echo e($value); ?> 
                                            <?php 
											$pr_at = $product['item']['attributes'];
	                                        $pr_arr = json_decode($pr_at, true);
											?>
											<b> prices : </b><?php echo e($pr_arr [$key]['prices'][0]); ?></p>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php endif; ?>
                                            
                                            
                                            <br />
                                            
                                            <strong>Sold By : </strong> <?php echo e($vendorName->shop_name); ?>

                                        
                                        
                                        
                                    </td>
                                    
                                  
                                    <td>
                                      <p>
                                                 <?php echo e($order->currency_sign); ?><?php echo e(round($product['item']['price'] * $order->currency_value , 2)); ?>

                                        </p>
                                    </td>
                                    
                                    <td class="qty_td">
                                      
                                       <p>
                                            <?php echo e(__('x')); ?>  <?php echo e($product['qty']); ?> <?php echo e($product['item']['measure']); ?> <br /> <input class="form-control" type="number" id="ref_quantity" priceprod="<?php echo e(round($product['item']['price'] * $order->currency_value , 2)); ?>" name="ref_quantity<?php echo e($i); ?>" min="1" max="<?php echo e($product['qty']); ?>" 

                                            <?php if($vdetails): ?>
                                            <?php $__currentLoopData = $vdetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php if($item->product_item_qty): ?>
											<?php echo e(__('disabled')); ?>

                                            <?php endif; ?>
											<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php endif; ?>
                                             > <br />
											<?php if($vdetails): ?>
                                            <?php $__currentLoopData = $vdetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php if($item->product_item_qty): ?>
											<?php echo e(__('Refund Qty')); ?>: <?php echo e($item->product_item_qty); ?>

                                            <?php endif; ?>
											<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php endif; ?>
											<input type="hidden" class="or_qty" name="or_qty<?php echo e($i); ?>" value="<?php echo e($product['qty']); ?>">
                                       </p>
                                    </td>
                                    
                                     <td class="price_td">
                                      
                                       <p>
                                            <?php echo e($order->currency_sign); ?><?php echo e(round($product['price'] * $order->currency_value , 2)); ?> <br /> 
                                            <input type="text" class="form-control ref_price" id="ref_price" name="ref_price<?php echo e($i); ?>"
                                             <?php if($vdetails): ?>                                               
                                            <?php $__currentLoopData = $vdetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                             <?php if($item->product_item_qty): ?>
                                            <?php echo e(__('disabled')); ?>

                                            <?php endif; ?>
											<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>	
                                            <?php endif; ?>	
                                              >	
                                            <?php if($vdetails): ?>                                               
                                            <?php $__currentLoopData = $vdetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                             <?php if($item->product_item_qty): ?>
                                            <?php echo e(__('Refund Price')); ?>: <?php echo e($item->product_item_price); ?>

                                            <?php endif; ?>
											<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>	
                                            <?php endif; ?>										
											<input type="hidden" class="or_price" name="or_price<?php echo e($i); ?>" value="<?php echo e(round($product['price'] * $order->currency_value , 2)); ?>">	
											
                                       </p>
                                    </td>
									<td>
									<?php 
										$orderid=$order->id;
										$cls_val='';
                                        $reasondetails = App\Models\VendorOrder::all()->where('order_id',$orderid)->where('product_id',$product['item']['id']);										
                                        if($reasondetails) {                                              
                                            foreach($reasondetails as $item){
                                             if($item->reason){
                                                $cls_val=$item->reason;
										}
										}
										}
											
									?>
                                            									
									<input type="text" class="form-control refund-reason" id="ref_reason" name="ref_reason<?php echo e($i); ?>" <?php if($cls_val) { echo 'disabled'; }?>
                                     value="<?php if($cls_val) { echo $cls_val; }?>">
									</td>
                                    
							

                                </tr>
								<?php $i++;
								?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
						
                    </div>
                    
                 
                </div>
                                    
                   <div class="text-right mt-30">
                       <strong>Total Refund Amount : </strong> <span id="prval" ></span>
					   <?php if($sum_price) { ?><strong>Total Refunded Amount : </strong> <span id="ramt" ><?php echo array_sum($sum_price); ?></span><?php } ?>
                   </div>				         
                         <input type="hidden" id="total_price" name="total_price" value="">	
						 
                         <input type="hidden" id="order_id" name="order_id" value="<?php echo e($order->id); ?>">							 
						<button class="addProductSubmit-btn pull-right" id="track-btn" type="submit" >Refund Manually</button>
            </form>
			</div>
			
            
        </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
$("#checkAll").click(function () {$('input:checkbox').not(this).prop('checked', this.checked);}); 
$(document).ready(function() {    
     
	 calculateSum();
		$('.addProductSubmit-btn').prop('disabled', true);	
    $(".ref_price").on("keydown keyup", function() {
        calculateSum();
    });
    
     $(document).on('change','#ref_quantity',function () {
        calculateSum();
    });
	
});

function calculateSum() {
    var sum = 0;    
    $(".ref_price").each(function() {
        
        if (!isNaN(this.value) && this.value.length != 0) {
            sum += parseFloat(this.value);            
        }
        else if (this.value.length != 0){
           
        }
    });
         $("#total_price").empty().val(sum);	
         $("#prval").empty().append(sum);
		 $('.addProductSubmit-btn').prop('disabled', false);          
}
		
	</script>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.load', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>