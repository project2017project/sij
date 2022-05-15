@extends('layouts.admin') 

@section('content')  
					<input type="hidden" id="headerdata" value="{{ __('CURRENCY') }}">
					<div class="content-area">
						<div class="mr-breadcrumb">
							<div class="row">
								<div class="col-lg-12">
										<h4 class="heading">{{ __('Update Shipping Rate') }}</h4>
										<ul class="links">
											<li>
												<a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }} </a>
											</li>

						                      <li>
						                        <a href="javascript:;">{{ __('General Settings') }}</a>
						                      </li>
											
											<li>
												<a href="{{ route('admin-manageshipping-index') }}">{{ __('Shipping Rate') }}</a>
											</li>											
										</ul>
								</div>
							</div>
						</div>
						<div class="product-area">
							<div class="row">
								<div class="col-lg-12">
								 
									<div class="mr-table allproduct">

                        
										<div class="table-responsiv">
										<form id="shippingform" action="{{route('admin-manageshipping-update')}}" method="POST" enctype="multipart/form-data">
										{{csrf_field()}}
										@include('includes.admin.form-success') 
                                        @include('includes.admin.form-error')
												<table id="geniustable" class="table table-hover dt-responsive" cellspacing="0" width="100%">
													<thead>
														<tr>
									                        <th>{{ __('Shipping Value(Product)') }}</th>
									                        <th>{{ __('Shipping Rate') }}</th>									                        
														</tr>
													</thead>
													<tbody>
													<?php foreach($manageshippings as $manageshipping) { ?>
						<tr>		
				<td><input type="text" name="sh_value[]" placeholder="Shipping Value(<?php echo $manageshipping->shiping_value; ?>)" value="<?php echo $manageshipping->shiping_value; ?>" readonly></td>
				   
				<td><input type="text" name="sh_rate[]" placeholder="{{ __('Shipping Rate') }}" value="<?php echo $manageshipping->shiping_rate; ?>"></td>														
				</tr>
				<input type ="hidden" name="sh_id[]" value="<?php echo $manageshipping->id; ?>">
													<?php } ?>
												</tbody>
												</table>
												<input type ="hidden" name="sh_tot" value="<?php echo count($manageshippings); ?>">
												<button type="submit" class="btn btn-success referesh-btn" name="save">Submit</button>
												</form>
												
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
@endsection    
  