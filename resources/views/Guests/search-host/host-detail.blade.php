@extends('guest_layout.master')
@section('content')

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert"></script>
<style>
  /*PRELOADING------------ */
#overlayer {
  display: none;
  width: 100%;
    height: 100%;
    position: fixed;
    z-index: 99;
    background: #2455a6e0;
    top: 0px;
    height: 100vh;
}
.loader {
  display: inline-block;
  width: 30px;
  height: 30px;
  position: absolute;
  z-index:3;
  border: 4px solid #Fff;
  top: 50%;
  animation: loader 2s infinite ease;
  left: 0px;
    right: 0px;
    margin: auto;
    transform: translateY(-50%);
}

.loader-inner {
  vertical-align: top;
  display: inline-block;
  width: 100%;
  background-color: #fff;
  animation: loader-inner 2s infinite ease-in;
}
/* .loader-wrapper {
  display: none;
    height: 100vh;
    width: 100%;
    position: fixed;
    left: 0;
    top: 0;
    z-index: 99;
} */
body.model-open{
  overflow: hidden;
}
.form-group select.form-control {
    padding: 0px;
}

@keyframes loader {
  0% {
    transform: rotate(0deg);
  }
  
  25% {
    transform: rotate(180deg);
  }
  
  50% {
    transform: rotate(180deg);
  }
  
  75% {
    transform: rotate(360deg);
  }
  
  100% {
    transform: rotate(360deg);
  }
}

@keyframes loader-inner {
  0% {
    height: 0%;
  }
  
  25% {
    height: 0%;
  }
  
  50% {
    height: 100%;
  }
  
  75% {
    height: 100%;
  }
  
  100% {
    height: 0%;
  }
}
</style>
<!-- loader  -->
<!-- <pre> -->
<?php
//  print_r($host_details);
// print_r($available_host);
$date = date('Y-m-d h:i');
// echo $date;
?>
<!-- </pre> -->
<div id="overlayer">
  <span class="loader">
    <span class="loader-inner"></span>
  </span>
</div>
<!-- #################### Host Details ################################# -->

<div class="dark-banner dark">
  <div class="container-fluid">
    <div class="dark-banner-content">
      <h1><span class="yellow">Host</span> <span class="blue">Introduction</span></h1>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="#">Home</a></li>        
          <li class="breadcrumb-item"><a href="#">Search Host</a></li>

          <li class="breadcrumb-item active" aria-current="page">{{ isset($host_details['first_name'])?'I am ' .$host_details['first_name']:'' }}</li>
        </ol>
      </nav>
    </div>
  </div>
</div>

<section class="host-intro-section">
  <div class="container-fluid">
    <div class="row host-intro-row">
      <div class="image-col col-md-6">
        <div class="image-box hover-zoom">
          @if(isset($host_details['profile_image_url']))
            <img src="{{ $host_details['profile_image_url'] }}" alt="logo">
          @else
            <img src="{{ asset('/Assets/images/default-avatar.jpg') }}" alt="unknown-avatar">
          @endif
        </div>
      </div>
      <div class="host-detail col-md-6">
        <div class="text-box">
           <div class="head-wrapper d-flex">
            
           <h2><span class="yellow"> I am</span><span class="blue"> {{ $host_details['first_name'] }} </span></h2>
           <span class="head-star-pattern"><img src="{{ asset('streamlode-front-assets/images/star.png') }}" alt="logo" style="max-height: 292px;"></span>
         </div>
         <h3 class="host_tag">
            <?php 
                $host_id = '';
                foreach($host_details['_id'] as $i){
                    $host_id = $i;
                }
                
                $host_tags = App\Models\Tags::where('user_id',$host_id)->get(['name']);
                    
            ?>
            @forelse($host_tags as $tag)
            <span>
                {{ $tag['name']. ',' }}
            </span>
            @empty

            @endforelse
         </h3>
         @if(isset($host_details['description']))
         <p>
           <?php  echo $host_details['description']; ?>
         </p>
         @endif
         <div class="host-mail">
           <a href="mailto:{{ $host_details['email'] }}"><i class="fa-solid fa-envelope"></i> {{ $host_details['email'] }} </a>
         </div>
         <ul class="host-social-links">
          <li><a href="//{{ $host_details['facebook'] ?? '' }}"><i class="fa-brands fa-facebook-f"></i></a></li>
          <li><a href="//{{ $host_details['linkdin'] ?? '' }}"><i class="fa-brands fa-linkedin-in"></i></a></li>
           <li><a href="//{{ $host_details['instagram'] ?? '' }}"><i class="fa-brands fa-instagram"></i></a></li>
          <li><a href="//{{ $host_details['twitter'] ?? '' }}"><i class="fa-brands fa-twitter"></i></a></li> 
         </ul>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="appointment-section">
  <div class="container">
    <div class="section-head text-center">
      <h2>Just Gotta Have Sync.</h2>
    </div>
    <div class="calender-wrapper text-center container card p-5">
      <!--  -->
      <div id="calendar"></div>
      
      <!-- login confirm modal -->
      <div class="modal fade" id="loginConfirmation" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLongTitle">We are not able to find you in our members.</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close" >
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <a href="{{ url('login') }}">Please click here for login...</a>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              </div>
          </div>
        </div>
      </div>
      <!-- schedule metting Modal -->
      <div class="modal fade" id="calendarModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <div class="modal-title" id="exampleModalLongTitle">
                <h5>
                  Schedule a meeting with {{ $host_details['first_name'] }} {{ $host_details['last_name'] }}
                </h5>
                <div class="available_txt text text-info">
                  Available between <span id="available_start" class="text text-dark "></span> to <span class="text text-dark" id="available_end"></span> on <span id="available_date" class="text text-dark"></span>
                </div>

              </div>

              <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="calendarCloseBtn">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body-wrapper">
              <form id="scheduleMeetingForm" action="" >
                <div class="modal-body">
                  <input type="hidden" name="user_login_status" id="user_login_status" user_id="{{ isset(auth()->user()->id)?auth()->user()->id:''; }}" value="{{ isset(auth()->user()->id)?1:0; }}">
                  <div class="form-group">
                    <label for="name">Enter your name</label>
                    <input type="text" class="form-control" id="name"  placeholder="Enter your name" value="{{ Auth::user()->first_name ?? '' }}">
                  </div>
                  <div class="form-group">
                    <label for="email">Enter your email</label>
                    <input type="email" class="form-control" id="email"  placeholder="Enter your email" value="{{ Auth::user()->email ?? '' }}" @if(Auth::check()) disabled @endif>
                  </div>
                  <!-- Select Duration of time -->
                  <div class="form-group">
                    <label for="meeting_duration">Select duration of meeting</label>
                    <select name="meeting_duration" class="form-control" id="meeting_duration">
                      @if(isset($host_meeting_charges))
                        @foreach($host_meeting_charges as $meeting_charge)
                          <option value="{{ $meeting_charge['duration_in_minutes'] }}" amount="{{ $meeting_charge['amount'] }}" currency="{{ $meeting_charge['currency'] }}" >For {{ $meeting_charge['duration_in_minutes'] }} minutes charges will be {{ $meeting_charge['amount'] }}({{ $meeting_charge['currency'] }}) </option>
                        @endforeach
                      @endif
                    </select>
                  </div>
                  <!-- End Duration of time -->

                  <div class="form-group">
                    <label for="time">Meeting start time</label>
                    <input type="datetime-local" class="form-control" id="start_time" placeholder="Meetimg time" value=""/>
                  </div>
                
                  <div class="form-group">
                    <label for="time">Meeting end time</label>
                    <input type="datetime-local" class="form-control" id="end_time" placeholder="Meetimg time" value=""/>
                  </div>
                </div>
                <div class="modal-footer">
                  
                  <button type="submit" class="btn btn-primary">Schedule meeting</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <!-- modal end -->
    </div>
  </div>
</section>

<section class="reviews-section">
  <div class="container-fluid">
    <div class="section-head text-center">
      <h2>Reviews</h2>
    </div>
    <div class="reviews-wrapper">
      <div class="review-slider">
        <div class="review-item">
          <div class="review">
            <div class="review-header dflex">
              <div class="author-info">
                <div class="author-info-wrapper dflex">
                  <div class="author-image">
                    <img src="{{ asset('streamlode-front-assets/images/review-image.png') }}" alt="logo">
                  </div>
                  <div class="author-detail">
                    <h5>Tamra Alderson</h5>
                    <h6>Lorem Ipsum</h6>
                  </div>
                </div>
              </div>
              <div class="author-rating">
                <img src="{{ asset('streamlode-front-assets/images/starstarstarstarstar.png') }}" alt="logo">
              </div>
            </div>
            <div class="review-body">
              <p>“It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.”</p>
            </div>
          </div>
        </div>
        <div class="review-item">
          <div class="review">
            <div class="review-header dflex">
              <div class="author-info">
                <div class="author-info-wrapper dflex">
                  <div class="author-image">
                    <img src="{{ asset('streamlode-front-assets/images/review-image2.png') }}" alt="logo">
                  </div>
                  <div class="author-detail">
                    <h5>Tamra Alderson</h5>
                    <h6>Lorem Ipsum</h6>
                  </div>
                </div>
              </div>
              <div class="author-rating">
                <img src="{{ asset('streamlode-front-assets/images/starstarstarstarstar.png') }}" alt="logo">
              </div>
            </div>
            <div class="review-body">
              <p>“It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.”</p>
            </div>
          </div>
        </div>
        <div class="review-item">
          <div class="review">
            <div class="review-header dflex">
              <div class="author-info">
                <div class="author-info-wrapper dflex">
                  <div class="author-image">
                    <img src="{{ asset('streamlode-front-assets/images/review-image3.png') }}" alt="logo">

                  </div>
                  <div class="author-detail">
                    <h5>Tamra Alderson</h5>
                    <h6>Lorem Ipsum</h6>
                  </div>
                </div>
              </div>
              <div class="author-rating">
                <img src="{{ asset('streamlode-front-assets/images/starstarstarstarstar.png') }}" alt="logo">
              </div>
            </div>
            <div class="review-body">
              <p>“It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.”</p>
            </div>
          </div>
        </div>
        <div class="review-item">
          <div class="review">
            <div class="review-header dflex">
              <div class="author-info">
                <div class="author-info-wrapper dflex">
                  <div class="author-image">
                    <img src="{{ asset('streamlode-front-assets/images/review-image.png') }}" alt="logo">
                  </div>
                  <div class="author-detail">
                    <h5>Tamra Alderson</h5>
                    <h6>Lorem Ipsum</h6>
                  </div>
                </div>
              </div>
              <div class="author-rating">
                <img src="{{ asset('streamlode-front-assets/images/starstarstarstarstar.png') }}" alt="logo">
              </div>
            </div>
            <div class="review-body">
              <p>“It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.”</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
 <!-- Questionarie modal -->
 <div class="modal fade" id="exampleModalCenterqueston" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog mx-0 mx-sm-auto">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h5 class="modal-title text-white" id="exampleModalLabel">Host Questionarie</h5>
      </div>
      <div class="modal-body">
        <p class="text-center text-primary">These questions are mandatory to fill for fix appoinments.</p>
        <span class="text-danger" id="errorspan"> </span>
        <?php $count = 0;
        ?>

        <form class="px-4" id="questionform" action="{{ url('questionnaire') }}" method="post">
          @csrf
         
        <input type="hidden" name="host_id" value="{{ $host_details['_id'] ?? ''}}">   <!--appoinment_id -->
          @foreach($HostQuestionnaire as $hq)
        <?php $count = $count+1; ?>
          <p class=""><strong>{{ $count }}.{{ $hq->question }}</strong></p>
           <input type="hidden" name="question[]" value="{{$hq->_id}}">
              @if($hq->answer_type == 'checkbox')
              @foreach($hq->checkboxname as $checkbox)
                <div class="form-check mb-2">
                 
                  <input class="form-check-input" type="radio" name="answer{{ $count-1 }}" id="radio4Example1" value="{{ $checkbox }}" />
                  <label class="form-check-label" for="radio4Example1">
                    {{ $checkbox }}
                  </label>
                </div>
                @endforeach
                @else
                <textarea class="form-control" id="form4Example4" rows="4" name="answer{{ $count-1 }}"></textarea>
              @endif
              <hr />
         @endforeach
          <button type="submit" class="btn btn-primary">Submit</button>
        </form>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
        $(document).ready(function () {
        
          let data = @json($available_host);
          $.ajaxSetup({
              headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
          });
          var isLoading = false;
          var calendar =  $('#calendar').fullCalendar({
                            // editable: true,
                            events: data,
                            displayEventEnd: true,
                            // editable: true,
                            eventRender: function (event, element, view) {
                                if (event.allDay === 'true') {
                                        event.allDay = true;
                                } else {
                                        event.allDay = false;
                                }
                            },
                            selectable: true,
                            selectHelper: true,
                            eventClick: function (event) {
                              
                              // $.each(event,function(key, value){
                              //   console.log(key + ' : ' + value);
                              // });
                              // $.fullCalendar.formatDate(event.start, "MM/dd/YYYY")
                              let available_date = $.fullCalendar.formatDate(event.start, "DD-MMM-YYYY");
                              let available_start = $.fullCalendar.formatDate(event.start, "HH:mm");
                              let available_end = $.fullCalendar.formatDate(event.end, "HH:mm");
                              
                              $("span#available_date").html('<u>'+ available_date+ '</u>');
                              $("span#available_start").html('<u>'+available_start+ '</u>');
                              $("span#available_end").html('<u>'+available_end+ '</u>');

                                if(event.type == 'available_host'){
                                  $("#calendarModal").modal({
                                    backdrop : 'static',
                                    keyboard : false});
                                    var dt = new Date();
                                    time = moment(dt).format("YYYY-MM-DD HH:mm");
                                    if(time > event.start._i){
                                      starttime = time;
                                    }else{
                                      starttime = event.start._i;
                                    }
                                    // console.log(starttime);
                                    // changes after selecting the duration 
                                    var meet_duration = $("#meeting_duration").val();
                                    var defaulttimestamp = moment(starttime, "YYYY-MM-DD HH:mm").add(meet_duration, 'minutes').format('YYYY-MM-DD HH:mm');
                                    if(defaulttimestamp > event.end._i){
                                      if(event.end._i < starttime ){
                                        $(".modal-body-wrapper").addClass('p-3 text text-secondary');
                                        $(".modal-body-wrapper").html("Host's available time is over for today please wait for host's update.");
                                      
                                      }else{
                                        $(".modal-body-wrapper").addClass('p-3 text text-secondary');
                                        $(".modal-body-wrapper").html("Host's available time is less than its minimum slot please wait for host update.");
                                      }
                                    }
                                    var previous_selected;
                                    $("select#meeting_duration").on('focus',function(){
                                        //  change end time and check if it is on available time if it is not give him alert to select small interval
                                        previous_selected =  this.value;
                                    }).change(function(){
                                      var start_time_new = $("#start_time").val(); 
                                      var defaulttimestamp = moment(start_time_new, "YYYY-MM-DD HH:mm").add($(this).val(), 'minutes').format('YYYY-MM-DD HH:mm');
                                      if(defaulttimestamp > event.end._i){
                                            swal({
                                              title: "Sorry !",
                                              text: "sorry your slot time is greater than available time.",
                                              icon: "info",
                                              button: "Dismiss",
                                            });
                                            var defaulttimestamp = moment(start_time_new, "YYYY-MM-DD HH:mm").add(previous_selected, 'minutes').format('YYYY-MM-DD HH:mm');
                                            $(this).val(previous_selected);
                                            $('#end_time').val(defaulttimestamp);
                                            return false;   
                                        }else{
                                          $('#end_time').val(defaulttimestamp);
                                        }
                                    });
                                    $('#start_time').val(starttime); // Default start time 
                                    defaulttimestamp = moment(starttime, "YYYY-MM-DD HH:mm").add(meet_duration, 'minutes').format('YYYY-MM-DD HH:mm');
                                    // console.log(defaulttimestamp);
                                    $('#end_time').val(defaulttimestamp);
                                    $('#start_time').change(function(){
                                      var meet_duration = $("#meeting_duration").val();
                                      startdate = $('#start_time').val();
                                      //  console.log(startdate);
                                      newDateTime = moment(startdate, "YYYY-MM-DD HH:mm").add(meet_duration, 'minutes').format('YYYY-MM-DD HH:mm');
                                      // console.log(newDateTime);
                                      let dateString_ = moment(startdate).format("YYYY-MM-DD HH:mm");
                                      if(dateString_ > event.end._i){
                                        swal({
                                          title: "Sorry !",
                                          text: "This timestamp is not valid",
                                          icon: "error",
                                          button: "Dismiss",
                                        });
                                        $('#start_time').val(starttime);
                                      }
                                      //  console.log(dateString_);
                                      if(dateString_ < starttime){
                                        swal({
                                          title: "Sorry !",
                                          text: "This timestamp is not valid",
                                          icon: "error",
                                          button: "Dismiss",
                                        });
                                        $('#start_time').val(starttime);
                                      }else{
                                        $('#end_time').val(newDateTime);
                                        $('#end_time').change(function(){
                                          endtime = $(this).val();
                                          let endtimeString_ = moment(endtime).format("YYYY-MM-DD HH:mm");
                                          if(endtimeString_ < newDateTime){
                                            swal({
                                              title: "Sorry !",
                                              text: "Minimum time interval is 30 minutes",
                                              icon: "error",
                                              button: "Dismiss",
                                            });
                                            $('#end_time').val(newDateTime);
                                          }
                                          if(endtimeString_ < starttime){
                                            swal({
                                              title: "Sorry !",
                                              text: "This timestamp is not valid",
                                              icon: "error",
                                              button: "Dismiss",
                                            });
                                            $('#end_time').val(newDateTime);
                                          }
                                        });
                                      }
                                    });
                                    // $('#end_time').change(function(){
                                    //  startdate = $('#start_time').val();
                                    //  newDateTime = moment(startdate, "YYYY-MM-DD HH:mm").add(meet_duration, 'minutes').format('YYYY-MM-DD HH:mm');
                                    //  console.log(newDateTime);
                                    //   let dateString = moment($(this).val()).format("YYYY-MM-DD HH:mm");
                                    //   if(dateString < defaulttimestamp){
                                    //     swal({
                                    //       title: "Sorry !",
                                    //       text: "Minimum time interval is 30",
                                    //       icon: "error",
                                    //       button: "Dismiss",
                                    //     });
                                    //     $('#end_time').val(newDateTime);
                                    //     // console.log(newDateTime);
                                    //   }
                                    //   // console.log(event.end._i)
                                    //   if(dateString > event.end._i){
                                    //     swal({
                                    //       title: "Sorry !",
                                    //       text: "This timestamp is not valid",
                                    //       icon: "error",
                                    //       button: "Dismiss",
                                    //     });
                                    //     $('#end_time').val(newDateTime);
                                    //     // console.log(newDateTime);
                                    //   }
                                    // });

                                  //  console.log(event.start._i);
                                  $("#scheduleMeetingForm").on('submit',function(e){
                                    e.preventDefault();
                                    $("#overlayer").fadeIn();
                                    $("#calendarModal").modal('hide');
                                    let user_login_status = $("#user_login_status").val();
                                    let name = $("#name").val();
                                    let email = $("#email").val();
                                    let start_time = $("#start_time").val();
                                    let end_time = $("#end_time").val();
                                    let duration = $("#meeting_duration").val();
                                      // console.log(duration);
                                      if (!isLoading) {
                                        isLoading = true;
                                        $.ajax({
                                              type: "POST",
                                              url: "{{ url('schedule-meeting') }}",
                                              data: {
                                                      available_id : event.id,
                                                      user_id : $("#user_login_status").attr('user_id') ,
                                                      host_id : "{{ $host_id }}",
                                                      name : name,
                                                      email : email,
                                                      start : start_time,
                                                      end : end_time,
                                                      duration :duration,
                                                      status : 1,
                                                      type : 'add',
                                              },
                                              success: function (data) {
                                                // console.log(data);
                                                isLoading = false;
                                                if(data.status == false){
                                                  setTimeout(function(){
                                                    $(".loader-wrapper").fadeOut('1000');
                                                    $("#overlayer").fadeOut('100');
                                                  }
                                                    , 1000);
                                                swal({
                                                  title: "Slot is already booked.",
                                                  text: data.message,
                                                  icon: "info",
                                                  button: "Dismiss",
                                                 });
                                                }else{
                                                setTimeout(function(){
                                                  //  location.reload();
                                                  $('#exampleModalCenterqueston').modal({backdrop: 'static'});
                                                    $(".loader-wrapper").fadeOut('3000');
                                                    $("#overlayer").fadeOut('3000');
                                                  }
                                                    , 3000);
                                                }
                                                
                                            
                                                // // console.log(data);
                                                //   calendar.fullCalendar('renderEvent',
                                                //     {
                                                //         id: data.id,
                                                //         start : data.start,
                                                //         end: data.end,
                                                //         allDay: data.allDay
                                                //     },true);
                                                // calendar.fullCalendar('unselect');
                                               
                                                // displayMessage("Meeting Scheduled Successfully");
                                              },
                                              error: function(XMLHttpRequest, textStatus, errorThrown) { 
                                                isLoading = false;
                                                $("#overlayer").fadeOut('3000');
                                                // console.log(XMLHttpRequest.responseJSON.message);
                                                // console.log(textStatus);
                                                // console.log(errorThrown);
                                                swal({
                                                     title: "Error !",
                                                     text: XMLHttpRequest.responseJSON.message,
                                                     icon: "error",
                                                     button: "Dismiss",
                                                 });
                                            }
                                        });
                                      
                                    }
                                  });
                                }else if(event.type == 'duration_below_thirty'){
                                  swal({
                                      title: "Sorry !",
                                      text: "Sorry host is not available.",
                                      icon: "error",
                                      button: "Dismiss",
                                  });
                                }else{
                                  swal({
                                      title: "Sorry !",
                                      text: "Sorry this slot is booked",
                                      icon: "error",
                                      button: "Dismiss",
                                  });
                                }
                             }
                          });
                          $("#calendarCloseBtn").on('click',function(){
                            calendar.unselect()
                          });
        });


        function displayMessage(message) {
            toastr.success(message, 'Event');
        } 
        $(document).ready(function(){
        var dt = new Date();
        time = moment(dt).format("YYYY-MM-DD HH:mm");
        // console.log(time);
        });

        $('#questionform').on('submit',function(e){
          e.preventDefault();
          $("#overlayer").fadeIn();
          formdata = new FormData(this);
          var questions = '{{ count($HostQuestionnaire) }}';
          data = $(this).serialize();
          for (let i = 0; i < questions; i++) {
            const answer1 = new URLSearchParams(data).get('answer'+i);
            if(answer1 == null || answer1 == ""){
            $('#errorspan').html('Please answer all the below questions');
          $("#overlayer").fadeOut();
            return false;
            }else{
            $('#errorspan').html('');
            }
          }
          $.ajax({
            method: 'post',
            url: '{{url('questionnaire')}}',
            data: formdata,
            dataType: 'json',
            contentType: false,
            processData: false,
            success: function(response)
            {
              // console.log(response);
              if(response.error){
                $("#overlayer").fadeOut();
                  $('#errorspan').html(response.error);
              }else{
                // console.log(response);
                location.reload();
              }
            },
          })
        });
        
      </script>
@if($questionrie_status)
    @if($questionrie_status['questionrie_status'] == 0)
    <script>
      $(document).ready(function(){
    $('#exampleModalCenterqueston').modal({backdrop: 'static'});
      });
    </script>
    @endif
@endif

@endsection