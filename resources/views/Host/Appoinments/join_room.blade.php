@extends('host_layout.master')
@section('content')
<!-- <script src="https://media.twiliocdn.com/sdk/js/video/releases/1.0.0-beta5/twilio-video.min.js"></script> -->
<script src="https://media.twiliocdn.com/sdk/js/video/v1/twilio-video.min.js"></script>
<!-- <script src="https://media.twiliocdn.com/sdk/js/video/releases/2.17.0/twilio-video.min.js"></script> -->
<!-- <script src="//media.twiliocdn.com/sdk/js/client/v1.15/twilio.min.js"></script> -->


<div class="btn btn-danger" id="join_metting">click me to join</div>

<script>

    $(document).ready(function(){
        $("#join_metting").on('click',function(){  
            const Video = Twilio.Video;
            const token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiIsImN0eSI6InR3aWxpby1mcGE7dj0xIn0.eyJqdGkiOiJTSzA3ZmViYzE2OTk3Y2Q4NjFhNjBiZTJiMDE5MzI3ZGFlLTE2Nzg5NjUzNDkiLCJpc3MiOiJTSzA3ZmViYzE2OTk3Y2Q4NjFhNjBiZTJiMDE5MzI3ZGFlIiwic3ViIjoiQUMzMjJhNjVjMWZmMmVhZTU3N2IwZDA5YTgxMWQ2ZGQ3ZCIsImV4cCI6MTY3ODk2ODk0OSwiZ3JhbnRzIjp7ImlkZW50aXR5Ijoiam9obnlfaG9zdCIsInZpZGVvIjp7InJvb20iOiJuZXdfdGUifX19.rw_ErEo1vpweGZpzEmhvQd-bXrAHxFWgOBqy2CB6ekg';
            const room_name = 'new_te';

            Video.connect(token, { name: room_name }).then(room => {
                console.log('Connected to Room "%s"', room.name);
            },function(error) {
                // console.error('Unable to connect to Room:', error.message);
                console.log(error);
            });
        });  
    });
</script>


@endsection