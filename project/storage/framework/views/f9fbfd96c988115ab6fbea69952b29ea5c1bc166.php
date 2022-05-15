<?php $__env->startSection('content'); ?>  
<div class="content-area">
	<div class="mr-breadcrumb">
		<div class="row">
			<div class="col-lg-12">
				<h4 class="heading"><?php echo e(__('Complete Dispute')); ?></h4>
				<ul class="links">
					<li><a href="<?php echo e(route('admin.dashboard')); ?>"><?php echo e(__('Dashboard')); ?> </a></li>
					<li><a href="javascript:;"><?php echo e(__('Complete Dispute')); ?></a></li>					
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
						<table id="geniustable" class="table table-hover dt-responsive" cellspacing="0" width="100%">
							<thead>
								<tr>
									<th><?php echo e(__('Dispute Id')); ?></th>									
                                    <th><?php echo e(__('Vendor Name')); ?></th>
									<th><?php echo e(__('Order Id')); ?></th>
                                    <th><?php echo e(__('Product Name')); ?></th>
                                    <th><?php echo e(__('Product SKU')); ?></th>									
									<th><?php echo e(__('Dispute Date')); ?></th>									
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
                  url: "<?php echo e(route('admin-load-resolved-disputeds','none')); ?>",
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
                   { data: 'created_at', name: 'created_at' }									
					
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