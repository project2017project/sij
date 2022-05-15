@extends('layouts.admin')
@section('content')
<div class="content-area">
	<div class="mr-breadcrumb">
		<div class="row">
			<div class="col-lg-12">
				<h4 class="heading">{{ __('Coupon') }} 				
				<ul class="links">
					<li><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }} </a></li>					
					<li><a href="javascript:;">{{ __('Create Coupon Request') }}</a></li>					
				</ul>
			</div>
		</div>
	</div>

	<form id="createcouponform" action="{{route('admin-coupon-submit')}}" method="POST" enctype="multipart/form-data">
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
										<div class="col-lg-12"><div class="left-area"><h4 class="heading">{{ __('Order Id') }} </h4></div></div>
										<div class="col-lg-12">
										<select id="orderid" name="order_id">
                                          <option value="">{{ __('Select Order Id') }}</option>
										  @foreach($orders as $orderdt)
                                    <option data-href="{{ route('order-data-cload',$orderdt->id) }}" value="{{$orderdt->id}}">{{$orderdt->id}}</option>
                                    @endforeach
                                        </select>
										</div>
									</div>
									<div class="orderdata"></div>
									<div class="row">
										<div class="col-lg-12"><div class="left-area"><h4 class="heading">{{ __('Code') }}* </h4></div></div>
										<div class="col-lg-12"><input type="text" class="input-field rdamt" placeholder="{{ __('Code') }}" name="code" required=""></div>
									</div>
																	
		                            		
									<div class="row">
										<div class="col-lg-12 text-center">										
											<button class="createcoupon-btn"
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
 $(document).on('change','#orderid',function () {
            var orderlink = $(this).find(':selected').attr('data-href');
           if(orderlink){
				$('.orderdata').show();
                $('.orderdata').load(orderlink);                
            }else{
				$('.orderdata').hide();
			}		
            
        });
    </script>
@endsection
