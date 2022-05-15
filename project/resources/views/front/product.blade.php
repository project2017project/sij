@extends('layouts.front')

@section('content')
<?php $dataimage=array();
$dataimage=explode(',',$productt->size_image); ?>
 @php
$total_stock = 0;
@endphp	
@if($productt->stock || $productt->size_qty)
	@php
$total_stock = $productt->stock;
@endphp
@if(!empty($productt->size_qty))
 @foreach($productt->size_qty as $skey => $skeydata)
@php
$total_stock += $productt->size_qty[$skey];
@endphp 

 @endforeach
 @endif 
@endif


<section class="product-details-page">
  <div class="container">
    <div class="row">
    <div class="col-lg-12">
        <div class="row">

            <div class="col-lg-6 col-md-12">
                
                @php
                $sellprice = $productt->showPrice();
                $mrpprice =  $productt->showPreviousPrice();
                @endphp
                
                @if($mrpprice > $sellprice)
                
                <span class="selllabel">Sale</span>
                
                @endif
                
              <div class="xzoom-container">
                     <div class="preview-xzoom">
                  <img class="xzoom5" id="xzoom-magnific" src="{{filter_var($productt->photo, FILTER_VALIDATE_URL) ?$productt->photo:asset('assets/images/products/'.$productt->photo)}}" xoriginal="{{filter_var($productt->photo, FILTER_VALIDATE_URL) ?$productt->photo:asset('assets/images/products/'.$productt->photo)}}" />
                  </div>
                  <div class="xzoom-thumbs">
                    <div class="xzoom-inner-container">
                    <div class="all-slider">

                        <a href="{{filter_var($productt->photo, FILTER_VALIDATE_URL) ?$productt->photo:asset('assets/images/products/'.$productt->photo)}}">
                      <img class="xzoom-gallery5" width="80" src="{{filter_var($productt->photo, FILTER_VALIDATE_URL) ?$productt->photo:asset('assets/images/products/'.$productt->photo)}}" title="The description goes here">
                        </a>

                    @foreach($productt->galleries as $gal)


                        <a href="{{asset('assets/images/galleries/'.$gal->photo)}}">
                      <img class="xzoom-gallery5" width="80" src="{{asset('assets/images/galleries/'.$gal->photo)}}" title="The description goes here">
                        </a>

                    @endforeach
					
					
				
					  @foreach($dataimage as $datimg)

                        @if(!empty($datimg))

                        <a href="{{asset('assets/images/products/'.$datimg)}}">
                      <img class="xzoom-gallery5" width="80" src="{{asset('assets/images/products/'.$datimg)}}" title="The description goes here">
                        </a>
                        
                           @endif

                    @endforeach
                 
                    
                  

               
                    
                    
                    

                    </div>
                    </div>


                  </div>
              </div>

            </div>

            <div class="col-lg-6">
              <div class="right-area">
                <div class="product-info">
                  <h4 class="product-name">{{ $productt->name }}</h4>
                  
                  
                  
                  
                  
              
                  
                  
                  @if(!empty($dataimage))
					  @foreach($dataimage as $datimg)


                  
                       

                    @endforeach
                    @endif
                  
                  
                  <div class="info-meta-1">
                    <ul>
                        
                      @if($productt->type == 'Physical') 
                                @if(($productt->sum_stock) == 0)
                            
                                    <li class="product-outstook">
                                        
                                        <p>
                                          <i class="icofont-close-circled"></i>
                                          {{ $langg->lang78 }}
                
                                         <form id="notifyform" style="width : 100%; margin : 15px 0;">
                                             
                                            <div class="input-group">
                                                 <input type="hidden" name="product_id" value="{{ $productt->id }}">
                                                  <input  class="form-control" type="email" name="email" id="email"  placeholder="Enter Email" required="">
                                                <div class="input-group-btn" style="margin-left : -5px;">
                                                  <button class="btn btn-danger submit-btn" type="submit"> <i class="icofont-envelope"></i> Notify Me</button>
                                                </div>
                                            </div>
                                                {{csrf_field()}}
                                                
                                                @include('includes.admin.form-both') 
                                               
                                           
                                             
                                          </form>
                                        
                                        </p>
                                        <p class="successmsg"></p>
                                      </li>
                                      
                                      
                                      
                                  @endif
                            
                            @else
                                <!--  @if($productt->emptyStock())
                                  
                                  <li class="product-outstook">
                                    <p class="successmsg"></p>
                                    <p>
                                      <i class="icofont-close-circled"></i>
                                      {{ $langg->lang78 }}
            
                                     <form id="notifyform" >-->
                                      <!-- <form id="notifyform" action="{{route('front.notify.submit')}}" method="POST"> -->
                               <!--             {{csrf_field()}}
                                            
                                            @include('includes.admin.form-both') 
                                            <input type="hidden" name="product_id" value="{{ $productt->id }}">
                                        <input type="text" name="email" id="email"  placeholder="{{ $langg->lang49 }} *" required="">
                                                        <i class="icofont-envelope"></i>
                                         <button class="submit-btn" type="submit">{{ $langg->lang52 }}</button>
                                      </form>
                                    </p>
                                  </li>-->
                                  
                              <!--    @else 
                                  <li class="product-isstook">
                                    <p>
                                      <i class="icofont-check-circled"></i>
                                      {{ $gs->show_stock == 0 ? '' : $productt->stock }} {{ $langg->lang79 }}
                                    </p>
                                  </li>
                                  
                                     
                                  @endif-->
                      @endif
                      <li>
                        <!--<div class="ratings">
                          <div class="empty-stars"></div>
                          <div class="full-stars" style="width:{{App\Models\Rating::ratings($productt->id)}}%"></div>
                        </div>-->
                      </li>
                      <li class="review-count">
                       <!-- <p>{{count($productt->ratings)}} {{ $langg->lang80 }}</p>-->
                      </li>
                        @if($productt->product_condition != 0)
                     <li>
                       <div class="{{ $productt->product_condition == 2 ? 'mybadge' : 'mybadge1' }}">
                        {{ $productt->product_condition == 2 ? 'New' : 'Used' }}
                       </div>
                     </li>
                        @endif
                    </ul>
                    
                    
                      <div class="product-price">
                          @php
                $sellprice = $productt->showPrice();
                $mrpprice =  $productt->showPreviousPrice();
                
            
                
                @endphp
                
                   @if($productt->size_price < 1)
                @php
                 $sellpricen = $productt->price;
                $mrppricen =  $productt->previous_price;
                
                $discount = ((int)$mrppricen) - ((int)$sellpricen);
                $discountpi = (int)$discount / (int)$mrppricen;
                
                $discountpercentage = round($discountpi * 100, 2);
                @endphp
                
                @endif
             
                          
                     
                          
              <p class="title" style="display: none;"><b>{{ $langg->lang87 }} :</b></p>
                    
              
                    <p class="price"><span id="sizeprice">{{ $productt->showPrice() }}</span>
                      <small>
                
                @if($mrpprice > $sellprice)
                
                <del>{{ $productt->showPreviousPrice() }}</del> <span class="text-danger">{{$discountpercentage}}% off</span>
                
                @endif</small></p>
                      
                      
                    
                  </div>
                    
                     <div class="seller-info mt-3">
        <div class="content">
          <h4 class="title">
            {{ $langg->lang246 }}
          </h4>
          
          

       

          <p class="stor-name">
           @if( $productt->user_id  != 0)
              @if(isset($productt->user))
                 <a href="{{ route('front.vendor',str_replace(' ', '-', $productt->user->shop_name)) }}"> {{ $productt->user->shop_name }} </a>
                @if($productt->user->checkStatus())
                <br>
                <a class="verify-link" href="{{ route('front.vendor',str_replace(' ', '-', $productt->user->shop_name)) }}"  data-toggle="tooltip" data-placement="top" title="{{ $langg->lang783 }}">
                  {{--  {{ $langg->lang783 }}  --}}
                  <i class="fas fa-check-circle"></i>
                
                </a>
                @endif

              @else
                {{ $langg->lang247 }}
              @endif
          @else
             <a href="{{ route('front.vendor',str_replace(' ', '-', $productt->user->shop_name)) }}"> {{ App\Models\Admin::find(1)->shop_name }} </a>
          @endif
          </p>
          
          
          
          
          
         

       
        </div>
  

                  {{-- CONTACT SELLER --}}



                 
                  {{-- CONTACT SELLER ENDS --}}

      </div>


                    
                    
                 
                  
                  </div>



          
                  
                  
                  <div class="product_short_desc">
                      {!! $productt->short_details !!}
                     
          </div>
          
          
              @if($productt->stock == '1')
                
                  <div class="text-danger" style="display:block; opacity : 1;" role="alert">
                     Only 1 Left In Stock
                  </div>
                 
                  @endif

                  <div class="info-meta-2">
                    <ul>

                      @if($productt->type == 'License')

                      @if($productt->platform != null)
                      <li>
                        <p>{{ $langg->lang82 }}: <b>{{ $productt->platform }}</b></p>
                      </li>
                      @endif

                      @if($productt->region != null)
                      <li>
                        <p>{{ $langg->lang83 }}: <b>{{ $productt->region }}</b></p>
                      </li>
                      @endif

                      @if($productt->licence_type != null)
                      <li>
                        <p>{{ $langg->lang84 }}: <b>{{ $productt->licence_type }}</b></p>
                      </li>
                      @endif

                      @endif

                    </ul>
                  </div>


                                            
                  @if(!empty($productt->size))
                  <div class="product-size">
                      @if(!empty($productt->variation_title))
                    <p class="title"><b>Choose {{$productt->variation_title}} :</b></p>
                     @else
                     <p class="title"><b>Choose @if(!empty($productt->variation_title)) {{$productt->variation_title}} @else Option @endif :</b></p>
                     @endif

                    <div class="selectbox_wrap_list_optin">Choose </div>

                    <ul class="siz-list">					
                        @php
                        $is_first = false;
                        @endphp
                     
                        @foreach($productt->size as $key => $data1)
                      
                        <li class="stock-<?php echo $productt->size_qty[$key];?> {{ $is_first ? 'active' : '' }}">
                            
                            <span class="box">{{ $data1 }}<span class="qty-label">&nbsp; [Sold Out]</span>
                                <span class="qty-price font-s-0">&nbsp; ({{$productt->size_price[$key]}})</span>
                                <input type="hidden" class="size" value="{{ $data1 }}">
                                <input type="hidden" class="size_qty" value="{{ $productt->size_qty[$key] }}">
                                <input type="hidden" class="size_key" value="{{$key}}">
                                <input type="hidden" class="size_price" value="{{ round($productt->size_price[$key] * $curr->value,2) }}">
                                @if(!empty($productt->size_image))
                                <a href="@if(@$dataimage[$key]){{asset('assets/images/products/'.@$dataimage[$key])}}@else @endif" class="variation_imgage_for_sl">
                                <img src="@if(@$dataimage[$key]){{asset('assets/images/products/'.@$dataimage[$key])}}@else @endif" class="xzoom-gallery5">
                                </a>
                                @endif
                            </span>
                        </li>
                        @php
                        $is_first = false;
                        @endphp
                      
                        @endforeach
                      
                        
                    </ul>
                    
                   <span class="os-stock">out of stock</span>
                  </div>
                  @endif
                  
                 


                  @if(!empty($productt->color))
                  <div class="product-color">
                    <p class="title">{{ $langg->lang89 }} :</p>
                    <ul class="color-list">
                      @php
                      $is_first = true;
                      @endphp
                      @foreach($productt->color as $key => $data1)
                      <li class="{{ $is_first ? 'active' : '' }}">
                        <span class="box" data-color="{{ $productt->color[$key] }}" style="background-color: {{ $productt->color[$key] }}"></span>
                      </li>
                      @php
                      $is_first = false;
                      @endphp
                      @endforeach

                    </ul>
                  </div>
                  @endif

                  @if(!empty($productt->size))

                  <input type="hidden" id="stock" value="{{ $productt->size_qty[0] }}">
                  @else
                  @php
                  $stck = (string)$productt->stock;
                  @endphp
                  @if($stck != null)
                  <input type="hidden" id="stock" value="{{ $stck }}">
                  @elseif($productt->type != 'Physical')
                  <input type="hidden" id="stock" value="0">
                  @else
                  <input type="hidden" id="stock" value="">
                  @endif

                  @endif
                  <input type="hidden" id="product_price" value="{{ round($productt->vendorPrice() * $curr->value,2) }}">

                  <input type="hidden" id="product_id" value="{{ $productt->id }}">
                  <input type="hidden" id="curr_pos" value="{{ $gs->currency_format }}">
                  <input type="hidden" id="curr_sign" value="{{ $curr->sign }}">
                  <div class="info-meta-3">
                    <ul class="meta-list">
                      @if($productt->product_type != "affiliate")
                      <li class="d-block count {{ $productt->type == 'Physical' ? '' : 'd-none' }}">
                        <div class="qty">
                          <ul>
                            <li>
                              <span class="qtminus">
                                <i class="icofont-minus"></i>
                              </span>
                            </li>
                            <li>
                              <span class="qttotal">1</span>
                            </li>
                            <li>
                              <span class="qtplus">
                                <i class="icofont-plus"></i>
                              </span>
                            </li>
                          </ul>
                        </div>
                      </li>
                      @endif

                      @if (!empty($productt->attributes))
                        @php
                          $attrArr = json_decode($productt->attributes, true);
                        @endphp
                      @endif
                      @if (!empty($attrArr))
                        <div class="product-attributes my-4">
                          <div class="row">
                          @foreach ($attrArr as $attrKey => $attrVal)
                            @if (array_key_exists("details_status",$attrVal) && $attrVal['details_status'] == 1)

                          <div class="col-lg-6">
                              <div class="form-group mb-2">
                                <strong for="" class="text-capitalize">{{ str_replace("_", " ", $attrKey) }} :</strong>
                                <div class="">
                              
                                    
                                @foreach ($attrVal['values'] as $optionKey => $optionVal)
                                  <div class="custom-control custom-radio">
                                    <input type="hidden" class="keys" value="">
                                    <input type="hidden" class="values" value="">
                                    <input type="checkbox" id="{{$attrKey}}{{ $optionKey }}" name="{{ $attrKey }}" class="custom-control-input product-attr"  data-key="{{ $attrKey }}" data-price = "{{ $attrVal['prices'][$optionKey] * $curr->value }}" value="{{ $optionVal }}" {{ $loop->first ? '' : '' }}>
                                    <label class="custom-control-label" for="{{$attrKey}}{{ $optionKey }}">{{ $optionVal }}

                                    @if (!empty($attrVal['prices'][$optionKey]))
                                      +
                                      {{$curr->sign}} {{$attrVal['prices'][$optionKey] * $curr->value}}
                                    @endif
                                    </label>
                                  </div>
                                @endforeach
                                </div>
                              </div>
                          </div>
                            @endif
                          @endforeach
                          </div>
                        </div>
                      @endif
                      
                            @if (!empty($productt->attributes))
                      <div class="product-addon-totals" style="display : none;">
                          <ul>
                              <li>
                                  <div class="wc-pao-col1">
                                      <strong><span class="qtycalc">1</span> x {{ $productt->name }}</strong>
                                    </div>
                                    <div class="wc-pao-col2">
                                          <strong>
                                              <span class=curr_sign"">{{$curr->sign}}</span><span class="amount" id="calcprice">{{ $productt->showPrice() }}</span>
                                              </strong>
                                              </div>
                              </li>
                              
                              <li class="addon_li">
                                  
                              </li>
                              
                                <li>
                                  <div class="wc-pao-col1">
                                      
                                    </div>
                                    <div class="wc-pao-col2">
                                          <strong>
                                             Subtotal :  <span class=curr_sign"">{{$curr->sign}}</span><span class="subtotalamtli"></span>
                                              </strong>
                                              </div>
                              </li>
                              
                             <!-- <li class="wc-pao-subtotal-line">
                                  <p class="price">Subtotal <span class="amount">{{ $productt->showPrice() }}</span>
                                   </p>
                              </li>-->
                         </ul>
                      </div>
                      
                      @endif
                      

                      @if($productt->product_type == "affiliate")

                      <li class="addtocart">
                        <a href="{{ route('affiliate.product', $productt->slug) }}" target="_blank"> BUY NOW</a>
                      </li>
                      @else
                      @if($productt->emptyStock())
                      <li class="addtocart">
                        <a href="javascript:;" class="cart-out-of-stock">
                          <i class="icofont-close-circled"></i>
                          {{ $langg->lang78 }}</a>
                      </li>
                      @elseif($productt->sum_stock == 0)
                      <li class="addtocart">
                        <a href="javascript:;" class="cart-out-of-stock">
                          <i class="icofont-close-circled"></i>
                          {{ $langg->lang78 }}</a>
                      </li>
                      @else
                      <li class="addtocart">
                        <a href="javascript:;" id="addcrt">BUY NOW</a>
                      </li>

                      <!-- <li class="addtocart">
                        <a id="qaddcrt" href="javascript:;">
                          <i class="icofont-cart"></i>{{ $langg->lang251 }}
                        </a>
                      </li> -->
                      @endif

                      @endif

                      @if(Auth::guard('web')->check())
                      <li class="favorite">
                        <a href="javascript:;" class="add-to-wish"
                          data-href="{{ route('user-wishlist-add',$productt->id) }}"><i class="icofont-heart-alt"></i></a>
                      </li>
                      @else
                      <li class="favorite">
                        <a href="javascript:;" data-toggle="modal" data-target="#comment-log-reg"><i
                            class="icofont-heart-alt"></i></a>
                      </li>
                      @endif
                      <!-- <li class="compare">
                        <a href="javascript:;" class="add-to-compare"
                          data-href="{{ route('product.compare.add',$productt->id) }}"><i class="icofont-exchange"></i></a>
                      </li> -->
                    </ul>
                  </div>
                 <!-- <div class="social-links social-sharing a2a_kit a2a_kit_size_32">
                    <ul class="link-list social-links">
                      <li>
                        <a class="facebook a2a_button_facebook" href="">
                          <i class="fab fa-facebook-f"></i>
                        </a>
                      </li>
                     
                      <li>
                        <a class="twitter a2a_button_twitter" href="">
                          <i class="fab fa-twitter"></i>
                        </a>
                      </li>
                      <li>
                       <a class="linkedin a2a_button_linkedin" href="">
                          <i class="fab fa-linkedin-in"></i>
                        </a>
                      </li>
                      <li>
                        <a class="pinterest a2a_button_pinterest" href="">
                          <i class="fab fa-pinterest-p"></i>
                        </a>
                      </li>
                    </ul>
                  </div>-->
                  <script async src="https://static.addtoany.com/menu/page.js"></script>


                  @if($productt->ship != null)
                    <p class="estimate-time">{{ $langg->lang86 }}: <b> {{ $productt->ship }}</b></p>
                  @endif
                  @if( $productt->sku != null )
                  <p class="p-sku">
                    {{ $langg->lang77 }}: <span class="idno">{{ $productt->sku }}</span>
                  </p>
                  @endif
                  
                  
                  
                 @if( $productt->category_id != null ) <a href="{{route('front.category', $productt->category->slug)}}">  {{ $productt->category->name }} </a> @endif
                 @if( $productt->subcategory_id != null ) - <a href="{{route('front.category', [$productt->category->slug, $productt->subcategory->slug])}}">  {{ $productt->subcategory->name }} </a> @endif
                 @if( $productt->childcategory_id != null ) - <a href="{{route('front.category', [$productt->category->slug, $productt->subcategory->slug, $productt->childcategory->slug])}}"> {{ $productt->childcategory->name }} </a>  @endif
                  
                  
                   @if($productt->tags != null)
                    <p class="estimate-time"><b>Tags: </b> <span>{!! !empty($productt->tags) ? implode('</span>, <span>', $productt->tags ): '' !!}</span></p>
                  @endif
                  
                  
                  
                 <!--  @if($productt->tags != null)
					  @foreach($productt->tags as $tag)

                        <a class="{{ isset($tags) ? ($tag == $tags ? 'active' : '') : ''}}" href="{{ route('front.tag',$tag) }}">
                            {{ $tag }}
                        </a>
                        

                    @endforeach
                    @endif-->
                  
                   
                 
                  
                  
                  
                  
   <!--    @if($gs->is_report)

      {{-- PRODUCT REPORT SECTION --}}

                    @if(Auth::guard('web')->check())

                    <div class="report-area">
                        <a href="javascript:;" data-toggle="modal" data-target="#report-modal"><i class="fas fa-flag"></i> {{ $langg->lang776 }}</a>
                    </div>

                    @else

                    <div class="report-area">
                        <a href="javascript:;" data-toggle="modal" data-target="#comment-log-reg"><i class="fas fa-flag"></i> {{ $langg->lang776 }}</a>
                    </div>
                    @endif

      {{-- PRODUCT REPORT SECTION ENDS --}}

      @endif -->



                </div>
              </div>
            </div>

          </div>
         
    </div>
    <div class="col-lg-3">

      @if(!empty($productt->whole_sell_qty))
      <div class="table-area wholesell-details-page">
        <h3>{{ $langg->lang770 }}</h3>
        <table class="table">
          <tr>
            <th>{{ $langg->lang768 }}</th>
            <th>{{ $langg->lang769 }}</th>
          </tr>
          @foreach($productt->whole_sell_qty as $key => $data1)
          <tr>
            <td>{{ $productt->whole_sell_qty[$key] }}+</td>
            <td>{{ $productt->whole_sell_discount[$key] }}% {{ $langg->lang771 }}</td>
          </tr>
          @endforeach
        </table>
      </div>
      @endif


     












      <div class="categori  mt-30" style="display:none;">
        <div class="section-top">
            <h2 class="section-title">
                {{ $langg->lang245 }}
            </h2>
        </div>
                        <div class="hot-and-new-item-slider">

                          @foreach($vendors->chunk(3) as $chunk)
                            <div class="item-slide">
                              <ul class="item-list">
                                @foreach($chunk as $prod)
                                  @include('includes.product.list-product')
                                @endforeach
                              </ul>
                            </div>
                          @endforeach

                        </div>

    </div>




    </div>

    </div>
    <div class="row">
      <div class="col-lg-12">

      </div>
    </div>
  </div>






 <!-- Begin Hiraola's Single Product Tab Area -->
        <div class="hiraola-product-tab_area-2 sp-product-tab_area">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="sp-product-tab_nav ">
                            <div class="product-tab">
                                <ul class="nav product-menu">
                                    <li><a class="active" data-toggle="tab" href="#description"><span>Description</span></a>
                                    </li>
                                    <li><a data-toggle="tab" href="#reviews"><span>{{ $langg->lang94 }}({{ count($productt->ratings) }})</span></a></li>
                                </ul>
                            </div>
                            <div class="tab-content hiraola-tab_content">
                                <div id="description" class="tab-pane active show" role="tabpanel">
                                    <div class="product-description">
                                        {!! $productt->details !!}
                                                       
      @if($productt->youtube != null)              
                    <iframe width="840" height="630"
src="{{ $productt->youtube }}">
</iframe>
    @endif          
                                    </div>
                                </div>
                                
                                <div id="reviews" class="tab-pane" role="tabpanel">
                                    <div class="tab-pane active" id="tab-review">
                                      <div class="heading-area">
                          
                          <div class="reating-area">
                            <div class="stars"><h4 class="title">
                            {{ $langg->lang96 }}
                          </h4><span id="star-rating">{{App\Models\Rating::rating($productt->id)}}</span> <i
                                class="fas fa-star"></i></div>
                          </div>
                        </div>
                        <div id="replay-area">
                          <div id="reviews-section">
                            @if(count($productt->ratings) > 0)
                            <ul class="all-replay">
                              @foreach($productt->ratings as $review)
                              <li>
                                <div class="single-review">
                                  <div class="left-area">
                                    <img
                                      src="{{ $review->user->photo ? asset('assets/images/users/'.$review->user->photo):asset('assets/images/noimage.png') }}"
                                      alt="">
                                    <h5 class="name">{{ $review->user->name }}</h5>
                                    <p class="date">
                                      {{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$review->review_date)->diffForHumans() }}
                                    </p>
                                  </div>
                                  <div class="right-area">
                                    <div class="header-area">
                                      <div class="stars-area">
                                        <ul class="stars">
                                          <div class="ratings">
                                            <div class="empty-stars"></div>
                                            <div class="full-stars" style="width:{{$review->rating*20}}%"></div>
                                          </div>
                                        </ul>
                                      </div>
                                    </div>
                                    <div class="review-body">
                                      <p>
                                        {{$review->review}}
                                      </p>
                                      <p>
                                        <a href="{{asset('assets/images/review/'.$review->image)}}" target="_BLANK"><img src="{{asset('assets/images/review/'.$review->image)}}" width="50px"></a>
                                      </p>
                                    </div>
                                  </div>
                                </div>
                                @endforeach
                              </li>
                            </ul>
                            @else
                            <p>{{ $langg->lang97 }}</p>
                            @endif
                          </div>
                          @if(Auth::guard('web')->check())
                          <div class="review-area" style="display: none;">
                            <h4 class="title">{{ $langg->lang98 }}</h4>
                            <div class="star-area">
                              <ul class="star-list">
                                <li class="stars" data-val="1">
                                  <i class="fas fa-star"></i>
                                </li>
                                <li class="stars" data-val="2">
                                  <i class="fas fa-star"></i>
                                  <i class="fas fa-star"></i>
                                </li>
                                <li class="stars" data-val="3">
                                  <i class="fas fa-star"></i>
                                  <i class="fas fa-star"></i>
                                  <i class="fas fa-star"></i>
                                </li>
                                <li class="stars" data-val="4">
                                  <i class="fas fa-star"></i>
                                  <i class="fas fa-star"></i>
                                  <i class="fas fa-star"></i>
                                  <i class="fas fa-star"></i>
                                </li>
                                <li class="stars active" data-val="5">
                                  <i class="fas fa-star"></i>
                                  <i class="fas fa-star"></i>
                                  <i class="fas fa-star"></i>
                                  <i class="fas fa-star"></i>
                                  <i class="fas fa-star"></i>
                                </li>
                              </ul>
                            </div>
                          </div>
                          <!-- <div class="write-comment-area" style="display: none;">
                            <div class="gocover"
                              style="background: url({{ asset('assets/images/'.$gs->loader) }}) no-repeat scroll center center rgba(45, 45, 45, 0.5);">
                            </div>
                            <form id="reviewform" action="{{route('front.review.submit')}}"
                              data-href="{{ route('front.reviews',$productt->id) }}" method="POST">
                              @include('includes.admin.form-both')
                              {{ csrf_field() }}
                              <input type="hidden" id="rating" name="rating" value="5">
                              <input type="hidden" name="user_id" value="{{Auth::guard('web')->user()->id}}">
                              <input type="hidden" name="product_id" value="{{$productt->id}}">
                              <div class="row">
                                <div class="col-lg-12">
                                  <textarea name="review" placeholder="{{ $langg->lang99 }}" required=""></textarea>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col-lg-12">
                                  <button class="submit-btn" type="submit">{{ $langg->lang100 }}</button>
                                </div>
                              </div>
                            </form>
                          </div> -->
                          @else
                          <!-- <div class="row">
                            <div class="col-lg-12">
                              <br>
                              <h5 class="text-center"><a href="javascript:;" data-toggle="modal" data-target="#comment-log-reg"
                                  class="btn login-btn mr-1">{{ $langg->lang101 }}</a> {{ $langg->lang102 }}</h5>
                              <br>
                            </div>
                          </div> -->
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
        <!-- Hiraola's Single Product Tab Area End Here -->








<div class="hiraola-product-tab_area-2" style="margin-bottom : 40px;">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="product-tab">
                            <div class="hiraola-tab_title">
                               <h4>{{ $langg->lang216 }}</h4>
                            </div>
                        </div>
                        
                        <div class="shop-product-wrap grid gridview-4 home-4productsrow row mt-10">
                               	@foreach($productt->category->products()->where('status','=',1)->where('id','!=',$productt->id)->take(8)->get()
          as $prod)
          @include('includes.product.slider-product')
          @endforeach
                         </div>
                    </div>
                </div>
            </div>
        </div>




{{-- MESSAGE MODAL --}}
        <div class="message-modal">
          <div class="modal" id="vendorform" tabindex="-1" role="dialog" aria-labelledby="vendorformLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="vendorformLabel">{{ $langg->lang118 }}</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <div class="container-fluid p-0">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="contact-form">
                          <form id="emailreply1">
                            {{csrf_field()}}
                            <ul>
                              <li>
                                <input type="text" class="input-field" id="subj1" name="subject"
                                  placeholder="{{ $langg->lang119}}" required="">
                              </li>
                              <li>
                                <textarea class="input-field textarea" name="message" id="msg1"
                                  placeholder="{{ $langg->lang120 }}" required=""></textarea>
                              </li>
                              <input type="hidden"  name="type" value="Ticket">
                            </ul>
                            <button class="submit-btn" id="emlsub" type="submit">{{ $langg->lang118 }}</button>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
        </div>
  {{-- MESSAGE MODAL ENDS --}}


  @if(Auth::guard('web')->check())

  @if($productt->user_id != 0)

  {{-- MESSAGE VENDOR MODAL --}}


  <div class="modal" id="vendorform1" tabindex="-1" role="dialog" aria-labelledby="vendorformLabel1" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="vendorformLabel1">{{ $langg->lang118 }}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="container-fluid p-0">
            <div class="row">
              <div class="col-md-12">
                <div class="contact-form">
                  <form id="emailreply">
                    {{csrf_field()}}
                    <ul>

                      <li>
                        <input type="text" class="input-field" readonly=""
                          placeholder="Send To {{ $productt->user->shop_name }}" readonly="">
                      </li>

                      <li>
                        <input type="text" class="input-field" id="subj" name="subject"
                          placeholder="{{ $langg->lang119}}" required="">
                      </li>

                      <li>
                        <textarea class="input-field textarea" name="message" id="msg"
                          placeholder="{{ $langg->lang120 }}" required=""></textarea>
                      </li>

                      <input type="hidden" name="email" value="{{ Auth::guard('web')->user()->email }}">
                      <input type="hidden" name="name" value="{{ Auth::guard('web')->user()->name }}">
                      <input type="hidden" name="user_id" value="{{ Auth::guard('web')->user()->id }}">
                      <input type="hidden" name="vendor_id" value="{{ $productt->user->id }}">

                    </ul>
                    <button class="submit-btn" id="emlsub1" type="submit">{{ $langg->lang118 }}</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>


  {{-- MESSAGE VENDOR MODAL ENDS --}}


  @endif

  @endif

</div>


@if($gs->is_report)

@if(Auth::check())

{{-- REPORT MODAL SECTION --}}

<div class="modal fade" id="report-modal" tabindex="-1" role="dialog" aria-labelledby="report-modal-Title" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

 <div class="gocover" style="background: url({{ asset('assets/images/'.$gs->loader) }}) no-repeat scroll center center rgba(45, 45, 45, 0.5);"></div>

                    <div class="login-area">
                        <div class="header-area forgot-passwor-area">
                            <h4 class="title">{{ $langg->lang777 }}</h4>
                            <p class="text">{{ $langg->lang778 }}</p>
                        </div>
                        <div class="login-form">

                            <form id="reportform" action="{{ route('product.report') }}" method="POST">

                              @include('includes.admin.form-login')

                                {{ csrf_field() }}
                                <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                                <input type="hidden" name="product_id" value="{{ $productt->id }}">
                                <div class="form-input">
                                    <input type="text" name="title" class="User Name" placeholder="{{ $langg->lang779 }}" required="">
                                    <i class="icofont-notepad"></i>
                                </div>

                                <div class="form-input">
                                  <textarea name="note" class="User Name" placeholder="{{ $langg->lang780 }}" required=""></textarea>
                                </div>

                                <button type="submit" class="submit-btn">{{ $langg->lang196 }}</button>
                            </form>
                        </div>
                    </div>
      </div>
    </div>
  </div>
</div>

{{-- REPORT MODAL SECTION ENDS --}}

@endif

@endif

@endsection


@section('scripts')

<script type="text/javascript">

  $(document).on("submit", "#emailreply1", function () {
    var token = $(this).find('input[name=_token]').val();
    var subject = $(this).find('input[name=subject]').val();
    var message = $(this).find('textarea[name=message]').val();
    var $type  = $(this).find('input[name=type]').val();
    $('#subj1').prop('disabled', true);
    $('#msg1').prop('disabled', true);
    $('#emlsub').prop('disabled', true);
    $.ajax({
      type: 'post',
      url: "{{URL::to('/user/admin/user/send/message')}}",
      data: {
        '_token': token,
        'subject': subject,
        'message': message,
        'type'   : $type
      },
      success: function (data) {
        $('#subj1').prop('disabled', false);
        $('#msg1').prop('disabled', false);
        $('#subj1').val('');
        $('#msg1').val('');
        $('#emlsub').prop('disabled', false);
        if(data == 0)
          toastr.error("Oops Something Goes Wrong !!");
        else
          toastr.success("Message Sent !!");
        $('.close').click();
      }

    });
    return false;
  });

</script>


<script type="text/javascript">

  $(document).on("submit", "#emailreply", function () {
    var token = $(this).find('input[name=_token]').val();
    var subject = $(this).find('input[name=subject]').val();
    var message = $(this).find('textarea[name=message]').val();
    var email = $(this).find('input[name=email]').val();
    var name = $(this).find('input[name=name]').val();
    var user_id = $(this).find('input[name=user_id]').val();
    var vendor_id = $(this).find('input[name=vendor_id]').val();
    $('#subj').prop('disabled', true);
    $('#msg').prop('disabled', true);
    $('#emlsub').prop('disabled', true);
    $.ajax({
      type: 'post',
      url: "{{URL::to('/vendor/contact')}}",
      data: {
        '_token': token,
        'subject': subject,
        'message': message,
        'email': email,
        'name': name,
        'user_id': user_id,
        'vendor_id': vendor_id
      },
      success: function () {
        $('#subj').prop('disabled', false);
        $('#msg').prop('disabled', false);
        $('#subj').val('');
        $('#msg').val('');
        $('#emlsub').prop('disabled', false);
        toastr.success("{{ $langg->message_sent }}");
        $('.ti-close').click();
      }
    });
    return false;
  });

</script>
<script type="text/javascript">

    $('#notifyform').on('submit',function(event){
        event.preventDefault();        
        let email = $('#email').val();
        let product_id = $('#product_id').val();

        $.ajax({
          url: "notify",
          type:"POST",
          data:{
            "_token": "{{ csrf_token() }}",           
            email:email,product_id:product_id,            
          },
          success:function(response){
            //alert(response);
             $("p.successmsg").html(response);
          },
         });
        });
      </script>
@endsection