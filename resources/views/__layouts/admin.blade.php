<!DOCTYPE html>

<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->

<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->

<!--[if !IE]><!-->

<html lang="en" class="no-js">

<!--<![endif]-->

<!-- BEGIN HEAD -->

<head>
<meta charset="utf-8"/>
<title>Grit Dashboard - Home</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="width=device-width, initial-scale=1" name="viewport"/>
<meta content="" name="description"/>
<meta content="" name="author"/>
@include('__partials.admin_css')
</head>

<!-- END HEAD -->

<!-- BEGIN BODY -->

<body class="page-header-fixed page-sidebar-closed-hide-logo page-container-bg-solid page-content-white">

<!-- BEGIN HEADER -->

<div class="page-header md-shadow-z-1-i navbar navbar-fixed-top"> 
  
  <!-- BEGIN HEADER INNER -->
  
  <div class="page-header-inner"> 
    
    <!-- BEGIN LOGO --> 
    
    {{--
    <div class="page-logo"> <a href="{{url('/dashboard')}}"> <img src="{{asset('assets/img/logo.png')}}" alt="logo" class="logo-default"/> </a>--}}
      {{--
      <div class="menu-toggler sidebar-toggler hide"> </div>
      --}}
      {{--</div>
    --}}
    <div class="page-logo"> <a href="{{url('/dashboard')}}"> <img src="{{asset("assets/img/logo.png")}}" alt="logo" class="logo-default"> </a>
      <div class="menu-toggler sidebar-toggler"> <span></span> </div>
    </div>
    
    <!-- END LOGO --> 
    
    <!-- BEGIN RESPONSIVE MENU TOGGLER --> 
    
    {{--<a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse"> </a> --}} 
    
    <!-- END RESPONSIVE MENU TOGGLER --> 
    
    <!-- BEGIN TOP NAVIGATION MENU -->
    
    <div class="top-menu">
      <ul class="nav navbar-nav pull-right">
        
        <!-- BEGIN NOTIFICATION DROPDOWN -->
        
        <li class="dropdown dropdown-user"> <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true"> @if(\Session::has('profilePic') && \Session::get('profilePic') != '') <img alt="" class="img-circle" src="{{asset(\Session::get('profilePic'))}}"/> @else <img alt="" class="img-circle" src="{{asset('assets/img/avatar3_small.jpg')}}"/> @endif <span class="username username-hide-on-mobile"> {{\Session::get('firstName')}}</span> <i class="fa fa-angle-down"></i> </a>
          <ul class="dropdown-menu dropdown-menu-default">
            <li> <a href="{{url('/club')}}"> <i class="icon-user"></i> My Profile </a> </li>
            <li> <a href="{{url('/logout')}}"> <i class="icon-key"></i> Log Out </a> </li>
          </ul>
        </li>
        
        <!-- END USER LOGIN DROPDOWN --> 
        
        <!-- BEGIN QUICK SIDEBAR TOGGLER --> 
        
        <!-- END QUICK SIDEBAR TOGGLER -->
        
      </ul>
    </div>
    
    <!-- END TOP NAVIGATION MENU --> 
    
  </div>
  
  <!-- END HEADER INNER --> 
  
</div>

<!-- END HEADER -->

<div class="clearfix"> </div>

<!-- BEGIN CONTAINER -->

<div class="page-container"> 
  <!-- BEGIN SIDEBAR --> 
  @include('__partials.admin_sidebar') 
  <!-- END SIDEBAR -->
  <div class="page-content-wrapper">
    <div class="page-content"> @yield('main') </div>
  </div>
  <!--  page content wrapper --> 
  <!-- BEGIN QUICK SIDEBAR --> 
  
  <a href="javascript:;" class="page-quick-sidebar-toggler"><i class="icon-close"></i></a> 
  
  <!-- END QUICK SIDEBAR --> 
</div>
<!-- page-container --> 

<!-- BEGIN FOOTER -->

<div class="page-footer">
  <div class="page-footer-inner"> Copyrights <?php echo date("Y"); ?> Design & Developed for Grit
    <div class="scroll-to-top"> <i class="icon-arrow-up"></i> </div>
  </div>
</div>

<!-- END FOOTER --> 
@include('__partials.admin_js')
@yield('page-specific-scripts')
</body>
<!-- END BODY -->
</html>