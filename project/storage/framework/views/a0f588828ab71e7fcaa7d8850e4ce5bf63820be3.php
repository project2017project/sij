

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
                <h5 class="card-header">Revenue Reports</h5>
                <div class="row row-cards-one">
                    <div class="col-md-12 col-lg-12 col-xl-12">
                 <ul class="tabs">		
		
		<li class="tab-link" data-tab="tab-1"></li>
		
	</ul>	
	
	<div  id="tab-1" class="tab-content current" >
		<div class="row row-cards-one">

        <div class="col-md-12 col-lg-12 col-xl-12">
            <form id="contactform" action="<?php echo e(route('admin.productrecord.submit')); ?>" method="POST">
                <?php echo e(csrf_field()); ?>

				<select name="vendor" id="vendor">
                                    <option value=''>all</option>
									<?php
$sel= ''

?>
                                    <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $userid): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									 <?php if($vendor_id==$userid->id): ?>
																	<?php
$sel= 'selected';
?>
<?php else: ?>
	<?php
$sel= '';	
?>
									 
										 <?php endif; ?>
                                    <option value="<?php echo e($userid->id); ?>" <?php echo e($sel); ?>><?php echo e($userid->shop_name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>                                        
                                </select> 
                <input type="date" name="startdate">
                <input type="date" name="enddate">
                <input type="submit" name="submit">
				<?php $enddates =date('Y-m-d', strtotime("-1 day", strtotime($enddate)));;?>
				<?php if($startdate && $enddates): ?>
                Start Date : <?php echo e($startdate); ?> End Date : <?php echo e($enddates); ?>

			<?php endif; ?>
            </form>
            
                <div class="row row-cards-one">

                    <?php if(!empty($days_between-1)): ?>                  
        
        <div class="col-md-6 col-xl-3">
            <div class="card c-info-box-area">
                <div class="c-info-box box1">
                    <p><?php echo e(App\Models\Currency::where('is_default','=','1')->get()->first()->sign); ?>

					<?php echo e(round($pay_amount - $refund_fee,2)); ?>

					</p>
                </div>
                <div class="c-info-box-content">
                    <h6 class="title"><?php echo e(__('Net Sales')); ?></h6>
                    
                </div>
            </div>
        </div>		 
 
<div class="col-md-6 col-xl-3">
            <div class="card c-info-box-area">
                <div class="c-info-box box2">
                    <p>
					<?php echo e($allorders); ?>

					</p>
                </div>
                <div class="c-info-box-content">
                    <h6 class="title"><?php echo e(__('Orders')); ?></h6>
                    
                </div>
            </div>
        </div>
		
		<div class="col-md-6 col-xl-3">
            <div class="card c-info-box-area">
                <div class="c-info-box box2">
                    <p>
					<?php echo e($totalQty); ?>

					</p>
                </div>
                <div class="c-info-box-content">
                    <h6 class="title"><?php echo e(__('Item sold')); ?></h6>
                    
                </div>
            </div>
        </div>
		<div class="">
		<div class="">
                    <h6 class="title"><?php echo e(__('Product Details')); ?></h6>
                    
         </div>
		<table id="geniustable" class="table table-hover dt-responsive" cellspacing="0" style="background : #ffffff;" width="100%">
		<?php if($product_list): ?>
								<thead>
									<tr>
				                        <th><?php echo e(__("Product Name")); ?></th><th><?php echo e(__("SKU")); ?></th>
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
<?php echo $__env->make('layouts.admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>