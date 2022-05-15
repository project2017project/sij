<?php $__env->startSection('content'); ?>
<div class="content-area">
	<div class="mr-breadcrumb">
		<div class="row">
			<div class="col-lg-12">
				<h4 class="heading"><?php echo e(__('Coupon')); ?> 				
				<ul class="links">
					<li><a href="<?php echo e(route('admin.dashboard')); ?>"><?php echo e(__('Dashboard')); ?> </a></li>					
					<li><a href="javascript:;"><?php echo e(__('Create Coupon Request')); ?></a></li>					
				</ul>
			</div>
		</div>
	</div>

	<form id="createcouponform" action="<?php echo e(route('admin-coupon-submit')); ?>" method="POST" enctype="multipart/form-data">
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
										<div class="col-lg-12"><div class="left-area"><h4 class="heading"><?php echo e(__('Order Id')); ?> </h4></div></div>
										<div class="col-lg-12">
										<select id="orderid" name="order_id">
                                          <option value=""><?php echo e(__('Select Order Id')); ?></option>
										  <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $orderdt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option data-href="<?php echo e(route('order-data-cload',$orderdt->id)); ?>" value="<?php echo e($orderdt->id); ?>"><?php echo e($orderdt->id); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
										</div>
									</div>
									<div class="orderdata"></div>
									<div class="row">
										<div class="col-lg-12"><div class="left-area"><h4 class="heading"><?php echo e(__('Code')); ?>* </h4></div></div>
										<div class="col-lg-12"><input type="text" class="input-field rdamt" placeholder="<?php echo e(__('Code')); ?>" name="code" required=""></div>
									</div>
																	
		                            		
									<div class="row">
										<div class="col-lg-12 text-center">										
											<button class="createcoupon-btn"
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
 $(document).on('change','#orderid',function () {
            var orderlink = $(this).find(':selected').attr('data-href');
           if(orderlink){
				$('.orderdata').show();
                $('.orderdata').load(orderlink);                
            }else{
				$('.orderdata').hide();
			}		
            
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>