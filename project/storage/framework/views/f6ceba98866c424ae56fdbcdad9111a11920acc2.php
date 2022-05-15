<form  method="POST" action="<?php echo e(route('admin-exchange-update',$data->id)); ?>" enctype="multipart/form-data" id="exchangedform">
<?php echo e(csrf_field()); ?>

<?php echo $__env->make('includes.admin.form-both', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<input type = "hidden" name="echangeid" value="<?php echo e($data->id); ?>">
<p class="text-center">Are you Sure You want to Create Accept Request?</p>
				<button class="exchangedform-btn btn btn-success" style="margin-top : 0; width:auto; height:auto; font-size : 1rem; 
    background-color: #28a745; border: 1px solid transparent; border-color: #28a745;" type="submit"><?php echo e(__('Confirm')); ?></button>
                <button type="button" class="btn btn-danger" data-dismiss="modal"><?php echo e(__('Cancel')); ?></button>

</form>
											
												