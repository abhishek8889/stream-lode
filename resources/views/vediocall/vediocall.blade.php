<!DOCTYPE html>
<html>
<head>
  <title>LiveStream|Streamlode</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <link rel="stylesheet" href="{{ asset('twilio-assets/site.css') }}">
  
</head>
<body>
  <!-- modal  -->
  
  <!-- modal end -->
  <div id="remote-media"></div>
  <div id="controls">
    <div id="preview">
      <p class="instructions">Hello Beautiful</p>
      <div id="local-media"></div>
      <button id="button-preview">Preview My Camera</button>
    </div>
    <div id="room-controls">
      <p class="instructions">Room Name:</p>
      <input id="room-name" type="text" placeholder="Enter a room name" />
      <button id="button-join">Join Room</button>
      <button id="button-leave">Leave Room</button>
    </div>
    <div id="log"></div>
  </div>

  <div class="modal fade show" id="roomNameModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          ...
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button>
        </div>
      </div>
    </div>
  </div>
  <script src="//media.twiliocdn.com/sdk/js/common/v0.1/twilio-common.min.js"></script>
  <script src="//sdk.twilio.com/js/video/releases/2.26.2/twilio-video.min.js"></script>
  <!-- <script src="//media.twiliocdn.com/sdk/js/video/releases/1.14.0/twilio-video.js"></script> -->
  <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
  <script src="{{ asset('twilio-assets/quickstart.js') }}"></script>
</body>
</html>
