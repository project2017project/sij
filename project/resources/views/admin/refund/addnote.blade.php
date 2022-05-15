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
					<form id="geniusformdata" action="{{route('admin-refund-addnote',$data->id)}}" method="POST" enctype="multipart/form-data">
						{{csrf_field()}}

						<select name="statusare">
							<option>Select Status</option>
							<option value="accept">Accept</option>
							<option value="decline">Decline</option>
						</select>

						<div class="row">
							<div class="col-lg-3"><div class="left-area"><h4 class="heading">Comments</h4></div></div>
			                <div class="col-sm-8">
			                	<textarea name="adminMessage" rows="8" class="form-control">{{ $data->name}}</textarea>
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


@endsection
