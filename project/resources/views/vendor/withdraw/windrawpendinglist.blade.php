@extends('layouts.vendor') 
@section('content')
	<div class="content-area">
		<div class="mr-breadcrumb">
			<div class="row">
				<div class="col-lg-12">
					<h4 class="heading">{{ $langg->lang472 }}</h4>
					<ul class="links">
						<li><a href="{{ route('vendor-dashboard') }}">{{ $langg->lang441 }} </a></li>
						<li><a href="{{ route('vendor-wt-index') }}">{{ $langg->lang472 }}</a></li>
					</ul>
				</div>
			</div>
		</div>
		<div class="product-area">
			<div class="row">
				<div class="col-lg-12">
					<div class="mr-table allproduct">
						 
						<div class="table-responsiv">
							<table id="geniustable" class="table table-hover dt-responsive" cellspacing="0" width="100%">
								<thead>
									<tr>
										<th>{{ __("Vendor Name") }}</th>
										<th>{{ __("Order Id") }}</th>
										<th>{{ __("Price") }}</th>
									</tr>
								</thead>
								<tbody>
		                            @foreach($withdraws as $withdraw)
		                                <tr>
		                                    <td>{{$withdraw->user->name}}</td>
											@php
                                                $vdata = App\Models\VendorOrder::find($withdraw->order_id);
                                                @endphp
		                                    <td><a href="{{ route('vendor-order-vshow',$vdata->order_number)}}">{{ $withdraw->order_id }}</a></td>
		                                   
		                                    <td>{{ucfirst($withdraw->price)}}</td>
		                                </tr>
		                            @endforeach
								</tbody>	
														
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection    
@section('scripts')

{{-- DATA TABLE --}}


    <script type="text/javascript">

		var table = $('#geniustable').DataTable({
			ordering:false
		});

  									
    </script>

{{-- DATA TABLE --}}
    
@endsection   