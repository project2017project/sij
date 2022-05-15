<?php if(Auth::guard('admin')->user()->role_id != 0): ?>

    <?php if(Auth::guard('admin')->user()->sectionCheck('add_new_product')): ?>
            <li><a href="<?php echo e(route('admin-prod-physical-create')); ?>"><span><?php echo e(__('Add New Product')); ?></span></a></li>
        <?php endif; ?>
        <?php if(Auth::guard('admin')->user()->sectionCheck('all_products')): ?>
            <li><a href="<?php echo e(route('admin-prod-index')); ?>"><span><?php echo e(__('All Products')); ?></span></a></li>
        <?php endif; ?>
        <?php if(Auth::guard('admin')->user()->sectionCheck('simple_products')): ?>
            <li><a href="<?php echo e(route('admin-prod-simpleproduct')); ?>"><span><?php echo e(__('Simple Products')); ?></span></a></li>
        <?php endif; ?>
        <?php if(Auth::guard('admin')->user()->sectionCheck('variation_products')): ?>
            <li><a href="<?php echo e(route('admin-prod-variationproduct')); ?>"><span><?php echo e(__('Variation Products')); ?></span></a></li>
        <?php endif; ?>
        <?php if(Auth::guard('admin')->user()->sectionCheck('deactivated_product')): ?>
            <li><a href="<?php echo e(route('admin-prod-deactive')); ?>"><span><?php echo e(__('Deactivated Product')); ?></span></a></li>
        <?php endif; ?>
          <!--  <li><a href="<?php echo e(route('admin-prod-catalog-index')); ?>"><span><?php echo e(__('Product Catalogs')); ?></span></a></li>   --> 
          <?php if(Auth::guard('admin')->user()->sectionCheck('manage_categories')): ?>
             <li>
        <a href="#menu5" class="dropdown_level_3"><span><?php echo e(__('Manage Categories')); ?> </a>
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
    <?php if(Auth::guard('admin')->user()->sectionCheck('bulk_product_upload')): ?>
     <li><a href="<?php echo e(route('admin-prod-import')); ?>"><span><?php echo e(__('Bulk Product Upload')); ?></span></a></li>
    <?php endif; ?>
    <?php if(Auth::guard('admin')->user()->sectionCheck('product_reviews')): ?>     
     <li><a href="<?php echo e(route('admin-reviews-index')); ?>"><span><?php echo e(__('Product Reviews')); ?></span></a></li>
    <?php endif; ?>
    <?php if(Auth::guard('admin')->user()->sectionCheck('media')): ?>
      <li><a href="<?php echo e(route('admin-media-index')); ?>"><span><?php echo e(__('Media')); ?></span></a></li>
    <?php endif; ?>
     

        <?php if(Auth::guard('admin')->user()->sectionCheck('all_orders')): ?>
            <li><a href="<?php echo e(route('admin-order-index')); ?>"><span> <?php echo e(__('All Orders')); ?></span></a></li>
        <?php endif; ?>
        <?php if(Auth::guard('admin')->user()->sectionCheck('pending_orders')): ?>
            <li><a href="<?php echo e(route('admin-order-pending')); ?>"><span> <?php echo e(__('Pending Orders')); ?></span></a></li>
        <?php endif; ?>
        <?php if(Auth::guard('admin')->user()->sectionCheck('processing_orders')): ?>
            <li><a href="<?php echo e(route('admin-order-processing')); ?>"><span> <?php echo e(__('Processing Orders')); ?></span></a></li>
        <?php endif; ?>
        <?php if(Auth::guard('admin')->user()->sectionCheck('shipped_orders')): ?>
            <li><a href="<?php echo e(route('admin-order-shipping')); ?>"><span> <?php echo e(__('Shipped Orders')); ?></span></a></li>
        <?php endif; ?>
        <?php if(Auth::guard('admin')->user()->sectionCheck('completed_orders')): ?>
            <li><a href="<?php echo e(route('admin-order-completed')); ?>"><span> <?php echo e(__('Completed Orders')); ?></span></a></li>
        <?php endif; ?>
        <?php if(Auth::guard('admin')->user()->sectionCheck('declined_orders')): ?>
            <li><a href="<?php echo e(route('admin-order-declined')); ?>"><span> <?php echo e(__('Declined Orders')); ?></span></a></li>
        <?php endif; ?>
        <?php if(Auth::guard('admin')->user()->sectionCheck('refund_orders')): ?>
            <li><a href="<?php echo e(route('admin-order-refundod')); ?>"><span> <?php echo e(__('Refund Orders')); ?></span></a></li>
        <?php endif; ?>
        <?php if(Auth::guard('admin')->user()->sectionCheck('download_order_track')): ?>
            <li><a href="<?php echo e(route('admin-order-ordertracks')); ?>"><span> <?php echo e(__('Download Order Track')); ?></span></a></li>
        <?php endif; ?>
        <?php if(Auth::guard('admin')->user()->sectionCheck('ticket_dispute')): ?>
            <li>
        <a href="#msg" class="dropdown_level_3"><span><?php echo e(__('Tickets & Disputes')); ?></span></a>
        <ul class="list-unstyled" id="msg">
            <li><a href="<?php echo e(route('admin-message-index')); ?>"><span><?php echo e(__('Tickets')); ?></span></a></li>
            <li><a href="<?php echo e(route('admin-message-dispute')); ?>"><span><?php echo e(__('Disputes')); ?></span></a></li>
        </ul>
    </li>
    <?php endif; ?>
     
        <?php if(Auth::guard('admin')->user()->sectionCheck('vendor_list')): ?>
            <li><a href="<?php echo e(route('admin-vendor-index')); ?>"><span><?php echo e(__('Vendors List')); ?></span></a></li>
        <?php endif; ?>
        <?php if(Auth::guard('admin')->user()->sectionCheck('vendor_registration')): ?>
            <li><a href="<?php echo e(route('admin-vendor-register')); ?>"><span><?php echo e(__('Vendors Registration')); ?></span></a></li>
        <?php endif; ?>
        <?php if(Auth::guard('admin')->user()->sectionCheck('withdrawls')): ?>
            <li><a href="<?php echo e(route('admin-vendor-withdraw-index')); ?>"><span><?php echo e(__('Withdrawals')); ?></span></a></li>
        <?php endif; ?>
        <?php if(Auth::guard('admin')->user()->sectionCheck('admin_approve_list')): ?>
            <li><a href="<?php echo e(route('admin-vendor-adminapprovelist-index')); ?>"><span><?php echo e(__('Admin Approve List')); ?></span></a></li>
        <?php endif; ?>
        <?php if(Auth::guard('admin')->user()->sectionCheck('vendor_subscription')): ?>
            <li><a href="<?php echo e(route('admin-vendor-subs')); ?>"><span><?php echo e(__('Vendor Subscriptions')); ?></span></a></li>
        <?php endif; ?>
        <?php if(Auth::guard('admin')->user()->sectionCheck('default_background')): ?>
            <li><a href="<?php echo e(route('admin-vendor-color')); ?>"><span><?php echo e(__('Default Background')); ?></span></a></li>
        <?php endif; ?>
        <?php if(Auth::guard('admin')->user()->sectionCheck('vendor_verification')): ?>
             <li>
        <a href="#vendor1" class="dropdown_level_3"><span><?php echo e(__('Vendor Verifications')); ?></span></a>
        <ul class="list-unstyled" id="vendor1">
            <li><a href="<?php echo e(route('admin-vr-index')); ?>"><span><?php echo e(__('All Verifications')); ?></span></a></li>
            <li><a href="<?php echo e(route('admin-vr-pending')); ?>"><span><?php echo e(__('Pending Verifications')); ?></span></a></li>
        </ul>
    </li>
    <?php endif; ?>
    <?php if(Auth::guard('admin')->user()->sectionCheck('vendor_subscription_plans')): ?>
        <li><a href="<?php echo e(route('admin-subscription-index')); ?>" class=" wave-effect"><span><?php echo e(__('Vendor Subscription Plans')); ?></span></a></li>
    <?php endif; ?>

 
        <?php if(Auth::guard('admin')->user()->sectionCheck('customer_list')): ?>
            <li><a href="<?php echo e(route('admin-user-index')); ?>"><span><?php echo e(__('Customers List')); ?></span></a></li>
        <?php endif; ?>
        <?php if(Auth::guard('admin')->user()->sectionCheck('customer_withdraw')): ?>
            <li><a href="<?php echo e(route('admin-withdraw-index')); ?>"><span><?php echo e(__('Withdraws')); ?></span></a></li>
        <?php endif; ?>
        <?php if(Auth::guard('admin')->user()->sectionCheck('customer_default_image')): ?>
            <li><a href="<?php echo e(route('admin-user-image')); ?>"><span><?php echo e(__('Customer Default Image')); ?></span></a></li>
        <?php endif; ?>
        <?php if(Auth::guard('admin')->user()->sectionCheck('customer_enquiry')): ?>
            <li><a href="<?php echo e(route('admin-customenquiry-index')); ?>"><span><?php echo e(__('Customer Enquiry')); ?></span></a></li>
        <?php endif; ?>
        <?php if(Auth::guard('admin')->user()->sectionCheck('subscriber')): ?>
            <li><a href="<?php echo e(route('admin-subs-index')); ?>" class=" wave-effect"><span><?php echo e(__('Subscribers')); ?></span></a>
        <?php endif; ?>
    </li>
   
     
        <?php if(Auth::guard('admin')->user()->sectionCheck('manage_staffs')): ?>
         <li><a href="<?php echo e(route('admin-staff-index')); ?>" class=" wave-effect"><span><?php echo e(__('Manage Staffs')); ?></span></a></li>
     <?php endif; ?>
     <?php if(Auth::guard('admin')->user()->sectionCheck('manage_roles')): ?>
        <li><a href="<?php echo e(route('admin-role-index')); ?>" class=" wave-effect"><span><?php echo e(__('Manage Roles')); ?></span></a></li>
    <?php endif; ?>

    <?php if(Auth::guard('admin')->user()->sectionCheck('overview')): ?>
         <li><a href="<?php echo e(route('admin.overview')); ?>" class=" wave-effect"><span><?php echo e(__('Overview ')); ?></span></a></li>
    <?php endif; ?>
    <?php if(Auth::guard('admin')->user()->sectionCheck('anal_orders')): ?>
        <li><a href="<?php echo e(route('admin.orderrecord')); ?>" class=" wave-effect"><span><?php echo e(__('Orders')); ?></span></a></li>
    <?php endif; ?>
    <?php if(Auth::guard('admin')->user()->sectionCheck('refund')): ?>
        <li><a href="<?php echo e(route('admin.refundrecord')); ?>" class=" wave-effect"><span><?php echo e(__('Refund')); ?></span></a></li>
    <?php endif; ?>
    <?php if(Auth::guard('admin')->user()->sectionCheck('revanue')): ?>
        <li><a href="<?php echo e(route('admin.revenue')); ?>" class=" wave-effect"><span><?php echo e(__('Revenue')); ?></span></a></li>
    <?php endif; ?>
    <?php if(Auth::guard('admin')->user()->sectionCheck('product')): ?>  
        <li><a href="<?php echo e(route('admin.productrecord')); ?>" class=" wave-effect"><span><?php echo e(__('Product')); ?></span></a></li>
    <?php endif; ?>
    <?php if(Auth::guard('admin')->user()->sectionCheck('vendor_commision_reports')): ?>
        <li><a href="<?php echo e(route('admin.analyticrecord')); ?>" class=" wave-effect"><span><?php echo e(__('Vendor Commission Reports')); ?></span></a></li>
    <?php endif; ?>


        <?php if(Auth::guard('admin')->user()->sectionCheck('set_coupons')): ?>
            <li><a href="<?php echo e(route('admin-coupon-index')); ?>" class=" wave-effect"><span><?php echo e(__('Set Coupons')); ?></span></a></li>
        <?php endif; ?>
        <?php if(Auth::guard('admin')->user()->sectionCheck('general_settings')): ?>
            <li>
        <a href="#general"  class="dropdown_level_3"><span><?php echo e(__('General Settings')); ?></span></a>
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
    <?php if(Auth::guard('admin')->user()->sectionCheck('home_page_settings')): ?>
      <li>
        <a href="#homepage"  class="dropdown_level_3"><span><?php echo e(__('Home Page Settings')); ?></span></a>
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
    <?php if(Auth::guard('admin')->user()->sectionCheck('menu_page_settings')): ?>
     <li>
        <a href="#menu" class="dropdown_level_3"><span><?php echo e(__('Menu Page Settings')); ?></span></a>
        <ul class="list-unstyled" id="menu">
            <li><a href="<?php echo e(route('admin-faq-index')); ?>"><span><?php echo e(__('FAQ Page')); ?></span></a></li>
            <li><a href="<?php echo e(route('admin-ps-contact')); ?>"><span><?php echo e(__('Contact Us Page')); ?></span></a></li>
            <li><a href="<?php echo e(route('admin-page-index')); ?>"><span><?php echo e(__('Other Pages')); ?></span></a></li>
        </ul>
    </li>
    <?php endif; ?>
    <?php if(Auth::guard('admin')->user()->sectionCheck('email_settings')): ?>
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
    <?php if(Auth::guard('admin')->user()->sectionCheck('payment_settings')): ?>
       <li>
        <a href="#payments" class="dropdown_level_3"><span><?php echo e(__('Payment Settings')); ?></span></a>
        <ul class="list-unstyled" id="payments">
            <li><a href="<?php echo e(route('admin-gs-payments')); ?>"><span><?php echo e(__('Payment Information')); ?></span></a></li>
            <li><a href="<?php echo e(route('admin-payment-index')); ?>"><span><?php echo e(__('Payment Gateways')); ?></span></a></li>
            <li><a href="<?php echo e(route('admin-currency-index')); ?>"><span><?php echo e(__('Currencies')); ?></span></a></li>
        </ul>
    </li>
    <?php endif; ?>
    <?php if(Auth::guard('admin')->user()->sectionCheck('social_settings')): ?>
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
    <?php if(Auth::guard('admin')->user()->sectionCheck('language_settings')): ?>
   <li>
        <a href="#langs" class="dropdown_level_3"><span><?php echo e(__('Language Settings')); ?></span></a>
        <ul class=" list-unstyled" id="langs">
                <li><a href="<?php echo e(route('admin-lang-index')); ?>"><span><?php echo e(__('Website Language')); ?></span></a></li>
                <li><a href="<?php echo e(route('admin-tlang-index')); ?>"><span><?php echo e(__('Admin Panel Language')); ?></span></a></li>
        </ul>
    </li>
    <?php endif; ?>
    <?php if(Auth::guard('admin')->user()->sectionCheck('seo_tools')): ?>
    <li>
        <a href="#seoTools" class="dropdown_level_3"><span><?php echo e(__('SEO Tools')); ?></span></a>
        <ul class="list-unstyled" id="seoTools">
            <li><a href="<?php echo e(route('admin-prod-popular',30)); ?>"><span><?php echo e(__('Popular Products')); ?></span></a></li>
            <li><a href="<?php echo e(route('admin-seotool-analytics')); ?>"><span><?php echo e(__('Google Analytics')); ?></span></a></li>
            <li><a href="<?php echo e(route('admin-seotool-keywords')); ?>"><span><?php echo e(__('Website Meta Keywords')); ?></span></a></li>
        </ul>
    </li>
    <?php endif; ?>
  

       
    <?php if(Auth::guard('admin')->user()->sectionCheck('clear_cache')): ?>
         <li><a href="<?php echo e(route('admin-cache-clear')); ?>" class=" wave-effect"><span><?php echo e(__('Clear Cache')); ?></span></a></li>
     <?php endif; ?>
     <?php if(Auth::guard('admin')->user()->sectionCheck('generate_backup')): ?>
         <li><a href="<?php echo e(route('admin-generate-backup')); ?>"><span> <?php echo e(__('Generate Backup')); ?></span></a></li>
     <?php endif; ?>
    
      
        <?php if(Auth::guard('admin')->user()->sectionCheck('create_refund')): ?>
           <li><a href="<?php echo e(route('admin-raise-dispute')); ?>"><span> <?php echo e(__('Create Refund')); ?></span></a></li>
       <?php endif; ?>
       <?php if(Auth::guard('admin')->user()->sectionCheck('pending_refund')): ?>
           <li><a href="<?php echo e(route('admin-open-dispute')); ?>"><span> <?php echo e(__('Pending Refunds')); ?></span></a></li>
       <?php endif; ?>
       <?php if(Auth::guard('admin')->user()->sectionCheck('refunds_paid')): ?>
           <li><a href="<?php echo e(route('admin-resolved-dispute')); ?>"><span> <?php echo e(__('Refunds Paid')); ?></span></a></li>
       <?php endif; ?>
       <?php if(Auth::guard('admin')->user()->sectionCheck('cancelled_refunds')): ?>
           <li><a href="<?php echo e(route('admin-decline-dispute')); ?>"><span> <?php echo e(__('Cancelled Refunds')); ?></span></a></li>
       <?php endif; ?>      
   
 
        <?php if(Auth::guard('admin')->user()->sectionCheck('debit_note')): ?>
           <li><a href="<?php echo e(route('admin-debitnote-list')); ?>"><span> <?php echo e(__('Debit Note')); ?></span></a></li>
        <?php endif; ?>
       <?php if(Auth::guard('admin')->user()->sectionCheck('unsettle_note')): ?>
           <li><a href="<?php echo e(route('admin-open-debit')); ?>"><span> <?php echo e(__('Unsettle Note')); ?></span></a></li>
        <?php endif; ?>
       <?php if(Auth::guard('admin')->user()->sectionCheck('settle_note')): ?>
           <li><a href="<?php echo e(route('admin-resolved-debit')); ?>"><span> <?php echo e(__('Settle Note')); ?></span></a></li>
        <?php endif; ?>
    


        <?php if(Auth::guard('admin')->user()->sectionCheck('credit_note')): ?>
           <li><a href="<?php echo e(route('admin-creditnote-list')); ?>"><span> <?php echo e(__('Credit Note')); ?></span></a></li>
        <?php endif; ?>
       <?php if(Auth::guard('admin')->user()->sectionCheck('cunsettle_note')): ?>
           <li><a href="<?php echo e(route('admin-open-credit')); ?>"><span> <?php echo e(__('Unsettle Note')); ?></span></a></li>
        <?php endif; ?>
       <?php if(Auth::guard('admin')->user()->sectionCheck('csettle_note')): ?>
           <li><a href="<?php echo e(route('admin-resolved-credit')); ?>"><span> <?php echo e(__('Settle Note')); ?></span></a></li>
        <?php endif; ?>


        <?php if(Auth::guard('admin')->user()->sectionCheck('add_exchange')): ?>
           <li><a href="<?php echo e(route('admin-order-exchange')); ?>"><span> <?php echo e(__('Add Exchange')); ?></span></a></li>
        <?php endif; ?>
       <?php if(Auth::guard('admin')->user()->sectionCheck('shipped_exchange')): ?>
           <li><a href="<?php echo e(route('admin-ship-exchange')); ?>"><span> <?php echo e(__('Shipped Exchange')); ?></span></a></li>
        <?php endif; ?>
       <?php if(Auth::guard('admin')->user()->sectionCheck('pending_exchange')): ?>
           <li><a href="<?php echo e(route('admin-open-exchange')); ?>"><span> <?php echo e(__('Pending Exchange')); ?></span></a></li>
        <?php endif; ?>
       <?php if(Auth::guard('admin')->user()->sectionCheck('delivered_exchange')): ?>
         <li><a href="<?php echo e(route('admin-resolved-exchange')); ?>"><span> <?php echo e(__('Delivered Exchange')); ?></span></a></li>
        <?php endif; ?>
        <?php if(Auth::guard('admin')->user()->sectionCheck('not_delivered_exchange')): ?>
        <li><a href="<?php echo e(route('admin-notdelivered-exchange')); ?>"><span> <?php echo e(__('Notdelivered Exchange')); ?></span></a></li>
        <?php endif; ?>
        <?php if(Auth::guard('admin')->user()->sectionCheck('decline_exchange')): ?>
           <li><a href="<?php echo e(route('admin-decline-exchange')); ?>"><span> <?php echo e(__('Decline Exchange')); ?></span></a></li>
        <?php endif; ?>     
   

        <?php if(Auth::guard('admin')->user()->sectionCheck('add_rto')): ?>
           <li><a href="<?php echo e(route('admin-order-rto')); ?>"><span> <?php echo e(__('Add Rto')); ?></span></a></li>
        <?php endif; ?>
        <?php if(Auth::guard('admin')->user()->sectionCheck('shipped_rto')): ?>
           <li><a href="<?php echo e(route('admin-ship-rto')); ?>"><span> <?php echo e(__('Shipped Rto')); ?></span></a></li>
        <?php endif; ?>
       <?php if(Auth::guard('admin')->user()->sectionCheck('pending_rto')): ?>
           <li><a href="<?php echo e(route('admin-open-rto')); ?>"><span> <?php echo e(__('Pending Rto')); ?></span></a></li>
        <?php endif; ?>
       <?php if(Auth::guard('admin')->user()->sectionCheck('delivered_rto')): ?>
         <li><a href="<?php echo e(route('admin-resolved-rto')); ?>"><span> <?php echo e(__('Delivered Rto')); ?></span></a></li>
        <?php endif; ?>
        <?php if(Auth::guard('admin')->user()->sectionCheck('not_delivered_rto')): ?>
        <li><a href="<?php echo e(route('admin-notdelivered-rto')); ?>"><span> <?php echo e(__('Notdelivered Rto')); ?></span></a></li>
        <?php endif; ?>
        <?php if(Auth::guard('admin')->user()->sectionCheck('decline_rto')): ?>
           <li><a href="<?php echo e(route('admin-decline-rto')); ?>"><span> <?php echo e(__('Decline Rto')); ?></span></a></li>
          <?php endif; ?>


        <?php if(Auth::guard('admin')->user()->sectionCheck('add_dispute')): ?>
           <li><a href="<?php echo e(route('admin-order-disputes')); ?>"><span> <?php echo e(__('Add Dispute')); ?></span></a></li>
        <?php endif; ?>      
       <?php if(Auth::guard('admin')->user()->sectionCheck('pending_dispute')): ?>
           <li><a href="<?php echo e(route('admin-open-disputes')); ?>"><span> <?php echo e(__('Pending Dispute')); ?></span></a></li>
        <?php endif; ?>
        <?php if(Auth::guard('admin')->user()->sectionCheck('complete_dispute')): ?>
           <li><a href="<?php echo e(route('admin-resolved-disputeds')); ?>"><span> <?php echo e(__('Complete Dispute')); ?></span></a></li>
        <?php endif; ?>      
    

        <?php if(Auth::guard('admin')->user()->sectionCheck('coupon')): ?>
           <li><a href="<?php echo e(route('admin-coupon-code')); ?>"><span> <?php echo e(__('Coupon')); ?></span></a></li>
       <?php endif; ?>
       <?php if(Auth::guard('admin')->user()->sectionCheck('list_coupon')): ?>
           <li><a href="<?php echo e(route('admin-coupon-alllist')); ?>"><span> <?php echo e(__('List Coupon')); ?></span></a></li>
       <?php endif; ?>
       <?php if(Auth::guard('admin')->user()->sectionCheck('approval_coupon')): ?>
           <li><a href="<?php echo e(route('admin-coupon-approvallist')); ?>"><span> <?php echo e(__('Approval Coupon')); ?></span></a></li>
       <?php endif; ?>
       <?php if(Auth::guard('admin')->user()->sectionCheck('reject_coupon')): ?>
           <li><a href="<?php echo e(route('admin-coupon-rejectlist')); ?>"><span> <?php echo e(__('Reject Coupon')); ?></span></a></li>
       <?php endif; ?>      
    </ul>

<?php endif; ?>