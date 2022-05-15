<?php $__env->startSection('content'); ?>

<section class="user-dashbord">
    <div class="container">
      <div class="row">
        <?php echo $__env->make('includes.user-dashboard-sidebar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                <div class="col-lg-8">
                    <div class="user-profile-details">
                        <div class="account-info">
                            <div class="header-area">
                                <h4 class="title">
                                    <?php echo e($langg->lang272); ?>

                                </h4>
                            </div>
                            <div class="edit-info-area">
                                
                                <div class="body">
                                        <div class="edit-info-area-form">
                                                <div class="gocover" style="background: url(<?php echo e(asset('assets/images/'.$gs->loader)); ?>) no-repeat scroll center center rgba(45, 45, 45, 0.5);"></div>
                                                <form id="userform" action="<?php echo e(route('user-reset-submit')); ?>" method="POST" enctype="multipart/form-data">
                                                    <?php echo e(csrf_field()); ?>

                                                    <?php echo $__env->make('includes.admin.form-both', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?> 
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                                <input type="password" name="cpass"  class="input-field" placeholder="<?php echo e($langg->lang273); ?>" value="" required="">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                                <input type="password" name="newpass"  class="input-field" placeholder="<?php echo e($langg->lang274); ?>" value="" required="">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                                <input type="password" name="renewpass"  class="input-field" placeholder="<?php echo e($langg->lang275); ?>" value="" required="">
                                                        </div>
                                                    </div>

                                                        <div class="form-links">
                                                            <button class="submit-btn" type="submit"><?php echo e($langg->lang276); ?></button>
                                                        </div>
                                                </form>
                                            </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
      </div>
    </div>
  </section>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.front', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>