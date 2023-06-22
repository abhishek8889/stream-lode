@extends('host_layout.master')
@section('content')
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">My Schedule</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            {{ Breadcrumbs::render('calender') }}
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
<div class="container">
    <!-- schedule metting Modal -->
    <div class="modal fade" id="calendarModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLongTitle">Enter your available time </h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="calendarCloseBtn">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
        
            <form id="availableHostForm" action="" >
              <div class="modal-body">
                @if(count($meeting_charges) == 0 || empty($host_stripe_account_details))
                    @if(count($meeting_charges) == 0 )
                    
                    <div class="alert alert-danger" role="alert">
                        <p style="font-size:large;"> You have to <a href="{{ url(Auth()->user()->unique_id.'/meeting-charges/add') }}" data-toggle="tooltip" data-placement="bottom" title="Click here to create meeting charges"> create meeting charge </a> before set your availability. </p>
                    </div>
                    @endif
                    @if(empty($host_stripe_account_details))
                    <div class="alert alert-danger" role="alert">
                        <p style="font-size:large;"> You have to <a href="{{ url(Auth()->user()->unique_id.'/register-account') }}" data-toggle="tooltip" data-placement="bottom" title="Click here to register your account"> register your account </a> so you can get video stream payments from guests. </p>
                    </div>
                    @endif
                @else
                    @if($host_stripe_account_details['active_status'] == 'false')
                    <div class="alert alert-danger" role="alert">
                        <p style="font-size:large;"> Your account is not activate please <a href="{{ url(auth()->user()->unique_id.'/') }}">refresh your dashboard</a>
                         or accept terms of service got in your registered email so you can get video stream payments from guests. </p>
                    </div>
                    @else
                    
                    <div class="alert alert-info" role="alert">
                        <p style="font-size: large;">Your meeting charges for @foreach($meeting_charges as $mc) {{ $mc->duration_in_minutes ?? ''}} minutes is ${{ $mc->amount ?? '' }},  @endforeach if you want to add more charges than <a href="{{ url(Auth()->user()->unique_id.'/meeting-charges/add') }}" data-toggle="tooltip" data-placement="bottom" title="Click here to create meeting charges"> click here </a></p>
                    </div>  
                    @endif 
                @endif
                @if(count($host_question) == 0)
                    <div class="alert alert-danger" role="alert">
                        <p style="font-size:large;"> You have to add Question for Guest <a href="">Click here</a> to add these questions</p>
                    </div>
                @endif
                <div class="form-group">
                  <label for="time">Title</label>
                  <input type="text" class="form-control" id="title" placeholder="Enter your Title" />
                </div>
                <?php 
                    $today_date = date("Y-m-d H:i");
                    $end_time_string = strtotime($today_date);
                    $end_suggestion = date('Y-m-d H:i', strtotime('+30 minutes',$end_time_string));
                ?>
                <div class="form-group">
                  <label for="time">Start time</label>
                  <input type="datetime-local" class="form-control" id="start_time" placeholder="Meetimg time" value="{{ $today_date }}"/>
                </div>

                <div class="form-group">
                  <label for="time">End time</label>
                  <input type="datetime-local" class="form-control" id="end_time" placeholder="Meetimg time" value="{{ $end_suggestion }}"/>
                </div>
              </div>
              <div class="modal-footer">
                <button type="submit" class="btn btn-primary" @if( count($meeting_charges) == 0|| count($host_question) == 0
                 || empty($host_stripe_account_details)) disabled @else @if($host_stripe_account_details['active_status'] == 'false') disabled @endif @endif>Schedule meeting</button>
              </div>
            </form>
          </div>
        </div>
      </div>
      <!-- modal end -->
    <div id='calendar'></div>
</div>
  
<script type="text/javascript">
  
$(document).ready(function () {
   
    // var SITEURL = "{{ url('/') }}";
    // var data = [
    //     {
    //         title:'my title',
    //         start : '2015-02-13'
    //     }
    // ]

    $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var isLoading = false;

    var calendar = $('#calendar').fullCalendar({
                    // editable: true,
                    events: "{{ url('/'.auth()->user()->unique_id.'/calendar') }}",
                    // displayEventTime: true,
                    displayEventEnd: true,
                    // editable: true,
                    header:{
                        left:'prev,next today',
                        center:'title',
                        // right:'month,agendaWeek,agendaDay'
                        right:'month'
                    },
                    eventRender: function (event, element, view) {
                        if (event.allDay === 'true') {
                                event.allDay = true;
                        } else {
                                event.allDay = false;
                        }
                    },
                    selectable: true,
                    selectHelper: true,
                    select: function (start, end ,allDay) {
                        // var title = prompt('Event Title:');
                        $("#calendarModal").modal('show');
                        let startdateString = moment(start._d).format("YYYY-MM-DD HH:mm");
                        let enddateString = moment(start._d, "YYYY-MM-DD HH:mm").add(30, 'minutes').format('YYYY-MM-DD HH:mm');
                        let currentdateString = moment().format("YYYY-MM-DD HH:mm");
                        let currentenddateString = moment().add(30, 'minutes').format('YYYY-MM-DD HH:mm');
                        
                        $('#start_time').val(startdateString);
                        $('#end_time').val(enddateString);
                        if(currentdateString > startdateString){
                            $('#start_time').val(currentdateString);
                            $('#end_time').val(currentenddateString);
                        }
                        $('#start_time').on('keyup',function(){
                            if($(this).val() < currentdateString){
                                $('#start_time').val(currentdateString);
                                $('#end_time').val(currentenddateString);
                        }
                        });
                        $('#end_time').change(function(){
                            let starttime = moment($('#start_time').val()).format("YYYY-MM-DD HH:mm");
                            let endtime = moment($(this).val()).format("YYYY-MM-DD HH:mm");
                            if(starttime > endtime){
                                swal({
                                      title: "Sorry !",
                                      text: "End time must be greater than starttime",
                                      icon: "error",
                                      button: "Dismiss",
                                  });
                                  $(this).val(enddateString);
                            }
                        })
                       $("#availableHostForm").on('submit',function(e){
                            e.preventDefault();
                            var title = $("#title").val();
                            var start_time = $("#start_time").val();
                            var end_time = $("#end_time").val();
                           if(title != '' || title != 'undefined' || title != 'null' || start != '' || start != 'undefined' || start != 'null' || end != '' || end != 'undefined' || end != 'null'){
                            if (!isLoading) {
                                isLoading = true;
                                $.ajax({
                                    url: "{{ url(auth()->user()->unique_id.'/calendar-response') }}",
                                    data: {
                                        title: title,
                                        start: start_time,
                                        end: end_time,
                                        type: 'add'
                                    },
                                    type: "POST",
                                    success: function (data) {
                                        isLoading = false;
                                        $("#calendarModal").modal('hide');
                                        if(data.error){
                                            displayError(data.error);
                                        }else{
                                            displayMessage("Event created successfully.");
                                            calendar.fullCalendar('renderEvent',
                                            {
                                                id: data.id,
                                                title: data.title,
                                                start: data.start,
                                                end: data.end,
                                                allDay: allDay
                                            },true);
                                            
                                        calendar.fullCalendar('unselect');
                                        // location.reload();
                                        swal({
                                                title: "Success!",
                                                text: "Successfully added availability",
                                                icon: "success",
                                                button: "done",
                                            }).then((result) => {
                                                location.reload();
                                            });
                                        }
                                    }
                                });
                            }
                           }
                     
                        });
                    },
                    eventDrop: function (event, delta) {
                        var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm");
                        var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD HH:mm");
                        // console.log(event);
                        // console.log(start+end);
                        $.ajax({
                            url: "{{ url(auth()->user()->unique_id.'/calendar-response') }}",
                            data: {
                                title: event.title,
                                start: start,
                                end:end,
                                id: event._id,
                                type: 'update'
                            },
                            type: "POST",
                            success: function (response) {
                            //   console.log(response);
                                if(response.error){
                                    displayError(response.error);
                                }else{
                                    displayMessage("Event Updated Successfully");
                                }
                            }
                        });
                    },
                    eventClick: function (event) {
                        var deleteMsg = confirm("Do you really want to delete?");
                        // console.log(event);
                        if (deleteMsg) {
                            $.ajax({
                                type: "POST",
                                url: "{{ url('/'.auth()->user()->unique_id.'/calendar-response') }}",
                                data: {
                                        id: event.id,
                                        types: event.type,
                                        type: 'delete'
                                },
                                success: function (response) {
                                    // console.log(response);
                                    calendar.fullCalendar('removeEvents', event._id);
                                    displayMessage("Event Deleted Successfully");
                                }
                            });
                        }
                    }
 
                });
 
    });
    
      
    /*------------------------------------------
    --------------------------------------------
    Toastr Success Code
    --------------------------------------------
    --------------------------------------------*/
    
    function displayMessage(message) {
        toastr.success(message, 'Event');
    } 
    function displayError(message) {
        toastr.error(message, 'Error');
    } 
    
</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert"></script>
@endsection