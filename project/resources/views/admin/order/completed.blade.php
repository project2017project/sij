@extends('layouts.admin') 
@section('styles')
<style type="text/css">.input-field { padding: 15px 20px; }</style>
@endsection
@section('content')  
<input type="hidden" id="headerdata" value="{{ __('ORDER') }}">
<div class="content-area">
	<div class="mr-breadcrumb">
		<div class="row">
			<div class="col-lg-12">
				<h4 class="heading">{{ __('Completed Orders') }}</h4>
				<ul class="links">
					<li><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }} </a></li>
					<li><a href="javascript:;">{{ __('Orders') }}</a></li>
					<li><a href="{{ route('admin-order-completed') }}">{{ __('All Completed Orders') }}</a></li>
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
						<div class="row" style="padding-top : 20px; background : #eeeeee;">				                                                                     
                                   
                                   
                                   <div class ="col-sm-10">
                                       
                                   <div class="row">
                                                    
							<div class="form-group col-md-3">                               
                                <select name="svendor" id="svendor">
                                    <option value=''>--Select Any Vendor-- </option>
                                    @foreach($users as $userid)
                                    <option value="{{$userid->id}}">{{$userid->shop_name}}</option>
                                    @endforeach                                        
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
						<form id="geniusstatus" style="min-width : 100%;" class="form-horizontal" action="{{route('admin-order-status-update')}}" method="POST" enctype="multipart/form-data">
										{{csrf_field()}}	
						<table id="geniustable" class="table table-hover dt-responsive" cellspacing="0" width="100%">
							<thead>
								<tr>
									<th>{{ __('Order Id') }}</th>
									<th>{{ __('Customer Name') }}</th>
									<th>{{ __('Vendor Name') }}</th>									
									<th>{{ __('Total Qty') }}</th>
									<th>{{ __('Total Cost') }}</th>
									<th>{{ __('Payment') }}</th>
									<th>{{ __('Order Date') }}</th>
									<th>{{ __('Options') }}</th>
								</tr>
							</thead>
						</table>					
						
						
						 <div class="modal" id="model-status" tabindex="-1" role="dialog" aria-labelledby="model-statuslevel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="model-statuslevel">{{ __('Order Status') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
				<div class="modal-body">
					<div class="container-fluid p-0">
						<div class="row">
							<div class="col-md-12">
								<div class="contact-form">									
																		

                        <div class="row">
                          <div class="col-lg-4">
                            <div class="left-area">
                                <h4 class="heading">Order Status *</h4>
                            </div>
                          </div>                         
                          <div class="col-lg-7">
                              <select name="status" required="" required>
							  <option value="">Please select status</option>
                                <option value="pending">Pending</option>
                                <option value="processing">Processing</option>
                                <option value="on delivery">On Delivery</option>
                                <option value="completed">Completed</option>
                                <option value="declined">Declined</option>
                              </select>
                          </div>
                        </div>


                        <div class="row">
                          <div class="col-lg-4">
                            <div class="left-area">
                              
                            </div>
                          </div>
                          <div class="col-lg-7">
                            <button class="addProductSubmit-btn" type="submit">Save</button>
                          </div>
                        </div>
						
								</div>
							</div>
						</div>
					</div>
				</div>
            </div>
        </div>
    </div>
	</form>	
	</div>
				</div>
			</div>
		</div>
	</div>
</div>
{{-- ORDER MODAL --}}
<div class="modal fade" id="confirm-delete1" tabindex="-1" role="dialog" aria-labelledby="modal1" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="submit-loader"><img  src="{{asset('assets/images/'.$gs->admin_loader)}}" alt=""></div>
			

			<div class="modal-header d-block text-center">
				<h4 class="modal-title d-inline-block">{{ __('Update Status') }}</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<!-- Modal body -->
			<div class="modal-body">
				<p class="text-center">{{ __("You are about to update the order's Status.") }}</p>
				<p class="text-center">{{ __('Do you want to proceed?') }}</p>
				<input type="hidden" id="t-add" value="{{ route('admin-order-track-add') }}">
				<input type="hidden" id="t-id" value="">
				<input type="hidden" id="t-title" value="">
				<textarea class="input-field" placeholder="Enter Your Tracking Note (Optional)" id="t-txt"></textarea>
			</div>
			<!-- Modal footer -->
			<div class="modal-footer justify-content-center">
				<button type="button" class="btn btn-default" data-dismiss="modal">{{ __('Cancel') }}</button>
				<a class="btn btn-success btn-ok order-btn">{{ __('Proceed') }}</a>
			</div>
		</div>
	</div>
</div>

{{-- ORDER MODAL ENDS --}}



{{-- MESSAGE MODAL --}}
<div class="sub-categori">
    <div class="modal" id="vendorform" tabindex="-1" role="dialog" aria-labelledby="vendorformLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="vendorformLabel">{{ __('Send Email') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
				<div class="modal-body">
					<div class="container-fluid p-0">
						<div class="row">
							<div class="col-md-12">
								<div class="contact-form">
									<form id="emailreply">
										{{csrf_field()}}
										<ul>
											<li><input type="email" class="input-field eml-val" id="eml" name="to" placeholder="{{ __('Email') }} *" value="" required=""></li>
											<li><input type="text" class="input-field" id="subj" name="subject" placeholder="{{ __('Subject') }} *" required=""></li>
											<li><textarea class="input-field textarea" name="message" id="msg" placeholder="{{ __('Your Message') }} *" required=""></textarea></li>
										</ul>
										<button class="submit-btn" id="emlsub" type="submit">{{ __('Send Email') }}</button>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
            </div>
        </div>
    </div>
</div>

{{-- MESSAGE MODAL ENDS --}}

{{-- ADD / EDIT MODAL --}}

<div class="modal fade" id="modal1" tabindex="-1" role="dialog" aria-labelledby="deliverymodal1" aria-hidden="true">						
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


<!--<div class="modal fade" id="refundpopup" tabindex="-1" role="dialog" aria-labelledby="refundpopup" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">

    <div class="modal-header d-block text-center">
        <h4 class="modal-title d-inline-block">{{ __("Update Status") }}</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
    </div>

      Modal body 
      <div class="modal-body">
            <p class="text-center">{{ __("You are about to change the status.") }}</p>
            <p class="text-center">{{ __("Do you want to proceed?") }}</p>
      </div>

       Modal footer 
      <div class="modal-footer justify-content-center">
            <button type="button" class="btn btn-default" data-dismiss="modal">{{ __("Cancel") }}</button>
            <a class="btn btn-success btn-ok">{{ __("Update") }}</a>
      </div>

    </div>
  </div>
</div>-->



{{-- ADD / EDIT MODAL ENDS --}}



@endsection    

@section('scripts')

{{-- DATA TABLE --}}

<script type="text/javascript">

	var table = $('#geniustable').DataTable({
		   ordering: false,
		   processing: true,
		   serverSide: true,
		   
		   ajax: {
                  url: "{{ route('admin-complet-datatables','completed') }}",
                  type: 'GET',
                  data: function (d) {
           
					d.svendor          = $('#svendor').val();
					d.enddateis          = $('#enddateis').val();
					d.startdateis          = $('#startdateis').val();

                  }
                 },
		   columns: [
					{ data: 'number', name: 'number' },
					{ data: 'customer_name', name: 'customer_name' },
					{ data: 'vendor_name', name: 'vendor_name' },					
					{ data: 'totalQty', name: 'totalQty' },
					{ data: 'pay_amount', name: 'pay_amount' },
					{ data: 'payment_status', name: 'payment_status' },
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
$("#checkAll").click(function () {$('input:checkbox').not(this).prop('checked', this.checked);}); 		  
</script>
<script type="text/javascript">

$(document).on('click','.refund',function(){
  var href = $(this).attr('href');
});


</script>
{{-- DATA TABLE --}}
@endsection   