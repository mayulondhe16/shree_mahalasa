@extends('layout.master')
 
@section('content')
<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" data-scroll="true">
      <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">{{ $title }}</a></li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Edit {{ $title }}</li>
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
                <h6 class="text-white text-capitalize ps-3" style="width:90%;float:left">Edit {{ $title }}</h6>
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
                            <img id="output_image1" height="200px" width="300px" src="{{url('/')}}{{$data['thumbnail_image']}}" />
                           </p>
                            <div class="input-group input-group-outline mb-3">
                            <input type="file"  name="thumbnail_image" accept="image/*" onchange="preview_image(event,1)" required="true">
                        </div>
                    </div>
                </div>
              </div>
              <div class="row">
                @foreach($shop_images as $key=> $image)
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="oldpassword">Shop Image {{ $key+1 }}<span style="color:red;" >*</span></label>
                            <p>
                            <img id="output_image1" height="200px" width="300px" src="{{url('/')}}{{$image->images}}" />
                            </p>
                            {{-- <div class="input-group input-group-outline mb-3">
                            <input type="file"  name="images[]" accept="image/*" onchange="preview_image(event,1)" required="true" multiple>
                        </div> --}}
                    </div>
                </div>
                @endforeach
              </div>
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="form-label">Shop Name</label>
                      <div class="input-group input-group-outline mb-3">
                          <input type="text" class="form-control" name="name" value="{{ $data['name'] }}">
                        </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="form-label">Shop Address</label>
                      <div class="input-group input-group-outline mb-3">
                          <input type="text" class="form-control" name="address" value="{{ $data['address'] }}">
                        </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="form-label">Link</label>
                      <div class="input-group input-group-outline mb-3">
                          <input type="text" class="form-control" name="link" value={{ $data['link'] }}>
                        </div>
                  </div>
                </div>
              </div>
              <div class="row">
                {{-- <div class="col-md-4">
                  <div class="form-group">
                    <label class="form-label">Longitude</label>
                      <div class="input-group input-group-outline mb-3">
                          <input type="text" class="form-control" name="long"  value={{ $data['long'] }}>
                        </div>
                  </div>
                </div> --}}
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="form-label">City</label>
                      <div class="input-group input-group-outline mb-3">
                          <select class="form-control" id="city" name="city" required="true">
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
                            <textarea  class="form-control" name="description">{{ $data['description'] }}</textarea>
                          </div>
                    </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="form-label">Telephone Number</label>
                      <div class="input-group input-group-outline mb-3">
                          <input type="text" class="form-control" name="telephone_no" maxlength="10" value={{ $data['telephone_no'] }}>
                      </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="form-label">Mobile Number</label>
                      <div class="input-group input-group-outline mb-3">
                          <input type="text" class="form-control" name="mobile_no" maxlength="10" value={{ $data['mobile_no'] }}>
                      </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="form-label">Contact Person</label>
                      <div class="input-group input-group-outline mb-3">
                          <input type="text" class="form-control" name="contact_person" value={{ $data['contact_person'] }}>
                      </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label class="form-label">Map Link</label>
                      <div class="input-group input-group-outline mb-3">
                        <input type="text" class="form-control" name="map_link" value={{ $data['map_link'] }} data-parsley-pattern="^((http|https):\/\/.)[-a-zA-Z0-9@:%._\+~#=]{2,256}\.[a-z]{2,600}\b([-a-zA-Z0-9@:%_\+.~#?&//=]*)$">
                      </div>
                  </div>
                </div>
              </div>
              <div class="box-footer">
                    <button type="submit" class="btn btn-primary" style="float: right">Update</button>
              </div>
                </form>
            </div>
          </div>
        </div>
      </div>
@endsection