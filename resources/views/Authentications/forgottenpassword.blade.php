@extends('guest_layout.master')
@section('content')
<div style="margin-top:100px;">
<div class="col-lg-6 m-auto">
  
<form action="forgottenProc" method="POST">
  <!-- Email input -->
  @csrf
  <div class="form-outline mb-4">
    <label class="form-label" for="form2Example1">Email address</label>
    <input type="email" id="form2Example1" class="form-control" name="email" />
    
  </div>
  <!-- Submit button -->
  <button type="submit" class="btn btn-primary btn-block mb-4">Forgotten Password</button>

  <!-- Register buttons -->
  <div class="text-center">
    <p>Not a member? <a href="{{ url('/membership') }}#all">Register</a></p>
  </div>
</form>
</div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert"></script>
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