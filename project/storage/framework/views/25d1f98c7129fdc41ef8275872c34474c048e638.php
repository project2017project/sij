

<?php $__env->startSection('content'); ?>
<div class="content-area">
    <?php echo $__env->make('includes.form-success', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    <?php if($activation_notify != ""): ?>
    <div class="alert alert-danger validation">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                aria-hidden="true">×</span></button>
        <h3 class="text-center"><?php echo $activation_notify; ?></h3>
    </div>
    <?php endif; ?>
    
    <?php if(Session::has('cache')): ?>

    <div class="alert alert-success validation">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span></button>
        <h3 class="text-center"><?php echo e(Session::get("cache")); ?></h3>
    </div>


  <?php endif; ?>   
  
  
  
  
  
    <style>
      .tabs_cts ul.tabs{
			margin: 0px;
			padding: 0px;
			list-style: none;
		}
		.tabs_cts ul.tabs li{
			background: none;
			color: #222;
			display: inline-block;
			padding: 10px 15px;
			cursor: pointer;
		}

		.tabs_cts ul.tabs li.current{
			background: #ededed;
			color: #222;
		}

		.tabs_cts .tab-content{
			display: inherit;
			background: #ededed;
			padding: 15px;
			position : absolute;
			visibility : hidden;
			opacity : 0;
			 margin : 0 25px;
		}

		.tabs_cts .tab-content.current{
			display: inherit;
			position : initial;
			visibility : visible;
			opacity : 1;
			margin : 0;
		}
		.tabs-rev-ct{
		    position : relative;
		}
		.tabs-rev-ct .c-info-box-area{
		    margin-bottom : 30px;
		}
  </style>
  
  
  <div class="row row-cards-one tabs_cts">

        <div class="col-md-12 col-lg-12 col-xl-12 tabs-rev-ct">
            <div class="card">
                <h5 class="card-header">Overview Reports</h5>
                <div class="row row-cards-one">
                    <div class="col-md-12 col-lg-12 col-xl-12">
                 <ul class="tabs">
		<li class="tab-link current" data-tab="tab-1">This Month</li>
		
		<li class="tab-link" data-tab="tab-2">7 Days</li>
		<li class="tab-link" data-tab="tab-3">Today</li>
		<li class="tab-link" data-tab="tab-4">Yesterday</li>
		<li class="tab-link" data-tab="tab-5">Current Year</li>
		<li class="tab-link" data-tab="tab-6">Custom Date Range</li>
		
	</ul>

	<div  id="tab-1" class="tab-content current" >
	     
     <canvas id="lineChart"></canvas>
     
      <div class="row row-cards-one">
                            <div class="col-md-6 col-xl-3">
                                <div class="card c-info-box-area">
                                    <div class="c-info-box box4">
                                       <p><?php echo e(App\Models\Currency::where('is_default','=','1')->get()->first()->sign); ?>

                                        <?php echo e(App\Models\Order::where('status','=','completed')
										->where('payment_status','=','completed')
                                        ->where( 'created_at', '>', Carbon\Carbon::now()->subDays(30))
                                        ->get()->sum('pay_amount')); ?></p>
                                    </div>
                                    <div class="c-info-box-content">
                                        <h6 class="title"><?php echo e(__('Total Sales')); ?></h6>
                                        <p class="text"><?php echo e(__('Last 30 Days')); ?></p>
                                    </div>
                                </div>
                            </div>                           
                            <div class="col-md-6 col-xl-3">
                                <div class="card c-info-box-area">
                                    <div class="c-info-box box4">
                                       <p><?php echo e(App\Models\Currency::where('is_default','=','1')->get()->first()->sign); ?>

                                        <?php echo e(App\Models\Order::where('status','=','completed')
										->where('payment_status','=','completed')
                                        ->where( 'created_at', '>', Carbon\Carbon::now()->subDays(30))
                                        ->get()
                                        ->sum('pay_amount') -
                                        App\Models\VendorOrder::where('status','=','completed')
                                        ->where( 'created_at', '>', Carbon\Carbon::now()->subDays(30))
                                        ->get()
                                        ->sum('product_item_price')); ?>

                                </p>
                            </div>
                            <div class="c-info-box-content">
                                <h6 class="title"><?php echo e(__('Net Sales')); ?></h6>
                                <p class="text"><?php echo e(__('Last 30 Days')); ?></p>
                            </div>
                        </div>
                    </div>
                   
            <div class="col-md-6 col-xl-3">
                <div class="card c-info-box-area">
                    <div class="c-info-box box1">
                        <p><?php echo e(App\Models\Order::where('status','!=','Pending')->where('status','!=','declined')->where( 'created_at', '>', Carbon\Carbon::now()->subDays(30))->get()->count()); ?></p>
                    </div>
                    <div class="c-info-box-content">
                        <h6 class="title"><?php echo e(__('New Orders')); ?></h6>
                        <p class="text"><?php echo e(__('Last 30 Days')); ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-3">
                <div class="card c-info-box-area">
                    <div class="c-info-box box2">
                        <p><?php echo e(App\Models\VendorOrder::where('status','!=','Pending')->where('status','!=','declined')->where( 'created_at', '>', Carbon\Carbon::now()->subDays(30))->get()->sum('qty')); ?></p>
                    </div>
                    <div class="c-info-box-content">
                        <h6 class="title"><?php echo e(__('Total Items Sold')); ?></h6>
                        <p class="text"><?php echo e(__('Last 30 days')); ?></p>
                    </div>
                </div>
            </div>
			<div class="col-md-6 col-xl-3">
                <div class="card c-info-box-area">
                    <div class="c-info-box box2">
                        <p><?php echo e(App\Models\Order::where('status','!=','Pending')->where('status','!=','declined')->where( 'created_at', '>', Carbon\Carbon::now()->subDays(30))->get()->sum('totalQty')); ?></p>
                    </div>
                    <div class="c-info-box-content">
                        <h6 class="title"><?php echo e(__('Items Sold')); ?></h6>
                        <p class="text"><?php echo e(__('Last 30 days')); ?></p>
                    </div>
                </div>
            </div>
			                       <?php 
										$product_list = App\Models\VendorOrder::select('product_id', DB::raw('SUM(qty) as count'), DB::raw('COUNT(order_id) as ordercount'), DB::raw('SUM(price) as prices'))
                                                        ->groupBy('product_id')
						                                ->where('status','!=','pending')
						                                ->where('status','!=','declined')
						                                ->where( 'created_at', '>', Carbon\Carbon::now()->subDays(30))
                                                        ->orderBy('count', 'desc')
                                                        ->take(5)														
                                                        ->get();                     									
									?>
									
									</div>
									<div class="row">
									
								<div class="row mr-table">
		<div class="col-sm-12">
                    <h6 class="title"><?php echo e(__('Product Details')); ?></h6>
                    
         </div>
		<table id="geniustable" class="table table-hover dt-responsive" cellspacing="0" width="100%" style="background : #ffffff;">
		<?php if($product_list): ?>
								<thead>
									<tr>
				                        <th><?php echo e(__("Title")); ?></th><th><?php echo e(__("SKU")); ?></th>
				                        <th><?php echo e(__("Stock")); ?></th><th><?php echo e(__("Total sales")); ?></th><th><?php echo e(__("Total sales Amount")); ?></th><th><?php echo e(__("Category")); ?></th><th><?php echo e(__("Orders")); ?></th>				                       
										
									</tr>									
									<?php $__currentLoopData = $product_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $product_lists): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<?php if($product_lists->product_id): ?>
									<?php
                                        $ProductDetails = App\Models\Product::find($product_lists->product_id);
                                        ?>
										<?php 
										$category_all = App\Models\Category::where('id','=',$ProductDetails['category_id'])->get();
								        $category_name='';                            									
										?>
										
										<?php 
										$subcat_all = App\Models\Subcategory::where('id','=',$ProductDetails['subcategory_id'])->get();
								        $subcat_name='';                           									
										?>
										
										<?php 
										$childcat_all = App\Models\Childcategory::where('id','=',$ProductDetails['childcategory_id'])->get();
								        $childcat_name='';                           									
										?>
										
										 <?php $__currentLoopData = $category_all; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
										 <?php
                                          $category_name=$value->name;
                                         ?>                                            
                                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                    <?php $__currentLoopData = $subcat_all; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
										 <?php
                                          $subcat_name=$value->name;
                                         ?>                                            
                                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>	

                                      <?php $__currentLoopData = $childcat_all; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
										 <?php
                                          $childcat_name=$value->name;
                                         ?>                                            
                                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>	
                                <?php if($category_name && $subcat_name && $childcat_name): ?>
									<?php 
								$all_cat=$category_name.'->'.$subcat_name.'->'.$childcat_name;
								?> 
								<?php elseif($category_name && $subcat_name ): ?>
								<?php
								$all_cat=$category_name.'->'.$subcat_name;
								?> 
								<?php elseif($category_name): ?>
								<?php
									$all_cat=$category_name;
									?> 
								<?php endif; ?>									  
										
										<?php if($ProductDetails['name']): ?>
											 <?php
$total_stock = 0;
?>	
<?php if($ProductDetails['stock'] || $ProductDetails['size_qty']): ?>
	<?php
$total_stock = $ProductDetails['stock'];
?>
<?php if(!empty($ProductDetails['size_qty'])): ?>
 <?php $__currentLoopData = $ProductDetails['size_qty']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $skey => $skeydata): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<?php
$total_stock += $ProductDetails['size_qty'][$skey];
?> 

 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
 <?php endif; ?> 
<?php endif; ?>  	
									<tr>
				                        <td><?php echo e($ProductDetails['name']); ?></td><td><?php echo e($ProductDetails['sku']); ?></td>
				                        <td><?php echo e($total_stock); ?></td><td><?php echo e($product_lists->count); ?></td><td><?php echo e($product_lists->prices); ?></td><td><?php echo e($all_cat); ?></td><td><?php echo e($product_lists->ordercount); ?></td>				                        
										
									</tr>
									<?php endif; ?>
									<?php endif; ?>
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								</thead>
								<?php endif; ?>
							</table>
							</div>
           
                              
                        </div>
  
	</div>
	
	
	<div id="tab-2" class="tab-content">
	     <canvas id="lineChart7"></canvas>
	   <div class="row row-cards-one">
                            <div class="col-md-6 col-xl-3">
                                <div class="card c-info-box-area">
                                    <div class="c-info-box box4">
                                       <p><?php echo e(App\Models\Currency::where('is_default','=','1')->get()->first()->sign); ?>

                                        <?php echo e(App\Models\Order::where('status','=','completed')->where('payment_status','=','completed')->where( 'created_at', '>', Carbon\Carbon::now()->subDays(7))->get()->sum('pay_amount')); ?></p>
                                    </div>
                                    <div class="c-info-box-content">
                                        <h6 class="title"><?php echo e(__('Total Sales')); ?></h6>
                                        <p class="text"><?php echo e(__('Last 7 days')); ?></p>
                                    </div>
                                </div>
                            </div>
                           
                    <div class="col-md-6 col-xl-3">
                        <div class="card c-info-box-area">
                            <div class="c-info-box box4">
                               <p><?php echo e(App\Models\Currency::where('is_default','=','1')->get()->first()->sign); ?>

                                <?php echo e(App\Models\Order::where('status','=','completed')
								->where('payment_status','=','completed')
                                ->where( 'created_at', '>', Carbon\Carbon::now()->subDays(7))
                                ->get()
                                ->sum('pay_amount') -
                                App\Models\VendorOrder::where('status','=','completed')
                                ->where( 'created_at', '>', Carbon\Carbon::now()->subDays(7))
                                ->get()
                                ->sum('product_item_price')); ?>

                        </p>
                    </div>
                    <div class="c-info-box-content">
                        <h6 class="title"><?php echo e(__('Net Sales')); ?></h6>
                        <p class="text"><?php echo e(__('Last 7 Days')); ?></p>
                    </div>
                </div>
            </div>
            
    <div class="col-md-6 col-xl-3">
        <div class="card c-info-box-area">
            <div class="c-info-box box1">
                <p><?php echo e(App\Models\Order::where('status','!=','Pending')->where('status','!=','declined')->where( 'created_at', '>', Carbon\Carbon::now()->subDays(7))->get()->count()); ?></p>
            </div>
            <div class="c-info-box-content">
                <h6 class="title"><?php echo e(__('New Orders')); ?></h6>
                <p class="text"><?php echo e(__('Last 7 Days')); ?></p>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card c-info-box-area">
            <div class="c-info-box box2">
                <p><?php echo e(App\Models\VendorOrder::where('status','!=','Pending')->where('status','!=','declined')->where( 'created_at', '>', Carbon\Carbon::now()->subDays(7))->get()->sum('qty')); ?></p>
            </div>
            <div class="c-info-box-content">
                <h6 class="title"><?php echo e(__('Total Items Sold')); ?></h6>
                <p class="text"><?php echo e(__('Last 7 days')); ?></p>
            </div>
        </div>
    </div>
	 <div class="col-md-6 col-xl-3">
        <div class="card c-info-box-area">
            <div class="c-info-box box2">
                <p><?php echo e(App\Models\Order::where('status','!=','Pending')->where('status','!=','declined')->where( 'created_at', '>', Carbon\Carbon::now()->subDays(7))->get()->sum('totalQty')); ?></p>
            </div>
            <div class="c-info-box-content">
                <h6 class="title"><?php echo e(__('Items Sold')); ?></h6>
                <p class="text"><?php echo e(__('Last 7 days')); ?></p>
            </div>
        </div>
    </div>
	
	        <?php 
										$product_list = App\Models\VendorOrder::select('product_id', DB::raw('SUM(qty) as count'), DB::raw('COUNT(order_id) as ordercount'), DB::raw('SUM(price) as prices'))
                                                        ->groupBy('product_id')
						                                ->where('status','!=','pending')
						                                ->where('status','!=','declined')
						                                ->where( 'created_at', '>', Carbon\Carbon::now()->subDays(7))
                                                        ->orderBy('count', 'desc')
                                                        ->take(5)														
                                                        ->get();                     									
									?>
									
									<div class="">
		<div class="">
                    <h6 class="title"><?php echo e(__('Product Details')); ?></h6>
                    
         </div>
		<table id="geniustable" class="table table-hover dt-responsive" cellspacing="0" width="100%">
		<?php if($product_list): ?>
								<thead>
									<tr>
				                        <th><?php echo e(__("Title")); ?></th><th><?php echo e(__("SKU")); ?></th>
				                        <th><?php echo e(__("Stock")); ?></th><th><?php echo e(__("Total sales")); ?></th><th><?php echo e(__("Total sales Amount")); ?></th><th><?php echo e(__("Category")); ?></th><th><?php echo e(__("Orders")); ?></th>				                       
										
									</tr>									
									<?php $__currentLoopData = $product_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $product_lists): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<?php if($product_lists->product_id): ?>
									<?php
                                        $ProductDetails = App\Models\Product::find($product_lists->product_id);
                                        ?>
										<?php 
										$category_all = App\Models\Category::where('id','=',$ProductDetails['category_id'])->get();
								        $category_name='';                            									
										?>
										
										<?php 
										$subcat_all = App\Models\Subcategory::where('id','=',$ProductDetails['subcategory_id'])->get();
								        $subcat_name='';                           									
										?>
										
										<?php 
										$childcat_all = App\Models\Childcategory::where('id','=',$ProductDetails['childcategory_id'])->get();
								        $childcat_name='';                           									
										?>
										
										 <?php $__currentLoopData = $category_all; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
										 <?php
                                          $category_name=$value->name;
                                         ?>                                            
                                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                    <?php $__currentLoopData = $subcat_all; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
										 <?php
                                          $subcat_name=$value->name;
                                         ?>                                            
                                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>	

                                      <?php $__currentLoopData = $childcat_all; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
										 <?php
                                          $childcat_name=$value->name;
                                         ?>                                            
                                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>	
                                <?php if($category_name && $subcat_name && $childcat_name): ?>
									<?php 
								$all_cat=$category_name.'->'.$subcat_name.'->'.$childcat_name;
								?> 
								<?php elseif($category_name && $subcat_name ): ?>
								<?php
								$all_cat=$category_name.'->'.$subcat_name;
								?> 
								<?php elseif($category_name): ?>
								<?php
									$all_cat=$category_name;
									?> 
								<?php endif; ?>									  
										
										<?php if($ProductDetails['name']): ?>
											 <?php
$total_stock = 0;
?>	
<?php if($ProductDetails['stock'] || $ProductDetails['size_qty']): ?>
	<?php
$total_stock = $ProductDetails['stock'];
?>
<?php if(!empty($ProductDetails['size_qty'])): ?>
 <?php $__currentLoopData = $ProductDetails['size_qty']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $skey => $skeydata): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<?php
$total_stock += $ProductDetails['size_qty'][$skey];
?> 

 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
 <?php endif; ?> 
<?php endif; ?>  	
									<tr>
				                        <td><?php echo e($ProductDetails['name']); ?></td><td><?php echo e($ProductDetails['sku']); ?></td>
				                        <td><?php echo e($total_stock); ?></td><td><?php echo e($product_lists->count); ?></td><td><?php echo e($product_lists->prices); ?></td><td><?php echo e($all_cat); ?></td><td><?php echo e($product_lists->ordercount); ?></td>				                        
										
									</tr>
									<?php endif; ?>
									<?php endif; ?>
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								</thead>
								<?php endif; ?>
							</table>
							</div>
    
            
                
                    
                </div>
	</div>
	
	<div id="tab-3" class="tab-content">
	     <canvas id="lineCharttoday"></canvas>
	   <div class="row row-cards-one">
                            <div class="col-md-6 col-xl-3">
                                <div class="card c-info-box-area">
                                    <div class="c-info-box box4">
                                       <p><?php echo e(App\Models\Currency::where('is_default','=','1')->get()->first()->sign); ?>

                                        <?php echo e(App\Models\Order::where('status','=','completed')->where('payment_status','=','completed')->where( 'created_at', '>', Carbon\Carbon::now()->subDays(1))->get()->sum('pay_amount')); ?></p>
                                    </div>
                                    <div class="c-info-box-content">
                                        <h6 class="title"><?php echo e(__('Total Sales')); ?></h6>
                                        <p class="text"><?php echo e(__('Today')); ?></p>
                                    </div>
                                </div>
                            </div>
                           
                    <div class="col-md-6 col-xl-3">
                        <div class="card c-info-box-area">
                            <div class="c-info-box box4">
                               <p><?php echo e(App\Models\Currency::where('is_default','=','1')->get()->first()->sign); ?>

                                <?php echo e(App\Models\Order::where('status','=','completed')
								->where('payment_status','=','completed')
                                ->where( 'created_at', '>', Carbon\Carbon::now()->subDays(1))
                                ->get()
                                ->sum('pay_amount') -
                                App\Models\VendorOrder::where('status','=','completed')
                                ->where( 'created_at', '>', Carbon\Carbon::now()->subDays(1))
                                ->get()
                                ->sum('product_item_price')); ?>

                        </p>
                    </div>
                    <div class="c-info-box-content">
                        <h6 class="title"><?php echo e(__('Net Sales')); ?></h6>
                        <p class="text"><?php echo e(__('Today')); ?></p>
                    </div>
                </div>
            </div>
            
    <div class="col-md-6 col-xl-3">
        <div class="card c-info-box-area">
            <div class="c-info-box box1">
                <p><?php echo e(App\Models\Order::where('status','!=','Pending')->where('status','!=','declined')->where( 'created_at', '>', Carbon\Carbon::now()->subDays(1))->get()->count()); ?></p>
            </div>
            <div class="c-info-box-content">
                <h6 class="title"><?php echo e(__('New Orders')); ?></h6>
                <p class="text"><?php echo e(__('Today')); ?></p>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card c-info-box-area">
            <div class="c-info-box box2">
                <p><?php echo e(App\Models\VendorOrder::where('status','!=','Pending')->where('status','!=','declined')->where( 'created_at', '>', Carbon\Carbon::now()->subDays(1))->get()->sum('qty')); ?></p>
            </div>
            <div class="c-info-box-content">
                <h6 class="title"><?php echo e(__('Total Items Sold')); ?></h6>
                <p class="text"><?php echo e(__('Today')); ?></p>
            </div>
        </div>
    </div>
	 <div class="col-md-6 col-xl-3">
        <div class="card c-info-box-area">
            <div class="c-info-box box2">
                <p><?php echo e(App\Models\Order::where('status','!=','Pending')->where('status','!=','declined')->where( 'created_at', '>', Carbon\Carbon::now()->subDays(1))->get()->sum('totalQty')); ?></p>
            </div>
            <div class="c-info-box-content">
                <h6 class="title"><?php echo e(__('Items Sold')); ?></h6>
                <p class="text"><?php echo e(__('Today')); ?></p>
            </div>
        </div>
    </div>
	
	        <?php 
										$product_list = App\Models\VendorOrder::select('product_id', DB::raw('SUM(qty) as count'), DB::raw('COUNT(order_id) as ordercount'), DB::raw('SUM(price) as prices'))
                                                        ->groupBy('product_id')
						                                ->where('status','!=','pending')
						                                ->where('status','!=','declined')
						                                ->where( 'created_at', '>', Carbon\Carbon::now()->subDays(1))
                                                        ->orderBy('count', 'desc')
                                                        ->take(5)														
                                                        ->get();                     									
									?>
									
									<div class="">
		<div class="">
                    <h6 class="title"><?php echo e(__('Product Details')); ?></h6>
                    
         </div>
		<table id="geniustable" class="table table-hover dt-responsive" cellspacing="0" width="100%">
		<?php if($product_list): ?>
								<thead>
									<tr>
				                        <th><?php echo e(__("Title")); ?></th><th><?php echo e(__("SKU")); ?></th>
				                        <th><?php echo e(__("Stock")); ?></th><th><?php echo e(__("Total sales")); ?></th><th><?php echo e(__("Total sales Amount")); ?></th><th><?php echo e(__("Category")); ?></th><th><?php echo e(__("Orders")); ?></th>				                       
										
									</tr>									
									<?php $__currentLoopData = $product_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $product_lists): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<?php if($product_lists->product_id): ?>
									<?php
                                        $ProductDetails = App\Models\Product::find($product_lists->product_id);
                                        ?>
										<?php 
										$category_all = App\Models\Category::where('id','=',$ProductDetails['category_id'])->get();
								        $category_name='';                            									
										?>
										
										<?php 
										$subcat_all = App\Models\Subcategory::where('id','=',$ProductDetails['subcategory_id'])->get();
								        $subcat_name='';                           									
										?>
										
										<?php 
										$childcat_all = App\Models\Childcategory::where('id','=',$ProductDetails['childcategory_id'])->get();
								        $childcat_name='';                           									
										?>
										
										 <?php $__currentLoopData = $category_all; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
										 <?php
                                          $category_name=$value->name;
                                         ?>                                            
                                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                    <?php $__currentLoopData = $subcat_all; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
										 <?php
                                          $subcat_name=$value->name;
                                         ?>                                            
                                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>	

                                      <?php $__currentLoopData = $childcat_all; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
										 <?php
                                          $childcat_name=$value->name;
                                         ?>                                            
                                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>	
                                <?php if($category_name && $subcat_name && $childcat_name): ?>
									<?php 
								$all_cat=$category_name.'->'.$subcat_name.'->'.$childcat_name;
								?> 
								<?php elseif($category_name && $subcat_name ): ?>
								<?php
								$all_cat=$category_name.'->'.$subcat_name;
								?> 
								<?php elseif($category_name): ?>
								<?php
									$all_cat=$category_name;
									?> 
								<?php endif; ?>									  
										
										<?php if($ProductDetails['name']): ?>
											 <?php
$total_stock = 0;
?>	
<?php if($ProductDetails['stock'] || $ProductDetails['size_qty']): ?>
	<?php
$total_stock = $ProductDetails['stock'];
?>
<?php if(!empty($ProductDetails['size_qty'])): ?>
 <?php $__currentLoopData = $ProductDetails['size_qty']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $skey => $skeydata): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<?php
$total_stock += $ProductDetails['size_qty'][$skey];
?> 

 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
 <?php endif; ?> 
<?php endif; ?>  	
									<tr>
				                        <td><?php echo e($ProductDetails['name']); ?></td><td><?php echo e($ProductDetails['sku']); ?></td>
				                        <td><?php echo e($total_stock); ?></td><td><?php echo e($product_lists->count); ?></td><td><?php echo e($product_lists->prices); ?></td><td><?php echo e($all_cat); ?></td><td><?php echo e($product_lists->ordercount); ?></td>				                        
										
									</tr>
									<?php endif; ?>
									<?php endif; ?>
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								</thead>
								<?php endif; ?>
							</table>
							</div>
    
            
                
                    
                </div>
	</div>
	
	<div id="tab-4" class="tab-content">
	     <canvas id="lineChartyesterday"></canvas>
	   <div class="row row-cards-one">
                            <div class="col-md-6 col-xl-3">
                                <div class="card c-info-box-area">
                                    <div class="c-info-box box4">
                                       <p><?php echo e(App\Models\Currency::where('is_default','=','1')->get()->first()->sign); ?>

                                        <?php echo e(App\Models\Order::where('status','=','completed')->where('payment_status','=','completed')->where( 'created_at', '>', Carbon\Carbon::now()->subDays(2))->get()->sum('pay_amount')); ?></p>
                                    </div>
                                    <div class="c-info-box-content">
                                        <h6 class="title"><?php echo e(__('Total Sales')); ?></h6>
                                        <p class="text"><?php echo e(__('Yesterday')); ?></p>
                                    </div>
                                </div>
                            </div>
                           
                    <div class="col-md-6 col-xl-3">
                        <div class="card c-info-box-area">
                            <div class="c-info-box box4">
                               <p><?php echo e(App\Models\Currency::where('is_default','=','1')->get()->first()->sign); ?>

                                <?php echo e(App\Models\Order::where('status','=','completed')
								->where('payment_status','=','completed')
                                ->where( 'created_at', '>', Carbon\Carbon::now()->subDays(2))
                                ->get()
                                ->sum('pay_amount') -
                                App\Models\VendorOrder::where('status','=','completed')
                                ->where( 'created_at', '>', Carbon\Carbon::now()->subDays(2))
                                ->get()
                                ->sum('product_item_price')); ?>

                        </p>
                    </div>
                    <div class="c-info-box-content">
                        <h6 class="title"><?php echo e(__('Net Sales')); ?></h6>
                        <p class="text"><?php echo e(__('Yesterday')); ?></p>
                    </div>
                </div>
            </div>
            
    <div class="col-md-6 col-xl-3">
        <div class="card c-info-box-area">
            <div class="c-info-box box1">
                <p><?php echo e(App\Models\Order::where('status','!=','Pending')->where('status','!=','declined')->where( 'created_at', '>', Carbon\Carbon::now()->subDays(2))->get()->count()); ?></p>
            </div>
            <div class="c-info-box-content">
                <h6 class="title"><?php echo e(__('New Orders')); ?></h6>
                <p class="text"><?php echo e(__('Yesterday')); ?></p>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card c-info-box-area">
            <div class="c-info-box box2">
                <p><?php echo e(App\Models\VendorOrder::where('status','!=','Pending')->where('status','!=','declined')->where( 'created_at', '>', Carbon\Carbon::now()->subDays(2))->get()->sum('qty')); ?></p>
            </div>
            <div class="c-info-box-content">
                <h6 class="title"><?php echo e(__('Total Items Sold')); ?></h6>
                <p class="text"><?php echo e(__('Yesterday')); ?></p>
            </div>
        </div>
    </div>
	 <div class="col-md-6 col-xl-3">
        <div class="card c-info-box-area">
            <div class="c-info-box box2">
                <p><?php echo e(App\Models\Order::where('status','!=','Pending')->where('status','!=','declined')->where( 'created_at', '>', Carbon\Carbon::now()->subDays(2))->get()->sum('totalQty')); ?></p>
            </div>
            <div class="c-info-box-content">
                <h6 class="title"><?php echo e(__('Items Sold')); ?></h6>
                <p class="text"><?php echo e(__('Yesterday')); ?></p>
            </div>
        </div>
    </div>
    
	        <?php 
										$product_list = App\Models\VendorOrder::select('product_id', DB::raw('SUM(qty) as count'), DB::raw('COUNT(order_id) as ordercount'), DB::raw('SUM(price) as prices'))
                                                        ->groupBy('product_id')
						                                ->where('status','!=','pending')
						                                ->where('status','!=','declined')
						                                ->where( 'created_at', '>', Carbon\Carbon::now()->subDays(2))
                                                        ->orderBy('count', 'desc')
                                                        ->take(5)														
                                                        ->get();                     									
									?>
									
									<div class="">
		<div class="">
                    <h6 class="title"><?php echo e(__('Product Details')); ?></h6>
                    
         </div>
		<table id="geniustable" class="table table-hover dt-responsive" cellspacing="0" width="100%">
		<?php if($product_list): ?>
								<thead>
									<tr>
				                        <th><?php echo e(__("Title")); ?></th><th><?php echo e(__("SKU")); ?></th>
				                        <th><?php echo e(__("Stock")); ?></th><th><?php echo e(__("Total sales")); ?></th><th><?php echo e(__("Total sales Amount")); ?></th><th><?php echo e(__("Category")); ?></th><th><?php echo e(__("Orders")); ?></th>				                       
										
									</tr>									
									<?php $__currentLoopData = $product_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $product_lists): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<?php if($product_lists->product_id): ?>
									<?php
                                        $ProductDetails = App\Models\Product::find($product_lists->product_id);
                                        ?>
										<?php 
										$category_all = App\Models\Category::where('id','=',$ProductDetails['category_id'])->get();
								        $category_name='';                            									
										?>
										
										<?php 
										$subcat_all = App\Models\Subcategory::where('id','=',$ProductDetails['subcategory_id'])->get();
								        $subcat_name='';                           									
										?>
										
										<?php 
										$childcat_all = App\Models\Childcategory::where('id','=',$ProductDetails['childcategory_id'])->get();
								        $childcat_name='';                           									
										?>
										
										 <?php $__currentLoopData = $category_all; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
										 <?php
                                          $category_name=$value->name;
                                         ?>                                            
                                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                    <?php $__currentLoopData = $subcat_all; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
										 <?php
                                          $subcat_name=$value->name;
                                         ?>                                            
                                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>	

                                      <?php $__currentLoopData = $childcat_all; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
										 <?php
                                          $childcat_name=$value->name;
                                         ?>                                            
                                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>	
                                <?php if($category_name && $subcat_name && $childcat_name): ?>
									<?php 
								$all_cat=$category_name.'->'.$subcat_name.'->'.$childcat_name;
								?> 
								<?php elseif($category_name && $subcat_name ): ?>
								<?php
								$all_cat=$category_name.'->'.$subcat_name;
								?> 
								<?php elseif($category_name): ?>
								<?php
									$all_cat=$category_name;
									?> 
								<?php endif; ?>									  
										
										<?php if($ProductDetails['name']): ?>
											 <?php
$total_stock = 0;
?>	
<?php if($ProductDetails['stock'] || $ProductDetails['size_qty']): ?>
	<?php
$total_stock = $ProductDetails['stock'];
?>
<?php if(!empty($ProductDetails['size_qty'])): ?>
 <?php $__currentLoopData = $ProductDetails['size_qty']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $skey => $skeydata): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<?php
$total_stock += $ProductDetails['size_qty'][$skey];
?> 

 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
 <?php endif; ?> 
<?php endif; ?>  	
									<tr>
				                        <td><?php echo e($ProductDetails['name']); ?></td><td><?php echo e($ProductDetails['sku']); ?></td>
				                        <td><?php echo e($total_stock); ?></td><td><?php echo e($product_lists->count); ?></td><td><?php echo e($product_lists->prices); ?></td><td><?php echo e($all_cat); ?></td><td><?php echo e($product_lists->ordercount); ?></td>				                        
										
									</tr>
									<?php endif; ?>
									<?php endif; ?>
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								</thead>
								<?php endif; ?>
							</table>
							</div>
            
                
                    
                </div>
	</div>
	
	
	<div id="tab-5" class="tab-content">
	
	 <canvas id="lineChartyear"></canvas>
	
	<div class="row row-cards-one">
                    <div class="col-md-6 col-xl-3">
                        <div class="card c-info-box-area">
                            <div class="c-info-box box4">
                                 <p><?php echo e(App\Models\Currency::where('is_default','=','1')->get()->first()->sign); ?>

                                    <?php echo e(App\Models\Order::where('status','=','completed')
									                    ->where('payment_status','=','completed')
                                                        ->whereYear( 'created_at', '=', Carbon\Carbon::now()->year)
                                                        ->get()
                                                        ->sum('pay_amount')); ?>

                                </p>
                            </div>
                            <div class="c-info-box-content">
                                <h6 class="title"><?php echo e(__('Total Sales')); ?></h6>
                                <p class="text"><?php echo e(__('Current Year')); ?></p>
                            </div>
                        </div>
                    </div>                   

                    <div class="col-md-6 col-xl-3">
                        <div class="card c-info-box-area">
                            <div class="c-info-box box4">
                                 <p><?php echo e(App\Models\Currency::where('is_default','=','1')->get()->first()->sign); ?>

                                    <?php echo e(App\Models\Order::where('status','=','completed')
									                    ->where('payment_status','=','completed')
                                                        ->whereYear( 'created_at', '=', Carbon\Carbon::now()->year)
                                                        ->get()
                                                        ->sum('pay_amount') -
                                        App\Models\VendorOrder::where('status','=','completed')
                                                        ->whereYear( 'created_at', '=', Carbon\Carbon::now()->year)
                                                        ->get()
                                                        ->sum('product_item_price')); ?>

                                </p>
                            </div>
                            <div class="c-info-box-content">
                                <h6 class="title"><?php echo e(__('Net Sales')); ?></h6>
                                <p class="text"><?php echo e(__('Current Year')); ?></p>
                            </div>
                        </div>
                    </div>
                   
                    <div class="col-md-6 col-xl-3">
                        <div class="card c-info-box-area">
                            <div class="c-info-box box1">
                                <p><?php echo e(App\Models\Order::where('status','=','completed')
                                    ->whereYear( 'created_at', '=', Carbon\Carbon::now()->year)->get()->count()); ?></p>
                            </div>
                            <div class="c-info-box-content">
                                <h6 class="title"><?php echo e(__('New Orders')); ?></h6>
                                <p class="text"><?php echo e(__('Current Year')); ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-3">
                        <div class="card c-info-box-area">
                            <div class="c-info-box box2">
                                <p><?php echo e(App\Models\VendorOrder::where('status','=','completed')
                                    ->whereYear( 'created_at', '=', Carbon\Carbon::now()->year)->get()->sum('qty')); ?></p>
                            </div>
                            <div class="c-info-box-content">
                                <h6 class="title"><?php echo e(__('Total Items Sold')); ?></h6>
                                <p class="text"><?php echo e(__('Current Year')); ?></p>
                            </div>
                        </div>
                    </div> 

                     <div class="col-md-6 col-xl-3">
                        <div class="card c-info-box-area">
                            <div class="c-info-box box2">
                                <p><?php echo e(App\Models\Order::where('status','=','completed')
                                    ->whereYear( 'created_at', '=', Carbon\Carbon::now()->year)->get()->sum('totalQty')); ?></p>
                            </div>
                            <div class="c-info-box-content">
                                <h6 class="title"><?php echo e(__('Items Sold')); ?></h6>
                                <p class="text"><?php echo e(__('Current Year')); ?></p>
                            </div>
                        </div>
                    </div> 	
 <?php 
										$product_list = App\Models\VendorOrder::select('product_id', DB::raw('SUM(qty) as count'), DB::raw('COUNT(order_id) as ordercount'), DB::raw('SUM(price) as prices'))
                                                        ->groupBy('product_id')
						                                ->where('status','!=','pending')
						                                ->where('status','!=','declined')
						                                ->where( 'created_at', '>',  Carbon\Carbon::now()->year)
                                                        ->orderBy('count', 'desc')
                                                        ->take(5)														
                                                        ->get();                     									
									?>
									
									<div class="">
		<div class="">
                    <h6 class="title"><?php echo e(__('Product Details')); ?></h6>
                    
         </div>
		<table id="geniustable" class="table table-hover dt-responsive" cellspacing="0" width="100%">
		<?php if($product_list): ?>
								<thead>
									<tr>
				                        <th><?php echo e(__("Title")); ?></th><th><?php echo e(__("SKU")); ?></th>
				                        <th><?php echo e(__("Stock")); ?></th><th><?php echo e(__("Total sales")); ?></th><th><?php echo e(__("Total sales Amount")); ?></th><th><?php echo e(__("Category")); ?></th><th><?php echo e(__("Orders")); ?></th>				                       
										
									</tr>									
									<?php $__currentLoopData = $product_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $product_lists): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<?php if($product_lists->product_id): ?>
									<?php
                                        $ProductDetails = App\Models\Product::find($product_lists->product_id);
                                        ?>
										<?php 
										$category_all = App\Models\Category::where('id','=',$ProductDetails['category_id'])->get();
								        $category_name='';                            									
										?>
										
										<?php 
										$subcat_all = App\Models\Subcategory::where('id','=',$ProductDetails['subcategory_id'])->get();
								        $subcat_name='';                           									
										?>
										
										<?php 
										$childcat_all = App\Models\Childcategory::where('id','=',$ProductDetails['childcategory_id'])->get();
								        $childcat_name='';                           									
										?>
										
										 <?php $__currentLoopData = $category_all; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
										 <?php
                                          $category_name=$value->name;
                                         ?>                                            
                                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                    <?php $__currentLoopData = $subcat_all; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
										 <?php
                                          $subcat_name=$value->name;
                                         ?>                                            
                                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>	

                                      <?php $__currentLoopData = $childcat_all; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
										 <?php
                                          $childcat_name=$value->name;
                                         ?>                                            
                                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>	
                                <?php if($category_name && $subcat_name && $childcat_name): ?>
									<?php 
								$all_cat=$category_name.'->'.$subcat_name.'->'.$childcat_name;
								?> 
								<?php elseif($category_name && $subcat_name ): ?>
								<?php
								$all_cat=$category_name.'->'.$subcat_name;
								?> 
								<?php elseif($category_name): ?>
								<?php
									$all_cat=$category_name;
									?> 
								<?php endif; ?>									  
										
										<?php if($ProductDetails['name']): ?>
											 <?php
$total_stock = 0;
?>	
<?php if($ProductDetails['stock'] || $ProductDetails['size_qty']): ?>
	<?php
$total_stock = $ProductDetails['stock'];
?>
<?php if(!empty($ProductDetails['size_qty'])): ?>
 <?php $__currentLoopData = $ProductDetails['size_qty']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $skey => $skeydata): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<?php
$total_stock += $ProductDetails['size_qty'][$skey];
?> 

 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
 <?php endif; ?> 
<?php endif; ?>  	
									<tr>
				                        <td><?php echo e($ProductDetails['name']); ?></td><td><?php echo e($ProductDetails['sku']); ?></td>
				                        <td><?php echo e($total_stock); ?></td><td><?php echo e($product_lists->count); ?></td><td><?php echo e($product_lists->prices); ?></td><td><?php echo e($all_cat); ?></td><td><?php echo e($product_lists->ordercount); ?></td>				                        
										
									</tr>
									<?php endif; ?>
									<?php endif; ?>
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								</thead>
								<?php endif; ?>
							</table>
							</div>					
                         
                </div>	
	</div>
	
	
	<div id="tab-6" class="tab-content">
		<div class="row row-cards-one">

        <div class="col-md-12 col-lg-12 col-xl-12">
            <form id="contactform" action="<?php echo e(route('admin.overview.submit')); ?>" method="POST">
                <?php echo e(csrf_field()); ?>

                <input type="date" name="startdate">
                <input type="date" name="enddate">
                <input type="submit" name="submit">
            </form>
            <?php $enddates =date('Y-m-d', strtotime("-1 day", strtotime($enddate)));;?>
               <?php if($startdate && $enddates): ?>
                Start Date : <?php echo e($startdate); ?> End Date : <?php echo e($enddates); ?>

			<?php endif; ?>
                <div class="row row-cards-one">

                    <?php if(!empty($days_between-1)): ?>
                    <div class="col-md-6 col-xl-3">
            <div class="card c-info-box-area">
                <div class="c-info-box box4">
                     <p><?php echo e(App\Models\Currency::where('is_default','=','1')->get()->first()->sign); ?>

                        <?php echo e($pay_amount); ?>

                    </p>
                </div>
                <div class="c-info-box-content">
                    <h6 class="title"><?php echo e(__('Total Sales')); ?></h6>
                    
                </div>
            </div>
        </div>
        
         <div class="col-md-6 col-xl-3">
            <div class="card c-info-box-area">
                <div class="c-info-box box4">
                     <p><?php echo e(App\Models\Currency::where('is_default','=','1')->get()->first()->sign); ?>

                        <?php echo e($pay_amount - $refund_fee); ?>

                    </p>
                </div>
                <div class="c-info-box-content">
                    <h6 class="title"><?php echo e(__('Net Sales')); ?></h6>
                    
                </div>
            </div>
        </div>
       
        <div class="col-md-6 col-xl-3">
            <div class="card c-info-box-area">
                <div class="c-info-box box1">
                    <p><?php echo e($allorders); ?></p>
                </div>
                <div class="c-info-box-content">
                    <h6 class="title"><?php echo e(__('New Orders')); ?></h6>
                    
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="card c-info-box-area">
                <div class="c-info-box box2">
                    <p><?php echo e($qty_data); ?></p>
                </div>
                <div class="c-info-box-content">
                    <h6 class="title"><?php echo e(__('Total Items Sold')); ?></h6>
                    
                </div>
            </div>
        </div>
		<div class="col-md-6 col-xl-3">
            <div class="card c-info-box-area">
                <div class="c-info-box box2">
                    <p><?php echo e($totalQty); ?></p>
                </div>
                <div class="c-info-box-content">
                    <h6 class="title"><?php echo e(__('Items Sold')); ?></h6>
                    
                </div>
            </div>
        </div>
		<div class="">
		<div class="">
                    <h6 class="title"><?php echo e(__('Product Details')); ?></h6>
                    
         </div>
		<table id="geniustable" class="table table-hover dt-responsive" cellspacing="0" width="100%">
		<?php if($product_list): ?>
								<thead>
									<tr>
				                        <th><?php echo e(__("Title")); ?></th><th><?php echo e(__("SKU")); ?></th>
				                        <th><?php echo e(__("Stock")); ?></th><th><?php echo e(__("Total sales")); ?></th><th><?php echo e(__("Total sales Amount")); ?></th><th><?php echo e(__("Category")); ?></th><th><?php echo e(__("Orders")); ?></th>				                       
										
									</tr>									
									<?php $__currentLoopData = $product_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $product_lists): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<?php if($product_lists->product_id): ?>
									<?php
                                        $ProductDetails = App\Models\Product::find($product_lists->product_id);
                                        ?>
										<?php 
										$category_all = App\Models\Category::where('id','=',$ProductDetails['category_id'])->get();
								        $category_name='';                            									
										?>
										
										<?php 
										$subcat_all = App\Models\Subcategory::where('id','=',$ProductDetails['subcategory_id'])->get();
								        $subcat_name='';                           									
										?>
										
										<?php 
										$childcat_all = App\Models\Childcategory::where('id','=',$ProductDetails['childcategory_id'])->get();
								        $childcat_name='';                           									
										?>
										
										 <?php $__currentLoopData = $category_all; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
										 <?php
                                          $category_name=$value->name;
                                         ?>                                            
                                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                    <?php $__currentLoopData = $subcat_all; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
										 <?php
                                          $subcat_name=$value->name;
                                         ?>                                            
                                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>	

                                      <?php $__currentLoopData = $childcat_all; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
										 <?php
                                          $childcat_name=$value->name;
                                         ?>                                            
                                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>	
                                <?php if($category_name && $subcat_name && $childcat_name): ?>
									<?php 
								$all_cat=$category_name.'->'.$subcat_name.'->'.$childcat_name;
								?> 
								<?php elseif($category_name && $subcat_name ): ?>
								<?php
								$all_cat=$category_name.'->'.$subcat_name;
								?> 
								<?php elseif($category_name): ?>
								<?php
									$all_cat=$category_name;
									?> 
								<?php endif; ?>									  
										
										<?php if($ProductDetails['name']): ?>
											 <?php
$total_stock = 0;
?>	
<?php if($ProductDetails['stock'] || $ProductDetails['size_qty']): ?>
	<?php
$total_stock = $ProductDetails['stock'];
?>
<?php if(!empty($ProductDetails['size_qty'])): ?>
 <?php $__currentLoopData = $ProductDetails['size_qty']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $skey => $skeydata): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<?php
$total_stock += $ProductDetails['size_qty'][$skey];
?> 

 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
 <?php endif; ?> 
<?php endif; ?>  	
									<tr>
				                        <td><?php echo e($ProductDetails['name']); ?></td><td><?php echo e($ProductDetails['sku']); ?></td>
				                        <td><?php echo e($total_stock); ?></td><td><?php echo e($product_lists->count); ?></td><td><?php echo e($product_lists->prices); ?></td><td><?php echo e($all_cat); ?></td><td><?php echo e($product_lists->ordercount); ?></td>				                        
										
									</tr>
									<?php endif; ?>
									<?php endif; ?>
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								</thead>
								<?php endif; ?>
							</table>
							</div>
        
        <?php else: ?>
        <p>Please Select Range</p>
     
        <?php endif; ?>
        
                </div>
           

        </div>

    </div>
	</div>
	
	
	
  </div>
                </div>
                </div>
                </div>
                </div>
  
   
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>

<script language="JavaScript">
    displayLineChart();
    displayLineChartyear();
    displayLineChart7();
	displayLineChartyes();
	displayLineCharttoday();

function displayLineChartrangerecord() {
        var data = {
            labels: [
            <?php echo $daysrange; ?>

            ],
           
            datasets: [{
                label: "Prime and Fibonacci",
                fillColor: "#3dbcff",
                strokeColor: "#0099ff",
                pointColor: "rgba(220,220,220,1)",
                pointStrokeColor: "#fff",
                pointHighlightFill: "#fff",
                pointHighlightStroke: "rgba(220,220,220,1)",
                data: [
                <?php echo $salesrange; ?>

                ]
            }]
        };

        var ctx = document.getElementById("lineChartrange").getContext("2d");
        var options = {
            responsive: true,
            showXLabels: 10 
        };
        var lineChart = new Chart(ctx).Line(data, options);
    }
    function displayLineChart7() {
        var data = {
            labels: [
            <?php echo $days7; ?>

            ],
            datasets: [{
                label: "Prime and Fibonacci",
                fillColor: "#3dbcff",
                strokeColor: "#0099ff",
                pointColor: "rgba(220,220,220,1)",
                pointStrokeColor: "#fff",
                pointHighlightFill: "#fff",
                pointHighlightStroke: "rgba(220,220,220,1)",
                data: [
                <?php echo $sales7; ?>

                ]
            }]
        };
        var ctx = document.getElementById("lineChart7").getContext("2d");
        var options = {
            responsive: true
        };
        var lineChart = new Chart(ctx).Line(data, options);
    }
	 function displayLineChartyes() {
        var data = {
            labels: [
            <?php echo $days_yes; ?>

            ],
            datasets: [{
                label: "Prime and Fibonacci",
                fillColor: "#3dbcff",
                strokeColor: "#0099ff",
                pointColor: "rgba(220,220,220,1)",
                pointStrokeColor: "#fff",
                pointHighlightFill: "#fff",
                pointHighlightStroke: "rgba(220,220,220,1)",
                data: [
                <?php echo $sales_yes; ?>

                ]
            }]
        };
        var ctx = document.getElementById("lineChartyesterday").getContext("2d");
        var options = {
            responsive: true
        };
        var lineChart = new Chart(ctx).Line(data, options);
    }
	 function displayLineCharttoday() {
        var data = {
            labels: [
            <?php echo $days_today; ?>

            ],
            datasets: [{
                label: "Prime and Fibonacci",
                fillColor: "#3dbcff",
                strokeColor: "#0099ff",
                pointColor: "rgba(220,220,220,1)",
                pointStrokeColor: "#fff",
                pointHighlightFill: "#fff",
                pointHighlightStroke: "rgba(220,220,220,1)",
                data: [
                <?php echo $sales_today; ?>

                ]
            }]
        };
        var ctx = document.getElementById("lineCharttoday").getContext("2d");
        var options = {
            responsive: true
        };
        var lineChart = new Chart(ctx).Line(data, options);
    }
      function displayLineChartyear() {
        var data = {
            labels: [
            <?php echo $daysyear; ?>

            ],
            datasets: [{
                label: "Prime and Fibonacci",
                fillColor: "#3dbcff",
                strokeColor: "#0099ff",
                pointColor: "rgba(220,220,220,1)",
                pointStrokeColor: "#fff",
                pointHighlightFill: "#fff",
                pointHighlightStroke: "rgba(220,220,220,1)",
                data: [
                <?php echo $salesyear; ?>

                ]
            }]
        };
        var ctx = document.getElementById("lineChartyear").getContext("2d");
        var options = {
            responsive: true
        };
        var lineChart = new Chart(ctx).Line(data, options);
    }
    function displayLineChart() {
        var data = {
            labels: [
            <?php echo $days; ?>

            ],
            datasets: [{
                label: "Prime and Fibonacci",
                fillColor: "#3dbcff",
                strokeColor: "#0099ff",
                pointColor: "rgba(220,220,220,1)",
                pointStrokeColor: "#fff",
                pointHighlightFill: "#fff",
                pointHighlightStroke: "rgba(220,220,220,1)",
                data: [
                <?php echo $sales; ?>

                ]
            }]
        };
        var ctx = document.getElementById("lineChart").getContext("2d");
        var options = {
            responsive: true
        };
        var lineChart = new Chart(ctx).Line(data, options);
    }
     function displayLineChart2() {
        var data = {
            labels: [
            <?php echo $days30; ?>

            ],
            datasets: [{
                label: "Prime and Fibonacci",
                fillColor: "#3dbcff",
                strokeColor: "#0099ff",
                pointColor: "rgba(220,220,220,1)",
                pointStrokeColor: "#fff",
                pointHighlightFill: "#fff",
                pointHighlightStroke: "rgba(220,220,220,1)",
                data: [
                <?php echo $sales30; ?>

                ]
            }]
        };
        var ctx = document.getElementById("lineChart2").getContext("2d");
        var options = {
            responsive: true
        };
        var lineChart = new Chart(ctx).Line(data, options);
    }


    
</script>

<script type="text/javascript">
    $('#poproducts').dataTable( {
      "ordering": false,
          'lengthChange': false,
          'searching'   : false,
          'ordering'    : false,
          'info'        : false,
          'autoWidth'   : false,
          'responsive'  : true,
          'paging'  : false
    } );
    </script>


<script type="text/javascript">
    $('#pproducts').dataTable( {
      "ordering": false,
      'lengthChange': false,
          'searching'   : false,
          'ordering'    : false,
          'info'        : false,
          'autoWidth'   : false,
          'responsive'  : true,
          'paging'  : false
    } );
    </script>

<script type="text/javascript">
        var chart1 = new CanvasJS.Chart("chartContainer-topReference",
            {
                exportEnabled: true,
                animationEnabled: true,

                legend: {
                    cursor: "pointer",
                    horizontalAlign: "right",
                    verticalAlign: "center",
                    fontSize: 16,
                    padding: {
                        top: 20,
                        bottom: 2,
                        right: 20,
                    },
                },
                data: [
                    {
                        type: "pie",
                        showInLegend: true,
                        legendText: "",
                        toolTipContent: "{name}: <strong>{#percent%} (#percent%)</strong>",
                        indexLabel: "#percent%",
                        indexLabelFontColor: "white",
                        indexLabelPlacement: "inside",
                        dataPoints: [
                                <?php $__currentLoopData = $referrals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $browser): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    {y:<?php echo e($browser->total_count); ?>, name: "<?php echo e($browser->referral); ?>"},
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        ]
                    }
                ]
            });
        chart1.render();

        var chart = new CanvasJS.Chart("chartContainer-os",
            {
                exportEnabled: true,
                animationEnabled: true,
                legend: {
                    cursor: "pointer",
                    horizontalAlign: "right",
                    verticalAlign: "center",
                    fontSize: 16,
                    padding: {
                        top: 20,
                        bottom: 2,
                        right: 20,
                    },
                },
                data: [
                    {
                        type: "pie",
                        showInLegend: true,
                        legendText: "",
                        toolTipContent: "{name}: <strong>{#percent%} (#percent%)</strong>",
                        indexLabel: "#percent%",
                        indexLabelFontColor: "white",
                        indexLabelPlacement: "inside",
                        dataPoints: [
                            <?php $__currentLoopData = $browsers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $browser): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                {y:<?php echo e($browser->total_count); ?>, name: "<?php echo e($browser->referral); ?>"},
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        ]
                    }
                ]
            });
        chart.render();    
</script>

<script>
                    $(document).ready(function(){
	
	$('ul.tabs li').click(function(){
		var tab_id = $(this).attr('data-tab');

		$('ul.tabs li').removeClass('current');
		$('.tab-content').removeClass('current');

		$(this).addClass('current');
		$("#"+tab_id).addClass('current');
	})

})
                </script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>