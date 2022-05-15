<!DOCTYPE html>
<html lang="en">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php if(isset($page->meta_tag) && isset($page->meta_description)): ?>
  <meta name="keywords" content="<?php echo e($page->meta_tag); ?>">
  <meta name="description" content="<?php echo e($page->meta_description); ?>">
  <title><?php echo e($gs->title); ?></title>
  <?php elseif(isset($blog->meta_tag) && isset($blog->meta_description)): ?>
  <meta name="keywords" content="<?php echo e($blog->meta_tag); ?>">
  <meta name="description" content="<?php echo e($blog->meta_description); ?>">
  <title><?php echo e($gs->title); ?></title>
  <?php elseif(isset($productt)): ?>
  <meta name="keywords" content="<?php echo e(!empty($productt->meta_tag) ? implode(',', $productt->meta_tag ): ''); ?>">
  <meta name="description" content="<?php echo e($productt->meta_description != null ? $productt->meta_description : strip_tags($productt->description)); ?>">
  <meta property="og:title" content="<?php echo e($productt->name); ?>" />
  <meta property="og:description" content="<?php echo e($productt->meta_description != null ? $productt->meta_description : strip_tags($productt->description)); ?>" />
  <meta property="og:image" content="<?php echo e(asset('assets/images/thumbnails/'.$productt->thumbnail)); ?>" />
  <meta name="author" content="Webngigs">
  <title><?php echo e(substr($productt->name, 0,11)."-"); ?><?php echo e($gs->title); ?></title>
  
    <?php elseif(isset($childcat)): ?>
  
  <meta name="keywords" content="<?php echo e($childcat->meta_keyword); ?>">
  <meta name="description" content="<?php echo e($childcat->meta_description); ?>">
    <meta name="author" content="Webngigs">
  <title><?php echo e($childcat->meta_title); ?> <?php echo e($gs->title); ?></title>
  
   
  
  <?php elseif(isset($cat)): ?>
  
  <meta name="keywords" content="<?php echo e($cat->meta_keyword); ?>">
  <meta name="description" content="<?php echo e(str_replace('&nbsp;', ' ', $cat->meta_description)); ?>">
    <meta name="author" content="Webngigs">
  <title><?php echo e($cat->meta_title); ?> <?php echo e($gs->title); ?></title>
  

  

  
  <?php else: ?>
  <meta name="keywords" content="<?php echo e($seo->meta_keys); ?>">
  <meta name="author" content="Webngigs">
  <title><?php echo e($gs->title); ?></title>
  <?php endif; ?>
  <!-- favicon -->
  <link rel="icon"  type="image/x-icon" href="<?php echo e(asset('assets/images/'.$gs->favicon)); ?>"/>
  <link
  href="https://fonts.googleapis.com/css?family=Maven+Pro:400,500,700%7CRoboto:300,300i,400,400i,500,500i,700,700i,900,900i&display=swap"
  rel="stylesheet">


  <?php if($langg->rtl == "1"): ?>


  <link rel="stylesheet" href="<?php echo e(asset('assets/lunia/css/vendor/bootstrap.min.css')); ?>">

  <link rel="stylesheet" href="<?php echo e(asset('assets/lunia/css/vendor/font-awesome.css')); ?>">

  <link rel="stylesheet" href="<?php echo e(asset('assets/lunia/css/vendor/fontawesome-stars.css')); ?>">

  <link rel="stylesheet" href="<?php echo e(asset('assets/lunia/css/vendor/ion-fonts.css')); ?>">


  <link rel="stylesheet" href="<?php echo e(asset('assets/lunia/css/plugins/slick.css')); ?>">

  <link rel="stylesheet" href="<?php echo e(asset('assets/lunia/css/plugins/animate.css')); ?>">

  <link rel="stylesheet" href="<?php echo e(asset('assets/lunia/css/plugins/jquery-ui.min.css')); ?>">

  <link rel="stylesheet" href="<?php echo e(asset('assets/lunia/css/plugins/lightgallery.min.css')); ?>">

  <link rel="stylesheet" href="<?php echo e(asset('assets/lunia/css/plugins/nice-select.css')); ?>">

  <link rel="stylesheet" href="<?php echo e(asset('assets/lunia/css/plugins/timecircles.css')); ?>">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/prettyphoto/3.1.5/js/jquery.prettyPhoto.js">

  <link rel="stylesheet" href="<?php echo e(asset('assets/lunia/css/scss.css')); ?>">

  <link rel="stylesheet" href="<?php echo e(asset('assets/lunia/css/style.css')); ?>">


  <?php else: ?>


  <link rel="stylesheet" href="<?php echo e(asset('assets/front/css/all.css')); ?>">






  <link rel="stylesheet" href="<?php echo e(asset('assets/lunia/css/vendor/bootstrap.min.css')); ?>">

  <link rel="stylesheet" href="<?php echo e(asset('assets/lunia/css/vendor/font-awesome.css')); ?>">

  <link rel="stylesheet" href="<?php echo e(asset('assets/lunia/css/vendor/fontawesome-stars.css')); ?>">

  <link rel="stylesheet" href="<?php echo e(asset('assets/lunia/css/vendor/ion-fonts.css')); ?>">
  <link rel="stylesheet" href="<?php echo e(asset('assets/beads/css/linearicons.css')); ?>">

  <link rel="stylesheet" href="<?php echo e(asset('assets/lunia/css/plugins/slick.css')); ?>">

  <link rel="stylesheet" href="<?php echo e(asset('assets/lunia/css/plugins/animate.css')); ?>">

  <link rel="stylesheet" href="<?php echo e(asset('assets/lunia/css/plugins/jquery-ui.min.css')); ?>">

  <link rel="stylesheet" href="<?php echo e(asset('assets/lunia/css/plugins/lightgallery.min.css')); ?>">

  <link rel="stylesheet" href="<?php echo e(asset('assets/lunia/css/plugins/nice-select.css')); ?>">

  <link rel="stylesheet" href="<?php echo e(asset('assets/lunia/css/plugins/timecircles.css')); ?>">
  <link rel="stylesheet" href="<?php echo e(asset('assets/lunia/css/prettyPhoto.min.css')); ?>">

  <link rel="stylesheet" href="<?php echo e(asset('assets/lunia/css/scss.css')); ?>">


  <link rel="stylesheet" href="<?php echo e(asset('assets/lunia/css/style.css')); ?>">



  <?php endif; ?>



  <?php echo $__env->yieldContent('styles'); ?>

</head>

<body class="template-color-3">

  <?php if($gs->is_loader == 1): ?>
<!-- 	<div class="preloader" id="preloader" style="background: url(<?php echo e(asset('assets/images/'.$gs->loader)); ?>) no-repeat scroll center center #FFF;"></div>
--><?php endif; ?>

<?php if($gs->is_popup== 1): ?>

<?php if(isset($visited)): ?>
<div style="display:none">
  <img src="<?php echo e(asset('assets/images/'.$gs->popup_background)); ?>">
</div>

<!--  Starting of subscribe-pre-loader Area   -->
<div class="subscribe-preloader-wrap" id="subscriptionForm" style="display: none;">
  <div class="subscribePreloader__thumb" style="background-image: url(<?php echo e(asset('assets/images/'.$gs->popup_background)); ?>);">
    <span class="preload-close"><i class="fas fa-times"></i></span>
    <div class="subscribePreloader__text text-center">
      <h1><?php echo e($gs->popup_title); ?></h1>
      <p><?php echo e($gs->popup_text); ?></p>
      <form action="<?php echo e(route('front.subscribe')); ?>" id="subscribeform" method="POST">
        <?php echo e(csrf_field()); ?>

        <div class="form-group">
          <input type="email" name="email"  placeholder="<?php echo e($langg->lang741); ?>" required="">
          <button id="sub-btn" type="submit"><?php echo e($langg->lang742); ?></button>
        </div>
      </form>
    </div>
  </div>
</div>
<!--  Ending of subscribe-pre-loader Area   -->

<?php endif; ?>

<?php endif; ?>


<div class="main-wrapper">
  <header class="header-main_area header-main_area-3">
    <div class="header-top_area">
      <div class="container-fluid">
        <div class="row">



            <div class="col-lg-3">
            <!--div class="ht-right_area left-align">
              <div class="ht-menu">
                <ul>





                  <?php if($gs->is_currency == 1): ?>
                  <li><a href="javascript:void(0)"><?php echo e(Session::has('currency') ?   DB::table('currencies')->where('id','=',Session::get('currency'))->first()->sign   : DB::table('currencies')->where('is_default','=',1)->first()->sign); ?> <?php echo e(Session::has('currency') ?   DB::table('currencies')->where('id','=',Session::get('currency'))->first()->name   : DB::table('currencies')->where('is_default','=',1)->first()->name); ?><i class="fa fa-chevron-down"></i></a>
                    <ul class="ht-dropdown ht-currency">

                     <?php $__currentLoopData = DB::table('currencies')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $currency): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                     <li><a href="<?php echo e(route('front.currency',$currency->id)); ?>"><?php echo e($currency->sign); ?> <?php echo e($currency->name); ?></a></li>

                     <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                   </ul>
                 </li>
                 <?php endif; ?>
              </ul>
            </div>
          </div-->
        </div>



          <div class="col-lg-6">
            <div class="ht-left_area">
                <div class="mobile-only-item">
             <ul>

                <li>
                    <a href="tel:+91 9150724959">
                    <i class="icon licon-phone"></i>  +91 9150724959 (9.00AM to 6.00PM IST)
                    </a>
                </li>
                
                 <li>
                     <a href="mailto:info@southindiajewels.com">
                    <i class="icon licon-envelope"></i> info@southindiajewels.com
                    </a>
                    
                </li>
              
            </ul>
          </div>
              <div class="welcome_text text-center">
                <p>
                  Free shipping all over India. There might be some delays in delivery due to covid-19
                </p>
              </div>
            </div>
          </div>
          <div class="col-lg-3">
            <div class="ht-right_area">
              <div class="ht-menu">
                <ul>



                 <?php if(!Auth::guard('web')->check()): ?>

                 <li><a href="<?php echo e(route('user.login')); ?>"> <i class="icon licon-user"></i> My Account</a>
                 </li>

                 <?php else: ?>


                 <li><a href="<?php echo e(route('user.login')); ?>"> <i class="icon licon-user"></i> <i class="fa fa-chevron-down"></i></a>
                  <ul class="ht-dropdown ht-my_account">
                    <li><a href="<?php echo e(route('user-dashboard')); ?>" class="mad-ln--independent"><?php echo e($langg->lang221); ?></a></li>
                    <li><a href="<?php echo e(route('user-profile')); ?>" class="mad-ln--independent"><?php echo e($langg->lang205); ?></a></li>
                    <li><a href="<?php echo e(route('user-logout')); ?>" class="mad-ln--independent"> <?php echo e($langg->lang223); ?></a></li>
                  </ul>
                </li>
				

                <?php endif; ?>
				
				<!--<li><a href="<?php echo e(route('front.vendorlogin')); ?>" class="sell-btn"><?php echo e(__('Vendor Login')); ?></a></li>
				<li><a href="<?php echo e(route('front.vendorreg')); ?>" class="sell-btn"><?php echo e(__('Vendor Reg')); ?></a></li>-->
                
               <!--<?php if($gs->reg_vendor == 1): ?>
										<li>
                        				<?php if(Auth::check()): ?>
	                        				<?php if(Auth::guard('web')->user()->is_vendor == 2): ?>
	                        					<a href="<?php echo e(route('vendor-dashboard')); ?>" class="sell-btn"><?php echo e($langg->lang220); ?></a>
	                        				<?php else: ?>
	                        					<a href="<?php echo e(route('user-package')); ?>" class="sell-btn"><?php echo e($langg->lang220); ?></a>
	                        				<?php endif; ?>
										</li>
                        				<?php else: ?>
										<li>
											<a href="javascript:;" data-toggle="modal" data-target="#vendor-login" class="sell-btn"><?php echo e($langg->lang220); ?></a>
										</li>
										<?php endif; ?>
									<?php endif; ?>-->






              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

<div class="header-sticky stick">

  <div class="header-middle_area d-lg-block">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-12">
          <div class="header-middle_wrap">
            <div class="header-contact_area col-sm-3 d-none d-lg-block">
             <ul>

                <li>
                    <a href="tel:+91 9150724959">
                    <i class="icon licon-phone"></i>  +91 9150724959 (9.00AM to 6.00PM IST)
                    </a>
                </li>
                
                 <li>
                     <a href="mailto:info@southindiajewels.com">
                    <i class="icon licon-envelope"></i> info@southindiajewels.com
                    </a>
                    
                </li>
              
            </ul>
          </div>


          <div class="header-logo col-lg-6 col-md-6 text-center">
            <a href="<?php echo e(route('front.index')); ?>"  class="mad-ln--independent logo-header">
              <img src="<?php echo e(asset('assets/images/'.$gs->logo)); ?>" alt="" width="320px">
            </a>

          </div>


          <div class="header-right_area col-lg-3 col-md-6">
            <ul>


                <li>






                <div class="categori-container" id="catSelectForm" style="opacity: 0; position: absolute; visibility: hidden;">
                  <select name="category" id="category_select" class="categoris">
                    <option value=""><?php echo e($langg->lang1); ?></option>

                  </select>
                </div>

                <form id="searchForm" class="mad-search-form" action="<?php echo e(route('front.category')); ?>" method="GET">
                  <button type="submit" class="mad-icon mad-seacrh-click search-btn"><i class="icon licon-magnifier"></i></button>
                  <?php if(!empty(request()->input('sort'))): ?>
                  <input type="hidden" name="sort" value="<?php echo e(request()->input('sort')); ?>">
                  <?php endif; ?>
                  <?php if(!empty(request()->input('minprice'))): ?>
                  <input type="hidden" name="minprice" value="<?php echo e(request()->input('minprice')); ?>">
                  <?php endif; ?>
                  <?php if(!empty(request()->input('maxprice'))): ?>
                  <input type="hidden" name="maxprice" value="<?php echo e(request()->input('maxprice')); ?>">
                  <?php endif; ?>

                  <input type="text" id="prod_name" name="search" placeholder="<?php echo e($langg->lang2); ?>" value="<?php echo e(request()->input('search')); ?>" autocomplete="off">
                  <div class="autocomplete">
                    <!--div id="myInputautocomplete-list" class="autocomplete-items">
                    </div-->
                  </div>

                </form>
              </li>



              <li class="desktop-only-item">

               <?php if(Auth::guard('web')->check()): ?>
               <a href="<?php echo e(route('user-wishlists')); ?>" class="mad-icon wishlistheader" title="Wishlist">
                <i
                class="icon licon-heart"></i><span id="wishlist-count" class="notranslate"><?php echo e(Auth::user()->wishlistCount()); ?></span>
              </a>
              <?php else: ?>
              <a href="javascript:;" data-toggle="modal" id="wish-btn" data-target="#comment-log-reg" class="mad-icon"  title="Wishlist">
                <i
                class="icon licon-heart"></i><span id="wishlist-count" class="notranslate">0</span>
              </a>
              <?php endif; ?>


            </li>

            <li class="cart_icon_header">
           
              <a href="#miniCart" class="minicart-btn toolbar-btn subtotal sc-footer" title="View Your Shopping Cart">
                <i class="icon licon-bag2"></i><span class="cart-quantity notranslate" id="cart-count"><?php echo e(Session::has('cart') ? count(Session::get('cart')->items) : '0'); ?></span> 

              </a>
            </li>


         


            <li class="mobile-only-item menu-icon-mobile">
              <a href="#mobileMenu" class="mobile-menu_btn toolbar-btn color--white d-lg-none d-block">
                <i class="ion-navicon"></i>
              </a>
            </li>




          






        </ul>
      </div>
    </div>
  </div>
</div>
</div>
</div>

<!--<div class="covid_warning">
    Due to Covid restriction, there will be delays in delivery. Orders will be shipped after the lockdown.
</div>
-->
<div class="header-bottom_area">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-4 col-sm-4 d-lg-none d-block">
        <div class="header-logo">
          <a href="index.html">
          <img src="assets/images/menu/logo/2.png" alt="Logo">
          </a>
        </div>
      </div>
      <div class="col-lg-12 d-none d-lg-flex justify-content-center position-static">
        <div class="main-menu_area">
          <nav>



            <ul class="">

             <?php if($gs->is_home == 1): ?>
             <li><a href="<?php echo e(route('front.index')); ?>" class="mad-ln--independent"><?php echo e($langg->lang17); ?></a></li>
             <?php endif; ?>


             <?php $__currentLoopData = DB::table('pages')->where('header','=',1)->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
             <li><a href="<?php echo e(route('front.page',$data->slug)); ?>" class="mad-ln--independent"><?php echo e($data->title); ?></a></li>
             <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


           



             <?php
								$i=1;
								?>
								<?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

								<li class="<?php echo e($category->name); ?>">
								<?php if(count($category->subs) > 0): ?>
										<a href="<?php echo e(route('front.category',$category->slug)); ?>"><?php echo e($category->name); ?></a>
								<?php else: ?>
									<a href="<?php echo e(route('front.category',$category->slug)); ?>"><?php echo e($category->name); ?></a>

								<?php endif; ?>
									<?php if(count($category->subs) > 0): ?>

									<?php
									$ck = 0;
									foreach($category->subs as $subcat) {
										if(count($subcat->childs) > 0) {
											$ck = 1;
											break;
										}
									}
									?>
									<ul class="hm-dropdown">
										<?php $__currentLoopData = $category->subs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subcat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
											<li>
												<a href="<?php echo e(route('front.subcat',['slug1' => $subcat->category->slug, 'slug2' => $subcat->slug])); ?>"><?php echo e($subcat->name); ?></a>
												<?php if(count($subcat->childs) > 0): ?>
														<ul class="hm-dropdown hm-sub_dropdown">
															<?php $__currentLoopData = $subcat->childs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $childcat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
															<li><a href="<?php echo e(route('front.childcat',['slug1' => $childcat->subcategory->category->slug, 'slug2' => $childcat->subcategory->slug, 'slug3' => $childcat->slug])); ?>"><?php echo e($childcat->name); ?></a></li>
															<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
														</ul>
												<?php endif; ?>
											</li>
										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									</ul>

									<?php endif; ?>

									</li>

									<?php
									$i++;
									?>

									<?php if($i == 15): ?>
						                <li>
						                <a href="<?php echo e(route('front.categories')); ?>"><i class="fas fa-plus"></i> <?php echo e($langg->lang15); ?> </a>
						                </li>
						                <?php break; ?>
									<?php endif; ?>


									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

     
                                
     
     
                                     <li>
                                        <a href="<?php echo e(route('front.onsale','imitation-jewellery')); ?>" class="">On Sale</a>
                                      </li> 
                                      
                                      
                                       <li>
                                        <a href="<?php echo e(route('front.below','imitation-jewellery')); ?>" class="">Below 1000</a>
                                      </li> 




                    <!--     <?php if($gs->is_faq == 1): ?>
              <li class="menu-item"><a href="https://blog.southindiajewels.com/" class="mad-ln--independent">Blogs</a></li>
              <?php endif; ?> 

             -->


            



         <li>
                <a href="javascript:;" data-toggle="modal" data-target="#track-order-modal" class="track-btn"><?php echo e($langg->lang16); ?></a>
              </li> 
			  
			  







              
              
            </ul>





          </nav>
        </div>
      </div>
    </div>
  </div>
</div>



</div>










<div class="offcanvas-minicart_wrapper" id="miniCart">

   <div class="offcanvas-menu-inner"  >
    <a href="#" class="btn-close menu-wrap-close"><i class="ion-android-close"></i></a>

    <div class="minicart-content">
      <div class="minicart-heading">
        <h4>Shopping Cart</h4>
      </div>

      </div>

 <?php echo $__env->make('load.cart', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

 </div>

</div>

<div class="mobile-menu_wrapper" id="mobileMenu">
  <div class="offcanvas-menu-inner">
    <div class="container">
      <a href="#" class="btn-close"><i class="ion-android-close"></i></a>
     <!--  <div class="offcanvas-inner_search">
        <form action="#" class="hm-searchbox">
          <input type="text" placeholder="Search for item...">
          <button class="search_btn" type="submit"><i class="ion-ios-search-strong"></i></button>
        </form>
      </div> -->
      <nav class="offcanvas-navigation">
          
          <div class="mobile-menu-title">
              MENU
          </div>
          
          
                <div class="text-center mob-div-log">
                     <?php if(Auth::guard('web')->check()): ?>
               <a href="<?php echo e(route('user-wishlists')); ?>" class="mad-icon wishlistheader" title="Wishlist">
                <i
                class="icon licon-heart"></i>
              </a>
              <?php else: ?>
              <a href="javascript:;" data-toggle="modal" id="wish-btn" data-target="#comment-log-reg" class="mad-icon"  title="Wishlist">
                <i
                class="icon licon-heart"></i>
              </a>
              <?php endif; ?>
              
              &nbsp; &nbsp;
              
           <?php if(!Auth::guard('web')->check()): ?>

                <a href="<?php echo e(route('user.login')); ?>"> <i class="icon licon-user"></i></a>
               

                 <?php else: ?>

                  <a href="<?php echo e(route('user-dashboard')); ?>"> <i class="icon licon-user"></i></a>
                
            

                <?php endif; ?>
                </div>
        
            
            
             <ul class="mobile-menu">
                 
                  <li>
                <a href="javascript:;" data-toggle="modal" data-target="#track-order-modal" class="track-btn"><?php echo e($langg->lang16); ?></a>
              </li> 



             <?php if($gs->is_home == 1): ?>
             <li><a href="<?php echo e(route('front.index')); ?>" class="mad-ln--independent"><?php echo e($langg->lang17); ?></a></li>
             <?php endif; ?>


             <?php $__currentLoopData = DB::table('pages')->where('header','=',1)->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
             <li><a href="<?php echo e(route('front.page',$data->slug)); ?>" class="mad-ln--independent"><?php echo e($data->title); ?></a></li>
             <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


           



             <?php
								$i=1;
								?>
								<?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

								
								<?php if(count($category->subs) > 0): ?>
								<li class="<?php echo e($category->name); ?>  menu-item-has-children">
										<a href="<?php echo e(route('front.category',$category->slug)); ?>"><?php echo e($category->name); ?></a>
								<?php else: ?>
								<li class="<?php echo e($category->name); ?>">
									<a href="<?php echo e(route('front.category',$category->slug)); ?>"><?php echo e($category->name); ?></a>

								<?php endif; ?>
									<?php if(count($category->subs) > 0): ?>

									<?php
									$ck = 0;
									foreach($category->subs as $subcat) {
										if(count($subcat->childs) > 0) {
											$ck = 1;
											break;
										}
									}
									?>
									<ul class="sub-menu">
										<?php $__currentLoopData = $category->subs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subcat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
											
												<?php if(count($subcat->childs) > 0): ?>
												<li class="menu-item-has-children">
												<a href="<?php echo e(route('front.subcat',['slug1' => $subcat->category->slug, 'slug2' => $subcat->slug])); ?>"><?php echo e($subcat->name); ?></a>
														<ul class="sub-menu">
															<?php $__currentLoopData = $subcat->childs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $childcat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
															<li><a href="<?php echo e(route('front.childcat',['slug1' => $childcat->subcategory->category->slug, 'slug2' => $childcat->subcategory->slug, 'slug3' => $childcat->slug])); ?>"><?php echo e($childcat->name); ?></a></li>
															<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
														</ul>
												</li>
												<?php else: ?>
												
												<li>
											    	<a href="<?php echo e(route('front.subcat',['slug1' => $subcat->category->slug, 'slug2' => $subcat->slug])); ?>"><?php echo e($subcat->name); ?></a>
												</li>
												<?php endif; ?>
											
										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									</ul>

									<?php endif; ?>

									</li>

									<?php
									$i++;
									?>

									<?php if($i == 15): ?>
						                <li>
						                <a href="<?php echo e(route('front.categories')); ?>"><i class="fas fa-plus"></i> <?php echo e($langg->lang15); ?> </a>
						                </li>
						                <?php break; ?>
									<?php endif; ?>


									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

     
     
                                     <li>
                                        <a href="<?php echo e(route('front.onsale')); ?>" class="">On Sale</a>
                                      </li> 
                                      
                                      
                                       <li>
                                        <a href="<?php echo e(route('front.below')); ?>"  class="">Below 1000</a>
                                      </li>  




                    <!--     <?php if($gs->is_faq == 1): ?>
              <li class="menu-item"><a href="https://blog.southindiajewels.com/" class="mad-ln--independent">Blogs</a></li>
              <?php endif; ?> 

             -->


            



        





              
              
            </ul>

            
          </nav>
        </div>
      </div>
    </div>
  </header>

</div>








<?php echo $__env->yieldContent('content'); ?>











<!-- Begin Hiraola's Footer Area -->
<div class="hiraola-footer_area" style="margin-top: 50px;">
  <div class="footer-top_area">
    <div class="container">
      <div class="row">
        <div class="col-lg-6">
          <div class="footer-widgets_info">

                <div class="row">
                  <div class="col-lg-4">
                <div class="footer-widgets_title">
                  <h6>South India Jewels</h6>
                </div>
                <div class="footer-widgets">
                  <ul>
                    <li><a href="<?php echo e(route('front.index')); ?>/about-us">About Us</a></li>
                    <li><a href="https://blog.southindiajewels.com/" target="_blank">Blog</a></li>
                    <!--<li><a href="<?php echo e(route('front.index')); ?>/userreview">Customer Reviews</a></li>-->
                  </ul>
                </div>
              </div>


              <div class="col-lg-4">
                <div class="footer-widgets_title">
                  <h6>Quick Links</h6>
                </div>
                <div class="footer-widgets">
                  <ul>
                    <li><a href="<?php echo e(route('front.index')); ?>/faq">FAQ's</a></li>
                    <li><a href="javascript:;" data-toggle="modal" data-target="#track-order-modal">Track Your Order</a></li>
                  </ul>
                </div>
              </div>


              <div class="col-lg-4">
                <div class="footer-widgets_title">
                  <h6>Policies</h6>
                </div>
                <div class="footer-widgets">
                  <ul>
                    <li><a href="<?php echo e(route('front.index')); ?>/returns-exchanges">Return & Exchange Policy</a></li>
                    <li><a href="<?php echo e(route('front.index')); ?>/shipping-delivery">Shipping & Delivery Policy</a></li>
                    <li><a href="<?php echo e(route('front.index')); ?>/privacy-policy-2">Privacy Policy</a></li>
                    <li><a href="<?php echo e(route('front.index')); ?>/terms-conditions/">Terms & Conditions</a></li>
                  </ul>
                </div>
              </div>








                </div>



            

            
            
          </div>
        </div>
        <div class="col-lg-6">
          <div class="footer-widgets_area">
            <div class="row">
              
              
              <div class="col-lg-6">
                <div class="instagram-container footer-widgets_area">
                  <div class="footer-widgets_title">
                    <h6>Follow Us</h6>
                  </div>
                  
                     <div class="hiraola-social_link" style="padding-top : 0;">
              <ul>
                <?php if(App\Models\Socialsetting::find(1)->f_status == 1): ?>

                <li class="facebook">
                  <a href="<?php echo e(App\Models\Socialsetting::find(1)->facebook); ?>" data-toggle="tooltip" target="_blank" title="Facebook">
                    <i class="fab fa-facebook"></i>
                  </a>
                </li>
                <?php endif; ?>



                <?php if(App\Models\Socialsetting::find(1)->t_status == 1): ?>
                <li class="twitter">
                  <a href="<?php echo e(App\Models\Socialsetting::find(1)->twitter); ?>" data-toggle="tooltip" target="_blank" title="Pinterest">
                    <i class="fab fa-pinterest-square"></i>
                  </a>
                </li>

                <?php endif; ?>


                <?php if(App\Models\Socialsetting::find(1)->g_status == 1): ?>

                <li class="google-plus">
                  <a href="<?php echo e(App\Models\Socialsetting::find(1)->gplus); ?>" data-toggle="tooltip" target="_blank" title="YouTube">
                    <i class="fab fa-youtube"></i>
                  </a>
                </li>
                <?php endif; ?>



                <?php if(App\Models\Socialsetting::find(1)->l_status == 1): ?>

                <li class="instagram">
                  <a href="<?php echo e(App\Models\Socialsetting::find(1)->linkedin); ?>" data-toggle="tooltip" target="_blank" title="Instagram">
                    <i class="fab fa-instagram"></i>
                  </a>
                </li>
                <?php endif; ?>

              </ul>
            </div>   
                 <!-- <div class="widget-short_desc">
                    <p>Stay Tuned with our latest offers and updates by subscribing our mailing list</p>
                  </div>
                  <div class="newsletter-form_wrap">
                    <form action="#" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="newsletters-form validate" target="_blank" novalidate>
                      <div id="mc_embed_signup_scroll">
                        <div id="mc-form" class="mc-form subscribe-form">
                          <input id="mc-email" class="newsletter-input" type="email" autocomplete="off" placeholder="Enter your email" />
                          <button class="newsletter-btn" id="mc-submit">
                            <i class="ion-android-mail" aria-hidden="true"></i>
                          </button>
                        </div>
                      </div>
                    </form>
                  </div>-->
                </div>
              </div>

              <div class="col-lg-6">
                <div class="footer-widgets_info">
                  <div class="footer-widgets_title">
                    <h6>Customer Support</h6>
                  </div>
                  <div class="widgets-essential_stuff">
                    <ul style="font-size : 13px;">
                      <?php if(App\Models\Pagesetting::find(1)): ?>
                      <li class="hiraola-phone"><i class="ion-ios-telephone"></i> <a href="tel:<?php echo e(App\Models\Pagesetting::find(1)->phone); ?>"><?php echo e(App\Models\Pagesetting::find(1)->phone); ?> (9.00AM to 6.00PM IST)</a>
                      </li>
                      <li class="hiraola-email"><i class="ion-android-mail"></i><span>Email:</span> <a href="mailto:<?php echo e(App\Models\Pagesetting::find(1)->email); ?>"><?php echo e(App\Models\Pagesetting::find(1)->email); ?></a></li>
                       <?php endif; ?>
                    </ul>
                  </div>
               
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="footer-bottom_area">
    <div class="container">
      <div class="footer-bottom_nav">
        <div class="row">
        <div class="col-lg-6">
            <div class="copyright text-left">
              <span><?php echo $gs->copyright; ?></span>
            </div>
          </div>
          <div class="col-lg-6">
            <div class="payment text-right">
              <a href="#">
                <img src="<?php echo e(asset('assets/beads/images/payment.png')); ?>" alt="Hiraola's Payment Method">
              </a>
            </div>
          </div>
          
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Hiraola's Footer Area End Here -->

<a href="javascript:;" data-toggle="modal" data-target="#customer-support-modal" class="customer-support-btn">Customer Support</a>













<!-- Back to Top Start -->
<div class="bottomtotop">
  <i class="fas fa-chevron-right"></i>
</div>
<!-- Back to Top End -->

<!-- LOGIN MODAL -->
<div class="modal fade" id="comment-log-reg" tabindex="-1" role="dialog" aria-labelledby="comment-log-reg-Title"
aria-hidden="true">
<div class="modal-dialog  modal-dialog-centered" role="document">
 <div class="modal-content">
  <div class="modal-header">
   <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
<div class="modal-body">
 <nav class="comment-log-reg-tabmenu">
  <div class="nav nav-tabs" id="nav-tab" role="tablist">
   <a class="nav-item nav-link login active" id="nav-log-tab1" data-toggle="tab" href="#nav-log1"
   role="tab" aria-controls="nav-log" aria-selected="true">
   <?php echo e($langg->lang197); ?>

 </a>
 <a class="nav-item nav-link" id="nav-reg-tab1" data-toggle="tab" href="#nav-reg1" role="tab"
 aria-controls="nav-reg" aria-selected="false">
 <?php echo e($langg->lang198); ?>

</a>
</div>
</nav>
<div class="tab-content" id="nav-tabContent">
  <div class="tab-pane fade show active" id="nav-log1" role="tabpanel"
  aria-labelledby="nav-log-tab1">
  <div class="login-area">
    <div class="header-area">
     <h4 class="title"><?php echo e($langg->lang172); ?></h4>
   </div>
   <div class="login-form signin-form">
     <?php echo $__env->make('includes.admin.form-login', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
     <form class="mloginform" action="<?php echo e(route('user.login.submit')); ?>" method="POST">
      <?php echo e(csrf_field()); ?>

      <div class="form-input">
       <input type="email" name="email" placeholder="<?php echo e($langg->lang173); ?>"
       required="">
       <i class="icofont-user-alt-5"></i>
     </div>
     <div class="form-input">
       <input type="password" class="Password" name="password"
       placeholder="<?php echo e($langg->lang174); ?>" required="">
       <i class="icofont-ui-password"></i>
     </div>
     <div class="form-forgot-pass">
       <div class="left">
        <input type="checkbox" name="remember" id="mrp"
        <?php echo e(old('remember') ? 'checked' : ''); ?>>
        <label for="mrp"><?php echo e($langg->lang175); ?></label>
      </div>
      <div class="right">
        <a href="javascript:;" id="show-forgot">
         <?php echo e($langg->lang176); ?>

       </a>
     </div>
   </div>
   <input type="hidden" name="modal" value="1">
   <input class="mauthdata" type="hidden" value="<?php echo e($langg->lang177); ?>">
   <button type="submit" class="submit-btn"><?php echo e($langg->lang178); ?></button>
   <?php if(App\Models\Socialsetting::find(1)->f_check == 1 ||
   App\Models\Socialsetting::find(1)->g_check == 1): ?>
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
</div>
<div class="tab-pane fade" id="nav-reg1" role="tabpanel" aria-labelledby="nav-reg-tab1">
 <div class="login-area signup-area">
  <div class="header-area">
   <h4 class="title"><?php echo e($langg->lang181); ?></h4>
 </div>
 <div class="login-form signup-form">
   <?php echo $__env->make('includes.admin.form-login', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
   <form class="mregisterform" action="<?php echo e(route('user-register-submit')); ?>"
   method="POST">
   <?php echo e(csrf_field()); ?>


   <div class="form-input">
     <input type="text" class="User Name" name="name"
     placeholder="<?php echo e($langg->lang182); ?>" required="">
     <i class="icofont-user-alt-5"></i>
   </div>

   <div class="form-input">
     <input type="email" class="User Name" name="email"
     placeholder="<?php echo e($langg->lang183); ?>" required="">
     <i class="icofont-email"></i>
   </div>

   <div class="form-input">
     <input type="text" class="User Name" name="phone"
     placeholder="<?php echo e($langg->lang184); ?>" required="">
     <i class="icofont-phone"></i>
   </div>

   <div class="form-input">
     <input type="text" class="User Name" name="address"
     placeholder="<?php echo e($langg->lang185); ?>" required="">
     <i class="icofont-location-pin"></i>
   </div>

   <div class="form-input">
     <input type="password" class="Password" name="password"
     placeholder="<?php echo e($langg->lang186); ?>" required="">
     <i class="icofont-ui-password"></i>
   </div>

   <div class="form-input">
     <input type="password" class="Password" name="password_confirmation"
     placeholder="<?php echo e($langg->lang187); ?>" required="">
     <i class="icofont-ui-password"></i>
   </div>


   <?php if($gs->is_capcha == 1): ?>

   <ul class="captcha-area">
     <li>
      <p><img class="codeimg1"
        src="<?php echo e(asset("assets/images/capcha_code.png")); ?>" alt=""> <i
        class="fas fa-sync-alt pointer refresh_code "></i></p>
      </li>
    </ul>

    <div class="form-input">
     <input type="text" class="Password" name="codes"
     placeholder="<?php echo e($langg->lang51); ?>" required="">
     <i class="icofont-refresh"></i>
   </div>


   <?php endif; ?>

   <input class="mprocessdata" type="hidden" value="<?php echo e($langg->lang188); ?>">
   <button type="submit" class="submit-btn"><?php echo e($langg->lang189); ?></button>

 </form>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
<!-- LOGIN MODAL ENDS -->

<!-- FORGOT MODAL -->
<div class="modal fade" id="forgot-modal" tabindex="-1" role="dialog" aria-labelledby="comment-log-reg-Title"
aria-hidden="true">
<div class="modal-dialog  modal-dialog-centered" role="document">
 <div class="modal-content">
  <div class="modal-header">
   <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
<div class="modal-body">

 <div class="login-area">
  <div class="header-area forgot-passwor-area">
   <h4 class="title"><?php echo e($langg->lang191); ?> </h4>
   <p class="text"><?php echo e($langg->lang192); ?> </p>
 </div>
 <div class="login-form">
   <?php echo $__env->make('includes.admin.form-login', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
   <form id="mforgotform" action="<?php echo e(route('user-forgot-submit')); ?>" method="POST">
    <?php echo e(csrf_field()); ?>

    <div class="form-input">
     <input type="email" name="email" class="User Name"
     placeholder="<?php echo e($langg->lang193); ?>" required="">
     <i class="icofont-user-alt-5"></i>
   </div>
   <div class="to-login-page">
     <a href="javascript:;" id="show-login">
      <?php echo e($langg->lang194); ?>

    </a>
  </div>
  <input class="fauthdata" type="hidden" value="<?php echo e($langg->lang195); ?>">
  <button type="submit" class="submit-btn"><?php echo e($langg->lang196); ?></button>
</form>
</div>
</div>

</div>
</div>
</div>
</div>
<!-- FORGOT MODAL ENDS -->


<!-- VENDOR LOGIN MODAL -->
<div class="modal fade" id="vendor-login" tabindex="-1" role="dialog" aria-labelledby="vendor-login-Title" aria-hidden="true">
  <div class="modal-dialog  modal-dialog-centered" style="transition: .5s;" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <nav class="comment-log-reg-tabmenu">
         <div class="nav nav-tabs" id="nav-tab1" role="tablist">
          <a class="nav-item nav-link login active" id="nav-log-tab11" data-toggle="tab" href="#nav-log11" role="tab" aria-controls="nav-log" aria-selected="true">
           <?php echo e($langg->lang234); ?>

         </a>
         <a class="nav-item nav-link" id="nav-reg-tab11" data-toggle="tab" href="#nav-reg11" role="tab" aria-controls="nav-reg" aria-selected="false">
           <?php echo e($langg->lang235); ?>

         </a>
       </div>
     </nav>
     <div class="tab-content" id="nav-tabContent">
       <div class="tab-pane fade show active" id="nav-log11" role="tabpanel" aria-labelledby="nav-log-tab">
        <div class="login-area">
          <div class="login-form signin-form">
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
     </div>
     <div class="tab-pane fade" id="nav-reg11" role="tabpanel" aria-labelledby="nav-reg-tab">
      <div class="login-area signup-area">
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
					</select></div>
			</div>
			<div class="col-lg-6"><div class="form-input">
                    <select id="userstate" name="state"  disabled="">
                        <option value=""><?php echo e(__('Select State')); ?></option>
                    </select></div>
							
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
        <input type="text" class="User Name" name="reg_number" placeholder="<?php echo e($langg->lang242); ?>" required="">
        <i class="icofont-ui-cart"></i>
      </div>
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
</div>
</div>
</div>
</div>
</div>
<!-- VENDOR LOGIN MODAL ENDS -->

<!-- Product Quick View Modal -->

<div class="modal fade" id="quickview" tabindex="-1" role="dialog"  aria-hidden="true">
  <div class="modal-dialog quickview-modal modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
     <div class="submit-loader">
      <img src="<?php echo e(asset('assets/images/'.$gs->loader)); ?>" alt="">
    </div>
    <div class="modal-header">
     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  <div class="modal-body">
    <div class="container quick-view-modal">

    </div>
  </div>
</div>
</div>
</div>
<!-- Product Quick View Modal -->

<!-- Order Tracking modal Start-->
<div class="modal fade" id="track-order-modal" tabindex="-1" role="dialog" aria-labelledby="order-tracking-modal" aria-hidden="true">
  <div class="modal-dialog  modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h6 class="modal-title modern" style="font-weight : 400;"> <?php echo e($langg->lang772); ?> </h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <div class="order-tracking-content">
          <form id="track-form" class="track-form">
            <?php echo e(csrf_field()); ?>

            <input type="text" id="track-code" placeholder="Enter Your Order ID" required="">
            <button type="submit" class="mybtn1"><?php echo e($langg->lang774); ?></button>
            <a href="#"  data-toggle="modal" data-target="#order-tracking-modal"></a>
          </form>
        </div>

        <div>
          <div class="submit-loader d-none">
            <img src="<?php echo e(asset('assets/images/'.$gs->loader)); ?>" alt="">
          </div>
          <div id="track-order">

          </div>
        </div>

      </div>
    </div>
  </div>
</div>
<!-- Order Tracking modal End -->


<!-- Order Tracking modal Start-->
<div class="modal fade" id="customer-support-modal" tabindex="-1" role="dialog" aria-labelledby="customer-support-modal" aria-hidden="true">
  <div class="modal-dialog  modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h6 class="modal-title modern" style="font-weight : 400;"> Customer Support </h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <span class="sucess"></span>
			<span class="error"></span>
        <div class="customer-support-content">
          <form id="support-form" action="<?php echo e(route('front.customer.supports')); ?>" class="support-form">
            <?php echo e(csrf_field()); ?>

            <div class="form-group">
            <input type="text" class="form-control form-control-lg" id="cname" name= "cname" placeholder="Your name" required="">
            </div>
            <div class="form-group">
			<input type="text" id="cemail" class="form-control form-control-lg" name= "cemail" placeholder="Your email" required="">
			</div>
			<div class="form-group">
			<select id="treq" class="form-control form-control-lg" name="treq" required="" onchange="problemCheck(this);">
			  <option value="">Select Type Of Request</option>			  
			  <option value="Order Problem">Order Problem</option>
			  <option value="Enquiry">Enquiry</option>
			</select>
			</div>
			<div class="form-group">
			<input type="text" class="form-control form-control-lg"  id="orderno" name= "orderno" placeholder="Order Number" style="display:none">
			</div>
			<div class="form-group">
			<input type="text" class="form-control form-control-lg"  id="productnumber" name= "productnumber" placeholder="Product Name/Brand/SKU Code" style="display:none">
			</div>
			<div class="form-group">
			<textarea id="desissue" class="form-control form-control-lg" placeholder="Describe the issue" name="desissue" rows="4" cols="50"></textarea>
			</div>
            <button type="submit" class="mybtn1">Submit</button>            <br /> <br />
          </form>
        </div>

        <div>
          <div class="submit-loader d-none">
            <img src="<?php echo e(asset('assets/images/'.$gs->loader)); ?>" alt="">
          </div>
          
        </div>

      </div>
    </div>
  </div>
</div>
<!-- Order Tracking modal End -->

<script type="text/javascript">
function problemCheck(that) {
        document.getElementById("orderno").style.display = "none";
		document.getElementById("productnumber").style.display = "none";
		$("#orderno").prop('required',false);
		$("#productnumber").prop('required',false);
    if (that.value == "Order Problem") { 
        $("#productnumber").prop('required',false);
        $("#orderno").prop('required',true);
        document.getElementById("orderno").style.display = "block";
		document.getElementById("productnumber").style.display = "none";
    }
	if (that.value == "Enquiry") {
	    $("#orderno").prop('required',false);
		$("#productnumber").prop('required',true);
	    document.getElementById("productnumber").style.display = "block";
        document.getElementById("orderno").style.display = "none";
    }
}
    function setCookie(key, value, expiry) {
      var expires = new Date();
      expires.setTime(expires.getTime() + (expiry * 24 * 60 * 60 * 1000));
      document.cookie = key + '=' + value + ';expires=' + expires.toUTCString();
    }

</script>



<script type="text/javascript">
  var mainurl = "<?php echo e(url('/')); ?>";
  var gs      = <?php echo json_encode($gs); ?>;
  var langg    = <?php echo json_encode($langg); ?>;
</script>


<!-- jquery -->


<script src="<?php echo e(asset('assets/front/js/jquery.js')); ?>"></script>
<script src="<?php echo e(asset('assets/lunia/js/vendor/modernizr-2.8.3.min.js')); ?>"></script>
<!-- 	<script src="<?php echo e(asset('assets/front/js/vue.js')); ?>"></script> -->
<script src="<?php echo e(asset('assets/front/jquery-ui/jquery-ui.min.js')); ?>"></script>
<!-- popper -->
<script src="<?php echo e(asset('assets/front/js/popper.min.js')); ?>"></script>


<!-- 	<script src="<?php echo e(asset('assets/beads/vendors/owl-carousel/owl.carousel.min.js')); ?>"></script> -->
<!-- bootstrap -->
<script src="<?php echo e(asset('assets/front/js/bootstrap.min.js')); ?>"></script>
<!-- plugin js-->
<script src="<?php echo e(asset('assets/front/js/plugin.js')); ?>"></script>

<script src="<?php echo e(asset('assets/front/js/xzoom.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/front/js/jquery.hammer.min.js')); ?>"></script>
<script src="<?php echo e(asset('assets/front/js/setup.js')); ?>"></script>

<script src="<?php echo e(asset('assets/front/js/toastr.js')); ?>"></script>






<script src="<?php echo e(asset('assets/lunia/js/plugins/slick.min.js')); ?>"></script>

<script src="<?php echo e(asset('assets/lunia/js/plugins/countdown.js')); ?>"></script>

<script src="<?php echo e(asset('assets/lunia/js/plugins/jquery.barrating.min.js')); ?>"></script>

<script src="<?php echo e(asset('assets/lunia/js/plugins/jquery.counterup.js')); ?>"></script>

<script src="<?php echo e(asset('assets/lunia/js/plugins/jquery.nice-select.js')); ?>"></script>

<script src="<?php echo e(asset('assets/lunia/js/plugins/jquery.sticky-sidebar.js')); ?>"></script>


<script src="<?php echo e(asset('assets/lunia/js/plugins/jquery.ui.touch-punch.min.js')); ?>"></script>

<script src="<?php echo e(asset('assets/lunia/js/plugins/lightgallery.min.js')); ?>"></script>

<script src="<?php echo e(asset('assets/lunia/js/plugins/scroll-top.js')); ?>"></script>

<script src="<?php echo e(asset('assets/lunia/js/plugins/theia-sticky-sidebar.min.js')); ?>"></script>

<script src="<?php echo e(asset('assets/lunia/js/plugins/waypoints.min.js')); ?>"></script>

<script src="<?php echo e(asset('assets/lunia/js/plugins/instafeed.min.js')); ?>"></script>

<script src="<?php echo e(asset('assets/lunia/js/plugins/jquery.elevateZoom-3.0.8.min.js')); ?>"></script>

<script src="<?php echo e(asset('assets/lunia/js/plugins/timecircles.js')); ?>"></script>




<script src="<?php echo e(asset('assets/lunia/js/jquery.prettyPhoto.js')); ?>"></script>







<!-- main -->
<script src="<?php echo e(asset('assets/front/js/main.js')); ?>"></script>
<!-- custom -->
<script src="<?php echo e(asset('assets/front/js/custom.js')); ?>"></script>

<script src="<?php echo e(asset('assets/lunia/js/main.js')); ?>"></script>


<script>


  $(document).ready(function(){
    $("a[rel^='prettyPhoto']").prettyPhoto();
  });

  $(".mad-grid.owl-carousel.mad-products").owlCarousel({
    loop: true,
    autoplay: true,
    margin:10,
        autoplayTimeout: 2000, //2000ms = 2s;
        autoplayHoverPause: true,
        responsive:{
          0:{
            items:2
          },
          600:{
            items:3
          },
          1000:{
            items:5
          }
        },
      });
        $(document).on('change','#usercountry',function () {
            var link = $(this).find(':selected').attr('data-href');
           
            if(link != ""){
                $('#userstate').load(link);
                $('#userstate').prop('disabled',false);
            }
        });





    </script>
    
    
    

    <link rel="stylesheet" href="<?php echo e(asset('assets/lunia/css/scss.css')); ?>">

    <?php echo $seo->google_analytics; ?>


    <?php if($gs->is_talkto == 1): ?>
    <!--Start of Tawk.to Script-->
    <?php echo $gs->talkto; ?>

    <!--End of Tawk.to Script-->
    <?php endif; ?>
    <?php if($gs->is_webpushr == 1): ?>
    <!--Start of webpushr Script-->
    <?php echo $gs->webpushr; ?>

    <!--End of webpushr Script-->
    <?php endif; ?>

    <?php echo $__env->yieldContent('scripts'); ?>
    

  </body>

  </html>
