@extends('admin_layout.master')
@section('content')
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
           
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <!-- <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard v1</li> -->
              {{ Breadcrumbs::render('admin-changepassword') }}
            </ol> 
          </div>
        </div>
      </div>
    </div>
<div class="container-fluid">
            <div class="card card-info" style="min-height:500px;">
              <div class="card-header">
                <h3 class="card-title"><b>Change Password</b></h3>
              </div>
                <div class="card-body">
                  <div class="col-md-6">
                    <!-- form  -->
                    <div class="userform">
                      <form action="{{ url('admin/update-password') }}" method="POST">
                        @csrf                    
                        <div class="form-group row">
                          <label for="current-password" class="col-sm-5 col-form-label">Current Password</label>
                          <div class="col-sm-10">
                            <input type="password" class="form-control" id="current-password" name="current_password" placeholder="Your current password">
                          </div>
                          @error('current_password')
                            <div class="text text-danger">{{ $message }}</div>
                          @enderror
                        </div>
                        <div class="form-group row">
                          <label for="new-password" class="col-sm-5 col-form-label">New Password</label>
                          <div class="col-sm-10">
                            <input type="password" class="form-control" id="new-password" name="new_password" placeholder="Your new password">
                          </div>
                          @error('new_password')
                            <div class="text text-danger">{{ $message }}</div>
                          @enderror
                        </div>
                        <div class="form-group row">
                          <label for="confirm-new-password" class="col-sm-5 col-form-label">Confirm new Password</label>
                          <div class="col-sm-10">
                            <input type="password" class="form-control" id="confirm-new-password" name="confirm_new_password" placeholder="Confirm your new password">
                          </div>
                          @error('confirm_new_password')
                            <div class="text text-danger">{{ $message }}</div>
                          @enderror
                        </div>
                        <div class="form-group row">
                          <div class="col-sm-10">
                          <button class="btn btn-info">Change Password</button>
                          </div>
                        </div>
                   </div>
                  </div>
                </div>
                <div class="card-footer">
                  
                </div> 
            </form>
              
            </div>
      </div>
@endsection