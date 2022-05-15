<?php $__env->startSection('content'); ?>

<!-- Vendor Area Start -->
  <div class="vendor-banner" style="background: url(https://shop.southindiajewels.com/wp-content/uploads/2021/03/banner1.png) no-repeat center center / cover;">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
           
          <div class="content text-center">
            <p class="sub-title">
               
            </p>
            <h2 class="title text-center">
              Below 1000
            </h2>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <div class="hiraola-content_wrapper">
  <div class="container">
    <div class="row">
     <?php echo $__env->make('includes.below-catalog', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
     <div class="col-lg-9 order-first order-lg-last ajax-loader-parent">
       <div class="right-area" id="app">
        <?php echo $__env->make('includes.below-filter', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <div class="categori-item-area">
          <div class="shop-product-wrap grid gridview-3 row" id="ajaxContent">
          
           <?php echo $__env->make('includes.product.filtered-belowproducts', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
             
         </div>
         <div id="ajaxLoader" class="ajax-loader" style="background: url(<?php echo e(asset('assets/images/'.$gs->loader)); ?>) no-repeat scroll center center rgba(0,0,0,.6);"></div>
       </div>
     </div>
   </div>
 </div>
</div>
</div>

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
        filterlink += '<?php echo e(route('front.below', [Request::route('category'), Request::route('subcategory'), Request::route('childcategory')])); ?>' + '?search='+$("#prod_name").val();
      } else {
        filterlink += '&search='+$("#prod_name").val();
      }
    }

    $(".attribute-input").each(function() {
      if ($(this).is(':checked')) {
        if (filterlink == '') {
          filterlink += '<?php echo e(route('front.below', [Request::route('category'), Request::route('subcategory'), Request::route('childcategory')])); ?>' + '?'+$(this).attr('name')+'='+$(this).val();
        } else {
          filterlink += '&'+$(this).attr('name')+'='+$(this).val();
        }
      }
    });

    if ($("#sortby").val() != '') {
      if (filterlink == '') {
        filterlink += '<?php echo e(route('front.below', [Request::route('category'), Request::route('subcategory'), Request::route('childcategory')])); ?>' + '?'+$("#sortby").attr('name')+'='+$("#sortby").val();
      } else {
        filterlink += '&'+$("#sortby").attr('name')+'='+$("#sortby").val();
      }
    }
    
     if ($("#sortbytext").val() != '') {
      if (filterlink == '') {
        filterlink += '<?php echo e(route('front.below', [Request::route('category'), Request::route('subcategory'), Request::route('childcategory')])); ?>' + '?'+$("#sortby").attr('name')+'='+$("#sortby").val();
      } else {
        filterlink += '&'+$("#sortbytext").attr('name')+'='+$("#sortbytext").val();
      }
    }

    if ($("#min_price").val() != '') {
      if (filterlink == '') {
        filterlink += '<?php echo e(route('front.below', [Request::route('category'), Request::route('subcategory'), Request::route('childcategory')])); ?>' + '?'+$("#min_price").attr('name')+'='+$("#min_price").val();
      } else {
        filterlink += '&'+$("#min_price").attr('name')+'='+$("#min_price").val();
      }
    }

    if ($("#max_price").val() != '') {
      if (filterlink == '') {
        filterlink += '<?php echo e(route('front.below', [Request::route('category'), Request::route('subcategory'), Request::route('childcategory')])); ?>' + '?'+$("#max_price").attr('name')+'='+$("#max_price").val();
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

      let fullUrl = '<?php echo e(route('front.below', [Request::route('category'),Request::route('subcategory'),Request::route('childcategory')])); ?>?page='+page+'&search='+'<?php echo e(request()->input('search')); ?>';

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

  $(document).on('click', '.categori-item-area .pagination li a', function (event) {
    event.preventDefault();
    if ($(this).attr('href') != '#' && $(this).attr('href')) {
      $('#preloader').show();
      $('#ajaxContent').load($(this).attr('href'), function (response, status, xhr) {
        if (status == "success") {
          $('#preloader').fadeOut();
          $("html,body").animate({
            scrollTop: 0
          }, 1);

          addToPagination();
        }
      });
    }
  });

</script>

<script type="text/javascript">

  $(function () {
    $("#slider-range").slider({
    range: true,
    orientation: "horizontal",
    min: 0,
    max: 10000000,
    values: [<?php echo e(isset($_GET['min']) ? $_GET['min'] : '0'); ?>, <?php echo e(isset($_GET['max']) ? $_GET['max'] : '10000000'); ?>],
    step: 5,

    slide: function (event, ui) {
      if (ui.values[0] == ui.values[1]) {
        return false;
      }

      $("#min_price").val(ui.values[0]);
      $("#max_price").val(ui.values[1]);
    }
    });

    $("#min_price").val($("#slider-range").slider("values", 0));
    $("#max_price").val($("#slider-range").slider("values", 1));

  });
</script>




<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.front', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>