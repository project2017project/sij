@extends('layouts.admin')
@section('content')
<div class="content-area">
    <div class="mr-breadcrumb">
        <div class="row">
            <div class="col-lg-12">
                <h4 class="heading">{{ __('Reviews Details') }} <a class="add-btn" href="{{ route('admin-reviews-index') }}"><i class="fas fa-arrow-left"></i> {{ __('Back') }}</a></h4>
                <ul class="links">
                    <li><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }} </a></li>                    
                    <li><a href="javascript:;">{{ __('Reviews Details') }}</a></li>
                </ul>
            </div>
        </div>
    </div>
	<div class="order-table-wrap">
      
        <div class="row">
            <div class="col-lg-12">
                <div class="special-box"><div class="heading-area"><h4 class="title">{{ __('Reviews Details') }}</h4></div>
                    <div class="table-responsive-sm">
                        <table  class="table">
                            <tbody>
							    <tr><th width="45%">{{ __('Product Name') }}</th><td width="10%">:</td><td width="45%">{{$data->product->name}}</td></tr> 
                                <tr><th width="45%">{{ __('User Name') }}</th><td width="10%">:</td><td width="45%">{{$data->user->name}}</td></tr>
								 <tr><th width="45%">{{ __('Review') }}</th><td width="10%">:</td><td width="45%">{{$data->review}}</td></tr>
								<tr><th width="45%">{{ __('Rating') }}</th><td width="10%">:</td><td width="45%">{{$data->rating}}</td></tr>
								<tr><th width="45%">{{ __('Status') }}</th><td width="10%">:</td><td width="45%">{{$data->admin_approve == 1? "Approved":"Rejected"}} </td></tr>
                                <tr><th width="45%">{{ __('Review Date') }}</th><td width="10%">:</td><td width="45%">{{ date('d-M-Y h:i:s',strtotime($data->review_date))}}</td></tr>
                                 								
                            </tbody>
                        </table>
                    </div>                    
                </div>
            </div>
			</div>
			</div>
	
                        

@endsection