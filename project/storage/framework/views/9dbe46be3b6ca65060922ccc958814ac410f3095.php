<?php $__env->startSection('styles'); ?>

<link href="<?php echo e(asset('assets/admin/css/jquery-ui.css')); ?>" rel="stylesheet" type="text/css">

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="content-area">
	
	<div class="add-product-content">
		<div class="row">
			<div class="col-lg-12">
				<div class="product-description">
					<div class="body-area">
					<?php echo $__env->make('includes.admin.form-error', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?> 
					<form id="geniusformdata" action="<?php echo e(route('admin-prod-quickedit',$data->id)); ?>" method="POST" enctype="multipart/form-data">
						<?php echo e(csrf_field()); ?>


						<div class="row">
							<div class="col-lg-8">
								<div class="left-area">
										<h4 class="heading">Product Name</h4>
								</div>
							</div>
			                  <div class="col-sm-3">
			                  	<input class="form-control" type="text" name="name" value="<?php echo e($data->name); ?>" ></div>
						</div>

						


						<div class="row">
							<div class="col-lg-8">
								<div class="left-area">
										<h4 class="heading">SKU *</h4>
								</div>
							</div>
			                  <div class="col-sm-3">			                    
			                      <input class="form-control" type="text" name="sku" value="<?php echo e($data->sku); ?>" >                
			                  </div>
						</div>

						<div class="row">
							<div class="col-lg-8">
								<div class="left-area">
										<h4 class="heading">Price*</h4>
								</div>
							</div>
			                  <div class="col-sm-3">
			                      <input type="number" class="input-field" name="price" value="<?php echo e($data->price); ?>"  >
			                  </div>
						</div>						

						<div class="row">
							<div class="col-lg-6">
								<div class="left-area">
										<h4 class="heading"><?php echo e(__("Regular Price")); ?> *</h4>
								</div>
							</div>
			                  <div class="col-sm-6">
			                      <input type="number" class="input-field" name="previous_price"  placeholder="<?php echo e(__('Enter Regular Price')); ?>" value="<?php echo e($data->previous_price); ?>">

			                  </div>
						</div>
						<div class="row">
							<div class="col-lg-6">
								<div class="left-area">
										<h4 class="heading"><?php echo e(__("Stock")); ?> *</h4>
								</div>
							</div>
			                  <div class="col-sm-6">
			                      <input type="number" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" min="0" class="input-field" name="stock"  placeholder="<?php echo e(__('Enter Quantity')); ?>" value="<?php echo e($data->stock); ?>">

			                  </div>
						</div>
						
						<div class="row">
							<div class="col-lg-5">
								<div class="left-area">
									
								</div>
							</div>
							<div class="col-lg-7">
								<button class="addProductSubmit-btn" type="submit"><?php echo e(__("Submit")); ?></button>
							</div>
						</div>


					</form>


					</div>
				</div>
			</div>
		</div>
	</div>
	
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>


<script>
    $(document).ready(function(){
  $("input[type='number']").keypress(function(e){
     var keyCode = e.which;
    /*
      8 - (backspace)
      32 - (space)
      48-57 - (0-9)Numbers
    */
 
    if ( (keyCode != 8 || keyCode ==32 ) && (keyCode < 48 || keyCode > 57)) { 
      return false;
    }
  });
});
</script>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.load', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>