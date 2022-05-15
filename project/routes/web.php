<?php

// ************************************ ADMIN SECTION **********************************************

Route::prefix('admin')->group(function() {

  //------------ ADMIN LOGIN SECTION ------------
  Route::get('/login', 'Admin\LoginController@showLoginForm')->name('admin.login');
  Route::post('/login', 'Admin\LoginController@login')->name('admin.login.submit');
  Route::get('/forgot', 'Admin\LoginController@showForgotForm')->name('admin.forgot');
  Route::post('/forgot', 'Admin\LoginController@forgot')->name('admin.forgot.submit');
  Route::get('/logout', 'Admin\LoginController@logout')->name('admin.logout');

  //------------ ADMIN LOGIN SECTION ENDS ------------

  //------------ ADMIN NOTIFICATION SECTION ------------

  // User Notification
  Route::get('/user/notf/show', 'Admin\NotificationController@user_notf_show')->name('user-notf-show');
  Route::get('/user/notf/count','Admin\NotificationController@user_notf_count')->name('user-notf-count');
  Route::get('/user/notf/clear','Admin\NotificationController@user_notf_clear')->name('user-notf-clear');
  // User Notification Ends

  // Order Notification
  Route::get('/order/notf/show', 'Admin\NotificationController@order_notf_show')->name('order-notf-show');
  Route::get('/order/notf/count','Admin\NotificationController@order_notf_count')->name('order-notf-count');
  Route::get('/order/notf/clear','Admin\NotificationController@order_notf_clear')->name('order-notf-clear');
  // Order Notification Ends

  // Product Notification
  Route::get('/product/notf/show', 'Admin\NotificationController@product_notf_show')->name('product-notf-show');
  Route::get('/product/notf/count','Admin\NotificationController@product_notf_count')->name('product-notf-count');
  Route::get('/product/notf/clear','Admin\NotificationController@product_notf_clear')->name('product-notf-clear');
  
  Route::get('/manageshipping', 'Admin\ManageShippingController@index')->name('admin-manageshipping-index');
  Route::post('/manageshipping/update/', 'Admin\ManageShippingController@update')->name('admin-manageshipping-update');
  // Product Notification Ends

  // Product Notification
  Route::get('/conv/notf/show', 'Admin\NotificationController@conv_notf_show')->name('conv-notf-show');
  Route::get('/conv/notf/count','Admin\NotificationController@conv_notf_count')->name('conv-notf-count');
  Route::get('/conv/notf/clear','Admin\NotificationController@conv_notf_clear')->name('conv-notf-clear');
  // Product Notification Ends

  //------------ ADMIN NOTIFICATION SECTION ENDS ------------

  //------------ ADMIN DASHBOARD & PROFILE SECTION ------------
  Route::get('/', 'Admin\DashboardController@index')->name('admin.dashboard');
  Route::get('/profile', 'Admin\DashboardController@profile')->name('admin.profile');
  Route::post('/profile/update', 'Admin\DashboardController@profileupdate')->name('admin.profile.update');
  Route::get('/password', 'Admin\DashboardController@passwordreset')->name('admin.password');
  Route::post('/password/update', 'Admin\DashboardController@changepass')->name('admin.password.update');
  //------------ ADMIN DASHBOARD & PROFILE SECTION ENDS ------------

  Route::get('/record', 'Admin\RecordController@record')->name('admin.record');
  Route::post('/record', 'Admin\RecordController@record')->name('admin.record.submit');
  Route::get('/overview', 'Admin\OverviewController@record')->name('admin.overview');
  Route::post('/overview', 'Admin\OverviewController@record')->name('admin.overview.submit');  
  Route::get('/orderrecord', 'Admin\OrderrecordController@record')->name('admin.orderrecord');
  Route::post('/orderrecord', 'Admin\OrderrecordController@record')->name('admin.orderrecord.submit');  
  Route::get('/revenue', 'Admin\RevenueController@record')->name('admin.revenue');
  Route::post('/revenue', 'Admin\RevenueController@record')->name('admin.revenue.submit');      
  Route::get('/productrecord', 'Admin\ProductrecordController@record')->name('admin.productrecord');
  Route::post('/productrecord', 'Admin\ProductrecordController@record')->name('admin.productrecord.submit');
  Route::get('/analyticrecord', 'Admin\AnalticController@record')->name('admin.analyticrecord');
  Route::post('/analyticrecord', 'Admin\AnalticController@record')->name('admin.analyticrecord.submit');
  Route::post('/analyticreports', 'Admin\AnalticController@reports')->name('admin.analyticreports.submit');
  Route::get('/refundrecord', 'Admin\RefundrecordController@record')->name('admin.refundrecord');
  Route::post('/refundrecord', 'Admin\RefundrecordController@record')->name('admin.refundrecord.submit');
  //------------ ADMIN ORDER SECTION ------------
	Route::group(['middleware'=>'permissions:refund'],function(){
		Route::get('/refund/datatables/', 'Admin\RefundController@datatables')->name('admin-refund-datatables');
		Route::get('/refund', 'Admin\RefundController@index')->name('admin-refund-index');
	});	
  Route::group(['middleware'=>'permissions:orders'],function(){

  Route::get('/orders/datatables/{slug}', 'Admin\OrderController@datatables')->name('admin-order-datatables'); //JSON REQUEST
  Route::get('/orders', 'Admin\OrderController@index')->name('admin-order-index');
  Route::get('/order/edit/{id}', 'Admin\OrderController@edit')->name('admin-order-edit');
  Route::post('/order/update/{id}', 'Admin\OrderController@update')->name('admin-order-update');
  Route::get('/order/unpaidstatus/{id}', 'Admin\OrderController@unpaidstatus')->name('admin-order-unpaidstatus');
  Route::post('/order/unpaidstock/{id}', 'Admin\OrderController@unpaidstock')->name('admin-order-unpaidstock');
  Route::get('/orders/pending', 'Admin\OrderController@pending')->name('admin-order-pending');
  Route::get('/orders/pendingdatatables/{slug}', 'Admin\OrderController@pendingdatatables')->name('admin-pending-datatables');
  Route::get('/orders/shipping', 'Admin\OrderController@shipping')->name('admin-order-shipping');
  Route::get('/orders/processingdatatables/{slug}', 'Admin\OrderController@processingdatatables')->name('admin-process-datatables');
  Route::get('/orders/processing', 'Admin\OrderController@processing')->name('admin-order-processing');
  Route::get('/orders/shippingdatatables/{slug}', 'Admin\OrderController@shippingdatatables')->name('admin-ship-datatables');
  Route::get('/orders/completed', 'Admin\OrderController@completed')->name('admin-order-completed');
  Route::get('/orders/completeddatatables/{slug}', 'Admin\OrderController@completeddatatables')->name('admin-complet-datatables');
  Route::get('/orders/declined', 'Admin\OrderController@declined')->name('admin-order-declined');
  Route::get('/orders/declineddatatables/{slug}', 'Admin\OrderController@declineddatatables')->name('admin-decline-datatables');
  Route::get('/orders/refundod', 'Admin\OrderController@refundod')->name('admin-order-refundod');
  Route::get('/orders/refunddatatables/{slug}', 'Admin\OrderController@refunddatatables')->name('admin-refundod-datatables');
  Route::get('/order/{id}/show', 'Admin\OrderController@show')->name('admin-order-show');
  Route::get('/order/{id}/generateinvoice', 'Admin\OrderController@generateinvoice')->name('admin-generate-invoice');
  Route::get('/order/{id}/showitems', 'Admin\OrderController@showitems')->name('admin-order-show-items');
  Route::get('/order/{id}/refund', 'Admin\OrderController@refund')->name('admin-order-refund');
  Route::get('/order/{id}/refunds', 'Admin\OrderrefundController@refunds')->name('admin-order-refunds');
  Route::post('/order/refunds/store', 'Admin\OrderrefundController@store')->name('admin-order-refund-store');
  Route::get('/order/{id}/razorrefund', 'Admin\OrderrefundController@razorrefund')->name('admin-order-razorrefund');
  Route::get('/order/{id}/razormanualrefund', 'Admin\OrderrefundController@razormanualrefund')->name('admin-order-razormanualrefund');
  Route::post('razorpay/refundamt', 'Admin\RazorpayController@refundamt')->name('admin-razorrefund-store');
  Route::post('razorpay/refundmanualamt', 'Admin\RazorpayController@refundmanualamt')->name('admin-refundmanualamt-store');
  Route::get('/order/{id}/packagingslip', 'Admin\OrderController@packagingslip')->name('admin-packaging-slip');
  Route::get('/order/{id}/invoice', 'Admin\OrderController@invoice')->name('admin-order-invoice');
  Route::get('/order/{id}/editbilling', 'Admin\OrderController@editbilling')->name('admin-order-editbilling');
  Route::get('/order/{id}/editshipping', 'Admin\OrderController@editshipping')->name('admin-order-editshipping');
  Route::post('/order/updatebilling/{id}', 'Admin\OrderController@updatebilling')->name('admin-order-updatebilling');
  Route::post('/order/updateshipping/{id}', 'Admin\OrderController@updateshipping')->name('admin-order-updateshipping');
  Route::get('/order/{id}/print', 'Admin\OrderController@printpage')->name('admin-order-print');
  Route::get('/order/{id1}/status/{status}', 'Admin\OrderController@status')->name('admin-order-status');
  Route::post('/order/email/', 'Admin\OrderController@emailsub')->name('admin-order-emailsub');
  Route::post('/order/addnote/', 'Admin\OrderController@customaddnote')->name('admin-order-customaddnote');
  Route::post('/order/{id}/license', 'Admin\OrderController@license')->name('admin-order-license');
  Route::post('/statusupdate', 'Admin\OrderController@statusupdate')->name('admin-order-status-update');
  Route::get('/order/{id}/tid', 'Admin\OrderController@tidgenerate')->name('admin-order-tidgenerate');
  Route::post('/order/{id}/uid', 'Admin\OrderController@tidupdate')->name('admin-order-tidupdate');

  // Order Tracking

  Route::get('/order/{id}/track', 'Admin\OrderTrackController@index')->name('admin-order-track');
  Route::get('/order/{id}/trackload', 'Admin\OrderTrackController@load')->name('admin-order-track-load');
  Route::post('/order/track/store', 'Admin\OrderTrackController@store')->name('admin-order-track-store');
  Route::get('/order/track/add', 'Admin\OrderTrackController@add')->name('admin-order-track-add');
  Route::get('/order/track/edit/{id}', 'Admin\OrderTrackController@edit')->name('admin-order-track-edit');
  Route::post('/order/track/update/{id}', 'Admin\OrderTrackController@update')->name('admin-order-track-update');
  Route::get('/order/track/delete/{id}', 'Admin\OrderTrackController@delete')->name('admin-order-track-delete');

  // Order Tracking Ends

  });

  //------------ ADMIN ORDER SECTION ENDS------------


  //------------ ADMIN PRODUCT SECTION ------------

  Route::group(['middleware'=>'permissions:products'],function(){

Route::get('/customenquiry/datatables', 'Admin\CustomenquiryController@datatables')->name('admin-customenquiry-datatables');  
  Route::get('/customenquiry', 'Admin\CustomenquiryController@index')->name('admin-customenquiry-index');
    
  Route::get('/products/datatables', 'Admin\ProductController@datatables')->name('admin-prod-datatables'); //JSON REQUEST
  Route::get('/products', 'Admin\ProductController@index')->name('admin-prod-index');
  
  Route::post('/priceupdate', 'Admin\ProductController@priceupdate')->name('admin-prod-price-update');
  
 
  Route::post('/bulkstockupdate', 'Admin\ProductController@bulkstockupdate')->name('admin-prod-bulkstock-update');
  
  Route::post('/products/upload/update/{id}', 'Admin\ProductController@uploadUpdate')->name('admin-prod-upload-update');
  Route::get('/products/productupdate/datatables', 'Admin\ProductController@productupdatedatatables')->name('admin-prod-productupdate-datatables'); //JSON REQUEST
  Route::get('/products/deactive/datatables', 'Admin\ProductController@deactivedatatables')->name('admin-prod-deactive-datatables'); //JSON REQUEST
  Route::get('/products/deactive', 'Admin\ProductController@deactive')->name('admin-prod-deactive');
  Route::get('/products/productupdate', 'Admin\ProductController@productupdate')->name('admin-prod-productupdate');


  Route::get('/products/catalogs/datatables', 'Admin\ProductController@catalogdatatables')->name('admin-prod-catalog-datatables'); //JSON REQUEST
  Route::get('/products/catalogs/', 'Admin\ProductController@catalogs')->name('admin-prod-catalog-index');

  // CREATE SECTION
  Route::get('/products/types', 'Admin\ProductController@types')->name('admin-prod-types');
  Route::get('/products/physical/create', 'Admin\ProductController@createPhysical')->name('admin-prod-physical-create');
  Route::get('/products/digital/create', 'Admin\ProductController@createDigital')->name('admin-prod-digital-create');
  Route::get('/products/license/create', 'Admin\ProductController@createLicense')->name('admin-prod-license-create');
  Route::post('/products/store', 'Admin\ProductController@store')->name('admin-prod-store');
  Route::get('/getattributes', 'Admin\ProductController@getAttributes')->name('admin-prod-getattributes');
  // CREATE SECTION

    // EDIT SECTION
  Route::get('/products/edit/{id}', 'Admin\ProductController@edit')->name('admin-prod-edit');
  Route::post('/products/edit/{id}', 'Admin\ProductController@update')->name('admin-prod-update');
  // EDIT SECTION ENDS

 // DELETE SECTION
  Route::get('/customenquiry/delete/{id}', 'Admin\CustomenquiryController@destroy')->name('admin-customenquiry-delete');
  // DELETE SECTION ENDS


  // DELETE SECTION
  Route::get('/products/delete/{id}', 'Admin\ProductController@destroy')->name('admin-prod-delete');
  // DELETE SECTION ENDS


  Route::get('/products/catalog/{id1}/{id2}', 'Admin\ProductController@catalog')->name('admin-prod-catalog');
  
  Route::get('/products/simpleproduct', 'Admin\ProductController@simpleproduct')->name('admin-prod-simpleproduct');
  Route::get('/products/simple_datatables', 'Admin\ProductController@simple_datatables')->name('admin-prod-simple-datatables'); //JSON REQUEST
  
   Route::get('/products/variationproduct', 'Admin\ProductController@variationproduct')->name('admin-prod-variationproduct');
  Route::get('/products/variation_datatables', 'Admin\ProductController@variation_datatables')->name('admin-prod-variation-datatables'); //JSON REQUEST
  //------------ ADMIN PRODUCT SECTION ENDS------------

  });

  //------------ ADMIN AFFILIATE PRODUCT SECTION ------------

  Route::group(['middleware'=>'permissions:affilate_products'],function(){

    Route::get('/products/import/create', 'Admin\ImportController@createImport')->name('admin-import-create');
    Route::get('/products/import/edit/{id}', 'Admin\ImportController@edit')->name('admin-import-edit');


    Route::get('/products/import/datatables', 'Admin\ImportController@datatables')->name('admin-import-datatables'); //JSON REQUEST
    Route::get('/products/import/index', 'Admin\ImportController@index')->name('admin-import-index');

    Route::post('/products/import/store', 'Admin\ImportController@store')->name('admin-import-store');
    Route::post('/products/import/update/{id}', 'Admin\ImportController@update')->name('admin-import-update');


    // DELETE SECTION
    Route::get('/affiliate/products/delete/{id}', 'Admin\ProductController@destroy')->name('admin-affiliate-prod-delete');
    // DELETE SECTION ENDS

  });

  //------------ ADMIN AFFILIATE PRODUCT SECTION ENDS ------------


  //------------ ADMIN USER SECTION ------------

  Route::group(['middleware'=>'permissions:customers'],function(){

  Route::get('/users/datatables', 'Admin\UserController@datatables')->name('admin-user-datatables'); //JSON REQUEST
  Route::get('/users', 'Admin\UserController@index')->name('admin-user-index');
  Route::get('/users/changepwd/{id}', 'Admin\UserController@changepwd')->name('admin-user-changepwd');
  Route::post('/users/passupdate/{id}', 'Admin\UserController@changepass')->name('user.password.update');
  Route::get('/users/edit/{id}', 'Admin\UserController@edit')->name('admin-user-edit');
  Route::post('/users/edit/{id}', 'Admin\UserController@update')->name('admin-user-update');
  Route::get('/users/delete/{id}', 'Admin\UserController@destroy')->name('admin-user-delete');
  Route::get('/user/{id}/show', 'Admin\UserController@show')->name('admin-user-show');
  Route::get('/users/ban/{id1}/{id2}', 'Admin\UserController@ban')->name('admin-user-ban');
  Route::get('/user/default/image', 'Admin\UserController@image')->name('admin-user-image');
  

  // WITHDRAW SECTION
  Route::get('/users/withdraws/datatables', 'Admin\UserController@withdrawdatatables')->name('admin-withdraw-datatables'); //JSON REQUEST
  Route::get('/users/withdraws', 'Admin\UserController@withdraws')->name('admin-withdraw-index');
  Route::get('/user/withdraw/{id}/show', 'Admin\UserController@withdrawdetails')->name('admin-withdraw-show');
  Route::get('/users/withdraws/accept/{id}', 'Admin\UserController@accept')->name('admin-withdraw-accept');
  Route::get('/user/withdraws/reject/{id}', 'Admin\UserController@reject')->name('admin-withdraw-reject');
  // WITHDRAW SECTION ENDS


  });

  //------------ ADMIN USER SECTION ENDS ------------

  //------------ ADMIN VENDOR SECTION ------------

  Route::group(['middleware'=>'permissions:vendors'],function(){

  Route::get('/vendors/datatables', 'Admin\VendorController@datatables')->name('admin-vendor-datatables');
  Route::get('/vendors', 'Admin\VendorController@index')->name('admin-vendor-index');
  Route::get('/vendors/register', 'Admin\VendorController@register')->name('admin-vendor-register');
  Route::post('/vendors/register', 'Admin\VendorController@addvendor')->name('admin-vendor-submit');
  Route::get('/vendors/{id}/show', 'Admin\VendorController@show')->name('admin-vendor-show');
  Route::get('/vendors/secret/login/{id}', 'Admin\VendorController@secret')->name('admin-vendor-secret');
  Route::get('/vendor/edit/{id}', 'Admin\VendorController@edit')->name('admin-vendor-edit');
  Route::post('/vendor/edit/{id}', 'Admin\VendorController@update')->name('admin-vendor-update');

  Route::get('/vendor/verify/{id}', 'Admin\VendorController@verify')->name('admin-vendor-verify');
  Route::get('/vendor/changepwd/{id}', 'Admin\VendorController@changepwd')->name('admin-vendor-changepwd');
  Route::post('/vendor/passupdate/{id}', 'Admin\VendorController@changepass')->name('vendor.password.update');
  Route::post('/vendor/verify/{id}', 'Admin\VendorController@verifySubmit')->name('admin-vendor-verify-submit');

  
  Route::get('/records', 'Vendor\RecordsController@records')->name('vendor.records');
  Route::post('/records', 'Vendor\RecordsController@records')->name('vendor.records.submit');

  Route::get('/vendors', 'Admin\VendorController@index')->name('admin-vendor-index');
  
  Route::get('/vendor/color', 'Admin\VendorController@color')->name('admin-vendor-color');
  Route::get('/vendors/status/{id1}/{id2}', 'Admin\VendorController@status')->name('admin-vendor-st');
  Route::get('/vendors/delete/{id}', 'Admin\VendorController@destroy')->name('admin-vendor-delete');

  Route::get('/vendors/adminapprovelist/datatables', 'Admin\VendorController@adminapprovelistdatatables')->name('admin-vendor-adminapprovelist-datatables'); //JSON REQUEST
  Route::get('/vendors/adminapprovelist', 'Admin\VendorController@adminapprovelist')->name('admin-vendor-adminapprovelist-index');
  Route::get('/vendors/adminapprove/accept/{id}', 'Admin\VendorController@adminapprove')->name('admin-vendor-adminapprove-accept');
  
  Route::get('/vendors/withdraws/datatables', 'Admin\VendorController@withdrawdatatables')->name('admin-vendor-withdraw-datatables'); //JSON REQUEST
  Route::get('/vendors/withdraws', 'Admin\VendorController@withdraws')->name('admin-vendor-withdraw-index');
  Route::get('/vendors/withdraw/{id}/show', 'Admin\VendorController@withdrawdetails')->name('admin-vendor-withdraw-show');
  Route::post('/vendors/withdraws/accept/{id}', 'Admin\VendorController@accept')->name('admin-vendor-withdraw-accept');
  Route::get('/vendors/withdraw/{id}/accepts', 'Admin\VendorController@accepts')->name('admin-vendor-withdraw-accepts');
  Route::get('/order/{id}/rejected', 'Admin\VendorController@rejected')->name('admin-order-rejected');
  Route::get('/vendors/{id}/withdrawslip', 'Admin\VendorController@withdrawslip')->name('admin-vendor-withdrawslip');
  Route::get('/vendors/{id}/withdrawexcel', 'Admin\VendorController@withdrawexcel')->name('admin-vendor-withdrawexcel');
  Route::post('/vendors/withdraws/reject/{id}', 'Admin\VendorController@reject')->name('admin-vendor-withdraw-reject');

  //  Vendor Registration Section

  Route::get('/general-settings/vendor-registration/{status}', 'Admin\GeneralSettingController@regvendor')->name('admin-gs-regvendor');

  //  Vendor Registration Section Ends



// Verification Section

  Route::get('/verificatons/datatables/{status}', 'Admin\VerificationController@datatables')->name('admin-vr-datatables');
  Route::get('/verificatons', 'Admin\VerificationController@index')->name('admin-vr-index');
  Route::get('/verificatons/pendings', 'Admin\VerificationController@pending')->name('admin-vr-pending');

  Route::get('/verificatons/show', 'Admin\VerificationController@show')->name('admin-vr-show');
  Route::get('/verificatons/edit/{id}', 'Admin\VerificationController@edit')->name('admin-vr-edit');
  Route::post('/verificatons/edit/{id}', 'Admin\VerificationController@update')->name('admin-vr-update');
  Route::get('/verificatons/status/{id1}/{id2}', 'Admin\VerificationController@status')->name('admin-vr-st');
  Route::get('/verificatons/delete/{id}', 'Admin\VerificationController@destroy')->name('admin-vr-delete');
  
  // Admin Coupon Section
  Route::get('/couponcodes', 'Admin\AdminCouponController@index')->name('admin-coupon-code');  
  Route::post('/couponcodes/store', 'Admin\AdminCouponController@store')->name('admin-coupon-submit');  
  Route::get('/cload/order/{id}/', 'Admin\AdminCouponController@cload')->name('order-data-cload');    
  Route::get('/couponcodes/alllist', 'Admin\AdminCouponController@alllist')->name('admin-coupon-alllist');
  Route::get('/couponcodes/alllist_datatables', 'Admin\AdminCouponController@alllist_datatables')->name('admin-load-alllist');
  Route::get('/couponcodes/approvallist', 'Admin\AdminCouponController@approvallist')->name('admin-coupon-approvallist');
  Route::get('/couponcodes/approvallist_datatables', 'Admin\AdminCouponController@approvallist_datatables')->name('admin-load-approvallist');
  Route::get('/couponcodes/rejectlist', 'Admin\AdminCouponController@rejectlist')->name('admin-coupon-rejectlist');
  Route::get('/couponcodes/rejectlist_datatables', 'Admin\AdminCouponController@rejectlist_datatables')->name('admin-load-rejectlist');
  Route::get('/couponcodes/app_loads/{id}', 'Admin\AdminCouponController@app_loads')->name('admin-approval-loads');
  Route::post('/couponcodes/approval/{id}', 'Admin\AdminCouponController@approval')->name('admin-approval-update');
  Route::get('/couponcodes/rej_loads/{id}', 'Admin\AdminCouponController@rej_loads')->name('admin-reject-loads');
  Route::post('/couponcodes/reject/{id}', 'Admin\AdminCouponController@reject')->name('admin-reject-update');
  Route::get('all-coupon-code/{type}', array('as'=>'all-coupon-code','uses'=>'Admin\AdminCouponController@allcouponcode'));
  Route::get('used-coupon-code/{type}', array('as'=>'used-coupon-code','uses'=>'Admin\AdminCouponController@usedcouponcode'));
  Route::get('unused-coupon-code/{type}', array('as'=>'unused-coupon-code','uses'=>'Admin\AdminCouponController@unusedcouponcode'));
  Route::get('expired-coupon-code/{type}', array('as'=>'expired-coupon-code','uses'=>'Admin\AdminCouponController@expiredcouponcode'));  
 
  
  // Raise Dispute Section
  Route::get('/raisedispute', 'Admin\RaiseDisputeController@index')->name('admin-raise-dispute');
  Route::get('/raisedisputeadd/{id1}/{id2}/', 'Admin\RaiseDisputeController@add')->name('admin-raise-adispute');
  Route::post('/raisedispute/store', 'Admin\RaiseDisputeController@store')->name('admin-raisedispute-submit');
  Route::post('/raisedispute/addstore', 'Admin\RaiseDisputeController@addstore')->name('addstore-raisedispute-submit');
  Route::get('/load/order/{id}/', 'Admin\RaiseDisputeController@load')->name('order-data-load');
  Route::get('/pload/product/{id}/', 'Admin\RaiseDisputeController@pload')->name('product-data-pload');  
  Route::get('/raisedispute/opendispute', 'Admin\RaiseDisputeController@opendispute')->name('admin-open-dispute');
  Route::get('/raisedispute/opendispute_datatables', 'Admin\RaiseDisputeController@opendispute_datatables')->name('admin-load-open-dispute');
  Route::get('/raisedispute/resolved', 'Admin\RaiseDisputeController@resolved')->name('admin-resolved-dispute');
  Route::get('/raisedispute/resolved_datatables', 'Admin\RaiseDisputeController@resolved_datatables')->name('admin-load-resolved-dispute');
  Route::get('/raisedispute/decline', 'Admin\RaiseDisputeController@decline')->name('admin-decline-dispute');
  Route::get('/raisedispute/decline_datatables', 'Admin\RaiseDisputeController@decline_datatables')->name('admin-load-decline-dispute');  
  Route::get('/raisedispute/{id}/show', 'Admin\RaiseDisputeController@show')->name('admin-dispute-show');
  Route::get('/raisedispute/{id}/addshow', 'Admin\RaiseDisputeController@addshow')->name('admin-dispute-addshow');  
  Route::post('/raisedispute/rstatus/{id}', 'Admin\RaiseDisputeController@rstatus')->name('admin-rstatus-update');
  Route::post('/raisedispute/dstatus/{id}', 'Admin\RaiseDisputeController@dstatus')->name('admin-dstatus-update');  
  Route::post('/raisedispute/refonline/{id}', 'Admin\RaiseDisputeController@refundonline')->name('admin-refundonline-update');
  Route::post('/raisedispute/refoffline/{id}', 'Admin\RaiseDisputeController@refundoffline')->name('admin-refundoffline-update');
  Route::post('/raisedispute/refundcoupon/{id}', 'Admin\RaiseDisputeController@refundcoupon')->name('admin-refundcoupon-update');
  Route::get('download-raise-dispute/{type}', array('as'=>'admindw-raise-dispute','uses'=>'Admin\RaiseDisputeController@export'));
  Route::post('/raisedispute/adddocument/{id}', 'Admin\RaiseDisputeController@adddocument')->name('admin-raisedocument-update');
  Route::get('raisedispute-excel-file/{type}', array('as'=>'raisedispute-excel-file','uses'=>'Admin\RaiseDisputeController@allraisedisputeExcelFile'));
  
  
   // Debit Note Section
  Route::get('/debitnote', 'Admin\DebitNoteController@index')->name('admin-debitnote-list');
  Route::get('/debitnoteadd/{id1}/{id2}/', 'Admin\DebitNoteController@add')->name('admin-add-debitnote');
  Route::post('/debitnote/store', 'Admin\DebitNoteController@store')->name('admin-debitnote-submit');
  Route::post('/debitnote/addstore', 'Admin\DebitNoteController@addstore')->name('addstore-debitnote-submit');
  Route::get('/load/orders/{id}/', 'Admin\DebitNoteController@load')->name('order-debit-load');
  Route::get('/prload/product/{id}/', 'Admin\DebitNoteController@pload')->name('product-debit-pload');  
  Route::get('/prload/product/{id}/', 'Admin\DebitNoteController@ptload')->name('product-debit-ptload');  
  Route::get('/ptload/product/{id}/', 'Admin\DebitNoteController@ptload')->name('product-data-ptload');   
  Route::get('/debitnote/unsettle', 'Admin\DebitNoteController@opendebit')->name('admin-open-debit');
  Route::get('/debitnote/opendebit_datatables', 'Admin\DebitNoteController@opendebit_datatables')->name('admin-load-open-debit');
  Route::get('/debitnote/settle', 'Admin\DebitNoteController@resolved')->name('admin-resolved-debit');
  Route::get('/debitnote/resolved_datatables', 'Admin\DebitNoteController@resolved_datatables')->name('admin-load-resolved-debit');
  Route::get('/debitnote/cancelled', 'Admin\DebitNoteController@decline')->name('admin-decline-debit');
  Route::get('/debitnote/decline_datatables', 'Admin\DebitNoteController@decline_datatables')->name('admin-load-decline-debit');
  Route::get('/debitnote/{id}/unsettle', 'Admin\DebitNoteController@show')->name('admin-debitnote-show');
  Route::get('/debitnote/{id}/cancelled', 'Admin\DebitNoteController@cancelled')->name('admin-debitnote-cancelled');   
  Route::post('/debitnote/rstatus/{id}', 'Admin\DebitNoteController@rstatus')->name('admin-debitrstatus-update');
  Route::post('/debitnote/cancelstatus/{id}', 'Admin\DebitNoteController@cancelstatus')->name('debit-cancel-status');
  Route::get('download-debit/{type}', array('as'=>'admindw-down-debit','uses'=>'Admin\DebitNoteController@export'));
  Route::post('/debitnote/adddocument/{id}', 'Admin\DebitNoteController@adddocument')->name('admin-debitdocument-update');
  Route::get('debitnote-excel-file/{type}', array('as'=>'debitnote-excel-file','uses'=>'Admin\DebitNoteController@alldebitExcelFile'));  
  
  // credit Note Section
  Route::get('/creditnote', 'Admin\CreditNoteController@index')->name('admin-creditnote-list');
  Route::get('/creditnoteadd/{id1}/{id2}/', 'Admin\CreditNoteController@add')->name('admin-add-creditnote');
  Route::post('/creditnote/store', 'Admin\CreditNoteController@store')->name('admin-creditnote-submit');
  Route::post('/creditnote/addstore', 'Admin\CreditNoteController@addstore')->name('addstore-creditnote-submit');
  Route::get('/load/corders/{id}/', 'Admin\CreditNoteController@load')->name('order-crdit-load');
  Route::get('/prloads/product/{id}/', 'Admin\CreditNoteController@pload')->name('product-credit-pload');  
  Route::get('/creditnote/unsettle', 'Admin\CreditNoteController@opencredit')->name('admin-open-credit');
  Route::get('/creditnote/opencredit_datatables', 'Admin\CreditNoteController@opencredit_datatables')->name('admin-load-open-credit');
  Route::get('/creditnote/settle', 'Admin\CreditNoteController@resolved')->name('admin-resolved-credit');
  Route::get('/creditnote/resolved_datatables', 'Admin\CreditNoteController@resolved_datatables')->name('admin-load-resolved-credit');
  Route::get('/creditnote/cancelled', 'Admin\CreditNoteController@decline')->name('admin-decline-credit');
  Route::get('/creditnote/decline_datatables', 'Admin\CreditNoteController@decline_datatables')->name('admin-load-decline-credit');
  Route::get('/creditnote/{id}/unsettle', 'Admin\CreditNoteController@show')->name('admin-creditnote-show'); 
  Route::get('/creditnote/{id}/cancelled', 'Admin\CreditNoteController@cancelled')->name('admin-creditnote-cancelled');  
  Route::post('/creditnote/rstatus/{id}', 'Admin\CreditNoteController@rstatus')->name('admin-creditrstatus-update');
  Route::post('/creditnote/cancelstatus/{id}', 'Admin\CreditNoteController@cancelstatus')->name('credit-cancel-status');
  Route::get('download-credit/{type}', array('as'=>'admindw-down-credit','uses'=>'Admin\CreditNoteController@export'));
  Route::post('/creditnote/adddocument/{id}', 'Admin\CreditNoteController@adddocument')->name('admin-creditdocument-update');
  Route::get('creditnote-excel-file/{type}', array('as'=>'creditnote-excel-file','uses'=>'Admin\CreditNoteController@allcreditExcelFile'));
  
  // Exchange Section
  Route::get('/exchangeod', 'Admin\ExchangeController@index')->name('admin-order-exchange');
  Route::get('/exchangeodadd/{id1}/{id2}/', 'Admin\ExchangeController@add')->name('admin-order-aexchange');
  Route::post('/exchangeod/store', 'Admin\ExchangeController@store')->name('admin-exchangeod-submit');
  Route::post('/exchangeod/addstore', 'Admin\ExchangeController@addstore')->name('addstore-exchangeod-submit');
  Route::get('/loads/orders/{id}/', 'Admin\ExchangeController@load')->name('orders-data-loads');
  Route::get('/ploads/products/{id}/', 'Admin\ExchangeController@pload')->name('products-data-ploads');  
  Route::get('/exchangeod/openexchange', 'Admin\ExchangeController@openexchange')->name('admin-open-exchange');
  Route::get('/exchangeod/openexchange_datatables', 'Admin\ExchangeController@openexchange_datatables')->name('admin-load-open-exchange');
  Route::get('/exchangeod/ship', 'Admin\ExchangeController@shipexchange')->name('admin-ship-exchange');
  Route::get('/exchangeod/ship_datatables', 'Admin\ExchangeController@shipexchange_datatables')->name('admin-load-ship-exchange');
  Route::get('/exchangeod/resolved', 'Admin\ExchangeController@resolved')->name('admin-resolved-exchange');
  Route::get('/exchangeod/resolved_datatables', 'Admin\ExchangeController@resolved_datatables')->name('admin-load-resolved-exchange');  
  Route::get('/exchangeod/notdeliveredexchange', 'Admin\ExchangeController@notdeliveredexchange')->name('admin-notdelivered-exchange');  
  Route::get('/exchangeod/notdelivered_datatables', 'Admin\ExchangeController@notdelivered_datatables')->name('admin-load-notdelivered-exchange');  
  Route::get('/exchangeod/decline', 'Admin\ExchangeController@decline')->name('admin-decline-exchange');
  Route::get('/exchangeod/decline_datatables', 'Admin\ExchangeController@decline_datatables')->name('admin-load-decline-exchange');  
  Route::get('/exchangeod/{id}/show', 'Admin\ExchangeController@show')->name('admin-exchange-show');  
  Route::get('/exchangeod/loads/{id}', 'Admin\ExchangeController@loads')->name('admin-exchange-loads');
  Route::get('/exchangeod/nloads/{id}', 'Admin\ExchangeController@nloads')->name('admin-exchange-nloads');
  Route::post('/exchangeod/exchangestatus/{id}', 'Admin\ExchangeController@exchangestatus')->name('admin-exchange-update');
  Route::post('/exchangeod/dstatus/{id}', 'Admin\ExchangeController@dstatus')->name('admin-dstatus-exchange');
  //Route::post('/exchangeod/notdelivered/{id}', 'Admin\ExchangeController@notdelivered')->name('admin-exchange-notdelivered');
  Route::get('/exchangeod/notdelivered/{id}', 'Admin\ExchangeController@notdelivered')->name('admin-exchange-notdelivered');
  Route::post('/exchangeod/notdelivered/{id}', 'Admin\ExchangeController@estatus')->name('admin-exch-update');
  Route::post('/exchangeod/adddocument/{id}', 'Admin\ExchangeController@adddocument')->name('admin-exchangedocument-update');
  //Route::get('/exchangeod/notdelivered','Admin\ExchangeController@notdelivered')->name('admin-exchange-notdelivered');
  Route::get('exchange-excel-file/{type}', array('as'=>'exchange-excel-file','uses'=>'Admin\ExchangeController@allexchangeExcelFile'));


// Rto Section
  Route::get('/rtood', 'Admin\RtoController@index')->name('admin-order-rto');
  Route::get('/rtoodadd/{id1}/{id2}/', 'Admin\RtoController@add')->name('admin-order-arto');
  Route::post('/rtood/store', 'Admin\RtoController@store')->name('admin-rtood-submit');
  Route::post('/rtood/addstore', 'Admin\RtoController@addstore')->name('addstore-rtood-submit');
  Route::get('/loads/orders/{id}/', 'Admin\RtoController@load')->name('orders-data-loads');
  Route::get('/ploads/products/{id}/', 'Admin\RtoController@pload')->name('products-data-ploads');  
  Route::get('/rtood/openrto', 'Admin\RtoController@openrto')->name('admin-open-rto');
  Route::get('/rtood/openrto_datatables', 'Admin\RtoController@openrto_datatables')->name('admin-load-open-rto');
  Route::get('/rtood/ship', 'Admin\RtoController@shiprto')->name('admin-ship-rto');
  Route::get('/rtood/ship_datatables', 'Admin\RtoController@shiprto_datatables')->name('admin-load-ship-rto');
  Route::get('/rtood/resolved', 'Admin\RtoController@resolved')->name('admin-resolved-rto');
  Route::get('/rtood/resolved_datatables', 'Admin\RtoController@resolved_datatables')->name('admin-load-resolved-rto');
  Route::get('/rtood/notdeliveredrto', 'Admin\RtoController@notdeliveredrto')->name('admin-notdelivered-rto');
  Route::get('/rtood/notdelivered_datatables', 'Admin\RtoController@notdelivered_datatables')->name('admin-load-notdelivered-rto');
  Route::get('/rtood/decline', 'Admin\RtoController@decline')->name('admin-decline-rto');
  Route::get('/rtood/decline_datatables', 'Admin\RtoController@decline_datatables')->name('admin-load-decline-rto');  
  Route::get('/rtood/{id}/show', 'Admin\RtoController@show')->name('admin-rto-show');  
  Route::get('/rtood/loads/{id}', 'Admin\RtoController@loads')->name('admin-rto-loads');
  Route::get('/rtood/nloads/{id}', 'Admin\RtoController@nloads')->name('admin-rto-nloads');
  Route::post('/rtood/rtostatus/{id}', 'Admin\RtoController@rtostatus')->name('admin-rto-update');
  Route::post('/rtood/dstatus/{id}', 'Admin\RtoController@dstatus')->name('admin-dstatus-rto');
  Route::get('/rtood/notdelivered/{id}', 'Admin\RtoController@notdelivered')->name('admin-rto-notdelivered');
  Route::post('/rtood/notdelivered/{id}', 'Admin\RtoController@estatus')->name('admin-rtoh-update');
  Route::get('rto-excel-file/{type}', array('as'=>'rto-excel-file','uses'=>'Admin\RtoController@allrtoExcelFile'));  

// Dispute Section
  Route::get('/disputedata', 'Admin\DisputeController@index')->name('admin-order-disputes');
  Route::get('/disputes/{id1}/{id2}/', 'Admin\DisputeController@add')->name('admin-order-adisputes');
  Route::post('/disputes/store', 'Admin\DisputeController@store')->name('admin-disputes-submit');
  Route::post('/disputes/addstore', 'Admin\DisputeController@addstore')->name('addstore-disputes-submit');
  Route::get('/disload/orders/{id}/', 'Admin\DisputeController@disload')->name('orders-data-disload');
  Route::get('/dispload/products/{id}/', 'Admin\DisputeController@dispload')->name('products-data-dispload');
  Route::get('/disputes/opendispute', 'Admin\DisputeController@opendispute')->name('admin-open-disputes');
  Route::get('/disputes/opendispute_datatables', 'Admin\DisputeController@opendispute_datatables')->name('admin-load-open-disputes');
  Route::get('/disputeds/resolved', 'Admin\DisputeController@resolved')->name('admin-resolved-disputeds');
  Route::get('/disputeds/resolved_datatables', 'Admin\DisputeController@resolved_datatables')->name('admin-load-resolved-disputeds');
  Route::get('/disputeds/{id}/show', 'Admin\DisputeController@show')->name('admin-disputeds-show');
  Route::post('/disputeds/ustatus/{id}', 'Admin\DisputeController@ustatus')->name('admin-disputeds-status');
  Route::get('dispute-excel-file/{type}', array('as'=>'dispute-excel-file','uses'=>'Admin\DisputeController@alldisputeExcelFile'));  
  
  });




  //------------ ADMIN VENDOR SECTION ENDS ------------


  //------------ ADMIN SUBSCRIPTION SECTION ------------

  Route::group(['middleware'=>'permissions:vendor_subscription_plans'],function(){

  Route::get('/subscription/datatables', 'Admin\SubscriptionController@datatables')->name('admin-subscription-datatables');
  Route::get('/subscription', 'Admin\SubscriptionController@index')->name('admin-subscription-index');
  Route::get('/subscription/create', 'Admin\SubscriptionController@create')->name('admin-subscription-create');
  Route::post('/subscription/create', 'Admin\SubscriptionController@store')->name('admin-subscription-store');
  Route::get('/subscription/edit/{id}', 'Admin\SubscriptionController@edit')->name('admin-subscription-edit');
  Route::post('/subscription/edit/{id}', 'Admin\SubscriptionController@update')->name('admin-subscription-update');
  Route::get('/subscription/delete/{id}', 'Admin\SubscriptionController@destroy')->name('admin-subscription-delete');

  Route::get('/vendors/subs/datatables', 'Admin\VendorController@subsdatatables')->name('admin-vendor-subs-datatables');
  Route::get('/vendors/subs', 'Admin\VendorController@subs')->name('admin-vendor-subs');
  Route::get('/vendors/sub/{id}', 'Admin\VendorController@sub')->name('admin-vendor-sub');

  });

  //------------ ADMIN SUBSCRIPTION SECTION ENDS ------------


  //------------ ADMIN CATEGORY SECTION ------------

  Route::group(['middleware'=>'permissions:categories'],function(){

  Route::get('/category/datatables', 'Admin\CategoryController@datatables')->name('admin-cat-datatables'); //JSON REQUEST
  Route::get('/category', 'Admin\CategoryController@index')->name('admin-cat-index');
  Route::get('/category/create', 'Admin\CategoryController@create')->name('admin-cat-create');
  Route::post('/category/create', 'Admin\CategoryController@store')->name('admin-cat-store');
  Route::get('/category/edit/{id}', 'Admin\CategoryController@edit')->name('admin-cat-edit');
  Route::post('/category/edit/{id}', 'Admin\CategoryController@update')->name('admin-cat-update');
  Route::get('/category/delete/{id}', 'Admin\CategoryController@destroy')->name('admin-cat-delete');
  Route::get('/category/status/{id1}/{id2}', 'Admin\CategoryController@status')->name('admin-cat-status');


  //------------ ADMIN ATTRIBUTE SECTION ------------

  Route::get('/attribute/datatables', 'Admin\AttributeController@datatables')->name('admin-attr-datatables'); //JSON REQUEST
  Route::get('/attribute', 'Admin\AttributeController@index')->name('admin-attr-index');
  Route::get('/attribute/{catid}/attrCreateForCategory', 'Admin\AttributeController@attrCreateForCategory')->name('admin-attr-createForCategory');
  Route::get('/attribute/{subcatid}/attrCreateForSubcategory', 'Admin\AttributeController@attrCreateForSubcategory')->name('admin-attr-createForSubcategory');
  Route::get('/attribute/{childcatid}/attrCreateForChildcategory', 'Admin\AttributeController@attrCreateForChildcategory')->name('admin-attr-createForChildcategory');
  Route::post('/attribute/store', 'Admin\AttributeController@store')->name('admin-attr-store');
  Route::get('/attribute/{id}/manage', 'Admin\AttributeController@manage')->name('admin-attr-manage');
  Route::get('/attribute/{attrid}/edit', 'Admin\AttributeController@edit')->name('admin-attr-edit');
  Route::post('/attribute/edit/{id}', 'Admin\AttributeController@update')->name('admin-attr-update');
  Route::get('/attribute/{id}/options', 'Admin\AttributeController@options')->name('admin-attr-options');
  Route::get('/attribute/delete/{id}', 'Admin\AttributeController@destroy')->name('admin-attr-delete');


  // SUBCATEGORY SECTION ------------

  Route::get('/subcategory/datatables', 'Admin\SubCategoryController@datatables')->name('admin-subcat-datatables'); //JSON REQUEST
  Route::get('/subcategory', 'Admin\SubCategoryController@index')->name('admin-subcat-index');
  Route::get('/subcategory/create', 'Admin\SubCategoryController@create')->name('admin-subcat-create');
  Route::post('/subcategory/create', 'Admin\SubCategoryController@store')->name('admin-subcat-store');
  Route::get('/subcategory/edit/{id}', 'Admin\SubCategoryController@edit')->name('admin-subcat-edit');
  Route::post('/subcategory/edit/{id}', 'Admin\SubCategoryController@update')->name('admin-subcat-update');
  Route::get('/subcategory/delete/{id}', 'Admin\SubCategoryController@destroy')->name('admin-subcat-delete');
  Route::get('/subcategory/status/{id1}/{id2}', 'Admin\SubCategoryController@status')->name('admin-subcat-status');
  Route::get('/load/subcategories/{id}/', 'Admin\SubCategoryController@load')->name('admin-subcat-load'); //JSON REQUEST

  // SUBCATEGORY SECTION ENDS------------

  // CHILDCATEGORY SECTION ------------

  Route::get('/childcategory/datatables', 'Admin\ChildCategoryController@datatables')->name('admin-childcat-datatables'); //JSON REQUEST
  Route::get('/childcategory', 'Admin\ChildCategoryController@index')->name('admin-childcat-index');
  Route::get('/childcategory/create', 'Admin\ChildCategoryController@create')->name('admin-childcat-create');
  Route::post('/childcategory/create', 'Admin\ChildCategoryController@store')->name('admin-childcat-store');
  Route::get('/childcategory/edit/{id}', 'Admin\ChildCategoryController@edit')->name('admin-childcat-edit');
  Route::post('/childcategory/edit/{id}', 'Admin\ChildCategoryController@update')->name('admin-childcat-update');
  Route::get('/childcategory/delete/{id}', 'Admin\ChildCategoryController@destroy')->name('admin-childcat-delete');
  Route::get('/childcategory/status/{id1}/{id2}', 'Admin\ChildCategoryController@status')->name('admin-childcat-status');
  Route::get('/load/childcategories/{id}/', 'Admin\ChildCategoryController@load')->name('admin-childcat-load'); //JSON REQUEST

  // CHILDCATEGORY SECTION ENDS------------

  });

  //------------ ADMIN CATEGORY SECTION ENDS------------


  //------------ ADMIN CSV IMPORT SECTION ------------

  Route::group(['middleware'=>'permissions:bulk_product_upload'],function(){

    Route::get('/products/import', 'Admin\ProductController@import')->name('admin-prod-import');
    Route::post('/products/import-submit', 'Admin\ProductController@importSubmit')->name('admin-prod-importsubmit');

    });

  //------------ ADMIN CSV IMPORT SECTION ENDS ------------

  //------------ ADMIN PRODUCT DISCUSSION SECTION ------------

    Route::group(['middleware'=>'permissions:product_discussion'],function(){
		
		// RATING SECTION ENDS------------

    Route::get('/ratings/datatables', 'Admin\RatingController@datatables')->name('admin-rating-datatables'); //JSON REQUEST
    Route::get('/ratings', 'Admin\RatingController@index')->name('admin-rating-index');
    Route::get('/ratings/delete/{id}', 'Admin\RatingController@destroy')->name('admin-rating-delete');
    Route::get('/ratings/show/{id}', 'Admin\RatingController@show')->name('admin-rating-show');

    // RATING SECTION ENDS------------   

    // COMMENT SECTION ------------

    Route::get('/comments/datatables', 'Admin\CommentController@datatables')->name('admin-comment-datatables'); //JSON REQUEST
    Route::get('/comments', 'Admin\CommentController@index')->name('admin-comment-index');
    Route::get('/comments/delete/{id}', 'Admin\CommentController@destroy')->name('admin-comment-delete');
    Route::get('/comments/show/{id}', 'Admin\CommentController@show')->name('admin-comment-show');

    // COMMENT CHECK
    Route::get('/general-settings/comment/{status}', 'Admin\GeneralSettingController@comment')->name('admin-gs-iscomment');
    // COMMENT CHECK ENDS


    // COMMENT SECTION ENDS ------------

    // REPORT SECTION ------------

    Route::get('/reports/datatables', 'Admin\ReportController@datatables')->name('admin-report-datatables'); //JSON REQUEST
    Route::get('/reports', 'Admin\ReportController@index')->name('admin-report-index');
    Route::get('/reports/delete/{id}', 'Admin\ReportController@destroy')->name('admin-report-delete');
    Route::get('/reports/show/{id}', 'Admin\ReportController@show')->name('admin-report-show');	
	// Reviews SECTION ENDS------------

    Route::get('/reviews/datatables', 'Admin\ReviewsController@datatables')->name('admin-reviews-datatables'); //JSON REQUEST
    Route::get('/reviews', 'Admin\ReviewsController@index')->name('admin-reviews-index');
    Route::get('/reviews/delete/{id}', 'Admin\ReviewsController@destroy')->name('admin-reviews-delete');
    Route::get('/reviews/show/{id}', 'Admin\ReviewsController@show')->name('admin-reviews-show');
	Route::get('/managecategory', 'Admin\ManagecategoryController@index')->name('admin-manage-cat');
	Route::get('/reviews/status/{id1}/{id2}', 'Admin\ReviewsController@status')->name('admin-reviews-status');


    // REPORT CHECK
    Route::get('/general-settings/report/{status}', 'Admin\GeneralSettingController@isreport')->name('admin-gs-isreport');
    // REPORT CHECK ENDS

    // REPORT SECTION ENDS ------------

    });

 //------------ ADMIN PRODUCT DISCUSSION SECTION ENDS ------------


  //------------ ADMIN COUPON SECTION ------------

  Route::group(['middleware'=>'permissions:set_coupons'],function(){

  Route::get('/coupon/datatables', 'Admin\CouponController@datatables')->name('admin-coupon-datatables'); //JSON REQUEST
  Route::get('/coupon', 'Admin\CouponController@index')->name('admin-coupon-index');
  
  
  Route::get('/searchresult/datatables/{type}', 'Admin\SearchResultController@datatables')->name('admin-searchresult-datatables');
  Route::get('/searchlisting', 'Admin\SearchResultController@index')->name('admin-searchresult-index');
  
  Route::get('/coupon/create', 'Admin\CouponController@create')->name('admin-coupon-create');
  Route::post('/coupon/create', 'Admin\CouponController@store')->name('admin-coupon-store');
  Route::get('/coupon/edit/{id}', 'Admin\CouponController@edit')->name('admin-coupon-edit');
  Route::post('/coupon/edit/{id}', 'Admin\CouponController@update')->name('admin-coupon-update');
  Route::get('/coupon/delete/{id}', 'Admin\CouponController@destroy')->name('admin-coupon-delete');
  Route::get('/coupon/status/{id1}/{id2}', 'Admin\CouponController@status')->name('admin-coupon-status');

  });

  //------------ ADMIN COUPON SECTION ENDS------------

  //------------ ADMIN BLOG SECTION ------------

  Route::group(['middleware'=>'permissions:blog'],function(){

  Route::get('/blog/datatables', 'Admin\BlogController@datatables')->name('admin-blog-datatables'); //JSON REQUEST
  Route::get('/blog', 'Admin\BlogController@index')->name('admin-blog-index');
  Route::get('/blog/create', 'Admin\BlogController@create')->name('admin-blog-create');
  Route::post('/blog/create', 'Admin\BlogController@store')->name('admin-blog-store');
  Route::get('/blog/edit/{id}', 'Admin\BlogController@edit')->name('admin-blog-edit');
  Route::post('/blog/edit/{id}', 'Admin\BlogController@update')->name('admin-blog-update');
  Route::get('/blog/delete/{id}', 'Admin\BlogController@destroy')->name('admin-blog-delete');

  Route::get('/blog/category/datatables', 'Admin\BlogCategoryController@datatables')->name('admin-cblog-datatables'); //JSON REQUEST
  Route::get('/blog/category', 'Admin\BlogCategoryController@index')->name('admin-cblog-index');
  Route::get('/blog/category/create', 'Admin\BlogCategoryController@create')->name('admin-cblog-create');
  Route::post('/blog/category/create', 'Admin\BlogCategoryController@store')->name('admin-cblog-store');
  Route::get('/blog/category/edit/{id}', 'Admin\BlogCategoryController@edit')->name('admin-cblog-edit');
  Route::post('/blog/category/edit/{id}', 'Admin\BlogCategoryController@update')->name('admin-cblog-update');
  Route::get('/blog/category/delete/{id}', 'Admin\BlogCategoryController@destroy')->name('admin-cblog-delete');

  });

  //------------ ADMIN BLOG SECTION ENDS ------------

   //------------ ADMIN media SECTION ------------

  Route::group(['middleware'=>'permissions:media'],function(){

    Route::get('/media/datatables', 'Admin\MediaController@datatables')->name('admin-media-datatables'); //JSON REQUEST
    Route::get('/media', 'Admin\MediaController@index')->name('admin-media-index');
    Route::get('/media/create', 'Admin\MediaController@create')->name('admin-media-create');
    Route::post('/media/create', 'Admin\MediaController@store')->name('admin-media-store');
    Route::get('/media/edit/{id}', 'Admin\MediaController@edit')->name('admin-media-edit');
    Route::post('/media/edit/{id}', 'Admin\MediaController@update')->name('admin-media-update');
    Route::get('/media/delete/{id}', 'Admin\MediaController@destroy')->name('admin-media-delete');
  });

  //------------ ADMIN media SECTION ENDS ------------


  //------------ ADMIN USER MESSAGE SECTION ------------

  Route::group(['middleware'=>'permissions:messages'],function(){

  Route::get('/messages/datatables/{type}', 'Admin\MessageController@datatables')->name('admin-message-datatables');
  Route::get('/tickets', 'Admin\MessageController@index')->name('admin-message-index');
  Route::get('/disputes', 'Admin\MessageController@disputes')->name('admin-message-dispute');
  Route::get('/message/{id}', 'Admin\MessageController@message')->name('admin-message-show');
  Route::get('/message/load/{id}', 'Admin\MessageController@messageshow')->name('admin-message-load');
  Route::post('/message/post', 'Admin\MessageController@postmessage')->name('admin-message-store');
  Route::get('/message/{id}/delete', 'Admin\MessageController@messagedelete')->name('admin-message-delete');
  Route::post('/user/send/message', 'Admin\MessageController@usercontact')->name('admin-send-message');

  });

  //------------ ADMIN USER MESSAGE SECTION ENDS ------------

  //------------ ADMIN GENERAL SETTINGS SECTION ------------

  Route::group(['middleware'=>'permissions:general_settings'],function(){

  Route::get('/general-settings/logo', 'Admin\GeneralSettingController@logo')->name('admin-gs-logo');
  Route::get('/general-settings/favicon', 'Admin\GeneralSettingController@fav')->name('admin-gs-fav');
  Route::get('/general-settings/loader', 'Admin\GeneralSettingController@load')->name('admin-gs-load');
  Route::get('/general-settings/contents', 'Admin\GeneralSettingController@contents')->name('admin-gs-contents');
  Route::get('/general-settings/footer', 'Admin\GeneralSettingController@footer')->name('admin-gs-footer');
  Route::get('/general-settings/affilate', 'Admin\GeneralSettingController@affilate')->name('admin-gs-affilate');
  Route::get('/general-settings/error-banner', 'Admin\GeneralSettingController@errorbanner')->name('admin-gs-error-banner');
  Route::get('/general-settings/popup', 'Admin\GeneralSettingController@popup')->name('admin-gs-popup');
  Route::get('/general-settings/maintenance', 'Admin\GeneralSettingController@maintain')->name('admin-gs-maintenance');
  //------------ ADMIN PICKUP LOACTION ------------

  Route::get('/pickup/datatables', 'Admin\PickupController@datatables')->name('admin-pick-datatables'); //JSON REQUEST
  Route::get('/pickup', 'Admin\PickupController@index')->name('admin-pick-index');
  Route::get('/pickup/create', 'Admin\PickupController@create')->name('admin-pick-create');
  Route::post('/pickup/create', 'Admin\PickupController@store')->name('admin-pick-store');
  Route::get('/pickup/edit/{id}', 'Admin\PickupController@edit')->name('admin-pick-edit');
  Route::post('/pickup/edit/{id}', 'Admin\PickupController@update')->name('admin-pick-update');
  Route::get('/pickup/delete/{id}', 'Admin\PickupController@destroy')->name('admin-pick-delete');

  //------------ ADMIN PICKUP LOACTION ENDS ------------

  //------------ ADMIN SHIPPING ------------

  Route::get('/shipping/datatables', 'Admin\ShippingController@datatables')->name('admin-shipping-datatables');
  Route::get('/shipping', 'Admin\ShippingController@index')->name('admin-shipping-index');
  Route::get('/shipping/create', 'Admin\ShippingController@create')->name('admin-shipping-create');
  Route::post('/shipping/create', 'Admin\ShippingController@store')->name('admin-shipping-store');
  Route::get('/shipping/edit/{id}', 'Admin\ShippingController@edit')->name('admin-shipping-edit');
  Route::post('/shipping/edit/{id}', 'Admin\ShippingController@update')->name('admin-shipping-update');
  Route::get('/shipping/delete/{id}', 'Admin\ShippingController@destroy')->name('admin-shipping-delete');

  //------------ ADMIN SHIPPING ENDS ------------

  //------------ ADMIN PACKAGE ------------

  Route::get('/package/datatables', 'Admin\PackageController@datatables')->name('admin-package-datatables');
  Route::get('/package', 'Admin\PackageController@index')->name('admin-package-index');
  Route::get('/package/create', 'Admin\PackageController@create')->name('admin-package-create');
  Route::post('/package/create', 'Admin\PackageController@store')->name('admin-package-store');
  Route::get('/package/edit/{id}', 'Admin\PackageController@edit')->name('admin-package-edit');
  Route::post('/package/edit/{id}', 'Admin\PackageController@update')->name('admin-package-update');
  Route::get('/package/delete/{id}', 'Admin\PackageController@destroy')->name('admin-package-delete');

  //------------ ADMIN PACKAGE ENDS------------



  //------------ ADMIN GENERAL SETTINGS JSON SECTION ------------

  // General Setting Section
  Route::get('/general-settings/home/{status}', 'Admin\GeneralSettingController@ishome')->name('admin-gs-ishome');
  Route::get('/general-settings/disqus/{status}', 'Admin\GeneralSettingController@isdisqus')->name('admin-gs-isdisqus');
  Route::get('/general-settings/loader/{status}', 'Admin\GeneralSettingController@isloader')->name('admin-gs-isloader');
  Route::get('/general-settings/email-verify/{status}', 'Admin\GeneralSettingController@isemailverify')->name('admin-gs-is-email-verify');
  Route::get('/general-settings/popup/{status}', 'Admin\GeneralSettingController@ispopup')->name('admin-gs-ispopup');

  Route::get('/general-settings/admin/loader/{status}', 'Admin\GeneralSettingController@isadminloader')->name('admin-gs-is-admin-loader');
  Route::get('/general-settings/talkto/{status}', 'Admin\GeneralSettingController@talkto')->name('admin-gs-talkto');
  Route::get('/general-settings/orderapprove/{status}', 'Admin\GeneralSettingController@orderapprove')->name('admin-gs-orderapprove');
  Route::get('/general-settings/approvepermission/{status}', 'Admin\GeneralSettingController@approvepermission')->name('admin-gs-approvepermission');
  Route::get('/general-settings/webpushr/{status}', 'Admin\GeneralSettingController@webpushr')->name('admin-gs-webpushr');

  Route::get('/general-settings/multiple/shipping/{status}', 'Admin\GeneralSettingController@mship')->name('admin-gs-mship');
  Route::get('/general-settings/multiple/packaging/{status}', 'Admin\GeneralSettingController@mpackage')->name('admin-gs-mpackage');
  Route::get('/general-settings/security/{status}', 'Admin\GeneralSettingController@issecure')->name('admin-gs-secure');
  Route::get('/general-settings/stock/{status}', 'Admin\GeneralSettingController@stock')->name('admin-gs-stock');
  Route::get('/general-settings/maintain/{status}', 'Admin\GeneralSettingController@ismaintain')->name('admin-gs-maintain');
  //  Affilte Section

  Route::get('/general-settings/affilate/{status}', 'Admin\GeneralSettingController@isaffilate')->name('admin-gs-isaffilate');

  //  Capcha Section

  Route::get('/general-settings/capcha/{status}', 'Admin\GeneralSettingController@iscapcha')->name('admin-gs-iscapcha');


  //------------ ADMIN GENERAL SETTINGS JSON SECTION ENDS------------




  });

  //------------ ADMIN GENERAL SETTINGS SECTION ENDS ------------


  //------------ ADMIN HOME PAGE SETTINGS SECTION ------------

  Route::group(['middleware'=>'permissions:home_page_settings'],function(){

  //------------ ADMIN SLIDER SECTION ------------

  Route::get('/slider/datatables', 'Admin\SliderController@datatables')->name('admin-sl-datatables'); //JSON REQUEST
  Route::get('/slider', 'Admin\SliderController@index')->name('admin-sl-index');
  Route::get('/slider/create', 'Admin\SliderController@create')->name('admin-sl-create');
  Route::post('/slider/create', 'Admin\SliderController@store')->name('admin-sl-store');
  Route::get('/slider/edit/{id}', 'Admin\SliderController@edit')->name('admin-sl-edit');
  Route::post('/slider/edit/{id}', 'Admin\SliderController@update')->name('admin-sl-update');
  Route::get('/slider/delete/{id}', 'Admin\SliderController@destroy')->name('admin-sl-delete');

  //------------ ADMIN SLIDER SECTION ENDS ------------

  //------------ ADMIN SERVICE SECTION ------------

  Route::get('/service/datatables', 'Admin\ServiceController@datatables')->name('admin-service-datatables'); //JSON REQUEST
  Route::get('/service', 'Admin\ServiceController@index')->name('admin-service-index');
  Route::get('/service/create', 'Admin\ServiceController@create')->name('admin-service-create');
  Route::post('/service/create', 'Admin\ServiceController@store')->name('admin-service-store');
  Route::get('/service/edit/{id}', 'Admin\ServiceController@edit')->name('admin-service-edit');
  Route::post('/service/edit/{id}', 'Admin\ServiceController@update')->name('admin-service-update');
  Route::get('/service/delete/{id}', 'Admin\ServiceController@destroy')->name('admin-service-delete');

  //------------ ADMIN SERVICE SECTION ENDS ------------

  //------------ ADMIN BANNER SECTION ------------

  Route::get('/banner/datatables/{type}', 'Admin\BannerController@datatables')->name('admin-sb-datatables'); //JSON REQUEST
  Route::get('top/small/banner/', 'Admin\BannerController@index')->name('admin-sb-index');
  Route::get('large/banner/', 'Admin\BannerController@large')->name('admin-sb-large');
  Route::get('bottom/small/banner/', 'Admin\BannerController@bottom')->name('admin-sb-bottom');
  Route::get('top/small/banner/create', 'Admin\BannerController@create')->name('admin-sb-create');
  Route::get('large/banner/create', 'Admin\BannerController@largecreate')->name('admin-sb-create-large');
  Route::get('bottom/small/banner/create', 'Admin\BannerController@bottomcreate')->name('admin-sb-create-bottom');


  Route::post('/banner/create', 'Admin\BannerController@store')->name('admin-sb-store');
  Route::get('/banner/edit/{id}', 'Admin\BannerController@edit')->name('admin-sb-edit');
  Route::post('/banner/edit/{id}', 'Admin\BannerController@update')->name('admin-sb-update');
  Route::get('/banner/delete/{id}', 'Admin\BannerController@destroy')->name('admin-sb-delete');

  //------------ ADMIN BANNER SECTION ENDS ------------

  //------------ ADMIN REVIEW SECTION ------------

  Route::get('/review/datatables', 'Admin\ReviewController@datatables')->name('admin-review-datatables'); //JSON REQUEST
  Route::get('/review', 'Admin\ReviewController@index')->name('admin-review-index');
  Route::get('/review/create', 'Admin\ReviewController@create')->name('admin-review-create');
  Route::post('/review/create', 'Admin\ReviewController@store')->name('admin-review-store');
  Route::get('/review/edit/{id}', 'Admin\ReviewController@edit')->name('admin-review-edit');
  Route::post('/review/edit/{id}', 'Admin\ReviewController@update')->name('admin-review-update');
  Route::get('/review/delete/{id}', 'Admin\ReviewController@destroy')->name('admin-review-delete');

  //------------ ADMIN REVIEW SECTION ENDS ------------


  //------------ ADMIN PARTNER SECTION ------------

  Route::get('/partner/datatables', 'Admin\PartnerController@datatables')->name('admin-partner-datatables');
  Route::get('/partner', 'Admin\PartnerController@index')->name('admin-partner-index');
  Route::get('/partner/create', 'Admin\PartnerController@create')->name('admin-partner-create');
  Route::post('/partner/create', 'Admin\PartnerController@store')->name('admin-partner-store');
  Route::get('/partner/edit/{id}', 'Admin\PartnerController@edit')->name('admin-partner-edit');
  Route::post('/partner/edit/{id}', 'Admin\PartnerController@update')->name('admin-partner-update');
  Route::get('/partner/delete/{id}', 'Admin\PartnerController@destroy')->name('admin-partner-delete');

  //------------ ADMIN PARTNER SECTION ENDS ------------


  //------------ ADMIN PAGE SETTINGS SECTION ------------

  Route::get('/page-settings/customize', 'Admin\PageSettingController@customize')->name('admin-ps-customize');
  Route::get('/page-settings/big-save', 'Admin\PageSettingController@big_save')->name('admin-ps-big-save');
  Route::get('/page-settings/best-seller', 'Admin\PageSettingController@best_seller')->name('admin-ps-best-seller');


  });

  //------------ ADMIN HOME PAGE SETTINGS SECTION ENDS ------------

  Route::group(['middleware'=>'permissions:menu_page_settings'],function(){

  //------------ ADMIN MENU PAGE SETTINGS SECTION ------------

  //------------ ADMIN FAQ SECTION ------------

  Route::get('/faq/datatables', 'Admin\FaqController@datatables')->name('admin-faq-datatables'); //JSON REQUEST
  Route::get('/faq', 'Admin\FaqController@index')->name('admin-faq-index');
  Route::get('/faq/create', 'Admin\FaqController@create')->name('admin-faq-create');
  Route::post('/faq/create', 'Admin\FaqController@store')->name('admin-faq-store');
  Route::get('/faq/edit/{id}', 'Admin\FaqController@edit')->name('admin-faq-edit');
  Route::post('/faq/update/{id}', 'Admin\FaqController@update')->name('admin-faq-update');
  Route::get('/faq/delete/{id}', 'Admin\FaqController@destroy')->name('admin-faq-delete');

  //------------ ADMIN FAQ SECTION ENDS ------------


  //------------ ADMIN PAGE SECTION ------------

  Route::get('/page/datatables', 'Admin\PageController@datatables')->name('admin-page-datatables'); //JSON REQUEST
  Route::get('/page', 'Admin\PageController@index')->name('admin-page-index');
  Route::get('/page/create', 'Admin\PageController@create')->name('admin-page-create');
  Route::post('/page/create', 'Admin\PageController@store')->name('admin-page-store');
  Route::get('/page/edit/{id}', 'Admin\PageController@edit')->name('admin-page-edit');
  Route::post('/page/update/{id}', 'Admin\PageController@update')->name('admin-page-update');
  Route::get('/page/delete/{id}', 'Admin\PageController@destroy')->name('admin-page-delete');
  Route::get('/page/header/{id1}/{id2}', 'Admin\PageController@header')->name('admin-page-header');
  Route::get('/page/footer/{id1}/{id2}', 'Admin\PageController@footer')->name('admin-page-footer');

  //------------ ADMIN PAGE SECTION ENDS------------


  Route::get('/general-settings/contact/{status}', 'Admin\GeneralSettingController@iscontact')->name('admin-gs-iscontact');
  Route::get('/general-settings/faq/{status}', 'Admin\GeneralSettingController@isfaq')->name('admin-gs-isfaq');
  Route::get('/page-settings/contact', 'Admin\PageSettingController@contact')->name('admin-ps-contact');
  Route::post('/page-settings/update/all', 'Admin\PageSettingController@update')->name('admin-ps-update');

});

//------------ ADMIN MENU PAGE SETTINGS SECTION ENDS ------------



  //------------ ADMIN EMAIL SETTINGS SECTION ------------

  Route::group(['middleware'=>'permissions:emails_settings'],function(){

  Route::get('/email-templates/datatables', 'Admin\EmailController@datatables')->name('admin-mail-datatables');
  Route::get('/email-templates', 'Admin\EmailController@index')->name('admin-mail-index');
  Route::get('/email-templates/{id}', 'Admin\EmailController@edit')->name('admin-mail-edit');
  Route::post('/email-templates/{id}', 'Admin\EmailController@update')->name('admin-mail-update');
  Route::get('/email-config', 'Admin\EmailController@config')->name('admin-mail-config');
  Route::get('/groupemail', 'Admin\EmailController@groupemail')->name('admin-group-show');
  Route::post('/groupemailpost', 'Admin\EmailController@groupemailpost')->name('admin-group-submit');
  Route::get('/issmtp/{status}', 'Admin\GeneralSettingController@issmtp')->name('admin-gs-issmtp');

});

  //------------ ADMIN EMAIL SETTINGS SECTION ENDS ------------



  //------------ ADMIN PAYMENT SETTINGS SECTION ------------

  Route::group(['middleware'=>'permissions:payment_settings'],function(){

// Payment Informations

  Route::get('/payment-informations', 'Admin\GeneralSettingController@paymentsinfo')->name('admin-gs-payments');

  Route::get('/general-settings/guest/{status}', 'Admin\GeneralSettingController@guest')->name('admin-gs-guest');
  Route::get('/general-settings/paypal/{status}', 'Admin\GeneralSettingController@paypal')->name('admin-gs-paypal');
  Route::get('/general-settings/instamojo/{status}', 'Admin\GeneralSettingController@instamojo')->name('admin-gs-instamojo');
  Route::get('/general-settings/paystack/{status}', 'Admin\GeneralSettingController@paystack')->name('admin-gs-paystack');
  Route::get('/general-settings/stripe/{status}', 'Admin\GeneralSettingController@stripe')->name('admin-gs-stripe');
  Route::get('/general-settings/cod/{status}', 'Admin\GeneralSettingController@cod')->name('admin-gs-cod');
  Route::get('/general-settings/paytm/{status}', 'Admin\GeneralSettingController@paytm')->name('admin-gs-paytm');
  Route::get('/general-settings/ccavenue/{status}', 'Admin\GeneralSettingController@ccavenue')->name('admin-gs-ccavenue');
  Route::get('/general-settings/molly/{status}', 'Admin\GeneralSettingController@molly')->name('admin-gs-molly');
  Route::get('/general-settings/razor/{status}', 'Admin\GeneralSettingController@razor')->name('admin-gs-razor');
// Payment Gateways

  Route::get('/paymentgateway/datatables', 'Admin\PaymentGatewayController@datatables')->name('admin-payment-datatables'); //JSON REQUEST
  Route::get('/paymentgateway', 'Admin\PaymentGatewayController@index')->name('admin-payment-index');
  Route::get('/paymentgateway/create', 'Admin\PaymentGatewayController@create')->name('admin-payment-create');
  Route::post('/paymentgateway/create', 'Admin\PaymentGatewayController@store')->name('admin-payment-store');
  Route::get('/paymentgateway/edit/{id}', 'Admin\PaymentGatewayController@edit')->name('admin-payment-edit');
  Route::post('/paymentgateway/update/{id}', 'Admin\PaymentGatewayController@update')->name('admin-payment-update');
  Route::get('/paymentgateway/delete/{id}', 'Admin\PaymentGatewayController@destroy')->name('admin-payment-delete');
  Route::get('/paymentgateway/status/{id1}/{id2}', 'Admin\PaymentGatewayController@status')->name('admin-payment-status');

// Currency Settings


  // MULTIPLE CURRENCY

  Route::get('/general-settings/currency/{status}', 'Admin\GeneralSettingController@currency')->name('admin-gs-iscurrency');
  Route::get('/currency/datatables', 'Admin\CurrencyController@datatables')->name('admin-currency-datatables'); //JSON REQUEST
  Route::get('/currency', 'Admin\CurrencyController@index')->name('admin-currency-index');
  Route::get('/currency/create', 'Admin\CurrencyController@create')->name('admin-currency-create');
  Route::post('/currency/create', 'Admin\CurrencyController@store')->name('admin-currency-store');
  Route::get('/currency/edit/{id}', 'Admin\CurrencyController@edit')->name('admin-currency-edit');
  Route::post('/currency/update/{id}', 'Admin\CurrencyController@update')->name('admin-currency-update');
  Route::get('/currency/delete/{id}', 'Admin\CurrencyController@destroy')->name('admin-currency-delete');
  Route::get('/currency/status/{id1}/{id2}', 'Admin\CurrencyController@status')->name('admin-currency-status');
  Route::get('/updatecurrency', 'Admin\CurrencyController@updatecurrency')->name('admin-currency-updatecurrency');
  Route::get('/updatecurrency/datatables', 'Admin\CurrencyController@updatecurdatatables')->name('admin-currency-updatecurdatatables');
  Route::post('/currency/allupdate/', 'Admin\CurrencyController@allupdate')->name('admin-currency-allupdate');

});

  //------------ ADMIN PAYMENT SETTINGS SECTION ENDS------------





  //------------ ADMIN SOCIAL SETTINGS SECTION ------------

  Route::group(['middleware'=>'permissions:social_settings'],function(){

  Route::get('/social', 'Admin\SocialSettingController@index')->name('admin-social-index');
  Route::post('/social/update', 'Admin\SocialSettingController@socialupdate')->name('admin-social-update');
  Route::post('/social/update/all', 'Admin\SocialSettingController@socialupdateall')->name('admin-social-update-all');
  Route::get('/social/facebook', 'Admin\SocialSettingController@facebook')->name('admin-social-facebook');
  Route::get('/social/google', 'Admin\SocialSettingController@google')->name('admin-social-google');
  Route::get('/social/facebook/{status}', 'Admin\SocialSettingController@facebookup')->name('admin-social-facebookup');
  Route::get('/social/google/{status}', 'Admin\SocialSettingController@googleup')->name('admin-social-googleup');


});
  //------------ ADMIN SOCIAL SETTINGS SECTION ENDS------------



  //------------ ADMIN LANGUAGE SETTINGS SECTION ------------

  Route::group(['middleware'=>'permissions:language_settings'],function(){

  //  Multiple Language Section

  Route::get('/general-settings/language/{status}', 'Admin\GeneralSettingController@language')->name('admin-gs-islanguage');

  //  Multiple Language Section Ends

  Route::get('/languages/datatables', 'Admin\LanguageController@datatables')->name('admin-lang-datatables'); //JSON REQUEST
  Route::get('/languages', 'Admin\LanguageController@index')->name('admin-lang-index');
  Route::get('/languages/create', 'Admin\LanguageController@create')->name('admin-lang-create');
  Route::get('/languages/edit/{id}', 'Admin\LanguageController@edit')->name('admin-lang-edit');
  Route::post('/languages/create', 'Admin\LanguageController@store')->name('admin-lang-store');
  Route::post('/languages/edit/{id}', 'Admin\LanguageController@update')->name('admin-lang-update');
  Route::get('/languages/status/{id1}/{id2}', 'Admin\LanguageController@status')->name('admin-lang-st');
  Route::get('/languages/delete/{id}', 'Admin\LanguageController@destroy')->name('admin-lang-delete');


  //------------ ADMIN PANEL LANGUAGE SETTINGS SECTION ------------

  Route::get('/adminlanguages/datatables', 'Admin\AdminLanguageController@datatables')->name('admin-tlang-datatables'); //JSON REQUEST
  Route::get('/adminlanguages', 'Admin\AdminLanguageController@index')->name('admin-tlang-index');
  Route::get('/adminlanguages/create', 'Admin\AdminLanguageController@create')->name('admin-tlang-create');
  Route::get('/adminlanguages/edit/{id}', 'Admin\AdminLanguageController@edit')->name('admin-tlang-edit');
  Route::post('/adminlanguages/create', 'Admin\AdminLanguageController@store')->name('admin-tlang-store');
  Route::post('/adminlanguages/edit/{id}', 'Admin\AdminLanguageController@update')->name('admin-tlang-update');
  Route::get('/adminlanguages/status/{id1}/{id2}', 'Admin\AdminLanguageController@status')->name('admin-tlang-st');
  Route::get('/adminlanguages/delete/{id}', 'Admin\AdminLanguageController@destroy')->name('admin-tlang-delete');

  //------------ ADMIN PANEL LANGUAGE SETTINGS SECTION ENDS ------------

  //------------ ADMIN LANGUAGE SETTINGS SECTION ENDS ------------

  });

  //------------ ADMIN SEOTOOL SETTINGS SECTION ------------

  Route::group(['middleware'=>'permissions:seo_tools'],function(){

  Route::get('/seotools/analytics', 'Admin\SeoToolController@analytics')->name('admin-seotool-analytics');
  Route::post('/seotools/analytics/update', 'Admin\SeoToolController@analyticsupdate')->name('admin-seotool-analytics-update');
  Route::get('/seotools/keywords', 'Admin\SeoToolController@keywords')->name('admin-seotool-keywords');
  Route::post('/seotools/keywords/update', 'Admin\SeoToolController@keywordsupdate')->name('admin-seotool-keywords-update');
  Route::get('/products/popular/{id}','Admin\SeoToolController@popular')->name('admin-prod-popular');

  });

  //------------ ADMIN SEOTOOL SETTINGS SECTION ------------

  //------------ ADMIN STAFF SECTION ------------

  Route::group(['middleware'=>'permissions:manage_staffs'],function(){

  Route::get('/staff/datatables', 'Admin\StaffController@datatables')->name('admin-staff-datatables');
  Route::get('/staff', 'Admin\StaffController@index')->name('admin-staff-index');
  Route::get('/staff/create', 'Admin\StaffController@create')->name('admin-staff-create');
  Route::post('/staff/create', 'Admin\StaffController@store')->name('admin-staff-store');
  Route::get('/staff/edit/{id}', 'Admin\StaffController@edit')->name('admin-staff-edit');
  Route::post('/staff/update/{id}', 'Admin\StaffController@update')->name('admin-staff-update');
  Route::get('/staff/show/{id}', 'Admin\StaffController@show')->name('admin-staff-show');
  Route::get('/staff/delete/{id}', 'Admin\StaffController@destroy')->name('admin-staff-delete');

  });

  //------------ ADMIN STAFF SECTION ENDS------------

  //------------ ADMIN SUBSCRIBERS SECTION ------------

  Route::group(['middleware'=>'permissions:subscribers'],function(){

  Route::get('/subscribers/datatables', 'Admin\SubscriberController@datatables')->name('admin-subs-datatables'); //JSON REQUEST
  Route::get('/subscribers', 'Admin\SubscriberController@index')->name('admin-subs-index');
  Route::get('/subscribers/download', 'Admin\SubscriberController@download')->name('admin-subs-download');

  });

  //------------ ADMIN SUBSCRIBERS ENDS ------------
  Route::get('/notify/datatables', 'Admin\NotifyController@datatables')->name('admin-notify-datatables');
  Route::get('/notify', 'Admin\NotifyController@index')->name('admin-notify-index');
  Route::get('/notify/download', 'Admin\NotifyController@download')->name('admin-notify-download');
  Route::get('/notify/sent', 'Admin\NotifyController@sentnofication')->name('admin-notify-sent');
// ------------ GLOBAL ----------------------
  Route::post('/general-settings/update/all', 'Admin\GeneralSettingController@generalupdate')->name('admin-gs-update');
  Route::post('/general-settings/update/payment', 'Admin\GeneralSettingController@generalupdatepayment')->name('admin-gs-update-payment');

  // STATUS SECTION
  Route::get('/products/status/{id1}/{id2}', 'Admin\ProductController@status')->name('admin-prod-status');
  // STATUS SECTION ENDS
    // STATUS SECTION
  Route::get('/refund/status/{id1}/{id2}', 'Admin\RefundController@status')->name('admin-refund-status');
  // STATUS SECTION ENDS

  // FEATURE SECTION
  Route::get('/products/feature/{id}', 'Admin\ProductController@feature')->name('admin-prod-feature');
  Route::post('/products/feature/{id}', 'Admin\ProductController@featuresubmit')->name('admin-prod-feature');
  // FEATURE SECTION ENDS
  
   // Admin Quick Edit SECTION
  Route::get('/products/quickedit/{id}', 'Admin\ProductController@quickedit')->name('admin-prod-quickedit');
  Route::post('/products/quickedit/{id}', 'Admin\ProductController@quickeditsubmit')->name('admin-prod-quickedit');
  // Admin Quick Edit SECTION ENDS
  
  // Admin Quick Edit SECTION
  Route::get('/refund/addnote/{id}', 'Admin\RefundController@addnote')->name('admin-refund-addnote');
  Route::post('/refund/addnote/{id}', 'Admin\RefundController@addnotesubmit')->name('admin-refund-addnote');
  // Admin Quick Edit SECTION ENDS

  

  // GALLERY SECTION ------------
Route::get('/enquirygallery/show', 'Admin\EnquirygalleryController@show')->name('admin-enquirygallery-show');
  Route::get('/gallery/show', 'Admin\GalleryController@show')->name('admin-gallery-show');
  Route::post('/gallery/store', 'Admin\GalleryController@store')->name('admin-gallery-store');
  Route::get('/gallery/delete', 'Admin\GalleryController@destroy')->name('admin-gallery-delete');

  // GALLERY SECTION ENDS------------

  Route::post('/page-settings/update/all', 'Admin\PageSettingController@update')->name('admin-ps-update');
  Route::post('/page-settings/update/home', 'Admin\PageSettingController@homeupdate')->name('admin-ps-homeupdate');

// ------------ GLOBAL ENDS ----------------------

Route::group(['middleware'=>'permissions:super'],function(){



  Route::get('/cache/clear', function() {
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('route:clear');
    Artisan::call('view:clear');
    return redirect()->route('admin.dashboard')->with('cache','System Cache Has Been Removed.');
  })->name('admin-cache-clear');

  Route::get('/check/movescript', 'Admin\DashboardController@movescript')->name('admin-move-script');
  Route::get('/generate/backup', 'Admin\DashboardController@generate_bkup')->name('admin-generate-backup');
  Route::get('/activation', 'Admin\DashboardController@activation')->name('admin-activation-form');
  Route::post('/activation', 'Admin\DashboardController@activation_submit')->name('admin-activate-purchase');
  Route::get('/clear/backup', 'Admin\DashboardController@clear_bkup')->name('admin-clear-backup');
  
  // ------------ ROLE SECTION ----------------------

  Route::get('/role/datatables', 'Admin\RoleController@datatables')->name('admin-role-datatables');
  Route::get('/role', 'Admin\RoleController@index')->name('admin-role-index');
  Route::get('/role/create', 'Admin\RoleController@create')->name('admin-role-create');
  Route::post('/role/create', 'Admin\RoleController@store')->name('admin-role-store');
  Route::get('/role/edit/{id}', 'Admin\RoleController@edit')->name('admin-role-edit');
  Route::post('/role/edit/{id}', 'Admin\RoleController@update')->name('admin-role-update');
  Route::get('/role/delete/{id}', 'Admin\RoleController@destroy')->name('admin-role-delete');

  // ------------ ROLE SECTION ENDS ----------------------


  });


});


// ************************************ ADMIN SECTION ENDS**********************************************

// ************************************ USER SECTION **********************************************

Route::prefix('user')->group(function() {

  // User Dashboard
  Route::get('/dashboard', 'User\UserController@index')->name('user-dashboard');

  // User Login
  Route::get('/login', 'User\LoginController@showLoginForm')->name('user.login');
  Route::post('/login', 'User\LoginController@login')->name('user.login.submit');
  // User Login End

  // User Register
  Route::get('/register', 'User\RegisterController@showRegisterForm')->name('user-register');
  Route::post('/register', 'User\RegisterController@register')->name('user-register-submit');
  Route::get('/register/verify/{token}', 'User\RegisterController@token')->name('user-register-token');
  // User Register End

  // User Reset
  Route::get('/reset', 'User\UserController@resetform')->name('user-reset');
  Route::post('/reset', 'User\UserController@reset')->name('user-reset-submit');
  // User Reset End

  // User Profile
  Route::get('/profile', 'User\UserController@profile')->name('user-profile');
  Route::post('/profile', 'User\UserController@profileupdate')->name('user-profile-update');
  // User Profile Ends

  // User Forgot
  Route::get('/forgot', 'User\ForgotController@showforgotform')->name('user-forgot');
  Route::post('/forgot', 'User\ForgotController@forgot')->name('user-forgot-submit');
  // User Forgot Ends

  // User Wishlist
  Route::get('/wishlists','User\WishlistController@wishlists')->name('user-wishlists');
  Route::get('/wishlist/add/{id}','User\WishlistController@addwish')->name('user-wishlist-add');
  Route::get('/wishlist/remove/{id}','User\WishlistController@removewish')->name('user-wishlist-remove');
  // User Wishlist Ends

  // User Review
  Route::post('/review/submit','User\UserController@reviewsubmit')->name('front.review.submit');
    Route::post('/refund/submit','User\UserController@refundsubmit')->name('front.refund.submit');
  // User Review Ends

// User Orders

  Route::get('/orders', 'User\OrderController@orders')->name('user-orders');
  Route::get('/refunds', 'User\OrderController@refunds')->name('user-refunds');
  Route::get('/exchange', 'User\OrderController@exchange')->name('user-exchange');
  Route::get('/order/tracking', 'User\OrderController@ordertrack')->name('user-order-track');
  Route::get('/order/trackings/{id}', 'User\OrderController@trackload')->name('user-order-track-search');
  Route::get('/order/trackings2/{id}', 'User\OrderController@trackload2')->name('user-order-track-search2');
  Route::get('/order/{id}', 'User\OrderController@order')->name('user-order');
  Route::get('/userrefund/{id}', 'User\OrderController@userrefund')->name('user-refund');
  Route::get('/userexchanges/{id}', 'User\OrderController@userexchanges')->name('user-exchanges');
  Route::get('/download/order/{slug}/{id}', 'User\OrderController@orderdownload')->name('user-order-download');
  Route::get('print/order/print/{id}', 'User\OrderController@orderprint')->name('user-order-print');
  Route::get('/json/trans','User\OrderController@trans');

// User Orders Ends


// User Subscription

  Route::get('/package', 'User\UserController@package')->name('user-package');
  Route::get('/subscription/{id}', 'User\UserController@vendorrequest')->name('user-vendor-request');
  Route::post('/vendor-request', 'User\UserController@vendorrequestsub')->name('user-vendor-request-submit');

  Route::post('/paypal/submit', 'User\PaypalController@store')->name('user.paypal.submit');
  Route::get('/paypal/cancle', 'User\PaypalController@paycancle')->name('user.payment.cancle');
  Route::get('/paypal/return', 'User\PaypalController@payreturn')->name('user.payment.return');
  Route::post('/paypal/notify', 'User\PaypalController@notify')->name('user.payment.notify');
  Route::post('/stripe/submit', 'User\StripeController@store')->name('user.stripe.submit');

  Route::get('/instamojo/notify', 'User\InstamojoController@notify')->name('user.instamojo.notify');
  Route::post('/instamojo/submit', 'User\InstamojoController@store')->name('user.instamojo.submit');


  Route::get('/molly/notify', 'User\MollyController@notify')->name('user.molly.notify');
  Route::post('/molly/submit', 'User\MollyController@store')->name('user.molly.submit');

  Route::get('/paystack/check', 'User\PaystackController@check')->name('user.paystack.check');
  Route::post('/paystack/submit', 'User\PaystackController@store')->name('user.paystack.submit');

  //PayTM Routes
  Route::post('/paytm/submit', 'User\PaytmController@store')->name('user.paytm.submit');
  Route::post('/paytm/notify', 'User\PaytmController@notify')->name('user.paytm.notify');
  
  Route::post('/ccavenue/submit', 'User\CcavenueController@store')->name('user.ccavenue.submit');
  Route::post('/ccavenue/notify', 'User\CcavenueController@notify')->name('user.ccavenue.notify');



  //PayTM Routes
  Route::post('/razorpay/submit', 'User\RazorpayController@store')->name('user.razorpay.submit');;
  Route::post('/razorpay/notify', 'User\RazorpayController@notify')->name('user.razorpay.notify');


// User Subscription Ends

// User Vendor Send Message

  Route::post('/user/contact', 'User\MessageController@usercontact');
  Route::get('/messages', 'User\MessageController@messages')->name('user-messages');
  Route::get('/message/{id}', 'User\MessageController@message')->name('user-message');
  Route::post('/message/post', 'User\MessageController@postmessage')->name('user-message-post');
  Route::get('/message/{id}/delete', 'User\MessageController@messagedelete')->name('user-message-delete');
  Route::get('/message/load/{id}', 'User\MessageController@msgload')->name('user-vendor-message-load');

// User Vendor Send Message Ends

// User Admin Send Message


// Tickets
  Route::get('admin/tickets', 'User\MessageController@adminmessages')->name('user-message-index');
// Disputes
  Route::get('admin/disputes', 'User\MessageController@adminDiscordmessages')->name('user-dmessage-index');

  Route::get('admin/message/{id}', 'User\MessageController@adminmessage')->name('user-message-show');
  Route::post('admin/message/post', 'User\MessageController@adminpostmessage')->name('user-message-store');
  Route::get('admin/message/{id}/delete', 'User\MessageController@adminmessagedelete')->name('user-message-delete1');
  Route::post('admin/user/send/message', 'User\MessageController@adminusercontact')->name('user-send-message');
  Route::get('admin/message/load/{id}', 'User\MessageController@messageload')->name('user-message-load');
// User Admin Send Message Ends

  Route::get('/affilate/code', 'User\WithdrawController@affilate_code')->name('user-affilate-code');
  Route::get('/affilate/withdraw', 'User\WithdrawController@index')->name('user-wwt-index');
  Route::get('/affilate/withdraw/create', 'User\WithdrawController@create')->name('user-wwt-create');
  Route::post('/affilate/withdraw/create', 'User\WithdrawController@store')->name('user-wwt-store');

// User Favorite Seller

  Route::get('/favorite/seller', 'User\UserController@favorites')->name('user-favorites');
  Route::get('/favorite/{id1}/{id2}', 'User\UserController@favorite')->name('user-favorite');
  Route::get('/favorite/seller/{id}/delete', 'User\UserController@favdelete')->name('user-favorite-delete');

// User Favorite Seller Ends

  // User Logout
  Route::get('/logout', 'User\LoginController@logout')->name('user-logout');
  // User Logout Ends

});

// ************************************ USER SECTION ENDS**********************************************



Route::post('the/genius/ocean/2441139', 'Front\FrontendController@subscription');
Route::post('/sendinvoice/{id}', 'Front\FrontendController@sendinvoice')->name('front-order-invoice');
Route::get('finalize', 'Front\FrontendController@finalize');

Route::get('/under-maintenance', 'Front\FrontendController@maintenance')->name('front-maintenance');


  Route::group(['middleware'=>'maintenance'],function(){

// ************************************ VENDOR SECTION **********************************************


Route::prefix('vendor')->group(function() {


  Route::group(['middleware'=>'vendor'],function(){
  // Vendor Dashboard
  Route::get('/dashboard', 'Vendor\VendorController@index')->name('vendor-dashboard');


    //IMPORT SECTION
    Route::get('/products/import/create', 'Vendor\ImportController@createImport')->name('vendor-import-create');
    Route::get('/products/import/edit/{id}', 'Vendor\ImportController@edit')->name('vendor-import-edit');
    Route::get('/products/import/csv', 'Vendor\ImportController@importCSV')->name('vendor-import-csv');
    Route::get('/products/import/datatables', 'Vendor\ImportController@datatables')->name('vendor-import-datatables');
    Route::get('/products/import/index', 'Vendor\ImportController@index')->name('vendor-import-index');
    Route::post('/products/import/store', 'Vendor\ImportController@store')->name('vendor-import-store');
    Route::post('/products/import/update/{id}', 'Vendor\ImportController@update')->name('vendor-import-update');
    Route::post('/products/import/csv/store', 'Vendor\ImportController@importStore')->name('vendor-import-csv-store');
    //IMPORT SECTION


  //------------ ADMIN ORDER SECTION ------------
  
  
  
  Route::get('/orders', 'Vendor\OrderController@index')->name('vendor-order-index');
  Route::get('/vorders', 'Vendor\OrderController@newindex')->name('vendor-vorders-newindex');
  Route::get('/vorders/processing', 'Vendor\OrderController@vprocessing')->name('vendor-order-vprocessing');
  Route::get('/vorders/completed', 'Vendor\OrderController@vcompleted')->name('vendor-order-vcompleted');
  Route::get('/vorders/shipping', 'Vendor\OrderController@vshipping')->name('vendor-order-shipping');
  Route::get('/withdraworderlist', 'Vendor\OrderController@withdraworderlist')->name('vendor-order-withdraw-list');
  Route::get('/order/{id}/show', 'Vendor\OrderController@show')->name('vendor-order-show');
  Route::get('/order/{id}/vshow', 'Vendor\OrderController@vshow')->name('vendor-order-vshow');   
  
  Route::get('ven-download-all-excel-file/{type}', array('as'=>'ven-all-excel-file','uses'=>'Vendor\OrderController@allorderExcelFile'));
  Route::get('ven-download-excel-file/{type}', array('as'=>'ven-excel-file','uses'=>'Vendor\OrderController@downloadExcelFile'));
  Route::get('ven-download-ship-file/{type}', array('as'=>'ven-shipping-excel-file','uses'=>'Vendor\OrderController@downloadShipFile'));
  Route::get('ven-download--file/{type}', array('as'=>'ven-process-excel-file','uses'=>'Vendor\OrderController@downloadprocessExcel'));
  
  Route::get('/order/{id}/invoice', 'Vendor\OrderController@invoice')->name('vendor-order-invoice');
  Route::get('/order/{id}/generateinvoice', 'Vendor\OrderController@generateinvoice')->name('vendor-generate-invoice');
  Route::get('/order/{id}/generatetaxinvoice', 'Vendor\OrderController@generatetaxinvoice')->name('vendor-tax-invoice');
  Route::get('/order/{id}/packingslipinvoice', 'Vendor\OrderController@packingslipinvoice')->name('vendor-packingslip-invoice');
  
  Route::get('/raise/datatables/{slug}', 'Vendor\RaiseDisputeController@datatables')->name('vendor-raise-datatables');
  Route::get('/raise/', 'Vendor\RaiseDisputeController@index')->name('vendor-raise-index');
  Route::get('/raise/{id}/show', 'Vendor\RaiseDisputeController@show')->name('vendor-raise-show');
  Route::get('download-raise-dispute/{type}', array('as'=>'vendordw-raise-dispute','uses'=>'Vendor\RaiseDisputeController@export'));
  
  Route::get('/debit/datatables/{slug}', 'Vendor\DebitNoteController@datatables')->name('vendor-debit-datatables');
  Route::get('/debit/', 'Vendor\DebitNoteController@index')->name('vendor-debit-index');
  Route::get('/debit/{id}/show', 'Vendor\DebitNoteController@show')->name('vendor-debit-show');
  Route::get('downloads-debit/{type}', array('as'=>'vendordw-debit-data','uses'=>'Vendor\DebitNoteController@export'));
  
  Route::get('/credit/datatables/{slug}', 'Vendor\CreditNoteController@datatables')->name('vendor-credit-datatables');
  Route::get('/credit/', 'Vendor\CreditNoteController@index')->name('vendor-credit-index');
  Route::get('/credit/{id}/show', 'Vendor\CreditNoteController@show')->name('vendor-credit-show');
  Route::get('downloads-credit/{type}', array('as'=>'vendordw-credit-data','uses'=>'Vendor\CreditNoteController@export'));
  
  Route::get('/exchange/datatables/{slug}', 'Vendor\ExchangeController@datatables')->name('vendor-exchange-datatables');
  Route::get('/exchange/', 'Vendor\ExchangeController@index')->name('vendor-exchange-index');
  Route::get('/exchange/{id}/show', 'Vendor\ExchangeController@show')->name('vendor-exchange-show');
  Route::post('/exchange/updatetrack/{id}', 'Vendor\ExchangeController@updatetrack')->name('vendor-exchange-update');
  Route::get('downloads-exchange/{type}', array('as'=>'vendordw-exchange-data','uses'=>'Vendor\ExchangeController@export'));
  
  Route::get('/rto/datatables/{slug}', 'Vendor\RtoController@datatables')->name('vendor-rto-datatables');
  Route::get('/rto/', 'Vendor\RtoController@index')->name('vendor-rto-index');
  Route::get('/rto/{id}/show', 'Vendor\RtoController@show')->name('vendor-rto-show');
  Route::post('/rto/updatetrack/{id}', 'Vendor\RtoController@updatetrack')->name('vendor-rto-update');
  Route::get('downloads-rto/{type}', array('as'=>'vendordw-rto-data','uses'=>'Vendor\RtoController@export'));
  
  Route::get('/order/{id}/print', 'Vendor\OrderController@printpage')->name('vendor-order-print');
  Route::get('/order/{id1}/status/{status}', 'Vendor\OrderController@status')->name('vendor-order-status');
  Route::post('/order/email/', 'Vendor\OrderController@emailsub')->name('vendor-order-emailsub');
  Route::post('/order/addnote/', 'Vendor\OrderController@customaddnote')->name('vendor-order-customaddnote');
  Route::post('/order/{slug}/license', 'Vendor\OrderController@license')->name('vendor-order-license');
  
  Route::get('/vendorrecord', 'Vendor\VendorrecordController@record')->name('vendor.vendorrecord');
  Route::post('/vendorrecord', 'Vendor\VendorrecordController@record')->name('vendor.vendorrecord.submit');
  Route::get('exportreport/{startdate}/{enddate}', array('as'=>'exportreport','uses'=>'Vendor\VendorrecordController@exportreport'));
  

  //------------ ADMIN CATEGORY SECTION ENDS------------
  
  
  
  
  
  // Verification Section Ends
      // Order Tracking

   Route::get('/vorder/{id}/track', 'Vendor\OrderTrackController@index')->name('vendor-order-track');
   Route::get('/vorder/{id}/trackload', 'Vendor\OrderTrackController@load')->name('vendor-order-track-load');
   Route::post('/vorder/track/store', 'Vendor\OrderTrackController@store')->name('vendor-order-track-store');
    Route::post('/vorder/vorder/{id}', 'Vendor\OrderTrackController@ordertracks')->name('vendor-ordertracks');
   Route::get('/vorder/track/add', 'Vendor\OrderTrackController@add')->name('vendor-order-track-add');
   Route::get('/vorder/track/edit/{id}', 'Vendor\OrderTrackController@edit')->name('vendor-order-track-edit');
   Route::post('/vorder/track/update/{id}', 'Vendor\OrderTrackController@update')->name('vendor-order-track-update');
   Route::get('/vorder/track/delete/{id}', 'Vendor\OrderTrackController@delete')->name('vendor-order-track-delete');
   Route::get('/load/subcategories/{id}/', 'Vendor\SubCategoryController@load')->name('vendor-subcat-load'); //JSON REQUEST
   Route::get('/orders/datatables/{slug}', 'Vendor\OrderController@datatables')->name('vendor-order-datatables'); //JSON REQUEST
   Route::get('/products/simpleproduct', 'Vendor\ProductController@simpleproduct')->name('vendor-prod-simpleproduct');
   Route::get('/products/simple_datatables', 'Vendor\ProductController@simple_datatables')->name('vendor-prod-simple-datatables');

  // Order Tracking Ends
  
  


  //------------ VENDOR SUBCATEGORY SECTION ------------

  Route::get('/load/subcategories/{id}/', 'Vendor\VendorController@subcatload')->name('vendor-subcat-load'); //JSON REQUEST

  //------------ VENDOR SUBCATEGORY SECTION ENDS------------

  //------------ VENDOR CHILDCATEGORY SECTION ------------

  Route::get('/load/childcategories/{id}/', 'Vendor\VendorController@childcatload')->name('vendor-childcat-load'); //JSON REQUEST

  //------------ VENDOR CHILDCATEGORY SECTION ENDS------------

  //------------ VENDOR PRODUCT SECTION ------------

  Route::get('/products/datatables', 'Vendor\ProductController@datatables')->name('vendor-prod-datatables'); //JSON REQUEST
  Route::get('/products', 'Vendor\ProductController@index')->name('vendor-prod-index');


  // Vendor Quick Edit SECTION
  Route::get('/products/quickedit/{id}', 'Vendor\ProductController@quickedit')->name('vendor-prod-quickedit');
  Route::post('/products/quickedit/{id}', 'Vendor\ProductController@quickeditsubmit')->name('vendor-prod-quickedit');
  
  // Vendor Quick Edit SECTION ENDS

  Route::post('/vpriceupdate', 'Vendor\ProductController@vpriceupdate')->name('admin-vendorprod-price-update');

  Route::post('/products/upload/update/{id}', 'Vendor\ProductController@uploadUpdate')->name('vendor-prod-upload-update');
  
  Route::get('/products/vproductupdate', 'Vendor\ProductController@vproductupdate')->name('vendor-prod-vproductupdate');
  
  Route::post('/vbulkstockupdate', 'Vendor\ProductController@vbulkstockupdate')->name('vendor-prod-vbulkstock-update');
  Route::get('/products/vproductupdate/datatables', 'Vendor\ProductController@vproductupdatedatatables')->name('vendor-prod-vproductupdate-datatables'); //JSON REQUEST
  // CREATE SECTION
  Route::get('/products/types', 'Vendor\ProductController@types')->name('vendor-prod-types');
  Route::get('/products/physical/create', 'Vendor\ProductController@createPhysical')->name('vendor-prod-physical-create');
  Route::get('/products/digital/create', 'Vendor\ProductController@createDigital')->name('vendor-prod-digital-create');
  Route::get('/products/license/create', 'Vendor\ProductController@createLicense')->name('vendor-prod-license-create');
  Route::post('/products/store', 'Vendor\ProductController@store')->name('vendor-prod-store');
  Route::get('/getattributes', 'Vendor\ProductController@getAttributes')->name('vendor-prod-getattributes');
  Route::get('/products/import', 'Vendor\ProductController@import')->name('vendor-prod-import');
  Route::post('/products/import-submit', 'Vendor\ProductController@importSubmit')->name('vendor-prod-importsubmit');

  Route::get('/products/catalog/datatables', 'Vendor\ProductController@catalogdatatables')->name('admin-vendor-catalog-datatables');
  Route::get('/products/catalogs', 'Vendor\ProductController@catalogs')->name('admin-vendor-catalog-index');

  // CREATE SECTION

  // EDIT SECTION
  Route::get('/products/edit/{id}', 'Vendor\ProductController@edit')->name('vendor-prod-edit');
  Route::post('/products/edit/{id}', 'Vendor\ProductController@update')->name('vendor-prod-update');

  Route::get('/products/catalog/{id}', 'Vendor\ProductController@catalogedit')->name('vendor-prod-catalog-edit');
  Route::post('/products/catalog/{id}', 'Vendor\ProductController@catalogupdate')->name('vendor-prod-catalog-update');

  // EDIT SECTION ENDS

  // STATUS SECTION
  Route::get('/products/status/{id1}/{id2}', 'Vendor\ProductController@status')->name('vendor-prod-status');
  // STATUS SECTION ENDS

  // DELETE SECTION
  Route::get('/products/delete/{id}', 'Vendor\ProductController@destroy')->name('vendor-prod-delete');
  // DELETE SECTION ENDS

  //------------ VENDOR PRODUCT SECTION ENDS------------

  //------------ VENDOR GALLERY SECTION ------------

  Route::get('/gallery/show', 'Vendor\GalleryController@show')->name('vendor-gallery-show');
  Route::post('/gallery/store', 'Vendor\GalleryController@store')->name('vendor-gallery-store');
  Route::get('/gallery/delete', 'Vendor\GalleryController@destroy')->name('vendor-gallery-delete');

  //------------ VENDOR GALLERY SECTION ENDS------------

  //------------ ADMIN SHIPPING ------------

Route::get('/shipping/datatables', 'Vendor\ShippingController@datatables')->name('vendor-shipping-datatables');
Route::get('/shipping', 'Vendor\ShippingController@index')->name('vendor-shipping-index');
Route::get('/shipping/create', 'Vendor\ShippingController@create')->name('vendor-shipping-create');
Route::post('/shipping/create', 'Vendor\ShippingController@store')->name('vendor-shipping-store');
Route::get('/shipping/edit/{id}', 'Vendor\ShippingController@edit')->name('vendor-shipping-edit');
Route::post('/shipping/edit/{id}', 'Vendor\ShippingController@update')->name('vendor-shipping-update');
Route::get('/shipping/delete/{id}', 'Vendor\ShippingController@destroy')->name('vendor-shipping-delete');

  //------------ ADMIN SHIPPING ENDS ------------


  //------------ ADMIN PACKAGE ------------

Route::get('/package/datatables', 'Vendor\PackageController@datatables')->name('vendor-package-datatables');
Route::get('/package', 'Vendor\PackageController@index')->name('vendor-package-index');
Route::get('/package/create', 'Vendor\PackageController@create')->name('vendor-package-create');
Route::post('/package/create', 'Vendor\PackageController@store')->name('vendor-package-store');
Route::get('/package/edit/{id}', 'Vendor\PackageController@edit')->name('vendor-package-edit');
Route::post('/package/edit/{id}', 'Vendor\PackageController@update')->name('vendor-package-update');
Route::get('/package/delete/{id}', 'Vendor\PackageController@destroy')->name('vendor-package-delete');


  //------------ ADMIN PACKAGE ENDS------------



  //------------ VENDOR NOTIFICATION SECTION ------------

  // Order Notification
  Route::get('/order/notf/show/{id}', 'Vendor\NotificationController@order_notf_show')->name('vendor-order-notf-show');
  Route::get('/order/notf/count/{id}','Vendor\NotificationController@order_notf_count')->name('vendor-order-notf-count');
  Route::get('/order/notf/clear/{id}','Vendor\NotificationController@order_notf_clear')->name('vendor-order-notf-clear');
  // Order Notification Ends

  // Product Notification Ends

  //------------ VENDOR NOTIFICATION SECTION ENDS ------------

  // Vendor Profile
  Route::get('/profile', 'Vendor\VendorController@profile')->name('vendor-profile');
  Route::post('/profile', 'Vendor\VendorController@profileupdate')->name('vendor-profile-update');
  // Vendor Profile Ends

  // Vendor Shipping Cost
  Route::get('/shipping-cost', 'Vendor\VendorController@ship')->name('vendor-shop-ship');

  // Vendor Shipping Cost
  Route::get('/banner', 'Vendor\VendorController@banner')->name('vendor-banner');

  // Vendor Social
  Route::get('/social', 'Vendor\VendorController@social')->name('vendor-social-index');
  Route::post('/social/update', 'Vendor\VendorController@socialupdate')->name('vendor-social-update');

  Route::get('/withdraw/datatables', 'Vendor\WithdrawController@datatables')->name('vendor-wt-datatables');
  Route::get('/withdraw', 'Vendor\WithdrawController@index')->name('vendor-wt-index');
  Route::get('/withdraw/rejected', 'Vendor\WithdrawController@rejected')->name('vendor-wt-rejected');
  Route::get('/withdraw/completed', 'Vendor\WithdrawController@completed')->name('vendor-wt-completed');
  Route::get('/withdraw/withdrawadminapprovelist', 'Vendor\WithdrawController@withdrawadminapprovelist')->name('vendor-withdraw-adminapprovelist');
  
  Route::get('/withdraws/datatables', 'Vendor\VendorController@withdrawdatatables')->name('vendor-withdraws-datatables'); //JSON REQUEST
Route::get('/withdraws', 'Vendor\VendorController@withdraws')->name('vendor-withdraws-index');
Route::get('download-withdraws-file/{type}', array('as'=>'withdraws-excel-file','uses'=>'Vendor\VendorController@withdrawpendinglist'));
Route::get('/withdraw/{id}/shows', 'Vendor\VendorController@withdrawdetails')->name('vendor-withdraw-shows');
  
  Route::get('/withdraw/pending', 'Vendor\WithdrawController@pending')->name('vendor-wt-pending');
  Route::get('/withdraw/create', 'Vendor\WithdrawController@create')->name('vendor-wt-create');
  Route::post('/withdraw/create', 'Vendor\WithdrawController@store')->name('vendor-wt-store');

  Route::post('/vendor/withdraworderlist', 'Vendor\WithdrawController@withdraworder')->name('vendor-withdraw-order');

  Route::get('/service/datatables', 'Vendor\ServiceController@datatables')->name('vendor-service-datatables');
  Route::get('/service', 'Vendor\ServiceController@index')->name('vendor-service-index');
  Route::get('/service/create', 'Vendor\ServiceController@create')->name('vendor-service-create');
  Route::post('/service/create', 'Vendor\ServiceController@store')->name('vendor-service-store');
  Route::get('/service/edit/{id}', 'Vendor\ServiceController@edit')->name('vendor-service-edit');
  Route::post('/service/edit/{id}', 'Vendor\ServiceController@update')->name('vendor-service-update');
  Route::get('/service/delete/{id}', 'Vendor\ServiceController@destroy')->name('vendor-service-delete');


 Route::get('/verify', 'Vendor\VendorController@verify')->name('vendor-verify');
 Route::get('/warning/verify/{id}', 'Vendor\VendorController@warningVerify')->name('vendor-warning');
 Route::post('/verify', 'Vendor\VendorController@verifysubmit')->name('vendor-verify-submit');

  });

});


// ************************************ VENDOR SECTION ENDS**********************************************

// ************************************ FRONT SECTION **********************************************

  Route::get('/', 'Front\FrontendController@index')->name('front.index');
  Route::get('/extras', 'Front\FrontendController@extraIndex')->name('front.extraIndex');
  Route::get('/currency/{id}', 'Front\FrontendController@currency')->name('front.currency');
  Route::get('/language/{id}', 'Front\FrontendController@language')->name('front.language');

  // BLOG SECTION
  Route::get('/userreview','Front\FrontendController@userreview')->name('front.userreview');
  // BLOG SECTION
  Route::get('/blog','Front\FrontendController@blog')->name('front.blog');
  Route::get('/blog/{id}','Front\FrontendController@blogshow')->name('front.blogshow');
  Route::get('/blog/category/{slug}','Front\FrontendController@blogcategory')->name('front.blogcategory');
  Route::get('/blog/tag/{slug}','Front\FrontendController@blogtags')->name('front.blogtags');
  Route::get('/blog-search','Front\FrontendController@blogsearch')->name('front.blogsearch');
  Route::get('/blog/archive/{slug}','Front\FrontendController@blogarchive')->name('front.blogarchive');
  Route::get('/vendor/login','Front\FrontendController@vendorlogin')->name('front.vendorlogin');
  Route::get('/vendor/register','Front\FrontendController@vendorreg')->name('front.vendorreg');
  // BLOG SECTION ENDS

  // FAQ SECTION
  Route::get('/faq','Front\FrontendController@faq')->name('front.faq');
  // FAQ SECTION ENDS

  // CONTACT SECTION
  Route::get('/contact','Front\FrontendController@contact')->name('front.contact');
  Route::post('/contact','Front\FrontendController@contactemail')->name('front.contact.submit');
  Route::get('/contact/refresh_code','Front\FrontendController@refresh_code');

  // Route::post('/notify','Front\FrontendController@notify')->name('front.notify.submit');




Route::post('item/notify', 'Front\FrontendController@notify')->name('front.notify.submit');
  // CONTACT SECTION  ENDS

  // Enquiry SECTION
  Route::get('/custom-order','Front\FrontendController@enquiry')->name('front.enquiry');
  Route::post('/custom-order','Front\FrontendController@enquiryemail')->name('front.enquiry.submit');
  Route::get('/custom-order/refresh_code','Front\FrontendController@refresh_code');
  // Enquiry SECTION  ENDS

  // PRODCT AUTO SEARCH SECTION
  Route::get('/autosearch/product/{slug}','Front\FrontendController@autosearch');
  // PRODCT AUTO SEARCH SECTION ENDS

  // CATEGORY SECTION
  Route::get('/category/{category?}/{subcategory?}/{childcategory?}','Front\CatalogController@category')->name('front.category');
  Route::get('/category/{slug1}/{slug2}','Front\CatalogController@subcategory')->name('front.subcat');
  Route::get('/category/{slug1}/{slug2}/{slug3}','Front\CatalogController@childcategory')->name('front.childcat');
  Route::get('/categories/','Front\CatalogController@categories')->name('front.categories');
  Route::get('/childcategories/{slug}', 'Front\CatalogController@childcategories')->name('front.childcategories');
  // CATEGORY SECTION ENDS

  // TAG SECTION
  Route::get('/tag/{slug}','Front\CatalogController@tag')->name('front.tag');
  // TAG SECTION ENDS

  // TAG SECTION
  Route::get('/search/','Front\CatalogController@search')->name('front.search');
  // TAG SECTION ENDS

    Route::get('/popularproduct/','Front\PopularController@index')->name('popular.product');

  // PRODCT SECTION
  Route::get('/item/{slug}','Front\CatalogController@product')->name('front.product');
  Route::get('/afbuy/{slug}','Front\CatalogController@affProductRedirect')->name('affiliate.product');
  Route::get('/item/quick/view/{id}/','Front\CatalogController@quick')->name('product.quick');
  Route::post('/item/review','Front\CatalogController@reviewsubmit')->name('front.review.submit');
  Route::post('/item/refund','Front\CatalogController@refundsubmit')->name('front.refund.submit');
  Route::get('/item/view/review/{id}','Front\CatalogController@reviews')->name('front.reviews');
  // PRODCT SECTION ENDS

  // COMMENT SECTION
  Route::post('/item/comment/store', 'Front\CatalogController@comment')->name('product.comment');
  Route::post('/item/comment/edit/{id}', 'Front\CatalogController@commentedit')->name('product.comment.edit');
  Route::get('/item/comment/delete/{id}', 'Front\CatalogController@commentdelete')->name('product.comment.delete');
  // COMMENT SECTION ENDS

  // REPORT SECTION
  Route::post('/item/report', 'Front\CatalogController@report')->name('product.report');
  // REPORT SECTION ENDS


  // COMPARE SECTION
  Route::get('/item/compare/view', 'Front\CompareController@compare')->name('product.compare');
  Route::get('/item/compare/add/{id}', 'Front\CompareController@addcompare')->name('product.compare.add');
  Route::get('/item/compare/remove/{id}', 'Front\CompareController@removecompare')->name('product.compare.remove');
  // COMPARE SECTION ENDS

  // REPLY SECTION
  Route::post('/item/reply/{id}', 'Front\CatalogController@reply')->name('product.reply');
  Route::post('/item/reply/edit/{id}', 'Front\CatalogController@replyedit')->name('product.reply.edit');
  Route::get('/item/reply/delete/{id}', 'Front\CatalogController@replydelete')->name('product.reply.delete');
  // REPLY SECTION ENDS

  // CART SECTION
  Route::get('/carts/view','Front\CartController@cartview');
  Route::get('/carts/','Front\CartController@cart')->name('front.cart');
  Route::get('/addcart/{id}','Front\CartController@addcart')->name('product.cart.add');
  Route::get('/addtocart/{id}','Front\CartController@addtocart')->name('product.cart.quickadd');
  Route::get('/addnumcart','Front\CartController@addnumcart');
  Route::get('/addtonumcart','Front\CartController@addtonumcart');
  Route::get('/addbyone','Front\CartController@addbyone');
  Route::get('/reducebyone','Front\CartController@reducebyone');
  Route::get('/upcolor','Front\CartController@upcolor');
  Route::get('/removecart/{id}','Front\CartController@removecart')->name('product.cart.remove');
  Route::get('/carts/coupon','Front\CartController@coupon');
  Route::get('/carts/coupon/check','Front\CartController@couponcheck');
  // CART SECTION ENDS

  // CHECKOUT SECTION
  Route::get('/checkout/','Front\CheckoutController@checkout')->name('front.checkout');
  Route::get('/checkout/payment/{slug1}/{slug2}','Front\CheckoutController@loadpayment')->name('front.load.payment');
  Route::get('/order/track/{id}','Front\FrontendController@trackload')->name('front.track.search');
  Route::post('/customersupports/','Front\FrontendController@customersupports')->name('front.customer.supports');
  Route::get('/checkout/payment/return', 'Front\PaymentController@payreturn')->name('payment.return');
  Route::get('/checkout/payment/cancle', 'Front\PaymentController@paycancle')->name('payment.cancle');
  Route::post('/checkout/payment/notify', 'Front\PaymentController@notify')->name('payment.notify');
  Route::get('/checkout/instamojo/notify', 'Front\InstamojoController@notify')->name('instamojo.notify');
  
  Route::get('/load/states/{id}/', 'Front\StateController@load')->name('front-state-load');

  Route::post('/paystack/submit', 'Front\PaystackController@store')->name('paystack.submit');
  Route::post('/instamojo/submit', 'Front\InstamojoController@store')->name('instamojo.submit');
  Route::post('/paypal-submit', 'Front\PaymentController@store')->name('paypal.submit');
  Route::post('/stripe-submit', 'Front\StripeController@store')->name('stripe.submit');


  // Molly Routes

  Route::post('/molly/submit', 'Front\MollyController@store')->name('molly.submit');
  Route::get('/molly/notify', 'Front\MollyController@notify')->name('molly.notify');
  // Molly Routes Ends

   //PayTM Routes
   Route::post('/paytm-submit', 'Front\PaytmController@store')->name('paytm.submit');;
   Route::post('/paytm-callback', 'Front\PaytmController@paytmCallback')->name('paytm.notify');
   
   Route::post('/ccavenue-submit', 'Front\CcavenueController@store')->name('ccavenue.submit');;
   Route::post('/ccavenue-callback', 'Front\CcavenueController@ccavenueCallback')->name('ccavenue.notify');

  //RazorPay Routes
  Route::post('/razorpay-submit', 'Front\RazorpayController@store')->name('razorpay.submit');;
  Route::post('/razorpay-callback', 'Front\RazorpayController@razorCallback')->name('razorpay.notify');

  Route::post('/cashondelivery', 'Front\CheckoutController@cashondelivery')->name('cash.submit');
  Route::post('/gateway', 'Front\CheckoutController@gateway')->name('gateway.submit');
  // CHECKOUT SECTION ENDS

  // TAG SECTION
  Route::get('/search/','Front\CatalogController@search')->name('front.search');
  // TAG SECTION ENDS

  // VENDOR SECTION
  Route::get('/store/{category}','Front\VendorController@index')->name('front.vendor');
  Route::post('/vendor/contact','Front\VendorController@vendorcontact');
  // TAG SECTION ENDS

  // SUBSCRIBE SECTION

  Route::post('/subscriber/store', 'Front\FrontendController@subscribe')->name('front.subscribe');

  // SUBSCRIBE SECTION ENDS
  
  Route::get('/onsale/{category?}/{subcategory?}/{childcategory?}','Front\OnsaleController@index')->name('front.onsale');
  Route::get('/below1000/{category?}/{subcategory?}/{childcategory?}','Front\BelowController@index')->name('front.below'); 

 Route::get('/collections/','Front\ColloctionController@index')->name('front.colloction');
 Route::get('/designer/','Front\DesignerController@index')->name('front.designer');
 Route::get('/bridal/','Front\BribalController@index')->name('front.bribal');
 Route::get('/chokers/','Front\ChokarsController@index')->name('front.chokars');
 Route::get('/deals/','Front\OthersController@index')->name('front.others');  



  // LOGIN WITH FACEBOOK OR GOOGLE SECTION
  Route::get('auth/{provider}', 'User\SocialRegisterController@redirectToProvider')->name('social-provider');
  Route::get('auth/{provider}/callback', 'User\SocialRegisterController@handleProviderCallback');
  // LOGIN WITH FACEBOOK OR GOOGLE SECTION ENDS

  //  CRONJOB
  Route::get('/vendor/subscription/check','Front\FrontendController@subcheck');
  // CRONJOB ENDS

  // PAGE SECTION
  Route::get('/{slug}','Front\FrontendController@page')->name('front.page');
  // PAGE SECTION ENDS
  Route::get('download-all-excel-file/{type}', array('as'=>'all-excel-file','uses'=>'Admin\OrderController@allorderExcelFile'));
  Route::get('download-excel-file/{type}', array('as'=>'excel-file','uses'=>'Admin\OrderController@downloadExcelFile'));
  Route::get('download-ship-file/{type}', array('as'=>'shipping-excel-file','uses'=>'Admin\OrderController@downloadShipFile'));
  Route::get('download--file/{type}', array('as'=>'process-excel-file','uses'=>'Admin\OrderController@downloadprocessExcel'));
  Route::get('/orders/ordertracks', 'Admin\OrderController@ordertracks')->name('admin-order-ordertracks');
  Route::post('download-ftrack-file/{type}', array('as'=>'order-ftrack-data','uses'=>'Admin\OrderController@ordertrackExcel'));  
  Route::get('download-withdraw-file/{type}', array('as'=>'withdraw-excel-file','uses'=>'Admin\VendorController@withdrawpendinglist'));
  Route::get('/ordersave', 'Admin\OrderController@ordersave')->name('admin.ordersave');
  Route::post('/ordersave', 'Admin\OrderController@ordersave')->name('admin.ordersave.submit');

// ************************************ FRONT SECTION ENDS**********************************************




  });
