<?php $__env->startSection('content'); ?>
<div class="content-area">
    <div class="mr-breadcrumb">
        <div class="row">
            <div class="col-lg-12">
                <h4 class="heading"><?php echo e(__('Withdraw Details')); ?> <a class="add-btn" href="javascript:history.back();"><i class="fas fa-arrow-left"></i> <?php echo e(__('Back')); ?></a></h4>
                <ul class="links">
                    <li><a href="<?php echo e(route('admin.dashboard')); ?>"><?php echo e(__('Dashboard')); ?> </a></li>
                    <li><a href="javascript:;"><?php echo e(__('Withdraw')); ?></a></li>
                    <li><a href="javascript:;"><?php echo e(__('Withdraw Details')); ?></a></li>
                </ul>
            </div>
        </div>
    </div>

                        <div class="content-area no-padding">
                            <div class="add-product-content1">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="product-description">
                                            <div class="body-area">

                                    <div class="table-responsive show-table">
                                        <table class="table">
                                          
                                              <tr>
                                                <th><?php echo e(__("Withdraw ID#")); ?></th>
                                                <td><?php echo e($withdraw->id); ?></td>
                                            </tr>
                                            <tr>
                                                <th><?php echo e(__("Vendor Name")); ?></th>
                                                <td>
                                                    <a href="<?php echo e(route('admin-user-show',$withdraw->user->id)); ?>" target="_blank"><?php echo e($withdraw->user->name); ?></a>
                                                </td>
                                            </tr>
                                                <tr>
                                                
 <th><?php echo e(__("Orders")); ?></th>
                                                <td>
                                                    <a href="<?php echo e(route('admin-user-show',$withdraw->user->id)); ?>" target="_blank"><?php echo e($withdraw->group_order_id); ?></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th><?php echo e(__("Amount")); ?></th>
                                                <td><?php echo e($sign->sign); ?><?php echo e(round($withdraw->withdrawal_amount * $sign->original_val , 2)); ?></td>
                                            </tr>
                                            <tr>
                                                <th><?php echo e(__("Admin Fee")); ?></th>
                                                <td><?php echo e($sign->sign); ?><?php echo e(round($withdraw->fee * $sign->original_val , 2)); ?></td>
                                            </tr>
											<?php if($withdraw->sgst): ?>
											<tr>
                                                <th><?php echo e(__("SGST")); ?></th>
                                                <td><?php echo e($withdraw->sgst); ?></td>
                                            </tr>
											<?php endif; ?>
											<?php if($withdraw->cgst): ?>
											<tr>
                                                <th><?php echo e(__("CGST")); ?></th>
                                                <td><?php echo e($withdraw->cgst); ?></td>
                                            </tr>
											<?php endif; ?>
											<?php if($withdraw->igst): ?>
											<tr>
                                                <th><?php echo e(__("IGST")); ?></th>
                                                <td><?php echo e($withdraw->igst); ?></td>
                                            </tr>
											<?php endif; ?>
											<?php if($withdraw->tcs): ?>
											<tr>
                                                <th><?php echo e(__("TCS")); ?></th>
                                                <td><?php echo e($withdraw->tcs); ?></td>
                                            </tr>
											<?php endif; ?>
											
											
											 <?php if($withdraw->total_debit_amount): ?>
											<tr>
                                                <th><?php echo e(__("Total Debit Amount")); ?></th>
                                                <td><?php echo e($withdraw->total_debit_amount); ?></td>
                                            </tr>
											<?php endif; ?>
											 <?php if($withdraw->total_credit_amount	): ?>
											<tr>
                                                <th><?php echo e(__("Total Credit Amount")); ?></th>
                                                <td><?php echo e($withdraw->total_credit_amount); ?></td>
                                            </tr>
											<?php endif; ?>
											
											<?php
			$alldata = $withdraw->amount;								
										
            
            $debitdata = $withdraw->total_debit_amount;
        
            
            $creditdata = $withdraw->total_credit_amount;
            
            ?>
<?php
$availabledata = $alldata + $creditdata - $debitdata;
?> 
											
											
											
											<tr>
                                                <th><?php echo e(__("Net Payable")); ?></th>
                                                <td><?php echo e($availabledata); ?></td>
                                            </tr>
											
											
											
											 <?php if($withdraw->settle_amount	): ?>
											<tr>
                                                <th><?php echo e(__("Settle Amount")); ?></th>
                                                <td><?php echo e($withdraw->settle_amount); ?></td>
                                            </tr>
											<?php endif; ?>
											
                                            <tr>
                                                <th><?php echo e(__("Withdraw Process Date")); ?></th>
                                                <td><?php echo e(date('d-M-Y',strtotime($withdraw->created_at))); ?></td>
                                            </tr>
                                            <tr>
                                                <th><?php echo e(__("Withdraw Status")); ?></th>
                                                <td><?php echo e(ucfirst($withdraw->status)); ?></td>
                                            </tr>
											<tr>
                                                <th><?php echo e(__("Settle Status")); ?></th>
                                                <td><?php echo e(ucfirst($withdraw->settle)); ?></td>
                                            </tr>
                                            <tr>
                                                <th><?php echo e(__("User Email")); ?></th>
                                                <td><?php echo e($withdraw->user->email); ?></td>
                                            </tr>
                                            <tr>
                                                <th><?php echo e(__("User Phone")); ?></th>
                                                <td><?php echo e($withdraw->user->phone); ?></td>
                                            </tr>
											<tr>
                                                <th><?php echo e(__("Note")); ?></th>
                                                <td><?php echo e($withdraw->note); ?></td>
                                            </tr>
											<?php $images=array();
										                      $temp=explode(',',$withdraw->screen_shot);
															  
															  foreach($temp as $image){
                                                              $images[]=trim( str_replace( array('[',']') ,"" ,$image ) );
                                                                }
                                                                  $j=1;
                                                               foreach($images as $image){ 
															   if($image) {?>
															   <tr>
                                                <th>Screen Shot <?php echo e($j); ?></th>
                                                <td><a href="<?php echo e(asset('assets/images/screenshot/'.$image)); ?>" download>Screen Shot <?php echo e($j); ?></a></td>
                                            </tr>
															   
															   <?php $j++; } }
                                                           ?>
                                            <tr>
                                                <th><?php echo e(__("Withdraw Method")); ?></th>
                                                <td><?php echo e($withdraw->method); ?></td>
                                            </tr>
											 <?php if($withdraw->comment): ?>
											<tr>
                                                <th><?php echo e(__("Reject Reason")); ?></th>
                                                <td><?php echo e($withdraw->comment); ?></td>
                                            </tr>
											<?php endif; ?>
                                            <?php if($withdraw->method != "Bank"): ?>
                                            <tr>
                                                <th><?php echo e($withdraw->method); ?> <?php echo e(__("Email")); ?>:</th>
                                                <td><?php echo e($withdraw->acc_email); ?></td>
                                            </tr>
                                            <?php else: ?> 
                                            <tr>
                                                <th><?php echo e($withdraw->method); ?> <?php echo e(__("Account")); ?>:</th>
                                                <td><?php echo e($withdraw->iban); ?></td>
                                            </tr>
                                            <tr>
                                                <th><?php echo e(__("Account Name")); ?>:</th>
                                                <td><?php echo e($withdraw->acc_name); ?></td>
                                            </tr>
                                            <tr>
                                                <th><?php echo e(__("Country")); ?></th>
                                                <td><?php echo e(ucfirst(strtolower($withdraw->country))); ?></td>
                                            </tr>
                                            <tr>
                                                <th><?php echo e(__("Address")); ?></th>
                                                <td><?php echo e($withdraw->address); ?></td>
                                            </tr>
                                            <tr>
                                                <th><?php echo e($withdraw->method); ?> <?php echo e(__("Swift Code")); ?>:</th>
                                                <td><?php echo e($withdraw->swift); ?></td>
                                            </tr>
											
                                            <?php endif; ?>
                                        </table>
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