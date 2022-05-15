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