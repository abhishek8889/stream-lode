@extends('guest_layout.master')
@section('content')

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert"></script>

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
           <img src="{{ $host_details['profile_image_url'] }}" alt="logo">
        </div>
      </div>
      <div class="host-detail col-md-6">
        <div class="text-box">
           <div class="head-wrapper d-flex">
            
           <h2><span class="yellow"> I am</span><span class="blue"> {{ $host_details['first_name'] }} </span></h2>
           <span class="head-star-pattern"><img src="{{ asset('streamlode-front-assets/images/star.png') }}" alt="logo"></span>
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
         <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
         <div class="host-mail">
           <a href="mailto:{{ $host_details['email'] }}"><i class="fa-solid fa-envelope"></i> {{ $host_details['email'] }} </a>
         </div>
         <ul class="host-social-links">
           <li><a href="#"><i class="fa-brands fa-facebook-f"></i></a></li>
            <li><a href="#"><i class="fa-brands fa-linkedin-in"></i></a></li>
           <li><a href="#"><i class="fa-brands fa-instagram"></i></a></li>
          <li><a href="#"><i class="fa-brands fa-twitter"></i></a></li> 
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
              <h5 class="modal-title" id="exampleModalLongTitle">Schedule metting with {{ $host_details['first_name'] }} </h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="calendarCloseBtn">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form id="scheduleMeetingForm" action="" >
              <div class="modal-body">
                <input type="hidden" name="user_login_status" id="user_login_status" user_id="{{ isset(auth()->user()->id)?auth()->user()->id:''; }}" value="{{ isset(auth()->user()->id)?1:0; }}">
                <div class="form-group">
                  <label for="name">Enter your name</label>
                  <input type="text" class="form-control" id="name"  placeholder="Enter your name">
                </div>
                <div class="form-group">
                  <label for="email">Enter your email</label>
                  <input type="email" class="form-control" id="email"  placeholder="Enter your email">
                </div>
                <div class="form-group">
                  <label for="time">Meeting start time</label>
                  <input type="datetime-local" class="form-control" id="start_time" placeholder="Meetimg time" value="10:00"/>
                </div>
                <div class="form-group">
                  <label for="time">Meeting end time</label>
                  <input type="datetime-local" class="form-control" id="end_time" placeholder="Meetimg time" value="10:00"/>
                </div>
              </div>
              <div class="modal-footer">
                
                <button type="submit" class="btn btn-primary">Schedule meeting</button>
              </div>
            </form>
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
      <h2>Revies</h2>
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

<script>
         $(document).ready(function () {
          

          $.ajaxSetup({
              headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
          });
          var isLoading = false;
          var calendar = $('#calendar').fullCalendar({
                            // editable: true,
                            events: "{{ url('/details/'.$host_details['unique_id'] ) }}",
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
                                if(event.type == 'available_host'){
                                  $("#calendarModal").modal({
                                    backdrop : 'static',
                                    keyboard : false});
                                    
                                  $("#scheduleMeetingForm").on('submit',function(e){
                                    e.preventDefault();
                                    let user_login_status = $("#user_login_status").val();
                                    let name = $("#name").val();
                                    let email = $("#email").val();
                                    let start_time = $("#start_time").val();
                                    let end_time = $("#end_time").val();
                                  
                                    if(user_login_status == 0){
                                      $("#calendarModal").modal('hide');
                                      $("#loginConfirmation").modal('toggle');
                                    }else{
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
                                                      status : 1,
                                                      type : 'add',
                                              },
                                              success: function (data) {
                                                console.log(data);
                                                isLoading = false;
                                                $("#calendarModal").modal('hide');
                                                  calendar.fullCalendar('renderEvent',
                                                    {
                                                        id: data.id,
                                                        start : data.start,
                                                        end: data.end,
                                                        allDay: data.allDay
                                                    },true);
                                                calendar.fullCalendar('unselect');
                                                // window.location.href="{{ url('/details/'.$host_details['unique_id']) }}";
                                                displayMessage("Meeting Scheduled Successfully");
                                              }
                                        });
                                      }
                                    }
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
           
      </script>

@endsection