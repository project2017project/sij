<?php $__currentLoopData = $order; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $orders): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<div class="row">
<div class="col-lg-12"><div class="left-area"><h4 class="heading"><?php echo e(__('Email Address')); ?>* </h4></div></div>
<div class="col-lg-12"><input type="text" class="input-field rdamt" placeholder="<?php echo e(__('Email Address')); ?>" name="email_address"  value="<?php echo e($orders->customer_email); ?>"required=""></div>
</div>
<div class="row">
<div class="col-lg-12"><div class="left-area"><h4 class="heading"><?php echo e(__('Amount')); ?>* </h4></div></div>
<div class="col-lg-12"><input type="text" class="input-field rdamt" placeholder="<?php echo e(__('Amount')); ?>" name="price"  value="<?php echo e($orders->pay_amount); ?>"required=""></div>
</div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>