@extends('layouts.admin')
@section('content')  
<div class="content-area">
	<div class="mr-breadcrumb">
		<div class="row">
			<div class="col-lg-12">
				<h4 class="heading">{{ __('Reject List') }}</h4>
				<ul class="links">
					<li><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }} </a></li>
					<li><a href="javascript:;">{{ __('Reject List') }}</a></li>					
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
									<th>{{ __('Id') }}</th>									
                                    <th>{{ __('Code') }}</th>
									<th>{{ __('Order Id') }}</th>
                                    <th>{{ __('Email Address') }}</th>                                    
									<th>{{ __('Amount') }}</th>
									<th>{{ __('Start Date') }}</th>
									<th>{{ __('End Date') }}</th>									
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
                  url: "{{ route('admin-load-rejectlist','none') }}",
                  type: 'GET',
                  data: function (d) {    
					

                  }
                 },
		   columns: [
					{ data: 'id', name: 'id' },
					{ data: 'code', name: 'code' },
					{ data: 'order_id', name: 'order_id' },
					{ data: 'email_address', name: 'email_address' },
					{ data: 'price', name: 'price' },					
					{ data: 'start_date', name: 'start_date' },
                   { data: 'end_date', name: 'end_date' }
				   
										
					
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