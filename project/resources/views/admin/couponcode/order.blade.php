@foreach($order as $orders)
<div class="row">
<div class="col-lg-12"><div class="left-area"><h4 class="heading">{{ __('Email Address') }}* </h4></div></div>
<div class="col-lg-12"><input type="text" class="input-field rdamt" placeholder="{{ __('Email Address') }}" name="email_address"  value="{{ $orders->customer_email }}"required=""></div>
</div>
<div class="row">
<div class="col-lg-12"><div class="left-area"><h4 class="heading">{{ __('Amount') }}* </h4></div></div>
<div class="col-lg-12"><input type="text" class="input-field rdamt" placeholder="{{ __('Amount') }}" name="price"  value="{{ $orders->pay_amount }}"required=""></div>
</div>
@endforeach