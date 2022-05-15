@extends('layouts.admin')
@section('styles')
<style type="text/css">
    .table-responsive {
    overflow-x: hidden;
}
table#example2 {
    margin-left: 10px;
}
</style>
@endsection
@section('content')
                    <div class="content-area">
                        <div class="mr-breadcrumb">
                            <div class="row">
                               <div class="col-lg-12">
                      <h4 class="heading">{{ __('Dispute Details') }} <a class="add-btn" href="{{route('admin-open-disputes')}}"><i class="fas fa-arrow-left"></i> {{ __('Back') }}</a></h4>
                      <ul class="links">
                        <li>
                          <a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }} </a>
                        </li>
                        <li>
                          <a href="javascript:;">{{ __('Dispute Details') }}</a>
                        </li>                        
                      </ul>
                  </div>
                            </div>
                        </div>
                            <div class="add-product-content1 customar-details-area">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="product-description">
                                            <div class="body-area">
                                            <div class="row">  											
                                                    <div class="col-md-4">
                                                    <div class="table-responsive show-table">
                                                        <table class="table">
                                                        <tr>
                                                            <th>{{ __("Dispute Id#") }}</th>
                                                            <td>{{$data->id}}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>{{ __("Vendor Name") }}</th>
															@php
                                        $user = App\Models\User::find($data->vendor_id);
                                        @endphp
                                                            <td>{{$user->name}}</td>
                                                        </tr>
                                                        <tr>
                                                            <th>{{ __("Order Id") }}</th>
                                                            <td>{{$data->order_id}}</td>
                                                        </tr>                                                       
                                                           															
                                                        </table>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                    <div class="table-responsive show-table">
                                                    <table class="table"> 
													 <tr>
                                                                <th>{{ __("Product Name") }}</th>
                                                                <td>{{$data->product_name}}</td>
                                                            </tr>
                                                             <tr>
                                                                <th>{{ __("Product SKU") }}</th>
                                                                <td>{{$data->product_sku}}</td>
                                                            </tr>
                                                            <tr>
                                                                <th>{{ __("Dispute Date") }}</th>
                                                                <td>{{$data->created_at}}</td>
                                                            </tr>
                                                        </table>
                                                        </div>
                                                    </div>
                                                												
                                                        </div>
												<br>
												<div class="col-md-2">
												<form  method="POST" action="{{route('admin-disputeds-status',$data->id)}}" enctype="multipart/form-data" id="declineform">
												{{ csrf_field() }}
												@include('includes.admin.form-both')
												<input type = "hidden" name="rtoid" value="{{$data->id}}">
												<button class="decline-btn" type="submit">{{ __('Update Status') }}</button>
												</form>
												</div>	
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
@endsection
@section('scripts')
<script type="text/javascript">
$('#example2').dataTable( {
  "ordering": false,
      'paging'      : false,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : false,
      'info'        : false,
      'autoWidth'   : false,
      'responsive'  : true
} );
</script>
@endsection