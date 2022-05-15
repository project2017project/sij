@extends('layouts.front')

@section('content')

<!-- Breadcrumb Area Start -->
	<!-- <div class="breadcrumb-area">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<ul class="pages">
						<li>
							<a href="{{ route('front.index') }}">
								{{ $langg->lang17 }}
							</a>
						</li>
						<li>
							<a href="{{ route('user-wishlists') }}">
								{{ $langg->lang168 }}
							</a>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div> -->
<!-- Breadcrumb Area End -->

<!-- Wish List Area Start -->


@if(count($wishlists))


	 <div class="hiraola-wishlist_area">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <form action="javascript:void(0)">
                            <div class="table-content table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th class="hiraola-product_remove">remove</th>
                                            <th class="hiraola-product-thumbnail">images</th>
                                            <th class="cart-product-name">Product</th>
                                            <th class="hiraola-product-price">Unit Price</th>
                                            <th class="hiraola-product-stock-status">Rating</th>
                                            <th class="hiraola-cart_btn">View Product</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($wishlists as $wishlist)
                                        <tr>
                                            <td class="hiraola-product_remove"><span class="remove wishlist-remove" data-href="{{ route('user-wishlist-remove',$wishlist->id) }}"><i class="licon-trash2"
                                                title="Remove"></i></span></td>
                                            <td class="hiraola-product-thumbnail"><a href="{{ route('front.product', $wishlist->product->slug) }}"><img style="width: 100px;" src="{{ $wishlist->product->photo ? asset('assets/images/products/'.$wishlist->product->photo):asset('assets/images/noimage.png') }}" alt="Hiraola's Wishlist Thumbnail"></a>
                                            </td>
                                            <td class="hiraola-product-name"><a href="{{ route('front.product', $wishlist->product->slug) }}">{{ $wishlist->product->name }}</a></td>
                                            <td class="hiraola-product-price"><span class="amount price">{{ $wishlist->product->showPrice() }}<small><del>{{ $wishlist->product->showPreviousPrice() }}</del></small></span></td>
                                            <td class="hiraola-product-stock-status"> <div class="ratings">
                                    <div class="empty-stars"></div>
                                    <div class="full-stars" style="width:{{App\Models\Rating::ratings($wishlist->product->id)}}%"></div>
                                </div></td>
                                            <td class="hiraola-cart_btn"><a href="{{ route('front.product', $wishlist->product->slug) }}">VIEW PRODUCT</a></td>
                                        </tr>
                                     @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>



        @else

			<div class="page-center" style="padding: 100px 0;">
				<h4 class="text-center">{{ $langg->lang60 }}</h4>
			</div>

			@endif

	



@endsection

@section('scripts')

<script type="text/javascript">
        $("#sortby").on('change',function () {
        var sort = $("#sortby").val();
        window.location = "{{url('/user/wishlists')}}?sort="+sort;
    	});
</script>

@endsection
