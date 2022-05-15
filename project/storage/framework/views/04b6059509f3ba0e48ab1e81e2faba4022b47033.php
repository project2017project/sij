
<?php $__env->startSection('content'); ?>

<!-- Vendor Area Start -->
  <div class="vendor-banner newstyle" style="background: url(<?php echo e($vendor->shop_image != null ? asset('assets/images/vendorbanner/'.$vendor->shop_image) : ''); ?>); background-repeat: no-repeat; background-size: cover;background-position: center;<?php echo $vendor->shop_image != null ? '' : 'background-color:'.$gs->vendor_color; ?> ">
  
  </div>
<div class="container">
  <div class="row vendor_detail_row">	  
        <div class="col-lg-12">
             <?php if( $vendor->shop_logo != null): ?>
         <p class="stor-logo-vendorpage">
               <img class="vendor-logo" src="<?php echo e($vendor->shop_logo != null ? asset('assets/images/users/'.$vendor->shop_logo) : ''); ?>">

          </p>
              <?php endif; ?>
          <div class="content">
           <!-- <p class="sub-title">
                <?php echo e($langg->lang226); ?>

            </p>-->
            <h2 class="title">
              <?php echo e($vendor->shop_name); ?>

            </h2>
          </div>
        </div>
      </div>
</div>

<!--<section class="info-area">
  <div class="container">


        <?php $__currentLoopData = $services->chunk(4); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $chunk): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

        <div class="row">

        <div class="col-lg-12 p-0">
          <div class="info-big-box">
              <div class="row">
                <?php $__currentLoopData = $chunk; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <div class="col-6 col-xl-3 p-0">
                <div class="info-box">
                  <div class="icon">
                    <img src="<?php echo e(asset('assets/images/services/'.$service->photo)); ?>">
                  </div>
                  <div class="info">
                      <div class="details">
                        <h4 class="title"><?php echo e($service->title); ?></h4>
                      <p class="text">
                        <?php echo $service->details; ?>

                      </p>
                      </div>
                  </div>
                </div>
              </div>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </div>
          </div>
        </div>

        </div>

          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


        </div>
</section>-->


<div class="hiraola-content_wrapper">
  <div class="container">
    <div class="row">
	
     <div class="col-lg-12 order-first order-lg-last ajax-loader-parent">
       <div class="right-area" id="app">
	   
            <?php if(count($vprods) > 0): ?>
        <?php echo $__env->make('includes.vendor-filter', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <div class="categori-item-area">
          <div class="shop-product-wrap grid gridview-4 row" id="ajaxContent">
              <?php $__currentLoopData = $vprods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prod): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
           <?php echo $__env->make('includes.product.product', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
             <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
         </div>
         <div class="page-center category">
                    <?php echo $vprods->appends(['sort' => request()->input('sort'), 'min' => request()->input('min'), 'max' => request()->input('max')])->links(); ?>

                  </div>
         <div id="ajaxLoader" class="ajax-loader" style="background: url(<?php echo e(asset('assets/images/'.$gs->loader)); ?>) no-repeat scroll center center rgba(0,0,0,.6);"></div>
       </div>
        <?php else: ?>
              <div class="page-center">
                <h4 class="text-center"><?php echo e($langg->lang60); ?></h4>
              </div>
            <?php endif; ?>
     </div>
   </div>
 </div>
</div>
</div>





<?php if(Auth::guard('web')->check()): ?>



<div class="message-modal">
  <div class="modal" id="vendorform1" tabindex="-1" role="dialog" aria-labelledby="vendorformLabel1" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="vendorformLabel1"><?php echo e($langg->lang118); ?></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>
      <div class="modal-body">
        <div class="container-fluid p-0">
          <div class="row">
            <div class="col-md-12">
              <div class="contact-form">

                <form id="emailreply">
                  <?php echo e(csrf_field()); ?>

                  <ul>

                    <li>
                      <input type="text" class="input-field" readonly="" placeholder="Send To <?php echo e($vendor->shop_name); ?>" readonly="">
                    </li>

                    <li>
                      <input type="text" class="input-field" id="subj" name="subject" placeholder="<?php echo e($langg->lang119); ?>" required="">
                    </li>

                    <li>
                      <textarea class="input-field textarea" name="message" id="msg" placeholder="<?php echo e($langg->lang120); ?>" required=""></textarea>
                    </li>

                    <input type="hidden" name="email" value="<?php echo e(Auth::guard('web')->user()->email); ?>">
                    <input type="hidden" name="name" value="<?php echo e(Auth::guard('web')->user()->name); ?>">
                    <input type="hidden" name="user_id" value="<?php echo e(Auth::guard('web')->user()->id); ?>">
                    <input type="hidden" name="vendor_id" value="<?php echo e($vendor->id); ?>">

                  </ul>
                  <button class="submit-btn" id="emlsub1" type="submit"><?php echo e($langg->lang118); ?></button>
                </form>

              </div>
            </div>
          </div>
        </div>
      </div>
      </div>
    </div>
  </div>
</div>




<?php endif; ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>

  $(document).ready(function() {

    // when dynamic attribute changes
    $(".attribute-input, #sortby").on('change', function() {
      $("#ajaxLoader").show();
      filter();
    });
    
    $(".attribute-input, #sortbytext").on('keyup', function() {
      $("#ajaxLoader").show();
      filter();
    });

    // when price changed & clicked in search button
    $(".filter-btn").on('click', function(e) {
      e.preventDefault();
      $("#ajaxLoader").show();
      filter();
    });
  });

  function filter() {
    let filterlink = '';

    if ($("#prod_name").val() != '') {
      if (filterlink == '') {
        filterlink += '<?php echo e(route('front.vendor', [Request::route('category'), Request::route('subcategory'), Request::route('childcategory')])); ?>' + '?search='+$("#prod_name").val();
      } else {
        filterlink += '&search='+$("#prod_name").val();
      }
    }

    $(".attribute-input").each(function() {
      if ($(this).is(':checked')) {
        if (filterlink == '') {
          filterlink += '<?php echo e(route('front.vendor', [Request::route('category'), Request::route('subcategory'), Request::route('childcategory')])); ?>' + '?'+$(this).attr('name')+'='+$(this).val();
        } else {
          filterlink += '&'+$(this).attr('name')+'='+$(this).val();
        }
      }
    });

    if ($("#sortby").val() != '') {
      if (filterlink == '') {
        filterlink += '<?php echo e(route('front.vendor', [Request::route('category'), Request::route('subcategory'), Request::route('childcategory')])); ?>' + '?'+$("#sortby").attr('name')+'='+$("#sortby").val();
      } else {
        filterlink += '&'+$("#sortby").attr('name')+'='+$("#sortby").val();
      }
    }
    
     if ($("#sortbytext").val() != '') {
      if (filterlink == '') {
        filterlink += '<?php echo e(route('front.vendor', [Request::route('category'), Request::route('subcategory'), Request::route('childcategory')])); ?>' + '?'+$("#sortby").attr('name')+'='+$("#sortby").val();
      } else {
        filterlink += '&'+$("#sortbytext").attr('name')+'='+$("#sortbytext").val();
      }
    }

    if ($("#min_price").val() != '') {
      if (filterlink == '') {
        filterlink += '<?php echo e(route('front.vendor', [Request::route('category'), Request::route('subcategory'), Request::route('childcategory')])); ?>' + '?'+$("#min_price").attr('name')+'='+$("#min_price").val();
      } else {
        filterlink += '&'+$("#min_price").attr('name')+'='+$("#min_price").val();
      }
    }

    if ($("#max_price").val() != '') {
      if (filterlink == '') {
        filterlink += '<?php echo e(route('front.vendor', [Request::route('category'), Request::route('subcategory'), Request::route('childcategory')])); ?>' + '?'+$("#max_price").attr('name')+'='+$("#max_price").val();
      } else {
        filterlink += '&'+$("#max_price").attr('name')+'='+$("#max_price").val();
      }
    }

    // console.log(filterlink);
    console.log(encodeURI(filterlink));
    $("#ajaxContent").load(encodeURI(filterlink), function(data) {
      // add query string to pagination
      addToPagination();
      $("#ajaxLoader").fadeOut(1000);
    });
  }

  // append parameters to pagination links
  function addToPagination() {
    // add to attributes in pagination links
    $('ul.pagination li a').each(function() {
      let url = $(this).attr('href');
      let queryString = '?' + url.split('?')[1]; // "?page=1234...."

      let urlParams = new URLSearchParams(queryString);
      let page = urlParams.get('page'); // value of 'page' parameter

      let fullUrl = '<?php echo e(route('front.vendor', [Request::route('category'),Request::route('subcategory'),Request::route('childcategory')])); ?>?page='+page+'&search='+'<?php echo e(request()->input('search')); ?>';

      $(".attribute-input").each(function() {
        if ($(this).is(':checked')) {
          fullUrl += '&'+encodeURI($(this).attr('name'))+'='+encodeURI($(this).val());
        }
      });

      if ($("#sortby").val() != '') {
        fullUrl += '&sort='+encodeURI($("#sortby").val());
      }
    
        if ($("#sortbytext").val() != '') {
        fullUrl += '&sort='+encodeURI($("#sortbytext").val());
      }
    

      if ($("#min_price").val() != '') {
        fullUrl += '&min='+encodeURI($("#min_price").val());
      }

      if ($("#max_price").val() != '') {
        fullUrl += '&max='+encodeURI($("#max_price").val());
      }

      $(this).attr('href', fullUrl);
    });
  }



</script>

<script type="text/javascript">
          $(document).on("submit", "#emailreply" , function(){
          var token = $(this).find('input[name=_token]').val();
          var subject = $(this).find('input[name=subject]').val();
          var message =  $(this).find('textarea[name=message]').val();
          var email = $(this).find('input[name=email]').val();
          var name = $(this).find('input[name=name]').val();
          var user_id = $(this).find('input[name=user_id]').val();
          var vendor_id = $(this).find('input[name=vendor_id]').val();
          $('#subj').prop('disabled', true);
          $('#msg').prop('disabled', true);
          $('#emlsub').prop('disabled', true);
     $.ajax({
            type: 'post',
            url: "<?php echo e(URL::to('/vendor/contact')); ?>",
            data: {
                '_token': token,
                'subject'   : subject,
                'message'  : message,
                'email'   : email,
                'name'  : name,
                'user_id'   : user_id,
                'vendor_id'  : vendor_id
                  },
            success: function() {
          $('#subj').prop('disabled', false);
          $('#msg').prop('disabled', false);
          $('#subj').val('');
          $('#msg').val('');
        $('#emlsub').prop('disabled', false);
        toastr.success("<?php echo e($langg->message_sent); ?>");
        $('.ti-close').click();
            }
        });
          return false;
        });
</script>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.front', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>