			@if (count($vprods) > 0)
					@foreach ($vprods as $key => $prod)




								<div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-6">
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
                                                <img class="primary-img" src="{{ $prod->thumbnail ? asset('assets/images/thumbnails/'.$prod->thumbnail):asset('assets/images/noimage.png') }}" alt="Product Image">
                                                 @foreach($prod->galleries as $gal)
                                                         @if ($loop->first)
                                                         <img class="secondary-img" src="{{asset('assets/images/galleries/'.$gal->photo)}}" alt="{{ $prod->showName() }}">
                                                    @endif
                                                        
                                                     @endforeach
                                            </a>
                                            @if(!empty($prod->features))
													  @foreach($prod->features as $key => $data1)
														<span class="sticker"style="background-color:{{ $prod->colors[$key] }}">{{ $prod->features[$key] }}</span>
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
                            <span class="new-price ">{{ $prod->showPrice() }}</span><span><del> @php
                $sellprice = $prod->showPrice();
                $mrpprice =  $prod->showPreviousPrice();
                @endphp
                
                @if($mrpprice > $sellprice)
                
                {{ $prod->showPreviousPrice() }}
                
                @endif</del></span>
                        <?php  } ?>
                    </div>
                                                <div class="additional-add_action">
                                                    <ul>
                                                        <li>
                                                        	@if(Auth::guard('web')->check())

																<span class="add-to-wish" data-href="{{ route('user-wishlist-add',$prod->id) }}" data-toggle="tooltip" data-placement="right" title="{{ $langg->lang54 }}" data-placement="right"><i class="ion-android-favorite-outline" ></i>
																</span>

																@else

																<span rel-toggle="tooltip" title="{{ $langg->lang54 }}" data-toggle="modal" id="wish-btn" data-target="#comment-log-reg" data-placement="right">
																	<i class="ion-android-favorite-outline"></i>
																</span>

																@endif
                                                        </li>
                                                    </ul>
                                                </div>
                                             <!--   <div class="ratings">
                                <div class="empty-stars"></div>
                                <div class="full-stars" style="width:{{App\Models\Rating::ratings($prod->id)}}%"></div>
                            </div>-->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


									
				@endforeach
				<div class="row" style="width:100%;">
				<div class="text-center" style="width:100%;">
					<div class="page-center mt-5">
						{!! $vprods->appends(['search' => request()->input('search')])->links() !!}
					</div>
				</div>
				</div>
			@else
				<div class="no product-found-shop">
					{{ $langg->lang60 }}
				</div>
			@endif


@if(isset($ajax_check))


<script type="text/javascript">


// Tooltip Section


    $('[data-toggle="tooltip"]').tooltip({
      });
      $('[data-toggle="tooltip"]').on('click',function(){
          $(this).tooltip('hide');
      });




      $('[rel-toggle="tooltip"]').tooltip();

      $('[rel-toggle="tooltip"]').on('click',function(){
          $(this).tooltip('hide');
      });


// Tooltip Section Ends

</script>

@endif