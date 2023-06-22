<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>StreamLode|Hosts</title>
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ url('public/AdminLTE-3.2.0/plugins/fontawesome-free/css/all.min.css') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="{{ url('public/AdminLTE-3.2.0/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{ url('public/AdminLTE-3.2.0/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
  <!-- JQVMap -->
  <link rel="stylesheet" href="{{ url('public/AdminLTE-3.2.0/plugins/jqvmap/jqvmap.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ url('public/AdminLTE-3.2.0/dist/css/adminlte.min.css') }}">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{ url('public/AdminLTE-3.2.0/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="{{ url('public/AdminLTE-3.2.0/plugins/daterangepicker/daterangepicker.css') }}">
  <!-- summernote -->
  <link rel="stylesheet" href="{{ url('public/AdminLTE-3.2.0/plugins/summernote/summernote-bs4.min.css') }}">
<!-- Twilio css -->
<link rel="stylesheet" href="{{ asset('twilio-assets/site.css') }}">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.css" />
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<!-- vite(['resources/css/app.css' , 'resources/js/app.js']) -->
<link rel="stylesheet" href="{{ url('public/build/assets/app-c59fe4ba.css') }}"/>
    <script type="module" src="{{ url('public/build/assets/app-5c8075f8.js') }}"></script>

 
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
      <!-- <li class="nav-item d-none d-sm-inline-block">
        <a href="{{ url(auth()->user()->unique_id.'/') }}" class="nav-link">Home</a>
      </li> -->
    </ul>
<input type="hidden" id="base_url" value="{{ url(Auth()->user()->unique_id) }}">
    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Navbar Search -->
      @if(!isset(auth()->user()->membership_id) || empty(auth()->user()->membership_id) || auth()->user()->active_status == 0)
      <li class="nav-item d-none d-sm-inline-block">
        <a href="{{ url('/'.auth()->user()->unique_id.'/membership') }}"  class="btn btn-warning text-white " data-toggle="tooltip" data-placement="bottom" title="Click this button and enjoy the hosting feature.">Get Membership <i class="fa fa-star-o" style="font-size:16px"></i></a>
      </li>
      @else
      <?php  
        $membership_details = App\Models\MembershipTier::Where('_id',auth()->user()->membership_id)->first();
        $membership_status = App\Models\HostSubscriptions::Where('host_id',auth()->user()->id)->first();
      ?>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="{{ url('/'.auth()->user()->unique_id.'/membership-details') }}" class="btn btn-warning text-white " data-toggle="tooltip" data-placement="bottom" title="@if($membership_status['subscription_status'] == 'paused')Your subscription billing is paused you cannot enjoy the feature of video streaming after the duration of your subscription. @endif">{{ $membership_details['name'] }}@if($membership_status['subscription_status'] == 'paused')(Paused) @endif </a>
      </li>
      @endif
      
      @php
         $messages = App\Models\Messages::where([['reciever_id','=',Auth()->user()->id],['status','=',1]])->orWhere([['type','=',1],['status','=',1]])->with('users')->get();
         $mnotification = App\Models\Messages::where([['reciever_id','=',Auth()->user()->id],['status','=',1]])->distinct('sender_id')->get()->toArray();
         $admin = App\Models\User::where('status',2)->first();
      @endphp
   
      <!-- Messages Dropdown Menu -->
      
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown show">
      <input type="hidden" id="adminid" value="{{ $admin->id ?? '' }}">
      <input type="hidden" id="hostauthid" value="{{Auth::user()->id}}">
        <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="true">
          <i class="far fa-comments"></i>
          <span class="badge badge-danger navbar-badge" id="messagecount">{{ count($messages) ?? 0 }}</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" id="messagedropdown" style="left: inherit; right: 0px;">
        @foreach($mnotification as $m)
        @php
        $user = App\Models\User::where('_id',$m[0])->with('adminmessage',function($response){ $response->where('reciever_id',Auth()->user()->id); })->first();
        @endphp
          <a href="{{ url(Auth()->user()->unique_id.'/message/'.$user['_id']) }}" class="dropdown-item" id="{{ $m[0] }}">
            <div class="media">
              <div class="media-body" id="messages-notification">
                <p class="text-sm"><b>{{ count($user['adminmessage']) ?? '' }} new message from {{ $user['first_name'] ?? '' }}</b></p>
              </div>
            </div>
          </a>
          <div class="dropdown-divider"></div>
        @endforeach
        </div>
      </li>
       <?php  $appoinments = App\Models\HostAppointments::where([['host_id',Auth()->user()->id],['seen_status',0],['questionrie_status',1]])->get();
        $notification = App\Models\PostNotification::get()->toArray();
        $data = array();
          foreach($notification as $d){
                if (in_array(Auth()->user()->id, $d['seen_users'])){
                 array_push($data,$d);                                   // check user is in seen hosts list or not
                  }else{
                   
                  }
            }
       ?>
      <li class="nav-item ">
        <a class="nav-link"  href="{{ url('/'.Auth()->user()->unique_id.'/notifications') }}">
          <i class="far fa-bell"></i>
          
          <span class="badge badge-warning navbar-badge" id="notificationcount" >{{ count($appoinments)+count($data) }}</span>
        </a>
       
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" id="notificationbox12" style="max-height: 171px; overflow: auto;">
          <span class="dropdown-item dropdown-header"></span>
          <div class="dropdown-divider"></div>
        
          @foreach($appoinments as $ap)
          <a href="{{ url(Auth()->user()->unique_id.'/appointments') }}" class="dropdown-item">
          <i class="nav-icon fas fa-calendar mr-2"></i>
          new appointment scheduled with {{$ap->guest_name}}
            <!-- <span class="float-right text-muted text-sm">12 hours</span> -->
          </a>
          <div class="dropdown-divider"></div>
          @endforeach
      
        </div>
      </li>
      <!-- Logout -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-user"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">Account</span>
          <div class="dropdown-divider"></div>
        
          @if(auth()->user()->status == 2)
          <a href="{{ url('admin/dashboard')}}" class="dropdown-item">
            <i class="fas fa-users mr-2"></i> Go to admin
          </a>
          @endif
          <a href="{{ url(Auth()->user()->unique_id.'/general-settings')}}" class="dropdown-item">
            <i class="fas fa-cog mr-2"></i> Settings
          </a>
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
      <!-- <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-controlsidebar-slide="true" href="#" role="button">
          <i class="fas fa-th-large"></i>
        </a>
      </li> -->
      
    </ul>
  </nav>
  <!-- /.navbar -->

<!-- Modal -->


  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ url(auth()->user()->unique_id.'/') }}" class="brand-link" style="height:57px;">
      <img src="{{ asset('streamlode-front-assets/images/logo.png') }}" alt="Host-dashboard-logo" class="brand-image" style="opacity: .8">
    
    </a>
    

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          @if(isset(auth()->user()->profile_image_name) || !empty(auth()->user()->profile_image_name))
          <img src="{{ asset('Assets/images/user-profile-images/'.auth()->user()->profile_image_name)  }}" class="img-circle elevation-3" alt="User Image">
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
            <a href=" {{ url('/'.auth()->user()->unique_id) }} " class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          <!-- Account Details -->
          <li class="nav-item ">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-user"></i>
              <p>
                Profile
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ url( '/'.auth()->user()->unique_id.'/general-settings') }}" class="nav-link active">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Generals</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ url( '/'.auth()->user()->unique_id.'/tags') }}" class="nav-link active">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Tags</p>
                </a>
              </li>
              
              <li class="nav-item">
                <a href="{{ url( '/'.auth()->user()->unique_id.'/change-password') }}" class="nav-link active">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Change Password</p>
                </a>
              </li>
            </ul>
          </li>
          <!-- membership -->
          <li class="nav-item ">
            <a href="#" class="nav-link active">
              <i class="fab fa-google-play nav-icon"></i>
              <p>
                Membership
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
            
              @if(isset(auth()->user()->membership_id) || !empty(auth()->user()->membership_id))
              <li class="nav-item">
                <a href="{{ url( '/'.auth()->user()->unique_id.'/membership-details') }}" class="nav-link active">
                  <i class="far fa-circle nav-icon"></i>
                  <p>membership details</p>
                </a>
              </li>
              @else
              <li class="nav-item">
                <a href="{{ url( '/'.auth()->user()->unique_id.'/membership') }}" class="nav-link active">
                  <i class="far fa-circle nav-icon"></i>
                  <p>get membership</p>
                </a>
              </li>
              @endif
              
            </ul>
          </li>
          <!-- a,hdfkjakjdsfiad -->
          <!-- Register Account -->
          <li class="nav-item ">
            <a href="#" class="nav-link active">
            <i class="fas fa-file-invoice-dollar nav-icon"></i>
              <p>
                Register Your Account
              </p> 
              <i class="right fas fa-angle-left"></i>
            </a>@php
                $stripe_account = App\Models\HostStripeAccount::where('host_id',Auth()->user()->id)->first();
                @endphp
              <ul class="nav nav-treeview">
               @if(empty($stripe_account))
                <li class="nav-item">
                  <a href="{{ url( '/'.auth()->user()->unique_id.'/register-account') }}" class="nav-link active">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Register</p>
                  </a>
                </li>
                @else
                <li class="nav-item">
                  <a href="{{ url( '/'.auth()->user()->unique_id.'/edit-account') }}" class="nav-link active">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Account Details</p>
                  </a>
                </li>
                @endif
              </ul>
          </li> 
          <!-- Register Account End -->
          
          <!-- Questionary -->
          <li class="nav-item ">
              <a href="" class="nav-link active">
                <i class="nav-icon fas fa-question-circle"></i>
                <p>
                Guest Questions
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{ url( '/'.auth()->user()->unique_id.'/questionnaire') }}" class="nav-link active">
                    <i class="far fa-circle nav-icon"></i>
                    <p>List</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{ url( '/'.auth()->user()->unique_id.'/addquestionnaire') }}" class="nav-link active">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Add-Question</p>
                  </a>
                </li>
              </ul>
          </li>

          <!-- ajdfkljahsdfklhakdf -->
          <!-- calendar -->
          <li class="nav-item ">
            <a href="{{ url('/'.auth()->user()->unique_id.'/calendar') }}" class="nav-link active">
              <i class="nav-icon fas fa-calendar"></i>
              <p>
                Calendar
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
          </li>
          
          <li class="nav-item ">
            <a href="{{ url('/'.auth()->user()->unique_id.'/appointments') }}" class="nav-link active">
            <i class="far fa-calendar-check nav-icon"></i>
              <p>
                Appointments
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
          </li>
        <!-- discount -->
        <li class="nav-item ">
            <a href="#" class="nav-link active">
            <i class="fas fa-file-invoice-dollar nav-icon"></i>
              <p>
                Discount-Coupon
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ url( '/'.auth()->user()->unique_id.'/coupons') }}" class="nav-link active">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Coupon-list</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ url( '/'.auth()->user()->unique_id.'/coupons/create') }}" class="nav-link active">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Create-Coupon</p>
                </a>
              </li>
              
            </ul>
          </li>

          <!-- payments -->
          <li class="nav-item ">
            <a href="{{ url('/'.auth()->user()->unique_id.'/payment-methods') }}" class="nav-link active">
            <i class="fas fa-file-invoice-dollar nav-icon"></i>
              <p>
              Payment Methods
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
           
          </li>
          <li class="nav-item ">
            <a href="{{ url('/'.auth()->user()->unique_id.'/stream-payments') }}" class="nav-link active">
            <i class="fas fa-file-invoice-dollar nav-icon"></i>
              <p>
              Stream Payments
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
          </li>
          <!-- payment method end -->
          <li class="nav-item ">
            <a href="#" class="nav-link active">
            <i class="fas fa-file-invoice-dollar nav-icon"></i>
              <p>
                Meeting-Charges
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ url( '/'.auth()->user()->unique_id.'/meeting-charges') }}" class="nav-link active">
                  <i class="far fa-circle nav-icon"></i>
                  <p>List</p>
                </a>
              </li>
            </ul>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ url( '/'.auth()->user()->unique_id.'/meeting-charges/add') }}" class="nav-link active">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Add-Charges</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item ">
            <a href="{{ url('/'.auth()->user()->unique_id.'/message/') }}" class="nav-link active">
            <i class="fas fa-comment-alt nav-icon"></i>
              <p>
                Message
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
          </li>
          <!-- Users -->
          <!-- <li class="nav-item ">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Users
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="./index.html" class="nav-link active">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Guest</p>
                </a>
              </li>
            </ul>
          </li> -->
          <!-- Appointments -->
          <!-- <li class="nav-item ">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Schedule Meetings
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="./index.html" class="nav-link active">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Calendar</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./index.html" class="nav-link active">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Guest</p>
                </a>
              </li>
            </ul>
          </li> -->
          
          <!-- Discount Code -->
          <!-- <li class="nav-item ">
            <a href="index.html" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Discount Coupon
              </p>
            </a>
          </li> -->
          <!-- Total sales -->
          <!-- <li class="nav-item ">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Total Sales
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="./index.html" class="nav-link active">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Daily</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./index.html" class="nav-link active">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Weekly</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="./index.html" class="nav-link active">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Monthly</p>
                </a>
              </li>
            </ul>
          </li> -->
          <!-- payments -->
          <!-- <li class="nav-item ">
            <a href="index.html" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Payments
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
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    @yield('content')
  </div>
  <!-- End Content -->
  <footer class="main-footer">
    <strong>Copyright &copy; 2023 <a href="{{ URL::to('/') }}">StreamLode</a>.</strong>
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
<script src="{{ url('public/AdminLTE-3.2.0/plugins/jquery/jquery.min.js') }}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{ url('public/AdminLTE-3.2.0/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{ url('public/AdminLTE-3.2.0/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- ChartJS -->
<script src="{{ url('public/AdminLTE-3.2.0/plugins/chart.js/Chart.min.js') }}"></script>
<!-- Sparkline -->
<script src="{{ url('public/AdminLTE-3.2.0/plugins/sparklines/sparkline.js') }}"></script>
<!-- JQVMap -->
<script src="{{ url('public/AdminLTE-3.2.0/plugins/jqvmap/jquery.vmap.min.js') }}"></script>
<script src="{{ url('public/AdminLTE-3.2.0/plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
<!-- jQuery Knob Chart -->
<script src="{{ url('public/AdminLTE-3.2.0/plugins/jquery-knob/jquery.knob.min.js') }}"></script>
<!-- daterangepicker -->
<script src="{{ url('public/AdminLTE-3.2.0/plugins/moment/moment.min.js') }}"></script>
<script src="{{ url('public/AdminLTE-3.2.0/plugins/daterangepicker/daterangepicker.js') }}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{ url('public/AdminLTE-3.2.0/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<!-- Summernote -->
<script src="{{ url('public/AdminLTE-3.2.0/plugins/summernote/summernote-bs4.min.js') }}"></script>
<!-- overlayScrollbars -->
<script src="{{ url('public/AdminLTE-3.2.0/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ url('public/AdminLTE-3.2.0/dist/js/adminlte.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ url('public/AdminLTE-3.2.0/dist/js/demo.js') }}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{ url('public/AdminLTE-3.2.0/dist/js/pages/dashboard.js') }}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.js"></script>

<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script> -->

<link rel="stylesheet" type="text/css"  href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

<!-- Twilio Llibraries -->

<script src="//media.twiliocdn.com/sdk/js/common/v0.1/twilio-common.min.js"></script>
<script src="//sdk.twilio.com/js/video/releases/2.26.2/twilio-video.min.js"></script>
<!-- <script src="//media.twiliocdn.com/sdk/js/video/releases/1.14.0/twilio-video.js"></script> -->
<!-- ////////////////////////////////////////////////////////////////////////////////// -->
<!-- <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script> -->
<!-- ////////////////////////////////////////////////////////////////////////////////// -->

<!-- <script src="{{ asset('twilio-assets/quickstart.js') }}"></script> -->
<!-- <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script> -->
<!-- <script src="{{ asset('twilio-assets/quickstart.js') }}"></script> -->


<!-- Twilio ends -->
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
