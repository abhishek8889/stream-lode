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


<section class="choose-plan-section">
  <div class="dark_navigation up">
    <div class="container-fluid">
      <div class="dark-nav">
        <ul class="nav-list" id="filter-list">
          <li class="nave-list-item" id="all"><a href="#all" onclick="filterSelection('all')">All</a></li>
          <li class="nave-list-item" id="standar-tier"><a href="#standar-tier" onclick="filterSelection('Standard')">Standard Tier</a></li>
          <li class="nave-list-item" id="premium-tier"><a href="#premium-tier" onclick="filterSelection('Premium')">Premium Tier</a></li>
          <li class="nave-list-item" id="group-tier"><a href="#group-tier" onclick="filterSelection('Group')">Group Tier</a></li> 
        </ul>
      </div>
    </div>
  </div>
  <div class="plans-section">
    <div class="container-fluid" id="membership-tiers">
      <div class="section-head text-center">
        <!-- <h2>Choose a plan to start with <span class="yellow">Stream</span><span class="blue">Lode</span></h2> -->
        <h2>Choose a plan to start with <br> <span class="yellow">Stream</span><span class="blue">Lode</span></h2>
      </div>
      <div class="plans-wrapper">
        <div class="row plans-row justify-content-center">
          <!-- <div class="col-lg-4 col-md-6 col-sm-6 plans-col filter_item Sponsorship_tire">
            <div class="pricing-box-wrapper">
              <div class="pricing-box">
                <div class="pricing-top">
                  <div class="pricing-header">
                    <h4>Sponsorship Tier</h4>
                    <h3 class="price">
                      $0.00 <span class="period">/ Month</span>
                    </h3>
                  </div>
                  <div class="pricing-body">
                    <ul class="access-list">
                      <li> 6% commission per stream + stripe fee 2.9%</li>
                      <li> $10 min charge per guest</li>
                      <li>  Email notification before meeting</li>
                      <li> Calender appointments - Outlook, Google maps, etc...</li>
                    </ul>
                  </div>
                </div>
                <div class="pricing-footer">
                  <p><b>For a Sponsorship Tier, email <a href="mailto:Sales@StreamLode.com">Sales@StreamLode.com</a> about being a StreamLode Sponsor.</b></p>
                </div>
              </div>
            </div>
          </div>

          <div class="col-lg-4 col-md-6 col-sm-6 plans-col filter_item Standard_tier">
            <div class="pricing-box-wrapper">
              <div class="pricing-box">
                <div class="pricing-top">
                  <div class="pricing-header">
                    <h4>Standard Tier</h4>
                    <h3 class="price">
                      $9.99 <span class="period">/ Month</span>
                    </h3>
                  </div>
                  <div class="pricing-body">
                    <ul class="access-list">
                      <li>10% commission per stream + stripe fee 2.9% </li>
                      <li>$10 min charge per guest</li>
                      <li>Chat window</li>
                      <li>Email notification before meeting</li>
                      <li>Calender appointments - Outlook, Google maps, etc...</li>
                    </ul>
                  </div>
                </div>
                <div class="pricing-footer">
                  <a href="" class="cta cta-yellow">Sign Up</a>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-6 col-sm-6 plans-col filter_item Premium_tier">
            <div class="pricing-box-wrapper">
              <div class="pricing-box">
                <div class="pricing-top">
                  <div class="pricing-header">
                    <h4>Premium Tier</h4>
                    <h3 class="price">
                      $19.99 <span class="period">/ Month</span>
                    </h3>
                  </div>
                  <div class="pricing-body">
                    <ul class="access-list">
                      <li> 6% commission per stream + stripe fee 2.9%</li>
                      <li> $10 min charge per guest</li>
                      <li>Chat window</li>
                      <li>Email notification before meeting</li>
                      <li>Calender appointments - Outlook, Google maps, etc...</li>
                    </ul>
                  </div>
                </div>
                <div class="pricing-footer">
                  <a href="" class="cta cta-yellow">Sign Up</a>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-6 col-sm-6 plans-col filter_item group_tier">
            <div class="pricing-box-wrapper">
              <div class="pricing-box">
                <div class="pricing-top">
                  <div class="pricing-header">
                    <h4>Standard group tier</h4>
                    <h3 class="price">
                      $49.99 <span class="period">/ Month</span>
                    </h3>
                  </div>
                  <div class="pricing-body">
                    <ul class="access-list">
                      <li>Up to 6 hosts for this group</li>
                      <li> 10% commission per stream + stripe fee 2.9%</li>
                      <li>  $10 min charge per guest</li>
                      <li>Chat window</li>
                      <li>Email notification before meeting</li>
                      <li>Calender appointments - Outlook, Google maps, etc...</li>
                    </ul>
                  </div>
                </div>
                <div class="pricing-footer">
                  <a href="" class="cta cta-yellow">Sign Up</a>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-4 col-md-6 col-sm-6 plans-col filter_item group_tier">
            <div class="pricing-box-wrapper">
              <div class="pricing-box">
                <div class="pricing-top">
                  <div class="pricing-header">
                    <h4>Premium Group Tier</h4>
                    <h3 class="price">
                      $59.99 <span class="period">/ Month</span>
                    </h3>
                  </div>
                  <div class="pricing-body">
                    <ul class="access-list">
                      <li>Up to 6 hosts for this group</li>
                      <li> 6% commission per stream + stripe fee 2.9%</li>
                      <li>  $10 min charge per guest</li>
                      <li>Chat window</li>
                      <li>Email notification before meeting</li>
                      <li>Calender appointments - Outlook, Google maps, etc...</li>
                    </ul>
                  </div>
                </div>
                <div class="pricing-footer">
                  <a href="" class="cta cta-yellow">Sign Up</a>
                </div>
              </div>
            </div>
          </div> -->

          
          @foreach($subscription_list as $subscription)
            <div class="col-lg-4 col-md-6 col-sm-6 plans-col filter_item {{ $subscription['name'] ?? '' }}">
              <div class="pricing-box-wrapper">
                <div class="pricing-box">
                  <div class="pricing-top">
                    <div class="pricing-header">
                      <h4>{{ $subscription['name'] }}</h4>
                      <h3 class="price">
                        ${{ number_format($subscription['amount'],2) }} <span class="period">/ {{ $subscription['interval'] }}</span> 
                      </h3>
                    </div>
                    <div class="pricing-body">
                      <ul class="access-list">
                        <?php 
                          // $features_list = json_decode($subscription['membership_features']); 
                        ?>
                      @if($subscription['membership_features']) 
                       @foreach($subscription['membership_features'] as $feature)
                      
                        @php
                        $data = App\Models\MembershipFeature::find($feature);
                        @endphp
                       
                        <?php 
                        if($data){ ?>
                        <li>
                          {{ $data['description'] ?? '' }}
                        </li>
                       <?php }
                        ?>
                       
                        @endforeach
                        @endif
                      </ul>
                    </div>
                  </div>
                  <div class="pricing-footer">
                    @if((int)$subscription['amount'] < 1)
                    <p><b>For a Sponsorship Tier, email <a href="mailto:Sales@StreamLode.com">Sales@StreamLode.com</a> about being a StreamLode Sponsor.</b></p>
                    @else
                    <a href="{{ url('/membership-payment/'.$subscription['slug']) }}" class="cta cta-yellow">Sign Up</a>
                    @endif
                  </div>
                </div>
              </div>
            </div>
          @endforeach
        
        </div>
      </div>
    </div>
  </div>
</section>

<section class="rolling-section">
  <div class="container-fluid">
    <div class="inner-section text-center">
    <div class="marquee">
      <div class="marquee--inner">
        <span class="marquee-span">
          <h2>We Have <span class="image"><img src="{{ asset('streamlode-front-assets/images/marque-image.png') }}"></span> <span class="blue"> Great</span> Hosts For You!</h2>
        </span>
      </div>
    </div>
  </div>
  </div>
</section>
<script>
  $('.nave-list-item').click(function(){
    $('.nave-list-item').removeClass('active');
    $(this).addClass('active');
  });
</script>
@endsection