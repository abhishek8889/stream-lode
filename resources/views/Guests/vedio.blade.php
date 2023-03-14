
@extends('guest_layout.master')
@section('content')

    <div id="remote-media"></div>
    <div id="local-media"></div>
    
    <script>
        Twilio.Video.connect("{{ $response['accessToken'] }}", {
            roomName: "{{ $response['roomName'] }}",
            name: "{{ $response['identity'] }}",
            video: { width: 640 }
        }).then(function(room) {
            room.on('participantConnected', function(participant) {
                participant.tracks.forEach(function(track) {
                    document.getElementById('remote-media').appendChild(track.attach());
                });
            });

            var localTracksPromise = Twilio.Video.createLocalTracks();

            localTracksPromise.then(function(localTracks) {
                localTracks.forEach(function(track) {
                    document.getElementById('local-media').appendChild(track.attach());
                    room.localParticipant.publishTrack(track);
                });
                console.log('nothing error');
            }, function(error) {
                console.error('Unable to access local media', error);
            });
        });
    </script>
@endsection