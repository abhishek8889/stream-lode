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
                
                <button type="submit" class="btn btn-primary">Schedule meeting</button>
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
                    editable: true,
                    events: "{{ url('/'.auth()->user()->unique_id.'/calendar') }}",
                    // displayEventTime: true,
                    displayEventEnd: true,
                    editable: true,
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
                        let enddateString = moment(start._d, "YYYY-MM-DD HH:mm").add(60, 'minutes').format('YYYY-MM-DD HH:mm');
                        $('#start_time').val(startdateString);
                        $('#end_time').val(enddateString);
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
                                        location.reload();
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
                        // console.log(delta);
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
                        // console.log(event._id);
                        if (deleteMsg) {
                            $.ajax({
                                type: "POST",
                                url: "{{ url('/'.auth()->user()->unique_id.'/calendar-response') }}",
                                data: {
                                        id: event._id,
                                        type: 'delete'
                                },
                                success: function (response) {
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