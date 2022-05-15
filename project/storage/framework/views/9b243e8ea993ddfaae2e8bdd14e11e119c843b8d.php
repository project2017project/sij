
<?php if($prod->user_id != 0): ?>


<?php if($prod->user->is_vendor == 2): ?>
 
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
                                                    <img class="primary-img" src="<?php echo e($prod->thumbnail ? asset('assets/images/thumbnails/'.$prod->thumbnail):asset('assets/images/noimage.png')); ?>" alt="<?php echo e($prod->showName()); ?>">
                                                     <?php $__currentLoopData = $prod->galleries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                         <?php if($loop->first): ?>
                                                         <img class="secondary-img" src="<?php echo e(asset('assets/images/galleries/'.$gal->photo)); ?>" alt="<?php echo e($prod->showName()); ?>">
                                                    <?php endif; ?>
                                                        
                                                     <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    
                                                </a>


                                                <?php if(!empty($prod->features)): ?>
                                                <?php $__currentLoopData = $prod->features; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $data1): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <span class="sticker" style="background-color:<?php echo e($prod->colors[$key]); ?>"><?php echo e($prod->features[$key]); ?></span>
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
                            <span class="new-price "><?php echo e($prod->showPrice()); ?></span><span><del> <?php echo e($prod->showPreviousPrice()); ?></del></span>
                        <?php  } ?>
                    </div>
                                            <div class="additional-add_action">
                                                <ul>
                                                    <li>

                                                    	<?php if(Auth::guard('web')->check()): ?>

                                                    	<span class="hiraola-add_compare add-to-wish btn" data-href="<?php echo e(route('user-wishlist-add',$prod->id)); ?>" data-toggle="tooltip" data-placement="top" title="Add To Wishlist"><i class="ion-android-favorite-outline"></i>
                                                    	</span>

                                                    	<?php else: ?> 

                                                    	<span class="hiraola-add_compare btn" data-toggle="modal" id="wish-btn" data-target="#comment-log-reg" data-placement="right"  data-toggle="tooltip" data-placement="top" title="Add To Wishlist">
                                                    		<i class="ion-android-favorite-outline"></i>
                                                    	</span>

                                                    	<?php endif; ?>


                                                  




                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="rating-box">

                                            <div class="stars">
<!--<div class="ratings">
<div class="empty-stars"></div>
<div class="full-stars" style="width:<?php echo e(App\Models\Rating::ratings($prod->id)); ?>%"></div>
</div>-->
</div>
                                                <!--ul>
                                                    <li><i class="fa fa-star-of-david"></i></li>
                                                    <li><i class="fa fa-star-of-david"></i></li>
                                                    <li><i class="fa fa-star-of-david"></i></li>
                                                    <li><i class="fa fa-star-of-david"></i></li>
                                                    <li class="silver-color"><i class="fa fa-star-of-david"></i></li>
                                                </ul-->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>










<?php endif; ?>



<?php else: ?> 


<div class="slide-item">
                                <div class="single_product">
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
                                                <span class="sticker" style="background-color:<?php echo e($prod->colors[$key]); ?>"><?php echo e($prod->features[$key]); ?></span>
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
                            <span class="new-price "><?php echo e($prod->showPrice()); ?></span><span><del> <?php echo e($prod->showPreviousPrice()); ?></del></span>
                        <?php  } ?>
                    </div>
                                            <div class="additional-add_action">
                                                <ul>
                                                    <li>

                                                    	<?php if(Auth::guard('web')->check()): ?>

                                                    	<span class="hiraola-add_compare add-to-wish btn" data-href="<?php echo e(route('user-wishlist-add',$prod->id)); ?>" data-toggle="tooltip" data-placement="top" title="Add To Wishlist"><i class="ion-android-favorite-outline"></i>
                                                    	</span>

                                                    	<?php else: ?> 

                                                    	<span class="hiraola-add_compare btn" data-toggle="modal" id="wish-btn" data-target="#comment-log-reg" data-placement="right"  data-toggle="tooltip" data-placement="top" title="Add To Wishlist">
                                                    		<i class="ion-android-favorite-outline"></i>
                                                    	</span>

                                                    	<?php endif; ?>


                                                  




                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="rating-box">

                                            <div class="stars">
<!--<div class="ratings">
<div class="empty-stars"></div>
<div class="full-stars" style="width:<?php echo e(App\Models\Rating::ratings($prod->id)); ?>%"></div>
</div>-->
</div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
					
<?php endif; ?>