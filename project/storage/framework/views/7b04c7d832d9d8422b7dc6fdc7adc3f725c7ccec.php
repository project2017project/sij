<?php $__env->startSection('content'); ?>
<?php $dataimage=array();
$dataimage=explode(',',$productt->size_image); ?>
 <?php
$total_stock = 0;
?>	
<?php if($productt->stock || $productt->size_qty): ?>
	<?php
$total_stock = $productt->stock;
?>
<?php if(!empty($productt->size_qty)): ?>
 <?php $__currentLoopData = $productt->size_qty; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $skey => $skeydata): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<?php
$total_stock += $productt->size_qty[$skey];
?> 

 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
 <?php endif; ?> 
<?php endif; ?>


<section class="product-details-page">
  <div class="container">
    <div class="row">
    <div class="col-lg-12">
        <div class="row">

            <div class="col-lg-6 col-md-12">
                
                <?php
                $sellprice = $productt->showPrice();
                $mrpprice =  $productt->showPreviousPrice();
                ?>
                
                <?php if($mrpprice > $sellprice): ?>
                
                <span class="selllabel">Sale</span>
                
                <?php endif; ?>
                
              <div class="xzoom-container">
                     <div class="preview-xzoom">
                  <img class="xzoom5" id="xzoom-magnific" src="<?php echo e(filter_var($productt->photo, FILTER_VALIDATE_URL) ?$productt->photo:asset('assets/images/products/'.$productt->photo)); ?>" xoriginal="<?php echo e(filter_var($productt->photo, FILTER_VALIDATE_URL) ?$productt->photo:asset('assets/images/products/'.$productt->photo)); ?>" />
                  </div>
                  <div class="xzoom-thumbs">
                    <div class="xzoom-inner-container">
                    <div class="all-slider">

                        <a href="<?php echo e(filter_var($productt->photo, FILTER_VALIDATE_URL) ?$productt->photo:asset('assets/images/products/'.$productt->photo)); ?>">
                      <img class="xzoom-gallery5" width="80" src="<?php echo e(filter_var($productt->photo, FILTER_VALIDATE_URL) ?$productt->photo:asset('assets/images/products/'.$productt->photo)); ?>" title="The description goes here">
                        </a>

                    <?php $__currentLoopData = $productt->galleries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>


                        <a href="<?php echo e(asset('assets/images/galleries/'.$gal->photo)); ?>">
                      <img class="xzoom-gallery5" width="80" src="<?php echo e(asset('assets/images/galleries/'.$gal->photo)); ?>" title="The description goes here">
                        </a>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					
					
				
					  <?php $__currentLoopData = $dataimage; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $datimg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                        <?php if(!empty($datimg)): ?>

                        <a href="<?php echo e(asset('assets/images/products/'.$datimg)); ?>">
                      <img class="xzoom-gallery5" width="80" src="<?php echo e(asset('assets/images/products/'.$datimg)); ?>" title="The description goes here">
                        </a>
                        
                           <?php endif; ?>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                 
                    
                  

               
                    
                    
                    

                    </div>
                    </div>


                  </div>
              </div>

            </div>

            <div class="col-lg-6">
              <div class="right-area">
                <div class="product-info">
                  <h4 class="product-name"><?php echo e($productt->name); ?></h4>
                  
                  
                  
                  
                  
              
                  
                  
                  <?php if(!empty($dataimage)): ?>
					  <?php $__currentLoopData = $dataimage; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $datimg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>


                  
                       

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                  
                  
                  <div class="info-meta-1">
                    <ul>
                        
                      <?php if($productt->type == 'Physical'): ?> 
                                <?php if(($productt->sum_stock) == 0): ?>
                            
                                    <li class="product-outstook">
                                        
                                        <p>
                                          <i class="icofont-close-circled"></i>
                                          <?php echo e($langg->lang78); ?>

                
                                         <form id="notifyform" style="width : 100%; margin : 15px 0;">
                                             
                                            <div class="input-group">
                                                 <input type="hidden" name="product_id" value="<?php echo e($productt->id); ?>">
                                                  <input  class="form-control" type="email" name="email" id="email"  placeholder="Enter Email" required="">
                                                <div class="input-group-btn" style="margin-left : -5px;">
                                                  <button class="btn btn-danger submit-btn" type="submit"> <i class="icofont-envelope"></i> Notify Me</button>
                                                </div>
                                            </div>
                                                <?php echo e(csrf_field()); ?>

                                                
                                                <?php echo $__env->make('includes.admin.form-both', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?> 
                                               
                                           
                                             
                                          </form>
                                        
                                        </p>
                                        <p class="successmsg"></p>
                                      </li>
                                      
                                      
                                      
                                  <?php endif; ?>
                            
                            <?php else: ?>
                                <!--  <?php if($productt->emptyStock()): ?>
                                  
                                  <li class="product-outstook">
                                    <p class="successmsg"></p>
                                    <p>
                                      <i class="icofont-close-circled"></i>
                                      <?php echo e($langg->lang78); ?>

            
                                     <form id="notifyform" >-->
                                      <!-- <form id="notifyform" action="<?php echo e(route('front.notify.submit')); ?>" method="POST"> -->
                               <!--             <?php echo e(csrf_field()); ?>

                                            
                                            <?php echo $__env->make('includes.admin.form-both', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?> 
                                            <input type="hidden" name="product_id" value="<?php echo e($productt->id); ?>">
                                        <input type="text" name="email" id="email"  placeholder="<?php echo e($langg->lang49); ?> *" required="">
                                                        <i class="icofont-envelope"></i>
                                         <button class="submit-btn" type="submit"><?php echo e($langg->lang52); ?></button>
                                      </form>
                                    </p>
                                  </li>-->
                                  
                              <!--    <?php else: ?> 
                                  <li class="product-isstook">
                                    <p>
                                      <i class="icofont-check-circled"></i>
                                      <?php echo e($gs->show_stock == 0 ? '' : $productt->stock); ?> <?php echo e($langg->lang79); ?>

                                    </p>
                                  </li>
                                  
                                     
                                  <?php endif; ?>-->
                      <?php endif; ?>
                      <li>
                        <!--<div class="ratings">
                          <div class="empty-stars"></div>
                          <div class="full-stars" style="width:<?php echo e(App\Models\Rating::ratings($productt->id)); ?>%"></div>
                        </div>-->
                      </li>
                      <li class="review-count">
                       <!-- <p><?php echo e(count($productt->ratings)); ?> <?php echo e($langg->lang80); ?></p>-->
                      </li>
                        <?php if($productt->product_condition != 0): ?>
                     <li>
                       <div class="<?php echo e($productt->product_condition == 2 ? 'mybadge' : 'mybadge1'); ?>">
                        <?php echo e($productt->product_condition == 2 ? 'New' : 'Used'); ?>

                       </div>
                     </li>
                        <?php endif; ?>
                    </ul>
                    
                    
                      <div class="product-price">
                          <?php
                $sellprice = $productt->showPrice();
                $mrpprice =  $productt->showPreviousPrice();
                
            
                
                ?>
                
                   <?php if($productt->size_price < 1): ?>
                <?php
                 $sellpricen = $productt->price;
                $mrppricen =  $productt->previous_price;
                
                $discount = ((int)$mrppricen) - ((int)$sellpricen);
                $discountpi = (int)$discount / (int)$mrppricen;
                
                $discountpercentage = round($discountpi * 100, 2);
                ?>
                
                <?php endif; ?>
             
                          
                     
                          
              <p class="title" style="display: none;"><b><?php echo e($langg->lang87); ?> :</b></p>
                    
              
                    <p class="price"><span id="sizeprice"><?php echo e($productt->showPrice()); ?></span>
                      <small>
                
                <?php if($mrpprice > $sellprice): ?>
                
                <del><?php echo e($productt->showPreviousPrice()); ?></del> <span class="text-danger"><?php echo e($discountpercentage); ?>% off</span>
                
                <?php endif; ?></small></p>
                      
                      
                    
                  </div>
                    
                     <div class="seller-info mt-3">
        <div class="content">
          <h4 class="title">
            <?php echo e($langg->lang246); ?>

          </h4>
          
          

       

          <p class="stor-name">
           <?php if( $productt->user_id  != 0): ?>
              <?php if(isset($productt->user)): ?>
                 <a href="<?php echo e(route('front.vendor',str_replace(' ', '-', $productt->user->shop_name))); ?>"> <?php echo e($productt->user->shop_name); ?> </a>
                <?php if($productt->user->checkStatus()): ?>
                <br>
                <a class="verify-link" href="<?php echo e(route('front.vendor',str_replace(' ', '-', $productt->user->shop_name))); ?>"  data-toggle="tooltip" data-placement="top" title="<?php echo e($langg->lang783); ?>">
                  
                  <i class="fas fa-check-circle"></i>
                
                </a>
                <?php endif; ?>

              <?php else: ?>
                <?php echo e($langg->lang247); ?>

              <?php endif; ?>
          <?php else: ?>
             <a href="<?php echo e(route('front.vendor',str_replace(' ', '-', $productt->user->shop_name))); ?>"> <?php echo e(App\Models\Admin::find(1)->shop_name); ?> </a>
          <?php endif; ?>
          </p>
          
          
          
          
          
         

       
        </div>
  

                  



                 
                  

      </div>


                    
                    
                 
                  
                  </div>



          
                  
                  
                  <div class="product_short_desc">
                      <?php echo $productt->short_details; ?>

                     
          </div>
          
          
              <?php if($productt->stock == '1'): ?>
                
                  <div class="text-danger" style="display:block; opacity : 1;" role="alert">
                     Only 1 Left In Stock
                  </div>
                 
                  <?php endif; ?>

                  <div class="info-meta-2">
                    <ul>

                      <?php if($productt->type == 'License'): ?>

                      <?php if($productt->platform != null): ?>
                      <li>
                        <p><?php echo e($langg->lang82); ?>: <b><?php echo e($productt->platform); ?></b></p>
                      </li>
                      <?php endif; ?>

                      <?php if($productt->region != null): ?>
                      <li>
                        <p><?php echo e($langg->lang83); ?>: <b><?php echo e($productt->region); ?></b></p>
                      </li>
                      <?php endif; ?>

                      <?php if($productt->licence_type != null): ?>
                      <li>
                        <p><?php echo e($langg->lang84); ?>: <b><?php echo e($productt->licence_type); ?></b></p>
                      </li>
                      <?php endif; ?>

                      <?php endif; ?>

                    </ul>
                  </div>


                                            
                  <?php if(!empty($productt->size)): ?>
                  <div class="product-size">
                      <?php if(!empty($productt->variation_title)): ?>
                    <p class="title"><b>Choose <?php echo e($productt->variation_title); ?> :</b></p>
                     <?php else: ?>
                     <p class="title"><b>Choose <?php if(!empty($productt->variation_title)): ?> <?php echo e($productt->variation_title); ?> <?php else: ?> Option <?php endif; ?> :</b></p>
                     <?php endif; ?>

                    <div class="selectbox_wrap_list_optin">Choose </div>

                    <ul class="siz-list">					
                        <?php
                        $is_first = false;
                        ?>
                     
                        <?php $__currentLoopData = $productt->size; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $data1): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      
                        <li class="stock-<?php echo $productt->size_qty[$key];?> <?php echo e($is_first ? 'active' : ''); ?>">
                            
                            <span class="box"><?php echo e($data1); ?><span class="qty-label">&nbsp; [Sold Out]</span>
                                <span class="qty-price font-s-0">&nbsp; (<?php echo e($productt->size_price[$key]); ?>)</span>
                                <input type="hidden" class="size" value="<?php echo e($data1); ?>">
                                <input type="hidden" class="size_qty" value="<?php echo e($productt->size_qty[$key]); ?>">
                                <input type="hidden" class="size_key" value="<?php echo e($key); ?>">
                                <input type="hidden" class="size_price" value="<?php echo e(round($productt->size_price[$key] * $curr->value,2)); ?>">
                                <?php if(!empty($productt->size_image)): ?>
                                <a href="<?php if(@$dataimage[$key]): ?><?php echo e(asset('assets/images/products/'.@$dataimage[$key])); ?><?php else: ?> <?php endif; ?>" class="variation_imgage_for_sl">
                                <img src="<?php if(@$dataimage[$key]): ?><?php echo e(asset('assets/images/products/'.@$dataimage[$key])); ?><?php else: ?> <?php endif; ?>" class="xzoom-gallery5">
                                </a>
                                <?php endif; ?>
                            </span>
                        </li>
                        <?php
                        $is_first = false;
                        ?>
                      
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                      
                        
                    </ul>
                    
                   <span class="os-stock">out of stock</span>
                  </div>
                  <?php endif; ?>
                  
                 


                  <?php if(!empty($productt->color)): ?>
                  <div class="product-color">
                    <p class="title"><?php echo e($langg->lang89); ?> :</p>
                    <ul class="color-list">
                      <?php
                      $is_first = true;
                      ?>
                      <?php $__currentLoopData = $productt->color; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $data1): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <li class="<?php echo e($is_first ? 'active' : ''); ?>">
                        <span class="box" data-color="<?php echo e($productt->color[$key]); ?>" style="background-color: <?php echo e($productt->color[$key]); ?>"></span>
                      </li>
                      <?php
                      $is_first = false;
                      ?>
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    </ul>
                  </div>
                  <?php endif; ?>

                  <?php if(!empty($productt->size)): ?>

                  <input type="hidden" id="stock" value="<?php echo e($productt->size_qty[0]); ?>">
                  <?php else: ?>
                  <?php
                  $stck = (string)$productt->stock;
                  ?>
                  <?php if($stck != null): ?>
                  <input type="hidden" id="stock" value="<?php echo e($stck); ?>">
                  <?php elseif($productt->type != 'Physical'): ?>
                  <input type="hidden" id="stock" value="0">
                  <?php else: ?>
                  <input type="hidden" id="stock" value="">
                  <?php endif; ?>

                  <?php endif; ?>
                  <input type="hidden" id="product_price" value="<?php echo e(round($productt->vendorPrice() * $curr->value,2)); ?>">

                  <input type="hidden" id="product_id" value="<?php echo e($productt->id); ?>">
                  <input type="hidden" id="curr_pos" value="<?php echo e($gs->currency_format); ?>">
                  <input type="hidden" id="curr_sign" value="<?php echo e($curr->sign); ?>">
                  <div class="info-meta-3">
                    <ul class="meta-list">
                      <?php if($productt->product_type != "affiliate"): ?>
                      <li class="d-block count <?php echo e($productt->type == 'Physical' ? '' : 'd-none'); ?>">
                        <div class="qty">
                          <ul>
                            <li>
                              <span class="qtminus">
                                <i class="icofont-minus"></i>
                              </span>
                            </li>
                            <li>
                              <span class="qttotal">1</span>
                            </li>
                            <li>
                              <span class="qtplus">
                                <i class="icofont-plus"></i>
                              </span>
                            </li>
                          </ul>
                        </div>
                      </li>
                      <?php endif; ?>

                      <?php if(!empty($productt->attributes)): ?>
                        <?php
                          $attrArr = json_decode($productt->attributes, true);
                        ?>
                      <?php endif; ?>
                      <?php if(!empty($attrArr)): ?>
                        <div class="product-attributes my-4">
                          <div class="row">
                          <?php $__currentLoopData = $attrArr; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attrKey => $attrVal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if(array_key_exists("details_status",$attrVal) && $attrVal['details_status'] == 1): ?>

                          <div class="col-lg-6">
                              <div class="form-group mb-2">
                                <strong for="" class="text-capitalize"><?php echo e(str_replace("_", " ", $attrKey)); ?> :</strong>
                                <div class="">
                              
                                    
                                <?php $__currentLoopData = $attrVal['values']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $optionKey => $optionVal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                  <div class="custom-control custom-radio">
                                    <input type="hidden" class="keys" value="">
                                    <input type="hidden" class="values" value="">
                                    <input type="checkbox" id="<?php echo e($attrKey); ?><?php echo e($optionKey); ?>" name="<?php echo e($attrKey); ?>" class="custom-control-input product-attr"  data-key="<?php echo e($attrKey); ?>" data-price = "<?php echo e($attrVal['prices'][$optionKey] * $curr->value); ?>" value="<?php echo e($optionVal); ?>" <?php echo e($loop->first ? '' : ''); ?>>
                                    <label class="custom-control-label" for="<?php echo e($attrKey); ?><?php echo e($optionKey); ?>"><?php echo e($optionVal); ?>


                                    <?php if(!empty($attrVal['prices'][$optionKey])): ?>
                                      +
                                      <?php echo e($curr->sign); ?> <?php echo e($attrVal['prices'][$optionKey] * $curr->value); ?>

                                    <?php endif; ?>
                                    </label>
                                  </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                              </div>
                          </div>
                            <?php endif; ?>
                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                          </div>
                        </div>
                      <?php endif; ?>
                      
                            <?php if(!empty($productt->attributes)): ?>
                      <div class="product-addon-totals" style="display : none;">
                          <ul>
                              <li>
                                  <div class="wc-pao-col1">
                                      <strong><span class="qtycalc">1</span> x <?php echo e($productt->name); ?></strong>
                                    </div>
                                    <div class="wc-pao-col2">
                                          <strong>
                                              <span class=curr_sign""><?php echo e($curr->sign); ?></span><span class="amount" id="calcprice"><?php echo e($productt->showPrice()); ?></span>
                                              </strong>
                                              </div>
                              </li>
                              
                              <li class="addon_li">
                                  
                              </li>
                              
                                <li>
                                  <div class="wc-pao-col1">
                                      
                                    </div>
                                    <div class="wc-pao-col2">
                                          <strong>
                                             Subtotal :  <span class=curr_sign""><?php echo e($curr->sign); ?></span><span class="subtotalamtli"></span>
                                              </strong>
                                              </div>
                              </li>
                              
                             <!-- <li class="wc-pao-subtotal-line">
                                  <p class="price">Subtotal <span class="amount"><?php echo e($productt->showPrice()); ?></span>
                                   </p>
                              </li>-->
                         </ul>
                      </div>
                      
                      <?php endif; ?>
                      

                      <?php if($productt->product_type == "affiliate"): ?>

                      <li class="addtocart">
                        <a href="<?php echo e(route('affiliate.product', $productt->slug)); ?>" target="_blank"> BUY NOW</a>
                      </li>
                      <?php else: ?>
                      <?php if($productt->emptyStock()): ?>
                      <li class="addtocart">
                        <a href="javascript:;" class="cart-out-of-stock">
                          <i class="icofont-close-circled"></i>
                          <?php echo e($langg->lang78); ?></a>
                      </li>
                      <?php elseif($productt->sum_stock == 0): ?>
                      <li class="addtocart">
                        <a href="javascript:;" class="cart-out-of-stock">
                          <i class="icofont-close-circled"></i>
                          <?php echo e($langg->lang78); ?></a>
                      </li>
                      <?php else: ?>
                      <li class="addtocart">
                        <a href="javascript:;" id="addcrt">BUY NOW</a>
                      </li>

                      <!-- <li class="addtocart">
                        <a id="qaddcrt" href="javascript:;">
                          <i class="icofont-cart"></i><?php echo e($langg->lang251); ?>

                        </a>
                      </li> -->
                      <?php endif; ?>

                      <?php endif; ?>

                      <?php if(Auth::guard('web')->check()): ?>
                      <li class="favorite">
                        <a href="javascript:;" class="add-to-wish"
                          data-href="<?php echo e(route('user-wishlist-add',$productt->id)); ?>"><i class="icofont-heart-alt"></i></a>
                      </li>
                      <?php else: ?>
                      <li class="favorite">
                        <a href="javascript:;" data-toggle="modal" data-target="#comment-log-reg"><i
                            class="icofont-heart-alt"></i></a>
                      </li>
                      <?php endif; ?>
                      <!-- <li class="compare">
                        <a href="javascript:;" class="add-to-compare"
                          data-href="<?php echo e(route('product.compare.add',$productt->id)); ?>"><i class="icofont-exchange"></i></a>
                      </li> -->
                    </ul>
                  </div>
                 <!-- <div class="social-links social-sharing a2a_kit a2a_kit_size_32">
                    <ul class="link-list social-links">
                      <li>
                        <a class="facebook a2a_button_facebook" href="">
                          <i class="fab fa-facebook-f"></i>
                        </a>
                      </li>
                     
                      <li>
                        <a class="twitter a2a_button_twitter" href="">
                          <i class="fab fa-twitter"></i>
                        </a>
                      </li>
                      <li>
                       <a class="linkedin a2a_button_linkedin" href="">
                          <i class="fab fa-linkedin-in"></i>
                        </a>
                      </li>
                      <li>
                        <a class="pinterest a2a_button_pinterest" href="">
                          <i class="fab fa-pinterest-p"></i>
                        </a>
                      </li>
                    </ul>
                  </div>-->
                  <script async src="https://static.addtoany.com/menu/page.js"></script>


                  <?php if($productt->ship != null): ?>
                    <p class="estimate-time"><?php echo e($langg->lang86); ?>: <b> <?php echo e($productt->ship); ?></b></p>
                  <?php endif; ?>
                  <?php if( $productt->sku != null ): ?>
                  <p class="p-sku">
                    <?php echo e($langg->lang77); ?>: <span class="idno"><?php echo e($productt->sku); ?></span>
                  </p>
                  <?php endif; ?>
                  
                  
                  
                 <?php if( $productt->category_id != null ): ?> <a href="<?php echo e(route('front.category', $productt->category->slug)); ?>">  <?php echo e($productt->category->name); ?> </a> <?php endif; ?>
                 <?php if( $productt->subcategory_id != null ): ?> - <a href="<?php echo e(route('front.category', [$productt->category->slug, $productt->subcategory->slug])); ?>">  <?php echo e($productt->subcategory->name); ?> </a> <?php endif; ?>
                 <?php if( $productt->childcategory_id != null ): ?> - <a href="<?php echo e(route('front.category', [$productt->category->slug, $productt->subcategory->slug, $productt->childcategory->slug])); ?>"> <?php echo e($productt->childcategory->name); ?> </a>  <?php endif; ?>
                  
                  
                   <?php if($productt->tags != null): ?>
                    <p class="estimate-time"><b>Tags: </b> <span><?php echo !empty($productt->tags) ? implode('</span>, <span>', $productt->tags ): ''; ?></span></p>
                  <?php endif; ?>
                  
                  
                  
                 <!--  <?php if($productt->tags != null): ?>
					  <?php $__currentLoopData = $productt->tags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                        <a class="<?php echo e(isset($tags) ? ($tag == $tags ? 'active' : '') : ''); ?>" href="<?php echo e(route('front.tag',$tag)); ?>">
                            <?php echo e($tag); ?>

                        </a>
                        

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>-->
                  
                   
                 
                  
                  
                  
                  
   <!--    <?php if($gs->is_report): ?>

      

                    <?php if(Auth::guard('web')->check()): ?>

                    <div class="report-area">
                        <a href="javascript:;" data-toggle="modal" data-target="#report-modal"><i class="fas fa-flag"></i> <?php echo e($langg->lang776); ?></a>
                    </div>

                    <?php else: ?>

                    <div class="report-area">
                        <a href="javascript:;" data-toggle="modal" data-target="#comment-log-reg"><i class="fas fa-flag"></i> <?php echo e($langg->lang776); ?></a>
                    </div>
                    <?php endif; ?>

      

      <?php endif; ?> -->



                </div>
              </div>
            </div>

          </div>
         
    </div>
    <div class="col-lg-3">

      <?php if(!empty($productt->whole_sell_qty)): ?>
      <div class="table-area wholesell-details-page">
        <h3><?php echo e($langg->lang770); ?></h3>
        <table class="table">
          <tr>
            <th><?php echo e($langg->lang768); ?></th>
            <th><?php echo e($langg->lang769); ?></th>
          </tr>
          <?php $__currentLoopData = $productt->whole_sell_qty; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $data1): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <tr>
            <td><?php echo e($productt->whole_sell_qty[$key]); ?>+</td>
            <td><?php echo e($productt->whole_sell_discount[$key]); ?>% <?php echo e($langg->lang771); ?></td>
          </tr>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </table>
      </div>
      <?php endif; ?>


     












      <div class="categori  mt-30" style="display:none;">
        <div class="section-top">
            <h2 class="section-title">
                <?php echo e($langg->lang245); ?>

            </h2>
        </div>
                        <div class="hot-and-new-item-slider">

                          <?php $__currentLoopData = $vendors->chunk(3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $chunk): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="item-slide">
                              <ul class="item-list">
                                <?php $__currentLoopData = $chunk; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prod): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                  <?php echo $__env->make('includes.product.list-product', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                              </ul>
                            </div>
                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        </div>

    </div>




    </div>

    </div>
    <div class="row">
      <div class="col-lg-12">

      </div>
    </div>
  </div>






 <!-- Begin Hiraola's Single Product Tab Area -->
        <div class="hiraola-product-tab_area-2 sp-product-tab_area">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="sp-product-tab_nav ">
                            <div class="product-tab">
                                <ul class="nav product-menu">
                                    <li><a class="active" data-toggle="tab" href="#description"><span>Description</span></a>
                                    </li>
                                    <li><a data-toggle="tab" href="#reviews"><span><?php echo e($langg->lang94); ?>(<?php echo e(count($productt->ratings)); ?>)</span></a></li>
                                </ul>
                            </div>
                            <div class="tab-content hiraola-tab_content">
                                <div id="description" class="tab-pane active show" role="tabpanel">
                                    <div class="product-description">
                                        <?php echo $productt->details; ?>

                                                       
      <?php if($productt->youtube != null): ?>              
                    <iframe width="840" height="630"
src="<?php echo e($productt->youtube); ?>">
</iframe>
    <?php endif; ?>          
                                    </div>
                                </div>
                                
                                <div id="reviews" class="tab-pane" role="tabpanel">
                                    <div class="tab-pane active" id="tab-review">
                                      <div class="heading-area">
                          
                          <div class="reating-area">
                            <div class="stars"><h4 class="title">
                            <?php echo e($langg->lang96); ?>

                          </h4><span id="star-rating"><?php echo e(App\Models\Rating::rating($productt->id)); ?></span> <i
                                class="fas fa-star"></i></div>
                          </div>
                        </div>
                        <div id="replay-area">
                          <div id="reviews-section">
                            <?php if(count($productt->ratings) > 0): ?>
                            <ul class="all-replay">
                              <?php $__currentLoopData = $productt->ratings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                              <li>
                                <div class="single-review">
                                  <div class="left-area">
                                    <img
                                      src="<?php echo e($review->user->photo ? asset('assets/images/users/'.$review->user->photo):asset('assets/images/noimage.png')); ?>"
                                      alt="">
                                    <h5 class="name"><?php echo e($review->user->name); ?></h5>
                                    <p class="date">
                                      <?php echo e(Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$review->review_date)->diffForHumans()); ?>

                                    </p>
                                  </div>
                                  <div class="right-area">
                                    <div class="header-area">
                                      <div class="stars-area">
                                        <ul class="stars">
                                          <div class="ratings">
                                            <div class="empty-stars"></div>
                                            <div class="full-stars" style="width:<?php echo e($review->rating*20); ?>%"></div>
                                          </div>
                                        </ul>
                                      </div>
                                    </div>
                                    <div class="review-body">
                                      <p>
                                        <?php echo e($review->review); ?>

                                      </p>
                                      <p>
                                        <a href="<?php echo e(asset('assets/images/review/'.$review->image)); ?>" target="_BLANK"><img src="<?php echo e(asset('assets/images/review/'.$review->image)); ?>" width="50px"></a>
                                      </p>
                                    </div>
                                  </div>
                                </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                              </li>
                            </ul>
                            <?php else: ?>
                            <p><?php echo e($langg->lang97); ?></p>
                            <?php endif; ?>
                          </div>
                          <?php if(Auth::guard('web')->check()): ?>
                          <div class="review-area" style="display: none;">
                            <h4 class="title"><?php echo e($langg->lang98); ?></h4>
                            <div class="star-area">
                              <ul class="star-list">
                                <li class="stars" data-val="1">
                                  <i class="fas fa-star"></i>
                                </li>
                                <li class="stars" data-val="2">
                                  <i class="fas fa-star"></i>
                                  <i class="fas fa-star"></i>
                                </li>
                                <li class="stars" data-val="3">
                                  <i class="fas fa-star"></i>
                                  <i class="fas fa-star"></i>
                                  <i class="fas fa-star"></i>
                                </li>
                                <li class="stars" data-val="4">
                                  <i class="fas fa-star"></i>
                                  <i class="fas fa-star"></i>
                                  <i class="fas fa-star"></i>
                                  <i class="fas fa-star"></i>
                                </li>
                                <li class="stars active" data-val="5">
                                  <i class="fas fa-star"></i>
                                  <i class="fas fa-star"></i>
                                  <i class="fas fa-star"></i>
                                  <i class="fas fa-star"></i>
                                  <i class="fas fa-star"></i>
                                </li>
                              </ul>
                            </div>
                          </div>
                          <!-- <div class="write-comment-area" style="display: none;">
                            <div class="gocover"
                              style="background: url(<?php echo e(asset('assets/images/'.$gs->loader)); ?>) no-repeat scroll center center rgba(45, 45, 45, 0.5);">
                            </div>
                            <form id="reviewform" action="<?php echo e(route('front.review.submit')); ?>"
                              data-href="<?php echo e(route('front.reviews',$productt->id)); ?>" method="POST">
                              <?php echo $__env->make('includes.admin.form-both', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                              <?php echo e(csrf_field()); ?>

                              <input type="hidden" id="rating" name="rating" value="5">
                              <input type="hidden" name="user_id" value="<?php echo e(Auth::guard('web')->user()->id); ?>">
                              <input type="hidden" name="product_id" value="<?php echo e($productt->id); ?>">
                              <div class="row">
                                <div class="col-lg-12">
                                  <textarea name="review" placeholder="<?php echo e($langg->lang99); ?>" required=""></textarea>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-lg-12">
                                  <button class="submit-btn" type="submit"><?php echo e($langg->lang100); ?></button>
                                </div>
                              </div>
                            </form>
                          </div> -->
                          <?php else: ?>
                          <!-- <div class="row">
                            <div class="col-lg-12">
                              <br>
                              <h5 class="text-center"><a href="javascript:;" data-toggle="modal" data-target="#comment-log-reg"
                                  class="btn login-btn mr-1"><?php echo e($langg->lang101); ?></a> <?php echo e($langg->lang102); ?></h5>
                              <br>
                            </div>
                          </div> -->
                          <?php endif; ?>
                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Hiraola's Single Product Tab Area End Here -->








<div class="hiraola-product-tab_area-2" style="margin-bottom : 40px;">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="product-tab">
                            <div class="hiraola-tab_title">
                               <h4><?php echo e($langg->lang216); ?></h4>
                            </div>
                        </div>
                        
                        <div class="shop-product-wrap grid gridview-4 home-4productsrow row mt-10">
                               	<?php $__currentLoopData = $productt->category->products()->where('status','=',1)->where('id','!=',$productt->id)->take(8)->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prod): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <?php echo $__env->make('includes.product.slider-product', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                         </div>
                    </div>
                </div>
            </div>
        </div>





        <div class="message-modal">
          <div class="modal" id="vendorform" tabindex="-1" role="dialog" aria-labelledby="vendorformLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="vendorformLabel"><?php echo e($langg->lang118); ?></h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <div class="container-fluid p-0">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="contact-form">
                          <form id="emailreply1">
                            <?php echo e(csrf_field()); ?>

                            <ul>
                              <li>
                                <input type="text" class="input-field" id="subj1" name="subject"
                                  placeholder="<?php echo e($langg->lang119); ?>" required="">
                              </li>
                              <li>
                                <textarea class="input-field textarea" name="message" id="msg1"
                                  placeholder="<?php echo e($langg->lang120); ?>" required=""></textarea>
                              </li>
                              <input type="hidden"  name="type" value="Ticket">
                            </ul>
                            <button class="submit-btn" id="emlsub" type="submit"><?php echo e($langg->lang118); ?></button>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
        </div>
  


  <?php if(Auth::guard('web')->check()): ?>

  <?php if($productt->user_id != 0): ?>

  


  <div class="modal" id="vendorform1" tabindex="-1" role="dialog" aria-labelledby="vendorformLabel1" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="vendorformLabel1"><?php echo e($langg->lang118); ?></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="container-fluid p-0">
            <div class="row">
              <div class="col-md-12">
                <div class="contact-form">
                  <form id="emailreply">
                    <?php echo e(csrf_field()); ?>

                    <ul>

                      <li>
                        <input type="text" class="input-field" readonly=""
                          placeholder="Send To <?php echo e($productt->user->shop_name); ?>" readonly="">
                      </li>

                      <li>
                        <input type="text" class="input-field" id="subj" name="subject"
                          placeholder="<?php echo e($langg->lang119); ?>" required="">
                      </li>

                      <li>
                        <textarea class="input-field textarea" name="message" id="msg"
                          placeholder="<?php echo e($langg->lang120); ?>" required=""></textarea>
                      </li>

                      <input type="hidden" name="email" value="<?php echo e(Auth::guard('web')->user()->email); ?>">
                      <input type="hidden" name="name" value="<?php echo e(Auth::guard('web')->user()->name); ?>">
                      <input type="hidden" name="user_id" value="<?php echo e(Auth::guard('web')->user()->id); ?>">
                      <input type="hidden" name="vendor_id" value="<?php echo e($productt->user->id); ?>">

                    </ul>
                    <button class="submit-btn" id="emlsub1" type="submit"><?php echo e($langg->lang118); ?></button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>


  


  <?php endif; ?>

  <?php endif; ?>

</div>


<?php if($gs->is_report): ?>

<?php if(Auth::check()): ?>



<div class="modal fade" id="report-modal" tabindex="-1" role="dialog" aria-labelledby="report-modal-Title" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

 <div class="gocover" style="background: url(<?php echo e(asset('assets/images/'.$gs->loader)); ?>) no-repeat scroll center center rgba(45, 45, 45, 0.5);"></div>

                    <div class="login-area">
                        <div class="header-area forgot-passwor-area">
                            <h4 class="title"><?php echo e($langg->lang777); ?></h4>
                            <p class="text"><?php echo e($langg->lang778); ?></p>
                        </div>
                        <div class="login-form">

                            <form id="reportform" action="<?php echo e(route('product.report')); ?>" method="POST">

                              <?php echo $__env->make('includes.admin.form-login', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                                <?php echo e(csrf_field()); ?>

                                <input type="hidden" name="user_id" value="<?php echo e(Auth::user()->id); ?>">
                                <input type="hidden" name="product_id" value="<?php echo e($productt->id); ?>">
                                <div class="form-input">
                                    <input type="text" name="title" class="User Name" placeholder="<?php echo e($langg->lang779); ?>" required="">
                                    <i class="icofont-notepad"></i>
                                </div>

                                <div class="form-input">
                                  <textarea name="note" class="User Name" placeholder="<?php echo e($langg->lang780); ?>" required=""></textarea>
                                </div>

                                <button type="submit" class="submit-btn"><?php echo e($langg->lang196); ?></button>
                            </form>
                        </div>
                    </div>
      </div>
    </div>
  </div>
</div>



<?php endif; ?>

<?php endif; ?>

<?php $__env->stopSection(); ?>


<?php $__env->startSection('scripts'); ?>

<script type="text/javascript">

  $(document).on("submit", "#emailreply1", function () {
    var token = $(this).find('input[name=_token]').val();
    var subject = $(this).find('input[name=subject]').val();
    var message = $(this).find('textarea[name=message]').val();
    var $type  = $(this).find('input[name=type]').val();
    $('#subj1').prop('disabled', true);
    $('#msg1').prop('disabled', true);
    $('#emlsub').prop('disabled', true);
    $.ajax({
      type: 'post',
      url: "<?php echo e(URL::to('/user/admin/user/send/message')); ?>",
      data: {
        '_token': token,
        'subject': subject,
        'message': message,
        'type'   : $type
      },
      success: function (data) {
        $('#subj1').prop('disabled', false);
        $('#msg1').prop('disabled', false);
        $('#subj1').val('');
        $('#msg1').val('');
        $('#emlsub').prop('disabled', false);
        if(data == 0)
          toastr.error("Oops Something Goes Wrong !!");
        else
          toastr.success("Message Sent !!");
        $('.close').click();
      }

    });
    return false;
  });

</script>


<script type="text/javascript">

  $(document).on("submit", "#emailreply", function () {
    var token = $(this).find('input[name=_token]').val();
    var subject = $(this).find('input[name=subject]').val();
    var message = $(this).find('textarea[name=message]').val();
    var email = $(this).find('input[name=email]').val();
    var name = $(this).find('input[name=name]').val();
    var user_id = $(this).find('input[name=user_id]').val();
    var vendor_id = $(this).find('input[name=vendor_id]').val();
    $('#subj').prop('disabled', true);
    $('#msg').prop('disabled', true);
    $('#emlsub').prop('disabled', true);
    $.ajax({
      type: 'post',
      url: "<?php echo e(URL::to('/vendor/contact')); ?>",
      data: {
        '_token': token,
        'subject': subject,
        'message': message,
        'email': email,
        'name': name,
        'user_id': user_id,
        'vendor_id': vendor_id
      },
      success: function () {
        $('#subj').prop('disabled', false);
        $('#msg').prop('disabled', false);
        $('#subj').val('');
        $('#msg').val('');
        $('#emlsub').prop('disabled', false);
        toastr.success("<?php echo e($langg->message_sent); ?>");
        $('.ti-close').click();
      }
    });
    return false;
  });

</script>
<script type="text/javascript">

    $('#notifyform').on('submit',function(event){
        event.preventDefault();        
        let email = $('#email').val();
        let product_id = $('#product_id').val();

        $.ajax({
          url: "notify",
          type:"POST",
          data:{
            "_token": "<?php echo e(csrf_token()); ?>",           
            email:email,product_id:product_id,            
          },
          success:function(response){
            //alert(response);
             $("p.successmsg").html(response);
          },
         });
        });
      </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.front', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>