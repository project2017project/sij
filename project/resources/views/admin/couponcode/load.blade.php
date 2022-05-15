<form  method="POST" action="{{route('admin-approval-update',$data->id)}}" enctype="multipart/form-data" id="couponapproveform">
{{ csrf_field() }}
@include('includes.admin.form-both')
<input type = "hidden" name="couponid" value="{{$data->id}}">
<button class="couponapproveform-btn" type="submit">{{ __('OK') }}</button>
</form>
											
												