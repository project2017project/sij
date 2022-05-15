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
						@include('includes.admin.form-success') 
						<div class="table-responsiv">
							<table id="geniustable" class="table table-hover dt-responsive" cellspacing="0" width="100%">
								<thead>
									<tr>
									    	                               
									    	                                <th>Withdraw ID</th>
	                                <th> Request Date</th>
	                                <th>Orders</th>
	                                <th>{{ $langg->lang476 }}</th>
	                                <th>{{ $langg->lang477 }}</th>
								<th>{{ _('Admin fees (₹)') }}</th>
									<th>{{ _('SGST (₹)') }}</th>
									<th>{{ _('CGST (₹)') }}</th>
									<th>{{ _('IGST (₹)') }}</th>
									<th>{{ _('TCS (₹)') }}</th>
									<th>{{ _('Net Payment (₹)') }}</th>
									<th>{{ _('Settle Amount (₹)') }}</th>
									<th>{{ _('Debit Note(₹)') }}</th>
									<th>{{ _('Credit Note (₹)') }}</th>
	                                <th>{{ $langg->lang478 }}</th>
									</tr>
								</thead>

								<tbody>
		                            @foreach($withdraws as $withdraw)
									 @php
									                   $order = App\Models\Order::find($withdraw->group_order_id);                                                       
													   $bankdetails= 'Name:- '.$user->account_holder_name	.'Account No:- '.$user->account_number.' IFSC Code'.$user->ifsc_code;
													   $state=$user->state;
													   $gst_number=$user->reg_number;
													   
											   $withdrawid = $withdraw->id;
													   
										$debitamt = App\Models\DebitNote::where('vendor_id','=',$user->id)->where('withdraw_id','=',$withdrawid)->orderBy('id','desc')->sum('amount');
											
											
											$creditamt = App\Models\CreditNote::where('vendor_id','=',$user->id)->where('withdraw_id','=',$withdrawid)->orderBy('id','desc')->sum('amount');		   
													   
                                      @endphp

									  
		                                <tr>
		                                    <td>#{{$withdraw->id}}</td>
		                                    <td>{{date('d-M-Y',strtotime($withdraw->created_at))}}</td>
		                                    <td>{{$withdraw->group_order_id}}</td>
		                                    @if($withdraw->method != "Bank")
		                                        <td>{{$withdraw->acc_email}}</td>
		                                    @else
		                                        <td>{{$withdraw->iban}}</td>
		                                    @endif
		                                    <td>{{$sign->sign}}{{ $withdraw->withdrawal_amount}}</td>
											<td>{{round($withdraw->fee, 2)}}</td>
											<td>{{$withdraw->sgst}}</td>
											<td>{{$withdraw->cgst}}</td>
											<td>{{$withdraw->igst}}</td>
											<td>{{$withdraw->tcs}}</td>
											<td>{{$sign->sign}}{{$withdraw->amount}}</td>
											@if($withdraw->settle_amount)
											<td>{{$sign->sign}} {{$withdraw->settle_amount}}</td>
										    @else
											<td>-</td>
										    @endif
											@if($withdraw->debit_note_id)
											<td>{{$debitamt}} (#{{$withdraw->debit_note_id}})</td>
										    @else
											<td>-</td>
										   @endif
											@if($withdraw->credit_note_id)
											<td>{{$creditamt}} (#{{$withdraw->credit_note_id}})</td>
										    @else
											<td>-</td>
										   @endif
		                                    <td>{{ucfirst($withdraw->status)}}</td>
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