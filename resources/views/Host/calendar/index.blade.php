@extends('host_layout.master')

@section('content')

    <!-- Modal  -->
    <div class="modal fade" id="titleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Enter title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="text" class="form-control" name="event_title" id="title" placeholder="enter title name here..." />
                <span class="text text-danger" id="titleError"></span>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveTitle">Save title</button>
            </div>
            </div>
        </div>
    </div>
    <!-- Modal End -->
    <br />
    <h2 align="center"><a href="#">My Schedule</a></h2>
    <br />
    <div class="container">
    <div id="calendar" attr="tst"></div>
    </div>

    <script>

$(document).ready(function () {
    var available_time = @json($event);
    // console.log(available_time);
    $.ajaxSetup({
        headers:{
            'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
        }
    });

    var calendar = $('#calendar').fullCalendar({
        
        editable:true,
        header:{
            left:'prev,next today',
            center:'title',
            right:'month,agendaWeek,agendaDay'
        },
        events: available_time,
        selectable:true,
        selectHelper: true,
        
        select:function(start, end, allDay)
        {
            
            $("#titleModal").modal('toggle');
            $("#saveTitle").on('click',function(){
                title = $("#title").val();
                var start_date = moment(start).format('YYYY-MM-DD HH:mm');
                // var end_date = $.fullCalendar.formatDate(end, "Y-MM-DD HH:mm:ss");

                // console.log(start_date);
                $.ajax({
                    url:"{{ url('/'.auth()->user()->unique_id.'/insert-schedule') }}",
                    type:"POST",
                    data:{
                        title: title,
                        start: start_date,
                        // end: end_date,
                        host_id : "{{ auth()->user()->id }}", 
                        type: 'insert-schedule'
                    },
                    success:function(response)
                    {
                        // console.log(response);
                        $("#titleModal").modal('hide');
                        // window.location.href={{ url('/'. auth()->user()->unique_id .'/calendar') }};
                        $("#calendar").fullCalendar('renderEvent',{
                            title:response.title,
                            start:response.start_date,
                            allDay:response.allDay,
                        });
                        // calendar.fullCalendar('refetchEvents');
                        // alert("Event Created Successfully");
                    },error:function(error){
                        
                        if(error.responseJSON.errors){
                            $("#titleError").html(error.responseJSON.errors.title);
                        }
                    }
                })
            });
        },
        editable:true,
        eventResize: function(event, delta)
        {
            console.log('hello');
            var start = $.fullCalendar.formatDate(event.start, 'Y-MM-DD HH:mm:ss');
            var end = $.fullCalendar.formatDate(event.end, 'Y-MM-DD HH:mm:ss');
            var title = event.title;
            var id = event.id;
            $.ajax({
                url:"/full-calender/action",
                type:"POST",
                data:{
                    title: title,
                    start: start,
                    end: end,
                    id: id,
                    type: 'update'
                },
                success:function(response)
                {
                    calendar.fullCalendar('refetchEvents');
                    alert("Event Updated Successfully");
                }
            })
        },
        eventDrop: function(event, delta)
        {
            var start = $.fullCalendar.formatDate(event.start, 'Y-MM-DD HH:mm:ss');
            var end = $.fullCalendar.formatDate(event.end, 'Y-MM-DD HH:mm:ss');
            var title = event.title;
            var id = event.id;
            $.ajax({
                url:"/full-calender/action",
                type:"POST",
                data:{
                    title: title,
                    start: start,
                    end: end,
                    id: id,
                    type: 'update'
                },
                success:function(response)
                {
                    calendar.fullCalendar('refetchEvents');
                    alert("Event Updated Successfully");
                }
            })
        },

        eventClick:function(event)
        {
            if(confirm("Are you sure you want to remove it?"))
            {
                var id = event.id;
                $.ajax({
                    url:"/full-calender/action",
                    type:"POST",
                    data:{
                        id:id,
                        type:"delete"
                    },
                    success:function(response)
                    {
                        calendar.fullCalendar('refetchEvents');
                        alert("Event Deleted Successfully");
                    }
                })
            }
        }
    });


});
  
</script>

@endsection