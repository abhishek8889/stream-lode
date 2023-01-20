@extends('guest_layout.master')
@section('content')
<div style="margin-top:100px;">
<div class="col-lg-6 m-auto">
<form action="loginProc" method="POST">
  <!-- Email input -->
  @csrf
  <div class="form-outline mb-4">
    <input type="email" id="form2Example1" class="form-control" name="email" />
    <label class="form-label" for="form2Example1">Email address</label>
  </div>

  <!-- Password input -->
  <div class="form-outline mb-4">
    <input type="password" id="form2Example2" class="form-control" name="password"/>
    <label class="form-label" for="form2Example2"  >Password</label>
  </div>
  <!-- Submit button -->
  <button type="submit" class="btn btn-primary btn-block mb-4">Sign in</button>

  <!-- Register buttons -->
  <div class="text-center">
    <p>Not a member? <a href="{{ route('register') }}">Register</a></p>
  </div>
</form>
</div>
</div>
@endsection