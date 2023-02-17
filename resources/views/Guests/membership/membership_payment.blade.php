@extends('guest_layout.master')
@section('content')
<section class="top_banner inner_banner">
  <div class="container-fluid">
    <div class="inner-section">
      <div class="row banner-content">
        <div class="col-md-6 text_col">
          <div class="banner-heading">
            <h1>Select A <span class="blue">membership</span> level to meet your needs.</h1><span class="heading-pattern"><img src="{{ asset('streamlode-front-assets/images/star.png') }}"></span>
          </div>
          <div class="banner-text">
            <p>StreamLode can help you create an online platform that works for you, while being on a membership plan that meets your needs.</p><span class="text-pattern"><img src="{{ asset('streamlode-front-assets/images/text-star.png') }}"></span>
          </div>
        </div>
        <div class="col-md-6 media_col">
          <div class="banner-media">
            <img src=" {{ asset('streamlode-front-assets/images/membership-baner.png') }}" class="radius_top_50" />
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection