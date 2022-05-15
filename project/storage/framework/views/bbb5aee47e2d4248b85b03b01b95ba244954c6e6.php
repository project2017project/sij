		<a class="clear"><?php echo e(__('New Order(s).')); ?> 
			<?php if(count($datas) > 0): ?>
			<span id="order-notf-clear" class="clear-notf" data-href="<?php echo e(route('order-notf-clear')); ?>">
				<?php echo e(__('Clear All')); ?>

			</span>
			<?php endif; ?>
		</a>
		<?php if(count($datas) > 0): ?>

		<ul>
		<?php $__currentLoopData = $datas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			<li>
				<a href="<?php echo e(route('admin-order-show',$data->order_id)); ?>">
					 <i class="fas fa-2x fa-newspaper"></i> <?php echo e(__('You Have a new order.')); ?>

					<small class="d-block notf-time "><?php echo e($data->created_at->diffForHumans()); ?></small>
				</a>
			</li>
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

		</ul>

		<?php else: ?> 

		<a class="clear" href="javascript:;">
			<?php echo e(__('No New Notifications.')); ?>

		</a>

		<?php endif; ?>