@extends('layouts.admin')
@section('content')  
<div class="content-area">
	<div class="mr-breadcrumb">
		<div class="row">
			<div class="col-lg-12">
				<h4 class="heading">{{ __('Complete Exchange') }}</h4>
				<ul class="links">
					<li><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }} </a></li>
					<li><a href="javascript:;">{{ __('Complete Exchange') }}</a></li>					
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
									<th>{{ __('Exchange Id') }}</th>									
                                    <th>{{ __('Vendor Name') }}</th>
									<th>{{ __('Order Id') }}</th>
                                    <th>{{ __('Product Name') }}</th>
                                    <th>{{ __('Product SKU') }}</th>
									<!--th>{{ __('Amount') }}</th-->
									<th>{{ __('Quantity') }}</th>
									<th>{{ __('Exchange Date') }}</th>									
								</tr>
							</thead>
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
		   ordering: false,
		   processing: true,
		   serverSide: true,
		   
		   ajax: {
                  url: "{{ route('admin-load-resolved-exchange','none') }}",
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
                   { data: 'created_at', name: 'created_at' }									
					
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