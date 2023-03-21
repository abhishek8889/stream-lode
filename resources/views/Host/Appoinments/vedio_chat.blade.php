@extends('host_layout.master')
@section('content')
<h4>Create Room for Vediocall : </h4>
<div class="container">
    <div class="card" style="width:500px;padding:10px;">
        <form action="{{ url('create-room') }}"  method="POST">
            @csrf
            <label for="room_name" >Room name</label> <br>
            <input type="text"  id="room_name" class="form-control" name="room_name" /> <br>
            @error('room_name')
                <div class="text text-danger">{{ $message }}</div>
            @enderror
            <input type="submit" value="Generate" class="btn btn-warning"/>
        </form>
        @if(Session::has('data'))
        <?php $data = Session::get('data');  ?>
        <div id="roomDetails"><span>Your room name is : </span> <span class="text text-primary">{{ $data['roomName'] }}</span></div>
        <label for="roomDetails">This room name is required for join vedio call</label>
        <a id="roomLink" class="meeting-link">{{$data['join_link']}}</a>
        <label for="roomLink">Click this link to join or store this for future use</label>
        @endif
    </div>
</div>

@endsection