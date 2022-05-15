<?php $__env->startSection('content'); ?>

<section class="user-dashbord">
    <div class="container">
        <div class="row">
            <?php echo $__env->make('includes.user-dashboard-sidebar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <div class="col-lg-8">
                <div class="user-profile-details">
                    <div class="order-details">

                        


                        <div class="header-area">
                            <h4 class="title">
                                <?php echo e(__('Exchange Details')); ?>

                            </h4>
                        </div>
                        <div class="view-order-page">
                          <div class="row">  											
                                                    <div class="col-md-4">
                                                    <div class="table-responsive show-table">
                                                        <table class="table">
                                                        <tr>
                                                            <th><?php echo e(__("Exchange Id#")); ?></th>
                                                            <td><?php echo e($data->id); ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th><?php echo e(__("Vendor Name")); ?></th>
															<?php
                                        $user = App\Models\User::find($data->vendor_id);
                                        ?>
                                                            <td><?php echo e($user->name); ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th><?php echo e(__("Order Id")); ?></th>
                                                            <td><?php echo e($data->order_id); ?></td>
                                                        </tr>                                                       
                                                            <tr>
                                                                <th><?php echo e(__("Product Name")); ?></th>
                                                                <td><?php echo e($data->product_name); ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th><?php echo e(__("Product SKU")); ?></th>
                                                                <td><?php echo e($data->product_sku); ?></td>
                                                            </tr>															

                                                        </table>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                    <div class="table-responsive show-table">
                                                    <table class="table"> 
                                                      												
                                                           
                                                            <!--tr>
                                                                <th><?php echo e(__("Amount")); ?></th>
                                                                <td><?php echo e($data->amount); ?></td>
                                                            </tr-->
                                                            <tr>
                                                                <th><?php echo e(__("Quantity")); ?></th>
                                                                <td><?php echo e($data->quantity); ?></td>
                                                            </tr>
                                                        <?php if($data->companyname): ?>
															<tr>
                                                                <th><?php echo e(__("Courier Name")); ?></th>
                                                                <td><?php echo e($data->companyname); ?></td>
                                                            </tr>
															<?php endif; ?>
															<?php if($data->title): ?>
                                                           <tr>
                                                                <th><?php echo e(__("Tracking Code")); ?></th>
                                                                <td><?php echo e($data->title); ?></td>
                                                            </tr>
															<?php endif; ?>
															<?php if($data->text): ?>
                                                           <tr>
                                                                <th><?php echo e(__("Tracking URL")); ?></th>
                                                                <td><?php echo e($data->text); ?></td>
                                                            </tr>
															<?php endif; ?>															
                                                            <tr>
                                                                <th><?php echo e(__("Exchange Date")); ?></th>
                                                                <td><?php echo e($data->created_at); ?></td>
                                                            </tr>
                                                            
                                                           
                                                        </table>
                                                        </div>
                                                    </div>			
													
															  
                                                        </div>
														
														<div class="row">
														<h4>Screen Shot :- </h4>
														<?php $scrimage=array();
										                      $temp=explode(',',$data->screen_shot);
															  foreach($temp as $image){
                                                              $images[]=trim( str_replace( array('[',']') ,"" ,$image ) );
                                                                }
                                                                  $j=1;
                                                               foreach($images as $image){ ?>
															   <div class="col-md-2">
                                                        <div class="user-image">
															   <a href="<?php echo e(asset('assets/images/screenshot/'.$image)); ?>" download>Screen Shot <?php echo e($j); ?></a>
															   </div>
														
														
                                                    </div>
                                                           <?php $j++; }
                                                           ?>													
													
                                                </div>
												<br>  
                </div>
            </div>
        </div>
    </div>
	  </div>
        </div>    
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.front', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>