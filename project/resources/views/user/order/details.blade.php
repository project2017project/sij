@extends('layouts.front')
@section('content')
<!-- User Dashbord Area Start -->
<section class="user-dashbord">
    <div class="container">
        <div class="row">
            @include('includes.user-dashboard-sidebar')
            <div class="col-lg-8">
                <div class="user-profile-details">
                    <div class="order-details">

                        <div class="process-steps-area">
                            @include('includes.order-process')

                        </div>


                        <div class="header-area">
                            <h4 class="title">
                                {{ $langg->lang284 }}
                            </h4>
                        </div>
                        <div class="view-order-page">
                            <h3 class="order-code">{{ $langg->lang285 }} {{$order->order_number}} [{{$order->status}}]
                            </h3>
                            <div class="print-order text-right">
                                <a href="{{route('user-order-print',$order->id)}}" target="_blank"
                                    class="print-order-btn">
                                    <i class="fa fa-print"></i> INVOICE
                                </a>
                            </div>
                            <p class="order-date">{{ $langg->lang301 }} {{date('d-M-Y',strtotime($order->created_at))}}
                            </p>

                            @if($order->dp == 1)

                            <div class="billing-add-area">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h5>{{ $langg->lang287 }}</h5>
                                        <address>
                                            {{ $langg->lang288 }} {{$order->customer_name}}<br>
                                            {{ $langg->lang289 }} {{$order->customer_email}}<br>
                                            {{ $langg->lang290 }} {{$order->customer_phone}}<br>
                                            {{ $langg->lang291 }} {{$order->customer_address}}<br>
                                            @if($order->order_note != null)
                                            {{ $langg->lang801 }}: {{$order->order_note}}<br>
                                            @endif
                                            {{$order->customer_city}}-{{$order->customer_zip}}
                                        </address>
                                    </div>
                                    <div class="col-md-6">
                                        <h5>{{ $langg->lang292 }}</h5>

                                        <p>{{ $langg->lang798 }}:
                                             {!! $order->payment_status == 'Pending' ? "<span class='badge badge-danger'>". $langg->lang799 ."</span>":"<span class='badge badge-success'>". $langg->lang800 ."</span>" !!}
                                        </p>

                                        <p>{{ $langg->lang293 }}
                                            {{$order->currency_sign}}{{ round($order->pay_amount * $order->currency_value , 2) }}
                                        </p>
                                        <p>{{ $langg->lang294 }} {{$order->method}}</p>

                                        @if($order->method != "Cash On Delivery")
                                        @if($order->method=="Stripe")
                                        {{$order->method}} {{ $langg->lang295 }} <p>{{$order->charge_id}}</p>
                                        @endif
                                        {{$order->method}} {{ $langg->lang296 }} <p id="ttn">{{$order->txnid}}</p>
                                        <a id="tid" style="cursor: pointer;" class="mybtn2">{{ $langg->lang297 }}</a> 

                                        <form id="tform">
                                            <input style="display: none; width: 100%;" type="text" id="tin" placeholder="{{ $langg->lang299 }}" required="" class="mb-3">
                                            <input type="hidden" id="oid" value="{{$order->id}}">

                                            <button style="display: none; padding: 5px 15px; height: auto; width: auto; line-height: unset;" id="tbtn" type="submit" class="mybtn1">{{ $langg->lang300 }}</button>
                                                
                                                <a style="display: none; cursor: pointer;  padding: 5px 15px; height: auto; width: auto; line-height: unset;" id="tc"  class="mybtn1">{{ $langg->lang298 }}</a>
                                                
                                                {{-- Change 1 --}}
                                        </form>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            @else
                            <div class="shipping-add-area">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h5>{{ $langg->lang302 }}</h5>
                                        <address>
                                            {{ $langg->lang288 }}
                                            {{$order->shipping_name == null ? $order->customer_name : $order->shipping_name}}<br>
                                            {{ $langg->lang289 }}
                                            {{$order->shipping_email == null ? $order->customer_email : $order->shipping_email}}<br>
                                            {{ $langg->lang290 }}
                                            {{$order->shipping_phone == null ? $order->customer_phone : $order->shipping_phone}}<br>
                                            {{ $langg->lang291 }}
                                            {{$order->shipping_address == null ? $order->customer_address : $order->shipping_address}}<br>
                                            {{$order->shipping_city == null ? $order->customer_city : $order->shipping_city}}-{{$order->shipping_zip == null ? $order->customer_zip : $order->shipping_zip}}
                                        </address>
                                       

                                    </div>
                                    
                                </div>
                            </div>
                            <div class="billing-add-area">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h5>{{ $langg->lang287 }}</h5>
                                        <address>
                                            {{ $langg->lang288 }} {{$order->customer_name}}<br>
                                            {{ $langg->lang289 }} {{$order->customer_email}}<br>
                                            {{ $langg->lang290 }} {{$order->customer_phone}}<br>
                                            {{ $langg->lang291 }} {{$order->customer_address}}<br>
                                            @if($order->order_note != null)
                                            {{ $langg->lang801 }}: {{$order->order_note}}<br>
                                            @endif
                                            {{$order->customer_city}}-{{$order->customer_zip}}
                                        </address>
                                    </div>
                                    <div class="col-md-6">
                                        <h5>{{ $langg->lang292 }}</h5>

                                        <p>{{ $langg->lang798 }}
                                             {!! $order->payment_status == 'Pending' ? "<span class='badge badge-danger'>". $langg->lang799 ."</span>":"<span class='badge badge-success'>". $langg->lang800 ."</span>" !!}
                                        </p>



                                        <p>{{ $langg->lang293 }}
                                            {{$order->currency_sign}}{{ round($order->pay_amount * $order->currency_value , 2) }}
                                        </p>
                                        <p>{{ $langg->lang294 }} {{$order->method}}</p>
                                        	@php
                                            $ship_cost = $order->shipping_cost + $order->packing_cost;
                                            @endphp
                                        
                                        <p>
                                            Shipping Cost : @if($ship_cost == 0)Free Shipping @else{{ App\Models\Currency::where('sign',$order->currency_sign)->first()->name }} {{ round($ship_cost, 2) }} @endif
                                        </p>

                                        @if($order->method != "Cash On Delivery")
                                        @if($order->method=="Stripe")
                                        {{$order->method}} {{ $langg->lang295 }} <p>{{$order->charge_id}}</p>
                                        @endif
                                        <!--{{$order->method}} {{ $langg->lang296 }} <p id="ttn"> {{$order->txnid}}</p>-->

                                       <!-- <a id="tid" style="cursor: pointer;" class="mybtn2">{{ $langg->lang297 }}</a> 

                                        <form id="tform">
                                            <input style="display: none; width: 100%;" type="text" id="tin" placeholder="{{ $langg->lang299 }}" required="" class="mb-3">
                                            <input type="hidden" id="oid" value="{{$order->id}}">

                                            <button style="display: none; padding: 5px 15px; height: auto; width: auto; line-height: unset;" id="tbtn" type="submit" class="mybtn1">{{ $langg->lang300 }}</button>
                                                
                                                <a style="display: none; cursor: pointer;  padding: 5px 15px; height: auto; width: auto; line-height: unset;" id="tc"  class="mybtn1">{{ $langg->lang298 }}</a>
                                                
                                                {{-- Change 1 --}}
                                        </form>-->
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endif
                            <br>




                            <div class="table-responsive">
                                <h5>{{ $langg->lang308 }}</h5>
                                <table class="table table-bordered veiw-details-table">
                                    <thead>
                                        <tr>
                                           <!-- <th width="5%">{{ $langg->lang309 }}</th>-->
                                            <th>Image</th>
                                            <th width="35%">{{ $langg->lang310 }}</th>
                                            <th width="20%">{{ $langg->lang539 }}</th>
                                            <th>{{ $langg->lang314 }}</th>
                                            <th>{{ $langg->lang315 }}</th>
                                           <!-- <th>Review</th>-->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                        @foreach($cart->items as $product)
                                       @if($product['item']['user_id'] != 0)
                                                @php
                                                $user = App\Models\User::find($product['item']['user_id']);
                                                $productsku = App\Models\Product::find($product['item']['id']);
                                                @endphp
												@endif
                                        
                                        <tr>
                                           <!-- <td>{{ $product['item']['id'] }}</td>-->
                                            <td><img src="../../assets/images/products/{{ $product['item']['photo'] }} " style="width: 40px;"></td>
                                            <td>
                                                <input type="hidden" value="{{ $product['license'] }}">
                                                

                                                @if($product['item']['user_id'] != 0)
                                                @php
                                                $user = App\Models\User::find($product['item']['user_id']);
                                                @endphp
                                                @if(isset($user))
                                                <a class="inline-btn" target="_blank"
                                                    href="{{ route('front.product', $product['item']['slug']) }}">{{ $product['item']['name']}} x {{$product['qty']}} {{ $product['item']['measure'] }}</a><br> 
                    <span>{{'SKU : '.$productsku->sku}}</span> <br />
                    <span>{{'Sold By :'. $user->name}}</span>
                                                @else
                                                <a class="inline-btn" target="_blank"
                                                    href="{{ route('front.product', $product['item']['slug']) }}">{{ $product['item']['name']}} x {{$product['qty']}} {{ $product['item']['measure'] }}</a><br> 
                    <span>{{'SKU : '.$productsku->sku}}</span> <br />
                    <span>{{'Sold By :'. $user->name}}</span>
                                                @endif
                                                @else

                                                <a target="_blank" class="d-block"
                                                    href="{{ route('front.product', $product['item']['slug']) }}">{{mb_strlen($product['item']['name'],'utf-8') > 30 ? mb_substr($product['item']['name'],0,30,'utf-8').'...' : $product['item']['name']}}</a>

                                                @endif
                                                @if($product['item']['type'] != 'Physical')
                                                @if($order->payment_status == 'Completed')
                                                @if($product['item']['file'] != null)
                                                <a href="{{ route('user-order-download',['slug' => $order->order_number , 'id' => $product['item']['id']]) }}"
                                                    class="btn btn-sm btn-primary mt-1">
                                                    <i class="fa fa-download"></i> {{ $langg->lang316 }}
                                                </a>
                                                @else
                                                <a target="_blank" href="{{ $product['item']['link'] }}"
                                                    class="btn btn-sm btn-primary mt-1">
                                                    <i class="fa fa-download"></i> {{ $langg->lang316 }}
                                                </a>
                                                @endif
                                                @if($product['license'] != '')
                                                <a href="javascript:;" data-toggle="modal" data-target="#confirm-delete"
                                                    class="btn btn-sm btn-info product-btn mt-1" id="license"><i
                                                        class="fa fa-eye"></i> {{ $langg->lang317 }}</a>
                                                @endif
                                                @endif
                                                @endif
                                            </td>
                                            <td>     @php
                                       $refundqty = App\Models\VendorOrder::where('order_id','=',$order->id)->where('user_id','=',$product['item']['user_id'])->where('product_id','=',$product['item']['id'])->first();
                                        @endphp
                                        <p>
                                                <b>{{ $langg->lang311 }}</b>: {{$product['qty']}} <br> </p>
                                                
                                                
                                                @if(!empty($refundqty->product_item_qty))
                                       <p class="text-danger">
                                            <strong>{{ __(' Refund Qty') }} :</strong> {{ $refundqty->product_item_qty}}
                                       </p>
                                       @endif
                                                
                                                
                                                @if(!empty($product['size']))
                                                <b>Option</b>: {{ $product['item']['measure'] }}{{str_replace('-',' ',$product['size'])}} <br>
                                                @endif
                                                @if(!empty($product['color']))
                                                <div class="d-flex mt-2">
                                                <b>{{ $langg->lang313 }}</b>:  <span id="color-bar" style="border: 10px solid {{$product['color'] == "" ? "white" : '#'.$product['color']}};"></span>
                                                </div>
                                                @endif

                                                    @if(!empty($product['keys']))

                                                    @foreach( array_combine(explode(',', $product['keys']), explode(',', $product['values']))  as $key => $value)

                                                        <b>{{ ucwords(str_replace('_', ' ', $key))  }} : </b> {{ $value }} 
                                                    @php 
											$pr_at = $product['item']['attributes'];
	                                        $pr_arr = json_decode($pr_at, true);
											@endphp
											<b> prices : </b>{{ $pr_arr [$key]['prices'][0] }}<br>
                                            @endforeach

                                                    @endif

                                                  </td>
                                            <td>{{$order->currency_sign}}{{round($product['item']['price'] * $order->currency_value,2)}}
                                            </td>
                                            <td><p>{{$order->currency_sign}}{{round($product['price'] * $order->currency_value,2)}}</p>
                                            
                                            
                                        
                                         @if(!empty($refundqty->product_item_price))
                                    <p class="text-danger"> <strong>Refund Amount : </strong> {{$order->currency_sign}}{{ round($refundqty->product_item_price * $order->currency_value , 2) }}</p>
                                    @endif
                                            
                                            
                                            </td>
                                            <!--<td> 
                                            @if($order->status == 'completed') 
                                                <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#myreviewModal">Rate Product</button>
                                            @else

                                            You can rate the product after delivery


                                            @endif
                                                <div class="modal fade" id="myreviewModal" role="dialog">
                                                	<div class="modal-dialog">
                                                		<div class="modal-content">
                                                			<div class="modal-header">
                                                				<button type="button" class="close" data-dismiss="modal">&times;</button>
                                                				<h4 class="modal-title" style="width: 100%; padding-top: 30px; text-align: center;">Order Review</h4>
                                                			</div>
													        <div class="modal-body">
													          <div id="product-details-tab">
                                                                <?php //echo count($prev);?>
                                                                @if(count($prev)>0)
                                                                     @foreach($prev as $about)
                                                                     <div class="stars-area">
                                        <ul class="stars">
                                          <div class="ratings">
                          <div class="empty-stars"></div>
                          <div class="full-stars" style="width:{{App\Models\Rating::ratings($about->product_id)}}%"></div>
                        </div>
                                        </ul>
                                      </div>

                                <p style="float: left; margin-right: 20px;">
                                    <img src="{{ $about->image ? asset('assets/images/review/'.$about->image):asset('assets/images/noimage.png') }}" width="50px">
                                </p>

                                    <div class="review-body"><p>{{$about->review}}</p></div>
                                                                         {{$about->rating}}

                                                                     @endforeach
                                                                @else



													            <div id="replay-area">
													            
													            <div class="review-area">
													                <div class="star-area">
													                  <ul class="star-list">
													                    <li class="stars" data-val="1"><i class="fas fa-star"></i></li>
													                    <li class="stars" data-val="2"><i class="fas fa-star"></i><i class="fas fa-star"></i></li>
													                    <li class="stars" data-val="3"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></li>
													                    <li class="stars" data-val="4"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></li>
													                    <li class="stars active" data-val="5"><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></li>
													                  </ul>
													                </div>
													              </div>
													             <div class="write-comment-area">
													                <div class="gocover" style="background: url({{ asset('assets/images/'.$gs->loader) }}) no-repeat scroll center center rgba(45, 45, 45, 0.5);"></div>
													                <form id="reviewform" action="{{route('front.review.submit')}}" data-href="{{ route('front.reviews',$product['item']['id']) }}" method="POST">
													                  @include('includes.admin.form-both')
													                  {{ csrf_field() }}
													                  <input type="hidden" id="rating" name="rating" value="5">
													                  <input type="hidden" name="user_id" value="{{Auth::guard('web')->user()->id}}">
													                  <input type="hidden" name="product_id" value="{{$product['item']['id']}}">
													                  <div class="row">
													                    <div class="col-lg-12">
													                      	<textarea name="review" placeholder="{{ $langg->lang99 }}" required=""></textarea>            	
													                        <input type="file" class="form-control" name="photo"  />
													                    </div>
													                  </div>
													                  <div class="row">
													                    <div class="col-lg-12">
													                      <button class="submit-btn" type="submit">{{ $langg->lang100 }}</button>
													                    </div>
													                  </div>
													                </form>
													              </div>
													              </div>
                                                              @endif
													          </div>
													        </div>
													    </div>
      
												    </div>
												</div>
                                            </td>-->
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="edit-account-info-div">
                                    <div class="form-group">
                                        <a class="back-btn" href="{{ route('user-orders') }}">{{ $langg->lang318 }}</a><!--
                                        <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#myrefundModal">Refund</button>-->
                                        <div class="modal fade" id="myrefundModal" role="dialog">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                <h4 class="modal-title" style="width: 100%; padding-top: 30px; text-align: center;">Refund</h4>
                                                            </div>
                                                            <div class="modal-body">
                                                              <div id="product-details-tab">
                                                                <div id="replay-area">                                                             
                                                                 <div class="write-comment-area">
                                                                    <div class="gocover" style="background: url({{ asset('assets/images/'.$gs->loader) }}) no-repeat scroll center center rgba(45, 45, 45, 0.5);"></div>
                                                                    
                                                                    @if(count($refundcreated)=='0')
                                                                    <form enctype="multipart/form-data" id="refundform" action="{{route('front.refund.submit')}}" method="POST">
                                                                      @include('includes.admin.form-both')
                                                                      {{ csrf_field() }}
                                                                      <select class="form-control" name="idqtypricename">
                                                                          <option>
                                                                              Select Product For Refund
                                                                          </option>
                                                                          @foreach($cart->items as $product)
                                                                          <option value="{{ $product['item']['id'] }}/{{$product['qty']}}/{{round($product['price'] * $order->currency_value,2)}}/{{$product['item']['user_id']}}">{{ $product['item']['name'] }}</option>
                                                                          @endforeach
                                                                      </select>

                                                                      <input type="hidden" id="orderId" name="OrderId" value="{{$order->id}}">
                                                                      <input type="hidden" name="user_id" value="{{Auth::guard('web')->user()->id}}">
                                                                     <input type="hidden" id="statusare" name="statusare" value="requested">
                                                                      <div class="row">
                                                                        <div class="col-lg-12">
                                                                            <textarea name="review" placeholder="{{ $langg->lang99 }}" required=""></textarea>              
                                                                        <input type="file" class="form-control" name="refundimage"  />
                                                                        </div>
                                                                      </div>
                                                                      <div class="row">
                                                                        <div class="col-lg-12">
                                                                          <button class="submit-btn" type="submit">{{ $langg->lang100 }}</button>
                                                                        </div>
                                                                      </div>
                                                                    </form>
                                                                    @else

                                                                     
                                                                        @foreach($refundcreated as $refundvalue)
                                                                        Customer Comments
                                                                        Product Name        : {{$refundvalue->product_id}}
                                                                        Refund Request ID   : {{$refundvalue->id}}
                                                                        Reason              : {{$refundvalue->reason}}
                                                                        Image               : {{asset('assets/images/refund/').$refundvalue->image}}
                                                                        Date for request    : {{$refundvalue->created_at}}
                                                                        @if($refundvalue->status!='requested')
                                                                        Status:{{$refundvalue->status}}
                                                                        Admin Comments      : {{$refundvalue->adminMessage}}
                                                                        Date for request    : {{$refundvalue->updated_at}}
                                                                        This request has closed for further details and support email us at info@southindiajewels.com with refund request Id.
                                                                        @endif
                                                                        @endforeach
                                                                        

                                                                    @endif

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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="modal1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header d-block text-center">
                <h4 class="modal-title d-inline-block">{{ $langg->lang319 }}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <p class="text-center">{{ $langg->lang320 }} <span id="key"></span></p>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-danger" data-dismiss="modal">{{ $langg->lang321 }}</button>
            </div>
        </div>
    </div>
</div>

@endsection


@section('scripts')

<script type="text/javascript">
    $('#example').dataTable({
        "ordering": false,
        'paging': false,
        'lengthChange': false,
        'searching': false,
        'ordering': false,
        'info': false,
        'autoWidth': false,
        'responsive': true
    });
</script>
<script>
    $(document).on("click", "#tid", function (e) {
        $(this).hide();
        $("#tc").show();
        $("#tin").show();
        $("#tbtn").show();
    });
    $(document).on("click", "#tc", function (e) {
        $(this).hide();
        $("#tid").show();
        $("#tin").hide();
        $("#tbtn").hide();
    });
    $(document).on("submit", "#tform", function (e) {
        var oid = $("#oid").val();
        var tin = $("#tin").val();
        $.ajax({
            type: "GET",
            url: "{{URL::to('user/json/trans')}}",
            data: {
                id: oid,
                tin: tin
            },
            success: function (data) {
                $("#ttn").html(data);
                $("#tin").val("");
                $("#tid").show();
                $("#tin").hide();
                $("#tbtn").hide();
                $("#tc").hide();
            }
        });
        return false;
    });
</script>
<script type="text/javascript">
    $(document).on('click', '#license', function (e) {
        var id = $(this).parent().find('input[type=hidden]').val();
        $('#key').html(id);
    });
</script>
@endsection