<option data-href="" value="">Select Order Id</option>
<?php $__currentLoopData = $order; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $orders): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<option  value="<?php echo e($orders->id); ?>"><?php echo e($orders->id); ?></option>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>