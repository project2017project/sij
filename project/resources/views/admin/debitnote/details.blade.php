@extends('layouts.admin')

@section('styles')

<style type="text/css">
    .table-responsive {
    overflow-x: hidden;
}
table#example2 {
    margin-left: 10px;
}

</style>

@endsection

@section('content')

                    <div class="content-area">
                        <div class="mr-breadcrumb">
                            <div class="row">
                               <div class="col-lg-12">
                      <h4 class="heading">{{ __('Debit Note Details') }} <a class="add-btn" href="{{route('admin-open-debit')}}"><i class="fas fa-arrow-left"></i> {{ __('Back') }}</a></h4>
                      <ul class="links">
                        <li>
                          <a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }} </a>
                        </li>
                        <li>
                          <a href="javascript:;">{{ __('Debit Note Details') }}</a>
                        </li>                        
                        
                      </ul>
                  </div>
                            </div>
                        </div>
                            <div class="add-product-content1 customar-details-area">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="product-description">
                                            <div class="body-area">
                                            <div class="row">  											
                                                    <div class="col-md-4">
                                                    <div class="table-responsive show-table">
                                                        <table class="table">
                                                        <tr>
                                                            <th>{{ __("Debit Note Id#") }}</th>
                                                            <td>{{$data->id}}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>{{ __("Vendor Name") }}</th>
															@php
                                        $user = App\Models\User::find($data->vendor_id);
                                        @endphp
                                                            <td>{{$user->name}}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>{{ __("Order Id") }}</th>
                                                            <td>{{$data->order_id}}</td>
                                                        </tr>                                                       
                                                            <tr>
                                                                <th>{{ __("Product Name") }}</th>
                                                                <td>{{$data->product_name}}</td>
                                                            </tr>	

                                                        </table>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                    <div class="table-responsive show-table">
                                                    <table class="table"> 
                                                      												
                                                           <tr>
                                                                <th>{{ __("Product SKU") }}</th>
                                                                <td>{{$data->product_sku}}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>{{ __("Total Deduction Amount") }}</th>
                                                                <td>{{$data->amount}}</td>
                                                            </tr>
															@if($data->quantity)
                                                            <tr>
                                                                <th>{{ __("Quantity") }}</th>
                                                                <td>{{$data->quantity}}</td>
                                                            </tr>
															@endif
															
															
															<tr>
                                                                <th>{{ __("IS PAYMENT") }}</th>
                                                                <td>{{$data->is_payment}}</td>
                                                            </tr>
                                                                                                                        <tr>
                                                                <th>{{ __("SGST") }}</th>
                                                                <td>{{$data->sgst}}</td>
                                                            </tr>
                                                                                                                        <tr>
                                                                <th>{{ __("CGST") }}</th>
                                                                <td>{{$data->cgst}}</td>
                                                            </tr>
                                                                                                                        <tr>
                                                                <th>{{ __("IGST") }}</th>
                                                                <td>{{$data->igst}}</td>
                                                            </tr>
                                                                                                                        <tr>
                                                                <th>{{ __("TCS") }}</th>
                                                                <td>{{$data->tcs}}</td>
                                                            </tr>
                                                                                                                        <tr>
                                                                <th>{{ __("ADMIN FEE") }}</th>
                                                                <td>{{$data->adminfee}}</td>
                                                            </tr>
                                                            
                                                            <tr>
                                                                <th>{{ __("AMT BEFORE TAX") }}</th>
                                                                <td>{{$data->amt_before_tax}}</td>
                                                            </tr>
                                                            
                                                            <tr>
                                                                <th>{{ __("OTHER AMT") }}</th>
                                                                <td>{{$data->others_amt}}</td>
                                                            </tr>
                                                            
                                                            <tr>
                                                                <th>{{ __("REMARKS") }}</th>
                                                                <td>{{$data->remarks}}</td>
                                                            </tr>
															
															
															
															<tr>
                                                                <th>{{ __("Reason") }}</th>
                                                                <td>{{$data->reason}}</td>
                                                            </tr>
                                                         @if($data->withdraw_id)														
                                                            <tr>
                                                                <th>{{ __("Withdraw ID") }}</th>
                                                                <td>{{$data->withdraw_id}}</td>
                                                            </tr>
                                                            @endif															
                                                            <tr>
                                                                <th>{{ __("Dispute Date") }}</th>
                                                                <td>{{$data->created_at}}</td>
                                                            </tr>
                                                            
                                                           
                                                        </table>
                                                        </div>
                                                    </div>			
													
															  
                                                        </div>
														
														<div class="row">
														<h4>Attachment :- </h4>
														<?php $scrimage=array();
										                      $temp=explode(',',$data->screen_shot);
															  foreach($temp as $image){
                                                              $images[]=trim( str_replace( array('[',']') ,"" ,$image ) );
                                                                }
                                                                  $j=1;
                                                               foreach($images as $image){ ?>
															   <div class="col-md-2">
                                                        <div class="user-image">
															   <a href="{{ asset('assets/images/screenshot/'.$image) }}" download>Screen Shot {{ $j }}</a>
															   </div>
														
														
                                                    </div>
                                                           <?php $j++; }
                                                           ?>													
													
                                                </div>
														
												<br>
												
												<div class="row">														
														<?php 
										                      $docment=explode(',',$data->document);
															  if($data->document){ ?>
															  <h6>Document : </h6>
															  <?php foreach($docment as $docments){
                                                              $docmentdata[]=trim( str_replace( array('[',']') ,"" ,$docments ) );
                                                                }
                                                                  $k=1;
                                                               foreach($docmentdata as $docm){ ?>
															   <div class="col-md-2">
                                                        <div class="user-image">
															   <a href="{{ asset('assets/images/document/'.$docm) }}" download>Download Document {{ $k }}</a>
															   </div>
														
														
                                                    </div>
															  <?php $k++; } }
                                                           ?>													
													
                                                </div>
												<br>
												
												<div class="row">
												<div class="col-md-6">
												<form  method="POST" action="{{route('admin-debitdocument-update',$data->id)}}" enctype="multipart/form-data" id="documentform">
												{{ csrf_field() }}
												@include('includes.admin.form-both')												
										         <div class="left-area"><input type="file" class="form-control" name="document[]" placeholder="Upload Document" multiple></div>
												 </div>	
                                                <div class="col-md-6">												 
												<button class="addocument-btn" type="submit">{{ __('Add Document') }}</button>
												</form>
												</div>
												</div>
												@php
                                                $order_data = App\Models\Order::find($data->order_id);
                                                $vorder_data = App\Models\VendorOrder::where('user_id',$data->vendor_id)->where('order_id',$data->order_id)->where('product_id',$data->product_id)->first();
                                                @endphp
												
												<!--div class="row">											
												
												<div class="col-md-2">
												<form  method="POST" action="{{route('admin-debitrstatus-update',$data->id)}}" enctype="multipart/form-data" id="settlementform">
												{{ csrf_field() }}
												@include('includes.admin.form-both')
												<input type = "hidden" name="debitid" value="{{$data->id}}">
												<button class="settlementform-btn" type="submit">{{ __('Settlement') }}</button>
												</form>
												</div>							
												
																								
												</div-->
												<!--div class="row">											
												
												<div class="col-md-2">
												<form  method="POST" action="{{route('debit-cancel-status',$data->id)}}" enctype="multipart/form-data" id="settlementform">
												{{ csrf_field() }}
												@include('includes.admin.form-both')
												<input type = "hidden" name="debitid" value="{{$data->id}}">
												<button class="settlementform-btn" type="submit">{{ __('Cancel') }}</button>
												</form>
												</div>							
												
																								
												</div-->
                                            </div>
											
                                            
											
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

@endsection

@section('scripts')

<script type="text/javascript">
$('#example2').dataTable( {
  "ordering": false,
      'paging'      : false,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : false,
      'info'        : false,
      'autoWidth'   : false,
      'responsive'  : true
} );
</script>


@endsection