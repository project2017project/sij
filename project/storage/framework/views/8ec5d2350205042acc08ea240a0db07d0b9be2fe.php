<?php $__env->startSection('content'); ?>
<div class="content-area">
	<div class="mr-breadcrumb">
		<div class="row">
			<div class="col-lg-12">
				<h4 class="heading"><?php echo e(__('Rto')); ?> 				
				<ul class="links">
					<li><a href="<?php echo e(route('admin.dashboard')); ?>"><?php echo e(__('Dashboard')); ?> </a></li>					
					<li><a href="javascript:;"><?php echo e(__('Add Rto')); ?></a></li>					
				</ul>
			</div>
		</div>
	</div>

	<form id="rrtodforms" action="<?php echo e(route('admin-rtood-submit')); ?>" method="POST" enctype="multipart/form-data">
		<?php echo e(csrf_field()); ?>

       <?php echo $__env->make('includes.admin.form-both', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>	
	<div class="row">
		<div class="col-lg-12">
			<div class="add-product-content">
				<div class="row">
					<div class="col-lg-12">
						<div class="product-description">
							<div class="body-area">						
		
									

                                    <div class="row">
										<div class="col-lg-12"><div class="left-area"><h4 class="heading"><?php echo e(__('Vendor Name')); ?> </h4></div></div>
										<div class="col-lg-12">										
										<select class="form-control" name="vendor_id" id="vendorid">
						                    <option value=''>--Select Vendor Name-- </option>
                                    <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $userid): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option data-href="<?php echo e(route('orders-data-loads',$userid->id)); ?>" value="<?php echo e($userid->id); ?>"><?php echo e($userid->shop_name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					                    </select>
										
										</div>
									</div>
									
                                     <div class="row">
										<div class="col-lg-12"><div class="left-area"><h4 class="heading"><?php echo e(__('Order Id')); ?> </h4></div></div>
										<div class="col-lg-12">
										<select id="orderid" name="order_id"  disabled="">
                                          <option value=""><?php echo e(__('Select Order Id')); ?></option>
                                        </select>
										</div>
									</div>
									
																	
		                            		
									<div class="row">
										<div class="col-lg-12 text-center">										
											<button class="addrtos-btn"
												type="submit"><?php echo e(__('Create Request')); ?></button>
										</div>
									</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>					
					
	</div>
	</form>
	
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>

<script src="<?php echo e(asset('assets/admin/js/jquery.Jcrop.js')); ?>"></script>
<script src="<?php echo e(asset('assets/admin/js/jquery.SimpleCropper.js')); ?>"></script>
<script>
 $(document).on('change','#vendorid',function () {
            var orderlink = $(this).find(':selected').attr('data-href');           
            if(orderlink != ""){
                $('#orderid').load(orderlink);
                $('#orderid').prop('disabled',false);
            }
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>