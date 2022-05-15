                        @if(isset($order))
                    <div class="tracking-steps-area">
                            @if(count($order->tracks)>0)
                            <ul class="tracking-steps">
                                
                                    @foreach($order->tracks as $track)
                                        <li class="{{ in_array($track->title, $datas) ? 'active' : '' }}">
                                            <div class="icon">{{ $loop->index + 1 }}</div>
                                            <div class="content">
                                                    <h4 class="title">{{ ucwords($track->title)}}</h4>
                                                    <p class="date">{{ date('d/M/Y',strtotime($track->created_at)) }}</p>
                                                    <p class="details" ><a target="_BLANK" href="{{ $track->text }}">{{ $track->text }}</a></p>
                                                    
                                                    <p class="details">{{ $track->companyname }}</p>
                                            </div>
                                        </li>
                                    @endforeach
                                

                                </ul>
                                
                                @else
                                    <h3 class="text-center">No Tracking Info available, check later</h3>
                                @endif
                                
                    </div>


                        @else 
                        <h3 class="text-center">{{ $langg->lang775 }}</h3>
                        @endif          