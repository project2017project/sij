<option value=""><?php echo e($langg->lang157); ?></option>
<?php if(Auth::check()): ?>
	<?php $__currentLoopData = DB::table('countries')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
	<option data-href="<?php echo e(route('front-state-load',$data->id)); ?>" value="<?php echo e($data->name); ?>" <?php echo e(Auth::user()->country == $data->name ? 'selected' : ''); ?>><?php echo e($data->name); ?></option>		
	<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php else: ?>
	<?php $__currentLoopData = DB::table('countries')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
	<option data-href="<?php echo e(route('front-state-load',$data->id)); ?>" value="<?php echo e($data->name); ?>"><?php echo e($data->name); ?></option>		
	<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>