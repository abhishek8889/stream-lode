<!DOCTYPE html>
<html>
<head>
  <title>LiveStream|Streamlode</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <link rel="stylesheet" href="{{ asset('twilio-assets/site.css') }}">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  @vite('resources/js/pingStatus.js')
  <style>

   #couponcode{
     border: 2px solid;
   padding: 6px;
   } 
  table {
    width: 100%;
}

.form-row-table {
    margin: 0px 0px 20px;
}

.form-row-table th {
    text-align: left;
}

.form-row-table td {
    text-align: right;
}

.form-row-table td,.form-row-table th {
    padding: 10px;
}
.payment-option button#card-button {
    width: auto;
    height: auto;
    border-radius: 10px;
    padding: 7px 20px;
}
</style>
</head>

<body>
  <div id="test" style="display:none;"></div>
  @if($roomName)
    <input type="hidden" id="room-name" value="{{ $roomName }}">
  @endif
  @if(isset(auth()->user()->id))
    @if(auth()->user()->id == $appoinment_details['host_id'] || auth()->user()->status == 1)
    <input type="hidden" id="user_type" value="host">
    @else
    <input type="hidden" id="user_type" value="guest">
    @endif
  @else
  <input type="hidden" id="user_type" value="notlogin">
  @endif
  <input type="hidden" id="stream_amount" value="" />
  <div id="controls">
    <div id="preview">
    <div class="vedio-response-text" style="display:none;"></div>
      <div id="vedio-timer"></div>
      <div class="response-wrapper">
        <div id="video-response" class="participantResponse"></div>
        <div id="mic-response" class="participantResponse"></div>
      </div>
      <div id="remote-media"></div>
      <!-- <div id="mute-icon" style="display:none;"><i class="fa-solid fa-microphone-slash"></i></div> -->
      <!-- <div id="local-media"></div> -->
      <div class="vedio-btn-wrapper">
        <button id="button-mic" class="active"><i class="fa-solid fa-microphone"></i></button>
        <button id="button-preview" class="active"><i class="fa-sharp fa-solid fa-video"></i></button>
        <button id="button-message"><i class="fa-regular fa-comment"></i></button>
        <button id="button-leave" class="btn btn-danger done-call" guest-email="{{$appoinment_details['guest_email'] ?? ''}}"><i class="fa-solid fa-phone"></i></button>
        <div id="user_type_div">

          <!-- //////////////////////////// payment modal \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\ -->

            <div class="modal fade bd-example-modal-lg" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="paymentModal" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="guestPaymentModalTitle">Enter you card details</h5>
                   
                    </button>
                  </div>

                  <!-- //////////////////////////// payment modal  body ///////////////////////// -->

                  <div class="modal-body">
                    <form id="payment-form" action="{{ url('videocall-payment') }}" method="POST">
                      @csrf
                        <div class="form-box">
                          <div class="charity-content">
                            <div class="anti-form">
                                <div class="form-part">
                                  <!-- card detail -->
                                  <div class="card-detail payment-option" id="card">
                                    <div class="form-group">
                                      <div id="card-elements"></div>
                                      <div class="text text-danger mt-2" id="card-error-message"></div>
                                    </div>
                                    <div class="form-row-table">
                                     <table>
                                      <tr>
                                        <th>Subtotal</th>
                                        <td>${{ $appoinment_details['meeting_charges']}}</td>
                                      </tr>
                                      <tr>
                                        <th>Meeting duration</th>
                                        <td>{{ $appoinment_details['duration_in_minutes']}} minutes</td>
                                      </tr>
                                      <tr>
                                        <th><button type="button" class="btn btn-info" style="width:165px; border-radius:0px; background-color:rgb(66 106 137);" id="discount-button">Apply Coupon</button> </th>
                                        <td><input type="text" id ="couponcode" host_id = "{{ $appoinment_details['host_id'] }}" amount= "{{ $appoinment_details['meeting_charges'] }}" ><br><span class="text-danger" id="error-response"></span></td>
                                      </tr>
                                      <tr>
                                        <th>Discount amount</th>
                                        <td>-$ <span id="discount-amount" >0</span></td>
                                      </tr>
                                      <tr>
                                        <th>Total</th>
                                        <td>$ <span id="final_amount">{{ $appoinment_details['meeting_charges']}}</span> </td>
                                      </tr>
                                     </table>
                                    </div>
                                  </div>
                                  <input type="hidden" name="appoinment_id" value="{{ $appoinment_details['_id'] }}">
                                  <input type="hidden" name="host_id" value="{{ $appoinment_details['host_id'] }}">
                                  <input type="hidden" name="subtotal" value="{{ $appoinment_details['meeting_charges']}}"/>
                                  <input type="hidden" id="discount_code" name="discount_code" value="">
                                  <input type="hidden" id="discount_price" name="discount_amount" value="">
                                  <input type="hidden" id="payment_amount" name="payment_amount" value="{{ $appoinment_details['meeting_charges']}}">
                                  <input type="hidden" name="currency" value="{{ $appoinment_details['currency'] }}" />
                                  <div class="paypal-payment payment-option" id="card-pay-btn">
                                    <div class="button-wrapper">
                                      <button type="submit" class="btn-main btn btn-primary pay-with-btn" id="card-button" data-secret="{{ $client_secret }}">Pay Now</button>
                                    </div>
                                  </div>
                                </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </form>
                  </div>

                  <!-- //////////////////////////// payment modal  body end ///////////////////////// -->

                  <div class="modal-footer">
                  </div>
                </div>
              </div>
            </div>
          <!-- payment modal end -->
        </div>
        <!-- <div id="sendPaymentBtn" class="btn btn-success" style="display:none;" data-toggle="tooltip" data-placement="top" title="Ask for payment"><i class="fa-solid fa-dollar-sign"></i></div> -->
        <div class="site-logo">
          <img src="{{ asset('streamlode-front-assets/images/logo.png') }}" alt="logo.png">
        </div>
      </div>
    </div>
    <!-- Ask for payment modal -->
      <div class="modal fade" id="askForPayment" tabindex="-1" role="dialog" aria-labelledby="askForPayment" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLongTitle">Ask for payment</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form action="" id="askForPaymentFrm">
                  <label for="amountForStream">Enter amount you required for stream</label>
                  <input type="text" class="form-control mt-2" name="amount_required_for_payment" id="amountForStream" placeholder="Enter amount" />
                  <select name="" class="form-control mt-2" id="currency_code">
                    <option value="usd">US($)</option>
                  </select>
                  <input type="Submit" class="btn btn-primary mt-3" value="Send Request" />
              </form>
            </div>
            <div class="modal-footer">
              
            </div>
          </div>
        </div>
      </div>
    <!-- Ask for payment modal end -->
    <div class="alert-login" value="{{ auth()->user()->_id ?? ''}}"></div>
    <!-- <div id="log"></div> -->
  </div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<style>
.my-actions { margin: 0 2em; }
.order-1 { order: 1; }
.order-2 { order: 2; }
.order-3 { order: 3; }

.right-gap {
margin-right: auto;
}
</style>

<script>
    $(document).ready(function(){
      $('#couponcode').hide();
      $('#discount-button').click(function(){
        $('#couponcode').toggle();
      });
      $('#couponcode').on('keyup',function(){
        let coupon_code = $(this).val();
        let host_id = $(this).attr('host_id');
        let amount = $(this).attr('amount');
       if(coupon_code == ""){
        $('#error-response').html('');
        $('#discount-amount').html(0);
        $('#final_amount').html(amount);
        $('#discount_code').val('');
        $('#discount_price').val('');
        $('#payment_amount').val(amount);
        return false;
       }
        $.ajax({
          method: 'post',
          url: '{{ url('coupon-check') }}',
          dataType: 'json',
          data: {amount:amount,coupon_code:coupon_code ,host_id:host_id, _token: '{{csrf_token()}}'},
          success: function(response){
            // console.log(response);
            if(response.status == true){
            $('#error-response').html('');
              $('#discount-amount').html(response.discount_amount);
              $('#final_amount').html(response.total_amount);
              $('#discount_code').val(response.coupon_code);
              $('#discount_price').val(response.discount_amount);
              $('#payment_amount').val(response.total_amount);
              // console.log(true);
            }
            if(response.status == false){
            $('#error-response').html(response.response);
            $('#discount-amount').html(response.discount_amount);
              $('#final_amount').html(response.total_amount);
              // console.log(false);
            }
          }
        })
      });
    });
  </script>
<script src="https://js.stripe.com/v3/"></script>
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
            startVedioCall();   //Add  start video call fucntion here for start video call after payment submit
        }
    });
</script>

  <script>
    $(document).ready(function(){
      var user_type = $("#user_type").val();
      if(user_type == 'host'){
        Swal.fire({
        title: 'Are you ready for your session ?',
        text : 'Please press yes for join your video session.',
        icon: "info",
        showDenyButton: true,
        showCancelButton: true,
        confirmButtonText: 'Yes',
        denyButtonText: 'No',
        customClass: {
          actions: 'my-actions',
          cancelButton: 'order-1 right-gap',
          confirmButton: 'order-2',
          denyButton: 'order-3',
        }
        }).then((result) => {
          if (result.isConfirmed) {
            // $("#paymentModal").modal('show');
            var user_type = $("#user_type").val();
            
            if(user_type == "host"){
              $("#user_type_div").attr('class','btn btn-success sendPaymentPingBtn');
              $("#user_type_div").attr('data-toggle','tooltip');
              $("#user_type_div").attr('data-placement','top');
              $("#user_type_div").attr('title','Ask for payment');
              $("#user_type_div").attr('type','host_box');
              $("#user_type_div").html("<i class='fa-solid fa-dollar-sign'></i>");
            }else{
              $("#user_type_div").attr('type','guest_box');
              @if($appoinment_details['payment_status'] == 0)
                $("#paymentModal").modal({backdrop: 'static'});
              @endif
            }
            startVedioCall();
          }else if (result.isDenied) {
            window.location.href = "{{ url('/') }}";
          }
        });
      }else if(user_type == "notlogin"){
                  Swal.fire({
            title: 'Warning ?',
            text: "Sorry we did not find you in our system. Please login first",
            icon: 'warning',
            showCancelButton: false,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'OK'
          }).then((result) => {
            if (result.isConfirmed) {
              window.location.replace("/login");
            }
          })
      }else{
        Swal.fire({
        title: 'Are you ready for your session ?',
        @if($appoinment_details['payment_status'] == 1)
        text : 'Please press yes for join your video session.',
        @else
        text : 'Please press yes for payment for your video session.',
        @endif
        icon: "info",
        showDenyButton: true,
        showCancelButton: true,
        confirmButtonText: 'Yes',
        denyButtonText: 'No',
        customClass: {
          actions: 'my-actions',
          cancelButton: 'order-1 right-gap',
          confirmButton: 'order-2',
          denyButton: 'order-3',
        }
        }).then((result) => {
          if (result.isConfirmed) {
            // $("#paymentModal").modal('show');
            var user_type = $("#user_type").val();
            if(user_type == "host"){
              $("#user_type_div").attr('class','btn btn-success sendPaymentPingBtn');
              $("#user_type_div").attr('data-toggle','tooltip');
              $("#user_type_div").attr('data-placement','top');
              $("#user_type_div").attr('title','Ask for payment');
              $("#user_type_div").attr('type','host_box');
              $("#user_type_div").html("<i class='fa-solid fa-dollar-sign'></i>");
            }else{
              $("#user_type_div").attr('type','guest_box');
              @if($appoinment_details['payment_status'] == 0)
                $("#paymentModal").modal({backdrop: 'static'});
              @endif
            }
            @if ($appoinment_details['payment_status'] == 1)
              startVedioCall();         // add start video call function here!
            @endif
            // startVedioCall();        // Comment start cideo call function from here!
          }else if (result.isDenied) {
            window.location.href = "{{ url('/') }}";
          }
        });
      }
    });
    $("#user_type_div").on('click',function(){
      if($(this).attr('type') == 'host_box'){
        $("#askForPayment").modal('show');
      }
      $("#askForPaymentFrm").on('submit',function(e){
        e.preventDefault();
        var amountForStream = $("#amountForStream").val();
        var currency_code = $("#currency_code").val();
        $.ajax({
        url: "{{ url('ping-for-payment') }}",
        data: {
            "_token": "{{ csrf_token() }}",
            'amountForStream': amountForStream,
            'currency' : currency_code,
            'appointment_id': "{{ $appoinment_details['_id'] }}",
            'host_id' : "{{ $appoinment_details['host_id'] }}",
            'message':'please pay for this if you want to continue',
        },
        type: "POST",
        success: function(data) {
            console.log(data);
            $("#askForPayment").modal('hide');
        }
        });
      });
    });


// Leave video call local storage null button
  </script>


<!-- script for save time duration of video call  -->

<script>
  $(document).ready(function() {
    $('.done-call').on('click', function (){
      if($('#user_type').val() == 'guest'){
        total_duration = $('.run-time').html();
        const room_id = $('#room-name').val();
        $.ajax({
          method: 'post',
          url: "{{ url('call_duration') }}", 
          dataType: 'json',
          data: {room_id: room_id, total_duration: total_duration, _token: '{{ csrf_token() }}'},
          success: function(response){
            console.warn(response);
          }
        });
      }
    });
  });
</script>
<!-- End script video call duration -->
 
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js" integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+" crossorigin="anonymous"></script>
  <script src="//media.twiliocdn.com/sdk/js/common/v0.1/twilio-common.min.js"></script>
  <script src="//sdk.twilio.com/js/video/releases/2.26.2/twilio-video.min.js"></script>
  <!-- <script src="//media.twiliocdn.com/sdk/js/video/releases/1.14.0/twilio-video.js"></script>  this is commented --> 
  <!-- <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script> default jquery -->
  <script src="{{ asset('twilio-assets/quickstart.js') }}"></script>
</body>
</html>
