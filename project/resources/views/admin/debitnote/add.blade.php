@extends('layouts.admin')
@section('content')
<div class="content-area">
	<div class="mr-breadcrumb">
		<div class="row">
			<div class="col-lg-12">
				<h4 class="heading">{{ __('Debit Note') }} 				
				<ul class="links">
					<li><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }} </a></li>					
					<li><a href="javascript:;">{{ __('Add Debit Note') }}</a></li>					
				</ul>
			</div>
		</div>
	</div>

	<form id="adddebitnoteform" action="{{route('addstore-debitnote-submit')}}" method="POST" enctype="multipart/form-data">
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
                                  
@foreach($vendordata as $vendordatas)
<input type="text" class="vendor_name" value="{{$vendordatas->name}}" readonly>   
<input type="text" class="vendor_state" value="{{$vendordatas->state}}" readonly> 

@if($vendordatas->reg_number)

<input type="text" id="txtGSTIN"  class="gst" value="{{$vendordatas->reg_number}}" />

@endif


									@endforeach
                                    
                                
                                    
                                  
<div class="table-responsive-sm">
<table class="table">
  <tr>
    <th>Product Name</th>
    <th>Amount</th>
    <th>Quantity</th>
    <th>Comission</th>
	<th>Refund</th>
    <th>Exchange</th>
    <th>Payment Status</th>
	<th>Debit Note Created</th>
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
                                    $dispute_data = App\Models\DebitNote::where('order_id','=',$alldata->order_id)->where('vendor_id','=',$alldata->user_id)->where('product_id','=',$alldata->product_id)->get();
                                    
                                    
                                    @endphp
									 
									 
 <tr class="setproduct{{$i}}">
    <td>{{$product_data->name}}</td>
    <td class="datapamt" dataamt="{{$alldata->price}}">{{$alldata->price}}</td>
    <td class="datapqty" dataqty="{{$alldata->qty}}">{{$alldata->qty}}</td>
    <td class="dataadminfee" dataadminfee="{{$alldata->admin_fee}}">{{$alldata->admin_fee}}</td>
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
	@if($vender_data->vendor_request_status=='completed')
	<td class="paystatus" paystatus="paid">Paid</td>
    @elseif($vender_data->vendor_request_status=='NotRaised')
	<td class="paystatus" paystatus="unpaid">Unpaid</td>
	@elseif($vender_data->vendor_request_status=='requested')
	<td class="paystatus" paystatus="request">Request</td>
	@else
		<td class="paystatus" paystatus="">Unpaid</td>
	@endif
	
	@if($dispute_data)
    <td class="refundreq" pendingref="{{ count($dispute_data)}}" refundreq="">{{ count($dispute_data)}}</td>
     @else
    <td class="refundreq" pendingref="{{ count($dispute_data)}}" refundreq="">-</td>
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
                                    <option data-href="{{ route('product-data-pload',$vdatas->product_id) }}" value="{{$vdatas->product_id}}"  data-hreftax="{{ route('product-data-ptload',$vdatas->product_id) }}" value="{{$vdatas->product_id}}"  dataidp=".setproduct{{$j}}">({{$productsku->sku}}) {{$productsku->name}}</option>
									@php $j++ @endphp
                                    @endforeach
					                    </select>
										
										</div>
									</div>	                                    
									<div class="products" style="position : absolute; opacity : 0; visibilty : hidden;"></div>
									
									
											<div class="row">
										<div class="col-lg-12"><div class="left-area"><h4 class="heading">{{ __('Quantity') }}* </h4></div></div>
										<div class="col-lg-12"><input type="number" class="input-field rdqty" placeholder="{{ __('Quantity') }}" name="quantity" min="1"  required=""></div>
									</div>
									
									
									
									
									<div class="row">
										<div class="col-lg-12"><div class="left-area"><h4 class="heading">{{ __('Order Amount') }}* </h4></div></div>
										<div class="col-lg-12"><input type="text" class="input-field rdamt" placeholder="{{ __('Amount') }}" name="calcamount" required="" ></div>
									</div>
									
									
									<div class="row">
										<div class="col-lg-12"><div class="left-area"><h4 class="heading">{{ __('OTHER AMT') }}* </h4></div></div>
										<div class="col-lg-12"><input type="text" class="input-field othersamt" placeholder="{{ __('OTHER AMT') }}" value="0" name="others_amt" ></div>
									</div>
									
									

																												 <div class="row">
										<div class="col-lg-12"><div class="left-area"><h6 class="heading"> {{ __('Payment Type?') }} </h6>  </div><select name="is_payment" class="ispayselect">
										    <option value="Payment to vendor">Payment to Vendor</option>
										    <option value="Comission and Tax">Commission + GST & TCS (If appplicable)</option>
										    <option value="Payment to vendor with Comission and tax">Payment made to vendor + Commission + GST & TCS (If applicable)</option>
										    <option value="Payment to vendor with Comission and tax and shipping charges">Shipping charges + Payment made to vendor + Commission + GST & TCS (If applicable)</option>
											<option value="Shipping Charges">Shipping Charges</option>
										</select></div>
									
									</div>
									
									
									
														 <div class="row">
										<div class="col-lg-12"><a href="javascript:void(0);" class="btn btn-primary btn-calculate"> Calculate Amount </a></div>
									
									</div>
									
									
									
									
																			<div class="row">
										<div class="col-lg-12"><div class="left-area"><h4 class="heading">{{ __('ADMIN FEE') }}* </h4></div></div>
										<div class="col-lg-12"><input type="text" class="input-field adminfeecadmin" placeholder="{{ __('ADMIN FEE') }}" name="adminfee" required="" ></div>
									</div>
									
									<div class="row">
										<div class="col-lg-12"><div class="left-area"><h4 class="heading">{{ __('SGST') }}* </h4></div></div>
										<div class="col-lg-12"><input type="text" class="input-field sgstcadmin" placeholder="{{ __('SGST') }}" name="sgst"  ></div>
									</div>
									
										<div class="row">
										<div class="col-lg-12"><div class="left-area"><h4 class="heading">{{ __('CGST') }}* </h4></div></div>
										<div class="col-lg-12"><input type="text" class="input-field cgstcadmin" placeholder="{{ __('CGST') }}" name="cgst"  ></div>
									</div>
									
																			<div class="row">
										<div class="col-lg-12"><div class="left-area"><h4 class="heading">{{ __('IGST') }}* </h4></div></div>
										<div class="col-lg-12"><input type="text" class="input-field igstcadmin" placeholder="{{ __('igst') }}" name="igst"  ></div>
										
										
										
																											
										
										
										
								
									</div>
									
									
									
											<div class="row">
										<div class="col-lg-12"><div class="left-area"><h4 class="heading">{{ __('Gross Amount') }}* </h4></div></div>
										<div class="col-lg-12"><input type="text" class="input-field grossamt" placeholder="{{ __('gross amount') }}" ></div>
										
										</div>
									
									
										<div class="row">
										<div class="col-lg-12"><div class="left-area"><h4 class="heading">{{ __('TCS') }}* </h4></div></div>
										<div class="col-lg-12"><input type="text" class="input-field tcscadmin" placeholder="{{ __('TCS') }}" name="tcs" ></div>
									</div>
									
									
										<div class="row">
										<div class="col-lg-12"><div class="left-area"><h4 class="heading">{{ __('Net Payment to Vendor') }}* </h4></div></div>
										<div class="col-lg-12"><input type="text" class="input-field amtbeforetaxcadmin" placeholder="{{ __('AMT BEFORE FEES') }}" name="amt_before_tax" ></div>
									</div>
									
									
									
										
										<div class="row">
										<div class="col-lg-12"><div class="left-area"><h4 class="heading">{{ __('REMARKS') }} </h4></div></div>
										<div class="col-lg-12"><input type="text" class="input-field " placeholder="{{ __('REMARKS') }}" name="remarks" ></div>
									</div>
									
									
									
									
									<div class="row">
										<div class="col-lg-12"><div class="left-area"><h4 class="heading">{{ __('Total Deduction Amount') }}* </h4></div></div>
										<div class="col-lg-12"><input type="text" class="input-field finaldnamt" placeholder="{{ __('Total Deduction Amount') }}" name="amount" required="" ></div>
									</div>
									
									
									
									
									
                                    <div class="row">
										<div class="col-lg-12"><div class="left-area"><h4 class="heading">{{ __('Reason *') }} </h4></div></div>
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
                                          
                                          <option value="Shipping Charges">Shipping Charges</option>
                                          
                                          <option value="Penalty for delayed shipping">Penalty for delayed shipping</option>
                                         
                                         <option value="others">others</option>
                                        </select>
										<input type="text" class="input-field" id="reason" placeholder="{{ __('Reason') }}" name="reason" style="display:none;"></div>
									</div> 
                                   <div class="row">
										<div class="col-lg-12"><div class="left-area"><h4 class="heading">{{ __('Upload Attachments') }} </h4></div></div>
										<div class="col-lg-12"><input required type="file" class="form-control" name="screenshot[]" placeholder="Upload Screen Shot" multiple></div>
									</div> 
									
									<div class="row">
										<div class="col-lg-12 text-center">
										<input type="hidden" name="vendor_id" value="{{ $vendorid }}">
										<input type="hidden" name="order_id" value="{{ $orderid }}">
										<div class="modal fade" id="debitmod" tabindex="-1" role="dialog" aria-labelledby="debitmod" aria-hidden="true">                        
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">            
            <div class="modal-body">
                <p class="text-center">Are you Sure You want to Create Debit Note Request?</p>
				<button class="adddebitnoteform-btn btn btn-success" style="margin-top : 0; width:auto; height:auto; font-size : 1rem; 
    background-color: #28a745; border: 1px solid transparent; border-color: #28a745;" type="submit">{{ __('Confirm') }}</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">{{ __('Cancel') }}</button>
            </div>
            </div>
    </div>
</div>
											
												<a href="javascript:;" class="btn btn-info" data-toggle="modal" data-target="#debitmod">{{ __('Add') }}</a>
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
    
    
    
    
    
    $(document).ready(function () {
        
     $(".btn-calculate").click(function(){
         
     
            var qtyr = $(".rdqty").val();
            var productamt = $(".tractive .datapamt").attr('dataamt');
            var productqty = $(".tractive .datapqty").attr('dataqty');
            
            var otheramt = $(".othersamt").val();
            
            var productprice = productamt / productqty;
            
          var total = productprice * qtyr;
          
          var vstate = $(".vendor_state").val();
          
          
             
             var productadminfee = (total*15/100).toFixed(2);
             
             
              
              
                if(vstate == "Tamil Nadu") {
                    
                    var sgstadmin = (productadminfee*9/100).toFixed(2);
             
             var cgstadmin =  (productadminfee*9/100).toFixed(2);
             
              var igstadmin =  0;
                    
                } else {
                    
                    var sgstadmin = 0;
             
             var cgstadmin =  0;
             
              var igstadmin =  (productadminfee*18/100).toFixed(2);
                    
                }
          
              
              
              var amtbeforetcs = (total - productadminfee - sgstadmin - cgstadmin - igstadmin).toFixed(2);
              
 
              
              if(vstate == "Tamil Nadu"){
                    
                    
                    var gstr = $(".gst").val();
                    
                    if(gstr)
                    {
                    
                      var tcsadmin = (amtbeforetcs*1/100).toFixed(2);
                        
                    }else{
                        
                       var tcsadmin = 0; 
                    }
                }else{
                    
                       var tcsadmin = 0; 
                    }
                    
                   
              
              var finaldnamnt  = (amtbeforetcs - tcsadmin);
              
                $(".adminfeecadmin").val(productadminfee);
                
                
                  $(".sgstcadmin").val(sgstadmin);
                  
                    $(".cgstcadmin").val(cgstadmin);
                    
                      $(".igstcadmin").val(igstadmin);
                      
                        $(".tcscadmin").val(tcsadmin);
                        
                        var grsamt = (total - productadminfee - sgstadmin - cgstadmin - igstadmin).toFixed(2);
                        
                        
                        var amountbeforefees = (total - productadminfee - sgstadmin - cgstadmin - igstadmin - tcsadmin).toFixed(2);
              
              
              $(".grossamt").val(grsamt);
              
              $(".amtbeforetaxcadmin").val(amountbeforefees);
              
              var ispay = $('.ispayselect').val();
              
              var feentax = (parseFloat(productadminfee) + parseFloat(sgstadmin) + parseFloat(cgstadmin) + parseFloat(igstadmin) + parseFloat(tcsadmin)).toFixed(2);
              
               var payenttax = parseFloat(finaldnamnt) + parseFloat(feentax);
               
               var payenttaxshipping = parseFloat(finaldnamnt) + parseFloat(feentax) + parseFloat(otheramt);
              
              if (ispay == "Payment to vendor"){
                   $(".finaldnamt").val(finaldnamnt);
              } else if (ispay == "Comission and Tax"){
                   $(".finaldnamt").val(feentax);
              } else if (ispay == "Payment to vendor with Comission and tax"){
                  $(".finaldnamt").val(payenttax);
              } else if (ispay == "Payment to vendor with Comission and tax and shipping charges"){
                  $(".finaldnamt").val(payenttaxshipping);
              } else{
                  $(".finaldnamt").val(otheramt);
                   $(".adminfeecadmin").val(0);
                
                
                  $(".sgstcadmin").val(0);
                  
                    $(".cgstcadmin").val(0);
                    
                      $(".igstcadmin").val(0);
                      
                        $(".tcscadmin").val(0);
                         $(".grossamt").val(0);
              
              $(".amtbeforetaxcadmin").val(0);
              }
              
             
              
     });
              
     
    });

    
    
    



 $(document).on('change','.productid',function () {
	 
            var productlink = $(this).find(':selected').attr('data-href');
            var producttaxlink = $(this).find(':selected').attr('data-hreftax');
            var productidp = $(this).find(':selected').attr('dataidp');
            var productqty = $(productidp+" .datapqty").attr('dataqty');
            $('tr').removeClass('tractive');
            $(productidp).addClass('tractive');
            
            $(".rdqty").attr("max", productqty);
            
            $(".rdqty").val('1');
            
            
            var productamt = $(productidp+" .datapamt").attr('dataamt');
            
            $(".rdamt").val(productprice);
            
            
            var productadminfee = $(productidp+" .dataadminfee").attr('dataadminfee');
           
           
         
          
            
              var productprice = productamt / productqty;
              
              $(".rdamt").val(productprice);			
            if(productlink){
				$('.products').show();
                $('.products').load(productlink);                
            }else{
				$('.products').hide();
			}
			
			
			if(producttaxlink){
				$('.order_taxes').show();
                $('.order_taxes').load(producttaxlink);                
            }else{
				$('.order_taxes').hide();
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
