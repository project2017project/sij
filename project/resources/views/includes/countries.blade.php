<option value="">{{ $langg->lang157 }}</option>
@if(Auth::check())
	@foreach (DB::table('countries')->get() as $data)
	<option data-href="{{ route('front-state-load',$data->id) }}" value="{{ $data->name }}" {{ Auth::user()->country == $data->name ? 'selected' : '' }}>{{ $data->name }}</option>		
	@endforeach
@else
	@foreach (DB::table('countries')->get() as $data)
	<option data-href="{{ route('front-state-load',$data->id) }}" value="{{ $data->name }}">{{ $data->name }}</option>		
	@endforeach
@endif