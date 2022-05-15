		<a class="clear"><?php echo e(__('Low Quantity Product(s).')); ?>

			<?php if(count($datas) > 0): ?>
			<span id="product-notf-clear" class="clear-notf" data-href="<?php echo e(route('product-notf-clear')); ?>">
				<?php echo e(__('Clear All')); ?>

			</span>
			<?php endif; ?>
		</a>
		<?php if(count($datas) > 0): ?>
		<ul>
		<?php $__currentLoopData = $datas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			<li>
				<a href="<?php echo e(route('admin-prod-edit',$data->product->id)); ?>"> <i class="icofont-cart"></i> <?php echo e(mb_strlen($data->product->name,'utf-8') > 30 ? mb_substr($data->product->name,0,30,'utf-8') : $data->product->name); ?>

					<small class="d-block notf-stock"><?php echo e(__('Stock')); ?> : <?php echo e($data->product->stock); ?></small>
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