@extends('host_layout.master')
@section('content')


 <div class="container-fluid">
    
    <div class="card direct-chat direct-chat-primary" >
            <div class="card-body" >
               <!-- Conversations are loaded here -->
               <div class="direct-chat-messages" style="display: flex; flex-direction: column-reverse; height:460px;">
                    <div class="direct-chat-msg" id="messages">
                        @foreach($messages as $m)
                               <p><strong>{{$m['username'] ?? ''}}</strong> : {{$m['message'] ??''}}</p>
                       @endforeach
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <form id="message" action="{{ url('send-message') }}" method="post">
                  @csrf
                  <div class="input-group">
                    <input type="hidden"  id ="reciever_id" name="reciever_id" value="{{ $uid }}">
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
 </div>
 <script> 
$(document).ready(function(){
   id = '{{Auth()->user()->id}}';
  $.ajax({
   method: 'post',
   url: '{{ url('host/updatemessage') }}',
   dataType: 'json',
   data: {id:id ,  _token: '{{csrf_token()}}'},
   success: function(response)
                    { 
                     // location.reload();
                    }

  });
});

$(document).ready(function(){
      $('#message').on('submit',function(e){
         if(message == ''){
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