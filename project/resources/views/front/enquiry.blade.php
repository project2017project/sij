@extends('layouts.front')
@section('styles')

<link href="{{asset('assets/admin/css/product.css')}}" rel="stylesheet" />
<link href="{{asset('assets/admin/css/jquery.Jcrop.css')}}" rel="stylesheet" />
<link href="{{asset('assets/admin/css/Jcrop-style.css')}}" rel="stylesheet" />

@endsection

@section('content')

<!-- <div class="breadcrumb-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <ul class="pages">
                    <li><a href="{{ route('front.index') }}">{{ $langg->lang17 }}</a></li>
                    <li><a href="{{ route('front.enquiry') }}">Custom Order</a></li>
                </ul>
            </div>
        </div>
    </div>
</div> -->

    <!-- Contact Us Area Start -->
    <section class="contact-us">
        <div class="container">


                <div class="row">
            

                            <div style="text-align: left;" class="col-sm-6">

                            <div class="hiraola-tab_title" style="padding-bottom: 30px; text-align: left;">
                                <h3>CUSTOM JEWELERY & PERSONALISATION</h3>
                            </div>

                            <p>
                                Thankyou for showing interest in getting a piece customised / personalised with Lunias Gemco            
                            </p>
                                
                            <p>
                                Since our inception we have been helping Jewelry Designers / Brands / Private Labels / Wholesalers and individuals to give shape to their jewelry desings and convert them into a reality           
                            </p>

                            <p>
                                    If you think you have not been able to find your style on our store, or in case you have a specific design or special gemstone requirement for your jewelry, We'd love to design a custom piece for you or your loved ones          
                            </p>

                            <p>
                                Submit us your detailed requirement in form below           
                            </p>

                            <p>
                                We will work on your requirements and get back with the proposal            
                            </p>


                            <p>
                                 After finalising the desing, we will list your product, and you can complete your purchase.            
                            </p>

                            <p>
                                Once We've received your message We'll get back to you within 2-3 days. Please be patient if you don't hear from us immediately.            
                            </p>

                            <p>
                                Thank you so much for taking the time to view our website and considering us to design your custom / Personalised piece!            
                            </p>


                            </div>


                            <div class="col-sm-6 custom-jewellery-wrap">
                                
                                <div class="left-area">
                        <div class="contact-form custom-jewellery">
                            <div class="gocover" style="background: url({{ asset('assets/images/'.$gs->loader) }}) no-repeat scroll center center rgba(45, 45, 45, 0.5);"></div>
                            <form id="contactform" action="{{route('front.enquiry.submit')}}" method="POST">

                                    <div class="hiraola-tab_title" style="padding-bottom: 30px; text-align: center;">
                                <h3>CUSTOM ORDER FORM</h3>
                            </div>


                                {{csrf_field()}}
                                    @include('includes.admin.form-both')  

                                    <div class="form-input">
                                        <input type="text" name="name" placeholder="{{ $langg->lang47 }} *" required="">
                                       
                                    </div>
                                    <div class="form-input">
                                        <input type="text" name="phonenumber"  placeholder="{{ $langg->lang48 }} *">
                                       
                                    </div>
                                    <div class="form-input">
                                        <input type="email" name="email"  placeholder="{{ $langg->lang49 }} *" required="">
                                      
                                    </div>
                                   
                                    <div class="form-input">
                                        <select name="productCategory">
                                            <option>Product Category</option>
                                            <option value="Ring">Ring</option>
                                            <option value="Ear Ring">Ear Ring</option>
                                            <option value="Pendant">Pendant</option>
                                            <option value="Necklance">Necklance</option>
                                            <option value="Bracelet">Bracelet</option>
                                            <option value="other">Other</option>
                                        </select>
                                    </div>
                                    <div class="form-input">
                                        <select name="metal">
                                            <option>Metal</option>
                                            <option value="Solid Gold">Solid Gold</option>
                                            <option value="Sterling Silver">Sterling Silver</option>
                                            <option value="other">Other</option>
                                        </select>
                                    </div>
                                    <div class="form-input">
                                        <select name="hueofmetal">
                                            <option>Hue of Metal</option>
                                            <option value="Yellow">Yellow</option>
                                            <option value="Pink">Pink</option>
                                            <option value="White">White</option>
                                        </select>
                                    </div>
                                    <div class="form-input">
                                        <input type="text" name="gemstonepreference" placeholder="Gemstone Preferences (if any)" required="">
                                       
                                    </div>
                                    <div class="form-input">
                                        <input type="text" name="tentativebudget" placeholder="Tentative Budget (if any)" required="">
                                     
                                    </div>
                                    <div class="form-input">
                                        <textarea name="address" placeholder="Please take up a momet to write a brief description of the product you would want us to create, including sizing details" required=""></textarea>
                                    </div>
                                    <div class="form-input">
                                        <input type="datadealing" name="datadealing" placeholder="Date Deadlines (if any)" required="">
                                       
                                    </div>
                                                                      
                                    <div class="form-input">
                                        <input type="text" name="linkoftheitem" placeholder="Link of something similar to your requiremnt (if Any)" required="">
                                       
                                    </div>
                                    <input type="file" name="gallery[]" class="hidden" id="uploadgallery" accept="image/*"
                                        multiple>
                                    <div class="row mb-4">
                                        <div class="col-lg-12 mb-2">
                                            <div class="left-area">
                                               
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                        <p>If you have a sketch or photographs that can give us a better idea of what you would like the finished piece to look like, please upload it</p>
                                            <a href="#" class="set-gallery" data-toggle="modal" data-target="#setgallery">
                                                <i class="icofont-plus"></i> {{ __('Add Images') }}
                                            </a>
                                        </div>
                                    </div>
                                    <input type="hidden" name="to" value="{{ $ps->contact_email }}">
                                    <button class="submit-btn" type="submit">{{ $langg->lang52 }}</button>
                            </form>
                        </div>
                    </div>


                            </div>

                            </div>



          
        </div>
    </section>


    <div class="modal fade" id="setgallery" tabindex="-1" role="dialog" aria-labelledby="setgallery" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered  modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">{{ __('Image Gallery') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="top-area">
                    <div class="row">
                        <div class="col-sm-6 text-right">
                            <div class="upload-img-btn">
                                <label for="image-upload" id="prod_gallery"><i
                                        class="icofont-upload-alt"></i>{{ __('Upload File') }}</label>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <a href="javascript:;" class="upload-done" data-dismiss="modal"> <i
                                    class="fas fa-check"></i> {{ __('Done') }}</a>
                        </div>
                        <div class="col-sm-12 text-center">( <small>{{ __('You can upload multiple Images.') }}</small>
                            )</div>
                    </div>
                </div>
                <div class="gallery-images">
                    <div class="selected-image">
                        <div class="row">


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    <!-- Contact Us Area End-->

@endsection

@section('scripts')

<script src="{{asset('assets/admin/js/jquery.Jcrop.js')}}"></script>
<script src="{{asset('assets/admin/js/jquery.SimpleCropper.js')}}"></script>

<script type="text/javascript">
    // Gallery Section Insert

    $(document).on('click', '.remove-img', function () {
        var id = $(this).find('input[type=hidden]').val();
        $('#galval' + id).remove();
        $(this).parent().parent().remove();
    });

    $(document).on('click', '#prod_gallery', function () {
        $('#uploadgallery').click();
        $('.selected-image .row').html('');
        $('#contactform').find('.removegal').val(0);
    });


    $("#uploadgallery").change(function () {
        var total_file = document.getElementById("uploadgallery").files.length;
        for (var i = 0; i < total_file; i++) {
            $('.selected-image .row').append('<div class="col-sm-6">' +
                '<div class="img gallery-img">' +
                '<span class="remove-img"><i class="fas fa-times"></i>' +
                '<input type="hidden" value="' + i + '">' +
                '</span>' +
                '<a href="' + URL.createObjectURL(event.target.files[i]) + '" target="_blank">' +
                '<img src="' + URL.createObjectURL(event.target.files[i]) + '" alt="gallery image">' +
                '</a>' +
                '</div>' +
                '</div> '
            );
            $('#contactform').append('<input type="hidden" name="galval[]" id="galval' + i +
                '" class="removegal" value="' + i + '">')
        }

    });

    // Gallery Section Insert Ends
</script>

<script type="text/javascript">
    $('.cropme').simpleCropper();
</script>


@endsection