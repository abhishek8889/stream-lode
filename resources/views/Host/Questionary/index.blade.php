@extends('host_layout.master')
@section('content')

<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0"> </h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            {{ Breadcrumbs::render('questionnaire') }}
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>

<section class="content">
      <div class="container">
        <!-- SELECT2 EXAMPLE -->
        <div class="card card-default">
          <div class="card-header">
            <h3 class="card-title">Guest Questions</h3>

            <div class="card-tools">
              <a href="{{ url('/'.Auth()->user()->unique_id.'/addquestionnaire') }}">
              <button type="button" class="btn btn-tool" id="add-qustion" >
                <i class="fas fa-plus"></i>
              </button></a>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                 <table class="table table-bordered w-100 text-center">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th class="w-50">Questions</th>
                            <th>Answer-Type</th>
                            <th>Values</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class="questions">
                       <?php $count = 0; ?>
                        @foreach($question_data as $qd)
                       <?php $count++ ?>

                        <tr>
                            <td>{{ $count }}</td>
                           
                                <input type="hidden" value="{{ $qd->id }}" name="id">
                            <td><input type="text" name="question" class="form-control " id="question{{ $qd->id }}" value="{{ $qd->question }}" disabled></td>
                            <td>
                                {{ $qd->answer_type ?? '' }}
                            </td>
                            @if($qd->checkboxname !== null)
                            <?php $data = implode(",",$qd->checkboxname);
                             ?>
                             @endif
                             
                            <td>@if($qd->answer_type == 'input') - @else  {{ $data ?? '' }}@endif</td>
                            
                            <td><a href="{{ url('/'.Auth()->user()->unique_id.'/addquestionnaire/'.$qd->id) }}" class="edit" data-id="{{ $qd->id }}"><i class="far fa-edit"></i></a>
                            <a class="delete ml-2" data-id = "{{ $qd->id }}" id ="delete{{$qd->id}}" style="cursor: pointer;"><i class="fas fa-trash-alt"></i> </a></td>
                    
                        </tr>
                        @endforeach
                    </tbody>
                 </table>
                 {{ $question_data->links() }}
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
   <script>
       
        $('.delete').click(function(){
            id = $(this).attr('data-id');
            Swal.fire({
                      title: 'Are you sure to delete this question?',
                      showCancelButton: true,
                      confirmButtonText: 'yes',
                      confirmButtonColor: '#008000',
                      cancelButtonText: 'no',
                      cancelButtonColor: '#d33',

                    }).then((result) => {
                      if (result.isConfirmed) {
                          $.ajax({
                          method: 'post',
                          url: '{{ url('/'.Auth()->user()->unique_id.'/questionnaire/delete') }}',
                          data: { id:id ,_token:'{{ csrf_token() }}'},
                          dataType: 'json',
                          success: function(response){ 
                            Swal.fire({
                                    title: "Success!",
                                    text: "Successfully deleted question",
                                    icon: "success",
                                    button: "done",
                                }).then((result) => {
                      location.reload();
                  });
                     
             }
            });
          }
            
          });
        });
    </script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@endsection