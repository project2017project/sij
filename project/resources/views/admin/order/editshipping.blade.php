@extends('layouts.load')

@section('content')

            <div class="content-area">

              <div class="add-product-content1">
                <div class="row">
                  <div class="col-lg-12">
                    <div class="product-description">
                      <div class="body-area">
                      
                      <form id="editformdata" action="{{route('admin-order-updateshipping',$order->id)}}" method="POST" enctype="multipart/form-data">
                        {{csrf_field()}}
						@include('includes.admin.form-success') 
                        @include('includes.admin.form-error') 

                        <div class="row">
													<div class="col-lg-4">
														<div class="left-area">
																<h4 class="heading">{{ __('Name') }} *</h4>
														</div>
													</div>
													<div class="col-lg-7">
														<input type="text" class="input-field" name="shipping_name" placeholder="{{ __('User Name') }}" required="" value="{{$order->shipping_name == null ? $order->customer_name : $order->shipping_name}}">
													</div>
												</div>


												<div class="row">
													<div class="col-lg-4">
														<div class="left-area">
																<h4 class="heading">{{ __('Email') }} *</h4>
														</div>
													</div>
													<div class="col-lg-7">
														<input type="email" class="input-field" name="shipping_email" placeholder="{{ __('Email Address') }}" required="" value="{{$order->shipping_email == null ? $order->customer_email : $order->shipping_email}}">
													</div>
												</div>

												<div class="row">
													<div class="col-lg-4">
														<div class="left-area">
																<h4 class="heading">{{ __('Phone') }} *</h4>
														</div>
													</div>
													<div class="col-lg-7">
														<input type="text" class="input-field" name="shipping_phone" placeholder="{{ __('Phone Number') }}" required="" value="{{$order->shipping_phone == null ? $order->customer_phone : $order->shipping_phone}}">
													</div>
												</div>
												<div class="row">
													<div class="col-lg-4">
														<div class="left-area">
																<h4 class="heading">{{ __('Landmark') }} *</h4>
														</div>
													</div>
													<div class="col-lg-7">
														<input type="text-area" class="input-field" name="shipping_landmark" placeholder="{{ __('Landmark') }}" required="" value="{{$order->shipping_landmark == null ? $order->customer_landmark : $order->shipping_landmark}}">
													</div>
												</div>
												<div class="row">
													<div class="col-lg-4">
														<div class="left-area">
																<h4 class="heading">{{ __('Address') }} *</h4>
														</div>
													</div>
													<div class="col-lg-7">
														<input type="text-area" class="input-field" name="shipping_address" placeholder="{{ __('Address') }}" required="" value="{{$order->shipping_address == null ? $order->customer_address : $order->shipping_address}}">
													</div>
												</div>
												
												<div class="row">
													<div class="col-lg-4">
														<div class="left-area">
																<h4 class="heading">{{ __('Country') }} *</h4>
														</div>
													</div>
													<div class="col-lg-7">
														<select class="form-control" name="shipping_country" id="admin_country" required="">
														<option value="">{{ $langg->lang157 }}</option>
@if(Auth::check())
	@foreach (DB::table('countries')->get() as $datas)
	<option data-href="{{ route('front-state-load',$datas->id) }}" value="{{ $datas->name }}" {{ $order->customer_country == $datas->name ? 'selected' : '' }}>{{ $datas->name }}</option>		
	@endforeach
@else
	@foreach (DB::table('countries')->get() as $datas)
	<option data-href="{{ route('front-state-load',$datas->id) }}" value="{{ $datas->name }}">{{ $datas->name }}</option>		
	@endforeach
@endif
													</select>
													</div>
												</div>
												
												<div class="row">
													<div class="col-lg-4">
														<div class="left-area">
																<h4 class="heading">{{ __('State') }} *</h4>
														</div>
													</div>
													
													<div class="col-lg-7">
														<select class="form-control" name="shipping_state" id="admin_state" required="">
														@if($order->customer_state)
															<option value="{{$order->shipping_state == null ? $order->customer_state : $order->shipping_state}}">{{$order->shipping_state == null ? $order->customer_state : $order->shipping_state}}</option>
															@else
														<option value="">{{ __('Select State') }}</option>
													@endif
													</select>
													</div>
												</div>
												
												<div class="row">
													<div class="col-lg-4">
														<div class="left-area">
																<h4 class="heading">{{ __('City') }} *</h4>
														</div>
													</div>
													<div class="col-lg-7">
														<input type="text" class="input-field" name="shipping_city" placeholder="{{ __('City') }}" required="" value="{{$order->shipping_city == null ? $order->customer_city : $order->shipping_city}}">
													</div>
												</div>
												
												<div class="row">
													<div class="col-lg-4">
														<div class="left-area">
																<h4 class="heading">{{ __('Postal Code') }} *</h4>
														</div>
													</div>
													<div class="col-lg-7">
														<input type="text" class="input-field" name="shipping_zip" placeholder="{{ __('Zip Code') }}" required="" value="{{$order->shipping_zip == null ? $order->customer_zip : $order->shipping_zip}}">
													</div>
												</div>


                        <div class="row">
                          <div class="col-lg-4">
                            <div class="left-area">
                              
                            </div>
                          </div>
                          <div class="col-lg-7">
                            <button class="addProductSubmit-btn" type="submit">{{ __('Update') }}</button>
                          </div>
                        </div>
                      </form>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
@endsection