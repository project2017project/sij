<?php $__env->startSection('content'); ?>

  <section class="blogpagearea">
    <div class="container">


      <div class="hiraola-tab_title" style="padding-bottom: 60px;"><h3>Our Shop Reviews</h3></div>




        <div id="reviews-section">
                            <ul class="all-replay">
                              <?php $__currentLoopData = $rating; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                              <li style="margin-bottom: 35px;">
                                <div class="single-review">
                                  <div class="left-area">
                                    <img
                                      src="<?php echo e($rat->user->photo ? asset('assets/images/users/'.$review->user->photo):asset('assets/images/noimage.png')); ?>"
                                      alt=""> 
                                    <h5 class="name"><?php echo e($rat->user->name); ?></h5>
                                    <p class="date">
                                      <?php echo e(date('d', strtotime($rat->review_date))); ?> <?php echo e(date('M', strtotime($rat->review_date))); ?> <?php echo e(date('Y', strtotime($rat->review_date))); ?>

                                    </p>
                                  </div>
                                  <div class="right-area">
                                    <div class="header-area">

                                        <p>
                                          <img src="<?php echo e($rat->product->photo ? asset('assets/images/products/'.$rat->product->photo):asset('assets/images/noimage.png')); ?>" class="img-fluid" alt="" width="50px;" style="margin-right: 15px;">

                                          <a href="<?php echo e(route('front.product', $rat->product->slug)); ?>"><?php echo e($rat->product->name); ?></a>
                                        </p>
<div style="margin-left: 140px; border-top: 1px solid #eeeeee; padding-left: 25px; padding-top: 20px;">

                <p style="float: left; margin-right: 20px;">
                                        <a href="<?php echo e($rat->image ? asset('assets/images/review/'.$rat->image):asset('assets/images/noimage.png')); ?>" target="_BLANK"><img src="<?php echo e($rat->image ? asset('assets/images/review/'.$rat->image):asset('assets/images/noimage.png')); ?>" width="50px"></a>
                                      </p>

                                      <div class="stars-area">
                                        <ul class="stars">
                                          <div class="ratings">
                          <div class="empty-stars"></div>
                          <div class="full-stars" style="width:<?php echo e(App\Models\Rating::ratings($rat->product_id)); ?>%"></div>
                        </div>
                                        </ul>
                                      </div>
                                   
                                    <div class="review-body">
                                      <p>
                                        <?php echo e($rat->review); ?>

                                      </p>
                                      
                                    </div>
 </div>
                                    </div>
                                  </div>
                                </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                              </li>
                            </ul>


                             <div class="page-center">
          <?php echo $rating->links(); ?>               
        </div>
                          
                          </div>




     

    </div>
  </section>
  <!-- Blog Page Area Start -->




<?php $__env->stopSection(); ?>


<?php $__env->startSection('scripts'); ?>

<script type="text/javascript">
  

    // Pagination Starts

    $(document).on('click', '.pagination li', function (event) {
      event.preventDefault();
      if ($(this).find('a').attr('href') != '#' && $(this).find('a').attr('href')) {
        $('#preloader').show();
        $('#ajaxContent').load($(this).find('a').attr('href'), function (response, status, xhr) {
          if (status == "success") {
            $("html,body").animate({
              scrollTop: 0
            }, 1);
            $('#preloader').fadeOut();


          }

        });
      }
    });

    // Pagination Ends

</script>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.front', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>