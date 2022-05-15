 

<?php $__env->startSection('content'); ?>  
    <input type="hidden" id="headerdata" value="<?php echo e(__('PRODUCT')); ?>">
	<div class="content-area">
		<div class="mr-breadcrumb">
			<div class="row">
				<div class="col-lg-12">
					<h4 class="heading"><?php echo e(__("Products")); ?></h4>
					<ul class="links">
						<li><a href="<?php echo e(route('admin.dashboard')); ?>"><?php echo e(__("Dashboard")); ?> </a></li>
						<li><a href="javascript:;"><?php echo e(__("Products")); ?> </a></li>
						<li><a href="<?php echo e(route('admin-prod-index')); ?>"><?php echo e(__("All Products")); ?></a></li>
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
						<div class="row">				                                                                     
                            <div class="form-group col-md-2">
                                <select id="cat" name="category_id" required="">
                                    <option value=""><?php echo e(__('Select Category')); ?></option>
                                    <?php $__currentLoopData = $cats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option data-href="<?php echo e(route('admin-subcat-load',$cat->id)); ?>"
                                        value="<?php echo e($cat->id); ?>"><?php echo e($cat->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <div class="form-group col-md-2">
                                <select id="subcat" name="subcategory_id" disabled="">
                                    <option value=""><?php echo e(__('Select Sub Category')); ?></option>
                                </select>
                            </div>                          
                            <div class="form-group col-md-2">
                                <select id="childcat" name="childcategory_id" disabled="">
                                    <option value=""><?php echo e(__('Select Child Category')); ?></option>
                                </select>
                            </div>                          
							<div class="form-group col-md-2">                               
                                <select name="svendor" id="svendor">
                                    <option value=''>--Select Any Vendor-- </option>
                                    <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $userid): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($userid->id); ?>"><?php echo e($userid->shop_name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>                                        
                                </select>                                
                            </div>
                            
							<div class="form-group col-md-2">                               
                                <select name="highlight" id="highlight">
                                    <option value=''>--Select Highlight-- </option>
                                    <option value="colloction">Collection</option>
									<option value="designer">Designer</option>
									<option value="bribal">Bridal</option>
									<option value="chokars">Chokers</option>
                                    <option value="others">Today's Deals</option>								
                                </select>                                
                            </div>
                            	<div class="form-group col-md-2">                               
                                <select name="stock" id="stock">
                                    <option value=''>--Select Stock-- </option>
                                    <option value="in">IN</option>
									<option value="out">Out</option>
																	
                                </select>                                
                            </div>
                            <div class="text-left" >
                                <button type="text" id="btnFiterSubmitSearch" class="btn btn-info">Submit</button>
                                <button type="text" id="btnFiterReset" class="btn btn-info">Reset</button>
                            </div>
                        </div>
                    
                        <br>
					    <form id="geniusform" class="form-horizontal" action="<?php echo e(route('admin-prod-price-update')); ?>" method="POST" enctype="multipart/form-data">      
						    <?php echo e(csrf_field()); ?>

							<table id="geniustable" class="table table-hover dt-responsive" cellspacing="0" width="100%">
								<thead>
									<tr>
				                        <th><input type="checkbox"  id="checkAll"><?php echo e(__("Product Image")); ?></th><th><?php echo e(__("Name")); ?></th><th><?php echo e(__("SKU")); ?></th>
				                        <th><?php echo e(__("Stock")); ?></th><th><?php echo e(__("Price")); ?></th><th><?php echo e(__("Category List")); ?></th>
				                        <th><?php echo e(__("Last Update Date")); ?></th>
										<th><?php echo e(__("Vendor")); ?></th><th><?php echo e(__("View")); ?></th>
										<th><?php echo e(__("Options")); ?></th><th>Status</th>
									</tr>
								</thead>
							</table>
							
                            <div class="modal fade" id="bulk-edit" tabindex="-1" role="dialog" aria-labelledby="modal1" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="submit-loader">
                                            <img src="http://shop.webngigs.com/assets/images/1564224329loading3.gif" alt="">
                                        </div>
                                        <div class="modal-header d-block text-center">
                                            <h4 class="modal-title d-inline-block">Select Bulk Edit</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                        </div>
                                        <div class="modal-body">
                                            <input type="radio" name="gender" value="s"  />Sale
                                            <input type="radio" name="gender" value="r"  />Regular
                                            <select name="valuetype" class="form-control">
                                                <option>select Any</option>
                                                <option value="newprice">Static Price</option>
                                                <option value="addonprice">Add Fixed Price</option>
                                                <option value="addonpercentprice">Add Percentage Price</option>
                                                <option value="reduceonpercentprice">Decrease Percentage Price</option>
                                                <option value="reducefixedprice">Decrease Fixed Price</option>
                                            </select>
                                            <div class="sale_price_inputs"><input type="text"  class="form-control" name="pricevalue" value"" placeholder="Enter Value"></div>
                                            <h4>Stock</h4>
                                            <select name="stock" class="form-control">
                                                <option>select Any</option>
                                                <option value="instock">In stock</option>
                                                <option value="outofstock">Out of stock</option>
                                                <option value="stockupdate">stock update</option>
                                            </select>
                                            <input type="text"  class="form-control" name="staticstock" value"" placeholder="Enter Value">
                                            <hr>
                                        </div>
                                        <div class="modal-footer justify-content-center">
                                            <p align="center"><button type="submit" class="btn btn-success referesh-btn" name="save">Submit</button></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
				        </form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="modal2" tabindex="-1" role="dialog" aria-labelledby="modal2" aria-hidden="true">
    <div class="modal-dialog highlight" role="document">
        <div class="modal-content">
        	<div class="submit-loader"><img  src="<?php echo e(asset('assets/images/'.$gs->admin_loader)); ?>" alt=""></div>
        	<div class="modal-header">
        	    <h5 class="modal-title"></h5>
            	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        	</div>
        	<div class="modal-body">
        
        	</div>
        	<div class="modal-footer">
        	    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo e(__("Close")); ?></button>
        	</div>
        </div>
    </div>
</div>


<div class="modal fade" id="modal3" tabindex="-1" role="dialog" aria-labelledby="modal3" aria-hidden="true">
    <div class="modal-dialog modal-lg quickedit" role="document">
        <div class="modal-content">
            <div class="submit-loader"><img  src="<?php echo e(asset('assets/images/'.$gs->admin_loader)); ?>" alt=""></div>
        	<div class="modal-header">
        	    <h5 class="modal-title"></h5>
            	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        	</div>
        	<div class="modal-body">
        
        	</div>
        	<div class="modal-footer">
        	    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo e(__("Close")); ?></button>
        	</div>
        </div>
    </div>
</div>



<div class="modal fade" id="catalog-modal" tabindex="-1" role="dialog" aria-labelledby="modal1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        	<div class="modal-header d-block text-center">
		        <h4 class="modal-title d-inline-block"><?php echo e(__("Update Status")); ?></h4>
    			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
    				<span aria-hidden="true">&times;</span>
    			</button>
	        </div>
            <!-- Modal body -->
            <div class="modal-body">
                <p class="text-center"><?php echo e(__("You are about to change the status of this Product.")); ?></p>
                <p class="text-center"><?php echo e(__("Do you want to proceed?")); ?></p>
            </div>
            <!-- Modal footer -->
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo e(__("Cancel")); ?></button>
                <a class="btn btn-success btn-ok"><?php echo e(__("Proceed")); ?></a>
            </div>
        </div>
    </div>
</div>




<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="modal1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        	<div class="modal-header d-block text-center">
        		<h4 class="modal-title d-inline-block"><?php echo e(__("Confirm Delete")); ?></h4>
    			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
    				<span aria-hidden="true">&times;</span>
    			</button>
	        </div>
            <!-- Modal body -->
            <div class="modal-body">
                <p class="text-center"><?php echo e(__("You are about to delete this Product.")); ?></p>
                <p class="text-center"><?php echo e(__("Do you want to proceed?")); ?></p>
            </div>
            
            <!-- Modal footer -->
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo e(__("Cancel")); ?></button>
                <a class="btn btn-danger btn-ok"><?php echo e(__("Delete")); ?></a>
            </div>
        </div>
    </div>
</div>



<div class="modal fade" id="setgallery" tabindex="-1" role="dialog" aria-labelledby="setgallery" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalCenterTitle"><?php echo e(__("Image Gallery")); ?></h5>
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
									<input type="file" name="gallery[]" class="hidden" id="uploadgallery" accept="image/*" multiple>
									<label for="image-upload" id="prod_gallery"><i class="icofont-upload-alt"></i><?php echo e(__("Upload File")); ?></label>
								</form>
							</div>
						</div>
						<div class="col-sm-6">
							<a href="javascript:;" class="upload-done" data-dismiss="modal"> <i class="fas fa-check"></i> <?php echo e(__("Done")); ?></a>
						</div>
						<div class="col-sm-12 text-center">( <small><?php echo e(__("You can upload multiple Images")); ?>.</small> )</div>
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
<div class="modal fade" id="data-update" tabindex="-1" role="dialog" aria-labelledby="modal1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
    <div class="submit-loader">
        <img  src="<?php echo e(asset('assets/images/'.$gs->admin_loader)); ?>" alt="">
    </div>
    <div class="modal-header d-block text-center">
        <h4 class="modal-title d-inline-block">Data Update</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

      <!-- Modal body -->
      <div class="modal-body">
        <p class="text-center">Data Updated Successfully.</p>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer justify-content-center">
            <a class="btn btn-success btn-ok order-btn referesh-btn">OK</a>
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
               ajax: {
                  url: "<?php echo e(route('admin-prod-datatables')); ?>",
                  type: 'GET',
                  data: function (d) {
                    d.category         = $('#cat').val();
                    d.subcat           = $('#subcat').val();
                    d.childcat         = $('#childcat').val();
					d.svendor          = $('#svendor').val();
					d.highlight          = $('#highlight').val();
					d.stock          = $('#stock').val();
					
                  }
                 },
               columns: [
                       
                        { data: 'image', name: 'image' }, 
                        { data: 'name', name: 'name' },
                        { data: 'sku', name: 'sku' },
                        { data: 'stock', name: 'stock' },
                        { data: 'price', name: 'price' },  
                        { data: 'category', name: 'category' },
                        { data: 'date', name: 'date' },
						{ data: 'vendor', name: 'vendor' },
                        { data: 'views', name: 'views' },
                        
            			{ data: 'action', searchable: false, orderable: false },{ data: 'status', searchable: false, orderable: false}

                     ],
                language : {
                	processing: '<img src="<?php echo e(asset('assets/images/'.$gs->admin_loader)); ?>">'
                },
				drawCallback : function( settings ) {
	    				$('.select').niceSelect();	
				}
            });
			$('#btnFiterSubmitSearch').click(function(){
             $('#geniustable').DataTable().draw(true);
          });
      	$(function() {
            $(".btn-area").append('<div class="col-sm-3 table-contents">'+
            	'<a class="add-btn" href="<?php echo e(route('admin-prod-physical-create')); ?>">'+
              '<i class="fas fa-plus"></i> <span class="remove-mobile"><?php echo e(__("Add New Product")); ?><span>'+
              '</a>'+
              ' <a class="add-btn" href="<?php echo e(route('admin-prod-productupdate')); ?>">'+
              '<span class="remove-mobile"><?php echo e(__("Product Update")); ?><span>'+
              '</a>'+
              '</div>');
        });
        
									





</script>


<script type="text/javascript">
	

// Gallery Section Update

    $(document).on("click", ".set-gallery" , function(){
        var pid = $(this).find('input[type=hidden]').val();
        $('#pid').val(pid);
        $('.selected-image .row').html('');
            $.ajax({
                    type: "GET",
                    url:"<?php echo e(route('admin-gallery-show')); ?>",
                    data:{id:pid},
                    success:function(data){
                      if(data[0] == 0)
                      {
	                    $('.selected-image .row').addClass('justify-content-center');
	      				$('.selected-image .row').html('<h3><?php echo e(__("No Images Found.")); ?></h3>');
     				  }
                      else {
	                    $('.selected-image .row').removeClass('justify-content-center');
	      				$('.selected-image .row h3').remove();      
                          var arr = $.map(data[1], function(el) {
                          return el });

                        for(var k in arr){
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
	        url:"<?php echo e(route('admin-gallery-delete')); ?>",
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
	   url:"<?php echo e(route('admin-gallery-store')); ?>",
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
		            return el 
	            });
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
	<script>    
        $('#btnFiterReset').click(function(){window.location.reload();});
		$("#checkAll").click(function () {$('input:checkbox').not(this).prop('checked', this.checked);});    
		$(document).ready(function(){$(".referesh-btn").click(function(){location.reload(true);});});
	</script>
<?php $__env->stopSection(); ?>   
<?php echo $__env->make('layouts.admin', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>