<?php $__env->startSection('content'); ?>

						<div class="content-area">
							<div class="mr-breadcrumb">
								<div class="row">
									<div class="col-lg-12">
											<h4 class="heading"><?php echo e(__('Edit Profile')); ?></h4>
											<ul class="links">
												<li>
													<a href="<?php echo e(route('admin.dashboard')); ?>"><?php echo e(__('Dashboard')); ?> </a>
												</li>
												<li>
													<a href="<?php echo e(route('admin.profile')); ?>"><?php echo e(__('Edit Profile')); ?> </a>
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
											<form id="geniusform" action="<?php echo e(route('admin.profile.update')); ?>" method="POST" enctype="multipart/form-data">
												<?php echo e(csrf_field()); ?>


                        <?php echo $__env->make('includes.admin.form-both', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>  

						                        <div class="row">
						                          <div class="col-lg-4">
						                            <div class="left-area">
						                                <h4 class="heading"><?php echo e(__('Current Profile Image')); ?> *</h4>
						                            </div>
						                          </div>
						                          <div class="col-lg-7">
						                            <div class="img-upload">
						                                <div id="image-preview" class="img-preview" style="background: url(<?php echo e($data->photo ? asset('assets/images/admins/'.$data->photo):asset('assets/images/noimage.png')); ?>);">
						                                    <label for="image-upload" class="img-label" id="image-label"><i class="icofont-upload-alt"></i><?php echo e(__('Upload Image')); ?></label>
						                                    <input type="file" name="photo" class="img-upload" id="image-upload">
						                                  </div>
						                            </div>
						                          </div>
						                        </div>


												<div class="row">
													<div class="col-lg-4">
														<div class="left-area">
																<h4 class="heading"><?php echo e(__('Name')); ?> *</h4>
														</div>
													</div>
													<div class="col-lg-7">
														<input type="text" class="input-field" name="name" placeholder="<?php echo e(__('User Name')); ?>" required="" value="<?php echo e($data->name); ?>">
													</div>
												</div>


												<div class="row">
													<div class="col-lg-4">
														<div class="left-area">
																<h4 class="heading"><?php echo e(__('Email')); ?> *</h4>
														</div>
													</div>
													<div class="col-lg-7">
														<input type="email" class="input-field" name="email" placeholder="<?php echo e(__('Email Address')); ?>" required="" value="<?php echo e($data->email); ?>">
													</div>
												</div>

												<div class="row">
													<div class="col-lg-4">
														<div class="left-area">
																<h4 class="heading"><?php echo e(__('Phone')); ?> *</h4>
														</div>
													</div>
													<div class="col-lg-7">
														<input type="text" class="input-field" name="phone" placeholder="<?php echo e(__('Phone Number')); ?>" required="" value="<?php echo e($data->phone); ?>">
													</div>
												</div>

											<?php if(Auth::guard('admin')->user()->id == 1): ?>
												<div class="row">
													<div class="col-lg-4">
														<div class="left-area">
															<h4 class="heading"><?php echo e(__('Shop Name')); ?> *</h4>
														</div>
													</div>
													<div class="col-lg-7">
														<input type="text" class="input-field" name="shop_name" placeholder="<?php echo e(__('Shop Name')); ?>" required="" value="<?php echo e($data->shop_name); ?>">
													</div>
												</div>
											<?php endif; ?>
											
											<div class="row">
													<div class="col-lg-4">
														<div class="left-area">
																<h4 class="heading"><?php echo e(__('GST Number')); ?> *</h4>
														</div>
													</div>
													<div class="col-lg-7">
														<input type="text" class="input-field" name="gst_number" placeholder="<?php echo e(__('GST Number')); ?>" required="" value="<?php echo e($data->gst_number); ?>">
													</div>
												</div>
												
												<div class="row">
													<div class="col-lg-4">
														<div class="left-area">
																<h4 class="heading"><?php echo e(__('Address')); ?> *</h4>
														</div>
													</div>
													<div class="col-lg-7">
														<input type="text-area" class="input-field" name="address" placeholder="<?php echo e(__('Address')); ?>" required="" value="<?php echo e($data->address); ?>">
													</div>
												</div>
												
												<div class="row">
													<div class="col-lg-4">
														<div class="left-area">
																<h4 class="heading"><?php echo e(__('Country')); ?> *</h4>
														</div>
													</div>
													<div class="col-lg-7">
														<select class="form-control" name="admin_country" id="admin_country" required="">
														<option value=""><?php echo e($langg->lang157); ?></option>
<?php if(Auth::check()): ?>
	<?php $__currentLoopData = DB::table('countries')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $datas): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
	<option data-href="<?php echo e(route('front-state-load',$datas->id)); ?>" value="<?php echo e($datas->name); ?>" <?php echo e(Auth::user()->admin_country == $datas->name ? 'selected' : ''); ?>><?php echo e($datas->name); ?></option>		
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
														<select class="form-control" name="admin_state" id="admin_state" required="">
														<?php if($data->admin_state): ?>
															<option value="<?php echo e($data->admin_state); ?>"><?php echo e($data->admin_state); ?></option>
															<?php else: ?>
														<option value=""><?php echo e(__('Select State')); ?></option>
													<?php endif; ?>
													</select>
													</div>
												</div>
												
												<div class="row">
													<div class="col-lg-4">
														<div class="left-area">
																<h4 class="heading"><?php echo e(__('City')); ?> *</h4>
														</div>
													</div>
													<div class="col-lg-7">
														<input type="text" class="input-field" name="city" placeholder="<?php echo e(__('City')); ?>" required="" value="<?php echo e($data->city); ?>">
													</div>
												</div>
												
												<div class="row">
													<div class="col-lg-4">
														<div class="left-area">
																<h4 class="heading"><?php echo e(__('Zip Code')); ?> *</h4>
														</div>
													</div>
													<div class="col-lg-7">
														<input type="text" class="input-field" name="zip_code" placeholder="<?php echo e(__('Zip Code')); ?>" required="" value="<?php echo e($data->zip_code); ?>">
													</div>
												</div>



						                        <div class="row">
						                          <div class="col-lg-4">
						                            <div class="left-area">
						                              
						                            </div>
						                          </div>
						                          <div class="col-lg-7">
						                            <button class="addProductSubmit-btn" type="submit"><?php echo e(__('Save')); ?></button>
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