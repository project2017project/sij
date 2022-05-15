                        @if(isset($order))
                    <div class="tracking-steps-area">
                            
                    
                            
                            @if(count($order->tracks)>0 || count($notification)>0 )
                            <!--<ul class="tracking-steps">
                                
                                    @foreach($order->tracks as $track)
                                        <li class="{{ in_array($track->title, $datas) ? 'active' : '' }}">
                                            <div class="icon">{{ $loop->index + 1 }}</div>
                                            <div class="content">
                                                    <h4 class="title">{{ ucwords($track->title)}}</h4>
                                                    <p class="date">{{ date('d/M/Y',strtotime($track->created_at)) }}</p>
                                                    <p class="details" ><a target="_BLANK" href="{{ $track->text }}">{{ $track->text }}</a></p>
                                                    
                                                    <p class="details">{{ $track->companyname }}</p>
                                            </div>
								  <form id="sendinvoice" action="{{route('front-order-invoice',$track->id)}}" class="sendinvoice" method="POST" enctype="multipart/form-data"> 
                                   {{csrf_field()}}								  
                                  <input type="hidden" id="order-id" value="{{ $track->order_id }}">
                                  <button type="submit" class="mybtn1">Send Invoice</button>            
                                  </form>											
                                        </li>
                                    @endforeach
                                    
                                    </ul>-->
                                    <ul class="tracking-steps">
                                         <li class="{{ in_array($track->title, $datas) ? 'active' : '' }}">
									     <div class="icon"> </div>
                                            <div class="content">
                                                    <h4 class="title">Order Number : {{ $order->order_number }}  {{date('d-M-Y',strtotime($order->created_at))}}</h4>
                                                    <p class="details" >Your order has been received</p>
                                                    
                                                   
                                            </div>
								
									</li>
									 @foreach($notification as $notify)
									 
									 <li class="{{ in_array($track->title, $datas) ? 'active' : '' }}">
									     <div class="icon"> </div>
                                            <div class="content">
                                                    <h4 class="title">Order Note {{ date('d-M-Y',strtotime($track->created_at)) }}</h4>
                                                    <p class="details" ><?php echo html_entity_decode($notify->message);?></p>
                                                    
                                                   
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