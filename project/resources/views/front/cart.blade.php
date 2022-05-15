@extends('layouts.front')
@section('content')

<!-- Breadcrumb Area Start -->
<!-- <div class="breadcrumb-area">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <ul class="pages">
          <li>
            <a href="{{ route('front.index') }}">
              {{ $langg->lang17 }}
            </a>
          </li>
          <li>
            <a href="{{ route('front.cart') }}">
              {{ $langg->lang121 }}
            </a>
          </li>
        </ul>
      </div>
    </div>
  </div>
</div> -->
<!-- Breadcrumb Area End -->










    <div class="hiraola-cart-area">
            <div class="container">
                <div class="row">
                    <div class="col-12">

        <div class="hiraola-tab_title" style="margin-bottom: 50px;">
                                <h4>VIEW CART</h4>
                            </div>
                            <div class="table-content table-responsive cart-table">
                            @include('includes.form-success')
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th class="hiraola-product-remove">remove</th>
                                            <th class="hiraola-product-thumbnail">images</th>
                                            <th class="cart-product-name">Product</th>
                                            <th class="hiraola-product-price">Unit Price</th>
                                            <th class="hiraola-product-quantity">Quantity</th>
                                            <th class="hiraola-product-subtotal">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>


                                        @if(Session::has('cart'))

                    @foreach($products as $product)
                    <tr class="cremove{{ $product['item']['id'].$product['size'].$product['color'].str_replace(str_split(' ,'),'',$product['values']) }}">
                    <td>
                        <span class="removecart cart-remove" data-class="cremove{{ $product['item']['id'].$product['size'].$product['color'].str_replace(str_split(' ,'),'',$product['values']) }}" data-href="{{ route('product.cart.remove',$product['item']['id'].$product['size'].$product['color'].str_replace(str_split(' ,'),'',$product['values'])) }}"><i class="icofont-ui-delete"></i> </span>
                      </td>
                      <td class="product-img">
                        <div class="item">
                          <img style="width: 80px;" src="{{ $product['item']['photo'] ? filter_var($product['item']['photo'], FILTER_VALIDATE_URL) ?$product['item']['photo']:asset('assets/images/products/'.$product['item']['photo']):asset('assets/images/noimage.png') }}" alt="">
                          
                        </div>
                      </td>
                                            <td>
                                                <p class="name"><a href="{{ route('front.product', $product['item']['slug']) }}">{{mb_strlen($product['item']['name'],'utf-8') > 135 ? mb_substr($product['item']['name'],0,135,'utf-8').'...' : $product['item']['name']}}</a></p>
                                                @if(!empty($product['size']))
                                                <b>@if(!empty($product['item']['variation_title'])){{ $product['item']['variation_title'] }} @else {{ $langg->lang312 }} @endif </b>: {{ $product['item']['measure'] }}{{str_replace('-',' ',$product['size'])}} <br>
                                                @endif
                                                @if(!empty($product['color']))
                                                <div class="d-flex mt-2">
                                                <b>{{ $langg->lang313 }}</b>:  <span id="color-bar" style="border: 10px solid #{{$product['color'] == "" ? "white" : $product['color']}};"></span>
                                                </div>
                                                @endif

                                                    @if(!empty($product['keys']))

                                                    @foreach( array_combine(explode(',', $product['keys']), explode(',', $product['values']))  as $key => $value)

                                                        <b>{{ ucwords(str_replace('_', ' ', $key))  }} : </b> {{ $value }} <br>
                                                    @endforeach

                                                    @endif

                                                  </td>


                                                  <td>
                                                    <p class="product-unit-price">
                          {{ App\Models\Product::convertPrice($product['item']['price']) }}                        
                        </p>
                                                  </td>

                      <td class="unit-price quantity">
                        
          @if($product['item']['type'] == 'Physical')

                          <div class="qty">
                              <ul>
              <input type="hidden" class="prodid" value="{{$product['item']['id']}}">  
              <input type="hidden" class="itemid" value="{{$product['item']['id'].$product['size'].$product['color'].str_replace(str_split(' ,'),'',$product['values'])}}">     
              <input type="hidden" class="size_qty" value="{{$product['size_qty']}}">     
              <input type="hidden" class="size_price" value="{{$product['item']['price']}}">   
                                <li>
                                  <span class="qtminus1 reducing">
                                    <i class="icofont-minus"></i>
                                  </span>
                                </li>
                                <li>
                                  <span class="qttotal1" id="qty{{$product['item']['id'].$product['size'].$product['color'].str_replace(str_split(' ,'),'',$product['values'])}}">{{ $product['qty'] }}</span>
                                </li>
                                <li>
                                  <span class="qtplus1 adding">
                                    <i class="icofont-plus"></i>
                                  </span>
                                </li>
                              </ul>
                          </div>
        @endif


                      </td>

                            @if($product['size_qty'])
                            <input type="hidden" id="stock{{$product['item']['id'].$product['size'].$product['color'].str_replace(str_split(' ,'),'',$product['values'])}}" value="{{$product['size_qty']}}">
                            @elseif($product['item']['type'] != 'Physical') 
                            <input type="hidden" id="stock{{$product['item']['id'].$product['size'].$product['color'].str_replace(str_split(' ,'),'',$product['values'])}}" value="1">
                            @else
                            <input type="hidden" id="stock{{$product['item']['id'].$product['size'].$product['color'].str_replace(str_split(' ,'),'',$product['values'])}}" value="{{$product['stock']}}">
                            @endif

                      <td class="total-price">
                        <p id="prc{{$product['item']['id'].$product['size'].$product['color'].str_replace(str_split(' ,'),'',$product['values'])}}">
                          {{ App\Models\Product::convertPrice($product['price']) }}                 
                        </p>
                      </td>
                      
                    </tr>
                    @endforeach
                    @endif


                                        
                                        
                                    </tbody>
                                </table>
                            </div>
                           <!-- <div class="row">
                                <div class="col-12">
                                    <div class="coupon-all">
                                        <div class="coupon">
                                            <input id="coupon_code" class="input-text" name="coupon_code" value="" placeholder="Coupon code" type="text">
                                            <input class="button" name="apply_coupon" value="Apply coupon" type="submit">
                                        </div>
                                        <div class="coupon2">
                                            <input class="button" name="update_cart" value="Update cart" type="submit">
                                        </div>
                                    </div>
                                </div>
                            </div>  -->

                            @if(Session::has('cart'))
                            <div class="row right-area cartpage">


                                 <div class="col-md-8">

                                

                <!--================ End of Products ================-->
              </div>



                                <div class="col-lg-4">
                                    <div class="cart-page-total right-area">
                                        <h2>Cart totals</h2>
                                        <ul>
                                            <li>Subtotal <span class="cart-total">{{ Session::has('cart') ? App\Models\Product::convertPrice($totalPrice) : '0.00' }}</span></li>
                                            <li>Shipping <span class="cart-total">Free shipping all over India</span></li>
                                            <li>Total <span class="main-total">{{ Session::has('cart') ? App\Models\Product::convertPrice($mainTotal) : '0.00' }}</span></li>
                                        </ul>
                                        <a href="{{ route('front.checkout') }}">Proceed to checkout</a>
                                    </div>
                                </div>
                            </div>
                            @endif
                    </div>
                </div>
            </div>
        </div>



<!-- Cart Area End -->
@endsection 