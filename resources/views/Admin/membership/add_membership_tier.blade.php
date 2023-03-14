@extends('admin_layout.master')
@section('content')
<section class="content">
<div class="card card-primary">
    <div class="card-header">
    <h3 class="card-title"><strong>Add Membership Tier</strong></h3>
    </div>
    <!-- /.card-header -->
    <!-- form start -->
    <form action="{{ url('/admin/insert-membership-tier') }}" method="POST" enctype="multipart/form-data" class="form-horizontal">
        @csrf
        <div class="row">
            <div class="card-body col-md-6">
                <div class="form-group row">
                    <label for="name" class="col-sm-3 col-form-label">Name</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="name" placeholder="Name" name="name">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="slug" class="col-sm-3 col-form-label">Slug</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="slug" placeholder="Slug" name="slug">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-3 col-form-label">Price</label>
                    <div class="col-sm-9">
                        <input type="number" step="0.01" class="form-control" id="inputEmail3" placeholder="USD($)" name="price">
                    </div>
                </div>
                <!-- currency code -->
                <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-3 col-form-label">Currency code</label>
                    <div class="col-sm-9">
                        <select id="" class="form-control" id="inputEmail3" name="currency_code">
                            <option value="usd">USD</option>
                        </select>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-3 col-form-label">Membership Type</label>
                    <div class="col-sm-9">
                        <select id="" class="form-control" id="inputEmail3" name="membership_type">
                            <option value="recurring">Recurring</option>
                            <option value="one-time">one time</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-3 col-form-label">Interval</label>
                    <div class="col-sm-9">
                        <select id="" class="form-control" id="inputEmail3" name="interval_time">
                            <option value="month">Monthly</option>
                            <!-- <option value="6 months">6 Months</option>
                            <option value="9 months">9 Months</option>
                            <option value="yearly">Yearly</option> -->
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-3 col-form-label">Features</label>
                    <div class="col-sm-9" style="max-height: 161px; overflow: auto;">
                        <!-- <div class="btn btn-info" id="addFeatures"> Add features </div>
                        <div class="" id="featureBox"></div> -->
                 
                        @foreach($features as $f)
                    <div>
                        <input type="checkbox" name="membership_fetaures[]" id="feature{{ $f['id'] }}" value="{{ $f['id'] }}" multiple>
                        <label for="feature{{ $f['id'] }}">{{ $f['feature_name'] }} </label>
                        <button type="button" class="btn" data-toggle="popover" title="{{ $f['description'] }}" data-content="done" ><i class="fas fa-info-circle"></i></button>
                    </div>
                        @endforeach
                   
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-3 col-form-label">Description</label>
                    <div class="col-sm-9">
                        <textarea name="description" class="form-control" id="inputEmail3" id="" cols="10" rows="3"></textarea>
                    </div>
                </div>
            </div>
            <!-- <div class="card-body col-md-4">
                <div class="form-group row">
                    <div class="col-sm-8">
                        <input type="file" class="form-control" id="inputEmail3" name="card_logo" />
                    </div>
                </div>
            </div> -->
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Add membership tier</button>
        </div>
    </form>
</div>
</section>

<script>
    // $("#addFeatures").on('click',function(){
    //     newRowAdd =
    //         '<div id="row"> <div class="input-group mt-3">' +
    //         '<div class="input-group-prepend">' +
    //         '<button class="btn btn-secondary" id="DeleteRow" type="button">' +
    //         '<i class="fa-solid fa-xmark"></i> </button> </div>' +
    //         '<input type="text" class="form-control m-input" name="membership_fetaures[]" value=""> </div> </div>';
 
    //         $('#featureBox').append(newRowAdd);
    // });
    // $("body").on("click", "#DeleteRow", function () {
    //         $(this).parents("#row").remove();
    //     })
        $(document).ready(function(){
           $("#name").on('change',function(){
            let name = $(this).val().toLowerCase();
            let slug = name.replace(/ /g, "-");
            $("#slug").val(slug);
           });
            
        });
       
</script>
@endsection