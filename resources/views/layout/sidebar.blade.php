<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3   bg-gradient-dark" id="sidenav-main">
    <div class="sidenav-header">
      <i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
      <a class="navbar-brand m-0" href="/dashbord">
        <img src="{{asset('assets/img/logo-cm.png')}}" class="navbar-brand-img h-100" alt="main_logo">
        <span class="ms-1 font-weight-bold text-white">Shree Mahalasa</span>
      </a>
    </div>
    <hr class="horizontal light mt-0 mb-2">
    <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
      <ul class="navbar-nav">
        {{-- <li class="nav-item">
          <a class="nav-link text-white active bg-gradient-primary" href="/dashbord">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">dashboard</i>
            </div>
            <span class="nav-link-text ms-1">Dashboard</span>
          </a>
        </li> --}}
        <li class="nav-item">
          <a class="nav-link text-white active bg-gradient-primary @if(Request::segment(1)=='dashbord' || Request::segment(1)=='add_city' || Request::segment(1)=='edit_city' || Request::segment(1)=='dashbord') active @endif" href="{{url('/')}}/dashbord">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">dashboard</i>
            </div>
            <span class="nav-link-text ms-1">Dashboard</span>
          </a>
        </li>


        <li class="nav-item">
          <a class="nav-link text-white @if(Request::segment(1)=='manage_logo' || Request::segment(1)=='add_logo' || Request::segment(1)=='edit_logo' || Request::segment(1)=='view_logo') active @endif" href="{{url('/')}}/manage_logo">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">table_view</i>
            </div>
            <span class="nav-link-text ms-1">Logo</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white @if(Request::segment(1)=='manage_city' || Request::segment(1)=='add_city' || Request::segment(1)=='edit_city' || Request::segment(1)=='view_city') active @endif" href="{{url('/')}}/manage_city">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">table_view</i>
            </div>
            <span class="nav-link-text ms-1">City</span>
          </a>
        </li>
        
        <li class="nav-item">
          <a class="nav-link text-white @if(Request::segment(1)=='manage_socialmedialinks' || Request::segment(1)=='add_socialmedialinks' || Request::segment(1)=='edit_socialmedialinks' || Request::segment(1)=='view_socialmedialinks') active @endif"  href="{{url('/')}}/manage_socialmedialinks">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">table_view</i>
            </div>
            <span class="nav-link-text ms-1">Social Media Links</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white @if(Request::segment(1)=='manage_main_category' || Request::segment(1)=='add_main_category' || Request::segment(1)=='edit_main_category' || Request::segment(1)=='view_main_category') active @endif" href="{{url('/')}}/manage_main_category">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">table_view</i>
            </div>
            <span class="nav-link-text ms-1">Product Main-Category</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white @if(Request::segment(1)=='manage_category' || Request::segment(1)=='add_category' || Request::segment(1)=='edit_category' || Request::segment(1)=='view_category') active @endif" href="{{url('/')}}/manage_category">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">table_view</i>
            </div>
            <span class="nav-link-text ms-1">Product Sub-Category</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white @if(Request::segment(1)=='manage_homebanner' || Request::segment(1)=='add_homebanner' || Request::segment(1)=='edit_homebanner' || Request::segment(1)=='view_homebanner') active @endif" href="{{url('/')}}/manage_homebanner">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">table_view</i>
            </div>
            <span class="nav-link-text ms-1">Home Banner</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white @if(Request::segment(1)=='manage_banner' || Request::segment(1)=='add_banner' || Request::segment(1)=='edit_banner' || Request::segment(1)=='view_banner') active @endif" href="{{url('/')}}/manage_banner">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">table_view</i>
            </div>
            <span class="nav-link-text ms-1">Category Banner</span>
          </a>
        </li>
        {{-- <li class="nav-item">
          <a class="nav-link text-white @if(Request::segment(1)=='manage_menu' || Request::segment(1)=='add_menu' || Request::segment(1)=='edit_menu' || Request::segment(1)=='view_menu') active @endif" href="{{url('/')}}/manage_menu">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">table_view</i>
            </div>
            <span class="nav-link-text ms-1">Menu</span>
          </a>
        </li> --}}
        <li class="nav-item">
          <a class="nav-link text-white @if(Request::segment(1)=='manage_aboutus' || Request::segment(1)=='add_aboutus' || Request::segment(1)=='edit_aboutus' || Request::segment(1)=='view_aboutus') active @endif" href="{{url('/')}}/manage_aboutus">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">table_view</i>
            </div>
            <span class="nav-link-text ms-1">About Us</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white @if(Request::segment(1)=='manage_products' || Request::segment(1)=='add_products' || Request::segment(1)=='edit_products' || Request::segment(1)=='view_products') active @endif"  href="{{url('/')}}/manage_products">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">table_view</i>
            </div>
            <span class="nav-link-text ms-1">Products</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white @if(Request::segment(1)=='manage_manage_top_selling' || Request::segment(1)=='add_manage_top_selling' || Request::segment(1)=='edit_manage_top_selling' || Request::segment(1)=='view_manage_top_selling') active @endif"  href="{{url('/')}}/manage_top_selling">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">table_view</i>
            </div>
            <span class="nav-link-text ms-1">Top Selling Products</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white @if(Request::segment(1)=='manage_brands' || Request::segment(1)=='add_brand' || Request::segment(1)=='edit_brand' || Request::segment(1)=='view_brand') active @endif" href="{{url('/')}}/manage_brands">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">table_view</i>
            </div>
            <span class="nav-link-text ms-1">Brands</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white @if(Request::segment(1)=='manage_location' || Request::segment(1)=='add_location' || Request::segment(1)=='edit_location' || Request::segment(1)=='view_location') active @endif" href="{{url('/')}}/manage_location">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">table_view</i>
            </div>
            <span class="nav-link-text ms-1">Location</span>
          </a>
        </li>
         
        <li class="nav-item">
          <a class="nav-link text-white @if(Request::segment(1)=='manage_contactdetails' || Request::segment(1)=='add_contactdetails' || Request::segment(1)=='edit_contactdetails' || Request::segment(1)=='view_contactdetails') active @endif" href="{{url('/')}}/manage_contactdetails">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">table_view</i>
            </div>
            <span class="nav-link-text ms-1">Company Contact Details</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white @if(Request::segment(1)=='manage_newsletter' || Request::segment(1)=='add_newsletter' || Request::segment(1)=='edit_newsletter' || Request::segment(1)=='view_newsletter') active @endif"  href="{{url('/')}}/manage_newsletter">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">table_view</i>
            </div>
            <span class="nav-link-text ms-1">Newsletter List</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white @if(Request::segment(1)=='manage_contactus' || Request::segment(1)=='add_contactus' || Request::segment(1)=='edit_contactus' || Request::segment(1)=='view_contactus') active @endif"  href="{{url('/')}}/manage_contactus">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">table_view</i>
            </div>
            <span class="nav-link-text ms-1">Contact Us</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white @if(Request::segment(1)=='manage_profile' || Request::segment(1)=='add_profile' || Request::segment(1)=='edit_profile' || Request::segment(1)=='view_profile') active @endif"  href="{{url('/')}}/manage_profile">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">table_view</i>
            </div>
            <span class="nav-link-text ms-1">Profile</span>
          </a>
        </li>
        {{-- <li class="nav-item">
          <a class="nav-link text-white @if(Request::segment(1)=='manage_size' || Request::segment(1)=='add_size' || Request::segment(1)=='edit_size' || Request::segment(1)=='view_size') active @endif" href="{{url('/')}}/manage_size">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">table_view</i>
            </div>
            <span class="nav-link-text ms-1">Size</span>
          </a>
        </li> --}}
      
   
        {{-- <li class="nav-item">
          <a class="nav-link text-white @if(Request::segment(1)=='manage_shade' || Request::segment(1)=='add_shade' || Request::segment(1)=='edit_shade' || Request::segment(1)=='view_shade') active @endif" href="{{url('/')}}/manage_shade">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">table_view</i>
            </div>
            <span class="nav-link-text ms-1">Shade</span>
          </a>
        </li> --}}
       
       
        {{-- <li class="nav-item">
          <a class="nav-link text-white @if(Request::segment(1)=='manage_quicklinks' || Request::segment(1)=='add_quicklinks' || Request::segment(1)=='edit_quicklinks' || Request::segment(1)=='view_quicklinks') active @endif" href="{{url('/')}}/manage_quicklinks">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">table_view</i>
            </div>
            <span class="nav-link-text ms-1">Quick Links</span>
          </a>
        </li> --}}
        
    
        {{-- <li class="nav-item">
          <a class="nav-link text-white @if(Request::segment(1)=='manage_shops' || Request::segment(1)=='add_shops' || Request::segment(1)=='edit_shops' || Request::segment(1)=='view_shops') active @endif" href="{{url('/')}}/manage_shops">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">table_view</i>
            </div>
            <span class="nav-link-text ms-1">Shops Master</span>
          </a>
        </li> --}}
       
       
      </ul>
    </div>
  </aside>