@extends('host_layout.master')
@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert"></script>
<style>
  .custom-switch {
    padding-left: 2.25rem;
    padding-top: 6px;
}

.loader {
    position: absolute;
    width: 100%;
    height: 100%;
    background: #00000014;
    z-index: 99;
    display:none; 
    background-image: url('https://i.gifer.com/ZZ5H.gif');
    background-repeat: no-repeat;
    background-position: center 25%;
    background-size: 80px;
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
            {{ Breadcrumbs::render('tags') }}
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
                    <div class="col-md-8" >
                        <!-- form  -->
                        <div class="userform">
                            <form action="{{ url(auth()->user()->unique_id.'/add-tags') }}" method="POST"  enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="id" value="{{ auth()->user()->id }}">
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-2 col-form-label">Tag Name</label>
                                    <div class="col-sm-7 d-flex flex-row">
                                        <input type="text" class="form-control" id="inputEmail3" name="tag_name" placeholder="Tag name" >
                                        <button type="submit" class="btn btn-info ml-3">Generate</button>
                                    </div>
                                    @error('tag_name')
                                    <div class="text text-danger">{{ $message }}</div>
                                    @enderror
                                  
                                </div>
                            </form>
                        </div>
                    </div>
                    @if(!empty($tags))
                    <div class="row">
                      <div class="loader"></div>
                        @foreach($tags as $tag)
                            <div class="col-md-3 d-flex flex-row p-3 tags-list" disabled>
                                <input class="form-control tag-input" type="text" value="{{ $tag['name'] }}" tag_id="{{ $tag['_id'] }}"  disabled>
                                <span class="btn edit-tag"> <i class="fa fa-edit"></i> </span>
                                <span class="btn dlt-tag" tag_id="{{ $tag['_id'] }}"> <i class="fa fa-trash"></i> </span>

                            </div>
                        @endforeach
                    </div>
                    @endif
                </div>
             
                
            </div>
      </div>
    </section>
    <script>
    $(document).ready(function(){
      $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
      });
      $(".edit-tag").on('click',function(){
        var input_box = $(this).prev();
        input_box.removeAttr('disabled');
        input_box.focus();
       
        $(".tag-input").on('blur',function(){
          $('.loader').show();
          $.ajax({
            type: 'POST',
            url: "{{ url('/'.auth()->user()->unique_id.'/edit-tags') }}",
            data: { 
              'tag_id' : input_box.attr('tag_id'),
              'tag_name' : input_box.val(),
            },
            success: function(response){
              $('.loader').hide();
            swal({
                  title: "Tag is edited succesfully.",
                  text: "Tag is edited succesfully",
                  icon: "success",
                  button: "Go back.",
              });
            }
            }); 
          input_box.prop('disabled', true);
        });

      });
      $(".dlt-tag").on('click',function(){
        var parent = $(this).parent();
        var tag_id = $(this).attr('tag_id');
        $.ajax({
            type: 'POST',
            url: "{{ url('/'.auth()->user()->unique_id.'/delete-tags') }}",
            data: { 
              'tag_id' : tag_id,
            },
            success: function(response){
              $('.loader').hide();
              swal({
                    title: "Tag is deleted succesfully.",
                    text: "Tag is deleted succesfully",
                    icon: "success",
                    button: "Go back.",
                }).then((value) => {
                  parent.remove();
                  });
                
            }
            }); 
      });
    });
    </script>
@endsection