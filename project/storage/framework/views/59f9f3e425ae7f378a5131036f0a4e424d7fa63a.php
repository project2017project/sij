<?php $__env->startSection('content'); ?>
<div class="content-area">
	<div class="mr-breadcrumb">
		<div class="row">
			<div class="col-lg-12">
				<h4 class="heading"><?php echo e(__('Debit Note')); ?> 				
				<ul class="links">
					<li><a href="<?php echo e(route('admin.dashboard')); ?>"><?php echo e(__('Dashboard')); ?> </a></li>					
					<li><a href="javascript:;"><?php echo e(__('Add Debit Note')); ?></a></li>					
				</ul>
			</div>
		</div>
	</div>

	<form id="adddebitnoteform" action="<?php echo e(route('addstore-debitnote-submit')); ?>" method="POST" enctype="multipart/form-data">
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
                                  
<?php $__currentLoopData = $vendordata; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vendordatas): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<input type="text" class="vendor_name" value="<?php echo e($vendordatas->name); ?>" readonly>   
<input type="text" class="vendor_state" value="<?php echo e($vendordatas->state); ?>" readonly> 

<?php if($vendordatas->reg_number): ?>

<input type="text" id="txtGSTIN"  class="gst" value="<?php echo e($vendordatas->reg_number); ?>" />

<?php endif; ?>


									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    
                                
                                    
                                  
<div class="table-responsive-sm">
<table class="table">
  <tr>
    <th>Product Name</th>
    <th>Amount</th>
    <th>Quantity</th>
    <th>Comission</th>
	<th>Refund</th>
    <th>Exchange</th>
    <th>Payment Status</th>
	<th>Debit Note Created</th>
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
                                    $dispute_data = App\Models\DebitNote::where('order_id','=',$alldata->order_id)->where('vendor_id','=',$alldata->user_id)->where('product_id','=',$alldata->product_id)->get();
                                    
                                    
                                    ?>
									 
									 
 <tr class="setproduct<?php echo e($i); ?>">
    <td><?php echo e($product_data->name); ?></td>
    <td class="datapamt" dataamt="<?php echo e($alldata->price); ?>"><?php echo e($alldata->price); ?></td>
    <td class="datapqty" dataqty="<?php echo e($alldata->qty); ?>"><?php echo e($alldata->qty); ?></td>
    <td class="dataadminfee" dataadminfee="<?php echo e($alldata->admin_fee); ?>"><?php echo e($alldata->admin_fee); ?></td>
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
	<?php if($vender_data->vendor_request_status=='completed'): ?>
	<td class="paystatus" paystatus="paid">Paid</td>
    <?php elseif($vender_data->vendor_request_status=='NotRaised'): ?>
	<td class="paystatus" paystatus="unpaid">Unpaid</td>
	<?php elseif($vender_data->vendor_request_status=='requested'): ?>
	<td class="paystatus" paystatus="request">Request</td>
	<?php else: ?>
		<td class="paystatus" paystatus="">Unpaid</td>
	<?php endif; ?>
	
	<?php if($dispute_data): ?>
    <td class="refundreq" pendingref="<?php echo e(count($dispute_data)); ?>" refundreq=""><?php echo e(count($dispute_data)); ?></td>
     <?php else: ?>
    <td class="refundreq" pendingref="<?php echo e(count($dispute_data)); ?>" refundreq="">-</td>
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
                                    <option data-href="<?php echo e(route('product-data-pload',$vdatas->product_id)); ?>" value="<?php echo e($vdatas->product_id); ?>"  data-hreftax="<?php echo e(route('product-data-ptload',$vdatas->product_id)); ?>" value="<?php echo e($vdatas->product_id); ?>"  dataidp=".setproduct<?php echo e($j); ?>">(<?php echo e($productsku->sku); ?>) <?php echo e($productsku->name); ?></option>
									<?php $j++ ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					                    </select>
										
										</div>
									</div>	                                    
									<div class="products" style="position : absolute; opacity : 0; visibilty : hidden;"></div>
									
									
											<div class="row">
										<div class="col-lg-12"><div class="left-area"><h4 class="heading"><?php echo e(__('Quantity')); ?>* </h4></div></div>
										<div class="col-lg-12"><input type="number" class="input-field rdqty" placeholder="<?php echo e(__('Quantity')); ?>" name="quantity" min="1"  required=""></div>
									</div>
									
									
									
									
									<div class="row">
										<div class="col-lg-12"><div class="left-area"><h4 class="heading"><?php echo e(__('Order Amount')); ?>* </h4></div></div>
										<div class="col-lg-12"><input type="text" class="input-field rdamt" placeholder="<?php echo e(__('Amount')); ?>" name="calcamount" required="" ></div>
									</div>
									
									
									<div class="row">
										<div class="col-lg-12"><div class="left-area"><h4 class="heading"><?php echo e(__('OTHER AMT')); ?>* </h4></div></div>
										<div class="col-lg-12"><input type="text" class="input-field othersamt" placeholder="<?php echo e(__('OTHER AMT')); ?>" value="0" name="others_amt" ></div>
									</div>
									
									

																												 <div class="row">
										<div class="col-lg-12"><div class="left-area"><h6 class="heading"> <?php echo e(__('Payment Type?')); ?> </h6>  </div><select name="is_payment" class="ispayselect">
										    <option value="Payment to vendor">Payment to Vendor</option>
										    <option value="Comission and Tax">Commission + GST & TCS (If appplicable)</option>
										    <option value="Payment to vendor with Comission and tax">Payment made to vendor + Commission + GST & TCS (If applicable)</option>
										    <option value="Payment to vendor with Comission and tax and shipping charges">Shipping charges + Payment made to vendor + Commission + GST & TCS (If applicable)</option>
											<option value="Shipping Charges">Shipping Charges</option>
										</select></div>
									
									</div>
									
									
									
														 <div class="row">
										<div class="col-lg-12"><a href="javascript:void(0);" class="btn btn-primary btn-calculate"> Calculate Amount </a></div>
									
									</div>
									
									
									
									
																			<div class="row">
										<div class="col-lg-12"><div class="left-area"><h4 class="heading"><?php echo e(__('ADMIN FEE')); ?>* </h4></div></div>
										<div class="col-lg-12"><input type="text" class="input-field adminfeecadmin" placeholder="<?php echo e(__('ADMIN FEE')); ?>" name="adminfee" required="" ></div>
									</div>
									
									<div class="row">
										<div class="col-lg-12"><div class="left-area"><h4 class="heading"><?php echo e(__('SGST')); ?>* </h4></div></div>
										<div class="col-lg-12"><input type="text" class="input-field sgstcadmin" placeholder="<?php echo e(__('SGST')); ?>" name="sgst"  ></div>
									</div>
									
										<div class="row">
										<div class="col-lg-12"><div class="left-area"><h4 class="heading"><?php echo e(__('CGST')); ?>* </h4></div></div>
										<div class="col-lg-12"><input type="text" class="input-field cgstcadmin" placeholder="<?php echo e(__('CGST')); ?>" name="cgst"  ></div>
									</div>
									
																			<div class="row">
										<div class="col-lg-12"><div class="left-area"><h4 class="heading"><?php echo e(__('IGST')); ?>* </h4></div></div>
										<div class="col-lg-12"><input type="text" class="input-field igstcadmin" placeholder="<?php echo e(__('igst')); ?>" name="igst"  ></div>
										
										
										
																											
										
										
										
								
									</div>
									
									
									
											<div class="row">
										<div class="col-lg-12"><div class="left-area"><h4 class="heading"><?php echo e(__('Gross Amount')); ?>* </h4></div></div>
										<div class="col-lg-12"><input type="text" class="input-field grossamt" placeholder="<?php echo e(__('gross amount')); ?>" ></div>
										
										</div>
									
									
										<div class="row">
										<div class="col-lg-12"><div class="left-area"><h4 class="heading"><?php echo e(__('TCS')); ?>* </h4></div></div>
										<div class="col-lg-12"><input type="text" class="input-field tcscadmin" placeholder="<?php echo e(__('TCS')); ?>" name="tcs" ></div>
									</div>
									
									
										<div class="row">
										<div class="col-lg-12"><div class="left-area"><h4 class="heading"><?php echo e(__('Net Payment to Vendor')); ?>* </h4></div></div>
										<div class="col-lg-12"><input type="text" class="input-field amtbeforetaxcadmin" placeholder="<?php echo e(__('AMT BEFORE FEES')); ?>" name="amt_before_tax" ></div>
									</div>
									
									
									
										
										<div class="row">
										<div class="col-lg-12"><div class="left-area"><h4 class="heading"><?php echo e(__('REMARKS')); ?> </h4></div></div>
										<div class="col-lg-12"><input type="text" class="input-field " placeholder="<?php echo e(__('REMARKS')); ?>" name="remarks" ></div>
									</div>
									
									
									
									
									<div class="row">
										<div class="col-lg-12"><div class="left-area"><h4 class="heading"><?php echo e(__('Total Deduction Amount')); ?>* </h4></div></div>
										<div class="col-lg-12"><input type="text" class="input-field finaldnamt" placeholder="<?php echo e(__('Total Deduction Amount')); ?>" name="amount" required="" ></div>
									</div>
									
									
									
									
									
                                    <div class="row">
										<div class="col-lg-12"><div class="left-area"><h4 class="heading"><?php echo e(__('Reason *')); ?> </h4></div></div>
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
                                          
                                          <option value="Shipping Charges">Shipping Charges</option>
                                          
                                          <option value="Penalty for delayed shipping">Penalty for delayed shipping</option>
                                         
                                         <option value="others">others</option>
                                        </select>
										<input type="text" class="input-field" id="reason" placeholder="<?php echo e(__('Reason')); ?>" name="reason" style="display:none;"></div>
									</div> 
                                   <div class="row">
										<div class="col-lg-12"><div class="left-area"><h4 class="heading"><?php echo e(__('Upload Attachments')); ?> </h4></div></div>
										<div class="col-lg-12"><input required type="file" class="form-control" name="screenshot[]" placeholder="Upload Screen Shot" multiple></div>
									</div> 
									
									<div class="row">
										<div class="col-lg-12 text-center">
										<input type="hidden" name="vendor_id" value="<?php echo e($vendorid); ?>">
										<input type="hidden" name="order_id" value="<?php echo e($orderid); ?>">
										<div class="modal fade" id="debitmod" tabindex="-1" role="dialog" aria-labelledby="debitmod" aria-hidden="true">                        
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">            
            <div class="modal-body">
                <p class="text-center">Are you Sure You want to Create Debit Note Request?</p>
				<button class="adddebitnoteform-btn btn btn-success" style="margin-top : 0; width:auto; height:auto; font-size : 1rem; 
    background-color: #28a745; border: 1px solid transparent; border-color: #28a745;" type="submit"><?php echo e(__('Confirm')); ?></button>
                <button type="button" class="btn btn-danger" data-dismiss="modal"><?php echo e(__('Cancel')); ?></button>
            </div>
            </div>
    </div>
</div>
											
												<a href="javascript:;" class="btn btn-info" data-toggle="modal" data-target="#debitmod"><?php echo e(__('Add')); ?></a>
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
    
    
    
    
    
    $(document).ready(function () {
        
     $(".btn-calculate").click(function(){
         
     
            var qtyr = $(".rdqty").val();
            var productamt = $(".tractive .datapamt").attr('dataamt');
            var productqty = $(".tractive .datapqty").attr('dataqty');
            
            var otheramt = $(".othersamt").val();
            
            var productprice = productamt / productqty;
            
          var total = productprice * qtyr;
          
          var vstate = $(".vendor_state").val();
          
          
             
             var productadminfee = (total*15/100).toFixed(2);
             
             
              
              
                if(vstate == "Tamil Nadu") {
                    
                    var sgstadmin = (productadminfee*9/100).toFixed(2);
             
             var cgstadmin =  (productadminfee*9/100).toFixed(2);
             
              var igstadmin =  0;
                    
                } else {
                    
                    var sgstadmin = 0;
             
             var cgstadmin =  0;
             
              var igstadmin =  (productadminfee*18/100).toFixed(2);
                    
                }
          
              
              
              var amtbeforetcs = (total - productadminfee - sgstadmin - cgstadmin - igstadmin).toFixed(2);
              
 
              
              if(vstate == "Tamil Nadu"){
                    
                    
                    var gstr = $(".gst").val();
                    
                    if(gstr)
                    {
                    
                      var tcsadmin = (amtbeforetcs*1/100).toFixed(2);
                        
                    }else{
                        
                       var tcsadmin = 0; 
                    }
                }else{
                    
                       var tcsadmin = 0; 
                    }
                    
                   
              
              var finaldnamnt  = (amtbeforetcs - tcsadmin);
              
                $(".adminfeecadmin").val(productadminfee);
                
                
                  $(".sgstcadmin").val(sgstadmin);
                  
                    $(".cgstcadmin").val(cgstadmin);
                    
                      $(".igstcadmin").val(igstadmin);
                      
                        $(".tcscadmin").val(tcsadmin);
                        
                        var grsamt = (total - productadminfee - sgstadmin - cgstadmin - igstadmin).toFixed(2);
                        
                        
                        var amountbeforefees = (total - productadminfee - sgstadmin - cgstadmin - igstadmin - tcsadmin).toFixed(2);
              
              
              $(".grossamt").val(grsamt);
              
              $(".amtbeforetaxcadmin").val(amountbeforefees);
              
              var ispay = $('.ispayselect').val();
              
              var feentax = (parseFloat(productadminfee) + parseFloat(sgstadmin) + parseFloat(cgstadmin) + parseFloat(igstadmin) + parseFloat(tcsadmin)).toFixed(2);
              
               var payenttax = parseFloat(finaldnamnt) + parseFloat(feentax);
               
               var payenttaxshipping = parseFloat(finaldnamnt) + parseFloat(feentax) + parseFloat(otheramt);
              
              if (ispay == "Payment to vendor"){
                   $(".finaldnamt").val(finaldnamnt);
              } else if (ispay == "Comission and Tax"){
                   $(".finaldnamt").val(feentax);
              } else if (ispay == "Payment to vendor with Comission and tax"){
                  $(".finaldnamt").val(payenttax);
              } else if (ispay == "Payment to vendor with Comission and tax and shipping charges"){
                  $(".finaldnamt").val(payenttaxshipping);
              } else{
                  $(".finaldnamt").val(otheramt);
                   $(".adminfeecadmin").val(0);
                
                
                  $(".sgstcadmin").val(0);
                  
                    $(".cgstcadmin").val(0);
                    
                      $(".igstcadmin").val(0);
                      
                        $(".tcscadmin").val(0);
                         $(".grossamt").val(0);
              
              $(".amtbeforetaxcadmin").val(0);
              }
              
             
              
     });
              
     
    });

    
    
    



 $(document).on('change','.productid',function () {
	 
            var productlink = $(this).find(':selected').attr('data-href');
            var producttaxlink = $(this).find(':selected').attr('data-hreftax');
            var productidp = $(this).find(':selected').attr('dataidp');
            var productqty = $(productidp+" .datapqty").attr('dataqty');
            $('tr').removeClass('tractive');
            $(productidp).addClass('tractive');
            
            $(".rdqty").attr("max", productqty);
            
            $(".rdqty").val('1');
            
            
            var productamt = $(productidp+" .datapamt").attr('dataamt');
            
            $(".rdamt").val(productprice);
            
            
            var productadminfee = $(productidp+" .dataadminfee").attr('dataadminfee');
           
           
         
          
            
              var productprice = productamt / productqty;
              
              $(".rdamt").val(productprice);			
            if(productlink){
				$('.products').show();
                $('.products').load(productlink);                
            }else{
				$('.products').hide();
			}
			
			
			if(producttaxlink){
				$('.order_taxes').show();
                $('.order_taxes').load(producttaxlink);                
            }else{
				$('.order_taxes').hide();
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