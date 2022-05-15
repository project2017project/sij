<?php if($ps->review_blog == 1): ?>
		<!-- Blog Area Start -->
	<!--	<div class="hiraola-product-tab_area-2" style="margin-bottom : 40px;">
            <div class="container">
                <div class="row">
              
              
              
              <div class="col-lg-12">
                        <div class="product-tab">
                            <div class="hiraola-tab_title">
                                <h4>From The Blog</h4>
                            </div>
                        </div>
                        
                       
                    </div>
              
              
              
              
              
              
              










          

          </div>

        </div>
        </div>-->
	<!--	<section class="blog-area">
			<div class="container">
				<div class="row">
					
					
						<?php $__currentLoopData = DB::table('blogs')->orderby('views','desc')->take(2)->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $blogg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="col-lg-6">
							<div class="blog-box">
								<div class="blog-images">
									<div class="img">
									    <a class="read-more-btn" href="<?php echo e($blogg->source); ?>">
										<img src="<?php echo e($blogg->photo ? asset('assets/images/blogs/'.$blogg->photo):asset('assets/images/noimage.png')); ?>" class="img-fluid" alt="">
									    </a>
									</div>

								</div>
								<div class="details">
									
										<h4 class="blog-title">
											<?php echo e(mb_strlen($blogg->title,'utf-8') > 40 ? mb_substr($blogg->title,0,40,'utf-8')."...":$blogg->title); ?>

										</h4>
									
								
								</div>
							</div>
</div>
						<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

					
				</div>
			</div>
		</section>-->
		<!-- Blog Area start-->
	<?php endif; ?>













       
	<!-- main -->
	<script src="<?php echo e(asset('assets/front/js/mainextra.js')); ?>"></script>