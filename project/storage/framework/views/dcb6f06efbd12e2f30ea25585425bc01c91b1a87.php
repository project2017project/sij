<?php $__env->startSection('styles'); ?>

<style type="text/css">
	
	    .root.root--in-iframe {
      background: #4682b447 !important;
    }
</style>

<?php $__env->stopSection(); ?>



<?php $__env->startSection('content'); ?>

<!-- Breadcrumb Area Start -->
<!-- <div class="breadcrumb-area">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<ul class="pages">
					<li>
						<a href="<?php echo e(route('front.index')); ?>">
							<?php echo e($langg->lang17); ?>

						</a>
					</li>
					<li>
						<a href="<?php echo e(route('front.checkout')); ?>">
							<?php echo e($langg->lang136); ?>

						</a>
					</li>
				</ul>
			</div>
		</div>
	</div>
</div> -->
<!-- Breadcrumb Area End -->

	<!-- Check Out Area Start -->
	<section class="checkout">
		<div class="container">
			<div class="row">
				<div class="col-lg-12" style="position: absolute; visibility: hidden; opacity: 0;">
					<div class="checkout-area mb-0 pb-0">
						<div class="checkout-process">
							<ul class="nav"  role="tablist">
								<li class="nav-item">
									<a class="nav-link active" id="pills-step1-tab" data-toggle="pill" href="#pills-step1" role="tab" aria-controls="pills-step1" aria-selected="true">
									<span>1</span> <?php echo e($langg->lang743); ?>

									<i class="far fa-address-card"></i>
									</a>
								</li>
								<li class="nav-item">
									<a class="nav-link disabled" id="pills-step2-tab" data-toggle="pill" href="#pills-step2" role="tab" aria-controls="pills-step2" aria-selected="false" >
										<span>2</span> <?php echo e($langg->lang744); ?> 
										<i class="fas fa-dolly"></i>
									</a>
								</li>
								<li class="nav-item">
									<a class="nav-link disabled" id="pills-step3-tab" data-toggle="pill" href="#pills-step3" role="tab" aria-controls="pills-step3" aria-selected="false">
											<span>3</span> <?php echo e($langg->lang745); ?>

											<i class="far fa-credit-card"></i>
									</a>
								</li>
							</ul>
						</div>
					</div>
				</div>


				<div class="col-lg-7">

				 




		<form id="" action="" method="POST" class="checkoutform">

			<?php echo $__env->make('includes.form-success', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
			<?php echo $__env->make('includes.form-error', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

			<?php echo e(csrf_field()); ?>


					<div class="checkout-area"  style="padding-top: 0px;">
						<div class="tab-content" id="pills-tabContent">
							<div class="tab-pane fade show active" id="pills-step1" role="tabpanel" aria-labelledby="pills-step1-tab">


								  <div class="hiraola-product_area hiraola-product_area-2 section-space_add" style="padding-top: 0; padding-bottom: 0;">
            <div class="container">
                <div class="row">
      <div class="col-lg-12">
        <div class="hiraola-section_title">
            <h4>Billing & Shipping Address</h4>
        </div>
      </div>

    

    </div>
  </div>
</div>


								<div class="content-box">
								
									<div class="content">
										<div class="personal-info">
											<h5 class="title">
												<?php echo e($langg->lang746); ?>:  <?php if(!Auth::guard('web')->check()): ?> <span style="float: right; font-size : 15px; font-weight:400;"> Already have an account ? <a href="<?php echo e(route('user.login')); ?>"> Login</a> </span> <?php endif; ?> 
											</h5>
											<div class="row">
												<div class="col-lg-6">
												    <label>Your Name <abbr class="required text-danger" title="required">*</abbr></label>
													<input type="text" onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode==32)"  id="personal-name" class="form-control" name="personal_name" placeholder="<?php echo e($langg->lang747); ?>" value="<?php echo e(Auth::check() ? Auth::user()->name : ''); ?>" <?php echo Auth::check() ? 'readonly' : ''; ?>>
												</div>
												<div class="col-lg-6">
												    <label>Your Email <abbr class="required text-danger" title="required">*</abbr></label>
													<input type="email" id="personal-email" class="form-control" name="personal_email" placeholder="<?php echo e($langg->lang748); ?>" value="<?php echo e(Auth::check() ? Auth::user()->email : ''); ?>"  <?php echo Auth::check() ? 'readonly' : ''; ?>>
												</div>
											</div>
											<?php if(!Auth::check()): ?>
											<div class="row">
												<div class="col-lg-12 mt-3">
														<input class="styled-checkbox" id="open-pass" type="checkbox" value="1" name="pass_check">
														<label for="open-pass"><?php echo e($langg->lang749); ?></label>
												</div>
											</div>
											
												
											
											<div class="row set-account-pass d-none">
												<div class="col-lg-6">
													<input type="password" name="personal_pass" id="personal-pass" class="form-control" placeholder="<?php echo e($langg->lang750); ?>">
												</div>
												<div class="col-lg-6">
													<input type="password" name="personal_confirm" id="personal-pass-confirm" class="form-control" placeholder="<?php echo e($langg->lang751); ?>">
												</div>
											</div>
											<?php endif; ?>
											
											
										
											
											
											
											
										</div>
										<div class="billing-address">
											<h5 class="title">
												<?php echo e($langg->lang147); ?>

											</h5>
											<div class="row">
											<div class="col-lg-6 hidden-select <?php echo e($digital == 1 ? 'hidden-select' : ''); ?>">
													<select class="form-control" id="shipop" name="shipping" required="">
														<option value="shipto"><?php echo e($langg->lang149); ?></option>
													</select>
												</div>
		
											
		
												<div class="col-lg-6">
												     <label><?php echo e($langg->lang152); ?> <abbr class="required text-danger" title="required">*</abbr></label>
													<input class="form-control" type="text" onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode==32)"  name="name"
														placeholder="<?php echo e($langg->lang152); ?>" required=""
														value="<?php echo e(Auth::guard('web')->check() ? Auth::guard('web')->user()->name : ''); ?>">
												</div>
												<div class="col-lg-6">
												    <label><?php echo e($langg->lang153); ?> <abbr class="required text-danger" title="required">*</abbr></label>
													<input class="form-control" type="tel" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"   title="Phone number must be of 10 digit(0 or + not required at start)" name="phone"
														placeholder="<?php echo e($langg->lang153); ?>" required=""
														value="<?php echo e(Auth::guard('web')->check() ? Auth::guard('web')->user()->phone : ''); ?>">
												</div>
												<div class="col-lg-12">
												    <label><?php echo e($langg->lang154); ?> <abbr class="required text-danger" title="required">*</abbr></label>
													<input class="form-control" type="text" name="email"
														placeholder="<?php echo e($langg->lang154); ?>" required=""
														value="<?php echo e(Auth::guard('web')->check() ? Auth::guard('web')->user()->email : ''); ?>">
												</div>
												<div class="col-lg-6">
												    <label><?php echo e($langg->lang155); ?> <abbr class="required text-danger" title="required">*</abbr></label>
													<input class="form-control" type="text" name="address"
														placeholder="<?php echo e($langg->lang155); ?>" required=""
														value="<?php echo e(Auth::guard('web')->check() ? Auth::guard('web')->user()->address : ''); ?>">
												</div>
												<div class="col-lg-6">
												    <label>Country <abbr class="required text-danger" title="required">*</abbr></label>
													<select class="form-control" name="customer_country" id="country" required="">
														<?php echo $__env->make('includes.countries', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
													</select>
												</div><div class="col-lg-6">
												    <label>State <abbr class="required text-danger" title="required">*</abbr></label>
                                                    <select class="form-control" id="state" name="customer_state"  required="">
                                                        <option value=""><?php echo e(__('Select State')); ?></option>
                                                    </select>
												</div>
												<div class="col-lg-6">
												    <label><?php echo e($langg->lang158); ?> <abbr class="required text-danger" title="required">*</abbr></label>
													<input class="form-control" type="text" name="city"
														placeholder="<?php echo e($langg->lang158); ?>" required=""
														value="<?php echo e(Auth::guard('web')->check() ? Auth::guard('web')->user()->city : ''); ?>">
												</div>
												<div class="col-lg-6">
												    <label><?php echo e($langg->lang159); ?> <abbr class="required text-danger" title="required">*</abbr></label>
													<input class="form-control" type="text" name="zip"
														placeholder="<?php echo e($langg->lang159); ?>" required=""
														value="<?php echo e(Auth::guard('web')->check() ? Auth::guard('web')->user()->zip : ''); ?>">
												</div>
												<div class="col-lg-6">
												    <label>Landmark <abbr class="required text-danger" title="required">*</abbr></label>
													<input class="form-control" type="text" name="customer_landmark" placeholder="Landmark" required="" value="">
												</div>
											</div>
										</div>
										<div class="row <?php echo e($digital == 1 ? 'd-none' : ''); ?>">
											<div class="col-lg-12 mt-3">
													<input class="styled-checkbox" id="ship-diff-address" type="checkbox" value="value1" >
													<label for="ship-diff-address"><?php echo e($langg->lang160); ?></label>
											</div>
										</div>
										<div class="ship-diff-addres-area d-none">
												<h5 class="title">
														<?php echo e($langg->lang752); ?>

												</h5>
											<div class="row">
												<div class="col-lg-6">
												    <label><?php echo e($langg->lang152); ?> <abbr class="required text-danger" title="required">*</abbr></label>
													<input class="form-control ship_input" onkeypress="return (event.charCode > 64 && event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode==32)"  type="text" name="shipping_name"
														id="shippingFull_name" placeholder="<?php echo e($langg->lang152); ?>">
														<input type="hidden" name="shipping_email" value="">
												</div>
												<div class="col-lg-6">
												    <label><?php echo e($langg->lang153); ?> <abbr class="required text-danger" title="required">*</abbr></label>
													<input class="form-control ship_input" type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"  name="shipping_phone"
														id="shipingPhone_number" placeholder="<?php echo e($langg->lang153); ?>">
												</div>
											</div>
											<div class="row">
												<div class="col-lg-6">
												    <label><?php echo e($langg->lang155); ?> <abbr class="required text-danger" title="required">*</abbr></label>
													<input class="form-control ship_input" type="text" name="shipping_address"
														id="shipping_address" placeholder="<?php echo e($langg->lang155); ?>">
												</div>

											
												
												<div class="col-lg-6">
												    <label>Country <abbr class="required text-danger" title="required">*</abbr></label>
													<select class="form-control ship_input" id="shipping_country" name="shipping_country">
														<?php echo $__env->make('includes.countries', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
													</select>
												</div><div class="col-lg-6">
												    <label>State <abbr class="required text-danger" title="required">*</abbr></label>
                                                     <select id="shipping_state" class="form-control" name="shipping_state">
                                                        <option value=""><?php echo e(__('Select State')); ?></option>
                                                    </select>
												</div>
												<div class="col-lg-6">
													<label><?php echo e($langg->lang158); ?> <abbr class="required text-danger" title="required">*</abbr></label>
													<input class="form-control ship_input" type="text" name="shipping_city"
														id="shipping_city" placeholder="<?php echo e($langg->lang158); ?>">
												</div>
												
											</div>
											<div class="row">
												
												<div class="col-lg-6">
												    <label><?php echo e($langg->lang159); ?> <abbr class="required text-danger" title="required">*</abbr></label>
													<input class="form-control ship_input" type="text" name="shipping_zip"
														id="shippingPostal_code" placeholder="<?php echo e($langg->lang159); ?>">
												</div>
												<div class="col-lg-6">
												    <label>Landmark <abbr class="required text-danger" title="required">*</abbr></label>
													<input class="form-control ship_input" type="text" name="shipping_landmark"
														id="shipping_landmark" placeholder="Landmark">
												</div>
												<!--div class="col-lg-6">
													<input class="form-control" type="text" name="shipping_landmark" placeholder="Landmark" required="" value="">
												</div-->

											</div>

										</div>
										<!--<div class="order-note mt-3">
											<div class="row">
												<div class="col-lg-12">
												<input type="text" id="Order_Note" class="form-control" name="order_notes" placeholder="<?php echo e($langg->lang217); ?> (<?php echo e($langg->lang218); ?>)">
												</div>
											</div>
										</div>-->
									<!--	<div class="row">
											<div class="col-lg-12  mt-3">
												<div class="bottom-area paystack-area-btn" style="margin-top: 30px;">
													<button type="submit"  class="mybtn1 rev-btn-ct">Review Order</button>
												</div>
												
											</div>
										</div>-->
									</div>
								</div>
								<div class="content-box">
									<div class="content">

			<div class="submit-loader">
				<img src="<?php echo e(asset('assets/images/loading_large.gif')); ?>" alt="">
			</div>

			<div class="hiraola-product_area hiraola-product_area-2 section-space_add" style="padding-top: 0; padding-bottom: 0;">
			    <div class="sipping_wrap_international">
			   <div class="packeging-area shiping-rate" style="display:none">
              
            <h4 class="title">Shipping Cost</h4>
			
<?php
						$product_count=0;						
						foreach(Session::get('cart')->items as $cval){	
						
						if (is_numeric($cval['qty']) && !empty($cval['qty'])){ 
							
                           $product_count += ($cval['qty']);
						}}
						   
  ?>

								<?php $product_arr = array();
                                  $numItems = count($manage_shippings);
                                 $i = 0; 
								 
							foreach($manage_shippings as $manage_shipping){ 
						$product_arr = explode(",",$manage_shipping->sh_last_val);							
                            if($product_count <= 20){							
						if (in_array($product_count, $product_arr)){
							?>
								<div class="radio-design">
										<input type="radio" class="shippingdata" id="shipping-data" name="shipping" value="<?php echo round($manage_shipping->shiping_rate * $curr->value,2); ?>" checked> 
										<span class="checkmark"></span>
										<label for="shipping-data"> 
											 <?php if($manage_shipping->shiping_rate != 0) { 
										   echo 'Shipping Rate '.' + '.$curr->sign.round($manage_shipping->shiping_rate * $curr->value,2);
												
										   } ?>									
										</label>
								</div>
						<?php }
							}elseif($product_count >= 21) {
if(++$i === $numItems) {
	?>
<div class="radio-design">
										<input type="radio" class="shippingdata" id="shipping-data" name="shipping" value="<?php echo round($manage_shipping->shiping_rate * $curr->value,2); ?>" checked> 
										<span class="checkmark"></span>
										<label for="shipping-data"> 
											
                                           <?php if($manage_shipping->shiping_rate != 0) { 
										   echo 'Shipping Rate '.' + '.$curr->sign.round($manage_shipping->shiping_rate * $curr->value,2);
												
										   } ?>										
										</label>
								</div>
							<?php }}} ?>	

						
						
        
  </div>
  </div>
  <!--
            <div class="container">
                <div class="row">
        <div class="hiraola-section_title">
            <h4>Shipping Info</h4>
        </div>

    

    </div>
  </div>-->
</div>
											<div class="billing-info-area <?php echo e($digital == 1 ? 'd-none' : ''); ?>">
															
													<ul class="info-list">
														<li>
															<p id="shipping_user"></p>
														</li>
														<li>
															<p id="shipping_location"></p>
														</li>
														<li>
															<p id="shipping_phone"></p>
														</li>
														<li>
															<p id="shipping_email"></p>
														</li>
													</ul>
											</div>

											<div class="hiraola-product_area hiraola-product_area-2 section-space_add" style="padding-top: 50px; padding-bottom: 0;">
            <div class="container">
                <div class="row">
        <div class="hiraola-section_title">
            <h4>Select Payment Method</h4>
        </div>
      

    

    </div>
  </div>
</div>
											<div class="payment-information">
													
												<div class="row">
													<div class="col-lg-12">
														<div class="nav flex-column"  role="tablist" aria-orientation="vertical">
														    
														    	<?php if($gs->is_razorpay == 1): ?>
																	<a class="nav-link payment" data-val="" data-show="no" data-form="<?php echo e(route('razorpay.submit')); ?>" data-href="<?php echo e(route('front.load.payment',['slug1' => 'razorpay','slug2' => 0])); ?>"  id="v-pills-tab6-tab" data-toggle="pill" href="#v-pills-tab6" role="tab" aria-controls="v-pills-tab6" aria-selected="false">
																			<div class="icon">
																					<span class="radio"></span>
																			</div>
																			<p>
																					
																				Credit Card/Debit Card/NetBanking   <img src="https://cdn.razorpay.com/static/assets/logo/payment.svg" style="width:auto;">
		
																				<?php if($gs->razorpay_text != null): ?>
		
																				<small>
																						<?php echo e($gs->razorpay_text); ?>

																				</small>
		
																				<?php endif; ?>
		
																			</p>
																	</a>
																	<?php endif; ?>
															
															<?php if($gs->is_ccavenue == 1): ?>
													            <a class="nav-link payment" data-val="" data-show="no" data-form="<?php echo e(route('ccavenue.submit')); ?>" data-href="<?php echo e(route('front.load.payment',['slug1' => 'ccavenue','slug2' => 0])); ?>"  id="v-pills-tab5-tab" data-toggle="pill" href="#v-pills-tab5" role="tab" aria-controls="v-pills-tab5" aria-selected="false">
																		<div class="icon">
																				<span class="radio"></span>
																		</div>
																		<p>
																				CCAvenue <img src="https://shop.southindiajewels.com/wp-content/plugins/ccavanue-woocommerce-payment-getway/images/logo.png" style="width:auto;">
	
																			<?php if($gs->ccavenue_text != null): ?>
	
																			<small>
																					<?php echo e($gs->ccavenue_text); ?>

																			</small>
	
																			<?php endif; ?>
	
																		</p>
																</a>	
															<?php endif; ?>
														    
														<?php if($gs->paypal_check == 1): ?>
															<a class="nav-link payment" data-val="" data-show="no" data-form="<?php echo e(route('paypal.submit')); ?>" data-href="<?php echo e(route('front.load.payment',['slug1' => 'paypal','slug2' => 0])); ?>" id="v-pills-tab1-tab" data-toggle="pill" href="#v-pills-tab1" role="tab" aria-controls="v-pills-tab1" aria-selected="true">
																	<div class="icon">
																			<span class="radio"></span>
																	</div>
																<p>
																		<?php echo e($langg->lang760); ?>


																	<?php if($gs->paypal_text != null): ?>

																	<small>
																			<?php echo e($gs->paypal_text); ?>

																	</small>

																	<?php endif; ?>

																</p>
															</a>
														<?php endif; ?>
														<?php if($gs->stripe_check == 1): ?>
															<a class="nav-link payment" data-val="" data-show="yes" data-form="<?php echo e(route('stripe.submit')); ?>" data-href="<?php echo e(route('front.load.payment',['slug1' => 'stripe','slug2' => 0])); ?>" id="v-pills-tab2-tab" data-toggle="pill" href="#v-pills-tab2" role="tab" aria-controls="v-pills-tab2" aria-selected="false">
																	<div class="icon">
																			<span class="radio"></span>
																	</div>
																	<p>
																	<?php echo e($langg->lang761); ?>


																		<?php if($gs->stripe_text != null): ?>

																		<small>
																			<?php echo e($gs->stripe_text); ?>

																		</small>

																		<?php endif; ?>

																	</p>
															</a>
														<?php endif; ?>
														<?php if($gs->cod_check == 1): ?>
														 <?php if($digital == 0): ?>
															<a class="nav-link payment cash-ondel" data-val="" data-show="no" data-form="<?php echo e(route('cash.submit')); ?>" data-href="<?php echo e(route('front.load.payment',['slug1' => 'cod','slug2' => 0])); ?>" id="v-pills-tab3-tab" data-toggle="pill" href="#v-pills-tab3" role="tab" aria-controls="v-pills-tab3" aria-selected="false">
																	<div class="icon">
																			<span class="radio"></span>
																	</div>
																	<p>Gift Cards</p>
																	<!--p>
																			<?php echo e($langg->lang762); ?>


																		<?php if($gs->cod_text != null): ?>

																		<small>
																				<?php echo e($gs->cod_text); ?>

																		</small>

																		<?php endif; ?>

																	</p-->
															</a>
														 <?php endif; ?>
														<?php endif; ?>
														<?php if($gs->is_instamojo == 1): ?>
															<a class="nav-link payment" data-val="" data-show="no" data-form="<?php echo e(route('instamojo.submit')); ?>" data-href="<?php echo e(route('front.load.payment',['slug1' => 'instamojo','slug2' => 0])); ?>"  id="v-pills-tab4-tab" data-toggle="pill" href="#v-pills-tab4" role="tab" aria-controls="v-pills-tab4" aria-selected="false">
																	<div class="icon">
																			<span class="radio"></span>
																	</div>
																	<p>
																			<?php echo e($langg->lang763); ?>


																		<?php if($gs->instamojo_text != null): ?>

																		<small>
																				<?php echo e($gs->instamojo_text); ?>

																		</small>

																		<?php endif; ?>

																	</p>
															</a>
															<?php endif; ?>
															
															
															<?php if($gs->is_paytm == 1): ?>
																<a class="nav-link payment" data-val="" data-show="no" data-form="<?php echo e(route('paytm.submit')); ?>" data-href="<?php echo e(route('front.load.payment',['slug1' => 'paytm','slug2' => 0])); ?>"  id="v-pills-tab5-tab" data-toggle="pill" href="#v-pills-tab5" role="tab" aria-controls="v-pills-tab5" aria-selected="false">
																		<div class="icon">
																				<span class="radio"></span>
																		</div>
																		<p>
																				<?php echo e($langg->paytm); ?>

	
																			<?php if($gs->paytm_text != null): ?>
	
																			<small>
																					<?php echo e($gs->paytm_text); ?>

																			</small>
	
																			<?php endif; ?>
	
																		</p>
																</a>
																<?php endif; ?>
															
															<?php if($gs->is_paystack == 1): ?>

															<a class="nav-link payment" data-val="paystack" data-show="no" data-form="<?php echo e(route('paystack.submit')); ?>" data-href="<?php echo e(route('front.load.payment',['slug1' => 'paystack','slug2' => 0])); ?>" id="v-pills-tab7-tab" data-toggle="pill" href="#v-pills-tab7" role="tab" aria-controls="v-pills-tab7" aria-selected="false">
																	<div class="icon">
																			<span class="radio"></span>
																	</div>
																	<p>
																			<?php echo e($langg->lang764); ?>


																		<?php if($gs->paystack_text != null): ?>

																		<small>
																				<?php echo e($gs->paystack_text); ?>

																		</small>

																		<?php endif; ?>
																	</p>
															</a>

															<?php endif; ?>


															<?php if($gs->is_molly == 1): ?>
															<a class="nav-link payment" data-val="" data-show="no" data-form="<?php echo e(route('molly.submit')); ?>" data-href="<?php echo e(route('front.load.payment',['slug1' => 'molly','slug2' => 0])); ?>" id="v-pills-tab8-tab" data-toggle="pill" href="#v-pills-tab8" role="tab" aria-controls="v-pills-tab8" aria-selected="false">
																	<div class="icon">
																			<span class="radio"></span>
																	</div>
																	<p>
																			<?php echo e($langg->lang802); ?>


																		<?php if($gs->molly_text != null): ?>

																		<small>
																				<?php echo e($gs->molly_text); ?>

																		</small>

																		<?php endif; ?>
																	</p>
															</a>

															<?php endif; ?>


<?php if($digital == 0): ?>

<?php $__currentLoopData = $gateways; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

															<a class="nav-link payment" data-val="" data-show="yes" data-form="<?php echo e(route('gateway.submit')); ?>" data-href="<?php echo e(route('front.load.payment',['slug1' => 'other','slug2' => $gt->id])); ?>" id="v-pills-tab<?php echo e($gt->id); ?>-tab" data-toggle="pill" href="#v-pills-tab<?php echo e($gt->id); ?>" role="tab" aria-controls="v-pills-tab<?php echo e($gt->id); ?>" aria-selected="false">
																	<div class="icon">
																			<span class="radio"></span>
																	</div>
																	<p>
																			<?php echo e($gt->title); ?>


																		<?php if($gt->subtitle != null): ?>

																		<small>
																				<?php echo e($gt->subtitle); ?>

																		</small>

																		<?php endif; ?>

																	</p>
															</a>



<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

<?php endif; ?>

														</div>
													</div>
													<div class="col-lg-12">
													  <div class="pay-area d-none">
														<div class="tab-content" id="v-pills-tabContent">
														    	<?php if($gs->is_razorpay == 1): ?>
																<div class="tab-pane fade" id="v-pills-tab6" role="tabpanel" aria-labelledby="v-pills-tab6-tab">
																</div>
															<?php endif; ?>
															
														    	<?php if($gs->is_ccavenue == 1): ?>
																<div class="tab-pane fade" id="v-pills-tab5" role="tabpanel" aria-labelledby="v-pills-tab5-tab">
																</div>
															<?php endif; ?>
														
														    
															<?php if($gs->paypal_check == 1): ?>
															<div class="tab-pane fade" id="v-pills-tab1" role="tabpanel" aria-labelledby="v-pills-tab1-tab">

															</div>
															<?php endif; ?>
															<?php if($gs->stripe_check == 1): ?>
															<div class="tab-pane fade" id="v-pills-tab2" role="tabpanel" aria-labelledby="v-pills-tab2-tab">
															</div>
															<?php endif; ?>
															<?php if($gs->cod_check == 1): ?>
															<?php if($digital == 0): ?>
															<div class="tab-pane fade" id="v-pills-tab3" role="tabpanel" aria-labelledby="v-pills-tab3-tab">
															</div>
															<?php endif; ?>
															<?php endif; ?>
															<?php if($gs->is_instamojo == 1): ?>
																<div class="tab-pane fade" id="v-pills-tab4" role="tabpanel" aria-labelledby="v-pills-tab4-tab">
																</div>
															<?php endif; ?>
															<?php if($gs->is_paytm == 1): ?>
																<div class="tab-pane fade" id="v-pills-tab5" role="tabpanel" aria-labelledby="v-pills-tab5-tab">
																</div>
															<?php endif; ?>
														
															<?php if($gs->is_paystack == 1): ?>
																<div class="tab-pane fade" id="v-pills-tab7" role="tabpanel" aria-labelledby="v-pills-tab7-tab">
																</div>
															<?php endif; ?>
															<?php if($gs->is_molly == 1): ?>
																<div class="tab-pane fade" id="v-pills-tab8" role="tabpanel" aria-labelledby="v-pills-tab8-tab">
																</div>
															<?php endif; ?>

													<?php if($digital == 0): ?>
														<?php $__currentLoopData = $gateways; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

															<div class="tab-pane fade" id="v-pills-tab<?php echo e($gt->id); ?>" role="tabpanel" aria-labelledby="v-pills-tab<?php echo e($gt->id); ?>-tab">

															</div>

														<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>		
													<?php endif; ?>												
													</div>
														</div>
													</div>
												</div>
											</div>
											
										<div class="row">
												<div class="col-lg-12 mt-3">
													<div class="bottom-area">

														<!--	<a href="javascript:;" id="step2-btn" class="mybtn1 mr-3"><?php echo e($langg->lang757); ?></a>-->
															<button type="submit" id="final-btn" class="mybtn1">Place Order</button>
													</div>

												</div>
											</div>
									</div>
								</div>
							</div>
							<div class="tab-pane fade" id="pills-step2" role="tabpanel" aria-labelledby="pills-step2-tab">


								  <div class="hiraola-product_area hiraola-product_area-2 section-space_add" style="padding-top: 0; padding-bottom: 0;">
            <div class="container">
                <div class="row">
      <div class="col-lg-12">
        <div class="hiraola-section_title">
            <h4>Review Order</h4>
        </div>
      </div>

    

    </div>
  </div>
</div>



							
							</div>
							<div class="tab-pane fade" id="pills-step3" role="tabpanel" aria-labelledby="pills-step3-tab">
								
							</div>
						</div>
					</div>


                            <input type="hidden" id="shipping-cost" name="shipping_cost" value="0">
                            <input type="hidden" id="packing-cost" name="packing_cost" value="0">
                            <input type="hidden" name="dp" value="<?php echo e($digital); ?>">
                            <input type="hidden" name="tax" value="<?php echo e($gs->tax); ?>">
                            <input type="hidden" name="totalQty" value="<?php echo e($totalQty); ?>">

                            <input type="hidden" name="vendor_shipping_id" value="<?php echo e($vendor_shipping_id); ?>">
                            <input type="hidden" name="vendor_packing_id" value="<?php echo e($vendor_packing_id); ?>">


							<?php if(Session::has('coupon_total')): ?>
                            	<input type="hidden" name="total" id="grandtotal" value="<?php echo e($totalPrice); ?>">
                            	<input type="hidden" id="tgrandtotal" value="<?php echo e($totalPrice); ?>">
							<?php elseif(Session::has('coupon_total1')): ?>
								<input type="hidden" name="total" id="grandtotal" value="<?php echo e(preg_replace("/[^0-9,.]/", "", Session::get('coupon_total1') )); ?>">
								<input type="hidden" id="tgrandtotal" value="<?php echo e(preg_replace("/[^0-9,.]/", "", Session::get('coupon_total1') )); ?>">
							<?php else: ?>
                            	<input type="hidden" name="total" id="grandtotal" value="<?php echo e(round($totalPrice * $curr->value,2)); ?>">
                            	<input type="hidden" id="tgrandtotal" value="<?php echo e(round($totalPrice * $curr->value,2)); ?>">
							<?php endif; ?>


                            <input type="hidden" name="coupon_code" id="coupon_code" value="<?php echo e(Session::has('coupon_code') ? Session::get('coupon_code') : ''); ?>">
                            <input type="hidden" name="coupon_discount" id="coupon_discount" value="<?php echo e(Session::has('coupon') ? Session::get('coupon') : ''); ?>">
                            <input type="hidden" name="coupon_id" id="coupon_id" value="<?php echo e(Session::has('coupon') ? Session::get('coupon_id') : ''); ?>">
                            <input type="hidden" name="user_id" id="user_id" value="<?php echo e(Auth::guard('web')->check() ? Auth::guard('web')->user()->id : ''); ?>">
							


</form>

				</div>

				<?php if(Session::has('cart')): ?>
				<div class="col-lg-5 checkout-area">
				    	<div class="content-box">
									<div class="content" style="padding : 0;">
										
										<div class="order-area">
											<?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
											<div class="order-item">
												<div class="product-img">
													<div class="d-flex">
														<img src="<?php echo e($product['item']['photo'] ? filter_var($product['item']['photo'], FILTER_VALIDATE_URL) ?$product['item']['photo']:asset('assets/images/products/'.$product['item']['photo']):asset('assets/images/noimage.png')); ?>"
															height="80" width="80" class="p-1">

													</div>
												</div>
												<div class="product-content">
													<p class="name" style="margin-top: 10px;"><a
															href="<?php echo e(route('front.product', $product['item']['slug'])); ?>"
															target="_blank"><?php echo e($product['item']['name']); ?></a></p>
													<div class="unit-price">
														<h5 class="label"><?php echo e($langg->lang754); ?> : </h5>
														<p><?php echo e(App\Models\Product::convertPrice($product['item']['price'])); ?></p>
													</div>
													<?php if(!empty($product['size'])): ?>
													<div class="unit-price">
														<h5 class="label"><?php if(!empty($product['item']['variation_title'])): ?><?php echo e($product['item']['variation_title']); ?> <?php else: ?> <?php echo e($langg->lang312); ?> <?php endif; ?> : </h5>
														<p><?php echo e(str_replace('-',' ',$product['size'])); ?></p>
													</div>
													<?php endif; ?>
													<?php if(!empty($product['color'])): ?>
													<div class="unit-price">
														<h5 class="label"><?php echo e($langg->lang313); ?> : </h5>
														<span id="color-bar" style="border: 10px solid <?php echo e($product['color'] == "" ? "white" : '#'.$product['color']); ?>;"></span>
													</div>
													<?php endif; ?>
													<?php if(!empty($product['keys'])): ?>

													<?php $__currentLoopData = array_combine(explode(',', $product['keys']), explode(',', $product['values'])); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

														<div class="quantity">
															<h5 class="label"><?php echo e(ucwords(str_replace('_', ' ', $key))); ?> : </h5>
															<span class="qttotal"><?php echo e($value); ?> </span>
														</div>
													<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

													<?php endif; ?>
													<div class="quantity">
														<h5 class="label"><?php echo e($langg->lang755); ?> : </h5>
														<span class="qttotal"><?php echo e($product['qty']); ?> </span>
													</div>
													<div class="total-price">
														<h5 class="label"><?php echo e($langg->lang756); ?> : </h5>
														<p><?php echo e(App\Models\Product::convertPrice($product['price'])); ?>

														</p>
													</div>
												</div>
											</div>


											<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

										</div>



										<!--<div class="row">
											<div class="col-lg-12 mt-3">
												<div class="bottom-area">
													<a href="javascript:;" id="step1-btn"  class="mybtn1 mr-3"><?php echo e($langg->lang757); ?></a>
													<a href="javascript:;" id="step3-btn"  class="mybtn1">Proceed</a>
												</div>
											</div>
										</div>-->
									</div>
								</div>
					<div class="right-area">
						<div class="order-box">
						<h4 class="title"><?php echo e($langg->lang127); ?></h4>
						<ul class="order-list">
							<li>
							<p>
								<?php echo e($langg->lang128); ?>

							</p>
							<P>
								<b
								class="cart-total"><?php echo e(Session::has('cart') ? App\Models\Product::convertPrice(Session::get('cart')->totalPrice) : '0.00'); ?></b>
							</P>
							</li>

							<?php if($gs->tax != 0): ?>

							<li>
							<p>
								<?php echo e($langg->lang144); ?>

							</p>
							<P>
								<b> <?php echo e($gs->tax); ?>% </b>
								
							</P>
							</li>

							<?php endif; ?>




												<?php if(Session::has('coupon')): ?>


							<li class="discount-bar">
							<p>
								<?php echo e($langg->lang145); ?> <span class="dpercent"><?php echo e(Session::get('coupon_percentage') == 0 ? '' : '('.Session::get('coupon_percentage').')'); ?></span>
							</p>
							<P>
								<?php if($gs->currency_format == 0): ?>
									<b id="discount"><?php echo e($curr->sign); ?><?php echo e(Session::get('coupon')); ?></b>
								<?php else: ?> 
									<b id="discount"><?php echo e(Session::get('coupon')); ?><?php echo e($curr->sign); ?></b>
								<?php endif; ?>
							</P>
							</li>


												<?php else: ?> 


							<li class="discount-bar d-none">
							<p>
								<?php echo e($langg->lang145); ?> <span class="dpercent"></span>
							</p>
							<P>
								<b id="discount"><?php echo e($curr->sign); ?><?php echo e(Session::get('coupon')); ?></b>
							</P>
							</li>


												<?php endif; ?>




						</ul>

		            <div class="total-price">
		              <p>
		                <?php echo e($langg->lang131); ?>

		              </p>
		              <p>

						<?php if(Session::has('coupon_total')): ?>
							<?php if($gs->currency_format == 0): ?>
								<span id="total-cost"><?php echo e($curr->sign); ?><?php echo e($totalPrice); ?></span>
							<?php else: ?> 
								<span id="total-cost"><?php echo e($totalPrice); ?><?php echo e($curr->sign); ?></span>
							<?php endif; ?>

						<?php elseif(Session::has('coupon_total1')): ?>
							<span id="total-cost"> <?php echo e(Session::get('coupon_total1')); ?></span>
							<?php else: ?>
							<span id="total-cost"><?php echo e(App\Models\Product::convertPrice($totalPrice)); ?></span>
						<?php endif; ?>

		              </p>
		            </div>


						<div class="cupon-box">

							<div id="coupon-link">
							<img src="<?php echo e(asset('assets/front/images/tag.png')); ?>">
							<?php echo e($langg->lang132); ?>

							</div>

						    <form id="check-coupon-form" class="coupon">
						        <input type="hidden" id="user_id" value="<?php echo e(Auth::check() ? Auth::user()->id : ''); ?>">
						        <input type="text" placeholder="<?php echo e($langg->lang133); ?>" id="code" required="" autocomplete="off">
						        <button type="submit"><?php echo e($langg->lang134); ?></button>
						    </form>


						</div>				
						
								
						<?php if($digital == 0): ?>

						
						<div class="packeging-area ship_methods_checkout">
								<h4 class="title"><?php echo e($langg->lang765); ?></h4>

							<?php $__currentLoopData = $shipping_data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
						
								<div class="radio-design">
										<input type="radio" class="shipping" id="free-shepping<?php echo e($data->id); ?>" name="shipping" value="<?php echo e(round($data->price * $curr->value,2)); ?>" <?php echo e(($loop->first) ? 'checked' : ''); ?>> 
										<span class="checkmark"></span>
										<label for="free-shepping<?php echo e($data->id); ?>"> 
												<?php echo e($data->title); ?>

												<?php if($data->price != 0): ?>
												+ <?php echo e($curr->sign); ?><?php echo e(round($data->price * $curr->value,2)); ?>

												<?php endif; ?>
												<small><?php echo e($data->subtitle); ?></small>
										</label>
								</div>

							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>		

						</div>
												
						

						
						<div class="packeging-area">
							<!--	<h4 class="title"><?php echo e($langg->lang766); ?></h4>-->

							<?php $__currentLoopData = $package_data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>	

								<div class="radio-design">
										<input type="radio" class="packing" id="free-package<?php echo e($data->id); ?>" name="packeging" value="<?php echo e(round($data->price * $curr->value,2)); ?>" <?php echo e(($loop->first) ? 'checked' : ''); ?>> 
										<span class="checkmark"></span>
										<label for="free-package<?php echo e($data->id); ?>"> 
												<?php echo e($data->title); ?>

												<?php if($data->price != 0): ?>
												+ <?php echo e($curr->sign); ?><?php echo e(round($data->price * $curr->value,2)); ?>

												<?php endif; ?>
												<small><?php echo e($data->subtitle); ?></small>
										</label>
								</div>

							<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>	

						</div>
						

						
						<div class="final-price">
							<span><?php echo e($langg->lang767); ?> :</span>
						<?php if(Session::has('coupon_total')): ?>
							<?php if($gs->currency_format == 0): ?>
								<span id="final-cost"><?php echo e($curr->sign); ?><?php echo e($totalPrice); ?></span>
							<?php else: ?> 
								<span id="final-cost"><?php echo e($totalPrice); ?><?php echo e($curr->sign); ?></span>
							<?php endif; ?>

						<?php elseif(Session::has('coupon_total1')): ?>
							<span id="final-cost"> <?php echo e(Session::get('coupon_total1')); ?></span>
							<?php else: ?>
							<span id="final-cost"><?php echo e(App\Models\Product::convertPrice($totalPrice)); ?></span>
						<?php endif; ?>



						</div>
						

						<?php endif; ?>


						</div>
					</div>
				</div>
				<?php endif; ?>
			</div>
		</div>
	</section>
		<!-- Check Out Area End-->

<?php if(isset($checked)): ?>

<!-- LOGIN MODAL -->
<div class="modal fade" id="comment-log-reg1" data-keyboard="false" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="comment-log-reg-Title" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" aria-label="Close">
          <a href="<?php echo e(url()->previous()); ?>"><span aria-hidden="true">&times;</span></a>
        </button>
      </div>
      <div class="modal-body">
				<nav class="comment-log-reg-tabmenu">
					<div class="nav nav-tabs" id="nav-tab" role="tablist">
						<a class="nav-item nav-link login active" id="nav-log-tab" data-toggle="tab" href="#nav-log" role="tab" aria-controls="nav-log" aria-selected="true">
							<?php echo e($langg->lang197); ?>

						</a>
						<a class="nav-item nav-link" id="nav-reg-tab" data-toggle="tab" href="#nav-reg" role="tab" aria-controls="nav-reg" aria-selected="false">
							<?php echo e($langg->lang198); ?>

						</a>
					</div>
				</nav>
				<div class="tab-content" id="nav-tabContent">
					<div class="tab-pane fade show active" id="nav-log" role="tabpanel" aria-labelledby="nav-log-tab">
				        <div class="login-area">
				          <div class="header-area">
				            <h4 class="title"><?php echo e($langg->lang172); ?></h4>
				          </div>
				          <div class="login-form signin-form">
				                <?php echo $__env->make('includes.admin.form-login', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
				            <form id="loginform" action="<?php echo e(route('user.login.submit')); ?>" method="POST">
				              <?php echo e(csrf_field()); ?>

				              <div class="form-input">
				                <input type="email" name="email" placeholder="<?php echo e($langg->lang173); ?>" value="user@gmail.com" required="">
				                <i class="icofont-user-alt-5"></i>
				              </div>
				              <div class="form-input">
				                <input type="password" class="Password" name="password" placeholder="<?php echo e($langg->lang174); ?>" value="1234" required="">
				                <i class="icofont-ui-password"></i>
				              </div>
				              <div class="form-forgot-pass">
				                <div class="left">
				              <input type="hidden" name="modal" value="1">
				                  <input type="checkbox" name="remember"  id="mrp" <?php echo e(old('remember') ? 'checked' : ''); ?>>
				                  <label for="mrp"><?php echo e($langg->lang175); ?></label>
				                </div>
				                <div class="right">
				                  <a href="<?php echo e(route('user-forgot')); ?>">
				                    <?php echo e($langg->lang176); ?>

				                  </a>
				                </div>
				              </div>
				              <input id="authdata" type="hidden"  value="<?php echo e($langg->lang177); ?>">
				              <button type="submit" class="submit-btn"><?php echo e($langg->lang178); ?></button>
					              <?php if(App\Models\Socialsetting::find(1)->f_check == 1 || App\Models\Socialsetting::find(1)->g_check == 1): ?>
					              <div class="social-area">
					                  <h3 class="title"><?php echo e($langg->lang179); ?></h3>
					                  <p class="text"><?php echo e($langg->lang180); ?></p>
					                  <ul class="social-links">
					                    <?php if(App\Models\Socialsetting::find(1)->f_check == 1): ?>
					                    <li>
					                      <a href="<?php echo e(route('social-provider','facebook')); ?>"> 
					                        <i class="fab fa-facebook-f"></i>
					                      </a>
					                    </li>
					                    <?php endif; ?>
					                    <?php if(App\Models\Socialsetting::find(1)->g_check == 1): ?>
					                    <li>
					                      <a href="<?php echo e(route('social-provider','google')); ?>">
					                        <i class="fab fa-google-plus-g"></i>
					                      </a>
					                    </li>
					                    <?php endif; ?>
					                  </ul>
					              </div>
					              <?php endif; ?>
				            </form>
				          </div>
				        </div>
					</div>
					<div class="tab-pane fade" id="nav-reg" role="tabpanel" aria-labelledby="nav-reg-tab">
                <div class="login-area signup-area">
                    <div class="header-area">
                        <h4 class="title"><?php echo e($langg->lang181); ?></h4>
                    </div>
                    <div class="login-form signup-form">
                       <?php echo $__env->make('includes.admin.form-login', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                        <form id="registerform" action="<?php echo e(route('user-register-submit')); ?>" method="POST">
                          <?php echo e(csrf_field()); ?>


                            <div class="form-input">
                                <input type="text" class="User Name" name="name" placeholder="<?php echo e($langg->lang182); ?>" required="">
                                <i class="icofont-user-alt-5"></i>
                            </div>

                            <div class="form-input">
                                <input type="email" class="User Name" name="email" placeholder="<?php echo e($langg->lang183); ?>" required="">
                                <i class="icofont-email"></i>
                            </div>

                            <div class="form-input">
                                <input type="text" class="User Name" name="phone" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"  placeholder="<?php echo e($langg->lang184); ?>" required="">
                                <i class="icofont-phone"></i>
                            </div>

                            <div class="form-input">
                                <input type="text" class="User Name" name="address" placeholder="<?php echo e($langg->lang185); ?>" required="">
                                <i class="icofont-location-pin"></i>
                            </div>

                            <div class="form-input">
                                <input type="password" class="Password" name="password" placeholder="<?php echo e($langg->lang186); ?>" required="">
                                <i class="icofont-ui-password"></i>
                            </div>

                            <div class="form-input">
                                <input type="password" class="Password" name="password_confirmation" placeholder="<?php echo e($langg->lang187); ?>" required="">
                                <i class="icofont-ui-password"></i>
                            </div>

                                <?php if($gs->is_capcha == 1): ?>

                                    <ul class="captcha-area">
                                        <li>
                                            <p><img class="codeimg1" src="<?php echo e(asset("assets/images/capcha_code.png")); ?>" alt=""> <i class="fas fa-sync-alt pointer refresh_code "></i></p>
                                        </li>
                                    </ul>

                            <div class="form-input">
                                <input type="text" class="Password" name="codes" placeholder="<?php echo e($langg->lang51); ?>" required="">
                                <i class="icofont-refresh"></i>
                            </div>

                                    <?php endif; ?>

                            <input id="processdata" type="hidden"  value="<?php echo e($langg->lang188); ?>">
                            <button type="submit" class="submit-btn"><?php echo e($langg->lang189); ?></button>
                        
                        </form>
                    </div>
                </div>
					</div>
				</div>
      </div>
    </div>
  </div>
</div>
<!-- LOGIN MODAL ENDS -->

<?php endif; ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>

<script src="https://js.paystack.co/v1/inline.js"></script>


<script type="text/javascript">
	$('a.payment:first').addClass('active');
	$('.checkoutform').prop('action',$('a.payment:first').data('form'));
	$($('a.payment:first').attr('href')).load($('a.payment:first').data('href'));


		var show = $('a.payment:first').data('show');
		if(show != 'no') {
			$('.pay-area').removeClass('d-none');
		}
		else {
			$('.pay-area').addClass('d-none');
		}
	$($('a.payment:first').attr('href')).addClass('active').addClass('show');
	
		   $('.submit-loader').hide();
</script>


<script type="text/javascript">

var coup = 0;
var pos = <?php echo e($gs->currency_format); ?>;

<?php if(isset($checked)): ?>

	$('#comment-log-reg1').modal('show');

<?php endif; ?>

var mship = $('.shipping').length > 0 ? $('.shipping').first().val() : 0;
var mpack = $('.packing').length > 0 ? $('.packing').first().val() : 0;
mship = parseFloat(mship);
mpack = parseFloat(mpack);

$('#shipping-cost').val(mship);
$('#packing-cost').val(mpack);
var ftotal = parseFloat($('#grandtotal').val()) + mship + mpack;
ftotal = parseFloat(ftotal);
      if(ftotal % 1 != 0)
      {
        ftotal = ftotal.toFixed(2);
      }
		if(pos == 0){
			$('#final-cost').html('<?php echo e($curr->sign); ?>'+ftotal)
		}
		else{
			$('#final-cost').html(ftotal+'<?php echo e($curr->sign); ?>')
		}
		
		if(ftotal == 0){
			$('.cash-ondel').show();
		}
		else{
			$('.cash-ondel').hide();
		}
		

$('#grandtotal').val(ftotal);

$('#shipop').on('change',function(){

	var val = $(this).val();
	if(val == 'pickup'){
		$('#shipshow').removeClass('d-none');
		$("#ship-diff-address").parent().addClass('d-none');
        $('.ship-diff-addres-area').addClass('d-none');  
        $('.ship-diff-addres-area input, .ship-diff-addres-area select').prop('required',false);  
	}
	else{
		$('#shipshow').addClass('d-none');
		$("#ship-diff-address").parent().removeClass('d-none');
        $('.ship-diff-addres-area').removeClass('d-none');  
        $('.ship-diff-addres-area input, .ship-diff-addres-area select').prop('required',true); 
	}

});


$('.shipping').on('click',function(){
	mship = $(this).val();

$('#shipping-cost').val(mship);
var ttotal = parseFloat($('#tgrandtotal').val()) + parseFloat(mship) + parseFloat(mpack);
ttotal = parseFloat(ttotal);
      if(ttotal % 1 != 0)
      {
        ttotal = ttotal.toFixed(2);
      }
		if(pos == 0){
			$('#final-cost').html('<?php echo e($curr->sign); ?>'+ttotal);
		}
		else{
			$('#final-cost').html(ttotal+'<?php echo e($curr->sign); ?>');
		}
	
$('#grandtotal').val(ttotal);

})

/*$('#shipping_country').on( "change", function(){
	mship = $('#shipping-data').val();
	var target = $('#shipping_country').val();
        if(target==''){
			var target = $('#country').val();
		}
		if(target == "India"){
			
			$('.shiping-rate').hide();
		}else{			
			$('.shipping').attr('checked',false);
			$('.shiping-rate').show();
$('#shipping-cost').val(mship);
var ttotal = parseFloat($('#tgrandtotal').val()) + parseFloat(mship) + parseFloat(mpack);
ttotal = parseFloat(ttotal);
      if(ttotal % 1 != 0)
      {
        ttotal = ttotal.toFixed(2);
      }
		if(pos == 0){
			$('#final-cost').html('<?php echo e($curr->sign); ?>'+ttotal);
		}
		else{
			$('#final-cost').html(ttotal+'<?php echo e($curr->sign); ?>');
		}
	
$('#grandtotal').val(ttotal);
}
})*/

$('#step2-btn').on('click',function(){
	mship = 0;
	var target = $('#shipping_country').val();
        if(target==''){
			var target = $('#country').val();
		}
		if(target == "India"){
			
			$('.shiping-rate').hide();
		}else{			
			$('.shipping').attr('checked',false);
			$('.shiping-rate').show();
$('#shipping-cost').val(mship);
var ttotal = parseFloat($('#tgrandtotal').val()) + parseFloat(mship) + parseFloat(mpack);
ttotal = parseFloat(ttotal);
      if(ttotal % 1 != 0)
      {
        ttotal = ttotal.toFixed(2);
      }
		if(pos == 0){
			$('#final-cost').html('<?php echo e($curr->sign); ?>'+ttotal);
		}
		else{
			$('#final-cost').html(ttotal+'<?php echo e($curr->sign); ?>');
		}
	
$('#grandtotal').val(ttotal);
}
})

$('.packing').on('click',function(){
	mpack = $(this).val();
$('#packing-cost').val(mpack);
var ttotal = parseFloat($('#tgrandtotal').val()) + parseFloat(mship) + parseFloat(mpack);
ttotal = parseFloat(ttotal);
      if(ttotal % 1 != 0)
      {
        ttotal = ttotal.toFixed(2);
      }

		if(pos == 0){
			$('#final-cost').html('<?php echo e($curr->sign); ?>'+ttotal);
		}
		else{
			$('#final-cost').html(ttotal+'<?php echo e($curr->sign); ?>');
		}	


$('#grandtotal').val(ttotal);
		
})

    $("#check-coupon-form").on('submit', function () {
        var val = $("#code").val();
        var total = $("#grandtotal").val();
        var id = $("#user_id").val();
        
        var ship = 0;
            $.ajax({
                    type: "GET",
                    url:mainurl+"/carts/coupon/check",
                    data:{code:val, total:total, shipping_cost:ship,id:id},
                    success:function(data){
                        if(data == 0)
                        {
                        	toastr.error(langg.no_coupon);
                            $("#code").val("");
                        }
                        else if(data == 2)
                        {
                        	toastr.error(langg.already_coupon);
                            $("#code").val("");
                        }
                        else
                        {
                            $("#check-coupon-form").toggle();
                            $(".discount-bar").removeClass('d-none');

							if(pos == 0){
								$('#total-cost').html('<?php echo e($curr->sign); ?>'+data[0]);
								$('#discount').html('<?php echo e($curr->sign); ?>'+data[2]);
							}
							else{
								$('#total-cost').html(data[0]+'<?php echo e($curr->sign); ?>');
								$('#discount').html(data[2]+'<?php echo e($curr->sign); ?>');
							}
								$('#grandtotal').val(data[0]);
								$('#tgrandtotal').val(data[0]);
								$('#coupon_code').val(data[1]);
								$('#coupon_discount').val(data[2]);
								if(data[4] != 0){
								$('.dpercent').html('('+data[4]+')');
								}
								else{
								$('.dpercent').html('');									
								}


var ttotal = parseFloat($('#grandtotal').val()) + parseFloat(mship) + parseFloat(mpack);
ttotal = parseFloat(ttotal);
      if(ttotal % 1 != 0)
      {
        ttotal = ttotal.toFixed(2);
      }


		if(pos == 0){
			$('#final-cost').html('<?php echo e($curr->sign); ?>'+ttotal)
		}
		else{
			$('#final-cost').html(ttotal+'<?php echo e($curr->sign); ?>')
		}	
		if(ttotal == 0){
			$('.cash-ondel').show();
		}
		else{
			$('.cash-ondel').hide();
		}

                        	toastr.success(langg.coupon_found);
                            $("#code").val("");
                        }
                      }
              }); 
              return false;
    });

// Password Checking

        $("#open-pass").on( "change", function() {
            if(this.checked){
             $('.set-account-pass').removeClass('d-none');  
             $('.set-account-pass input').prop('required',true); 
             $('#personal-email').prop('required',true);
             $('#personal-name').prop('required',true);
            }
            else{
             $('.set-account-pass').addClass('d-none');   
             $('.set-account-pass input').prop('required',false); 
             $('#personal-email').prop('required',false);
             $('#personal-name').prop('required',false);

            }
        });

// Password Checking Ends


// Shipping Address Checking

		$("#ship-diff-address").on( "change", function() {
            if(this.checked){
             $('.ship-diff-addres-area').removeClass('d-none');  
             $('.ship-diff-addres-area input, .ship-diff-addres-area select').prop('required',true); 
            }
            else{
             $('.ship-diff-addres-area').addClass('d-none');  
             $('.ship-diff-addres-area input, .ship-diff-addres-area select').prop('required',false);  
            }
            
        });


// Shipping Address Checking Ends


</script>


<script type="text/javascript">

$(window).load(function() {
$('#shipping_country').prop('selectedIndex',0);
});

var ck = 0;

	$('.checkoutform').on('submit',function(e){
		if(ck == 0) {
			e.preventDefault();			
		$('#pills-step2-tab').removeClass('disabled');
		$('#pills-step2-tab').click();

	}else {
		$('#preloader').show();
	}
	$('#pills-step1-tab').addClass('active');
	});

	$('#step1-btn').on('click',function(){
		$('#pills-step1-tab').removeClass('active');
		$('#pills-step2-tab').removeClass('active');
		$('#pills-step3-tab').removeClass('active');
		$('#pills-step2-tab').addClass('disabled');
		$('#pills-step3-tab').addClass('disabled');

		$('#pills-step1-tab').click();

	});

// Step 2 btn DONE

	$('#step2-btn').on('click',function(){
		$('#pills-step3-tab').removeClass('active');
		$('#pills-step1-tab').removeClass('active');
		$('#pills-step2-tab').removeClass('active');
		$('#pills-step3-tab').addClass('disabled');
		$('#pills-step2-tab').click();
		$('#pills-step1-tab').addClass('active');

	});
	
	
	if($('#ship-diff-address').is(":checked")){
	    
	}

$("#ship-diff-address").on( "change", function(){
	 	if($('a.payment:first').data('val') == 'paystack'){
			$('.checkoutform').prop('id','step1-form');
		}
		else {
			$('.checkoutform').prop('id','');
		}
		/*$('#pills-step3-tab').removeClass('disabled');
		$('#pills-step3-tab').click();*/

		var shipping_user  = !$('input[name="shipping_name"]').val() ? $('input[name="name"]').val() : $('input[name="shipping_name"]').val();	
        var shipping_landmark  = !$('input[name="shipping_landmark"]').val() ? $('input[name="customer_landmark"]').val() : $('input[name="shipping_landmark"]').val();		
		var shipping_address  = !$('input[name="shipping_address"]').val() ? $('input[name="address"]').val() : $('input[name="shipping_address"]').val();
		var shipping_city  = !$('input[name="shipping_city"]').val() ? $('input[name="city"]').val() : $('input[name="shipping_city"]').val();
		var shipping_country  = !$("#shipping_country option:selected").val() ?$("#country option:selected").val() :$("#shipping_country option:selected").val() ;
		var shipping_state  = !$("#shipping_state option:selected").val() ?$("#state option:selected").val() :$("#shipping_state option:selected").val() ;
		var shipping_zip  = !$('input[name="shipping_zip"]').val() ? $('input[name="zip"]').val() : $('input[name="shipping_zip"]').val();
		var shipping_location  = shipping_landmark + ' ' + shipping_address + ' ' + shipping_city + ' ' + shipping_state + ' ' + shipping_country+ ' ' + shipping_zip;
		var shipping_phone = !$('input[name="shipping_phone"]').val() ? $('input[name="phone"]').val() : $('input[name="shipping_phone"]').val();
		var shipping_email= !$('input[name="shipping_email"]').val() ? $('input[name="email"]').val() : $('input[name="shipping_email"]').val();

	/*	$('#shipping_user').html('<i class="fas fa-user"></i>'+shipping_user);
		$('#shipping_location').html('<i class="fas fas fa-map-marker-alt"></i>'+shipping_location);
		$('#shipping_phone').html('<i class="fas fa-phone"></i>'+shipping_phone);
		$('#shipping_email').html('<i class="fas fa-envelope"></i>'+shipping_email);*/

	/*	$('#pills-step1-tab').addClass('active');
		$('#pills-step2-tab').addClass('active');*/
		
		/*
		var shipcosthtml = $(".sipping_wrap_international").html();
		$(".ship_methods_checkout").html(shipcosthtml);
		*/
		
	});

	$('#final-btn').on('click',function(){
		ck = 1;
	})


	$('.payment').on('click',function(){
	    
      $('.submit-loader').show();
		if($(this).data('val') == 'paystack'){
			$('.checkoutform').prop('id','step1-form');
		}
		else {
			$('.checkoutform').prop('id','');
		}
		$('.checkoutform').prop('action',$(this).data('form'));
		$('.pay-area #v-pills-tabContent .tab-pane.fade').not($(this).attr('href')).html('');
		var show = $(this).data('show');
		if(show != 'no') {
			$('.pay-area').removeClass('d-none');
		}
		else {
			$('.pay-area').addClass('d-none');
		}
		$($(this).attr('href')).load($(this).data('href'), function() {
            $('.submit-loader').hide();
        });

		  
	})


        $(document).on('submit','#step1-form',function(){
        	$('#preloader').hide();
            var val = $('#sub').val();
            var total = $('#grandtotal').val();
			total = Math.round(total);
                if(val == 0)
                {
                var handler = PaystackPop.setup({
                  key: '<?php echo e($gs->paystack_key); ?>',
                  email: $('input[name=email]').val(),
                  amount: total * 100,
                  currency: "<?php echo e($curr->name); ?>",
                  ref: ''+Math.floor((Math.random() * 1000000000) + 1),
                  callback: function(response){
                    $('#ref_id').val(response.reference);
                    $('#sub').val('1');
                    $('#final-btn').click();
                  },
                  onClose: function(){
                  	window.location.reload();
                  	
                  }
                });
                handler.openIframe();
                    return false;                    
                }
                else {
                	$('#preloader').show();
                    return true;   
                }
        });
        $(document).on('change','#country',function () {
            var link = $(this).find(':selected').attr('data-href');
           
            if(link != ""){
                $('#state').load(link);
                $('#state').prop('disabled',false);
            }
        });
        
       $(function () {
    $("select#country").change();
});
        
         $(document).on('change','#shipping_country',function () {
            var link = $(this).find(':selected').attr('data-href');
           
            if(link != ""){
                $('#shipping_state').load(link);
                $('#shipping_state').prop('disabled',false);
            }
        });
        
            $(function () {
    $("select#shipping_country").change();
});

   
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.front', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>