@extends('layouts.admin')
@section('content')
<div class="content-area">
	<div class="mr-breadcrumb">
		<div class="row">
			<div class="col-lg-12">
				<h4 class="heading">{{ __('Vendor Registration') }} 				
				<ul class="links">
					<li><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }} </a></li>
					<li><a href="{{ route('admin-vendor-index') }}">{{ __('Vendor List') }}</a></li>
					<li><a href="javascript:;">{{ __('Add Vendor') }}</a></li>					
				</ul>
			</div>
		</div>
	</div>

	<form id="vendorform" action="{{route('admin-vendor-submit')}}" method="POST" enctype="multipart/form-data">
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
										<div class="col-lg-12"><div class="left-area"><h4 class="heading">{{ __('Full Name') }} </h4></div></div>
										<div class="col-lg-12"><input type="text" class="input-field" placeholder="{{ __('Full Name') }}" name="name"></div>
									</div>	
                                   
                                    <div class="row">
										<div class="col-lg-12"><div class="left-area"><h4 class="heading">{{ __('Email Address') }}* </h4></div></div>
										<div class="col-lg-12"><input type="email" class="input-field" placeholder="{{ __('Email Address') }}" name="email" required=""></div>
									</div>

                                    <div class="row">
										<div class="col-lg-12"><div class="left-area"><h4 class="heading">{{ __('Country') }} </h4></div></div>
										<div class="col-lg-12">										
										<select class="form-control" name="country" id="usercountry">
						                    @include('includes.countries')
					                    </select>
										
										</div>
									</div>
									
                                     <div class="row">
										<div class="col-lg-12"><div class="left-area"><h4 class="heading">{{ __('State') }} </h4></div></div>
										<div class="col-lg-12">
										<select id="userstate" name="state"  disabled="">
                                          <option value="">{{ __('Select State') }}</option>
                                        </select>
										</div>
									</div>
                                 
                                    <div class="row">
										<div class="col-lg-12"><div class="left-area"><h4 class="heading">{{ __('Address') }} </h4></div></div>
										<div class="col-lg-12"><input type="text" class="input-field" placeholder="{{ __('Address') }}" name="address"></div>
									</div>		

                                     <div class="row">
										<div class="col-lg-12"><div class="left-area"><h4 class="heading">{{ __('Shop Name') }}* </h4></div></div>
										<div class="col-lg-12"><input type="text" class="input-field" placeholder="{{ __('Shop Name') }}" name="shop_name" required=""></div>
									</div>		

                                         
                                    <div class="row">
										<div class="col-lg-12"><div class="left-area"><h4 class="heading">{{ __('Owner Name') }} </h4></div></div>
										<div class="col-lg-12"><input type="text" class="input-field" placeholder="{{ __('Owner Name') }}" name="owner_name"></div>
									</div>		


                                    <div class="row">
										<div class="col-lg-12"><div class="left-area"><h4 class="heading">{{ __('Shop Number') }} </h4></div></div>
										<div class="col-lg-12"><input type="text" class="input-field" placeholder="{{ __('Shop Number') }}" name="shop_number"></div>
									</div>		


                                    <div class="row">
										<div class="col-lg-12"><div class="left-area"><h4 class="heading">{{ __('Shop Address') }} </h4></div></div>
										<div class="col-lg-12"><input type="text" class="input-field" placeholder="{{ __('Shop Address') }}" name="shop_address"></div>
									</div>		


                                    <div class="row">
										<div class="col-lg-12"><div class="left-area"><h4 class="heading">{{ __('Registration Number') }} </h4></div></div>
										<div class="col-lg-12"><input type="text" class="input-field" placeholder="{{ __('Registration Number') }}" name="reg_number"></div>
									</div>	

                                    <div class="row">
										<div class="col-lg-12"><div class="left-area"><h4 class="heading">{{ __('Message') }} </h4></div></div>
										<div class="col-lg-12"><input type="text" class="input-field" placeholder="{{ __('Message') }}" name="shop_message"></div>
									</div>


                                     <div class="row">
										<div class="col-lg-12"><div class="left-area"><h4 class="heading">{{ __('Password') }}* </h4></div></div>
										<div class="col-lg-12"><input type="password" class="input-field" placeholder="{{ __('Password') }}" name="password" required=""></div>
									</div>


                                   <div class="row">
										<div class="col-lg-12"><div class="left-area"><h4 class="heading">{{ __('Confirm Password') }}* </h4></div></div>
										<div class="col-lg-12"><input type="password" class="input-field" placeholder="{{ __('Confirm Password') }}" name="password_confirmation" required=""></div>
									</div>									
									                           
		                            		
									<div class="row">
										<div class="col-lg-12 text-center">
										<input type="hidden" name="vendor" value="1">
										<input class="mprocessdata" type="hidden" value="{{ $langg->lang188 }}">
											<button class="addVendorRegister-btn"
												type="submit">{{ __('Register') }}</button>
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
 $(document).on('change','#usercountry',function () {
            var link = $(this).find(':selected').attr('data-href');
           console.log(link);
            if(link != ""){
                $('#userstate').load(link);
                $('#userstate').prop('disabled',false);
            }
        });
    </script>
@endsection
