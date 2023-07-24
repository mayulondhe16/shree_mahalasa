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
              <form action="{{ url('/')}}/view_{{$url_slug}}/{{$data['id']}}" method="post" role="form" data-parsley-validate="parsley" enctype="multipart/form-data" autocomplete="off">
                {!! csrf_field() !!}    
                <?php
                
                  $category = \DB::table('category')->where(['id'=>$data['category_id']])->first();
                  $brand = \DB::table('brands')->where(['id'=>$data['brand_id']])->first();
                  $product_images = \DB::table('product_images')->where(['product_id'=>$data['id']])->get();
                  
                ?>
                <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="oldpassword">Product Images</label>
                                @foreach($product_images as $image)   
                                <p>
                                  <img id="output_image1" height="200px" width="300px" src="{{url('/')}}{{$image->image}}" />
                                </p>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label class="form-label">Product Name</label>
                                <div class="input-group input-group-outline mb-3">
                                    <input type="text" class="form-control" readonly name="title"  value="{{$data['name']}}">
                                  </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label class="form-label">Category</label>
                                <div class="input-group input-group-outline mb-3">
                                  <input type="text" class="form-control" readonly name="title"  value="{{$category->title}}">  
                                  </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                      <div class="col-md-8">
                          <div class="form-group">
                              <label class="form-label">Brand</label>
                              <div class="input-group input-group-outline mb-3">
                                <input type="text" class="form-control" readonly name="title"  value="{{$brand->title}}">  
                                </div>
                          </div>
                      </div>
                  </div>

                  <div class="row">
                    <div class="col-md-8">
                        <div class="form-group">
                            <label class="form-label">Description</label>
                            <div class="input-group input-group-outline mb-3">
                                <textarea  class="form-control" readonly name="description">{{$data['description']}}</textarea>
                              </div>
                        </div>
                    </div>
                </div>
                  
                    
                    {{-- <div class="text-center">
                      <button type="button" class="btn btn-lg bg-gradient-primary btn-lg w-100 mt-4 mb-0">Sign Up</button>
                    </div> --}}
                    
                    <div class="box-footer">
                        <a href="{{url('/')}}/manage_products" type="submit" class="btn btn-primary pull-right">Back</a>
                    </div>
                  </form>
            </div>
          </div>
        </div>
      </div>
@endsection