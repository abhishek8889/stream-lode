@extends('host_layout.master')
@section('content')
<style>
  .custom-switch {
    padding-left: 2.25rem;
    padding-top: 6px;
}
/* #password-strength-status {
                padding: 5px 10px;
                color: #FFFFFF;
                border-radius: 4px;
                margin-top: 5px;
            }

            .medium-password {
                background-color: #b7d60a;
                border: #BBB418 1px solid;
            }

            .weak-password {
                background-color: #ce1d14;
                border: #AA4502 1px solid;
            }

            .strong-password {
                background-color: #12CC1A;
                border: #0FA015 1px solid;
            } */
</style>
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">General Settings</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            {{ Breadcrumbs::render('change-password') }}
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
            <div class="card card-info">
              <div class="card-header">
                <h3 class="card-title"><b>User id : #{{ auth()->user()->unique_id }}</b></h3>
              </div>
                <div class="card-body">
                  <div class="col-md-6" >
                    <!-- form  -->
                    <div class="userform">
                      <form action="{{ url(auth()->user()->unique_id.'/update-password') }}" method="POST" >
                        @csrf
                        
                        <div class="form-group row">
                          <label for="current-password" class="col-sm-5 col-form-label">Current Password</label>
                          <div class="col-sm-10">
                            <input type="password" class="form-control" id="current-password" name="current_password" placeholder="Your current password" />
                          </div>
                          @error('current_password')
                            <div class="text text-danger">{{ $message }}</div>
                          @enderror
                        </div>
                        <div class="form-group row">
                          <label for="new-password" class="col-sm-5 col-form-label">New Password</label>
                          <div class="col-sm-10">
                            <input type="password" class="form-control" id="new-password" name="new_password" placeholder="Your new password" />
                          </div>
                          <span class="text-danger" id="password-strength-status"></span>     
                          @error('new_password')
                            <div id="error_password" class="text text-danger">{{ $message }}</div>
                          @enderror
                        </div>
                        <div class="form-group row">
                          <label for="confirm-new-password" class="col-sm-5 col-form-label">Confirm new Password</label>
                          <div class="col-sm-10">
                            <input type="password" class="form-control" id="confirm-new-password" name="confirm_new_password" placeholder="Confirm your new password" />
                          </div>
                          @error('confirm_new_password')
                            <div class="text text-danger">{{ $message }}</div>
                          @enderror
                        </div>
                    </div>
                  </div>
                </div>
                <div class="card-footer">
                  <button type="submit" id ="register_button" class="btn btn-info">Change Password</button>
                </div>
              </form>
            </div>
      </div>
    </section>
    <script>
      $("#new-password").on('keyup', function(){
        $('#error_password').hide();
        var number = /([0-9])/;
        var alphabets = /([a-zA-Z])/;
        var special_characters = /([@,!,$,#,%])/;
        if ($(this).val().length < 6) {
        $('#password-strength-status').removeClass();
        // $('#password-strength-status').addClass('weak-password');
        $('#password-strength-status').html("Weak (should be atleast 6 characters.)");
    } else {
        if ($(this).val().match(number) && $(this).val().match(alphabets) && $(this).val().match(special_characters)) {
          $('#password-strength-status').html("");
        } else {
            $('#password-strength-status').html("Medium (should include alphabets, numbers and special characters.e.g:Stream@123)");
         
          }
    
    }
      });
    </script>
@endsection