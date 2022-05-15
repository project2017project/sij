@extends('layouts.admin')
@section('content')
<div class="content-area">
	<div class="mr-breadcrumb">
		<div class="row">
			<div class="col-lg-12">
				<h4 class="heading">{{ __('Rto') }} 				
				<ul class="links">
					<li><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }} </a></li>					
					<li><a href="javascript:;">{{ __('Add Rto') }}</a></li>					
				</ul>
			</div>
		</div>
	</div>

	<form id="rtodforms" action="{{route('addstore-rtood-submit')}}" method="POST" enctype="multipart/form-data">
		{{csrf_field()}}
       @include('includes.admin.form-both')	
	<div class="row">
		<div class="col-lg-12">
			<div class="add-product-content">
				<div class="row">
					<div class="col-lg-12">
						<div class="product-description">
							<div class="body-area">
		<div class="row">									
                                  <div class="col-md-12"> 
<div class="table-responsive-sm">
<table class="table">
  <tr>
    <th>Product Name</th>
    <th>Amount</th>
    <th>Quantity</th>
	<th>Refund</th>
    <th>rto</th>
    <th>Payment Status</th>
  </tr>
  @php $i=1; @endphp
  @foreach($vdata as $alldata)
		                            @php
                                    $product_data = App\Models\Product::find($alldata->product_id);
                                    @endphp
									 @php
                                    $vender_data = App\Models\VendorOrder::where('order_id','=',$alldata->order_id)->where('user_id','=',$alldata->user_id)->where('product_id','=',$alldata->product_id)->first();
                                    @endphp
									@php
                                      $withdraw_data = App\Models\VendorOrder::where('user_id','=',$alldata->user_id)->where('product_item_price','=',NULL)->orderBy('id','desc')->get();
                                     @endphp
									
									
  <tr class="setproduct{{$i}}">
    <td>{{$product_data->name}}</td>
    <td>{{$alldata->price}}</td>
   <td class="datapqty" dataqty="{{$alldata->qty-$vender_data->product_item_qty}}">{{$alldata->qty-$vender_data->product_item_qty}}</td>
   @if($alldata->refund_status)
	<td class="refund" refund="{{$alldata->refund_status}}">{{$alldata->refund_status}}</td>
    @else
	<td class="refund" refund="">-</td>
    @endif
	@if($alldata->other_status)
	<td class="rto" rto="{{$alldata->other_status}}">{{$alldata->other_status}}</td>
    @else
	<td class="rto" rto="">-</td>
    @endif
	@if($vender_data->vendor_request_status=='completed')
	<td class="paystatus" paystatus="paid">Paid</td>
    @elseif($vender_data->vendor_request_status=='NotRaised')
	<td class="paystatus" paystatus="unpaid">Unpaid</td>
	@elseif($vender_data->vendor_request_status=='requested')
	<td class="paystatus" paystatus="request">Request</td>
	@else
		<td class="paystatus" paystatus="">Unpaid</td>
	@endif
  </tr>
  @php $i++ @endphp
 @endforeach
</table>
</div>
</div>

</div>							
		
									

                                    <div class="row">
										<div class="col-lg-12"><div class="left-area"><h4 class="heading">{{ __('Product Id') }} </h4></div></div>
										<div class="col-lg-12">	
									
										<select class="form-control productid" name="product_id" id="productid" required>
						                    <option value=''>--Select Product Id-- </option>
											@php $j=1; @endphp
                                    @foreach($vdata as $vdatas)
									 @php
                                                $productsku = App\Models\Product::find($vdatas->product_id);
                                                @endphp
                                    <option data-href="{{ route('product-data-pload',$vdatas->product_id) }}" value="{{$vdatas->product_id}}"  dataidp=".setproduct{{$j}}">({{$productsku->sku}}) {{$productsku->name}}</option>
									@php $j++ @endphp
                                    @endforeach
					                    </select>
										
										</div>
									</div>	                                    
									<div class="products"></div>
									
									<!--div class="row">
										<div class="col-lg-12"><div class="left-area"><h4 class="heading">{{ __('Amount') }}* </h4></div></div>
										<div class="col-lg-12"><input type="text" class="input-field" placeholder="{{ __('Amount') }}" name="amount" required=""></div>
									</div-->
									<div class="row">
										<div class="col-lg-12"><div class="left-area"><h4 class="heading">{{ __('Quantity') }}* </h4></div></div>
										<div class="col-lg-12"><input type="number" class="input-field rdqty" placeholder="{{ __('Quantity') }}" name="quantity" min="0"  required=""></div>
									</div>
									
									 <div class="row">
										<div class="col-lg-12"><div class="left-area"><h4 class="heading">{{ __('Type *') }} </h4></div></div>
										<div class="col-lg-12">
										<select name="type"  required> 
                                         <option value="">Please Select a Type</option>  
                                         <option value="rto">RTO</option></option>
                                         <option value="reshipping">Re-Shipping</option>
                                        </select>
									</div>
									</div> 
                                 
                                    <div class="row">
										<div class="col-lg-12"><div class="left-area"><h4 class="heading">{{ __('Reason *') }} </h4></div></div>
										<div class="col-lg-12">
										<select name="prreason" onchange="changereason(this.value);" required> 
                                         <option value="">Please Select a Reason</option>  
                                         <option value="Wrong product delivered to customer">Wrong product delivered to customer</option>
                                         <option value="Damaged product delivered to customer">Damaged product delivered to customer</option>
                                         
                                          <option value="Wrong address given by customer">Wrong address given by customer</option>
                                          
                                           <option value="Product sent wrong address">Product sent wrong address</option>
                                         
                                         <option value="others">others</option>
                                        </select>
										<input type="text" class="input-field" id="reason" placeholder="{{ __('Reason') }}" name="reason" style="display:none;"></div>
									</div> 
									
									
																		
																		<!--div class="row">
										<div class="col-lg-12"><div class="left-area"><h4 class="heading">{{ __('Courier_partner') }}* </h4></div></div>
										<div class="col-lg-12"><input type="text" class="input-field rdcour" placeholder="{{ __('Courier_partner') }}" name="courier_partner" min="0"  required=""></div>
									</div>	
									
																											<div class="row">
										<div class="col-lg-12"><div class="left-area"><h4 class="heading">{{ __('Tracking_code') }}* </h4></div></div>
										<div class="col-lg-12"><input type="text" class="input-field rdcode" placeholder="{{ __('Tracking_code') }}" name="tracking_code" min="0"  required=""></div>
									</div>
									
									
																																				<div class="row">
										<div class="col-lg-12"><div class="left-area"><h4 class="heading">{{ __('Tracking_url') }}* </h4></div></div>
										<div class="col-lg-12"><input type="text" class="input-field rdurl" placeholder="{{ __('Tracking_url') }}" name="tracking_url" min="0"  required=""></div>
									</div-->
									
									
									
									
									
									
									
									
									

                                   <div class="row">
										<div class="col-lg-12"><div class="left-area"><h4 class="heading">{{ __('Upload Screen Shot') }} </h4></div></div>
										<div class="col-lg-12"><input required type="file" class="form-control" name="screenshot[]" placeholder="Upload Screen Shot" multiple></div>
									</div> 									
		                            		
										<div class="row">
										<div class="col-lg-12 text-center">
										<input type="hidden" name="vendor_id" value="{{ $vendorid }}">
										<input type="hidden" name="order_id" value="{{ $orderid }}">
										<div class="modal fade" id="rtomod" tabindex="-1" role="dialog" aria-labelledby="rtomod" aria-hidden="true">                        
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">            
            <div class="modal-body">
                <p class="text-center">Are you Sure You want to Create RTO Request?</p>
				<button class="addrtos-btn btn btn-success" style="margin-top : 0; width:auto; height:auto; font-size : 1rem; 
    background-color: #28a745; border: 1px solid transparent; border-color: #28a745;" type="submit">{{ __('Confirm') }}</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">{{ __('Cancel') }}</button>
            </div>
            </div>
    </div>
</div>
											
												<a href="javascript:;" class="btn btn-info" data-toggle="modal" data-target="#rtomod">{{ __('Add') }}</a>
													</div>
									</div>
							</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>					
					
	</div>
	</form>
	
</div>
@endsection
@section('scripts')

<script src="{{asset('assets/admin/js/jquery.Jcrop.js')}}"></script>
<script src="{{asset('assets/admin/js/jquery.SimpleCropper.js')}}"></script>
<script>
 $(document).on('change','.productid',function () {
	 
            var productlink = $(this).find(':selected').attr('data-href');
			var productidp = $(this).find(':selected').attr('dataidp');
            var productqty = $(productidp+" .datapqty").attr('dataqty');
            $(".rdqty").attr("max", productqty);			
            if(productlink){
				$('.products').show();
                $('.products').load(productlink);                
            }else{
				$('.products').hide();
			}
        });
    </script>
<script type="text/javascript">
function changereason(val){
 var element=document.getElementById('reason');
 if(val==''||val=='others')
   element.style.display='block';
 else  
   element.style.display='none';
}

</script>
@endsection
