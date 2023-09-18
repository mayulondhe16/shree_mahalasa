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
          {{-- <h6 class="font-weight-bolder mb-0">Tables</h6> --}}
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
                {{-- <a href="{{url('/')}}/add_{{ $url_slug }}" class="btn btn-s text-white text-capitalize" style="float: right;">Add {{ $title }}</a> --}}


              </div>
            </div>
            <div class="card-body">
              <form action="{{ url('/')}}/store_{{$url_slug}}" method="post" role="form" data-parsley-validate="parsley" enctype="multipart/form-data" autocomplete="off">
                {!! csrf_field() !!}    
                        <div class="row">
                          <div class="col-md-8">
                              <div class="form-group">
                                  <label for="oldpassword">Image<span style="color:red;" >*</span></label>
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
                            <div class="col-md-8">
                                <div class="form-group">
                                  <label class="form-label">Title<span style="color:red;" >*</span></label>
                                    <div class="input-group input-group-outline mb-3">
                                        <input type="text" required class="form-control" name="title" required data-parsley-error-message="Please enter valid title." data-parsley-pattern="^[A-Z a-z .]+$">
                                      </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                          <div class="col-md-6">
                              <div class="form-group">
                                <label class="form-label">City</label><span style="color:red;" >*</span>
                                  <div class="input-group input-group-outline mb-3">
                                      <select class="form-control" id="city_id" name="city_id" data-parsley-error-message="Please select city." required="true">
                                        <option value="">Select City</option>
                                        @foreach($city as $val)
                                        <option value="{{$val->id}}">{{$val->city_name}}</option>
                                        @endforeach
                                      </select>
                                    </div>
                              </div>
                          </div>
                      </div>
                      <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                              <label class="form-label">Shop Name<span style="color:red;" >*</span></label>
                                <div class="input-group input-group-outline mb-3">
                                    <input type="text" required class="form-control" name="shop_name" required data-parsley-error-message="Please enter valid shop name." data-parsley-pattern="^[A-Z a-z 0-9 .]+$">
                                  </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                              <label class="form-label">Mobile Number 1<span style="color:red;" >*</span></label>
                                <div class="input-group input-group-outline mb-3">
                                    <input type="text" required class="form-control" name="mobile_no1" required data-parsley-error-message="Please enter valid contact number." data-parsley-pattern="^[0-9 .]+$" maxlength="10">
                                  </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                      <div class="col-md-8">
                          <div class="form-group">
                            <label class="form-label">Mobile Number 2<span style="color:red;" >*</span></label>
                              <div class="input-group input-group-outline mb-3">
                                  <input type="text" required class="form-control" name="mobile_no2" required data-parsley-error-message="Please enter valid contact number." data-parsley-pattern="^[0-9 .]+$" maxlength="10">
                                </div>
                          </div>
                      </div>
                  </div>
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                              <label class="form-label">Address<span style="color:red;" >*</span></label>
                                <div class="input-group input-group-outline mb-3">
                                  <textarea  class="form-control" name="address" required></textarea>
                                  </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                      <div class="col-md-8">
                          <div class="form-group">
                            <label class="form-label">Map Link<span style="color:red;" >*</span></label>
                              <div class="input-group input-group-outline mb-3">
                                <input type="text" required class="form-control" name="link" required data-parsley-error-message="Please enter valid shop name." >
                              </div>
                          </div>
                      </div>
                  </div>
                  {{-- <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                          <label class="form-label">Longitude<span style="color:red;" >*</span></label>
                            <div class="input-group input-group-outline mb-3">
                              <input type="text" required class="form-control" name="lat" required data-parsley-error-message="Please enter valid contact latitude." data-parsley-pattern="^[0-9 .]+$">
                              </div>
                        </div>
                    </div>
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