@extends('layouts.admin') 
@section('styles')
<style type="text/css">.input-field { padding: 15px 20px; }</style>
@endsection
@section('content')  
<input type="hidden" id="headerdata" value="{{ __('ORDER') }}">
<div class="content-area">
	<div class="mr-breadcrumb">
		<div class="row">
			<div class="col-lg-12">
				<h4 class="heading">{{ __('Order Track') }}</h4>
				<ul class="links">
					<li><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }} </a></li>
					<li><a href="javascript:;">{{ __('Orders') }}</a></li>
					<li><a href="{{ route('admin-order-ordertracks') }}">{{ __('All Order Track') }}</a></li>
				</ul>
			</div>
		</div>
	</div>
	<div class="product-area">
		<div class="row">
			<div class="col-lg-12">
				<div class="mr-table allproduct">					 
					<div class="table-responsiv">
						<div class="row" style="padding-top : 20px; background : #eeeeee;">	
						<div class ="col-sm-10">
                                       
                                   <div class="row">
                                 <form id="ordertrackdata" style="min-width : 100%;" class="form-horizontal" action="{{ route('order-ftrack-data',['status'=>'none']) }}" method="POST" enctype="multipart/form-data">
										{{csrf_field()}}          
							<div class="form-group col-md-3">                               
                                <select name="svendor" id="svendor">
                                    <option value=''>--Select Any Vendor-- </option>
                                    @foreach($users as $userid)
                                    <option value="{{$userid->id}}">{{$userid->shop_name}}</option>
                                    @endforeach                                        
                                </select>                                
                            </div>
                            
                            
                            <div class="text-left col-md-3" >
                                <button type="text" id="ordertrackform" class="btn btn-info">Submit</button></div>
								<form>
                            </div>
                            </div>                            
                         </div>
                        <br>
						
						
	</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection 
@section('scripts')

{{-- DATA TABLE --}}
<script type="text/javascript">
$(document).on('submit','#ordertrackdata',function(e){
	e.preventDefault();
	var vendorid=$("#svendor :selected").val();
	$.get($(this).prop('action')','vendorid='+vendorid+',function(){
        document.location.href = $(this).prop('action')?vendorid='+vendorid+';        
    });

});

</script>
{{-- DATA TABLE --}}
@endsection  