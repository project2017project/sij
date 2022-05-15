@extends('layouts.front')

@section('content')

	@if($ps->slider == 1)

		@if(count($sliders))
			@include('includes.slider-style')
		@endif
	@endif






    @if($ps->slider == 1)
		@if(count($sliders))
        <div class="hiraola-slider_area-2 hiraola-slider_area-3 color-white">
            <div class="main-slider">
                @foreach($sliders as $data)
                <a href="{{$data->link}}">
                    <div class="single-slide animation-style-01 bg-6" style=" background-repeat : no-repeat;     background-position: center center;  background-size: cover;">
                        <img src="{{asset('assets/images/sliders/'.$data->photo)}}" />
                        <!--<div class="container">
                            <div class="slider-content slider-content-2">
                                
                                <h5 style=" color: {{$data->subtitle_color}}" >{{$data->subtitle_text}}</h5>
                                <h2 style=" color: {{$data->title_color}}">{{$data->title_text}}</h2>
                         
                                <h4  style=" color: {{$data->details_color}}">{{$data->details_text}}</h4>
                              <div class="hiraola-btn-ps_center slide-btn">
                                    <a class="hiraola-btn {{$data->link}}" href="shop-left-sidebar.html">{{ $langg->lang25 }} </a>
                                </div>
                            </div>
                            <div class="slider-progress"></div>
                        </div>-->
                    </div>
                </a>
                @endforeach
            </div>
        </div>
        @endif
	@endif

  <!-- Begin Hiraola's Product Tab Area -->
        <div class="hiraola-product-tab_area-2" style="margin-bottom : 40px;">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="product-tab">
                            <div class="hiraola-tab_title">
                                <h4>Latest Collections</h4>
                            </div>
                        </div>
                        
                        <div class="shop-product-wrap grid gridview-4 home-4productsrow row mt-10">
                               		@foreach($latest_collection as $prod)
										@include('includes.product.slider-product')
									@endforeach
                         </div>
                        
                    
                    	<div class="hiraola-tab_title text-center">
                            <a href="{{ route('front.index') }}/category/imitation-jewellery" class="hiraola-btn home-page-all center mt-20">SHOW ALL</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        
        
        
        
        
          <!-- Begin Hiraola's Product Tab Area -->
        <div class="hiraola-product-tab_area-2" style="margin-bottom : 40px;">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="product-tab">
                            <div class="hiraola-tab_title">
                                <h4>Designer Jewellery</h4>
                            </div>
                        </div>
                        
                        <div class="shop-product-wrap grid gridview-4 home-4productsrow row mt-10">
                               		@foreach($designer_collection as $prod)
										@include('includes.product.slider-product')
									@endforeach
                         </div>
                        
                    
                    	<div class="hiraola-tab_title text-center">
                            <a href="{{ route('front.designer') }}" class="hiraola-btn home-page-all center mt-20">SHOW ALL</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        
        
        
         <div class="hiraola-product-tab_area-2" style="margin-bottom : 40px;">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="product-tab">
                            <div class="hiraola-tab_title">
                                <h4>Today's Deals</h4>
                            </div>
                        </div>
                        
                        <div class="shop-product-wrap grid gridview-4 home-4productsrow row mt-10">
                               		@foreach($today_collection as $prod)
										@include('includes.product.slider-product')
									@endforeach
                         </div>
                        
                    
                    	<div class="hiraola-tab_title text-center">
                            <a href="{{ route('front.index') }}/onsale/imitation-jewellery" class="hiraola-btn home-page-all center mt-20">SHOW ALL</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        
        
        
        <div class="hiraola-product-tab_area-2" style="margin-bottom : 40px;">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="product-tab">
                            <div class="hiraola-tab_title">
                                <h4>Best Sellers</h4>
                            </div>
                        </div>
                        
                        <div class="shop-product-wrap grid gridview-4 home-4productsrow row mt-10">
                               		@foreach($best_collection as $prod)
										@include('includes.product.slider-product')
									@endforeach
                         </div>
                        
                    
                    	<div class="hiraola-tab_title text-center">
                            <a href="{{ route('front.index') }}/popularproduct" class="hiraola-btn home-page-all center mt-20">SHOW ALL</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        
        
        <div class="hiraola-product-tab_area-2" style="margin-bottom : 40px;">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="product-tab">
                            <div class="hiraola-tab_title">
                                <h4>Bridal Collections</h4>
                            </div>
                        </div>
                        
                        <div class="shop-product-wrap grid gridview-4 home-4productsrow row mt-10">
                               		@foreach($bridal_collection as $prod)
										@include('includes.product.slider-product')
									@endforeach
                         </div>
                        
                    
                    	<div class="hiraola-tab_title text-center">
                            <a href="{{ route('front.bribal') }}" class="hiraola-btn home-page-all center mt-20">SHOW ALL</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        
        
        <!-- Begin Hiraola's Product Tab Area -->
        <div class="hiraola-product-tab_area-2" style="margin-bottom : 40px;">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="product-tab">
                            <div class="hiraola-tab_title">
                                <h4>Collections</h4>
                            </div>
                          
                        </div>
                        
                        <div class="category_boxes" style=" margin-top : 40px;">
                              <!--@if($ps->featured_category == 1)
                                      	@foreach($categories->where('is_featured','=',1) as $cat)
                            
                             @endforeach
                                    @endif-->
                                    
                                    @if($ps->featured_category == 1)
              
                @foreach($subcat as $cat)
                 
                    
                    <div class="category_item">
                                <div class="product-img">
                                                        <a href="{{ route('front.subcat',['slug1' =>$cat->category->slug, 'slug2' => $cat->slug]) }}">
                                                            <img class="primary-img" src="{{asset('assets/images/subcategory/'.$cat->image) }}" alt="{{ $cat->name }}">
                                                        </a>
                                                    </div>
                                                    <div class="hiraola-product_content">
                                                        <div class="product-desc_info">
                                                            <h6><a class="product-name" href="{{ route('front.subcat',['slug1' =>$cat->category->slug, 'slug2' => $cat->slug]) }}">{{ $cat->name }}</a></h6>
                                                        </div>
                                                    </div>
                            </div>
                            
                    
                @endforeach
     
            @endif
                        </div>    
                        
                        
                    
                    </div>
                </div>
            </div>
        </div>
        
        
        
        
        
        
        
        
     
        
        
        
        
        
        
        
    	<section id="extraData">
    		<div class="text-center">
    			<img src="{{asset('assets/images/'.$gs->loader)}}">
    		</div>
    	</section>
@endsection

@section('scripts')
	<script>
        $(window).on('load',function() {
            setTimeout(function(){
                $('#extraData').load('{{route('front.extraIndex')}}');
            }, 500);
        });
	</script>
@endsection