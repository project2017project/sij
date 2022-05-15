			<?php if(count($prods) > 0): ?>
			
			<div class="row">
					<?php $__currentLoopData = $prods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $prod): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>


								<div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-6">
                                <div class="slide-item">
                                    <div class="single_product">
                                         <?php
                $sellprice = $prod->showPrice();
                $mrpprice =  $prod->showPreviousPrice();
                ?>
                
                <?php if($mrpprice > $sellprice): ?>
                
                <span class="selllabel-list">Sale</span>
                
                <?php endif; ?>
                                        <div class="product-img">
                                            <a href="<?php echo e(route('front.product', $prod->slug)); ?>">
                                                <img class="primary-img" src="<?php echo e($prod->thumbnail ? asset('assets/images/thumbnails/'.$prod->thumbnail):asset('assets/images/noimage.png')); ?>" alt="Product Image">
                                                 <?php $__currentLoopData = $prod->galleries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                         <?php if($loop->first): ?>
                                                         <img class="secondary-img" src="<?php echo e(asset('assets/images/galleries/'.$gal->photo)); ?>" alt="<?php echo e($prod->showName()); ?>">
                                                    <?php endif; ?>
                                                        
                                                     <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </a>
                                            <?php if(!empty($prod->features)): ?>
													  <?php $__currentLoopData = $prod->features; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $data1): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
														<span class="sticker"style="background-color:<?php echo e($prod->colors[$key]); ?>"><?php echo e($prod->features[$key]); ?></span>
														<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
												<?php endif; ?>
                                            <div class="add-actions">
                                                <ul>
                                                    <li>

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


                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="hiraola-product_content">
                                            <div class="product-desc_info">
                                                <h6><a class="product-name" href="<?php echo e(route('front.product', $prod->slug)); ?>"><?php echo e($prod->showName()); ?></a></h6>
                                                <div class="price-box notranslate">
                            



                        <?php 
                            if(!empty($prod->size_price)){?>
                                <span class="new-price "><?php echo e($prod->showPriceNew()); ?><span>
                                 <?php   //echo '<span class="new-price notranslate">$'. min($prod->size_price);
                            }else{
                        ?>
                            <span class="new-price "><?php echo e($prod->showPrice()); ?></span><span><del> <?php
                $sellprice = $prod->showPrice();
                $mrpprice =  $prod->showPreviousPrice();
                ?>
                
                <?php if($mrpprice > $sellprice): ?>
                
                <?php echo e($prod->showPreviousPrice()); ?>

                
                <?php endif; ?></del></span>
                        <?php  } ?>
                    </div>
                                                <div class="additional-add_action">
                                                    <ul>
                                                        <li>
                                                        	<?php if(Auth::guard('web')->check()): ?>

																<span class="add-to-wish" data-href="<?php echo e(route('user-wishlist-add',$prod->id)); ?>" data-toggle="tooltip" data-placement="right" title="<?php echo e($langg->lang54); ?>" data-placement="right"><i class="ion-android-favorite-outline" ></i>
																</span>

																<?php else: ?>

																<span rel-toggle="tooltip" title="<?php echo e($langg->lang54); ?>" data-toggle="modal" id="wish-btn" data-target="#comment-log-reg" data-placement="right">
																	<i class="ion-android-favorite-outline"></i>
																</span>

																<?php endif; ?>
                                                        </li>
                                                    </ul>
                                                </div>
                                             <!--   <div class="ratings">
                                <div class="empty-stars"></div>
                                <div class="full-stars" style="width:<?php echo e(App\Models\Rating::ratings($prod->id)); ?>%"></div>
                            </div>-->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				
				<div class="row" style="width:100%;">
				<div class="text-center" style="width:100%;">
					<div class="page-center mt-5">
						<?php echo $prods->appends(['search' => request()->input('search')])->links(); ?>

					</div>
				</div>
				</div>
				
			<?php else: ?>
				<div class="no product-found-shop">
					<?php echo e($langg->lang60); ?>

				</div>
			<?php endif; ?>


<?php if(isset($ajax_check)): ?>


<script type="text/javascript">


// Tooltip Section


    $('[data-toggle="tooltip"]').tooltip({
      });
      $('[data-toggle="tooltip"]').on('click',function(){
          $(this).tooltip('hide');
      });




      $('[rel-toggle="tooltip"]').tooltip();

      $('[rel-toggle="tooltip"]').on('click',function(){
          $(this).tooltip('hide');
      });


// Tooltip Section Ends

</script>

<?php endif; ?>