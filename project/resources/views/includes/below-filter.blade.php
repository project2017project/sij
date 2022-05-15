						<div class="shop-toolbar">
                            
                            <div class="product-item-selection_area">
                                <div class="product-short">
                                    <label class="select-label">{{$langg->lang64}} :</label>
									<form id="sortForm" class="d-inline-block" action="{{ route('front.below', Request::route('category')) }}" method="get">
											@if (!empty(request()->input('min')))
												<input type="hidden" name="min" value="{{ request()->input('min') }}">
											@endif
											@if (!empty(request()->input('max')))
												<input type="hidden" name="max" value="{{ request()->input('max') }}">
											@endif
											</form>
                                    											
											<!--select id="sortby" name="sort" class="short-item" class="nice-select short-item" onchange="document.getElementById('sortForm').submit()"-->
											<select id="sortby" name="sort" class="short-item" class="nice-select short-item">
		                    <option value="date_desc" {{ request()->input('sort') == 'date_desc' ? 'selected' : '' }}>{{$langg->lang65}}</option>
		                    <option value="date_asc" {{ request()->input('sort') == 'date_asc' ? 'selected' : '' }}>{{$langg->lang66}}</option>
							<option value="popular_product" {{ request()->input('sort') == 'popular_product' ? 'selected' : '' }}>Popular Product</option>
		                    <option value="price_asc" {{ request()->input('sort') == 'price_asc' ? 'selected' : '' }}>{{$langg->lang67}}</option>
		                    <option value="price_desc" {{ request()->input('sort') == 'price_desc' ? 'selected' : '' }}>{{$langg->lang68}}</option>
											</select>
											
										
                                   
                                </div>
                            </div>
							<div class="product-item-selection_area">
                            <div class="product-short">
                                 <input type="text" id="sortbytext" name="sorttext" class="form-control" placeholder="Search By Product">
                                 </div></div>
                        </div>


						
