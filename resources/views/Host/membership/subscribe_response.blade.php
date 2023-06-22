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
    <title>Streamlode|Subscribe response</title>
  </head>
<body>
<section class="choose-plan-section">
    <div class="plans-section">
        <div class="container-fluid">
            <div class="dark-banner dark checkout-banner">
                <div class="container-fluid">
                    <div class="dark-banner-content">
                        <h1>Checkout / <a href="{{ url('/'.auth()->user()->unique_id) }}">Dashboard</a></h1>
                        <?php 
                        // dd(Session::get('membership_id'));
                            $membership_id = '';
                            if(!empty(Session::get('membership_id'))){
                                $membership_id = Session::get('membership_id');
                            }
                            if(!empty($membership_id)){
                                $membership_details = App\Models\MembershipTier::select('name','interval','amount')->where('_id',$membership_id)->first();
                                
                            }
                        ?>
                        <div class="plan-choosen">
                            @if(!empty($membership_details['name']))
                                <h2>{{ $membership_details['name'] }}</h2>
                            @endif
                            @if(!empty($membership_details['amount']) || !empty($membership_details['interval']))
                                <div class="price">${{ number_format($membership_details['amount'],2) }} <span class="period">/ {{ $membership_details['interval'] }} </span></div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <section class="ms-form-section">
                <div class="container">
                    <div class="form-wrapper">
                        <div class="container">
                            <div class="step_form">
                                <div class="form-box slide-3">
                                    <div class="charity-content">
                                        <div class="anti-form">
                                            <ul id="progressbar">
                                                <li class="active"><span class="number"><i class="fa-solid fa-check"></i></span><span class="step-name">Personal Details</span></li>
                                                <li class="active"><span class="number"><i class="fa-solid fa-check"></i></span> <span class="step-name">Payment Details</span> </li>
                                                <li class="active"><span class="number"><i class="fa-solid fa-check"></i></span> <span class="step-name">Finish</span> </li>
                                            </ul>
                                            <div class="form-part">
                                                <div class="thanku-content">
                                                    <img src="{{ asset('/streamlode-front-assets/images/tick-icon.svg') }}">
                                                    @if(!empty(Session::get('paymentStatus'))|| Session::get('paymentStatus') == TRUE)
                                                        <h2>We have just received your payment!</h2>
                                                        @if(!empty(Session::get('response')))
                                                        <p>{{ Session::get('response') }}</p>
                                                        @endif
                                                        <p> We are sending you a response to inform you that your payment has been successful.</p>
                                                    @else
                                                        <h2>You have just registered <span class="d-block">succesfully! </span></h2>
                                                        @if(!empty(Session::get('response')))
                                                        <p>{{ Session::get('response') }}</p>
                                                        @endif
                                                    @endif
                                                    <h4><a href="{{ url('/'.auth()->user()->unique_id) }}">Go to back Dashboard</a></h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> 
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</section>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"/>
<script src="{{ asset('streamlode-front-assets/js/custom.js') }}"></script>
</body>
</html>