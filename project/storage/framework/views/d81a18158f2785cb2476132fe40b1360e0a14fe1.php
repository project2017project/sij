<?php $__env->startSection('content'); ?>  
<div class="content-area">
	<div class="mr-breadcrumb">
		<div class="row">
			<div class="col-lg-12">
				<h4 class="heading"><?php echo e(__('Credit Note')); ?></h4>
				<ul class="links">
					<li><a href="<?php echo e(route('vendor-dashboard')); ?>"><?php echo e(__('Dashboard')); ?> </a></li>
					<li><a href="javascript:;"><?php echo e(__('Credit Note')); ?></a></li>					
				</ul>
			</div>
		</div>
	</div>
	<div class="product-area">
		<div class="row">
			<div class="col-lg-12">
				<div class="mr-table allproduct">					 
					<div class="table-responsiv">
					<div class="row">                    							
                                                <div class="text-left" >                                                    
                                                     <a href="<?php echo e(route('vendordw-credit-data',['status'=>'none'])); ?>" class="btn btn-warning" >Export</a>
                                                </div>
											<?php if($pending__count): ?>		
											<div class="text-right">                                     
                                            <h5 class="title">Pending</h5>
                                            <span class="count"><?php echo e($pending__count); ?></span>
									        </div>
											<?php endif; ?>
                                            </div>
					<div class="row" style="padding-top : 20px; background : #eeeeee;">				                                                                     
                                   
                                   
                                   <div class ="col-sm-12">
                                       
                                   <div class="row">
                                                    
							<div class="form-group col-md-3">                               
                                <select name="status" id="status">
                                    <option value=''>--Select Status-- </option>
								
									<option value='0'>Unsettle Note</option>
									<option value='1'>Settle Note</option>								
									<option value='2'>Cancelled Note</option>
                                                                           
                                </select>                                
                            </div>
							
                            
                            <div class="text-left col-md-3" >
                                <button type="text" id="btnFiterSubmitSearch" class="btn btn-info">Submit</button>
                                <button type="text" id="btnFiterReset" class="btn btn-danger">Reset</button>
                            </div>
                            </div>
                            </div>
                            
                           
						
                    </div>
                        <br>
						<table id="geniustable" class="table table-hover dt-responsive" cellspacing="0" width="100%">
							<thead>
								<tr>
									<th><?php echo e(__('Id')); ?></th>									
                                    <th><?php echo e(__('Vendor Name')); ?></th>
									<th><?php echo e(__('Order Id')); ?></th>
                                    <th><?php echo e(__('Product Name')); ?></th>
                                    <th><?php echo e(__('Product SKU')); ?></th>
									<th><?php echo e(__('Amount')); ?></th>
									<!--th><?php echo e(__('Quantity')); ?></th-->
									<th><?php echo e(__('Withdraw ID')); ?></th>
									<th><?php echo e(__('Status')); ?></th>
									<th><?php echo e(__('Date')); ?></th>
									<th><?php echo e(__('Options')); ?></th>
								</tr>
							</thead>
						</table>
	
				</div>
				</div>
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
                  url: "<?php echo e(route('vendor-credit-datatables','none')); ?>",
                  type: 'GET',
                  data: function (d) { 
					
                   d.status = $('#status').val();
                  }
                 },
		   columns: [
					{ data: 'id', name: 'id' },
					{ data: 'vendor_name', name: 'vendor_name' },
					{ data: 'order_data', name: 'order_data' },
					{ data: 'product_name', name: 'product_name' },
					{ data: 'product_sku', name: 'product_sku' },
					{ data: 'amount', name: 'amount' },
					//{ data: 'quantity', name: 'quantity' },
					{ data: 'withdraw_data', name: 'withdraw_data' },
					{ data: 'status', name: 'status' },
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
		  
</script>

<?php $__env->stopSection(); ?>   
<?php echo $__env->make('layouts.vendor', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>