@extends('layout.master')
 
@section('content')
<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" data-scroll="true">
      <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">{{ $title }}</a></li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Add {{ $title }}</li>
          </ol>
        </nav>
      </div>
    </nav>
    <!-- End Navbar -->
    <div class="container-fluid py-4">
      @include('admin.flash-message')
      <div class="row">
        <div class="col-12">
          <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
              <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                <h6 class="text-white text-capitalize ps-3" style="width:90%;float:left">Add {{ $title }}</h6>
              </div>
            </div>
            <div class="card-body">
              <form action="{{ url('/')}}/store_{{$url_slug}}" method="post" role="form" data-parsley-validate="parsley" enctype="multipart/form-data" autocomplete="off">
                {!! csrf_field() !!}    
                <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="oldpassword">Banner<span style="color:red;" >*</span></label>
                                   <p>
                                    <img id="output_image1" height="200px" width="300px" src="{{asset('assets/img/top.jpeg')}}" />
                                   </p>
                                    <div class="input-group input-group-outline mb-3">
                                    <input type="file"  name="image" id="image" accept="image/*" onchange="preview_image(event,1)" required="true">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                          <div class="form-group">
                            <label class="form-label">Background Color Left</label><span style="color:red;" >*</span>
                              <div class="input-group input-group-outline mb-3">
                                <input type="color"  class="form-control" name="background_color_left"  data-parsley-error-message="Please enter valid color." required="true">
                              </div>
                          </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-md-6">
                          <div class="form-group">
                            <label class="form-label">Background Color Right</label><span style="color:red;" >*</span>
                              <div class="input-group input-group-outline mb-3">
                                <input type="color"  class="form-control" name="background_color_right"  data-parsley-error-message="Please enter valid color." required="true">
                              </div>
                          </div>
                      </div>
                    </div>

                    
                  
                    
                    {{-- <div class="text-center">
                      <button type="button" class="btn btn-lg bg-gradient-primary btn-lg w-100 mt-4 mb-0">Sign Up</button>
                    </div> --}}
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary" style="float: right">Submit</button>
                      </div>
                  </form>
            </div>
          </div>
        </div>
      </div>
@endsection