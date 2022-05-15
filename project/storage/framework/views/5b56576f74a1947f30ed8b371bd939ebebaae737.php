<?php $__env->startSection('content'); ?>
<div class="content-area">
	<div class="mr-breadcrumb">
		<div class="row">
			<div class="col-lg-12">
				<h4 class="heading"><?php echo e(__('Dispute')); ?> 				
				<ul class="links">
					<li><a href="<?php echo e(route('admin.dashboard')); ?>"><?php echo e(__('Dashboard')); ?> </a></li>					
					<li><a href="javascript:;"><?php echo e(__('Add Dispute')); ?></a></li>					
				</ul>
			</div>
		</div>
	</div>
	<form id="disputedform" action="<?php echo e(route('addstore-disputes-submit')); ?>" method="POST" enctype="multipart/form-data">
		<?php echo e(csrf_field()); ?>

       <?php echo $__env->make('includes.admin.form-both', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>	
	<div class="row">
		<div class="col-lg-12">
			<div class="add-product-content">
				<div class="row">
					<div class="col-lg-12">
						<div class="product-description">
							<div class="body-area">
		<div class="row">									
                                  <div class="col-md-12"> 
<div class="table-responsive-sm">
<table class="table">
  <tr>
    <th>Product Name</th>
    <th>Amount</th>
    <th>Quantity</th>
	<th>Refund</th>
    <th>Exchange</th>
    <th>Payment Status</th>
  </tr>
  <?php $i=1; ?>
  <?php $__currentLoopData = $vdata; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $alldata): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		                            <?php
                                    $product_data = App\Models\Product::find($alldata->product_id);
                                    ?>
									 <?php
                                    $vender_data = App\Models\VendorOrder::where('order_id','=',$alldata->order_id)->where('user_id','=',$alldata->user_id)->where('product_id','=',$alldata->product_id)->first();
                                    ?>
									<?php
                                      $withdraw_data = App\Models\VendorOrder::where('user_id','=',$alldata->user_id)->where('product_item_price','=',NULL)->orderBy('id','desc')->get();
                                     ?>
  <tr class="setproduct<?php echo e($i); ?>">
    <td><?php echo e($product_data->name); ?></td>
    <td><?php echo e($alldata->price); ?></td>
   <td class="datapqty" dataqty="<?php echo e($alldata->qty-$vender_data->product_item_qty); ?>"><?php echo e($alldata->qty-$vender_data->product_item_qty); ?></td>
   <?php if($alldata->refund_status): ?>
	<td class="refund" refund="<?php echo e($alldata->refund_status); ?>"><?php echo e($alldata->refund_status); ?></td>
    <?php else: ?>
	<td class="refund" refund="">-</td>
    <?php endif; ?>
	<?php if($alldata->other_status): ?>
	<td class="rto" rto="<?php echo e($alldata->other_status); ?>"><?php echo e($alldata->other_status); ?></td>
    <?php else: ?>
	<td class="rto" rto="">-</td>
    <?php endif; ?>
	<?php if($withdraw_data[0]->vendor_request_status=='completed'): ?>
	<td class="paystatus" paystatus="paid">Paid</td>
    <?php elseif($withdraw_data[0]->vendor_request_status=='NotRaised'): ?>
	<td class="paystatus" paystatus="unpaid">Unpaid</td>
	<?php elseif($withdraw_data[0]->vendor_request_status=='requested'): ?>
	<td class="paystatus" paystatus="request">Request</td>
	<?php else: ?>
		<td class="paystatus" paystatus="">-</td>
	<?php endif; ?>
  </tr>
  <?php $i++ ?>
 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</table>
</div>
</div>
</div>							
                                    <div class="row">
										<div class="col-lg-12"><div class="left-area"><h4 class="heading"><?php echo e(__('Product Id')); ?> </h4></div></div>
										<div class="col-lg-12">	
										<select class="form-control productid" name="product_id" id="productid" required>
						                    <option value=''>--Select Product Id-- </option>
											<?php $j=1; ?>
                                    <?php $__currentLoopData = $vdata; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vdatas): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									 <?php
                                                $productsku = App\Models\Product::find($vdatas->product_id);
                                                ?>
                                    <option data-href="<?php echo e(route('product-data-pload',$vdatas->product_id)); ?>" value="<?php echo e($vdatas->product_id); ?>"  dataidp=".setproduct<?php echo e($j); ?>">(<?php echo e($productsku->sku); ?>) <?php echo e($productsku->name); ?></option>
									<?php $j++ ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					                    </select>
										</div>
									</div>	                                    
									<div class="products"></div> 
										<div class="row">
										<div class="col-lg-12 text-center">
										<input type="hidden" name="vendor_id" value="<?php echo e($vendorid); ?>">
										<input type="hidden" name="order_id" value="<?php echo e($orderid); ?>">
										<div class="modal fade" id="disputesmod" tabindex="-1" role="dialog" aria-labelledby="disputesmod" aria-hidden="true">                        
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">            
            <div class="modal-body">
                <p class="text-center">Are you Sure You want to Create Dispute Request?</p>
				<button class="disputedform-btn btn btn-success" style="margin-top : 0; width:auto; height:auto; font-size : 1rem; 
    background-color: #28a745; border: 1px solid transparent; border-color: #28a745;" type="submit"><?php echo e(__('Confirm')); ?></button>
                <button type="button" class="btn btn-danger" data-dismiss="modal"><?php echo e(__('Cancel')); ?></button>
            </div>
            </div>
    </div>
</div>
											
												<a href="javascript:;" class="btn btn-info" data-toggle="modal" data-target="#disputesmod"><?php echo e(__('Add')); ?></a>
													</div>
									</div>
									
									
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>					
	</div>
	</form>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
<script src="<?php echo e(asset('assets/admin/js/jquery.Jcrop.js')); ?>"></script>
<script src="<?php echo e(asset('assets/admin/js/jquery.SimpleCropper.js')); ?>"></script>
<script>
 $(document).on('change','.productid',function () {
            var productlink = $(this).find(':selected').attr('data-href');						
            if(productlink){
				$('.products').show();
                $('.products').load(productlink);                
            }else{
				$('.products').hide();
			}
        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>