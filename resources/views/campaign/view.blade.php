@extends('layouts.full')

@section('content')
        <!-- Section -->
<section class="small-section">
    <div class="container relative">

        <div class="row">

            <!-- Content -->
            <div class="col-sm-9">

                <!-- Post -->
                <div class="blog-item">

                    <!-- Post Title -->
                    <h2 class="blog-item-title font-alt">{{$campaign->name}}</h2>
                    <h5>Korisnik: <a
                                href="{{trans('routes.front.beneficiaries')}}/{{trans('routes.actions.view')}}/{{$campaign->beneficiary->id}}">{{$campaign->beneficiary->name}}</a>
                    </h5>

                    <!-- Author, Categories, Comments -->
                    <div class="blog-item-data">
                        <a href="#"><i class="fa fa-clock-o"></i> {{date("d.m.Y", strtotime($campaign->created_at))}}
                            .</a>
                        <span class="separator">&nbsp;</span>
                        <a href="/{{trans('routes.front.campaigns')}}/{{trans('routes.actions.listing')}}/{{trans('routes.campaignTypes.place')}}/{{$campaign->beneficiary->person->city
                        ?$campaign->beneficiary->person->city_id:$campaign->beneficiary->entity->city_id}}"><i
                                    class="fa fa-map-marker"></i> {{$campaign->beneficiary->person->city}}
                        </a>
                        <span class="separator">&nbsp;</span>
                        <i class="fa fa-folder-open"></i>
                        <a href="/{{trans('routes.front.campaigns')}}/{{trans('routes.actions.listing')}}/
                        {{trans('routes.campaignTypes.'.$campaign->category)}}">{{ucfirst(trans('routes.campaignTypes.'.$campaign->category))}}</a>
                    </div>

                    <!-- Media Gallery -->
                    <div class="blog-media">
                        <ul class="clearlist content-slider">

                            @foreach( $campaign->media_info as $media)
                                <li>
                                    <img src="{{$media->getPath('small')}}" class="img-sm" alt=""/>
                                </li>
                            @endforeach

                        </ul>
                    </div>

                    <!-- Text Intro -->
                    <div class="blog-item-body">

                        <p>
                            <btn class="btn-mod btn-circle bg-facebook fbShare" data-link="{{env('APP_URL')}}/{{trans('routes.front.campaigns')}}/{{trans('routes.actions.view')}}/{{$campaign->id}}"><i class="fa fa-facebook"></i> Share</btn>
                            <btn class="btn-mod btn-circle"><i class="fa fa-twitter"></i> Tweet</btn>
                        </p>

                        {!! $campaign->description_full!!}
                    </div>
                    <!-- End Post -->

                </div>
                <div class="row">
                    <div class="col-md-4">
                        <img alt="image" class="img-responsive" src="/front/images/campaigns/types/stalni.png"
                             style="width: 150px;">
                    </div>
                    <div class="col-md-4">
                        <img alt="image" class="img-responsive"
                             src="/front/images/campaigns/types/{{$campaign->classification_code}}.png"
                             style="width: 150px;">
                    </div>
                    <div class="col-md-4">
                        <img alt="image" class="img-responsive"
                             src="{{$campaign->organization->logo->getPath('small')}}" style="width: 150px;">
                    </div>

                </div>
                <hr/>
                <div class="row">
                    <div class="col-md-2">
                        <h5 class="text-center">Zahtjev</h5>
                        <div class="col-md-10 col-md-offset-1">
                            <a href="{{$campaign->registration_request_doc->getPath('large')}}" target="_blank"> <img
                                        alt="image" class="img-responsive"
                                        src="{{$campaign->registration_request_doc->getPath('thumb')}}"
                                        style="width: 70px;margin:auto;"></a>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <h5 class="text-center">Registracija</h5>
                        <div class="col-md-10 col-md-offset-1">
                            <a href="{{$campaign->registration_request_doc->getPath('large')}}" target="_blank"><img
                                        alt="image" class="img-responsive"
                                        src="{{$campaign->registration_doc->getPath('thumb')}}"
                                        style="width: 70px;margin:auto;"></a>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <h5 class="text-center">Plan akcije</h5>
                        <div class="col-md-10 col-md-offset-1">
                            <a href="{{$campaign->registration_request_doc->getPath('large')}}" target="_blank"><img
                                        alt="image" class="img-responsive"
                                        src="{{$campaign->action_plan_doc->getPath('thumb')}}"
                                        style="width: 70px;margin:auto;"></a>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <h5 class="text-center">Plan distribucije</h5>
                        <div class="col-md-10 col-md-offset-1">
                            <a href="{{$campaign->registration_request_doc->getPath('large')}}" target="_blank"><img
                                        alt="image" class="img-responsive"
                                        src="{{$campaign->distribution_plan_doc->getPath('thumb')}}"
                                        style="width: 70px;margin:auto;"></a>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <h5 class="text-center">Zahtjev korisnika</h5>
                        <div class="col-md-10 col-md-offset-1">
                            <a href="{{$campaign->registration_request_doc->getPath('large')}}" target="_blank"><img
                                        alt="image" class="img-responsive"
                                        src="{{$campaign->beneficiary_request_doc->getPath('thumb')}}"
                                        style="width: 70px;margin:auto;"></a>
                        </div>
                    </div>

                    @if($campaign->status == 'finalized')
                        <div class="col-md-2">
                            <h5 class="text-center">Potvrda primljene donacije</h5>
                            <div class="col-md-10 col-md-offset-1"><a
                                        href="{{$campaign->beneficiary_receipt_doc->getPath('large')}}" target="_blank">
                                    <img    alt="image" class="img-responsive"
                                            src="{{$campaign->beneficiary_receipt_doc->getPath('thumb')}}"
                                            style="width: 70px;margin:auto;"></a></div>
                        </div>
                    @endif

                </div>
                <!-- End Content -->


            </div>
            @include('sections.campaign_sidebar')
        </div>

    </div>

</section>

<!-- End Section -->

@endsection

