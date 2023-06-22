@extends('guest_layout.master')
@section('content')
<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
<div class="dark-banner dark checkout-banner">
  <div class="container-fluid">
    <div class="dark-banner-content">
      <h1>Checkout</h1>

      <div class="plan-choosen">
        @if(isset($subscription_details['name']) && !empty($subscription_details['name']))
        <h2>{{ $subscription_details['name'] }}</h2>
        @endif
        <div class="price">${{ $subscription_details['amount'] }}<span class="period">/ {{ $subscription_details['interval'] }}</span></div>
      </div>
    </div>
  </div>
</div>

<section class="ms-form-section">
  <div class="container">
    <div class="form-wrapper">
      <div class="container">
        <div class="step_form">
          <div class="form-box slide-1">
            <div class="charity-content">
              <div class="anti-form">
                <ul id="progressbar">
                  <li class="active nobar"><span class="number">01</span><span class="step-name">Personal Details</span></li>
                  <li class=""><span class="number">02</span> <span class="step-name">Payment Details</span> </li>
                  <li class=""><span class="number">03</span> <span class="step-name">Finish</span> </li>
                </ul>
                <div class="form-heading text-center">
                  <h2>Personal Details</h2>
                </div>
                <form id="registerForm" data-action="{{ url('registerProc') }}">
                  @csrf
                  <div class="form-part">
                    <div class="form-group">
                      <label for="fname">First Name</label>
                      <input class="form-control" type="text" id="first_name" name="first_name">
                    </div>
                    <div class="form-group">
                      <label for="lname">Last Name</label>
                      <input class="form-control" type="text" id="last_name" name="last_name">
                    </div>
                    <div class="form-group">
                      <label for="email">Email Address</label>
                      <input class="form-control" type="text" id="email" name="email">
                    </div>
                    <div class="form-group">
                      <label for="stram-lode-page-name">Stream Lode page name</label>
                      <input class="form-control" type="text" id="stram-lode-page-name" name="unique_id">
                    </div>
                    <div class="form-group">
                      <label for="Password">Password</label>
                      <input class="form-control" type="Password" id="password" name="password">
                    </div>
                    <!-- <div class="form-group">
                      <label for="con_Password">Confirm Password</label>
                      <input class="form-control" type="Password" id="confirm_password" name="confirmPassword">
                    </div> -->
                    <!-- <div class="form-group check-group">
                      <input type="checkbox" id="check_reminder">
                      <label for="check_reminder"> Remember Me</label>
                    </div> -->

                    <div class="button-wrapper">
                      <button type="submit" class="btn-main" id="firstStep">Continue</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
          <!-- 2nd slide starts -->
          <div class="form-box slide2">
            <div class="charity-content">
              <div class="anti-form">
                <ul id="progressbar">
                  <li class="active "><span class="number"><i class="fa-solid fa-check"></i></span><span class="step-name">Personal Details</span></li>
                  <li class="active nobar"><span class="number">02</span> <span class="step-name">Payment Details</span> </li>
                  <li class=""><span class="number">03</span> <span class="step-name">Finish</span> </li>
                </ul>
                <div class="form-heading text-center">
                  <h2>Payment Details</h2>
                </div>
                <form id="createSubscriptionForm" action="{{ url('register') }}" method="POST">
                <input type="hidden" name="membership_id" value="{{ $subscription_details['_id'] }}">
                <input type="hidden" name="register_user_data" id="register_user_data" value=""/>
                  <div class="form-part">
                    <div class="form-group radio-grioup">
                      <label>Way to pay</label>
                      <label class="payemnt-radio">
                        <span class="image-text">
                          <img src="{{ asset('/streamlode-front-assets/images/cards.png') }}" /> Payment Card
                        </span>
                        <input type="radio" checked="checked" name="payent_method" class="paywith" paywith="card">
                        <span class="checkmark"></span>
                      </label>
                      <!-- <label class="payemnt-radio">
                        <span class="image-text">
                          <img src="{{ asset('/streamlode-front-assets/images/paypal.png') }}" /> PayPal
                        </span>
                        <input type="radio" name="payent_method" class="paywith" paywith="paypal">
                        <span class="checkmark"></span>
                      </label> -->
                    </div>
                    <!-- card detail -->
                    <div class="card-detail payment-option" id="card">
                      <div class="form-group">
                        <label for="cardnumber">Card Details</label>
                        <div id="card-elements"></div>
                        <!-- <input class="form-control" type="Number" id="cardnumber" name="cardnumber"> -->
                      </div>
                      <!-- <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="cardnumber">Date</label>
                            <input class="form-control" type="text" id="cardate" name="cardate">
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label for="cardnumber">CVC/CVV</label>
                            <input class="form-control" type="number" id="cardcvv" name="cardcvv">
                          </div>
                        </div>
                      </div> -->
                      <!-- Buttons  -->
                      <div class="button-wrapper">
                       
                        <button type="submit" class="btn-main pay-with-btn" id="secondStep" data-secret="{{ $intent->client_secret }}">Pay Now</button>
                      </div>
                    </div>
                    <!--  -->
                    <div class="paypal-payment payment-option" id="paypal">
                      <div class="button-wrapper">
                        <button type="button" class="btn-main pay-with-btn" id="paypalStep">Pay with paypal</button>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
          <!-- slide3 starts here -->
          <div class="form-box slide-3">
            <div class="charity-content">
              <div class="anti-form">
                <ul id="progressbar">
                  <li class="active"><span class="number"><i class="fa-solid fa-check"></i></span><span class="step-name">Personal Details</span></li>
                  <li class="active"><span class="number"><i class="fa-solid fa-check"></i></span> <span class="step-name">Payment Details</span> </li>
                  <li class="active"><span class="number"><i class="fa-solid fa-check"></i></span> <span class="step-name">Finish</span> </li>
                </ul>
                <form id="msform">
                  <div class="form-part">
                    <div class="thanku-content">
                      <img src="{{ asset('/streamlode-front-assets/images/tick-icon.svg') }}">
                      <h2>We have just received your payment!</h2>
                      <p> We are sending you a message to inform you that your payment has been successful.</p>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
        </form>
      </div>
    </div>
</section>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
<script src="https://js.stripe.com/v3/"></script>

<script>
//  const stripe = Stripe('{{ env("STRIPE_PUB_KEY") }}');
//   // console.log(stripe);
//   const elements= stripe.elements();
//   const cardElement= elements.create('card');
//   cardElement.mount('#card-elements');

//   const form = document.getElementById('createSubscriptionForm');
//   const cardBtn = document.getElementById('#secondStep');
//   const cardHolderName = document.getElementById('card-holder-name');

  
</script>
<script>
  $(document).ready(function() {
    const stripe = Stripe('{{ env("STRIPE_PUB_KEY") }}');
    // console.log(stripe);
    const elements= stripe.elements();
    const cardElement= elements.create('card');
    cardElement.mount('#card-elements');

    const cardForm = document.getElementById('createSubscriptionForm');
    const cardBtn = document.getElementById('#secondStep');
    const cardHolderName = document.getElementById('card-holder-name');

    $('.step_form').slick({
      slidesToShow: 1,
      adaptiveHeight: true,
      draggable: false,
      dots: false,
      prevArrow: false,
      nextArrow: false
    });

    $('#firstStep').click(function() {
   
      $("#registerForm").on('submit', function(event){
          event.preventDefault();
          let registerFormData = new FormData(this);
          var url = $(this).attr('data-action');
          let cardDetails = '';
        // go to second page
        $('.step_form').slick('slickGoTo', 1);
        
        $("#createSubscriptionForm").on('submit', function(event){
          event.preventDefault();

            cardBtn.disabled = true
            const { setupIntent, error } = await stripe.confirmCardSetup(
                cardBtn.dataset.secret, {
                    payment_method: {
                        card: cardElement,
                        billing_details: {
                            name: cardHolderName.value
                        }   
                    }
                }
            )
            if(error) {
                cardBtn.disable = false
                // console.log(error);
            } else {
                let token = document.createElement('input')
                token.setAttribute('type', 'hidden')
                token.setAttribute('name', 'token')
                token.setAttribute('value', setupIntent.payment_method)
                form.appendChild(token)
                form.submit();
            }
  });

        });
         
          //   // create-subscription
          
          //   console.log('register_details' + registerFormData + 'card details ' + cardDetails);
          //   $('.step_form').slick('slickGoTo', 2);
          // });
        
        // $.ajax({
        //     url: url,
        //     method: 'POST',
        //     data: new FormData(this),
        //     dataType: 'JSON',
        //     contentType: false,
        //     cache: false,
        //     processData: false,
        //     success:function(data)
        //     {
        //       // let error = data.error.customMessages;
        //     if(data == true){
        //       $('.step_form').slick('slickGoTo', 1);
        //     }
        //     },
        //     error: function(data) {
        //       // console.log(data); here is all error;
        //     }
        // });
    });
      

    });

    
    $('#paypalStep').click(function() {
      $('.step_form').slick('slickGoTo', 2);
    });
   

    $('.step_form').on('afterChange', function(event, slick, currentSlide, nextSlide) {
      if (currentSlide === 1) {
        $('.first-slide').addClass('step_disabled');
      } else {
        $('.first-slide').removeClass('step_disabled');
      }

      if (currentSlide === 2) {
        $('.scond-slide').addClass('step_disabled');
        $('.first-slide').addClass('step_disabled');
      } else {
        $('.scond-slide').removeClass('step_disabled');
      }

      var activeCls = currentSlide + 1;
      $("ul.navlist li").removeClass('active').each(function(index) {
        if (index < activeCls) {
          $(this).addClass('active');
        }
      });
    });
</script>
@endsection