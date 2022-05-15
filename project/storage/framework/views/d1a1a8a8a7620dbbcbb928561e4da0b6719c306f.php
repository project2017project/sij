<?php $__env->startSection('content'); ?>

                       
                      <form id="rejectdata" action="<?php echo e(route('admin-vendor-withdraw-reject',$data->id)); ?>" method="POST" enctype="multipart/form-data">
                        <?php echo e(csrf_field()); ?>

						<?php echo $__env->make('includes.admin.form-success', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?> 
                        <?php echo $__env->make('includes.admin.form-error', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

      
            <p class="text-center"><?php echo e(__("You are about to reject this Withdraw.")); ?></p>
            <p class="text-center"><?php echo e(__("Do you want to proceed.Please enter your reason?")); ?></p>
			<input type="text" class="form-control" Placeholder="Please enter your reason"  name="comment" required>		    

      <!-- Modal footer -->
      <div class="modal-footer justify-content-center">	  
       <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo e(__("Cancel")); ?></button>
	   <button class="btn btn-danger btn-ok" type="submit"><?php echo e(__('Reject')); ?></button>
            
      </div>
	  </form>                 
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.load', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>