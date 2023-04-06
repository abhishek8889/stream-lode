@extends('host_layout.master')
@section('content')
<style>
  .copy-text {
    width:85%;
    margin-inline:40px;
	position: relative;
	/* padding: 10px; */
	background: #fff;
	border: 1px solid #ddd;
	border-radius: 10px;
	display: flex;
}
.copy-text input.text {
	padding: 10px;
	font-size: 18px;
  width:100%;
	color: #555;
	border: none;
	outline: none;
}
.copy-text button {
	padding: 10px;
	background: #5784f5;
	color: #fff;
	font-size: 18px;
	border: none;
	outline: none;
	border-radius: 10px;
	cursor: pointer;
}

.copy-text button:active {
	background: #809ce2;
}
.copy-text button:before {
	content: "Copied";
	position: absolute;
	top: -45px;
	right: 0px;
	background: #5c81dc;
	padding: 8px 10px;
	border-radius: 20px;
	font-size: 15px;
	display: none;
}
.copy-text button:after {
	content: "";
	position: absolute;
	top: -20px;
	right: 25px;
	width: 10px;
	height: 10px;
	background: #5c81dc;
	transform: rotate(45deg);
	display: none;
}
.copy-text.active button:before,
.copy-text.active button:after {
	display: block;
}
.link-text{
  text-align: center;
  padding: 16px;
  font-size: 20px;
  font-weight: 10px;
  font-style: initial;
}
#send-link{
  cursor:move;
}

/* loader */
#overlayer{
display: none;
  width: 100%;
    height: 100%;
    position: fixed;
    z-index: 99;
    background: #e9edf3e0;
    top: 0px;
    height: 100vh;
}
.loader{
  width: 60px;
    height: 60px;
    margin: auto;
    display: flex;
    justify-content: center;
    align-items: center;
    position: absolute;
    transform: rotate(45deg) translate3d(0,0,0);
    animation: loader 1.2s infinite ease-in-out;
    top: 50%;
    left: calc(50% - 160px);
    transform: translate(-50%, -50%);
}
.loader span{
    background: #EE4040;
    width: 30px;
    height: 30px;
    display: block;
    position: absolute;
    animation: loaderBlock 1.2s infinite ease-in-out both;
}
.loader span:nth-child(1){
    top: 0;
    left: 0;
}
.loader span:nth-child(2){
    top: 0;
    right: 0;
    animation: loaderBlockInverse 1.2s infinite ease-in-out both;
}
.loader span:nth-child(3){
    bottom: 0;
    left: 0;
    animation: loaderBlockInverse 1.2s infinite ease-in-out both;
}
.loader span:nth-child(4){
    bottom: 0;
    right: 0;
}
@keyframes loader{
    0%, 10%, 100% {
        width: 60px;
        height: 60px;
    }
    65% {
        width: 120px;
        height: 120px;
    }
}
@keyframes loaderBlock{
    0%, 30% { transform: rotate(0); }
        55% { background: #F37272; }
    100% { transform: rotate(90deg); }
}
@keyframes loaderBlockInverse {
    0%, 20% { transform: rotate(0); }
        55% { background: #F37272; }
    100% { transform: rotate(-90deg); }
}

</style>
<div id="overlayer">
<div class="loader">
    <span></span>
    <span></span>
    <span></span>
    <span></span>
</div>
</div>
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            {{ Breadcrumbs::render('appoinments') }}
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
<div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Appoinments</h3>

                <div class="card-tools">
                
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0" style="height: 450px;">
                <table class="table table-head-fixed text-nowrap">
                  <thead>
                    <tr>
                      <th>Sr no.</th>
                      <th>Guest Name</th>
                      <th>Start Time</th>
                      <th>End Time</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <?php $count = 0; ?>
                  <tbody>
              <?php
              $current_date = date('Y-m-d H:i');
              
              ?>
                    @if($host_schedule)
                    @forelse ($host_schedule as $hs)
                      <tr>
                        <?php $count = $count+1; ?>
                        <td>{{$count}}</td>
                        <td>{{$hs->guest_name}}</td>
                        <?php 
                        $startdate =  Date("M/d/Y H:i", strtotime("0 minutes", strtotime($hs->start)));
                        $enddate =  Date("M/d/Y H:i", strtotime("0 minutes", strtotime($hs->end)));
                        // $time = Date("M/d/Y H:i", strtotime("0 minutes", strtotime($hs->end)));
                        ?>
                        <td>{{$startdate}}</td>
                        <td>{{$enddate}}</td>
                        <td>
                        
                        @if($current_date < $hs->end)
                          @if($hs->video_link_name)
                          <a class="videoconfrencelink" app-id="{{$hs->_id}}" data-id="{{$hs->video_link_name}}" href="{{ url(auth()->user()->unique_id.'/vedio-conference/'.$hs->_id) }}">
                            <span>View Room</span>
                            <i class="fa fa-video-camera" aria-hidden="true"></i>
                          </a>
                          @else
                          <a class="videoconfrence" data-id="{{$hs->_id}}" href="{{ url(auth()->user()->unique_id.'/vedio-conference/'.$hs->_id) }}">
                            <span>Create Room</span>
                            <i class="fa fa-video-camera" aria-hidden="true"></i>
                          </a>
                          @endif
                          @else
                         <span class="badge badge-pill badge-danger">Expired</span>
                          @endif
                        </td>
                       
                      </tr>
                    @empty
                      <tr>
                        <td class="text text-bold text-danger">You have no appointments</td>
                      </tr>
                    @endforelse
                    @endif
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
</div>
          <div class="modal fade " id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" >
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                
                <div class="modal-header" style="background-color: azure;">
                <h4>Your Room link is successfully generated</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                <div class="copy-text">
	              	<input type="text" class="text" id="link-input" />
	              	<button><i class="fa fa-clone"></i></button>
	              </div>
                <!-- <div id="linkdiv"></div>
                <label for="roomLink">Click this link to join or store this for future use</label> -->
                <!-- <Button class="btn btn-dark" id="send-link">Send Link</Button>
                <label for="send-link"> Send link to guest by click on Send link after refresh this will disappear from here </label> -->
               <p class="link-text" > <a class="text-primary" id="send-link">Click here</a> if your want to send link to guest  </p>
              </div>
              </div>
            </div>
          </div>
  <script>
    $(document).ready(function(){
     
      $('.videoconfrence').click(function(e){
       e.preventDefault();
       $('#overlayer').fadeIn();
        aid = $(this).attr('data-id');
        $.ajax({
            method: 'POST',
            url: "{{ url('create-room') }}",
            data:{ room_name:aid,_token:'{{csrf_token()}}' },
            dataType: 'json',
            success: function(response){
            //  console.log(response);
            $('#overlayer').fadeOut();
             $('#exampleModalCenter').modal("show");
            //  $('#exampleModalCenter').css("display","block");
             $('#send-link').attr("data-id",aid);
             $('#send-link').attr("link",response);
             $('#link-input').val(response);
            //  $('#linkdiv').append('<a target="_blank" href="'+response.join_link+'" id="roomLink" class="meeting-link">'+response.join_link+'</a>')
            }

        });
        $('.close').click(function(){
location.reload();
});

      });
    });
    $(document).ready(function(){
     
     $('.videoconfrencelink').click(function(e){
      e.preventDefault();
      // $('#overlayer').fadeIn();
       room_name = $(this).attr('data-id');
       room_link = '{{url('live-stream')}}/'+room_name;
       aid = $(this).attr('app-id');
       $('#exampleModalCenter').modal("show");
       $('#send-link').attr("data-id",aid);
       $('#send-link').attr("link",room_link);
       $('#link-input').val(room_link);

     });
   });

    $('#send-link').click(function(e){
      $('#overlayer').fadeIn();
      e.preventDefault();
      $('#exampleModalCenter').css("display","none");
      $('#exampleModalCenter').removeClass("show");
      aid = $(this).attr('data-id');
      link = $(this).attr('link');
      $.ajax({
            method: 'POST',
            url: "{{url('host/send-room-link')}}",
            data:{ link:link, id:aid ,_token:'{{csrf_token()}}' },
            dataType: 'json',
            success: function(response){
              // console.log(response);
              $('#overlayer').fadeOut();
              $('#exampleModalCenter').addClass("show");
              $('#exampleModalCenter').css("display","block");
                swal({
                          title: "success !",
                          text: response,
                          icon: "success",
                          button: "Done",
                      });
            }

        });
    });

// copy to clipboard
let copyText = document.querySelector(".copy-text");

copyText.querySelector("button").addEventListener("click", function () {
	let input = copyText.querySelector("input.text");
	input.select();
	document.execCommand("copy");
	copyText.classList.add("active");
	window.getSelection().removeAllRanges();
	setTimeout(function () {
		copyText.classList.remove("active");
	}, 2500);
});


  </script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert"></script>

@endsection