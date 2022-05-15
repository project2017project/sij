 

<?php $__env->startSection('content'); ?>  
					<input type="hidden" id="headerdata" value="<?php echo e(__('CURRENCY')); ?>">
					<div class="content-area">
						<div class="mr-breadcrumb">
							<div class="row">
								<div class="col-lg-12">
										<h4 class="heading"><?php echo e(__('Update All Currencies')); ?></h4>
										<ul class="links">
											<li>
												<a href="<?php echo e(route('admin.dashboard')); ?>"><?php echo e(__('Dashboard')); ?> </a>
											</li>

						                      <li>
						                        <a href="javascript:;"><?php echo e(__('Payment Settings')); ?></a>
						                      </li>
											
											<li>
												<a href="<?php echo e(route('admin-currency-index')); ?>"><?php echo e(__('Currencies')); ?></a>
											</li>
											<li>
												<a href="<?php echo e(route('admin-currency-updatecurrency')); ?>"><?php echo e(__('Update All Currencies')); ?></a>
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
										<form id="currencyform" action="<?php echo e(route('admin-currency-allupdate')); ?>" method="POST" enctype="multipart/form-data">
										<?php echo e(csrf_field()); ?>

										<?php echo $__env->make('includes.admin.form-success', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?> 
                                        <?php echo $__env->make('includes.admin.form-error', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
												<table id="geniustable" class="table table-hover dt-responsive" cellspacing="0" width="100%">
													<thead>
														<tr>
									                        <th><?php echo e(__('Name')); ?></th>
									                        <th><?php echo e(__('Sign')); ?></th>
									                        <th><?php echo e(__('Value')); ?></th>
									                        <th><?php echo e(__('Original Inr')); ?></th>
														</tr>
													</thead>
													<tbody>
													<?php foreach($currencies as $currencie) { ?>
													<tr>													 
                                                     <td><?php echo e($currencie->name); ?></td>
													  <td><?php echo e($currencie->sign); ?></td>
													   <?php
                                 $cur_name = $currencie->name;
                                  $convert_price = '';
                                  $req_url = 'https://data.fixer.io/api/latest?access_key=08a8c08ca50b6682a460ccb346be0750&base=INR';
                                  $response_json = file_get_contents($req_url);
                                  if(false !== $response_json) {

                                      try {
                                      
                                      $response = json_decode($response_json);
                                      if(1 ==$response->success) {
                                          $base_price = 1.10;
                                        $convert_price = round(($base_price * $response->rates->$cur_name), 3);

                                      }

                                      }
                                      catch(Exception $e) {
                                         
                                      }

                                  }
                                  
								  ?>
  
				<td><input type="text" name="cur_value[]" placeholder="<?php echo e(__('Enter Currency Sign')); ?>" value="<?php echo $convert_price; ?>"></td>
				   <?php
                               $cur_nameo = $currencie->name;
							   $convert_priceo ='';
							   $req_url = 'https://data.fixer.io/api/latest?access_key=08a8c08ca50b6682a460ccb346be0750&base='. $cur_nameo;
                               $response_json = file_get_contents($req_url);
                                 if(false !== $response_json) {

                                      try {
                                      
                                      $response = json_decode($response_json);
                                      if(1 ==$response->success) {
                                          $base_price = 1;
                                        $convert_priceo = round(($base_price * $response->rates->INR), 3);

                                      }

                                      }
                                      catch(Exception $e) {
                                         
                                      }

                                  }
							   
                            ?>
				<td><input type="text" name="cur_orgvalue[]" placeholder="<?php echo e(__('Enter Currency Sign')); ?>" value="<?php echo $convert_priceo ?>"></td>														
				</tr>
				<input type ="hidden" name="cur_id[]" value="<?php echo $currencie->id ?>">
													<?php } ?>
												</tbody>
												</table>
												<input type ="hidden" name="cur_tot" value="<?php echo count($currencies); ?>">
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