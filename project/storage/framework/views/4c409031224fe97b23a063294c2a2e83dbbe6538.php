

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
            <form id="contactform" action="<?php echo e(route('admin.revenue.submit')); ?>" method="POST">
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
                <div class="c-info-box box4">
                     <p><?php echo e(App\Models\Currency::where('is_default','=','1')->get()->first()->sign); ?>

                        <?php echo e(round($pay_amount, 2)); ?>

                    </p>
                </div>
                <div class="c-info-box-content">
                    <h6 class="title"><?php echo e(__('Gross Payment')); ?></h6>
                    
                </div>
            </div>
        </div>  

		<div class="col-md-6 col-xl-3">
            <div class="card c-info-box-area">
                <div class="c-info-box box1">
                    <p><?php echo e(App\Models\Currency::where('is_default','=','1')->get()->first()->sign); ?>

					<?php echo e(round($pay_amount - $refund_fee,2)); ?>

					</p>
                </div>
                <div class="c-info-box-content">
                    <h6 class="title"><?php echo e(__('Net payment')); ?></h6>
                    
                </div>
            </div>
        </div>		 
 
<div class="col-md-6 col-xl-3">
            <div class="card c-info-box-area">
                <div class="c-info-box box2">
                    <p><?php echo e(App\Models\Currency::where('is_default','=','1')->get()->first()->sign); ?>

					<?php echo e(round($admin_fee, 2)); ?>

					</p>
                </div>
                <div class="c-info-box-content">
                    <h6 class="title"><?php echo e(__('Admin Fees')); ?></h6>
                    
                </div>
            </div>
        </div>	
 
		 <div class="col-md-6 col-xl-3">
            <div class="card c-info-box-area">
                <div class="c-info-box box3">
                    <p><?php echo e(App\Models\Currency::where('is_default','=','1')->get()->first()->sign); ?>

					<?php echo e(round($shipping_cost, 2)); ?>

					</p>
                </div>
                <div class="c-info-box-content">
                    <h6 class="title"><?php echo e(__('Shipping Cost')); ?></h6>
                    
                </div>
            </div>
        </div>
		 <div class="col-md-6 col-xl-3">
            <div class="card c-info-box-area">
                <div class="c-info-box box4">
                     <p><?php echo e(App\Models\Currency::where('is_default','=','1')->get()->first()->sign); ?>

                        <?php echo e(round($admin_fee*18/100, 2)); ?>

                    </p>
                </div>
                <div class="c-info-box-content">
                    <h6 class="title"><?php echo e(__('Taxes')); ?></h6>
                    
                </div>
            </div>
        </div> 

<div class="col-md-6 col-xl-3">
            <div class="card c-info-box-area">
                <div class="c-info-box box1">
                    <p><?php echo e(App\Models\Currency::where('is_default','=','1')->get()->first()->sign); ?>

					<?php echo e(round($refund_fee, 2)); ?>

					</p>
                </div>
                <div class="c-info-box-content">
                    <h6 class="title"><?php echo e(__('Refund Amount')); ?></h6>
                    
                </div>
            </div>
        </div>	
	
	
	<div class="col-md-6 col-xl-3">
            <div class="card c-info-box-area">
                <div class="c-info-box box3">
                    <p><?php echo e(App\Models\Currency::where('is_default','=','1')->get()->first()->sign); ?>

					<?php echo e(round($shipping_cost, 2)); ?>

					</p>
                </div>
                <div class="c-info-box-content">
                    <h6 class="title"><?php echo e(__('Coupons')); ?></h6>
                    
                </div>
            </div>
        </div>
        
        </div>
				<div class="row">
<div class="col-sm-12">
<div class="">
<h6 class="title"><?php echo e(__('Order List')); ?> <button id="download-button"> EXPORT </button></h6>                    
</div>
		
							<?php if($all_orders): ?>
							<table id="geniustable" class="table table-hover dt-responsive" style="background : #ffffff;" cellspacing="0" width="100%">
							<thead>
								<tr>
									<th><?php echo e(__('Order Number')); ?></th>
									<th><?php echo e(__('Customer Name')); ?></th>
									<th><?php echo e(__('Customer Email')); ?></th>
									<th><?php echo e(__('Customer Phone')); ?></th>									
									<th><?php echo e(__('Quantity')); ?></th>
									<th><?php echo e(__('Gross Sale (INR)')); ?></th>
                                    <th><?php echo e(__('Status')); ?></th>
                                    <th><?php echo e(__('Payment')); ?></th>										
                                    <th><?php echo e(__('Order Date')); ?></th>									
									
									</tr>
									<?php $__currentLoopData = $all_orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $all_order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<?php
                                        $OrderDetails = App\Models\Order::find($all_order['id']);
                                        ?>
										<?php
                                        $ProductDetails = App\Models\Product::find($all_order['product_id']);
                                        ?>
										<?php
                                        $price = $OrderDetails['inr_currency_sign'].$all_order['price']
										?>	
                                        <?php
                                        $paystatus =  $OrderDetails['payment_status']
                                        ?>											
									<tr>
				                        <td><a href="<?php echo e(route('admin-order-show',$all_order['id'])); ?>"><?php echo e($all_order['order_number']); ?> <a></td>
                                        <td><?php echo e($OrderDetails['customer_name']); ?></td>
                                        <td><?php echo e($OrderDetails['customer_email']); ?></td>
                                        <td><?php echo e($OrderDetails['customer_phone']); ?></td>                                        
										<td><?php echo e($OrderDetails['totalQty']); ?></td>
                                        <td><?php echo e($OrderDetails['pay_amount']); ?></td>
										<td><?php echo e($all_order['status']); ?></td>
                                         <?php if($paystatus == 'Completed'): ?>
										<td>Paid</td>
									    <?php else: ?>
											<td>Unpaid</td>
										<?php endif; ?>
                                        <td><?php echo e($all_order['created_at']); ?></td>
                                        
                                         										
										
									</tr>
								
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							</thead>
							<?php endif; ?>
						</table>
						<iframe id="txtArea1" style="display:none"></iframe>
						
						<script>
						    function htmlToCSV(html, filename) {
	var data = [];
	var rows = document.querySelectorAll("table tr");
			
	for (var i = 0; i < rows.length; i++) {
		var row = [], cols = rows[i].querySelectorAll("td, th");
				
		for (var j = 0; j < cols.length; j++) {
		        row.push(cols[j].innerText);
                 }
		        
		data.push(row.join(",")); 		
	}

	downloadCSVFile(data.join("\n"), filename);
}

function downloadCSVFile(csv, filename) {
	var csv_file, download_link;

	csv_file = new Blob([csv], {type: "text/csv"});

	download_link = document.createElement("a");

	download_link.download = filename;

	download_link.href = window.URL.createObjectURL(csv_file);

	download_link.style.display = "none";

	document.body.appendChild(download_link);

	download_link.click();
}


document.getElementById("download-button").addEventListener("click", function () {
	var html = document.querySelector("table").outerHTML;
	htmlToCSV(html, "reports.csv");
});

						</script>
						
						
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