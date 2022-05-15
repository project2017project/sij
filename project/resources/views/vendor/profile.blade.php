@extends('layouts.vendor')
@section('content')

						<div class="content-area">
							<div class="mr-breadcrumb">
								<div class="row">
									<div class="col-lg-12">
											<h4 class="heading">{{ $langg->lang434 }}</h4>
											<ul class="links">
												<li>
													<a href="{{ route('vendor-dashboard') }}">{{ $langg->lang441 }} </a>
												</li>
												<li>
													<a href="{{ route('vendor-profile') }}">{{ $langg->lang434 }} </a>
												</li>
											</ul>
									</div>
								</div>
							</div>
							<div class="add-product-content1">
								<div class="row">
									<div class="col-lg-12">
										<div class="product-description">
											<div class="body-area">

				                        <div class="gocover" style="background: url({{asset('assets/images/'.$gs->admin_loader)}}) no-repeat scroll center center rgba(45, 45, 45, 0.5);"></div>
											<form id="geniusform" action="{{ route('vendor-profile-update') }}" method="POST" enctype="multipart/form-data">
												{{csrf_field()}}

                      						 @include('includes.vendor.form-both')  

												<div class="row">
													<div class="col-lg-4">
														<div class="left-area">
																<h4 class="heading">{{ $langg->lang457 }}: </h4>
														</div>
													</div>
													<div class="col-lg-7">
														<div class="right-area">
																<h6 class="heading"> {{ $data->shop_name }}
																	@if($data->checkStatus())
																	<a class="badge badge-success verify-link" href="javascript:;">{{ $langg->lang783 }}</a>
																	@else
																	 <span class="verify-link"><a href="{{ route('vendor-verify') }}">{{ $langg->lang784 }}</a></span>
																	@endif
																</h6>
														</div>
													</div>
												</div>

												<div class="row">
													<div class="col-lg-4">
														<div class="left-area">
																<h4 class="heading">{{ $langg->lang458 }} </h4>
														</div>
													</div>
													<div class="col-lg-7">
														<input type="text" class="input-field" name="owner_name" placeholder="{{ $langg->lang458 }}"  value="{{$data->owner_name}}">
													</div>
												</div>

												<div class="row">
													<div class="col-lg-4">
														<div class="left-area">
																<h4 class="heading">{{ $langg->lang459 }}</h4>
														</div>
													</div>
													<div class="col-lg-7">
														<input type="text" class="input-field" name="shop_number" placeholder="{{ $langg->lang459 }}"  value="{{$data->shop_number}}" readonly>
													</div>
												</div>

												<div class="row">
													<div class="col-lg-4">
														<div class="left-area">
																<h4 class="heading">{{ $langg->lang460 }} *</h4>
														</div>
													</div>
													<div class="col-lg-7">
														<input type="text" class="input-field" name="shop_address" placeholder="{{ $langg->lang460 }}" value="{{$data->shop_address}}" readonly>
													</div>
												</div>

												<div class="row">
													<div class="col-lg-4">
														<div class="left-area">
																<h4 class="heading">{{ __('GST Number') }} </h4>
																
														</div>
													</div>
													<div class="col-lg-7">
														<input type="text" class="input-field" name="reg_number" placeholder="{{ $langg->lang461 }}"  value="{{$data->reg_number}}" readonly>
													</div>
												</div>
												
												<div class="row">
													<div class="col-lg-4">
														<div class="left-area">
																<h4 class="heading">{{ __("Bank Name") }} </h4>
														</div>
													</div>
													<div class="col-lg-7">
														<input type="text" class="input-field" name="bank_name" placeholder="Bank Name" value="{{ $data->bank_name }}" readonly>
													</div>
												</div>
												
												<div class="row">
													<div class="col-lg-4">
														<div class="left-area">
																<h4 class="heading">{{ __("Branch") }} </h4>
														</div>
													</div>
													<div class="col-lg-7">
														<input type="text" class="input-field" name="branch" placeholder="Branch" value="{{ $data->branch }}" readonly>
													</div>
												</div>
												
												<div class="row">
													<div class="col-lg-4">
														<div class="left-area">
																<h4 class="heading">{{ __("IFSC Code") }} </h4>
														</div>
													</div>
													<div class="col-lg-7">
														<input type="text" class="input-field" name="ifsc_code" placeholder="IFSC Code" value="{{ $data->ifsc_code }}" readonly>
													</div>
												</div>
												
												<div class="row">
													<div class="col-lg-4">
														<div class="left-area">
																<h4 class="heading">{{ __("Account Holder Name") }} </h4>
																
														</div>
													</div>
													<div class="col-lg-7">
														<input type="text" class="input-field" name="account_holder_name" placeholder="Account Holder Name" value="{{ $data->account_holder_name }}" readonly>
													</div>
												</div>
												
												<div class="row">
													<div class="col-lg-4">
														<div class="left-area">
																<h4 class="heading">{{ __("Account Number") }} </h4>
														</div>
													</div>
													<div class="col-lg-7">
														<input type="text" class="input-field" name="account_number" placeholder="Account Number" value="{{ $data->account_number }}" readonly>
													</div>
												</div>
												
												<div class="row">
													<div class="col-lg-4">
														<div class="left-area">
																<h4 class="heading">{{ __("Commission") }} </h4>
														</div>
													</div>
													<div class="col-lg-7">
														<input type="text" class="input-field" name="percentage_commission" placeholder="Commission" value="{{ $data->percentage_commission }}" readonly>
													</div>
												</div>
												

												<div class="row">
													<div class="col-lg-4">
														<div class="left-area">
																<h4 class="heading">{{ $langg->lang463 }} </h4>
														</div>
													</div>
													<div class="col-lg-7">
														<textarea class="input-field nic-edit" name="shop_details" placeholder="{{ $langg->lang463 }}" disabled="disabled">{{$data->shop_details}}</textarea>
													</div>
												</div>
												
												
													<div class="row">
													<div class="col-lg-4">
														<div class="left-area">
																<h4 class="heading">Shop Logo </h4>
														</div>
													</div>
													<div class="col-lg-7">
													    <img id="shop_logo" src="{{ Auth::user()->shop_logo ? asset('assets/images/users/'.Auth::user()->shop_logo ):asset('assets/images/noimage.png') }}" style="width:100px;">
														<input type="file" class="input-field" name="shop_logo">
													</div>
												</div>
												
												
												<div class="row">
													<div class="col-lg-4">
														<div class="left-area">
																<h4 class="heading">Shop Banner </h4>
														</div>
													</div>
													<div class="col-lg-7">
													    <img id="shop_image" src="{{ Auth::user()->shop_image ? asset('assets/images/vendorbanner/'.Auth::user()->shop_image ):asset('assets/images/noimage.png') }}" style="width:300px;">
														<input type="file" class="input-field" name="shop_image">
													</div>
												</div>
												
												
												<div class="row">
													<div class="col-lg-4">
														<div class="left-area">
																<h4 class="heading">{{ __('Country') }} *</h4>
														</div>
													</div>
													<div class="col-lg-7">
														<select class="form-control" name="country" id="country" disabled="disabled">
														<option value="">{{ $langg->lang157 }}</option>
@if(Auth::check())
	@foreach (DB::table('countries')->get() as $datas)
	<option data-href="{{ route('front-state-load',$datas->id) }}" value="{{ $datas->name }}" {{ Auth::user()->country == $datas->name ? 'selected' : '' }}>{{ $datas->name }}</option>		
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
														<select class="form-control" name="state" id="state" disabled="disabled">
														@if($data->state)
															<option value="{{ $data->state }}">{{ $data->state }}</option>
															@else
														<option value="">{{ __('Select State') }}</option>
													@endif
													</select>
													</div>
												</div>

						                        <div class="row">
						                          <div class="col-lg-4">
						                            <div class="left-area">
						                              
						                            </div>
						                          </div>
						                          <div class="col-lg-7">
						                            <button class="addProductSubmit-btn" type="submit">{{ $langg->lang464 }}</button>
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