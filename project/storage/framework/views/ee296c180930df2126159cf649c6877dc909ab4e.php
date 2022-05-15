<?php $__env->startSection('content'); ?>

						<div class="content-area">
							<div class="add-product-content1">
								<div class="row">
									<div class="col-lg-12">
										<div class="product-description">
											<div class="body-area">
											<?php echo $__env->make('includes.admin.form-error', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?> 
											<form id="geniusformdata" action="<?php echo e(route('admin-vendor-verify-submit',$data->id)); ?>" method="POST" enctype="multipart/form-data">
												<?php echo e(csrf_field()); ?>

												<div class="row">
													<div class="col-lg-4">
														<div class="left-area">
																<h4 class="heading"><?php echo e(__('Details')); ?> *</h4>
																<p class="sub-heading"><?php echo e(__('(In Any Language)')); ?></p>
														</div>
													</div>
                                                    <div class="col-lg-7">
                                                        <textarea class="input-field" name="details" required="" placeholder="<?php echo e(__('Enter Verification Details')); ?>" rows="5"></textarea> 
                                                    </div>
												</div>
                                                <input type="hidden" name="user_id" value="<?php echo e($data->id); ?>">

												<div class="row">
													<div class="col-lg-4">
														<div class="left-area">
															
														</div>
													</div>
													<div class="col-lg-7">
														<button class="addProductSubmit-btn" type="submit"><?php echo e(__('Send')); ?></button>
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
<?php echo $__env->make('layouts.load', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>