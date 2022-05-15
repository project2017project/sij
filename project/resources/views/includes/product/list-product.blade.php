                                {{-- If This product belongs to vendor then apply this --}}
                                @if($prod->user_id != 0)

                                {{-- check  If This vendor status is active --}}
                                @if($prod->user->is_vendor == 2)

													     <div class="mad-grid-item">
                    <!-- Product -->
                    <div class="mad-product">
                      <figure class="mad-product-image">
                      @if(!empty($prod->features))
													@foreach($prod->features as $key => $data1)
													<div class="mad-label" style="background-color:{{ $prod->colors[$key] }}">
														{{ $prod->features[$key] }}
														</div>
														@endforeach 
													
						@endif
                        <a href="{{ route('front.product',$prod->slug) }}"><img src="{{ $prod->thumbnail ? asset('assets/images/thumbnails/'.$prod->thumbnail):asset('assets/images/noimage.png') }}" alt=""></a>
                        <div class="overlay">
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


																@if(Auth::guard('web')->check())

																<span class="add-to-wish btn" data-href="{{ route('user-wishlist-add',$prod->id) }}" data-toggle="tooltip" data-placement="right" title="{{ $langg->lang54 }}" data-placement="right"><i class="icofont-heart-alt" ></i>
																</span>

																@else 

																<span rel-toggle="tooltip" title="{{ $langg->lang54 }}" data-toggle="modal" id="wish-btn" data-target="#comment-log-reg" data-placement="right" class="btn">
																	<i class="icofont-heart-alt"></i>
																</span>

																@endif
                        </div>
                      </figure>
                      <!-- product-info -->
                      <div class="mad-product-description">
                        <h5 class="mad-product-title"><a href="{{ route('front.product',$prod->slug) }}">{{ mb_strlen($prod->name,'utf-8') > 35 ? mb_substr($prod->name,0,35,'utf-8').'...' : $prod->name }}</a></h5>
                        <span class="mad-product-price notranslate"><span>{{ $prod->showPreviousPrice() }}</span> {{ $prod->showPrice() }}</span>
                        <div class="stars">
					                                                 <!-- <div class="ratings">
					                                                      <div class="empty-stars"></div>
					                                                      <div class="full-stars" style="width:{{App\Models\Rating::ratings($prod->id)}}%"></div>
					                                                  </div>-->
																		</div>
                      </div>
                      <!--/ product-info -->
                    </div>
                    <!-- End of Product -->
                  </div>



								@endif

                                {{-- If This product belongs admin and apply this --}}

								@else 

													     <div class="mad-grid-item">
                    <!-- Product -->
                    <div class="mad-product">
                      <figure class="mad-product-image">
                      @if(!empty($prod->features))
													@foreach($prod->features as $key => $data1)
													<div class="mad-label" style="background-color:{{ $prod->colors[$key] }}">
														{{ $prod->features[$key] }}
														</div>
														@endforeach 
													
						@endif
                        <a href="{{ route('front.product',$prod->slug) }}"><img src="{{ $prod->thumbnail ? asset('assets/images/thumbnails/'.$prod->thumbnail):asset('assets/images/noimage.png') }}" alt=""></a>
                        <div class="overlay">
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


																@if(Auth::guard('web')->check())

																<span class="add-to-wish btn" data-href="{{ route('user-wishlist-add',$prod->id) }}" data-toggle="tooltip" data-placement="right" title="{{ $langg->lang54 }}" data-placement="right"><i class="icofont-heart-alt" ></i>
																</span>

																@else 

																<span rel-toggle="tooltip" title="{{ $langg->lang54 }}" data-toggle="modal" id="wish-btn" data-target="#comment-log-reg" data-placement="right" class="btn">
																	<i class="icofont-heart-alt"></i>
																</span>

																@endif
                        </div>
                      </figure>
                      <!-- product-info -->
                      <div class="mad-product-description">
                        <h5 class="mad-product-title"><a href="{{ route('front.product',$prod->slug) }}">{{ mb_strlen($prod->name,'utf-8') > 35 ? mb_substr($prod->name,0,35,'utf-8').'...' : $prod->name }}</a></h5>
                        <span class="mad-product-price notranslate"><span>{{ $prod->showPreviousPrice() }}</span> {{ $prod->showPrice() }}</span>
                        <div class="stars">
					                                                  <!--<div class="ratings">
					                                                      <div class="empty-stars"></div>
					                                                      <div class="full-stars" style="width:{{App\Models\Rating::ratings($prod->id)}}%"></div>
					                                                  </div>-->
																		</div>
                      </div>
                      <!--/ product-info -->
                    </div>
                    <!-- End of Product -->
                  </div>

								

								@endif

