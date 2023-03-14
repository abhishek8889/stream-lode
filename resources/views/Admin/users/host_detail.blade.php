@extends('admin_layout.master')
@section('content')
<section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Profile</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">User Profile</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-3">

            <!-- Profile Image -->
            <div class="card card-primary card-outline">
              <div class="card-body box-profile">
                <div class="text-center">
                    @if(isset($host_detail['profile_image_url']) || !empty($host_detail['profile_image_url']))
                        <img class="profile-user-img img-fluid img-circle" src="{{ $host_detail['profile_image_url'] }}" alt="{{ $host_detail['profile_image_name'] }}">
                    @else
                        <img class="profile-user-img img-fluid img-circle" src="{{ asset('Assets/images/default-avatar.jpg') }}" alt="default image">
                    @endif
                </div>
                @if(!empty($host_detail['first_name']) || !empty($host_detail['last_name']))
                <h3 class="profile-username text-center">{{ $host_detail['first_name']. ' ' .$host_detail['last_name'] }}</h3>
                @endif
                <!-- profile occupation -->
                <p class="text-muted text-center">Software Engineer</p>

                <!-- <ul class="list-group list-group-unbordered mb-3">
                  <li class="list-group-item">
                    <b>Followers</b> <a class="float-right">1,322</a>
                  </li>
                  <li class="list-group-item">
                    <b>Following</b> <a class="float-right">543</a>
                  </li>
                  <li class="list-group-item">
                    <b>Friends</b> <a class="float-right">13,287</a>
                  </li>
                </ul> -->

                <a href="#" class="btn btn-primary btn-block"  data-toggle="modal" data-target="#exampleModal"><b>Change Image</b></a>

              </div>
              <!-- /.card-body -->
            </div>
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <form action="{{ url('').'/'.$host_detail['unique_id'].'/add-profile-picture' }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div>
                            <input type="hidden" name="id" value="{{ $host_detail['id'] }}">
                            @if($host_detail['profile_image_name'])
                            <input type="hidden" name="profile_exist" value="1">
                            @endif
                            <input type="file" name="profile_img">
                          </div>
                          <div  class="mt-1">
                          <button class="btn" >Upload</button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
            </div>
            <!-- /.card -->

            <!-- About Me Box -->
            <div class="card card-primary">
              <div class="card-header">
                @if(!empty($host_detail['first_name']))
                <h3 class="card-title">About <b> {{  $host_detail['first_name']  }}</b></h3>
                @endif
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <strong><i class="fas fa-book mr-1"></i> Education</strong>

                <p class="text-muted">
                  B.S. in Computer Science from the University of Tennessee at Knoxville
                </p>

                <hr>

                <strong><i class="fas fa-map-marker-alt mr-1"></i> Location</strong>

                <p class="text-muted">Malibu, California</p>

                <hr>

                <strong><i class="fas fa-pencil-alt mr-1"></i> Skills</strong>

                <p class="text-muted">
                  <span class="tag tag-danger">UI Design</span>
                  <span class="tag tag-success">Coding</span>
                  <span class="tag tag-info">Javascript</span>
                  <span class="tag tag-warning">PHP</span>
                  <span class="tag tag-primary">Node.js</span>
                </p>

                <hr>

                <strong><i class="far fa-file-alt mr-1"></i> Notes</strong>

                <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam fermentum enim neque.</p>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
          <div class="col-md-9">
            <div class="card">
              <div class="card-header p-2">
                <ul class="nav nav-pills">
                  <!-- <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">Activity</a></li>
                  <li class="nav-item"><a class="nav-link" href="#timeline" data-toggle="tab">Timeline</a></li> -->
                  <li class="nav-item"><a class="nav-link active" href="#settings" data-toggle="tab">Settings</a></li>
                  <li class="nav-item"><a class="nav-link" href="#timeline" data-toggle="tab">Message</a></li>
                </ul>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane active" id="settings">
                        <form action="{{ url('/admin/host-generals-update') }}" method="POST" class="form-horizontal">
                        @csrf  
                        <input type="hidden" value="{{ $host_detail['_id'] }} " name="id">
                        <input type="hidden" value="{{ $host_detail['unique_id'] }} " name="unique_id">
                          <div class="form-group row">
                              <label for="fname" class="col-sm-2 col-form-label">First Name</label>
                              <div class="col-sm-10">
                              <input type="text" class="form-control" id="fname" placeholder="First Name" name="first_name" value="{{ isset($host_detail['first_name'])?$host_detail['first_name']:''; }}" />
                              </div>
                          </div>
                          <div class="form-group row">
                              <label for="lname" class="col-sm-2 col-form-label">Last Name</label>
                              <div class="col-sm-10">
                              <input type="text" class="form-control" id="lname" placeholder="Last Name" name="last_name" value="{{ isset($host_detail['last_name'])?$host_detail['last_name']:''; }}" />
                              </div>
                          </div>
                          <div class="form-group row">
                              <label for="email" class="col-sm-2 col-form-label">Email</label>
                              <div class="col-sm-10">
                              <input type="email" class="form-control" id="email" placeholder="Email" name="email" value="{{ isset($host_detail['email'])?$host_detail['email']:''; }}" />
                              </div>
                          </div>
                          <div class="form-group row">
                              <label for="phone" class="col-sm-2 col-form-label">Phone</label>
                              <div class="col-sm-10">
                              <input type="text" class="form-control" id="phone" placeholder="Phone" name="phone" value="{{ isset($host_detail['phone'])?$host_detail['phone']:''; }}" />
                              </div>
                          </div>
                          <div class="form-group row">
                              <label for="facebook" class="col-sm-2 col-form-label">Facebook</label>
                              <div class="col-sm-10">
                              <input type="text" class="form-control" id="facebook" placeholder="facebook" name="facebook" value="{{ isset($host_detail['facebook'])?$host_detail['facebook']:''; }}" />
                              </div>
                          </div>
                          <div class="form-group row">
                              <label for="instagram" class="col-sm-2 col-form-label">Instagram</label>
                              <div class="col-sm-10">
                              <input type="text" class="form-control" id="instagram" placeholder="instagram" name="instagram" value="{{ isset($host_detail['instagram'])?$host_detail['instagram']:''; }}" />
                              </div>
                          </div>
                          <div class="form-group row">
                              <label for="linkdin" class="col-sm-2 col-form-label">Linkdin</label>
                              <div class="col-sm-10">
                              <input type="text" class="form-control" id="linkdin" placeholder="linkdin" name="linkdin" value="{{ isset($host_detail['linkdin'])?$host_detail['linkdin']:''; }}" />
                              </div>
                          </div>
                          <div class="form-group row">
                              <label for="twitter" class="col-sm-2 col-form-label">Twitter</label>
                              <div class="col-sm-10">
                              <input type="text" class="form-control" id="twitter" placeholder="twitter" name="twitter" value="{{ isset($host_detail['twitter'])?$host_detail['twitter']:''; }}" />
                              </div>
                          </div>
                          <div class="form-group row">
                              <label for="password" class="col-sm-2 col-form-label">New Password</label>
                              <div class="col-sm-10">
                              <input type="text" class="form-control" id="password" placeholder="New Password" name="newPassword" value="" />
                              <label for="password" class="text text-info">Enter text here only when you want to enter a new password</label>  
                            </div>
                          </div>
                          <div class="form-group row">
                              <label for="confirmPassword" class="col-sm-2 col-form-label">Confirm Password</label>
                              <div class="col-sm-10">
                              <input type="text" class="form-control" id="phone" placeholder="Confirm New Password" name="confirmNewPassword" value="" />
                              <label for="password" class="text text-info">Enter text here only when you want to enter a new password. This should match the text entered above.</label>  
                              </div>
                          </div>
                          <div class="form-group row">
                              <label for="hide_profile" class="col-sm-2 col-form-label">Hide Profile</label>
                              <div class="col-sm-10">
                                  <div class="custom-control custom-switch">
                                  @if($host_detail['public_visibility'] == 1)
                                  <input type="checkbox" class="custom-control-input" id="customSwitches" name="hide_profile">
                                  @else
                                  <input type="checkbox" class="custom-control-input" id="customSwitches" name="hide_profile" checked>
                                  @endif
                                  <label class="custom-control-label" for="customSwitches">By enable it you will make host's profile private and it will not visible to public.</label>
                                  </div>
                              </div>
                          </div>
                          <div class="form-group row">
                            <label for="description" class="col-sm-2 col-form-label">Description</label>
                            <div class="card-body col-sm-10">
                              <textarea class="summernote" name="hostDescription">{{ isset($host_detail['description'])?$host_detail['description']:''; }}</textarea>
                            </div>
                          </div>
                          <div class="form-group row">
                              <div class="offset-sm-2 col-sm-10">
                              <button type="submit" class="btn btn-danger">Update host information</button>
                              </div>
                          </div>
                        </form>
                    </div>
                    <div class="tab-pane" id="timeline">
                   
                    <div class="card direct-chat direct-chat-primary">
             
              <div class="card-body">
                <!-- Conversations are loaded here -->
                <div class="direct-chat-messages" style="display: flex; flex-direction: column-reverse;">
                  <div class="direct-chat-msg">
                    @foreach($message as $m)
                    <div class="direct-chat-text mt-1" style="margin: 0 0 0 0;">
                    {{ $m['message'] }}
                    </div>
                    @endforeach
                  </div>
                </div>
               
              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                <form id="message" action="{{ url('admin/message') }}" method="post">
                  @csrf
                  <div class="input-group">
                    <input type="hidden" name="reciever_id" value="{{ $host_detail['_id'] ?? '' }}">
                    <input type="hidden" name="sender_id" value="{{ Auth() ->user()->id ?? '' }}">
                    <input type="text" id ="messageinput" name="message" placeholder="Type Message ..." class="form-control">
                    <span class="input-group-append">
                      <button class="btn btn-primary">Send</button>
                    </span>
                  </div>
                </form>
              </div>
              <!-- /.card-footer-->
            </div>
                </div>


                    </div>
                  </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <script type="text/javascript">
    $(document).ready(function() {
    $('.summernote').summernote();
    });

    $(document).ready(function(){
      $('#message').on('submit',function(e){
        e.preventDefault();
        formdata = new FormData(this);
        $.ajax({
          method: 'post',
                    url: '{{url('/admin/message')}}',
                    data: formdata,
                    dataType: 'json',
                    contentType: false,
                    processData: false,
                    success: function(response)
                    {
                      console.log(response);
                      $('#messageinput').val('');
                      $(".direct-chat-messages").load(location.href + " .direct-chat-messages");
                    }
        });
      });
    });


  </script>
@endsection