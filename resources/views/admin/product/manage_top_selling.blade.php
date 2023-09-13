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
        {{-- <div class="box-header">
          <a href="{{url('/')}}/add_{{ $url_slug }}" class="btn btn-primary btn-xs" style="float: right;">Add {{ $title }}</a>
        </div> --}}
      </div>
    </nav>
    <!-- End Navbar -->
    <div class="container-fluid py-4">
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
                      <th>Product Name</th>
                      <th>Main-Category </th>
                      <th>Sub-Category </th>
                      <th>Brand</th>
                      <th>Top Seller</th>
                      <th>Top Trending</th>
                      {{-- <th>General</th> --}}
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($data as $key=>$value)
                    <?php 
                    // dd($value);
                    $image_details = \DB::table('product_images')->where(['product_id'=>$value->id])->first();
                    $category = \DB::table('category')->where(['id'=>$value->category_id])->first();
                    $main_category = \DB::table('main_category')->where(['id'=>$value->main_category])->first();
                    $brand = \DB::table('brands')->where(['id'=>$value->brand_id])->first();

                    // $image_details =  isset($image_details->image?$image_details->image:'')
                    ?>
                      <tr>
                        <td>
                          {{$key+1}}
                        </td>
                        <td>
                          {{$value->name}}
                        </td>
                        <td>
                          {{ (isset($main_category->title))? $main_category->title: '-'; }}
                        </td>
                        <td>
                          {{ (isset($category->title))? $category->title: '-'; }}
                        </td>
                        <td>
                          {{ (isset($brand->title))? $brand->title: '-'; }}
                        </td>
                        <td>
                            @if($value['topSelling']=='1')
                            <a class="btn btn-success btn-sm" href="{{url('/')}}/change_topselling_status/{{$value->id}}">Yes</a>
                            @else($value['topSelling']=='0')
                              <a class="btn btn-danger btn-sm" href="{{url('/')}}/change_topselling_status/{{$value->id}}">No</a>
                            @endif
                          </td>
                          <td>
                            @if($value['topTrending']=='1')
                            <a class="btn btn-success btn-sm" href="{{url('/')}}/change_toptrending_status/{{$value->id}}">Yes</a>
                            @else($value['topTrending']=='0')
                              <a class="btn btn-danger btn-sm" href="{{url('/')}}/change_toptrending_status/{{$value->id}}">No</a>
                            @endif
                          </td>
                          {{-- <td>
                            @if($value['general']=='1')
                            <a class="btn btn-success btn-sm" href="{{url('/')}}/change_general_status/{{$value->id}}">Yes</a>
                            @else($value['general']=='0')
                              <a class="btn btn-danger btn-sm" href="{{url('/')}}/change_general_status/{{$value->id}}">No</a>
                            @endif
                          </td> --}}
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