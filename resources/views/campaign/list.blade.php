@extends('layouts.full')
@section('content')
        <!-- Service Section -->
<section class="small-section pt-30">
    <div class="container relative">

        <div class="works-filter font-alt align-center">
            <a href="/{{trans('routes.front.campaigns')}}/{{trans('routes.actions.listing')}}/{{trans('routes.parameters.new')}}" class="filter active" >Novo</a>
            <a href="/{{trans('routes.front.campaigns')}}/{{trans('routes.actions.listing')}}/{{trans('routes.parameters.popular')}}" class="filter">Izdvojene</a>
            <a href="/{{trans('routes.front.campaigns')}}/{{trans('routes.actions.listing')}}/{{trans('routes.parameters.near_goal')}}" class="filter">Pred ciljem</a>
            <a href="/{{trans('routes.front.campaigns')}}/{{trans('routes.actions.listing')}}/{{trans('routes.parameters.all')}}" class="filter">Vidi sve</a>
        </div>

        <div class="row multi-columns-row">
            @if(!count($campaigns))
                <h3 class="text-center">There are no campaigns that match your criteria</h3>
            @endif
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
                    <a href="/{{trans('routes.front.campaigns')}}/{{trans('routes.actions.listing')}}/{{trans('routes.campaignTypes.place')}}/{{$campaign->beneficiary->person->city_id
                        ?$campaign->beneficiary->person->city_id:$campaign->beneficiary->entity->city_id}}"><i
                                class="fa fa-map-marker"></i> {{$campaign->beneficiary->person->city->name}}
                        , {{$campaign->beneficiary->person->city->region->name}}</a> <span>/</span>
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
@endsection



