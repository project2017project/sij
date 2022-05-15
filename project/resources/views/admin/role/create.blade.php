@extends('layouts.admin')

@section('content')

            <div class="content-area">
                <div class="mr-breadcrumb">
                    <div class="row">
                      <div class="col-lg-12">
                          <h4 class="heading">{{ __('Add Role') }} <a class="add-btn" href="{{route('admin-role-index')}}"><i class="fas fa-arrow-left"></i> {{ __('Back') }}</a></h4>
                          <ul class="links">
                            <li>
                              <a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }} </a>
                            </li>
                            <li>
                              <a href="{{ route('admin-role-index') }}">{{ __('Manage Roles') }}</a>
                            </li>
                            <li>
                              <a href="{{ route('admin-role-create') }}">{{ __('Add Role') }}</a>
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
                      <form id="geniusform" action="{{route('admin-role-create')}}" method="POST" enctype="multipart/form-data">
                        {{csrf_field()}}
                      @include('includes.admin.form-both') 

                        <div class="row">
                          <div class="col-lg-2">
                            <div class="left-area">
                                <h4 class="heading">{{ __("Name") }} *</h4>
                                <p class="sub-heading">{{ __("(In Any Language)") }}</p>
                            </div>
                          </div>
                          <div class="col-lg-10">
                            <input type="text" class="input-field" name="name" placeholder="{{ __('Name') }}" required="" value="">
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
                                <input type="checkbox" name="section[]" value="orders" >
                                <span class="slider round"></span>
                              </label>
                            </div>
                            <div class="col-lg-2"></div>
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label">{{ __(' All Orders') }} *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="all_orders">
                                <span class="slider round"></span>
                              </label>
                            </div>
                        </div>
						<div class="row justify-content-center">
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label">{{ __('Pending Orders') }} *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="pending_orders" >
                                <span class="slider round"></span>
                              </label>
                            </div>
                            <div class="col-lg-2"></div>
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label">{{ __('Processing Orders') }} *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="processing_orders">
                                <span class="slider round"></span>
                              </label>
                            </div>
                        </div>
						<div class="row justify-content-center">
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label">{{ __('Shipped Orders') }} *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="shipped_orders" >
                                <span class="slider round"></span>
                              </label>
                            </div>
                            <div class="col-lg-2"></div>
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label">{{ __('Completed Orders') }} *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="completed_orders">
                                <span class="slider round"></span>
                              </label>
                            </div>
                        </div>
						<div class="row justify-content-center">
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label">{{ __('Declined Orders') }} *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="declined_orders" >
                                <span class="slider round"></span>
                              </label>
                            </div>
                            <div class="col-lg-2"></div>
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label">{{ __('Refund Orders') }} *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="refund_orders">
                                <span class="slider round"></span>
                              </label>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label">{{ __('Download Order Track') }} *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="download_order_track" >
                                <span class="slider round"></span>
                              </label>
                            </div>
                            <div class="col-lg-2"></div>
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label">{{ __('Tickets & Disputes') }} *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="ticket_dispute">
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
                                <input type="checkbox" name="section[]" value="add_new_product" >
                                <span class="slider round"></span>
                              </label>
                            </div>
                            <div class="col-lg-2"></div>
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label">{{ __('All Products') }} *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="all_products">
                                <span class="slider round"></span>
                              </label>
                            </div>
                        </div> 
                        
                       
                        
                          
                          <div class="row justify-content-center">
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label">{{ __('Simple Products') }} *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="simple_products" >
                                <span class="slider round"></span>
                              </label>
                            </div>
                            <div class="col-lg-2"></div>
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label">{{ __('Variation Products') }} *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="variation_products">
                                <span class="slider round"></span>
                              </label>
                            </div>
                        </div> 
                        
                        
                        
                           <div class="row justify-content-center">
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label">{{ __('Deactiavted Product') }} *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="deactivated_product" >
                                <span class="slider round"></span>
                              </label>
                            </div>
                            <div class="col-lg-2"></div>
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label">{{ __('Manage categories') }} *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="manage_categories">
                                <span class="slider round"></span>
                              </label>
                            </div>
                        </div> 
                        
                        
                        
                          <div class="row justify-content-center">
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label">{{ __('Bulk Product Upload') }} *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="bulk_product_upload" >
                                <span class="slider round"></span>
                              </label>
                            </div>
                            <div class="col-lg-2"></div>
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label">{{ __('Product Reviews') }} *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="product_reviews">
                                <span class="slider round"></span>
                              </label>
                            </div>
                        </div> 
                        
                        
                        
                          <div class="row justify-content-center">
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label">{{ __('Media') }} *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="media" >
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
                                <input type="checkbox" name="section[]" value="vendor_list" >
                                <span class="slider round"></span>
                              </label>
                            </div>
                            <div class="col-lg-2"></div>
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label">{{ __('Vendor Registration') }} *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="vendor_registration">
                                <span class="slider round"></span>
                              </label>
                            </div>
                        </div> 
                        
                       
                
                          
                          <div class="row justify-content-center">
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label">{{ __('Withdrawls') }} *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="withdrawls" >
                                <span class="slider round"></span>
                              </label>
                            </div>
                            <div class="col-lg-2"></div>
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label">{{ __('Admin Approve List') }} *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="admin_approve_list">
                                <span class="slider round"></span>
                              </label>
                            </div>
                        </div> 
                        
                        
                        
                           <div class="row justify-content-center">
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label">{{ __('Vendor Subscription') }} *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="vendor_subscription" >
                                <span class="slider round"></span>
                              </label>
                            </div>
                            <div class="col-lg-2"></div>
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label">{{ __('Default Background') }} *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="default_background">
                                <span class="slider round"></span>
                              </label>
                            </div>
                        </div> 
                        
                        
                        
                          <div class="row justify-content-center">
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label">{{ __('Vendor V erifiaction') }} *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="vendor_verification" >
                                <span class="slider round"></span>
                              </label>
                            </div>
                            <div class="col-lg-2"></div>
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label">{{ __('Vendor Subscription Plans') }} *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="vendor_subscription_plans">
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
                                <input type="checkbox" name="section[]" value="customer_list" >
                                <span class="slider round"></span>
                              </label>
                            </div>
                            <div class="col-lg-2"></div>
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label">{{ __('Withdraws') }} *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="customer_withdraw">
                                <span class="slider round"></span>
                              </label>
                            </div>
                        </div> 
                        
                       
                        
                          
                          <div class="row justify-content-center">
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label">{{ __('Customer Default Image') }} *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="customer_default_image" >
                                <span class="slider round"></span>
                              </label>
                            </div>
                            <div class="col-lg-2"></div>
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label">{{ __('Customer Enquiry') }} *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="customer_enquiry">
                                <span class="slider round"></span>
                              </label>
                            </div>
                        </div> 
                        
                        
                        
                           <div class="row justify-content-center">
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label">{{ __('Subscribers') }} *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="subscriber" >
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
                                <input type="checkbox" name="section[]" value="manage_staffs" >
                                <span class="slider round"></span>
                              </label>
                            </div>
                            <div class="col-lg-2"></div>
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label">{{ __('Manage Roles') }} *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="manage_roles">
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
                                <input type="checkbox" name="section[]" value="overview" >
                                <span class="slider round"></span>
                              </label>
                            </div>
                            <div class="col-lg-2"></div>
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label">{{ __('Orders') }} *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="anal_orders">
                                <span class="slider round"></span>
                              </label>
                            </div>
                        </div> 
                        
                       
                        
                          
                          <div class="row justify-content-center">
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label">{{ __('Refund') }} *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="refund" >
                                <span class="slider round"></span>
                              </label>
                            </div>
                            <div class="col-lg-2"></div>
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label">{{ __('Revanue') }} *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="revanue">
                                <span class="slider round"></span>
                              </label>
                            </div>
                        </div> 
                        
                        
                        
                           <div class="row justify-content-center">
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label">{{ __('Product') }} *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="product" >
                                <span class="slider round"></span>
                              </label>
                            </div>
                            <div class="col-lg-2"></div>
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label">{{ __('Vendor Commision Reports') }} *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="vendor_commision_reports">
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
                                <input type="checkbox" name="section[]" value="set_coupons" >
                                <span class="slider round"></span>
                              </label>
                            </div>
                            <div class="col-lg-2"></div>
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label">{{ __('General Settings') }} *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="general_settings">
                                <span class="slider round"></span>
                              </label>
                            </div>
                        </div> 
                        
                       
                        
                          
                          <div class="row justify-content-center">
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label">{{ __('Home Page Settings') }} *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="home_page_settings" >
                                <span class="slider round"></span>
                              </label>
                            </div>
                            <div class="col-lg-2"></div>
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label">{{ __('Menu Page Settings') }} *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="menu_page_settings">
                                <span class="slider round"></span>
                              </label>
                            </div>
                        </div> 
                        
                        
                        
                           <div class="row justify-content-center">
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label">{{ __('Email Settings') }} *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="email_settings" >
                                <span class="slider round"></span>
                              </label>
                            </div>
                            <div class="col-lg-2"></div>
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label">{{ __('Payment Settings') }} *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="payment_settings">
                                <span class="slider round"></span>
                              </label>
                            </div>
                        </div> 
                        
                        
                        
                          <div class="row justify-content-center">
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label">{{ __('Social Settings') }} *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="social_settings" >
                                <span class="slider round"></span>
                              </label>
                            </div>
                            <div class="col-lg-2"></div>
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label">{{ __('Language Settings') }} *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="language_settings">
                                <span class="slider round"></span>
                              </label>
                            </div>
                        </div> 
                        
                        
                                                  <div class="row justify-content-center">
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label">{{ __('Seo Tools') }} *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="seo_tools" >
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
                                <input type="checkbox" name="section[]" value="clear_cache" >
                                <span class="slider round"></span>
                              </label>
                            </div>
                            <div class="col-lg-2"></div>
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label">{{ __('Generate Backup') }} *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="generate_backup">
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
                                <input type="checkbox" name="section[]" value="create_refund" >
                                <span class="slider round"></span>
                              </label>
                            </div>
                            <div class="col-lg-2"></div>
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label">{{ __('Pending Refund') }} *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="pending_refund">
                                <span class="slider round"></span>
                              </label>
                            </div>
                        </div> 
                        
                         <div class="row justify-content-center">
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label">{{ __('Refunds Paid ') }} *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="refunds_paid" >
                                <span class="slider round"></span>
                              </label>
                            </div>
                            <div class="col-lg-2"></div>
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label">{{ __('Cancelled Refunds') }} *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="cancelled_refunds">
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
                                <input type="checkbox" name="section[]" value="debit_note" >
                                <span class="slider round"></span>
                              </label>
                            </div>
                            <div class="col-lg-2"></div>
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label">{{ __('Unsettle Note') }} *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="unsettle_note">
                                <span class="slider round"></span>
                              </label>
                            </div>
                        </div> 
                        
                         <div class="row justify-content-center">
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label">{{ __('Settle Note') }} *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="settle_note" >
                                <span class="slider round"></span>
                              </label>
                            </div>
                            <div class="col-lg-2"></div>
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label">{{ __('Cancelled Note') }} *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="cancelled_note">
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
                                <input type="checkbox" name="section[]" value="credit_note" >
                                <span class="slider round"></span>
                              </label>
                            </div>
                            <div class="col-lg-2"></div>
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label">{{ __('Unsettle Note') }} *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="cunsettle_note">
                                <span class="slider round"></span>
                              </label>
                            </div>
                        </div> 
                        
                         <div class="row justify-content-center">
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label">{{ __('Settle Note') }} *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="csettle_note" >
                                <span class="slider round"></span>
                              </label>
                            </div>
                            <div class="col-lg-2"></div>
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label">{{ __('Cancelled Note') }} *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="ccancelled_note">
                                <span class="slider round"></span>
                              </label>
                            </div>
                        </div>
                        
                        
                        
        <hr>
                        <h6>Exchange</h6>
                        
                        <hr>
                        
                        <div class="row justify-content-center">
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label">{{ __('Add Exchange ') }} *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="add_exchange" >
                                <span class="slider round"></span>
                              </label>
                            </div>
                            <div class="col-lg-2"></div>
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label">{{ __('Shipped Exchange') }} *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="shipped_exchange">
                                <span class="slider round"></span>
                              </label>
                            </div>
                        </div> 
                        
                         <div class="row justify-content-center">
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label">{{ __('Pending Exchange') }} *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="pending_exchange" >
                                <span class="slider round"></span>
                              </label>
                            </div>
                            <div class="col-lg-2"></div>
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label">{{ __('Delivered Exchange') }} *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="delivered_exchange">
                                <span class="slider round"></span>
                              </label>
                            </div>
                        </div>
                           <div class="row justify-content-center">
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label">{{ __('Not Delivered Exchange') }} *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="not_delivered_exchange" >
                                <span class="slider round"></span>
                              </label>
                            </div>
                            <div class="col-lg-2"></div>
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label">{{ __('Decline Exchange') }} *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="decline_exchange">
                                <span class="slider round"></span>
                              </label>
                            </div>
                        </div>
                        
						<hr>
                        <h6>Rto</h6>
                        
                        <hr>
                        
                        <div class="row justify-content-center">
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label">{{ __('Add Rto') }} *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="add_rto" >
                                <span class="slider round"></span>
                              </label>
                            </div>
                            <div class="col-lg-2"></div>
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label">{{ __('Shipped Rto') }} *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="shipped_rto">
                                <span class="slider round"></span>
                              </label>
                            </div>
                        </div> 
                        
                         <div class="row justify-content-center">
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label">{{ __('Pending Rto') }} *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="pending_rto" >
                                <span class="slider round"></span>
                              </label>
                            </div>
                            <div class="col-lg-2"></div>
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label">{{ __('Delivered Rto') }} *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="delivered_rto">
                                <span class="slider round"></span>
                              </label>
                            </div>
                        </div>
                           <div class="row justify-content-center">
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label">{{ __('Not Delivered Rto') }} *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="not_delivered_rto" >
                                <span class="slider round"></span>
                              </label>
                            </div>
                            <div class="col-lg-2"></div>
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label">{{ __('Decline Rto') }} *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="decline_rto">
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
                                <input type="checkbox" name="section[]" value="add_dispute" >
                                <span class="slider round"></span>
                              </label>
                            </div>
                            <div class="col-lg-2"></div>
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label">{{ __('Pending Dispute') }} *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="pending_dispute">
                                <span class="slider round"></span>
                              </label>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label">{{ __('Complete Dispute') }} *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="complete_dispute" >
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
                                <input type="checkbox" name="section[]" value="coupon" >
                                <span class="slider round"></span>
                              </label>
                            </div>
                            <div class="col-lg-2"></div>
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label">{{ __('List Coupon') }} *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="list_coupon">
                                <span class="slider round"></span>
                              </label>
                            </div>
                        </div> 
                        
                         <div class="row justify-content-center">
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label">{{ __('Approval Coupon') }} *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="approval_coupon" >
                                <span class="slider round"></span>
                              </label>
                            </div>
                            <div class="col-lg-2"></div>
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label">{{ __('Reject Coupon') }} *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="reject_coupon">
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
                            <button class="addProductSubmit-btn" type="submit">{{ __('Create Role') }}</button>
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