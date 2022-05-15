@extends('layouts.load')

@section('content')

            <div class="content-area">

              <div class="add-product-content1">
                <div class="row">
                  <div class="col-lg-12">
                    <div class="product-description">
                      <div class="body-area">
                       
                      <form id="editformdata" action="{{route('admin-order-updatebilling',$order->id)}}" method="POST" enctype="multipart/form-data">
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
														<input type="text" class="input-field" name="customer_name" placeholder="{{ __('User Name') }}" required="" value="{{$order->customer_name}}">
													</div>
												</div>


												<div class="row">
													<div class="col-lg-4">
														<div class="left-area">
																<h4 class="heading">{{ __('Email') }} *</h4>
														</div>
													</div>
													<div class="col-lg-7">
														<input type="email" class="input-field" name="customer_email" placeholder="{{ __('Email Address') }}" required="" value="{{$order->customer_email}}">
													</div>
												</div>

												<div class="row">
													<div class="col-lg-4">
														<div class="left-area">
																<h4 class="heading">{{ __('Phone') }} *</h4>
														</div>
													</div>
													<div class="col-lg-7">
														<input type="text" class="input-field" name="customer_phone" placeholder="{{ __('Phone Number') }}" required="" value="{{$order->customer_phone}}">
													</div>
												</div>
												<div class="row">
													<div class="col-lg-4">
														<div class="left-area">
																<h4 class="heading">{{ __('Landmark') }} *</h4>
														</div>
													</div>
													<div class="col-lg-7">
														<input type="text-area" class="input-field" name="customer_landmark" placeholder="{{ __('Landmark') }}" required="" value="{{$order->customer_landmark}}">
													</div>
												</div>
												<div class="row">
													<div class="col-lg-4">
														<div class="left-area">
																<h4 class="heading">{{ __('Address') }} *</h4>
														</div>
													</div>
													<div class="col-lg-7">
														<input type="text-area" class="input-field" name="customer_address" placeholder="{{ __('Address') }}" required="" value="{{$order->customer_address}}">
													</div>
												</div>
												
												<div class="row">
													<div class="col-lg-4">
														<div class="left-area">
																<h4 class="heading">{{ __('Country') }} *</h4>
														</div>
													</div>
													<div class="col-lg-7">
														<select class="form-control" name="customer_country" id="admin_country" required="">
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
														<select class="form-control" name="customer_state" id="admin_state" required="">
														@if($order->customer_state)
															<option value="{{ $order->customer_state }}">{{ $order->customer_state }}</option>
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
														<input type="text" class="input-field" name="customer_city" placeholder="{{ __('City') }}" required="" value="{{$order->customer_city}}">
													</div>
												</div>
												
												<div class="row">
													<div class="col-lg-4">
														<div class="left-area">
																<h4 class="heading">{{ __('Postal Code') }} *</h4>
														</div>
													</div>
													<div class="col-lg-7">
														<input type="text" class="input-field" name="customer_zip" placeholder="{{ __('Zip Code') }}" required="" value="{{$order->customer_zip}}">
													</div>
												</div>


                        <div class="row">
                          <div class="col-lg-4">
                            <div class="left-area">
                              
                            </div>
                          </div>
                          <div class="col-lg-7">
						  <button class="addProductSubmit-btn" type="submit">{{ __('update') }}</button>                            
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