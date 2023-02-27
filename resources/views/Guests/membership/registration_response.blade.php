@extends('guest_layout.master')
@section('content')

<div class="dark-banner dark checkout-banner">
  <div class="container-fluid">
    <div class="dark-banner-content">
      <h1>Checkout</h1>
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
            <div class="price">${{ $membership_details['amount'] }} <span class="period">/ {{ $membership_details['interval'] }} </span></div>
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
          <!-- slide3 starts here -->
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
                            @if(!empty(Session::get('message')))
                            <p>{{ Session::get('message') }}</p>
                            @endif
                            <p> We are sending you a message to inform you that your payment has been successful.</p>
                        @else
                            <h2>You have just registered <span class="d-block">succesfully! </span></h2>
                            @if(!empty(Session::get('message')))
                            <p>{{ Session::get('message') }}</p>
                            @endif
                        @endif
                        <div>
                            <a href="{{ url('login') }}" class="text text-success">Go for login....</a>
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

@endsection