<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Stream-Lode|Admin</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('AdminLTE-3.2.0/plugins/fontawesome-free/css/all.min.css') }}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="{{ asset('AdminLTE-3.2.0/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{ asset('AdminLTE-3.2.0/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
  <!-- JQVMap -->
  <link rel="stylesheet" href="{{ asset('AdminLTE-3.2.0/plugins/jqvmap/jqvmap.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('AdminLTE-3.2.0/dist/css/adminlte.min.css') }}">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{ asset('AdminLTE-3.2.0/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="{{ asset('AdminLTE-3.2.0/plugins/daterangepicker/daterangepicker.css') }}">
  <!-- summernote -->
  <link rel="stylesheet" href="{{ asset('AdminLTE-3.2.0/plugins/summernote/summernote-bs4.min.css') }}">
  <!-- <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
  <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script> -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  @vite(['resources/css/app.css' , 'resources/js/adminapp.js'])
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="{{ asset('Assets/site-logos/Stresmlode-logo.png') }}" alt="AdminLTELogo" height="80" width="220">
  </div>

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="{{ url('/admin/dashboard') }}" class="nav-link">Home</a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Navbar Search -->
      <li class="nav-item">
        <a class="nav-link" data-widget="navbar-search" href="#" role="button">
          <i class="fas fa-search"></i>
        </a>
        <div class="navbar-search-block">
          <form class="form-inline">
            <div class="input-group input-group-sm">
              <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
              <div class="input-group-append">
                <button class="btn btn-navbar" type="submit">
                  <i class="fas fa-search"></i>
                </button>
                <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
          </form>
        </div>
      </li>
      @php
        $messages = App\Models\Messages::where([['reciever_id','=',Auth()->user()->id],['status','=',1]])->orWhere([['type','=',1],['status','=',1]])->with('users')->get();
        $mnotification = App\Models\Messages::where([['reciever_id','=',Auth()->user()->id],['status','=',1]])->distinct('sender_id')->get()->toArray();
        @endphp
      <input type="hidden" id="hostauthid" value="{{Auth::user()->id}}">
      <!-- Messages Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-comments"></i>
          <span class="badge badge-danger navbar-badge" id="messagecount">{{ count($messages) ?? 0 }}</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" id="messagedropdown" style="left: inherit; right: 0px;">
        @foreach($mnotification as $m)
        @php
        $user = App\Models\User::where('_id',$m[0])->with('adminmessage',function($response){ $response->where('reciever_id',Auth()->user()->id); })->first();
        @endphp
          <a href="{{ url('/admin/host-details/'.$user['unique_id']) }}" class="dropdown-item" id="{{ $m[0] }}">
            <div class="media">
              <div class="media-body">
                <p class="text-sm"><b>{{ count($user['adminmessage']) ?? '' }} new message from {{ $user['first_name'] ?? '' }}</b></p>
              </div>
            </div>
          </a>
          <div class="dropdown-divider"></div>
        @endforeach
        </div>
      </li>
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="">
          <i class="far fa-bell"></i>
          <span class="badge badge-warning navbar-badge" id="notificationcount"></span>
        </a>
       
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
        
          <span class="dropdown-item dropdown-header">15 Notifications</span>
          <div class="dropdown-divider"></div>
          <a href="{{url('admin/host-list')}}" class="dropdown-item">
            <i class="fas fa-envelope mr-2"></i> <span ></span> new messages
            <span class="float-right text-muted text-sm">3 mins</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-users mr-2"></i> 8 friend requests
            <span class="float-right text-muted text-sm">12 hours</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-file mr-2"></i> 3 new reports
            <span class="float-right text-muted text-sm">2 days</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
        </div>
      </li>
      <!-- Account  -->
       <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-user"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header"> <h6> Account </h6></span>
          <div class="dropdown-divider"></div>
          <a href="{{ url('logout') }}" class="dropdown-item">
            <i class="fas fa-user mr-2"></i> Logout
          </a>
          <div class="dropdown-divider"></div>
        </div>
      </li>
      <!--  -->

      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-controlsidebar-slide="true" href="#" role="button">
          <i class="fas fa-th-large"></i>
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ url('/admin/dashboard') }}" class="brand-link" style="height:57px;">

      <img src="http://127.0.0.1:8000/streamlode-front-assets/images/logo.png" alt="AdminLTE Logo" class="brand-image" height="80" width="220">
     
    </a>

   
    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          @if(isset(auth()->user()->profile_image_url) || !empty(auth()->user()->profile_image_url))
          <img src="{{ auth()->user()->profile_image_url }}" class="img-circle elevation-3" alt="User Image">
          @else
          <img src="{{ asset('Assets/images/default-avatar.jpg') }}" class="img-circle elevation-3" alt="User Image">
          @endif
        </div>
        @if(auth()->user()->first_name)
        <div class="info">
          <a href="#" class="d-block">{{ auth()->user()->first_name }}</a>
        </div>
        @endif
      </div>
     
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Dashboard -->
           <li class="nav-item ">
            <a href="{{ url('/admin/dashboard') }}" class="nav-link active">
              <i class="nav-icon fas fa-solid fa-house"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          <!-- Users -->
          <li class="nav-item ">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Users
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('host-list') }}" class="nav-link active">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Hosts</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('guest-list') }}" class="nav-link active">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Guest</p>
                </a>
              </li>
            </ul>
          </li>
          <!-- membership tiers -->
          <li class="nav-item ">
            <a href="#" class="nav-link active">
              <i class="nav-icon fa-solid fa-users-viewfinder"></i>
              <p>
                Membership Tiers
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ url('/admin/membership-list') }}" class="nav-link active">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Membership list</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ url('/admin/add-membership-tier') }}" class="nav-link active">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Add Membership Tier</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ url('/admin/features') }}" class="nav-link active">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Add Membership Feature</p>
                </a>
              </li>
            </ul>
          </li>
          <!-- Discount Coupons  -->
          <li class="nav-item ">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-solid fa-hand-holding-dollar"></i>
              <p>
                Discount Coupons
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <input type="hidden" id="base_url" value="{{ url('') }}">
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('generate-discount') }}" class="nav-link active">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Generate Coupon</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('discount-coupon-list') }}" class="nav-link active">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Coupons List</p>
                </a>
              </li>
            </ul>
          </li>
          <!-- payments -->
          <li class="nav-item ">
            <a href="#" class="nav-link active">
              <i class="nav-icon fa-solid fa-money-bill "></i>
              <p>
                Payments
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('membership-payment-list') }}" class="nav-link active">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Membership payments</p>
                 
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ url('/admin/stream-payments') }}" class="nav-link active">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Stream Payments</p>
                </a>
              </li>
            </ul>
          </li>
          <!-- Post notification -->
          <li class="nav-item ">
            <a href="{{ route('postnotification') }}" class="nav-link active">
            <i class="fa-regular fa-message nav-icon"></i>
              <p>
                  Post Notification 
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
          </li>
          <!-- Meetings -->
          <li class="nav-item ">
            <a href="{{ route('meetings') }}" class="nav-link active">
            <i class="fa-solid fa-users nav-icon"></i>
              <p>
                 Meetings
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
          </li>
          <!-- Account Details -->
          <li class="nav-item ">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-cog"></i>
              <p>
                Settings
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ url('/admin/general-settings') }}" class="nav-link active">
                  <i class="far fa-circle nav-icon"></i>
                  <p>General Settings</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ Route('changepassword') }}" class="nav-link active">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Change Password</p>
                </a>
              </li>
            </ul>
          </li>
          
          <!-- Discount Code -->
          <!-- <li class="nav-item ">
            <a href="index.html" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Discount Coupon
              </p>
            </a>
          </li> -->
          <!-- Emails -->
          <!-- <li class="nav-item ">
            <a href="index.html" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Emails
              </p>
            </a>
          </li> -->
          <!-- Emails -->
          <!-- <li class="nav-item ">
            <a href="index.html" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Messages <span style="border-radius:50%; background;red; color:white;">1</span>
              </p>
            </a>
          </li> -->
          <!-- Payments -->
          <!-- <li class="nav-item ">
            <a href="index.html" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                payments
              </p>
            </a>
          </li> -->
          <!-- settings -->
          <!-- <li class="nav-item ">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Settings
              </p>
            </a>
          </li> -->
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
  <div class="content-wrapper">
    @yield('content')
  </div>
  <footer class="main-footer">
  <strong>Copyright &copy; 2023 <a href="{{ URL::to('/') }}">Stream lode</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 1.0
    </div>
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="{{ asset('AdminLTE-3.2.0/plugins/jquery/jquery.min.js') }}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{ asset('AdminLTE-3.2.0/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{ asset('AdminLTE-3.2.0/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- ChartJS -->
<script src="{{ asset('AdminLTE-3.2.0/plugins/chart.js/Chart.min.js') }}"></script>
<!-- Sparkline -->
<script src="{{ asset('AdminLTE-3.2.0/plugins/sparklines/sparkline.js') }}"></script>
<!-- JQVMap -->
<script src="{{ asset('AdminLTE-3.2.0/plugins/jqvmap/jquery.vmap.min.js') }}"></script>
<script src="{{ asset('AdminLTE-3.2.0/plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
<!-- jQuery Knob Chart -->
<script src="{{ asset('AdminLTE-3.2.0/plugins/jquery-knob/jquery.knob.min.js') }}"></script>
<!-- daterangepicker -->
<script src="{{ asset('AdminLTE-3.2.0/plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('AdminLTE-3.2.0/plugins/daterangepicker/daterangepicker.js') }}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{ asset('AdminLTE-3.2.0/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<!-- Summernote -->
<script src="{{ asset('AdminLTE-3.2.0/plugins/summernote/summernote-bs4.min.js') }}"></script>
<!-- overlayScrollbars -->
<script src="{{ asset('AdminLTE-3.2.0/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('AdminLTE-3.2.0/dist/js/adminlte.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('AdminLTE-3.2.0/dist/js/demo.js') }}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{ asset('AdminLTE-3.2.0/dist/js/pages/dashboard.js') }}"></script>

<link rel="stylesheet" type="text/css"  href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script>

  @if(Session::has('success'))

  toastr.options =

  {

  	"closeButton" : true,

  	"progressBar" : true

  }

  		toastr.success("{{ session('success') }}");

  @endif



  @if(Session::has('error'))

  toastr.options =

  {

  	"closeButton" : true,

  	"progressBar" : true

  }

  		toastr.error("{{ session('error') }}");

  @endif



  @if(Session::has('info'))

  toastr.options =

  {

  	"closeButton" : true,

  	"progressBar" : true

  }

  		toastr.info("{{ session('info') }}");

  @endif



  @if(Session::has('warning'))

  toastr.options =

  {

  	"closeButton" : true,

  	"progressBar" : true

  }

  		toastr.warning("{{ session('warning') }}");

  @endif

</script>
</body>
</html>
