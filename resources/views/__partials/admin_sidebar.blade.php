<!--  preloader -->
<div class="se-pre-con"></div>
<!--  preloader -->
<!-- BEGIN SIDEBAR -->
  <div class="page-sidebar-wrapper">
    <div class="page-sidebar navbar-collapse collapse">
      <ul class="page-sidebar-menu page-sidebar-menu-light" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
        <li class="sidebar-search-wrapper"> 
          
          <!-- BEGIN RESPONSIVE QUICK SEARCH FORM -->
          
          <form class="sidebar-search " action="extra_search.html" method="POST">
            <a href="javascript:;" class="remove"> <i class="icon-close"></i> </a>
          </form>
          
          <!-- END RESPONSIVE QUICK SEARCH FORM --> 
          
        </li>
        <li class="{{App\Http\Libraries\Helper::isMenuActive('dashboard','start active open')}}"> <a href="{{url('/dashboard')}}"> <i class="icon-speedometer"></i> <span class="title">Dashboard</span> <span class="selected"></span> </a> </li>


        @canAccess('reservations')
          <li class="{{App\Http\Libraries\Helper::isMenuActive('reservation','start active open')}}"> <a href="{{url('/reservation')}}"> <i class="icon-calendar"></i> <span class="title">Reservations</span> </a> </li>
        @endif

        @canAccess('trainings')
          <li class="{{App\Http\Libraries\Helper::isMenuActive('private-lessons','start active open')}}"> <a href="{{route('private_lessons.list')}}"> <i class="icon-graph"></i> <span class="title">Private Lessons</span> </a> </li>
        @endif

        @canAccess('members')
          <li class="nav-item {{App\Http\Libraries\Helper::isMenuActive('member*','start active open')}}">
            <a href="?p=" class="nav-link nav-toggle">
              <i class="icon-user"></i>
              <span class="title">Members</span>
              <span class="selected"></span>
              <span class="arrow open"></span>
            </a>
            <ul class="sub-menu">
              <li class="nav-item {{App\Http\Libraries\Helper::isMenuActive('member','active open')}}">
                <a href="{{url('/member')}}" class="nav-link ">
                  <span class="title">Registered Members</span>
                  <span class="selected"></span>
                </a>
              </li>
              <li class="nav-item {{App\Http\Libraries\Helper::isMenuActive('member/pending','active open')}}">
                <a href="{{url('/member/pending')}}" class="nav-link ">
                  <span class="title">Pending Approval</span>
                  <span class="selected"></span>
                </a>
              </li>
              <li class="nav-item {{App\Http\Libraries\Helper::isMenuActive('member/rejected','active open')}}">
                <a href="{{url('/member/rejected')}}" class="nav-link ">
                  <span class="title">Rejected</span>
                  <span class="selected"></span>
                </a>
              </li>
            </ul>
          </li>
        @endif

        @canAccess('employees')
          <li class="{{App\Http\Libraries\Helper::isMenuActive('employee*','start active open')}}"> <a href="{{url('/employee')}}"> <i class="icon-grid"></i> <span class="title">Employee</span> </a> </li>
        @endif

        @canAccess('beacons')
         <li class="{{App\Http\Libraries\Helper::isMenuActive('beacon','start active open')}}"> <a href="{{url('/beacon')}}"> <i class="icon-feed"></i> <span class="title">Beacon</span> </a> </li>

        @endif

        @canAccess('courts')
          <li class="{{App\Http\Libraries\Helper::isMenuActive('court*','start active open')}}"> <a href="{{url('/court')}}"> <i class="icon-grid"></i> <span class="title">Courts</span> </a> </li>

        @endif

        @canAccess('coaches')
          <li class="{{App\Http\Libraries\Helper::isMenuActive('coaches*','start active open')}}"> <a href="{{url('/coaches')}}"> <i class="icon-grid"></i> <span class="title">Coaches</span> </a> </li>

        @endif

        @canAccess('trainings')
          <li class="{{App\Http\Libraries\Helper::isMenuActive('trainings*','start active open')}}"> <a href="{{url('/trainings')}}"> <i class="icon-grid"></i> <span class="title">Trainings</span> </a> </li>

        @endif

        @canAccess('photoGallery')
          <li> <a href="javascript:;"> <i class="icon-film"></i> <span class="title">Photo Gallery</span> </a> </li>

        @endif

        @canAccess('news')
          <li class="{{App\Http\Libraries\Helper::isMenuActive('newsfeeds','start active open')}}"> <a href="{{url('/newsfeeds')}}"> <i class="icon-speech"></i> <span class="title">News / Events</span> </a> </li>

        @endif

        @canAccess('clubWall')
          <li> <a href="javascript:;"> <i class="icon-frame"></i> <span class="title">Club Wall</span> </a> </li>

        @endif
        {{--<li> <a href="javascript:;"> <i class="icon-notebook"></i> <span class="title">Billing</span> </a> </li>--}}

        @canAccess('communication')
          <li class="{{App\Http\Libraries\Helper::isMenuActive('communication','start active open')}}"> <a href="{{url('/communication')}}"> <i class="icon-speech"></i> <span class="title">Communication</span> </a> </li>

        @endif
        {{--<li> <a href="javascript:;"> <i class="icon-list"></i> <span class="title">Information</span> </a> </li>--}}

        @canAccess('leagues')
          <li class="{{App\Http\Libraries\Helper::isMenuActive('league*','start active open')}}"> <a href="{{url('/league')}}"> <i class="icon-grid"></i> <span class="title">Leagues</span> </a> </li>

        @endif
        
        @canAccess('tournaments')
          <li class="nav-item {{App\Http\Libraries\Helper::isMenuActive('tournament*','start active open')}}">
            <a href="?p=" class="nav-link nav-toggle">
              <i class="icon-users"></i>
              <span class="title">Tournaments</span>
              <span class="selected"></span>
              <span class="arrow open"></span>
            </a>
            <ul class="sub-menu">
              <li class="nav-item {{App\Http\Libraries\Helper::isMenuActive('tournament','active open')}}">
                <a href="{{url('/tournament')}}" class="nav-link ">
                  <span class="title">Tournaments</span>
                  <span class="selected"></span>
                </a>
              </li>
              <li class="nav-item {{App\Http\Libraries\Helper::isMenuActive('tournament','active open')}}">
                <a href="{{url('/event')}}" class="nav-link ">
                  <span class="title">Events</span>
                  <span class="selected"></span>
                </a>
              </li>
            </ul>
          </li>
        @endif
        @canAccess('restaurant')
        <li class="{{App\Http\Libraries\Helper::isMenuActive('restaurant','start active open')}}"> <a href="{{url('/restaurant')}}"> <i class="icon-grid"></i> <span class="title">Restaurant</span> </a> </li>
        <li class="{{App\Http\Libraries\Helper::isMenuActive('restaurant/orders-archive*','start active open')}}"> <a href="{{url('/restaurant/orders-archive')}}"> <i class="icon-grid"></i> <span class="title">Orders Archive</span> </a> </li>
        <li class="{{App\Http\Libraries\Helper::isMenuActive('misc-receipts*','start active open')}}"> <a href="{{url('/misc-receipts')}}"> <i class="icon-grid"></i> <span class="title">Misc Receipts</span> </a> </li>
        <li class="{{App\Http\Libraries\Helper::isMenuActive('tab-accounts','start active open')}}"> <a href="{{url('/tab-accounts')}}"> <i class="icon-grid"></i> <span class="title">Tabs</span> </a> </li>
        <li class="{{App\Http\Libraries\Helper::isMenuActive('tab-accounts/deposits*','start active open')}}"> <a href="{{url('/tab-accounts/deposits')}}"> <i class="icon-grid"></i> <span class="title">Tab Deposits</span> </a> </li>

        @endif
        
        
      </ul>
      
      <!-- END SIDEBAR MENU --> 
      
    </div>
  </div>
  
  <!-- END SIDEBAR -->
