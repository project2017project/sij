<?php $__env->startSection('content'); ?>

<!-- Breadcrumb Area Start -->
	<!-- <div class="breadcrumb-area">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<ul class="pages">
						<li>
							<a href="<?php echo e(route('front.index')); ?>">
								<?php echo e($langg->lang17); ?>

							</a>
						</li>
						<li>
							<a href="<?php echo e(route('user-wishlists')); ?>">
								<?php echo e($langg->lang168); ?>

							</a>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div> -->
<!-- Breadcrumb Area End -->

<!-- Wish List Area Start -->


<?php if(count($wishlists)): ?>


	 <div class="hiraola-wishlist_area">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <form action="javascript:void(0)">
                            <div class="table-content table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th class="hiraola-product_remove">remove</th>
                                            <th class="hiraola-product-thumbnail">images</th>
                                            <th class="cart-product-name">Product</th>
                                            <th class="hiraola-product-price">Unit Price</th>
                                            <th class="hiraola-product-stock-status">Rating</th>
                                            <th class="hiraola-cart_btn">View Product</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php $__currentLoopData = $wishlists; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $wishlist): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td class="hiraola-product_remove"><span class="remove wishlist-remove" data-href="<?php echo e(route('user-wishlist-remove',$wishlist->id)); ?>"><i class="licon-trash2"
                                                title="Remove"></i></span></td>
                                            <td class="hiraola-product-thumbnail"><a href="<?php echo e(route('front.product', $wishlist->product->slug)); ?>"><img style="width: 100px;" src="<?php echo e($wishlist->product->photo ? asset('assets/images/products/'.$wishlist->product->photo):asset('assets/images/noimage.png')); ?>" alt="Hiraola's Wishlist Thumbnail"></a>
                                            </td>
                                            <td class="hiraola-product-name"><a href="<?php echo e(route('front.product', $wishlist->product->slug)); ?>"><?php echo e($wishlist->product->name); ?></a></td>
                                            <td class="hiraola-product-price"><span class="amount price"><?php echo e($wishlist->product->showPrice()); ?><small><del><?php echo e($wishlist->product->showPreviousPrice()); ?></del></small></span></td>
                                            <td class="hiraola-product-stock-status"> <div class="ratings">
                                    <div class="empty-stars"></div>
                                    <div class="full-stars" style="width:<?php echo e(App\Models\Rating::ratings($wishlist->product->id)); ?>%"></div>
                                </div></td>
                                            <td class="hiraola-cart_btn"><a href="<?php echo e(route('front.product', $wishlist->product->slug)); ?>">VIEW PRODUCT</a></td>
                                        </tr>
                                     <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>



        <?php else: ?>

			<div class="page-center" style="padding: 100px 0;">
				<h4 class="text-center"><?php echo e($langg->lang60); ?></h4>
			</div>

			<?php endif; ?>

	



<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>

<script type="text/javascript">
        $("#sortby").on('change',function () {
        var sort = $("#sortby").val();
        window.location = "<?php echo e(url('/user/wishlists')); ?>?sort="+sort;
    	});
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.front', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>