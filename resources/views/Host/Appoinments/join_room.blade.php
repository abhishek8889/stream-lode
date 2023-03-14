@extends('host_layout.master')
@section('content')
<!-- <script src="//sdk.twilio.com/js/video/releases/2.17.1/twilio-video.min.js"></script> -->
<!-- <script src="https://media.twiliocdn.com/sdk/js/video/v1/twilio-video.min.js"></script> -->

<div id="join_metting">click me to join</div>
<script src="//media.twiliocdn.com/sdk/js/video/v1/twilio-video.min.js"></script>
<script>

    $(document).ready(function(){
    
        $("#join_metting").on('click',function(){  
            const socket = new WebSocket('wss://endpoint.twilio.com/');
            const accessToken = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiIsImN0eSI6InR3aWxpby1mcGE7dj0xIn0.eyJqdGkiOiJTSzA3ZmViYzE2OTk3Y2Q4NjFhNjBiZTJiMDE5MzI3ZGFlLTE2NzgzNjA5NDYiLCJpc3MiOiJTSzA3ZmViYzE2OTk3Y2Q4NjFhNjBiZTJiMDE5MzI3ZGFlIiwic3ViIjoiQUMzMjJhNjVjMWZmMmVhZTU3N2IwZDA5YTgxMWQ2ZGQ3ZCIsImV4cCI6MTY3ODM2NDU0NiwiZ3JhbnRzIjp7ImlkZW50aXR5IjoiYWJoaXNoZWsiLCJ2aWRlbyI6eyJyb29tIjoicm9vbV9hYmhpNyJ9fX0.KG3L86KUO7CQ3P02RffOWmuP0IamDpvwtOw-gmgVZ9w';
            const roomName  = 'room_abhi7';
            
            Twilio.Video.connect( accessToken, {
                name: roomName,
                // tracks: localTracks,
                // video: { width: 300 }
            }).then(function(room) {
            console.log('Successfully joined a Room: ', room.name);
            });

        });
            // Twilio.Video.createLocalTracks({
            // audio: true,
            // video: { width: 300 }
            // }).then(function(localTracks) {
            // return Twilio.Video.connect( accessToken, {
            //     name: roomName,
            //     tracks: localTracks,
            //     video: { width: 300 }
            // });
            // }).then(function(room) {
            // console.log('Successfully joined a Room: ', room.name);

            // room.participants.forEach(participantConnected);

            // var previewContainer = document.getElementById(room.localParticipant.sid);
            // if (!previewContainer || !previewContainer.querySelector('video')) {
            //     participantConnected(room.localParticipant);
            // }

            // room.on('participantConnected', function(participant) {
            //     console.log("Joining: '"   participant.identity   "'");
            //     participantConnected(participant);
            // });

            // room.on('participantDisconnected', function(participant) {
            //     console.log("Disconnected: '"   participant.identity   "'");
            //     participantDisconnected(participant);
            // });
            // }).error(function(error){
            //     console.log('unable to connect' + error);
            // });

        

        
        // function participantConnected(participant) {
        //     console.log('Participant "%s" connected', participant.identity);

        //     const div = document.createElement('div');
        //     div.id = participant.sid;
        //     div.setAttribute("style", "float: left; margin: 10px;");
        //     div.innerHTML = "<div style='clear:both'>" participant.identity "</div>";

        //     participant.tracks.forEach(function(track) {
        //         trackAdded(div, track)
        //     });

        //     participant.on('trackAdded', function(track) {
        //         trackAdded(div, track)
        //     });
        //     participant.on('trackRemoved', trackRemoved);

        //     document.getElementById('media-div').appendChild(div);
        // }

        // function participantDisconnected(participant) {
        //     console.log('Participant "%s" disconnected', participant.identity);

        //     participant.tracks.forEach(trackRemoved);
        //     document.getElementById(participant.sid).remove();
        // }

        // function trackAdded(div, track) {
        //     div.appendChild(track.attach());
        //     var video = div.getElementsByTagName("video")[0];
        //     if (video) {
        //         video.setAttribute("style", "max-width:300px;");
        //     }
        // }

        // function trackRemoved(track) {
        //     track.detach().forEach( function(element) { element.remove() });
        // }

    });


</script>
<div class="content">
    <div class="title m-b-md">
        Video Chat Rooms
    </div>

    <div id="media-div">
    </div>
</div>

@endsection