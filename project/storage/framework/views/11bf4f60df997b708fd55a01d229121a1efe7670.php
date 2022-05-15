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
            <a href="<?php echo e(route('front.cart')); ?>">
              <?php echo e($langg->lang121); ?>

            </a>
          </li>
        </ul>
      </div>
    </div>
  </div>
</div> -->
<!-- Breadcrumb Area End -->










    <div class="hiraola-cart-area">
            <div class="container">
                <div class="row">
                    <div class="col-12">

        <div class="hiraola-tab_title" style="margin-bottom: 50px;">
                                <h4>VIEW CART</h4>
                            </div>
                            <div class="table-content table-responsive cart-table">
                            <?php echo $__env->make('includes.form-success', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th class="hiraola-product-remove">remove</th>
                                            <th class="hiraola-product-thumbnail">images</th>
                                            <th class="cart-product-name">Product</th>
                                            <th class="hiraola-product-price">Unit Price</th>
                                            <th class="hiraola-product-quantity">Quantity</th>
                                            <th class="hiraola-product-subtotal">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>


                                        <?php if(Session::has('cart')): ?>

                    <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr class="cremove<?php echo e($product['item']['id'].$product['size'].$product['color'].str_replace(str_split(' ,'),'',$product['values'])); ?>">
                    <td>
                        <span class="removecart cart-remove" data-class="cremove<?php echo e($product['item']['id'].$product['size'].$product['color'].str_replace(str_split(' ,'),'',$product['values'])); ?>" data-href="<?php echo e(route('product.cart.remove',$product['item']['id'].$product['size'].$product['color'].str_replace(str_split(' ,'),'',$product['values']))); ?>"><i class="icofont-ui-delete"></i> </span>
                      </td>
                      <td class="product-img">
                        <div class="item">
                          <img style="width: 80px;" src="<?php echo e($product['item']['photo'] ? filter_var($product['item']['photo'], FILTER_VALIDATE_URL) ?$product['item']['photo']:asset('assets/images/products/'.$product['item']['photo']):asset('assets/images/noimage.png')); ?>" alt="">
                          
                        </div>
                      </td>
                                            <td>
                                                <p class="name"><a href="<?php echo e(route('front.product', $product['item']['slug'])); ?>"><?php echo e(mb_strlen($product['item']['name'],'utf-8') > 135 ? mb_substr($product['item']['name'],0,135,'utf-8').'...' : $product['item']['name']); ?></a></p>
                                                <?php if(!empty($product['size'])): ?>
                                                <b><?php if(!empty($product['item']['variation_title'])): ?><?php echo e($product['item']['variation_title']); ?> <?php else: ?> <?php echo e($langg->lang312); ?> <?php endif; ?> </b>: <?php echo e($product['item']['measure']); ?><?php echo e(str_replace('-',' ',$product['size'])); ?> <br>
                                                <?php endif; ?>
                                                <?php if(!empty($product['color'])): ?>
                                                <div class="d-flex mt-2">
                                                <b><?php echo e($langg->lang313); ?></b>:  <span id="color-bar" style="border: 10px solid #<?php echo e($product['color'] == "" ? "white" : $product['color']); ?>;"></span>
                                                </div>
                                                <?php endif; ?>

                                                    <?php if(!empty($product['keys'])): ?>

                                                    <?php $__currentLoopData = array_combine(explode(',', $product['keys']), explode(',', $product['values'])); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                                        <b><?php echo e(ucwords(str_replace('_', ' ', $key))); ?> : </b> <?php echo e($value); ?> <br>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                                    <?php endif; ?>

                                                  </td>


                                                  <td>
                                                    <p class="product-unit-price">
                          <?php echo e(App\Models\Product::convertPrice($product['item']['price'])); ?>                        
                        </p>
                                                  </td>

                      <td class="unit-price quantity">
                        
          <?php if($product['item']['type'] == 'Physical'): ?>

                          <div class="qty">
                              <ul>
              <input type="hidden" class="prodid" value="<?php echo e($product['item']['id']); ?>">  
              <input type="hidden" class="itemid" value="<?php echo e($product['item']['id'].$product['size'].$product['color'].str_replace(str_split(' ,'),'',$product['values'])); ?>">     
              <input type="hidden" class="size_qty" value="<?php echo e($product['size_qty']); ?>">     
              <input type="hidden" class="size_price" value="<?php echo e($product['item']['price']); ?>">   
                                <li>
                                  <span class="qtminus1 reducing">
                                    <i class="icofont-minus"></i>
                                  </span>
                                </li>
                                <li>
                                  <span class="qttotal1" id="qty<?php echo e($product['item']['id'].$product['size'].$product['color'].str_replace(str_split(' ,'),'',$product['values'])); ?>"><?php echo e($product['qty']); ?></span>
                                </li>
                                <li>
                                  <span class="qtplus1 adding">
                                    <i class="icofont-plus"></i>
                                  </span>
                                </li>
                              </ul>
                          </div>
        <?php endif; ?>


                      </td>

                            <?php if($product['size_qty']): ?>
                            <input type="hidden" id="stock<?php echo e($product['item']['id'].$product['size'].$product['color'].str_replace(str_split(' ,'),'',$product['values'])); ?>" value="<?php echo e($product['size_qty']); ?>">
                            <?php elseif($product['item']['type'] != 'Physical'): ?> 
                            <input type="hidden" id="stock<?php echo e($product['item']['id'].$product['size'].$product['color'].str_replace(str_split(' ,'),'',$product['values'])); ?>" value="1">
                            <?php else: ?>
                            <input type="hidden" id="stock<?php echo e($product['item']['id'].$product['size'].$product['color'].str_replace(str_split(' ,'),'',$product['values'])); ?>" value="<?php echo e($product['stock']); ?>">
                            <?php endif; ?>

                      <td class="total-price">
                        <p id="prc<?php echo e($product['item']['id'].$product['size'].$product['color'].str_replace(str_split(' ,'),'',$product['values'])); ?>">
                          <?php echo e(App\Models\Product::convertPrice($product['price'])); ?>                 
                        </p>
                      </td>
                      
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>


                                        
                                        
                                    </tbody>
                                </table>
                            </div>
                           <!-- <div class="row">
                                <div class="col-12">
                                    <div class="coupon-all">
                                        <div class="coupon">
                                            <input id="coupon_code" class="input-text" name="coupon_code" value="" placeholder="Coupon code" type="text">
                                            <input class="button" name="apply_coupon" value="Apply coupon" type="submit">
                                        </div>
                                        <div class="coupon2">
                                            <input class="button" name="update_cart" value="Update cart" type="submit">
                                        </div>
                                    </div>
                                </div>
                            </div>  -->

                            <?php if(Session::has('cart')): ?>
                            <div class="row right-area cartpage">


                                 <div class="col-md-8">

                                

                <!--================ End of Products ================-->
              </div>



                                <div class="col-lg-4">
                                    <div class="cart-page-total right-area">
                                        <h2>Cart totals</h2>
                                        <ul>
                                            <li>Subtotal <span class="cart-total"><?php echo e(Session::has('cart') ? App\Models\Product::convertPrice($totalPrice) : '0.00'); ?></span></li>
                                            <li>Shipping <span class="cart-total">Free shipping all over India</span></li>
                                            <li>Total <span class="main-total"><?php echo e(Session::has('cart') ? App\Models\Product::convertPrice($mainTotal) : '0.00'); ?></span></li>
                                        </ul>
                                        <a href="<?php echo e(route('front.checkout')); ?>">Proceed to checkout</a>
                                    </div>
                                </div>
                            </div>
                            <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>



<!-- Cart Area End -->
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layouts.front', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>