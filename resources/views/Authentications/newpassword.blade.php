@extends('guest_layout.master')
@section('content')
<div style="margin-top:100px;">
<div class="col-lg-6 m-auto">
<form action="{{ url('forgottenProc') }}" method="POST">
  <!-- Email input -->
  @csrf
  <div class="form-outline mb-4">
    <input type="hidden" name="emaill" value="{{ $email }}">
    <input type="hidden" name="password_token" value="{{ $password_token }}">
    <label class="form-label" for="newpassword">New password</label>
    <input type="password" id="newpassword" class="form-control" name="password" />
    <span class="text-danger" id="password-strength-status"></span>  
    @error('password')
    <span id="password_error" class="text-danger">{{ $message }}</span>
@enderror
  </div>
  <div class="form-outline mb-4">
    <label class="form-label" for="confirmpassword">Confirm your password</label>
    <input type="password" id="confirmpassword" class="form-control" name="cpassword" />
  </div>
  @error('cpassword')
    <span class="text-danger">{{ $message }}</span>
@enderror
  <!-- Submit button -->
  <button type="submit" class="btn btn-primary btn-block mb-4" >Reset Password</button>

  <!-- Register buttons -->
  <div class="text-center">
    <p>Not a member? <a href="{{ route('register') }}">Register</a></p>
    
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
<script>
      $("#newpassword").on('keyup', function(){
        $('#password_error').hide();
        var number = /([0-9])/;
        var alphabets = /([a-zA-Z])/;
        var special_characters = /([@,!,$,#,%])/;
        if ($(this).val().length < 6) {
        // $('#password-strength-status').addClass('weak-password');
        $('#password-strength-status').html("Weak (should be atleast 6 characters.)");
    } else {
        if ($(this).val().match(number) && $(this).val().match(alphabets) && $(this).val().match(special_characters)) {
          $('#password-strength-status').html("");
        } else {
            $('#password-strength-status').html("Password should include alphabets, numbers and special characters.e.g:Stream@123");
         
          }
    
    }
      });
    </script>
  
@endsection

