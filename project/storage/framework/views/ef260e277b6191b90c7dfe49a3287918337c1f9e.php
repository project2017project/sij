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
                      <h4 class="heading"><?php echo e(__('Exchange Details')); ?> <a class="add-btn" href="<?php echo e(route('vendor-exchange-index')); ?>"><i class="fas fa-arrow-left"></i> <?php echo e(__('Back')); ?></a></h4>
                      <ul class="links">
                        <li>
                          <a href="<?php echo e(route('vendor-dashboard')); ?>"><?php echo e(__('Dashboard')); ?> </a>
                        </li>
                        <li>
                          <a href="javascript:;"><?php echo e(__('Exchange')); ?></a>
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
                                                            <th><?php echo e(__("Exchange Id#")); ?></th>
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
                                                            <tr>
                                                                <th><?php echo e(__("Product SKU")); ?></th>
                                                                <td><?php echo e($data->product_sku); ?></td>
                                                            </tr>															

                                                        </table>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                    <div class="table-responsive show-table">
                                                    <table class="table"> 
                                                      												
                                                           
                                                            <!--tr>
                                                                <th><?php echo e(__("Amount")); ?></th>
                                                                <td><?php echo e($data->amount); ?></td>
                                                            </tr-->
                                                            <tr>
                                                                <th><?php echo e(__("Quantity")); ?></th>
                                                                <td><?php echo e($data->quantity); ?></td>
                                                            </tr>
															<tr>
                                                         <th><?php echo e(__("Customer Courier Partner")); ?></th>
                                                       <td><?php echo e($data->courier_partner); ?></td>
                                                      </tr>
                                                     <tr>
                                                      <th><?php echo e(__("Customer Tracking Code")); ?></th>
                                                      <td><?php echo e($data->tracking_code); ?></td> </tr>
                                                     <tr> <th><?php echo e(__("Costumer Tracking Url")); ?></th>
                                                     <td><a href="<?php echo e($data->tracking_url); ?>" target="_blank"><?php echo e($data->tracking_url); ?></a></td>
                                                     </tr>
                                                        <?php if($data->companyname): ?>
															<tr>
                                                                <th><?php echo e(__("Vendor Courier Name")); ?></th>
                                                                <td><?php echo e($data->companyname); ?></td>
                                                            </tr>
															<?php endif; ?>
															<?php if($data->title): ?>
                                                           <tr>
                                                                <th><?php echo e(__("Vendor Tracking Code")); ?></th>
                                                                <td><?php echo e($data->title); ?></td>
                                                            </tr>
															<?php endif; ?>
															<?php if($data->text): ?>
                                                           <tr>
                                                                <th><?php echo e(__("Vendor Tracking URL")); ?></th>
                                                                <td><a href="<?php echo e($data->text); ?>" target="_blank"><?php echo e($data->text); ?></a></td>
                                                            </tr>
															<?php endif; ?>															
                                                            <tr>
                                                                <th><?php echo e(__("Exchange Date")); ?></th>
                                                                <td><?php echo e($data->created_at); ?></td>
                                                            </tr>
                                                            
                                                           
                                                        </table>
                                                        </div>
                                                    </div>			
													
															  
                                                        </div>
														
														<div class="row">
														<h4>Screen Shot :- </h4>
														<?php $scrimage=array();
										                      $temp=explode(',',$data->screen_shot);
															  foreach($temp as $image){
                                                              $images[]=trim( str_replace( array('[',']') ,"" ,$image ) );
                                                                }
                                                                  $j=1;
                                                               foreach($images as $image){ ?>
															   <div class="col-md-2">
                                                        <div class="user-image">
															   <a href="<?php echo e(asset('assets/images/screenshot/'.$image)); ?>" download>Screen Shot <?php echo e($j); ?></a>
															   </div>
														
														
                                                    </div>
                                                           <?php $j++; }
                                                           ?>													
													
                                                </div>
												<br>
												<?php if($data->status=='notdelivered' || $data->status=='delivered' ) { ?>
													
												<?php }else{?>
												<div class="text-left" style="display:inline-block; width:100%; padding:30px 20px;"><a href="javascript:void(0)" class="add-btn btn-md"> <span data-toggle="modal" data-target="#exshipform-all" class="">Add Shipping<span></span></span></a></div>
												<?php } ?>
												<form  method="POST" action="<?php echo e(route('vendor-exchange-update',$data->id)); ?>" enctype="multipart/form-data" id="exshipform">
												<?php echo e(csrf_field()); ?>

												<div class="modal fade" id="exshipform-all" tabindex="-1" role="dialog" aria-labelledby="modal1" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="submit-loader">
                                            <img src="http://shop.webngigs.com/assets/images/1564224329loading3.gif" alt="">
                                        </div>
                                        <div class="modal-header d-block text-center">
                                            <h4 class="modal-title d-inline-block">SHIPPING DETAILS</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                        </div>
                                        <div class="modal-body">            <?php echo $__env->make('includes.vendor.form-both', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>                                        					
                   
                    <div class="row">
                        <div class="col-lg-12">
                         <input type="text" class="input-field" name="companyname" placeholder="<?php echo e(__('Courier Name')); ?>" required="">                           
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <input type="text" class="input-field" name="title" placeholder="<?php echo e(__('Tracking Code')); ?>" required="">
                    </div>

                   </div>
                    <div class="row">
                        <div class="col-lg-12">
                         <input type="text" class="input-field"  name="text" placeholder="<?php echo e(__('Tracking URL')); ?>" required="">          
                        </div>
                    </div>
                                   
                                        </div>
                                        <div class="modal-footer justify-content-center">
                                            <p align="center"><button type="submit"  class="exshipform-btn btn btn-success referesh-btn" name="save">ADD</button></p>
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
<?php echo $__env->make('layouts.vendor', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>