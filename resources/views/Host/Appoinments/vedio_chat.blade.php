@extends('host_layout.master')
@section('content')
<h4>Create Room for Videocall : </h4>
<div class="container">
    <div class="card" style="width:500px;padding:10px;">
        <form action="{{ url('create-room') }}"  method="POST">
            @csrf
            <label for="room_name" >Room name</label> <br>
            <input type="text" onload="convertToSlug(this.value)" onkeyup="convertToSlug(this.value)" id="room_name" name="room_real_name" class="form-control"  /> <br>
            <input type="hidden" class="form-control" id="room_slug" name="room_name" /> <br>

            @error('room_name')
                <div class="text text-danger">{{ $message }}</div>
            @enderror
            <input type="submit" value="Generate" class="btn btn-warning"/>
        </form>
        @if(Session::has('data'))
        <?php $data = Session::get('data');  ?>
        <div id="roomDetails"><span>Your room name is : </span> <span class="text text-primary">{{ $data['roomName'] }}</span></div>
        <label for="roomDetails">This room name is required for join video call</label>
        <a target="_blank" href="{{$data['join_link']}}" id="roomLink" class="meeting-link">{{$data['join_link']}}</a>
        <label for="roomLink">Click this link to join or store this for future use</label>
        <Button class="btn btn-dark" id="send-link" link="{{$data['join_link']}}">Send Link</Button>
        <label for="send-link"> Send link to guest by click on Send link after refresh this will disappear from here </label>
        @endif
    </div>
</div>
<script>
     function convertToSlug(str){
 str = str.replace(/[`~!@#$%^&*()_\-+=\[\]{};:'"\\|\/,.<>?\s]/g, ' ')
             .toLowerCase();
    str = str.replace(/^\s+|\s+$/gm,'');
    str = str.replace(/\s+/g, '-');   
    $('#room_slug').val(str);
  }
  $(document).ready(function(){
    $('#send-link').click(function(e){
        e.preventDefault();
        link = $(this).attr('link');
        email = '{{ $appoinments->guest_email }}';
        host = '{{ $appoinments->user['first_name'] ?? ''}} {{ $appoinments->user['last_name'] ?? '' }}';
        // console.log(link+email);
        $.ajax({
            method: 'POST',
            url: '{{url('host/send-room-link')}}',
            data:{ link:link, host_name:host, email:email,_token:'{{csrf_token()}}' },
            dataType: 'json',
            success: function(response){
                swal({
                                      title: "success !",
                                      text: response,
                                      icon: "success",
                                      button: "Done",
                                  });
            }

        });
    });
  });
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert"></script>

@endsection