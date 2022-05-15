 
<?php $__env->startSection('content'); ?>
	<div class="content-area">
		<div class="mr-breadcrumb">
			<div class="row">
				<div class="col-lg-12">
					<h4 class="heading"><?php echo e($langg->lang472); ?></h4>
					<ul class="links">
						<li><a href="<?php echo e(route('vendor-dashboard')); ?>"><?php echo e($langg->lang441); ?> </a></li>
						<li><a href="<?php echo e(route('vendor-wt-index')); ?>"><?php echo e($langg->lang472); ?></a></li>
					</ul>
				</div>
			</div>
		</div>
		<div class="product-area">
			<div class="row">
				<div class="col-lg-12">
					<div class="mr-table allproduct">
						<?php echo $__env->make('includes.admin.form-success', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?> 
						<div class="table-responsiv">
							<table id="geniustable" class="table table-hover dt-responsive" cellspacing="0" width="100%">
								<thead>
									<tr>
									    	                               
									    	                                <th>Withdraw ID</th>
	                                <th> Request Date</th>
	                                <th>Orders</th>
	                                <th><?php echo e($langg->lang476); ?></th>
	                                <th><?php echo e($langg->lang477); ?></th>
								<th><?php echo e(_('Admin fees (₹)')); ?></th>
									<th><?php echo e(_('SGST (₹)')); ?></th>
									<th><?php echo e(_('CGST (₹)')); ?></th>
									<th><?php echo e(_('IGST (₹)')); ?></th>
									<th><?php echo e(_('TCS (₹)')); ?></th>
									<th><?php echo e(_('Net Payment (₹)')); ?></th>
									<th><?php echo e(_('Settle Amount (₹)')); ?></th>
									<th><?php echo e(_('Debit Note(₹)')); ?></th>
									<th><?php echo e(_('Credit Note (₹)')); ?></th>
	                                <th><?php echo e($langg->lang478); ?></th>
									</tr>
								</thead>

								<tbody>
		                            <?php $__currentLoopData = $withdraws; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $withdraw): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									 <?php
									                   $order = App\Models\Order::find($withdraw->group_order_id);                                                       
													   $bankdetails= 'Name:- '.$user->account_holder_name	.'Account No:- '.$user->account_number.' IFSC Code'.$user->ifsc_code;
													   $state=$user->state;
													   $gst_number=$user->reg_number;
													   
											   $withdrawid = $withdraw->id;
													   
										$debitamt = App\Models\DebitNote::where('vendor_id','=',$user->id)->where('withdraw_id','=',$withdrawid)->orderBy('id','desc')->sum('amount');
											
											
											$creditamt = App\Models\CreditNote::where('vendor_id','=',$user->id)->where('withdraw_id','=',$withdrawid)->orderBy('id','desc')->sum('amount');		   
													   
                                      ?>

									  
		                                <tr>
		                                    <td>#<?php echo e($withdraw->id); ?></td>
		                                    <td><?php echo e(date('d-M-Y',strtotime($withdraw->created_at))); ?></td>
		                                    <td><?php echo e($withdraw->group_order_id); ?></td>
		                                    <?php if($withdraw->method != "Bank"): ?>
		                                        <td><?php echo e($withdraw->acc_email); ?></td>
		                                    <?php else: ?>
		                                        <td><?php echo e($withdraw->iban); ?></td>
		                                    <?php endif; ?>
		                                    <td><?php echo e($sign->sign); ?><?php echo e($withdraw->withdrawal_amount); ?></td>
											<td><?php echo e(round($withdraw->fee, 2)); ?></td>
											<td><?php echo e($withdraw->sgst); ?></td>
											<td><?php echo e($withdraw->cgst); ?></td>
											<td><?php echo e($withdraw->igst); ?></td>
											<td><?php echo e($withdraw->tcs); ?></td>
											<td><?php echo e($sign->sign); ?><?php echo e($withdraw->amount); ?></td>
											<?php if($withdraw->settle_amount): ?>
											<td><?php echo e($sign->sign); ?> <?php echo e($withdraw->settle_amount); ?></td>
										    <?php else: ?>
											<td>-</td>
										    <?php endif; ?>
											<?php if($withdraw->debit_note_id): ?>
											<td><?php echo e($debitamt); ?> (#<?php echo e($withdraw->debit_note_id); ?>)</td>
										    <?php else: ?>
											<td>-</td>
										   <?php endif; ?>
											<?php if($withdraw->credit_note_id): ?>
											<td><?php echo e($creditamt); ?> (#<?php echo e($withdraw->credit_note_id); ?>)</td>
										    <?php else: ?>
											<td>-</td>
										   <?php endif; ?>
		                                    <td><?php echo e(ucfirst($withdraw->status)); ?></td>
		                                </tr>
		                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
								</tbody>									
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php $__env->stopSection(); ?>    
<?php $__env->startSection('scripts'); ?>




    <script type="text/javascript">

		var table = $('#geniustable').DataTable({
			ordering:false
		});

  									
    </script>


    
<?php $__env->stopSection(); ?>   
<?php echo $__env->make('layouts.vendor', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>