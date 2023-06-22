@extends('guest_layout.master')
@section('content')

<div class="page-content page-container" id="page-content">
    <div class="padding">
        <div class="row container d-flex justify-content-center">
<div class="col-md-9">
             
              <div class="box box-warning direct-chat direct-chat-warning">
                <div class="box-header with-border">
                  <h3 class="box-title">{{$host_detail['first_name'] ?? ''}} {{ $host_detail['last_name'] ?? '' }}</h3>
                </div>
              
                <div class="box-body">
                  
                  <div class="direct-chat-messages" style="display: flex; flex-direction: column-reverse; height:350px; overflow: auto;">
                  <div class="direct-chat-msg" id ="messages">
                    </div>
                        @foreach($messages as $m)  
                        <div class="direct-chat-text <?php if($m['sender_id'] == Auth()->user()->id){ echo 'message-sender'; }else{ echo 'message-reciever'; }?>">
                            <?php
                          echo $m->message; ?>
                            </div>
                          <div class="direct-chat-infos clearfix">
                            <span class="direct-chat-name float-left">{{ $m->username }}</span>
                            <?php $time = Date("Y-m-d h:i A", strtotime("0 minutes", strtotime($m['created_at'])));  ?>
                            <span class="direct-chat-timestamp float-right">{{ $time }}</span>
                          </div>
                        
                      @endforeach
                     
                </div>
                <div class="box-footer">
                  <form id="message" action="{{ url('send-messages') }}" method="post">
                    @csrf
                    <div class="input-group">
                        <input type="hidden" name="reciever_id" id ="reciever_id" value="{{ $host_detail['_id'] }}">
                        <input type="hidden" name="sender_id" id="sender_id" value="{{ Auth::user()->id }}">
                        <input type="hidden" name="username" id="username" value="{{ Auth::user()->first_name }}">
                      <input type="text" id ="messageinput" name="message" placeholder="Type Message ..." class="form-control">
                      <span class="input-group-btn">
                            <button class="btn btn-warning btn-flat">Send</button>
                        </span>
                    </div>
                  </form>
                </div>
             
              </div>
           
            </div>
             </div>
            
              </div>
             
            </div>
            <script>

$(document).ready(function(){
      $('#message').on('submit',function(e){
         if(message == ''){
            alert('Please enter message')
            return false;
        }
        e.preventDefault();
        formdata = new FormData(this);
        // console.log(formdata);
      //   console.log(formdata);
        $.ajax({
         method: 'post',
         url: '{{url('send-messages')}}',
         data: formdata,
         dataType: 'json',
         contentType: false,
         processData: false,
         success: function(response)
         {
           // console.log(response);
           $('#messageinput').val('');
           let timeString_ = moment(response.created_at).format("YYYY-MM-DD hh:mm A");
           $('#messages').append('<div class="direct-chat-msg ml-0" id ="messages"><span class="direct-chat-name float-left">'+response.username+'</span><span class="direct-chat-name float-right">'+timeString_+'</span>:<div class="direct-chat-text message-sender">'+response.message+'</div></div>');
           // $(".direct-chat-messages").load(location.href + " .direct-chat-messages");
         }
        });
      });
    });

    $(document).ready(function(){
    sender_id = $('#reciever_id').val();
    reciever_id = $('#sender_id').val();
    // console.log(sender_id+reciever_id);
    $.ajax({
    method: 'post',
    url: '{{ url('messageseen') }}',
    dataType: 'json',
    data: {sender_id:sender_id ,reciever_id:reciever_id ,  _token: '{{csrf_token()}}'},
     success: function(response)
                      { 
                        // console.log(response);
                        $('#'+sender_id).hide();
                        let count = parseInt(response.length);
                        // console.log(count);
                        let messagecount =  parseInt($('.messagecount').html());
                        $('.messagecount').html(messagecount-count);         
        }            
    });
    });
</script>
<script type="text/javascript">
  $(document).ready(function(){
    var APP_URL = {!! json_encode(url('/')) !!}
    // console.log(APP_URL);
  });
</script>

@endsection