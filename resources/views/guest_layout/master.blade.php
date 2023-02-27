<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css">
    <link rel="stylesheet" href="{{  asset('streamlode-front-assets/css/stylesheet.css') }}">
    <script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>




    <title>Streamlode</title>
  </head>
<body>
<header class="site_header">
  <div class="container-fluid">
    <nav class="navbar navbar-expand-lg navbar-light">
      <a class="navbar-brand" href="{{ url('/') }}"><img src="{{  asset('streamlode-front-assets/images/logo.png') }}" alt="logo"></a>
      

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <a class="nav-link" href="{{ url('membership') }}">Membership</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ url('about-support') }}">About</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ url('search-host') }}">Search Host</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ url('about-support') }}">Support</a>
          </li>
        </ul>
      </div>
      <div class="form-inline my-2 my-lg-0 login button-col">
        @if(isset(auth()->user()->id) || !empty(auth()->user()->id))
          <a href="{{ url('/logout') }}" class="cta cta-yellow"> <i class="fa-regular fa-user"></i> Logout </a>
        @else
        <a href="{{ url('/login') }}" class="cta cta-yellow"> <i class="fa-regular fa-user"></i> Login </a>
        @endif
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="bar bar-1"></span>
          <span class="bar bar-2"></span>
          <span class="bar bar-3"></span>
      </button>
      </div>
    </nav>
  </div>
</header>
<!-- ##################################################################   -->

      <!-- body content -->
      @yield('content')

<!--  ################################################################## -->

<footer class="site_footer">
  <div class="lets-talk">
    <div class="container-fluid">
      <div class="row lets-talk-row align-items-center">
      <div class="col-md-8 text-col">
        <h4>Have a question in mind?
          Let's meet together!</h4>
      </div>
      <div class="col-md-4 button-col">
        <a href="#" class="round-cta">
                <span class="cta__text">Lets Talk</span>
                <svg viewBox="-1 -1 202 102" preserveAspectRatio="none">
                    <ellipse class="ellipse" cx="100" cy="50" rx="100" ry="50" stroke-width="1" stroke="currentColor" fill="none"></ellipse>
                </svg>
            </a>
      </div>
    </div>
    </div>
  </div>
  <div class="footer-menu-section">
    <div class="container-fluid">
      <div class="footer-inner-wrapper">
        <div class="row menu-row">
          <div class="col-md-5 brand-col">
            <a class="navbar-brand" href="index.html"><img src="{{ asset('streamlode-front-assets/images/logo.png') }}" alt="logo"></a>
          </div>
          <div class="col-md-7 menu-col">
            <ul>
              <li><a href="{{ url('/membership') }}" class="footer-link">Membership</a></li>
              <li><a href="{{ url('about-support') }}" class="footer-link">About</a></li>
              <li><a href="{{ url('search-host') }}" class="footer-link">Search Host</a></li>
              <li><a href="{{ url('about-support') }}" class="footer-link">Support</a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="social-address-footer">
    <div class="container-fluid">
      <div class="row">
         <div class="col-md-5 address-col">
           <div class="address-box">
             <p><a href="mailto:info@streamlode.com">info@streamlode.com</a></p>
           <p>621 Bingamon Road Independence, OH 44131</p>
           </div>
         </div>
         <div class="col-md-7 social-col">
           <h4>Follow Us:</h4>
           <ul class="social-list">
             <li><a href="#"> Facebook</a></li>
             <li><a href="#"> Instagram</a></li>
             <li><a href="#"> LinkedIn</a></li>
             <li><a href="#"> Twitter</a></li>
           </ul>
         </div>
      </div>
    </div>
  </div>
  <div class="bottom-footer">
    <div class="container-fluid">
      <div class="row align-items-center">
        <div class="col-md-5 text-col">
          <p class="mb-0">© 2023 StreamLode  |  All Rights Reserved  |  <a href="#">Privacy Policy.</a></p>
        </div>
        <div class="col-md-7 image-col">
          <img src="{{ asset('streamlode-front-assets/images/footer-pattern.png') }}" alt="logo"></a>
        </div>
      </div>
    </div>
  </div>
</footer>


<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script> -->
<script src="{{ asset('streamlode-front-assets/js/custom.js') }}"></script>

</body>
</html>