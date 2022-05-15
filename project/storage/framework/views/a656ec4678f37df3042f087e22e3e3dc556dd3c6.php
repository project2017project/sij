<form  method="POST" action="<?php echo e(route('admin-exch-update',$data->id)); ?>" enctype="multipart/form-data" id="exchangedform">
<?php echo e(csrf_field()); ?>

<?php echo $__env->make('includes.admin.form-both', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<input type = "hidden" name="echangeid" value="<?php echo e($data->id); ?>">
<select name="prreason" onchange="changereason(this.value);" required> 
                                         <option value="">Please Select a Reason</option>  
                                         <option value="wrong">Wrong</option>
                                         <option value="bad">Bad</option>
                                         <option value="others">others</option>
                                        </select>
										<input type="text" class="input-field" id="reason" placeholder="<?php echo e(__('Reason')); ?>" name="reason" style="display:none;"></div>
<button class="exchangedform-btn" type="submit"><?php echo e(__('OK')); ?></button>
</form>
			
<script type="text/javascript">
function changereason(val){
 var element=document.getElementById('reason');
 if(val==''||val=='others')
   element.style.display='block';
 else  
   element.style.display='none';
}

</script>			
												