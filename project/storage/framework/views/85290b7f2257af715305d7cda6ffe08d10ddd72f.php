<?php $__env->startSection('styles'); ?>

<style type="text/css">
    .table-responsive {
    overflow-x: hidden;
}
table#example2 {
    margin-left: 10px;
}

</style>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

                    <div class="content-area">
                        <div class="mr-breadcrumb">
                            <div class="row">
                               <div class="col-lg-12">
                      <h4 class="heading"><?php echo e(__('Raise Dispute Details')); ?> <a class="add-btn" href="<?php echo e(route('admin-open-dispute')); ?>"><i class="fas fa-arrow-left"></i> <?php echo e(__('Back')); ?></a></h4>
                      <ul class="links">
                        <li>
                          <a href="<?php echo e(route('admin.dashboard')); ?>"><?php echo e(__('Dashboard')); ?> </a>
                        </li>
                        <li>
                          <a href="javascript:;"><?php echo e(__('Raise Dispute Details')); ?></a>
                        </li>                        
                        
                      </ul>
                  </div>
                            </div>
                        </div>
                            <div class="add-product-content1 customar-details-area">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="product-description">
                                            <div class="body-area">
                                            <div class="row">  											
                                                    <div class="col-md-4">
                                                    <div class="table-responsive show-table">
                                                        <table class="table">
                                                        <tr>
                                                            <th><?php echo e(__("Refund Id#")); ?></th>
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

                                                        </table>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                    <div class="table-responsive show-table">
                                                    <table class="table"> 
                                                      												
                                                           <tr>
                                                                <th><?php echo e(__("Product SKU")); ?></th>
                                                                <td><?php echo e($data->product_sku); ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th><?php echo e(__("Amount")); ?></th>
                                                                <td><?php echo e($data->amount); ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th><?php echo e(__("Quantity")); ?></th>
                                                                <td><?php echo e($data->quantity); ?></td>
                                                            </tr>
                                                           <tr>
                                                                <th><?php echo e(__("Reason")); ?></th>
                                                                <td><?php echo e($data->reason); ?></td>
                                                            </tr>															
                                                            <tr>
                                                                <th><?php echo e(__("Refund Date")); ?></th>
                                                                <td><?php echo e($data->created_at); ?></td>
                                                            </tr>
                                                            
                                                             <?php if($data->tracking_code): ?>
                                                             <tr>
                                                                <th><?php echo e(__("Return Tracking Code")); ?></th>
                                                                <td><?php echo e($data->tracking_code); ?></td>
                                                            </tr>
                                                            <?php endif; ?>
                                                            
                                                            <?php if($data->tracking_url): ?>
                                                            
                                                             <tr>
                                                                <th><?php echo e(__("Return Tracking Url")); ?></th>
                                                                <td><a href="<?php echo e($data->tracking_url); ?>" target="_blank"><?php echo e($data->tracking_url); ?></a></td>
                                                            </tr>
                                                            
                                                            <?php endif; ?>
                                                            
                                                            <?php if($data->tracking_partner): ?>
                                                            
                                                             <tr>
                                                                <th><?php echo e(__("Return Courier Partner")); ?></th>
                                                                <td><?php echo e($data->tracking_partner); ?></td>
                                                            </tr>
                                                            <?php endif; ?>
                                                            
                                                           
                                                        </table>
                                                        </div>
                                                    </div>			
													
															  
                                                        </div>
														
														<div class="row">
														<h6>Attachment : </h6>
														<?php $scrimage=array();
										                      $temp=explode(',',$data->screen_shot);
															  foreach($temp as $image){
                                                              $images[]=trim( str_replace( array('[',']') ,"" ,$image ) );
                                                                }
                                                                  $j=1;
                                                               foreach($images as $image){ ?>
															   <div class="col-md-2">
                                                        <div class="user-image">
															   <a href="<?php echo e(asset('assets/images/screenshot/'.$image)); ?>" download>Download Attachment <?php echo e($j); ?></a>
															   </div>
														
														
                                                    </div>
                                                           <?php $j++; }
                                                           ?>													
													
                                                </div>
												<br>
												<div class="row">														
														<?php 
										                      $docment=explode(',',$data->document);
															  if($data->document){ ?>
															  <h6>Document : </h6>
															  <?php foreach($docment as $docments){
                                                              $docmentdata[]=trim( str_replace( array('[',']') ,"" ,$docments ) );
                                                                }
                                                                  $k=1;
                                                               foreach($docmentdata as $docm){ ?>
															   <div class="col-md-2">
                                                        <div class="user-image">
															   <a href="<?php echo e(asset('assets/images/document/'.$docm)); ?>" download>Download Document <?php echo e($k); ?></a>
															   </div>
														
														
                                                    </div>
															  <?php $k++; } }
                                                           ?>													
													
                                                </div>
												<br>
												<div class="row">
												<div class="col-md-6">
												<form  method="POST" action="<?php echo e(route('admin-raisedocument-update',$data->id)); ?>" enctype="multipart/form-data" id="documentform">
												<?php echo e(csrf_field()); ?>

												<?php echo $__env->make('includes.admin.form-both', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>												
										         <div class="left-area"><input type="file" class="form-control" name="document[]" placeholder="Upload Document" multiple></div>
												 </div>	
                                                <div class="col-md-6">												 
												<button class="addocument-btn" type="submit"><?php echo e(__('Add Document')); ?></button>
												</form>
												</div>
												</div>
												
												<?php
                                                $order_data = App\Models\Order::find($data->order_id);
                                                $vorder_data = App\Models\VendorOrder::where('user_id',$data->vendor_id)->where('order_id',$data->order_id)->where('product_id',$data->product_id)->first();
                                                ?>
												<?php
												$payment_method=$order_data->method
												?>
												<?php
												$return_status=$vorder_data->refund_status
												?>
												<div class="row">
												<?php if($payment_method!='Razorpay'): ?>
												<div class="col-md-2">
												<form  method="POST" action="<?php echo e(route('admin-rstatus-update',$data->id)); ?>" enctype="multipart/form-data" id="resolvedform">
												<?php echo e(csrf_field()); ?>

												<?php echo $__env->make('includes.admin.form-both', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
												<input type = "hidden" name="disputeid" value="<?php echo e($data->id); ?>">
												<div class="modal fade" id="resolved" tabindex="-1" role="dialog" aria-labelledby="resolved" aria-hidden="true">                        
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">            
            <div class="modal-body">
                <p class="text-center">Are you Sure You want to Create Resolved Request?</p>
				<button class="resolved-btn btn btn-success" style="margin-top : 0; width:auto; height:auto; font-size : 1rem; 
    background-color: #28a745; border: 1px solid transparent; border-color: #28a745;" type="submit"><?php echo e(__('Confirm')); ?></button>
                <button type="button" class="btn btn-danger" data-dismiss="modal"><?php echo e(__('Cancel')); ?></button>
            </div>
            </div>
    </div>
</div>
											
												</form>
												<a href="javascript:;" class="btn btn-info" data-toggle="modal" data-target="#resolved"><?php echo e(__('Resolved')); ?></a>												
												
												</div>
												<div class="col-md-2">
												<form  method="POST" action="<?php echo e(route('admin-dstatus-update',$data->id)); ?>" enctype="multipart/form-data" id="declineform">
												<?php echo e(csrf_field()); ?>

												<?php echo $__env->make('includes.admin.form-both', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
												<input type = "hidden" name="disputeid" value="<?php echo e($data->id); ?>">
												
												<div class="modal fade" id="decline" tabindex="-1" role="dialog" aria-labelledby="decline" aria-hidden="true">                        
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">            
            <div class="modal-body">
                <p class="text-center">Are you Sure You want to Create Decline Request?</p>
				<button class="decline-btn btn btn-success" style="margin-top : 0; width:auto; height:auto; font-size : 1rem; 
    background-color: #28a745; border: 1px solid transparent; border-color: #28a745;" type="submit"><?php echo e(__('Confirm')); ?></button>
                <button type="button" class="btn btn-danger" data-dismiss="modal"><?php echo e(__('Cancel')); ?></button>
            </div>
            </div>
    </div>
</div>
											
												</form>
												<a href="javascript:;" class="btn btn-info" data-toggle="modal" data-target="#decline"><?php echo e(__('Decline')); ?></a>
												</div>
												<?php elseif($data->refund_status): ?>
												<!--div class="col-md-2">
												<form  method="POST" action="<?php echo e(route('admin-rstatus-update',$data->id)); ?>" enctype="multipart/form-data" id="resolvedform">
												<?php echo e(csrf_field()); ?>

												<?php echo $__env->make('includes.admin.form-both', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
												<input type = "hidden" name="disputeid" value="<?php echo e($data->id); ?>">
												<button class="resolved-btn" type="submit"><?php echo e(__('Resolved')); ?></button>
												</form>
												</div-->											
												
												<?php endif; ?>
												
												<?php if($payment_method=='Razorpay' && $data->refund_status !='1' ): ?>
													<div class="col-md-2">
												<form  method="POST" action="<?php echo e(route('admin-dstatus-update',$data->id)); ?>" enctype="multipart/form-data" id="declineform">
												<?php echo e(csrf_field()); ?>

												<?php echo $__env->make('includes.admin.form-both', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
												<input type = "hidden" name="disputeid" value="<?php echo e($data->id); ?>">
												
												<div class="modal fade" id="decline" tabindex="-1" role="dialog" aria-labelledby="decline" aria-hidden="true">                        
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">            
            <div class="modal-body">
                <p class="text-center">Are you Sure You want to Create Decline Request?</p>
				<button class="decline-btn btn btn-success" style="margin-top : 0; width:auto; height:auto; font-size : 1rem; 
    background-color: #28a745; border: 1px solid transparent; border-color: #28a745;" type="submit"><?php echo e(__('Confirm')); ?></button>
                <button type="button" class="btn btn-danger" data-dismiss="modal"><?php echo e(__('Cancel')); ?></button>
            </div>
            </div>
    </div>
</div>
																						</form>
													<a href="javascript:;" class="btn btn-info" data-toggle="modal" data-target="#decline"><?php echo e(__('Decline')); ?></a>
												</div>
												<div class="col-md-2">
												<form  method="POST" action="<?php echo e(route('admin-refundonline-update',$data->id)); ?>" enctype="multipart/form-data" id="redonform">
												<?php echo e(csrf_field()); ?>

												<?php echo $__env->make('includes.admin.form-both', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
												<input type = "hidden" name="user_id" value="<?php echo e($data->vendor_id); ?>">
												<input type = "hidden" name="order_id" value="<?php echo e($data->order_id); ?>">
												<input type = "hidden" name="product_id" value="<?php echo e($data->product_id); ?>">
												<input type = "hidden" name="product_item_qty" value="<?php echo e($data->quantity); ?>">
												<input type = "hidden" name="product_item_price" value="<?php echo e($data->amount); ?>">
												<input type = "hidden" name="reason" value="<?php echo e($data->reason); ?>">
													<div class="modal fade" id="refundon" tabindex="-1" role="dialog" aria-labelledby="refundon" aria-hidden="true">                        
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">            
            <div class="modal-body">
                <p class="text-center">Are you Sure You want to Create Refund Online Request?</p>
				<button class="redonform-btn btn btn-success" style="margin-top : 0; width:auto; height:auto; font-size : 1rem; 
    background-color: #28a745; border: 1px solid transparent; border-color: #28a745;" type="submit"><?php echo e(__('Confirm')); ?></button>
                <button type="button" class="btn btn-danger" data-dismiss="modal"><?php echo e(__('Cancel')); ?></button>
            </div>
            </div>
    </div>
</div>
												
												
												</form>
												<a href="javascript:;" class="btn btn-info" data-toggle="modal" data-target="#refundon"><?php echo e(__('Refund Online')); ?></a>
												</div>
												<div class="col-md-2">
												<form  method="POST" action="<?php echo e(route('admin-refundoffline-update',$data->id)); ?>" enctype="multipart/form-data" id="redoffform">
												<?php echo e(csrf_field()); ?>

												<?php echo $__env->make('includes.admin.form-both', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
												<input type = "hidden" name="user_id" value="<?php echo e($data->vendor_id); ?>">
												<input type = "hidden" name="order_id" value="<?php echo e($data->order_id); ?>">
												<input type = "hidden" name="product_id" value="<?php echo e($data->product_id); ?>">
												<input type = "hidden" name="product_item_qty" value="<?php echo e($data->quantity); ?>">
												<input type = "hidden" name="product_item_price" value="<?php echo e($data->amount); ?>">
												<input type = "hidden" name="reason" value="<?php echo e($data->reason); ?>">
												
												<div class="modal fade" id="refundoff" tabindex="-1" role="dialog" aria-labelledby="refundoff" aria-hidden="true">                        
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">            
            <div class="modal-body">
                <p class="text-center">Are you Sure You want to Create Refund Offline Request?</p>
				<button class="redoffform-btn btn btn-success" style="margin-top : 0; width:auto; height:auto; font-size : 1rem; 
    background-color: #28a745; border: 1px solid transparent; border-color: #28a745;" type="submit"><?php echo e(__('Confirm')); ?></button>
                <button type="button" class="btn btn-danger" data-dismiss="modal"><?php echo e(__('Cancel')); ?></button>
            </div>
            </div>
    </div>
</div>
												
												
												</form>
												<a href="javascript:;" class="btn btn-info" data-toggle="modal" data-target="#refundoff"><?php echo e(__('Refund Offline')); ?></a>
												</div>
                        <div class="col-md-2">
                        <form  method="POST" action="<?php echo e(route('admin-refundcoupon-update',$data->id)); ?>" enctype="multipart/form-data" id="redoffform">
                        <?php echo e(csrf_field()); ?>

                        <?php echo $__env->make('includes.admin.form-both', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                        <input type = "hidden" name="user_id" value="<?php echo e($data->vendor_id); ?>">
                        <input type = "hidden" name="order_id" value="<?php echo e($data->order_id); ?>">
                        <input type = "hidden" name="product_id" value="<?php echo e($data->product_id); ?>">
                        <input type = "hidden" name="product_item_qty" value="<?php echo e($data->quantity); ?>">
                        <input type = "hidden" name="product_item_price" value="<?php echo e($data->amount); ?>">
                        <input type = "hidden" name="reason" value="<?php echo e($data->reason); ?>">
                        
                        		<div class="modal fade" id="refcoupon" tabindex="-1" role="dialog" aria-labelledby="refcoupon" aria-hidden="true">                        
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">            
            <div class="modal-body">
                <p class="text-center">Are you Sure You want to Create Refund By Coupon Request?</p>
				<button class="redoffform-btn btn btn-success" style="margin-top : 0; width:auto; height:auto; font-size : 1rem; 
    background-color: #28a745; border: 1px solid transparent; border-color: #28a745;" type="submit"><?php echo e(__('Confirm')); ?></button>
                <button type="button" class="btn btn-danger" data-dismiss="modal"><?php echo e(__('Cancel')); ?></button>
            </div>
            </div>
    </div>
</div>
                       
                        </form>
                        <a href="javascript:;" class="btn btn-info" data-toggle="modal" data-target="#refcoupon"><?php echo e(__('Refund By Coupon')); ?></a>
                        </div>
												<?php endif; ?>												
													
												</div>
												
                                            </div>
											
                                            
											
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>

<script type="text/javascript">
$('#example2').dataTable( {
  "ordering": false,
      'paging'      : false,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : false,
      'info'        : false,
      'autoWidth'   : false,
      'responsive'  : true
} );
</script>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>