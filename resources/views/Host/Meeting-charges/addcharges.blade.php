@extends('host_layout.master')
@section('content')
<div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Add Meeting Charges</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            {{ Breadcrumbs::render('meeting-charges-add') }}
            </ol>
          </div>
        </div>
      </div>
</div>
<div class="container col-12">
      <div class="card card-info ">
              <div class="card-header">
                <h3 class="card-title">Horizontal Form</h3>
              </div>
              <form action="{{ route('meeting-add',['id' => Auth()->user()->unique_id]) }}" method="POST" class="form-horizontal">
                @csrf
                <div class="card-body col-6">
                  <div class="form-group row">
                    <label for="duration" class="col-sm-2 col-form-label">Duration In Minutes</label>
                    <div class="col-sm-10">
                      <input type="number" class="form-control" id="duration" name="duration" placeholder="Duration" value="{{ $meetingcharges['duration_in_minutes'] ?? '' }}">
                    </div>
                    @error('duration')
                            <div class="text text-danger">{{ $message }}</div>
                    @enderror
                  </div>
                  <div class="form-group row">
                    <label for="duration" class="col-sm-2 col-form-label">Currency</label>
                    <div class="col-sm-10">
                      <select class="form-control" name="currency" id="">
                        <option value="usd">USD</option>
                      </select>
                    </div>
                    @error('duration')
                            <div class="text text-danger">{{ $message }}</div>
                    @enderror
                  </div>
                  <div class="form-group row">
                    <label for="payment" class="col-sm-2 col-form-label">Amount</label>
                    <div class="col-sm-10">
                      <input type="number" class="form-control" id="payment" name="payment" placeholder="Payment" value="{{ $meetingcharges['amount'] ?? '' }}">
                    </div>
                    @error('payment')
                            <div class="text text-danger">{{ $message }}</div>
                    @enderror
                  </div>
                <div class="card-footer">
                  <button type="submit" class="btn btn-info">Save</button>
                  @if($meetingcharges)
                  <a class="btn btn-success" href="{{ url(Auth()->user()->unique_id.'/meeting-charges/add') }}">Add New</a>
                  @endif
                </div>
                <!-- /.card-footer -->
              </form>
            </div>
      </div>
</div>
<script>
    $(document).ready(function(){
        $('#duration').change(function(){
          duration = parseInt($(this).val());
          if(duration < 30){
            $('#duration').val('30');
          }
        });
    })
</script>
@endsection