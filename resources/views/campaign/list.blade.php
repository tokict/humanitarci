@extends('layouts.full')
@section('content')
        <!-- Service Section -->
<section class="small-section pt-30">
    <div class="container relative">

        <div class="works-filter font-alt align-center">
            <a href="/{{trans('routes.front.campaigns')}}/{{trans('routes.actions.listing')}}/{{trans('routes.parameters.new')}}" class="filter {{trans('routes.parameters.'.$category) == 'new'?'active':''}}" >Novo</a>
            <a href="/{{trans('routes.front.campaigns')}}/{{trans('routes.actions.listing')}}/{{trans('routes.parameters.popular')}}" class="filter {{trans('routes.parameters.'.$category) == 'popular'?'active':''}}">Izdvojene</a>
            <a href="/{{trans('routes.front.campaigns')}}/{{trans('routes.actions.listing')}}/{{trans('routes.parameters.near_goal')}}" class="filter {{trans('routes.parameters.'.$category) == 'near_goal'?'active':''}}">Pred ciljem</a>
            <a href="/{{trans('routes.front.campaigns')}}/{{trans('routes.actions.listing')}}/{{trans('routes.parameters.all')}}" class="filter {{trans('routes.parameters.'.$category) == 'all'?'active':''}}">Vidi sve</a>
        </div>

        <div class="row multi-columns-row">
            @if(!count($campaigns))
                <h3 class="text-center">Trenutno nemamo akcije koja zadovoljava zadane kriterije</h3>
            @endif
            @foreach($campaigns as $campaign)
                    <!-- Post Item -->
            <div class="col-sm-6 col-md-4 col-lg-4 mb-60 mb-xs-40">

                <div class="post-prev-img">
                    <a href="/{{trans('routes.front.campaigns')}}/{{trans('routes.actions.view')}}/{{$campaign->id}}"><img src="{{$campaign->cover->getPath('small')}}" alt=""></a>
                </div>

                @if(isset($campaign->target_amount))
                <div class="progress tpl-progress">
                    <div class="progress-bar" role="progressbar" aria-valuenow="{{$campaign->percent_done}}" aria-valuemin="0" aria-valuemax="100" style="width: {{$campaign->percent_done}}%;">
                        <span>{{$campaign->percent_done}}%</span>
                    </div>
                    <br/>
                    {{$campaign->target_amount}} {{env('CURRENCY')}}
                </div>
                    @else
                    <small>Do sada prikupljeno: {{number_format($campaign->current_funds/100)}} {{env('CURRENCY')}}</small>
                    <br/><br/>
                @endif


                <div class="post-prev-info font-alt">
                    @if(isset($campaign->beneficiary->entity->city))
                        <a href="/{{trans('routes.front.campaigns')}}/{{trans('routes.actions.listing')}}/{{trans('routes.campaignTypes.place')}}/{{$campaign->beneficiary->entity->city_id}}"><i
                                    class="fa fa-map-marker"></i> {{$campaign->beneficiary->entity->city}}
                        </a>
                        <span>/</span>
                    @endif
                    @if(isset($campaign->beneficiary->person->city))
                        <a href="/{{trans('routes.front.campaigns')}}/{{trans('routes.actions.listing')}}/{{trans('routes.campaignTypes.place')}}/{{$campaign->beneficiary->person->city}}"><i
                                    class="fa fa-map-marker"></i> {{$campaign->beneficiary->person->city}}
                        </a>
                        <span>/</span>
                    @endif
                    @if(isset($campaign->beneficiary->group->city))
                        <a href="/{{trans('routes.front.campaigns')}}/{{trans('routes.actions.listing')}}/{{trans('routes.campaignTypes.place')}}/{{$campaign->beneficiary->group->city
                        ?$campaign->beneficiary->group->city_id:''}}"><i
                                    class="fa fa-map-marker"></i> {{$campaign->beneficiary->group->city->name}}
                        </a>
                        <span>/</span>
                    @endif
                    <a href="/{{trans('routes.front.campaigns')}}/{{trans('routes.actions.listing')}}/{{trans('routes.campaignTypes.'.$campaign->category)}}">{{ucfirst(trans('routes.campaignTypes.'.$campaign->category))}}</a>
                      <br/><i
                                    class="fa fa-clock-o"></i> {{date("d.m.Y", strtotime($campaign->created_at))}} - {{date("d.m.Y", strtotime($campaign->ends))}}

                </div>

                <div class="post-prev-text line-clamp">
                    {!! $campaign->description_short!!}
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



