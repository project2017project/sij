<?php $__env->startSection('content'); ?>  
<div class="content-area">
	<div class="mr-breadcrumb">
		<div class="row">
			<div class="col-lg-12">
				<h4 class="heading"><?php echo e(__('Ship Exchange')); ?></h4>
				<ul class="links">
					<li><a href="<?php echo e(route('admin.dashboard')); ?>"><?php echo e(__('Dashboard')); ?> </a></li>
					<li><a href="javascript:;"><?php echo e(__('Ship Exchange')); ?></a></li>					
				</ul>
			</div>
		</div>
	</div>
	<div class="product-area">
		<div class="row">
			<div class="col-lg-12">
				<div class="mr-table allproduct">					 
					<div class="table-responsiv">
						<table id="geniustable" class="table table-hover dt-responsive" cellspacing="0" width="100%">
							<thead>
								<tr>
									<th><?php echo e(__('Exchange Id')); ?></th>									
                                    <th><?php echo e(__('Vendor Name')); ?></th>
									<th><?php echo e(__('Order Id')); ?></th>
                                    <th><?php echo e(__('Product Name')); ?></th>
                                    <th><?php echo e(__('Product SKU')); ?></th>
									<!--th><?php echo e(__('Amount')); ?></th-->
									<th><?php echo e(__('Quantity')); ?></th>									
                                    <th><?php echo e(__('Courier Partner Name')); ?></th>
                                    <th><?php echo e(__('Track Code')); ?></th>
									<th><?php echo e(__('Track URL')); ?></th>
									<th><?php echo e(__('Exchange Date')); ?></th>
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



<div class="modal fade" id="modalaccept" tabindex="-1" role="dialog" aria-labelledby="modalaccept" aria-hidden="true">						
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





<div class="modal fade" id="modaldel" tabindex="-1" role="dialog" aria-labelledby="modaldel" aria-hidden="true">						
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



<?php $__env->stopSection(); ?>    

<?php $__env->startSection('scripts'); ?>



<script type="text/javascript">

	var table = $('#geniustable').DataTable({
		   ordering: false,
		   processing: true,
		   serverSide: true,
		   
		   ajax: {
                  url: "<?php echo e(route('admin-load-ship-exchange','none')); ?>",
                  type: 'GET',
                  data: function (d) {    
					

                  }
                 },
		   columns: [
					{ data: 'id', name: 'id' },
					{ data: 'vendor_id', name: 'vendor_id' },
					{ data: 'order_id', name: 'order_id' },
					{ data: 'product_name', name: 'product_name' },
					{ data: 'product_sku', name: 'product_sku' },
					//{ data: 'amount', name: 'amount' },
					{ data: 'quantity', name: 'quantity' },                   
				   { data: 'courier_name', name: 'courier_name' },
                   { data: 'track_code', name: 'track_code' },
				   { data: 'track_url', name: 'track_url' }, 
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
		  
</script>

<?php $__env->stopSection(); ?>   
<?php echo $__env->make('layouts.admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>