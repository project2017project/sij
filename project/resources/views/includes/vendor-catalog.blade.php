   <div class="col-lg-3 order-2 order-lg-1">
    <div class="hiraola-sidebar-catagories_area">
      <div class="category-module hiraola-sidebar_categories">
        <div class="category-module_heading"><h5>Categories</h5></div>
        <div class="module-body">          
          <ul  class="module-list_item">
            @foreach ($categories as $element)
            <li>
              <a href="{{route('front.vendor', $element->slug)}}"> <i class="icon licon-chevron-right"></i>  {{$element->name}} <span class="notranslate">({{ count($element->vproducts) }})</span> </a>
              @if(!empty($cat) && $cat->id == $element->id && !empty($cat->subs))
              <ul class="module-sub-list_item">
                @foreach ($cat->subs as $key => $subelement)
                <li>
                  <a href="{{route('front.vendor', [$cat->slug, $subelement->slug])}}" ><i class="icon licon-chevron-right"></i> {{$subelement->name}} <span class="notranslate">({{ count($subelement->vproducts) }})</span></a>
                  @if(!empty($subcat) && $subcat->id == $subelement->id && !empty($subcat->childs))
                  <ul  class="module-list_item">
                    @foreach ($subcat->childs as $key => $childcat)
                    <li>
                      <a href="{{route('front.vendor', [$cat->slug, $subelement->slug, $childcat->slug])}}"><i class="icon licon-chevron-right"></i>  {{$childcat->name}} <span class="notranslate">({{ count($childcat->vproducts) }})</span></a>
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
      <div class="hiraola-sidebar-catagories_area" style="display:none">
        <div class="hiraola-sidebar_categories">
          <div class="hiraola-categories_title">
            <h5>Price</h5>
          </div>
          <div class="price-filter">
            <form id="catalogForm" action="{{ route('front.vendor', [Request::route('category'), Request::route('subcategory'), Request::route('childcategory')]) }}" method="GET">
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




</div>
</div>
