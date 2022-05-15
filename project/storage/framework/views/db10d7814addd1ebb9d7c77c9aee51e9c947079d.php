<?php $__env->startSection('styles'); ?>

<link href="<?php echo e(asset('assets/admin/css/jquery-ui.css')); ?>" rel="stylesheet" type="text/css">

<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>

            <div class="content-area">

              <div class="mr-breadcrumb">
                <div class="row">
                  <div class="col-lg-12">
                      <h4 class="heading"><?php echo e(__('Edit Coupon')); ?> <a class="add-btn" href="<?php echo e(route('admin-coupon-index')); ?>"><i class="fas fa-arrow-left"></i> <?php echo e(__('Back')); ?></a></h4>
                      <ul class="links">
                        <li>
                          <a href="<?php echo e(route('admin.dashboard')); ?>"><?php echo e(__('Dashboard')); ?> </a>
                        </li>
                        <li>
                          <a href="<?php echo e(route('admin-coupon-index')); ?>"><?php echo e(__('Coupons')); ?></a>
                        </li>
                        <li>
                          <a href="<?php echo e(route('admin-coupon-edit',$data->id)); ?>"><?php echo e(__('Edit Coupon')); ?></a>
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
                      <form id="geniusform" action="<?php echo e(route('admin-coupon-update',$data->id)); ?>" method="POST" enctype="multipart/form-data">
                        <?php echo e(csrf_field()); ?>


                        <div class="row">
                          <div class="col-lg-4">
                            <div class="left-area">
                                <h4 class="heading"><?php echo e(__('Code')); ?> *</h4>
                                <p class="sub-heading"><?php echo e(__('(In Any Language)')); ?></p>
                            </div>
                          </div>
                          <div class="col-lg-7">
                            <input type="text" class="input-field" name="code" placeholder="<?php echo e(__('Enter Code')); ?>" required="" value="<?php echo e($data->code); ?>">
                          </div>
                        </div>
                         <div class="row">
                          <div class="col-lg-4">
                            <div class="left-area">
                                <h4 class="heading"><?php echo e(__('Cart Total')); ?> *</h4>
                                <p class="sub-heading"><?php echo e(__('(In Any Language)')); ?></p>
                            </div>
                          </div>
                          <div class="col-lg-7">
                            <input type="text" class="input-field" name="cart_total_limit" placeholder="<?php echo e(__('Enter Code')); ?>" required="" value="<?php echo e($data->cart_total_limit); ?>">
                          </div>
                        </div>
                         <div class="row">
                          <div class="col-lg-4">
                            <div class="left-area">
                                <h4 class="heading"><?php echo e(__('User Limit To Use Code')); ?> *</h4>
                                <p class="sub-heading"><?php echo e(__('(In Any Language)')); ?></p>
                            </div>
                          </div>
                          <div class="col-lg-7">
                            <input type="text" class="input-field" name="user_used_count" placeholder="<?php echo e(__('Enter Code')); ?>" required="" value="<?php echo e($data->user_used_count); ?>">
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-lg-4">
                            <div class="left-area">
                                <h4 class="heading"><?php echo e(__('Type')); ?> *</h4>
                            </div>
                          </div>
                          <div class="col-lg-7">
                              <select id="type" name="type" required="">
                                <option value=""><?php echo e(__('Choose a type')); ?></option>
                                <option value="0" <?php echo e($data->type == 0 ? "selected":""); ?>><?php echo e(__('Discount By Percentage')); ?></option>
                                <option value="1" <?php echo e($data->type == 1 ? "selected":""); ?>><?php echo e(__('Discount By Amount')); ?></option>
                              </select>
                          </div>
                        </div>

                        <div class="row hidden">
                          <div class="col-lg-4">
                            <div class="left-area">
                                <h4 class="heading"></h4>
                            </div>
                          </div>
                          <div class="col-lg-3">
                            <input type="text" class="input-field less-width" name="price" placeholder="" required="" value="<?php echo e($data->price); ?>"><span></span>
                          </div>
                        </div>

                       

                        <div class="row hidden">
                          <div class="col-lg-4">
                            <div class="left-area">
                                <h4 class="heading"><?php echo e(__('Value')); ?> *</h4>
                            </div>
                          </div>
                          <div class="col-lg-7">
                            <input type="text" class="input-field less-width" name="times" placeholder="<?php echo e(__('Enter Value')); ?>" value="<?php echo e($data->times); ?>"><span></span>
                          </div>
                        </div>


                        <div class="row">
                          <div class="col-lg-4">
                            <div class="left-area">
                                <h4 class="heading"><?php echo e(__('Start Date')); ?> *</h4>
                                <p class="sub-heading"><?php echo e(__('(In Any Language)')); ?></p>
                            </div>
                          </div>
                          <div class="col-lg-7">
                            <input type="text" class="input-field" name="start_date" id="from" placeholder="<?php echo e(__('Select a date')); ?>" required="" value="<?php echo e($data->start_date); ?>">
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-lg-4">
                            <div class="left-area">
                                <h4 class="heading"><?php echo e(__('End Date')); ?> *</h4>
                                <p class="sub-heading"><?php echo e(__('(In Any Language)')); ?></p>
                            </div>
                          </div>
                          <div class="col-lg-7">
                            <input type="text" class="input-field" name="end_date" id="to" placeholder="<?php echo e(__('Select a date')); ?>" required="" value="<?php echo e($data->end_date); ?>">
                          </div>
                        </div>

                        <br>
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

<?php $__env->startSection('scripts'); ?>

<script type="text/javascript">



(function () {

      var val = $('#type').val();
      var selector = $('#type').parent().parent().next();
      if(val == "")
      {
        selector.hide();
      }
      else {
        if(val == 0)
        {
          selector.find('.heading').html('<?php echo e(__('Percentage')); ?> *');
          selector.find('input').attr("placeholder", "<?php echo e(__('Enter Percentage')); ?>").next().html('%');
          selector.css('display','flex');
        }
        else if(val == 1){
          selector.find('.heading').html('<?php echo e(__('Amount')); ?> *');
          selector.find('input').attr("placeholder", "<?php echo e(__('Enter Amount')); ?>").next().html('$');
          selector.css('display','flex');
        }
      }
})();



    $('#type').on('change', function() {
      var val = $(this).val();
      var selector = $(this).parent().parent().next();
      if(val == "")
      {
        selector.hide();
      }
      else {
        if(val == 0)
        {
          selector.find('.heading').html('<?php echo e(__('Percentage')); ?> *');
          selector.find('input').attr("placeholder", "<?php echo e(__('Enter Percentage')); ?>").next().html('%');
          selector.css('display','flex');
        }
        else if(val == 1){
          selector.find('.heading').html('<?php echo e(__('Amount')); ?> *');
          selector.find('input').attr("placeholder", "<?php echo e(__('Enter Amount')); ?>").next().html('$');
          selector.css('display','flex');
        }
      }
    });






(function () {

    var val = $("#times").val();
    var selector = $("#times").parent().parent().next();
    if(val == 1){
    selector.css('display','flex');
    }
    else{
    selector.find('input').val("");
    selector.hide();    
    }

})();


  $(document).on("change", "#times" , function(){
    var val = $(this).val();
    var selector = $(this).parent().parent().next();
    if(val == 1){
    selector.css('display','flex');
    }
    else{
    selector.find('input').val("");
    selector.hide();    
    }
});

</script>

<script type="text/javascript">
    var dateToday = new Date();
    var dates =  $( "#from,#to" ).datepicker({
        defaultDate: "+1w",
        changeMonth: true,
        changeYear: true,
        minDate: dateToday,
        onSelect: function(selectedDate) {
        var option = this.id == "from" ? "minDate" : "maxDate",
          instance = $(this).data("datepicker"),
          date = $.datepicker.parseDate(instance.settings.dateFormat || $.datepicker._defaults.dateFormat, selectedDate, instance.settings);
          dates.not(this).datepicker("option", option, date);
    }
});
</script>

<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>