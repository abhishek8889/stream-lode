@extends('guest_layout.master')
@section('content')

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

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
      <div id="calendar"></div>
      <!-- <img src="{{ asset('streamlode-front-assets/images/calender-img.png') }}" alt="logo"> -->
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
                    <img src="images/review-image.png" alt="logo">
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
                    <img src="{{-- asset('streamlode-front-assets/images/review-image3.png') --}}" alt="logo">

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
            
         var SITEURL = "{{ url('/') }}";
           
         $.ajaxSetup({
             headers: {
             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
             }
         });
         var calendar = $('#calendar').fullCalendar({
                             editable: true,
                             events: SITEURL + "/fullcalender",
                             displayEventTime: false,
                             editable: true,
                             eventRender: function (event, element, view) {
                                 if (event.allDay === 'true') {
                                         event.allDay = true;
                                 } else {
                                         event.allDay = false;
                                 }
                             },
                             selectable: true,
                             selectHelper: true,
                             select: function (start, end, allDay) {
                                 var title = prompt('Event Title:');
                                 if (title) {
                                     var start = $.fullCalendar.formatDate(start, "Y-MM-DD");
                                     var end = $.fullCalendar.formatDate(end, "Y-MM-DD");
                                     $.ajax({
                                         url: SITEURL + "/fullcalenderAjax",
                                         data: {
                                             title: title,
                                             start: start,
                                             end: end,
                                             type: 'add'
                                         },
                                         type: "POST",
                                         success: function (data) {
                                             displayMessage("Event Created Successfully");
           
                                             calendar.fullCalendar('renderEvent',
                                                 {
                                                     id: data.id,
                                                     title: title,
                                                     start: start,
                                                     end: end,
                                                     allDay: allDay
                                                 },true);
           
                                             calendar.fullCalendar('unselect');
                                         }
                                     });
                                 }
                             },
                             eventDrop: function (event, delta) {
                                 var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD");
                                 var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD");
           
                                 $.ajax({
                                     url: SITEURL + '/fullcalenderAjax',
                                     data: {
                                         title: event.title,
                                         start: start,
                                         end: end,
                                         id: event.id,
                                         type: 'update'
                                     },
                                     type: "POST",
                                     success: function (response) {
                                         displayMessage("Event Updated Successfully");
                                     }
                                 });
                             },
                             eventClick: function (event) {
                                 var deleteMsg = confirm("Do you really want to delete?");
                                 if (deleteMsg) {
                                     $.ajax({
                                         type: "POST",
                                         url: SITEURL + '/fullcalenderAjax',
                                         data: {
                                                 id: event.id,
                                                 type: 'delete'
                                         },
                                         success: function (response) {
                                             calendar.fullCalendar('removeEvents', event.id);
                                             displayMessage("Event Deleted Successfully");
                                         }
                                     });
                                 }
                             }
          
                         });
          
         });
          
         function displayMessage(message) {
             toastr.success(message, 'Event');
         } 
           
      </script>

@endsection