 
<?php $__env->startSection('styles'); ?>
<style type="text/css">.input-field { padding: 15px 20px; }</style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>  
<input type="hidden" id="headerdata" value="<?php echo e(__('ORDER')); ?>">
<div class="content-area">
	<div class="mr-breadcrumb">
		<div class="row">
			<div class="col-lg-12">
				<h4 class="heading"><?php echo e(__('Order Track')); ?></h4>
				<ul class="links">
					<li><a href="<?php echo e(route('admin.dashboard')); ?>"><?php echo e(__('Dashboard')); ?> </a></li>
					<li><a href="javascript:;"><?php echo e(__('Orders')); ?></a></li>
					<li><a href="<?php echo e(route('admin-order-ordertracks')); ?>"><?php echo e(__('All Order Track')); ?></a></li>
				</ul>
			</div>
		</div>
	</div>
	<div class="product-area">
		<div class="row">
			<div class="col-lg-12">
				<div class="mr-table allproduct">					 
					<div class="table-responsiv">
						<div class="row" style="padding-top : 20px; background : #eeeeee;">	
						<div class ="col-sm-10">
                                       
                                   <div class="row">
                                 <form id="ordertrackdata" style="min-width : 100%;" class="form-horizontal" action="<?php echo e(route('order-ftrack-data',['status'=>'none'])); ?>" method="POST" enctype="multipart/form-data">
										<?php echo e(csrf_field()); ?>          
							<div class="form-group col-md-3">                               
                                <select name="svendor" id="svendor">
                                    <option value=''>--Select Any Vendor-- </option>
                                    <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $userid): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($userid->id); ?>"><?php echo e($userid->shop_name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>                                        
                                </select>                                
                            </div>
                            
                            
                            <div class="text-left col-md-3" >
                                <button type="text" id="ordertrackform" class="btn btn-info">Submit</button></div>
								<form>
                            </div>
                            </div>                            
                         </div>
                        <br>
						
						
	</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php $__env->stopSection(); ?> 
<?php $__env->startSection('scripts'); ?>


<script type="text/javascript">
$(document).on('submit','#ordertrackdata',function(e){
	e.preventDefault();
	var vendorid=$("#svendor :selected").val();
	$.get($(this).prop('action')','vendorid='+vendorid+',function(){
        document.location.href = $(this).prop('action')?vendorid='+vendorid+';        
    });

});

</script>

<?php $__env->stopSection(); ?>  
<?php echo $__env->make('layouts.admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>