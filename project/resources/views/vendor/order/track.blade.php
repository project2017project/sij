@extends('layouts.load')
@section('content')



{{-- ADD ORDER TRACKING --}}

<div class="add-product-content1">
    <div class="row">
        <div class="col-lg-12">
            <div class="product-description">
                <div class="body-area">
                    <div class="gocover" style="background: url({{asset('assets/images/'.$gs->admin_loader)}}) no-repeat scroll center center rgba(45, 45, 45, 0.5);"></div>
                <input type="hidden" id="vendor-track-store" value="{{route('vendor-order-track-store')}}">
                <form id="trackform" action="{{route('vendor-order-track-store')}}" method="POST" enctype="multipart/form-data">
                    {{csrf_field()}}
                    @include('includes.vendor.form-both')  
                    <input type="hidden" name="vid" value="{{ $orderdata->id }}">
                    <input type="hidden" name="pid" value="{{ $orderdata->product_id }}">					
                    <input type="hidden" name="order_id" value="{{ $order->id }}">
                    <input type="hidden" name="vendor_id" value="{{ $user->id }}">
					@php
						$orderid=$order->id;
                        $vdetails = App\Models\VendorOrder::all()->where('order_id',$orderid)->where('user_id',$user->id);									
                        @endphp
						 <?php  
                                              if($vdetails) {
                                              foreach($vdetails as $item){
                                                 
                                                if($item->status) {
                                                       $status= $item->status;
                                                 }
                                              }
                                           }
                                          
                                         ?>
						
					 <input type="hidden" name="status" value="{{ $status }}">
                    <div class="row">
                        <div class="col-lg-5">
                            <div class="left-area">
                                    <h4 class="heading">{{ __('Courier Name') }} *</h4>
                            </div>
                        </div>
                        <div class="col-lg-7">
                            <input type="text" class="input-field companyname" id="companyname" name="companyname" placeholder="{{ __('Courier Name') }}" value="" required="">
                            <!--<textarea class="input-field" id="companyname" name="companyname" placeholder="{{ __('Company') }}" required=""></textarea>-->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-5">
                            <div class="left-area">
                                    <h4 class="heading">{{ __('Tracking Code') }} *</h4>
                            </div>
                        </div>
                        <div class="col-lg-7">
                            <input type="text" class="input-field track-title" id="track-title" name="title" placeholder="{{ __('Tracking Code') }}" value="" required="">
                            <!--<textarea class="input-field" id="track-title" name="title" placeholder="{{ __('Title') }}" required=""></textarea>-->
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-lg-5">
                            <div class="left-area">
                                    <h4 class="heading">{{ __('Tracking URL') }} *</h4>
                            </div>
                        </div>
                        <div class="col-lg-7">
                            <input type="text" class="input-field track-details" id="track-details" name="text" placeholder="{{ __('Tracking URL') }}" value="" required="">
                            <!--<textarea class="input-field" id="track-details" name="text" placeholder="{{ __('Details') }}" required=""></textarea>-->
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-5">
                            <div class="left-area">
                                
                            </div>
                        </div>
                        <div class="col-lg-7">
                            <button class="addProductSubmit-btn" id="track-btn" type="submit">{{ __('ADD') }}</button>
                            <button class="addProductSubmit-btn ml=3 d-none" id="cancel-btn" type="button">{{ __('Cancel') }}</button>
                            <input type="hidden" id="add-text" value="{{ __('ADD') }}">
                            <input type="hidden" id="edit-text" value="{{ __('UPDATE') }}">
                        </div>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
</div>

<hr>
<h5 class="text-center">TRACKING DETAILS</h5>
<hr>

{{-- ORDER TRACKING DETAILS --}}

						<div class="content-area no-padding">
							<div class="add-product-content1">
								<div class="row">
									<div class="col-lg-12">
										<div class="product-description">
											<div class="body-area">


                                    <div class="table-responsive show-table ml-3 mr-3">
                                        <table class="table" id="track-load" data-href="{{ route('vendor-order-track-load',$order->id) }}">
                                            <tr>
                                                <th width="15%">{{ __("Courier Name") }}</th>
                                                <th width="15%">{{ __("Tracking Code") }}</th>
                                                <th width="45%">{{ __("Tracking URL") }}</th>
                                                <th width="15%" style="width:15%;">{{ __("Date") }}</th>
                                              <!--  <th>{{ __("Time") }}</th>-->
                                                <th>{{ __("Options") }}</th>
                                            </tr>
                                            @foreach($order->tracks as $track)
                                              @if($track->vendor_id == $user->id && $track->vid == $orderdata->id )
                                            <tr data-id="{{ $track->id }}">
                                                <td width="15%" class="t-companyname">{{ $track->companyname }}</td>
                                                <td width="15%" class="t-title">{{ $track->title }}</td>
                                                <td width="45%" class="t-text">{{ $track->text }}</td>
                                                <td  width="15%">{{  date('d-M-Y',strtotime($track->created_at)) }}</td>
                                             <!--   <td>{{  date('h:i:s:a',strtotime($track->created_at)) }}</td>-->
                                                <td>
                                                    <div class="action-list">
                                                        <a data-href="{{ route('vendor-order-track-update',$track->id) }}" class="track-edit"> <i class="fas fa-edit"></i>Edit</a>
                                                        <a href="javascript:;" data-href="{{ route('vendor-order-track-delete',$track->id) }}" class="track-delete"><i class="fas fa-trash-alt"></i></a>
                                                    </div>
                                                </td>
                                            </tr>
											@endif
                                            @endforeach
                                        </table>
                                    </div>


											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

@endsection