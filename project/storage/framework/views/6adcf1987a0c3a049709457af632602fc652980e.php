 

<?php $__env->startSection('content'); ?>  
<input type="hidden" id="headerdata" value="<?php echo e(__("Check Completed Order list")); ?>">
<div class="content-area">
	<div class="mr-breadcrumb">
		<div class="row">
			<div class="col-lg-12">
				<h4 class="heading"><?php echo e(__("Check Completed Order list")); ?></h4>
				<ul class="links">
					<li><a href="<?php echo e(route('admin.dashboard')); ?>"><?php echo e(__("Dashboard")); ?> </a></li>
					<li><a href="javascript:;"><?php echo e(__("Vendors")); ?></a></li>
					<li><a href="<?php echo e(route('admin-withdraw-index')); ?>"><?php echo e(__("Check Completed Order list")); ?></a></li>
				</ul>
			</div>
		</div>
	</div>
	<div class="product-area">
		<div class="row">
			<div class="col-lg-12">
				<div class="mr-table allproduct">
					<?php echo $__env->make('includes.admin.form-success', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?> 
					<div class="row" style="padding-top : 20px; background : #eeeeee;">				                                                                     
                                   
                                   
                                   <div class ="col-sm-12">
                                       
                                   <div class="row">
                                                    
							<div class="form-group col-md-2">                               
                                <select name="svendor" id="svendor">
                                    <option value=''>--Select Any Vendor-- </option>
                                    <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $userid): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($userid->id); ?>"><?php echo e($userid->shop_name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>                                        
                                </select>                                
                            </div>
							<div class="form-group col-md-2">                               
                                <select name="orderstatus" id="orderstatus">
                                    <option value=''>--Select Status-- </option>
								     <option value='completed'>Pending</option>
									<option value='approved'>Completed</option>
								    <option value='declined'>Declined</option>
                                                                           
                                </select>                                
                            </div>
                            <div class="form-group col-md-2">                               
                                <input type="date" name="start" id="startdateis" class="form-control">  
                                <em class="help-text">Start Date</em>
                            </div>
                            <div class="form-group col-md-2">                     
                                <input type="date" name="end" id="enddateis" class="form-control">
                                <em class="help-text">End Date</em>
                            </div>
                            <div class="text-left col-md-4" >
                                <button type="text" id="btnFiterSubmitSearch" class="btn btn-info">Submit</button>
                                <button type="text" id="btnFiterReset" class="btn btn-danger">Reset</button>
                            </div>
                            </div>
                            </div>                       
                           
							
						
						
                    </div>
                        <br>
					<div class="table-responsiv">
							<table id="geniustable" class="table table-hover dt-responsive" cellspacing="0" width="100%">
								<thead>
									<tr>
										<th><?php echo e(__("Vendor Name")); ?></th>
										<th><?php echo e(__("Order Id")); ?></th>
										<th><?php echo e(__("Price")); ?></th><th><?php echo e(__("Actions")); ?></th>
										<th><?php echo e(__("Order Date")); ?></th>
										<th><?php echo e(__("Shipping Date")); ?></th>
										<th><?php echo e(__("Tracking Info")); ?></th>
									</tr>
								</thead>
							</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="modal1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
    <div class="modal-header d-block text-center">
        <h4 class="modal-title d-inline-block"><?php echo e(__("Accept Order")); ?></h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
    </div>
      <!-- Modal body -->
      <div class="modal-body">
            <p class="text-center"><?php echo e(__("You are about to accept this Order.")); ?></p>
            <p class="text-center"><?php echo e(__("Do you want to proceed?")); ?></p>
      </div>
      <!-- Modal footer -->
      <div class="modal-footer justify-content-center">
            <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo e(__("Cancel")); ?></button>
            <a class="btn btn-success btn-ok"><?php echo e(__("Accept")); ?></a>
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
                  url: "<?php echo e(route('admin-vendor-adminapprovelist-datatables')); ?>",
                  type: 'GET',
                  data: function (d) {
                    
					d.svendor          = $('#svendor').val();
					d.orderstatus          = $('#orderstatus').val();
					d.startdateis          = $('#startdateis').val();
					d.enddateis          = $('#enddateis').val();
					

                  }
                 },
		   columns: [
                        { data: 'name', name: 'name' }, { data: 'OrderId', name: 'OrderId' },{ data: 'price', name: 'price' },
						{ data: 'action', searchable: false, orderable: false },{ data: 'orderdate', name: 'orderdate' },{ data: 'shippingdate', name: 'shippingdate' },{ data: 'trackinginfo', searchable: false, name: 'trackinginfo' }
                     ],
		
		   language : {
				processing: '<img src="<?php echo e(asset('assets/images/'.$gs->admin_loader)); ?>">'
			},			
              
            });
                           
        $('#confirm-delete1').on('show.bs.modal', function(e) {
            $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
        });
		
		$('#btnFiterReset').click(function(){window.location.reload();});
			$('#btnFiterSubmitSearch').click(function(){
             $('#geniustable').DataTable().draw(true);
          });	

    </script>


    
<?php $__env->stopSection(); ?>   
<?php echo $__env->make('layouts.admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>