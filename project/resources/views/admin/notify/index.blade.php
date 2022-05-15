@extends('layouts.admin') 

@section('content')  

<div class="content-area">
	<div class="mr-breadcrumb">
		<div class="row">
			<div class="col-lg-12">
				<h4 class="heading">{{ __("Notify") }}</h4>
				<ul class="links">
					<li><a href="{{ route('admin.dashboard') }}">{{ __("Dashboard") }} </a></li>
					<li><a href="{{ route('admin-notify-index') }}">{{ __("Notify") }}</a></li>
				</ul>
			</div>
		</div>
	</div>
	<div class="product-area">
		<div class="row">
			<div class="col-lg-12">
				<div class="mr-table allproduct">
    				@include('includes.admin.form-both')  
					<div class="table-responsiv">
						<table id="example" class="table table-hover dt-responsive" cellspacing="0" width="100%">
							<thead>
								<tr>
			                        <th>{{ __("No.") }}</th>
			                        <th>{{ __("Email") }}</th>
			                        <th>{{ __("Product Name") }}</th>
			                        <th>{{ __("Status") }}</th>
								</tr>
							</thead>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
@section('scripts')
<script type="text/javascript">
	$('#example').DataTable({
	    ordering: false,
        processing: true,
        serverSide: true,
        ajax: '{{ route('admin-notify-datatables') }}',
        columns: [
                { data: 'id', name: 'id' },
                { data: 'email', name: 'email' },
                { data: 'product', name: 'product' },
                { data: 'status', name: 'status' }
             ],
        language : {
        	processing: '<img src="{{asset('assets/images/'.$gs->admin_loader)}}">'
        }
    });								
				
  	$(function(){
        $(".btn-area").append('<div class="col-sm-4 text-right">'+
        	'<a class="add-btn" href="{{route('admin-notify-download')}}">'+
          '<i class="fa fa-download"></i> {{ __("Download") }}'+
          '</a>'+
          '</div><div class="col-sm-4 text-right">'+
        	'<a class="add-btn" href="{{route('admin-notify-sent')}}">'+
          '<i class="fa fa-download"></i> {{ __("Send Notify") }}'+
          '</a>'+
          '</div>');
    });	
</script>
@endsection   