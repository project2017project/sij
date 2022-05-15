<?php $__env->startSection('content'); ?>

            <div class="content-area">

              <div class="mr-breadcrumb">
                <div class="row">
                  <div class="col-lg-12">
                      <h4 class="heading"><?php echo e(__('Add New Page')); ?> <a class="add-btn" href="<?php echo e(url()->previous()); ?>"><i class="fas fa-arrow-left"></i> <?php echo e(__("Back")); ?></a></h4>
                      <ul class="links">
                        <li>
                          <a href="<?php echo e(route('admin.dashboard')); ?>"><?php echo e(__('Dashboard')); ?> </a>
                        </li>
                        <li>
                          <a href="javascript:;"><?php echo e(__('Menu Page Settings')); ?> </a>
                        </li>
                        <li>
                          <a href="<?php echo e(route('admin-page-index')); ?>"><?php echo e(__('Pages')); ?></a>
                        </li>
                        <li>
                          <a href="<?php echo e(route('admin-page-create')); ?>"><?php echo e(__('Add')); ?></a>
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

                      <form id="geniusform" action="<?php echo e(route('admin-page-create')); ?>" method="POST" enctype="multipart/form-data">

                        <?php echo e(csrf_field()); ?>


                        <div class="row">
                          <div class="col-lg-4">
                            <div class="left-area">
                                <h4 class="heading"><?php echo e(__('Title')); ?> *</h4>
                                <p class="sub-heading"><?php echo e(__('In Any Language')); ?></p>
                            </div>
                          </div>
                          <div class="col-lg-7">
                            <input type="text" class="input-field" name="title" placeholder="<?php echo e(__('Title')); ?>" required="" value="<?php echo e(Request::old('title')); ?>">
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-lg-4">
                            <div class="left-area">
                                <h4 class="heading"><?php echo e(__('Slug')); ?> *</h4>
                                <p class="sub-heading"><?php echo e(__('(In English)')); ?></p>
                            </div>
                          </div>
                          <div class="col-lg-7">
                            <input type="text" class="input-field" name="slug" placeholder="<?php echo e(__('Slug')); ?>" required="" value="<?php echo e(Request::old('slug')); ?>">
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-lg-4">
                            <div class="left-area">
                              <h4 class="heading">
                                  <?php echo e(__('Description')); ?> *
                              </h4>
                            </div>
                          </div>
                          <div class="col-lg-7">
                              <textarea  class="nic-edit-p" name="details" placeholder="<?php echo e(__('Description')); ?>"><?php echo e(Request::old('details')); ?></textarea> 
                              <div class="checkbox-wrapper">
                                <input type="checkbox" name="secheck" class="checkclick" id="allowProductSEO">
                                <label for="allowProductSEO"><?php echo e(__('Allow Page SEO')); ?></label>
                              </div>
                          </div>
                        </div>



                        <div class="showbox">
                          <div class="row">
                            <div class="col-lg-4">
                              <div class="left-area">
                                  <h4 class="heading"><?php echo e(__('Meta Tags')); ?> *</h4>
                              </div>
                            </div>
                            <div class="col-lg-7">
                              <ul id="metatags" class="myTags">
                              </ul>
                            </div>
                          </div>  

                          <div class="row">
                            <div class="col-lg-4">
                              <div class="left-area">
                                <h4 class="heading">
                                    <?php echo e(__('Meta Description')); ?> *
                                </h4>
                              </div>
                            </div>
                            <div class="col-lg-7">
                              <div class="text-editor">
                                <textarea name="meta_description" class="input-field" placeholder="<?php echo e(__('Meta Description')); ?>"></textarea> 
                              </div>
                            </div>
                          </div>
                        </div>


                        <div class="row">
                          <div class="col-lg-4">
                            <div class="left-area">
                              
                            </div>
                          </div>
                          <div class="col-lg-7">
                            <button class="addProductSubmit-btn" type="submit"><?php echo e(__('Create Page')); ?></button>
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

<?php $__env->startSection('scripts'); ?>
<script type="text/javascript">



          $("#metatags").tagit({
          fieldName: "meta_tag[]",
          allowSpaces: true 
          });


</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>