 

<?php $__env->startSection('content'); ?>  
					<input type="hidden" id="headerdata" value="<?php echo e(__('FAQ')); ?>">
					<div class="content-area">
						<div class="mr-breadcrumb">
							<div class="row">
								<div class="col-lg-12">
										<h4 class="heading"><?php echo e(__('Faq')); ?></h4>
										<ul class="links">
											<li>
												<a href="<?php echo e(route('admin.dashboard')); ?>"><?php echo e(__('Dashboard')); ?> </a>
											</li>
											<li>
												<a href="javascript:;"><?php echo e(__('Menu Page Settings')); ?> </a>
											</li>
											<li>
												<a href="<?php echo e(route('admin-faq-index')); ?>"><?php echo e(__('Faq')); ?></a>
											</li>
										</ul>
								</div>
							</div>
						</div>
						<div class="product-area">
							<div class="row">
								<div class="col-lg-12">
								<div class="heading-area">
									<h4 class="title">
										<?php echo e(__('Faq Page')); ?> :
									</h4>
	                                <div class="action-list">
	                                    <select class="process select droplinks <?php echo e($gs->is_faq == 1 ? 'drop-success' : 'drop-danger'); ?>">
	                                      <option data-val="1" value="<?php echo e(route('admin-gs-isfaq',1)); ?>" <?php echo e($gs->is_faq == 1 ? 'selected' : ''); ?>><?php echo e(__('Activated')); ?></option>
	                                      <option data-val="0" value="<?php echo e(route('admin-gs-isfaq',0)); ?>" <?php echo e($gs->is_faq == 0 ? 'selected' : ''); ?>><?php echo e(__('Deactivated')); ?></option>
	                                    </select>
	                                  </div>
								</div>
									<div class="mr-table allproduct">
										<?php echo $__env->make('includes.admin.form-success', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?> 
										<div class="table-responsiv">
												<table id="geniustable" class="table table-hover dt-responsive" cellspacing="0" width="100%">
													<thead>
														<tr>
									                        <th width="30%"><?php echo e(__('Faq Title')); ?></th>
									                        <th width="50%"><?php echo e(__('Faq Details')); ?></th>
									                        <th><?php echo e(__('Options')); ?></th>
														</tr>
													</thead>
												</table>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>



				<div class="modal fade" id="modal1" tabindex="-1" role="dialog" aria-labelledby="modal1" aria-hidden="true">
										
					<div class="modal-dialog modal-dialog-centered" role="document">
						<div class="modal-content">
												<div class="submit-loader">
														<img  src="<?php echo e(asset('assets/images/'.$gs->admin_loader)); ?>" alt="">
												</div>
											<div class="modal-header">
											<h5 class="modal-title"></h5>
											<button type="button" class="close" data-dismiss="modal" aria-label="Close">
												<span aria-hidden="true">&times;</span>
											</button>
											</div>
											<div class="modal-body">

											</div>
											<div class="modal-footer">
											<button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo e(__('Close')); ?></button>
											</div>
						</div>
					</div>

				</div>






<div class="modal fade" id="confirm-delete">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header text-center">
        <h4 class="modal-title w-100"><?php echo e(__('Confirm Delete')); ?></h4>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
            <p class="text-center"><?php echo e(__('You are about to delete this Faq.')); ?></p>
            <p class="text-center"><?php echo e(__('Do you want to proceed?')); ?></p>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer justify-content-center">
            <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo e(__('Cancel')); ?></button>
            <a class="btn btn-danger btn-ok"><?php echo e(__('Delete')); ?></a>
      </div>

    </div>
  </div>
</div>



<?php $__env->stopSection(); ?>    



<?php $__env->startSection('scripts'); ?>




    <script type="text/javascript">

		var table = $('#geniustable').DataTable({
			   ordering: false,
               processing: true,
               serverSide: true,
               ajax: '<?php echo e(route('admin-faq-datatables')); ?>',
               columns: [
                        { data: 'title', name: 'title' },
                        { data: 'details', name: 'details' },
            			{ data: 'action', searchable: false, orderable: false }

                     ],
               language : {
                	processing: '<img src="<?php echo e(asset('assets/images/'.$gs->admin_loader)); ?>">'
                }
            });

      	$(function() {
        $(".btn-area").append('<div class="col-sm-4 text-right">'+
        	'<a class="add-btn" href="<?php echo e(route('admin-faq-create')); ?>">'+
          '<i class="fas fa-plus"></i> <?php echo e(__('Add New Faq')); ?>'+
          '</a>'+
          '</div>');
      });												
									
    </script>


    
<?php $__env->stopSection(); ?>   
<?php echo $__env->make('layouts.admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>