@extends('guest_layout.master')
@section('content')
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
      <form id="payment-form" action="{{ url('registerProc') }}" method="POST">
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
                
                  @csrf
                  <div class="form-part">
                    <div class="form-group">
                      <label for="first_name">First Name</label>
                      <input class="form-control" type="text" id="first_name" name="first_name">
                      @error('first_name')
                        <div class="text text-danger">{{ $message }}</div>
                      @enderror
                    </div>
                    <div class="form-group">
                      <label for="last_name">Last Name</label>
                      <input class="form-control" type="text" id="last_name" name="last_name">
                      @error('last_name')
                        <div class="text text-danger">{{ $message }}</div>
                      @enderror
                    </div>
                    <div class="form-group">
                      <label for="email">Email Address</label>
                      <input class="form-control" type="text" id="email" name="email">
                      @error('email')
                        <div class="text text-danger">{{ $message }}</div>
                      @enderror
                    </div>
                    <div class="form-group">
                      <label for="stram-lode-page-name">Stream Lode page name</label>
                      <input class="form-control" type="text" id="stram-lode-page-name" name="unique_id">
                      @error('unique_id')
                        <div class="text text-danger">{{ $message }}</div>
                      @enderror
                    </div>
                    <div class="form-group">
                      <label for="password">Password</label>
                      <input class="form-control" type="Password" id="password" name="password">
                      @error('password')
                        <div class="text text-danger">{{ $message }}</div>
                      @enderror
                    </div>
                    <div class="button-wrapper">
                      <button type="button" class="btn-main" id="firstStep">Continue</button>
                    </div>
                  </div>
                <!-- </form> -->
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
                
                <input type="hidden" name="membership_id" value="{{ $subscription_details['_id'] }}">

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
                      <label class="payemnt-radio">
                        <span class="image-text">
                          <img src="{{ asset('/streamlode-front-assets/images/paypal.png') }}" /> PayPal
                        </span>
                        <input type="radio" name="payent_method" class="paywith" paywith="paypal">
                        <span class="checkmark"></span>
                      </label>
                    </div>
                    <!-- card detail -->
                    <div class="card-detail payment-option" id="card">
                      <div class="form-group">
                        <label for="cardnumber">Card Details</label>
                        <div id="card-elements"></div>
                        <div class="text text-danger mt-2" id="card-error-message"></div>
                      </div>
                    
                      <!-- <div class="button-wrapper">
                        <button type="submit" class="btn btn-primary" id="card-button" data-secret="{{ $intent->client_secret }}">Pay Now</button>
                      </div> -->
                    </div>
                    <!-- ###################### Price details ##########################  -->
                    <div class="disc-wrapper">
                      <div class="sub-wrapper">
                        <div class="sub-text">
                          <h6>Subtotal</h6>
                        </div>
                        <div class="sub-amt" subtotal="{{ $subscription_details['amount'] }}">
                          ${{ $subscription_details['amount'] }}
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
                          ${{ $subscription_details['amount'] }}
                        </div>
                      </div>
                    </div>

                    <div class="paypal-payment payment-option" id="card-pay-btn">
                      <div class="button-wrapper">
                        <button type="submit" class="btn-main pay-with-btn" id="card-button" data-secret="{{ $intent->client_secret }}">Pay Now</button>
                      </div>
                    </div>

                    <div class="paypal-payment payment-option" id="paypal">
                      <div class="button-wrapper">
                        <button type="button" class="btn-main pay-with-btn" id="paypalStep">Pay with paypal</button>
                      </div>
                    </div>

                  </div>
                
              </div>
            </div>
          </div>
          <!-- slide 3  -->
        </div>
        </form>
      </div>
    </div>
</section>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
<script src="https://js.stripe.com/v3/"></script>
<!-- New script add for change unique Id  -->
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

    const form = document.getElementById('payment-form');

    form.addEventListener('submit', async (e) => {
		
    const cardBtn = document.getElementById('card-button');
    const first_name = $('#first_name').val();
    const last_name = document.getElementById('last_name');

    const cardHolderName = first_name + ' ' + last_name; 
        e.preventDefault()
		
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
@endsection