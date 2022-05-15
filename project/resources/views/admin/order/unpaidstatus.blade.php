@extends('layouts.load')




@section('content')

            <div class="content-area">

              <div class="add-product-content1">
                <div class="row">
                  <div class="col-lg-12">
                    <div class="product-description">
                      <div class="body-area">
                        @include('includes.admin.form-error')  
                      <form id="geniusformdata" action="{{route('admin-order-unpaidstock',$data->id)}}" method="POST" enctype="multipart/form-data">
                        {{csrf_field()}}



                        <div class="row">
                          <div class="col-lg-4">
                            <div class="left-area">
                                <h4 class="heading">{{ __('Payment Status') }} *</h4>
                            </div>
                          </div>
                          
                          <div class="col-lg-7">
                              <select name="payment_status" required="">
                                <option value="Pending" {{$data->payment_status == 'Pending' ? "selected":""}}>{{ __('Unpaid') }}</option>
                                <option value="Completed" {{$data->payment_status == 'Completed' ? "selected":""}}>{{ __('Paid') }}</option>
                              </select>
                          </div>
                        </div>
                        <br>
                        <div class="row">
                          <div class="col-lg-4">
                            <div class="left-area">
                              
                            </div>
                          </div>
                          <div class="col-lg-7">
                            <button class="addProductSubmit-btn" type="submit">{{ __('Save') }}</button>
                          </div>
                        </div>
                      </form>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

@endsection

@section('scripts')





@endsection

