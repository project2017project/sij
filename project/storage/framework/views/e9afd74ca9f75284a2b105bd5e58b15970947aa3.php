<!doctype html>
<html lang="en" dir="ltr">

	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
    	<meta name="author" content="Webngigs">
      	<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
		<!-- Title -->
		<title><?php echo e($gs->title); ?></title>
		<!-- favicon -->
		<link rel="icon"  type="image/x-icon" href="<?php echo e(asset('assets/images/'.$gs->favicon)); ?>"/>
		<!-- Bootstrap -->
		<link href="<?php echo e(asset('assets/vendor/css/bootstrap.min.css')); ?>" rel="stylesheet" />
		<!-- Fontawesome -->
		<link rel="stylesheet" href="<?php echo e(asset('assets/vendor/css/fontawesome.css')); ?>">
		<!-- icofont -->
		<link rel="stylesheet" href="<?php echo e(asset('assets/vendor/css/icofont.min.css')); ?>">
		<!-- Sidemenu Css -->
		<link href="<?php echo e(asset('assets/admin/plugins/fullside-menu/css/dark-side-style.css')); ?>" rel="stylesheet" />
		<link href="<?php echo e(asset('assets/vendor/plugins/fullside-menu/waves.min.css')); ?>" rel="stylesheet" />

		<link href="<?php echo e(asset('assets/vendor/css/plugin.css')); ?>" rel="stylesheet" />

		<link href="<?php echo e(asset('assets/vendor/css/jquery.tagit.css')); ?>" rel="stylesheet" />
    	<link rel="stylesheet" href="<?php echo e(asset('assets/vendor/css/bootstrap-coloroicker.css')); ?>">
    	<link rel="stylesheet" href="<?php echo e(asset('assets/vendor/css/invoice.css')); ?>">
    	<link href="https://fonts.googleapis.com/css?family=Roboto:300" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
		<!-- Main Css -->

		<?php if($langg->rtl == "1"): ?>

		<link href="<?php echo e(asset('assets/admin/css/rtl/style.css')); ?>" rel="stylesheet"/>
		<link href="<?php echo e(asset('assets/admin/css/rtl/custom.css')); ?>" rel="stylesheet"/>
		<link href="<?php echo e(asset('assets/admin/css/rtl/responsive.css')); ?>" rel="stylesheet" />
		<link href="<?php echo e(asset('assets/admin/css/common.css')); ?>" rel="stylesheet" />

		<?php else: ?>

		<link href="<?php echo e(asset('assets/admin/css/style.css')); ?>" rel="stylesheet"/>
		<link href="<?php echo e(asset('assets/admin/css/custom.css')); ?>" rel="stylesheet"/>
		<link href="<?php echo e(asset('assets/admin/css/responsive.css')); ?>" rel="stylesheet" />
		<link href="<?php echo e(asset('assets/admin/css/common.css')); ?>" rel="stylesheet" />

		<?php endif; ?>

		<?php echo $__env->yieldContent('styles'); ?>

	</head>
	<body>
		<div class="page">
			<div class="page-main">
				<div class="header">
					<div class="container-fluid">
						<div class="d-flex justify-content-between">
							<a class="admin-logo" href="<?php echo e(route('front.index')); ?>" target="_blank"><img src="<?php echo e(asset('assets/images/'.$gs->logo)); ?>" alt=""></a>
							<div class="menu-toggle-button">
								<a class="nav-link" href="javascript:;" id="sidebarCollapse">
									<div class="my-toggl-icon">
										<span class="bar1"></span>
										<span class="bar2"></span>
										<span class="bar3"></span>
									</div>
								</a>
							</div>

							<div class="right-eliment">
								<ul class="list">
									<li class="bell-area">
										<a id="notf_order" class="dropdown-toggle-1" href="javascript:;">
											<i class="icofont-cart"></i>
											<span data-href="<?php echo e(route('vendor-order-notf-count',Auth::guard('web')->user()->id)); ?>" id="order-notf-count"><?php echo e(App\Models\UserNotification::countOrder(Auth::guard('web')->user()->id)); ?></span>
										</a>
										<div class="dropdown-menu">
											<div class="dropdownmenu-wrapper" 
												data-href="<?php echo e(route('vendor-order-notf-show',Auth::guard('web')->user()->id)); ?>" 
												id="order-notf-show">
											</div>
										</div>
									</li>
									<li class="login-profile-area">
										<a class="dropdown-toggle-1" href="javascript:;">
											<div class="user-img">
								              <?php if(Auth::user()->is_provider == 1): ?>
								              <img src="<?php echo e(Auth::user()->photo ? asset(Auth::user()->photo):asset('assets/images/noimage.png')); ?>" alt="">
								              <?php else: ?>
								              <img src="<?php echo e(Auth::user()->shop_logo ? asset('assets/images/users/'.Auth::user()->shop_logo ):asset('assets/images/noimage.png')); ?>" alt="">
								              <?php endif; ?>
											</div>
										</a>
										<div class="dropdown-menu">
											<div class="dropdownmenu-wrapper">
												<ul>
													<h5><?php echo e($langg->lang431); ?></h5>
													<li><a target="_blank" href="<?php echo e(route('front.vendor',str_replace(' ', '-', Auth::user()->shop_name))); ?>"><i class="fas fa-eye"></i> <?php echo e($langg->lang432); ?></a></li>
													<li><a href="<?php echo e(route('user-dashboard')); ?>"><i class="fas fa-sign-in-alt"></i> <?php echo e($langg->lang433); ?></a></li>
													<li><a href="<?php echo e(route('vendor-profile')); ?>"><i class="fas fa-user"></i> <?php echo e($langg->lang434); ?></a></li>
													<li><a href="<?php echo e(route('user-logout')); ?>"><i class="fas fa-power-off"></i> <?php echo e($langg->lang435); ?></a></li>
												</ul>
											</div>
										</div>
									</li>
								</ul>
							</div>
						</div>
					</div>
				</div>
				<div class="wrapper">
					<nav id="sidebar" class="nav-sidebar">
						<ul class="list-unstyled components" id="accordion">
							<li><a target="_blank" href="<?php echo e(route('front.vendor',str_replace(' ', '-', Auth::user()->shop_name))); ?>" class="wave-effect"><i class="fas fa-eye mr-2"></i> <?php echo e($langg->lang440); ?></a></li>
							<li><a href="<?php echo e(route('vendor-dashboard')); ?>" class="wave-effect "><i class="fa fa-home mr-2"></i>Home</a></li>
                            		<li>
							<a href="#vproducts" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false">
									<i class="icofont-cart"></i>Products</a>
								<ul class="collapse list-unstyled" id="vproducts" data-parent="#accordion">
									<li><a href="<?php echo e(route('vendor-prod-index')); ?>">My Products</a></li>
									<li><a href="<?php echo e(route('vendor-prod-simpleproduct')); ?>">Simple Products</a></li>									
								</ul>
							</li>
							
						<!--	<li><a href="<?php echo e(route('vendor-order-index')); ?>"><i class="fas fa-hand-holding-usd"></i> Orders</a></li>-->
							<li>
							<a href="#vorders" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false">
									<i class="icofont-cart"></i>Orders</a>
								<ul class="collapse list-unstyled" id="vorders" data-parent="#accordion">
								<?php							
							$all_order_count = App\Models\VendorOrder::where('user_id','=',Auth::guard('web')->user()->id)->orderBy('id','desc')->get()->groupBy('order_number');			
							?>
									<li><a href="<?php echo e(route('vendor-vorders-newindex')); ?>">All Orders <span class="badge badge-danger">(<?php echo e(count($all_order_count)); ?>)</span></a></li>
									<?php							
							$process_order_count = App\Models\VendorOrder::where('user_id','=',Auth::guard('web')->user()->id)->where('status','=','processing')->orderBy('id','desc')->get()->groupBy('order_number');			
							?>
									<li><a href="<?php echo e(route('vendor-order-vprocessing')); ?>">Processing <span class="badge badge-danger">(<?php echo e(count($process_order_count)); ?>)</span></a></li>
							<?php							
							$sh_order_count = App\Models\VendorOrder::where('user_id','=',Auth::guard('web')->user()->id)->where('status','=','on delivery')->orderBy('id','desc')->get()->groupBy('order_number');			
							?>
                                    <li><a href="<?php echo e(route('vendor-order-shipping')); ?>">Shipping <span class="badge badge-danger"> (<?php echo e(count($sh_order_count)); ?>) </span></a></li>
                            <?php							
							$com_order_count = App\Models\VendorOrder::where('user_id','=',Auth::guard('web')->user()->id)->where('status','=','completed')->orderBy('id','desc')->get()->groupBy('order_number');			
							?>									
                                     <li><a href="<?php echo e(route('vendor-order-vcompleted')); ?>">Completed <span class="badge badge-danger"> (<?php echo e(count($com_order_count)); ?>) <span></span></a></li>
																	
								</ul>
							</li>
							
							<!-- <li><a href="#order" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false"><i class="fas fa-hand-holding-usd"></i><?php echo e($langg->lang442); ?></a>
								<ul class="collapse list-unstyled" id="order" data-parent="#accordion" >
                                   	<li><a href="<?php echo e(route('vendor-order-index')); ?>"> <?php echo e($langg->lang443); ?></a></li>
								</ul>
							</li> -->
							
							
						
							<li>
								<a href="#withdraw" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false">
									<i class="fas fa-list"></i>Payments</a>
								<ul class="collapse list-unstyled" id="withdraw" data-parent="#accordion">
									<!--<li><a href="<?php echo e(route('vendor-wt-index')); ?>">Requested</a></li>-->
									<li><a href="<?php echo e(route('vendor-wt-pending')); ?>">Pending</a></li>
									<li><a href="<?php echo e(route('vendor-wt-completed')); ?>">Completed</a></li>
									<!--<li><a href="<?php echo e(route('vendor-wt-rejected')); ?>">Rejected</a></li>-->
									  <?php
                                      $withdraw_od_count = App\Models\VendorOrder::where('user_id','=',Auth::guard('web')->user()->id)->where('admin_approve','=','approved')->whereIn('vendor_request_status',['NotRaised','rejected'])->where('product_item_price','=',NULL)->orderBy('id','desc')->get()->groupBy('order_number');
                                     ?>
                                    <li><a href="<?php echo e(route('vendor-order-withdraw-list')); ?>">Available for Withdraw <?php echo e(count($withdraw_od_count)); ?>)</a></li>
									<li><a href="<?php echo e(route('vendor-withdraw-adminapprovelist')); ?>">Waiting For Admin Approval</a></li>
									<li><a href="<?php echo e(route('vendor-withdraws-index')); ?>">Withdraw List</a></li>
								</ul>
							</li>
							<?php							
							$ref_count = App\Models\RaiseDispute::where('vendor_id','=',Auth::guard('web')->user()->id)->where('status','=','open')->orderBy('id','desc')->count('id');
							?>
							<li><a href="<?php echo e(route('vendor-raise-index')); ?>"><i class="fas fa-hand-holding-usd"></i> Refunds </a></li>
							<?php							
							$deb_count = App\Models\DebitNote::where('vendor_id','=',Auth::guard('web')->user()->id)->where('status','=',0)->orderBy('id','desc')->count('id');
							?>
							<li><a href="<?php echo e(route('vendor-debit-index')); ?>"><i class="fas fa-hand-holding-usd"></i> Debit Note<span class="badge badge-danger"> (<?php echo e($deb_count); ?>) </span> </a></li>
							<?php							
							$credit_count = App\Models\CreditNote::where('vendor_id','=',Auth::guard('web')->user()->id)->where('status','=',0)->orderBy('id','desc')->count('id');
							?>
							<li><a href="<?php echo e(route('vendor-credit-index')); ?>"><i class="fas fa-hand-holding-usd"></i> Credit Note<span class="badge badge-danger"> (<?php echo e($credit_count); ?>) </span> </a></li>
							<?php							
							$exc_count = App\Models\Exchange::where('vendor_id','=',Auth::guard('web')->user()->id)->where('status','=','pending')->orderBy('id','desc')->count('id');
							?>
							<li><a href="<?php echo e(route('vendor-exchange-index')); ?>"><i class="fas fa-hand-holding-usd"></i> Exchange<span class="badge badge-danger"> (<?php echo e($exc_count); ?>) </span> </a></li>
							
							<?php							
							$rto_count = App\Models\Rto::where('vendor_id','=',Auth::guard('web')->user()->id)->where('status','=','pending')->orderBy('id','desc')->count('id');
							?>
							<li><a href="<?php echo e(route('vendor-rto-index')); ?>"><i class="fas fa-hand-holding-usd"></i> Rto<span class="badge badge-danger"> (<?php echo e($rto_count); ?>) </span> </a></li>
						
							<!-- <li><a href="#menu2" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false"><i class="icofont-cart"></i><?php echo e($langg->lang444); ?></a>
								<ul class="collapse list-unstyled" id="menu2" data-parent="#accordion">
									<li><a href="<?php echo e(route('vendor-prod-types')); ?>"><span><?php echo e($langg->lang445); ?></span></a></li>
									<li><a href="<?php echo e(route('vendor-prod-index')); ?>"><span><?php echo e($langg->lang446); ?></span></a></li>
									<li><a href="<?php echo e(route('admin-vendor-catalog-index')); ?>"><span><?php echo e($langg->lang785); ?></span></a></li>
								</ul>
							</li> -->
							<!-- <li>
								<a href="#affiliateprod" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false"><i class="icofont-cart"></i><?php echo e($langg->lang447); ?></a>
								<ul class="collapse list-unstyled" id="affiliateprod" data-parent="#accordion">
									<li><a href="<?php echo e(route('vendor-import-create')); ?>"><span><?php echo e($langg->lang448); ?></span></a></li>
									<li><a href="<?php echo e(route('vendor-import-index')); ?>"><span><?php echo e($langg->lang449); ?></span></a></li>
								</ul>
							</li> -->
							<!-- <li><a href="<?php echo e(route('vendor-prod-import')); ?>"><i class="fas fa-upload"></i><?php echo e($langg->lang450); ?></a></li> -->
							<!--Vendor Withdraw Start-->
							
							
							<!--Vendor Withdraw End-->
							<li>
        <a href="#analytic" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false"><i class="fas fa-user-tag"></i><?php echo e(__('Reports ')); ?></a>
        <ul class="collapse list-unstyled" id="analytic" data-parent="#accordion" >         
        <li><a href="<?php echo e(route('vendor.vendorrecord')); ?>" class=" wave-effect"><?php echo e(__('Orders')); ?></a></li>		
        </ul>
    </li>
    <li><a href="<?php echo e(route('vendor-profile')); ?>"><i class="fas fa-user"></i> <?php echo e($langg->lang434); ?></a></li>
    	<li><a href="<?php echo e(route('user-logout')); ?>"><i class="fas fa-power-off"></i> <?php echo e($langg->lang435); ?></a></li>
		
							<!--li><a href="<?php echo e(route('vendor.records')); ?>"><span><i class="icofont-chat"></i><?php echo e(__('Reports')); ?></span></a></li-->
						
							<!--<li>
								<a href="#general" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false">
									<i class="fas fa-cogs"></i><?php echo e($langg->lang452); ?>

								</a>
								<ul class="collapse list-unstyled" id="general" data-parent="#accordion">-->
                                    <!-- <li><a href="<?php echo e(route('vendor-service-index')); ?>"><span><?php echo e($langg->lang453); ?></span></a></li> -->
                                    <!--<li><a href="<?php echo e(route('vendor-banner')); ?>"><span><?php echo e($langg->lang454); ?></span></a></li>-->
                                    <!-- <?php if($gs->vendor_ship_info == 1): ?>
	                                    <li><a href="<?php echo e(route('vendor-shipping-index')); ?>"><span><?php echo e($langg->lang719); ?></span></a></li>
	                                <?php endif; ?>
	                                <?php if($gs->multiple_packaging == 1): ?>
	                                    <li><a href="<?php echo e(route('vendor-package-index')); ?>"><span><?php echo e($langg->lang721); ?></span></a></li>
	                                <?php endif; ?>
                                    <li><a href="<?php echo e(route('vendor-social-index')); ?>"><span><?php echo e($langg->lang456); ?></span></a></li> -->
								<!--</ul>
							</li>-->
						</ul>
					</nav>					
						<?php echo $__env->yieldContent('content'); ?>					
					</div>
				</div>
			</div>

		<?php
		  $curr = \App\Models\Currency::where('is_default','=',1)->first();
		?>

		<script type="text/javascript">

			var mainurl = "<?php echo e(url('/')); ?>";
			var admin_loader = <?php echo e($gs->is_admin_loader); ?>;
			var whole_sell = <?php echo e($gs->wholesell); ?>;
			var langg    = <?php echo json_encode($langg); ?>;
			var getattrUrl = '<?php echo e(route('vendor-prod-getattributes')); ?>';
			var curr = <?php echo json_encode($curr); ?>;

		</script>

		<!-- Dashboard Core -->
		<script src="<?php echo e(asset('assets/vendor/js/vendors/jquery-1.12.4.min.js')); ?>"></script>
		<script src="<?php echo e(asset('assets/vendor/js/vendors/bootstrap.min.js')); ?>"></script>
		<script src="<?php echo e(asset('assets/vendor/js/jqueryui.min.js')); ?>"></script>
		<!-- Fullside-menu Js-->
		<script src="<?php echo e(asset('assets/vendor/plugins/fullside-menu/jquery.slimscroll.min.js')); ?>"></script>
		<script src="<?php echo e(asset('assets/vendor/plugins/fullside-menu/waves.min.js')); ?>"></script>

		<script src="<?php echo e(asset('assets/vendor/js/plugin.js')); ?>"></script>

		<script src="<?php echo e(asset('assets/vendor/js/Chart.min.js')); ?>"></script>
		<script src="<?php echo e(asset('assets/vendor/js/tag-it.js')); ?>"></script>
		<script src="<?php echo e(asset('assets/vendor/js/nicEdit.js')); ?>"></script>
        <script src="<?php echo e(asset('assets/vendor/js/bootstrap-colorpicker.min.js')); ?>"></script>
        <script src="<?php echo e(asset('assets/vendor/js/notify.js')); ?>"></script>
		<script src="<?php echo e(asset('assets/vendor/js/load.js')); ?>"></script>
		<!-- Custom Js-->
		<script src="<?php echo e(asset('assets/vendor/js/custom.js')); ?>"></script>
		<!-- AJAX Js-->
		<script src="<?php echo e(asset('assets/vendor/js/myscript.js')); ?>"></script>
		<?php echo $__env->yieldContent('scripts'); ?>

		<?php if($gs->is_admin_loader == 0): ?>
			<style>div#geniustable_processing {display: none !important;}</style>
		<?php endif; ?>
	</body>
</html>