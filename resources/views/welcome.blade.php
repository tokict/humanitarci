@extends('layouts.full')

        @section('content')
    <!-- Slider -->
    <div class="container">
        <div class="fullwidth-slider bg-dark">

            <!-- Slide Item -->
            <div class="page-section bg-scroll bg-dark-alfa-30" data-background="/front/images/hero/djeca.jpg">

                <!-- Slide Content -->
                <div class="row">
                    <div class="col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-1 col-md-5 col-md-offset-1">

                        <div class="hs-line-8 no-transp font-alt mb-30 mb-xs-10">
                            O čemu se radi?
                        </div>

                        <h3 class="mb-40 mb-xs-30">
                            Sve je više ljudi kojima treba najnužnije - hrana, ogrjev, osnovne namirnice.
                        </h3>

                        <div class="local-scroll">
                            <a href="/{{trans('routes.front.pages')}}/{{trans('routes.pages.mission')}}" class="btn btn-mod btn-border-w btn-circle btn-small">Naša misija</a>
                            <span class="hidden-xs">&nbsp;</span>
                            <a href="/{{trans('routes.front.pages')}}/{{trans('routes.pages.how_to_donate')}}" class="btn btn-mod btn-circle btn-small btn-w">Kako mogu pomoći?</a>
                        </div>

                    </div>
                </div>
                <!-- End Slide Content -->

            </div>
            <!-- End Slide Item -->

            <!-- Slide Item -->
            <div class="page-section bg-scroll bg-dark-alfa-30" data-background="/front/images/hero/sova.jpg">

                <!-- Slide Content -->
                <div class="row">
                    <div class="col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-1 col-md-5 col-md-offset-1">

                        <div class="hs-line-8 no-transp font-alt mb-30 mb-xs-10">
                            POTPUNO TRANSPARENTNO
                        </div>

                        <h3 class="mb-40 mb-xs-30">
                            Vaša donacija se troši SAMO na ono što ste odabrali. SVAKA kuna se prati.
                        </h3>

                        <div class="local-scroll">
                            <a href="/{{trans('routes.front.pages')}}/{{trans('routes.pages.mission')}}" class="btn btn-mod btn-border-w btn-circle btn-small">Naša misija</a>
                            <span class="hidden-xs">&nbsp;</span>
                            <a href="/{{trans('routes.front.pages')}}/{{trans('routes.pages.how_to_donate')}}" class="btn btn-mod btn-circle btn-small btn-w">Kako mogu pomoći?</a>
                        </div>

                    </div>
                </div>
                <!-- End Slide Content -->

            </div>
            <!-- End Slide Item -->

            <!-- Slide Item -->
            <div class="page-section bg-scroll bg-dark-alfa-30" data-background="/front/images/hero/hands.jpg">

                <!-- Slide Content -->
                <div class="row">
                    <div class="col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-1 col-md-5 col-md-offset-1">

                        <div class="hs-line-8 no-transp font-alt mb-30 mb-xs-10">
                            NEKAD ĆE I VAMA BITI POTREBNA POMOĆ
                        </div>

                        <h3 class="mb-40 mb-xs-30">
                            Bitno je da pomognemo koliko možemo, bilo to i samo 50kn.
                        </h3>

                        <div class="local-scroll">
                            <a href="/{{trans('routes.front.pages')}}/{{trans('routes.pages.mission')}}" class="btn btn-mod btn-border-w btn-circle btn-small">Naša misija</a>
                            <span class="hidden-xs">&nbsp;</span>
                            <a href="/{{trans('routes.front.pages')}}/{{trans('routes.pages.how_to_donate')}}" class="btn btn-mod btn-circle btn-small btn-w">Kako mogu pomoći?</a>
                        </div>

                    </div>
                </div>
                <!-- End Slide Content -->

            </div>
            <!-- End Slide Item -->

        </div>
    </div>
    <!-- End Slider -->


    <!-- Service Section -->
    <section class="small-section pt-30">
        <div class="container relative">

            <div class="works-filter font-alt align-center">
                <a href="/{{trans('routes.front.campaigns')}}/{{trans('routes.actions.listing')}}/{{trans('routes.parameters.new')}}" class="filter active" >Novo</a>
                <a href="/{{trans('routes.front.campaigns')}}/{{trans('routes.actions.listing')}}/{{trans('routes.parameters.popular')}}" class="filter">Najpoznatije</a>
                <a href="/{{trans('routes.front.campaigns')}}/{{trans('routes.actions.listing')}}/{{trans('routes.parameters.near_goal')}}" class="filter">Pred ciljem</a>
                <a href="/{{trans('routes.front.campaigns')}}/{{trans('routes.actions.listing')}}/{{trans('routes.parameters.all')}}" class="filter">Vidi sve</a>
            </div>

            <div class="row multi-columns-row">
                @foreach($campaigns as $campaign)
                <!-- Post Item -->
                <div class="col-sm-6 col-md-4 col-lg-4 mb-60 mb-xs-40">

                    <div class="post-prev-img">
                        <a href="/{{trans('routes.front.campaigns')}}/{{trans('routes.actions.view')}}/{{$campaign->id}}"><img src="{{$campaign->cover->getPath('small')}}" alt=""></a>
                    </div>

                    <div class="progress tpl-progress">
                        <div class="progress-bar" role="progressbar" aria-valuenow="{{$campaign->percent_done}}" aria-valuemin="0" aria-valuemax="100" style="width: {{$campaign->percent_done}}%;">
                            <span>{{$campaign->percent_done}}%</span>
                        </div>
                        <br/>
                        {{$campaign->target_amount}} {{env('CURRENCY')}}
                    </div>


                    <div class="post-prev-info font-alt">
                        <a href="/{{trans('routes.front.campaigns')}}/{{trans('routes.actions.listing')}}/{{trans('routes.campaignTypes.place')}}/{{$campaign->beneficiary->person->city
                        ?$campaign->beneficiary->person->city:$campaign->beneficiary->entity->city_id}}"><i
                                    class="fa fa-map-marker"></i> {{$campaign->beneficiary->person->city}}
                            </a> <span>/</span>
                        <a href="/{{trans('routes.front.campaigns')}}/{{trans('routes.actions.listing')}}/{{trans('routes.campaignTypes.'.$campaign->category)}}">{{ucfirst(trans('routes.campaignTypes.'.$campaign->category))}}</a>
                    </div>

                    <div class="post-prev-text line-clamp">
                       {{$campaign->description_short}}
                    </div>

                    <div class="post-prev-more">
                        <a href="/{{trans('routes.front.campaigns')}}/{{trans('routes.actions.view')}}/{{$campaign->id}}" class="btn btn-mod btn-gray btn-round">Pročitaj više <i class="fa fa-angle-right"></i></a>
                    </div>

                </div>
                <!-- End Post Item -->

               @endforeach

            </div>
        </div>

</div>
</section>
<!-- End Service Section -->


<!-- Section -->
<section class="small-section bg-gray-lighter">
    <div class="container relative">

        <h2 class="section-title font-alt mb-70 mb-sm-40">
            Zašto je ovo najbolji način za doniranje?
        </h2>

        <!-- Features Grid -->

        <!-- *** More free construction icons - http://www.flaticon.com/free-icons/construction_246 *** -->

        <div class="benefits-grid mb-40 mb-xs-20">

            <!-- Features Item -->
            <div class="benefit-item">
                <div class="benefit-icon mb-20">
                    <img src="/front/images/construction/icons/1.png" width="64" height="64" alt="" />
                </div>
                <h3 class="benefit-title font-alt">Transparentnost</h3>
                <div class="benefits-descr">
                    Pratimo svaku kunu! Svi troškovi i računi su uvijek vidljivi.
                </div>
            </div>
            <!-- End Features Item -->

            <!-- Features Item -->
            <div class="benefit-item">
                <div class="benefit-icon mb-20">
                    <img src="/front/images/construction/icons/2.png" width="64" height="64" alt="" />
                </div>
                <h3 class="benefit-title font-alt">Mogućnosti</h3>
                <div class="benefits-descr">
                    Donirati se može karticom, PayPalom ili uplatom na račun.
                </div>
            </div>
            <!-- End Features Item -->

            <!-- Features Item -->
            <div class="benefit-item">
                <div class="benefit-icon mb-20">
                    <img src="/front/images/construction/icons/3.png" width="64" height="64" alt="" />
                </div>
                <h3 class="benefit-title font-alt">Provjera korisnika</h3>
                <div class="benefits-descr">
                    Naši humanitarci svakog korisnika posjete u domu i temeljito provjere.
                </div>
            </div>
            <!-- End Features Item -->

            <!-- Features Item -->
            <div class="benefit-item">
                <div class="benefit-icon mb-20">
                    <img src="/front/images/construction/icons/4.png" width="64" height="64" alt="" />
                </div>
                <h3 class="benefit-title font-alt">Nema birokracije</h3>
                <div class="benefits-descr">
                    Pomažemo jedni drugima, jer država čini premalo i prekasno.
                </div>
            </div>
            <!-- End Features Item -->

        </div>
        <!-- End Features Grid -->

        <div class="align-center">
            <a href="/{{trans('routes.front.donors')}}/{{trans('routes.actions.registration')}}" class="btn btn-mod btn-large btn-circle">Želim pomoći</a>
        </div>

    </div>
</section>
<!-- End Section -->

<!-- Testimonials Section -->
<section class="page-section bg-scroll bg-dark bg-dark-alfa-70 fullwidth-slider" data-background="/front/images/hero/campfire.jpg">

    <!-- Slide Item -->
    <div>
        <div class="container relative">
            <div class="row">
                <div class="col-md-8 col-md-offset-2 align-center">
                    <!-- Section Icon -->
                    <div class="section-icon">
                        <span class="icon-quote"></span>
                    </div>
                    <!-- Section Title --><h3 class="small-title font-alt">Što govore o nama?</h3>
                    <blockquote class="testimonial white">
                        <p>
                            Phasellus luctus commodo ullamcorper a posuere rhoncus commodo elit. Aenean congue,
                            risus utaliquam dapibus. Thanks!
                        </p>
                        <footer class="testimonial-author">
                            John Doe, doodle inc.
                        </footer>
                    </blockquote>
                </div>
            </div>
        </div>
    </div>
    <!-- End Slide Item -->

    <!-- Slide Item -->
    <div>
        <div class="container relative">
            <div class="row">
                <div class="col-md-8 col-md-offset-2 align-center">
                    <!-- Section Icon -->
                    <div class="section-icon">
                        <span class="icon-quote"></span>
                    </div>
                    <!-- Section Title --><h3 class="small-title font-alt">Što govore o nama?</h3>
                    <blockquote class="testimonial white">
                        <p>
                            Phasellus luctus commodo ullamcorper a posuere rhoncus commodo elit. Aenean congue,
                            risus utaliquam dapibus. Thanks!
                        </p>
                        <footer class="testimonial-author">
                            John Doe, doodle inc.
                        </footer>
                    </blockquote>
                </div>
            </div>
        </div>
    </div>
    <!-- End Slide Item -->

    <!-- Slide Item -->
    <div>
        <div class="container relative">
            <div class="row">
                <div class="col-md-8 col-md-offset-2 align-center">
                    <!-- Section Icon -->
                    <div class="section-icon">
                        <span class="icon-quote"></span>
                    </div>
                    <!-- Section Title --><h3 class="small-title font-alt">Što govore o nama?</h3>
                    <blockquote class="testimonial white">
                        <p>
                            Phasellus luctus commodo ullamcorper a posuere rhoncus commodo elit. Aenean congue,
                            risus utaliquam dapibus. Thanks!
                        </p>
                        <footer class="testimonial-author">
                            John Doe, doodle inc.
                        </footer>
                    </blockquote>
                </div>
            </div>
        </div>
    </div>
    <!-- End Slide Item -->

</section>
<!-- End Testimonials Section -->

<div align="center" style="color: red">Ovdje dolje idu logotipovi medija gdje se spominjemo i linkovi na članke.</div>
<!-- Logotypes Section -->
<section class="small-section bg-gray-lighter pt-20 pb-20">
    <div class="container relative">

        <div class="row">
            <div class="col-md-10 col-md-offset-1">

                <div class="small-item-carousel black owl-carousel mb-0 animate-init" data-anim-type="fade-in-right-large" data-anim-delay="100">

                    <!-- Logo Item -->
                    <div class="logo-item">
                        <img src="/front/images/clients-logos/client-1.png" width="67" height="67" alt="" />
                    </div>
                    <!-- End Logo Item -->

                    <!-- Logo Item -->
                    <div class="logo-item">
                        <img src="/front/images/clients-logos/client-2.png" width="67" height="67" alt="" />
                    </div>
                    <!-- End Logo Item -->

                    <!-- Logo Item -->
                    <div class="logo-item">
                        <img src="/front/images/clients-logos/client-3.png" width="67" height="67" alt="" />
                    </div>
                    <!-- End Logo Item -->

                    <!-- Logo Item -->
                    <div class="logo-item">
                        <img src="/front/images/clients-logos/client-4.png" width="67" height="67" alt="" />
                    </div>
                    <!-- End Logo Item -->

                    <!-- Logo Item -->
                    <div class="logo-item">
                        <img src="/front/images/clients-logos/client-5.png" width="67" height="67" alt="" />
                    </div>
                    <!-- End Logo Item -->

                    <!-- Logo Item -->
                    <div class="logo-item">
                        <img src="/front/images/clients-logos/client-6.png" width="67" height="67" alt="" />
                    </div>
                    <!-- End Logo Item -->

                    <!-- Logo Item -->
                    <div class="logo-item">
                        <img src="/front/images/clients-logos/client-1.png" width="67" height="67" alt="" />
                    </div>
                    <!-- End Logo Item -->

                    <!-- Logo Item -->
                    <div class="logo-item">
                        <img src="/front/images/clients-logos/client-2.png" width="67" height="67" alt="" />
                    </div>
                    <!-- End Logo Item -->

                </div>

            </div>
        </div>

    </div>
</section>
<!-- End Logotypes -->

@endsection