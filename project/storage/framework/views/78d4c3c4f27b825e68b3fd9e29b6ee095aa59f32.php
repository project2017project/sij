                        <?php if(isset($order)): ?>
                    <div class="tracking-steps-area">
                            
                    
                            
                            <?php if(count($order->tracks)>0 || count($notification)>0 ): ?>
                            <!--<ul class="tracking-steps">
                                
                                    <?php $__currentLoopData = $order->tracks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $track): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li class="<?php echo e(in_array($track->title, $datas) ? 'active' : ''); ?>">
                                            <div class="icon"><?php echo e($loop->index + 1); ?></div>
                                            <div class="content">
                                                    <h4 class="title"><?php echo e(ucwords($track->title)); ?></h4>
                                                    <p class="date"><?php echo e(date('d/M/Y',strtotime($track->created_at))); ?></p>
                                                    <p class="details" ><a target="_BLANK" href="<?php echo e($track->text); ?>"><?php echo e($track->text); ?></a></p>
                                                    
                                                    <p class="details"><?php echo e($track->companyname); ?></p>
                                            </div>
								  <form id="sendinvoice" action="<?php echo e(route('front-order-invoice',$track->id)); ?>" class="sendinvoice" method="POST" enctype="multipart/form-data"> 
                                   <?php echo e(csrf_field()); ?>								  
                                  <input type="hidden" id="order-id" value="<?php echo e($track->order_id); ?>">
                                  <button type="submit" class="mybtn1">Send Invoice</button>            
                                  </form>											
                                        </li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    
                                    </ul>-->
                                    <ul class="tracking-steps">
                                         <li class="<?php echo e(in_array($track->title, $datas) ? 'active' : ''); ?>">
									     <div class="icon"> </div>
                                            <div class="content">
                                                    <h4 class="title">Order Number : <?php echo e($order->order_number); ?>  <?php echo e(date('d-M-Y',strtotime($order->created_at))); ?></h4>
                                                    <p class="details" >Your order has been received</p>
                                                    
                                                   
                                            </div>
								
									</li>
									 <?php $__currentLoopData = $notification; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notify): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									 
									 <li class="<?php echo e(in_array($track->title, $datas) ? 'active' : ''); ?>">
									     <div class="icon"> </div>
                                            <div class="content">
                                                    <h4 class="title">Order Note <?php echo e(date('d-M-Y',strtotime($track->created_at))); ?></h4>
                                                    <p class="details" ><?php echo html_entity_decode($notify->message);?></p>
                                                    
                                                   
                                            </div>
								
									</li>
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </ul>                                

                                
                                
                                <?php else: ?>
                                    <h3 class="text-center">No Tracking Info available, check later</h3>
                                <?php endif; ?>
                                
                    </div>


                        <?php else: ?> 
                        <h3 class="text-center"><?php echo e($langg->lang775); ?></h3>
                        <?php endif; ?>          