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
                {{ __('Vendor Registration') }}
            </h2>
          </div>
        </div>
      </div>
    </div>
  </div>


  
  <section class="">
  <div class="container">
  <div class="row">
        <div class="col-sm-2"></div>
        <div class="login-area col-sm-8">
          <div class="login-area signup-area" style="margin-top : 120px;">
        <div class="login-form signup-form">
         @include('includes.admin.form-login')
         <form class="mregisterform" action="{{route('user-register-submit')}}" method="POST">
          {{ csrf_field() }}

          <div class="row">

            <div class="col-lg-6">
              <div class="form-input">
                <input type="text" class="User Name" name="name" placeholder="{{ $langg->lang182 }}" required="">
                <i class="icofont-user-alt-5"></i>
              </div>
            </div>

            <div class="col-lg-6">
             <div class="form-input">
              <input type="email" class="User Name" name="email" placeholder="{{ $langg->lang183 }}" required="">
              <i class="icofont-email"></i>
            </div>

          </div>
          <div class="col-lg-6">
            <div class="form-input">
              <input type="text" class="User Name" name="phone" placeholder="{{ $langg->lang184 }}" required="">
              <i class="icofont-phone"></i>
            </div>

          </div>
           <div class="col-lg-6"><div class="form-input">
					<select class="form-control" name="country" id="usercountry" required="">
						@include('includes.countries')
					</select><i class="icofont-location-pin"></i></div>
			</div>
			<div class="col-lg-6"><div class="form-input">
                    <select class="form-control" id="userstate" name="state"  disabled="">
                        <option value="">{{ __('Select State') }}</option>
                    </select><i class="icofont-location-pin"></i></div>
							
                </div>
          <div class="col-lg-6">

            <div class="form-input">
              <input type="text" class="User Name" name="address" placeholder="{{ $langg->lang185 }}" required="">
              <i class="icofont-location-pin"></i>
            </div>
          </div>

          <div class="col-lg-6">
           <div class="form-input">
            <input type="text" class="User Name" name="shop_name" placeholder="{{ $langg->lang238 }}" required="">
            <i class="icofont-cart-alt"></i>
          </div>

        </div>
        <div class="col-lg-6">

         <div class="form-input">
          <input type="text" class="User Name" name="owner_name" placeholder="{{ $langg->lang239 }}" required="">
          <i class="icofont-cart"></i>
        </div>
      </div>
      <div class="col-lg-6">

        <div class="form-input">
          <input type="text" class="User Name" name="shop_number" placeholder="{{ $langg->lang240 }}" required="">
          <i class="icofont-shopping-cart"></i>
        </div>
      </div>
      <div class="col-lg-6">

       <div class="form-input">
        <input type="text" class="User Name" name="shop_address" placeholder="{{ $langg->lang241 }}" required="">
        <i class="icofont-opencart"></i>
      </div>
    </div>
    <div class="col-lg-6">

      <div class="form-input">
        <input type="text" class="User Name" name="reg_number" placeholder="GST Number">
        <i class="icofont-ui-cart"></i>
      </div>
    </div>
	<div class="col-lg-6">

      <div class="form-input">
        <input type="text" class="User Name" name="bank_name" placeholder="Bank Name" required="">
        <i class="icofont-ui-cart"></i>
      </div>
    </div>
	<div class="col-lg-6">

      <div class="form-input">
        <input type="text" class="User Name" name="branch" placeholder="Branch" required="">
        <i class="icofont-ui-cart"></i>
      </div>
    </div>
	<div class="col-lg-6">

      <div class="form-input">
        <input type="text" class="User Name" name="ifsc_code" placeholder="IFSC Code" required="">
        <i class="icofont-ui-cart"></i>
      </div>
    </div>
	<div class="col-lg-6">

      <div class="form-input">
        <input type="text" class="User Name" name="account_holder_name" placeholder="Account Holder Name" required="">
        <i class="icofont-ui-cart"></i>
      </div>
    </div>
	<div class="col-lg-6">

      <div class="form-input">
        <input type="text" class="User Name" name="account_number" placeholder="Account Number" required="">
        <i class="icofont-ui-cart"></i>
      </div>
    </div>
	<div class="col-lg-6">
    <input type="file" class="" name="shop_logo" required="">
    </div>
    <div class="col-lg-6">

     <div class="form-input">
      <input type="text" class="User Name" name="shop_message" placeholder="{{ $langg->lang243 }}" required="">
      <i class="icofont-envelope"></i>
    </div>
  </div>

  <div class="col-lg-6">
    <div class="form-input">
      <input type="password" class="Password" name="password" placeholder="{{ $langg->lang186 }}" required="">
      <i class="icofont-ui-password"></i>
    </div>

  </div>
  <div class="col-lg-6">
   <div class="form-input">
    <input type="password" class="Password" name="password_confirmation" placeholder="{{ $langg->lang187 }}" required="">
    <i class="icofont-ui-password"></i>
  </div>
</div>

@if($gs->is_capcha == 1)

<div class="col-lg-6">


  <ul class="captcha-area">
    <li>
      <p>
       <img class="codeimg1" src="{{asset("assets/images/capcha_code.png")}}" alt=""> <i class="fas fa-sync-alt pointer refresh_code "></i>
     </p>

   </li>
 </ul>


</div>

<div class="col-lg-6">

 <div class="form-input">
  <input type="text" class="Password" name="codes" placeholder="{{ $langg->lang51 }}" required="">
  <i class="icofont-refresh"></i>

</div>



</div>

@endif

<input type="hidden" name="vendor"  value="1">
<input class="mprocessdata" type="hidden"  value="{{ $langg->lang188 }}">
<button type="submit" class="submit-btn">{{ $langg->lang189 }}</button>

</div>




</form>
</div>
</div>
       </div>
   
  
  </section>
  </div>
  </div>

@endsection