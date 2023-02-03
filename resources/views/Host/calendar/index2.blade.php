@extends('host_layout.master')
@section('content')

<div class="container">
    <h1>My Schedule</h1>
    <div id='calendar'></div>
</div>
  
<script type="text/javascript">
  
$(document).ready(function () {
   
    // var SITEURL = "{{ url('/') }}";
    var data = [
        {
            title:'my title',
            start : '2015-02-13'
        }
    ]
    $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var calendar = $('#calendar').fullCalendar({
                    editable: true,
                    events: "{{ url('/'.auth()->user()->unique_id.'/calendar') }}",
                    displayEventTime: false,
                    editable: true,
                    header:{
                        left:'prev,next today',
                        center:'title',
                        right:'month,agendaWeek,agendaDay'
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
                    select: function (start, end, allDay) {
                        var title = prompt('Event Title:');
                        if (title) {
                            var start = $.fullCalendar.formatDate(start, "Y-MM-DD HH:mm");
                            var end = $.fullCalendar.formatDate(end, "Y-MM-DD HH:mm");
                            $.ajax({
                                url: "{{ url(auth()->user()->unique_id.'/calendar-response') }}",
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
                                            start: start
                                        },true);
  
                                    calendar.fullCalendar('unselect');
                                }
                            });
                        }
                    },
                    eventDrop: function (event, delta) {
                        var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm");
                        var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD HH:mm");
  
                        $.ajax({
                            url: "{{ url(auth()->user()->unique_id.'/calendar-response') }}",
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
                                url: "{{ url('/'.auth()->user()->unique_id.'/calendar-response') }}",
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
      
    /*------------------------------------------
    --------------------------------------------
    Toastr Success Code
    --------------------------------------------
    --------------------------------------------*/
    function displayMessage(message) {
        toastr.success(message, 'Event');
    } 
    
</script>
@endsection