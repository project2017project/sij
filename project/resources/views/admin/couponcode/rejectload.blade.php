<form  method="POST" action="{{route('admin-reject-update',$data->id)}}" enctype="multipart/form-data" id="couponrejectform">
{{ csrf_field() }}
@include('includes.admin.form-both')
<input type = "hidden" name="couponid" value="{{$data->id}}">
<button class="couponrejectform-btn" type="submit">{{ __('OK') }}</button>
</form>
											
												