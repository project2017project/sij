<?php $__env->startSection('styles'); ?>

<style type="text/css">
    .table-responsive {
    overflow-x: hidden;
}
table#example2 {
    margin-left: 10px;
}

</style>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

                    <div class="content-area">
                        <div class="mr-breadcrumb">
                            <div class="row">
                               <div class="col-lg-12">
                      <h4 class="heading"><?php echo e(__('Credit Note Details')); ?> <a class="add-btn" href="<?php echo e(route('admin-resolved-credit')); ?>"><i class="fas fa-arrow-left"></i> <?php echo e(__('Back')); ?></a></h4>
                      <ul class="links">
                        <li>
                          <a href="<?php echo e(route('admin.dashboard')); ?>"><?php echo e(__('Dashboard')); ?> </a>
                        </li>
                        <li>
                          <a href="javascript:;"><?php echo e(__('Credit Note Details')); ?></a>
                        </li>                        
                        
                      </ul>
                  </div>
                            </div>
                        </div>
                            <div class="add-product-content1 customar-details-area">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="product-description">
                                            <div class="body-area">
                                            <div class="row">  											
                                                    <div class="col-md-4">
                                                    <div class="table-responsive show-table">
                                                        <table class="table">
                                                        <tr>
                                                            <th><?php echo e(__("Dispute Id#")); ?></th>
                                                            <td><?php echo e($data->id); ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th><?php echo e(__("Vendor Name")); ?></th>
															<?php
                                        $user = App\Models\User::find($data->vendor_id);
                                        ?>
                                                            <td><?php echo e($user->name); ?></td>
                                                        </tr>
                                                        <tr>
                                                            <th><?php echo e(__("Order Id")); ?></th>
                                                            <td><?php echo e($data->order_id); ?></td>
                                                        </tr>                                                       
                                                            <tr>
                                                                <th><?php echo e(__("Product Name")); ?></th>
                                                                <td><?php echo e($data->product_name); ?></td>
                                                            </tr>	

                                                        </table>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                    <div class="table-responsive show-table">
                                                    <table class="table"> 
                                                      												
                                                           <tr>
                                                                <th><?php echo e(__("Product SKU")); ?></th>
                                                                <td><?php echo e($data->product_sku); ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th><?php echo e(__("Amount")); ?></th>
                                                                <td><?php echo e($data->amount); ?></td>
                                                            </tr>
                                                            <tr>
                                                                <th><?php echo e(__("Quantity")); ?></th>
                                                                <td><?php echo e($data->quantity); ?></td>
                                                            </tr>															
                                                            <tr>
                                                                <th><?php echo e(__("Dispute Date")); ?></th>
                                                                <td><?php echo e($data->created_at); ?></td>
                                                            </tr>
                                                            
                                                           
                                                        </table>
                                                        </div>
                                                    </div>			
													
															  
                                                        </div>
														
												<br>
												<?php
                                                $order_data = App\Models\Order::find($data->order_id);
                                                $vorder_data = App\Models\VendorOrder::where('user_id',$data->vendor_id)->where('order_id',$data->order_id)->where('product_id',$data->product_id)->first();
                                                ?>
												
												
                                            </div>
											
                                            
											
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>

<script type="text/javascript">
$('#example2').dataTable( {
  "ordering": false,
      'paging'      : false,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : false,
      'info'        : false,
      'autoWidth'   : false,
      'responsive'  : true
} );
</script>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>