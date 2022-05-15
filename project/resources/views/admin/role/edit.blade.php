@extends('layouts.admin')

@section('content')
            <div class="content-area">
                <div class="mr-breadcrumb">
                    <div class="row">
                      <div class="col-lg-12">
                          <h4 class="heading">{{ __('Edit Role') }} <a class="add-btn" href="{{route('admin-role-index')}}"><i class="fas fa-arrow-left"></i> {{ __('Back') }}</a></h4>
                          <ul class="links">
                            <li>
                              <a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }} </a>
                            </li>
                            <li>
                              <a href="{{ route('admin-role-index') }}">{{ __('Manage Roles') }}</a>
                            </li>
                            <li>
                              <a href="{{ route('admin-role-edit',$data->id) }}">{{ __('Edit Role') }}</a>
                            </li>
                          </ul>
                      </div>
                    </div>
                  </div>
              <div class="add-product-content1">
                <div class="row">
                  <div class="col-lg-12">
                    <div class="product-description">
                      <div class="body-area">
                          <div class="gocover" style="background: url({{asset('assets/images/'.$gs->admin_loader)}}) no-repeat scroll center center rgba(45, 45, 45, 0.5);"></div>
                      <form id="geniusform" action="{{route('admin-role-update',$data->id)}}" method="POST" enctype="multipart/form-data">
                          {{csrf_field()}}
                          @include('includes.admin.form-both') 

                        <div class="row">
                          <div class="col-lg-4">
                            <div class="left-area">
                                <h4 class="heading">{{ __("Name") }} *</h4>
                                <p class="sub-heading">{{ __('(In Any Language)') }}</p>
                            </div>
                          </div>
                          <div class="col-lg-7">
                            <input type="text" class="input-field" name="name" placeholder="{{ __('Name') }}" value="{{$data->name}}" required="">
                          </div>
                        </div>


                        <hr>
                        <h5 class="text-center">{{ __('Permissions') }}</h5>
                        <hr>
						<hr>
                        <h6>Orders</h6>
                        
                        <hr>

                        <div class="row justify-content-center">
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label">{{ __('Orders') }} *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="orders" {{ $data->sectionCheck('orders') ? 'checked' : '' }} >
                                <span class="slider round"></span>
                              </label>
                            </div>
                            <div class="col-lg-2"></div>
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label">{{ __(' All Orders') }} *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="all_orders" {{ $data->sectionCheck('all_orders') ? 'checked' : '' }}>
                                <span class="slider round"></span>
                              </label>
                            </div>
                        </div>
						<div class="row justify-content-center">
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label">{{ __('Pending Orders') }} *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="pending_orders" {{ $data->sectionCheck('pending_orders') ? 'checked' : '' }}  >
                                <span class="slider round"></span>
                              </label>
                            </div>
                            <div class="col-lg-2"></div>
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label">{{ __('Processing Orders') }} *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="processing_orders" {{ $data->sectionCheck('processing_orders') ? 'checked' : '' }}>
                                <span class="slider round"></span>
                              </label>
                            </div>
                        </div>
						<div class="row justify-content-center">
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label">{{ __('Shipped Orders') }} *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="shipped_orders" {{ $data->sectionCheck('shipped_orders') ? 'checked' : '' }} >
                                <span class="slider round"></span>
                              </label>
                            </div>
                            <div class="col-lg-2"></div>
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label">{{ __('Completed Orders') }} *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="completed_orders" {{ $data->sectionCheck('completed_orders') ? 'checked' : '' }}>
                                <span class="slider round"></span>
                              </label>
                            </div>
                        </div>
						<div class="row justify-content-center">
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label">{{ __('Declined Orders') }} *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="declined_orders" {{ $data->sectionCheck('declined_orders') ? 'checked' : '' }} >
                                <span class="slider round"></span>
                              </label>
                            </div>
                            <div class="col-lg-2"></div>
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label">{{ __('Refund Orders') }} *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="refund_orders" {{ $data->sectionCheck('refund_orders') ? 'checked' : '' }}>
                                <span class="slider round"></span>
                              </label>
                            </div>
                        </div>
                       <div class="row justify-content-center">
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label">{{ __('Download Order Track') }} *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="download_order_track" {{ $data->sectionCheck('download_order_track') ? 'checked' : '' }} >
                                <span class="slider round"></span>
                              </label>
                            </div>
                            <div class="col-lg-2"></div>
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label">{{ __('Tickets & Disputes') }} *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="ticket_dispute" {{ $data->sectionCheck('ticket_dispute') ? 'checked' : '' }}>
                                <span class="slider round"></span>
                              </label>
                            </div>
                        </div> 						
						<hr>
                        <h6>Products</h6>
                        
                        <hr>
                        
                        <div class="row justify-content-center">
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label">{{ __('Add New Product') }} *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="add_new_product" {{ $data->sectionCheck('add_new_product') ? 'checked' : '' }} >
                                <span class="slider round"></span>
                              </label>
                            </div>
                            <div class="col-lg-2"></div>
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label">{{ __('All Products') }} *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="all_products" {{ $data->sectionCheck('all_products') ? 'checked' : '' }}>
                                <span class="slider round"></span>
                              </label>
                            </div>
                        </div> 
                        
                       
                        
                          
                          <div class="row justify-content-center">
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label">{{ __('Simple Products') }} *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="simple_products" {{ $data->sectionCheck('simple_products') ? 'checked' : '' }} >
                                <span class="slider round"></span>
                              </label>
                            </div>
                            <div class="col-lg-2"></div>
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label">{{ __('Variation Products') }} *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="variation_products" {{ $data->sectionCheck('variation_products') ? 'checked' : '' }}>
                                <span class="slider round"></span>
                              </label>
                            </div>
                        </div> 
                        
                        
                        
                           <div class="row justify-content-center">
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label">{{ __('Deactiavted Product') }} *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="deactivated_product" {{ $data->sectionCheck('deactivated_product') ? 'checked' : '' }} >
                                <span class="slider round"></span>
                              </label>
                            </div>
                            <div class="col-lg-2"></div>
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label">{{ __('Manage categories') }} *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="manage_categories" {{ $data->sectionCheck('manage_categories') ? 'checked' : '' }}>
                                <span class="slider round"></span>
                              </label>
                            </div>
                        </div> 
                        
                        
                        
                          <div class="row justify-content-center">
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label">{{ __('Bulk Product Upload') }} *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="bulk_product_upload" {{ $data->sectionCheck('bulk_product_upload') ? 'checked' : '' }} >
                                <span class="slider round"></span>
                              </label>
                            </div>
                            <div class="col-lg-2"></div>
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label">{{ __('Product Reviews') }} *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="product_reviews" {{ $data->sectionCheck('product_reviews') ? 'checked' : '' }}>
                                <span class="slider round"></span>
                              </label>
                            </div>
                        </div> 
                        
                        
                        
                          <div class="row justify-content-center">
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label">{{ __('Media') }} *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="media" {{ $data->sectionCheck('media') ? 'checked' : '' }} >
                                <span class="slider round"></span>
                              </label>
                            </div>
                            
                            <div class="col-lg-2"></div>
                            <div class="col-lg-4 d-flex justify-content-between">
                              
                              
                             
                             
                            </div>
                        </div> 
                        
                        
                        
                        
                        
                        <hr>
                        <h6>Vendors</h6>
                        
                        <hr>
                        
                        <div class="row justify-content-center">
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label">{{ __('Vendor List') }} *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="vendor_list" {{ $data->sectionCheck('vendor_list') ? 'checked' : '' }} >
                                <span class="slider round"></span>
                              </label>
                            </div>
                            <div class="col-lg-2"></div>
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label">{{ __('Vendor Registration') }} *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="vendor_registration" {{ $data->sectionCheck('vendor_registration') ? 'checked' : '' }}>
                                <span class="slider round"></span>
                              </label>
                            </div>
                        </div> 
                        
                       
                
                          
                          <div class="row justify-content-center">
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label">{{ __('Withdrawls') }} *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="withdrawls" {{ $data->sectionCheck('withdrawls') ? 'checked' : '' }} >
                                <span class="slider round"></span>
                              </label>
                            </div>
                            <div class="col-lg-2"></div>
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label">{{ __('Admin Approve List') }} *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="admin_approve_list" {{ $data->sectionCheck('admin_approve_list') ? 'checked' : '' }}>
                                <span class="slider round"></span>
                              </label>
                            </div>
                        </div> 
                        
                        
                        
                           <div class="row justify-content-center">
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label">{{ __('Vendor Subscription') }} *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="vendor_subscription" {{ $data->sectionCheck('vendor_subscription') ? 'checked' : '' }} >
                                <span class="slider round"></span>
                              </label>
                            </div>
                            <div class="col-lg-2"></div>
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label">{{ __('Default Background') }} *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="default_background" {{ $data->sectionCheck('default_background') ? 'checked' : '' }}>
                                <span class="slider round"></span>
                              </label>
                            </div>
                        </div> 
                        
                        
                        
                          <div class="row justify-content-center">
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label">{{ __('Vendor Verifiaction') }} *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="vendor_verification" {{ $data->sectionCheck('vendor_verification') ? 'checked' : '' }} >
                                <span class="slider round"></span>
                              </label>
                            </div>
                            <div class="col-lg-2"></div>
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label">{{ __('Vendor Subscription Plans') }} *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="vendor_subscription_plans" {{ $data->sectionCheck('vendor_subscription_plans') ? 'checked' : '' }}>
                                <span class="slider round"></span>
                              </label>
                            </div>
                        </div> 
                        
                        
                        
                        
                         <hr>
                        <h6>Custumers</h6>
                        
                        <hr>
                        
                        <div class="row justify-content-center">
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label">{{ __('Customer List') }} *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="customer_list" {{ $data->sectionCheck('customer_list') ? 'checked' : '' }} >
                                <span class="slider round"></span>
                              </label>
                            </div>
                            <div class="col-lg-2"></div>
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label">{{ __('Withdraws') }} *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="customer_withdraw" {{ $data->sectionCheck('customer_withdraw') ? 'checked' : '' }}>
                                <span class="slider round"></span>
                              </label>
                            </div>
                        </div> 
                        
                       
                        
                          
                          <div class="row justify-content-center">
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label">{{ __('Customer Default Image') }} *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="customer_default_image" {{ $data->sectionCheck('customer_default_image') ? 'checked' : '' }} >
                                <span class="slider round"></span>
                              </label>
                            </div>
                            <div class="col-lg-2"></div>
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label">{{ __('Customer Enquiry') }} *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="customer_enquiry" {{ $data->sectionCheck('customer_enquiry') ? 'checked' : '' }}>
                                <span class="slider round"></span>
                              </label>
                            </div>
                        </div> 
                        
                        
                        
                           <div class="row justify-content-center">
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label">{{ __('Subscribers') }} *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="subscriber" {{ $data->sectionCheck('subscriber') ? 'checked' : '' }} >
                                <span class="slider round"></span>
                              </label>
                            </div>
                            <div class="col-lg-2"></div>
                            <div class="col-lg-4 d-flex justify-content-between">
                              
                                                          </div>
                        </div>
                        

                        
                         <hr>
                        <h6>Users</h6>
                        
                        <hr>
                        
                        <div class="row justify-content-center">
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label">{{ __('Manage Staffs') }} *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="manage_staffs" {{ $data->sectionCheck('manage_staffs') ? 'checked' : '' }} >
                                <span class="slider round"></span>
                              </label>
                            </div>
                            <div class="col-lg-2"></div>
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label">{{ __('Manage Roles') }} *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="manage_roles" {{ $data->sectionCheck('manage_roles') ? 'checked' : '' }}>
                                <span class="slider round"></span>
                              </label>
                            </div>
                        </div> 
                        
                        
                        
                                                 <hr>
                        <h6>Data Analytic</h6>
                        
                        <hr>
                        
                        <div class="row justify-content-center">
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label">{{ __('Overview') }} *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="overview" {{ $data->sectionCheck('overview') ? 'checked' : '' }} >
                                <span class="slider round"></span>
                              </label>
                            </div>
                            <div class="col-lg-2"></div>
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label">{{ __('Orders') }} *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="anal_orders" {{ $data->sectionCheck('anal_orders') ? 'checked' : '' }}>
                                <span class="slider round"></span>
                              </label>
                            </div>
                        </div> 
                        
                       
                        
                          
                          <div class="row justify-content-center">
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label">{{ __('Refund') }} *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="refund" {{ $data->sectionCheck('refund') ? 'checked' : '' }} >
                                <span class="slider round"></span>
                              </label>
                            </div>
                            <div class="col-lg-2"></div>
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label">{{ __('Revanue') }} *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="revanue" {{ $data->sectionCheck('revanue') ? 'checked' : '' }}>
                                <span class="slider round"></span>
                              </label>
                            </div>
                        </div> 
                        
                        
                        
                           <div class="row justify-content-center">
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label">{{ __('Product') }} *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="product" {{ $data->sectionCheck('product') ? 'checked' : '' }} >
                                <span class="slider round"></span>
                              </label>
                            </div>
                            <div class="col-lg-2"></div>
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label">{{ __('Vendor Commision Reports') }} *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="vendor_commision_reports" {{ $data->sectionCheck('vendor_commision_reports') ? 'checked' : '' }}>
                                <span class="slider round"></span>
                              </label>
                            </div>
                        </div>
                        
                        
                        
                        
                        
                        <hr>
                        <h6>Settings</h6>
                        
                        <hr>
                        
                        <div class="row justify-content-center">
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label">{{ __('Set Coupans') }} *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="set_coupons" {{ $data->sectionCheck('set_coupons') ? 'checked' : '' }} >
                                <span class="slider round"></span>
                              </label>
                            </div>
                            <div class="col-lg-2"></div>
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label">{{ __('General Settings') }} *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="general_settings" {{ $data->sectionCheck('general_settings') ? 'checked' : '' }}>
                                <span class="slider round"></span>
                              </label>
                            </div>
                        </div> 
                        
                       
                        
                          
                          <div class="row justify-content-center">
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label">{{ __('Home Page Settings') }} *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="home_page_settings" {{ $data->sectionCheck('home_page_settings') ? 'checked' : '' }} >
                                <span class="slider round"></span>
                              </label>
                            </div>
                            <div class="col-lg-2"></div>
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label">{{ __('Menu Page Settings') }} *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="menu_page_settings" {{ $data->sectionCheck('menu_page_settings') ? 'checked' : '' }}>
                                <span class="slider round"></span>
                              </label>
                            </div>
                        </div> 
                        
                        
                        
                           <div class="row justify-content-center">
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label">{{ __('Email Settings') }} *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="email_settings" {{ $data->sectionCheck('email_settings') ? 'checked' : '' }} >
                                <span class="slider round"></span>
                              </label>
                            </div>
                            <div class="col-lg-2"></div>
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label">{{ __('Payment Settings') }} *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="payment_settings" {{ $data->sectionCheck('payment_settings') ? 'checked' : '' }}>
                                <span class="slider round"></span>
                              </label>
                            </div>
                        </div> 
                        
                        
                        
                          <div class="row justify-content-center">
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label">{{ __('Social Settings') }} *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="social_settings" {{ $data->sectionCheck('social_settings') ? 'checked' : '' }} >
                                <span class="slider round"></span>
                              </label>
                            </div>
                            <div class="col-lg-2"></div>
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label">{{ __('Language Settings') }} *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="language_settings" {{ $data->sectionCheck('language_settings') ? 'checked' : '' }}>
                                <span class="slider round"></span>
                              </label>
                            </div>
                        </div> 
                        
                        
                                                  <div class="row justify-content-center">
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label">{{ __('Seo Tools') }} *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="seo_tools" {{ $data->sectionCheck('seo_tools') ? 'checked' : '' }} >
                                <span class="slider round"></span>
                              </label>
                            </div>
                            <div class="col-lg-2"></div>
                            <div class="col-lg-4 d-flex justify-content-between">
                              
                              
                            </div>
                        </div>
                        
                        
                        
                        <hr>
                        <h6>System</h6>
                        
                        <hr>
                        
                        <div class="row justify-content-center">
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label">{{ __('Clear Cache') }} *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="clear_cache" {{ $data->sectionCheck('clear_cache') ? 'checked' : '' }} >
                                <span class="slider round"></span>
                              </label>
                            </div>
                            <div class="col-lg-2"></div>
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label">{{ __('Generate Backup') }} *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="generate_backup" {{ $data->sectionCheck('generate_backup') ? 'checked' : '' }}>
                                <span class="slider round"></span>
                              </label>
                            </div>
                        </div> 
                        
                        
                        
                        
                        
                        
                <hr>
                        <h6>Refunds</h6>
                        
                        <hr>
                        
                        <div class="row justify-content-center">
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label">{{ __('Create Refund ') }} *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="create_refund" {{ $data->sectionCheck('create_refund') ? 'checked' : '' }} >
                                <span class="slider round"></span>
                              </label>
                            </div>
                            <div class="col-lg-2"></div>
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label">{{ __('Pending Refund') }} *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="pending_refund" {{ $data->sectionCheck('pending_refund') ? 'checked' : '' }}>
                                <span class="slider round"></span>
                              </label>
                            </div>
                        </div> 
                        
                         <div class="row justify-content-center">
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label">{{ __('Refunds Paid ') }} *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="refunds_paid" {{ $data->sectionCheck('refunds_paid') ? 'checked' : '' }} >
                                <span class="slider round"></span>
                              </label>
                            </div>
                            <div class="col-lg-2"></div>
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label">{{ __('Cancelled Refunds') }} *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="cancelled_refunds" {{ $data->sectionCheck('cancelled_refunds') ? 'checked' : '' }}>
                                <span class="slider round"></span>
                              </label>
                            </div>
                        </div> 
                        
                        
                                        <hr>
                        <h6>Debit Note</h6>
                        
                        <hr>
                        
                        <div class="row justify-content-center">
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label">{{ __('Debit Note ') }} *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="debit_note" {{ $data->sectionCheck('debit_note') ? 'checked' : '' }} >
                                <span class="slider round"></span>
                              </label>
                            </div>
                            <div class="col-lg-2"></div>
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label">{{ __('Unsettle Note') }} *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="unsettle_note" {{ $data->sectionCheck('unsettle_note') ? 'checked' : '' }}>
                                <span class="slider round"></span>
                              </label>
                            </div>
                        </div> 
                        
                         <div class="row justify-content-center">
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label">{{ __('Settle Note') }} *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="settle_note" {{ $data->sectionCheck('settle_note') ? 'checked' : '' }} >
                                <span class="slider round"></span>
                              </label>
                            </div>
                            <div class="col-lg-2"></div>
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label">{{ __('Cancelled Note') }} *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="cancelled_note" {{ $data->sectionCheck('cancelled_note') ? 'checked' : '' }}>
                                <span class="slider round"></span>
                              </label>
                            </div>
                        </div>
                        
                        
                        
                                                                <hr>
                        <h6>Credit Note</h6>
                        
                        <hr>
                        
                        <div class="row justify-content-center">
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label">{{ __('Credit Note ') }} *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="credit_note" {{ $data->sectionCheck('credit_note') ? 'checked' : '' }} >
                                <span class="slider round"></span>
                              </label>
                            </div>
                            <div class="col-lg-2"></div>
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label">{{ __('Unsettle Note') }} *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="cunsettle_note" {{ $data->sectionCheck('cunsettle_note') ? 'checked' : '' }}>
                                <span class="slider round"></span>
                              </label>
                            </div>
                        </div> 
                        
                         <div class="row justify-content-center">
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label">{{ __('Settle Note') }} *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="csettle_note" {{ $data->sectionCheck('csettle_note') ? 'checked' : '' }} >
                                <span class="slider round"></span>
                              </label>
                            </div>
                            <div class="col-lg-2"></div>
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label">{{ __('Cancelled Note') }} *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="ccancelled_note"  {{ $data->sectionCheck('ccancelled_note') ? 'checked' : '' }}>
                                <span class="slider round"></span>
                              </label>
                            </div>
                        </div>
                        
                        
                        
        <hr>
                        <h6>Exchange</h6>
                        
                        <hr>
                        
                        <div class="row justify-content-center">
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label c
							  lass="control-label">{{ __('Add Exchange ') }} *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="add_exchange" {{ $data->sectionCheck('add_exchange') ? 'checked' : '' }} >
                                <span class="slider round"></span>
                              </label>
                            </div>
                            <div class="col-lg-2"></div>
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label">{{ __('Shipped Exchange') }} *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="shipped_exchange" {{ $data->sectionCheck('shipped_exchange') ? 'checked' : '' }}>
                                <span class="slider round"></span>
                              </label>
                            </div>
                        </div> 
                        
                         <div class="row justify-content-center">
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label">{{ __('Pending Exchange') }} *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="pending_exchange" {{ $data->sectionCheck('pending_exchange') ? 'checked' : '' }} >
                                <span class="slider round"></span>
                              </label>
                            </div>
                            <div class="col-lg-2"></div>
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label">{{ __('Delivered Exchange') }} *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="delivered_exchange" {{ $data->sectionCheck('delivered_exchange') ? 'checked' : '' }}>
                                <span class="slider round"></span>
                              </label>
                            </div>
                        </div>
                           <div class="row justify-content-center">
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label">{{ __('Not Delivered Exchange') }} *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="not_delivered_exchange" {{ $data->sectionCheck('not_delivered_exchange') ? 'checked' : '' }} >
                                <span class="slider round"></span>
                              </label>
                            </div>
                            <div class="col-lg-2"></div>
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label">{{ __('Decline Exchange') }} *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="decline_exchange" {{ $data->sectionCheck('decline_exchange') ? 'checked' : '' }}>
                                <span class="slider round"></span>
                              </label>
                            </div>
                        </div>
						
						  <hr>
                        <h6>Rto</h6>
                        
                        <hr>
                        
                        <div class="row justify-content-center">
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label c
							  lass="control-label">{{ __('Add Rto') }} *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="add_rto" {{ $data->sectionCheck('add_rto') ? 'checked' : '' }} >
                                <span class="slider round"></span>
                              </label>
                            </div>
                            <div class="col-lg-2"></div>
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label">{{ __('Shipped Rto') }} *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="shipped_rto" {{ $data->sectionCheck('shipped_rto') ? 'checked' : '' }}>
                                <span class="slider round"></span>
                              </label>
                            </div>
                        </div> 
                        
                         <div class="row justify-content-center">
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label">{{ __('Pending Rto') }} *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="pending_rto" {{ $data->sectionCheck('pending_rto') ? 'checked' : '' }} >
                                <span class="slider round"></span>
                              </label>
                            </div>
                            <div class="col-lg-2"></div>
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label">{{ __('Delivered Rto') }} *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="delivered_rto" {{ $data->sectionCheck('delivered_rto') ? 'checked' : '' }}>
                                <span class="slider round"></span>
                              </label>
                            </div>
                        </div>
                           <div class="row justify-content-center">
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label">{{ __('Not Delivered Rto') }} *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="not_delivered_rto" {{ $data->sectionCheck('not_delivered_rto') ? 'checked' : '' }} >
                                <span class="slider round"></span>
                              </label>
                            </div>
                            <div class="col-lg-2"></div>
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label">{{ __('Decline Rto') }} *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="decline_rto" {{ $data->sectionCheck('decline_rto') ? 'checked' : '' }}>
                                <span class="slider round"></span>
                              </label>
                            </div>
                        </div>
                        
                        <hr>
                        <h6>Dispute</h6>
                        
                        <hr>
                        
                        <div class="row justify-content-center">
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label">{{ __('Add Dispute') }} *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="add_dispute" {{ $data->sectionCheck('add_dispute') ? 'checked' : '' }} >
                                <span class="slider round"></span>
                              </label>
                            </div>
                            <div class="col-lg-2"></div>
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label">{{ __('Pending Dispute') }} *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="pending_dispute" {{ $data->sectionCheck('pending_dispute') ? 'checked' : '' }}>
                                <span class="slider round"></span>
                              </label>
                            </div>
                        </div>

                        <div class="row justify-content-center">
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label">{{ __('Complete Dispute') }} *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="complete_dispute" {{ $data->sectionCheck('complete_dispute') ? 'checked' : '' }} >
                                <span class="slider round"></span>
                              </label>
                            </div>                            
                        </div>  						
                        
                         
                          
						
                        <hr>
                        <h6>Coupon</h6>
                        
                        <hr>
                        
                        <div class="row justify-content-center">
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label">{{ __('Coupon ') }} *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="coupon" {{ $data->sectionCheck('coupon') ? 'checked' : '' }} >
                                <span class="slider round"></span>
                              </label>
                            </div>
                            <div class="col-lg-2"></div>
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label">{{ __('List Coupon') }} *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="list_coupon" {{ $data->sectionCheck('list_coupon') ? 'checked' : '' }}>
                                <span class="slider round"></span>
                              </label>
                            </div>
                        </div> 
                        
                         <div class="row justify-content-center">
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label">{{ __('Approval Coupon') }} *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="approval_coupon"{{ $data->sectionCheck('approval_coupon') ? 'checked' : '' }} >
                                <span class="slider round"></span>
                              </label>
                            </div>
                            <div class="col-lg-2"></div>
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label">{{ __('Reject Coupon') }} *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="reject_coupon" {{ $data->sectionCheck('reject_coupon') ? 'checked' : '' }}>
                                <span class="slider round"></span>
                              </label>
                            </div>
                        </div>
                        <div class="row">
                          <div class="col-lg-5">
                            <div class="left-area">
                              
                            </div>
                          </div>
                          <div class="col-lg-7">
                            <button class="addProductSubmit-btn" type="submit">{{ __('Save') }}</button>
                          </div>
                        </div>
                      </form>


                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

@endsection