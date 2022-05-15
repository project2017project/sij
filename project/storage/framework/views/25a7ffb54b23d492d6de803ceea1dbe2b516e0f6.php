   <div class="col-lg-3 order-2 order-lg-1">
       <a href="javascript:void(0)" class="filter_btn_mobile">Filter</a>
       <div class="fiter-box_side">
           <a href="javascript:void(0)" class="close_filter_mobile">X</a>
    <div class="hiraola-sidebar-catagories_area">
      <div class="category-module hiraola-sidebar_categories">
        <div class="category-module_heading"><h5>Categories</h5></div>
        <div class="module-body">          
          <ul  class="module-list_item">
            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $element): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li>
              <a href="<?php echo e(route('front.category', $element->slug)); ?>"> <i class="icon licon-chevron-right"></i>  <?php echo e($element->name); ?> <!--<span class="notranslate">(<?php echo e(count($element->products)); ?>)</span>--> </a>
              <?php if(!empty($cat) && $cat->id == $element->id && !empty($cat->subs)): ?>
              <ul class="module-sub-list_item">
                <?php $__currentLoopData = $cat->subs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $subelement): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li>
                  <a href="<?php echo e(route('front.category', [$cat->slug, $subelement->slug])); ?>" ><i class="icon licon-chevron-right"></i> <?php echo e($subelement->name); ?> <!--<span class="notranslate">(<?php echo e(count($subelement->products)); ?>)</span>--></a>
                  <?php if(!empty($subcat) && $subcat->id == $subelement->id && !empty($subcat->childs)): ?>
                  <ul  class="module-list_item">
                    <?php $__currentLoopData = $subcat->childs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $childcat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li>
                      <a href="<?php echo e(route('front.category', [$cat->slug, $subcat->slug, $childcat->slug])); ?>"><i class="icon licon-chevron-right"></i>  <?php echo e($childcat->name); ?> <!--<span class="notranslate">(<?php echo e(count($childcat->products)); ?>)</span>--></a>
                    </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  </ul>
                  <?php endif; ?>
                </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </ul>                      
              <?php endif; ?>
            </li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </ul>
        </div>
      </div>
      <div class="hiraola-sidebar-catagories_area">
        <div class="hiraola-sidebar_categories">
          <div class="hiraola-categories_title">
            <h5>Price</h5>
          </div>
          <div class="price-filter">
            <form id="catalogForm" action="<?php echo e(route('front.category', [Request::route('category'), Request::route('subcategory'), Request::route('childcategory')])); ?>" method="GET">
            <?php if(!empty(request()->input('search'))): ?>
            <input type="hidden" name="search" value="<?php echo e(request()->input('search')); ?>">
            <?php endif; ?>
            <?php if(!empty(request()->input('sort'))): ?>
            <input type="hidden" name="sort" value="<?php echo e(request()->input('sort')); ?>">
            <?php endif; ?>


            <div class="price-range-block">
              <div id="slider-range" class="price-filter-range" name="rangeInput"></div>
              <div class="livecount">
                <input type="number" min=0  name="min"  id="min_price" class="price-range-field" value="0" />
                <span><?php echo e($langg->lang62); ?></span>
                <input type="number" min=0  name="max" id="max_price" class="price-range-field" value="100" />
              </div>
            </div>

            <button class="filter-btn" type="submit" style="opacity: 0; visibility: hidden; position: absolute;"><?php echo e($langg->lang58); ?></button>
          </form>




        </div>
      </div>

    </div>










    <?php if((!empty($cat) && !empty(json_decode($cat->attributes, true))) || (!empty($subcat) && !empty(json_decode($subcat->attributes, true))) || (!empty($childcat) && !empty(json_decode($childcat->attributes, true)))): ?>


    <div class="hiraola-sidebar-catagories_area">


      <form id="attrForm" action="<?php echo e(route('front.category', [Request::route('category'), Request::route('subcategory'), Request::route('childcategory')])); ?>" method="post">

        <!--div>
          <?php if(!empty($cat) && !empty(json_decode($cat->attributes, true))): ?>
          <?php $__currentLoopData = $cat->attributes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $attr): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <div class="hiraola-sidebar_categories">
            <div class="hiraola-categories_title">
              <h5><?php echo e($attr->name); ?></h5>
            </div>
            <ul class="sidebar-checkbox_list">
              <?php if(!empty($attr->attribute_options)): ?>
              <?php $__currentLoopData = $attr->attribute_options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <li>
               <input name="<?php echo e($attr->input_name); ?>[]" class="form-check-input attribute-input" type="checkbox" id="<?php echo e($attr->input_name); ?><?php echo e($option->id); ?>" value="<?php echo e($option->name); ?>">
               <label class="form-check-label" for="<?php echo e($attr->input_name); ?><?php echo e($option->id); ?>"><?php echo e($option->name); ?></label>
             </li>

             <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
             <?php endif; ?>
           </ul>
         </div>
         <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
         <?php endif; ?>

       </div-->




       <!--div>


        <?php if(!empty($subcat) && !empty(json_decode($subcat->attributes, true))): ?>
        <?php $__currentLoopData = $subcat->attributes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $attr): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

        <div class="hiraola-sidebar_categories">
          <div class="hiraola-categories_title">
            <h5><?php echo e($attr->name); ?></h5>
          </div>
          <ul class="sidebar-checkbox_list">


            <?php if(!empty($attr->attribute_options)): ?>
            <?php $__currentLoopData = $attr->attribute_options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

            <li>

              <input name="<?php echo e($attr->input_name); ?>[]" class="form-check-input attribute-input" type="checkbox" id="<?php echo e($attr->input_name); ?><?php echo e($option->id); ?>" value="<?php echo e($option->name); ?>">
              <label class="form-check-label" for="<?php echo e($attr->input_name); ?><?php echo e($option->id); ?>"><?php echo e($option->name); ?></label>

            </li>


            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>


          </ul>
        </div>




        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>


      </div-->






      <!--div>


        <?php if(!empty($childcat) && !empty(json_decode($childcat->attributes, true))): ?>
        <?php $__currentLoopData = $childcat->attributes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $attr): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

        <div class="hiraola-sidebar_categories">
          <div class="hiraola-categories_title">
            <h5><?php echo e($attr->name); ?></h5>
          </div>
          <ul class="sidebar-checkbox_list">


           <?php if(!empty($attr->attribute_options)): ?>
           <?php $__currentLoopData = $attr->attribute_options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

           <li>

            <input name="<?php echo e($attr->input_name); ?>[]" class="form-check-input attribute-input" type="checkbox" id="<?php echo e($attr->input_name); ?><?php echo e($option->id); ?>" value="<?php echo e($option->name); ?>">
            <label class="form-check-label" for="<?php echo e($attr->input_name); ?><?php echo e($option->id); ?>"><?php echo e($option->name); ?></label>

          </li>


          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          <?php endif; ?>


        </ul>
      </div>




      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      <?php endif; ?>


    </div-->








  </form>



</div>

<?php endif; ?>







<?php if(!isset($vendor)): ?>




<?php else: ?>

<div class="service-center">
  <div class="header-area">
    <h4 class="title">
      <?php echo e($langg->lang227); ?>

    </h4>
  </div>
  <div class="body-area">
    <ul class="list">
      <li>
        <a href="javascript:;" data-toggle="modal" data-target="<?php echo e(Auth::guard('web')->check() ? '#vendorform1' : '#comment-log-reg'); ?>">
          <i class="icofont-email"></i> <span class="service-text"><?php echo e($langg->lang228); ?></span>
        </a>
      </li>
      <li>
        <a href="tel:+<?php echo e($vendor->shop_number); ?>">
          <i class="icofont-phone"></i> <span class="service-text"><?php echo e($vendor->shop_number); ?></span>
        </a>
      </li>
    </ul>
    <!-- Modal -->
  </div>

  <div class="footer-area">
    <p class="title">
      <?php echo e($langg->lang229); ?>

    </p>
    <ul class="list">


      <?php if($vendor->f_check != 0): ?>
      <li><a href="<?php echo e($vendor->f_url); ?>" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
      <?php endif; ?>
      <?php if($vendor->g_check != 0): ?>
      <li><a href="<?php echo e($vendor->g_url); ?>" target="_blank"><i class="fab fa-google"></i></a></li>
      <?php endif; ?>
      <?php if($vendor->t_check != 0): ?>
      <li><a href="<?php echo e($vendor->t_url); ?>" target="_blank"><i class="fab fa-twitter"></i></a></li>
      <?php endif; ?>
      <?php if($vendor->l_check != 0): ?>
      <li><a href="<?php echo e($vendor->l_url); ?>" target="_blank"><i class="fab fa-linkedin-in"></i></a></li>
      <?php endif; ?>


    </ul>
  </div>
</div>


<?php endif; ?>

</div>
</div>
</div>
