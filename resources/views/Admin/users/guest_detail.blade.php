@extends('admin_layout.master')
@section('content')
<div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane active" id="settings">
                        <form action="{{ route('guest-generals-update') }}" method="POST" class="form-horizontal">
                        @csrf  
                        <input type="hidden" value="{{ $guest_detail['id'] ?? '' }}" name="id">
                          <div class="form-group row">
                              <label for="fname" class="col-sm-2 col-form-label">First Name</label>
                              <div class="col-sm-10">
                              <input type="text" class="form-control" id="fname" placeholder="First Name" name="first_name" value="{{ isset($guest_detail['first_name'])?$guest_detail['first_name']:''; }}" />
                              </div>
                          </div>
                          <div class="form-group row">
                              <label for="lname" class="col-sm-2 col-form-label">Last Name</label>
                              <div class="col-sm-10">
                              <input type="text" class="form-control" id="lname" placeholder="Last Name" name="last_name" value="{{ isset($guest_detail['last_name'])?$guest_detail['last_name']:''; }}" />
                              </div>
                          </div>
                          <div class="form-group row">
                              <label for="email" class="col-sm-2 col-form-label">Email</label>
                              <div class="col-sm-10">
                              <input type="email" class="form-control" id="email" placeholder="Email" name="email" value="{{ isset($guest_detail['email'])?$guest_detail['email']:''; }}" />
                              </div>
                          </div>
                          <div class="form-group row">
                              <label for="password" class="col-sm-2 col-form-label">New Password</label>
                              <div class="col-sm-10">
                              <input type="password" class="form-control" id="password" placeholder="New Password" name="newPassword" />
                              <label for="password" class="text text-info">Enter text here only when you want to enter a new password</label>  
                            </div>
                          </div>
                          <div class="form-group row">
                              <label for="confirmPassword" class="col-sm-2 col-form-label">Confirm Password</label>
                              <div class="col-sm-10">
                              <input type="password" class="form-control" id="phone" placeholder="Confirm New Password" name="confirmNewPassword" />
                              @error('confirmNewPassword')
                              <div class="text text-danger">Password doesn't match</div>
                              @enderror
                              <label for="password" class="text text-info">Enter text here only when you want to enter a new password. This should match the text entered above.</label>  
                              
                            </div>
                          </div>
                          <div class="form-group row">
                              <div class="offset-sm-2 col-sm-10">
                              <button type="submit" class="btn btn-danger">Update guest information</button>
                              </div>
                          </div>
                        </form>
                    </div>
</div>
</div>
@endsection