@extends('layouts.admin')
@section('content')  
<div class="content-area">
	<div class="mr-breadcrumb">
		<div class="row">
			<div class="col-lg-12">
				<h4 class="heading">{{ __('Ship Rto') }}</h4>
				<ul class="links">
					<li><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }} </a></li>
					<li><a href="javascript:;">{{ __('Ship Rto') }}</a></li>					
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
									<th>{{ __('Rto Id') }}</th>									
                                    <th>{{ __('Vendor Name') }}</th>
									<th>{{ __('Order Id') }}</th>
                                    <th>{{ __('Product Name') }}</th>
                                    <th>{{ __('Product SKU') }}</th>
									<!--th>{{ __('Amount') }}</th-->
									<th>{{ __('Quantity') }}</th>									
                                    <th>{{ __('Courier Partner Name') }}</th>
                                    <th>{{ __('Track Code') }}</th>
									<th>{{ __('Track URL') }}</th>
									<th>{{ __('Rto Date') }}</th>
									<th>{{ __('Options') }}</th>
								</tr>
							</thead>
						</table>
	
				</div>
				</div>
			</div>
		</div>
	</div>
</div>

{{-- Accept MODAL --}}

<div class="modal fade" id="modalaccept" tabindex="-1" role="dialog" aria-labelledby="modalaccept" aria-hidden="true">						
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="submit-loader"><img  src="{{asset('assets/images/'.$gs->admin_loader)}}" alt=""></div>
			<div class="modal-header">
				<h5 class="modal-title"></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body"></div>
			<div class="modal-footer"><button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button></div>
		</div>
	</div>
</div>

{{-- Accept MODAL ENDS --}}

{{-- Not Delivered MODAL --}}

<div class="modal fade" id="modaldel" tabindex="-1" role="dialog" aria-labelledby="modaldel" aria-hidden="true">						
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="submit-loader"><img  src="{{asset('assets/images/'.$gs->admin_loader)}}" alt=""></div>
			<div class="modal-header">
				<h5 class="modal-title"></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body"></div>
			<div class="modal-footer"><button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button></div>
		</div>
	</div>
</div>

{{-- Not Delivered MODAL ENDS --}}

@endsection    

@section('scripts')

{{-- DATA TABLE --}}

<script type="text/javascript">

	var table = $('#geniustable').DataTable({
		   ordering: false,
		   processing: true,
		   serverSide: true,
		   
		   ajax: {
                  url: "{{ route('admin-load-ship-rto','none') }}",
                  type: 'GET',
                  data: function (d) {    
					

                  }
                 },
		   columns: [
					{ data: 'id', name: 'id' },
					{ data: 'vendor_id', name: 'vendor_id' },
					{ data: 'order_id', name: 'order_id' },
					{ data: 'product_name', name: 'product_name' },
					{ data: 'product_sku', name: 'product_sku' },
					//{ data: 'amount', name: 'amount' },
					{ data: 'quantity', name: 'quantity' },                   
				   { data: 'courier_name', name: 'courier_name' },
                   { data: 'track_code', name: 'track_code' },
				   { data: 'track_url', name: 'track_url' }, 
                   { data: 'created_at', name: 'created_at' },				   
				   { data: 'action', searchable: false, orderable: false }
										
					
				 ],
		
		   language : {
				processing: '<img src="{{asset('assets/images/'.$gs->admin_loader)}}">'
			},
			drawCallback : function( settings ) {
					$('.select').niceSelect();  
			}
		});				
		  
</script>
{{-- DATA TABLE --}}
@endsection   