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
            <label for="identity">Your identity</label> <br>
            <input type="text"  class="form-control" id="identity" name="identity" /> <br>
            @error('identity')
                <div class="text text-danger">{{ $message }}</div>
            @enderror
            <input type="submit" value="Generate" class="btn btn-warning"/>
        </form>
    </div>

   
    <a class="btn btn-primary mt-5" href="{{ url(auth()->user()->unique_id.'/join-room') }}">join room</a>
    
</div>

@endsection