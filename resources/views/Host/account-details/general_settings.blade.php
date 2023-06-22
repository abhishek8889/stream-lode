@extends('host_layout.master')
@section('content')
<style>
  .custom-switch {
    padding-left: 2.25rem;
    padding-top: 6px;
}
.note-codable{
  height: 900px;
}
</style>
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Generals settings</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            {{ Breadcrumbs::render('host-general-settings') }}
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
              <!-- /.card-header -->
              <!-- form start -->
                <div class="card-body">
                  <!-- <div class="btn btn-danger float-right">Membership Type</div> -->
                  <div class="col-md-10" >
                    <div class="form-group row">
                      <form action="{{ url(auth()->user()->unique_id.'/add-profile-picture') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div>
                          <input type="hidden"  value="{{ auth()->user()->id }}" name="id"/>
                          @if(auth()->user()->profile_image_name)
                            <input type="hidden" name="profile_exist" value="1">
                          @endif
                          <input type="hidden"  >
                          @if( auth()->user()->profile_image_url)
                            <img src="{{ asset('/Assets/images/user-profile-images/'.auth()->user()->profile_image_name) }}" alt="{{ auth()->user()->profile_image_name }}" width="100px" height="100px" style="border-radius:50%;">
                          @else
                            <img src="{{ asset('Assets/images/default-avatar.jpg') }}" alt="" width="100px" height="100px" style="border-radius:50%;">
                            @endif
                          <button type="button" class="btn btn-info ml-2" data-toggle="modal" data-target="#modal-default">
                            Profile Picture
                          </button>
                          <div class="modal fade" id="modal-default" style="display: none;" aria-hidden="true">
                            <div class="modal-dialog">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h4 class="modal-title">Do you want to change your profile picture?</h4>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                <input type="file" name="profile_img" />
                                </div>
                                <div class="modal-footer justify-content-between">
                                  <!-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> -->
                                  <button type="submit" class="btn btn-primary">Upload Profile</button>
                                </div>
                              </div>
                              <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                          </div>
                        </div>
                      </form>
                    </div>
                    @error('profile_img')
                      <div class="text text-danger p-3">{{ $message }}</div>
                    @enderror
                    <!-- form  -->
                    <div class="userform">
                      <form action="{{ url(auth()->user()->unique_id.'/add-user-meta') }}" method="POST" id="general_setting_form"  enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" value="{{ auth()->user()->id }}">
                        <div class="form-group row">
                          <label for="inputEmail3" class="col-sm-3 col-form-label">First Name</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" id="inputEmail3" name="first_name" placeholder="first name" value="{{ isset(auth()->user()->first_name)?auth()->user()->first_name:''; }}" maxlength ="50">
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="inputEmail3" class="col-sm-3 col-form-label">Last Name</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" id="inputEmail3" name="last_name" placeholder="last name" value="{{ isset(auth()->user()->last_name)?auth()->user()->last_name:''; }}" maxlength ="50">
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="inputEmail3" class="col-sm-3 col-form-label">Phone</label>
                          <div class="col-sm-9">
                            <input type="number" class="form-control" id="inputEmail3" name="phone" placeholder="phone" value="{{ isset(auth()->user()->phone)?auth()->user()->phone:''; }}">
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="email" class="col-sm-3 col-form-label">Email</label>
                          <div class="col-sm-9">
                            <input type="email" class="form-control" id="email" name="email" value="{{ isset(auth()->user()->email)?auth()->user()->email:''; }}" maxlength ="50">
                          <span class="text-danger" id="email_error">  </span>
                          </div>
                        </div>
                        <!-- hide profile -->
                        <div class="form-group row">
                          <label for="inputEmail3" class="col-sm-3 col-form-label">Hide profile</label>
                          <div class="col-sm-9">
                            <div class="custom-control custom-switch">
                              <input type="checkbox" class="custom-control-input" id="customSwitches" name="hide_profile" @if(auth()->user()->public_visibility == 1){{ " " }}@else{{ "checked" }}@endif  />
                              <label class="custom-control-label" for="customSwitches">When enabled,you will make your profile private, and it will not visible to the public.</label>
                            </div>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="Facebook" class="col-sm-3 col-form-label">Facebook link</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" id="Facebook" name="facebook" placeholder="Facebook" value="{{ Auth()->user()->facebook ?? '' }}" maxlength ="100">
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="twitter" class="col-sm-3 col-form-label">Twitter link</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" id="twitter" name="twitter" placeholder="Twitter" value="{{ Auth()->user()->twitter ?? '' }}" maxlength ="100">
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="linkdin" class="col-sm-3 col-form-label">linkedin link</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" id="linkdin" name="linkdin" placeholder="linkedin" value="{{ Auth()->user()->linkdin ?? '' }}" maxlength ="100">
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="instagram" class="col-sm-3 col-form-label">Instagram link</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" id="instagram" name="instagram" placeholder="Instagram" value="{{ Auth()->user()->instagram ?? '' }}" maxlength ="100">
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="description" class="col-sm-3 col-form-label">Description</label>
                          <div class="card-body col-sm-9">
                            <textarea class="summernote" name="hostDescription">{{ isset(auth()->user()->description)?auth()->user()->description:''; }}</textarea>
                          </div>
                        </div>
                    </div>
                  </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" class="btn btn-info">Update</button>
                  <!-- <button type="submit" class="btn btn-default float-right">Cancel</button> -->
                </div>
                <!-- /.card-footer -->
              </form>
            </div>
      </div>
    </section>
 
  <script type="text/javascript">
    $(document).ready(function() {
    $('.summernote').summernote();
    });

    $(document).ready(function(){
        $('#general_setting_form').on('submit',function(e){
          // e.preventDefault();
        
            email = $('#email').val();
         extension =  email.at(-4)+email.at(-3)+email.at(-2)+email.at(-1);
        
         if(extension == '.com'){
          return true;
          // $('#general_setting_form').submit();
          // console.log('done');
         }else{
          $('#email_error').html('your email format is not valid');
          return false;
          // console.log('errror');
         }
        });
    });
  </script>
@endsection