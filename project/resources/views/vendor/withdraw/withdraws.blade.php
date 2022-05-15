@extends('layouts.vendor') 

@section('content')  
                    <input type="hidden" id="headerdata" value="{{ __("WITHDRAW") }}">
                    <div class="content-area">
                        <div class="mr-breadcrumb">
                            <div class="row">
                                <div class="col-lg-12">
                                        <h4 class="heading">{{ __("Withdraws") }}</h4>
                                        <ul class="links">
                                            <li>
                                                <a href="{{ route('vendor-dashboard') }}">{{ __("Dashboard") }} </a>
                                            </li>
                                            <li>
                                                <a href="javascript:;">{{ __("Vendors") }}</a>
                                            </li>
                                            <li>
                                                <a href="{{ route('vendor-withdraws-index') }}">{{ __("Withdraws") }}</a>
                                            </li>
                                        </ul>
                                </div>
                            </div>
                        </div>
                        <div class="product-area">
                            
                                <div class="row">
                                <div class="col-lg-12">
                                    <div class="mr-table allproduct">
                                        @include('includes.vendor.form-success') 
                                        <div class="table-responsiv">
                                            
                                            <div class="row">		
                    							<div class="form-group col-md-2">                               
                                                    <select name="statuswwithdraw" id="statuswwithdraw">
                                                        <option value=''>--Select Option-- </option>
                                                        <option value="pending">Requested</option>
                    									<option value="rejected">Rejected</option>
                    									<option value="completed">Completed</option>								
                                                    </select>                                
                                                </div>
                                                <div class="text-left" >
                                                    <button type="text" id="btnFiterSubmitSearch" class="btn btn-info">Submit</button>
                                                    <button type="text" id="btnFiterReset" class="btn btn-danger">Reset</button>
                                                     <a href="{{ route('withdraws-excel-file',['status'=>'none']) }}" class="btn btn-warning" >Requested Export EXCEL</a>
                                                </div>
                                            </div>
                                            
                                            
                                            
                                            
                                                <table id="geniustable" class="table table-hover dt-responsive" cellspacing="0" width="100%">
                                                    <thead>
                                                        <tr>
                                                            <th>{{ __("Withdraw ID") }}</th>
                                                            <th>{{ __("Email") }}</th>
                                                            <!--th>{{ __("Vendor") }}</-->
                                                            <th>{{ __("Phone") }}</th>
                                                            <th>{{ __("Amount") }}</th>
                                                            <th>{{ __("Order") }}</th>
                                                            <th>{{ __("Date") }}</th>
                                                            <th>{{ __("Status") }}</th>
                                                            <th>{{ __("Options") }}</th>
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
                  url: "{{ route('vendor-withdraws-datatables') }}",
                  type: 'GET',
                  data: function (d) {
					d.statuswwithdraw         = $('#statuswwithdraw').val();
                  }
                 },
               columns: [
                        { data: 'id', name: 'id' },
                        { data: 'email', name: 'email' },
                        /*{ data: 'shop_name', name: 'shop_name' },*/
                        { data: 'phone', name: 'phone' },
                        { data: 'amount', name: 'amount' },
                        { data: 'group_order_id', name: 'group_order_id' },
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
                  	$('#btnFiterSubmitSearch').click(function(){
             $('#geniustable').DataTable().draw(true);
          });    
        

    </script>
	<script>    
        $('#btnFiterReset').click(function(){window.location.reload();});   
		$(document).ready(function(){$(".referesh-btn").click(function(){location.reload(true);});});
	</script>
{{-- DATA TABLE --}}
    
@endsection   