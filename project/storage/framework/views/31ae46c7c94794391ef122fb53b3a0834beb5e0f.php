<?php $__env->startSection('content'); ?>

  <div class="vendor-banner" style="">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="content">
            <p class="sub-title">
               
            </p>
            <h2 class="title">
                <?php echo e(__('Vendor Login')); ?>

            </h2>
          </div>
        </div>
      </div>
    </div>
  </div>


  
  <section class="">
  <div class="container">
  <div class="row">
        <div class="col-sm-3"></div>
        <div class="login-area col-sm-6">
          <div class="login-form signin-form" style="margin-top:60px;">
            <?php echo $__env->make('includes.admin.form-login', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            <form class="mloginform" action="<?php echo e(route('user.login.submit')); ?>" method="POST">
              <?php echo e(csrf_field()); ?>

              <div class="form-input">
                <input type="email" name="email" placeholder="<?php echo e($langg->lang173); ?>" required="">
                <i class="icofont-user-alt-5"></i>
              </div>
              <div class="form-input">
                <input type="password" class="Password" name="password" placeholder="<?php echo e($langg->lang174); ?>" required="">
                <i class="icofont-ui-password"></i>
              </div>
             
              <div class="form-forgot-pass">
                <div class="left">
                  <input type="checkbox" name="remember"  id="mrp1" <?php echo e(old('remember') ? 'checked' : ''); ?>>
                  <label for="mrp1"><?php echo e($langg->lang175); ?></label>
                </div>
                <div class="right">
                  <a href="javascript:;" id="show-forgot1">
                    <?php echo e($langg->lang176); ?>

                  </a>
                </div>
              </div>
              <input type="hidden" name="modal"  value="1">
              <input type="hidden" name="vendor"  value="1">
              <input class="mauthdata" type="hidden"  value="<?php echo e($langg->lang177); ?>">
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
   
  
  </section>
  </div>
  </div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.front', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>