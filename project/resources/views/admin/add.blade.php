@extends('layouts.admin')
@section('content')
<div class="content-area">
	<div class="mr-breadcrumb">
		<div class="row">
			<div class="col-lg-12">
				<h4 class="heading">{{ __('Raise Dispute') }} 				
				<ul class="links">
					<li><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }} </a></li>					
					<li><a href="javascript:;">{{ __('Add Raise Dispute') }}</a></li>					
				</ul>
			</div>
		</div>
	</div>

	<form id="raisedisputeform" action="{{route('addstore-raisedispute-submit')}}" method="POST" enctype="multipart/form-data">
		{{csrf_field()}}
       @include('includes.admin.form-both')	
	<div class="row">
		<div class="col-lg-12">
			<div class="add-product-content">
				<div class="row">
					<div class="col-lg-12">
						<div class="product-description">
							<div class="body-area">						
		
									

                                    <div class="row">
										<div class="col-lg-12"><div class="left-area"><h4 class="heading">{{ __('Product Id') }} </h4></div></div>
										<div class="col-lg-12">	
									
										<select class="form-control productid" name="product_id" id="productid" required>
						                    <option value=''>--Select Product Id-- </option>
                                    @foreach($vdata as $vdatas)
									 @php
                                                $productsku = App\Models\Product::find($vdatas->product_id);
                                                @endphp
                                    <option data-href="{{ route('product-data-pload',$vdatas->product_id) }}" value="{{$vdatas->product_id}}">{{$productsku->sku}}</option>
                                    @endforeach
					                    </select>
										
										</div>
									</div>	                                    
									<div class="products"></div>
									
									<div class="row">
										<div class="col-lg-12"><div class="left-area"><h4 class="heading">{{ __('Amount') }}* </h4></div></div>
										<div class="col-lg-12"><input type="text" class="input-field" placeholder="{{ __('Amount') }}" name="amount" required=""></div>
									</div>
									<div class="row">
										<div class="col-lg-12"><div class="left-area"><h4 class="heading">{{ __('Quantity') }}* </h4></div></div>
										<div class="col-lg-12"><input type="text" class="input-field" placeholder="{{ __('Quantity') }}" name="quantity" required=""></div>
									</div>
                                 
                                    <div class="row">
										<div class="col-lg-12"><div class="left-area"><h4 class="heading">{{ __('Reason') }} </h4></div></div>
										<div class="col-lg-12"><input type="text" class="input-field" placeholder="{{ __('Reason') }}" name="reason" required=""></div>
									</div> 

                                   <div class="row">
										<div class="col-lg-12"><div class="left-area"><h4 class="heading">{{ __('Upload Screen Shot') }} </h4></div></div>
										<div class="col-lg-12"><input required type="file" class="form-control" name="screenshot[]" placeholder="Upload Screen Shot" multiple></div>
									</div> 									
		                            		
									<div class="row">
										<div class="col-lg-12 text-center">
										<input type="hidden" name="vendor_id" value="{{ $vendorid }}">
										<input type="hidden" name="order_id" value="{{ $orderid }}">
											<button class="addraisedispute-btn"
												type="submit">{{ __('Add') }}</button>
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
@endsection
@section('scripts')

<script src="{{asset('assets/admin/js/jquery.Jcrop.js')}}"></script>
<script src="{{asset('assets/admin/js/jquery.SimpleCropper.js')}}"></script>
<script>
 $(document).on('change','.productid',function () {
	 
            var productlink = $(this).find(':selected').attr('data-href');					
            if(productlink){
				$('.products').show();
                $('.products').load(productlink);                
            }else{
				$('.products').hide();
			}
        });
    </script>
@endsection
