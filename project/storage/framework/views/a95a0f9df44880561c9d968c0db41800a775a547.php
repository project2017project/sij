<?php $__env->startSection('styles'); ?>

<link href="<?php echo e(asset('assets/vendor/css/product.css')); ?>" rel="stylesheet"/>
<link href="<?php echo e(asset('assets/admin/css/jquery.Jcrop.css')); ?>" rel="stylesheet"/>
<link href="<?php echo e(asset('assets/admin/css/Jcrop-style.css')); ?>" rel="stylesheet"/>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<style>
.add-fild-btn{
  pointer-events: none;
  cursor: default;
}
.set-gallery{
	pointer-events: none;
  cursor: default;
}
.ui-widget-content{
    pointer-events:none; 
    cursor: default;        
}
#size-btn{
	pointer-events:none; 
    cursor: default; 
}
#color-btn{
	pointer-events:none; 
    cursor: default; 
}
</style>
	<div class="content-area">
		<div class="mr-breadcrumb">
			<div class="row">
				<div class="col-lg-12">
						<h4 class="heading"> <?php echo e($langg->lang704); ?> <a class="add-btn" href="<?php echo e(route('vendor-prod-index')); ?>"><i class="fas fa-arrow-left"></i> <?php echo e($langg->lang550); ?></a></h4>
						<ul class="links">
							<li>
							<a href="<?php echo e(route('vendor-dashboard')); ?>"><?php echo e($langg->lang441); ?></a>
							</li>
							<li>
							<a href="javascript:;"><?php echo e($langg->lang444); ?> </a>
							</li>
							<li>
								<a href="javascript:;"><?php echo e($langg->lang629); ?></a>
							</li>
							<li>
								<a href="<?php echo e(route('vendor-prod-edit',$data->id)); ?>"><?php echo e($langg->lang705); ?></a>
							</li>
						</ul>
				</div>
			</div>
		</div>

		<form id="geniusform" action="<?php echo e(route('vendor-prod-update',$data->id)); ?>" method="POST" enctype="multipart/form-data">
			<?php echo e(csrf_field()); ?>


		<div class="row">
			<div class="col-lg-8">
				<div class="add-product-content">
					<div class="row">
						<div class="col-lg-12">
							<div class="product-description">
								<div class="body-area">

							  <div class="gocover" style="background: url(<?php echo e(asset('assets/images/'.$gs->admin_loader)); ?>) no-repeat scroll center center rgba(45, 45, 45, 0.5);"></div>			

								<?php echo $__env->make('includes.vendor.form-both', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

									<div class="row">
										<div class="col-lg-12">
											<div class="left-area">
													<h4 class="heading"><?php echo e($langg->lang632); ?>* </h4>
													<p class="sub-heading"><?php echo e($langg->lang517); ?></p>
											</div>
										</div>
										<div class="col-lg-12">
											<input type="text" class="input-field" placeholder="<?php echo e($langg->lang632); ?>" name="name" required="" value="<?php echo e($data->name); ?>" readonly>
										</div>
									</div>


									<!--<div class="row">
										<div class="col-lg-12">
											<div class="left-area">
													<h4 class="heading"><?php echo e($langg->lang793); ?>* </h4>
											</div>
										</div>
										<div class="col-lg-12">
											<input type="text" class="input-field" placeholder="<?php echo e($langg->lang794); ?>" name="sku" required="" value="<?php echo e($data->sku); ?>" readonly>

											<div class="checkbox-wrapper">
											  <input type="checkbox" name="product_condition_check" class="checkclick" id="conditionCheck" value="1" <?php echo e($data->product_condition != 0 ? "checked":""); ?>>
											  <label for="conditionCheck"><?php echo e($langg->lang633); ?></label>
											</div>

										</div>
									</div>-->

									<div class="<?php echo e($data->product_condition == 0 ? "showbox":""); ?>">

									<div class="row">
										<div class="col-lg-12">
											<div class="left-area">
													<h4 class="heading"><?php echo e($langg->lang634); ?>*</h4>
											</div>
										</div>
										<div class="col-lg-12">
												<select name="product_condition" disabled="disabled">
													  <option value="2" <?php echo e($data->product_condition == 2
										? "selected":""); ?>><?php echo e($langg->lang635); ?></option>
													  <option value="1" <?php echo e($data->product_condition == 1
										? "selected":""); ?>><?php echo e($langg->lang636); ?></option>
												</select>
										</div>

									</div>


									</div>

									<div class="row">
										<div class="col-lg-12">
											<div class="left-area">
													<h4 class="heading"><?php echo e($langg->lang637); ?>*</h4>
											</div>
										</div>
										<div class="col-lg-12">
												<select id="cat" name="category_id" required="" disabled="disabled">
														<option><?php echo e($langg->lang691); ?></option>

								  <?php $__currentLoopData = $cats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									  <option data-href="<?php echo e(route('vendor-subcat-load',$cat->id)); ?>" value="<?php echo e($cat->id); ?>" <?php echo e($cat->id == $data->category_id ? "selected":""); ?> ><?php echo e($cat->name); ?></option>
								  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
												 </select>
										</div>
									</div>

									<div class="row">
										<div class="col-lg-12">
											<div class="left-area">
													<h4 class="heading"><?php echo e($langg->lang638); ?>*</h4>
											</div>
										</div>
										<div class="col-lg-12">
												<select id="subcat" name="subcategory_id" disabled="disabled">
													<option value=""><?php echo e($langg->lang639); ?></option>
										  <?php if($data->subcategory_id == null): ?>
										  <?php $__currentLoopData = $data->category->subs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sub): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										  <option data-href="<?php echo e(route('vendor-childcat-load',$sub->id)); ?>" value="<?php echo e($sub->id); ?>" ><?php echo e($sub->name); ?></option>
										  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
										  <?php else: ?>
										  <?php $__currentLoopData = $data->category->subs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sub): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										  <option data-href="<?php echo e(route('vendor-childcat-load',$sub->id)); ?>" value="<?php echo e($sub->id); ?>" <?php echo e($sub->id == $data->subcategory_id ? "selected":""); ?> ><?php echo e($sub->name); ?></option>
										  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
										  <?php endif; ?>


												</select>
										</div>
									</div>

									<div class="row">
										<div class="col-lg-12">
											<div class="left-area">
													<h4 class="heading"><?php echo e($langg->lang640); ?>*</h4>
											</div>
										</div>
										<div class="col-lg-12">
												<select id="childcat" name="childcategory_id" disabled="disabled" <?php echo e($data->subcategory_id == null ? "disabled":""); ?>>
													  <option value=""><?php echo e($langg->lang641); ?></option>
										  <?php if($data->subcategory_id != null): ?>
										  <?php if($data->childcategory_id == null): ?>
										  <?php $__currentLoopData = $data->subcategory->childs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $child): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										  <option value="<?php echo e($child->id); ?>" ><?php echo e($child->name); ?></option>
										  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
										  <?php else: ?>
										  <?php $__currentLoopData = $data->subcategory->childs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $child): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										  <option value="<?php echo e($child->id); ?> " <?php echo e($child->id == $data->childcategory_id ? "selected":""); ?>><?php echo e($child->name); ?></option>
										  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
										  <?php endif; ?>
										  <?php endif; ?>
												</select>
										</div>
									</div>


									<?php
										$selectedAttrs = json_decode($data->attributes, true);
										// dd($selectedAttrs);
									?>


									
									<div id="catAttributes">
										<?php
											$catAttributes = !empty($data->category->attributes) ? $data->category->attributes : '';
										?>
										<?php if(!empty($catAttributes)): ?>
											<?php $__currentLoopData = $catAttributes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $catAttribute): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
												<div class="row">
													 <div class="col-lg-12">
															<div class="left-area">
																 <h4 class="heading"><?php echo e($catAttribute->name); ?> *</h4>
															</div>
													 </div>
													 <div class="col-lg-12">
														 <?php
															 $i = 0;
														 ?>
														 <?php $__currentLoopData = $catAttribute->attribute_options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $optionKey => $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
															 <?php
																$inName = $catAttribute->input_name;
																$checked = 0;
															 ?>


															 <div class="row">
																 <div class="col-lg-5">
																	 <div class="custom-control custom-checkbox">
																		  <input type="checkbox" disabled="disabled" id="<?php echo e($catAttribute->input_name); ?><?php echo e($option->id); ?>" name="<?php echo e($catAttribute->input_name); ?>[]" value="<?php echo e($option->name); ?>" class="custom-control-input attr-checkbox"
																		  <?php if(is_array($selectedAttrs) && array_key_exists($catAttribute->input_name,$selectedAttrs)): ?>
																			  <?php if(is_array($selectedAttrs["$inName"]["values"]) && in_array($option->name, $selectedAttrs["$inName"]["values"])): ?>
																				  checked
																				 <?php
																					 $checked = 1;
																				 ?>
																			  <?php endif; ?>
																		  <?php endif; ?>
																		  >
																		  <label class="custom-control-label" for="<?php echo e($catAttribute->input_name); ?><?php echo e($option->id); ?>"><?php echo e($option->name); ?></label>
																	 </div>
																 </div>

																 <div class="col-lg-7 <?php echo e($catAttribute->price_status == 0 ? 'd-none' : ''); ?>">
																		<div class="row">
																			 <div class="col-2">
																					+
																			 </div>
																			 <div class="col-10">
																					<div class="price-container">
																						 <span class="price-curr"><?php echo e($sign->sign); ?></span>
																						 <input type="text" disabled="disabled" class="input-field price-input" id="<?php echo e($catAttribute->input_name); ?><?php echo e($option->id); ?>_price" data-name="<?php echo e($catAttribute->input_name); ?>_price[]" placeholder="0.00 (Additional Price)" value="<?php echo e(!empty($selectedAttrs["$inName"]['prices'][$i]) && $checked == 1 ? $selectedAttrs["$inName"]['prices'][$i] : ''); ?>">
																					</div>
																			 </div>
																		</div>
																 </div>
															 </div>


															 <?php
																 if ($checked == 1) {
																	 $i++;
																 }
															 ?>
															<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
													 </div>

												</div>
											<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
										<?php endif; ?>
									</div>
									


									
									<div id="subcatAttributes">
										<?php
											$subAttributes = !empty($data->subcategory->attributes) ? $data->subcategory->attributes : '';
										?>
										<?php if(!empty($subAttributes)): ?>
											<?php $__currentLoopData = $subAttributes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subAttribute): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
												<div class="row">
													 <div class="col-lg-12">
															<div class="left-area">
																 <h4 class="heading"><?php echo e($subAttribute->name); ?> *</h4>
															</div>
													 </div>
													 <div class="col-lg-12">
															 <?php
																 $i = 0;
															 ?>
															 <?php $__currentLoopData = $subAttribute->attribute_options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
																 <?php
																	$inName = $subAttribute->input_name;
																	$checked = 0;
																 ?>

																 <div class="row">
																	<div class="col-lg-5">
																	   <div class="custom-control custom-checkbox">
																		  <input type="checkbox" disabled="disabled" id="<?php echo e($subAttribute->input_name); ?><?php echo e($option->id); ?>" name="<?php echo e($subAttribute->input_name); ?>[]" value="<?php echo e($option->name); ?>" class="custom-control-input attr-checkbox"
																		  <?php if(is_array($selectedAttrs) && array_key_exists($subAttribute->input_name,$selectedAttrs)): ?>
																		  <?php
																		  $inName = $subAttribute->input_name;
																		  ?>
																		  <?php if(is_array($selectedAttrs["$inName"]["values"]) && in_array($option->name, $selectedAttrs["$inName"]["values"])): ?>
																		  checked
																		  <?php
																			 $checked = 1;
																		  ?>
																		  <?php endif; ?>
																		  <?php endif; ?>
																		  >
																		  <label class="custom-control-label" for="<?php echo e($subAttribute->input_name); ?><?php echo e($option->id); ?>"><?php echo e($option->name); ?></label>
																	   </div>
																	</div>
																	<div class="col-lg-7 <?php echo e($subAttribute->price_status == 0 ? 'd-none' : ''); ?>">
																	   <div class="row">
																		  <div class="col-2">
																			 +
																		  </div>
																		  <div class="col-10">
																			 <div class="price-container">
																				<span class="price-curr"><?php echo e($sign->sign); ?></span>
																				<input type="text" disabled="disabled" class="input-field price-input" id="<?php echo e($subAttribute->input_name); ?><?php echo e($option->id); ?>_price" data-name="<?php echo e($subAttribute->input_name); ?>_price[]" placeholder="0.00 (Additional Price)" value="<?php echo e(!empty($selectedAttrs["$inName"]['prices'][$i]) && $checked == 1 ? $selectedAttrs["$inName"]['prices'][$i] : ''); ?>">
																			 </div>
																		  </div>
																	   </div>
																	</div>
																 </div>
																 <?php
																	 if ($checked == 1) {
																		 $i++;
																	 }
																 ?>
																<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

													 </div>
												</div>
											<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
										<?php endif; ?>
									</div>
									


									
									<div id="childcatAttributes">
										<?php
											$childAttributes = !empty($data->childcategory->attributes) ? $data->childcategory->attributes : '';
										?>
										<?php if(!empty($childAttributes)): ?>
											<?php $__currentLoopData = $childAttributes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $childAttribute): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
												<div class="row">
													 <div class="col-lg-12">
															<div class="left-area">
																 <h4 class="heading"><?php echo e($childAttribute->name); ?> *</h4>
															</div>
													 </div>
													 <div class="col-lg-12">
														 <?php
															 $i = 0;
														 ?>
														 <?php $__currentLoopData = $childAttribute->attribute_options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $optionKey => $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
															 <?php
																$inName = $childAttribute->input_name;
																$checked = 0;
															 ?>
															 <div class="row">
																	 <div class="col-lg-5">
																		 <div class="custom-control custom-checkbox">
																			  <input type="checkbox" disabled="disabled" id="<?php echo e($childAttribute->input_name); ?><?php echo e($option->id); ?>" name="<?php echo e($childAttribute->input_name); ?>[]" value="<?php echo e($option->name); ?>" class="custom-control-input attr-checkbox"
																			  <?php if(is_array($selectedAttrs) && array_key_exists($childAttribute->input_name,$selectedAttrs)): ?>
																				  <?php
																					 $inName = $childAttribute->input_name;
																				  ?>
																				  <?php if(is_array($selectedAttrs["$inName"]["values"]) && in_array($option->name, $selectedAttrs["$inName"]["values"])): ?>
																					  checked
																					 <?php
																						 $checked = 1;
																					 ?>
																				  <?php endif; ?>
																			  <?php endif; ?>
																			  >
																			  <label class="custom-control-label" for="<?php echo e($childAttribute->input_name); ?><?php echo e($option->id); ?>"><?php echo e($option->name); ?></label>
																		 </div>
																  </div>


																	<div class="col-lg-7 <?php echo e($childAttribute->price_status == 0 ? 'd-none' : ''); ?>">
																		 <div class="row">
																				<div class="col-2">
																					 +
																				</div>
																				<div class="col-10">
																					 <div class="price-container">
																							<span class="price-curr"><?php echo e($sign->sign); ?></span>
																							<input type="text" disabled="disabled" class="input-field price-input" id="<?php echo e($childAttribute->input_name); ?><?php echo e($option->id); ?>_price" data-name="<?php echo e($childAttribute->input_name); ?>_price[]" placeholder="0.00 (Additional Price)" value="<?php echo e(!empty($selectedAttrs["$inName"]['prices'][$i]) && $checked == 1 ? $selectedAttrs["$inName"]['prices'][$i] : ''); ?>">
																					 </div>
																				</div>
																		 </div>
																	</div>
															 </div>
															 <?php
																 if ($checked == 1) {
																	 $i++;
																 }
															 ?>
															<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
													 </div>

												</div>
											<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
										<?php endif; ?>
									</div>
									

		

									<div class="row">
										<div class="col-lg-12">
											<div class="left-area">

											</div>
										</div>
										<div class="col-lg-12">
											
										</div>
									</div>



									<div class="<?php echo e($data->ship != null ? "":"showbox"); ?>">

									<div class="row">
										<div class="col-lg-12">
											<div class="left-area">
													
											</div>
										</div>
										<div class="col-lg-12">
											</div>
									</div>


									</div>
									
									<div class="row">
										<div class="col-lg-12"><div class="left-area"><h4 class="heading"><?php echo e(__('Variation Title')); ?>* </h4></div></div>
										<div class="col-lg-12"><input type="text" disabled="disabled" class="input-field" placeholder="<?php echo e(__('Enter Variation Title')); ?>" name="variation_title" value="<?php echo e($data->variation_title); ?>" ></div>
									</div>

									<div class="row">
										<div class="col-lg-12">
											<div class="left-area">

											</div>
										</div>
										<div class="col-lg-12">
											<ul class="list">
												<li>
													<input name="size_check"  type="checkbox" id="size-check" value="1" <?php echo e(!empty($data->size) ? "checked":""); ?>>
													<label for="size-check"><?php echo e(_('Allow Variations')); ?></label>
												</li>
											</ul>
										</div>
									</div>
										<div class="<?php echo e(!empty($data->size) ? "":"showbox"); ?>" id="size-display">
										<div class="row">
												<div  class="col-lg-12">
												</div>
												<div  class="col-lg-12">
													<div class="product-size-details" id="size-section">
													    <?php $datasize=array();
													    if($data->size_pre_price){
													        	$datasize=explode(',',$data->size_pre_price);
													    }
									
										$dataimage=array();
										if($data->size_image){
										    $dataimage=explode(',',$data->size_image);
										}
										?>
														<?php if(!empty($data->size)): ?>
														 <?php $__currentLoopData = $data->size; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $data1): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
															<div class="size-area">
												<span class="remove size-remove"><i class="fas fa-times"></i></span>
												<div  class="row">
														<div class="col-md-4 col-sm-6">
															<label>
																<?php echo e(__('Variation Name')); ?> :
																<span>
																	<?php echo e(__('(eg. Enter Variation)')); ?>

																</span>
															</label>
															<input type="text" disabled="disabled" name="size[]" class="input-field" placeholder="Variation Name" value="<?php echo e($data->size[$key]); ?>">
														</div>
														<div class="col-md-4 col-sm-6">
																<label>
																	<?php echo e(__('Variation Qty')); ?> :
																	<span>
																		<?php echo e(__('(Number of quantity of this Variation)')); ?>

																	</span>
																</label>
															<input type="number"  name="size_qty[]" class="input-field" placeholder="Variation Qty" min="0" value="<?php echo e($data->size_qty[$key]); ?>">
														</div>
														<div class="col-md-4 col-sm-6">
																<label>
																	<?php echo e(__('Variation Price')); ?> :
																	<span>
																		<?php echo e(__('(This price will be added with base price)')); ?>

																	</span>
																</label>
															<input type="number" disabled="disabled" name="size_price[]" class="input-field var_price_s" placeholder="<?php echo e(__('Variation Price')); ?>" min="0" value="<?php echo e($data->size_price[$key]); ?>">
														</div>
													</div>
													<div  class="row">
													    
													<div class="col-md-4 col-sm-6">
																<label>
																	<?php echo e(__('Variation Previous Price')); ?> :
																	<span>
																		<?php echo e(__('')); ?>

																	</span>
																</label>
                                                             	<?php if(!empty($datasize[$key])): ?>
															<input type="number" disabled="disabled" name="size_pre_price[]" class="input-field var_price_p" placeholder="<?php echo e(__('Variation Previous Price')); ?>" min="0" value="<?php echo e($datasize[$key]); ?>">
														     <?php else: ?>
														     <input type="number" disabled="disabled" name="size_pre_price[]" class="input-field var_price_p" placeholder="<?php echo e(__('Variation Previous Price')); ?>" min="0" value="">
														     	<?php endif; ?>
														</div>
														<div class="col-md-4 col-sm-6">																
																  <div class="img-upload">
																      <?php if(!empty($dataimage[$key])): ?>
        <div id="image-preview" class="img-preview" style="background: url(<?php echo e($dataimage[$key] ? asset('assets/images/products/'.$dataimage[$key]):asset('assets/images/noimage.png')); ?>);">
            <label for="image-upload" class="img-label" id="image-label"><i class="icofont-upload-alt"></i><?php echo e(__('Upload Image')); ?></label>			
            <input type="file" disabled="disabled" name="size_image[<?php echo e($key); ?>]" class="img-upload" id="image-upload" disabled>
          </div>
           <?php else: ?>
           <label for="image-upload" class="img-label" id="image-label"><i class="icofont-upload-alt"></i><?php echo e(__('Upload Image')); ?></label>			
            <input type="file" name="size_image[]" class="img-upload" id="image-upload">
           <?php endif; ?>
    </div>

															
														</div>
														
													</div>
													
												</div>
														 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
														<?php else: ?>
															<div class="size-area">
												<span class="remove size-remove"><i class="fas fa-times"></i></span>
												<div  class="row">
														<div class="col-md-4 col-sm-6">
															<label>
																<?php echo e(__('Variation Name')); ?> :
																<span>
																	<?php echo e(__('(eg. Enter Variation)')); ?>

																</span>
															</label>
															<input type="text" name="size[]" disabled="disabled" class="input-field" placeholder="Variation Name" >
														</div>
														<div class="col-md-4 col-sm-6">
																<label>
																	<?php echo e(__('Variation Qty')); ?> :
																	<span>
																		<?php echo e(__('(Number of quantity of this Variation)')); ?>

																	</span>
																</label>
															<input type="number" name="size_qty[]" disabled="disabled" class="input-field" placeholder="Variation Qty" min="0" >
														</div>
														<div class="col-md-4 col-sm-6">
																<label>
																	<?php echo e(__('Variation Price')); ?> :
																	<span>
																		<?php echo e(__('(This price will be added with base price)')); ?>

																	</span>
																</label>
															<input type="number" name="size_price[]" disabled="disabled" class="input-field" placeholder="<?php echo e(__('Variation Price')); ?>" min="0" >
														</div>
													</div>
													<div  class="row">
													<div class="col-md-4 col-sm-6">
																<label>
																	<?php echo e(__('Variation Previous Price')); ?> :
																	<span>
																		<?php echo e(__('')); ?>

																	</span>
																</label>

															<input type="number" name="size_pre_price[]" disabled="disabled" class="input-field" placeholder="<?php echo e(__('Variation Previous Price')); ?>" min="0" >
														</div>
														<div class="col-md-4 col-sm-6">																
																  <div class="img-upload">
        
            <label for="image-upload" class="img-label" id="image-label"><i class="icofont-upload-alt"></i><?php echo e(__('Upload Image')); ?></label>			
            <input type="file" name="size_image[]" class="img-upload" id="image-upload">
          
    </div>

															
														</div>
													</div>
													
												</div>
														<?php endif; ?>
													</div>

													<a href="javascript:;" id="size-btn" class="add-more"><i class="fas fa-plus"></i><?php echo e(_('Add More Variations')); ?> </a>
												</div>
										</div>
									</div>

									<div class="row">
										<div class="col-lg-12">
											<div class="left-area">

											</div>
										</div>
										<div class="col-lg-12">
											
										</div>
									</div>



									<div class="<?php echo e(!empty($data->color) ? "":"showbox"); ?>">

										<div class="row">
											<?php if(!empty($data->color)): ?>
												<div  class="col-lg-12">
													<div class="left-area">
														<h4 class="heading">
															<?php echo e($langg->lang657); ?>*
														</h4>
														<p class="sub-heading">
															<?php echo e($langg->lang658); ?>

														</p>
													</div>
												</div>
												<div  class="col-lg-12">
														</div>
											<?php else: ?>								


											<?php endif; ?>
										</div>

									</div>

									<div class="row">
										<div class="col-lg-12">
											<div class="left-area">

											</div>
										</div>
										<div class="col-lg-12">
											
										</div>
									</div>

								<div class="<?php echo e(!empty($data->whole_sell_qty) ? "":"showbox"); ?>">
									<div class="row">
										<div class="col-lg-12">
											<div class="left-area">

											</div>
										</div>
										<div class="col-lg-12">
											<div class="featured-keyword-area">
												<div class="feature-tag-top-filds" id="whole-section">
													
												</div>

												</div>
										</div>
									</div>
								</div>


									<div class="<?php echo e(!empty($data->size) ? "showbox":""); ?>" id="stckprod">
									<div class="row">
										<div class="col-lg-12">
											<div class="left-area">
													<h4 class="heading"><?php echo e($langg->lang669); ?>*</h4>
													<p class="sub-heading"><?php echo e($langg->lang670); ?></p>
											</div>
										</div>
										<div class="col-lg-12">
											<input oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" name="stock" type="text" class="input-field" placeholder="<?php echo e($langg->lang666); ?>" value="<?php echo e($data->stock); ?>">
											<div class="checkbox-wrapper">
												<input type="checkbox"  name="measure_check" class="checkclick1" id="allowProductMeasurement" value="1" <?php echo e($data->measure == null ? '' : 'checked'); ?>>
												<label for="allowProductMeasurement"><?php echo e($langg->lang671); ?></label>
											</div>
										</div>
									</div>

									</div>

								<div class="<?php echo e($data->measure == null ? 'showbox' : ''); ?>">

									<div class="row">
										<div class="col-lg-12">
											<div class="left-area">
													<h4 class="heading"><?php echo e($langg->lang672); ?>*</h4>
											</div>
										</div>
										<div class="col-lg-12">
												<select id="product_measure" disabled="disabled">
												  <option value="" <?php echo e($data->measure == null ? 'selected':''); ?>><?php echo e($langg->lang673); ?></option>
												  <option value="Gram" <?php echo e($data->measure == 'Gram' ? 'selected':''); ?>><?php echo e($langg->lang674); ?></option>
												  <option value="Kilogram" <?php echo e($data->measure == 'Kilogram' ? 'selected':''); ?>><?php echo e($langg->lang675); ?></option>
												  <option value="Litre" <?php echo e($data->measure == 'Litre' ? 'selected':''); ?>><?php echo e($langg->lang676); ?></option>
												  <option value="Pound" <?php echo e($data->measure == 'Pound' ? 'selected':''); ?>><?php echo e($langg->lang677); ?></option>
												  <option value="Custom" <?php echo e(in_array($data->measure,explode(',', 'Gram,Kilogram,Litre,Pound')) ? '' : 'selected'); ?>><?php echo e($langg->lang678); ?></option>
												 </select>
										</div>
										<div class="col-lg-1"></div>
										<div class="col-lg-3 <?php echo e(in_array($data->measure,explode(',', 'Gram,Kilogram,Litre,Pound')) ? 'hidden' : ''); ?>" id="measure">
											<input name="measure" disabled="disabled" type="text" id="measurement" class="input-field" placeholder="<?php echo e($langg->lang679); ?>" value="<?php echo e($data->measure); ?>">
										</div>
									</div>

								</div>


									<div class="row">
										<div class="col-lg-12">
											<div class="left-area">
												<h4 class="heading">
														<?php echo e($langg->lang680); ?>*
												</h4>
											</div>
										</div>
										<div class="col-lg-12">
											<div class="text-editor">
												<textarea name="details"  class="nic-edit-p" readonly><?php echo e($data->details); ?></textarea>
											</div>
										</div>
									</div>



									<div class="row">
										<div class="col-lg-12">
											<div class="left-area">
												<h4 class="heading">
														<?php echo e($langg->lang681); ?>*
												</h4>
											</div>
										</div>
										<div class="col-lg-12">
											<div class="text-editor">
												<textarea name="policy"  class="nic-edit-p" readonly><?php echo e($data->policy); ?></textarea>
											</div>
										</div>
									</div>


									<div class="row">
										<div class="col-lg-12">
										<div class="checkbox-wrapper">
										  <input type="checkbox" name="seo_check" value="1" class="checkclick" id="allowProductSEO" <?php echo e(($data->meta_tag != null || strip_tags($data->meta_description) != null) ? 'checked':''); ?>>
										  <label for="allowProductSEO"><?php echo e($langg->lang683); ?></label>
										</div>
										</div>
									</div>



									<div class="<?php echo e(($data->meta_tag == null && strip_tags($data->meta_description) == null) ? "showbox":""); ?>">
									  <div class="row">
										<div class="col-lg-12">
										  <div class="left-area">
											  <h4 class="heading"><?php echo e($langg->lang684); ?> *</h4>
										  </div>
										</div>
										<div class="col-lg-12">
										  <ul id="metatags" class="myTags">
											  <?php if(!empty($data->meta_tag)): ?>
												<?php $__currentLoopData = $data->meta_tag; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $element): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
												  <li><?php echo e($element); ?></li>
												<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
											<?php endif; ?>
										  </ul>
										</div>
									  </div>

									  <div class="row">
										<div class="col-lg-12">
										  <div class="left-area">
											<h4 class="heading">
												<?php echo e($langg->lang685); ?> *
											</h4>
										  </div>
										</div>
										<div class="col-lg-12">
										  <div class="text-editor">
											<textarea name="meta_description" class="input-field" placeholder="<?php echo e($langg->lang685); ?>" disabled><?php echo e($data->meta_description); ?></textarea>
										  </div>
										</div>
									  </div>
									</div>

				


									<div class="row">
										<div class="col-lg-12 text-center">
											<button class="addProductSubmit-btn" type="submit"><?php echo e($langg->lang706); ?></button>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-4">
				<div class="add-product-content">
								<div class="row">
									<div class="col-lg-12">
										<div class="product-description">
											<div class="body-area">
												
												<div class="row">
													<div class="col-lg-12">
														<div class="left-area">
															<h4 class="heading"><?php echo e($langg->lang511); ?> *</h4>
														</div>
													</div>
													<div class="col-lg-12">
														<div class="img-upload  custom-image-upload">
															<div id="image-preview" class="img-preview" style="background: url(<?php echo e($data->photo ? asset('assets/images/products/'.$data->photo):asset('assets/images/noimage.png')); ?>);">
																<label for="image-upload" class="img-label" id="image-label"><i class="icofont-upload-alt"></i><?php echo e($langg->lang512); ?></label>
																<input type="file" disabled="disabled" name="photo" class="img-upload" id="image-upload" >
															</div>
															<p class="img-alert mt-2 text-danger d-none"></p>
															<p class="text"><?php echo e(isset($langg->lang805) ? $langg->lang805 : 'Prefered Size: (800x800) or Square Size.'); ?></p>
														</div>

													</div>
                        						</div>

												<div class="row">
													<div class="col-lg-12">
														<div class="left-area">
																<h4 class="heading">
																	<?php echo e($langg->lang644); ?> *
																</h4>
														</div>
													</div>
													<div class="col-lg-12">
														<a href="javascript" class="set-gallery"  data-toggle="modal" data-target="#setgallery" disabled>
															<input type="hidden" value="<?php echo e($data->id); ?>">
																<i class="icofont-plus"></i> <?php echo e($langg->lang645); ?>

														</a>
													</div>
												</div>


												<div class="row">
													<div class="col-lg-12">
														<div class="left-area">
															<h4 class="heading">
																<?php echo e($langg->lang664); ?>*
															</h4>
															<p class="sub-heading">
																(<?php echo e($langg->lang665); ?> <?php echo e($sign->name); ?>)
															</p>
														</div>
													</div>
													<div class="col-lg-7">
														<input name="price" disabled="disabled" step="0.1" type="number" class="input-field" placeholder="<?php echo e($langg->lang666); ?>" value="<?php echo e(round($data->price * $sign->value , 2)); ?>" required="" min="0">
													</div>
												</div>

												<div class="row">
													<div class="col-lg-12">
														<div class="left-area">
																<h4 class="heading"><?php echo e($langg->lang667); ?>*</h4>
																<p class="sub-heading"><?php echo e($langg->lang668); ?></p>
														</div>
													</div>
													<div class="col-lg-7">
														<input name="previous_price" disabled="disabled" step="0.1" type="number" class="input-field" placeholder="<?php echo e($langg->lang666); ?>" value="<?php echo e(round($data->previous_price * $sign->value , 2)); ?>" min="0">
													</div>
												</div>
											


												<div class="row">
													<div class="col-lg-12">
														<div class="left-area">
																<h4 class="heading"><?php echo e($langg->lang682); ?>*</h4>
																<p class="sub-heading"><?php echo e($langg->lang668); ?></p>
														</div>
													</div>
													<div class="col-lg-12">
														<input  name="youtube" disabled="disabled" type="text" class="input-field" placeholder="<?php echo e($langg->lang682); ?>" value="<?php echo e($data->youtube); ?>">
													</div>
												</div>


												<div class="row">
													<div class="col-lg-12">
														<div class="left-area">

														</div>
													</div>
													<div class="col-lg-12">
														<div class="featured-keyword-area">
															<div class="left-area">
																<h4 class="heading"><?php echo e($langg->lang686); ?></h4>
															</div>

															<div class="feature-tag-top-filds" id="feature-section">
																<?php if(!empty($data->features)): ?>

																	 <?php $__currentLoopData = $data->features; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $data1): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

																<div class="feature-area">
																	<span class="remove feature-remove"><i class="fas fa-times"></i></span>
																	<div class="row">
																		<div class="col-lg-6">
																		<input type="text" disabled="disabled" name="features[]" class="input-field" placeholder="<?php echo e($langg->lang687); ?>" value="<?php echo e($data->features[$key]); ?>">
																		</div>

																		<div class="col-lg-6">
											                                <div class="input-group colorpicker-component cp">
											                                  <input type="text" disabled="disabled" name="colors[]" value="<?php echo e($data->colors[$key]); ?>" class="input-field cp"/>
											                                  <span class="input-group-addon"><i></i></span>
											                                </div>
																		</div>
																	</div>
																</div>


																		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
																<?php else: ?>

																<div class="feature-area">
																	<span class="remove feature-remove"><i class="fas fa-times"></i></span>
																	<div class="row">
																		<div class="col-lg-6">
																		<input type="text" disabled="disabled" name="features[]" class="input-field" placeholder="<?php echo e($langg->lang687); ?>">
																		</div>

																		<div class="col-lg-6">
											                                <div class="input-group colorpicker-component cp">
											                                  <input type="text" disabled="disabled" name="colors[]" value="#000000" class="input-field cp"/>
											                                  <span class="input-group-addon"><i></i></span>
											                                </div>
																		</div>
																	</div>
																</div>

																<?php endif; ?>
															</div>

															<a href="javascript:;" id="feature-btn" disabled="disabled" class="add-fild-btn"><i class="icofont-plus"></i> <?php echo e($langg->lang688); ?></a>
														</div>
													</div>
												</div>


						                        <div class="row">
						                          <div class="col-lg-12">
						                            <div class="left-area">
						                                <h4 class="heading"><?php echo e($langg->lang689); ?> *</h4>
						                            </div>
						                          </div>
						                          <div class="col-lg-12">
						                            <ul id="tags" class="myTags">
						                            	<?php if(!empty($data->tags)): ?>
							                                <?php $__currentLoopData = $data->tags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $element): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							                                  <li><?php echo e($element); ?></li>
							                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						                                <?php endif; ?>
						                            </ul>
						                          </div>
						                        </div>
											
											</div>
										</div>
									</div>
								</div>
							</div>	
			</div>
		</div>
		
		</form>
	</div>


		<div class="modal fade" id="setgallery" tabindex="-1" role="dialog" aria-labelledby="setgallery" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
				<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalCenterTitle"><?php echo e($langg->lang619); ?></h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="top-area">
						<div class="row">
							<div class="col-sm-6 text-right">
								<div class="upload-img-btn">
									<form  method="POST" enctype="multipart/form-data" id="form-gallery">
										<?php echo e(csrf_field()); ?>

									<input type="hidden" id="pid" name="product_id" value="">
									<input type="file" disabled="disabled" name="gallery[]" class="hidden" id="uploadgallery" accept="image/*" multiple>
											<label id="prod_gallery"><i class="icofont-upload-alt"></i><?php echo e($langg->lang620); ?></label>
									</form>
								</div>
							</div>
							<div class="col-sm-6">
								<a href="javascript:;" class="upload-done" data-dismiss="modal"> <i class="fas fa-check"></i> <?php echo e($langg->lang621); ?></a>
							</div>
							<div class="col-sm-12 text-center">( <small><?php echo e($langg->lang622); ?></small> )</div>
						</div>
					</div>
					<div class="gallery-images">
						<div class="selected-image">
							<div class="row">


							</div>
						</div>
					</div>
				</div>
				</div>
			</div>
		</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>

<script type="text/javascript">

// Gallery Section Update

    $(document).on("click", ".set-gallery" , function(){
        var pid = $(this).find('input[type=hidden]').val();
        $('#pid').val(pid);
        $('.selected-image .row').html('');
            $.ajax({
                    type: "GET",
                    url:"<?php echo e(route('vendor-gallery-show')); ?>",
                    data:{id:pid},
                    success:function(data){
                      if(data[0] == 0)
                      {
	                    $('.selected-image .row').addClass('justify-content-center');
	      				$('.selected-image .row').html('<h3><?php echo e($langg->lang624); ?></h3>');
     				  }
                      else {
	                    $('.selected-image .row').removeClass('justify-content-center');
	      				$('.selected-image .row h3').remove();
                          var arr = $.map(data[1], function(el) {
                          return el });

                          for(var k in arr)
                          {
        				$('.selected-image .row').append('<div class="col-sm-6">'+
                                        '<div class="img gallery-img">'+
                                            '<span class="remove-img"><i class="fas fa-times"></i>'+
                                            '<input type="hidden" value="'+arr[k]['id']+'">'+
                                            '</span>'+
                                            '<a href="'+'<?php echo e(asset('assets/images/galleries').'/'); ?>'+arr[k]['photo']+'" target="_blank">'+
                                            '<img src="'+'<?php echo e(asset('assets/images/galleries').'/'); ?>'+arr[k]['photo']+'" alt="gallery image">'+
                                            '</a>'+
                                        '</div>'+
                                  	'</div>');
                          }
                       }

                    }
                  });
      });


  $(document).on('click', '.remove-img' ,function() {
    var id = $(this).find('input[type=hidden]').val();
    $(this).parent().parent().remove();
	    $.ajax({
	        type: "GET",
	        url:"<?php echo e(route('vendor-gallery-delete')); ?>",
	        data:{id:id}
	    });
  });

  $(document).on('click', '#prod_gallery' ,function() {
    $('#uploadgallery').click();
  });


  $("#uploadgallery").change(function(){
    $("#form-gallery").submit();
  });

  $(document).on('submit', '#form-gallery' ,function() {
		  $.ajax({
		   url:"<?php echo e(route('vendor-gallery-store')); ?>",
		   method:"POST",
		   data:new FormData(this),
		   dataType:'JSON',
		   contentType: false,
		   cache: false,
		   processData: false,
		   success:function(data)
		   {
		    if(data != 0)
		    {
	                    $('.selected-image .row').removeClass('justify-content-center');
	      				$('.selected-image .row h3').remove();
		        var arr = $.map(data, function(el) {
		        return el });
		        for(var k in arr)
		           {
        				$('.selected-image .row').append('<div class="col-sm-6">'+
                                        '<div class="img gallery-img">'+
                                            '<span class="remove-img"><i class="fas fa-times"></i>'+
                                            '<input type="hidden" value="'+arr[k]['id']+'">'+
                                            '</span>'+
                                            '<a href="'+'<?php echo e(asset('assets/images/galleries').'/'); ?>'+arr[k]['photo']+'" target="_blank">'+
                                            '<img src="'+'<?php echo e(asset('assets/images/galleries').'/'); ?>'+arr[k]['photo']+'" alt="gallery image">'+
                                            '</a>'+
                                        '</div>'+
                                  	'</div>');
		            }
		    }

		                       }

		  });
		  return false;
 });


// Gallery Section Update Ends

</script>

<script src="<?php echo e(asset('assets/admin/js/jquery.Jcrop.js')); ?>"></script>

<script src="<?php echo e(asset('assets/admin/js/jquery.SimpleCropper.js')); ?>"></script>

<script type="text/javascript">

$('.cropme').simpleCropper();


</script>


  <script type="text/javascript">
  $(document).ready(function() {

    let html = `<img src="<?php echo e(empty($data->photo) ? asset('assets/images/noimage.png') : filter_var($data->photo, FILTER_VALIDATE_URL) ? $data->photo :asset('assets/images/products/'.$data->photo)); ?>" alt="">`;
    $(".span4.cropme").html(html);

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

  });


  $('.ok').on('click', function () {

 setTimeout(
    function() {


  	var img = $('#feature_photo').val();

      $.ajax({
        url: "<?php echo e(route('vendor-prod-upload-update',$data->id)); ?>",
        type: "POST",
        data: {"image":img},
        success: function (data) {
          if (data.status) {
            $('#feature_photo').val(data.file_name);
          }
          if ((data.errors)) {
            for(var error in data.errors)
            {
              $.notify(data.errors[error], "danger");
            }
          }
        }
      });

    }, 1000);



    });

  </script>

<script src="<?php echo e(asset('assets/admin/js/product.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.vendor', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>