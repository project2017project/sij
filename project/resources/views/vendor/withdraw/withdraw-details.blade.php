@extends('layouts.vendor')
@section('content')
<div class="content-area">
    <div class="mr-breadcrumb">
        <div class="row">
            <div class="col-lg-12">
                <h4 class="heading">{{ __('Withdraw Details') }} <a class="add-btn" href="javascript:history.back();"><i class="fas fa-arrow-left"></i> {{ __('Back') }}</a></h4>
                <ul class="links">
                    <li><a href="{{ route('vendor-dashboard') }}">{{ __('Dashboard') }} </a></li>
                    <li><a href="javascript:;">{{ __('Withdraw') }}</a></li>
                    <li><a href="javascript:;">{{ __('Withdraw Details') }}</a></li>
                </ul>
            </div>
        </div>
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
                                                <th>{{ __("User ID#") }}</th>
                                                <td>{{$withdraw->user->id}}</td>
                                            </tr>
                                            <tr>
                                                <th>{{ __("User Name") }}</th>
                                                <td>
                                                    <a href="{{route('admin-user-show',$withdraw->user->id)}}" target="_blank">{{$withdraw->user->name}}</a>
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
											
											<tr>
                                                <th>{{ __("Net Payable") }}</th>
                                                <td>{{$withdraw->amount}}</td>
                                            </tr>
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
											 @if($withdraw->settle_amount	)
											<tr>
                                                <th>{{ __("Settle Amount") }}</th>
                                                <td>{{$withdraw->settle_amount	}}</td>
                                            </tr>
											@endif
											
                                            <tr>
                                                <th>{{ __("Withdraw Process Date") }}</th>
                                                <td>{{date('d-M-Y',strtotime($withdraw->created_at))}}</td>
                                            </tr>
                                            <tr>
                                                <th>{{ __("Withdraw Status") }}</th>
                                                <td>{{ucfirst($withdraw->status)}}</td>
                                            </tr>
											<tr>
                                                <th>{{ __("Settle Status") }}</th>
                                                <td>{{ucfirst($withdraw->settle)}}</td>
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
                                                <th>{{ __("Note") }}</th>
                                                <td>{{$withdraw->note}}</td>
                                            </tr>
											<?php $images=array();
										                      $temp=explode(',',$withdraw->screen_shot);
															  
															  foreach($temp as $image){
                                                              $images[]=trim( str_replace( array('[',']') ,"" ,$image ) );
                                                                }
                                                                  $j=1;
                                                               foreach($images as $image){ 
															   if($image) {?>
															   <tr>
                                                <th>Screen Shot {{ $j }}</th>
                                                <td><a href="{{ asset('assets/images/screenshot/'.$image) }}" download>Screen Shot {{ $j }}</a></td>
                                            </tr>
															   
															   <?php $j++; } }
                                                           ?>
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
						</div>

@endsection