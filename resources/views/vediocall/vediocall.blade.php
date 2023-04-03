<!DOCTYPE html>
<html>
<head>
  <title>LiveStream|Streamlode</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <link rel="stylesheet" href="{{ asset('twilio-assets/site.css') }}">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>


</head>
<body>
  @if($roomName)
    <input type="hidden" id="room-name" value="{{ $roomName }}">
  @endif
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
        <div class="site-logo">
          <img src="{{ asset('streamlode-front-assets/images/logo.png') }}" alt="logo.png">
        </div>
      </div>
      
    </div>
   
    <div id="log"></div>
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
        text : 'Please press yes for start if you are ready !',
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
          // Swal.fire('Saved!', '', 'success')
            console.log("ready??????");
            startVedioCall();
        } else if (result.isDenied) {
            window.location.href = "{{ url('/') }}";
        }
      })
    });
    $(".vedio-response").on('change',function(){
      alert($(this).html);
    });
    
    
    
  </script>
  <script src="//media.twiliocdn.com/sdk/js/common/v0.1/twilio-common.min.js"></script>
  <script src="//sdk.twilio.com/js/video/releases/2.26.2/twilio-video.min.js"></script>
  <!-- <script src="//media.twiliocdn.com/sdk/js/video/releases/1.14.0/twilio-video.js"></script> -->
  <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
  <script src="{{ asset('twilio-assets/quickstart.js') }}"></script>
</body>
</html>
