@extends('host_layout.master')
@section('content')
<script src="//sdk.twilio.com/js/video/releases/2.17.1/twilio-video.min.js"></script>

<div id="join_metting">click me for join</div>
<script>
    // RMafe482d7a17ec6f6bd4d7e29cbe56b46
    $(document).ready(function(){
        $("#join_metting").on('click',function(){
            const Video = Twilio.Video;
            let token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiIsImN0eSI6InR3aWxpby1mcGE7dj0xIn0.eyJqdGkiOiJTSzgzYWIxNmNhZDc2YjlkNDk2NzE5MTg5ODFhYmY4OTdhLTE2NzgxODQwMTMiLCJpc3MiOiJTSzgzYWIxNmNhZDc2YjlkNDk2NzE5MTg5ODFhYmY4OTdhIiwic3ViIjoiQUMzMjJhNjVjMWZmMmVhZTU3N2IwZDA5YTgxMWQ2ZGQ3ZCIsImV4cCI6MTY3ODE4NzYxMywiZ3JhbnRzIjp7ImlkZW50aXR5IjoiYWJoaXNoZWsiLCJ2aWRlbyI6eyJyb29tIjoibmV3LXJvb20xIn19fQ.LC3KJfKBx9MZbWVo2g2-n4KpIRwS6V6Pmmo4NCD7YLE';
            // const{ connect } = require('twilio-video');
            const{ connect } = Video;
                    connect(token, { name: 'new-room1' }).then(room => {
                    console.log(`Successfully joined a Room: ${room}`);
                    room.on('participantConnected', participant => {
                        console.log(`A remote Participant connected: ${participant}`);
                    });
                    }, error => {
                    console.error(`Unable to connect to Room: ${error.message}`);
                });
        });
    });
    

</script>
@endsection