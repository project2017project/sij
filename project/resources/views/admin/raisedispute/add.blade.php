@extends('layouts.admin')
@section('content')
<div class="content-area">
	<div class="mr-breadcrumb">
		<div class="row">
			<div class="col-lg-12">
				<h4 class="heading">{{ __('Refund') }} 				
				<ul class="links">
					<li><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }} </a></li>					
					<li><a href="javascript:;">{{ __('Add Refund') }}</a></li>					
				</ul>
			</div>
		</div>
	</div>

	<form id="raisedisputeform" action="{{route('addstore-raisedispute-submit')}}" method="POST" enctype="multipart/form-data">
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
    <th>Available Amt <br /> for Refund</th>
    <th>Quantity</th>
    <th>Available Qty <br /> for Refund</th>
	<th>Refund</th>
    <th>Exchange</th>
     <th>Pending Request</th>
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
                                     
                                      @php
                                    $dispute_data = App\Models\RaiseDispute::where('order_id','=',$alldata->order_id)->where('vendor_id','=',$alldata->user_id)->where('product_id','=',$alldata->product_id)->where('status','=','open')->get();
                                    @endphp
  <tr class="setproduct{{$i}}">
    <td>{{$product_data->name}}</td>
    <td>{{$alldata->price}}</td>
    
    <td class="datapamt" dataamt="{{$alldata->price-$vender_data->product_item_price}}">{{$alldata->price-$vender_data->product_item_price}}</td>
    
    <td>{{$alldata->qty}}</td>
    
    <td class="datapqty" dataqty="{{$alldata->qty-$vender_data->product_item_qty}}">{{$alldata->qty-$vender_data->product_item_qty}}</td>
	@if($alldata->refund_status)
	<td class="refund" refund="{{$alldata->refund_status}}">{{$alldata->refund_status}}</td>
    @else
	<td class="refund" refund="">-</td>
    @endif
	@if($alldata->other_status)
	<td class="exchange" exchange="{{$alldata->other_status}}">{{$alldata->other_status}}</td>
    @else
	<td class="exchange" exchange="">-</td>
    @endif
    @if($dispute_data)
    <td class="refundreq" pendingref="{{ count($dispute_data)}}" refundreq="">{{ count($dispute_data)}}</td>
     @else
    <td class="refundreq" pendingref="{{ count($dispute_data)}}" refundreq="">-</td>
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
									
									
										<div class="row refpenalert" style="display:none;">
									    <div class="col-lg-12">
									        <div class="alert alert-danger" role="alert">You already have <span class="prcount"></span> pending  request for this product. </div>
									    </div>
									</div>
									
									
									<div class="row">
										<div class="col-lg-12"><div class="left-area"><h4 class="heading">{{ __('Quantity') }}* </h4></div></div>
										<div class="col-lg-12"><input type="number" class="input-field rdqty" placeholder="{{ __('Quantity') }}" name="quantity" min="1"  required=""></div>
									</div>
									
									
									
									
									<div class="row">
										<div class="col-lg-12"><div class="left-area"><h4 class="heading">{{ __('Amount') }}* </h4></div></div>
										<div class="col-lg-12"><input type="text" class="input-field rdamt" placeholder="{{ __('Amount') }}" name="amount" required="" readonly></div>
									</div>
									
									<div class="row">
										<div class="col-lg-12"><div class="left-area"><h4 class="heading">{{ __('Customer Tracking Code') }} </h4></div></div>
										<div class="col-lg-12"><input type="text" class="input-field" placeholder="{{ __('Tracking Code') }}" name="tracking_code"></div>
									</div>
									
									<div class="row">
										<div class="col-lg-12"><div class="left-area"><h4 class="heading">{{ __('Customer Tracking Url') }} </h4></div></div>
										<div class="col-lg-12"><input type="text" class="input-field" placeholder="{{ __('Tracking URL') }}" name="tracking_url"></div>
									</div>
									
									<div class="row">
										<div class="col-lg-12"><div class="left-area"><h4 class="heading">{{ __('Customer Courier Partner') }} </h4></div></div>
										<div class="col-lg-12"><input type="text" class="input-field" placeholder="{{ __('Courier Partner') }}" name="tracking_partner"></div>
									</div>
									
									
                                 
                                    <div class="row">
										<div class="col-lg-12"><div class="left-area"><h4 class="heading">{{ __('Reason') }} </h4></div></div>
										<div class="col-lg-12">
										<select name="prreason" onchange="changereason(this.value);" required> 
                                         <option value="">Please Select a Reason</option>  
                                         <option value="Delay in dispatching the product">Delay in dispatching the product</option>
                                         <option value="Out of stock">Out of stock</option>
                                         <option value="Product lost in transit">Product lost in transit (No Proper POD)</option>
                                         
                                          <option value="Duplicate order created by customer">Duplicate order created by customer</option>
                                         <option value="Damaged product received by customer">Damaged product received by customer</option>
                                         <option value="Wrong product delivered to customer">Wrong product delivered to customer</option>
                                         
                                          <option value="Customer not satisfied by the product">Customer not satisfied by the product</option>
                                         
                                         
                                         <option value="others">others</option>
                                        </select>
										<input type="text" class="input-field" id="reason" placeholder="{{ __('Reason') }}" name="reason" style="display:none;"></div>
									</div> 
									
									
								
									
									

                                   <div class="row">
										<div class="col-lg-12"><div class="left-area"><h4 class="heading">{{ __('Upload Screen Shot') }} </h4></div></div>
										<div class="col-lg-12"><input required type="file" class="form-control" name="screenshot[]" placeholder="Upload Screen Shot" multiple></div>
									</div> 									
		                            		
								
									
									<div class="row">
										<div class="col-lg-12 text-center">
										<input type="hidden" name="vendor_id" value="{{ $vendorid }}">
										<input type="hidden" name="order_id" value="{{ $orderid }}">
										<div class="modal fade" id="raisemod" tabindex="-1" role="dialog" aria-labelledby="raisemod" aria-hidden="true">                        
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">            
            <div class="modal-body">
                <p class="text-center">Are you Sure You want to Create Refund Request?</p>
				<button class="addraisedispute-btn btn btn-success" style="margin-top : 0; width:auto; height:auto; font-size : 1rem; 
    background-color: #28a745; border: 1px solid transparent; border-color: #28a745;" type="submit">{{ __('Confirm') }}</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">{{ __('Cancel') }}</button>
            </div>
            </div>
    </div>
</div>
											
												<a href="javascript:;" class="btn btn-info" data-toggle="modal" data-target="#raisemod">{{ __('Add') }}</a>
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

$(document).on('change','.rdqty',function () {
            var qtyr = $(this).val();
            var productidp = $(this).find(':selected').attr('dataidp');
            var productamt = $(".tractive .datapamt").attr('dataamt');
            var productqty = $(".tractive .datapqty").attr('dataqty');
            var productprice = productamt / productqty;
             
             
             var total = productprice * qtyr;
     
       $(".rdamt").val(total);
    });


 $(document).on('change','.productid',function () {
	 
            var productlink = $(this).find(':selected').attr('data-href');
            var productidp = $(this).find(':selected').attr('dataidp');
            var productqty = $(productidp+" .datapqty").attr('dataqty');
             var refpending = $(productidp+" .refundreq").attr('pendingref');
            $('tr').removeClass('tractive');
            $(productidp).addClass('tractive');
            
            $(".rdqty").attr("max", productqty);
            
            $(".rdqty").val('1');
            
            
            var productamt = $(productidp+" .datapamt").attr('dataamt');
            
            $(".rdamt").val(productprice);
            
            
              var productprice = productamt / productqty;
              
              $(".rdamt").val(productprice);
              
               $(".prcount").text(refpending);
              
              if(refpending >= 1){
                  $('.refpenalert').show();
              }else{
                   $('.refpenalert').hide();
              }
            
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
