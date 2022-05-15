@extends('layouts.load')

@section('content')

                       
                      <form id="rejectdata" action="{{route('admin-vendor-withdraw-reject',$data->id)}}" method="POST" enctype="multipart/form-data">
                        {{csrf_field()}}
						@include('includes.admin.form-success') 
                        @include('includes.admin.form-error')

      
            <p class="text-center">{{ __("You are about to reject this Withdraw.") }}</p>
            <p class="text-center">{{ __("Do you want to proceed.Please enter your reason?") }}</p>
			<input type="text" class="form-control" Placeholder="Please enter your reason"  name="comment" required>		    

      <!-- Modal footer -->
      <div class="modal-footer justify-content-center">	  
       <button type="button" class="btn btn-default" data-dismiss="modal">{{ __("Cancel") }}</button>
	   <button class="btn btn-danger btn-ok" type="submit">{{ __('Reject') }}</button>
            
      </div>
	  </form>                 
@endsection