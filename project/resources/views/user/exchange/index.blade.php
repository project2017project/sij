@extends('layouts.front')
@section('content')


<section class="user-dashbord">
    <div class="container">
      <div class="row">
        @include('includes.user-dashboard-sidebar')
        <div class="col-lg-8">
					<div class="user-profile-details">
						<div class="order-history">
							<div class="header-area">
								<h4 class="title">
									{{ $langg->lang277 }}
								</h4>
							</div>
							<div class="mr-table allproduct mt-4">
									<div class="table-responsiv">
											<table id="example" class="table table-hover dt-responsive" cellspacing="0" width="100%">
												<thead>
													<tr>
									<th>{{ __('Exchange Id') }}</th>									
                                    <th>{{ __('Vendor Name') }}</th>
									<th>{{ __('Order Id') }}</th>
                                    <th>{{ __('Product Name') }}</th>
                                    <th>{{ __('Product SKU') }}</th>
									<th>{{ __('Status') }}</th>
									<th>{{ __('Exchange Date') }}</th>
									<th>{{ __('Options') }}</th>
								</tr>
												</thead>
												<tbody>
													 @foreach($exchange as $exchanges)
													@php
									  $users =  App\Models\User::where('id','=',$exchanges->vendor_id)->orderBy('id','desc')->first();							      
								@endphp
								@php
									  $vendor_data =  App\Models\VendorOrder::where('order_id','=',$exchanges->order_id)->where('other_status','!=','')->orderBy('id','desc')->first();							      
								@endphp
								@if($vendor_data)
													<tr>
													<td>{{$exchanges->id}}</td>
													<td>{{$users->name}}</td>
													<td>{{$exchanges->order_id}}</td>
													<td>{{$exchanges->product_name}}</td>
													<td>{{$exchanges->product_sku}}</td>
													<td>{{ucwords($exchanges->status)}}</td>
													<td>{{$exchanges->created_at}}</td>
															<td>
															<a class="mybtn2 sm" href="{{route('user-exchanges',$exchanges->id)}}">
																	{{ __('Details') }}
															</a>
														</td>
													</tr>
													@endif
													@endforeach
												</tbody>
											</table>
									</div>
								</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
@endsection