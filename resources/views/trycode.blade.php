@extends('guest_layout.master')
@section('content')
<style>
    #stopwatch {
  position:absolute;
  left:50%;
  margin-left:-100px;
  border:2px solid #3399cc;
  -webkit-border-radius:200px;
}
#time{
    text-align:center;
    font-size:80px;
    color:red;
    /* border: 2px solid black; */
    margin-inline: 45%;
    border-radius: 73px;
    height: 134px;
}
</style>
<button class="btn btn-dark" id = "endcall" data-toggle="modal" data-target="#exampleModal">EndCall</button>
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Join Room</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div id="time" class="couting">

        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary mr-5" data-dismiss="modal">Rejoin Room</button>
        <a href="/" class="btn btn-primary ml-5">Return Home</a>
      </div>
    </div>
  </div>
</div>

<script>
function startCountdown(seconds) {
    let counter = seconds;

    
  const interval = setInterval(() => {
    // console.log(counter);
    // console.log(window.location.href);
    document.getElementById('time').innerHTML = counter;
    counter--;
      
    if (counter < 0 ) {
      clearInterval(interval);
      startCountdown(6);
    //   window.location.href = "/";
      
    }
  }, 1000);
}
startCountdown(10);
</script>
@endsection