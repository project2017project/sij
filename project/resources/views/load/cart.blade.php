									

										
 
    

      <div id="cart-items">


      @if(Session::has('cart'))


       <div class="minicart-content" >

      <ul class="minicart-list">
                    @foreach(Session::get('cart')->items as $product)


                    <li class="minicart-product cremove{{ $product['item']['id'].$product['size'].$product['color'].str_replace(str_split(' ,'),'',$product['values']) }}">
                                 <button class="product-item_remove cart-remove" data-class="cremove{{ $product['item']['id'].$product['size'].$product['color'].str_replace(str_split(' ,'),'',$product['values']) }}" data-href="{{ route('product.cart.remove',$product['item']['id'].$product['size'].$product['color'].str_replace(str_split(' ,'),'',$product['values'])) }}" title="Remove Product"><i class="ion-android-close"></i></button>
                                <a href="{{ route('front.product', $product['item']['slug']) }}" class="product-item_img">
                                    <img src="{{ $product['item']['photo'] ? filter_var($product['item']['photo'], FILTER_VALIDATE_URL) ?$product['item']['photo']:asset('assets/images/products/'.$product['item']['photo']):asset('assets/images/noimage.png') }}" alt="product">
                                </a>
                                <div class="product-item_content">
                                    <a class="product-item_title" href="{{ route('front.product',$product['item']['slug']) }}">{{mb_strlen($product['item']['name'],'utf-8') > 145 ? mb_substr($product['item']['name'],0,145,'utf-8').'...' : $product['item']['name']}}</a>
                                    @if($product['size'])<p><b>option : </b>{{$product['size']}}</p>@endif
                                    <span class="product-item_quantity"><span class="cart-product-qty" id="cqt{{$product['item']['id'].$product['size'].$product['color'].str_replace(str_split(' ,'),'',$product['values'])}}">{{$product['qty']}}</span><span>{{ $product['item']['measure'] }}</span>x<span id="prct{{$product['item']['id'].$product['size'].$product['color'].str_replace(str_split(' ,'),'',$product['values'])}}">{{ App\Models\Product::convertPrice($product['item']['price']) }}</span></span>
                                </div>
                            </li>





                    
                      @endforeach

               </ul>


     <div class="sc-footer">
   <div class="minicart-item_total subtotal sc-footer">
    <span>Subtotal</span>
    <span class="ammount total-price cart-total">{{ Session::has('cart') ? App\Models\Product::convertPrice(Session::get('cart')->totalPrice) : '0.00' }}</span>
  </div>
  <div class="minicart-btn_area">
    <a href="{{ route('front.cart') }}" class="hiraola-btn hiraola-btn_dark hiraola-btn_fullwidth">View Cart</a>
  </div>
  <div class="minicart-btn_area">
    <a href="{{ route('front.checkout') }}" class="hiraola-btn hiraola-btn_dark hiraola-btn_fullwidth">Checkout</a>
  </div>

  </div>

   </div>




    @else <div class="minicart-content">
                  <p class="mt-1 pl-3 text-left">{{ $langg->lang8 }}</p> 


                  <div class="minicart-btn_area">
    <a href="{{ route('front.cart') }}" class="hiraola-btn hiraola-btn_dark hiraola-btn_fullwidth">Continue Shopping</a>
  </div>


                  </div>





                  @endif

                  </div>






								