<form  method="POST" action="{{route('admin-rtoh-update',$data->id)}}" enctype="multipart/form-data" id="exchangedform">
{{ csrf_field() }}
@include('includes.admin.form-both')
<input type = "hidden" name="rtoid" value="{{$data->id}}">
<select name="prreason" onchange="changereason(this.value);" required> 
                                         <option value="">Please Select a Reason</option>  
                                         <option value="wrong">Wrong</option>
                                         <option value="bad">Bad</option>
                                         <option value="others">others</option>
                                        </select>
										<input type="text" class="input-field" id="reason" placeholder="{{ __('Reason') }}" name="reason" style="display:none;"></div>
										<p class="text-center">Are you Sure You want to Create Not Delivered Request?</p>
				<button class="exchangedform-btn btn btn-success" style="margin-top : 0; width:auto; height:auto; font-size : 1rem; 
    background-color: #28a745; border: 1px solid transparent; border-color: #28a745;" type="submit">{{ __('Confirm') }}</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">{{ __('Cancel') }}</button>
</form>
			
<script type="text/javascript">
function changereason(val){
 var element=document.getElementById('reason');
 if(val==''||val=='others')
   element.style.display='block';
 else  
   element.style.display='none';
}

</script>			
												