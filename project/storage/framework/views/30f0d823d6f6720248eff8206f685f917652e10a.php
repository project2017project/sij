<?php 
$data = App\Models\Role::where('id',1)->first();
?>    
 <li>
        <a href="#order" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false"><i class="fas fa-hand-holding-usd"></i><?php echo e(__('Orders')); ?></a>
        <ul class="collapse list-unstyled" id="order" data-parent="#accordion" >
            <li><a href="<?php echo e(route('admin-order-index')); ?>"> <?php echo e(__('All Orders')); ?></a></li>
            <li><a href="<?php echo e(route('admin-order-pending')); ?>"> <?php echo e(__('Pending Orders')); ?></a></li>
            <li><a href="<?php echo e(route('admin-order-processing')); ?>"> <?php echo e(__('Processing Orders')); ?></a></li>
            <li><a href="<?php echo e(route('admin-order-shipping')); ?>"> <?php echo e(__('Shipped Orders')); ?></a></li>
            <li><a href="<?php echo e(route('admin-order-completed')); ?>"> <?php echo e(__('Completed Orders')); ?></a></li>
            <li><a href="<?php echo e(route('admin-order-declined')); ?>"> <?php echo e(__('Declined Orders')); ?></a></li>
			<li><a href="<?php echo e(route('admin-order-refundod')); ?>"> <?php echo e(__('Refund Orders')); ?></a></li>
			<li><a href="<?php echo e(route('admin-order-ordertracks')); ?>"> <?php echo e(__('Download Order Track')); ?></a></li>
            <li>
        <a href="#msg" class="dropdown_level_3"><?php echo e(__('Tickets & Disputes')); ?></a>
        <ul class="list-unstyled" id="msg">
            <li><a href="<?php echo e(route('admin-message-index')); ?>"><span><?php echo e(__('Tickets')); ?></span></a></li>
            <li><a href="<?php echo e(route('admin-message-dispute')); ?>"><span><?php echo e(__('Disputes')); ?></span></a></li>
        </ul>
    </li>

        </ul>
    </li>
<?php if($data): ?>
	   <li>
        <a href="#menu2" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false"><i class="icofont-cart"></i><?php echo e(__('Products')); ?></a>
        <ul class="collapse list-unstyled" id="menu2" data-parent="#accordion">
		<?php if($data->sectionCheck('add_new_product')): ?>
            <li><a href="<?php echo e(route('admin-prod-physical-create')); ?>"><span><?php echo e(__('Add New Product')); ?></span></a></li>
		<?php endif; ?>
		<?php if($data->sectionCheck('all_products')): ?>
            <li><a href="<?php echo e(route('admin-prod-index')); ?>"><span><?php echo e(__('All Products')); ?></span></a></li>
		<?php endif; ?>
		<?php if($data->sectionCheck('simple_products')): ?>
			<li><a href="<?php echo e(route('admin-prod-simpleproduct')); ?>"><span><?php echo e(__('Simple Products')); ?></span></a></li>
		<?php endif; ?>
		<?php if($data->sectionCheck('variation_products')): ?>
			<li><a href="<?php echo e(route('admin-prod-variationproduct')); ?>"><span><?php echo e(__('Variation Products')); ?></span></a></li>
		<?php endif; ?>
		<?php if($data->sectionCheck('deactivated_product')): ?>
            <li><a href="<?php echo e(route('admin-prod-deactive')); ?>"><span><?php echo e(__('Deactivated Product')); ?></span></a></li>
		<?php endif; ?>
          <!--  <li><a href="<?php echo e(route('admin-prod-catalog-index')); ?>"><span><?php echo e(__('Product Catalogs')); ?></span></a></li>   --> 
		  <?php if($data->sectionCheck('manage_categories')): ?>
             <li>
        <a href="#menu5" class="dropdown_level_3"><?php echo e(__('Manage Categories')); ?> </a>
        <ul class="list-unstyled
        <?php if(request()->is('admin/attribute/*/manage') && request()->input('type')=='category'): ?>
          show
        <?php elseif(request()->is('admin/attribute/*/manage') && request()->input('type')=='subcategory'): ?>
          show
        <?php elseif(request()->is('admin/attribute/*/manage') && request()->input('type')=='childcategory'): ?>
          show
        <?php endif; ?>" id="menu5">
                <li class="<?php if(request()->is('admin/attribute/*/manage') && request()->input('type')=='category'): ?> active <?php endif; ?>">
                    <a href="<?php echo e(route('admin-cat-index')); ?>"><span><?php echo e(__('Main Category')); ?></span></a>
                </li>
                <li class="<?php if(request()->is('admin/attribute/*/manage') && request()->input('type')=='subcategory'): ?> active <?php endif; ?>">
                    <a href="<?php echo e(route('admin-subcat-index')); ?>"><span><?php echo e(__('Sub Category')); ?></span></a>
                </li>
                <li class="<?php if(request()->is('admin/attribute/*/manage') && request()->input('type')=='childcategory'): ?> active <?php endif; ?>">
                    <a href="<?php echo e(route('admin-childcat-index')); ?>"><span><?php echo e(__('Child Category')); ?></span></a>
                </li>
        </ul>
    </li>
	<?php endif; ?>
    <?php if($data->sectionCheck('bulk_product_upload')): ?>
     <li><a href="<?php echo e(route('admin-prod-import')); ?>"><?php echo e(__('Bulk Product Upload')); ?></a></li>
    <?php endif; ?>
    <?php if($data->sectionCheck('product_reviews')): ?>     
     <li><a href="<?php echo e(route('admin-reviews-index')); ?>"><?php echo e(__('Product Reviews')); ?></a></li>
    <?php endif; ?>
    <?php if($data->sectionCheck('media')): ?>
      <li><a href="<?php echo e(route('admin-media-index')); ?>"><?php echo e(__('Media')); ?></a></li>
    <?php endif; ?>
        </ul>
    </li>
    <?php if($data->sectionCheck('orders')): ?>
    <li>
        <a href="#order" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false"><i class="fas fa-hand-holding-usd"></i><?php echo e(__('Orders')); ?></a>
        <ul class="collapse list-unstyled" id="order" data-parent="#accordion" >
		<?php if($data->sectionCheck('all_orders')): ?>
            <li><a href="<?php echo e(route('admin-order-index')); ?>"> <?php echo e(__('All Orders')); ?></a></li>
		<?php endif; ?>
		<?php if($data->sectionCheck('pending_orders')): ?>
            <li><a href="<?php echo e(route('admin-order-pending')); ?>"> <?php echo e(__('Pending Orders')); ?></a></li>
		<?php endif; ?>
		<?php if($data->sectionCheck('processing_orders')): ?>
            <li><a href="<?php echo e(route('admin-order-processing')); ?>"> <?php echo e(__('Processing Orders')); ?></a></li>
		<?php endif; ?>
		<?php if($data->sectionCheck('shipped_orders')): ?>
            <li><a href="<?php echo e(route('admin-order-shipping')); ?>"> <?php echo e(__('Shipped Orders')); ?></a></li>
		<?php endif; ?>
		<?php if($data->sectionCheck('completed_orders')): ?>
            <li><a href="<?php echo e(route('admin-order-completed')); ?>"> <?php echo e(__('Completed Orders')); ?></a></li>
		<?php endif; ?>
		<?php if($data->sectionCheck('declined_orders')): ?>
            <li><a href="<?php echo e(route('admin-order-declined')); ?>"> <?php echo e(__('Declined Orders')); ?></a></li>
		<?php endif; ?>
		<?php if($data->sectionCheck('refund_orders')): ?>
			<li><a href="<?php echo e(route('admin-order-refundod')); ?>"> <?php echo e(__('Refund Orders')); ?></a></li>
		<?php endif; ?>
		<?php if($data->sectionCheck('download_order_track')): ?>
			<li><a href="<?php echo e(route('admin-order-ordertracks')); ?>"> <?php echo e(__('Download Order Track')); ?></a></li>
		<?php endif; ?>
		<?php if($data->sectionCheck('ticket_dispute')): ?>
            <li>
        <a href="#msg" class="dropdown_level_3"><?php echo e(__('Tickets & Disputes')); ?></a>
        <ul class="list-unstyled" id="msg">
            <li><a href="<?php echo e(route('admin-message-index')); ?>"><span><?php echo e(__('Tickets')); ?></span></a></li>
            <li><a href="<?php echo e(route('admin-message-dispute')); ?>"><span><?php echo e(__('Disputes')); ?></span></a></li>
        </ul>
    </li>
	<?php endif; ?>
        </ul>
    </li>
	<?php endif; ?>
	 <!--li>
        <a href="#refund" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false"><i class="fas fa-hand-holding-usd"></i><?php echo e(__('Refund Orders')); ?></a>
        <ul class="collapse list-unstyled" id="refund" data-parent="#accordion" >
            <li><a href="<?php echo e(route('admin-refund-index')); ?>"> <?php echo e(__('All Refund Orders')); ?></a></li>
        </ul>
    </li-->
        <li>
        <a href="#vendor" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false"><i class="icofont-ui-user-group"></i><?php echo e(__('Vendors')); ?></a>
        <ul class="collapse list-unstyled" id="vendor" data-parent="#accordion">
		<?php if($data->sectionCheck('vendor_list')): ?>
            <li><a href="<?php echo e(route('admin-vendor-index')); ?>"><span><?php echo e(__('Vendors List')); ?></span></a></li>
		<?php endif; ?>
		<?php if($data->sectionCheck('vendor_registration')): ?>
			<li><a href="<?php echo e(route('admin-vendor-register')); ?>"><span><?php echo e(__('Vendors Registration')); ?></span></a></li>
		<?php endif; ?>
		<?php if($data->sectionCheck('withdrawls')): ?>
            <li><a href="<?php echo e(route('admin-vendor-withdraw-index')); ?>"><span><?php echo e(__('Withdrawals')); ?></span></a></li>
		<?php endif; ?>
		<?php if($data->sectionCheck('admin_approve_list')): ?>
			<li><a href="<?php echo e(route('admin-vendor-adminapprovelist-index')); ?>"><span><?php echo e(__('Admin Approve List')); ?></span></a></li>
		<?php endif; ?>
		<?php if($data->sectionCheck('vendor_subscription')): ?>
            <li><a href="<?php echo e(route('admin-vendor-subs')); ?>"><span><?php echo e(__('Vendor Subscriptions')); ?></span></a></li>
		<?php endif; ?>
		<?php if($data->sectionCheck('default_background')): ?>
            <li><a href="<?php echo e(route('admin-vendor-color')); ?>"><span><?php echo e(__('Default Background')); ?></span></a></li>
		<?php endif; ?>
		<?php if($data->sectionCheck('vendor_verification')): ?>
             <li>
        <a href="#vendor1" class="dropdown_level_3"><?php echo e(__('Vendor Verifications')); ?></a>
        <ul class="list-unstyled" id="vendor1">
            <li><a href="<?php echo e(route('admin-vr-index')); ?>"><span><?php echo e(__('All Verifications')); ?></span></a></li>
            <li><a href="<?php echo e(route('admin-vr-pending')); ?>"><span><?php echo e(__('Pending Verifications')); ?></span></a></li>
        </ul>
    </li>
	<?php endif; ?>
	<?php if($data->sectionCheck('vendor_subscription_plans')): ?>
        <li><a href="<?php echo e(route('admin-subscription-index')); ?>" class=" wave-effect"><?php echo e(__('Vendor Subscription Plans')); ?></a></li>
	<?php endif; ?>
        </ul>
    </li>
	
    <li>
        <a href="#menu3" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false">
            <i class="icofont-user"></i><?php echo e(__('Customers')); ?>

        </a>
        <ul class="collapse list-unstyled" id="menu3" data-parent="#accordion">
		<?php if($data->sectionCheck('customer_list')): ?>
            <li><a href="<?php echo e(route('admin-user-index')); ?>"><span><?php echo e(__('Customers List')); ?></span></a></li>
		<?php endif; ?>
		<?php if($data->sectionCheck('customer_withdraw')): ?>
            <li><a href="<?php echo e(route('admin-withdraw-index')); ?>"><span><?php echo e(__('Withdraws')); ?></span></a></li>
		<?php endif; ?>
		<?php if($data->sectionCheck('customer_default_image')): ?>
            <li><a href="<?php echo e(route('admin-user-image')); ?>"><span><?php echo e(__('Customer Default Image')); ?></span></a></li>
		<?php endif; ?>
		<?php if($data->sectionCheck('customer_enquiry')): ?>
            <li><a href="<?php echo e(route('admin-customenquiry-index')); ?>"><?php echo e(__('Customer Enquiry')); ?></a></li>
		<?php endif; ?>
		<?php if($data->sectionCheck('subscriber')): ?>
            <li><a href="<?php echo e(route('admin-subs-index')); ?>" class=" wave-effect"><?php echo e(__('Subscribers')); ?></a>
		<?php endif; ?>
    </li>
        </ul>
    </li>
       <li>
        <a href="#users" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false"><i class="fas fa-user-tag"></i><?php echo e(__('Users')); ?></a>
        <ul class="collapse list-unstyled" id="users" data-parent="#accordion" >
		<?php if($data->sectionCheck('manage_staffs')): ?>
         <li><a href="<?php echo e(route('admin-staff-index')); ?>" class=" wave-effect"><?php echo e(__('Manage Staffs')); ?></a></li>
	 <?php endif; ?>
	 <?php if($data->sectionCheck('manage_roles')): ?>
        <li><a href="<?php echo e(route('admin-role-index')); ?>" class=" wave-effect"><?php echo e(__('Manage Roles')); ?></a></li>
	<?php endif; ?>
        </ul>
    </li>
	 <li>
        <a href="#analytic" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false"><i class="fas fa-user-tag"></i><?php echo e(__('Data Analytic ')); ?></a>
        <ul class="collapse list-unstyled" id="analytic" data-parent="#accordion" >
	<?php if($data->sectionCheck('overview')): ?>
         <li><a href="<?php echo e(route('admin.overview')); ?>" class=" wave-effect"><?php echo e(__('Overview ')); ?></a></li>
	<?php endif; ?>
	<?php if($data->sectionCheck('anal_orders')): ?>
        <li><a href="<?php echo e(route('admin.orderrecord')); ?>" class=" wave-effect"><?php echo e(__('Orders')); ?></a></li>
	<?php endif; ?>
	<?php if($data->sectionCheck('refund')): ?>
		<li><a href="<?php echo e(route('admin.refundrecord')); ?>" class=" wave-effect"><?php echo e(__('Refund')); ?></a></li>
	<?php endif; ?>
	<?php if($data->sectionCheck('revanue')): ?>
		<li><a href="<?php echo e(route('admin.revenue')); ?>" class=" wave-effect"><?php echo e(__('Revenue')); ?></a></li>
	<?php endif; ?>
    <?php if($data->sectionCheck('product')): ?>	
		<li><a href="<?php echo e(route('admin.productrecord')); ?>" class=" wave-effect"><?php echo e(__('Product')); ?></a></li>
	<?php endif; ?>
	<?php if($data->sectionCheck('vendor_commision_reports')): ?>
		<li><a href="<?php echo e(route('admin.analyticrecord')); ?>" class=" wave-effect"><?php echo e(__('Vendor Commission Reports')); ?></a></li>
	<?php endif; ?>
        </ul>
    </li>
	<!--li><a href="<?php echo e(route('admin.record')); ?>"><i class="icofont-chat"></i><?php echo e(__('Reports')); ?></a></li-->
   <!-- <li>
        <a href="#menu4" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false"><i class="icofont-speech-comments"></i><?php echo e(__('Product Discussion')); ?></a>
        <ul class="collapse list-unstyled" id="menu4" data-parent="#accordion">            
            <li><a href="<?php echo e(route('admin-comment-index')); ?>"><span><?php echo e(__('Comments')); ?></span></a></li>
            <li><a href="<?php echo e(route('admin-report-index')); ?>"><span><?php echo e(__('Reports')); ?></span></a></li>
        </ul>
    </li>-->
 <li>
        <a href="#general" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false"><i class="fas fa-cogs"></i><?php echo e(__('Settings')); ?></a>
        <ul class="collapse list-unstyled" id="general" data-parent="#accordion">
		<?php if($data->sectionCheck('set_coupons')): ?>
            <li><a href="<?php echo e(route('admin-coupon-index')); ?>" class=" wave-effect"><?php echo e(__('Set Coupons')); ?></a></li>
		<?php endif; ?>
		<?php if($data->sectionCheck('general_settings')): ?>
            <li>
        <a href="#general"  class="dropdown_level_3"><?php echo e(__('General Settings')); ?></a>
        <ul class="list-unstyled" id="general">
            <li><a href="<?php echo e(route('admin-gs-logo')); ?>">                 <span><?php echo e(__('Logo')); ?></span></a></li>
            <li><a href="<?php echo e(route('admin-gs-fav')); ?>">                  <span><?php echo e(__('Favicon')); ?></span></a></li>
            <li><a href="<?php echo e(route('admin-gs-load')); ?>">                 <span><?php echo e(__('Loader')); ?></span></a></li>
            <li><a href="<?php echo e(route('admin-shipping-index')); ?>">          <span><?php echo e(__('Shipping Methods')); ?></span></a></li>
			<li><a href="<?php echo e(route('admin-manageshipping-index')); ?>">          <span><?php echo e(__('Shipping Rate')); ?></span></a></li>
            <li><a href="<?php echo e(route('admin-package-index')); ?>">           <span><?php echo e(__('Packagings')); ?></span></a></li>
            <li><a href="<?php echo e(route('admin-pick-index')); ?>">              <span><?php echo e(__('Pickup Locations')); ?></span></a></li>
            <li><a href="<?php echo e(route('admin-gs-contents')); ?>">             <span><?php echo e(__('Website Contents')); ?></span></a></li>
            <li><a href="<?php echo e(route('admin-gs-footer')); ?>">               <span><?php echo e(__('Footer')); ?></span></a></li>
            <li><a href="<?php echo e(route('admin-gs-affilate')); ?>">             <span><?php echo e(__('Affiliate Information')); ?></span></a></li>
            <li><a href="<?php echo e(route('admin-gs-popup')); ?>">                <span><?php echo e(__('Popup Banner')); ?></span></a></li>
            <li><a href="<?php echo e(route('admin-gs-error-banner')); ?>">         <span><?php echo e(__('Error Banner')); ?></span></a></li>
            <li><a href="<?php echo e(route('admin-gs-maintenance')); ?>">          <span><?php echo e(__('Website Maintenance')); ?></span></a></li>			
        </ul>
    </li>
	<?php endif; ?>
	<?php if($data->sectionCheck('home_page_settings')): ?>
      <li>
        <a href="#homepage"  class="dropdown_level_3"><?php echo e(__('Home Page Settings')); ?></a>
        <ul class="list-unstyled" id="homepage">
            <li><a href="<?php echo e(route('admin-sl-index')); ?>"><span><?php echo e(__('Sliders')); ?></span></a></li>
            <li><a href="<?php echo e(route('admin-service-index')); ?>"><span><?php echo e(__('Services')); ?></span></a></li>
            <li><a href="<?php echo e(route('admin-ps-best-seller')); ?>"><span><?php echo e(__('Right Side Banner1')); ?></span></a></li>
            <li><a href="<?php echo e(route('admin-ps-big-save')); ?>"><span><?php echo e(__('Right Side Banner2')); ?></span></a></li>
            <li><a href="<?php echo e(route('admin-sb-index')); ?>"><span><?php echo e(__('Top Small Banners')); ?></span></a></li>
            <li><a href="<?php echo e(route('admin-sb-large')); ?>"><span><?php echo e(__('Large Banners')); ?></span></a></li>
            <li><a href="<?php echo e(route('admin-sb-bottom')); ?>"><span><?php echo e(__('Offers Banners')); ?></span></a></li>
            <li><a href="<?php echo e(route('admin-review-index')); ?>"><span><?php echo e(__('Reviews')); ?></span></a></li>
            <li><a href="<?php echo e(route('admin-partner-index')); ?>"><span><?php echo e(__('Comming Soon')); ?></span></a></li>
            <li><a href="<?php echo e(route('admin-ps-customize')); ?>"><span><?php echo e(__('Home Page Customization')); ?></span></a></li>
        </ul>
    </li>
	<?php endif; ?>
	<?php if($data->sectionCheck('menu_page_settings')): ?>
     <li>
        <a href="#menu" class="dropdown_level_3"><?php echo e(__('Menu Page Settings')); ?></a>
        <ul class="list-unstyled" id="menu">
            <li><a href="<?php echo e(route('admin-faq-index')); ?>"><span><?php echo e(__('FAQ Page')); ?></span></a></li>
            <li><a href="<?php echo e(route('admin-ps-contact')); ?>"><span><?php echo e(__('Contact Us Page')); ?></span></a></li>
            <li><a href="<?php echo e(route('admin-page-index')); ?>"><span><?php echo e(__('Other Pages')); ?></span></a></li>
        </ul>
    </li>
	<?php endif; ?>
	<?php if($data->sectionCheck('email_settings')): ?>
    <li>
        <a href="#emails" class="dropdown_level_3">
           <?php echo e(__('Email Settings')); ?>

        </a>
        <ul class=" list-unstyled" id="emails">
            <li><a href="<?php echo e(route('admin-mail-index')); ?>"><span><?php echo e(__('Email Template')); ?></span></a></li>
            <li><a href="<?php echo e(route('admin-mail-config')); ?>"><span><?php echo e(__('Email Configurations')); ?></span></a></li>
            <li><a href="<?php echo e(route('admin-group-show')); ?>"><span><?php echo e(__('Group Email')); ?></span></a></li>
        </ul>
    </li>
	<?php endif; ?>
	<?php if($data->sectionCheck('payment_settings')): ?>
       <li>
        <a href="#payments" class="dropdown_level_3"><?php echo e(__('Payment Settings')); ?></a>
        <ul class="list-unstyled" id="payments">
            <li><a href="<?php echo e(route('admin-gs-payments')); ?>"><span><?php echo e(__('Payment Information')); ?></span></a></li>
            <li><a href="<?php echo e(route('admin-payment-index')); ?>"><span><?php echo e(__('Payment Gateways')); ?></span></a></li>
            <li><a href="<?php echo e(route('admin-currency-index')); ?>"><span><?php echo e(__('Currencies')); ?></span></a></li>
        </ul>
    </li>
	<?php endif; ?>
	<?php if($data->sectionCheck('social_settings')): ?>
     <li>
        <a href="#socials"class="dropdown_level_3">
            <?php echo e(__('Social Settings')); ?>

        </a>
        <ul class=" list-unstyled" id="socials">
                <li><a href="<?php echo e(route('admin-social-index')); ?>"><span><?php echo e(__('Social Links')); ?></span></a></li>
                <li><a href="<?php echo e(route('admin-social-facebook')); ?>"><span><?php echo e(__('Facebook Login')); ?></span></a></li>
                <li><a href="<?php echo e(route('admin-social-google')); ?>"><span><?php echo e(__('Google Login')); ?></span></a></li>
        </ul>
    </li>
	<?php endif; ?>
	<?php if($data->sectionCheck('language_settings')): ?>
   <li>
        <a href="#langs" class="dropdown_level_3"><?php echo e(__('Language Settings')); ?></a>
        <ul class=" list-unstyled" id="langs">
                <li><a href="<?php echo e(route('admin-lang-index')); ?>"><span><?php echo e(__('Website Language')); ?></span></a></li>
                <li><a href="<?php echo e(route('admin-tlang-index')); ?>"><span><?php echo e(__('Admin Panel Language')); ?></span></a></li>
        </ul>
    </li>
	<?php endif; ?>
	<?php if($data->sectionCheck('seo_tools')): ?>
    <li>
        <a href="#seoTools" class="dropdown_level_3"><?php echo e(__('SEO Tools')); ?></a>
        <ul class="list-unstyled" id="seoTools">
            <li><a href="<?php echo e(route('admin-prod-popular',30)); ?>"><span><?php echo e(__('Popular Products')); ?></span></a></li>
            <li><a href="<?php echo e(route('admin-seotool-analytics')); ?>"><span><?php echo e(__('Google Analytics')); ?></span></a></li>
            <li><a href="<?php echo e(route('admin-seotool-keywords')); ?>"><span><?php echo e(__('Website Meta Keywords')); ?></span></a></li>
        </ul>
    </li>
	<?php endif; ?>
        </ul>
    </li>
  <!--  <li><a href="<?php echo e(route('admin-searchresult-index')); ?>" class=" wave-effect"><i class="fas fa-percentage"></i><?php echo e(__('Search Result index')); ?></a></li>-->
 <!--   <li>
        <a href="#blog" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false">
            <i class="fas fa-fw fa-newspaper"></i><?php echo e(__('Blog')); ?>

        </a>
        <ul class="collapse list-unstyled" id="blog" data-parent="#accordion">
            <li><a href="<?php echo e(route('admin-cblog-index')); ?>"><span><?php echo e(__('Categories')); ?></span></a></li>
            <li><a href="<?php echo e(route('admin-blog-index')); ?>"><span><?php echo e(__('Posts')); ?></span></a></li>
        </ul>
    </li>
-->
  <!--  <li><a href="<?php echo e(route('admin-notify-index')); ?>" class=" wave-effect"><i class="fas fa-users-cog mr-2"></i><?php echo e(__('Notify')); ?></a>
    </li>-->
         <li>
        <a href="#system" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false"><i class="fas fa-sync"></i><?php echo e(__('System')); ?></a>
        <ul class="collapse list-unstyled" id="system" data-parent="#accordion" >
	<?php if($data->sectionCheck('clear_cache')): ?>
         <li><a href="<?php echo e(route('admin-cache-clear')); ?>" class=" wave-effect"><?php echo e(__('Clear Cache')); ?></a></li>
	 <?php endif; ?>
	 <?php if($data->sectionCheck('generate_backup')): ?>
         <li><a href="<?php echo e(route('admin-generate-backup')); ?>"> <?php echo e(__('Generate Backup')); ?></a></li>
	 <?php endif; ?>
        </ul>
    </li>
	  <li>
        <a href="#raisedispute" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false"><i class="fas fa-sync"></i><?php echo e(__('Refunds')); ?></a>
        <ul class="collapse list-unstyled" id="raisedispute" data-parent="#accordion" >
		<?php if($data->sectionCheck('create_refund')): ?>
           <li><a href="<?php echo e(route('admin-raise-dispute')); ?>"> <?php echo e(__('Create Refund')); ?></a></li>
	   <?php endif; ?>
	   <?php if($data->sectionCheck('pending_refund')): ?>
		   <li><a href="<?php echo e(route('admin-open-dispute')); ?>"> <?php echo e(__('Pending Refunds')); ?></a></li>
	   <?php endif; ?>
	   <?php if($data->sectionCheck('refunds_paid')): ?>
		   <li><a href="<?php echo e(route('admin-resolved-dispute')); ?>"> <?php echo e(__('Refunds Paid')); ?></a></li>
	   <?php endif; ?>
	   <?php if($data->sectionCheck('cancelled_refunds')): ?>
		   <li><a href="<?php echo e(route('admin-decline-dispute')); ?>"> <?php echo e(__('Cancelled Refunds')); ?></a></li>
       <?php endif; ?>	   
        </ul>
    </li>
	 <li>
        <a href="#debitnote" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false"><i class="fas fa-sync"></i><?php echo e(__('Debit Note')); ?></a>
        <ul class="collapse list-unstyled" id="debitnote" data-parent="#accordion" >
		<?php if($data->sectionCheck('debit_note')): ?>
           <li><a href="<?php echo e(route('admin-debitnote-list')); ?>"> <?php echo e(__('Debit Note')); ?></a></li>
	    <?php endif; ?>
	   <?php if($data->sectionCheck('unsettle_note')): ?>
		   <li><a href="<?php echo e(route('admin-open-debit')); ?>"> <?php echo e(__('Unsettle Note')); ?></a></li>
	    <?php endif; ?>
	   <?php if($data->sectionCheck('settle_note')): ?>
		   <li><a href="<?php echo e(route('admin-resolved-debit')); ?>"> <?php echo e(__('Settle Note')); ?></a></li>
	    <?php endif; ?>
	
        </ul>
    </li>
	 <li>
        <a href="#crditnote" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false"><i class="fas fa-sync"></i><?php echo e(__('Credit Note')); ?></a>
        <ul class="collapse list-unstyled" id="crditnote" data-parent="#accordion" >
		<?php if($data->sectionCheck('credit_note')): ?>
           <li><a href="<?php echo e(route('admin-creditnote-list')); ?>"> <?php echo e(__('Credit Note')); ?></a></li>
	    <?php endif; ?>
	   <?php if($data->sectionCheck('cunsettle_note')): ?>
		   <li><a href="<?php echo e(route('admin-open-credit')); ?>"> <?php echo e(__('Unsettle Note')); ?></a></li>
	    <?php endif; ?>
	   <?php if($data->sectionCheck('csettle_note')): ?>
		   <li><a href="<?php echo e(route('admin-resolved-credit')); ?>"> <?php echo e(__('Settle Note')); ?></a></li>
	    <?php endif; ?>
	 
        </ul>
    </li>
	<li>
        <a href="#exchanged" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false"><i class="fas fa-sync"></i><?php echo e(__('Exchange')); ?></a>
        <ul class="collapse list-unstyled" id="exchanged" data-parent="#accordion" >
		<?php if($data->sectionCheck('add_exchange')): ?>
           <li><a href="<?php echo e(route('admin-order-exchange')); ?>"> <?php echo e(__('Add Exchange')); ?></a></li>
	    <?php endif; ?>
	   <?php if($data->sectionCheck('shipped_exchange')): ?>
		   <li><a href="<?php echo e(route('admin-ship-exchange')); ?>"> <?php echo e(__('Shipped Exchange')); ?></a></li>
	    <?php endif; ?>
	   <?php if($data->sectionCheck('pending_exchange')): ?>
		   <li><a href="<?php echo e(route('admin-open-exchange')); ?>"> <?php echo e(__('Pending Exchange')); ?></a></li>
	    <?php endif; ?>
	   <?php if($data->sectionCheck('delivered_exchange')): ?>
		 <li><a href="<?php echo e(route('admin-resolved-exchange')); ?>"> <?php echo e(__('Delivered Exchange')); ?></a></li>
	    <?php endif; ?>
		<?php if($data->sectionCheck('not_delivered_exchange')): ?>
		<li><a href="<?php echo e(route('admin-notdelivered-exchange')); ?>"> <?php echo e(__('Notdelivered Exchange')); ?></a></li>
		<?php endif; ?>
		<?php if($data->sectionCheck('decline_exchange')): ?>
		   <li><a href="<?php echo e(route('admin-decline-exchange')); ?>"> <?php echo e(__('Decline Exchange')); ?></a></li>
        <?php endif; ?>	   
        </ul>
    </li>
	<li>
        <a href="#rtod" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false"><i class="fas fa-sync"></i><?php echo e(__('Rto')); ?></a>
        <ul class="collapse list-unstyled" id="rtod" data-parent="#accordion" >
		<?php if($data->sectionCheck('add_rto')): ?>
           <li><a href="<?php echo e(route('admin-order-rto')); ?>"> <?php echo e(__('Add Rto')); ?></a></li>
	    <?php endif; ?>
	    <?php if($data->sectionCheck('shipped_rto')): ?>
		   <li><a href="<?php echo e(route('admin-ship-rto')); ?>"> <?php echo e(__('Shipped Rto')); ?></a></li>
	    <?php endif; ?>
	   <?php if($data->sectionCheck('pending_rto')): ?>
		   <li><a href="<?php echo e(route('admin-open-rto')); ?>"> <?php echo e(__('Pending Rto')); ?></a></li>
	    <?php endif; ?>
	   <?php if($data->sectionCheck('delivered_rto')): ?>
		 <li><a href="<?php echo e(route('admin-resolved-rto')); ?>"> <?php echo e(__('Delivered Rto')); ?></a></li>
	    <?php endif; ?>
		<?php if($data->sectionCheck('not_delivered_rto')): ?>
		<li><a href="<?php echo e(route('admin-notdelivered-rto')); ?>"> <?php echo e(__('Notdelivered Rto')); ?></a></li>
		<?php endif; ?>
		<?php if($data->sectionCheck('decline_rto')): ?>
		   <li><a href="<?php echo e(route('admin-decline-rto')); ?>"> <?php echo e(__('Decline Rto')); ?></a></li>
          <?php endif; ?>
        </ul>
    </li>
	
	<li>
        <a href="#disputedata" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false"><i class="fas fa-sync"></i><?php echo e(__('Dispute')); ?></a>
        <ul class="collapse list-unstyled" id="disputedata" data-parent="#accordion" >
		<?php if($data->sectionCheck('add_dispute')): ?>
           <li><a href="<?php echo e(route('admin-order-disputes')); ?>"> <?php echo e(__('Add Dispute')); ?></a></li>
	    <?php endif; ?>	    
	   <?php if($data->sectionCheck('pending_dispute')): ?>
		   <li><a href="<?php echo e(route('admin-open-disputes')); ?>"> <?php echo e(__('Pending Dispute')); ?></a></li>
	    <?php endif; ?>
        <?php if($data->sectionCheck('complete_dispute')): ?>
		   <li><a href="<?php echo e(route('admin-resolved-disputeds')); ?>"> <?php echo e(__('Complete Dispute')); ?></a></li>
	    <?php endif; ?>		
        </ul>
    </li>
	<li>
        <a href="#couponed" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false"><i class="fas fa-sync"></i><?php echo e(__('Coupon')); ?></a>
        <ul class="collapse list-unstyled" id="couponed" data-parent="#accordion" >
		<?php if($data->sectionCheck('coupon')): ?>
           <li><a href="<?php echo e(route('admin-coupon-code')); ?>"> <?php echo e(__('Coupon')); ?></a></li>
	   <?php endif; ?>
	   <?php if($data->sectionCheck('list_coupon')): ?>
		   <li><a href="<?php echo e(route('admin-coupon-alllist')); ?>"> <?php echo e(__('List Coupon')); ?></a></li>
	   <?php endif; ?>
	   <?php if($data->sectionCheck('approval_coupon')): ?>
		   <li><a href="<?php echo e(route('admin-coupon-approvallist')); ?>"> <?php echo e(__('Approval Coupon')); ?></a></li>
	   <?php endif; ?>
	   <?php if($data->sectionCheck('reject_coupon')): ?>
           <li><a href="<?php echo e(route('admin-coupon-rejectlist')); ?>"> <?php echo e(__('Reject Coupon')); ?></a></li>
       <?php endif; ?>	   
        </ul>
    </li>
	<?php else: ?>
	
	
	
		        <li>
        <a href="#menu2" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false"><i class="icofont-cart"></i><?php echo e(__('Products')); ?></a>
        <ul class="collapse list-unstyled" id="menu2" data-parent="#accordion">
            <li><a href="<?php echo e(route('admin-prod-physical-create')); ?>"><span><?php echo e(__('Add New Product')); ?></span></a></li>
            <li><a href="<?php echo e(route('admin-prod-index')); ?>"><span><?php echo e(__('All Products')); ?></span></a></li>
			<li><a href="<?php echo e(route('admin-prod-simpleproduct')); ?>"><span><?php echo e(__('Simple Products')); ?></span></a></li>
			<li><a href="<?php echo e(route('admin-prod-variationproduct')); ?>"><span><?php echo e(__('Variation Products')); ?></span></a></li>
            <li><a href="<?php echo e(route('admin-prod-deactive')); ?>"><span><?php echo e(__('Deactivated Product')); ?></span></a></li>
          <!--  <li><a href="<?php echo e(route('admin-prod-catalog-index')); ?>"><span><?php echo e(__('Product Catalogs')); ?></span></a></li>   --> 
             <li>
        <a href="#menu5" class="dropdown_level_3"><?php echo e(__('Manage Categories')); ?> </a>
        <ul class="list-unstyled
        <?php if(request()->is('admin/attribute/*/manage') && request()->input('type')=='category'): ?>
          show
        <?php elseif(request()->is('admin/attribute/*/manage') && request()->input('type')=='subcategory'): ?>
          show
        <?php elseif(request()->is('admin/attribute/*/manage') && request()->input('type')=='childcategory'): ?>
          show
        <?php endif; ?>" id="menu5">
                <li class="<?php if(request()->is('admin/attribute/*/manage') && request()->input('type')=='category'): ?> active <?php endif; ?>">
                    <a href="<?php echo e(route('admin-cat-index')); ?>"><span><?php echo e(__('Main Category')); ?></span></a>
                </li>
                <li class="<?php if(request()->is('admin/attribute/*/manage') && request()->input('type')=='subcategory'): ?> active <?php endif; ?>">
                    <a href="<?php echo e(route('admin-subcat-index')); ?>"><span><?php echo e(__('Sub Category')); ?></span></a>
                </li>
                <li class="<?php if(request()->is('admin/attribute/*/manage') && request()->input('type')=='childcategory'): ?> active <?php endif; ?>">
                    <a href="<?php echo e(route('admin-childcat-index')); ?>"><span><?php echo e(__('Child Category')); ?></span></a>
                </li>
        </ul>
    </li>
    
    
     <li><a href="<?php echo e(route('admin-prod-import')); ?>"><?php echo e(__('Bulk Product Upload')); ?></a></li>
     
     <li><a href="<?php echo e(route('admin-reviews-index')); ?>"><?php echo e(__('Product Reviews')); ?></a></li>
     
      <li><a href="<?php echo e(route('admin-media-index')); ?>"><?php echo e(__('Media')); ?></a></li>
    
        </ul>
    </li>
    
    <li>
        <a href="#order" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false"><i class="fas fa-hand-holding-usd"></i><?php echo e(__('Orders')); ?></a>
        <ul class="collapse list-unstyled" id="order" data-parent="#accordion" >
            <li><a href="<?php echo e(route('admin-order-index')); ?>"> <?php echo e(__('All Orders')); ?></a></li>
            <li><a href="<?php echo e(route('admin-order-pending')); ?>"> <?php echo e(__('Pending Orders')); ?></a></li>
            <li><a href="<?php echo e(route('admin-order-processing')); ?>"> <?php echo e(__('Processing Orders')); ?></a></li>
            <li><a href="<?php echo e(route('admin-order-shipping')); ?>"> <?php echo e(__('Shipped Orders')); ?></a></li>
            <li><a href="<?php echo e(route('admin-order-completed')); ?>"> <?php echo e(__('Completed Orders')); ?></a></li>
            <li><a href="<?php echo e(route('admin-order-declined')); ?>"> <?php echo e(__('Declined Orders')); ?></a></li>
			<li><a href="<?php echo e(route('admin-order-refundod')); ?>"> <?php echo e(__('Refund Orders')); ?></a></li>
			<li><a href="<?php echo e(route('admin-order-ordertracks')); ?>"> <?php echo e(__('Download Order Track')); ?></a></li>
            <li>
        <a href="#msg" class="dropdown_level_3"><?php echo e(__('Tickets & Disputes')); ?></a>
        <ul class="list-unstyled" id="msg">
            <li><a href="<?php echo e(route('admin-message-index')); ?>"><span><?php echo e(__('Tickets')); ?></span></a></li>
            <li><a href="<?php echo e(route('admin-message-dispute')); ?>"><span><?php echo e(__('Disputes')); ?></span></a></li>
        </ul>
    </li>

        </ul>
    </li>
	 <!--li>
        <a href="#refund" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false"><i class="fas fa-hand-holding-usd"></i><?php echo e(__('Refund Orders')); ?></a>
        <ul class="collapse list-unstyled" id="refund" data-parent="#accordion" >
            <li><a href="<?php echo e(route('admin-refund-index')); ?>"> <?php echo e(__('All Refund Orders')); ?></a></li>
            
        </ul>
    </li-->

	
    
   
   
        <li>
        <a href="#vendor" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false"><i class="icofont-ui-user-group"></i><?php echo e(__('Vendors')); ?></a>
        <ul class="collapse list-unstyled" id="vendor" data-parent="#accordion">
            <li><a href="<?php echo e(route('admin-vendor-index')); ?>"><span><?php echo e(__('Vendors List')); ?></span></a></li>
			<li><a href="<?php echo e(route('admin-vendor-register')); ?>"><span><?php echo e(__('Vendors Registration')); ?></span></a></li>
            <li><a href="<?php echo e(route('admin-vendor-withdraw-index')); ?>"><span><?php echo e(__('Withdrawals')); ?></span></a></li>
			<li><a href="<?php echo e(route('admin-vendor-adminapprovelist-index')); ?>"><span><?php echo e(__('Admin Approve List')); ?></span></a></li>
            <li><a href="<?php echo e(route('admin-vendor-subs')); ?>"><span><?php echo e(__('Vendor Subscriptions')); ?></span></a></li>
            <li><a href="<?php echo e(route('admin-vendor-color')); ?>"><span><?php echo e(__('Default Background')); ?></span></a></li>
             <li>
        <a href="#vendor1" class="dropdown_level_3"><?php echo e(__('Vendor Verifications')); ?></a>
        <ul class="list-unstyled" id="vendor1">
            <li><a href="<?php echo e(route('admin-vr-index')); ?>"><span><?php echo e(__('All Verifications')); ?></span></a></li>
            <li><a href="<?php echo e(route('admin-vr-pending')); ?>"><span><?php echo e(__('Pending Verifications')); ?></span></a></li>
        </ul>
    </li>
    
        <li><a href="<?php echo e(route('admin-subscription-index')); ?>" class=" wave-effect"><?php echo e(__('Vendor Subscription Plans')); ?></a></li>

        </ul>
    </li>

    
    
     
     
    <li>
        <a href="#menu3" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false">
            <i class="icofont-user"></i><?php echo e(__('Customers')); ?>

        </a>
        <ul class="collapse list-unstyled" id="menu3" data-parent="#accordion">
            <li><a href="<?php echo e(route('admin-user-index')); ?>"><span><?php echo e(__('Customers List')); ?></span></a></li>
            <li><a href="<?php echo e(route('admin-withdraw-index')); ?>"><span><?php echo e(__('Withdraws')); ?></span></a></li>
			
            <li><a href="<?php echo e(route('admin-user-image')); ?>"><span><?php echo e(__('Customer Default Image')); ?></span></a></li>
            
            <li><a href="<?php echo e(route('admin-customenquiry-index')); ?>"><?php echo e(__('Customer Enquiry')); ?></a></li>
            
            <li><a href="<?php echo e(route('admin-subs-index')); ?>" class=" wave-effect"><?php echo e(__('Subscribers')); ?></a>
    </li>
            
        </ul>
    </li>


       <li>
        <a href="#users" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false"><i class="fas fa-user-tag"></i><?php echo e(__('Users')); ?></a>
        <ul class="collapse list-unstyled" id="users" data-parent="#accordion" >
         <li><a href="<?php echo e(route('admin-staff-index')); ?>" class=" wave-effect"><?php echo e(__('Manage Staffs')); ?></a></li>
        <li><a href="<?php echo e(route('admin-role-index')); ?>" class=" wave-effect"><?php echo e(__('Manage Roles')); ?></a></li>
        </ul>
    </li>
	 <li>
        <a href="#analytic" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false"><i class="fas fa-user-tag"></i><?php echo e(__('Data Analytic ')); ?></a>
        <ul class="collapse list-unstyled" id="analytic" data-parent="#accordion" >
         <li><a href="<?php echo e(route('admin.overview')); ?>" class=" wave-effect"><?php echo e(__('Overview ')); ?></a></li>
        <li><a href="<?php echo e(route('admin.orderrecord')); ?>" class=" wave-effect"><?php echo e(__('Orders')); ?></a></li>
		<li><a href="<?php echo e(route('admin.refundrecord')); ?>" class=" wave-effect"><?php echo e(__('Refund')); ?></a></li>
		<li><a href="<?php echo e(route('admin.revenue')); ?>" class=" wave-effect"><?php echo e(__('Revenue')); ?></a></li>		
		<li><a href="<?php echo e(route('admin.productrecord')); ?>" class=" wave-effect"><?php echo e(__('Product')); ?></a></li>
		<li><a href="<?php echo e(route('admin.analyticrecord')); ?>" class=" wave-effect"><?php echo e(__('Vendor Commission Reports')); ?></a></li>
        </ul>
    </li>
    

   
	<!--li><a href="<?php echo e(route('admin.record')); ?>"><i class="icofont-chat"></i><?php echo e(__('Reports')); ?></a></li-->
    
   

   <!-- <li>
        <a href="#menu4" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false"><i class="icofont-speech-comments"></i><?php echo e(__('Product Discussion')); ?></a>
        <ul class="collapse list-unstyled" id="menu4" data-parent="#accordion">            
            <li><a href="<?php echo e(route('admin-comment-index')); ?>"><span><?php echo e(__('Comments')); ?></span></a></li>
            <li><a href="<?php echo e(route('admin-report-index')); ?>"><span><?php echo e(__('Reports')); ?></span></a></li>
        </ul>
    </li>-->



 <li>
        <a href="#general" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false"><i class="fas fa-cogs"></i><?php echo e(__('Settings')); ?></a>
        <ul class="collapse list-unstyled" id="general" data-parent="#accordion">
            <li><a href="<?php echo e(route('admin-coupon-index')); ?>" class=" wave-effect"><?php echo e(__('Set Coupons')); ?></a></li>
            
            <li>
        <a href="#general"  class="dropdown_level_3"><?php echo e(__('General Settings')); ?></a>
        <ul class="list-unstyled" id="general">
            <li><a href="<?php echo e(route('admin-gs-logo')); ?>">                 <span><?php echo e(__('Logo')); ?></span></a></li>
            <li><a href="<?php echo e(route('admin-gs-fav')); ?>">                  <span><?php echo e(__('Favicon')); ?></span></a></li>
            <li><a href="<?php echo e(route('admin-gs-load')); ?>">                 <span><?php echo e(__('Loader')); ?></span></a></li>
            <li><a href="<?php echo e(route('admin-shipping-index')); ?>">          <span><?php echo e(__('Shipping Methods')); ?></span></a></li>
			<li><a href="<?php echo e(route('admin-manageshipping-index')); ?>">          <span><?php echo e(__('Shipping Rate')); ?></span></a></li>
            <li><a href="<?php echo e(route('admin-package-index')); ?>">           <span><?php echo e(__('Packagings')); ?></span></a></li>
            <li><a href="<?php echo e(route('admin-pick-index')); ?>">              <span><?php echo e(__('Pickup Locations')); ?></span></a></li>
            <li><a href="<?php echo e(route('admin-gs-contents')); ?>">             <span><?php echo e(__('Website Contents')); ?></span></a></li>
            <li><a href="<?php echo e(route('admin-gs-footer')); ?>">               <span><?php echo e(__('Footer')); ?></span></a></li>
            <li><a href="<?php echo e(route('admin-gs-affilate')); ?>">             <span><?php echo e(__('Affiliate Information')); ?></span></a></li>
            <li><a href="<?php echo e(route('admin-gs-popup')); ?>">                <span><?php echo e(__('Popup Banner')); ?></span></a></li>
            <li><a href="<?php echo e(route('admin-gs-error-banner')); ?>">         <span><?php echo e(__('Error Banner')); ?></span></a></li>
            <li><a href="<?php echo e(route('admin-gs-maintenance')); ?>">          <span><?php echo e(__('Website Maintenance')); ?></span></a></li>			
        </ul>
    </li>
    
    
      <li>
        <a href="#homepage"  class="dropdown_level_3"><?php echo e(__('Home Page Settings')); ?></a>
        <ul class="list-unstyled" id="homepage">
            <li><a href="<?php echo e(route('admin-sl-index')); ?>"><span><?php echo e(__('Sliders')); ?></span></a></li>
            <li><a href="<?php echo e(route('admin-service-index')); ?>"><span><?php echo e(__('Services')); ?></span></a></li>
            <li><a href="<?php echo e(route('admin-ps-best-seller')); ?>"><span><?php echo e(__('Right Side Banner1')); ?></span></a></li>
            <li><a href="<?php echo e(route('admin-ps-big-save')); ?>"><span><?php echo e(__('Right Side Banner2')); ?></span></a></li>
            <li><a href="<?php echo e(route('admin-sb-index')); ?>"><span><?php echo e(__('Top Small Banners')); ?></span></a></li>
            <li><a href="<?php echo e(route('admin-sb-large')); ?>"><span><?php echo e(__('Large Banners')); ?></span></a></li>
            <li><a href="<?php echo e(route('admin-sb-bottom')); ?>"><span><?php echo e(__('Offers Banners')); ?></span></a></li>
            <li><a href="<?php echo e(route('admin-review-index')); ?>"><span><?php echo e(__('Reviews')); ?></span></a></li>
            <li><a href="<?php echo e(route('admin-partner-index')); ?>"><span><?php echo e(__('Comming Soon')); ?></span></a></li>
            <li><a href="<?php echo e(route('admin-ps-customize')); ?>"><span><?php echo e(__('Home Page Customization')); ?></span></a></li>
        </ul>
    </li>
    
    
    
     <li>
        <a href="#menu" class="dropdown_level_3"><?php echo e(__('Menu Page Settings')); ?></a>
        <ul class="list-unstyled" id="menu">
            <li><a href="<?php echo e(route('admin-faq-index')); ?>"><span><?php echo e(__('FAQ Page')); ?></span></a></li>
            <li><a href="<?php echo e(route('admin-ps-contact')); ?>"><span><?php echo e(__('Contact Us Page')); ?></span></a></li>
            <li><a href="<?php echo e(route('admin-page-index')); ?>"><span><?php echo e(__('Other Pages')); ?></span></a></li>
        </ul>
    </li>
    
    
    <li>
        <a href="#emails" class="dropdown_level_3">
           <?php echo e(__('Email Settings')); ?>

        </a>
        <ul class=" list-unstyled" id="emails">
            <li><a href="<?php echo e(route('admin-mail-index')); ?>"><span><?php echo e(__('Email Template')); ?></span></a></li>
            <li><a href="<?php echo e(route('admin-mail-config')); ?>"><span><?php echo e(__('Email Configurations')); ?></span></a></li>
            <li><a href="<?php echo e(route('admin-group-show')); ?>"><span><?php echo e(__('Group Email')); ?></span></a></li>
        </ul>
    </li>
    
    
       <li>
        <a href="#payments" class="dropdown_level_3"><?php echo e(__('Payment Settings')); ?></a>
        <ul class="list-unstyled" id="payments">
            <li><a href="<?php echo e(route('admin-gs-payments')); ?>"><span><?php echo e(__('Payment Information')); ?></span></a></li>
            <li><a href="<?php echo e(route('admin-payment-index')); ?>"><span><?php echo e(__('Payment Gateways')); ?></span></a></li>
            <li><a href="<?php echo e(route('admin-currency-index')); ?>"><span><?php echo e(__('Currencies')); ?></span></a></li>
        </ul>
    </li>
    
    
    
    
    
     <li>
        <a href="#socials"class="dropdown_level_3">
            <?php echo e(__('Social Settings')); ?>

        </a>
        <ul class=" list-unstyled" id="socials">
                <li><a href="<?php echo e(route('admin-social-index')); ?>"><span><?php echo e(__('Social Links')); ?></span></a></li>
                <li><a href="<?php echo e(route('admin-social-facebook')); ?>"><span><?php echo e(__('Facebook Login')); ?></span></a></li>
                <li><a href="<?php echo e(route('admin-social-google')); ?>"><span><?php echo e(__('Google Login')); ?></span></a></li>
        </ul>
    </li>
   <li>
        <a href="#langs" class="dropdown_level_3"><?php echo e(__('Language Settings')); ?></a>
        <ul class=" list-unstyled" id="langs">
                <li><a href="<?php echo e(route('admin-lang-index')); ?>"><span><?php echo e(__('Website Language')); ?></span></a></li>
                <li><a href="<?php echo e(route('admin-tlang-index')); ?>"><span><?php echo e(__('Admin Panel Language')); ?></span></a></li>
        </ul>
    </li>
    <li>
        <a href="#seoTools" class="dropdown_level_3"><?php echo e(__('SEO Tools')); ?></a>
        <ul class="list-unstyled" id="seoTools">
            <li><a href="<?php echo e(route('admin-prod-popular',30)); ?>"><span><?php echo e(__('Popular Products')); ?></span></a></li>
            <li><a href="<?php echo e(route('admin-seotool-analytics')); ?>"><span><?php echo e(__('Google Analytics')); ?></span></a></li>
            <li><a href="<?php echo e(route('admin-seotool-keywords')); ?>"><span><?php echo e(__('Website Meta Keywords')); ?></span></a></li>
        </ul>
    </li>
    
    
    
    
        </ul>
    </li>
    

    
  <!--  <li><a href="<?php echo e(route('admin-searchresult-index')); ?>" class=" wave-effect"><i class="fas fa-percentage"></i><?php echo e(__('Search Result index')); ?></a></li>-->
     
 <!--   <li>
        <a href="#blog" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false">
            <i class="fas fa-fw fa-newspaper"></i><?php echo e(__('Blog')); ?>

        </a>
        <ul class="collapse list-unstyled" id="blog" data-parent="#accordion">
            <li><a href="<?php echo e(route('admin-cblog-index')); ?>"><span><?php echo e(__('Categories')); ?></span></a></li>
            <li><a href="<?php echo e(route('admin-blog-index')); ?>"><span><?php echo e(__('Posts')); ?></span></a></li>
        </ul>
    </li>
-->
    
    

  

   
    
 
   
    
  <!--  <li><a href="<?php echo e(route('admin-notify-index')); ?>" class=" wave-effect"><i class="fas fa-users-cog mr-2"></i><?php echo e(__('Notify')); ?></a>
    </li>-->
    
 
    
         <li>
        <a href="#system" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false"><i class="fas fa-sync"></i><?php echo e(__('System')); ?></a>
        <ul class="collapse list-unstyled" id="system" data-parent="#accordion" >
         <li><a href="<?php echo e(route('admin-cache-clear')); ?>" class=" wave-effect"><?php echo e(__('Clear Cache')); ?></a></li>
         <li><a href="<?php echo e(route('admin-generate-backup')); ?>"> <?php echo e(__('Generate Backup')); ?></a></li>
        </ul>
    </li>
	
	  <li>
        <a href="#raisedispute" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false"><i class="fas fa-sync"></i><?php echo e(__('Refunds')); ?></a>
        <ul class="collapse list-unstyled" id="raisedispute" data-parent="#accordion" >
           <li><a href="<?php echo e(route('admin-raise-dispute')); ?>"> <?php echo e(__('Create Refund')); ?></a></li>
		   <li><a href="<?php echo e(route('admin-open-dispute')); ?>"> <?php echo e(__('Pending Refunds')); ?></a></li>
		   <li><a href="<?php echo e(route('admin-resolved-dispute')); ?>"> <?php echo e(__('Refunds Paid')); ?></a></li>
		   <li><a href="<?php echo e(route('admin-decline-dispute')); ?>"> <?php echo e(__('Cancelled Refunds')); ?></a></li>		  
        </ul>
    </li>
	 <li>
        <a href="#debitnote" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false"><i class="fas fa-sync"></i><?php echo e(__('Debit Note')); ?></a>
        <ul class="collapse list-unstyled" id="debitnote" data-parent="#accordion" >
           <li><a href="<?php echo e(route('admin-debitnote-list')); ?>"> <?php echo e(__('Debit Note')); ?></a></li>
		   <li><a href="<?php echo e(route('admin-open-debit')); ?>"> <?php echo e(__('Unsettle Note')); ?></a></li>
		   <li><a href="<?php echo e(route('admin-resolved-debit')); ?>"> <?php echo e(__('Settle Note')); ?></a></li>
		   <li><a href="<?php echo e(route('admin-decline-debit')); ?>"> <?php echo e(__('Cancelled Note')); ?></a></li>
		  
        </ul>
    </li>
	 <li>
        <a href="#crditnote" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false"><i class="fas fa-sync"></i><?php echo e(__('Credit Note')); ?></a>
        <ul class="collapse list-unstyled" id="crditnote" data-parent="#accordion" >
           <li><a href="<?php echo e(route('admin-creditnote-list')); ?>"> <?php echo e(__('Credit Note')); ?></a></li>
		   <li><a href="<?php echo e(route('admin-open-credit')); ?>"> <?php echo e(__('Unsettle Note')); ?></a></li>
		   <li><a href="<?php echo e(route('admin-resolved-credit')); ?>"> <?php echo e(__('Settle Note')); ?></a></li>
		   <li><a href="<?php echo e(route('admin-decline-credit')); ?>"> <?php echo e(__('Cancelled Note')); ?></a></li>
		  
        </ul>
    </li>
	
	<li>
        <a href="#exchanged" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false"><i class="fas fa-sync"></i><?php echo e(__('Exchange')); ?></a>
        <ul class="collapse list-unstyled" id="exchanged" data-parent="#accordion" >
           <li><a href="<?php echo e(route('admin-order-exchange')); ?>"> <?php echo e(__('Add Exchange')); ?></a></li>
		   <li><a href="<?php echo e(route('admin-ship-exchange')); ?>"> <?php echo e(__('Shipped Exchange')); ?></a></li>


		   <li><a href="<?php echo e(route('admin-open-exchange')); ?>"> <?php echo e(__('Pending Exchange')); ?></a></li>
		   <li><a href="<?php echo e(route('admin-resolved-exchange')); ?>"> <?php echo e(__('Delivered Exchange')); ?></a></li>
		   		   		   <li><a href="<?php echo e(route('admin-notdelivered-exchange')); ?>"> <?php echo e(__('Notdelivered Exchange')); ?></a></li>
		   <li><a href="<?php echo e(route('admin-decline-exchange')); ?>"> <?php echo e(__('Decline Exchange')); ?></a></li>		  
        </ul>
    </li>
	
	<li>
        <a href="#rtod" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false"><i class="fas fa-sync"></i><?php echo e(__('Rto')); ?></a>
        <ul class="collapse list-unstyled" id="rtod" data-parent="#accordion" >
		
           <li><a href="<?php echo e(route('admin-order-rto')); ?>"> <?php echo e(__('Add Rto')); ?></a></li>
	   
		   <li><a href="<?php echo e(route('admin-ship-rto')); ?>"> <?php echo e(__('Shipped Rto')); ?></a></li>
	    
		   <li><a href="<?php echo e(route('admin-open-rto')); ?>"> <?php echo e(__('Pending Rto')); ?></a></li>
	    
		 <li><a href="<?php echo e(route('admin-resolved-rto')); ?>"> <?php echo e(__('Delivered Rto')); ?></a></li>
	    
		<li><a href="<?php echo e(route('admin-notdelivered-rto')); ?>"> <?php echo e(__('Notdelivered Rto')); ?></a></li>
		
		   <li><a href="<?php echo e(route('admin-decline-rto')); ?>"> <?php echo e(__('Decline Rto')); ?></a></li>
          
        </ul>
    </li>
	
	<li>
        <a href="#disputedata" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false"><i class="fas fa-sync"></i><?php echo e(__('Dispute')); ?></a>
        <ul class="collapse list-unstyled" id="disputedata" data-parent="#accordion" >		
           <li><a href="<?php echo e(route('admin-order-disputes')); ?>"> <?php echo e(__('Add Dispute')); ?></a></li>  
	       <li><a href="<?php echo e(route('admin-open-disputes')); ?>"> <?php echo e(__('Pending Dispute')); ?></a></li>
		   <li><a href="<?php echo e(route('admin-resolved-disputeds')); ?>"> <?php echo e(__('Complete Dispute')); ?></a></li>
	       
        </ul>
    </li>
	
	<li>
        <a href="#couponed" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false"><i class="fas fa-sync"></i><?php echo e(__('Coupon')); ?></a>
        <ul class="collapse list-unstyled" id="couponed" data-parent="#accordion" >
           <li><a href="<?php echo e(route('admin-coupon-code')); ?>"> <?php echo e(__('Coupon')); ?></a></li>
		   <li><a href="<?php echo e(route('admin-coupon-alllist')); ?>"> <?php echo e(__('List Coupon')); ?></a></li>
		   <li><a href="<?php echo e(route('admin-coupon-approvallist')); ?>"> <?php echo e(__('Approval Coupon')); ?></a></li>
           <li><a href="<?php echo e(route('admin-coupon-rejectlist')); ?>"> <?php echo e(__('Reject Coupon')); ?></a></li>		   
        </ul>
    </li>
<?php endif; ?>