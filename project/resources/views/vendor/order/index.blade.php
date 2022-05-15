@extends('layouts.vendor') 
@section('styles')
<style type="text/css">.input-field { padding: 15px 20px; }</style>
@endsection
@section('content')  
<input type="hidden" id="headerdata" value="{{ __('ORDER') }}">
<div class="content-area">
	<div class="mr-breadcrumb">
		<div class="row">
			<div class="col-lg-12">
				<h4 class="heading">{{ __('All Orders') }}</h4>
				<ul class="links">
					<li><a href="{{ route('vendor-dashboard') }}">{{ __('Dashboard') }} </a></li>
					<li><a href="javascript:;">{{ __('Orders') }}</a></li>
					<li><a href="{{ route('vendor-order-index') }}">{{ __('All Orders') }}</a></li>
				</ul>
			</div>
		</div>
	</div>
	<div class="product-area">
		<div class="row">
			<div class="col-lg-12">
				<div class="mr-table allproduct">
					@include('includes.vendor.form-success')
					@include('includes.form-success')
					<div class="table-responsiv">
						<div class="row" style="padding-top : 20px; background : #eeeeee;">				                                                                     
                                   
                                   
                                   <div class ="col-sm-12">
                                       
                                   <div class="row">
                                                    
							<div class="form-group col-md-3">                               
                                <select name="orderstatus" id="orderstatus">
                                    <option value=''>--Select Status-- </option>
								<!--	<option value='pending'>Pending</option>-->
									<option value='processing'>Processing</option>
									<option value='completed'>Completed</option>
								<!--	<option value='declined'>Declined</option>-->
									<option value='on delivery'>On Delivery</option>
                                                                           
                                </select>                                
                            </div>
							
                            <div class="form-group col-md-3">                               
                                <input type="date" name="start" id="startdateis" class="form-control">  
                                <em class="help-text">Start Date</em>
                            </div>
                            <div class="form-group col-md-3">                     
                                <input type="date" name="end" id="enddateis" class="form-control">
                                <em class="help-text">End Date</em>
                            </div>
                            <div class="text-left col-md-3" >
                                <button type="text" id="btnFiterSubmitSearch" class="btn btn-info">Submit</button>
                                <button type="text" id="btnFiterReset" class="btn btn-danger">Reset</button>
                            </div>
                            </div>
                            </div>
                            
                           
						
                    </div>
                        <br>
						<div class="gocover" style="background: url({{asset('assets/images/'.$gs->admin_loader)}}) no-repeat scroll center center rgba(45, 45, 45, 0.5);"></div>
							
						<table id="geniustable" class="table table-hover dt-responsive" cellspacing="0" width="100%">
							<thead>
								<tr>
									<th>{{ __('Order Number') }}</th>
									<th>{{ __('Customer Name') }}</th>  
									<th>{{ __('Billing Address') }}</th>
									<th>{{ __('Shipping Address') }}</th>
									<th>{{ __('Purchased') }}</th>
									<th>{{ __('Gross Sale') }}</th>																		
                                    <th>{{ __('Order Date') }}</th>									
									<th>{{ __('Status') }}</th>
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

{{-- ORDER MODAL --}}

<div class="modal fade" id="confirm-delete2" tabindex="-1" role="dialog" aria-labelledby="modal1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
    <div class="submit-loader">
        <img  src="{{asset('assets/images/'.$gs->admin_loader)}}" alt="">
    </div>
    <div class="modal-header d-block text-center">
        <h4 class="modal-title d-inline-block">{{ $langg->lang544 }}</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

      <!-- Modal body -->
      <div class="modal-body">
        <p class="text-center">{{ $langg->lang545 }}</p>
        <p class="text-center">{{ $langg->lang546 }}</p>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer justify-content-center">
            <button type="button" class="btn btn-default" data-dismiss="modal">{{ $langg->lang547 }}</button>
            <a class="btn btn-success btn-ok order-btn">{{ $langg->lang548 }}</a>
      </div>

    </div>
  </div>
</div>

{{-- ORDER MODAL ENDS --}}
{{-- ADD / EDIT MODAL --}}

<div class="modal fade" id="modal1" tabindex="-1" role="dialog" aria-labelledby="modal1" aria-hidden="true">
                        
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="submit-loader">
                    <img  src="{{asset('assets/images/'.$gs->admin_loader)}}" alt="">
            </div>
            <div class="modal-header">
            <h5 class="modal-title"></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
            </div>
        </div>
    </div>

</div>

{{-- ADD / EDIT MODAL ENDS --}}



@endsection    

@section('scripts')

{{-- DATA TABLE --}}

<script type="text/javascript">
$('.vendor-btn').on('change',function(){
          $('#confirm-delete2').modal('show');
          $('#confirm-delete2').find('.btn-ok').attr('href', $(this).val());

});


	var table = $('#geniustable').DataTable({
		   ordering: false,
		   processing: true,
		   serverSide: true,
		   
		   ajax: {
                  url: "{{ route('vendor-order-datatables','none') }}",
                  type: 'GET',
                  data: function (d) {
                    
					d.orderstatus          = $('#orderstatus').val();
					d.startdateis          = $('#startdateis').val();
					d.enddateis          = $('#enddateis').val();
					

                  }
                 },
		   columns: [
					{ data: 'number', name: 'number' },
					{ data: 'customer_name', name: 'customer_name' },
					{ data: 'billing_address', name: 'billing_address' },
					{ data: 'shipping_address', name: 'shipping_address' },
					{ data: 'totalQty', name: 'totalQty' },
					{ data: 'pay_amount', name: 'pay_amount' },					
                    { data: 'created_at', name: 'created_at' },                     					
					{ data: 'status', name: 'status' },	
					{ data: 'action', searchable: false, orderable: false }
				 ],
		
		   language : {
				processing: '<img src="{{asset('assets/images/'.$gs->admin_loader)}}">'
			},
			drawCallback : function( settings ) {
					$('.select').niceSelect();  
			}
		});
		$('#btnFiterReset').click(function(){window.location.reload();});
			$('#btnFiterSubmitSearch').click(function(){
             $('#geniustable').DataTable().draw(true);
          });	
		  
</script>
{{-- DATA TABLE --}}
@endsection   