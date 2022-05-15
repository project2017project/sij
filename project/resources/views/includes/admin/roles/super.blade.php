@php 
$data = App\Models\Role::where('id',1)->first();
@endphp    
 <li>
        <a href="#order" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false"><i class="fas fa-hand-holding-usd"></i>{{ __('Orders') }}</a>
        <ul class="collapse list-unstyled" id="order" data-parent="#accordion" >
            <li><a href="{{route('admin-order-index')}}"> {{ __('All Orders') }}</a></li>
            <li><a href="{{route('admin-order-pending')}}"> {{ __('Pending Orders') }}</a></li>
            <li><a href="{{route('admin-order-processing')}}"> {{ __('Processing Orders') }}</a></li>
            <li><a href="{{route('admin-order-shipping')}}"> {{ __('Shipped Orders') }}</a></li>
            <li><a href="{{route('admin-order-completed')}}"> {{ __('Completed Orders') }}</a></li>
            <li><a href="{{route('admin-order-declined')}}"> {{ __('Declined Orders') }}</a></li>
			<li><a href="{{route('admin-order-refundod')}}"> {{ __('Refund Orders') }}</a></li>
			<li><a href="{{route('admin-order-ordertracks')}}"> {{ __('Download Order Track') }}</a></li>
            <li>
        <a href="#msg" class="dropdown_level_3">{{ __('Tickets & Disputes') }}</a>
        <ul class="list-unstyled" id="msg">
            <li><a href="{{ route('admin-message-index') }}"><span>{{ __('Tickets') }}</span></a></li>
            <li><a href="{{ route('admin-message-dispute') }}"><span>{{ __('Disputes') }}</span></a></li>
        </ul>
    </li>

        </ul>
    </li>
@if($data)
	   <li>
        <a href="#menu2" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false"><i class="icofont-cart"></i>{{ __('Products') }}</a>
        <ul class="collapse list-unstyled" id="menu2" data-parent="#accordion">
		@if($data->sectionCheck('add_new_product'))
            <li><a href="{{ route('admin-prod-physical-create') }}"><span>{{ __('Add New Product') }}</span></a></li>
		@endif
		@if($data->sectionCheck('all_products'))
            <li><a href="{{ route('admin-prod-index') }}"><span>{{ __('All Products') }}</span></a></li>
		@endif
		@if($data->sectionCheck('simple_products'))
			<li><a href="{{ route('admin-prod-simpleproduct') }}"><span>{{ __('Simple Products') }}</span></a></li>
		@endif
		@if($data->sectionCheck('variation_products'))
			<li><a href="{{ route('admin-prod-variationproduct') }}"><span>{{ __('Variation Products') }}</span></a></li>
		@endif
		@if($data->sectionCheck('deactivated_product'))
            <li><a href="{{ route('admin-prod-deactive') }}"><span>{{ __('Deactivated Product') }}</span></a></li>
		@endif
          <!--  <li><a href="{{ route('admin-prod-catalog-index') }}"><span>{{ __('Product Catalogs') }}</span></a></li>   --> 
		  @if($data->sectionCheck('manage_categories'))
             <li>
        <a href="#menu5" class="dropdown_level_3">{{ __('Manage Categories') }} </a>
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
    @if($data->sectionCheck('bulk_product_upload'))
     <li><a href="{{ route('admin-prod-import') }}">{{ __('Bulk Product Upload') }}</a></li>
    @endif
    @if($data->sectionCheck('product_reviews'))     
     <li><a href="{{ route('admin-reviews-index') }}">{{ __('Product Reviews') }}</a></li>
    @endif
    @if($data->sectionCheck('media'))
      <li><a href="{{ route('admin-media-index') }}">{{ __('Media') }}</a></li>
    @endif
        </ul>
    </li>
    @if($data->sectionCheck('orders'))
    <li>
        <a href="#order" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false"><i class="fas fa-hand-holding-usd"></i>{{ __('Orders') }}</a>
        <ul class="collapse list-unstyled" id="order" data-parent="#accordion" >
		@if($data->sectionCheck('all_orders'))
            <li><a href="{{route('admin-order-index')}}"> {{ __('All Orders') }}</a></li>
		@endif
		@if($data->sectionCheck('pending_orders'))
            <li><a href="{{route('admin-order-pending')}}"> {{ __('Pending Orders') }}</a></li>
		@endif
		@if($data->sectionCheck('processing_orders'))
            <li><a href="{{route('admin-order-processing')}}"> {{ __('Processing Orders') }}</a></li>
		@endif
		@if($data->sectionCheck('shipped_orders'))
            <li><a href="{{route('admin-order-shipping')}}"> {{ __('Shipped Orders') }}</a></li>
		@endif
		@if($data->sectionCheck('completed_orders'))
            <li><a href="{{route('admin-order-completed')}}"> {{ __('Completed Orders') }}</a></li>
		@endif
		@if($data->sectionCheck('declined_orders'))
            <li><a href="{{route('admin-order-declined')}}"> {{ __('Declined Orders') }}</a></li>
		@endif
		@if($data->sectionCheck('refund_orders'))
			<li><a href="{{route('admin-order-refundod')}}"> {{ __('Refund Orders') }}</a></li>
		@endif
		@if($data->sectionCheck('download_order_track'))
			<li><a href="{{route('admin-order-ordertracks')}}"> {{ __('Download Order Track') }}</a></li>
		@endif
		@if($data->sectionCheck('ticket_dispute'))
            <li>
        <a href="#msg" class="dropdown_level_3">{{ __('Tickets & Disputes') }}</a>
        <ul class="list-unstyled" id="msg">
            <li><a href="{{ route('admin-message-index') }}"><span>{{ __('Tickets') }}</span></a></li>
            <li><a href="{{ route('admin-message-dispute') }}"><span>{{ __('Disputes') }}</span></a></li>
        </ul>
    </li>
	@endif
        </ul>
    </li>
	@endif
	 <!--li>
        <a href="#refund" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false"><i class="fas fa-hand-holding-usd"></i>{{ __('Refund Orders') }}</a>
        <ul class="collapse list-unstyled" id="refund" data-parent="#accordion" >
            <li><a href="{{route('admin-refund-index')}}"> {{ __('All Refund Orders') }}</a></li>
        </ul>
    </li-->
        <li>
        <a href="#vendor" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false"><i class="icofont-ui-user-group"></i>{{ __('Vendors') }}</a>
        <ul class="collapse list-unstyled" id="vendor" data-parent="#accordion">
		@if($data->sectionCheck('vendor_list'))
            <li><a href="{{ route('admin-vendor-index') }}"><span>{{ __('Vendors List') }}</span></a></li>
		@endif
		@if($data->sectionCheck('vendor_registration'))
			<li><a href="{{ route('admin-vendor-register') }}"><span>{{ __('Vendors Registration') }}</span></a></li>
		@endif
		@if($data->sectionCheck('withdrawls'))
            <li><a href="{{ route('admin-vendor-withdraw-index') }}"><span>{{ __('Withdrawals') }}</span></a></li>
		@endif
		@if($data->sectionCheck('admin_approve_list'))
			<li><a href="{{ route('admin-vendor-adminapprovelist-index') }}"><span>{{ __('Admin Approve List') }}</span></a></li>
		@endif
		@if($data->sectionCheck('vendor_subscription'))
            <li><a href="{{ route('admin-vendor-subs') }}"><span>{{ __('Vendor Subscriptions') }}</span></a></li>
		@endif
		@if($data->sectionCheck('default_background'))
            <li><a href="{{ route('admin-vendor-color') }}"><span>{{ __('Default Background') }}</span></a></li>
		@endif
		@if($data->sectionCheck('vendor_verification'))
             <li>
        <a href="#vendor1" class="dropdown_level_3">{{ __('Vendor Verifications') }}</a>
        <ul class="list-unstyled" id="vendor1">
            <li><a href="{{ route('admin-vr-index') }}"><span>{{ __('All Verifications') }}</span></a></li>
            <li><a href="{{ route('admin-vr-pending') }}"><span>{{ __('Pending Verifications') }}</span></a></li>
        </ul>
    </li>
	@endif
	@if($data->sectionCheck('vendor_subscription_plans'))
        <li><a href="{{ route('admin-subscription-index') }}" class=" wave-effect">{{ __('Vendor Subscription Plans') }}</a></li>
	@endif
        </ul>
    </li>
	
    <li>
        <a href="#menu3" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false">
            <i class="icofont-user"></i>{{ __('Customers') }}
        </a>
        <ul class="collapse list-unstyled" id="menu3" data-parent="#accordion">
		@if($data->sectionCheck('customer_list'))
            <li><a href="{{ route('admin-user-index') }}"><span>{{ __('Customers List') }}</span></a></li>
		@endif
		@if($data->sectionCheck('customer_withdraw'))
            <li><a href="{{ route('admin-withdraw-index') }}"><span>{{ __('Withdraws') }}</span></a></li>
		@endif
		@if($data->sectionCheck('customer_default_image'))
            <li><a href="{{ route('admin-user-image') }}"><span>{{ __('Customer Default Image') }}</span></a></li>
		@endif
		@if($data->sectionCheck('customer_enquiry'))
            <li><a href="{{ route('admin-customenquiry-index') }}">{{ __('Customer Enquiry') }}</a></li>
		@endif
		@if($data->sectionCheck('subscriber'))
            <li><a href="{{ route('admin-subs-index') }}" class=" wave-effect">{{ __('Subscribers') }}</a>
		@endif
    </li>
        </ul>
    </li>
       <li>
        <a href="#users" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false"><i class="fas fa-user-tag"></i>{{ __('Users') }}</a>
        <ul class="collapse list-unstyled" id="users" data-parent="#accordion" >
		@if($data->sectionCheck('manage_staffs'))
         <li><a href="{{ route('admin-staff-index') }}" class=" wave-effect">{{ __('Manage Staffs') }}</a></li>
	 @endif
	 @if($data->sectionCheck('manage_roles'))
        <li><a href="{{ route('admin-role-index') }}" class=" wave-effect">{{ __('Manage Roles') }}</a></li>
	@endif
        </ul>
    </li>
	 <li>
        <a href="#analytic" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false"><i class="fas fa-user-tag"></i>{{ __('Data Analytic ') }}</a>
        <ul class="collapse list-unstyled" id="analytic" data-parent="#accordion" >
	@if($data->sectionCheck('overview'))
         <li><a href="{{ route('admin.overview') }}" class=" wave-effect">{{ __('Overview ') }}</a></li>
	@endif
	@if($data->sectionCheck('anal_orders'))
        <li><a href="{{ route('admin.orderrecord') }}" class=" wave-effect">{{ __('Orders') }}</a></li>
	@endif
	@if($data->sectionCheck('refund'))
		<li><a href="{{ route('admin.refundrecord') }}" class=" wave-effect">{{ __('Refund') }}</a></li>
	@endif
	@if($data->sectionCheck('revanue'))
		<li><a href="{{ route('admin.revenue') }}" class=" wave-effect">{{ __('Revenue') }}</a></li>
	@endif
    @if($data->sectionCheck('product'))	
		<li><a href="{{ route('admin.productrecord') }}" class=" wave-effect">{{ __('Product') }}</a></li>
	@endif
	@if($data->sectionCheck('vendor_commision_reports'))
		<li><a href="{{ route('admin.analyticrecord') }}" class=" wave-effect">{{ __('Vendor Commission Reports') }}</a></li>
	@endif
        </ul>
    </li>
	<!--li><a href="{{ route('admin.record') }}"><i class="icofont-chat"></i>{{ __('Reports') }}</a></li-->
   <!-- <li>
        <a href="#menu4" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false"><i class="icofont-speech-comments"></i>{{ __('Product Discussion') }}</a>
        <ul class="collapse list-unstyled" id="menu4" data-parent="#accordion">            
            <li><a href="{{ route('admin-comment-index') }}"><span>{{ __('Comments') }}</span></a></li>
            <li><a href="{{ route('admin-report-index') }}"><span>{{ __('Reports') }}</span></a></li>
        </ul>
    </li>-->
 <li>
        <a href="#general" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false"><i class="fas fa-cogs"></i>{{ __('Settings') }}</a>
        <ul class="collapse list-unstyled" id="general" data-parent="#accordion">
		@if($data->sectionCheck('set_coupons'))
            <li><a href="{{ route('admin-coupon-index') }}" class=" wave-effect">{{ __('Set Coupons') }}</a></li>
		@endif
		@if($data->sectionCheck('general_settings'))
            <li>
        <a href="#general"  class="dropdown_level_3">{{ __('General Settings') }}</a>
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
	@if($data->sectionCheck('home_page_settings'))
      <li>
        <a href="#homepage"  class="dropdown_level_3">{{ __('Home Page Settings') }}</a>
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
	@if($data->sectionCheck('menu_page_settings'))
     <li>
        <a href="#menu" class="dropdown_level_3">{{ __('Menu Page Settings') }}</a>
        <ul class="list-unstyled" id="menu">
            <li><a href="{{ route('admin-faq-index') }}"><span>{{ __('FAQ Page') }}</span></a></li>
            <li><a href="{{ route('admin-ps-contact') }}"><span>{{ __('Contact Us Page') }}</span></a></li>
            <li><a href="{{ route('admin-page-index') }}"><span>{{ __('Other Pages') }}</span></a></li>
        </ul>
    </li>
	@endif
	@if($data->sectionCheck('email_settings'))
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
	@if($data->sectionCheck('payment_settings'))
       <li>
        <a href="#payments" class="dropdown_level_3">{{ __('Payment Settings') }}</a>
        <ul class="list-unstyled" id="payments">
            <li><a href="{{route('admin-gs-payments')}}"><span>{{__('Payment Information')}}</span></a></li>
            <li><a href="{{route('admin-payment-index')}}"><span>{{ __('Payment Gateways') }}</span></a></li>
            <li><a href="{{route('admin-currency-index')}}"><span>{{ __('Currencies') }}</span></a></li>
        </ul>
    </li>
	@endif
	@if($data->sectionCheck('social_settings'))
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
	@if($data->sectionCheck('language_settings'))
   <li>
        <a href="#langs" class="dropdown_level_3">{{ __('Language Settings') }}</a>
        <ul class=" list-unstyled" id="langs">
                <li><a href="{{route('admin-lang-index')}}"><span>{{ __('Website Language') }}</span></a></li>
                <li><a href="{{route('admin-tlang-index')}}"><span>{{ __('Admin Panel Language') }}</span></a></li>
        </ul>
    </li>
	@endif
	@if($data->sectionCheck('seo_tools'))
    <li>
        <a href="#seoTools" class="dropdown_level_3">{{ __('SEO Tools') }}</a>
        <ul class="list-unstyled" id="seoTools">
            <li><a href="{{ route('admin-prod-popular',30) }}"><span>{{ __('Popular Products') }}</span></a></li>
            <li><a href="{{ route('admin-seotool-analytics') }}"><span>{{ __('Google Analytics') }}</span></a></li>
            <li><a href="{{ route('admin-seotool-keywords') }}"><span>{{ __('Website Meta Keywords') }}</span></a></li>
        </ul>
    </li>
	@endif
        </ul>
    </li>
  <!--  <li><a href="{{ route('admin-searchresult-index') }}" class=" wave-effect"><i class="fas fa-percentage"></i>{{ __('Search Result index') }}</a></li>-->
 <!--   <li>
        <a href="#blog" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false">
            <i class="fas fa-fw fa-newspaper"></i>{{ __('Blog') }}
        </a>
        <ul class="collapse list-unstyled" id="blog" data-parent="#accordion">
            <li><a href="{{ route('admin-cblog-index') }}"><span>{{ __('Categories') }}</span></a></li>
            <li><a href="{{ route('admin-blog-index') }}"><span>{{ __('Posts') }}</span></a></li>
        </ul>
    </li>
-->
  <!--  <li><a href="{{ route('admin-notify-index') }}" class=" wave-effect"><i class="fas fa-users-cog mr-2"></i>{{ __('Notify') }}</a>
    </li>-->
         <li>
        <a href="#system" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false"><i class="fas fa-sync"></i>{{ __('System') }}</a>
        <ul class="collapse list-unstyled" id="system" data-parent="#accordion" >
	@if($data->sectionCheck('clear_cache'))
         <li><a href="{{ route('admin-cache-clear') }}" class=" wave-effect">{{ __('Clear Cache') }}</a></li>
	 @endif
	 @if($data->sectionCheck('generate_backup'))
         <li><a href="{{route('admin-generate-backup')}}"> {{ __('Generate Backup') }}</a></li>
	 @endif
        </ul>
    </li>
	  <li>
        <a href="#raisedispute" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false"><i class="fas fa-sync"></i>{{ __('Refunds') }}</a>
        <ul class="collapse list-unstyled" id="raisedispute" data-parent="#accordion" >
		@if($data->sectionCheck('create_refund'))
           <li><a href="{{route('admin-raise-dispute')}}"> {{ __('Create Refund') }}</a></li>
	   @endif
	   @if($data->sectionCheck('pending_refund'))
		   <li><a href="{{route('admin-open-dispute')}}"> {{ __('Pending Refunds') }}</a></li>
	   @endif
	   @if($data->sectionCheck('refunds_paid'))
		   <li><a href="{{route('admin-resolved-dispute')}}"> {{ __('Refunds Paid') }}</a></li>
	   @endif
	   @if($data->sectionCheck('cancelled_refunds'))
		   <li><a href="{{route('admin-decline-dispute')}}"> {{ __('Cancelled Refunds') }}</a></li>
       @endif	   
        </ul>
    </li>
	 <li>
        <a href="#debitnote" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false"><i class="fas fa-sync"></i>{{ __('Debit Note') }}</a>
        <ul class="collapse list-unstyled" id="debitnote" data-parent="#accordion" >
		@if($data->sectionCheck('debit_note'))
           <li><a href="{{route('admin-debitnote-list')}}"> {{ __('Debit Note') }}</a></li>
	    @endif
	   @if($data->sectionCheck('unsettle_note'))
		   <li><a href="{{route('admin-open-debit')}}"> {{ __('Unsettle Note') }}</a></li>
	    @endif
	   @if($data->sectionCheck('settle_note'))
		   <li><a href="{{route('admin-resolved-debit')}}"> {{ __('Settle Note') }}</a></li>
	    @endif
	
        </ul>
    </li>
	 <li>
        <a href="#crditnote" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false"><i class="fas fa-sync"></i>{{ __('Credit Note') }}</a>
        <ul class="collapse list-unstyled" id="crditnote" data-parent="#accordion" >
		@if($data->sectionCheck('credit_note'))
           <li><a href="{{route('admin-creditnote-list')}}"> {{ __('Credit Note') }}</a></li>
	    @endif
	   @if($data->sectionCheck('cunsettle_note'))
		   <li><a href="{{route('admin-open-credit')}}"> {{ __('Unsettle Note') }}</a></li>
	    @endif
	   @if($data->sectionCheck('csettle_note'))
		   <li><a href="{{route('admin-resolved-credit')}}"> {{ __('Settle Note') }}</a></li>
	    @endif
	 
        </ul>
    </li>
	<li>
        <a href="#exchanged" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false"><i class="fas fa-sync"></i>{{ __('Exchange') }}</a>
        <ul class="collapse list-unstyled" id="exchanged" data-parent="#accordion" >
		@if($data->sectionCheck('add_exchange'))
           <li><a href="{{route('admin-order-exchange')}}"> {{ __('Add Exchange') }}</a></li>
	    @endif
	   @if($data->sectionCheck('shipped_exchange'))
		   <li><a href="{{route('admin-ship-exchange')}}"> {{ __('Shipped Exchange') }}</a></li>
	    @endif
	   @if($data->sectionCheck('pending_exchange'))
		   <li><a href="{{route('admin-open-exchange')}}"> {{ __('Pending Exchange') }}</a></li>
	    @endif
	   @if($data->sectionCheck('delivered_exchange'))
		 <li><a href="{{route('admin-resolved-exchange')}}"> {{ __('Delivered Exchange') }}</a></li>
	    @endif
		@if($data->sectionCheck('not_delivered_exchange'))
		<li><a href="{{route('admin-notdelivered-exchange')}}"> {{ __('Notdelivered Exchange') }}</a></li>
		@endif
		@if($data->sectionCheck('decline_exchange'))
		   <li><a href="{{route('admin-decline-exchange')}}"> {{ __('Decline Exchange') }}</a></li>
        @endif	   
        </ul>
    </li>
	<li>
        <a href="#rtod" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false"><i class="fas fa-sync"></i>{{ __('Rto') }}</a>
        <ul class="collapse list-unstyled" id="rtod" data-parent="#accordion" >
		@if($data->sectionCheck('add_rto'))
           <li><a href="{{route('admin-order-rto')}}"> {{ __('Add Rto') }}</a></li>
	    @endif
	    @if($data->sectionCheck('shipped_rto'))
		   <li><a href="{{route('admin-ship-rto')}}"> {{ __('Shipped Rto') }}</a></li>
	    @endif
	   @if($data->sectionCheck('pending_rto'))
		   <li><a href="{{route('admin-open-rto')}}"> {{ __('Pending Rto') }}</a></li>
	    @endif
	   @if($data->sectionCheck('delivered_rto'))
		 <li><a href="{{route('admin-resolved-rto')}}"> {{ __('Delivered Rto') }}</a></li>
	    @endif
		@if($data->sectionCheck('not_delivered_rto'))
		<li><a href="{{route('admin-notdelivered-rto')}}"> {{ __('Notdelivered Rto') }}</a></li>
		@endif
		@if($data->sectionCheck('decline_rto'))
		   <li><a href="{{route('admin-decline-rto')}}"> {{ __('Decline Rto') }}</a></li>
          @endif
        </ul>
    </li>
	
	<li>
        <a href="#disputedata" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false"><i class="fas fa-sync"></i>{{ __('Dispute') }}</a>
        <ul class="collapse list-unstyled" id="disputedata" data-parent="#accordion" >
		@if($data->sectionCheck('add_dispute'))
           <li><a href="{{route('admin-order-disputes')}}"> {{ __('Add Dispute') }}</a></li>
	    @endif	    
	   @if($data->sectionCheck('pending_dispute'))
		   <li><a href="{{route('admin-open-disputes')}}"> {{ __('Pending Dispute') }}</a></li>
	    @endif
        @if($data->sectionCheck('complete_dispute'))
		   <li><a href="{{route('admin-resolved-disputeds')}}"> {{ __('Complete Dispute') }}</a></li>
	    @endif		
        </ul>
    </li>
	<li>
        <a href="#couponed" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false"><i class="fas fa-sync"></i>{{ __('Coupon') }}</a>
        <ul class="collapse list-unstyled" id="couponed" data-parent="#accordion" >
		@if($data->sectionCheck('coupon'))
           <li><a href="{{route('admin-coupon-code')}}"> {{ __('Coupon') }}</a></li>
	   @endif
	   @if($data->sectionCheck('list_coupon'))
		   <li><a href="{{route('admin-coupon-alllist')}}"> {{ __('List Coupon') }}</a></li>
	   @endif
	   @if($data->sectionCheck('approval_coupon'))
		   <li><a href="{{route('admin-coupon-approvallist')}}"> {{ __('Approval Coupon') }}</a></li>
	   @endif
	   @if($data->sectionCheck('reject_coupon'))
           <li><a href="{{route('admin-coupon-rejectlist')}}"> {{ __('Reject Coupon') }}</a></li>
       @endif	   
        </ul>
    </li>
	@else
	
	
	
		        <li>
        <a href="#menu2" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false"><i class="icofont-cart"></i>{{ __('Products') }}</a>
        <ul class="collapse list-unstyled" id="menu2" data-parent="#accordion">
            <li><a href="{{ route('admin-prod-physical-create') }}"><span>{{ __('Add New Product') }}</span></a></li>
            <li><a href="{{ route('admin-prod-index') }}"><span>{{ __('All Products') }}</span></a></li>
			<li><a href="{{ route('admin-prod-simpleproduct') }}"><span>{{ __('Simple Products') }}</span></a></li>
			<li><a href="{{ route('admin-prod-variationproduct') }}"><span>{{ __('Variation Products') }}</span></a></li>
            <li><a href="{{ route('admin-prod-deactive') }}"><span>{{ __('Deactivated Product') }}</span></a></li>
          <!--  <li><a href="{{ route('admin-prod-catalog-index') }}"><span>{{ __('Product Catalogs') }}</span></a></li>   --> 
             <li>
        <a href="#menu5" class="dropdown_level_3">{{ __('Manage Categories') }} </a>
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
    
    
     <li><a href="{{ route('admin-prod-import') }}">{{ __('Bulk Product Upload') }}</a></li>
     
     <li><a href="{{ route('admin-reviews-index') }}">{{ __('Product Reviews') }}</a></li>
     
      <li><a href="{{ route('admin-media-index') }}">{{ __('Media') }}</a></li>
    
        </ul>
    </li>
    
    <li>
        <a href="#order" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false"><i class="fas fa-hand-holding-usd"></i>{{ __('Orders') }}</a>
        <ul class="collapse list-unstyled" id="order" data-parent="#accordion" >
            <li><a href="{{route('admin-order-index')}}"> {{ __('All Orders') }}</a></li>
            <li><a href="{{route('admin-order-pending')}}"> {{ __('Pending Orders') }}</a></li>
            <li><a href="{{route('admin-order-processing')}}"> {{ __('Processing Orders') }}</a></li>
            <li><a href="{{route('admin-order-shipping')}}"> {{ __('Shipped Orders') }}</a></li>
            <li><a href="{{route('admin-order-completed')}}"> {{ __('Completed Orders') }}</a></li>
            <li><a href="{{route('admin-order-declined')}}"> {{ __('Declined Orders') }}</a></li>
			<li><a href="{{route('admin-order-refundod')}}"> {{ __('Refund Orders') }}</a></li>
			<li><a href="{{route('admin-order-ordertracks')}}"> {{ __('Download Order Track') }}</a></li>
            <li>
        <a href="#msg" class="dropdown_level_3">{{ __('Tickets & Disputes') }}</a>
        <ul class="list-unstyled" id="msg">
            <li><a href="{{ route('admin-message-index') }}"><span>{{ __('Tickets') }}</span></a></li>
            <li><a href="{{ route('admin-message-dispute') }}"><span>{{ __('Disputes') }}</span></a></li>
        </ul>
    </li>

        </ul>
    </li>
	 <!--li>
        <a href="#refund" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false"><i class="fas fa-hand-holding-usd"></i>{{ __('Refund Orders') }}</a>
        <ul class="collapse list-unstyled" id="refund" data-parent="#accordion" >
            <li><a href="{{route('admin-refund-index')}}"> {{ __('All Refund Orders') }}</a></li>
            
        </ul>
    </li-->

	
    
   
   
        <li>
        <a href="#vendor" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false"><i class="icofont-ui-user-group"></i>{{ __('Vendors') }}</a>
        <ul class="collapse list-unstyled" id="vendor" data-parent="#accordion">
            <li><a href="{{ route('admin-vendor-index') }}"><span>{{ __('Vendors List') }}</span></a></li>
			<li><a href="{{ route('admin-vendor-register') }}"><span>{{ __('Vendors Registration') }}</span></a></li>
            <li><a href="{{ route('admin-vendor-withdraw-index') }}"><span>{{ __('Withdrawals') }}</span></a></li>
			<li><a href="{{ route('admin-vendor-adminapprovelist-index') }}"><span>{{ __('Admin Approve List') }}</span></a></li>
            <li><a href="{{ route('admin-vendor-subs') }}"><span>{{ __('Vendor Subscriptions') }}</span></a></li>
            <li><a href="{{ route('admin-vendor-color') }}"><span>{{ __('Default Background') }}</span></a></li>
             <li>
        <a href="#vendor1" class="dropdown_level_3">{{ __('Vendor Verifications') }}</a>
        <ul class="list-unstyled" id="vendor1">
            <li><a href="{{ route('admin-vr-index') }}"><span>{{ __('All Verifications') }}</span></a></li>
            <li><a href="{{ route('admin-vr-pending') }}"><span>{{ __('Pending Verifications') }}</span></a></li>
        </ul>
    </li>
    
        <li><a href="{{ route('admin-subscription-index') }}" class=" wave-effect">{{ __('Vendor Subscription Plans') }}</a></li>

        </ul>
    </li>

    
    
     
     
    <li>
        <a href="#menu3" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false">
            <i class="icofont-user"></i>{{ __('Customers') }}
        </a>
        <ul class="collapse list-unstyled" id="menu3" data-parent="#accordion">
            <li><a href="{{ route('admin-user-index') }}"><span>{{ __('Customers List') }}</span></a></li>
            <li><a href="{{ route('admin-withdraw-index') }}"><span>{{ __('Withdraws') }}</span></a></li>
			
            <li><a href="{{ route('admin-user-image') }}"><span>{{ __('Customer Default Image') }}</span></a></li>
            
            <li><a href="{{ route('admin-customenquiry-index') }}">{{ __('Customer Enquiry') }}</a></li>
            
            <li><a href="{{ route('admin-subs-index') }}" class=" wave-effect">{{ __('Subscribers') }}</a>
    </li>
            
        </ul>
    </li>


       <li>
        <a href="#users" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false"><i class="fas fa-user-tag"></i>{{ __('Users') }}</a>
        <ul class="collapse list-unstyled" id="users" data-parent="#accordion" >
         <li><a href="{{ route('admin-staff-index') }}" class=" wave-effect">{{ __('Manage Staffs') }}</a></li>
        <li><a href="{{ route('admin-role-index') }}" class=" wave-effect">{{ __('Manage Roles') }}</a></li>
        </ul>
    </li>
	 <li>
        <a href="#analytic" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false"><i class="fas fa-user-tag"></i>{{ __('Data Analytic ') }}</a>
        <ul class="collapse list-unstyled" id="analytic" data-parent="#accordion" >
         <li><a href="{{ route('admin.overview') }}" class=" wave-effect">{{ __('Overview ') }}</a></li>
        <li><a href="{{ route('admin.orderrecord') }}" class=" wave-effect">{{ __('Orders') }}</a></li>
		<li><a href="{{ route('admin.refundrecord') }}" class=" wave-effect">{{ __('Refund') }}</a></li>
		<li><a href="{{ route('admin.revenue') }}" class=" wave-effect">{{ __('Revenue') }}</a></li>		
		<li><a href="{{ route('admin.productrecord') }}" class=" wave-effect">{{ __('Product') }}</a></li>
		<li><a href="{{ route('admin.analyticrecord') }}" class=" wave-effect">{{ __('Vendor Commission Reports') }}</a></li>
        </ul>
    </li>
    

   
	<!--li><a href="{{ route('admin.record') }}"><i class="icofont-chat"></i>{{ __('Reports') }}</a></li-->
    
   

   <!-- <li>
        <a href="#menu4" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false"><i class="icofont-speech-comments"></i>{{ __('Product Discussion') }}</a>
        <ul class="collapse list-unstyled" id="menu4" data-parent="#accordion">            
            <li><a href="{{ route('admin-comment-index') }}"><span>{{ __('Comments') }}</span></a></li>
            <li><a href="{{ route('admin-report-index') }}"><span>{{ __('Reports') }}</span></a></li>
        </ul>
    </li>-->



 <li>
        <a href="#general" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false"><i class="fas fa-cogs"></i>{{ __('Settings') }}</a>
        <ul class="collapse list-unstyled" id="general" data-parent="#accordion">
            <li><a href="{{ route('admin-coupon-index') }}" class=" wave-effect">{{ __('Set Coupons') }}</a></li>
            
            <li>
        <a href="#general"  class="dropdown_level_3">{{ __('General Settings') }}</a>
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
    
    
      <li>
        <a href="#homepage"  class="dropdown_level_3">{{ __('Home Page Settings') }}</a>
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
    
    
    
     <li>
        <a href="#menu" class="dropdown_level_3">{{ __('Menu Page Settings') }}</a>
        <ul class="list-unstyled" id="menu">
            <li><a href="{{ route('admin-faq-index') }}"><span>{{ __('FAQ Page') }}</span></a></li>
            <li><a href="{{ route('admin-ps-contact') }}"><span>{{ __('Contact Us Page') }}</span></a></li>
            <li><a href="{{ route('admin-page-index') }}"><span>{{ __('Other Pages') }}</span></a></li>
        </ul>
    </li>
    
    
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
    
    
       <li>
        <a href="#payments" class="dropdown_level_3">{{ __('Payment Settings') }}</a>
        <ul class="list-unstyled" id="payments">
            <li><a href="{{route('admin-gs-payments')}}"><span>{{__('Payment Information')}}</span></a></li>
            <li><a href="{{route('admin-payment-index')}}"><span>{{ __('Payment Gateways') }}</span></a></li>
            <li><a href="{{route('admin-currency-index')}}"><span>{{ __('Currencies') }}</span></a></li>
        </ul>
    </li>
    
    
    
    
    
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
   <li>
        <a href="#langs" class="dropdown_level_3">{{ __('Language Settings') }}</a>
        <ul class=" list-unstyled" id="langs">
                <li><a href="{{route('admin-lang-index')}}"><span>{{ __('Website Language') }}</span></a></li>
                <li><a href="{{route('admin-tlang-index')}}"><span>{{ __('Admin Panel Language') }}</span></a></li>
        </ul>
    </li>
    <li>
        <a href="#seoTools" class="dropdown_level_3">{{ __('SEO Tools') }}</a>
        <ul class="list-unstyled" id="seoTools">
            <li><a href="{{ route('admin-prod-popular',30) }}"><span>{{ __('Popular Products') }}</span></a></li>
            <li><a href="{{ route('admin-seotool-analytics') }}"><span>{{ __('Google Analytics') }}</span></a></li>
            <li><a href="{{ route('admin-seotool-keywords') }}"><span>{{ __('Website Meta Keywords') }}</span></a></li>
        </ul>
    </li>
    
    
    
    
        </ul>
    </li>
    

    
  <!--  <li><a href="{{ route('admin-searchresult-index') }}" class=" wave-effect"><i class="fas fa-percentage"></i>{{ __('Search Result index') }}</a></li>-->
     
 <!--   <li>
        <a href="#blog" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false">
            <i class="fas fa-fw fa-newspaper"></i>{{ __('Blog') }}
        </a>
        <ul class="collapse list-unstyled" id="blog" data-parent="#accordion">
            <li><a href="{{ route('admin-cblog-index') }}"><span>{{ __('Categories') }}</span></a></li>
            <li><a href="{{ route('admin-blog-index') }}"><span>{{ __('Posts') }}</span></a></li>
        </ul>
    </li>
-->
    
    

  

   
    
 
   
    
  <!--  <li><a href="{{ route('admin-notify-index') }}" class=" wave-effect"><i class="fas fa-users-cog mr-2"></i>{{ __('Notify') }}</a>
    </li>-->
    
 
    
         <li>
        <a href="#system" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false"><i class="fas fa-sync"></i>{{ __('System') }}</a>
        <ul class="collapse list-unstyled" id="system" data-parent="#accordion" >
         <li><a href="{{ route('admin-cache-clear') }}" class=" wave-effect">{{ __('Clear Cache') }}</a></li>
         <li><a href="{{route('admin-generate-backup')}}"> {{ __('Generate Backup') }}</a></li>
        </ul>
    </li>
	
	  <li>
        <a href="#raisedispute" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false"><i class="fas fa-sync"></i>{{ __('Refunds') }}</a>
        <ul class="collapse list-unstyled" id="raisedispute" data-parent="#accordion" >
           <li><a href="{{route('admin-raise-dispute')}}"> {{ __('Create Refund') }}</a></li>
		   <li><a href="{{route('admin-open-dispute')}}"> {{ __('Pending Refunds') }}</a></li>
		   <li><a href="{{route('admin-resolved-dispute')}}"> {{ __('Refunds Paid') }}</a></li>
		   <li><a href="{{route('admin-decline-dispute')}}"> {{ __('Cancelled Refunds') }}</a></li>		  
        </ul>
    </li>
	 <li>
        <a href="#debitnote" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false"><i class="fas fa-sync"></i>{{ __('Debit Note') }}</a>
        <ul class="collapse list-unstyled" id="debitnote" data-parent="#accordion" >
           <li><a href="{{route('admin-debitnote-list')}}"> {{ __('Debit Note') }}</a></li>
		   <li><a href="{{route('admin-open-debit')}}"> {{ __('Unsettle Note') }}</a></li>
		   <li><a href="{{route('admin-resolved-debit')}}"> {{ __('Settle Note') }}</a></li>
		   <li><a href="{{route('admin-decline-debit')}}"> {{ __('Cancelled Note') }}</a></li>
		  
        </ul>
    </li>
	 <li>
        <a href="#crditnote" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false"><i class="fas fa-sync"></i>{{ __('Credit Note') }}</a>
        <ul class="collapse list-unstyled" id="crditnote" data-parent="#accordion" >
           <li><a href="{{route('admin-creditnote-list')}}"> {{ __('Credit Note') }}</a></li>
		   <li><a href="{{route('admin-open-credit')}}"> {{ __('Unsettle Note') }}</a></li>
		   <li><a href="{{route('admin-resolved-credit')}}"> {{ __('Settle Note') }}</a></li>
		   <li><a href="{{route('admin-decline-credit')}}"> {{ __('Cancelled Note') }}</a></li>
		  
        </ul>
    </li>
	
	<li>
        <a href="#exchanged" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false"><i class="fas fa-sync"></i>{{ __('Exchange') }}</a>
        <ul class="collapse list-unstyled" id="exchanged" data-parent="#accordion" >
           <li><a href="{{route('admin-order-exchange')}}"> {{ __('Add Exchange') }}</a></li>
		   <li><a href="{{route('admin-ship-exchange')}}"> {{ __('Shipped Exchange') }}</a></li>


		   <li><a href="{{route('admin-open-exchange')}}"> {{ __('Pending Exchange') }}</a></li>
		   <li><a href="{{route('admin-resolved-exchange')}}"> {{ __('Delivered Exchange') }}</a></li>
		   		   		   <li><a href="{{route('admin-notdelivered-exchange')}}"> {{ __('Notdelivered Exchange') }}</a></li>
		   <li><a href="{{route('admin-decline-exchange')}}"> {{ __('Decline Exchange') }}</a></li>		  
        </ul>
    </li>
	
	<li>
        <a href="#rtod" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false"><i class="fas fa-sync"></i>{{ __('Rto') }}</a>
        <ul class="collapse list-unstyled" id="rtod" data-parent="#accordion" >
		
           <li><a href="{{route('admin-order-rto')}}"> {{ __('Add Rto') }}</a></li>
	   
		   <li><a href="{{route('admin-ship-rto')}}"> {{ __('Shipped Rto') }}</a></li>
	    
		   <li><a href="{{route('admin-open-rto')}}"> {{ __('Pending Rto') }}</a></li>
	    
		 <li><a href="{{route('admin-resolved-rto')}}"> {{ __('Delivered Rto') }}</a></li>
	    
		<li><a href="{{route('admin-notdelivered-rto')}}"> {{ __('Notdelivered Rto') }}</a></li>
		
		   <li><a href="{{route('admin-decline-rto')}}"> {{ __('Decline Rto') }}</a></li>
          
        </ul>
    </li>
	
	<li>
        <a href="#disputedata" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false"><i class="fas fa-sync"></i>{{ __('Dispute') }}</a>
        <ul class="collapse list-unstyled" id="disputedata" data-parent="#accordion" >		
           <li><a href="{{route('admin-order-disputes')}}"> {{ __('Add Dispute') }}</a></li>  
	       <li><a href="{{route('admin-open-disputes')}}"> {{ __('Pending Dispute') }}</a></li>
		   <li><a href="{{route('admin-resolved-disputeds')}}"> {{ __('Complete Dispute') }}</a></li>
	       
        </ul>
    </li>
	
	<li>
        <a href="#couponed" class="accordion-toggle wave-effect" data-toggle="collapse" aria-expanded="false"><i class="fas fa-sync"></i>{{ __('Coupon') }}</a>
        <ul class="collapse list-unstyled" id="couponed" data-parent="#accordion" >
           <li><a href="{{route('admin-coupon-code')}}"> {{ __('Coupon') }}</a></li>
		   <li><a href="{{route('admin-coupon-alllist')}}"> {{ __('List Coupon') }}</a></li>
		   <li><a href="{{route('admin-coupon-approvallist')}}"> {{ __('Approval Coupon') }}</a></li>
           <li><a href="{{route('admin-coupon-rejectlist')}}"> {{ __('Reject Coupon') }}</a></li>		   
        </ul>
    </li>
@endif