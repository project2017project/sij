@extends('layouts.load')

@section('styles')

<link href="{{asset('assets/admin/css/jquery-ui.css')}}" rel="stylesheet" type="text/css">

@endsection

@section('content')

<div class="content-area">
	
	<div class="add-product-content">
		<div class="row">
			<div class="col-lg-12">
				<div class="product-description">
					<div class="body-area">
					@include('includes.admin.form-error') 
					<form id="geniusformdata" action="{{route('admin-prod-quickedit',$data->id)}}" method="POST" enctype="multipart/form-data">
						{{csrf_field()}}

						<div class="row">
							<div class="col-lg-8">
								<div class="left-area">
										<h4 class="heading">Product Name</h4>
								</div>
							</div>
			                  <div class="col-sm-3">
			                  	<input class="form-control" type="text" name="name" value="{{ $data->name}}" ></div>
						</div>

						


						<div class="row">
							<div class="col-lg-8">
								<div class="left-area">
										<h4 class="heading">SKU *</h4>
								</div>
							</div>
			                  <div class="col-sm-3">			                    
			                      <input class="form-control" type="text" name="sku" value="{{$data->sku}}" >                
			                  </div>
						</div>

						<div class="row">
							<div class="col-lg-8">
								<div class="left-area">
										<h4 class="heading">Price*</h4>
								</div>
							</div>
			                  <div class="col-sm-3">
			                      <input type="number" class="input-field" name="price" value="{{ $data->price}}"  >
			                  </div>
						</div>						

						<div class="row">
							<div class="col-lg-6">
								<div class="left-area">
										<h4 class="heading">{{ __("Regular Price") }} *</h4>
								</div>
							</div>
			                  <div class="col-sm-6">
			                      <input type="number" class="input-field" name="previous_price"  placeholder="{{ __('Enter Regular Price') }}" value="{{ $data->previous_price }}">

			                  </div>
						</div>
						<div class="row">
							<div class="col-lg-6">
								<div class="left-area">
										<h4 class="heading">{{ __("Stock") }} *</h4>
								</div>
							</div>
			                  <div class="col-sm-6">
			                      <input type="number" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" min="0" class="input-field" name="stock"  placeholder="{{ __('Enter Quantity') }}" value="{{ $data->stock }}">

			                  </div>
						</div>
						
						<div class="row">
							<div class="col-lg-5">
								<div class="left-area">
									
								</div>
							</div>
							<div class="col-lg-7">
								<button class="addProductSubmit-btn" type="submit">{{ __("Submit") }}</button>
							</div>
						</div>


					</form>


					</div>
				</div>
			</div>
		</div>
	</div>
	
</div>

@endsection

@section('scripts')


<script>
    $(document).ready(function(){
  $("input[type='number']").keypress(function(e){
     var keyCode = e.which;
    /*
      8 - (backspace)
      32 - (space)
      48-57 - (0-9)Numbers
    */
 
    if ( (keyCode != 8 || keyCode ==32 ) && (keyCode < 48 || keyCode > 57)) { 
      return false;
    }
  });
});
</script>


@endsection
