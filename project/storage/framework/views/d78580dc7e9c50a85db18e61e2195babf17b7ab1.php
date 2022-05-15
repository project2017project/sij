		<a class="clear"><?php echo e(__('New Conversation(s).')); ?>

			<?php if(count($datas) > 0): ?>
			<span id="conv-notf-clear" class="clear-notf" data-href="<?php echo e(route('conv-notf-clear')); ?>">
				<?php echo e(__('Clear All')); ?>

			</span>
			<?php endif; ?>
		</a>
		<?php if(count($datas) > 0): ?>

		<ul>
		<?php $__currentLoopData = $datas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			<li>
				<a href="<?php echo e(route('admin-message-show',$data->conversation_id)); ?>">
					 <i class="fas fa-envelope"></i> <?php echo e(__('You Have a New Message.')); ?>

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