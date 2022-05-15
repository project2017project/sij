<?php $__env->startSection('content'); ?>

  <div class="vendor-banner" style="">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="content">
            <p class="sub-title">
               
            </p>
            <h2 class="title">
                <?php echo e(__('Vendor Registration')); ?>

            </h2>
          </div>
        </div>
      </div>
    </div>
  </div>


  
  <section class="">
  <div class="container">
  <div class="row">
        <div class="col-sm-2"></div>
        <div class="login-area col-sm-8">
          <div class="login-area signup-area" style="margin-top : 120px;">
        <div class="login-form signup-form">
         <?php echo $__env->make('includes.admin.form-login', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
         <form class="mregisterform" action="<?php echo e(route('user-register-submit')); ?>" method="POST">
          <?php echo e(csrf_field()); ?>


          <div class="row">

            <div class="col-lg-6">
              <div class="form-input">
                <input type="text" class="User Name" name="name" placeholder="<?php echo e($langg->lang182); ?>" required="">
                <i class="icofont-user-alt-5"></i>
              </div>
            </div>

            <div class="col-lg-6">
             <div class="form-input">
              <input type="email" class="User Name" name="email" placeholder="<?php echo e($langg->lang183); ?>" required="">
              <i class="icofont-email"></i>
            </div>

          </div>
          <div class="col-lg-6">
            <div class="form-input">
              <input type="text" class="User Name" name="phone" placeholder="<?php echo e($langg->lang184); ?>" required="">
              <i class="icofont-phone"></i>
            </div>

          </div>
           <div class="col-lg-6"><div class="form-input">
					<select class="form-control" name="country" id="usercountry" required="">
						<?php echo $__env->make('includes.countries', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
					</select><i class="icofont-location-pin"></i></div>
			</div>
			<div class="col-lg-6"><div class="form-input">
                    <select class="form-control" id="userstate" name="state"  disabled="">
                        <option value=""><?php echo e(__('Select State')); ?></option>
                    </select><i class="icofont-location-pin"></i></div>
							
                </div>
          <div class="col-lg-6">

            <div class="form-input">
              <input type="text" class="User Name" name="address" placeholder="<?php echo e($langg->lang185); ?>" required="">
              <i class="icofont-location-pin"></i>
            </div>
          </div>

          <div class="col-lg-6">
           <div class="form-input">
            <input type="text" class="User Name" name="shop_name" placeholder="<?php echo e($langg->lang238); ?>" required="">
            <i class="icofont-cart-alt"></i>
          </div>

        </div>
        <div class="col-lg-6">

         <div class="form-input">
          <input type="text" class="User Name" name="owner_name" placeholder="<?php echo e($langg->lang239); ?>" required="">
          <i class="icofont-cart"></i>
        </div>
      </div>
      <div class="col-lg-6">

        <div class="form-input">
          <input type="text" class="User Name" name="shop_number" placeholder="<?php echo e($langg->lang240); ?>" required="">
          <i class="icofont-shopping-cart"></i>
        </div>
      </div>
      <div class="col-lg-6">

       <div class="form-input">
        <input type="text" class="User Name" name="shop_address" placeholder="<?php echo e($langg->lang241); ?>" required="">
        <i class="icofont-opencart"></i>
      </div>
    </div>
    <div class="col-lg-6">

      <div class="form-input">
        <input type="text" class="User Name" name="reg_number" placeholder="GST Number">
        <i class="icofont-ui-cart"></i>
      </div>
    </div>
	<div class="col-lg-6">

      <div class="form-input">
        <input type="text" class="User Name" name="bank_name" placeholder="Bank Name" required="">
        <i class="icofont-ui-cart"></i>
      </div>
    </div>
	<div class="col-lg-6">

      <div class="form-input">
        <input type="text" class="User Name" name="branch" placeholder="Branch" required="">
        <i class="icofont-ui-cart"></i>
      </div>
    </div>
	<div class="col-lg-6">

      <div class="form-input">
        <input type="text" class="User Name" name="ifsc_code" placeholder="IFSC Code" required="">
        <i class="icofont-ui-cart"></i>
      </div>
    </div>
	<div class="col-lg-6">

      <div class="form-input">
        <input type="text" class="User Name" name="account_holder_name" placeholder="Account Holder Name" required="">
        <i class="icofont-ui-cart"></i>
      </div>
    </div>
	<div class="col-lg-6">

      <div class="form-input">
        <input type="text" class="User Name" name="account_number" placeholder="Account Number" required="">
        <i class="icofont-ui-cart"></i>
      </div>
    </div>
	<div class="col-lg-6">
    <input type="file" class="" name="shop_logo" required="">
    </div>
    <div class="col-lg-6">

     <div class="form-input">
      <input type="text" class="User Name" name="shop_message" placeholder="<?php echo e($langg->lang243); ?>" required="">
      <i class="icofont-envelope"></i>
    </div>
  </div>

  <div class="col-lg-6">
    <div class="form-input">
      <input type="password" class="Password" name="password" placeholder="<?php echo e($langg->lang186); ?>" required="">
      <i class="icofont-ui-password"></i>
    </div>

  </div>
  <div class="col-lg-6">
   <div class="form-input">
    <input type="password" class="Password" name="password_confirmation" placeholder="<?php echo e($langg->lang187); ?>" required="">
    <i class="icofont-ui-password"></i>
  </div>
</div>

<?php if($gs->is_capcha == 1): ?>

<div class="col-lg-6">


  <ul class="captcha-area">
    <li>
      <p>
       <img class="codeimg1" src="<?php echo e(asset("assets/images/capcha_code.png")); ?>" alt=""> <i class="fas fa-sync-alt pointer refresh_code "></i>
     </p>

   </li>
 </ul>


</div>

<div class="col-lg-6">

 <div class="form-input">
  <input type="text" class="Password" name="codes" placeholder="<?php echo e($langg->lang51); ?>" required="">
  <i class="icofont-refresh"></i>

</div>



</div>

<?php endif; ?>

<input type="hidden" name="vendor"  value="1">
<input class="mprocessdata" type="hidden"  value="<?php echo e($langg->lang188); ?>">
<button type="submit" class="submit-btn"><?php echo e($langg->lang189); ?></button>

</div>




</form>
</div>
</div>
       </div>
   
  
  </section>
  </div>
  </div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.front', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>