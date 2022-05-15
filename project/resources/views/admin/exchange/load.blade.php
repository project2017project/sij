<form  method="POST" action="{{route('admin-exchange-update',$data->id)}}" enctype="multipart/form-data" id="exchangedform">
{{ csrf_field() }}
@include('includes.admin.form-both')
<input type = "hidden" name="echangeid" value="{{$data->id}}">
<p class="text-center">Are you Sure You want to Create Accept Request?</p>
				<button class="exchangedform-btn btn btn-success" style="margin-top : 0; width:auto; height:auto; font-size : 1rem; 
    background-color: #28a745; border: 1px solid transparent; border-color: #28a745;" type="submit">{{ __('Confirm') }}</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">{{ __('Cancel') }}</button>

</form>
											
												