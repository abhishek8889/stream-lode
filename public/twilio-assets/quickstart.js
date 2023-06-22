var activeRoom;
var previewTracks;
var audioTracks;
var identity;
var roomName;
var hour = 0;
var minutes = 0;
var seconds = 0;
var timerIntervalId;
function attachTracks(tracks, container) {
 
    container.appendChild(tracks.attach());
 
}

function attachParticipantTracks(participant, container) {
  var tracks = Array.from(participant.tracks.values());
  attachTracks(tracks, container);
}

function detachTracks(track) {  
	console.log('trackcheck'+track);
    track.detach().forEach(function(detachedElement) {
    	console.log('detachelement' + detachedElement);
      detachedElement.remove();
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

// ###############################################  COUNTER START FUNCTION ###############################################
  function counterStart() {
    if (localStorage.getItem('seconds') !== null) {
      seconds = parseInt(localStorage.getItem('seconds'));
      minutes = parseInt(localStorage.getItem('minutes'));
      hour = parseInt(localStorage.getItem('hour'));
    }
    let timer_div = document.getElementById('vedio-timer');
  
    seconds = seconds + 1;
    if (seconds > 59) {
      seconds = 0;
      minutes = minutes + 1;
      if (minutes >= 60) {
        minutes = 0;
        hour = hour + 1;
      }
    }
  
    localStorage.setItem('seconds', seconds);
    localStorage.setItem('minutes', minutes);
    localStorage.setItem('hour', hour);
  
    // Update the HTML content with the current timer values
    timer_div.innerHTML = `<div class="run-time">${hour}:${minutes}:${seconds}</div>`;
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
  
  $.getJSON("https://www.streamlode.com/live-stream-token", function(data) {
    console.log(data);
    identity = data.identity;
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

    // //////////////////////// Bind button to leave room //////////////////////// 
    // document.getElementById('button-leave').onclick = function () {
    //   // log('Leaving room...');
    //   // const remote_media = document.getElementById('remote-media');
    //   counterStop();
    //   alert(activeRoom);
    //   activeRoom.disconnect();
    //   // var parser = document.createElement('a');
    //   // parser.href = window.location.href;
    //   // url = parser.protocol+'//'+parser.host+'/host';
    //   // window.location.href = url;
    // };
    
//======================  New Code for End Call Start ================================================

document.getElementById('button-leave').onclick = function () {
 
  localStorage.clear(); /////////////// Add Local Storage Clear \\\\\\\\\\\\\\\\\\\\\
  let timerInterval;
  Swal.fire({
    title: "You've left the meeting",
    html: 'I will close in <b>50</b> seconds.',
    timer: 50000,
    timerProgressBar: true,
    showConfirmButton: true,
    confirmButtonText: 'Returning to home screen',
    buttonsStyling: false,
    showCancelButton: true,
    cancelButtonColor: '#0000',
    cancelButtonText: 'Rejoin',
    customClass: {
      confirmButton: 'btn btn-info mx-2',
      cancelButton: 'btn btn-warning'
    },
    didOpen: () => {
      const b = Swal.getHtmlContainer().querySelector('b');
      timerInterval = setInterval(() => {
        const seconds = Math.ceil(Swal.getTimerLeft() / 1000);
        b.textContent = seconds;
      }, 100);
    },
    willClose: () => {
      clearInterval(timerInterval);
    },
    showCloseButton: false,
  }).then((result) => {
    if (result.dismiss === Swal.DismissReason.timer || result.isConfirmed) {
      localStorage.clear();
      window.location.replace('/');
    }
    if(result.dismiss === Swal.DismissReason.cancel){
      // Here we right our rejoin code to meating
      localStorage.clear();
      window.location.reload(true);
    }
  });
  counterStop();
  activeRoom.disconnect();
 
};
//======================  New Code for End Call End   ===========================
  });
}

// Successfully connected!
function roomJoined(room) {
  activeRoom = room;
  log("Joined as '" + identity + "'");
  let participantNum = 0;
  const handleConnectedParticipant = (participant) => {
    const participantDiv = document.createElement("div");
    const remote_media = document.getElementById('remote-media');
    let remote_participant;
    var existing_participant = document.getElementById(participant.identity);
    participantNum = parseInt(participantNum) + 1;
    let participantJoined =  participantNum;
    /////////// join message \\\\\\\\\\\
    if(participantJoined == 2 ){ // Here I replace > 1 with ==2  because it makes Time faster
      participantDiv.setAttribute("id", participant.identity);
      participantDiv.setAttribute("class", 'main-screen remote-participant');
      document.querySelector('.vedio-response-text').style.display = "block";
      document.querySelector('.vedio-response-text').innerHTML =' You are succesfully joined with '+participant.identity;
      timerIntervalId = setInterval(counterStart, 1000);  //  Here set timer as timeIntervalId
      // localStorage.setItem("video_call_time", timerIntervalId);      // Comment local storage from here !!!!
      setTimeout(function(){
      document.querySelector('.vedio-response-text').style.display = "none";
        document.querySelector('.vedio-response-text').innerHTML = '';
      },5000);
    }else{
      participantDiv.setAttribute("id", participant.identity);
      participantDiv.setAttribute("class", 'main-screen local-participant');
    }
    remote_media.appendChild(participantDiv);
    participant.tracks.forEach((trackPublication) => {
      handleTrackPublication(trackPublication, participant);
    });
    // listen for any new track publications
    participant.on("trackPublished", handleTrackPublication);
  }; 
      
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
      console.log('displaytack321' + trackPublication.track);
      displayTrack(trackPublication.track);
    }
    // listen for any new subscriptions to this track publication
    trackPublication.on("subscribed", displayTrack);
  };
  handleConnectedParticipant(room.localParticipant);
  room.participants.forEach(handleConnectedParticipant);
  room.on("participantConnected", handleConnectedParticipant); 

  const handleDisconnectedParticipant = (participant) => {
    participant.removeAllListeners();
    const participantDiv = document.getElementById(participant.identity);
    participantDiv.remove();
    // counterStop();        // ################## add a counter to stop the timer ##################
  };
  // handle cleanup when a participant disconnects
  room.on("participantDisconnected", handleDisconnectedParticipant);

  //////////////////////////////////////////// my code end \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
  
  const videoResponse = document.getElementById('video-response');
  const micResponse = document.getElementById('mic-response');

  room.on('trackSubscribed', track => {
    // Get the remote participant's audio track and listen for changes in track state
    if (track.kind === 'audio') {
      track.on('enabled', () => {
        // Display response when the remote participant unmutes
        micResponse.innerHTML = '';
      });
      track.on('disabled', () => {
        // Display response when the remote participant mutes
        micResponse.innerHTML = '<i class="fa-solid fa-microphone-slash"></i>';
      });
    }
    if (track.kind === 'video') {
      track.on('enabled', () => {
        // Display response when the remote participant unmutes
        videoResponse.innerHTML = '';
      });
      track.on('disabled', () => {
        // Display response when the remote participant mutes
        videoResponse.innerHTML = '<i class="fa-solid fa-video-slash"></i>';
      });
    }
  });

  ///////////////////////////////////// Handle remote participant \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\

  // Draw local video, if not already previewing

    var previewContainer = document.getElementById('remote-media');
    if (!previewContainer.querySelector('video')) {
      attachParticipantTracks(room.localParticipant, previewContainer);
    }
   
    room.on('participantDisconnected', function(participant) {
      
      log("Participant '" + participant.identity + "' left the room");
      detachParticipantTracks(participant);
      log("Participant '" + participant.identity + "'Left the room'");
    });

    // When we are disconnected, stop capturing local video
    // Also remove media for all remote participants

    room.on('disconnected', function() {
      handleDisconnectedParticipant(room.localParticipant);
      detachParticipantTracks(room.localParticipant);
      room.participants.forEach(detachParticipantTracks);
      activeRoom = null;
      alert(activeRoom);
      // document.getElementById('button-join').style.display = 'inline';
      // document.getElementById('button-leave').style.display = 'none';
    });
  }
  ///////////////////////////////// Camera functionality for on and off \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\ 

   document.getElementById('button-preview').onclick = function(participant) {
    
    var previewContainer = document.getElementById('remote-media');
    var localpreviewContainer = previewContainer.firstChild;
    var elementClass = this.classList;
    elementClass.toggle("active");

    activeRoom.localParticipant.videoTracks.forEach(track => {
      previewTracks = track.track;
    });
    if (!localpreviewContainer.querySelector('video')) {
        attachTracks(previewTracks,localpreviewContainer);
        this.innerHTML = '<i class="fa-sharp fa-solid fa-video"></i>';
        this.setAttribute('title','Hide your camera');
        previewTracks.enable();
        // handleRemoteParticipant(activeRoom.localParticipant,previewTracks);
    }else{
        previewTracks.disable();
        previewTracks.detach().forEach(function(detachedElement) {
          detachedElement.remove();
        });
        this.innerHTML = '<i class="fa-solid fa-video-slash"></i>';
        this.setAttribute('title','Unhide your camera');
        // handleRemoteParticipant(activeRoom.localParticipant,previewTracks);
    }
  }, function(error) {
    console.error('Unable to access local media', error);
    log('Unable to access Camera and Microphone');
  };

  //////////////////////////////// Camera functionality end ///////////////////////////////////////

  //////////////////////////////// Send payment links  ///////////////////////////////////////

  // document.getElementById('sendPaymentBtn').onclick = function(participant) {
    
  // }

  //////////////////////////////// Send payment links end ///////////////////////////////////////


  //////////////////////////////////// Mic functionality Start ////////////////////////////////////

  document.getElementById('button-mic').onclick = function() {
    var audioContainer = document.getElementById('remote-media');
    var localAudioContainer = audioContainer.firstChild;
    var elementClass = this.classList;
    elementClass.toggle("active");
    activeRoom.localParticipant.audioTracks.forEach(track => {
      audioTracks = track.track;
    });

    if (!localAudioContainer.querySelector('audio')) {
        attachTracks(audioTracks,localAudioContainer);
        this.innerHTML = '<i class="fa-solid fa-microphone"></i>';
        this.setAttribute('title','Mute the call');
        audioTracks.enable();
        console.log('audio is not there' + audioTracks);
        // handleRemoteParticipant(activeRoom.localParticipant,audioTracks);
    }else{
        audioTracks.disable();
        audioTracks.detach().forEach(function(detachedElement) {
          detachedElement.remove();
        });
        this.innerHTML = '<i class="fa-solid fa-microphone-slash"></i>';
        this.setAttribute('title','Unmute the call');
        console.log('audio'+audioTracks);
        // handleRemoteParticipant(activeRoom.localParticipant,audioTracks);
    }
  };

  //////////////////////////////////// Mic functionality End ////////////////////////////////////

 

  /////////////////////////////////////////////////////////////////////////////////////////////

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

