@if(Auth::guard('admin')->user()->role_id != 0)

    @if(Auth::guard('admin')->user()->sectionCheck('add_new_product'))
            <li><a href="{{ route('admin-prod-physical-create') }}"><span>{{ __('Add New Product') }}</span></a></li>
        @endif
        @if(Auth::guard('admin')->user()->sectionCheck('all_products'))
            <li><a href="{{ route('admin-prod-index') }}"><span>{{ __('All Products') }}</span></a></li>
        @endif
        @if(Auth::guard('admin')->user()->sectionCheck('simple_products'))
            <li><a href="{{ route('admin-prod-simpleproduct') }}"><span>{{ __('Simple Products') }}</span></a></li>
        @endif
        @if(Auth::guard('admin')->user()->sectionCheck('variation_products'))
            <li><a href="{{ route('admin-prod-variationproduct') }}"><span>{{ __('Variation Products') }}</span></a></li>
        @endif
        @if(Auth::guard('admin')->user()->sectionCheck('deactivated_product'))
            <li><a href="{{ route('admin-prod-deactive') }}"><span>{{ __('Deactivated Product') }}</span></a></li>
        @endif
          <!--  <li><a href="{{ route('admin-prod-catalog-index') }}"><span>{{ __('Product Catalogs') }}</span></a></li>   --> 
          @if(Auth::guard('admin')->user()->sectionCheck('manage_categories'))
             <li>
        <a href="#menu5" class="dropdown_level_3"><span>{{ __('Manage Categories') }} </a>
        <ul class="list-unstyled
        @if(request()->is('admin/attribute/*/manage') && request()->input('type')=='category')
          show
        @elseif(request()->is('admin/attribute/*/manage') && request()->input('type')=='subcategory')
          show
        @elseif(request()->is('admin/attribute/*/manage') && request()->input('type')=='childcategory')
          show
        @endif" id="menu5">
                <li class="@if(request()->is('admin/attribute/*/manage') && request()->input('type')=='category') active @endif">
                    <a href="{{ route('admin-cat-index') }}"><span>{{ __('Main Category') }}</span></a>
                </li>
                <li class="@if(request()->is('admin/attribute/*/manage') && request()->input('type')=='subcategory') active @endif">
                    <a href="{{ route('admin-subcat-index') }}"><span>{{ __('Sub Category') }}</span></a>
                </li>
                <li class="@if(request()->is('admin/attribute/*/manage') && request()->input('type')=='childcategory') active @endif">
                    <a href="{{ route('admin-childcat-index') }}"><span>{{ __('Child Category') }}</span></a>
                </li>
        </ul>
    </li>
    @endif
    @if(Auth::guard('admin')->user()->sectionCheck('bulk_product_upload'))
     <li><a href="{{ route('admin-prod-import') }}"><span>{{ __('Bulk Product Upload') }}</span></a></li>
    @endif
    @if(Auth::guard('admin')->user()->sectionCheck('product_reviews'))     
     <li><a href="{{ route('admin-reviews-index') }}"><span>{{ __('Product Reviews') }}</span></a></li>
    @endif
    @if(Auth::guard('admin')->user()->sectionCheck('media'))
      <li><a href="{{ route('admin-media-index') }}"><span>{{ __('Media') }}</span></a></li>
    @endif
     

        @if(Auth::guard('admin')->user()->sectionCheck('all_orders'))
            <li><a href="{{route('admin-order-index')}}"><span> {{ __('All Orders') }}</span></a></li>
        @endif
        @if(Auth::guard('admin')->user()->sectionCheck('pending_orders'))
            <li><a href="{{route('admin-order-pending')}}"><span> {{ __('Pending Orders') }}</span></a></li>
        @endif
        @if(Auth::guard('admin')->user()->sectionCheck('processing_orders'))
            <li><a href="{{route('admin-order-processing')}}"><span> {{ __('Processing Orders') }}</span></a></li>
        @endif
        @if(Auth::guard('admin')->user()->sectionCheck('shipped_orders'))
            <li><a href="{{route('admin-order-shipping')}}"><span> {{ __('Shipped Orders') }}</span></a></li>
        @endif
        @if(Auth::guard('admin')->user()->sectionCheck('completed_orders'))
            <li><a href="{{route('admin-order-completed')}}"><span> {{ __('Completed Orders') }}</span></a></li>
        @endif
        @if(Auth::guard('admin')->user()->sectionCheck('declined_orders'))
            <li><a href="{{route('admin-order-declined')}}"><span> {{ __('Declined Orders') }}</span></a></li>
        @endif
        @if(Auth::guard('admin')->user()->sectionCheck('refund_orders'))
            <li><a href="{{route('admin-order-refundod')}}"><span> {{ __('Refund Orders') }}</span></a></li>
        @endif
        @if(Auth::guard('admin')->user()->sectionCheck('download_order_track'))
            <li><a href="{{route('admin-order-ordertracks')}}"><span> {{ __('Download Order Track') }}</span></a></li>
        @endif
        @if(Auth::guard('admin')->user()->sectionCheck('ticket_dispute'))
            <li>
        <a href="#msg" class="dropdown_level_3"><span>{{ __('Tickets & Disputes') }}</span></a>
        <ul class="list-unstyled" id="msg">
            <li><a href="{{ route('admin-message-index') }}"><span>{{ __('Tickets') }}</span></a></li>
            <li><a href="{{ route('admin-message-dispute') }}"><span>{{ __('Disputes') }}</span></a></li>
        </ul>
    </li>
    @endif
     
        @if(Auth::guard('admin')->user()->sectionCheck('vendor_list'))
            <li><a href="{{ route('admin-vendor-index') }}"><span>{{ __('Vendors List') }}</span></a></li>
        @endif
        @if(Auth::guard('admin')->user()->sectionCheck('vendor_registration'))
            <li><a href="{{ route('admin-vendor-register') }}"><span>{{ __('Vendors Registration') }}</span></a></li>
        @endif
        @if(Auth::guard('admin')->user()->sectionCheck('withdrawls'))
            <li><a href="{{ route('admin-vendor-withdraw-index') }}"><span>{{ __('Withdrawals') }}</span></a></li>
        @endif
        @if(Auth::guard('admin')->user()->sectionCheck('admin_approve_list'))
            <li><a href="{{ route('admin-vendor-adminapprovelist-index') }}"><span>{{ __('Admin Approve List') }}</span></a></li>
        @endif
        @if(Auth::guard('admin')->user()->sectionCheck('vendor_subscription'))
            <li><a href="{{ route('admin-vendor-subs') }}"><span>{{ __('Vendor Subscriptions') }}</span></a></li>
        @endif
        @if(Auth::guard('admin')->user()->sectionCheck('default_background'))
            <li><a href="{{ route('admin-vendor-color') }}"><span>{{ __('Default Background') }}</span></a></li>
        @endif
        @if(Auth::guard('admin')->user()->sectionCheck('vendor_verification'))
             <li>
        <a href="#vendor1" class="dropdown_level_3"><span>{{ __('Vendor Verifications') }}</span></a>
        <ul class="list-unstyled" id="vendor1">
            <li><a href="{{ route('admin-vr-index') }}"><span>{{ __('All Verifications') }}</span></a></li>
            <li><a href="{{ route('admin-vr-pending') }}"><span>{{ __('Pending Verifications') }}</span></a></li>
        </ul>
    </li>
    @endif
    @if(Auth::guard('admin')->user()->sectionCheck('vendor_subscription_plans'))
        <li><a href="{{ route('admin-subscription-index') }}" class=" wave-effect"><span>{{ __('Vendor Subscription Plans') }}</span></a></li>
    @endif

 
        @if(Auth::guard('admin')->user()->sectionCheck('customer_list'))
            <li><a href="{{ route('admin-user-index') }}"><span>{{ __('Customers List') }}</span></a></li>
        @endif
        @if(Auth::guard('admin')->user()->sectionCheck('customer_withdraw'))
            <li><a href="{{ route('admin-withdraw-index') }}"><span>{{ __('Withdraws') }}</span></a></li>
        @endif
        @if(Auth::guard('admin')->user()->sectionCheck('customer_default_image'))
            <li><a href="{{ route('admin-user-image') }}"><span>{{ __('Customer Default Image') }}</span></a></li>
        @endif
        @if(Auth::guard('admin')->user()->sectionCheck('customer_enquiry'))
            <li><a href="{{ route('admin-customenquiry-index') }}"><span>{{ __('Customer Enquiry') }}</span></a></li>
        @endif
        @if(Auth::guard('admin')->user()->sectionCheck('subscriber'))
            <li><a href="{{ route('admin-subs-index') }}" class=" wave-effect"><span>{{ __('Subscribers') }}</span></a>
        @endif
    </li>
   
     
        @if(Auth::guard('admin')->user()->sectionCheck('manage_staffs'))
         <li><a href="{{ route('admin-staff-index') }}" class=" wave-effect"><span>{{ __('Manage Staffs') }}</span></a></li>
     @endif
     @if(Auth::guard('admin')->user()->sectionCheck('manage_roles'))
        <li><a href="{{ route('admin-role-index') }}" class=" wave-effect"><span>{{ __('Manage Roles') }}</span></a></li>
    @endif

    @if(Auth::guard('admin')->user()->sectionCheck('overview'))
         <li><a href="{{ route('admin.overview') }}" class=" wave-effect"><span>{{ __('Overview ') }}</span></a></li>
    @endif
    @if(Auth::guard('admin')->user()->sectionCheck('anal_orders'))
        <li><a href="{{ route('admin.orderrecord') }}" class=" wave-effect"><span>{{ __('Orders') }}</span></a></li>
    @endif
    @if(Auth::guard('admin')->user()->sectionCheck('refund'))
        <li><a href="{{ route('admin.refundrecord') }}" class=" wave-effect"><span>{{ __('Refund') }}</span></a></li>
    @endif
    @if(Auth::guard('admin')->user()->sectionCheck('revanue'))
        <li><a href="{{ route('admin.revenue') }}" class=" wave-effect"><span>{{ __('Revenue') }}</span></a></li>
    @endif
    @if(Auth::guard('admin')->user()->sectionCheck('product'))  
        <li><a href="{{ route('admin.productrecord') }}" class=" wave-effect"><span>{{ __('Product') }}</span></a></li>
    @endif
    @if(Auth::guard('admin')->user()->sectionCheck('vendor_commision_reports'))
        <li><a href="{{ route('admin.analyticrecord') }}" class=" wave-effect"><span>{{ __('Vendor Commission Reports') }}</span></a></li>
    @endif


        @if(Auth::guard('admin')->user()->sectionCheck('set_coupons'))
            <li><a href="{{ route('admin-coupon-index') }}" class=" wave-effect"><span>{{ __('Set Coupons') }}</span></a></li>
        @endif
        @if(Auth::guard('admin')->user()->sectionCheck('general_settings'))
            <li>
        <a href="#general"  class="dropdown_level_3"><span>{{ __('General Settings') }}</span></a>
        <ul class="list-unstyled" id="general">
            <li><a href="{{ route('admin-gs-logo') }}">                 <span>{{ __('Logo') }}</span></a></li>
            <li><a href="{{ route('admin-gs-fav') }}">                  <span>{{ __('Favicon') }}</span></a></li>
            <li><a href="{{ route('admin-gs-load') }}">                 <span>{{ __('Loader') }}</span></a></li>
            <li><a href="{{ route('admin-shipping-index') }}">          <span>{{ __('Shipping Methods') }}</span></a></li>
            <li><a href="{{ route('admin-manageshipping-index') }}">          <span>{{ __('Shipping Rate') }}</span></a></li>
            <li><a href="{{ route('admin-package-index') }}">           <span>{{ __('Packagings') }}</span></a></li>
            <li><a href="{{ route('admin-pick-index') }}">              <span>{{ __('Pickup Locations') }}</span></a></li>
            <li><a href="{{ route('admin-gs-contents') }}">             <span>{{ __('Website Contents') }}</span></a></li>
            <li><a href="{{ route('admin-gs-footer') }}">               <span>{{ __('Footer') }}</span></a></li>
            <li><a href="{{ route('admin-gs-affilate') }}">             <span>{{__('Affiliate Information')}}</span></a></li>
            <li><a href="{{ route('admin-gs-popup') }}">                <span>{{ __('Popup Banner') }}</span></a></li>
            <li><a href="{{ route('admin-gs-error-banner') }}">         <span>{{ __('Error Banner') }}</span></a></li>
            <li><a href="{{ route('admin-gs-maintenance') }}">          <span>{{ __('Website Maintenance') }}</span></a></li>           
        </ul>
    </li>
    @endif
    @if(Auth::guard('admin')->user()->sectionCheck('home_page_settings'))
      <li>
        <a href="#homepage"  class="dropdown_level_3"><span>{{ __('Home Page Settings') }}</span></a>
        <ul class="list-unstyled" id="homepage">
            <li><a href="{{ route('admin-sl-index') }}"><span>{{ __('Sliders') }}</span></a></li>
            <li><a href="{{ route('admin-service-index') }}"><span>{{ __('Services') }}</span></a></li>
            <li><a href="{{ route('admin-ps-best-seller') }}"><span>{{ __('Right Side Banner1') }}</span></a></li>
            <li><a href="{{ route('admin-ps-big-save') }}"><span>{{ __('Right Side Banner2') }}</span></a></li>
            <li><a href="{{ route('admin-sb-index') }}"><span>{{ __('Top Small Banners') }}</span></a></li>
            <li><a href="{{ route('admin-sb-large') }}"><span>{{ __('Large Banners') }}</span></a></li>
            <li><a href="{{ route('admin-sb-bottom') }}"><span>{{ __('Offers Banners') }}</span></a></li>
            <li><a href="{{ route('admin-review-index') }}"><span>{{ __('Reviews') }}</span></a></li>
            <li><a href="{{ route('admin-partner-index') }}"><span>{{ __('Comming Soon') }}</span></a></li>
            <li><a href="{{ route('admin-ps-customize') }}"><span>{{ __('Home Page Customization') }}</span></a></li>
        </ul>
    </li>
    @endif
    @if(Auth::guard('admin')->user()->sectionCheck('menu_page_settings'))
     <li>
        <a href="#menu" class="dropdown_level_3"><span>{{ __('Menu Page Settings') }}</span></a>
        <ul class="list-unstyled" id="menu">
            <li><a href="{{ route('admin-faq-index') }}"><span>{{ __('FAQ Page') }}</span></a></li>
            <li><a href="{{ route('admin-ps-contact') }}"><span>{{ __('Contact Us Page') }}</span></a></li>
            <li><a href="{{ route('admin-page-index') }}"><span>{{ __('Other Pages') }}</span></a></li>
        </ul>
    </li>
    @endif
    @if(Auth::guard('admin')->user()->sectionCheck('email_settings'))
    <li>
        <a href="#emails" class="dropdown_level_3">
           {{ __('Email Settings') }}
        </a>
        <ul class=" list-unstyled" id="emails">
            <li><a href="{{route('admin-mail-index')}}"><span>{{ __('Email Template') }}</span></a></li>
            <li><a href="{{route('admin-mail-config')}}"><span>{{ __('Email Configurations') }}</span></a></li>
            <li><a href="{{route('admin-group-show')}}"><span>{{ __('Group Email') }}</span></a></li>
        </ul>
    </li>
    @endif
    @if(Auth::guard('admin')->user()->sectionCheck('payment_settings'))
       <li>
        <a href="#payments" class="dropdown_level_3"><span>{{ __('Payment Settings') }}</span></a>
        <ul class="list-unstyled" id="payments">
            <li><a href="{{route('admin-gs-payments')}}"><span>{{__('Payment Information')}}</span></a></li>
            <li><a href="{{route('admin-payment-index')}}"><span>{{ __('Payment Gateways') }}</span></a></li>
            <li><a href="{{route('admin-currency-index')}}"><span>{{ __('Currencies') }}</span></a></li>
        </ul>
    </li>
    @endif
    @if(Auth::guard('admin')->user()->sectionCheck('social_settings'))
     <li>
        <a href="#socials"class="dropdown_level_3">
            {{ __('Social Settings') }}
        </a>
        <ul class=" list-unstyled" id="socials">
                <li><a href="{{route('admin-social-index')}}"><span>{{ __('Social Links') }}</span></a></li>
                <li><a href="{{route('admin-social-facebook')}}"><span>{{ __('Facebook Login') }}</span></a></li>
                <li><a href="{{route('admin-social-google')}}"><span>{{ __('Google Login') }}</span></a></li>
        </ul>
    </li>
    @endif
    @if(Auth::guard('admin')->user()->sectionCheck('language_settings'))
   <li>
        <a href="#langs" class="dropdown_level_3"><span>{{ __('Language Settings') }}</span></a>
        <ul class=" list-unstyled" id="langs">
                <li><a href="{{route('admin-lang-index')}}"><span>{{ __('Website Language') }}</span></a></li>
                <li><a href="{{route('admin-tlang-index')}}"><span>{{ __('Admin Panel Language') }}</span></a></li>
        </ul>
    </li>
    @endif
    @if(Auth::guard('admin')->user()->sectionCheck('seo_tools'))
    <li>
        <a href="#seoTools" class="dropdown_level_3"><span>{{ __('SEO Tools') }}</span></a>
        <ul class="list-unstyled" id="seoTools">
            <li><a href="{{ route('admin-prod-popular',30) }}"><span>{{ __('Popular Products') }}</span></a></li>
            <li><a href="{{ route('admin-seotool-analytics') }}"><span>{{ __('Google Analytics') }}</span></a></li>
            <li><a href="{{ route('admin-seotool-keywords') }}"><span>{{ __('Website Meta Keywords') }}</span></a></li>
        </ul>
    </li>
    @endif
  

       
    @if(Auth::guard('admin')->user()->sectionCheck('clear_cache'))
         <li><a href="{{ route('admin-cache-clear') }}" class=" wave-effect"><span>{{ __('Clear Cache') }}</span></a></li>
     @endif
     @if(Auth::guard('admin')->user()->sectionCheck('generate_backup'))
         <li><a href="{{route('admin-generate-backup')}}"><span> {{ __('Generate Backup') }}</span></a></li>
     @endif
    
      
        @if(Auth::guard('admin')->user()->sectionCheck('create_refund'))
           <li><a href="{{route('admin-raise-dispute')}}"><span> {{ __('Create Refund') }}</span></a></li>
       @endif
       @if(Auth::guard('admin')->user()->sectionCheck('pending_refund'))
           <li><a href="{{route('admin-open-dispute')}}"><span> {{ __('Pending Refunds') }}</span></a></li>
       @endif
       @if(Auth::guard('admin')->user()->sectionCheck('refunds_paid'))
           <li><a href="{{route('admin-resolved-dispute')}}"><span> {{ __('Refunds Paid') }}</span></a></li>
       @endif
       @if(Auth::guard('admin')->user()->sectionCheck('cancelled_refunds'))
           <li><a href="{{route('admin-decline-dispute')}}"><span> {{ __('Cancelled Refunds') }}</span></a></li>
       @endif      
   
 
        @if(Auth::guard('admin')->user()->sectionCheck('debit_note'))
           <li><a href="{{route('admin-debitnote-list')}}"><span> {{ __('Debit Note') }}</span></a></li>
        @endif
       @if(Auth::guard('admin')->user()->sectionCheck('unsettle_note'))
           <li><a href="{{route('admin-open-debit')}}"><span> {{ __('Unsettle Note') }}</span></a></li>
        @endif
       @if(Auth::guard('admin')->user()->sectionCheck('settle_note'))
           <li><a href="{{route('admin-resolved-debit')}}"><span> {{ __('Settle Note') }}</span></a></li>
        @endif
    


        @if(Auth::guard('admin')->user()->sectionCheck('credit_note'))
           <li><a href="{{route('admin-creditnote-list')}}"><span> {{ __('Credit Note') }}</span></a></li>
        @endif
       @if(Auth::guard('admin')->user()->sectionCheck('cunsettle_note'))
           <li><a href="{{route('admin-open-credit')}}"><span> {{ __('Unsettle Note') }}</span></a></li>
        @endif
       @if(Auth::guard('admin')->user()->sectionCheck('csettle_note'))
           <li><a href="{{route('admin-resolved-credit')}}"><span> {{ __('Settle Note') }}</span></a></li>
        @endif


        @if(Auth::guard('admin')->user()->sectionCheck('add_exchange'))
           <li><a href="{{route('admin-order-exchange')}}"><span> {{ __('Add Exchange') }}</span></a></li>
        @endif
       @if(Auth::guard('admin')->user()->sectionCheck('shipped_exchange'))
           <li><a href="{{route('admin-ship-exchange')}}"><span> {{ __('Shipped Exchange') }}</span></a></li>
        @endif
       @if(Auth::guard('admin')->user()->sectionCheck('pending_exchange'))
           <li><a href="{{route('admin-open-exchange')}}"><span> {{ __('Pending Exchange') }}</span></a></li>
        @endif
       @if(Auth::guard('admin')->user()->sectionCheck('delivered_exchange'))
         <li><a href="{{route('admin-resolved-exchange')}}"><span> {{ __('Delivered Exchange') }}</span></a></li>
        @endif
        @if(Auth::guard('admin')->user()->sectionCheck('not_delivered_exchange'))
        <li><a href="{{route('admin-notdelivered-exchange')}}"><span> {{ __('Notdelivered Exchange') }}</span></a></li>
        @endif
        @if(Auth::guard('admin')->user()->sectionCheck('decline_exchange'))
           <li><a href="{{route('admin-decline-exchange')}}"><span> {{ __('Decline Exchange') }}</span></a></li>
        @endif     
   

        @if(Auth::guard('admin')->user()->sectionCheck('add_rto'))
           <li><a href="{{route('admin-order-rto')}}"><span> {{ __('Add Rto') }}</span></a></li>
        @endif
        @if(Auth::guard('admin')->user()->sectionCheck('shipped_rto'))
           <li><a href="{{route('admin-ship-rto')}}"><span> {{ __('Shipped Rto') }}</span></a></li>
        @endif
       @if(Auth::guard('admin')->user()->sectionCheck('pending_rto'))
           <li><a href="{{route('admin-open-rto')}}"><span> {{ __('Pending Rto') }}</span></a></li>
        @endif
       @if(Auth::guard('admin')->user()->sectionCheck('delivered_rto'))
         <li><a href="{{route('admin-resolved-rto')}}"><span> {{ __('Delivered Rto') }}</span></a></li>
        @endif
        @if(Auth::guard('admin')->user()->sectionCheck('not_delivered_rto'))
        <li><a href="{{route('admin-notdelivered-rto')}}"><span> {{ __('Notdelivered Rto') }}</span></a></li>
        @endif
        @if(Auth::guard('admin')->user()->sectionCheck('decline_rto'))
           <li><a href="{{route('admin-decline-rto')}}"><span> {{ __('Decline Rto') }}</span></a></li>
          @endif


        @if(Auth::guard('admin')->user()->sectionCheck('add_dispute'))
           <li><a href="{{route('admin-order-disputes')}}"><span> {{ __('Add Dispute') }}</span></a></li>
        @endif      
       @if(Auth::guard('admin')->user()->sectionCheck('pending_dispute'))
           <li><a href="{{route('admin-open-disputes')}}"><span> {{ __('Pending Dispute') }}</span></a></li>
        @endif
        @if(Auth::guard('admin')->user()->sectionCheck('complete_dispute'))
           <li><a href="{{route('admin-resolved-disputeds')}}"><span> {{ __('Complete Dispute') }}</span></a></li>
        @endif      
    

        @if(Auth::guard('admin')->user()->sectionCheck('coupon'))
           <li><a href="{{route('admin-coupon-code')}}"><span> {{ __('Coupon') }}</span></a></li>
       @endif
       @if(Auth::guard('admin')->user()->sectionCheck('list_coupon'))
           <li><a href="{{route('admin-coupon-alllist')}}"><span> {{ __('List Coupon') }}</span></a></li>
       @endif
       @if(Auth::guard('admin')->user()->sectionCheck('approval_coupon'))
           <li><a href="{{route('admin-coupon-approvallist')}}"><span> {{ __('Approval Coupon') }}</span></a></li>
       @endif
       @if(Auth::guard('admin')->user()->sectionCheck('reject_coupon'))
           <li><a href="{{route('admin-coupon-rejectlist')}}"><span> {{ __('Reject Coupon') }}</span></a></li>
       @endif      
    </ul>

@endif