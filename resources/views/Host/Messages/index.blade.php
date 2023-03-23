@extends('host_layout.master')
@section('content')

 <div class="container-fluid">
    <div class="row">
      <div class="col-lg-3">
      <div class="card direct-chat direct-chat-primary" >
            <div class="card-body" >
               <!-- Conversations are loaded here -->
               <div class="direct-chat-messages" style="height:547px;">
                    <div class="direct-chat-msg px-3">
                    <a class="" href="{{ url(Auth::user()->unique_id.'/message/'.$admin['_id']) }}"><p><strong>{{$admin['first_name']}}</strong></p></a>
                               <hr>
                        @foreach($host_schedule as $h)
                               <a href="{{ url(Auth::user()->unique_id.'/message/'.$h['user_id']) }}"><p><strong>{{$h['guest_name']}}</strong></p></a>
                               <hr>
                       @endforeach
                    </div>
                </div>
            </div>
        </div>
      </div>
     
      <div class="col-lg-9">
        @if($idd)
      <div class="card direct-chat direct-chat-primary" >
            <div class="card-header">
            
            <img class="direct-chat-img" src="{{url('Assets/images/default-avatar.jpg')}}" alt="message user image">
            <h5 class="m-2"><b>{{ $user->first_name ?? '' }} {{ $user->last_name ?? '' }}</b></h5>
            </div>
            <div class="card-body" >
               <!-- Conversations are loaded here -->
               <div class="direct-chat-messages" style="display: flex; flex-direction: column-reverse; height:420px;">
                    <div class="direct-chat-msg messagesappend" id="messages">
                        @foreach($messages as $m)
                    <div class="direct-chat-msg <?php if($m['sender_id'] == Auth()->user()->id){ echo 'right'; }?>">
                    <div class="direct-chat-infos clearfix">
                      <span class="direct-chat-name <?php if($m['sender_id'] == Auth()->user()->id){ echo 'float-right'; }?>">{{$m['username']}}</span>
                    </div>
                    <div class="direct-chat-text"<?php if($m['sender_id'] == Auth()->user()->id){ echo 'style="margin-right:0px;text-align: right; margin-left:40%;"'; }else{ echo 'style="margin-left:0px; margin-right:40%;"'; }?> >
                    {{$m['message']}}
                    </div>
                    <!-- /.direct-chat-text -->
                  </div>
                       @endforeach
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <form id="message" action="{{ url('send-message') }}" method="post">
                  @csrf
                  <div class="input-group">
                    <input type="hidden"  id ="reciever_id" name="reciever_id" value="{{ $idd ?? '' }}">
                    <input type="hidden"  id ="sender_id"   name="sender_id" value="{{ Auth() ->user()->id ?? '' }}">
                    <input type="hidden" name="username" value="{{ Auth() ->user()->first_name ?? '' }}">
                    <input type="text" id ="messageinput" name="message" placeholder="Type Message ..." class="form-control">
                    <span class="input-group-append">
                      <button class="btn btn-primary">Send</button>
                    </span>
                  </div>
                </form>
              </div>
    </div>
    @endif
    </div>
      </div>
    </div>
 </div>
 <script> 
$(document).ready(function(){
  reciever_id = $('#reciever_id').val();
   sender_id = $('#sender_id').val()
  //  console.log(sender_id+reciever_id);
  $.ajax({
   method: 'post',
   url: '{{ url('host/updatemessage') }}',
   dataType: 'json',
   data: {reciever_id:reciever_id ,sender_id:sender_id, _token: '{{csrf_token()}}'},
   success: function(response)
                    { 
                    let messagecount = parseInt(response.length);
                    let notificationcount = parseInt($('#notificationcount').html());
                    let messagecount1 = parseInt($('#messagecount').html());
                    $('#messagecount').html(messagecount1-messagecount);
                    // $('#notificationcount').html(messagecount1-messagecount);
                    }

  });
});

$(document).ready(function(){
      $('#message').on('submit',function(e){
         if($('#messageinput').val() == ''){
            alert('Please enter message')
            return false;
        }
        e.preventDefault();
        formdata = new FormData(this);
      //   console.log(formdata);
        $.ajax({
         method: 'post',
         url: '{{url('send-message')}}',
         data: formdata,
         dataType: 'json',
         contentType: false,
         processData: false,
         success: function(response)
         {
           // console.log(response);
           $('#messageinput').val('');
           // $(".direct-chat-messages").load(location.href + " .direct-chat-messages");
         }
        });
      });
    });

</script>

@endsection