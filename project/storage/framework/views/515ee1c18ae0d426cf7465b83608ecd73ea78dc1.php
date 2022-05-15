<?php $__env->startSection('content'); ?>

						<div class="content-area">
							<div class="mr-breadcrumb">
								<div class="row">
									<div class="col-lg-12">
											<h4 class="heading"><?php echo e($langg->lang434); ?></h4>
											<ul class="links">
												<li>
													<a href="<?php echo e(route('vendor-dashboard')); ?>"><?php echo e($langg->lang441); ?> </a>
												</li>
												<li>
													<a href="<?php echo e(route('vendor-profile')); ?>"><?php echo e($langg->lang434); ?> </a>
												</li>
											</ul>
									</div>
								</div>
							</div>
							<div class="add-product-content1">
								<div class="row">
									<div class="col-lg-12">
										<div class="product-description">
											<div class="body-area">

				                        <div class="gocover" style="background: url(<?php echo e(asset('assets/images/'.$gs->admin_loader)); ?>) no-repeat scroll center center rgba(45, 45, 45, 0.5);"></div>
											<form id="geniusform" action="<?php echo e(route('vendor-profile-update')); ?>" method="POST" enctype="multipart/form-data">
												<?php echo e(csrf_field()); ?>


                      						 <?php echo $__env->make('includes.vendor.form-both', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>  

												<div class="row">
													<div class="col-lg-4">
														<div class="left-area">
																<h4 class="heading"><?php echo e($langg->lang457); ?>: </h4>
														</div>
													</div>
													<div class="col-lg-7">
														<div class="right-area">
																<h6 class="heading"> <?php echo e($data->shop_name); ?>

																	<?php if($data->checkStatus()): ?>
																	<a class="badge badge-success verify-link" href="javascript:;"><?php echo e($langg->lang783); ?></a>
																	<?php else: ?>
																	 <span class="verify-link"><a href="<?php echo e(route('vendor-verify')); ?>"><?php echo e($langg->lang784); ?></a></span>
																	<?php endif; ?>
																</h6>
														</div>
													</div>
												</div>

												<div class="row">
													<div class="col-lg-4">
														<div class="left-area">
																<h4 class="heading"><?php echo e($langg->lang458); ?> </h4>
														</div>
													</div>
													<div class="col-lg-7">
														<input type="text" class="input-field" name="owner_name" placeholder="<?php echo e($langg->lang458); ?>"  value="<?php echo e($data->owner_name); ?>">
													</div>
												</div>

												<div class="row">
													<div class="col-lg-4">
														<div class="left-area">
																<h4 class="heading"><?php echo e($langg->lang459); ?></h4>
														</div>
													</div>
													<div class="col-lg-7">
														<input type="text" class="input-field" name="shop_number" placeholder="<?php echo e($langg->lang459); ?>"  value="<?php echo e($data->shop_number); ?>" readonly>
													</div>
												</div>

												<div class="row">
													<div class="col-lg-4">
														<div class="left-area">
																<h4 class="heading"><?php echo e($langg->lang460); ?> *</h4>
														</div>
													</div>
													<div class="col-lg-7">
														<input type="text" class="input-field" name="shop_address" placeholder="<?php echo e($langg->lang460); ?>" value="<?php echo e($data->shop_address); ?>" readonly>
													</div>
												</div>

												<div class="row">
													<div class="col-lg-4">
														<div class="left-area">
																<h4 class="heading"><?php echo e(__('GST Number')); ?> </h4>
																
														</div>
													</div>
													<div class="col-lg-7">
														<input type="text" class="input-field" name="reg_number" placeholder="<?php echo e($langg->lang461); ?>"  value="<?php echo e($data->reg_number); ?>" readonly>
													</div>
												</div>
												
												<div class="row">
													<div class="col-lg-4">
														<div class="left-area">
																<h4 class="heading"><?php echo e(__("Bank Name")); ?> </h4>
														</div>
													</div>
													<div class="col-lg-7">
														<input type="text" class="input-field" name="bank_name" placeholder="Bank Name" value="<?php echo e($data->bank_name); ?>" readonly>
													</div>
												</div>
												
												<div class="row">
													<div class="col-lg-4">
														<div class="left-area">
																<h4 class="heading"><?php echo e(__("Branch")); ?> </h4>
														</div>
													</div>
													<div class="col-lg-7">
														<input type="text" class="input-field" name="branch" placeholder="Branch" value="<?php echo e($data->branch); ?>" readonly>
													</div>
												</div>
												
												<div class="row">
													<div class="col-lg-4">
														<div class="left-area">
																<h4 class="heading"><?php echo e(__("IFSC Code")); ?> </h4>
														</div>
													</div>
													<div class="col-lg-7">
														<input type="text" class="input-field" name="ifsc_code" placeholder="IFSC Code" value="<?php echo e($data->ifsc_code); ?>" readonly>
													</div>
												</div>
												
												<div class="row">
													<div class="col-lg-4">
														<div class="left-area">
																<h4 class="heading"><?php echo e(__("Account Holder Name")); ?> </h4>
																
														</div>
													</div>
													<div class="col-lg-7">
														<input type="text" class="input-field" name="account_holder_name" placeholder="Account Holder Name" value="<?php echo e($data->account_holder_name); ?>" readonly>
													</div>
												</div>
												
												<div class="row">
													<div class="col-lg-4">
														<div class="left-area">
																<h4 class="heading"><?php echo e(__("Account Number")); ?> </h4>
														</div>
													</div>
													<div class="col-lg-7">
														<input type="text" class="input-field" name="account_number" placeholder="Account Number" value="<?php echo e($data->account_number); ?>" readonly>
													</div>
												</div>
												
												<div class="row">
													<div class="col-lg-4">
														<div class="left-area">
																<h4 class="heading"><?php echo e(__("Commission")); ?> </h4>
														</div>
													</div>
													<div class="col-lg-7">
														<input type="text" class="input-field" name="percentage_commission" placeholder="Commission" value="<?php echo e($data->percentage_commission); ?>" readonly>
													</div>
												</div>
												

												<div class="row">
													<div class="col-lg-4">
														<div class="left-area">
																<h4 class="heading"><?php echo e($langg->lang463); ?> </h4>
														</div>
													</div>
													<div class="col-lg-7">
														<textarea class="input-field nic-edit" name="shop_details" placeholder="<?php echo e($langg->lang463); ?>" disabled="disabled"><?php echo e($data->shop_details); ?></textarea>
													</div>
												</div>
												
												
													<div class="row">
													<div class="col-lg-4">
														<div class="left-area">
																<h4 class="heading">Shop Logo </h4>
														</div>
													</div>
													<div class="col-lg-7">
													    <img id="shop_logo" src="<?php echo e(Auth::user()->shop_logo ? asset('assets/images/users/'.Auth::user()->shop_logo ):asset('assets/images/noimage.png')); ?>" style="width:100px;">
														<input type="file" class="input-field" name="shop_logo">
													</div>
												</div>
												
												
												<div class="row">
													<div class="col-lg-4">
														<div class="left-area">
																<h4 class="heading">Shop Banner </h4>
														</div>
													</div>
													<div class="col-lg-7">
													    <img id="shop_image" src="<?php echo e(Auth::user()->shop_image ? asset('assets/images/vendorbanner/'.Auth::user()->shop_image ):asset('assets/images/noimage.png')); ?>" style="width:300px;">
														<input type="file" class="input-field" name="shop_image">
													</div>
												</div>
												
												
												<div class="row">
													<div class="col-lg-4">
														<div class="left-area">
																<h4 class="heading"><?php echo e(__('Country')); ?> *</h4>
														</div>
													</div>
													<div class="col-lg-7">
														<select class="form-control" name="country" id="country" disabled="disabled">
														<option value=""><?php echo e($langg->lang157); ?></option>
<?php if(Auth::check()): ?>
	<?php $__currentLoopData = DB::table('countries')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $datas): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
	<option data-href="<?php echo e(route('front-state-load',$datas->id)); ?>" value="<?php echo e($datas->name); ?>" <?php echo e(Auth::user()->country == $datas->name ? 'selected' : ''); ?>><?php echo e($datas->name); ?></option>		
	<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php else: ?>
	<?php $__currentLoopData = DB::table('countries')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $datas): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
	<option data-href="<?php echo e(route('front-state-load',$datas->id)); ?>" value="<?php echo e($datas->name); ?>"><?php echo e($datas->name); ?></option>		
	<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>
													</select>
													</div>
												</div>
												
												<div class="row">
													<div class="col-lg-4">
														<div class="left-area">
																<h4 class="heading"><?php echo e(__('State')); ?> *</h4>
														</div>
													</div>
													
													<div class="col-lg-7">
														<select class="form-control" name="state" id="state" disabled="disabled">
														<?php if($data->state): ?>
															<option value="<?php echo e($data->state); ?>"><?php echo e($data->state); ?></option>
															<?php else: ?>
														<option value=""><?php echo e(__('Select State')); ?></option>
													<?php endif; ?>
													</select>
													</div>
												</div>

						                        <div class="row">
						                          <div class="col-lg-4">
						                            <div class="left-area">
						                              
						                            </div>
						                          </div>
						                          <div class="col-lg-7">
						                            <button class="addProductSubmit-btn" type="submit"><?php echo e($langg->lang464); ?></button>
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
<?php echo $__env->make('layouts.vendor', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>