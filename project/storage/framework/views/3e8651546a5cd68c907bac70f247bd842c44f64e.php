<?php $__env->startSection('content'); ?>
            <div class="content-area">
                <div class="mr-breadcrumb">
                    <div class="row">
                      <div class="col-lg-12">
                          <h4 class="heading"><?php echo e(__('Edit Role')); ?> <a class="add-btn" href="<?php echo e(route('admin-role-index')); ?>"><i class="fas fa-arrow-left"></i> <?php echo e(__('Back')); ?></a></h4>
                          <ul class="links">
                            <li>
                              <a href="<?php echo e(route('admin.dashboard')); ?>"><?php echo e(__('Dashboard')); ?> </a>
                            </li>
                            <li>
                              <a href="<?php echo e(route('admin-role-index')); ?>"><?php echo e(__('Manage Roles')); ?></a>
                            </li>
                            <li>
                              <a href="<?php echo e(route('admin-role-edit',$data->id)); ?>"><?php echo e(__('Edit Role')); ?></a>
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
                          <div class="gocover" style="background: url(<?php echo e(asset('assets/images/'.$gs->admin_loader)); ?>) no-repeat scroll center center rgba(45, 45, 45, 0.5);"></div>
                      <form id="geniusform" action="<?php echo e(route('admin-role-update',$data->id)); ?>" method="POST" enctype="multipart/form-data">
                          <?php echo e(csrf_field()); ?>

                          <?php echo $__env->make('includes.admin.form-both', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?> 

                        <div class="row">
                          <div class="col-lg-4">
                            <div class="left-area">
                                <h4 class="heading"><?php echo e(__("Name")); ?> *</h4>
                                <p class="sub-heading"><?php echo e(__('(In Any Language)')); ?></p>
                            </div>
                          </div>
                          <div class="col-lg-7">
                            <input type="text" class="input-field" name="name" placeholder="<?php echo e(__('Name')); ?>" value="<?php echo e($data->name); ?>" required="">
                          </div>
                        </div>


                        <hr>
                        <h5 class="text-center"><?php echo e(__('Permissions')); ?></h5>
                        <hr>
						<hr>
                        <h6>Orders</h6>
                        
                        <hr>

                        <div class="row justify-content-center">
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label"><?php echo e(__('Orders')); ?> *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="orders" <?php echo e($data->sectionCheck('orders') ? 'checked' : ''); ?> >
                                <span class="slider round"></span>
                              </label>
                            </div>
                            <div class="col-lg-2"></div>
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label"><?php echo e(__(' All Orders')); ?> *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="all_orders" <?php echo e($data->sectionCheck('all_orders') ? 'checked' : ''); ?>>
                                <span class="slider round"></span>
                              </label>
                            </div>
                        </div>
						<div class="row justify-content-center">
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label"><?php echo e(__('Pending Orders')); ?> *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="pending_orders" <?php echo e($data->sectionCheck('pending_orders') ? 'checked' : ''); ?>  >
                                <span class="slider round"></span>
                              </label>
                            </div>
                            <div class="col-lg-2"></div>
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label"><?php echo e(__('Processing Orders')); ?> *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="processing_orders" <?php echo e($data->sectionCheck('processing_orders') ? 'checked' : ''); ?>>
                                <span class="slider round"></span>
                              </label>
                            </div>
                        </div>
						<div class="row justify-content-center">
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label"><?php echo e(__('Shipped Orders')); ?> *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="shipped_orders" <?php echo e($data->sectionCheck('shipped_orders') ? 'checked' : ''); ?> >
                                <span class="slider round"></span>
                              </label>
                            </div>
                            <div class="col-lg-2"></div>
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label"><?php echo e(__('Completed Orders')); ?> *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="completed_orders" <?php echo e($data->sectionCheck('completed_orders') ? 'checked' : ''); ?>>
                                <span class="slider round"></span>
                              </label>
                            </div>
                        </div>
						<div class="row justify-content-center">
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label"><?php echo e(__('Declined Orders')); ?> *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="declined_orders" <?php echo e($data->sectionCheck('declined_orders') ? 'checked' : ''); ?> >
                                <span class="slider round"></span>
                              </label>
                            </div>
                            <div class="col-lg-2"></div>
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label"><?php echo e(__('Refund Orders')); ?> *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="refund_orders" <?php echo e($data->sectionCheck('refund_orders') ? 'checked' : ''); ?>>
                                <span class="slider round"></span>
                              </label>
                            </div>
                        </div>
                       <div class="row justify-content-center">
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label"><?php echo e(__('Download Order Track')); ?> *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="download_order_track" <?php echo e($data->sectionCheck('download_order_track') ? 'checked' : ''); ?> >
                                <span class="slider round"></span>
                              </label>
                            </div>
                            <div class="col-lg-2"></div>
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label"><?php echo e(__('Tickets & Disputes')); ?> *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="ticket_dispute" <?php echo e($data->sectionCheck('ticket_dispute') ? 'checked' : ''); ?>>
                                <span class="slider round"></span>
                              </label>
                            </div>
                        </div> 						
						<hr>
                        <h6>Products</h6>
                        
                        <hr>
                        
                        <div class="row justify-content-center">
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label"><?php echo e(__('Add New Product')); ?> *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="add_new_product" <?php echo e($data->sectionCheck('add_new_product') ? 'checked' : ''); ?> >
                                <span class="slider round"></span>
                              </label>
                            </div>
                            <div class="col-lg-2"></div>
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label"><?php echo e(__('All Products')); ?> *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="all_products" <?php echo e($data->sectionCheck('all_products') ? 'checked' : ''); ?>>
                                <span class="slider round"></span>
                              </label>
                            </div>
                        </div> 
                        
                       
                        
                          
                          <div class="row justify-content-center">
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label"><?php echo e(__('Simple Products')); ?> *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="simple_products" <?php echo e($data->sectionCheck('simple_products') ? 'checked' : ''); ?> >
                                <span class="slider round"></span>
                              </label>
                            </div>
                            <div class="col-lg-2"></div>
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label"><?php echo e(__('Variation Products')); ?> *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="variation_products" <?php echo e($data->sectionCheck('variation_products') ? 'checked' : ''); ?>>
                                <span class="slider round"></span>
                              </label>
                            </div>
                        </div> 
                        
                        
                        
                           <div class="row justify-content-center">
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label"><?php echo e(__('Deactiavted Product')); ?> *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="deactivated_product" <?php echo e($data->sectionCheck('deactivated_product') ? 'checked' : ''); ?> >
                                <span class="slider round"></span>
                              </label>
                            </div>
                            <div class="col-lg-2"></div>
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label"><?php echo e(__('Manage categories')); ?> *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="manage_categories" <?php echo e($data->sectionCheck('manage_categories') ? 'checked' : ''); ?>>
                                <span class="slider round"></span>
                              </label>
                            </div>
                        </div> 
                        
                        
                        
                          <div class="row justify-content-center">
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label"><?php echo e(__('Bulk Product Upload')); ?> *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="bulk_product_upload" <?php echo e($data->sectionCheck('bulk_product_upload') ? 'checked' : ''); ?> >
                                <span class="slider round"></span>
                              </label>
                            </div>
                            <div class="col-lg-2"></div>
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label"><?php echo e(__('Product Reviews')); ?> *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="product_reviews" <?php echo e($data->sectionCheck('product_reviews') ? 'checked' : ''); ?>>
                                <span class="slider round"></span>
                              </label>
                            </div>
                        </div> 
                        
                        
                        
                          <div class="row justify-content-center">
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label"><?php echo e(__('Media')); ?> *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="media" <?php echo e($data->sectionCheck('media') ? 'checked' : ''); ?> >
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
                              <label class="control-label"><?php echo e(__('Vendor List')); ?> *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="vendor_list" <?php echo e($data->sectionCheck('vendor_list') ? 'checked' : ''); ?> >
                                <span class="slider round"></span>
                              </label>
                            </div>
                            <div class="col-lg-2"></div>
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label"><?php echo e(__('Vendor Registration')); ?> *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="vendor_registration" <?php echo e($data->sectionCheck('vendor_registration') ? 'checked' : ''); ?>>
                                <span class="slider round"></span>
                              </label>
                            </div>
                        </div> 
                        
                       
                
                          
                          <div class="row justify-content-center">
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label"><?php echo e(__('Withdrawls')); ?> *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="withdrawls" <?php echo e($data->sectionCheck('withdrawls') ? 'checked' : ''); ?> >
                                <span class="slider round"></span>
                              </label>
                            </div>
                            <div class="col-lg-2"></div>
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label"><?php echo e(__('Admin Approve List')); ?> *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="admin_approve_list" <?php echo e($data->sectionCheck('admin_approve_list') ? 'checked' : ''); ?>>
                                <span class="slider round"></span>
                              </label>
                            </div>
                        </div> 
                        
                        
                        
                           <div class="row justify-content-center">
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label"><?php echo e(__('Vendor Subscription')); ?> *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="vendor_subscription" <?php echo e($data->sectionCheck('vendor_subscription') ? 'checked' : ''); ?> >
                                <span class="slider round"></span>
                              </label>
                            </div>
                            <div class="col-lg-2"></div>
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label"><?php echo e(__('Default Background')); ?> *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="default_background" <?php echo e($data->sectionCheck('default_background') ? 'checked' : ''); ?>>
                                <span class="slider round"></span>
                              </label>
                            </div>
                        </div> 
                        
                        
                        
                          <div class="row justify-content-center">
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label"><?php echo e(__('Vendor Verifiaction')); ?> *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="vendor_verification" <?php echo e($data->sectionCheck('vendor_verification') ? 'checked' : ''); ?> >
                                <span class="slider round"></span>
                              </label>
                            </div>
                            <div class="col-lg-2"></div>
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label"><?php echo e(__('Vendor Subscription Plans')); ?> *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="vendor_subscription_plans" <?php echo e($data->sectionCheck('vendor_subscription_plans') ? 'checked' : ''); ?>>
                                <span class="slider round"></span>
                              </label>
                            </div>
                        </div> 
                        
                        
                        
                        
                         <hr>
                        <h6>Custumers</h6>
                        
                        <hr>
                        
                        <div class="row justify-content-center">
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label"><?php echo e(__('Customer List')); ?> *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="customer_list" <?php echo e($data->sectionCheck('customer_list') ? 'checked' : ''); ?> >
                                <span class="slider round"></span>
                              </label>
                            </div>
                            <div class="col-lg-2"></div>
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label"><?php echo e(__('Withdraws')); ?> *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="customer_withdraw" <?php echo e($data->sectionCheck('customer_withdraw') ? 'checked' : ''); ?>>
                                <span class="slider round"></span>
                              </label>
                            </div>
                        </div> 
                        
                       
                        
                          
                          <div class="row justify-content-center">
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label"><?php echo e(__('Customer Default Image')); ?> *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="customer_default_image" <?php echo e($data->sectionCheck('customer_default_image') ? 'checked' : ''); ?> >
                                <span class="slider round"></span>
                              </label>
                            </div>
                            <div class="col-lg-2"></div>
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label"><?php echo e(__('Customer Enquiry')); ?> *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="customer_enquiry" <?php echo e($data->sectionCheck('customer_enquiry') ? 'checked' : ''); ?>>
                                <span class="slider round"></span>
                              </label>
                            </div>
                        </div> 
                        
                        
                        
                           <div class="row justify-content-center">
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label"><?php echo e(__('Subscribers')); ?> *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="subscriber" <?php echo e($data->sectionCheck('subscriber') ? 'checked' : ''); ?> >
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
                              <label class="control-label"><?php echo e(__('Manage Staffs')); ?> *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="manage_staffs" <?php echo e($data->sectionCheck('manage_staffs') ? 'checked' : ''); ?> >
                                <span class="slider round"></span>
                              </label>
                            </div>
                            <div class="col-lg-2"></div>
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label"><?php echo e(__('Manage Roles')); ?> *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="manage_roles" <?php echo e($data->sectionCheck('manage_roles') ? 'checked' : ''); ?>>
                                <span class="slider round"></span>
                              </label>
                            </div>
                        </div> 
                        
                        
                        
                                                 <hr>
                        <h6>Data Analytic</h6>
                        
                        <hr>
                        
                        <div class="row justify-content-center">
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label"><?php echo e(__('Overview')); ?> *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="overview" <?php echo e($data->sectionCheck('overview') ? 'checked' : ''); ?> >
                                <span class="slider round"></span>
                              </label>
                            </div>
                            <div class="col-lg-2"></div>
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label"><?php echo e(__('Orders')); ?> *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="anal_orders" <?php echo e($data->sectionCheck('anal_orders') ? 'checked' : ''); ?>>
                                <span class="slider round"></span>
                              </label>
                            </div>
                        </div> 
                        
                       
                        
                          
                          <div class="row justify-content-center">
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label"><?php echo e(__('Refund')); ?> *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="refund" <?php echo e($data->sectionCheck('refund') ? 'checked' : ''); ?> >
                                <span class="slider round"></span>
                              </label>
                            </div>
                            <div class="col-lg-2"></div>
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label"><?php echo e(__('Revanue')); ?> *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="revanue" <?php echo e($data->sectionCheck('revanue') ? 'checked' : ''); ?>>
                                <span class="slider round"></span>
                              </label>
                            </div>
                        </div> 
                        
                        
                        
                           <div class="row justify-content-center">
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label"><?php echo e(__('Product')); ?> *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="product" <?php echo e($data->sectionCheck('product') ? 'checked' : ''); ?> >
                                <span class="slider round"></span>
                              </label>
                            </div>
                            <div class="col-lg-2"></div>
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label"><?php echo e(__('Vendor Commision Reports')); ?> *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="vendor_commision_reports" <?php echo e($data->sectionCheck('vendor_commision_reports') ? 'checked' : ''); ?>>
                                <span class="slider round"></span>
                              </label>
                            </div>
                        </div>
                        
                        
                        
                        
                        
                        <hr>
                        <h6>Settings</h6>
                        
                        <hr>
                        
                        <div class="row justify-content-center">
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label"><?php echo e(__('Set Coupans')); ?> *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="set_coupons" <?php echo e($data->sectionCheck('set_coupons') ? 'checked' : ''); ?> >
                                <span class="slider round"></span>
                              </label>
                            </div>
                            <div class="col-lg-2"></div>
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label"><?php echo e(__('General Settings')); ?> *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="general_settings" <?php echo e($data->sectionCheck('general_settings') ? 'checked' : ''); ?>>
                                <span class="slider round"></span>
                              </label>
                            </div>
                        </div> 
                        
                       
                        
                          
                          <div class="row justify-content-center">
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label"><?php echo e(__('Home Page Settings')); ?> *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="home_page_settings" <?php echo e($data->sectionCheck('home_page_settings') ? 'checked' : ''); ?> >
                                <span class="slider round"></span>
                              </label>
                            </div>
                            <div class="col-lg-2"></div>
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label"><?php echo e(__('Menu Page Settings')); ?> *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="menu_page_settings" <?php echo e($data->sectionCheck('menu_page_settings') ? 'checked' : ''); ?>>
                                <span class="slider round"></span>
                              </label>
                            </div>
                        </div> 
                        
                        
                        
                           <div class="row justify-content-center">
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label"><?php echo e(__('Email Settings')); ?> *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="email_settings" <?php echo e($data->sectionCheck('email_settings') ? 'checked' : ''); ?> >
                                <span class="slider round"></span>
                              </label>
                            </div>
                            <div class="col-lg-2"></div>
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label"><?php echo e(__('Payment Settings')); ?> *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="payment_settings" <?php echo e($data->sectionCheck('payment_settings') ? 'checked' : ''); ?>>
                                <span class="slider round"></span>
                              </label>
                            </div>
                        </div> 
                        
                        
                        
                          <div class="row justify-content-center">
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label"><?php echo e(__('Social Settings')); ?> *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="social_settings" <?php echo e($data->sectionCheck('social_settings') ? 'checked' : ''); ?> >
                                <span class="slider round"></span>
                              </label>
                            </div>
                            <div class="col-lg-2"></div>
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label"><?php echo e(__('Language Settings')); ?> *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="language_settings" <?php echo e($data->sectionCheck('language_settings') ? 'checked' : ''); ?>>
                                <span class="slider round"></span>
                              </label>
                            </div>
                        </div> 
                        
                        
                                                  <div class="row justify-content-center">
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label"><?php echo e(__('Seo Tools')); ?> *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="seo_tools" <?php echo e($data->sectionCheck('seo_tools') ? 'checked' : ''); ?> >
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
                              <label class="control-label"><?php echo e(__('Clear Cache')); ?> *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="clear_cache" <?php echo e($data->sectionCheck('clear_cache') ? 'checked' : ''); ?> >
                                <span class="slider round"></span>
                              </label>
                            </div>
                            <div class="col-lg-2"></div>
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label"><?php echo e(__('Generate Backup')); ?> *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="generate_backup" <?php echo e($data->sectionCheck('generate_backup') ? 'checked' : ''); ?>>
                                <span class="slider round"></span>
                              </label>
                            </div>
                        </div> 
                        
                        
                        
                        
                        
                        
                <hr>
                        <h6>Refunds</h6>
                        
                        <hr>
                        
                        <div class="row justify-content-center">
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label"><?php echo e(__('Create Refund ')); ?> *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="create_refund" <?php echo e($data->sectionCheck('create_refund') ? 'checked' : ''); ?> >
                                <span class="slider round"></span>
                              </label>
                            </div>
                            <div class="col-lg-2"></div>
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label"><?php echo e(__('Pending Refund')); ?> *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="pending_refund" <?php echo e($data->sectionCheck('pending_refund') ? 'checked' : ''); ?>>
                                <span class="slider round"></span>
                              </label>
                            </div>
                        </div> 
                        
                         <div class="row justify-content-center">
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label"><?php echo e(__('Refunds Paid ')); ?> *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="refunds_paid" <?php echo e($data->sectionCheck('refunds_paid') ? 'checked' : ''); ?> >
                                <span class="slider round"></span>
                              </label>
                            </div>
                            <div class="col-lg-2"></div>
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label"><?php echo e(__('Cancelled Refunds')); ?> *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="cancelled_refunds" <?php echo e($data->sectionCheck('cancelled_refunds') ? 'checked' : ''); ?>>
                                <span class="slider round"></span>
                              </label>
                            </div>
                        </div> 
                        
                        
                                        <hr>
                        <h6>Debit Note</h6>
                        
                        <hr>
                        
                        <div class="row justify-content-center">
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label"><?php echo e(__('Debit Note ')); ?> *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="debit_note" <?php echo e($data->sectionCheck('debit_note') ? 'checked' : ''); ?> >
                                <span class="slider round"></span>
                              </label>
                            </div>
                            <div class="col-lg-2"></div>
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label"><?php echo e(__('Unsettle Note')); ?> *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="unsettle_note" <?php echo e($data->sectionCheck('unsettle_note') ? 'checked' : ''); ?>>
                                <span class="slider round"></span>
                              </label>
                            </div>
                        </div> 
                        
                         <div class="row justify-content-center">
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label"><?php echo e(__('Settle Note')); ?> *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="settle_note" <?php echo e($data->sectionCheck('settle_note') ? 'checked' : ''); ?> >
                                <span class="slider round"></span>
                              </label>
                            </div>
                            <div class="col-lg-2"></div>
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label"><?php echo e(__('Cancelled Note')); ?> *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="cancelled_note" <?php echo e($data->sectionCheck('cancelled_note') ? 'checked' : ''); ?>>
                                <span class="slider round"></span>
                              </label>
                            </div>
                        </div>
                        
                        
                        
                                                                <hr>
                        <h6>Credit Note</h6>
                        
                        <hr>
                        
                        <div class="row justify-content-center">
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label"><?php echo e(__('Credit Note ')); ?> *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="credit_note" <?php echo e($data->sectionCheck('credit_note') ? 'checked' : ''); ?> >
                                <span class="slider round"></span>
                              </label>
                            </div>
                            <div class="col-lg-2"></div>
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label"><?php echo e(__('Unsettle Note')); ?> *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="cunsettle_note" <?php echo e($data->sectionCheck('cunsettle_note') ? 'checked' : ''); ?>>
                                <span class="slider round"></span>
                              </label>
                            </div>
                        </div> 
                        
                         <div class="row justify-content-center">
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label"><?php echo e(__('Settle Note')); ?> *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="csettle_note" <?php echo e($data->sectionCheck('csettle_note') ? 'checked' : ''); ?> >
                                <span class="slider round"></span>
                              </label>
                            </div>
                            <div class="col-lg-2"></div>
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label"><?php echo e(__('Cancelled Note')); ?> *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="ccancelled_note"  <?php echo e($data->sectionCheck('ccancelled_note') ? 'checked' : ''); ?>>
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
							  lass="control-label"><?php echo e(__('Add Exchange ')); ?> *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="add_exchange" <?php echo e($data->sectionCheck('add_exchange') ? 'checked' : ''); ?> >
                                <span class="slider round"></span>
                              </label>
                            </div>
                            <div class="col-lg-2"></div>
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label"><?php echo e(__('Shipped Exchange')); ?> *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="shipped_exchange" <?php echo e($data->sectionCheck('shipped_exchange') ? 'checked' : ''); ?>>
                                <span class="slider round"></span>
                              </label>
                            </div>
                        </div> 
                        
                         <div class="row justify-content-center">
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label"><?php echo e(__('Pending Exchange')); ?> *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="pending_exchange" <?php echo e($data->sectionCheck('pending_exchange') ? 'checked' : ''); ?> >
                                <span class="slider round"></span>
                              </label>
                            </div>
                            <div class="col-lg-2"></div>
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label"><?php echo e(__('Delivered Exchange')); ?> *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="delivered_exchange" <?php echo e($data->sectionCheck('delivered_exchange') ? 'checked' : ''); ?>>
                                <span class="slider round"></span>
                              </label>
                            </div>
                        </div>
                           <div class="row justify-content-center">
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label"><?php echo e(__('Not Delivered Exchange')); ?> *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="not_delivered_exchange" <?php echo e($data->sectionCheck('not_delivered_exchange') ? 'checked' : ''); ?> >
                                <span class="slider round"></span>
                              </label>
                            </div>
                            <div class="col-lg-2"></div>
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label"><?php echo e(__('Decline Exchange')); ?> *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="decline_exchange" <?php echo e($data->sectionCheck('decline_exchange') ? 'checked' : ''); ?>>
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
							  lass="control-label"><?php echo e(__('Add Rto')); ?> *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="add_rto" <?php echo e($data->sectionCheck('add_rto') ? 'checked' : ''); ?> >
                                <span class="slider round"></span>
                              </label>
                            </div>
                            <div class="col-lg-2"></div>
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label"><?php echo e(__('Shipped Rto')); ?> *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="shipped_rto" <?php echo e($data->sectionCheck('shipped_rto') ? 'checked' : ''); ?>>
                                <span class="slider round"></span>
                              </label>
                            </div>
                        </div> 
                        
                         <div class="row justify-content-center">
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label"><?php echo e(__('Pending Rto')); ?> *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="pending_rto" <?php echo e($data->sectionCheck('pending_rto') ? 'checked' : ''); ?> >
                                <span class="slider round"></span>
                              </label>
                            </div>
                            <div class="col-lg-2"></div>
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label"><?php echo e(__('Delivered Rto')); ?> *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="delivered_rto" <?php echo e($data->sectionCheck('delivered_rto') ? 'checked' : ''); ?>>
                                <span class="slider round"></span>
                              </label>
                            </div>
                        </div>
                           <div class="row justify-content-center">
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label"><?php echo e(__('Not Delivered Rto')); ?> *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="not_delivered_rto" <?php echo e($data->sectionCheck('not_delivered_rto') ? 'checked' : ''); ?> >
                                <span class="slider round"></span>
                              </label>
                            </div>
                            <div class="col-lg-2"></div>
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label"><?php echo e(__('Decline Rto')); ?> *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="decline_rto" <?php echo e($data->sectionCheck('decline_rto') ? 'checked' : ''); ?>>
                                <span class="slider round"></span>
                              </label>
                            </div>
                        </div>
                        
                        <hr>
                        <h6>Dispute</h6>
                        
                        <hr>
                        
                        <div class="row justify-content-center">
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label"><?php echo e(__('Add Dispute')); ?> *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="add_dispute" <?php echo e($data->sectionCheck('add_dispute') ? 'checked' : ''); ?> >
                                <span class="slider round"></span>
                              </label>
                            </div>
                            <div class="col-lg-2"></div>
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label"><?php echo e(__('Pending Dispute')); ?> *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="pending_dispute" <?php echo e($data->sectionCheck('pending_dispute') ? 'checked' : ''); ?>>
                                <span class="slider round"></span>
                              </label>
                            </div>
                        </div>

                        <div class="row justify-content-center">
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label"><?php echo e(__('Complete Dispute')); ?> *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="complete_dispute" <?php echo e($data->sectionCheck('complete_dispute') ? 'checked' : ''); ?> >
                                <span class="slider round"></span>
                              </label>
                            </div>                            
                        </div>  						
                        
                         
                          
						
                        <hr>
                        <h6>Coupon</h6>
                        
                        <hr>
                        
                        <div class="row justify-content-center">
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label"><?php echo e(__('Coupon ')); ?> *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="coupon" <?php echo e($data->sectionCheck('coupon') ? 'checked' : ''); ?> >
                                <span class="slider round"></span>
                              </label>
                            </div>
                            <div class="col-lg-2"></div>
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label"><?php echo e(__('List Coupon')); ?> *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="list_coupon" <?php echo e($data->sectionCheck('list_coupon') ? 'checked' : ''); ?>>
                                <span class="slider round"></span>
                              </label>
                            </div>
                        </div> 
                        
                         <div class="row justify-content-center">
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label"><?php echo e(__('Approval Coupon')); ?> *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="approval_coupon"<?php echo e($data->sectionCheck('approval_coupon') ? 'checked' : ''); ?> >
                                <span class="slider round"></span>
                              </label>
                            </div>
                            <div class="col-lg-2"></div>
                            <div class="col-lg-4 d-flex justify-content-between">
                              <label class="control-label"><?php echo e(__('Reject Coupon')); ?> *</label>
                              <label class="switch">
                                <input type="checkbox" name="section[]" value="reject_coupon" <?php echo e($data->sectionCheck('reject_coupon') ? 'checked' : ''); ?>>
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
                            <button class="addProductSubmit-btn" type="submit"><?php echo e(__('Save')); ?></button>
                          </div>
                        </div>
                      </form>


                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>