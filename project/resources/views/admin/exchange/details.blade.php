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
                      <h4 class="heading">{{ __('Exchange Details') }} <a class="add-btn" href="{{route('admin-open-exchange')}}"><i class="fas fa-arrow-left"></i> {{ __('Back') }}</a></h4>
                      <ul class="links">
                        <li>
                          <a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }} </a>
                        </li>
                        <li>
                          <a href="javascript:;">{{ __('Exchange Details') }}</a>
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
                                                            <th>{{ __("Dispute Id#") }}</th>
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
                                                             <tr>
                                                                <th>{{ __("Product SKU") }}</th>
                                                                <td>{{$data->product_sku}}</td>
                                                            </tr>															

                                                        </table>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                    <div class="table-responsive show-table">
                                                    <table class="table"> 
                                                      												
                                                           
                                                            <!--tr>
                                                                <th>{{ __("Amount") }}</th>
                                                                <td>{{$data->amount}}</td>
                                                            </tr-->
                                                            <tr>
                                                                <th>{{ __("Quantity") }}</th>
                                                                <td>{{$data->quantity}}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>{{ __("Reason") }}</th>
                                                                <td>{{$data->reason}}</td>
                                                            </tr>
                                                            
                                                           
                                                           
                                                           
                                                            <tr>
                                                                <th>{{ __(" Customer Courier Partner") }}</th>
                                                                <td>{{$data->courier_partner}}</td>
                                                            </tr>  
                                                            
                                                                                                                                        <tr>
                                                                <th>{{ __("Customer Tracking Code") }}</th>
                                                                <td>{{$data->tracking_code}}</td>
                                                            </tr> 
                                                            
                                                            
                                                            
                                                                                                    <tr>
                                                                <th>{{ __("Customer Tracking Url") }}</th>
                                                                <td><a target="_blank" href="{{$data->tracking_url}}">{{$data->tracking_url}}</a></td>
                                                            </tr>                     
                                                            
                                                            
                                                            
                                                            
                                                            
                                                            
															@if($data->companyname)
															<tr>
                                                                <th>{{ __("Courier Name") }}</th>
                                                                <td>{{$data->companyname}}</td>
                                                            </tr>
															@endif
															@if($data->title)
                                                           <tr>
                                                                <th>{{ __("Tracking Code") }}</th>
                                                                <td>{{$data->title}}</td>
                                                            </tr>
															@endif
															@if($data->text)
                                                           <tr>
                                                                <th>{{ __("Tracking URL") }}</th>
                                                                <td>{{$data->text}}</td>
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
														<h4>Screen Shot :- </h4>
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
												<form  method="POST" action="{{route('admin-exchangedocument-update',$data->id)}}" enctype="multipart/form-data" id="documentform">
												{{ csrf_field() }}
												@include('includes.admin.form-both')												
										         <div class="left-area"><input type="file" class="form-control" name="document[]" placeholder="Upload Document" multiple></div>
												 </div>	
                                                <div class="col-md-6">												 
												<button class="addocument-btn" type="submit">{{ __('Add Document') }}</button>
												</form>
												</div>
												</div>
												
												<div class="row">
												
												<!--div class="col-md-2">
												<form  method="POST" action="{{route('admin-exchange-update',$data->id)}}" enctype="multipart/form-data" id="exchangedform">
												{{ csrf_field() }}
												@include('includes.admin.form-both')
												<input type = "hidden" name="echangeid" value="{{$data->id}}">
												<button class="exchangedform-btn" type="submit">{{ __('Exchange') }}</button>
												</form>
												</div-->
												
												<div class="col-md-2">
												<form  method="POST" action="{{route('admin-dstatus-exchange',$data->id)}}" enctype="multipart/form-data" id="declineform">
												{{ csrf_field() }}
												@include('includes.admin.form-both')
												<input type = "hidden" name="echangeid" value="{{$data->id}}">
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