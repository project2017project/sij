@extends('layouts.admin')
@section('content')
@php
$debitdata = 0;
$creditdata = 0;
@endphp  
@php
            $alldata = App\Models\VendorOrder::where('user_id','=',$withdraw->user->id)->where('admin_approve','=','approved')->whereIn('vendor_request_status',['NotRaised','rejected'])->orderBy('id','desc')->sum('price');
            @endphp
			@php
            $debitdata = App\Models\DebitNote::where('vendor_id','=',$withdraw->user->id)->where('status','=','0')->orderBy('id','desc')->sum('amount');
            @endphp
			@php
            $creditdata = App\Models\CreditNote::where('vendor_id','=',$withdraw->user->id)->where('status','=','0')->orderBy('id','desc')->sum('amount');
            @endphp
@php
$availabledata = $alldata + $creditdata - $debitdata;
@endphp 
<div class="content-area">
    <div class="mr-breadcrumb">
        <div class="row">
            <div class="col-lg-12">
                <h4 class="heading">{{ __('Withdraw Details') }} <a class="add-btn" href="javascript:history.back();"><i class="fas fa-arrow-left"></i> {{ __('Back') }}</a></h4>
                <ul class="links">
                    <li><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }} </a></li>
                    <li><a href="javascript:;">{{ __('Withdraw') }}</a></li>
                    <li><a href="javascript:;">{{ __('Withdraw Details') }}</a></li>
                </ul>
            </div>
        </div>
    </div>
	<div class="row row-cards-one">




                              

                            </div>

                        <div class="content-area no-padding">
                            <div class="add-product-content1">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="product-description">
                                            <div class="body-area">

                                    <div class="table-responsive show-table">
                                        <table class="table">
                                             <tr>
                                                <th>{{ __("Withdraw ID#") }}</th>
                                                <td>{{$withdraw->id}}</td>
                                            </tr>
                                            <tr>
                                                <th>{{ __("Vendor Name") }}</th>
                                                <td>
                                                    <a href="{{route('admin-user-show',$withdraw->user->id)}}" target="_blank">{{$withdraw->user->name}}</a>
                                                </td>
                                            </tr>
                                            
                                                <tr>
                                                
 <th>{{ __("Orders") }}</th>
                                                <td>
                                                    <a href="{{route('admin-user-show',$withdraw->user->id)}}" target="_blank">{{$withdraw->group_order_id}}</a>
                                                </td>
                                            </tr>
                                            
                                            <tr>
                                                <th>{{ __("Amount") }}</th>
                                                <td>{{$sign->sign}}{{ round($withdraw->withdrawal_amount * $sign->original_val , 2) }}</td>
                                            </tr>
                                            <tr>
                                                <th>{{ __("Admin Fee") }}</th>
                                                <td>{{$sign->sign}}{{ round($withdraw->fee * $sign->original_val , 2) }}</td>
                                            </tr>
											@if($withdraw->sgst)
											<tr>
                                                <th>{{ __("SGST") }}</th>
                                                <td>{{$withdraw->sgst}}</td>
                                            </tr>
											@endif
											@if($withdraw->cgst)
											<tr>
                                                <th>{{ __("CGST") }}</th>
                                                <td>{{$withdraw->cgst}}</td>
                                            </tr>
											@endif
											@if($withdraw->igst)
											<tr>
                                                <th>{{ __("IGST") }}</th>
                                                <td>{{$withdraw->igst}}</td>
                                            </tr>
											@endif
											@if($withdraw->tcs)
											<tr>
                                                <th>{{ __("TCS") }}</th>
                                                <td>{{$withdraw->tcs}}</td>
                                            </tr>
											@endif
											
											
											 @if($withdraw->total_debit_amount)
											<tr>
                                                <th>{{ __("Total Debit Amount") }}</th>
                                                <td>{{$withdraw->total_debit_amount}}</td>
                                            </tr>
											@endif
											 @if($withdraw->total_credit_amount	)
											<tr>
                                                <th>{{ __("Total Credit Amount") }}</th>
                                                <td>{{$withdraw->total_credit_amount	}}</td>
                                            </tr>
											@endif
											
											
											
											@php
			$alldata = $withdraw->amount;								
										
            
            $debitdata = $withdraw->total_debit_amount;
        
            
            $creditdata = $withdraw->total_credit_amount;
            
            @endphp
@php
$availabledata = $alldata + $creditdata - $debitdata;
@endphp 
											
											
											
											<tr>
                                                <th>{{ __("Net Payable") }}</th>
                                                <td>{{$availabledata}}</td>
                                            </tr>
											
                                            <tr>
                                                <th>{{ __("Withdraw Process Date") }}</th>
                                                <td>{{date('d-M-Y',strtotime($withdraw->created_at))}}</td>
                                            </tr>
                                            <tr>
                                                <th>{{ __("Withdraw Status") }}</th>
                                                <td>{{ucfirst($withdraw->status)}}</td>
                                            </tr>
                                            <tr>
                                                <th>{{ __("User Email") }}</th>
                                                <td>{{$withdraw->user->email}}</td>
                                            </tr>
                                            <tr>
                                                <th>{{ __("User Phone") }}</th>
                                                <td>{{$withdraw->user->phone}}</td>
                                            </tr>
                                            <tr>
                                                <th>{{ __("Withdraw Method") }}</th>
                                                <td>{{$withdraw->method}}</td>
                                            </tr>
											 @if($withdraw->comment)
											<tr>
                                                <th>{{ __("Reject Reason") }}</th>
                                                <td>{{$withdraw->comment}}</td>
                                            </tr>
											@endif
                                            @if($withdraw->method != "Bank")
                                            <tr>
                                                <th>{{$withdraw->method}} {{ __("Email") }}:</th>
                                                <td>{{$withdraw->acc_email}}</td>
                                            </tr>
                                            @else 
                                            <tr>
                                                <th>{{$withdraw->method}} {{ __("Account") }}:</th>
                                                <td>{{$withdraw->iban}}</td>
                                            </tr>
                                            <tr>
                                                <th>{{ __("Account Name") }}:</th>
                                                <td>{{$withdraw->acc_name}}</td>
                                            </tr>
                                            <tr>
                                                <th>{{ __("Country") }}</th>
                                                <td>{{ucfirst(strtolower($withdraw->country))}}</td>
                                            </tr>
                                            <tr>
                                                <th>{{ __("Address") }}</th>
                                                <td>{{$withdraw->address}}</td>
                                            </tr>
                                            <tr>
                                                <th>{{$withdraw->method}} {{__("Swift Code")}}:</th>
                                                <td>{{$withdraw->swift}}</td>
                                            </tr>
                                            @endif
											
                                        </table>
										
                                    </div>


                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
						<form id="acceptsform" class="form-horizontal" action="{{route('admin-vendor-withdraw-accept',$withdraw->id)}}" method="POST" enctype="multipart/form-data">      
						                                 {{ csrf_field() }}
					   <input type="hidden" class="form-control"  id="settle" name="settle" value="1">    
					   <div class="row">
                        <div class="col-lg-6">
                                 <input type="text" class="input-field" placeholder="{{ __('Settle Amount') }}" name="amount" required="">              
                        </div>                    
                        <div class="col-lg-6">
                            <input type="text" class="form-control" id="note" name="note" placeholder="{{ __('Note') }}" >
                    </div>

                   </div>
				   
				   
				   <div class="row">
										<div class="col-lg-12"><div class="left-area"><h4 class="heading">{{ __('Upload Screen Shot') }} </h4></div></div>
										<div class="col-lg-12"><input type="file" class="form-control" name="screenshot[]" placeholder="Upload Screen Shot" multiple></div>
									</div><br><br>
				   <div class="justify-content-center">
                     <p align="center"><button type="submit" id="acceptsform-btn" class="btn btn-success" name="save">Accept</button></p>
                   </div>
							                  </form>

@endsection