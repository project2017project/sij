@extends('layouts.adminpop')

@section('content')

                            @foreach($cart->items as $key => $product)
                            
                                   
                                      
            
                                    
            
                                            <a target="_blank" href="{{ route('front.product', $product['item']['slug']) }}">{{mb_strlen($product['item']['name'],'utf-8') > 30 ? mb_substr($product['item']['name'],0,30,'utf-8').'...' : $product['item']['name']}}</a>
                                    
                                                                                                              
                                        
                                            <strong>{{ __('Qty') }} :</strong> {{$product['qty']}} {{ $product['item']['measure'] }}
                                                                                                              
                                    

                               
                            @endforeach
                        
               
     

@endsection
