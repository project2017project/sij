<?php $__env->startSection('content'); ?>

	<?php if($ps->slider == 1): ?>

		<?php if(count($sliders)): ?>
			<?php echo $__env->make('includes.slider-style', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
		<?php endif; ?>
	<?php endif; ?>






    <?php if($ps->slider == 1): ?>
		<?php if(count($sliders)): ?>
        <div class="hiraola-slider_area-2 hiraola-slider_area-3 color-white">
            <div class="main-slider">
                <?php $__currentLoopData = $sliders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="<?php echo e($data->link); ?>">
                    <div class="single-slide animation-style-01 bg-6" style=" background-repeat : no-repeat;     background-position: center center;  background-size: cover;">
                        <img src="<?php echo e(asset('assets/images/sliders/'.$data->photo)); ?>" />
                        <!--<div class="container">
                            <div class="slider-content slider-content-2">
                                
                                <h5 style=" color: <?php echo e($data->subtitle_color); ?>" ><?php echo e($data->subtitle_text); ?></h5>
                                <h2 style=" color: <?php echo e($data->title_color); ?>"><?php echo e($data->title_text); ?></h2>
                         
                                <h4  style=" color: <?php echo e($data->details_color); ?>"><?php echo e($data->details_text); ?></h4>
                              <div class="hiraola-btn-ps_center slide-btn">
                                    <a class="hiraola-btn <?php echo e($data->link); ?>" href="shop-left-sidebar.html"><?php echo e($langg->lang25); ?> </a>
                                </div>
                            </div>
                            <div class="slider-progress"></div>
                        </div>-->
                    </div>
                </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
        <?php endif; ?>
	<?php endif; ?>

  <!-- Begin Hiraola's Product Tab Area -->
        <div class="hiraola-product-tab_area-2" style="margin-bottom : 40px;">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="product-tab">
                            <div class="hiraola-tab_title">
                                <h4>Latest Collections</h4>
                            </div>
                        </div>
                        
                        <div class="shop-product-wrap grid gridview-4 home-4productsrow row mt-10">
                               		<?php $__currentLoopData = $latest_collection; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prod): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<?php echo $__env->make('includes.product.slider-product', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                         </div>
                        
                    
                    	<div class="hiraola-tab_title text-center">
                            <a href="<?php echo e(route('front.index')); ?>/category/imitation-jewellery" class="hiraola-btn home-page-all center mt-20">SHOW ALL</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        
        
        
        
        
          <!-- Begin Hiraola's Product Tab Area -->
        <div class="hiraola-product-tab_area-2" style="margin-bottom : 40px;">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="product-tab">
                            <div class="hiraola-tab_title">
                                <h4>Designer Jewellery</h4>
                            </div>
                        </div>
                        
                        <div class="shop-product-wrap grid gridview-4 home-4productsrow row mt-10">
                               		<?php $__currentLoopData = $designer_collection; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prod): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<?php echo $__env->make('includes.product.slider-product', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                         </div>
                        
                    
                    	<div class="hiraola-tab_title text-center">
                            <a href="<?php echo e(route('front.designer')); ?>" class="hiraola-btn home-page-all center mt-20">SHOW ALL</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        
        
        
         <div class="hiraola-product-tab_area-2" style="margin-bottom : 40px;">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="product-tab">
                            <div class="hiraola-tab_title">
                                <h4>Today's Deals</h4>
                            </div>
                        </div>
                        
                        <div class="shop-product-wrap grid gridview-4 home-4productsrow row mt-10">
                               		<?php $__currentLoopData = $today_collection; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prod): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<?php echo $__env->make('includes.product.slider-product', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                         </div>
                        
                    
                    	<div class="hiraola-tab_title text-center">
                            <a href="<?php echo e(route('front.index')); ?>/onsale/imitation-jewellery" class="hiraola-btn home-page-all center mt-20">SHOW ALL</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        
        
        
        <div class="hiraola-product-tab_area-2" style="margin-bottom : 40px;">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="product-tab">
                            <div class="hiraola-tab_title">
                                <h4>Best Sellers</h4>
                            </div>
                        </div>
                        
                        <div class="shop-product-wrap grid gridview-4 home-4productsrow row mt-10">
                               		<?php $__currentLoopData = $best_collection; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prod): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<?php echo $__env->make('includes.product.slider-product', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                         </div>
                        
                    
                    	<div class="hiraola-tab_title text-center">
                            <a href="<?php echo e(route('front.index')); ?>/popularproduct" class="hiraola-btn home-page-all center mt-20">SHOW ALL</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        
        
        <div class="hiraola-product-tab_area-2" style="margin-bottom : 40px;">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="product-tab">
                            <div class="hiraola-tab_title">
                                <h4>Bridal Collections</h4>
                            </div>
                        </div>
                        
                        <div class="shop-product-wrap grid gridview-4 home-4productsrow row mt-10">
                               		<?php $__currentLoopData = $bridal_collection; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prod): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<?php echo $__env->make('includes.product.slider-product', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                         </div>
                        
                    
                    	<div class="hiraola-tab_title text-center">
                            <a href="<?php echo e(route('front.bribal')); ?>" class="hiraola-btn home-page-all center mt-20">SHOW ALL</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        
        
        <!-- Begin Hiraola's Product Tab Area -->
        <div class="hiraola-product-tab_area-2" style="margin-bottom : 40px;">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="product-tab">
                            <div class="hiraola-tab_title">
                                <h4>Collections</h4>
                            </div>
                          
                        </div>
                        
                        <div class="category_boxes" style=" margin-top : 40px;">
                              <!--<?php if($ps->featured_category == 1): ?>
                                      	<?php $__currentLoopData = $categories->where('is_featured','=',1); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            
                             <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>-->
                                    
                                    <?php if($ps->featured_category == 1): ?>
              
                <?php $__currentLoopData = $subcat; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                 
                    
                    <div class="category_item">
                                <div class="product-img">
                                                        <a href="<?php echo e(route('front.subcat',['slug1' =>$cat->category->slug, 'slug2' => $cat->slug])); ?>">
                                                            <img class="primary-img" src="<?php echo e(asset('assets/images/subcategory/'.$cat->image)); ?>" alt="<?php echo e($cat->name); ?>">
                                                        </a>
                                                    </div>
                                                    <div class="hiraola-product_content">
                                                        <div class="product-desc_info">
                                                            <h6><a class="product-name" href="<?php echo e(route('front.subcat',['slug1' =>$cat->category->slug, 'slug2' => $cat->slug])); ?>"><?php echo e($cat->name); ?></a></h6>
                                                        </div>
                                                    </div>
                            </div>
                            
                    
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
     
            <?php endif; ?>
                        </div>    
                        
                        
                    
                    </div>
                </div>
            </div>
        </div>
        
        
        
        
        
        
        
        
     
        
        
        
        
        
        
        
    	<section id="extraData">
    		<div class="text-center">
    			<img src="<?php echo e(asset('assets/images/'.$gs->loader)); ?>">
    		</div>
    	</section>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
	<script>
        $(window).on('load',function() {
            setTimeout(function(){
                $('#extraData').load('<?php echo e(route('front.extraIndex')); ?>');
            }, 500);
        });
	</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.front', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>