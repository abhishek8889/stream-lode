@extends('host_layout.master')
@section('content')
@if($token)
    {{ $token }}
@endif
@endsection