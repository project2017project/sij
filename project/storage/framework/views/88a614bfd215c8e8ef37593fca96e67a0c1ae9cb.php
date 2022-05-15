 
<?php $__env->startSection('content'); ?>
	<div class="content-area">
		<div class="mr-breadcrumb">
			<div class="row">
				<div class="col-lg-12">
					<h4 class="heading"><?php echo e($langg->lang472); ?></h4>
					<ul class="links">
						<li><a href="<?php echo e(route('vendor-dashboard')); ?>"><?php echo e($langg->lang441); ?> </a></li>
						<li><a href="<?php echo e(route('vendor-wt-index')); ?>"><?php echo e($langg->lang472); ?></a></li>
					</ul>
				</div>
			</div>
		</div>
		<div class="product-area">
			<div class="row">
				<div class="col-lg-12">
					<div class="mr-table allproduct">
						 
						<div class="table-responsiv">
							<table id="geniustable" class="table table-hover dt-responsive" cellspacing="0" width="100%">
								<thead>
									<tr>
										<th><?php echo e(__("Vendor Name")); ?></th>
										<th><?php echo e(__("Order Id")); ?></th>
										<th><?php echo e(__("Price")); ?></th>
									</tr>
								</thead>
								<tbody>
		                            <?php $__currentLoopData = $withdraws; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $withdraw): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		                                <tr>
		                                    <td><?php echo e($withdraw->user->name); ?></td>
											<?php
                                                $vdata = App\Models\VendorOrder::find($withdraw->order_id);
                                                ?>
		                                    <td><a href="<?php echo e(route('vendor-order-vshow',$vdata->order_number)); ?>"><?php echo e($withdraw->order_id); ?></a></td>
		                                   
		                                    <td><?php echo e(ucfirst($withdraw->price)); ?></td>
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
<?php $__env->stopSection(); ?>    
<?php $__env->startSection('scripts'); ?>




    <script type="text/javascript">

		var table = $('#geniustable').DataTable({
			ordering:false
		});

  									
    </script>


    
<?php $__env->stopSection(); ?>   
<?php echo $__env->make('layouts.vendor', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>