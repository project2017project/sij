 

<?php $__env->startSection('content'); ?>
<?php
$debitdata = 0;
$creditdata = 0;
?>  
<?php
            $alldatapr = App\Models\VendorOrder::where('user_id','=',$user->id)->where('admin_approve','=','approved')->whereIn('vendor_request_status',['NotRaised','rejected'])->orderBy('id','desc')->sum('price');
			
			$all_adminfee = App\Models\VendorOrder::where('user_id','=',$user->id)->where('admin_approve','=','approved')->whereIn('vendor_request_status',['NotRaised','rejected'])->orderBy('id','desc')->sum('admin_fee');
			
			$all_cgst = App\Models\VendorOrder::where('user_id','=',$user->id)->where('admin_approve','=','approved')->whereIn('vendor_request_status',['NotRaised','rejected'])->orderBy('id','desc')->sum('cgst');
			
			$all_sgst = App\Models\VendorOrder::where('user_id','=',$user->id)->where('admin_approve','=','approved')->whereIn('vendor_request_status',['NotRaised','rejected'])->orderBy('id','desc')->sum('sgst');
            
            
            
             $alldataref = App\Models\VendorOrder::where('user_id','=',$user->id)->where('admin_approve','=','approved')->whereIn('vendor_request_status',['NotRaised','rejected'])->orderBy('id','desc')->sum('product_item_price');
             
             $alldata = round($alldatapr,2) - round($alldataref,2);
             
             $comissionalldata =  $alldata * 15/100;
             
             $comissiontax =  $comissionalldata * 18/100;
             
             
             $grpay = round($alldata,2) - round($comissionalldata,2) - round($comissiontax,2); 
             
             
			$state=$user->state;
			$gst_number=$user->reg_number;
				  $commissiontcs = 0;
			
				if($state == 'Tamil Nadu'){
            				              
            				           if($gst_number == NULL){
                                    				  $commissiontcs = 0;
                                    				   }else{
                                    				    $commissiontcs = $grpay * 1/100;
                                    				   }
            				                            
            				                            
                                        		}
                                        				
                                        				
			
		 $netgrpay = round($alldata,2) - round($comissionalldata,2) - round($comissiontax,2) - round($commissiontcs,2); 
             
             
            
            ?>
			<?php
			
			$debitdatapr = App\Models\Withdraw::where('user_id','=',$user->id)->where('status','=','pending')->orderBy('id','desc')->sum('total_debit_amount');
			
            $debitdatar = App\Models\DebitNote::where('vendor_id','=',$user->id)->where('status','=','0')->orderBy('id','desc')->sum('amount');
            
            
            $debitdata = round($debitdatar,2) - round($debitdatapr,2);
            
            ?>
			<?php
			
			$creditdatapr = App\Models\Withdraw::where('user_id','=',$user->id)->where('status','=','pending')->orderBy('id','desc')->sum('total_credit_amount');
			
            $creditdatar = App\Models\CreditNote::where('vendor_id','=',$user->id)->where('status','=','0')->orderBy('id','desc')->sum('amount');
            
            $creditdata = round($creditdatar,2) - round($creditdatapr,2);
            
            ?>
<?php
$availabledata = $alldata + $creditdata - $debitdata;
$allnetpaymnet = round($alldatapr,2)- round($all_adminfee,2) - round($all_cgst,2) - round($all_sgst,2);
?> 

 <?php $all_netpaymnets = 0; ?>
<?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $orderr): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
								<?php 
								$qty = $orderr->sum('qty')-$orderr->sum('product_item_qty');
								$price = $orderr->sum('price')-$orderr->sum('product_item_price');
								  $adminfee = $price*15/100;
								   $sgst = @$adminfee*9/100;
									        $cgst = @$adminfee*9/100;
											$igst = @$adminfee*18/100;
											$tcs =  @$adminfee*1/100;
								?>
								<?php $__currentLoopData = $orderr; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										  <?php 
											if($user->shipping_cost != 0){
												$price +=  round($user->shipping_cost , 2);
											  }
											if(App\Models\Order::where('order_number','=',$order->order->order_number)->first()->tax != 0){
												$price  += ($price / 100) * App\Models\Order::where('order_number','=',$order->order->order_number)->first()->tax;
											  }    
										  ?>
										   <?php
                                                       $user = App\Models\User::find($order->user_id);
													   $bankdetails= 'Name:- '.$user->account_holder_name	.'Account No:- '.$user->account_number.' IFSC Code'.$user->ifsc_code;
													   $state=$user->state;
													   $gst_number=$user->reg_number;
                                      ?>
									   <?php
											$productcost = round($price , 2);
											if($state == 'Tamil Nadu'){
            				                            $grosspayment = $productcost - $adminfee - $cgst - $sgst;
            				                            $tcs = $grosspayment*1/100;
            				                            if($gst_number == NULL){
                                    				     $all_netpaymnet = $grosspayment;
                                    				   }else{
                                    				      $all_netpaymnet =  $grosspayment - $tcs;
                                    				   }
                                        				} else{
                                        				  $all_netpaymnet = $productcost - $adminfee - $cgst - $sgst;
                                        				}
														
														
                      ?>	
					  
					  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					 <?php $all_netpaymnets = $all_netpaymnets + $all_netpaymnet; ?>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								 

<div class="content-area">
    <div class="mr-breadcrumb">
        <div class="row">
            <div class="col-lg-12">
                <h4 class="heading"><?php echo e($langg->lang443); ?></h4>
					<ul class="links">
					  <li><a href="<?php echo e(route('vendor-dashboard')); ?>"><?php echo e($langg->lang441); ?> </a></li>
					  <li><a href="javascript:;"><?php echo e($langg->lang442); ?></a></li>
					  <li><a href="<?php echo e(route('vendor-order-index')); ?>"><?php echo e($langg->lang443); ?></a></li>
					</ul>
			</div>
		</div>
	</div>
	
	<div class="row row-cards-one">

                                <div class="col-md-12 col-lg-6 col-xl-4">
                                    <div class="mycard bg4">
                                        <div class="left">
                                            <h5 class="title">Withdrawal Amount </h5>
                                            <span class="number"><?php echo e($netgrpay); ?></span>											
											
                                      
                                        </div>
                                        <div class="right d-flex align-self-center">
                                            <div class="icon">
                                                ₹
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12 col-lg-6 col-xl-4">
                                    <div class="mycard bg5">
                                        <div class="left">
                                            <h5 class="title">Debit Note</h5>
                                            <span class="number"><?php echo e($debitdata); ?></span>
                                            
                                            <a href="<?php echo e(route('vendor-debit-index')); ?>" class="link">View All</a>
                                           
                                        </div>
                                        <div class="right d-flex align-self-center">
                                            <div class="icon">
                                                ₹
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12 col-lg-6 col-xl-4">
                                    <div class="mycard bg3">
                                        <div class="left">
                                            <h5 class="title">Credit Note</h5>
                                            <span class="number"><?php echo e($creditdata); ?></span>
                                         <a href="<?php echo e(route('vendor-credit-index')); ?>" class="link">View All</a>
                                        </div>
                                        <div class="right d-flex align-self-center">
                                            <div class="icon">
                                                ₹
                                            </div>
                                        </div>
                                    </div>
                                </div>
								
								<div class="col-md-12 col-lg-6 col-xl-4">
                                    <div class="mycard bg4">
                                        <div class="left">
                                            <h5 class="title">Net Amount </h5>                                            
											<span class="number"><?php echo e($all_netpaymnets); ?></span>											
                                      
                                        </div>
                                        <div class="right d-flex align-self-center">
                                            <div class="icon">
                                                ₹
                                            </div>
                                        </div>
                                    </div>
                                </div>



                              

                            </div>
	<div class="product-area">
		<div class="row">
			<div class="col-lg-12">		
			
			
		
				<div class="mr-table allproduct">
				
                    <?php echo $__env->make('includes.form-success', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?> 
                    <div class="table-responsiv">
                        <div class="gocover" style="background: url(<?php echo e(asset('assets/images/'.$gs->admin_loader)); ?>) no-repeat scroll center center rgba(45, 45, 45, 0.5);"></div>
    						<form id="geniusform" class="form-horizontal" action="<?php echo e(route('vendor-withdraw-order')); ?>" method="POST" enctype="multipart/form-data">      
    						<?php echo e(csrf_field()); ?>

							<table id="geniustable" class="table table-hover dt-responsive" cellspacing="0" width="100%">
								<thead>
									<tr>
										<th><input type="checkbox" id="checkAl"> Order ID</th>
                    <th>Order Number</th>
										<th><?php echo e(_('Quantity')); ?></th>
										<th><?php echo e($langg->lang536); ?></th>
										<th><?php echo e($langg->lang537); ?></th>
										<th><?php echo e(_('Admin fees')); ?></th>
										<th><?php echo e(_('SGST')); ?></th>
										<th><?php echo e(_('CGST')); ?></th>
										<th><?php echo e(_('IGST')); ?></th>
										<th><?php echo e(_('TCS')); ?></th>
										<th><?php echo e(_('Net Payment')); ?></th>
										<th><?php echo e($langg->lang538); ?></th>
										
									</tr>
								</thead>
								<tbody>
								<?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $orderr): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
								<?php 
								$qty = $orderr->sum('qty')-$orderr->sum('product_item_qty');
								$price = $orderr->sum('price')-$orderr->sum('product_item_price');
								  $adminfee = $price*15/100;
								  
								   $sgst = @$adminfee*9/100;
									        $cgst = @$adminfee*9/100;
											$igst = @$adminfee*18/100;
											$tcs =  @$adminfee*1/100;
								  
								  
								  
								?>
								<?php $__currentLoopData = $orderr; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

										  <?php 

											if($user->shipping_cost != 0){
												$price +=  round($user->shipping_cost , 2);
											  }
											if(App\Models\Order::where('order_number','=',$order->order->order_number)->first()->tax != 0){
												$price  += ($price / 100) * App\Models\Order::where('order_number','=',$order->order->order_number)->first()->tax;
											  }    

										  ?>
										  
										   <?php
                                                       $user = App\Models\User::find($order->user_id);
													   $bankdetails= 'Name:- '.$user->account_holder_name	.'Account No:- '.$user->account_number.' IFSC Code'.$user->ifsc_code;
													   $state=$user->state;
													   $gst_number=$user->reg_number;
													   
													   
													   
													   
													   
                                      ?>
								
									  
									
										<tr>
											<td>
                        <input type="checkbox" id="checkItem" class="orderwithprice" name="check[]" value="<?php echo e($order->order->id); ?>">
                        <input type="checkbox" style="position : absolute; visibility:hidden; opacity:0;" name="withdrawal_amount[]" value="<?php echo e(round($price, 2)); ?>" >
                        <?php echo e($order->order_id); ?>

                      </td>    
                      
                      
                      <?php
                     
											$productcost = round($price , 2);
											
											if($state == 'Tamil Nadu'){
            				              
            				                            $grosspayment = $productcost - $adminfee - $cgst - $sgst;
            				                            
            				                            $tcs = $grosspayment*1/100;
            				                            
            				                            
            				                            if($gst_number == NULL){
                                    				     $netpaymnet = $grosspayment;
                                    				   }else{
                                    				      $netpaymnet =  $grosspayment - $tcs;
                                    				   }
            				                            
            				                            
                                        				} else{
                                        				   
                                        				  $netpaymnet = $productcost - $adminfee - $cgst - $sgst;
                                        				   
                                        				}
            				
                      
                      ?>
											<td> <a href="<?php echo e(route('vendor-order-vshow',$order->order_number)); ?>"><?php echo e($order->order->order_number); ?></a></td>
											<td><?php echo e($qty); ?></td>
											<td><?php echo e($order->order->inr_currency_sign); ?><?php echo e(round($price , 2)); ?></td>
											<td><?php if($user->account_number): ?> <?php echo e($bankdetails); ?> <?php else: ?> <?php echo e(_('-')); ?> <?php endif; ?></td>
											<td><?php echo e($order->order->inr_currency_sign); ?><?php echo e($adminfee); ?></td>
											<td><?php if($order->sgst != ''): ?><?php echo e($order->order->inr_currency_sign); ?><?php echo e($sgst); ?><?php endif; ?></td>
											<td><?php if($order->cgst != ''): ?><?php echo e($order->order->inr_currency_sign); ?><?php echo e($cgst); ?><?php endif; ?></td>
											<td><?php if($order->igst != ''): ?><?php echo e($order->order->inr_currency_sign); ?><?php echo e($igst); ?><?php endif; ?></td>
											<td><?php if($order->tcs != ''): ?><?php echo e($order->inr_currency_sign); ?><?php echo e($tcs); ?><?php endif; ?></td>
											<td><?php echo e($order->order->inr_currency_sign); ?><?php echo e($netpaymnet); ?></td>
											<td>
												<div class="action-list">
													<a href="<?php echo e(route('vendor-order-vshow',$order->order_number)); ?>" class="btn btn-primary product-btn"><i class="fa fa-eye"></i> <?php echo e($langg->lang539); ?></a>
												  
												</div>
											</td>
										 </tr>
								<?php break; ?>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								</tbody>
							</table>
							<?php
                                                       $setting = App\Models\Generalsetting::find(1);
							?>	
                            <?php if($setting->withdraw_permission==1): ?>
                            
      <?php if($alldata > 0): ?>                      
                            
<?php if($availabledata < 0): ?>
	<p align="center"><button type="button" class="btn btn-success" data-toggle="modal" data-target="#insufbal">Submit</button></p>
<?php else: ?>								
							<p align="center"><button type="submit" class="btn btn-success" data-toggle="modal" data-target="#confirm-withdrawl" name="save">Submit</button></p>
						<?php endif; ?>
						    <?php endif; ?>
						    
			<?php endif; ?>			    
							
						</form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




<div class="modal fade" id="confirm-delete2" tabindex="-1" role="dialog" aria-labelledby="modal1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
    <div class="submit-loader">
        <img  src="<?php echo e(asset('assets/images/'.$gs->admin_loader)); ?>" alt="">
    </div>
    <div class="modal-header d-block text-center">
        <h4 class="modal-title d-inline-block"><?php echo e($langg->lang544); ?></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

      <!-- Modal body -->
      <div class="modal-body">
        <p class="text-center"><?php echo e($langg->lang545); ?></p>
        <p class="text-center"><?php echo e($langg->lang546); ?></p>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer justify-content-center">
            <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo e($langg->lang547); ?></button>
            <a class="btn btn-success btn-ok order-btn"><?php echo e($langg->lang548); ?></a>
      </div>

    </div>
  </div>
</div>

<div class="modal fade" id="confirm-withdrawl" tabindex="-1" role="dialog" aria-labelledby="modal1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
    <div class="submit-loader">
        <img  src="<?php echo e(asset('assets/images/'.$gs->admin_loader)); ?>" alt="">
    </div>
    <div class="modal-header d-block text-center">
        <h4 class="modal-title d-inline-block">Withdraw Requested</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

      <!-- Modal body -->
      <div class="modal-body">
        <p class="text-center">Withdraw Requested Successfully.</p>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer justify-content-center">
            <a class="btn btn-success btn-ok order-btn referesh-btn">OK</a>
      </div>

    </div>
  </div>
</div>


<div class="modal fade" id="insufbal" tabindex="-1" role="dialog" aria-labelledby="modal1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">    
    <div class="modal-header d-block text-center">
        <h4 class="modal-title d-inline-block">Insufficient Balance</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

      <!-- Modal body -->
      <div class="modal-body">
        <p class="text-center">Insufficient balance in your account.</p>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer justify-content-center">
            <a class="btn btn-success">OK</a>
      </div>

    </div>
  </div>
</div>




<?php $__env->stopSection(); ?>    

<?php $__env->startSection('scripts'); ?>



    <script type="text/javascript">

$(document).ready(function(){
        $(".referesh-btn").click(function(){
            location.reload(true);
        });
    });
$('.vendor-btn').on('change',function(){
          $('#confirm-delete2').modal('show');
          $('#confirm-delete2').find('.btn-ok').attr('href', $(this).val());

});

        var table = $('#geniustable').DataTable({
               ordering: false
           });
              $(document).on('submit','#trackform',function(e){
  e.preventDefault();
  if(admin_loader == 1)
  {
  $('.gocover').show();
  }

  $('button.addProductSubmit-btn').prop('disabled',true);
      $.ajax({
       method:"POST",
       url:$(this).prop('action'),
       data:new FormData(this),
       contentType: false,
       cache: false,
       processData: false,
       success:function(data)
       {
          if ((data.errors)) {
          $('#trackform .alert-success').hide();
          $('#trackform .alert-danger').show();
          $('#trackform .alert-danger ul').html('');
            for(var error in data.errors)
            {
              $('#trackform .alert-danger ul').append('<li>'+ data.errors[error] +'</li>')
            }
            $('#trackform input , #trackform select , #trackform textarea').eq(1).focus();
          }
          else
          {
            $('#trackform .alert-danger').hide();
            $('#trackform .alert-success').show();
            $('#trackform .alert-success p').html(data);
            $('#trackform input , #trackform select , #trackform textarea').eq(1).focus();
            $('#track-load').load($('#track-load').data('href'));

          }
  if(admin_loader == 1)
  {
          $('.gocover').hide();
  }

          $('button.addProductSubmit-btn').prop('disabled',false);
       }

      });

});                                                  
    </script>
	<script>
		$("#checkAl").click(function () {
			$('input:checkbox').not(this).prop('checked', this.checked);
		});
    $(".orderwithprice").click(function () {
      $(this).siblings('input').prop('checked', this.checked);
      
    });
    
    


	</script>

    
<?php $__env->stopSection(); ?>   
<?php echo $__env->make('layouts.vendor', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>