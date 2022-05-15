<?php $__env->startSection('content'); ?>





<div class="add-product-content1">
    <div class="row">
        <div class="col-lg-12">
            <div class="product-description">
                <div class="body-area">
                    <div class="gocover" style="background: url(<?php echo e(asset('assets/images/'.$gs->admin_loader)); ?>) no-repeat scroll center center rgba(45, 45, 45, 0.5);"></div>
                <input type="hidden" id="vendor-track-store" value="<?php echo e(route('vendor-order-track-store')); ?>">
                <form id="trackform" action="<?php echo e(route('vendor-order-track-store')); ?>" method="POST" enctype="multipart/form-data">
                    <?php echo e(csrf_field()); ?>

                    <?php echo $__env->make('includes.vendor.form-both', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>  
                    <input type="hidden" name="vid" value="<?php echo e($orderdata->id); ?>">
                    <input type="hidden" name="pid" value="<?php echo e($orderdata->product_id); ?>">					
                    <input type="hidden" name="order_id" value="<?php echo e($order->id); ?>">
                    <input type="hidden" name="vendor_id" value="<?php echo e($user->id); ?>">
					<?php
						$orderid=$order->id;
                        $vdetails = App\Models\VendorOrder::all()->where('order_id',$orderid)->where('user_id',$user->id);									
                        ?>
						 <?php  
                                              if($vdetails) {
                                              foreach($vdetails as $item){
                                                 
                                                if($item->status) {
                                                       $status= $item->status;
                                                 }
                                              }
                                           }
                                          
                                         ?>
						
					 <input type="hidden" name="status" value="<?php echo e($status); ?>">
                    <div class="row">
                        <div class="col-lg-5">
                            <div class="left-area">
                                    <h4 class="heading"><?php echo e(__('Courier Name')); ?> *</h4>
                            </div>
                        </div>
                        <div class="col-lg-7">
                            <input type="text" class="input-field companyname" id="companyname" name="companyname" placeholder="<?php echo e(__('Courier Name')); ?>" value="" required="">
                            <!--<textarea class="input-field" id="companyname" name="companyname" placeholder="<?php echo e(__('Company')); ?>" required=""></textarea>-->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-5">
                            <div class="left-area">
                                    <h4 class="heading"><?php echo e(__('Tracking Code')); ?> *</h4>
                            </div>
                        </div>
                        <div class="col-lg-7">
                            <input type="text" class="input-field track-title" id="track-title" name="title" placeholder="<?php echo e(__('Tracking Code')); ?>" value="" required="">
                            <!--<textarea class="input-field" id="track-title" name="title" placeholder="<?php echo e(__('Title')); ?>" required=""></textarea>-->
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-lg-5">
                            <div class="left-area">
                                    <h4 class="heading"><?php echo e(__('Tracking URL')); ?> *</h4>
                            </div>
                        </div>
                        <div class="col-lg-7">
                            <input type="text" class="input-field track-details" id="track-details" name="text" placeholder="<?php echo e(__('Tracking URL')); ?>" value="" required="">
                            <!--<textarea class="input-field" id="track-details" name="text" placeholder="<?php echo e(__('Details')); ?>" required=""></textarea>-->
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-5">
                            <div class="left-area">
                                
                            </div>
                        </div>
                        <div class="col-lg-7">
                            <button class="addProductSubmit-btn" id="track-btn" type="submit"><?php echo e(__('ADD')); ?></button>
                            <button class="addProductSubmit-btn ml=3 d-none" id="cancel-btn" type="button"><?php echo e(__('Cancel')); ?></button>
                            <input type="hidden" id="add-text" value="<?php echo e(__('ADD')); ?>">
                            <input type="hidden" id="edit-text" value="<?php echo e(__('UPDATE')); ?>">
                        </div>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
</div>

<hr>
<h5 class="text-center">TRACKING DETAILS</h5>
<hr>



						<div class="content-area no-padding">
							<div class="add-product-content1">
								<div class="row">
									<div class="col-lg-12">
										<div class="product-description">
											<div class="body-area">


                                    <div class="table-responsive show-table ml-3 mr-3">
                                        <table class="table" id="track-load" data-href="<?php echo e(route('vendor-order-track-load',$order->id)); ?>">
                                            <tr>
                                                <th width="15%"><?php echo e(__("Courier Name")); ?></th>
                                                <th width="15%"><?php echo e(__("Tracking Code")); ?></th>
                                                <th width="45%"><?php echo e(__("Tracking URL")); ?></th>
                                                <th width="15%" style="width:15%;"><?php echo e(__("Date")); ?></th>
                                              <!--  <th><?php echo e(__("Time")); ?></th>-->
                                                <th><?php echo e(__("Options")); ?></th>
                                            </tr>
                                            <?php $__currentLoopData = $order->tracks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $track): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                              <?php if($track->vendor_id == $user->id && $track->vid == $orderdata->id ): ?>
                                            <tr data-id="<?php echo e($track->id); ?>">
                                                <td width="15%" class="t-companyname"><?php echo e($track->companyname); ?></td>
                                                <td width="15%" class="t-title"><?php echo e($track->title); ?></td>
                                                <td width="45%" class="t-text"><?php echo e($track->text); ?></td>
                                                <td  width="15%"><?php echo e(date('d-M-Y',strtotime($track->created_at))); ?></td>
                                             <!--   <td><?php echo e(date('h:i:s:a',strtotime($track->created_at))); ?></td>-->
                                                <td>
                                                    <div class="action-list">
                                                        <a data-href="<?php echo e(route('vendor-order-track-update',$track->id)); ?>" class="track-edit"> <i class="fas fa-edit"></i>Edit</a>
                                                        <a href="javascript:;" data-href="<?php echo e(route('vendor-order-track-delete',$track->id)); ?>" class="track-delete"><i class="fas fa-trash-alt"></i></a>
                                                    </div>
                                                </td>
                                            </tr>
											<?php endif; ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </table>
                                    </div>


											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.load', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>