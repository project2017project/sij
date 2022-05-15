   <div class="col-lg-3 order-2 order-lg-1">
       <a href="javascript:void(0)" class="filter_btn_mobile">Filter</a>
       <div class="fiter-box_side">
           <a href="javascript:void(0)" class="close_filter_mobile">X</a>
    <div class="hiraola-sidebar-catagories_area">
      <div class="category-module hiraola-sidebar_categories">
        <div class="category-module_heading"><h5>Categories</h5></div>
        <div class="module-body">          
          <ul  class="module-list_item">
            @foreach ($categories as $element)
            <li>
              <a href="{{route('front.category', $element->slug)}}"> <i class="icon licon-chevron-right"></i>  {{$element->name}} <!--<span class="notranslate">({{ count($element->products) }})</span>--> </a>
              @if(!empty($cat) && $cat->id == $element->id && !empty($cat->subs))
              <ul class="module-sub-list_item">
                @foreach ($cat->subs as $key => $subelement)
                <li>
                  <a href="{{route('front.category', [$cat->slug, $subelement->slug])}}" ><i class="icon licon-chevron-right"></i> {{$subelement->name}} <!--<span class="notranslate">({{ count($subelement->products) }})</span>--></a>
                  @if(!empty($subcat) && $subcat->id == $subelement->id && !empty($subcat->childs))
                  <ul  class="module-list_item">
                    @foreach ($subcat->childs as $key => $childcat)
                    <li>
                      <a href="{{route('front.category', [$cat->slug, $subcat->slug, $childcat->slug])}}"><i class="icon licon-chevron-right"></i>  {{$childcat->name}} <!--<span class="notranslate">({{ count($childcat->products) }})</span>--></a>
                    </li>
                    @endforeach
                  </ul>
                  @endif
                </li>
                @endforeach
              </ul>                      
              @endif
            </li>
            @endforeach
          </ul>
        </div>
      </div>
      <div class="hiraola-sidebar-catagories_area">
        <div class="hiraola-sidebar_categories">
          <div class="hiraola-categories_title">
            <h5>Price</h5>
          </div>
          <div class="price-filter">
            <form id="catalogForm" action="{{ route('front.category', [Request::route('category'), Request::route('subcategory'), Request::route('childcategory')]) }}" method="GET">
            @if (!empty(request()->input('search')))
            <input type="hidden" name="search" value="{{ request()->input('search') }}">
            @endif
            @if (!empty(request()->input('sort')))
            <input type="hidden" name="sort" value="{{ request()->input('sort') }}">
            @endif


            <div class="price-range-block">
              <div id="slider-range" class="price-filter-range" name="rangeInput"></div>
              <div class="livecount">
                <input type="number" min=0  name="min"  id="min_price" class="price-range-field" value="0" />
                <span>{{$langg->lang62}}</span>
                <input type="number" min=0  name="max" id="max_price" class="price-range-field" value="100" />
              </div>
            </div>

            <button class="filter-btn" type="submit" style="opacity: 0; visibility: hidden; position: absolute;">{{$langg->lang58}}</button>
          </form>




        </div>
      </div>

    </div>










    @if ((!empty($cat) && !empty(json_decode($cat->attributes, true))) || (!empty($subcat) && !empty(json_decode($subcat->attributes, true))) || (!empty($childcat) && !empty(json_decode($childcat->attributes, true))))


    <div class="hiraola-sidebar-catagories_area">


      <form id="attrForm" action="{{route('front.category', [Request::route('category'), Request::route('subcategory'), Request::route('childcategory')])}}" method="post">

        <!--div>
          @if (!empty($cat) && !empty(json_decode($cat->attributes, true)))
          @foreach ($cat->attributes as $key => $attr)
          <div class="hiraola-sidebar_categories">
            <div class="hiraola-categories_title">
              <h5>{{$attr->name}}</h5>
            </div>
            <ul class="sidebar-checkbox_list">
              @if (!empty($attr->attribute_options))
              @foreach ($attr->attribute_options as $key => $option)
              <li>
               <input name="{{$attr->input_name}}[]" class="form-check-input attribute-input" type="checkbox" id="{{$attr->input_name}}{{$option->id}}" value="{{$option->name}}">
               <label class="form-check-label" for="{{$attr->input_name}}{{$option->id}}">{{$option->name}}</label>
             </li>

             @endforeach
             @endif
           </ul>
         </div>
         @endforeach
         @endif

       </div-->




       <!--div>


        @if (!empty($subcat) && !empty(json_decode($subcat->attributes, true)))
        @foreach ($subcat->attributes as $key => $attr)

        <div class="hiraola-sidebar_categories">
          <div class="hiraola-categories_title">
            <h5>{{$attr->name}}</h5>
          </div>
          <ul class="sidebar-checkbox_list">


            @if (!empty($attr->attribute_options))
            @foreach ($attr->attribute_options as $key => $option)

            <li>

              <input name="{{$attr->input_name}}[]" class="form-check-input attribute-input" type="checkbox" id="{{$attr->input_name}}{{$option->id}}" value="{{$option->name}}">
              <label class="form-check-label" for="{{$attr->input_name}}{{$option->id}}">{{$option->name}}</label>

            </li>


            @endforeach
            @endif


          </ul>
        </div>




        @endforeach
        @endif


      </div-->






      <!--div>


        @if (!empty($childcat) && !empty(json_decode($childcat->attributes, true)))
        @foreach ($childcat->attributes as $key => $attr)

        <div class="hiraola-sidebar_categories">
          <div class="hiraola-categories_title">
            <h5>{{$attr->name}}</h5>
          </div>
          <ul class="sidebar-checkbox_list">


           @if (!empty($attr->attribute_options))
           @foreach ($attr->attribute_options as $key => $option)

           <li>

            <input name="{{$attr->input_name}}[]" class="form-check-input attribute-input" type="checkbox" id="{{$attr->input_name}}{{$option->id}}" value="{{$option->name}}">
            <label class="form-check-label" for="{{$attr->input_name}}{{$option->id}}">{{$option->name}}</label>

          </li>


          @endforeach
          @endif


        </ul>
      </div>




      @endforeach
      @endif


    </div-->








  </form>



</div>

@endif







@if(!isset($vendor))

{{-- <div class="tags-area">
  <div class="header-area">
    <h4 class="title">
      {{$langg->lang63}}
    </h4>
  </div>
  <div class="body-area">
    <ul class="taglist">
      @foreach(App\Models\Product::showTags() as $tag)
      @if(!empty($tag))
      <li>
        <a class="{{ isset($tags) ? ($tag == $tags ? 'active' : '') : ''}}" href="{{ route('front.tag',$tag) }}">
          {{ $tag }}
        </a>
      </li>
      @endif
      @endforeach
    </ul>
  </div>
</div> --}}


@else

<div class="service-center">
  <div class="header-area">
    <h4 class="title">
      {{ $langg->lang227 }}
    </h4>
  </div>
  <div class="body-area">
    <ul class="list">
      <li>
        <a href="javascript:;" data-toggle="modal" data-target="{{ Auth::guard('web')->check() ? '#vendorform1' : '#comment-log-reg' }}">
          <i class="icofont-email"></i> <span class="service-text">{{ $langg->lang228 }}</span>
        </a>
      </li>
      <li>
        <a href="tel:+{{$vendor->shop_number}}">
          <i class="icofont-phone"></i> <span class="service-text">{{$vendor->shop_number}}</span>
        </a>
      </li>
    </ul>
    <!-- Modal -->
  </div>

  <div class="footer-area">
    <p class="title">
      {{ $langg->lang229 }}
    </p>
    <ul class="list">


      @if($vendor->f_check != 0)
      <li><a href="{{$vendor->f_url}}" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
      @endif
      @if($vendor->g_check != 0)
      <li><a href="{{$vendor->g_url}}" target="_blank"><i class="fab fa-google"></i></a></li>
      @endif
      @if($vendor->t_check != 0)
      <li><a href="{{$vendor->t_url}}" target="_blank"><i class="fab fa-twitter"></i></a></li>
      @endif
      @if($vendor->l_check != 0)
      <li><a href="{{$vendor->l_url}}" target="_blank"><i class="fab fa-linkedin-in"></i></a></li>
      @endif


    </ul>
  </div>
</div>


@endif

</div>
</div>
</div>
