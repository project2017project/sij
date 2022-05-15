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
                      <h4 class="heading">{{ __('Raise Dispute Details') }} <a class="add-btn" href="{{route('admin-open-dispute')}}"><i class="fas fa-arrow-left"></i> {{ __('Back') }}</a></h4>
                      <ul class="links">
                        <li>
                          <a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }} </a>
                        </li>
                        <li>
                          <a href="javascript:;">{{ __('Raise Dispute Details') }}</a>
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
                                                            <th>{{ __("Refund Id#") }}</th>
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
                                                                <th>{{ __("Amount") }}</th>
                                                                <td>{{$data->amount}}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>{{ __("Quantity") }}</th>
                                                                <td>{{$data->quantity}}</td>
                                                            </tr>
                                                           <tr>
                                                                <th>{{ __("Reason") }}</th>
                                                                <td>{{$data->reason}}</td>
                                                            </tr>															
                                                            <tr>
                                                                <th>{{ __("Refund Date") }}</th>
                                                                <td>{{$data->created_at}}</td>
                                                            </tr>
                                                            
                                                             @if($data->tracking_code)
                                                             <tr>
                                                                <th>{{ __("Return Tracking Code") }}</th>
                                                                <td>{{$data->tracking_code}}</td>
                                                            </tr>
                                                            @endif
                                                            
                                                            @if($data->tracking_url)
                                                            
                                                             <tr>
                                                                <th>{{ __("Return Tracking Url") }}</th>
                                                                <td><a href="{{$data->tracking_url}}" target="_blank">{{$data->tracking_url}}</a></td>
                                                            </tr>
                                                            
                                                            @endif
                                                            
                                                            @if($data->tracking_partner)
                                                            
                                                             <tr>
                                                                <th>{{ __("Return Courier Partner") }}</th>
                                                                <td>{{$data->tracking_partner}}</td>
                                                            </tr>
                                                            @endif
                                                            
                                                           
                                                        </table>
                                                        </div>
                                                    </div>			
													
															  
                                                        </div>
														
														<div class="row">
														<h6>Attachment : </h6>
														<?php $scrimage=array();
										                      $temp=explode(',',$data->screen_shot);
															  foreach($temp as $image){
                                                              $images[]=trim( str_replace( array('[',']') ,"" ,$image ) );
                                                                }
                                                                  $j=1;
                                                               foreach($images as $image){ ?>
															   <div class="col-md-2">
                                                        <div class="user-image">
															   <a href="{{ asset('assets/images/screenshot/'.$image) }}" download>Download Attachment {{ $j }}</a>
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
												<form  method="POST" action="{{route('admin-raisedocument-update',$data->id)}}" enctype="multipart/form-data" id="documentform">
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
												@php
												$payment_method=$order_data->method
												@endphp
												@php
												$return_status=$vorder_data->refund_status
												@endphp
												<div class="row">
												@if($payment_method!='Razorpay')
												<div class="col-md-2">
												<form  method="POST" action="{{route('admin-rstatus-update',$data->id)}}" enctype="multipart/form-data" id="resolvedform">
												{{ csrf_field() }}
												@include('includes.admin.form-both')
												<input type = "hidden" name="disputeid" value="{{$data->id}}">
												<div class="modal fade" id="resolved" tabindex="-1" role="dialog" aria-labelledby="resolved" aria-hidden="true">                        
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">            
            <div class="modal-body">
                <p class="text-center">Are you Sure You want to Create Resolved Request?</p>
				<button class="resolved-btn btn btn-success" style="margin-top : 0; width:auto; height:auto; font-size : 1rem; 
    background-color: #28a745; border: 1px solid transparent; border-color: #28a745;" type="submit">{{ __('Confirm') }}</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">{{ __('Cancel') }}</button>
            </div>
            </div>
    </div>
</div>
											
												</form>
												<a href="javascript:;" class="btn btn-info" data-toggle="modal" data-target="#resolved">{{ __('Resolved') }}</a>												
												
												</div>
												<div class="col-md-2">
												<form  method="POST" action="{{route('admin-dstatus-update',$data->id)}}" enctype="multipart/form-data" id="declineform">
												{{ csrf_field() }}
												@include('includes.admin.form-both')
												<input type = "hidden" name="disputeid" value="{{$data->id}}">
												
												<div class="modal fade" id="decline" tabindex="-1" role="dialog" aria-labelledby="decline" aria-hidden="true">                        
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">            
            <div class="modal-body">
                <p class="text-center">Are you Sure You want to Create Decline Request?</p>
				<button class="decline-btn btn btn-success" style="margin-top : 0; width:auto; height:auto; font-size : 1rem; 
    background-color: #28a745; border: 1px solid transparent; border-color: #28a745;" type="submit">{{ __('Confirm') }}</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">{{ __('Cancel') }}</button>
            </div>
            </div>
    </div>
</div>
											
												</form>
												<a href="javascript:;" class="btn btn-info" data-toggle="modal" data-target="#decline">{{ __('Decline') }}</a>
												</div>
												@elseif($data->refund_status)
												<!--div class="col-md-2">
												<form  method="POST" action="{{route('admin-rstatus-update',$data->id)}}" enctype="multipart/form-data" id="resolvedform">
												{{ csrf_field() }}
												@include('includes.admin.form-both')
												<input type = "hidden" name="disputeid" value="{{$data->id}}">
												<button class="resolved-btn" type="submit">{{ __('Resolved') }}</button>
												</form>
												</div-->											
												
												@endif
												
												@if($payment_method=='Razorpay' && $data->refund_status !='1' )
													<div class="col-md-2">
												<form  method="POST" action="{{route('admin-dstatus-update',$data->id)}}" enctype="multipart/form-data" id="declineform">
												{{ csrf_field() }}
												@include('includes.admin.form-both')
												<input type = "hidden" name="disputeid" value="{{$data->id}}">
												
												<div class="modal fade" id="decline" tabindex="-1" role="dialog" aria-labelledby="decline" aria-hidden="true">                        
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">            
            <div class="modal-body">
                <p class="text-center">Are you Sure You want to Create Decline Request?</p>
				<button class="decline-btn btn btn-success" style="margin-top : 0; width:auto; height:auto; font-size : 1rem; 
    background-color: #28a745; border: 1px solid transparent; border-color: #28a745;" type="submit">{{ __('Confirm') }}</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">{{ __('Cancel') }}</button>
            </div>
            </div>
    </div>
</div>
																						</form>
													<a href="javascript:;" class="btn btn-info" data-toggle="modal" data-target="#decline">{{ __('Decline') }}</a>
												</div>
												<div class="col-md-2">
												<form  method="POST" action="{{route('admin-refundonline-update',$data->id)}}" enctype="multipart/form-data" id="redonform">
												{{ csrf_field() }}
												@include('includes.admin.form-both')
												<input type = "hidden" name="user_id" value="{{$data->vendor_id}}">
												<input type = "hidden" name="order_id" value="{{$data->order_id}}">
												<input type = "hidden" name="product_id" value="{{$data->product_id}}">
												<input type = "hidden" name="product_item_qty" value="{{$data->quantity}}">
												<input type = "hidden" name="product_item_price" value="{{$data->amount}}">
												<input type = "hidden" name="reason" value="{{$data->reason}}">
													<div class="modal fade" id="refundon" tabindex="-1" role="dialog" aria-labelledby="refundon" aria-hidden="true">                        
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">            
            <div class="modal-body">
                <p class="text-center">Are you Sure You want to Create Refund Online Request?</p>
				<button class="redonform-btn btn btn-success" style="margin-top : 0; width:auto; height:auto; font-size : 1rem; 
    background-color: #28a745; border: 1px solid transparent; border-color: #28a745;" type="submit">{{ __('Confirm') }}</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">{{ __('Cancel') }}</button>
            </div>
            </div>
    </div>
</div>
												
												
												</form>
												<a href="javascript:;" class="btn btn-info" data-toggle="modal" data-target="#refundon">{{ __('Refund Online') }}</a>
												</div>
												<div class="col-md-2">
												<form  method="POST" action="{{route('admin-refundoffline-update',$data->id)}}" enctype="multipart/form-data" id="redoffform">
												{{ csrf_field() }}
												@include('includes.admin.form-both')
												<input type = "hidden" name="user_id" value="{{$data->vendor_id}}">
												<input type = "hidden" name="order_id" value="{{$data->order_id}}">
												<input type = "hidden" name="product_id" value="{{$data->product_id}}">
												<input type = "hidden" name="product_item_qty" value="{{$data->quantity}}">
												<input type = "hidden" name="product_item_price" value="{{$data->amount}}">
												<input type = "hidden" name="reason" value="{{$data->reason}}">
												
												<div class="modal fade" id="refundoff" tabindex="-1" role="dialog" aria-labelledby="refundoff" aria-hidden="true">                        
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">            
            <div class="modal-body">
                <p class="text-center">Are you Sure You want to Create Refund Offline Request?</p>
				<button class="redoffform-btn btn btn-success" style="margin-top : 0; width:auto; height:auto; font-size : 1rem; 
    background-color: #28a745; border: 1px solid transparent; border-color: #28a745;" type="submit">{{ __('Confirm') }}</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">{{ __('Cancel') }}</button>
            </div>
            </div>
    </div>
</div>
												
												
												</form>
												<a href="javascript:;" class="btn btn-info" data-toggle="modal" data-target="#refundoff">{{ __('Refund Offline') }}</a>
												</div>
                        <div class="col-md-2">
                        <form  method="POST" action="{{route('admin-refundcoupon-update',$data->id)}}" enctype="multipart/form-data" id="redoffform">
                        {{ csrf_field() }}
                        @include('includes.admin.form-both')
                        <input type = "hidden" name="user_id" value="{{$data->vendor_id}}">
                        <input type = "hidden" name="order_id" value="{{$data->order_id}}">
                        <input type = "hidden" name="product_id" value="{{$data->product_id}}">
                        <input type = "hidden" name="product_item_qty" value="{{$data->quantity}}">
                        <input type = "hidden" name="product_item_price" value="{{$data->amount}}">
                        <input type = "hidden" name="reason" value="{{$data->reason}}">
                        
                        		<div class="modal fade" id="refcoupon" tabindex="-1" role="dialog" aria-labelledby="refcoupon" aria-hidden="true">                        
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">            
            <div class="modal-body">
                <p class="text-center">Are you Sure You want to Create Refund By Coupon Request?</p>
				<button class="redoffform-btn btn btn-success" style="margin-top : 0; width:auto; height:auto; font-size : 1rem; 
    background-color: #28a745; border: 1px solid transparent; border-color: #28a745;" type="submit">{{ __('Confirm') }}</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">{{ __('Cancel') }}</button>
            </div>
            </div>
    </div>
</div>
                       
                        </form>
                        <a href="javascript:;" class="btn btn-info" data-toggle="modal" data-target="#refcoupon">{{ __('Refund By Coupon') }}</a>
                        </div>
												@endif												
													
												</div>
												
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