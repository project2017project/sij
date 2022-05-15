
<?php $__env->startSection('styles'); ?>

<link href="<?php echo e(asset('assets/admin/css/product.css')); ?>" rel="stylesheet" />
<link href="<?php echo e(asset('assets/admin/css/jquery.Jcrop.css')); ?>" rel="stylesheet" />
<link href="<?php echo e(asset('assets/admin/css/Jcrop-style.css')); ?>" rel="stylesheet" />

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

<div class="content-area">
	<div class="mr-breadcrumb">
		<div class="row">
			<div class="col-lg-12">
				<h4 class="heading"><?php echo e(__('Physical Product')); ?> 
				<a class="add-btn" href="<?php echo e(route('admin-prod-types')); ?>"><i class="fas fa-arrow-left"></i> <?php echo e(__('Back')); ?></a></h4>
				<ul class="links">
					<li><a href="<?php echo e(route('admin.dashboard')); ?>"><?php echo e(__('Dashboard')); ?> </a></li>
					<li><a href="javascript:;"><?php echo e(__('Products')); ?> </a></li>
					<li><a href="<?php echo e(route('admin-prod-index')); ?>"><?php echo e(__('All Products')); ?></a></li>
					<li><a href="<?php echo e(route('admin-prod-types')); ?>"><?php echo e(__('Add Product')); ?></a></li>
					<li><a href="<?php echo e(route('admin-prod-physical-create')); ?>"><?php echo e(__('Normal Product')); ?></a></li>
				</ul>
			</div>
		</div>
	</div>

	<form id="geniusform" action="<?php echo e(route('admin-prod-store')); ?>" method="POST" enctype="multipart/form-data">
		<?php echo e(csrf_field()); ?>	
	<div class="row">
		<div class="col-lg-8">
			<div class="add-product-content">
				<div class="row">
					<div class="col-lg-12">
						<div class="product-description">
							<div class="body-area">		
								<div class="gocover" style="background: url(<?php echo e(asset('assets/images/'.$gs->admin_loader)); ?>) no-repeat scroll center center rgba(45, 45, 45, 0.5);"></div>
		
									<?php echo $__env->make('includes.admin.form-both', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
		
		                            <div class="row">
            							<div class="col-lg-12">
            								<div class="left-area">
            									<h4 class="heading"><?php echo e(__('Vendors')); ?>*</h4>
            								</div>
            							</div>
            							<div class="col-lg-12">
        									<select id="vendor" name="user_id" required="">
        										<option value=""><?php echo e(__('Select Vendor')); ?></option>
        										
                                                <?php $__currentLoopData = $vendors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vendor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($vendor->id); ?>" vname="<?php echo e($vendor->shop_name); ?>"><?php echo e($vendor->shop_name); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
            							</div>
            						</div>
		
									<div class="row">
										<div class="col-lg-12"><div class="left-area"><h4 class="heading"><?php echo e(__('Product Name')); ?>* </h4><p class="sub-heading"><?php echo e(__('(In Any Language)')); ?></p></div></div>
										<div class="col-lg-12"><input type="text" class="input-field" placeholder="<?php echo e(__('Enter Product Name')); ?>" name="name" required=""></div>
									</div>		
									<div class="row">
										<div class="col-lg-12"><div class="left-area"><h4 class="heading"><?php echo e(__('Product Sku')); ?>* </h4></div></div>
										<div class="col-lg-12">
											<input type="text" class="input-field" placeholder="<?php echo e(__('Enter Product Sku')); ?>" id="skucode" name="sku" required="" value="">		
										</div>
									</div>		
									<div class="showbox">
										<div class="row">
											<div class="col-lg-12"><div class="left-area"><h4 class="heading"><?php echo e(__('Product Condition')); ?>*</h4></div></div>
											<div class="col-lg-12"><select name="product_condition"><option value="2"><?php echo e(__('New')); ?></option><option value="1"><?php echo e(__('Used')); ?></option></select></div>
										</div>
									</div>
		                            
            						           						
									<div class="row">
										<div class="col-lg-12">
											<div class="left-area">
												<h4 class="heading"><?php echo e(__('Category')); ?>*</h4>
											</div>
										</div>
										<div class="col-lg-12">
											<select id="cat" name="category_id" required="">
												<option value=""><?php echo e(__('Select Category')); ?></option>
												<?php $__currentLoopData = $cats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
												<option data-href="<?php echo e(route('admin-subcat-load',$cat->id)); ?>"
													value="<?php echo e($cat->id); ?>"><?php echo e($cat->name); ?></option>
												<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
											</select>
										</div>
									</div>
		
									<div class="row">
										<div class="col-lg-12">
											<div class="left-area">
												<h4 class="heading"><?php echo e(__('Sub Category')); ?></h4>
											</div>
										</div>
										<div class="col-lg-12">
											<select id="subcat" name="subcategory_id" disabled="">
												<option value=""><?php echo e(__('Select Sub Category')); ?></option>
											</select>
										</div>
									</div>
		
									<div class="row">
										<div class="col-lg-12">
											<div class="left-area">
												<h4 class="heading"><?php echo e(__('Child Category')); ?></h4>
											</div>
										</div>
										<div class="col-lg-12">
											<select id="childcat" name="childcategory_id" disabled="">
												<option value=""><?php echo e(__('Select Child Category')); ?></option>
											</select>
										</div>
									</div>
		
		
									<div id="catAttributes"></div>
									<div id="subcatAttributes"></div>
									<div id="childcatAttributes"></div>
		
		
		
			
		                               <div class="row">
										<div class="col-lg-12"><div class="left-area"><h4 class="heading"><?php echo e(__('Size or Color Title')); ?> </h4></div></div>
										<div class="col-lg-12"><input type="text" class="input-field" placeholder="<?php echo e(__('Enter Size or Color Title')); ?>" name="variation_title" ></div>
									</div>
		
		
									<div class="row">
										<div class="col-lg-12">
											<div class="left-area">
		
											</div>
										</div>
										<div class="col-lg-12">
											<ul class="list"><li><input name="size_check" type="checkbox" id="size-check" value="1"> <label for="size-check"> <?php echo e(__('Enable Size or Color')); ?></label></li></ul>
										</div>
									</div>
									<div class="showbox" id="size-display">
										<div class="row">
											<div class="col-lg-12">
											</div>
											<div class="col-lg-12">
												<div class="product-size-details" id="size-section">
													<div class="size-area">
														<span class="remove size-remove"><i class="fas fa-times"></i></span>
														<div class="row">
															<div class="col-md-4 col-sm-6">
																<label><?php echo e(__('Variation Name*')); ?> :<span><?php echo e(__('(eg. Enter color, size and more)')); ?></span></label>
																<input type="text" name="size[]" class="input-field" placeholder="<?php echo e(__('Variation Name')); ?>">
															</div>
															<div class="col-md-4 col-sm-6">
																<label><?php echo e(__('Variation Qty *')); ?> :<span><?php echo e(__('(Number of quantity of this Size or color)')); ?></span></label>
																<input type="number" name="size_qty[]" class="input-field" placeholder="<?php echo e(__('Variation Qty')); ?>" value="1" min="0">
															</div>
															<div class="col-md-4 col-sm-6">
																<label><?php echo e(__('Variation Selling Price *')); ?> :<span><?php echo e(__('(This price will be added with base price)')); ?></span></label>
																<input type="number" name="size_price[]" class="input-field var_price_s" placeholder="<?php echo e(__('Product Price')); ?>" value="0" min="0">
															</div>
														</div>
														<div class="row">															
															<div class="col-md-4 col-sm-6">
																<label><?php echo e(__('Variation Original Price *')); ?> <?php echo e(__('(Optional)')); ?> :<span><?php echo e(__('')); ?></span></label>
																<input type="number" name="size_pre_price[]" class="input-field var_price_p" placeholder="<?php echo e(__('MRP Price')); ?> <?php echo e(__('(Optional)')); ?>" value="0" min="0">
															</div>
															<div class="col-md-4 col-sm-6">
																<label><?php echo e(__('Upload Image')); ?> :<span><?php echo e(__('')); ?></span></label>
																<input type="file" name="size_image[]">
															</div>
														</div>
								<div class="image_for_sz_sec">				
                        		<div id="img-preview1"></div>
                                <input type="file" id="choose-file1" name="choose-file1" accept="image/*" />
                              <!--  <label for="choose-file1">Choose File</label>-->
                                </div>
                                
                               <!-- <script>
                                    const chooseFile = document.getElementById("choose-file1");
const imgPreview = document.getElementById("img-preview1");

chooseFile.addEventListener("change", function () {
  getImgData();
});

function getImgData() {
  const files = chooseFile.files[0];
  if (files) {
    const fileReader = new FileReader();
    fileReader.readAsDataURL(files);
    fileReader.addEventListener("load", function () {
      imgPreview.style.display = "block";
      imgPreview.innerHTML = '<img src="' + this.result + '" />';
    });    
  }
}
                                </script> -->
														
														
													</div>
												</div>
		
												<a href="javascript:;" id="size-btn" class="add-more"><i
														class="fas fa-plus"></i><?php echo e(__('Add More Color or Size')); ?> </a>
											</div>
										</div>
									</div>
									
	<!--	<div class="row">
										<div class="col-lg-12">
											<div class="left-area">
		
											</div>
										</div>
										<div class="col-lg-12">
											<ul class="list">
												<li>
													<input class="checkclick1" name="color_check" type="checkbox" id="check3"
														value="1">
													<label for="check3"><?php echo e(__('Allow Product Colors')); ?></label>
												</li>
											</ul>
										</div>
									</div>-->
									<input type="hidden" value="0" class="minprice" name="minPrice">
									<input type="hidden" value="0" class="maxprice" name="maxPrice">
									<input type="hidden" value="0" class="sumprice" name="sum_price">
									
									<div class="showbox">
		
										<div class="row">
											<div class="col-lg-12">
												<div class="left-area">
													<h4 class="heading">
														<?php echo e(__('Product Colors')); ?>*
													</h4>
													<p class="sub-heading">
														<?php echo e(__('(Choose Your Favorite Colors)')); ?>

													</p>
												</div>
											</div>
											<div class="col-lg-12">
												<div class="select-input-color" id="color-section">
													<div class="color-area">
														<span class="remove color-remove"><i class="fas fa-times"></i></span>
														<div class="input-group colorpicker-component cp">
															<input type="text" name="color[]" value="#000000"
																class="input-field cp" />
															<span class="input-group-addon"><i></i></span>
														</div>
													</div>
												</div>
												<a href="javascript:;" id="color-btn" class="add-more mt-4 mb-3"><i
														class="fas fa-plus"></i><?php echo e(__('Add More Color')); ?> </a>
											</div>
										</div>
		
									</div>
									<div class="row">
										<div class="col-lg-12">
											<div class="left-area">
		
											</div>
										</div>
										<div class="col-lg-12">
											<ul class="list">
												<li>
													<input class="checkclick1" name="whole_check" type="checkbox"
														id="whole_check" value="1">
													<label for="whole_check"><?php echo e(__('Allow Product Whole Sell')); ?></label>
												</li>
											</ul>
										</div>
									</div>
		
									<div class="showbox">
										<div class="row">
											<div class="col-lg-12">
												<div class="left-area">
		
												</div>
											</div>
											<div class="col-lg-12">
												<div class="featured-keyword-area">
													<div class="feature-tag-top-filds" id="whole-section">
														<div class="feature-area">
															<span class="remove whole-remove"><i
																	class="fas fa-times"></i></span>
															<div class="row">
																<div class="col-lg-6">
																	<input type="number" name="whole_sell_qty[]"
																		class="input-field"
																		placeholder="<?php echo e(__('Enter Quantity')); ?>" min="0">
																</div>
		
																<div class="col-lg-6">
																	<input type="number" name="whole_sell_discount[]"
																		class="input-field"
																		placeholder="<?php echo e(__('Enter Discount Percentage')); ?>"
																		min="0" />
																</div>
															</div>
														</div>
													</div>
		
													<a href="javascript:;" id="whole-btn" class="add-fild-btn"><i
															class="icofont-plus"></i> <?php echo e(__('Add More Field')); ?></a>
												</div>
											</div>
										</div>
									</div>
		                            <div class="row" id="stckprod">
										<div class="col-lg-12">
											<div class="left-area">
												<h4 class="heading"><?php echo e(__('Product Stock')); ?>*</h4>
												<p class="sub-heading">Stock For Simple Products</p>
											</div>
										</div>
										<div class="col-lg-12">
											<input name="stock" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" type="text" class="input-field" min="0" value="0"
												placeholder="<?php echo e(__('e.g 20')); ?>">
											
										</div>
									</div>
									
		
		
									<div class="row">
										<div class="col-lg-12">
											<div class="left-area">
												<h4 class="heading">
													<?php echo e(__('Product Description')); ?>

												</h4>
											</div>
										</div>
										<div class="col-lg-12">
											<div class="text-editor">
												<textarea class="nic-edit-p" name="details"></textarea>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-12">
											<div class="left-area">
												<h4 class="heading">
													<?php echo e(__('Product Short Description')); ?>

												</h4>
											</div>
										</div>
										<div class="col-lg-12">
											<div class="text-editor">
												<textarea class="nic-edit-p" name="short_details"></textarea>
											</div>
										</div>
									</div>
		
		
									
		                             <div class="row">
										<div class="col-lg-12">
											<div class="checkbox-data">
												<input type="checkbox" name="draft" value="1" class=""
													id="draft" >
												<label for="draft"><?php echo e(__('Save as draft')); ?></label>
											</div>
										</div>
									</div>
		
									<div class="row">
										<div class="col-lg-12">
											<div class="checkbox-wrapper">
												<input type="checkbox" name="seo_check" value="1" class="checkclick"
													id="allowProductSEO" value="1">
												<label for="allowProductSEO"><?php echo e(__('Allow Product SEO')); ?></label>
											</div>
										</div>
									</div>
									
									
		
		
		
									<div class="showbox">
									    
									    <div class="row">
											<div class="col-lg-12">
												<div class="left-area">
													<h4 class="heading"><?php echo e(__('Meta Title')); ?> </h4>
												</div>
											</div>
											<div class="col-lg-12">
											<input type="text" class="input-field" placeholder="<?php echo e(__('Enter Meta Title')); ?>" name="meta-title">
											</div>
										</div>
									    
										<div class="row">
											<div class="col-lg-12">
												<div class="left-area">
													<h4 class="heading"><?php echo e(__('Meta Tags')); ?> </h4>
												</div>
											</div>
											<div class="col-lg-12">
												<ul id="metatags" class="myTags">
												</ul>
											</div>
										</div>
		
										<div class="row">
											<div class="col-lg-12">
												<div class="left-area">
													<h4 class="heading">
														<?php echo e(__('Meta Description')); ?> 
													</h4>
												</div>
											</div>
											<div class="col-lg-12">
												<div class="text-editor">
													<textarea name="meta_description" id="metadesc" maxlength="300" class="input-field"
														placeholder="<?php echo e(__('Meta Description')); ?>"></textarea>
														<div id="the-count">
                                                            <span id="current">0</span>
                                                            <span id="maximum">/ 300</span>
                                                        </div>
                                                        
                                                  
												</div>
											</div>
										</div>
									</div>
		

		
		
									<div class="row">
										<div class="col-lg-12 text-center">
											<button class="addProductSubmit-btn"
												type="submit"><?php echo e(__('Create Product')); ?></button>
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
												<h4 class="heading"><?php echo e(__('Feature Image')); ?> *</h4>
											</div>
										</div>
										<div class="col-lg-12">
										<div class="img-upload full-width-img">
                                <div id="image-preview" class="img-preview" style="background: url(<?php echo e(asset('assets/admin/images/upload.png')); ?>);">
                                    <label for="image-upload" class="img-label" id="image-label"><i class="icofont-upload-alt"></i><?php echo e(__('Upload Image')); ?></label>
                                    <input type="file" name="photo" class="img-upload" id="image-upload">
                                  </div>                                 
                            </div>											
										</div>
									</div>
		
									<input type="hidden" id="feature_photo" name="photo" value="">
									

									<!--div class="col-lg-12">
											<div class="left-area">
												<h4 class="heading"><?php echo e(__('Secondary Image')); ?> </h4>
											</div>
										</div-->
									<!-- <input type="file"  name="second_photo" value="" > -->

								<!--div class="img-upload">
	                                <div id="image-preview" class="img-preview" style="background: url(<?php echo e(asset('assets/admin/images/upload.png')); ?>);">
	                                    <label for="image-upload" class="img-label" id="image-label"><i class="icofont-upload-alt"></i><?php echo e(__('Upload Image')); ?></label>
	                                    <input type="file" name="second_photo" class="img-upload" id="image-upload">
	                                  </div>
	                            </div-->








									<input type="file" name="gallery[]" class="hidden" id="uploadgallery" accept="image/*"
										multiple>

									<div class="row mb-4">
										<div class="col-lg-12 mb-2">
											<div class="left-area">
												<h4 class="heading">
													<?php echo e(__('Product Gallery Images')); ?>

												</h4>
											</div>
										</div>
										<div class="col-lg-12">
											<a href="#" class="set-gallery" data-toggle="modal" data-target="#setgallery">
												<i class="icofont-plus"></i> <?php echo e(__('Set Gallery')); ?>

											</a>
										</div>
									</div>

		
		                            <div class="row">
										<div class="col-lg-12">
											<div class="left-area">
												<h4 class="heading"><?php echo e(__('Original Price')); ?>*</h4>
												<p class="sub-heading"><?php echo e(__('(For regular price of products on sale)')); ?></p>
											</div>
										</div>
										<div class="col-lg-12">
											<input name="previous_price" step="0.01" type="number" required class="input-field previousprice"
												placeholder="<?php echo e(__('e.g 20')); ?>" min="0">
										</div>
									</div>
									
									<div class="row">
										<div class="col-lg-12">
											
										</div>
										<div class="col-lg-12">
											<input type="checkbox" id="enbdiscount" name="enbdiscount"> <label for="enbdiscount">Enable Discount</label> 
										</div>
									</div>
		
							
									<div class="row">
										<div class="col-lg-12">
											<div class="left-area">
												<h4 class="heading">
													<?php echo e(__('Selling Price')); ?>*
												</h4>
												<p class="sub-heading">
													(<?php echo e(__('In')); ?> <?php echo e($sign->name); ?>)
												</p>
											</div>
										</div>
										<div class="col-lg-12">
											<input name="price2" type="number" class="input-field selleingprice"
												placeholder="<?php echo e(__('e.g 20')); ?>" step="0.01" required="" min="0" disabled>
													
										</div>
									</div>
		
									
		
		
		
		                            <div class="row">
										<div class="col-lg-12">
											<div class="left-area">
												<h4 class="heading"><?php echo e(__("Youtube Video URL")); ?></h4>
												<p class="sub-heading"><?php echo e(__("(Optional)")); ?></p>
											</div>
										</div>
										<div class="col-lg-12">
											<input name="youtube" type="text" class="input-field"
												placeholder="<?php echo e(__("Enter Youtube Video URL")); ?>">
										</div>
									</div>
		
								<!--	
								<div class="row">
										<div class="col-lg-12">
											<div class="left-area">
		
											</div>
										</div>
										<div class="col-lg-12">
											<div class="featured-keyword-area">
												<div class="left-area">
													<h4 class="heading"><?php echo e(__('Feature Tags')); ?></h4>
												</div>
												<div class="feature-tag-top-filds" id="feature-section">
													<div class="feature-area">
														<span class="remove feature-remove"><i class="fas fa-times"></i></span>
														<div class="row">
															<div class="col-lg-6">
																<input type="text" name="features[]" class="input-field"
																	placeholder="<?php echo e(__('Enter Your Keyword')); ?>">
															</div>
		
															<div class="col-lg-6">
																<div class="input-group colorpicker-component cp">
																	<input type="text" name="colors[]" value="#000000"
																		class="input-field cp" />
																	<span class="input-group-addon"><i></i></span>
																</div>
															</div>
														</div>
													</div>
												</div>
		
												<a href="javascript:;" id="feature-btn" class="add-fild-btn"><i
														class="icofont-plus"></i> <?php echo e(__('Add More Field')); ?></a>
											</div>
										</div>
									</div>
		-->
		
									<div class="row">
										<div class="col-lg-12">
											<div class="left-area">
												<h4 class="heading"><?php echo e(__('Tags')); ?> </h4>
											</div>
										</div>
										<div class="col-lg-12">
											<ul id="tags" class="myTags">
											</ul>
										</div>
									</div>
									<input type="hidden" name="type" value="Physical">
									<input name="price" type="hidden" class="input-field selleingprice"
												placeholder="<?php echo e(__('e.g 20')); ?>" step="0.01" required="" min="0" >
		
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
	<div class="modal-dialog modal-dialog-centered  modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalCenterTitle"><?php echo e(__('Image Gallery')); ?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="top-area">
					<div class="row">
						<div class="col-sm-6 text-right">
							<div class="upload-img-btn">
								<label for="image-uploads" id="prod_gallery"><i
										class="icofont-upload-alt"></i><?php echo e(__('Upload File')); ?></label>
							</div>
						</div>
						<div class="col-sm-6">
							<a href="javascript:;" class="upload-done" data-dismiss="modal"> <i
									class="fas fa-check"></i> <?php echo e(__('Done')); ?></a>
						</div>
						<div class="col-sm-12 text-center">( <small><?php echo e(__('You can upload multiple Images.')); ?></small>
							)</div>
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

<script src="<?php echo e(asset('assets/admin/js/jquery.Jcrop.js')); ?>"></script>
<script src="<?php echo e(asset('assets/admin/js/jquery.SimpleCropper.js')); ?>"></script>


<script type="text/javascript">
        $(document).ready(function(){
       $('select#vendor').on('change', function() {
          var vname = ($(this).find("option:selected").attr('vname')).replace(/ /g,'');
          var vnamef = (vname.substring(0, 3)).toUpperCase();
          $("#skucode").val(vnamef);
});


$('#enbdiscount').change(function() {
        var preprice = $(".previousprice").val();
    
        if(this.checked) {
            $(".selleingprice").prop('disabled', false);
           
        }
        else{
            $(".selleingprice").prop('disabled', true);
             $(".selleingprice").val(preprice);
        }    
    });



$(".previousprice").keyup(function(){
    var prepricek = $(".previousprice").val();
    $(".selleingprice").val(prepricek);
    $(".selleingprice").attr({
       "max" : prepricek,        // substitute your own
       "min" : 1          // values (or variables) here
    });
});


$(".selleingprice").focusout(function(){
     var prepricesk = $(".previousprice").val();
    var sellpricesk = $(".selleingprice").val();
    
    if(sellpricesk > prepricesk){
        $(".selleingprice").val(prepricesk);
        alert("Sale price cannot be more than orignal price")
    } 
 
});


    });
</script>

<script type="text/javascript">
	// Gallery Section Insert

	$(document).on('click', '.remove-img', function () {
		var id = $(this).find('input[type=hidden]').val();
		$('#galval' + id).remove();
		$(this).parent().parent().remove();
	});

	$(document).on('click', '#prod_gallery', function () {
		$('#uploadgallery').click();
		$('.selected-image .row').html('');
		$('#geniusform').find('.removegal').val(0);
	});


	$("#uploadgallery").change(function () {
		var total_file = document.getElementById("uploadgallery").files.length;
		for (var i = 0; i < total_file; i++) {
			$('.selected-image .row').append('<div class="col-sm-6">' +
				'<div class="img gallery-img">' +
				'<span class="remove-img"><i class="fas fa-times"></i>' +
				'<input type="hidden" value="' + i + '">' +
				'</span>' +
				'<a href="' + URL.createObjectURL(event.target.files[i]) + '" target="_blank">' +
				'<img src="' + URL.createObjectURL(event.target.files[i]) + '" alt="gallery image">' +
				'</a>' +
				'</div>' +
				'</div> '
			);
			$('#geniusform').append('<input type="hidden" name="galval[]" id="galval' + i +
				'" class="removegal" value="' + i + '">')
		}

	});

	// Gallery Section Insert Ends
</script>

<script type="text/javascript">
	$('.cropme').simpleCropper();
</script>

      <script>
                                                            jQuery(document).ready(function(){
                                                                jQuery('#metadesc').keyup(function() {
                                                                        
                                                                      var characterCount = jQuery(this).val().length,
                                                                          current = jQuery('#current'),
                                                                          maximum = jQuery('#maximum'),
                                                                          theCount = jQuery('#the-count');
                                                                        
                                                                      current.text(characterCount);
                                                                     
                                                                      
                                                                      /*This isn't entirely necessary, just playin around*/
                                                                      if (characterCount < 70) {
                                                                        current.css('color', '#666');
                                                                      }
                                                                      if (characterCount > 70 && characterCount < 90) {
                                                                        current.css('color', '#666');
                                                                      }
                                                                      if (characterCount > 90 && characterCount < 100) {
                                                                        current.css('color', '#666');
                                                                      }
                                                                      if (characterCount > 100 && characterCount < 120) {
                                                                        current.css('color', '#666');
                                                                      }
                                                                      if (characterCount > 120 && characterCount < 139) {
                                                                        current.css('color', '#666');
                                                                      }
                                                                      
                                                                      if (characterCount >= 140) {
                                                                        maximum.css('color', '#666');
                                                                        current.css('color', '#666');
                                                                        theCount.css('font-weight','bold');
                                                                      } else {
                                                                        maximum.css('color','#666');
                                                                        theCount.css('font-weight','normal');
                                                                      }
                                                                      
                                                                          
                                                                    });
                                                            });
                                                        </script>
														<script>
    $(document).ready(function(){
  $(".addProductSubmit-btn").mouseover(function(){
      
     if ($('#size-check').is(':checked')) { 
      
    var ids = $(".var_price_s[value]").map(function() {
    return $(this).val();
}).get();
var pids = $(".var_price_p[value]").map(function() {
    return $(this).val();
}).get();

var highest = Math.max.apply( Math, ids );
var lowest = Math.min.apply( Math, ids );
var plowest = Math.min.apply( Math, pids );

}else{
    var highest = $("input[name='price']").val();
var lowest = $("input[name='price']").val();
var plowest = $("input[name='previous_price']").val();
}

$(".minprice").val(lowest);
$(".maxprice").val(highest);
$(".sumprice").val(plowest);



  });
});
</script>



<script src="<?php echo e(asset('assets/admin/js/product.js')); ?>"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>