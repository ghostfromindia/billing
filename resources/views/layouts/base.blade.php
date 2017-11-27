<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">


    <title>@yield('title')</title>

    <!-- vendor css -->
    <link href="{{URL::asset('/lib/font-awesome/css/font-awesome.css')}}" rel="stylesheet">
    <link href="{{URL::asset('/lib/Ionicons/css/ionicons.css')}}" rel="stylesheet">
    <link href="{{URL::asset('/lib/perfect-scrollbar/css/perfect-scrollbar.css')}}" rel="stylesheet">
    <link href="{{URL::asset('/lib/jquery-toggles/toggles-full.css')}}" rel="stylesheet">
    <link href="{{URL::asset('/lib/rickshaw/rickshaw.min.css')}}" rel="stylesheet">

    @section('styles')
    @show

    <!-- Amanda CSS -->
    <link rel="stylesheet" href="{{URL::asset('/css/amanda.css')}}">
  </head>

  <body>

    <div class="am-header">
      <div class="am-header-left">
        <a id="naviconLeft" href="" class="am-navicon d-none d-lg-flex"><i class="icon ion-navicon-round"></i></a>
        <a id="naviconLeftMobile" href="" class="am-navicon d-lg-none"><i class="icon ion-navicon-round"></i></a>
        <a href="index.html" class="am-logo">Development</a>
      </div><!-- am-header-left -->

      <div class="am-header-right">
        <!-- dropdown -->
        <div class="dropdown dropdown-profile">
          <a href="" class="nav-link nav-link-profile" data-toggle="dropdown">
            <img src="../img/img3.jpg" class="wd-32 rounded-circle" alt="">
            <span class="logged-name"><span class="hidden-xs-down">Admin</span> <i class="fa fa-angle-down mg-l-3"></i></span>
          </a>
          <div class="dropdown-menu wd-200">
            <ul class="list-unstyled user-profile-nav">
              <li><a href=""><i class="icon ion-ios-person-outline"></i> Edit Profile</a></li>
              <li><a href=""><i class="icon ion-ios-gear-outline"></i> Settings</a></li>
              <li><a href=""><i class="icon ion-power"></i> Sign Out</a></li>
            </ul>
          </div><!-- dropdown-menu -->
        </div><!-- dropdown -->
      </div><!-- am-header-right -->
    </div><!-- am-header -->

    <div class="am-sideleft">
    

      <div class="tab-content">
        <div id="mainMenu" class="tab-pane active">
          <ul class="nav am-sideleft-menu">
            <li class="nav-item">
              <a href="{{URL::to('home')}}" class="nav-link active">
                <i class="icon ion-ios-home-outline"></i>
                <span>Dashboard</span>
              </a>
            </li><!-- nav-item -->
            <li class="nav-item">
              <a href="" class="nav-link with-sub">
                <i class="icon ion-ios-gear-outline"></i>
                <span>Products</span>
              </a>
              <ul class="nav-sub">
                <li class="nav-item"><a href="{{URL::to('product/add')}}" class="nav-link">Add Product</a></li>
                <li class="nav-item"><a href="{{URL::to('product/edit/stock')}}" class="nav-link">Add/Remove stock</a></li>
                <li class="nav-item"><a href="{{URL::to('product/view')}}" class="nav-link">View Products</a></li>
              </ul>
            </li><!-- nav-item -->
            <li class="nav-item">
              <a href="" class="nav-link with-sub">
                <i class="icon ion-ios-gear-outline"></i>
                <span>Sales</span>
              </a>
              <ul class="nav-sub">
                <li class="nav-item"><a href="{{URL::to('sale')}}" class="nav-link">Add Sale</a></li>
                <li class="nav-item"><a href="{{URL::to('sale/view')}}" class="nav-link">View bills</a></li>
                <li class="nav-item"><a href="{{URL::to('search')}}" class="nav-link">Bill search</a></li>
              </ul>
            </li><!-- nav-item -->
            <li class="nav-item">
              <a href="{{URL::to('report')}}" class="nav-link ">
                <i class="icon ion-ios-gear-outline"></i>
                <span>Report</span>
              </a>
            </li><!-- nav-item -->
            
          </ul>
        </div><!-- #mainMenu -->
        
        
      </div><!-- tab-content -->
    </div><!-- am-sideleft -->

    <div class="am-mainpanel">
      <div class="am-pagetitle">
        <h5 class="am-title">@yield('title')</h5>
       
      </div><!-- am-pagetitle -->

       <div class="am-pagebody">

        @section('content')
        @show
   
      </div><!-- am-pagebody --> 
      <div class="am-footer">
        
      </div><!-- am-footer -->
    </div><!-- am-mainpanel -->

    <script src="{{URL::asset('/lib/jquery/jquery.js')}}"></script>
    <script src="{{URL::asset('/lib/popper.js/popper.js')}}"></script>
    <script src="{{URL::asset('/lib/bootstrap/bootstrap.js')}}"></script>
    <script src="{{URL::asset('/lib/perfect-scrollbar/js/perfect-scrollbar.jquery.js')}}"></script>
    <script src="{{URL::asset('/lib/jquery-toggles/toggles.min.js')}}"></script>
    <script src="{{URL::asset('/lib/d3/d3.js')}}"></script>
    <script src="{{URL::asset('/lib/rickshaw/rickshaw.min.js')}}"></script>
    <script src="http://maps.google.com/maps/api/js?key=AIzaSyAEt_DBLTknLexNbTVwbXyq2HSf2UbRBU8"></script>
    <script src="{{URL::asset('/lib/gmaps/gmaps.js')}}"></script>
    <script src="{{URL::asset('/lib/Flot/jquery.flot.js')}}"></script>
    <script src="{{URL::asset('/lib/Flot/jquery.flot.pie.js')}}"></script>
    <script src="{{URL::asset('/lib/Flot/jquery.flot.resize.js')}}"></script>
    <script src="{{URL::asset('/lib/flot-spline/jquery.flot.spline.js')}}"></script>

    <script src="{{URL::asset('/js/amanda.js')}}"></script>
    <script src="{{URL::asset('/js/ResizeSensor.js')}}"></script>
    <script src="{{URL::asset('/js/dashboard.js')}}"></script>

    @section('script')
    @show
  </body>
</html>
