@extends('host_layout.master')
@section('content')
<!-- Where all list of subscription while we hit to upgrade membership -->
<div class="container">
    <div class="row">
        @if(isset($membership_details) || !empty($membership_details))
        @foreach($membership_details as $m)
        <div class="col-md-3">
            <!-- Widget: user widget style 1 -->
            <div class="card card-widget widget-user">
                <!-- Add the bg color to the header using any of the bg-* classes -->
                <div class="widget-user-header bg-info">
                    @if(!empty($m['name']))
                    <h2 class="widget-user-username"><b>{{ $m['name'] }} </b></h2>
                    @endif
                </div>
                <div class="widget-user-image">
                    @if(!empty($m['logo_url']))
                    <img class="" src="{{ $m['logo_url'] }}" alt="{{ $m['logo_name'] }}">
                    @endif
                </div>
                <div class="card-footer">
                    @if(!empty($m['description']))
                    <div class="description">
                      {{ $m['description'] }}
                    </div>
                    @endif
                    <div class="price text-center">
                        <h3><b>${{ $m['amount'] }}</b></h3>
                        <!-- <form action="{{ url(auth()->user()->unique_id.'/subscribe')}}" method="POST">
                            @csrf
                            <input type="hidden" name="plan" value="{{ $m }}">
                            <button type="submit">Subscribe</button>
                        </form> -->
                        <a href="{{ url(auth()->user()->unique_id.'/upgrade-subscription/'.$m['slug']) }}" class="btn btn-primary">Upgrade Subscription</a>
                    </div>
                </div>
            </div>
            <!-- /.widget-user -->
        </div>
        @endforeach
        @endif
    </div>
</div>
@endsection