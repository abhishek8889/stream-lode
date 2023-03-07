@extends('host_layout.master')
@section('content')
<h4>Generate token for vedio chat</h4>
<div class="container">
    <form action="{{ url('generate-token') }}" method="POST">
        @csrf
        <label for="room_name">Room name</label> <br>
        <input type="text"  id="room_name" name="room_name" /> <br>
        @error('room_name')
            <div class="text text-danger">{{ $message }}</div>
        @enderror
        <label for="identity">Your identity</label> <br>
        <input type="text"  id="identity" name="identity" /> <br>
        @error('identity')
            <div class="text text-danger">{{ $message }}</div>
        @enderror
        <input type="submit" value="Generate" />
    </form>
</div>

@endsection