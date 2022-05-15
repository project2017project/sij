@extends('layouts.admin')
@section('content')  
<div class="content-area">
	<div class="mr-breadcrumb">
		<div class="row">
			<div class="col-lg-12">
				<h4 class="heading">{{ __('Pending Refunds') }}</h4>
				<ul class="links">
					<li><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }} </a></li>
					<li><a href="javascript:;">{{ __('Pending Refunds') }}</a></li>					
				</ul>
			</div>
			<div class="col-xs-12 col-sm-12 col-md-2"> 
      <a href="{{ route('raisedispute-excel-file',['status'=>'none']) }}" class="btn btn-info" >Export</a>
      </div>
	   <div class ="col-sm-10">
                                       
                                   <div class="row">                                                   
							
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
	</div>
	<div class="product-area">
		<div class="row">
			<div class="col-lg-12">
				<div class="mr-table allproduct">					 
					<div class="table-responsiv">
					<form id="geniusstatus" style="min-width : 100%;" class="form-horizontal" action="{{route('admin-load-open-dispute')}}" method="POST" enctype="multipart/form-data">
										{{csrf_field()}}
						<table id="geniustable" class="table table-hover dt-responsive" cellspacing="0" width="100%">
							<thead>
								<tr>
									<th>{{ __('Refund Id') }}</th>									
                                    <th>{{ __('Vendor Name') }}</th>
									<th>{{ __('Order Id') }}</th>
                                    <th>{{ __('Product Name') }}</th>
                                    <th>{{ __('Product SKU') }}</th>
									<th>{{ __('Amount') }}</th>
									<th>{{ __('Quantity') }}</th>
									<th>{{ __('Refund Date') }}</th>
									<th>{{ __('Options') }}</th>
								</tr>
							</thead>
						</table>
	                    </form>
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
                  url: "{{ route('admin-load-open-dispute','none') }}",
                  type: 'GET',
                  data: function (d) {    
					d.enddateis          = $('#enddateis').val();
					d.startdateis          = $('#startdateis').val();

                  }
                 },
		   columns: [
					{ data: 'id', name: 'id' },
					{ data: 'vendor_id', name: 'vendor_id' },
					{ data: 'order_id', name: 'order_id' },
					{ data: 'product_name', name: 'product_name' },
					{ data: 'product_sku', name: 'product_sku' },
					{ data: 'amount', name: 'amount' },
					{ data: 'quantity', name: 'quantity' },
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
$('#btnFiterReset').click(function(){window.location.reload();});
			$('#btnFiterSubmitSearch').click(function(){
             $('#geniustable').DataTable().draw(true);
          });		
		  
</script>
{{-- DATA TABLE --}}
@endsection   