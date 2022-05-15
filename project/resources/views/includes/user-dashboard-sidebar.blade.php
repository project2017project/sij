        <div class="col-lg-4">
          <div class="user-profile-info-area">
            <ul class="links">
                @php 

                  if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') 
                  {
                    $link = "https"; 
                  }
                  else
                  {
                    $link = "http"; 
                      
                    // Here append the common URL characters. 
                    $link .= "://"; 
                      
                    // Append the host(domain name, ip) to the URL. 
                    $link .= $_SERVER['HTTP_HOST']; 
                      
                    // Append the requested resource location to the URL 
                    $link .= $_SERVER['REQUEST_URI']; 
                  }      

                @endphp
              <li class="{{ $link == route('user-dashboard') ? 'active':'' }}">
                <a href="{{ route('user-dashboard') }}">
                  {{ $langg->lang200 }}
                </a>
              </li>
              
              @if(Auth::user()->IsVendor())
                <li>
                  <a href="{{ route('vendor-dashboard') }}">
                    {{ $langg->lang230 }}
                  </a>
                </li>
              @endif

              <li class="{{ $link == route('user-orders') ? 'active':'' }}">
                <a href="{{ route('user-orders') }}">
                 My Orders
                </a>
              </li>
			   <li class="{{ $link == route('user-refunds') ? 'active':'' }}">
                <a href="{{ route('user-refunds') }}">
                 Refund
                </a>
              </li>
			  <li class="{{ $link == route('user-exchange') ? 'active':'' }}">
                <a href="{{ route('user-exchange') }}">
                 Exchange
                </a>
              </li>

            


             <!-- <li class="{{ $link == route('user-order-track') ? 'active':'' }}">
                  <a href="{{route('user-order-track')}}">{{ $langg->lang772 }}</a>
              </li>-->
              
              
               <li class="{{ $link == route('user-order-track') ? 'active':'' }}">
                  <a href="javascript:;" data-toggle="modal" data-target="#track-order-modal">{{ $langg->lang772 }}</a>
              </li>



           

<!--
              <li class="{{ $link == route('user-message-index') ? 'active':'' }}">
                  <a href="{{route('user-message-index')}}">{{ $langg->lang204 }}</a>
              </li>

              <li class="{{ $link == route('user-dmessage-index') ? 'active':'' }}">
                  <a href="{{route('user-dmessage-index')}}">{{ $langg->lang250 }}</a>
              </li>-->

              <li class="{{ $link == route('user-profile') ? 'active':'' }}">
                <a href="{{ route('user-profile') }}">
                  {{ $langg->lang205 }}
                </a>
              </li>

              <li class="{{ $link == route('user-reset') ? 'active':'' }}">
                <a href="{{ route('user-reset') }}">
                 {{ $langg->lang206 }}
                </a>
              </li>

              <li>
                <a href="{{ route('user-logout') }}">
                  {{ $langg->lang207 }}
                </a>
              </li>

            </ul>
          </div>
        
        </div>