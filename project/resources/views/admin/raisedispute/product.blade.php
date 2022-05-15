@foreach($product as $products)
<div class="row">
										<div class="col-lg-12"><div class="left-area"><h4 class="heading">{{ __('Product Name') }} </h4></div></div>
										<div class="col-lg-12"><input type="text" class="input-field" placeholder="{{ __('Product Name') }}" name="product_name" value="{{ $products->name }}" required="" readonly></div>
									</div>	
                                   
                                    <div class="row">
										<div class="col-lg-12"><div class="left-area"><h4 class="heading">{{ __('Product SKU') }}* </h4></div></div>
										<div class="col-lg-12"><input type="text" class="input-field" placeholder="{{ __('Product SKU') }}" name="product_sku" value="{{ $products->sku }}" required="" readonly></div>
									</div>
									@endforeach