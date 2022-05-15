 

<?php $__env->startSection('content'); ?>  
                    <input type="hidden" id="headerdata" value="<?php echo e(__("WITHDRAW")); ?>">
                    <div class="content-area">
                        <div class="mr-breadcrumb">
                            <div class="row">
                                <div class="col-lg-12">
                                        <h4 class="heading"><?php echo e(__("Withdraws")); ?></h4>
                                        <ul class="links">
                                            <li>
                                                <a href="<?php echo e(route('vendor-dashboard')); ?>"><?php echo e(__("Dashboard")); ?> </a>
                                            </li>
                                            <li>
                                                <a href="javascript:;"><?php echo e(__("Vendors")); ?></a>
                                            </li>
                                            <li>
                                                <a href="<?php echo e(route('vendor-withdraws-index')); ?>"><?php echo e(__("Withdraws")); ?></a>
                                            </li>
                                        </ul>
                                </div>
                            </div>
                        </div>
                        <div class="product-area">
                            
                                <div class="row">
                                <div class="col-lg-12">
                                    <div class="mr-table allproduct">
                                        <?php echo $__env->make('includes.vendor.form-success', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?> 
                                        <div class="table-responsiv">
                                            
                                            <div class="row">		
                    							<div class="form-group col-md-2">                               
                                                    <select name="statuswwithdraw" id="statuswwithdraw">
                                                        <option value=''>--Select Option-- </option>
                                                        <option value="pending">Requested</option>
                    									<option value="rejected">Rejected</option>
                    									<option value="completed">Completed</option>								
                                                    </select>                                
                                                </div>
                                                <div class="text-left" >
                                                    <button type="text" id="btnFiterSubmitSearch" class="btn btn-info">Submit</button>
                                                    <button type="text" id="btnFiterReset" class="btn btn-danger">Reset</button>
                                                     <a href="<?php echo e(route('withdraws-excel-file',['status'=>'none'])); ?>" class="btn btn-warning" >Requested Export EXCEL</a>
                                                </div>
                                            </div>
                                            
                                            
                                            
                                            
                                                <table id="geniustable" class="table table-hover dt-responsive" cellspacing="0" width="100%">
                                                    <thead>
                                                        <tr>
                                                            <th><?php echo e(__("Withdraw ID")); ?></th>
                                                            <th><?php echo e(__("Email")); ?></th>
                                                            <!--th><?php echo e(__("Vendor")); ?></-->
                                                            <th><?php echo e(__("Phone")); ?></th>
                                                            <th><?php echo e(__("Amount")); ?></th>
                                                            <th><?php echo e(__("Order")); ?></th>
                                                            <th><?php echo e(__("Date")); ?></th>
                                                            <th><?php echo e(__("Status")); ?></th>
                                                            <th><?php echo e(__("Options")); ?></th>
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
                  url: "<?php echo e(route('vendor-withdraws-datatables')); ?>",
                  type: 'GET',
                  data: function (d) {
					d.statuswwithdraw         = $('#statuswwithdraw').val();
                  }
                 },
               columns: [
                        { data: 'id', name: 'id' },
                        { data: 'email', name: 'email' },
                        /*{ data: 'shop_name', name: 'shop_name' },*/
                        { data: 'phone', name: 'phone' },
                        { data: 'amount', name: 'amount' },
                        { data: 'group_order_id', name: 'group_order_id' },
                        { data: 'created_at', name: 'created_at' },
                        { data: 'status', name: 'status' },
                        { data: 'action', searchable: false, orderable: false }
                     ],
               language : {
                    processing: '<img src="<?php echo e(asset('assets/images/'.$gs->admin_loader)); ?>">'
                },
                	drawCallback : function( settings ) {
	    				$('.select').niceSelect();	
				}
            });
                  	$('#btnFiterSubmitSearch').click(function(){
             $('#geniustable').DataTable().draw(true);
          });    
        

    </script>
	<script>    
        $('#btnFiterReset').click(function(){window.location.reload();});   
		$(document).ready(function(){$(".referesh-btn").click(function(){location.reload(true);});});
	</script>

    
<?php $__env->stopSection(); ?>   
<?php echo $__env->make('layouts.vendor', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>