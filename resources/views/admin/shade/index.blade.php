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
          {{-- <h6 class="font-weight-bolder mb-0">Tables</h6> --}}
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
            {{-- <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
              <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                <h6 class="text-white text-capitalize ps-3" style="width:90%;float:left">{{ $title }} table</h6>
                <a href="{{url('/')}}/add_{{ $url_slug }}" class="btn btn-s text-white text-capitalize" style="float: right;">Add {{ $title }}</a>


              </div>
            </div> --}}
            
            <div class="card-body">
              <div class="table-responsive p-0">
                <table id ="example" class="table table-bordered table-striped">
                  <thead>
                    <tr>
                      <th>Sr No</th>
                      <th>Shade Name</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($data as $key=>$value)
                      <tr>
                        <td>
                          {{$key+1}}
                        </td>
                        <td>
                          {{$value->shade_name}}
                        </td>
                        <td>
                          <a class="success" href="{{url('/')}}/edit_{{$url_slug}}/{{base64_encode($value->id)}}" title="Edit">
                            <i class="fa fa-edit"></i>
                          </a>
                          <a class="primary" href="{{url('/')}}/view_{{$url_slug}}/{{base64_encode($value->id)}}" title="View">
                            <i class="fa fa-eye"></i>
                          </a>
                          <a class="danger" href="{{url('/')}}/delete_{{$url_slug}}/{{base64_encode($value->id)}}" title="Delete" onclick="return confirm('Are you sure you want to delete this record?');">
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