 

<?php $__env->startSection('content'); ?>  
					<input type="hidden" id="headerdata" value="<?php echo e(__('CURRENCY')); ?>">
					<div class="content-area">
						<div class="mr-breadcrumb">
							<div class="row">
								<div class="col-lg-12">
										<h4 class="heading"><?php echo e(__('Update Shipping Rate')); ?></h4>
										<ul class="links">
											<li>
												<a href="<?php echo e(route('admin.dashboard')); ?>"><?php echo e(__('Dashboard')); ?> </a>
											</li>

						                      <li>
						                        <a href="javascript:;"><?php echo e(__('General Settings')); ?></a>
						                      </li>
											
											<li>
												<a href="<?php echo e(route('admin-manageshipping-index')); ?>"><?php echo e(__('Shipping Rate')); ?></a>
											</li>											
										</ul>
								</div>
							</div>
						</div>
						<div class="product-area">
							<div class="row">
								<div class="col-lg-12">
								 
									<div class="mr-table allproduct">

                        
										<div class="table-responsiv">
										<form id="shippingform" action="<?php echo e(route('admin-manageshipping-update')); ?>" method="POST" enctype="multipart/form-data">
										<?php echo e(csrf_field()); ?>

										<?php echo $__env->make('includes.admin.form-success', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?> 
                                        <?php echo $__env->make('includes.admin.form-error', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
												<table id="geniustable" class="table table-hover dt-responsive" cellspacing="0" width="100%">
													<thead>
														<tr>
									                        <th><?php echo e(__('Shipping Value(Product)')); ?></th>
									                        <th><?php echo e(__('Shipping Rate')); ?></th>									                        
														</tr>
													</thead>
													<tbody>
													<?php foreach($manageshippings as $manageshipping) { ?>
						<tr>		
				<td><input type="text" name="sh_value[]" placeholder="Shipping Value(<?php echo $manageshipping->shiping_value; ?>)" value="<?php echo $manageshipping->shiping_value; ?>" readonly></td>
				   
				<td><input type="text" name="sh_rate[]" placeholder="<?php echo e(__('Shipping Rate')); ?>" value="<?php echo $manageshipping->shiping_rate; ?>"></td>														
				</tr>
				<input type ="hidden" name="sh_id[]" value="<?php echo $manageshipping->id; ?>">
													<?php } ?>
												</tbody>
												</table>
												<input type ="hidden" name="sh_tot" value="<?php echo count($manageshippings); ?>">
												<button type="submit" class="btn btn-success referesh-btn" name="save">Submit</button>
												</form>
												
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
<?php $__env->stopSection(); ?>    
  
<?php echo $__env->make('layouts.admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>