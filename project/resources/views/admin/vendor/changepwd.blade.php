@extends('layouts.load')
@section('content')

						<div class="content-area">
							<div class="add-product-content1">
								<div class="row">
									<div class="col-lg-12">
										<div class="product-description">
											<div class="body-area">											
                                             @include('includes.admin.form-both')											
											<form id="geniusformdata" action="{{ route('vendor.password.update',$data->id) }}" method="POST" enctype="multipart/form-data">
												{{csrf_field()}}
												<div class="row">
													<div class="col-lg-4">
														<div class="left-area">
																<h4 class="heading">{{ __('New Password') }} *</h4>
														</div>
													</div>
													<div class="col-lg-7">
														<input type="password" class="input-field" name="newpass" placeholder="Enter New Password" required="" value="">
													</div>
												</div>

												<div class="row">
													<div class="col-lg-4">
														<div class="left-area">
																<h4 class="heading">{{ __('Re-Type New Password') }} *</h4>
														</div>
													</div>
													<div class="col-lg-7">
														<input type="password" class="input-field" name="renewpass" placeholder="{{ __('Re-Type New Password') }}" required="" value="">
													</div>
												</div>
                                                <input type="hidden" name="user_id" value="{{ $data->id }}">

												<div class="row">
													<div class="col-lg-4">
														<div class="left-area">
															
														</div>
													</div>
													<div class="col-lg-7">
														<button class="addProductSubmit-btn" type="submit">{{ __('save') }}</button>
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