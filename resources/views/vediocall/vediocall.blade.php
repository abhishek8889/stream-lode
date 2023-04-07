<!DOCTYPE html>
<html>
<head>
  <title>LiveStream|Streamlode</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <link rel="stylesheet" href="{{ asset('twilio-assets/site.css') }}">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  @vite('resources/js/pingStatus.js')
</head>
<body>
  <div id="test" style="display:none;">anjkdfhadjshfk</div>
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
  <input type="hidden" id="user_type" value="guest">
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
        <button id="button-leave" class="btn btn-danger"><i class="fa-solid fa-phone"></i></button>
        <div id="user_type_div">
          <!-- payment modal -->
            <div class="modal fade" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="paymentModal" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="guestPaymentModalTitle"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <div class="text text-success">Please click here for payment.</div>
                    
                  </div>
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
      Swal.fire({
        title: 'Are you ready for your session ?',
        text : 'Please press yes for your payment and get ready for your session !',
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
            
           }
            startVedioCall();
        } else if (result.isDenied) {
            window.location.href = "{{ url('/') }}";
        }
      })
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
    // $(".vedio-response").on('change',function(){
    //   alert($(this).html);
    // });
    // $(document).ready(function(){
    //     var stream_amount = $(this).val();
    //     if(stream_amount != '' || stream_amount != null){
    //       alert(stream_amount);
    //     }
    // });
  </script>
  
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js" integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+" crossorigin="anonymous"></script>
  <script src="//media.twiliocdn.com/sdk/js/common/v0.1/twilio-common.min.js"></script>
  <script src="//sdk.twilio.com/js/video/releases/2.26.2/twilio-video.min.js"></script>
  <!-- <script src="//media.twiliocdn.com/sdk/js/video/releases/1.14.0/twilio-video.js"></script>  this is commented --> 
  <!-- <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script> default jquery -->
  <script src="{{ asset('twilio-assets/quickstart.js') }}"></script>
</body>
</html>
