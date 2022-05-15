<?php $__env->startSection('content'); ?>
<!-- User Dashbord Area Start -->
<section class="user-dashbord">
    <div class="container">
        <div class="row">
            <?php echo $__env->make('includes.user-dashboard-sidebar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <div class="col-lg-8">
                <div class="user-profile-details">
                    <div class="order-details">

                        <div class="process-steps-area">
                            <?php echo $__env->make('includes.order-process', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                        </div>


                        <div class="header-area">
                            <h4 class="title">
                                <?php echo e($langg->lang284); ?>

                            </h4>
                        </div>
                        <div class="view-order-page">
                            <h3 class="order-code"><?php echo e($langg->lang285); ?> <?php echo e($order->order_number); ?> [<?php echo e($order->status); ?>]
                            </h3>
                            <div class="print-order text-right">
                                <a href="<?php echo e(route('user-order-print',$order->id)); ?>" target="_blank"
                                    class="print-order-btn">
                                    <i class="fa fa-print"></i> INVOICE
                                </a>
                            </div>
                            <p class="order-date"><?php echo e($langg->lang301); ?> <?php echo e(date('d-M-Y',strtotime($order->created_at))); ?>

                            </p>

                            <?php if($order->dp == 1): ?>

                            <div class="billing-add-area">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h5><?php echo e($langg->lang287); ?></h5>
                                        <address>
                                            <?php echo e($langg->lang288); ?> <?php echo e($order->customer_name); ?><br>
                                            <?php echo e($langg->lang289); ?> <?php echo e($order->customer_email); ?><br>
                                            <?php echo e($langg->lang290); ?> <?php echo e($order->customer_phone); ?><br>
                                            <?php echo e($langg->lang291); ?> <?php echo e($order->customer_address); ?><br>
                                            <?php if($order->order_note != null): ?>
                                            <?php echo e($langg->lang801); ?>: <?php echo e($order->order_note); ?><br>
                                            <?php endif; ?>
                                            <?php echo e($order->customer_city); ?>-<?php echo e($order->customer_zip); ?>

                                        </address>
                                    </div>
                                    <div class="col-md-6">
                                        <h5><?php echo e($langg->lang292); ?></h5>

                                        <p><?php echo e($langg->lang798); ?>:
                                             <?php echo $order->payment_status == 'Pending' ? "<span class='badge badge-danger'>". $langg->lang799 ."</span>":"<span class='badge badge-success'>". $langg->lang800 ."</span>"; ?>

                                        </p>

                                        <p><?php echo e($langg->lang293); ?>

                                            <?php echo e($order->currency_sign); ?><?php echo e(round($order->pay_amount * $order->currency_value , 2)); ?>

                                        </p>
                                        <p><?php echo e($langg->lang294); ?> <?php echo e($order->method); ?></p>

                                        <?php if($order->method != "Cash On Delivery"): ?>
                                        <?php if($order->method=="Stripe"): ?>
                                        <?php echo e($order->method); ?> <?php echo e($langg->lang295); ?> <p><?php echo e($order->charge_id); ?></p>
                                        <?php endif; ?>
                                        <?php echo e($order->method); ?> <?php echo e($langg->lang296); ?> <p id="ttn"><?php echo e($order->txnid); ?></p>
                                        <a id="tid" style="cursor: pointer;" class="mybtn2"><?php echo e($langg->lang297); ?></a> 

                                        <form id="tform">
                                            <input style="display: none; width: 100%;" type="text" id="tin" placeholder="<?php echo e($langg->lang299); ?>" required="" class="mb-3">
                                            <input type="hidden" id="oid" value="<?php echo e($order->id); ?>">

                                            <button style="display: none; padding: 5px 15px; height: auto; width: auto; line-height: unset;" id="tbtn" type="submit" class="mybtn1"><?php echo e($langg->lang300); ?></button>
                                                
                                                <a style="display: none; cursor: pointer;  padding: 5px 15px; height: auto; width: auto; line-height: unset;" id="tc"  class="mybtn1"><?php echo e($langg->lang298); ?></a>
                                                
                                                
                                        </form>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>

                            <?php else: ?>
                            <div class="shipping-add-area">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h5><?php echo e($langg->lang302); ?></h5>
                                        <address>
                                            <?php echo e($langg->lang288); ?>

                                            <?php echo e($order->shipping_name == null ? $order->customer_name : $order->shipping_name); ?><br>
                                            <?php echo e($langg->lang289); ?>

                                            <?php echo e($order->shipping_email == null ? $order->customer_email : $order->shipping_email); ?><br>
                                            <?php echo e($langg->lang290); ?>

                                            <?php echo e($order->shipping_phone == null ? $order->customer_phone : $order->shipping_phone); ?><br>
                                            <?php echo e($langg->lang291); ?>

                                            <?php echo e($order->shipping_address == null ? $order->customer_address : $order->shipping_address); ?><br>
                                            <?php echo e($order->shipping_city == null ? $order->customer_city : $order->shipping_city); ?>-<?php echo e($order->shipping_zip == null ? $order->customer_zip : $order->shipping_zip); ?>

                                        </address>
                                       

                                    </div>
                                    
                                </div>
                            </div>
                            <div class="billing-add-area">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h5><?php echo e($langg->lang287); ?></h5>
                                        <address>
                                            <?php echo e($langg->lang288); ?> <?php echo e($order->customer_name); ?><br>
                                            <?php echo e($langg->lang289); ?> <?php echo e($order->customer_email); ?><br>
                                            <?php echo e($langg->lang290); ?> <?php echo e($order->customer_phone); ?><br>
                                            <?php echo e($langg->lang291); ?> <?php echo e($order->customer_address); ?><br>
                                            <?php if($order->order_note != null): ?>
                                            <?php echo e($langg->lang801); ?>: <?php echo e($order->order_note); ?><br>
                                            <?php endif; ?>
                                            <?php echo e($order->customer_city); ?>-<?php echo e($order->customer_zip); ?>

                                        </address>
                                    </div>
                                    <div class="col-md-6">
                                        <h5><?php echo e($langg->lang292); ?></h5>

                                        <p><?php echo e($langg->lang798); ?>

                                             <?php echo $order->payment_status == 'Pending' ? "<span class='badge badge-danger'>". $langg->lang799 ."</span>":"<span class='badge badge-success'>". $langg->lang800 ."</span>"; ?>

                                        </p>



                                        <p><?php echo e($langg->lang293); ?>

                                            <?php echo e($order->currency_sign); ?><?php echo e(round($order->pay_amount * $order->currency_value , 2)); ?>

                                        </p>
                                        <p><?php echo e($langg->lang294); ?> <?php echo e($order->method); ?></p>
                                        	<?php
                                            $ship_cost = $order->shipping_cost + $order->packing_cost;
                                            ?>
                                        
                                        <p>
                                            Shipping Cost : <?php if($ship_cost == 0): ?>Free Shipping <?php else: ?><?php echo e(App\Models\Currency::where('sign',$order->currency_sign)->first()->name); ?> <?php echo e(round($ship_cost, 2)); ?> <?php endif; ?>
                                        </p>

                                        <?php if($order->method != "Cash On Delivery"): ?>
                                        <?php if($order->method=="Stripe"): ?>
                                        <?php echo e($order->method); ?> <?php echo e($langg->lang295); ?> <p><?php echo e($order->charge_id); ?></p>
                                        <?php endif; ?>
                                        <!--<?php echo e($order->method); ?> <?php echo e($langg->lang296); ?> <p id="ttn"> <?php echo e($order->txnid); ?></p>-->

                                       <!-- <a id="tid" style="cursor: pointer;" class="mybtn2"><?php echo e($langg->lang297); ?></a> 

                                        <form id="tform">
                                            <input style="display: none; width: 100%;" type="text" id="tin" placeholder="<?php echo e($langg->lang299); ?>" required="" class="mb-3">
                                            <input type="hidden" id="oid" value="<?php echo e($order->id); ?>">

                                            <button style="display: none; padding: 5px 15px; height: auto; width: auto; line-height: unset;" id="tbtn" type="submit" class="mybtn1"><?php echo e($langg->lang300); ?></button>
                                                
                                                <a style="display: none; cursor: pointer;  padding: 5px 15px; height: auto; width: auto; line-height: unset;" id="tc"  class="mybtn1"><?php echo e($langg->lang298); ?></a>
                                                
                                                
                                        </form>-->
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <?php endif; ?>
                            <br>




                            <div class="table-responsive">
                                <h5><?php echo e($langg->lang308); ?></h5>
                                <table class="table table-bordered veiw-details-table">
                                    <thead>
                                        <tr>
                                           <!-- <th width="5%"><?php echo e($langg->lang309); ?></th>-->
                                            <th>Image</th>
                                            <th width="35%"><?php echo e($langg->lang310); ?></th>
                                            <th width="20%"><?php echo e($langg->lang539); ?></th>
                                            <th><?php echo e($langg->lang314); ?></th>
                                            <th><?php echo e($langg->lang315); ?></th>
                                           <!-- <th>Review</th>-->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                        <?php $__currentLoopData = $cart->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                       <?php if($product['item']['user_id'] != 0): ?>
                                                <?php
                                                $user = App\Models\User::find($product['item']['user_id']);
                                                $productsku = App\Models\Product::find($product['item']['id']);
                                                ?>
												<?php endif; ?>
                                        
                                        <tr>
                                           <!-- <td><?php echo e($product['item']['id']); ?></td>-->
                                            <td><img src="../../assets/images/products/<?php echo e($product['item']['photo']); ?> " style="width: 40px;"></td>
                                            <td>
                                                <input type="hidden" value="<?php echo e($product['license']); ?>">
                                                

                                                <?php if($product['item']['user_id'] != 0): ?>
                                                <?php
                                                $user = App\Models\User::find($product['item']['user_id']);
                                                ?>
                                                <?php if(isset($user)): ?>
                                                <a class="inline-btn" target="_blank"
                                                    href="<?php echo e(route('front.product', $product['item']['slug'])); ?>"><?php echo e($product['item']['name']); ?> x <?php echo e($product['qty']); ?> <?php echo e($product['item']['measure']); ?></a><br> 
                    <span><?php echo e('SKU : '.$productsku->sku); ?></span> <br />
                    <span><?php echo e('Sold By :'. $user->name); ?></span>
                                                <?php else: ?>
                                                <a class="inline-btn" target="_blank"
                                                    href="<?php echo e(route('front.product', $product['item']['slug'])); ?>"><?php echo e($product['item']['name']); ?> x <?php echo e($product['qty']); ?> <?php echo e($product['item']['measure']); ?></a><br> 
                    <span><?php echo e('SKU : '.$productsku->sku); ?></span> <br />
                    <span><?php echo e('Sold By :'. $user->name); ?></span>
                                                <?php endif; ?>
                                                <?php else: ?>

                                                <a target="_blank" class="d-block"
                                                    href="<?php echo e(route('front.product', $product['item']['slug'])); ?>"><?php echo e(mb_strlen($product['item']['name'],'utf-8') > 30 ? mb_substr($product['item']['name'],0,30,'utf-8').'...' : $product['item']['name']); ?></a>

                                                <?php endif; ?>
                                                <?php if($product['item']['type'] != 'Physical'): ?>
                                                <?php if($order->payment_status == 'Completed'): ?>
                                                <?php if($product['item']['file'] != null): ?>
                                                <a href="<?php echo e(route('user-order-download',['slug' => $order->order_number , 'id' => $product['item']['id']])); ?>"
                                                    class="btn btn-sm btn-primary mt-1">
                                                    <i class="fa fa-download"></i> <?php echo e($langg->lang316); ?>

                                                </a>
                                                <?php else: ?>
                                                <a target="_blank" href="<?php echo e($product['item']['link']); ?>"
                                                    class="btn btn-sm btn-primary mt-1">
                                                    <i class="fa fa-download"></i> <?php echo e($langg->lang316); ?>

                                                </a>
                                                <?php endif; ?>
                                                <?php if($product['license'] != ''): ?>
                                                <a href="javascript:;" data-toggle="modal" data-target="#confirm-delete"
                                                    class="btn btn-sm btn-info product-btn mt-1" id="license"><i
                                                        class="fa fa-eye"></i> <?php echo e($langg->lang317); ?></a>
                                                <?php endif; ?>
                                                <?php endif; ?>
                                                <?php endif; ?>
                                            </td>
                                            <td>     <?php
                                       $refundqty = App\Models\VendorOrder::where('order_id','=',$order->id)->where('user_id','=',$product['item']['user_id'])->where('product_id','=',$product['item']['id'])->first();
                                        ?>
                                        <p>
                                                <b><?php echo e($langg->lang311); ?></b>: <?php echo e($product['qty']); ?> <br> </p>
                                                
                                                
                                                <?php if(!empty($refundqty->product_item_qty)): ?>
                                       <p class="text-danger">
                                            <strong><?php echo e(__(' Refund Qty')); ?> :</strong> <?php echo e($refundqty->product_item_qty); ?>

                                       </p>
                                       <?php endif; ?>
                                                
                                                
                                                <?php if(!empty($product['size'])): ?>
                                                <b>Option</b>: <?php echo e($product['item']['measure']); ?><?php echo e(str_replace('-',' ',$product['size'])); ?> <br>
                                                <?php endif; ?>
                                                <?php if(!empty($product['color'])): ?>
                                                <div class="d-flex mt-2">
                                                <b><?php echo e($langg->lang313); ?></b>:  <span id="color-bar" style="border: 10px solid <?php echo e($product['color'] == "" ? "white" : '#'.$product['color']); ?>;"></span>
                                                </div>
                                                <?php endif; ?>

                                                    <?php if(!empty($product['keys'])): ?>

                                                    <?php $__currentLoopData = array_combine(explode(',', $product['keys']), explode(',', $product['values'])); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                                        <b><?php echo e(ucwords(str_replace('_', ' ', $key))); ?> : </b> <?php echo e($value); ?> 
                                                    <?php 
											$pr_at = $product['item']['attributes'];
	                                        $pr_arr = json_decode($pr_at, true);
											?>
											<b> prices : </b><?php echo e($pr_arr [$key]['prices'][0]); ?><br>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                                    <?php endif; ?>

                                                  </td>
                                            <td><?php echo e($order->currency_sign); ?><?php echo e(round($product['item']['price'] * $order->currency_value,2)); ?>

                                            </td>
                                            <td><p><?php echo e($order->currency_sign); ?><?php echo e(round($product['price'] * $order->currency_value,2)); ?></p>
                                            
                                            
                                        
                                         <?php if(!empty($refundqty->product_item_price)): ?>
                                    <p class="text-danger"> <strong>Refund Amount : </strong> <?php echo e($order->currency_sign); ?><?php echo e(round($refundqty->product_item_price * $order->currency_value , 2)); ?></p>
                                    <?php endif; ?>
                                            
                                            
                                            </td>
                                            <!--<td> 
                                            <?php if($order->status == 'completed'): ?> 
                                                <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#myreviewModal">Rate Product</button>
                                            <?php else: ?>

                                            You can rate the product after delivery


                                            <?php endif; ?>
                                                <div class="modal fade" id="myreviewModal" role="dialog">
                                                	<div class="modal-dialog">
                                                		<div class="modal-content">
                                                			<div class="modal-header">
                                                				<button type="button" class="close" data-dismiss="modal">&times;</button>
                                                				<h4 class="modal-title" style="width: 100%; padding-top: 30px; text-align: center;">Order Review</h4>
                                                			</div>
													        <div class="modal-body">
													          <div id="product-details-tab">
                                                                <?php //echo count($prev);?>
                                                                <?php if(count($prev)>0): ?>
                                                                     <?php $__currentLoopData = $prev; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $about): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                     <div class="stars-area">
                                        <ul class="stars">
                                          <div class="ratings">
                          <div class="empty-stars"></div>
                          <div class="full-stars" style="width:<?php echo e(App\Models\Rating::ratings($about->product_id)); ?>%"></div>
                        </div>
                                        </ul>
                                      </div>

                                <p style="float: left; margin-right: 20px;">
                                    <img src="<?php echo e($about->image ? asset('assets/images/review/'.$about->image):asset('assets/images/noimage.png')); ?>" width="50px">
                                </p>

                                    <div class="review-body"><p><?php echo e($about->review); ?></p></div>
                                                                         <?php echo e($about->rating); ?>


                                                                     <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                <?php else: ?>



													            <div id="replay-area">
													            
													            <div class="review-area">
													                <div class="star-area">
													                  <ul class="star-list">
													                    <li class="stars" data-val="1"><i class="fas fa-star"></i></li>
													                    <li class="stars" data-val="2"><i class="fas fa-star"></i><i class="fas fa-star"></i></li>
													                    <li class="stars" data-val="3"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></li>
													                    <li class="stars" data-val="4"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></li>
													                    <li class="stars active" data-val="5"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></li>
													                  </ul>
													                </div>
													              </div>
													             <div class="write-comment-area">
													                <div class="gocover" style="background: url(<?php echo e(asset('assets/images/'.$gs->loader)); ?>) no-repeat scroll center center rgba(45, 45, 45, 0.5);"></div>
													                <form id="reviewform" action="<?php echo e(route('front.review.submit')); ?>" data-href="<?php echo e(route('front.reviews',$product['item']['id'])); ?>" method="POST">
													                  <?php echo $__env->make('includes.admin.form-both', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
													                  <?php echo e(csrf_field()); ?>

													                  <input type="hidden" id="rating" name="rating" value="5">
													                  <input type="hidden" name="user_id" value="<?php echo e(Auth::guard('web')->user()->id); ?>">
													                  <input type="hidden" name="product_id" value="<?php echo e($product['item']['id']); ?>">
													                  <div class="row">
													                    <div class="col-lg-12">
													                      	<textarea name="review" placeholder="<?php echo e($langg->lang99); ?>" required=""></textarea>            	
													                        <input type="file" class="form-control" name="photo"  />
													                    </div>
													                  </div>
													                  <div class="row">
													                    <div class="col-lg-12">
													                      <button class="submit-btn" type="submit"><?php echo e($langg->lang100); ?></button>
													                    </div>
													                  </div>
													                </form>
													              </div>
													              </div>
                                                              <?php endif; ?>
													          </div>
													        </div>
													    </div>
      
												    </div>
												</div>
                                            </td>-->
                                        </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                                <div class="edit-account-info-div">
                                    <div class="form-group">
                                        <a class="back-btn" href="<?php echo e(route('user-orders')); ?>"><?php echo e($langg->lang318); ?></a><!--
                                        <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#myrefundModal">Refund</button>-->
                                        <div class="modal fade" id="myrefundModal" role="dialog">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                <h4 class="modal-title" style="width: 100%; padding-top: 30px; text-align: center;">Refund</h4>
                                                            </div>
                                                            <div class="modal-body">
                                                              <div id="product-details-tab">
                                                                <div id="replay-area">                                                             
                                                                 <div class="write-comment-area">
                                                                    <div class="gocover" style="background: url(<?php echo e(asset('assets/images/'.$gs->loader)); ?>) no-repeat scroll center center rgba(45, 45, 45, 0.5);"></div>
                                                                    
                                                                    <?php if(count($refundcreated)=='0'): ?>
                                                                    <form enctype="multipart/form-data" id="refundform" action="<?php echo e(route('front.refund.submit')); ?>" method="POST">
                                                                      <?php echo $__env->make('includes.admin.form-both', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                                                                      <?php echo e(csrf_field()); ?>

                                                                      <select class="form-control" name="idqtypricename">
                                                                          <option>
                                                                              Select Product For Refund
                                                                          </option>
                                                                          <?php $__currentLoopData = $cart->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                          <option value="<?php echo e($product['item']['id']); ?>/<?php echo e($product['qty']); ?>/<?php echo e(round($product['price'] * $order->currency_value,2)); ?>/<?php echo e($product['item']['user_id']); ?>"><?php echo e($product['item']['name']); ?></option>
                                                                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                      </select>

                                                                      <input type="hidden" id="orderId" name="OrderId" value="<?php echo e($order->id); ?>">
                                                                      <input type="hidden" name="user_id" value="<?php echo e(Auth::guard('web')->user()->id); ?>">
                                                                     <input type="hidden" id="statusare" name="statusare" value="requested">
                                                                      <div class="row">
                                                                        <div class="col-lg-12">
                                                                            <textarea name="review" placeholder="<?php echo e($langg->lang99); ?>" required=""></textarea>              
                                                                        <input type="file" class="form-control" name="refundimage"  />
                                                                        </div>
                                                                      </div>
                                                                      <div class="row">
                                                                        <div class="col-lg-12">
                                                                          <button class="submit-btn" type="submit"><?php echo e($langg->lang100); ?></button>
                                                                        </div>
                                                                      </div>
                                                                    </form>
                                                                    <?php else: ?>

                                                                     
                                                                        <?php $__currentLoopData = $refundcreated; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $refundvalue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                        Customer Comments
                                                                        Product Name        : <?php echo e($refundvalue->product_id); ?>

                                                                        Refund Request ID   : <?php echo e($refundvalue->id); ?>

                                                                        Reason              : <?php echo e($refundvalue->reason); ?>

                                                                        Image               : <?php echo e(asset('assets/images/refund/').$refundvalue->image); ?>

                                                                        Date for request    : <?php echo e($refundvalue->created_at); ?>

                                                                        <?php if($refundvalue->status!='requested'): ?>
                                                                        Status:<?php echo e($refundvalue->status); ?>

                                                                        Admin Comments      : <?php echo e($refundvalue->adminMessage); ?>

                                                                        Date for request    : <?php echo e($refundvalue->updated_at); ?>

                                                                        This request has closed for further details and support email us at info@southindiajewels.com with refund request Id.
                                                                        <?php endif; ?>
                                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                        

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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="modal1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header d-block text-center">
                <h4 class="modal-title d-inline-block"><?php echo e($langg->lang319); ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <p class="text-center"><?php echo e($langg->lang320); ?> <span id="key"></span></p>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-danger" data-dismiss="modal"><?php echo e($langg->lang321); ?></button>
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>


<?php $__env->startSection('scripts'); ?>

<script type="text/javascript">
    $('#example').dataTable({
        "ordering": false,
        'paging': false,
        'lengthChange': false,
        'searching': false,
        'ordering': false,
        'info': false,
        'autoWidth': false,
        'responsive': true
    });
</script>
<script>
    $(document).on("click", "#tid", function (e) {
        $(this).hide();
        $("#tc").show();
        $("#tin").show();
        $("#tbtn").show();
    });
    $(document).on("click", "#tc", function (e) {
        $(this).hide();
        $("#tid").show();
        $("#tin").hide();
        $("#tbtn").hide();
    });
    $(document).on("submit", "#tform", function (e) {
        var oid = $("#oid").val();
        var tin = $("#tin").val();
        $.ajax({
            type: "GET",
            url: "<?php echo e(URL::to('user/json/trans')); ?>",
            data: {
                id: oid,
                tin: tin
            },
            success: function (data) {
                $("#ttn").html(data);
                $("#tin").val("");
                $("#tid").show();
                $("#tin").hide();
                $("#tbtn").hide();
                $("#tc").hide();
            }
        });
        return false;
    });
</script>
<script type="text/javascript">
    $(document).on('click', '#license', function (e) {
        var id = $(this).parent().find('input[type=hidden]').val();
        $('#key').html(id);
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.front', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>