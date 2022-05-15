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
              <a href="<?php echo e(route('front.below', $element->slug)); ?>"> <i class="icon licon-chevron-right"></i>  <?php echo e($element->name); ?> <span class="notranslate">(<?php echo e(count($element->bproducts)); ?>)</span> </a>
              <?php if(!empty($cat) && $cat->id == $element->id && !empty($cat->subs)): ?>
              <ul class="module-sub-list_item">
                <?php $__currentLoopData = $cat->subs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $subelement): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li>
                  <a href="<?php echo e(route('front.below', [$cat->slug, $subelement->slug])); ?>" ><i class="icon licon-chevron-right"></i> <?php echo e($subelement->name); ?> <span class="notranslate">(<?php echo e(count($subelement->bproducts)); ?>)</span></a>
                  <?php if(!empty($subcat) && $subcat->id == $subelement->id && !empty($subcat->childs)): ?>
                  <ul  class="module-list_item">
                    <?php $__currentLoopData = $subcat->childs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $childcat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li>
                      <a href="<?php echo e(route('front.below', [$cat->slug, $subelement->slug, $childcat->slug])); ?>"><i class="icon licon-chevron-right"></i>  <?php echo e($childcat->name); ?> <span class="notranslate">(<?php echo e(count($childcat->bproducts)); ?>)</span></a>
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
      <div class="hiraola-sidebar-catagories_area" style="display:none">
        <div class="hiraola-sidebar_categories">
          <div class="hiraola-categories_title">
            <h5>Price</h5>
          </div>
          <div class="price-filter">
            <form id="catalogForm" action="<?php echo e(route('front.below', [Request::route('category'), Request::route('subcategory'), Request::route('childcategory')])); ?>" method="GET">
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

</div>


</div>
</div>
