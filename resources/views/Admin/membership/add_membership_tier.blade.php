@extends('admin_layout.master')
@section('content')
<section class="content">
<div class="card card-primary">
    <div class="card-header">
    <h3 class="card-title"><strong>Add Membership Tier</strong></h3>
    </div>
    <!-- /.card-header -->
    <!-- form start -->
    <form action="{{ url('/admin/insert-membership-tier') }}" method="POST" class="form-horizontal">
        @csrf
        <div class="row">
            <div class="card-body col-md-6">
                <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-3 col-form-label">Name</label>
                    <div class="col-sm-9">
                        <input type="name" class="form-control" id="inputEmail3" placeholder="Name" name="name">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-3 col-form-label">Price</label>
                    <div class="col-sm-9">
                        <input type="number" step="0.01" class="form-control" id="inputEmail3" placeholder="USD($)" name="price">
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
                    <label for="inputEmail3" class="col-sm-3 col-form-label">Recurring Nature</label>
                    <div class="col-sm-9">
                        <select id="" class="form-control" id="inputEmail3" name="recurring_nature">
                            <option value="weekly">Weekly</option>
                            <option value="monthly">Monthly</option>
                            <option value="6-month">6 Months</option>
                            <option value="9-month">9 Months</option>
                            <option value="1-year">Yearly</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-3 col-form-label">Description</label>
                    <div class="col-sm-9">
                        <textarea name="description" class="form-control" id="inputEmail3" id="" cols="10" rows="3"></textarea>
                    </div>
                </div>
            </div>
            <div class="card-body col-md-4">
                <div class="form-group row">
                    <div class="col-sm-8">
                        <input type="file" class="form-control" id="inputEmail3" name="card_logo" />
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Add membership tier</button>
        </div>
    </form>
</div>
</section>
@endsection