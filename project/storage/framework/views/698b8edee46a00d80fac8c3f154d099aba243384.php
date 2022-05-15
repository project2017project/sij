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
                      <h4 class="heading"><?php echo e(__('Credit Note Details')); ?> <a class="add-btn" href="<?php echo e(route('admin-open-credit')); ?>"><i class="fas fa-arrow-left"></i> <?php echo e(__('Back')); ?></a></h4>
                      <ul class="links">
                        <li>
                          <a href="<?php echo e(route('admin.dashboard')); ?>"><?php echo e(__('Dashboard')); ?> </a>
                        </li>
                        <li>
                          <a href="javascript:;"><?php echo e(__('Credit Note Details')); ?></a>
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
                                                            <th><?php echo e(__("Credit Note Id#")); ?></th>
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
                                                            <!--tr>
                                                                <th><?php echo e(__("Quantity")); ?></th>
                                                                <td><?php echo e($data->quantity); ?></td>
                                                            </tr-->
															<tr>
                                                                <th><?php echo e(__("Reason")); ?></th>
                                                                <td><?php echo e($data->reason); ?></td>
                                                            </tr>
															<?php if($data->withdraw_id): ?>														
                                                            <tr>
                                                                <th><?php echo e(__("Withdraw ID")); ?></th>
                                                                <td><?php echo e($data->withdraw_id); ?></td>
                                                            </tr>
                                                            <?php endif; ?>															
                                                            <tr>
                                                                <th><?php echo e(__("Dispute Date")); ?></th>
                                                                <td><?php echo e($data->created_at); ?></td>
                                                            </tr>
                                                            
                                                           
                                                        </table>
                                                        </div>
                                                    </div>			
													
															  
                                                        </div>
														
														<div class="row">
														<h4>Attachment :- </h4>
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
												<form  method="POST" action="<?php echo e(route('admin-creditdocument-update',$data->id)); ?>" enctype="multipart/form-data" id="documentform">
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
												
												<!--div class="row">											
												
												<div class="col-md-2">
												<form  method="POST" action="<?php echo e(route('admin-creditrstatus-update',$data->id)); ?>" enctype="multipart/form-data" id="settlementform">
												<?php echo e(csrf_field()); ?>

												<?php echo $__env->make('includes.admin.form-both', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
												<input type = "hidden" name="creditid" value="<?php echo e($data->id); ?>">
												<button class="settlementform-btn" type="submit"><?php echo e(__('Settlement')); ?></button>
												</form>
												</div>							
												
																								
												</div-->
												
												<!--div class="row">											
												
												<div class="col-md-2">
												<form  method="POST" action="<?php echo e(route('credit-cancel-status',$data->id)); ?>" enctype="multipart/form-data" id="settlementform">
												<?php echo e(csrf_field()); ?>

												<?php echo $__env->make('includes.admin.form-both', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
												<input type = "hidden" name="debitid" value="<?php echo e($data->id); ?>">
												<button class="settlementform-btn" type="submit"><?php echo e(__('Cancel')); ?></button>
												</form>
												</div>							
												
																								
												</div-->
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