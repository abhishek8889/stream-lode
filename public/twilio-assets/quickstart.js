var activeRoom;
var previewTracks;
var identity;
var roomName;
var hour = 0;
var minutes = 0;
var seconds = 0;
var timerIntervalId;

function attachTracks(tracks, container) {
  tracks.forEach(function(track) {
    container.appendChild(track.attach());
  });
}

function attachParticipantTracks(participant, container) {
  var tracks = Array.from(participant.tracks.values());
  attachTracks(tracks, container);
}

function detachTracks(tracks) {
  tracks.forEach(function(track) {
    track.detach().forEach(function(detachedElement) {
      detachedElement.remove();
    });
  });
}

function detachParticipantTracks(participant) {
  var tracks = Array.from(participant.tracks.values());
  detachTracks(tracks);
}

// Check for WebRTC
if (!navigator.webkitGetUserMedia && !navigator.mozGetUserMedia) {
  alert('WebRTC is not available in your browser.');
}

// counter start function
  // let hour = 0;
  // let minutes = 0;
  // let seconds = 0;
  function counterStart(){
      let timer_div = document.getElementById('vedio-timer');
      seconds = ++seconds;
      if(seconds > 59){
          seconds = 0;
          minutes = minutes + 1;
          if(minutes > 60){
            minutes = 0;
            hour = hour + 1;
          }
      }
      // timer_div.innerHTML = '<div class="run-time">' + hour + ':' + minutes + ':' + seconds + '</div>';
      timer_div.innerHTML = `<div class="run-time"> ${hour}:${minutes}:${seconds}</div>`;
      
  }
  function counterStop(){
    if(timerIntervalId){
      clearInterval(timerIntervalId);
    }
  }

// When we are about to transition away from this page, disconnect
// from the room, if joined.
window.addEventListener('beforeunload', leaveRoomIfJoined);

function startVedioCall(){
  $.getJSON("http://127.0.0.1:8000/live-stream-token", function(data) {
    console.log(data);
    identity = data.identity;
    // roomName = document.getElementById('room-name').value;

    // join room 
    let joinRoom = function() {
      roomName = document.getElementById('room-name').value;
      if (roomName) {
        log("Joining room '" + roomName + "'...");

        var connectOptions = { name: roomName, logLevel: 'debug' };
        if (previewTracks) {
          connectOptions.tracks = previewTracks;
        }
       

        Twilio.Video.connect(data.token, connectOptions).then(roomJoined, function(error) {
          log('Could not connect to Twilio: ' + error.message);
          
          
        });
      } 
    }; 
    joinRoom();

    // Bind button to leave room
    document.getElementById('button-leave').onclick = function () {
      log('Leaving room...');
      activeRoom.disconnect();
      counterStop();
      // var parser = document.createElement('a');
      // parser.href = window.location.href;
      // url = parser.protocol+'//'+parser.host+'/host';
      // window.location.href = url;
    };
  });
}

// Successfully connected!
function roomJoined(room) {
  activeRoom = room;

  log("Joined as '" + identity + "'");
  // my code +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
  let participantNum = 0;
  const handleConnectedParticipant = (participant) => {
      
    // create a div for this participant's tracks
    const participantDiv = document.createElement("div");
    const remote_media = document.getElementById('remote-media');
    participantDiv.setAttribute("id", participant.identity);
    participantDiv.setAttribute("class", 'main-screen');
    
    // let hour_box = document.getElementById("hours"); 
    

    participantNum = parseInt(participantNum) + 1;
    let participantJoined =  participantNum;
    if(participantJoined > 1){
      // join message
      document.querySelector('.vedio-response-text').style.display = "block";
      document.querySelector('.vedio-response-text').innerHTML =' You are succesfully joined with '+participant.identity;
      timerIntervalId = setInterval(counterStart, 1000);  
      setTimeout(function(){
      document.querySelector('.vedio-response-text').style.display = "none";
        document.querySelector('.vedio-response-text').innerHTML = '';
      },5000);
    }
    // var previewContainer = document.getElementById('local-media');
    // if (previewContainer.querySelector('video')) {
    //   detachTracks(tracks, previewContainer);
    // }
    
    remote_media.appendChild(participantDiv);

    // iterate through the participant's published tracks and
    // call `handleTrackPublication` on them
    participant.tracks.forEach((trackPublication) => {
      handleTrackPublication(trackPublication, participant);
    });

    // listen for any new track publications
    participant.on("trackPublished", handleTrackPublication);
  };
  // 

  const handleTrackPublication = (trackPublication, participant) => {
    function displayTrack(track) {
      // append this track to the participant's div and render it on the page
      const participantDiv = document.getElementById(participant.identity);
      // track.attach creates an HTMLVideoElement or HTMLAudioElement
      // (depending on the type of track) and adds the video or audio stream
      participantDiv.append(track.attach());
    }

    // check if the trackPublication contains a `track` attribute. If it does,
    // we are subscribed to this track. If not, we are not subscribed.
    if (trackPublication.track) {
      displayTrack(trackPublication.track);
    }

    // listen for any new subscriptions to this track publication
    trackPublication.on("subscribed", displayTrack);
  };

  handleConnectedParticipant(room.localParticipant);
  room.participants.forEach(handleConnectedParticipant);
  room.on("participantConnected", handleConnectedParticipant);

  // my code en+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

    document.getElementById('button-join').style.display = 'none';
    document.getElementById('button-leave').style.display = 'inline';

    // Draw local video, if not already previewing
    var previewContainer = document.getElementById('local-media');
    if (!previewContainer.querySelector('video')) {
      attachParticipantTracks(room.localParticipant, previewContainer);
    
    }
    // publish track   ///////////////////////////////


  //////////////////////////////////////////
    room.participants.forEach(function(participant) {
      log("Already in Room: '" + participant.identity + "'");
      var previewContainer = document.getElementById('remote-media');
      attachParticipantTracks(participant, previewContainer);
    });

    // When a participant joins, draw their video on screen
    room.on('participantConnected', function(participant) {
      // alert('you are participant');
      log("Joining: '" + participant.identity + "'");
    });

    room.on('trackAdded', function(track, participant) {
      log(participant.identity + " added track: " + track.kind);
      var previewContainer = document.getElementById('remote-media');
      attachTracks([track], previewContainer);
    });

    room.on('trackRemoved', function(track, participant) {
      log(participant.identity + " removed track: " + track.kind);
      detachTracks([track]);
    });

    // When a participant disconnects, note in log
    room.on('participantDisconnected', function(participant) {
      log("Participant '" + participant.identity + "' left the room");
      detachParticipantTracks(participant);
    });

    // When we are disconnected, stop capturing local video
    // Also remove media for all remote participants
    room.on('disconnected', function() {
      log('Left');
      detachParticipantTracks(room.localParticipant);
      room.participants.forEach(detachParticipantTracks);
      activeRoom = null;
      document.getElementById('button-join').style.display = 'inline';
      document.getElementById('button-leave').style.display = 'none';
    });
}

//  Local video preview
document.getElementById('button-preview').onclick = function() {
  console.log('button-preiview clicked');
  // custom function for show camera

  // var localTracksPromise = previewTracks
  
  // ? Promise.resolve(previewTracks)
  // : Twilio.Video.createLocalTracks();

  // localTracksPromise.then(function(tracks) {
  //   previewTracks = tracks;
  //   var previewContainer = document.getElementById('remote-media');
  //   if (!previewContainer.querySelector('video')) {
  //     attachTracks(tracks, previewContainer);
  //   }else{
  //     detachTracks(tracks, previewContainer)
  //   }
  // }, function(error) {
  //   console.error('Unable to access local media', error);
  //   log('Unable to access Camera and Microphone');
  // });
  // room.localParticipant.audioTracks.forEach(trackPublication => {
  //   trackPublication.track.disable();
  // });
  // room.on('trackRemoved', function(track, participant) {
  //   log(participant.identity + " removed track: " + track.kind);
  //   detachTracks([track]);
  // });

};

// Activity log
function log(message) {
  var logDiv = document.getElementById('log');
  // logDiv.innerHTML += '<p>&gt;&nbsp;' + message + '</p>';
  // logDiv.scrollTop = logDiv.scrollHeight;
}

function leaveRoomIfJoined() {
  if (activeRoom) {
    activeRoom.disconnect();
  }
}
