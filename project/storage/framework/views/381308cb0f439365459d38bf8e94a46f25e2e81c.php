<?php $__env->startSection('content'); ?>  
<div class="content-area">
	<div class="mr-breadcrumb">
		<div class="row">
			<div class="col-lg-12">
				<h4 class="heading"><?php echo e(__('List')); ?></h4>
				<ul class="links">
					<li><a href="<?php echo e(route('admin.dashboard')); ?>"><?php echo e(__('Dashboard')); ?> </a></li>
					<li><a href="javascript:;"><?php echo e(__('List')); ?></a></li>					
				</ul>
			</div>
		</div>
	</div>
	<div class="product-area">
		<div class="row">
		 <div class="col-xs-12 col-sm-12 col-md-2"> 
      <a href="<?php echo e(route('all-coupon-code',['status'=>'none'])); ?>" class="btn btn-info" >ALL</a>
      </div>
      <div class="col-xs-12 col-sm-12 col-md-2"> 
      <a href="<?php echo e(route('used-coupon-code',['status'=>'none'])); ?>" class="btn btn-info" >Used CSV</a>
      </div>
	  <div class="col-xs-12 col-sm-12 col-md-2"> 
      <a href="<?php echo e(route('unused-coupon-code',['status'=>'none'])); ?>" class="btn btn-info" >Unused CSV</a>
      </div>
	  <div class="col-xs-12 col-sm-12 col-md-2"> 
      <a href="<?php echo e(route('expired-coupon-code',['status'=>'none'])); ?>" class="btn btn-info" >Expired CSV</a>
      </div>
			<div class="col-lg-12">
				<div class="mr-table allproduct">					 
					<div class="table-responsiv">
						<table id="geniustable" class="table table-hover dt-responsive" cellspacing="0" width="100%">
							<thead>
								<tr>
									<th><?php echo e(__('Id')); ?></th>									
                                    <th><?php echo e(__('Code')); ?></th>
									<th><?php echo e(__('Order Id')); ?></th>
                                    <th><?php echo e(__('Email Address')); ?></th>                                    
									<th><?php echo e(__('Amount')); ?></th>
									<th><?php echo e(__('Start Date')); ?></th>
									<th><?php echo e(__('End Date')); ?></th>
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




<div class="modal fade" id="modalapprove" tabindex="-1" role="dialog" aria-labelledby="modalapprove" aria-hidden="true">					
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





<div class="modal fade" id="modalreject" tabindex="-1" role="dialog" aria-labelledby="modalreject" aria-hidden="true">						
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
                  url: "<?php echo e(route('admin-load-alllist','none')); ?>",
                  type: 'GET',
                  data: function (d) {    
					

                  }
                 },
		   columns: [
					{ data: 'id', name: 'id' },
					{ data: 'code', name: 'code' },
					{ data: 'order_id', name: 'order_id' },
					{ data: 'email_address', name: 'email_address' },
					{ data: 'price', name: 'price' },					
					{ data: 'start_date', name: 'start_date' },
                   { data: 'end_date', name: 'end_date' },
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