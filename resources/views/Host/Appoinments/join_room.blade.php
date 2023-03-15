@extends('host_layout.master')
@section('content')
<!-- <script src="https://media.twiliocdn.com/sdk/js/video/releases/1.0.0-beta5/twilio-video.min.js"></script> -->
<script src="https://media.twiliocdn.com/sdk/js/video/v1/twilio-video.min.js"></script>
<!-- <script src="https://media.twiliocdn.com/sdk/js/video/releases/2.17.0/twilio-video.min.js"></script> -->



<div id="join_metting">click me to join</div>
<!-- <script src="//media.twiliocdn.com/sdk/js/client/v1.15/twilio.min.js"></script> -->
<script>

    $(document).ready(function(){
        
        $("#join_metting").on('click',function(){  
            const Video = Twilio.Video;
            const token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiIsImN0eSI6InR3aWxpby1mcGE7dj0xIn0.eyJqdGkiOiJTSzA3ZmViYzE2OTk3Y2Q4NjFhNjBiZTJiMDE5MzI3ZGFlLTE2Nzg4ODcxMjUiLCJpc3MiOiJTSzA3ZmViYzE2OTk3Y2Q4NjFhNjBiZTJiMDE5MzI3ZGFlIiwic3ViIjoiQUMzMjJhNjVjMWZmMmVhZTU3N2IwZDA5YTgxMWQ2ZGQ3ZCIsImV4cCI6MTY3ODg5MDcyNSwiZ3JhbnRzIjp7ImlkZW50aXR5Ijoiam9obnlfaG9zdCIsInZpZGVvIjp7InJvb20iOiJhYmhpX3Jvb21fNiJ9fX0.DbSha6Yrkru2-xbMhh6_PspE0vINBujF6hUYAT0LZRQ';
            const room_name = 'abhi_room_6';

            // const videoClient = Twilio.Video.Client(token);

            // Join the room

            var socket = new WebSocket("wss://endpoint.twilio.com/");
            socket.onopen = function(event) {
                console.log("Connection established");
            }
            socket.onerror = function(evt) {
                console.log(evt.data);
            };
            // Video.connect(token, { name: room_name }).then(room => {
            //     console.log('Connected to Room "%s"', room.name);
            // },function(error) {
            //     console.error('Unable to connect to Room:', error.message);
            // });

            // const room =  Video.connect({
            //     to: room_name,
            //     audio: true,
            //     video: true,
            // }).then(function(room) {
            //      console.log('Connected to Room:', room.name);
            // },function(error) {
            //     console.error('Unable to connect to Room:', error.message);
            // });

            // Handle the room events
            // room.on('participantConnected', participant => {
            // console.log(`Participant ${participant.identity} connected`);
            // });

            // room.on('participantDisconnected', participant => {
            // console.log(`Participant ${participant.identity} disconnected`);
            // });

            // room.on('disconnected', () => {
            // console.log('Room disconnected');
            // });

        });
            
    });
</script>


@endsection