<pre>
<?php 
// print_r($subscription_list);
?>
</pre>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css">
    <link rel="stylesheet" href="{{  asset('streamlode-front-assets/css/stylesheet.css') }}">
    <script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>




    <title>Streamlode</title>
  </head>
<body>
<section class="choose-plan-section">
  <div class="dark_navigation up">
    <div class="container-fluid">
      <div class="dark-nav">
        <ul class="nav-list" id="filter-list">
          <li class="nave-list-item" id="all"><a href="{{ url('') }}/{{ Auth::user()->unique_id.'/membership-details' }}">Go back</a></li>
          <li class="nave-list-item" id="all"><a href="#all" onclick="filterSelection('all')">All</a></li>
          <li class="nave-list-item" id="standar-tier"><a href="#standar-tier" onclick="filterSelection('Standard')">Standard Tier</a></li>
          <li class="nave-list-item" id="premium-tier"><a href="#premium-tier" onclick="filterSelection('Premium')">Premium Tier</a></li>
          <li class="nave-list-item" id="group-tier"><a href="#group-tier" onclick="filterSelection('Group')">Group Tier</a></li> 
        </ul>
      </div>
    </div>
  </div>
  <div class="plans-section">
    <div class="container-fluid">
      <div class="section-head text-center">
        <!-- <h2>Choose a plan to start with <span class="yellow">Stream</span><span class="blue">Lode</span></h2> -->
        <h2>Choose a plan to upgrade with <br> <span class="yellow">Stream</span><span class="blue">Lode</span></h2>
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
                        ${{ $subscription['amount'] }} <span class="period">/ {{ $subscription['interval'] }}</span>
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
                    <a href="{{ url(auth()->user()->unique_id.'/upgrade-subscription/'.$subscription['slug']) }}" class="cta cta-yellow">Upgrade Membership</a>
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

<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />
<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script> -->
<script src="{{ asset('streamlode-front-assets/js/custom.js') }}"></script>

</body>
</html>