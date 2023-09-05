@extends('layout.master')
 
@section('content')
<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" data-scroll="true">
      <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">{{ $title }}</a></li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">View {{ $title }}</li>
          </ol>
          {{-- <h6 class="font-weight-bolder mb-0">Tables</h6> --}}
        </nav>
      </div>
    </nav>
    <!-- End Navbar -->
    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-12">
          <div class="card my-4">
            <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
              <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                <h6 class="text-white text-capitalize ps-3" style="width:90%;float:left">View {{ $title }}</h6>
                {{-- <a href="{{url('/')}}/add_{{ $url_slug }}" class="btn btn-s text-white text-capitalize" style="float: right;">Add {{ $title }}</a> --}}


              </div>
            </div>
            <div class="card-body">
              <form action="{{ url('/')}}/update_{{$url_slug}}/{{ $data['id'] }}" method="post" role="form" data-parsley-validate="parsley" enctype="multipart/form-data" autocomplete="off">
                {!! csrf_field() !!} 
              <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="oldpassword">Shop Thumbnail Image<span style="color:red;" >*</span></label>
                           <p>
                            <img id="output_image1" height="200px" width="300px" src="{{ Config::get('DocumentConstant.SHOPTHUMB_VIEW') }}{{ $data['thumbnail_image'] }}" />
                          </p>
                    </div>
                </div>
              </div>
              <div class="row">
                @foreach($shop_images as $key=> $image)
                <div class="col-md-4">
                    <div class="form-group">
                      <div class="row">
                          <div class="col-md-10">
                              <label for="oldpassword">Shop Image {{ $key+1 }}<span style="color:red;" >*</span></label>
                          </div>
                          <div class="col-md-2">
                            <p><a href="{{url('/')}}/delete_shop_image/{{ $image->id }}" title="Delete" onclick="return confirm('Are you sure you want to delete this record?');">
                               <i class="fa fa-trash"></i></a>
                            </p>
                          </div>
                      </div>
                            <p>
                              <img id="output_image1" height="200px" width="300px" src="{{ Config::get('DocumentConstant.SHOP_VIEW') }}{{ $image->images }}" />
                            </p>
                    </div>
                </div>
                @endforeach
              </div>
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="form-label">Shop Name</label>
                      <div class="input-group input-group-outline mb-3">
                          <input type="text" class="form-control" name="name" value="{{ $data['name'] }}" readonly>
                        </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="form-label">Shop Address</label>
                      <div class="input-group input-group-outline mb-3">
                          <input type="text" class="form-control" name="address" value="{{ $data['address'] }}" readonly>
                        </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="form-label">Link</label>
                      <div class="input-group input-group-outline mb-3">
                          <input type="text" class="form-control" name="link" value={{ $data['link'] }} readonly>
                        </div>
                  </div>
                </div>
              </div>
              <div class="row">
                {{-- <div class="col-md-4">
                  <div class="form-group">
                    <label class="form-label">Longitude</label>
                      <div class="input-group input-group-outline mb-3">
                          <input type="text" class="form-control" name="long"  value={{ $data['long'] }} readonly>
                        </div>
                  </div>
                </div> --}}
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="form-label">City</label>
                      <div class="input-group input-group-outline mb-3">
                          <select class="form-control" id="city" name="city" required="true" @readonly(true)>
                            <option value="">Select City</option>
                            @foreach($city as $val)
                            <option value="{{$val->id}}" @if($data['city']==$val->id) selected="" @endif>{{$val->city_name}}</option>
                            @endforeach
                          </select>
                      </div>
                  </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                      <label class="form-label">Shop Description</label>
                        <div class="input-group input-group-outline mb-3">
                            <textarea  class="form-control" name="description" readonly>{{ $data['description'] }}</textarea>
                          </div>
                    </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="form-label">Telephone Number</label>
                      <div class="input-group input-group-outline mb-3">
                          <input type="text" class="form-control" name="telephone_no" readonly value={{ $data['telephone_no'] }}>
                      </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="form-label">Mobile Number</label>
                      <div class="input-group input-group-outline mb-3">
                          <input type="text" class="form-control" name="mobile_no" readonly value={{ $data['mobile_no'] }}>
                      </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="form-label">Contact Person</label>
                      <div class="input-group input-group-outline mb-3">
                          <input type="text" class="form-control" name="contact_person" readonly value={{ $data['contact_person'] }}>
                      </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="form-label">Map Link</label>
                      <div class="input-group input-group-outline mb-3">
                        <input type="text" class="form-control" name="map_link" readonly value={{ $data['map_link'] }}>
                      </div>
                  </div>
                </div>
              </div>
              <div class="box-footer">
                    <a href="{{url('/')}}/manage_shops" type="submit" class="btn btn-primary pull-right">Back</a>
              </div>
                </form>
            </div>
          </div>
        </div>
      </div>
@endsection