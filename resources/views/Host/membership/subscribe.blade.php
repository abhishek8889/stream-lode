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
    <title>Streamlode|Purchase membership</title>
  </head>
  
<style>
 .sub-wrapper {
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 1px solid #a9a9a975;
    padding-bottom: 10px;
}

.disc-wrapper {
    width: 100%;
    max-width: 300px;
    margin-left: auto;
}
.button-wrapper {
    margin-top: 40px;
}
.sub-text h6 {
    margin: 0px;
}
.coupon-code {
    width: 100%;
    padding: 3px 14px;
    border-radius: 20px;
    border: 1px solid #f7941e8c;
    background: #a9a9a914;
    display: none;
}

.coupon {
    padding: 20px 0px;
}

.lab {
    display: inline-block;
    margin-bottom: 10px;
    color: #f7941e;
    font-weight: bold;
}
</style>
<body>
<section class="choose-plan-section">
  <div class="plans-section">
    <div class="container-fluid">
      <div class="dark-banner dark checkout-banner">
        <div class="container-fluid">
          <div class="dark-banner-content">
            <h1>Checkout / <a href="{{url('/'.auth()->user()->unique_id)}}">Dashboard</a></h1>

            <div class="plan-choosen">
              @if(isset($subscription_details['name']) && !empty($subscription_details['name']))
              <h2>{{ $subscription_details['name'] }}</h2>
              @endif
              <div class="price">${{ number_format($subscription_details['amount'],2) }}<span class="period">/ {{ $subscription_details['interval'] }}</span></div>
            </div>
          </div>
        </div>
      </div>
      <section class="ms-form-section">
        <div class="container">
          <div class="form-wrapper">
            <div class="container">
            <form id="payment-form" action="{{ url('create-subscription') }}" method="POST">
              <div class="step_form1">
                <div class="form-box slide-1">
                  <div class="charity-content">
                    <div class="anti-form">
                        @csrf
                      <!-- 2nd slide starts -->
                      <!-- <input type="hidden" id="payment_method" name="payment_method" value=""/> -->
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
                              <input type="hidden" name="membership_id" value="{{ $subscription_details['_id'] }}">
                              <div class="form-part">
                                  <div class="form-group radio-grioup">
                                      <label>Way to pay</label>
                                      @if(!empty($users_payment_methods))
                                        @foreach($users_payment_methods as $user_payment_method)
                                        <label class="payemnt-radio">
                                            <span class="image-text">
                                                <img src="{{ asset('/streamlode-front-assets/images/cards.png') }}" /> {{ $user_payment_method['brand'].' ends in '.$user_payment_method['last_4']  }}
                                            </span>
                                            <input type="radio" class="paywith" name="payent_method" value="{{ $user_payment_method['_id'] }}" />
                                            <span class="checkmark"></span>
                                        </label>
                                        @endforeach
                                      @endif
                                      <label class="payemnt-radio">
                                          <span class="image-text">
                                          <img src="{{ asset('/streamlode-front-assets/images/cards.png') }}" /> Payment with new Card
                                          </span>
                                          <input type="radio" name="payent_method" class="paywith" paywith="card" value="new_payment_method">
                                          <span class="checkmark"></span>
                                      </label>
                                  </div>
                                  <!-- card detail -->
                                  <div id="card-form-wrapper"  style="display:none;">
                                      <div class="card-detail payment-option" id="card">
                                      <div class="form-group">
                                          <label for="cardnumber">Card Details</label>
                                          <div id="card-elements"></div>
                                          <div class="text text-danger mt-2" id="card-error-message"></div>
                                      </div>
                                      </div>
                                  </div>
                                  <!-- ###################### Price details ##########################  -->
                                  <div class="disc-wrapper">
                                  <div class="sub-wrapper">
                                      <div class="sub-text">
                                      <h6>Subtotal</h6>
                                      </div>
                                      <div class="sub-amt" subtotal="{{ number_format($subscription_details['amount'],2) }}">
                                      ${{ number_format($subscription_details['amount'],2) }}
                                      </div>
                                  </div>
                                  <div class="coupon">
                                      <a class="lab" href="javascript:void(0)">Apply coupon</a>
                                      <input type="text" class="coupon-code" id="coup-code" name="coupon_code"/>
                                      <div id="discount_error" class="text text-danger"></div>
                                  </div>
                                  <div class="sub-wrapper" id="discount_coloumn"></div>
                                  <div class="sub-wrapper">
                                      <div class="sub-text">
                                      <h6>Total</h6>
                                      </div>
                                      <div class="sub-amt" id="total-amt">
                                      ${{ number_format($subscription_details['amount'],2) }}
                                      </div>
                                  </div>
                                  </div>
                                  <div class="paypal-payment payment-option" id="card-pay-btn">
                                  <div class="button-wrapper">
                                      <button type="submit" class="btn btn-main pay-with-btn" id="card-button" data-secret="{{ $intent->client_secret }}">Pay Now</button>
                                      <button type="submit" class="btn btn-main" id="default-payment-btn">Pay Now</button>
                                  </div>
                                  </div>
                              </div>
                          </div>
                          </div>
                      </div>
              </div>
              </form>
            </div>
          </div>
      </section>
      </div>
  </div>
</section>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"/>
  <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script> -->
  <script src="{{ asset('streamlode-front-assets/js/custom.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
  <script src="https://js.stripe.com/v3/"></script>
  <script>
    $(document).ready(function(){
      $("#card-button").hide();
      $("#default-payment-btn").hide();
      $(".paywith").on('click',function(){
        if($(this).val() == 'new_payment_method'){
          $("#payment_method").val('new_payment_method');
          $("#card-form-wrapper").show();
          $("#card-button").show();
          $("#default-payment-btn").hide();
        }else{
          $("#payment_method").val('default_payment_method');
          $("#card-form-wrapper").hide();
          $("#card-button").hide();
          $("#default-payment-btn").show();
        }
      });
    });
  </script>
  <script>
    const inputBox = document.getElementById("stram-lode-page-name");
    inputBox.addEventListener("keyup", function() {
      let inputValue = this.value.toLowerCase().replace(/\s+/g, "-").replace(/-+/g, "-");
      this.value = inputValue;
    });
    $("#stram-lode-page-name").change(function () {
    let inputValue = $(this).val();
    if (inputValue.endsWith("-")) {
        inputValue = inputValue.slice(0, -1);
      }
    $('#stram-lode-page-name').val(inputValue);
    });
  </script>
  <!--  Unique Id Script end -->
  <script>
    const stripe = Stripe('{{ env('STRIPE_PUB_KEY') }}');
    // console.log(stripe);
    const elements= stripe.elements();
    const cardElement= elements.create('card');
    cardElement.mount('#card-elements');
    const cardBtn = document.getElementById('card-button');


    const form = document.getElementById('payment-form');
    cardBtn.addEventListener('click',function(){
      form.addEventListener('submit', async (e) => {
      
      const cardBtn = document.getElementById('card-button');
      const first_name = $('#first_name').val();
      const last_name = document.getElementById('last_name');

      const cardHolderName = first_name + ' ' + last_name; 
          e.preventDefault()
      
          // cardBtn.disabled = true
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
              if(error.message != ''){
                $("#card-error-message").html(error.message);
              }
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
    // ajax 
    $("#coup-code").on('keyup',function(){
      let coupon_code = $(this).val();
      let subtotal = $(".sub-amt").attr("subtotal");
      if(coupon_code != ''){
        $.ajax({
          url: "{{ url('coupon-for-host') }}",
          data: {subtotal,coupon_code},
          type: "GET",
          success: function (response) {
            // console.log(response);
              if(response.error){
                  $("#discount_error").show();
                  $("#discount_error").html(response.error);
                  $("#discount_coloumn").hide();
              }else{
                  $("#discount_error").hide();
                  $("#discount_coloumn").show();
                  $("#discount_coloumn").html('<div class="sub-text"><h6>Discount</h6></div><div class="sub-amt">$'+ response.appllied_discount.toFixed(2) +'</div>');
                  $("#total-amt").html('$'+response.total.toFixed(2));
              }
          }
        });
      }
    });
  </script>
</body>
</html>