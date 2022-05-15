@extends('layouts.admin') 

@section('content')  
          <div class="content-area">
            <div class="mr-breadcrumb">
              <div class="row">
                <div class="col-lg-12">
                    <h4 class="heading">{{ __('Search Result') }}</h4>
                    <ul class="links">
                      <li>
                        <a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }} </a>
                      </li>
                      <li>
                        <a href="javascript:;">{{ __('Search') }}</a>
                      </li>
                      <li>
                        <a href="javascript:;">{{ __('Search Result') }}</a>
                      </li>

                    </ul>
                </div>
              </div>
            </div>
            <div class="product-area">
              <div class="row">
                <div class="col-lg-12">
                  <div class="mr-table allproduct">

                        @include('includes.admin.form-success') 

                    <div class="table-responsiv">
                        <table id="geniustable" class="table table-hover dt-responsive" cellspacing="0" width="100%">
                          <thead>
                            <tr>
                              <th>{{ __('Id') }}</th>
                              <th>{{ __('Search Name') }}</th>
                              <th>{{ __('Date') }}</th>
                              
                            </tr>
                          </thead>
                          <tbody>
                            @foreach($datas as $list)
                          
                            <tr>
                                <td>{{$list->id}}</td><td>{{$list->search_name}}</td><td>{{$list->date}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>


@endsection    



@section('scripts')

     <script type="text/javascript">

    // var table = $('#geniustable').DataTable({
    //      ordering: false,
    //           processing: true,
    //           serverSide: true,
    //           ajax: '{{ route('admin-message-datatables','SearchResult') }}',
    //           columns: [
    //               { data: 'id', name: 'id' },
    //               { data: 'searchname', name: 'searchname' },
    //               { data: 'created_at', name: 'created_at'},
    //                  ],
    //           language: {
    //               processing: '<img src="{{asset('assets/images/'.$gs->admin_loader)}}">'
    //             },
    //     drawCallback : function( settings ) {
    //           $('.select').niceSelect();  
    //     }
    //         });
        
      

    // </script>


@endsection   