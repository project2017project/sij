 
<?php $__env->startSection('styles'); ?>
<style type="text/css">.input-field { padding: 15px 20px; }</style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>  
<input type="hidden" id="headerdata" value="<?php echo e(__('ORDER')); ?>">
<div class="content-area">
	<div class="mr-breadcrumb">
		<div class="row">
			<div class="col-lg-12">
				<h4 class="heading"><?php echo e(__('All Orders')); ?></h4>
				<ul class="links">
					<li><a href="<?php echo e(route('vendor-dashboard')); ?>"><?php echo e(__('Dashboard')); ?> </a></li>
					<li><a href="javascript:;"><?php echo e(__('Orders')); ?></a></li>
					<li><a href="<?php echo e(route('vendor-order-index')); ?>"><?php echo e(__('All Orders')); ?></a></li>
				</ul>
			</div>
		</div>
	</div>
	<div class="product-area">
		<div class="row">
			<div class="col-lg-12">
				<div class="mr-table allproduct">					
					<div class="table-responsiv">
						
							
						<table id="myTable" class="table table-hover dt-responsive" cellspacing="0" width="100%">
							<thead>
								<tr>
									<th><?php echo e(__('Order Number')); ?></th>
									<th><?php echo e(__('Customer Name')); ?></th>  
									<th><?php echo e(__('Billing Address')); ?></th>
									<th><?php echo e(__('Shipping Address')); ?></th>
									<th><?php echo e(__('Purchased')); ?></th>
									<th><?php echo e(__('Gross Sale')); ?></th>																		
                                    <th><?php echo e(__('Order Date')); ?></th>									
									<th><?php echo e(__('Status')); ?></th>
									<th><?php echo e(__('Options')); ?></th>
								</tr>
								</thead>
								<tbody>
								    
									<?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $orderr): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
								<?php 
								$qty = $orderr->sum('qty');
								$price = $orderr->sum('price');
								  
								?>
								<?php $__currentLoopData = $orderr; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

							
										  
                                      
                                      <?php
									  
                                        $order_data = App\Models\Order::find($order->order_id);
										
                                      ?>
								
									  
									
										<tr>
							
											<td> <a href="<?php echo e(route('vendor-order-invoice',$order->order_number)); ?>">#<?php echo e($order->order->order_number); ?></a></td>
											<td><?php echo e($order_data->customer_name); ?></td>
											<td><?php echo e($order_data->customer_name); ?>, <?php echo e($order_data->customer_address); ?>, <?php echo e($order_data->customer_city); ?>, <?php echo e($order_data->customer_state); ?>, <?php echo e($order_data->customer_country); ?>, <?php echo e($order_data->customer_zip); ?></td>
											<td><?php echo e($order_data->shipping_name == null ? $order_data->customer_name : $order_data->shipping_name); ?>, <?php echo e($order_data->shipping_address == null ? $order_data->customer_address : $order_data->shipping_address); ?>, <?php echo e($order_data->shipping_city == null ? $order_data->customer_city : $order_data->shipping_city); ?>, <?php echo e($order_data->shipping_state == null ? $order_data->customer_state : $order_data->shipping_state); ?>, <?php echo e($order_data->shipping_country == null ? $order_data->customer_country : $order_data->shipping_country); ?>, <?php echo e($order_data->shipping_zip == null ? $order_data->customer_zip : $order_data->shipping_zip); ?></td>
											
											
											
											<td>
											    
											  
											  
											  <?php $__currentLoopData = $orderr; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $productsve): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
											  
											   <?php
									  
                                        $product_data = App\Models\Product::find($productsve->product_id);
										
                                      ?>
                                      
                                      
                                     
                                       <span class="text-success"><b><?php echo e($order->qty. 'Item'); ?></b></span> <br /><?php echo e($product_data->name); ?>(<?php echo e($product_data->sku); ?>)<br /><br />
                                        
                                        
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
											</td>
											
											
											
											<td><?php echo e($order->order->inr_currency_sign); ?><?php echo e(round($price , 2)); ?></td>
											<td><?php echo e($order_data->created_at); ?></td>
											<td><?php echo e($order->status); ?></td>
											
											<?php
											
											$action = '';
											
											?>
											
											
											<td><div class="godropdown"><button class="go-dropdown-toggle"> Actions<i class="fas fa-chevron-down"></i></button>
                                <div class="action-list">
                                     
                                     <a href="<?php echo e(route('vendor-order-vshow',$order->order_number)); ?>" class="btn btn-primary product-btn"><i class="fa fa-eye"></i> <?php echo e($langg->lang539); ?></a> 
                                     
                                    <a href="<?php echo e(route('vendor-generate-invoice',$order->order_number)); ?>"><i class="fa fa-eye"></i> Invoice</a>
                                    <a href="<?php echo e(route('vendor-packingslip-invoice',$order->order_number)); ?>"><i class="fa fa-eye"></i> Packing Slip</a>
                                    <a href="<?php echo e(route('vendor-tax-invoice',$order->order_number)); ?>"><i class="fa fa-eye"></i> Tax Invoice</a>
                                   
                                    
                                </div>
                                </div></td>
											
										
											
											
											</td>
										 </tr>
								<?php break; ?>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>    
								 
								</tbody>							
							
						</table>
	
				</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php $__env->stopSection(); ?>    

<?php $__env->startSection('scripts'); ?>



<script type="text/javascript">
		  $(document).ready( function () {
    $('#myTable').DataTable({
        "aaSorting": [],
        "ordering": false
    });
} );
</script>

<?php $__env->stopSection(); ?>   
<?php echo $__env->make('layouts.vendor', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>