@extends('layouts.admin')
@section('content')
<div class="content-area">
	<div class="mr-breadcrumb">
		<div class="row">
			<div class="col-lg-12">
				<h4 class="heading">{{ __('Create Refund') }} 				
				<ul class="links">
					<li><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }} </a></li>					
					<li><a href="javascript:;">{{ __('Create Refund Request') }}</a></li>					
				</ul>
			</div>
		</div>
	</div>

	<form id="raisedisputeform" action="{{route('admin-raisedispute-submit')}}" method="POST" enctype="multipart/form-data">
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
										<div class="col-lg-12"><div class="left-area"><h4 class="heading">{{ __('Vendor Name') }} </h4></div></div>
										<div class="col-lg-12">										
										<select class="form-control" name="vendor_id" id="vendorid">
						                    <option value=''>--Select Vendor Name-- </option>
                                    @foreach($users as $userid)
                                    <option data-href="{{ route('order-data-load',$userid->id) }}" value="{{$userid->id}}">{{$userid->shop_name}}</option>
                                    @endforeach
					                    </select>
										
										</div>
									</div>
									
                                     <div class="row">
										<div class="col-lg-12"><div class="left-area"><h4 class="heading">{{ __('Order Id') }} </h4></div></div>
										<div class="col-lg-12">
										<select id="orderid" name="order_id"  disabled="">
                                          <option value="">{{ __('Select Order Id') }}</option>
                                        </select>
										</div>
									</div>
									
																	
		                            		
									<div class="row">
										<div class="col-lg-12 text-center">										
											<button class="addraisedispute-btn"
												type="submit">{{ __('Create Request') }}</button>
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
 $(document).on('change','#vendorid',function () {
            var orderlink = $(this).find(':selected').attr('data-href');           
            if(orderlink != ""){
                $('#orderid').load(orderlink);
                $('#orderid').prop('disabled',false);
            }
        });
    </script>
@endsection
