<form  method="POST" action="<?php echo e(route('admin-reject-update',$data->id)); ?>" enctype="multipart/form-data" id="couponrejectform">
<?php echo e(csrf_field()); ?>

<?php echo $__env->make('includes.admin.form-both', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<input type = "hidden" name="couponid" value="<?php echo e($data->id); ?>">
<button class="couponrejectform-btn" type="submit"><?php echo e(__('OK')); ?></button>
</form>
											
												