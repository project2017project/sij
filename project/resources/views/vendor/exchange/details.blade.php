@extends('layouts.vendor')

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
                      <h4 class="heading">{{ __('Exchange Details') }} <a class="add-btn" href="{{route('vendor-exchange-index')}}"><i class="fas fa-arrow-left"></i> {{ __('Back') }}</a></h4>
                      <ul class="links">
                        <li>
                          <a href="{{ route('vendor-dashboard') }}">{{ __('Dashboard') }} </a>
                        </li>
                        <li>
                          <a href="javascript:;">{{ __('Exchange') }}</a>
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
                                                            <th>{{ __("Exchange Id#") }}</th>
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
                                                         <th>{{ __("Customer Courier Partner") }}</th>
                                                       <td>{{$data->courier_partner}}</td>
                                                      </tr>
                                                     <tr>
                                                      <th>{{ __("Customer Tracking Code") }}</th>
                                                      <td>{{$data->tracking_code}}</td> </tr>
                                                     <tr> <th>{{ __("Costumer Tracking Url") }}</th>
                                                     <td><a href="{{$data->tracking_url}}" target="_blank">{{$data->tracking_url}}</a></td>
                                                     </tr>
                                                        @if($data->companyname)
															<tr>
                                                                <th>{{ __("Vendor Courier Name") }}</th>
                                                                <td>{{$data->companyname}}</td>
                                                            </tr>
															@endif
															@if($data->title)
                                                           <tr>
                                                                <th>{{ __("Vendor Tracking Code") }}</th>
                                                                <td>{{$data->title}}</td>
                                                            </tr>
															@endif
															@if($data->text)
                                                           <tr>
                                                                <th>{{ __("Vendor Tracking URL") }}</th>
                                                                <td><a href="{{$data->text}}" target="_blank">{{$data->text}}</a></td>
                                                            </tr>
															@endif															
                                                            <tr>
                                                                <th>{{ __("Exchange Date") }}</th>
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
												<?php if($data->status=='notdelivered' || $data->status=='delivered' ) { ?>
													
												<?php }else{?>
												<div class="text-left" style="display:inline-block; width:100%; padding:30px 20px;"><a href="javascript:void(0)" class="add-btn btn-md"> <span data-toggle="modal" data-target="#exshipform-all" class="">Add Shipping<span></span></span></a></div>
												<?php } ?>
												<form  method="POST" action="{{route('vendor-exchange-update',$data->id)}}" enctype="multipart/form-data" id="exshipform">
												{{ csrf_field() }}
												<div class="modal fade" id="exshipform-all" tabindex="-1" role="dialog" aria-labelledby="modal1" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="submit-loader">
                                            <img src="http://shop.webngigs.com/assets/images/1564224329loading3.gif" alt="">
                                        </div>
                                        <div class="modal-header d-block text-center">
                                            <h4 class="modal-title d-inline-block">SHIPPING DETAILS</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                                        </div>
                                        <div class="modal-body">            @include('includes.vendor.form-both')                                        					
                   
                    <div class="row">
                        <div class="col-lg-12">
                         <input type="text" class="input-field" name="companyname" placeholder="{{ __('Courier Name') }}" required="">                           
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <input type="text" class="input-field" name="title" placeholder="{{ __('Tracking Code') }}" required="">
                    </div>

                   </div>
                    <div class="row">
                        <div class="col-lg-12">
                         <input type="text" class="input-field"  name="text" placeholder="{{ __('Tracking URL') }}" required="">          
                        </div>
                    </div>
                                   
                                        </div>
                                        <div class="modal-footer justify-content-center">
                                            <p align="center"><button type="submit"  class="exshipform-btn btn btn-success referesh-btn" name="save">ADD</button></p>
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