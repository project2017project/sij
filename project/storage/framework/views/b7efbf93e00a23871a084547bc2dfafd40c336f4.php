 
<?php $__env->startSection('styles'); ?>
<style type="text/css">.input-field { padding: 15px 20px; }</style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>  
<input type="hidden" id="headerdata" value="<?php echo e(__('ORDER')); ?>">
<div class="content-area">
	<div class="mr-breadcrumb">
		<div class="row">
			<div class="col-lg-12">
				<h4 class="heading"><?php echo e(__('Shipping Orders')); ?></h4>
				<ul class="links">
					<li><a href="<?php echo e(route('admin.dashboard')); ?>"><?php echo e(__('Dashboard')); ?> </a></li>
					<li><a href="javascript:;"><?php echo e(__('Orders')); ?></a></li>
					<li><a href="<?php echo e(route('admin-order-shipping')); ?>"><?php echo e(__('All Shipping Orders')); ?></a></li>
				</ul>
			</div>
		</div>
	</div>
	<div class="product-area">
		<div class="row">
			<div class="col-lg-12">
				<div class="mr-table allproduct">
					<?php echo $__env->make('includes.admin.form-success', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?> 
					<div class="table-responsiv">
						<div class="row" style="padding-top : 20px; background : #eeeeee;">				                                                                     
                                   
                                   
                                   <div class ="col-sm-10">
                                       
                                   <div class="row">
                                                    
							<div class="form-group col-md-3">                               
                                <select name="svendor" id="svendor">
                                    <option value=''>--Select Any Vendor-- </option>
                                    <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $userid): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($userid->id); ?>"><?php echo e($userid->shop_name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>                                        
                                </select>                                
                            </div>
                            <div class="form-group col-md-3">                               
                                <input type="date" name="start" id="startdateis" class="form-control">  
                                <em class="help-text">Start Date</em>
                            </div>
                            <div class="form-group col-md-3">                     
                                <input type="date" name="end" id="enddateis" class="form-control">
                                <em class="help-text">End Date</em>
                            </div>
                            <div class="text-left col-md-3" >
                                <button type="text" id="btnFiterSubmitSearch" class="btn btn-info">Submit</button>
                                <button type="text" id="btnFiterReset" class="btn btn-danger">Reset</button>
                            </div>
                            </div>
                            </div>
                            
                         </div>
                        <br>
						<div class="gocover" style="background: url(<?php echo e(asset('assets/images/'.$gs->admin_loader)); ?>) no-repeat scroll center center rgba(45, 45, 45, 0.5);"></div>
						<form id="geniusstatus" style="min-width : 100%;" class="form-horizontal" action="<?php echo e(route('admin-order-status-update')); ?>" method="POST" enctype="multipart/form-data">
										<?php echo e(csrf_field()); ?>	
						<table id="geniustable" class="table table-hover dt-responsive" cellspacing="0" width="100%">
							<thead>
								<tr>
									<th><?php echo e(__('Order Id')); ?></th>
									<th><?php echo e(__('Customer Name')); ?></th>
									<th><?php echo e(__('Vendor Name')); ?></th>									
									<th><?php echo e(__('Total Qty')); ?></th>
									<th><?php echo e(__('Total Cost')); ?></th>
									<th><?php echo e(__('Payment')); ?></th>
									<th><?php echo e(__('Order Date')); ?></th>
									<th><?php echo e(__('Options')); ?></th>
								</tr>
							</thead>
						</table>					
						
						
						 <div class="modal" id="model-status" tabindex="-1" role="dialog" aria-labelledby="model-statuslevel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="model-statuslevel"><?php echo e(__('Order Status')); ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
				<div class="modal-body">
					<div class="container-fluid p-0">
						<div class="row">
							<div class="col-md-12">
								<div class="contact-form">									
																		

                        <div class="row">
                          <div class="col-lg-4">
                            <div class="left-area">
                                <h4 class="heading">Order Status *</h4>
                            </div>
                          </div>                         
                          <div class="col-lg-7">
                              <select name="status" required="" required>
							  <option value="">Please select status</option>
                                <option value="pending">Pending</option>
                                <option value="processing">Processing</option>
                                <option value="on delivery">On Delivery</option>
                                <option value="completed">Completed</option>
                                <option value="declined">Declined</option>
                              </select>
                          </div>
                        </div>


                        <div class="row">
                          <div class="col-lg-4">
                            <div class="left-area">
                              
                            </div>
                          </div>
                          <div class="col-lg-7">
                            <button class="addProductSubmit-btn" type="submit">Save</button>
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
	</form>	
	</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="confirm-delete1" tabindex="-1" role="dialog" aria-labelledby="modal1" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="submit-loader"><img  src="<?php echo e(asset('assets/images/'.$gs->admin_loader)); ?>" alt=""></div>
			

			<div class="modal-header d-block text-center">
				<h4 class="modal-title d-inline-block"><?php echo e(__('Update Status')); ?></h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<!-- Modal body -->
			<div class="modal-body">
				<p class="text-center"><?php echo e(__("You are about to update the order's Status.")); ?></p>
				<p class="text-center"><?php echo e(__('Do you want to proceed?')); ?></p>
				<input type="hidden" id="t-add" value="<?php echo e(route('admin-order-track-add')); ?>">
				<input type="hidden" id="t-id" value="">
				<input type="hidden" id="t-title" value="">
				<textarea class="input-field" placeholder="Enter Your Tracking Note (Optional)" id="t-txt"></textarea>
			</div>
			<!-- Modal footer -->
			<div class="modal-footer justify-content-center">
				<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo e(__('Cancel')); ?></button>
				<a class="btn btn-success btn-ok order-btn"><?php echo e(__('Proceed')); ?></a>
			</div>
		</div>
	</div>
</div>






<div class="sub-categori">
    <div class="modal" id="vendorform" tabindex="-1" role="dialog" aria-labelledby="vendorformLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="vendorformLabel"><?php echo e(__('Send Email')); ?></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
				<div class="modal-body">
					<div class="container-fluid p-0">
						<div class="row">
							<div class="col-md-12">
								<div class="contact-form">
									<form id="emailreply">
										<?php echo e(csrf_field()); ?>

										<ul>
											<li><input type="email" class="input-field eml-val" id="eml" name="to" placeholder="<?php echo e(__('Email')); ?> *" value="" required=""></li>
											<li><input type="text" class="input-field" id="subj" name="subject" placeholder="<?php echo e(__('Subject')); ?> *" required=""></li>
											<li><textarea class="input-field textarea" name="message" id="msg" placeholder="<?php echo e(__('Your Message')); ?> *" required=""></textarea></li>
										</ul>
										<button class="submit-btn" id="emlsub" type="submit"><?php echo e(__('Send Email')); ?></button>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
            </div>
        </div>
    </div>
</div>





<div class="modal fade" id="modal1" tabindex="-1" role="dialog" aria-labelledby="deliverymodal1" aria-hidden="true">						
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="submit-loader"><img  src="<?php echo e(asset('assets/images/'.$gs->admin_loader)); ?>" alt=""></div>
			<div class="modal-header">
				<h5 class="modal-title"></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body"></div>
			<div class="modal-footer"><button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo e(__('Close')); ?></button></div>
		</div>
	</div>
</div>


<div class="modal fade" id="refundpopup" tabindex="-1" role="dialog" aria-labelledby="refundpopup" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">

    <div class="modal-header d-block text-center">
        <h4 class="modal-title d-inline-block"><?php echo e(__("Update Status")); ?></h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
    </div>

      <!-- Modal body -->
      <div class="modal-body">
            <p class="text-center"><?php echo e(__("You are about to change the status.")); ?></p>
            <p class="text-center"><?php echo e(__("Do you want to proceed?")); ?></p>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer justify-content-center">
            <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo e(__("Cancel")); ?></button>
            <a class="btn btn-success btn-ok"><?php echo e(__("Update")); ?></a>
      </div>

    </div>
  </div>
</div>







<?php $__env->stopSection(); ?>    

<?php $__env->startSection('scripts'); ?>



<script type="text/javascript">

	var table = $('#geniustable').DataTable({
		   ordering: false,
		   processing: true,
		   serverSide: true,
		   
		   ajax: {
                  url: "<?php echo e(route('admin-ship-datatables','on delivery')); ?>",
                  type: 'GET',
                  data: function (d) {
           
					d.svendor          = $('#svendor').val();
					d.enddateis          = $('#enddateis').val();
					d.startdateis          = $('#startdateis').val();

                  }
                 },
		   columns: [
					{ data: 'number', name: 'number' },
					{ data: 'customer_name', name: 'customer_name' },
					{ data: 'vendor_name', name: 'vendor_name' },					
					{ data: 'totalQty', name: 'totalQty' },
					{ data: 'pay_amount', name: 'pay_amount' },
					{ data: 'payment_status', name: 'payment_status' },
					{ data: 'created_at', name: 'created_at' },
					{ data: 'action', searchable: false, orderable: false }
				 ],
		
		   language : {
				processing: '<img src="<?php echo e(asset('assets/images/'.$gs->admin_loader)); ?>">'
			},
			drawCallback : function( settings ) {
					$('.select').niceSelect();  
			}
		});
		$('#btnFiterReset').click(function(){window.location.reload();});
			$('#btnFiterSubmitSearch').click(function(){
             $('#geniustable').DataTable().draw(true);
          });		
$("#checkAll").click(function () {$('input:checkbox').not(this).prop('checked', this.checked);}); 		  
</script>
<script type="text/javascript">

$(document).on('click','.refund',function(){
  var href = $(this).attr('href');
});


</script>

<?php $__env->stopSection(); ?>   
<?php echo $__env->make('layouts.admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>