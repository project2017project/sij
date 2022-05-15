									

										
 
    

      <div id="cart-items">


      <?php if(Session::has('cart')): ?>


       <div class="minicart-content" >

      <ul class="minicart-list">
                    <?php $__currentLoopData = Session::get('cart')->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>


                    <li class="minicart-product cremove<?php echo e($product['item']['id'].$product['size'].$product['color'].str_replace(str_split(' ,'),'',$product['values'])); ?>">
                                 <button class="product-item_remove cart-remove" data-class="cremove<?php echo e($product['item']['id'].$product['size'].$product['color'].str_replace(str_split(' ,'),'',$product['values'])); ?>" data-href="<?php echo e(route('product.cart.remove',$product['item']['id'].$product['size'].$product['color'].str_replace(str_split(' ,'),'',$product['values']))); ?>" title="Remove Product"><i class="ion-android-close"></i></button>
                                <a href="<?php echo e(route('front.product', $product['item']['slug'])); ?>" class="product-item_img">
                                    <img src="<?php echo e($product['item']['photo'] ? filter_var($product['item']['photo'], FILTER_VALIDATE_URL) ?$product['item']['photo']:asset('assets/images/products/'.$product['item']['photo']):asset('assets/images/noimage.png')); ?>" alt="product">
                                </a>
                                <div class="product-item_content">
                                    <a class="product-item_title" href="<?php echo e(route('front.product',$product['item']['slug'])); ?>"><?php echo e(mb_strlen($product['item']['name'],'utf-8') > 145 ? mb_substr($product['item']['name'],0,145,'utf-8').'...' : $product['item']['name']); ?></a>
                                    <?php if($product['size']): ?><p><b>option : </b><?php echo e($product['size']); ?></p><?php endif; ?>
                                    <span class="product-item_quantity"><span class="cart-product-qty" id="cqt<?php echo e($product['item']['id'].$product['size'].$product['color'].str_replace(str_split(' ,'),'',$product['values'])); ?>"><?php echo e($product['qty']); ?></span><span><?php echo e($product['item']['measure']); ?></span>x<span id="prct<?php echo e($product['item']['id'].$product['size'].$product['color'].str_replace(str_split(' ,'),'',$product['values'])); ?>"><?php echo e(App\Models\Product::convertPrice($product['item']['price'])); ?></span></span>
                                </div>
                            </li>





                    
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

               </ul>


     <div class="sc-footer">
   <div class="minicart-item_total subtotal sc-footer">
    <span>Subtotal</span>
    <span class="ammount total-price cart-total"><?php echo e(Session::has('cart') ? App\Models\Product::convertPrice(Session::get('cart')->totalPrice) : '0.00'); ?></span>
  </div>
  <div class="minicart-btn_area">
    <a href="<?php echo e(route('front.cart')); ?>" class="hiraola-btn hiraola-btn_dark hiraola-btn_fullwidth">View Cart</a>
  </div>
  <div class="minicart-btn_area">
    <a href="<?php echo e(route('front.checkout')); ?>" class="hiraola-btn hiraola-btn_dark hiraola-btn_fullwidth">Checkout</a>
  </div>

  </div>

   </div>




    <?php else: ?> <div class="minicart-content">
                  <p class="mt-1 pl-3 text-left"><?php echo e($langg->lang8); ?></p> 


                  <div class="minicart-btn_area">
    <a href="<?php echo e(route('front.cart')); ?>" class="hiraola-btn hiraola-btn_dark hiraola-btn_fullwidth">Continue Shopping</a>
  </div>


                  </div>





                  <?php endif; ?>

                  </div>






								