@extends('layouts.front')
@section('content')

  <div class="vendor-banner" style="">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="content">
            <p class="sub-title">
               
            </p>
            <h2 class="title">
                {{ __('Vendor Login') }}
            </h2>
          </div>
        </div>
      </div>
    </div>
  </div>


  
  <section class="">
  <div class="container">
  <div class="row">
        <div class="col-sm-3"></div>
        <div class="login-area col-sm-6">
          <div class="login-form signin-form" style="margin-top:60px;">
            @include('includes.admin.form-login')
            <form class="mloginform" action="{{ route('user.login.submit') }}" method="POST">
              {{ csrf_field() }}
              <div class="form-input">
                <input type="email" name="email" placeholder="{{ $langg->lang173 }}" required="">
                <i class="icofont-user-alt-5"></i>
              </div>
              <div class="form-input">
                <input type="password" class="Password" name="password" placeholder="{{ $langg->lang174 }}" required="">
                <i class="icofont-ui-password"></i>
              </div>
             
              <div class="form-forgot-pass">
                <div class="left">
                  <input type="checkbox" name="remember"  id="mrp1" {{ old('remember') ? 'checked' : '' }}>
                  <label for="mrp1">{{ $langg->lang175 }}</label>
                </div>
                <div class="right">
                  <a href="javascript:;" id="show-forgot1">
                    {{ $langg->lang176 }}
                  </a>
                </div>
              </div>
              <input type="hidden" name="modal"  value="1">
              <input type="hidden" name="vendor"  value="1">
              <input class="mauthdata" type="hidden"  value="{{ $langg->lang177 }}">
              <button type="submit" class="submit-btn">{{ $langg->lang178 }}</button>
              @if(App\Models\Socialsetting::find(1)->f_check == 1 || App\Models\Socialsetting::find(1)->g_check == 1)
              <div class="social-area">
               <h3 class="title">{{ $langg->lang179 }}</h3>
               <p class="text">{{ $langg->lang180 }}</p>
               <ul class="social-links">
                 @if(App\Models\Socialsetting::find(1)->f_check == 1)
                 <li>
                   <a href="{{ route('social-provider','facebook') }}">
                     <i class="fab fa-facebook-f"></i>
                   </a>
                 </li>
                 @endif
                 @if(App\Models\Socialsetting::find(1)->g_check == 1)
                 <li>
                   <a href="{{ route('social-provider','google') }}">
                     <i class="fab fa-google-plus-g"></i>
                   </a>
                 </li>
                 @endif
               </ul>
             </div>
             @endif
           </form>
         </div>
       </div>
   
  
  </section>
  </div>
  </div>

@endsection