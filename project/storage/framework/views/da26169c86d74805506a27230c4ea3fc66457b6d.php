<?php $__env->startSection('content'); ?>  
<div class="content-area">
	<div class="mr-breadcrumb">
		<div class="row">
			<div class="col-lg-12">
				<h4 class="heading"><?php echo e(__('Pending Refunds')); ?></h4>
				<ul class="links">
					<li><a href="<?php echo e(route('admin.dashboard')); ?>"><?php echo e(__('Dashboard')); ?> </a></li>
					<li><a href="javascript:;"><?php echo e(__('Pending Refunds')); ?></a></li>					
				</ul>
			</div>
			<div class="col-xs-12 col-sm-12 col-md-2"> 
      <a href="<?php echo e(route('raisedispute-excel-file',['status'=>'none'])); ?>" class="btn btn-info" >Export</a>
      </div>
	   <div class ="col-sm-10">
                                       
                                   <div class="row">                                                   
							
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
	</div>
	<div class="product-area">
		<div class="row">
			<div class="col-lg-12">
				<div class="mr-table allproduct">					 
					<div class="table-responsiv">
					<form id="geniusstatus" style="min-width : 100%;" class="form-horizontal" action="<?php echo e(route('admin-load-open-dispute')); ?>" method="POST" enctype="multipart/form-data">
										<?php echo e(csrf_field()); ?>

						<table id="geniustable" class="table table-hover dt-responsive" cellspacing="0" width="100%">
							<thead>
								<tr>
									<th><?php echo e(__('Refund Id')); ?></th>									
                                    <th><?php echo e(__('Vendor Name')); ?></th>
									<th><?php echo e(__('Order Id')); ?></th>
                                    <th><?php echo e(__('Product Name')); ?></th>
                                    <th><?php echo e(__('Product SKU')); ?></th>
									<th><?php echo e(__('Amount')); ?></th>
									<th><?php echo e(__('Quantity')); ?></th>
									<th><?php echo e(__('Refund Date')); ?></th>
									<th><?php echo e(__('Options')); ?></th>
								</tr>
							</thead>
						</table>
	                    </form>
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
                  url: "<?php echo e(route('admin-load-open-dispute','none')); ?>",
                  type: 'GET',
                  data: function (d) {    
					d.enddateis          = $('#enddateis').val();
					d.startdateis          = $('#startdateis').val();

                  }
                 },
		   columns: [
					{ data: 'id', name: 'id' },
					{ data: 'vendor_id', name: 'vendor_id' },
					{ data: 'order_id', name: 'order_id' },
					{ data: 'product_name', name: 'product_name' },
					{ data: 'product_sku', name: 'product_sku' },
					{ data: 'amount', name: 'amount' },
					{ data: 'quantity', name: 'quantity' },
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
<?php echo $__env->make('layouts.admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>