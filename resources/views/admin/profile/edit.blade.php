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
              <form name="chngpwd" action="{{ url('/')}}/update_{{$url_slug}}/{{$data->id}}" method="post" role="form" data-parsley-validate="parsley" enctype="multipart/form-data" autocomplete="off">
                {!! csrf_field() !!}    
                <div class="row">
                      <div class="col-md-8">
                        <div class="form-group">
                          <label class="form-label">Old Password</label><span style="color:red;" >*</span>
                            <div class="input-group input-group-outline mb-3">
                                <input type="text" class="form-control" name="oldpassword" id="oldpassword"  required="true">
                              </div>
                        </div>
                    </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8">
                          <div class="form-group">
                            <label class="form-label">New Password</label><span style="color:red;" >*</span>
                              <div class="input-group input-group-outline mb-3">
                                  <input type="text" class="form-control" name="new_password" id="new_password" required="true">
                                </div>
                          </div>
                      </div>
                      </div>
                      <div class="row">
                        <div class="col-md-8">
                          <div class="form-group">
                            <label class="form-label">Confirm Password</label><span style="color:red;" >*</span>
                              <div class="input-group input-group-outline mb-3">
                                  <input type="text" class="form-control" name="confirm_password" id="confirm_password" required="true" onchange="valid();">
                                </div>
                          </div>
                          <span id="msg" style="color: red"></span>
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
<script>
function valid()
{
    if(document.chngpwd.new_password.value!= document.chngpwd.confirm_password.value)
    {
    // alert("Password and Confirm Password Field do not match  !!");
    $('#msg').text("New Password and Confirm Password Field do not match  !!");
    return false;
    }else{
        $('#msg').text("");
        return true;

    }
}
</script>
@endsection