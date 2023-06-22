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
          <h3>Appointments</h3>
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
            
                <div class="card-tools">
                
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0" >
                <table class="table table-head-fixed text-nowrap">
                  <thead class="text-center">
                    <tr>
                      <th class="text-center">Sr no.</th>
                      <th>Guest Name</th>
                      <th>Start Time</th>
                      <th>End Time</th>
                      <th>Duration</th>
                      <th>Action</th>
                      <th class="text-center">View</th>
                    </tr>
                  </thead>
                  <?php  
                   if($_GET){
                          $count = ($_GET['page']-1)*10;
                        }else{
                          $count = 0;
                        }
                        ?>
                  <tbody class="text-center">
              <?php
              $current_date = date('Y-m-d H:i');
              ?>
                    @if($host_schedule)
                    @forelse ($host_schedule as $hs)
                      <tr>
                        <?php 
                     
                        $count = $count+1; ?>
                        <td class="text-center">{{$count}}.</td>
                        <td>{{$hs->guest_name}}</td>
                        <?php 
                        $startdate =  Date("M/d/Y H:i", strtotime("0 minutes", strtotime($hs->start)));
                        $enddate =  Date("M/d/Y H:i", strtotime("0 minutes", strtotime($hs->end)));
                        // $time = Date("M/d/Y H:i", strtotime("0 minutes", strtotime($hs->end)));
                        ?>
                        <td>{{$startdate}}</td>
                        <td>{{$enddate}}</td>
                        <td>{{ $hs->duration_in_minutes ?? 0 }} minutes</td>
                        <td class="text-center">
                        @if($current_date < $hs->end)
                          @if($hs->video_link_name)
                          <a href="{{ url('delete-appointment/'.$hs->id) }}" class="btn btn-danger"><i class="fa fa-trash "></i></a>
                          <a class="videoconfrencelink btn btn-success" app-id="{{$hs->_id}}" data-id="{{$hs->video_link_name}}" style="cursor:pointer;" data-toggle="tooltip" data-placement="top" title="View Room">
                            <i class="fa fa-video-camera" aria-hidden="true"></i>
                          </a>
                          @else
                          <a href="{{ url('delete-appointment/'.$hs->id) }}" class="btn btn-danger"><i class="fa fa-trash "></i></a>
                          <a class="videoconfrence btn btn-info" data-id="{{$hs->_id}}" style="cursor:pointer;"  data-toggle="tooltip" data-placement="top" title="Create Room">
                            <i class="fa fa-video-camera" aria-hidden="true"></i>
                          </a>
                          @endif
                          @else
                          @if($hs->payment_status == 1)
                            <span class="badge badge-pill badge-success">Completed</span>
                          @else
                         <span class="badge badge-pill badge-danger">Expired</span>
                         @endif
                          @endif
                        </td>

                        <td class="text-center"><a class="btn btn-info" data-toggle="modal" data-target="#exampleModalCenter{{ $hs->_id }}"> <i class="fa fa-eye"></i></a>   </td>
                       
                      </tr>
                    @empty
                      <tr>
                        <td class="text text-bold text-danger">You have no appointments</td>
                      </tr>
                    @endforelse
                    @endif
                  </tbody>
                 
                </table>
                <div class="card-footer">
                {{ $host_schedule->onEachSide(5)->links() }}
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
</div>
            <!-- meeting link modal -->
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
               <p class="link-text" > <a class="text-primary" id="send-link" style="cursor:pointer;">Click here</a> if you want to send this link to guest .</p>
              </div>
              </div>
            </div>
          </div>
          
          @foreach($host_schedule as $hs)
          <div class="modal fade bd-example-modal-lg" id="exampleModalCenter{{ $hs->_id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Appointment_Details</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                    <div class="modal-body" style="max-height: 500px; overflow: auto;">
                    <div class="container-fluid">
                          <div class="invoice p-3 mb-3">
                                  <div class="row">
                                          <div class="col-12">
                                          <h4>    
                                            <small>
                                              Payment: @if($hs->payment_status == 1) <span class="badge badge-pill badge-success" >Success</span> @else <span class="badge badge-pill badge-danger" > pending</span> @endif
                                             </small>     
                                              <small class="float-right">Date: {{ $hs->created_at ?? '' }}</small>
                                          </h4>
                                          </div>
                                  </div>
                                  <div class="row invoice-info mt-3">
                                          <!-- /.col -->
                                          <div class="col-sm-6 invoice-col">
                                          <h5><b>Meeting Detail</b></h5>
                                                      <b>Meeting started time: </b>{{ $hs->start ?? '' }}<br>
                                                      <b>Meeting end time : </b>{{ $hs->end ?? '' }} <br>
                                                      <b>Duration: </b>{{ $hs->duration_in_minutes ?? '' }} minutes  <br>
                                                      <b>Total Video Duration: </b>{{ $hs->total_duration ?? '00:00' }} minutes   
                                          </div>
                                          <!-- /.col -->
                                          <div class="col-sm-6 invoice-col">
                                              <h5><b>Guest Detail</b></h5>
                                                  <div>
                                                          Guest name :{{ $hs->guest_name ?? '' }}<br>
                                                          Guest email : {{ $hs->guest_email ?? '' }} <br>
                                                  </div>
                                          </div>
                                  </div>
                                  @if($hs->payment_status == 1)
                                  <div class="row">
                                    <div class="col-6">

                                    </div>
                                   <div class="col-6">
                                          <div class="table-responsive">
                                              <table class="table">
                                              <tbody>
                                              <tr>
                                                  <th style="width:50%">Subtotal:</th>
                                                  <td class="text-right">${{ $hs->payments['subtotal'] ?? '' }}</td>
                                              </tr>
                                              <tr>
                                                  <th>Discount:</th>
                                                  <td class="text-right">${{ $hs->payments['discount_amount'] ?? 0 }}</td>
                                              </tr> 
                                              <tr>
                                                  <th>Total:</th>
                                                  <td class="text-right">${{ $hs->payments['total'] ?? '' }}</td>
                                              </tr>
                                              </tbody></table>
                                          </div>
                                    </div>
                                          @endif
                                  </div>
                              </div>
                              <?php 
                            $questions = $hs['answers']['questions'];
                            $answers = $hs['answers']['answers'];
                            $data = array($questions,$answers);
                            
                            ?>
                              <div id="accordion{{ $hs->_id }}">
                                <h3>Questions&Answers</h3>
                                <!-- for question answer -->
                              <?php 
                            for($i=0; $i<count($data[0]); $i++){ ?>
                                    <div class="card">
                                      <div class="card-header" id="headingOne">
                                          <button class="btn"  data-toggle="collapse" data-target="#collapseOne{{ $hs->_id }}{{ $i }}" aria-expanded="true" aria-controls="collapseOne">
                                          Q.{{ $i+1 }}. <?php print_r($data[0][$i]); ?> 
                                          </button>
                                      </div>

                                      <div id="collapseOne{{ $hs->_id }}{{ $i }}" class="collapse" aria-labelledby="headingOne" data-parent="#accordion{{ $hs->_id }}">
                                        <div class="card-body" style="margin-left: 16px;">
                                        Ans. <?php print_r($data[1][$i]); ?>
                                        </div>
                                      </div>
                                    </div>
                                <?php } ?>
                              </div>
                      </div>
                </div>
              </div>
            </div>
        </div>
        @endforeach
       
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
$(document).ready(function(){
   
      $.ajax({
        method:'post',
        url: '{{ url('/'.auth()->user()->unique_id.'/seen-status') }}',
        data: { status:1,_token: "{{ csrf_token() }}" },
        dataType: 'json',
        success: function(response) {
          // console.log(response);
          if(response[0]){
            
            // location.reload();
          }
          console.log(response.length);
          $('#notificationcount').html(parseInt($('#notificationcount').html())-parseInt(response.length));
        }
      })
    })

  </script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert"></script>

@endsection