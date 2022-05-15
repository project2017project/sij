@extends('layouts.front')
@section('content')

<section class="user-dashbord">
    <div class="container">
        <div class="row">
            @include('includes.user-dashboard-sidebar')
            <div class="col-lg-8">
                <div class="user-profile-details">
                    <div class="order-details">

                        


                        <div class="header-area">
                            <h4 class="title">
                                {{ __('Exchange Details') }}
                            </h4>
                        </div>
                        <div class="view-order-page">
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
                </div>
            </div>
        </div>
    </div>
	  </div>
        </div>    
</section>
@endsection
