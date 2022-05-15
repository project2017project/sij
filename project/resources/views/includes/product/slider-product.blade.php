{{-- If This product belongs to vendor then apply this --}}
@if($prod->user_id != 0)

{{-- check  If This vendor status is active --}}
@if($prod->user->is_vendor == 2)
 
<div class="slide-item">
                                <div class="single_product">
                                    
                                     @php
                $sellprice = $prod->showPrice();
                $mrpprice =  $prod->showPreviousPrice();
                @endphp
                
                @if($mrpprice > $sellprice)
                
                <span class="selllabel-list">Sale</span>
                
                @endif
                                    
                                    <div class="product-img">
                                         <a href="{{ route('front.product', $prod->slug) }}">
                                                    <img class="primary-img" src="{{ $prod->thumbnail ? asset('assets/images/thumbnails/'.$prod->thumbnail):asset('assets/images/noimage.png') }}" alt="{{ $prod->showName() }}">
                                                     @foreach($prod->galleries as $gal)
                                                         @if ($loop->first)
                                                         <img class="secondary-img" src="{{asset('assets/images/galleries/'.$gal->photo)}}" alt="{{ $prod->showName() }}">
                                                    @endif
                                                        
                                                     @endforeach
                                                    
                                                </a>


                                                @if(!empty($prod->features))
                                                @foreach($prod->features as $key => $data1)
                                                <span class="sticker" style="background-color:{{ $prod->colors[$key] }}">{{ $prod->features[$key] }}</span>
                                                @endforeach 

                                                @endif


                                        <div class="add-actions">
                                            <ul>
                                            	<li>

                                            		  @if($prod->emptyStock())
       <span class="add-to-cart-btn cart-out-of-stock btn">
        <i class="icofont-close-circled"></i> {{ $langg->lang78 }}
        </span>													
        @else
        
        
         <?php 
                            if(!empty($prod->size_price)){?>
                               <a class="btn select_option" href="{{ route('front.product', $prod->slug) }}">
        <i class="icofont-cart"></i> Select Option
        </a> 
                                 <?php   //echo '<span class="new-price notranslate">$'. min($prod->size_price);
                            }else{
                        ?>
                            <span class="add-to-cart add-to-cart-btn  btn" data-href="{{ route('product.cart.add',$prod->id) }}">
        <i class="icofont-cart"></i> {{ $langg->lang56 }}
        </span> 
                        <?php  } ?>
        
       
        @endif	
                                            	</li>


                                            </ul>
                                        </div>
                                    </div>
                                    <div class="hiraola-product_content">
                                        <div class="product-desc_info">
                                            <h6><a class="product-name" href="{{ route('front.product', $prod->slug) }}">{{ $prod->showName() }}</a></h6>
                                            <div class="price-box notranslate">
                            



                        <?php 
                            if(!empty($prod->size_price)){?>
                                <span class="new-price ">{{ $prod->showPriceNew() }}<span>
                                 <?php   //echo '<span class="new-price notranslate">$'. min($prod->size_price);
                            }else{
                        ?>
                            <span class="new-price ">{{ $prod->showPrice() }}</span><span><del> {{ $prod->showPreviousPrice() }}</del></span>
                        <?php  } ?>
                    </div>
                                            <div class="additional-add_action">
                                                <ul>
                                                    <li>

                                                    	@if(Auth::guard('web')->check())

                                                    	<span class="hiraola-add_compare add-to-wish btn" data-href="{{ route('user-wishlist-add',$prod->id) }}" data-toggle="tooltip" data-placement="top" title="Add To Wishlist"><i class="ion-android-favorite-outline"></i>
                                                    	</span>

                                                    	@else 

                                                    	<span class="hiraola-add_compare btn" data-toggle="modal" id="wish-btn" data-target="#comment-log-reg" data-placement="right"  data-toggle="tooltip" data-placement="top" title="Add To Wishlist">
                                                    		<i class="ion-android-favorite-outline"></i>
                                                    	</span>

                                                    	@endif


                                                  




                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="rating-box">

                                            <div class="stars">
<!--<div class="ratings">
<div class="empty-stars"></div>
<div class="full-stars" style="width:{{App\Models\Rating::ratings($prod->id)}}%"></div>
</div>-->
</div>
                                                <!--ul>
                                                    <li><i class="fa fa-star-of-david"></i></li>
                                                    <li><i class="fa fa-star-of-david"></i></li>
                                                    <li><i class="fa fa-star-of-david"></i></li>
                                                    <li><i class="fa fa-star-of-david"></i></li>
                                                    <li class="silver-color"><i class="fa fa-star-of-david"></i></li>
                                                </ul-->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>










@endif

{{-- If This product belongs admin and apply this --}}

@else 


<div class="slide-item">
                                <div class="single_product">
                                    <div class="product-img">
                                         <a href="{{ route('front.product', $prod->slug) }}">
                                                    <img class="primary-img" src="{{ $prod->thumbnail ? asset('assets/images/thumbnails/'.$prod->thumbnail):asset('assets/images/noimage.png') }}" alt="Product Image">
                                                   @foreach($prod->galleries as $gal)
                                                         @if ($loop->first)
                                                         <img class="secondary-img" src="{{asset('assets/images/galleries/'.$gal->photo)}}" alt="{{ $prod->showName() }}">
                                                    @endif
                                                        
                                                     @endforeach                                              
                                                </a>


                                                @if(!empty($prod->features))
                                                @foreach($prod->features as $key => $data1)
                                                <span class="sticker" style="background-color:{{ $prod->colors[$key] }}">{{ $prod->features[$key] }}</span>
                                                @endforeach 

                                                @endif


                                        <div class="add-actions">
                                            <ul>
                                            	<li>

                                            	  @if($prod->emptyStock())
       <span class="add-to-cart-btn cart-out-of-stock btn">
        <i class="icofont-close-circled"></i> {{ $langg->lang78 }}
        </span>													
        @else
        
        
         <?php 
                            if(!empty($prod->size_price)){?>
                               <a class="btn select_option" href="{{ route('front.product', $prod->slug) }}">
        <i class="icofont-cart"></i> Select Option
        </a> 
                                 <?php   //echo '<span class="new-price notranslate">$'. min($prod->size_price);
                            }else{
                        ?>
                            <span class="add-to-cart add-to-cart-btn  btn" data-href="{{ route('product.cart.add',$prod->id) }}">
        <i class="icofont-cart"></i> {{ $langg->lang56 }}
        </span> 
                        <?php  } ?>
        
       
        @endif	
                                            	</li>


                                            </ul>
                                        </div>
                                    </div>
                                    <div class="hiraola-product_content">
                                        <div class="product-desc_info">
                                            <h6><a class="product-name" href="{{ route('front.product', $prod->slug) }}">{{ $prod->showName() }}</a></h6>
                    <div class="price-box notranslate">
                            



                    	<?php 
                            if(!empty($prod->size_price)){?>
                                <span class="new-price ">{{ $prod->showPriceNew() }}<span>
                                 <?php   //echo '<span class="new-price notranslate">$'. min($prod->size_price);
                            }else{
                        ?>
                            <span class="new-price ">{{ $prod->showPrice() }}</span><span><del> {{ $prod->showPreviousPrice() }}</del></span>
                        <?php  } ?>
                    </div>
                                            <div class="additional-add_action">
                                                <ul>
                                                    <li>

                                                    	@if(Auth::guard('web')->check())

                                                    	<span class="hiraola-add_compare add-to-wish btn" data-href="{{ route('user-wishlist-add',$prod->id) }}" data-toggle="tooltip" data-placement="top" title="Add To Wishlist"><i class="ion-android-favorite-outline"></i>
                                                    	</span>

                                                    	@else 

                                                    	<span class="hiraola-add_compare btn" data-toggle="modal" id="wish-btn" data-target="#comment-log-reg" data-placement="right"  data-toggle="tooltip" data-placement="top" title="Add To Wishlist">
                                                    		<i class="ion-android-favorite-outline"></i>
                                                    	</span>

                                                    	@endif


                                                  




                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="rating-box">

                                            <div class="stars">
<!--<div class="ratings">
<div class="empty-stars"></div>
<div class="full-stars" style="width:{{App\Models\Rating::ratings($prod->id)}}%"></div>
</div>-->
</div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
					
@endif