                                
                                <?php if($prod->user_id != 0): ?>

                                
                                <?php if($prod->user->is_vendor == 2): ?>

													     <div class="mad-grid-item">
                    <!-- Product -->
                    <div class="mad-product">
                      <figure class="mad-product-image">
                      <?php if(!empty($prod->features)): ?>
													<?php $__currentLoopData = $prod->features; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $data1): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
													<div class="mad-label" style="background-color:<?php echo e($prod->colors[$key]); ?>">
														<?php echo e($prod->features[$key]); ?>

														</div>
														<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
													
						<?php endif; ?>
                        <a href="<?php echo e(route('front.product',$prod->slug)); ?>"><img src="<?php echo e($prod->thumbnail ? asset('assets/images/thumbnails/'.$prod->thumbnail):asset('assets/images/noimage.png')); ?>" alt=""></a>
                        <div class="overlay">
                           <?php if($prod->emptyStock()): ?>
       <span class="add-to-cart-btn cart-out-of-stock btn">
        <i class="icofont-close-circled"></i> <?php echo e($langg->lang78); ?>

        </span>													
        <?php else: ?>
        
        
         <?php 
                            if(!empty($prod->size_price)){?>
                               <a class="btn select_option" href="<?php echo e(route('front.product', $prod->slug)); ?>">
        <i class="icofont-cart"></i> Select Option
        </a> 
                                 <?php   //echo '<span class="new-price notranslate">$'. min($prod->size_price);
                            }else{
                        ?>
                            <span class="add-to-cart add-to-cart-btn  btn" data-href="<?php echo e(route('product.cart.add',$prod->id)); ?>">
        <i class="icofont-cart"></i> <?php echo e($langg->lang56); ?>

        </span> 
                        <?php  } ?>
        
       
        <?php endif; ?>	


																<?php if(Auth::guard('web')->check()): ?>

																<span class="add-to-wish btn" data-href="<?php echo e(route('user-wishlist-add',$prod->id)); ?>" data-toggle="tooltip" data-placement="right" title="<?php echo e($langg->lang54); ?>" data-placement="right"><i class="icofont-heart-alt" ></i>
																</span>

																<?php else: ?> 

																<span rel-toggle="tooltip" title="<?php echo e($langg->lang54); ?>" data-toggle="modal" id="wish-btn" data-target="#comment-log-reg" data-placement="right" class="btn">
																	<i class="icofont-heart-alt"></i>
																</span>

																<?php endif; ?>
                        </div>
                      </figure>
                      <!-- product-info -->
                      <div class="mad-product-description">
                        <h5 class="mad-product-title"><a href="<?php echo e(route('front.product',$prod->slug)); ?>"><?php echo e(mb_strlen($prod->name,'utf-8') > 35 ? mb_substr($prod->name,0,35,'utf-8').'...' : $prod->name); ?></a></h5>
                        <span class="mad-product-price notranslate"><span><?php echo e($prod->showPreviousPrice()); ?></span> <?php echo e($prod->showPrice()); ?></span>
                        <div class="stars">
					                                                 <!-- <div class="ratings">
					                                                      <div class="empty-stars"></div>
					                                                      <div class="full-stars" style="width:<?php echo e(App\Models\Rating::ratings($prod->id)); ?>%"></div>
					                                                  </div>-->
																		</div>
                      </div>
                      <!--/ product-info -->
                    </div>
                    <!-- End of Product -->
                  </div>



								<?php endif; ?>

                                

								<?php else: ?> 

													     <div class="mad-grid-item">
                    <!-- Product -->
                    <div class="mad-product">
                      <figure class="mad-product-image">
                      <?php if(!empty($prod->features)): ?>
													<?php $__currentLoopData = $prod->features; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $data1): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
													<div class="mad-label" style="background-color:<?php echo e($prod->colors[$key]); ?>">
														<?php echo e($prod->features[$key]); ?>

														</div>
														<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
													
						<?php endif; ?>
                        <a href="<?php echo e(route('front.product',$prod->slug)); ?>"><img src="<?php echo e($prod->thumbnail ? asset('assets/images/thumbnails/'.$prod->thumbnail):asset('assets/images/noimage.png')); ?>" alt=""></a>
                        <div class="overlay">
                           <?php if($prod->emptyStock()): ?>
       <span class="add-to-cart-btn cart-out-of-stock btn">
        <i class="icofont-close-circled"></i> <?php echo e($langg->lang78); ?>

        </span>													
        <?php else: ?>
        
        
         <?php 
                            if(!empty($prod->size_price)){?>
                               <a class="btn select_option" href="<?php echo e(route('front.product', $prod->slug)); ?>">
        <i class="icofont-cart"></i> Select Option
        </a> 
                                 <?php   //echo '<span class="new-price notranslate">$'. min($prod->size_price);
                            }else{
                        ?>
                            <span class="add-to-cart add-to-cart-btn  btn" data-href="<?php echo e(route('product.cart.add',$prod->id)); ?>">
        <i class="icofont-cart"></i> <?php echo e($langg->lang56); ?>

        </span> 
                        <?php  } ?>
        
       
        <?php endif; ?>	


																<?php if(Auth::guard('web')->check()): ?>

																<span class="add-to-wish btn" data-href="<?php echo e(route('user-wishlist-add',$prod->id)); ?>" data-toggle="tooltip" data-placement="right" title="<?php echo e($langg->lang54); ?>" data-placement="right"><i class="icofont-heart-alt" ></i>
																</span>

																<?php else: ?> 

																<span rel-toggle="tooltip" title="<?php echo e($langg->lang54); ?>" data-toggle="modal" id="wish-btn" data-target="#comment-log-reg" data-placement="right" class="btn">
																	<i class="icofont-heart-alt"></i>
																</span>

																<?php endif; ?>
                        </div>
                      </figure>
                      <!-- product-info -->
                      <div class="mad-product-description">
                        <h5 class="mad-product-title"><a href="<?php echo e(route('front.product',$prod->slug)); ?>"><?php echo e(mb_strlen($prod->name,'utf-8') > 35 ? mb_substr($prod->name,0,35,'utf-8').'...' : $prod->name); ?></a></h5>
                        <span class="mad-product-price notranslate"><span><?php echo e($prod->showPreviousPrice()); ?></span> <?php echo e($prod->showPrice()); ?></span>
                        <div class="stars">
					                                                  <!--<div class="ratings">
					                                                      <div class="empty-stars"></div>
					                                                      <div class="full-stars" style="width:<?php echo e(App\Models\Rating::ratings($prod->id)); ?>%"></div>
					                                                  </div>-->
																		</div>
                      </div>
                      <!--/ product-info -->
                    </div>
                    <!-- End of Product -->
                  </div>

								

								<?php endif; ?>

