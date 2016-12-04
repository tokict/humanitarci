@extends('layouts.full')

@section('content')
        <!-- About Section -->
<section class="page-section" id="about">
    <div class="container relative">

        <div class="section-text mb-60 mb-sm-40">
            <div class="row">
                @if (session('success'))
                    <h3 class="text-success text-center">{{ session('success') }}</h3>
                @endif
                <div class="col-sm-6 mb-sm-50 mb-xs-30">

                    <h4 class="mt-0 font-alt">{{$donor->user->username}}</h4>

                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. In maximus ligula semper metus
                        pellentesque mattis. Maecenas volutpat, diam enim sagittis quam.
                    </p>
                    <p>
                        Etiam sit amet fringilla lacus. Pellentesque suscipit ante at ullamcorper pulvinar neque
                        porttitor. Integer lectus. Praesent sed nisi eleifend, fermentum orci amet, iaculis libero.
                    </p>
                </div>

                <div class="col-sm-6 mb-sm-50 mb-xs-30">
                    <!-- Bar Item -->
                    <div class="progress tpl-progress">
                        <div class="progress-bar" role="progressbar" aria-valuenow="90" aria-valuemin="0"
                             aria-valuemax="100">
                            Raznovrsnost <span>90</span>
                            <br/>
                            <small>(Donacije namjenjene raznim tipovima akcija)</small>
                        </div>
                    </div>
                    <!-- End Bar Item -->

                    <!-- Bar Item -->
                    <div class="progress tpl-progress">
                        <div class="progress-bar" role="progressbar" aria-valuenow="80" aria-valuemin="0"
                             aria-valuemax="100">
                            Ustrajnost <span>80</span>
                            </br>
                            <small>(Automatske mjesečne donacije)</small>
                        </div>
                    </div>
                    <!-- End Bar Item -->

                    <!-- Bar Item -->
                    <div class="progress tpl-progress">
                        <div class="progress-bar" role="progressbar" aria-valuenow="85" aria-valuemin="0"
                             aria-valuemax="100">
                            Pravovremenost <span>85</span>
                            <br/>
                            <small>(Donacije hitnim kampanjama)</small>
                        </div>
                    </div>
                    <!-- End Bar Item -->

                    <!-- Bar Item -->
                    <div class="progress tpl-progress">
                        <div class="progress-bar" role="progressbar" aria-valuenow="75" aria-valuemin="0"
                             aria-valuemax="100">
                            Heroji dana <span>75</span>
                            </br>
                             <small>(Donacije koje su bile potrebne za zatvaranje akcija)</small>
                        </div>
                    </div>
                    <!-- End Bar Item -->

                </div>
            </div>
        </div>


        <!-- Counters -->
        <div class="count-wrapper mb-80 mb-sm-60">
            <div class="row">
                <!-- Counter Item -->
                <div class="col-xs-6 col-sm-3">
                    <div class="count-number">
                        {{number_format($donor->amount_donated /100, 2)}}
                    </div>
                    <div class="count-descr font-alt">
                        <i class="fa fa-dollar"></i>
                        <span class="count-title">Ukupno donirano {{env('CURRENCY')}}</span>
                    </div>
                </div>
                <!-- End Counter Item -->

                <!-- Counter Item -->
                <div class="col-xs-6 col-sm-3">
                    <div class="count-number">
                        {{count($donor->getCampaigns())}}
                    </div>
                    <div class="count-descr font-alt">
                        <i class="fa fa-heart"></i>
                        <span class="count-title">Broj akcija</span>
                    </div>
                </div>
                <!-- End Counter Item -->
                <!-- Counter Item -->
                <div class="col-xs-6 col-sm-3">
                    <div class="count-number">
                        {{count($donor->getBeneficiaries())}}
                    </div>
                    <div class="count-descr font-alt">
                        <i class="fa fa-users"></i>
                        <span class="count-title">Broj korisnika</span>
                    </div>
                </div>
                <!-- End Counter Item -->

                <!-- Counter Item -->
                <div class="col-xs-6 col-sm-3">
                    <div class="count-number">
                        {{count($donor->getRecurringDonationsSum())}}
                    </div>
                    <div class="count-descr font-alt">
                        <i class="fa fa-refresh"></i>
                        <span class="count-title">Iznos automatskih donacija</span>
                    </div>
                </div>
                <!-- End Counter Item -->

            </div>
        </div>
        <!-- End Counters -->


        <!-- Team -->
        <div class="row multi-columns-row">

            @foreach($donor->getCampaigns() as $c)
                    <!-- Team Item -->
            <div class="col-sm-6 col-md-3 col-lg-3 mb-sm-30 wow fadeInUp">
                <div class="team-item">

                    <div class="team-item-image">

                        <img src="{{$c->cover->getPath('small')}}" alt=""/>

                        <div class="team-item-detail">

                            <h4 class="font-alt normal">{{$c->beneficiary->name}}</h4>

                            <p>
                                {{$c->description_short}}
                            </p>

                            <div class="team-social-links">
                                <a href="#" target="_blank"><i class="fa fa-facebook"></i></a>
                                <a href="#" target="_blank"><i class="fa fa-twitter"></i></a>
                                <a href="#" target="_blank"><i class="fa fa-pinterest"></i></a>
                            </div>

                        </div>
                    </div>

                    <div class="team-item-descr font-alt">

                        <div class="team-item-name">
                            <a href="/{{trans('routes.front.campaigns')}}/{{trans('routes.actions.view')}}/{{$c->id}}">{{$c->name}}</a>
                        </div>

                        <div class="team-item-role">
                            Put total donated amount for this campaign
                        </div>

                    </div>

                </div>
            </div>
            <!-- End Team Item -->
            @endforeach


        </div>
        <!-- End Team -->


    </div>
</section>
<!-- End About Section -->


<!-- Logotypes Section -->
<section class="small-section pt-20 pb-20">
    <div class="container relative">

        <div class="row">
            <div class="col-md-10 col-md-offset-1">

                <div class="small-item-carousel black owl-carousel mb-0 animate-init"
                     data-anim-type="fade-in-right-large" data-anim-delay="100">

                    <!-- Logo Item -->
                    <div class="logo-item">
                        <img src="images/clients-logos/client-1.png" width="67" height="67" alt=""/>
                    </div>
                    <!-- End Logo Item -->

                    <!-- Logo Item -->
                    <div class="logo-item">
                        <img src="images/clients-logos/client-2.png" width="67" height="67" alt=""/>
                    </div>
                    <!-- End Logo Item -->

                    <!-- Logo Item -->
                    <div class="logo-item">
                        <img src="images/clients-logos/client-3.png" width="67" height="67" alt=""/>
                    </div>
                    <!-- End Logo Item -->

                    <!-- Logo Item -->
                    <div class="logo-item">
                        <img src="images/clients-logos/client-4.png" width="67" height="67" alt=""/>
                    </div>
                    <!-- End Logo Item -->

                    <!-- Logo Item -->
                    <div class="logo-item">
                        <img src="images/clients-logos/client-5.png" width="67" height="67" alt=""/>
                    </div>
                    <!-- End Logo Item -->

                    <!-- Logo Item -->
                    <div class="logo-item">
                        <img src="images/clients-logos/client-6.png" width="67" height="67" alt=""/>
                    </div>
                    <!-- End Logo Item -->

                    <!-- Logo Item -->
                    <div class="logo-item">
                        <img src="images/clients-logos/client-1.png" width="67" height="67" alt=""/>
                    </div>
                    <!-- End Logo Item -->

                    <!-- Logo Item -->
                    <div class="logo-item">
                        <img src="images/clients-logos/client-2.png" width="67" height="67" alt=""/>
                    </div>
                    <!-- End Logo Item -->

                </div>

            </div>
        </div>

    </div>
</section>
<!-- End Logotypes -->


<!-- Divider -->
<hr class="mt-0 mb-0 "/>
<!-- End Divider -->


<!-- Call Action Section -->
@if(!isset(\Illuminate\Support\Facades\Auth::User()->donor))
<section class="small-section bg-dark">
    <div class="container relative">

        <div class="align-center">
            <h3 class="banner-heading font-alt">Postani i ti donor!</h3>
            <div>
                <a href="/{{trans('routes.front.donors')}}/{{trans('routes.actions.registration')}}" class="btn btn-mod btn-w btn-medium btn-round">Registriraj se</a>
            </div>
        </div>

    </div>
</section>
@endif
<!-- End Call Action Section -->
@endsection
