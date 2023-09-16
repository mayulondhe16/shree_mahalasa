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
              <form action="{{ url('/')}}/update_{{$url_slug}}/{{$data['id']}}" method="post" role="form" data-parsley-validate="parsley" enctype="multipart/form-data" autocomplete="off">
                {!! csrf_field() !!}  
                <?php 
                    $product_images = \DB::table('product_images')->where('product_id',$data->id)->whereNull('deleted_at')->get();                
                ?>
               
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="oldpassword">Product Images<span style="color:red;" >*</span></label>
                            <div class="row">
                              @if ($product_images)
                              @foreach ($product_images as $image)
                              <div class="col-md-4">
                                 <p>
                                <img id="output_image1" height="200px" width="300px" src="{{ Config::get('DocumentConstant.PRODUCT_VIEW') }}{{ $image->image }}" />
                                </p> 
                                <p><a href="{{url('/')}}/delete_product_image/{{ $image->id }}" title="Delete" onclick="return confirm('Are you sure you want to delete this record?');">
                                    <i class="fa fa-trash"></i></a>
                                    
                              </div>
                              
                              @endforeach
                              <input type="file"  name="images[]" accept="image/*" onchange="preview_image(event,1)"   @if (empty($product_images)) required="true" @endif multiple>

                              @endif
                            </div>   
                    </div>
                </div>
                </div>
                <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                      <label for="oldpassword">Thumbnail Image<span style="color:red;" >*</span></label>
                         <p>
                          <img id="output_image1" height="200px" width="300px" src="{{ Config::get('DocumentConstant.PRODUCTTHUMB_VIEW') }}{{ $data['thumbnail_image'] }}" />
                        </p>
                          <div class="input-group input-group-outline mb-3">
                          <input type="file"  name="image" accept="image/*" onchange="preview_image(event,1)" @if (empty($data['thumbnail_image'])) required="true" @endif>
                      </div>
                  </div>
              </div>
                </div>
               
                    <div class="row">
                      <div class="col-md-6">
                          <div class="form-group">
                            <label class="form-label">Name</label><span style="color:red;" >*</span>
                              <div class="input-group input-group-outline mb-3">
                                <input type="text"  class="form-control" name="name"  data-parsley-error-message="Please enter valid product name." data-parsley-pattern="^[a-z A-Z .]+$" required="true" value="{{$data->name}}">
                              </div>
                          </div>
                      </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                              <label class="form-label">Brand</label><span style="color:red;" >*</span>
                                <div class="input-group input-group-outline mb-3">
                                    <select class="form-control" id="brand_id" name="brand_id"  data-parsley-error-message="Please select brand." required="true">
                                      <option value="">Select Brand</option>
                                      @foreach($brand as $val)
                                      <option value="{{$val->id}}" @if($data->brand_id==$val->id) selected @endif>{{$val->title}}</option>
                                      @endforeach
                                      <option value="Other" @if($data->brand_id=='Other') selected @endif>Other</option>
                                    </select>
                                  </div>
                            </div>
                        </div>
                    </div>
                      <div class="row">
                      <div class="col-md-6">
                          <div class="form-group">
                            <label class="form-label">Main Category</label><span style="color:red;" >*</span>
                              <div class="input-group input-group-outline mb-3">
                                  <select class="form-control" id="main_category" name="main_category" onchange="change_subcategory()" data-parsley-error-message="Please select main category." required="true">
                                    <option value="">Select Main Category</option>
                                    @foreach($main_category as $value)
                                    <option value="{{$value->id}}" @if($data->main_category==$value->id) selected @endif>{{$value->title}}</option>
                                    @endforeach
                                  </select>
                                </div>
                          </div>
                      </div>
                  </div> 
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                              <label class="form-label">Sub Category</label><span style="color:red;" >*</span>
                                <div class="input-group input-group-outline mb-3">
                                    <select class="form-control" id="category_id" name="category_id"data-parsley-error-message="Please select sub category." required="true">
                                      <option value="">Select Sub Category</option>
                                      @foreach($category as $value)
                                      <option value="{{$value->id}}" @if($data->category_id==$value->id) selected @endif>{{$value->title}}</option>
                                      @endforeach
                                    </select>
                                  </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                          <div class="form-group">
                            <label class="form-label">Product Description</label><span style="color:red;" >*</span>
                              <div class="input-group input-group-outline mb-3">
                                  <textarea  class="form-control" name="description" required="true">{{$data->description}}</textarea>
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
      <script>
        function change_subcategory() 
        {        
            var selectValue = $("#main_category").val();            
            //$("#city_id_").empty();

            $.ajax({
                url: '{{url('/')}}/getsubcategory',
                type: 'post',
                data: { "_token": "{{ csrf_token() }}",id: selectValue},
                success: function (data) 
                {
                  $("#category_id").html(data);
                }
            });
        };
      </script>
@endsection