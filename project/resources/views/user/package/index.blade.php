@extends('layouts.front')
@section('content')

<section class="user-dashbord">
    <div class="container">
        <div class="row">
            @include('includes.user-dashboard-sidebar')
            <div class="col-lg-8">
                <div class="user-profile-details">
                    <div class="row">
                        @foreach($subs as $sub)
                            <div class="col-lg-6">
                                <div class="elegant-pricing-tables style-2 text-center">
                                    <div class="pricing-head">
                                        <h3>{{ $sub->title }}</h3>
                                        @if($sub->price  == 0)
                                        <span class="price"><span class="price-digit">{{ $langg->lang402 }}</span></span>
                                        @else
                                        <span class="price">
                                            <sup>{{ $sub->currency }}</sup>
                                            <span class="price-digit">{{ $sub->price }}</span><br>
                                            <span class="price-month">{{ $sub->days }} {{ $langg->lang403 }}</span>
                                        </span>
                                        @endif
                                    </div>
                                    <div class="pricing-detail">{!! $sub->details !!}</div>
                                @if(!empty($package))
                                    @if($package->subscription_id == $sub->id)
                                        <a href="javascript:;" class="btn btn-default">{{ $langg->lang404 }}</a><br>
                                        @if(Carbon\Carbon::now()->format('Y-m-d') > $user->date)
                                        <small class="hover-white">{{ $langg->lang405 }} {{ date('d/m/Y',strtotime($user->date)) }}</small>
                                        @else
                                        <small class="hover-white">{{ $langg->lang406 }} {{ date('d/m/Y',strtotime($user->date)) }}</small>
                                        @endif
                                         <a href="{{route('user-vendor-request',$sub->id)}}" class="hover-white"><u>{{ $langg->lang407 }}</u></a>
                                    @else
                                        <a href="{{route('user-vendor-request',$sub->id)}}" class="btn btn-default">{{ $langg->lang408 }}</a><br><small>&nbsp;</small>
                                    @endif
                                @else
                                    <a href="{{route('user-vendor-request',$sub->id)}}" class="btn btn-default">{{ $langg->lang408 }}</a><br><small>&nbsp;</small>
                                @endif
                                {{--<a href="#" class="btn btn-default">Get Started Now</a> --}}                
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="row">
                        <?php //print_r($user); ?>
                        @if($user->is_vendor == 1)
                            <p>Your Vendor Account is under Verification, Once your account is approved you will be able to access the vendor panel and can start selling your products with South India Jeweles.</p>
                        @elseif($user->is_vendor == 2)
                            <p>Your Account is Active. Click on the below link to access your vendor panel. </p><br>
                            <p><a class="hiraola-btn center mt-60" href="{{ route('vendor-dashboard') }}">{{ $langg->lang230 }}</a></p>
                        @else
                        @endif
                        
                        
                        
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection