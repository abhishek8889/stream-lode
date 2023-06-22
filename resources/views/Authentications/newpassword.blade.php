@extends('guest_layout.master')
@section('content')
<div style="margin-top:100px;">
@if(!(Session::get('token'))) <p class="text-center text-danger" > Your Reset Password Session is expired please Regenrate your link </p> @endif
<div class="col-lg-6 m-auto">
<form action="{{ url('forgottenProc') }}" method="POST">
  <!-- Email input -->
  @csrf
  <div class="form-outline mb-4">
    <input type="hidden" name="emaill" value="{{ $email }}">
    <input type="hidden" name="token" value="{{ $token }}">
    <label class="form-label" for="newpassword">New password</label>
    <input type="password" id="newpassword" class="form-control" name="password" />
  </div>
  <div class="form-outline mb-4">
    <label class="form-label" for="confirmpassword">Confirm your password</label>
    <input type="password" id="confirmpassword" class="form-control" name="cpassword" />
  </div>
  <!-- Submit button -->
  <button type="submit" class="btn btn-primary btn-block mb-4" @if(!(Session::get('token'))) style="cursor: not-allowed" disabled @endif >Reset Password</button>

  <!-- Register buttons -->
  <div class="text-center">
    <p>Not a member? <a href="{{ route('register') }}">Register</a></p>
    
  </div>
</form>
</div>
</div>
@if(Session::get('error'))
<script>
swal({
    title: "error !",
    text: "{{ Session::get('error') }}",
    icon: "error",
    button: "Dismiss",
      });
</script>
@endif
@if(Session::get('success'))
<script>
swal({
    title: "success !",
    text: "{{ Session::get('success') }}",
    icon: "success",
    button: "Dismiss",
      });
</script>

@endif
@endsection