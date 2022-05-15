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
                      <h4 class="heading">{{ __('Rto Details') }} <a class="add-btn" href="{{route('admin-open-rto')}}"><i class="fas fa-arrow-left"></i> {{ __('Back') }}</a></h4>
                      <ul class="links">
                        <li>
                          <a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }} </a>
                        </li>
                        <li>
                          <a href="javascript:;">{{ __('Rto Details') }}</a>
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
                                                            <th>{{ __("Rto Id#") }}</th>
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
                                                                <td><a href="{{$data->text}}" target="_blank">{{$data->text}}</a></td>
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
												
												<!--div class="col-md-2">
												<form  method="POST" action="{{route('admin-rto-update',$data->id)}}" enctype="multipart/form-data" id="rtodform">
												{{ csrf_field() }}
												@include('includes.admin.form-both')
												<input type = "hidden" name="rtoid" value="{{$data->id}}">
												<button class="rtodform-btn" type="submit">{{ __('rto') }}</button>
												</form>
												</div-->
												
												<div class="col-md-2">
												<form  method="POST" action="{{route('admin-dstatus-rto',$data->id)}}" enctype="multipart/form-data" id="declineform">
												{{ csrf_field() }}
												@include('includes.admin.form-both')
												<input type = "hidden" name="rtoid" value="{{$data->id}}">
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