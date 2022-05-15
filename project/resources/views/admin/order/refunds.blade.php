@extends('layouts.load')
@section('content')


{{-- ADD ORDER REFUND --}}

<div class="add-product-content1">
    <div class="row">
        <div class="col-lg-12">
            <div class="product-description">
                <div class="body-area">
                    <div class="gocover" style="background: url({{asset('assets/images/'.$gs->admin_loader)}}) no-repeat scroll center center rgba(45, 45, 45, 0.5);"></div>
                 <h4 class="title">{{ __('Refund For Products') }}</h4>
                <div class="row">
				
            <div class="col-lg-12 order-details-table">
			<form id="refundform" action="{{route('admin-order-refund-store')}}" method="POST" enctype="multipart/form-data">
			{{csrf_field()}}
			 @include('includes.admin.form-both')
                <div class="mr-table">
                   
                    <div class="table-responsiv">
					
                        <table id="example2" class="table table-hover dt-responsive" cellspacing="0" width="100%">
                            <thead>
								<tr>
								    <th >{{ __('Image') }}</th>
								    <th >{{ __('Details') }}</th>
									<th >{{ __('Cost') }}</th>
									<th >{{ __('Qty') }}</th>
									<th>{{ __('Total') }}</th>
									<th>{{ __('Reason') }}</th>
								</tr>
							</thead>

                            <tbody>
							@php
                            $count = count($cart->items);
							$i=1;
                            @endphp
							<input type="hidden" id="pr_count" class="pr_count" name="pr_count" value="{{ $count }}">
                             <?php $sum_price = array(); ?>
                            @foreach($cart->items as $key => $product)
						
										@php
                                        $vendorName = App\Models\User::find($product['item']['user_id']);
                                        @endphp
									
                                        @php
                                        $ProductDetails = App\Models\Product::find($product['item']['id']);
                                        @endphp
										
										@php
										$orderid=$order->id;
                                        $vdetails = App\Models\VendorOrder::all()->where('order_id',$orderid)->where('product_id',$product['item']['id']);										
                                        @endphp										
                                         <?php  
                                              if($vdetails) {
                                              foreach($vdetails as $item){
                                                 
                                                if($item->product_item_price) {
                                                       $sum_price[$product['item']['id']]= $item->product_item_price;
                                                 }
                                              }
                                           }
                                          
                                         ?>																		

                                <tr>    
                                     <input type="hidden" id="rproduct_id" name="rproduct_id{{$i}}" value="{{$product['item']['id']}}">                                
                                    <td><img src="{{ $product['item']['photo'] ? filter_var($product['item']['photo'], FILTER_VALIDATE_URL) ?$product['item']['photo']:asset('assets/images/products/'.$product['item']['photo']):asset('assets/images/noimage.png') }}" alt="{{$product['item']['photo']}}"> </td>
                                    
                                    <td>
                                         <input type="hidden" value="{{ $product['license'] }}">            
                                        @if($product['item']['user_id'] != 0)
                                        @php
                                        $user = App\Models\User::find($product['item']['user_id']);
                                        @endphp
                                        @if(isset($user))
                                      <a target="_blank" href="{{ route('front.product', $product['item']['slug']) }}">{{mb_strlen($product['item']['name'],'utf-8') > 130 ? mb_substr($product['item']['name'],0,130,'utf-8').'...' : $product['item']['name']}}</a>
                                        @else
                                        <a target="_blank" href="{{ route('front.product', $product['item']['slug']) }}">{{mb_strlen($product['item']['name'],'utf-8') > 130 ? mb_substr($product['item']['name'],0,130,'utf-8').'...' : $product['item']['name']}}</a>
                                        @endif
                                        @else 
            
                                            <a target="_blank" href="{{ route('front.product', $product['item']['slug']) }}">{{mb_strlen($product['item']['name'],'utf-8') > 130 ? mb_substr($product['item']['name'],0,130,'utf-8').'...' : $product['item']['name']}}</a>
                                    
                                        @endif
            
            
                                        @if($product['license'] != '')
                                            <a href="javascript:;" data-toggle="modal" data-target="#confirm-delete" class="btn btn-info product-btn" id="license" style="padding: 5px 12px;"><i class="fa fa-eye"></i> {{ __('View License') }}</a>
                                        @endif
                                        
                                        <br />
                                        
                                        <strong>SKU : </strong> {{ $ProductDetails->sku }}
                                        
                                        <br /> 
                                        
                                         @if($product['size'])
                                       <p>
                                            <strong>{{ __('Option') }} :</strong> {{str_replace('-',' ',$product['size'])}}
                                       </p>
                                       @endif
                                       @if($product['color'])
                                        <p>
                                                <strong>{{ __('color') }} :</strong> <span
                                                style="width: 40px; height: 20px; display: block; background: #{{$product['color']}};"></span>
                                        </p>
                                        @endif
                                       
                                            @if(!empty($product['keys']))
                                            @foreach( array_combine(explode(',', $product['keys']), explode(',', $product['values']))  as $key => $value)
                                            <p><b>{{ ucwords(str_replace('_', ' ', $key))  }} : </b> {{ $value }} </p>
                                            @php 
											$pr_at = $product['item']['attributes'];
	                                        $pr_arr = json_decode($pr_at, true);
											@endphp
											<b> prices : </b>{{ $pr_arr [$key]['prices'][0] }}</p>
                                            @endforeach
                                            @endif
                                            
                                            
                                            <br />
                                            
                                            <strong>Sold By : </strong> {{$vendorName->shop_name}}
                                        
                                        
                                        
                                    </td>
                                    
                                  
                                    <td>
                                      <p>
                                                 {{$order->currency_sign}}{{ round($product['item']['price'] * $order->currency_value , 2) }}
                                        </p>
                                    </td>
                                    
                                    <td class="qty_td">
                                      
                                       <p>
                                            {{ __('x') }}  {{$product['qty']}} {{ $product['item']['measure'] }} <br /> <input class="form-control" type="number" id="ref_quantity" priceprod="{{ round($product['item']['price'] * $order->currency_value , 2) }}" name="ref_quantity{{$i}}" min="1" max="{{$product['qty']}}" 

                                            @if($vdetails)
                                            @foreach($vdetails as $item)
                                            @if($item->product_item_qty)
											{{__('disabled')}}
                                            @endif
											@endforeach
                                            @endif
                                             > <br />
											@if($vdetails)
                                            @foreach($vdetails as $item)
                                            @if($item->product_item_qty)
											{{__('Refund Qty')}}: {{ $item->product_item_qty }}
                                            @endif
											@endforeach
                                            @endif
											<input type="hidden" class="or_qty" name="or_qty{{$i}}" value="{{$product['qty']}}">
                                       </p>
                                    </td>
                                    
                                      <td class="price_td">
                                      
                                       <p>
                                            {{$order->currency_sign}}{{ round($product['price'] * $order->currency_value , 2) }} <br /> 
                                            <input type="text" class="form-control ref_price" id="ref_price" name="ref_price{{$i}}"
                                             @if($vdetails)                                               
                                            @foreach($vdetails as $item)
                                             @if($item->product_item_qty)
                                            {{__('disabled')}}
                                            @endif
											@endforeach	
                                            @endif	
                                              >	
                                            @if($vdetails)                                               
                                            @foreach($vdetails as $item)
                                             @if($item->product_item_qty)
                                            {{__('Refund Price')}}: {{ $item->product_item_price }}
                                            @endif
											@endforeach	
                                            @endif										
											<input type="hidden" class="or_price" name="or_price{{$i}}" value="{{ round($product['price'] * $order->currency_value , 2) }}">	
											
                                       </p>
                                    </td>
									<td>
									<?php 
										$orderid=$order->id;
										$cls_val='';
                                        $reasondetails = App\Models\VendorOrder::all()->where('order_id',$orderid)->where('product_id',$product['item']['id']);										
                                        if($reasondetails) {                                              
                                            foreach($reasondetails as $item){
                                             if($item->reason){
                                                $cls_val=$item->reason;
										}
										}
										}
											
									?>
                                            									
									<input type="text" class="form-control refund-reason" id="ref_reason" name="ref_reason{{$i}}" <?php if($cls_val) { echo 'disabled'; }?>
                                     value="<?php if($cls_val) { echo $cls_val; }?>">
									</td>
                                    
							

                                </tr>
								@php $i++;
								@endphp
                            @endforeach
                            </tbody>
                        </table>
						
                    </div>
                    
                 
                </div>
                                    
                   <div class="text-right mt-30">				   
                       <strong>Total Refund Amount : </strong> <span id="prval" ></span>
					   <?php if($sum_price) { ?><strong>Total Refunded Amount : </strong> <span id="ramt" ><?php echo array_sum($sum_price); ?></span><?php } ?>
                   </div>				         
                         <input type="hidden" id="total_price" name="total_price" value="">	
						 
                         <input type="hidden" id="order_id" name="order_id" value="{{$order->id}}">							 
						<button class="addProductSubmit-btn pull-right" id="track-btn" type="submit" >Refund Manually</button>
            </form>
			</div>
			
            
        </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
$("#checkAll").click(function () {$('input:checkbox').not(this).prop('checked', this.checked);}); 
$(document).ready(function() {    
     
	 calculateSum();
		$('.addProductSubmit-btn').prop('disabled', true);	
    $(".ref_price").on("keydown keyup", function() {
        calculateSum();
    });
    
    $(document).on('change','#ref_quantity',function () {
        calculateSum();
    });
	
});
function calculateSum() {
    var sum = 0;    
    $(".ref_price").each(function() {
        
        if (!isNaN(this.value) && this.value.length != 0) {
            sum += parseFloat(this.value);            
        }
        else if (this.value.length != 0){
           
        }
    });
         $("#total_price").empty().val(sum);	
         $("#prval").empty().append(sum);
		 $('.addProductSubmit-btn').prop('disabled', false);          
}
	
		
	</script>
@endsection

