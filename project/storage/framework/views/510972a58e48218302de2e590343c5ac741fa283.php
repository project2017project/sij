<?php $__currentLoopData = $product; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $products): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<div class="row">
										<div class="col-lg-12"><div class="left-area"><h4 class="heading"><?php echo e(__('Product Name')); ?> </h4></div></div>
										<div class="col-lg-12"><input type="text" class="input-field" placeholder="<?php echo e(__('Product Name')); ?>" name="product_name" value="<?php echo e($products->name); ?>" required="" readonly></div>
									</div>	
                                   
                                    <div class="row">
										<div class="col-lg-12"><div class="left-area"><h4 class="heading"><?php echo e(__('Product SKU')); ?>* </h4></div></div>
										<div class="col-lg-12"><input type="text" class="input-field" placeholder="<?php echo e(__('Product SKU')); ?>" name="product_sku" value="<?php echo e($products->sku); ?>" required="" readonly></div>
									</div>
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>