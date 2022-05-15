@extends('layouts.admin') 
@section('content')  
	<input type="hidden" id="headerdata" value="{{ __('ORDER') }}">	
	<div class="content-area">
		<div class="mr-breadcrumb">
			<div class="row">
				<div class="col-lg-12">
					<h4 class="heading">{{ __('Refund Orders') }}</h4>
					<ul class="links">
						<li><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }} </a></li>
						<li><a href="javascript:;">{{ __('Orders') }}</a></li>
						<li><a href="{{ route('admin-refund-index') }}">{{ __('Refund Orders') }}</a></li>
					</ul>
				</div>
			</div>
		</div>
		<div class="product-area">
			<div class="row">
				<div class="col-lg-12">
					<div class="mr-table allproduct">
						@include('includes.admin.form-success') 
						<div class="table-responsiv">
							<div class="row">				                                                                     
                            <div class="form-group col-md-4">
                                <select id="statusare" name="status" required="">
                                    <option value="">{{ __('Select Status') }}</option>                                   
                                    <option value="requested">Requested</option>
                                    <option value="accept">Approved</option>
                                    <option value="decline">Decline</option>                                   
                                </select>
                            </div>
                                                    
							<div class="form-group col-md-4">                               
                                <select name="svendor" id="svendor">
                                    <option value=''>--Select Any Vendor-- </option>
                                    @foreach($users as $userid)
                                    	<option value="{{$userid->id}}">{{$userid->shop_name}}</option>
                                    @endforeach                                        
                                </select>                                
                            </div>
                            <div class="text-left" >
                                <button type="text" id="btnFiterSubmitSearch" class="btn btn-info">Submit</button>
                                <button type="text" id="btnFiterReset" class="btn btn-info">Reset</button>
                            </div>
                        </div>
						<div class="gocover" style="background: url({{asset('assets/images/'.$gs->admin_loader)}}) no-repeat scroll center center rgba(45, 45, 45, 0.5);"></div>
							<table id="geniustable" class="table table-hover dt-responsive" cellspacing="0" width="100%">
								<thead>
									<tr>
										<th>{{ __('ID') }}</th>
										<th>{{ __('Image') }}</th>
										<th>{{ __('orderId') }}</th>
										<th>{{ __('Vendor Name') }}</th>
										<th>{{ __('Amount') }}</th>
										<th>{{ __('Product Name') }}</th>
										<th>{{ __('Reason') }}</th>
										<th>{{ __('admin Message') }}</th>
										<th>{{ __('Status') }}</th>
										<th>{{ __('Customer Name') }}</th>
										<th>{{ __('Date') }}</th>
										<th>{{ __('Action') }}</th>
									</tr>
								</thead>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	{{-- Add Message MODAL --}}
<div class="modal fade" id="modal3" tabindex="-1" role="dialog" aria-labelledby="modal3" aria-hidden="true">
    <div class="modal-dialog modal-lg quickedit" role="document">
        <div class="modal-content">
            <div class="submit-loader"><img  src="{{asset('assets/images/'.$gs->admin_loader)}}" alt=""></div>
        	<div class="modal-header">
        	    <h5 class="modal-title"></h5>
            	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        	</div>
        	<div class="modal-body">
        
        	</div>
        	<div class="modal-footer">
        	    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __("Close") }}</button>
        	</div>
        </div>
    </div>
</div>
{{-- Add Message ENDS --}}
@endsection    
@section('scripts')
<script type="text/javascript">
        var table = $('#geniustable').DataTable({
               ordering: false,
               processing: true,
               serverSide: true,
              
                ajax: {
                  url: "{{ route('admin-refund-datatables') }}",
                  type: 'GET',
                  data: function (d) {
                    d.statusare      = $('#statusare').val();
                   	d.svendor        = $('#svendor').val();

                  }
                 },
               columns: [
                        { data: 'id', name: 'id' },
                        { data: 'image', name: 'image' },
                        { data: 'orderId', name: 'orderId' },
						{ data: 'soldby', name: 'soldby' },
						{ data: 'amount', name: 'amount' },
                        { data: 'product_id', name: 'product_id' },
                        { data: 'reason', name: 'reason' },
                        { data: 'adminMessage', name: 'adminMessage' },
                        { data: 'statusare',name: 'statusare'},
						{ data: 'customerName', name: 'customerName' },
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
        $('#btnFiterSubmitSearch').click(function(){
             $('#geniustable').DataTable().draw(true);
          });
          $('#btnFiterReset').click(function(){window.location.reload();});                                                       
    </script>
{{-- DATA TABLE --}}
@endsection   