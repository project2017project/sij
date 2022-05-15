<?php $__env->startSection('content'); ?>
<div class="content-area">
	<div class="mr-breadcrumb">
		<div class="row">
			<div class="col-lg-12">
				<h4 class="heading"><?php echo e(__('Vendor Registration')); ?> 				
				<ul class="links">
					<li><a href="<?php echo e(route('admin.dashboard')); ?>"><?php echo e(__('Dashboard')); ?> </a></li>
					<li><a href="<?php echo e(route('admin-vendor-index')); ?>"><?php echo e(__('Vendor List')); ?></a></li>
					<li><a href="javascript:;"><?php echo e(__('Add Vendor')); ?></a></li>					
				</ul>
			</div>
		</div>
	</div>

	<form id="vendorform" action="<?php echo e(route('admin-vendor-submit')); ?>" method="POST" enctype="multipart/form-data">
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
										<div class="col-lg-12"><div class="left-area"><h4 class="heading"><?php echo e(__('Full Name')); ?> </h4></div></div>
										<div class="col-lg-12"><input type="text" class="input-field" placeholder="<?php echo e(__('Full Name')); ?>" name="name"></div>
									</div>	
                                   
                                    <div class="row">
										<div class="col-lg-12"><div class="left-area"><h4 class="heading"><?php echo e(__('Email Address')); ?>* </h4></div></div>
										<div class="col-lg-12"><input type="email" class="input-field" placeholder="<?php echo e(__('Email Address')); ?>" name="email" required=""></div>
									</div>

                                    <div class="row">
										<div class="col-lg-12"><div class="left-area"><h4 class="heading"><?php echo e(__('Country')); ?> </h4></div></div>
										<div class="col-lg-12">										
										<select class="form-control" name="country" id="usercountry">
						                    <?php echo $__env->make('includes.countries', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
					                    </select>
										
										</div>
									</div>
									
                                     <div class="row">
										<div class="col-lg-12"><div class="left-area"><h4 class="heading"><?php echo e(__('State')); ?> </h4></div></div>
										<div class="col-lg-12">
										<select id="userstate" name="state"  disabled="">
                                          <option value=""><?php echo e(__('Select State')); ?></option>
                                        </select>
										</div>
									</div>
                                 
                                    <div class="row">
										<div class="col-lg-12"><div class="left-area"><h4 class="heading"><?php echo e(__('Address')); ?> </h4></div></div>
										<div class="col-lg-12"><input type="text" class="input-field" placeholder="<?php echo e(__('Address')); ?>" name="address"></div>
									</div>		

                                     <div class="row">
										<div class="col-lg-12"><div class="left-area"><h4 class="heading"><?php echo e(__('Shop Name')); ?>* </h4></div></div>
										<div class="col-lg-12"><input type="text" class="input-field" placeholder="<?php echo e(__('Shop Name')); ?>" name="shop_name" required=""></div>
									</div>		

                                         
                                    <div class="row">
										<div class="col-lg-12"><div class="left-area"><h4 class="heading"><?php echo e(__('Owner Name')); ?> </h4></div></div>
										<div class="col-lg-12"><input type="text" class="input-field" placeholder="<?php echo e(__('Owner Name')); ?>" name="owner_name"></div>
									</div>		


                                    <div class="row">
										<div class="col-lg-12"><div class="left-area"><h4 class="heading"><?php echo e(__('Shop Number')); ?> </h4></div></div>
										<div class="col-lg-12"><input type="text" class="input-field" placeholder="<?php echo e(__('Shop Number')); ?>" name="shop_number"></div>
									</div>		


                                    <div class="row">
										<div class="col-lg-12"><div class="left-area"><h4 class="heading"><?php echo e(__('Shop Address')); ?> </h4></div></div>
										<div class="col-lg-12"><input type="text" class="input-field" placeholder="<?php echo e(__('Shop Address')); ?>" name="shop_address"></div>
									</div>		


                                    <div class="row">
										<div class="col-lg-12"><div class="left-area"><h4 class="heading"><?php echo e(__('Registration Number')); ?> </h4></div></div>
										<div class="col-lg-12"><input type="text" class="input-field" placeholder="<?php echo e(__('Registration Number')); ?>" name="reg_number"></div>
									</div>	

                                    <div class="row">
										<div class="col-lg-12"><div class="left-area"><h4 class="heading"><?php echo e(__('Message')); ?> </h4></div></div>
										<div class="col-lg-12"><input type="text" class="input-field" placeholder="<?php echo e(__('Message')); ?>" name="shop_message"></div>
									</div>


                                     <div class="row">
										<div class="col-lg-12"><div class="left-area"><h4 class="heading"><?php echo e(__('Password')); ?>* </h4></div></div>
										<div class="col-lg-12"><input type="password" class="input-field" placeholder="<?php echo e(__('Password')); ?>" name="password" required=""></div>
									</div>


                                   <div class="row">
										<div class="col-lg-12"><div class="left-area"><h4 class="heading"><?php echo e(__('Confirm Password')); ?>* </h4></div></div>
										<div class="col-lg-12"><input type="password" class="input-field" placeholder="<?php echo e(__('Confirm Password')); ?>" name="password_confirmation" required=""></div>
									</div>									
									                           
		                            		
									<div class="row">
										<div class="col-lg-12 text-center">
										<input type="hidden" name="vendor" value="1">
										<input class="mprocessdata" type="hidden" value="<?php echo e($langg->lang188); ?>">
											<button class="addVendorRegister-btn"
												type="submit"><?php echo e(__('Register')); ?></button>
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
 $(document).on('change','#usercountry',function () {
            var link = $(this).find(':selected').attr('data-href');
           console.log(link);
            if(link != ""){
                $('#userstate').load(link);
                $('#userstate').prop('disabled',false);
            }
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>