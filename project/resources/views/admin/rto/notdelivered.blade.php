	<form  method="POST" action="{{route('admin-rto-update',$data->id)}}" enctype="multipart/form-data" id="declineform">
												{{ csrf_field() }}
												@include('includes.admin.form-both')
												<input type = "hidden" name="echangeid" value="{{$data->id}}">
												<button class="rtodform-btn" type="submit">{{  __('OK') }}</button>
												</form>