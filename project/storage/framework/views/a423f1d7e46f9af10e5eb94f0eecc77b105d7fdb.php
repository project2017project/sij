<?php $__env->startSection('content'); ?>


<section class="user-dashbord">
    <div class="container">
      <div class="row">
        <?php echo $__env->make('includes.user-dashboard-sidebar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <div class="col-lg-8">
					<div class="user-profile-details">
						<div class="order-history">
							<div class="header-area">
								<h4 class="title">
									<?php echo e($langg->lang277); ?>

								</h4>
							</div>
							<div class="mr-table allproduct mt-4">
									<div class="table-responsiv">
											<table id="example" class="table table-hover dt-responsive" cellspacing="0" width="100%">
												<thead>
													<tr>
									<th><?php echo e(__('Exchange Id')); ?></th>									
                                    <th><?php echo e(__('Vendor Name')); ?></th>
									<th><?php echo e(__('Order Id')); ?></th>
                                    <th><?php echo e(__('Product Name')); ?></th>
                                    <th><?php echo e(__('Product SKU')); ?></th>
									<th><?php echo e(__('Status')); ?></th>
									<th><?php echo e(__('Exchange Date')); ?></th>
									<th><?php echo e(__('Options')); ?></th>
								</tr>
												</thead>
												<tbody>
													 <?php $__currentLoopData = $exchange; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $exchanges): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
													<?php
									  $users =  App\Models\User::where('id','=',$exchanges->vendor_id)->orderBy('id','desc')->first();							      
								?>
								<?php
									  $vendor_data =  App\Models\VendorOrder::where('order_id','=',$exchanges->order_id)->where('other_status','!=','')->orderBy('id','desc')->first();							      
								?>
								<?php if($vendor_data): ?>
													<tr>
													<td><?php echo e($exchanges->id); ?></td>
													<td><?php echo e($users->name); ?></td>
													<td><?php echo e($exchanges->order_id); ?></td>
													<td><?php echo e($exchanges->product_name); ?></td>
													<td><?php echo e($exchanges->product_sku); ?></td>
													<td><?php echo e(ucwords($exchanges->status)); ?></td>
													<td><?php echo e($exchanges->created_at); ?></td>
															<td>
															<a class="mybtn2 sm" href="<?php echo e(route('user-exchanges',$exchanges->id)); ?>">
																	<?php echo e(__('Details')); ?>

															</a>
														</td>
													</tr>
													<?php endif; ?>
													<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
												</tbody>
											</table>
									</div>
								</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.front', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>