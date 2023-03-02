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
            <h1 class="m-0">General Settings</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href=" {{ url('/'.auth()->user()->unique_id) }} ">Home</a></li>
              <li class="breadcrumb-item active">General settings</li>
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
                            <img src="{{ auth()->user()->profile_image_url }}" alt="{{ auth()->user()->profile_image_name }}" width="100px" height="100px" style="border-radius:50%;">
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
                                  <h4 class="modal-title">Want to change profile ?</h4>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                <input type="file" name="profile_img" />
                                </div>
                                <div class="modal-footer justify-content-between">
                                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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
                      <form action="{{ url(auth()->user()->unique_id.'/add-user-meta') }}" method="POST"  enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" value="{{ auth()->user()->id }}">
                        <div class="form-group row">
                          <label for="inputEmail3" class="col-sm-3 col-form-label">First Name</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" id="inputEmail3" name="first_name" placeholder="first name" value="{{ isset(auth()->user()->first_name)?auth()->user()->first_name:''; }}">
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="inputEmail3" class="col-sm-3 col-form-label">Last Name</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" id="inputEmail3" name="last_name" placeholder="last name" value="{{ isset(auth()->user()->last_name)?auth()->user()->last_name:''; }}">
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="inputEmail3" class="col-sm-3 col-form-label">Phone</label>
                          <div class="col-sm-9">
                            <input type="number" class="form-control" id="inputEmail3" name="phone" placeholder="phone" value="{{ isset(auth()->user()->phone)?auth()->user()->phone:''; }}">
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="inputEmail3" class="col-sm-3 col-form-label">Email</label>
                          <div class="col-sm-9">
                            <input type="email" class="form-control" id="inputEmail3" name="email" placeholder="Email" value="{{ isset(auth()->user()->email)?auth()->user()->email:''; }}">
                          </div>
                        </div>
                        <!-- hide profile -->
                        <div class="form-group row">
                          <label for="inputEmail3" class="col-sm-3 col-form-label">Hide profile</label>
                          <div class="col-sm-9">
                            <div class="custom-control custom-switch">
                              <input type="checkbox" class="custom-control-input" id="customSwitches" name="hide_profile" @if(auth()->user()->public_visibility == 1){{ " " }}@else{{ "checked" }}@endif  />
                              <label class="custom-control-label" for="customSwitches">By enable it you will make your profile private and it will not visible to public.</label>
                            </div>
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
  </script>
@endsection