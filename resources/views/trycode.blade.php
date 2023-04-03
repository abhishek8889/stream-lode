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
<button class="btn btn-dark" id = "endcall">EndCall</button>
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
        <a id="rejoin" class="btn btn-secondary mr-5">Rejoin Room</a>
        <a href="/" id="return" class="btn btn-primary ml-5">Return Home</a>
      </div>
    </div>
  </div>
</div>

<script>
function startCountdown(seconds) {
    let counter = seconds;

    
  const interval = setInterval(() => {
    document.getElementById('time').innerHTML = counter;
    counter--;
      
    if (counter < 0 ) {
      clearInterval(interval);
      startCountdown(6);
    }
  }, 1000);
}

// array filter
// var unique = [];
//           var distinct = [];
//           for( let i = 0; i < res.length; i++ ){
//             if( !unique[res[i]._id]){
//               distinct.push(res[i]);
//               unique[res[i]._id] = 1;
//             }

//  }

const button = document.querySelector("#endcall");
const modal = document.querySelector('#exampleModal');
  button.addEventListener("click",function(){
    startCountdown(10);
    // modal.classList.add('show');
    $('#exampleModal').modal();
     document.querySelector("#rejoin").addEventListener("click",function(e){
     e.preventDefault();
      console.log('rejoin');
    });
    document.querySelector("#return").addEventListener("click",function(e){
      e.preventDefault();
      console.log('return');
    });
    // console.log(App_url);
  });

 const data = [2,10,6,3,8,66,5,7,88,5,9,7];
  function test(){
    var res = data.filter(number => number%2 == 0);
      let sum = 0;
      for (let i = 0; i < res.length; i++) {
        sum += res[i];
    }
    console.log(res);
    console.log(sum);
  }
test();

//   rejoin.addEventListener("click",function(){
// console.log('rejoin');
//   });




</script>
@endsection