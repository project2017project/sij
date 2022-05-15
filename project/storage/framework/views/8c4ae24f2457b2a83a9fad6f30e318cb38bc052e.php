<?php $__env->startSection('content'); ?>

						<div class="content-area">
							<div class="mr-breadcrumb">
								<div class="row">
									<div class="col-lg-12">
											<h4 class="heading"><?php echo e(__("Edit Vendor")); ?> <a class="add-btn" href="<?php echo e(url()->previous()); ?>"><i class="fas fa-arrow-left"></i> <?php echo e(__("Back")); ?></a></h4>
											<ul class="links">
												<li>
													<a href="<?php echo e(route('admin.dashboard')); ?>"><?php echo e(__("Dashboard")); ?> </a>
												</li>
												<li>
													<a href="<?php echo e(route('admin-vendor-index')); ?>"><?php echo e(__("Vendors")); ?></a>
												</li>
												<li>
													<a href="<?php echo e(route('admin-vendor-edit',$data->id)); ?>"><?php echo e(__("Edit")); ?></a>
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
												<?php echo $__env->make('includes.admin.form-both', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?> 

											<form id="geniusform" action="<?php echo e(route('admin-vendor-edit',$data->id)); ?>" method="POST" enctype="multipart/form-data">
												<?php echo e(csrf_field()); ?>


												<div class="row">
													<div class="col-lg-4">
														<div class="left-area">
																<h4 class="heading"><?php echo e(__("Email")); ?> *</h4>
														</div>
													</div>
													<div class="col-lg-7">
														<input type="email" class="input-field" name="email" placeholder="<?php echo e(__("Email Address")); ?>" value="<?php echo e($data->email); ?>" disabled="">
													</div>
												</div>


												<div class="row">
													<div class="col-lg-4">
														<div class="left-area">
																<h4 class="heading"><?php echo e(__("Shop Name")); ?> *</h4>
														</div>
													</div>
													<div class="col-lg-7">
														<input type="text" class="input-field" name="shop_name" placeholder="<?php echo e(__("Shop Name")); ?>" required="" value="<?php echo e($data->shop_name); ?>">
													</div>
												</div>




												<div class="row">
													<div class="col-lg-4">
														<div class="left-area">
																<h4 class="heading"><?php echo e(__("Shop Details")); ?> *</h4>
														</div>
													</div>
													<div class="col-lg-7">
													<textarea class="nic-edit" name="shop_details" placeholder="<?php echo e(__("Details")); ?>"><?php echo e($data->shop_details); ?></textarea> 
													</div>
												</div>

												<div class="row">
													<div class="col-lg-4">
														<div class="left-area">
																<h4 class="heading"><?php echo e(__("Owner Name")); ?> *</h4>
														</div>
													</div>
													<div class="col-lg-7">
														<input type="text" class="input-field" name="owner_name" placeholder="<?php echo e(__("Owner Name")); ?>" required="" value="<?php echo e($data->owner_name); ?>">
													</div>
												</div>


												<div class="row">
													<div class="col-lg-4">
														<div class="left-area">
																<h4 class="heading"><?php echo e(__("Shop Number")); ?> *</h4>
														</div>
													</div>
													<div class="col-lg-7">
														<input type="text" class="input-field" name="shop_number" placeholder="<?php echo e(__("Shop Number")); ?>" required="" value="<?php echo e($data->shop_number); ?>">
													</div>
												</div>

												<div class="row">
													<div class="col-lg-4">
														<div class="left-area">
																<h4 class="heading"><?php echo e(__("Shop Address")); ?> *</h4>
														</div>
													</div>
													<div class="col-lg-7">
														<input type="text" class="input-field" name="shop_address" placeholder="<?php echo e(__("Shop Address")); ?>" required="" value="<?php echo e($data->shop_address); ?>">
													</div>
												</div>


												<div class="row">
													<div class="col-lg-4">
														<div class="left-area">
																<h4 class="heading"><?php echo e(__("Registration Number")); ?> </h4>
																<p class="sub-heading"><?php echo e(__("(This Field is Optional)")); ?></p>
														</div>
													</div>
													<div class="col-lg-7">
														<input type="text" class="input-field" name="reg_number" placeholder="Registration Number" value="<?php echo e($data->reg_number); ?>">
													</div>
												</div>
												
												<div class="row">
													<div class="col-lg-4">
														<div class="left-area">
																<h4 class="heading"><?php echo e(__("Bank Name")); ?> </h4>
														</div>
													</div>
													<div class="col-lg-7">
														<input type="text" class="input-field" name="bank_name" placeholder="Bank Name" value="<?php echo e($data->bank_name); ?>">
													</div>
												</div>
												
												<div class="row">
													<div class="col-lg-4">
														<div class="left-area">
																<h4 class="heading"><?php echo e(__("Branch")); ?> </h4>
														</div>
													</div>
													<div class="col-lg-7">
														<input type="text" class="input-field" name="branch" placeholder="Branch" value="<?php echo e($data->branch); ?>">
													</div>
												</div>
												
												<div class="row">
													<div class="col-lg-4">
														<div class="left-area">
																<h4 class="heading"><?php echo e(__("IFSC Code")); ?> </h4>
														</div>
													</div>
													<div class="col-lg-7">
														<input type="text" class="input-field" name="ifsc_code" placeholder="IFSC Code" value="<?php echo e($data->ifsc_code); ?>">
													</div>
												</div>
												
												<div class="row">
													<div class="col-lg-4">
														<div class="left-area">
																<h4 class="heading"><?php echo e(__("Account Holder Name")); ?> </h4>
																
														</div>
													</div>
													<div class="col-lg-7">
														<input type="text" class="input-field" name="account_holder_name" placeholder="Account Holder Name" value="<?php echo e($data->account_holder_name); ?>">
													</div>
												</div>
												
												<div class="row">
													<div class="col-lg-4">
														<div class="left-area">
																<h4 class="heading"><?php echo e(__("Account Number")); ?> </h4>
														</div>
													</div>
													<div class="col-lg-7">
														<input type="text" class="input-field" name="account_number" placeholder="Account Number" value="<?php echo e($data->account_number); ?>">
													</div>
												</div>
												
												<div class="row">
													<div class="col-lg-4">
														<div class="left-area">
																<h4 class="heading"><?php echo e(__("Shop Logo")); ?> </h4>
														</div>
													</div>
													<div class="col-lg-7">
													<img src="<?php echo e(asset('assets/images/users/'.$data->shop_logo)); ?>">
													<input type="file" class="" name="shop_logo" required="">
														</div>
												</div>

												<div class="row">
													<div class="col-lg-4">
														<div class="left-area">
																<h4 class="heading"><?php echo e(__("Message")); ?> </h4>
																<p class="sub-heading"><?php echo e(__("(This Field is Optional)")); ?></p>
														</div>
													</div>
													<div class="col-lg-7">
														<input type="text" class="input-field" name="shop_message" placeholder="<?php echo e(__("Message")); ?>" value="<?php echo e($data->shop_message); ?>">
													</div>
												</div>

						                        <div class="row">
						                          <div class="col-lg-4">
						                            <div class="left-area">
						                              
						                            </div>
						                          </div>
						                          <div class="col-lg-7">
						                            <button class="addProductSubmit-btn" type="submit"><?php echo e(__("Submit")); ?></button>
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
<?php echo $__env->make('layouts.admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>