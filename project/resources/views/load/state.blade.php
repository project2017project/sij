<?php //print_r($cat);die;?>
<option data-href="" value="">Select State</option>
@foreach($cat as $sub)
<option  value="{{ $sub->name }}">{{ $sub->name }}</option>
@endforeach