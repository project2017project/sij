<?php //print_r($cat);die;?>
<option data-href="" value="">Select State</option>
<?php $__currentLoopData = $cat; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sub): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<option  value="<?php echo e($sub->name); ?>"><?php echo e($sub->name); ?></option>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>