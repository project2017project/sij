<?php $__env->startSection('content'); ?>
<div class="content-area">
	<div class="mr-breadcrumb">
		<div class="row">
			<div class="col-lg-12">
				<h4 class="heading"><?php echo e(__('Refund')); ?> 				
				<ul class="links">
					<li><a href="<?php echo e(route('admin.dashboard')); ?>"><?php echo e(__('Dashboard')); ?> </a></li>					
					<li><a href="javascript:;"><?php echo e(__('Add Refund')); ?></a></li>					
				</ul>
			</div>
		</div>
	</div>

	<form id="raisedisputeform" action="<?php echo e(route('addstore-raisedispute-submit')); ?>" method="POST" enctype="multipart/form-data">
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
    <th>Available Amt <br /> for Refund</th>
    <th>Quantity</th>
    <th>Available Qty <br /> for Refund</th>
	<th>Refund</th>
    <th>Exchange</th>
     <th>Pending Request</th>
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
                                     
                                      <?php
                                    $dispute_data = App\Models\RaiseDispute::where('order_id','=',$alldata->order_id)->where('vendor_id','=',$alldata->user_id)->where('product_id','=',$alldata->product_id)->where('status','=','open')->get();
                                    ?>
  <tr class="setproduct<?php echo e($i); ?>">
    <td><?php echo e($product_data->name); ?></td>
    <td><?php echo e($alldata->price); ?></td>
    
    <td class="datapamt" dataamt="<?php echo e($alldata->price-$vender_data->product_item_price); ?>"><?php echo e($alldata->price-$vender_data->product_item_price); ?></td>
    
    <td><?php echo e($alldata->qty); ?></td>
    
    <td class="datapqty" dataqty="<?php echo e($alldata->qty-$vender_data->product_item_qty); ?>"><?php echo e($alldata->qty-$vender_data->product_item_qty); ?></td>
	<?php if($alldata->refund_status): ?>
	<td class="refund" refund="<?php echo e($alldata->refund_status); ?>"><?php echo e($alldata->refund_status); ?></td>
    <?php else: ?>
	<td class="refund" refund="">-</td>
    <?php endif; ?>
	<?php if($alldata->other_status): ?>
	<td class="exchange" exchange="<?php echo e($alldata->other_status); ?>"><?php echo e($alldata->other_status); ?></td>
    <?php else: ?>
	<td class="exchange" exchange="">-</td>
    <?php endif; ?>
    <?php if($dispute_data): ?>
    <td class="refundreq" pendingref="<?php echo e(count($dispute_data)); ?>" refundreq=""><?php echo e(count($dispute_data)); ?></td>
     <?php else: ?>
    <td class="refundreq" pendingref="<?php echo e(count($dispute_data)); ?>" refundreq="">-</td>
    <?php endif; ?>
	<?php if($vender_data->vendor_request_status=='completed'): ?>
	<td class="paystatus" paystatus="paid">Paid</td>
    <?php elseif($vender_data->vendor_request_status=='NotRaised'): ?>
	<td class="paystatus" paystatus="unpaid">Unpaid</td>
	<?php elseif($vender_data->vendor_request_status=='requested'): ?>
	<td class="paystatus" paystatus="request">Request</td>
	<?php else: ?>
		<td class="paystatus" paystatus="">Unpaid</td>
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
									
									
										<div class="row refpenalert" style="display:none;">
									    <div class="col-lg-12">
									        <div class="alert alert-danger" role="alert">You already have <span class="prcount"></span> pending  request for this product. </div>
									    </div>
									</div>
									
									
									<div class="row">
										<div class="col-lg-12"><div class="left-area"><h4 class="heading"><?php echo e(__('Quantity')); ?>* </h4></div></div>
										<div class="col-lg-12"><input type="number" class="input-field rdqty" placeholder="<?php echo e(__('Quantity')); ?>" name="quantity" min="1"  required=""></div>
									</div>
									
									
									
									
									<div class="row">
										<div class="col-lg-12"><div class="left-area"><h4 class="heading"><?php echo e(__('Amount')); ?>* </h4></div></div>
										<div class="col-lg-12"><input type="text" class="input-field rdamt" placeholder="<?php echo e(__('Amount')); ?>" name="amount" required="" readonly></div>
									</div>
									
									<div class="row">
										<div class="col-lg-12"><div class="left-area"><h4 class="heading"><?php echo e(__('Customer Tracking Code')); ?> </h4></div></div>
										<div class="col-lg-12"><input type="text" class="input-field" placeholder="<?php echo e(__('Tracking Code')); ?>" name="tracking_code"></div>
									</div>
									
									<div class="row">
										<div class="col-lg-12"><div class="left-area"><h4 class="heading"><?php echo e(__('Customer Tracking Url')); ?> </h4></div></div>
										<div class="col-lg-12"><input type="text" class="input-field" placeholder="<?php echo e(__('Tracking URL')); ?>" name="tracking_url"></div>
									</div>
									
									<div class="row">
										<div class="col-lg-12"><div class="left-area"><h4 class="heading"><?php echo e(__('Customer Courier Partner')); ?> </h4></div></div>
										<div class="col-lg-12"><input type="text" class="input-field" placeholder="<?php echo e(__('Courier Partner')); ?>" name="tracking_partner"></div>
									</div>
									
									
                                 
                                    <div class="row">
										<div class="col-lg-12"><div class="left-area"><h4 class="heading"><?php echo e(__('Reason')); ?> </h4></div></div>
										<div class="col-lg-12">
										<select name="prreason" onchange="changereason(this.value);" required> 
                                         <option value="">Please Select a Reason</option>  
                                         <option value="Delay in dispatching the product">Delay in dispatching the product</option>
                                         <option value="Out of stock">Out of stock</option>
                                         <option value="Product lost in transit">Product lost in transit (No Proper POD)</option>
                                         
                                          <option value="Duplicate order created by customer">Duplicate order created by customer</option>
                                         <option value="Damaged product received by customer">Damaged product received by customer</option>
                                         <option value="Wrong product delivered to customer">Wrong product delivered to customer</option>
                                         
                                          <option value="Customer not satisfied by the product">Customer not satisfied by the product</option>
                                         
                                         
                                         <option value="others">others</option>
                                        </select>
										<input type="text" class="input-field" id="reason" placeholder="<?php echo e(__('Reason')); ?>" name="reason" style="display:none;"></div>
									</div> 
									
									
								
									
									

                                   <div class="row">
										<div class="col-lg-12"><div class="left-area"><h4 class="heading"><?php echo e(__('Upload Screen Shot')); ?> </h4></div></div>
										<div class="col-lg-12"><input required type="file" class="form-control" name="screenshot[]" placeholder="Upload Screen Shot" multiple></div>
									</div> 									
		                            		
								
									
									<div class="row">
										<div class="col-lg-12 text-center">
										<input type="hidden" name="vendor_id" value="<?php echo e($vendorid); ?>">
										<input type="hidden" name="order_id" value="<?php echo e($orderid); ?>">
										<div class="modal fade" id="raisemod" tabindex="-1" role="dialog" aria-labelledby="raisemod" aria-hidden="true">                        
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">            
            <div class="modal-body">
                <p class="text-center">Are you Sure You want to Create Refund Request?</p>
				<button class="addraisedispute-btn btn btn-success" style="margin-top : 0; width:auto; height:auto; font-size : 1rem; 
    background-color: #28a745; border: 1px solid transparent; border-color: #28a745;" type="submit"><?php echo e(__('Confirm')); ?></button>
                <button type="button" class="btn btn-danger" data-dismiss="modal"><?php echo e(__('Cancel')); ?></button>
            </div>
            </div>
    </div>
</div>
											
												<a href="javascript:;" class="btn btn-info" data-toggle="modal" data-target="#raisemod"><?php echo e(__('Add')); ?></a>
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

$(document).on('change','.rdqty',function () {
            var qtyr = $(this).val();
            var productidp = $(this).find(':selected').attr('dataidp');
            var productamt = $(".tractive .datapamt").attr('dataamt');
            var productqty = $(".tractive .datapqty").attr('dataqty');
            var productprice = productamt / productqty;
             
             
             var total = productprice * qtyr;
     
       $(".rdamt").val(total);
    });


 $(document).on('change','.productid',function () {
	 
            var productlink = $(this).find(':selected').attr('data-href');
            var productidp = $(this).find(':selected').attr('dataidp');
            var productqty = $(productidp+" .datapqty").attr('dataqty');
             var refpending = $(productidp+" .refundreq").attr('pendingref');
            $('tr').removeClass('tractive');
            $(productidp).addClass('tractive');
            
            $(".rdqty").attr("max", productqty);
            
            $(".rdqty").val('1');
            
            
            var productamt = $(productidp+" .datapamt").attr('dataamt');
            
            $(".rdamt").val(productprice);
            
            
              var productprice = productamt / productqty;
              
              $(".rdamt").val(productprice);
              
               $(".prcount").text(refpending);
              
              if(refpending >= 1){
                  $('.refpenalert').show();
              }else{
                   $('.refpenalert').hide();
              }
            
            if(productlink){
				$('.products').show();
                $('.products').load(productlink);                
            }else{
				$('.products').hide();
			}
        });
    </script>
<script type="text/javascript">
function changereason(val){
 var element=document.getElementById('reason');
 if(val==''||val=='others')
   element.style.display='block';
 else  
   element.style.display='none';
}

</script>	
	
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>