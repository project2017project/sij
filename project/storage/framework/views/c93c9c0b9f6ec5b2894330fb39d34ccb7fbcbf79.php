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
                      <h4 class="heading"><?php echo e(__('Rto Details')); ?> <a class="add-btn" href="<?php echo e(route('admin-open-rto')); ?>"><i class="fas fa-arrow-left"></i> <?php echo e(__('Back')); ?></a></h4>
                      <ul class="links">
                        <li>
                          <a href="<?php echo e(route('admin.dashboard')); ?>"><?php echo e(__('Dashboard')); ?> </a>
                        </li>
                        <li>
                          <a href="javascript:;"><?php echo e(__('Rto Details')); ?></a>
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
                                                            <th><?php echo e(__("Rto Id#")); ?></th>
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
                                                            <tr>
                                                                <th><?php echo e(__("Reason")); ?></th>
                                                                <td><?php echo e($data->reason); ?></td>
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
                                                                <td><a href="<?php echo e($data->text); ?>" target="_blank"><?php echo e($data->text); ?></a></td>
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
												
												<div class="row">
												
												<!--div class="col-md-2">
												<form  method="POST" action="<?php echo e(route('admin-rto-update',$data->id)); ?>" enctype="multipart/form-data" id="rtodform">
												<?php echo e(csrf_field()); ?>

												<?php echo $__env->make('includes.admin.form-both', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
												<input type = "hidden" name="rtoid" value="<?php echo e($data->id); ?>">
												<button class="rtodform-btn" type="submit"><?php echo e(__('rto')); ?></button>
												</form>
												</div-->
												
												<div class="col-md-2">
												<form  method="POST" action="<?php echo e(route('admin-dstatus-rto',$data->id)); ?>" enctype="multipart/form-data" id="declineform">
												<?php echo e(csrf_field()); ?>

												<?php echo $__env->make('includes.admin.form-both', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
												<input type = "hidden" name="rtoid" value="<?php echo e($data->id); ?>">
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