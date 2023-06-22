@extends('guest_layout.master')
@section('content')
<div style="margin-top:50px;">
<div class="col-lg-6 m-auto">
<form action="registerProc" method="POST">
  @csrf
  <!-- Email input -->
  <div class="form-outline mb-4">
    <input type="text" id="form2Example2" class="form-control" name="first_name"/>
    <label class="form-label" for="form2Example2" >First Name</label>
    @error('first_name')
    <div class="text text-danger">{{ $message }}</div>
    @enderror
  </div>
  <div class="form-outline mb-4">
    <input type="text" id="form2Example2" class="form-control" name="last_name"/>
    <label class="form-label" for="form2Example2" >Last Name</label>
    @error('last_name')
    <div class="text text-danger">{{ $message }}</div>
    @enderror
  </div>

  <div class="form-outline mb-4">
    <input type="email" id="form2Example1" class="form-control" name="email"/>
    <label class="form-label" for="form2Example1">Email address</label>
    @error('email')
    <div class="text text-danger">{{ $message }}</div>
    @enderror
  </div>

  <div class="form-outline mb-4">
    <input type="text" id="form2Example1" class="form-control" name="unique_id"/>
    <label class="form-label" for="form2Example1">Unique id</label>
    @error('unique_id')
    <div class="text text-danger">{{ $message }}</div>
    @enderror
  </div>

  <div class="form-outline mb-4">
    <input type="number" id="form2Example1" class="form-control" name="phone"/>
    <label class="form-label" for="form2Example1">phone</label>
    @error('phone')
    <div class="text text-danger">{{ $message }}</div>
    @enderror
  </div>

  <!-- Password input -->
  <div class="form-outline mb-4">
    <input type="password" id="form2Example2" class="form-control" name="password"/>
    <label class="form-label" for="form2Example2">Password</label>
    @error('password')
    <div class="text text-danger">{{ $message }}</div>
    @enderror
  </div>

  <!-- Submit button -->
  <button type="submit" class="btn btn-primary btn-block mb-4">Register</button>

</form>
</div>
</div>
@endsection