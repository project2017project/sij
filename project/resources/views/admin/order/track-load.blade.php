<tr>
    <th>{{ __("Company ") }}</th>
    <th>{{ __("Tracking Code") }}</th>
    <th>{{ __("Tracking URL") }}</th>
    <th>{{ __("Date") }}</th>
<!--    <th>{{ __("Time") }}</th>-->
    <th>{{ __("Action") }}</th>
</tr>
@foreach($order->tracks as $track)

<tr data-id="{{ $track->id }}">
    <td width="15%">{{ $track->companyname }}</td>
    <td width="15%">{{ $track->title }}</td>
    <td width="45%">{{ $track->text }}</td>
    <td width="15%">{{  date('d-M-Y',strtotime($track->created_at)) }}</td>
   <!-- <td>{{  date('d-M-Y',strtotime($track->created_at)) }}</td>-->
    <td>
        <div class="action-list">
            <a data-href="{{ route('admin-order-track-update',$track->id) }}" class="track-edit"> <i class="fas fa-edit"></i>Edit</a>
            <a href="javascript:;" data-href="{{ route('admin-order-track-delete',$track->id) }}" class="track-delete"><i class="fas fa-trash-alt"></i></a>
        </div>
    </td>
</tr>
@endforeach