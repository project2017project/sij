@extends('layouts.admin')
@section('content')  
<div class="content-area">
	<div class="mr-breadcrumb">
		<div class="row">
			<div class="col-lg-12">
				<h4 class="heading">{{ __('List') }}</h4>
				<ul class="links">
					<li><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }} </a></li>
					<li><a href="javascript:;">{{ __('List') }}</a></li>					
				</ul>
			</div>
		</div>
	</div>
	<div class="product-area">
		<div class="row">
		 <div class="col-xs-12 col-sm-12 col-md-2"> 
      <a href="{{ route('all-coupon-code',['status'=>'none']) }}" class="btn btn-info" >ALL</a>
      </div>
      <div class="col-xs-12 col-sm-12 col-md-2"> 
      <a href="{{ route('used-coupon-code',['status'=>'none']) }}" class="btn btn-info" >Used CSV</a>
      </div>
	  <div class="col-xs-12 col-sm-12 col-md-2"> 
      <a href="{{ route('unused-coupon-code',['status'=>'none']) }}" class="btn btn-info" >Unused CSV</a>
      </div>
	  <div class="col-xs-12 col-sm-12 col-md-2"> 
      <a href="{{ route('expired-coupon-code',['status'=>'none']) }}" class="btn btn-info" >Expired CSV</a>
      </div>
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

<div class="modal fade" id="modalapprove" tabindex="-1" role="dialog" aria-labelledby="modalapprove" aria-hidden="true">					
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

{{-- Reject MODAL --}}

<div class="modal fade" id="modalreject" tabindex="-1" role="dialog" aria-labelledby="modalreject" aria-hidden="true">						
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

{{-- Reject MODAL ENDS --}}
@endsection    

@section('scripts')

{{-- DATA TABLE --}}

<script type="text/javascript">

	var table = $('#geniustable').DataTable({
		   ordering: false,
		   processing: true,
		   serverSide: true,
		   
		   ajax: {
                  url: "{{ route('admin-load-alllist','none') }}",
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
                   { data: 'end_date', name: 'end_date' },
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