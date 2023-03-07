@extends('host_layout.master')
@section('content')
<script src="//sdk.twilio.com/js/video/releases/2.17.1/twilio-video.min.js"></script>

<div id="join_metting">click me for join</div>
<script>
    // RMafe482d7a17ec6f6bd4d7e29cbe56b46
    $(document).ready(function(){
       const Video =  Twilio.Video;
       console.log(Video);
        $("#join_metting").on('click',function(){
           
                  
                const isSupported = Twilio.Video.isSupported;

                if (isSupported) {
                    const token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiIsImN0eSI6InR3aWxpby1mcGE7dj0xIn0.eyJqdGkiOiJqb1ROOXlvdjZFY2I0RkY3ajJXZFJxQ2RiOW96UjhkVy0xNjc4MTk0ODc4IiwiaXNzIjoiam9UTjl5b3Y2RWNiNEZGN2oyV2RScUNkYjlvelI4ZFciLCJzdWIiOiJBQzMyMmE2NWMxZmYyZWFlNTc3YjBkMDlhODExZDZkZDdkIiwiZXhwIjoxNjc4MTk4NDc4LCJncmFudHMiOnsiaWRlbnRpdHkiOiJhYmhpIiwidmlkZW8iOnsicm9vbSI6Im5ldy1jaGF0NDMxIn19fQ.cFIf5JiEs-TtbcaeJKanngzpNWhc2i3PmHGXlOFa0Cw';
                     const  room = 'new-chat431';
                    const connect  = Twilio.Video;
                    connect.connect(token, { name: 'abhi' }).then(room => {
                        console.log(`Successfully joined a Room: ${room}`);
                        // room.on('participantConnected', participant => {
                        //     console.log(`A remote Participant connected: ${participant}`);
                        // });
                        }, error => {
                        console.error(`Unable to connect to Room: ${error.message}`);
                    });
         
                } else {
                console.error('This browser is not supported by twilio-video.js.');
                }

                // const videoRoom = Video.connect(token, {
                //     name: 'new-chat431',
                //     identity : 'abhi'
                // });
                // console.log('response-> '.videoRoom);
        });
    });
    

</script>
@endsection