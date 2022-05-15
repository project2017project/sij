@extends('layouts.front')
@section('content')

<!-- Vendor Area Start -->
  <div class="vendor-banner" style="">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
           
          <div class="content">
            <p class="sub-title">
               
            </p>
            <h2 class="title">
              Designer
            </h2>
          </div>
        </div>
      </div>
    </div>
  </div>

 <div class="hiraola-content_wrapper">
  <div class="container">
    <div class="row">
     
     <div class="col-lg- order-first order-lg-last ajax-loader-parent">
       <div class="right-area" id="app">       
        <div class="categori-item-area">
          <div class="shop-product-wrap grid gridview-3 row" id="ajaxContent">
          
           @include('includes.product.filtered-designer')
             
         </div>
         <div id="ajaxLoader" class="ajax-loader" style="background: url({{asset('assets/images/'.$gs->loader)}}) no-repeat scroll center center rgba(0,0,0,.6);"></div>
       </div>
     </div>
   </div>
 </div>
</div>
</div>
@endsection
