@extends('layout.master')
 
@section('content')

<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" data-scroll="true">
      <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">{{ $title }}</a></li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Manage {{ $title }}</li>
          </ol>
          <h6 class="font-weight-bolder mb-0">Tables</h6>
        </nav>
        <div class="box-header">
          <a href="{{url('/')}}/add_{{ $url_slug }}" class="btn btn-primary btn-xs" style="float: right;">Add {{ $title }}</a>
        </div>
      </div>
    </nav>
    <!-- End Navbar -->
    <div class="container-fluid py-4">
      @include('admin.flash-message')
      <div class="row">
        <div class="col-12">
          <div class="card my-4">
        
            <div class="card-body">
              <div class="table-responsive p-0">
                <table id ="example" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>Sr No</th>
                      <th>Image</th>
                      <th>Title</th>
                      <th>Shop Name</th>
                      <th>City</th>
                      <th>Mobile No 1</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($data as $key=>$value)
                    <?php
                      $city =DB::table('city')->where('id',$value->city_id)->first();
                    ?>
                      <tr>
                        <td>
                          {{$key+1}}
                        </td>
                        <td>
                          <img src="{{ Config::get('DocumentConstant.LOCATION_VIEW') }}{{ $value->image }}" height="50px" width="60px">
                        </td>
                        <td>
                          {{$value->title}}
                        </td>
                        <td>
                          {{$value->shop_name}}
                        </td>
                        <td>
                          {{isset($city->city_name)?$city->city_name:'-'}}
                        </td>
                        <td>
                          {{$value->mobile_no1}}
                        </td>
                        <td>
                          <a class="success" href="{{url('/')}}/edit_{{$url_slug}}/{{base64_encode($value->id)}}" title="Edit">
                            <i class="fa fa-edit"></i>
                          </a>
                          <a class="primary" href="{{url('/')}}/view_{{$url_slug}}/{{base64_encode($value->id)}}" title="View">
                            <i class="fa fa-eye"></i>
                          </a>
                          <a href="{{url('/')}}/delete_{{$url_slug}}/{{base64_encode($value->id)}}" title="Delete" onclick="return confirm('Are you sure you want to delete this record?');">
                            <i class="fa fa-trash"></i>
                          </a>
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
@endsection