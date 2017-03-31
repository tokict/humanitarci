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
                                    href="/{{trans('routes.front.beneficiaries')}}/{{trans('routes.actions.view')}}/{{$campaign->beneficiary->id}}">{{$campaign->beneficiary->name}}</a>
                        </h5>

                        <!-- Author, Categories, Comments -->
                        <div class="blog-item-data">
                            <a href="#"><i
                                        class="fa fa-clock-o"></i> {{date("d.m.Y", strtotime($campaign->created_at))}}
                                .</a>
                            <span class="separator">&nbsp;</span>
                            @if(isset($campaign->beneficiary->entity->city))
                                <a href="/{{trans('routes.front.campaigns')}}/{{trans('routes.actions.listing')}}/{{trans('routes.campaignTypes.place')}}/{{$campaign->beneficiary->entity->city_id}}"><i
                                            class="fa fa-map-marker"></i> {{$campaign->beneficiary->entity->city}}
                                </a>
                            @endif
                            @if(isset($campaign->beneficiary->person->city))
                                <a href="/{{trans('routes.front.campaigns')}}/{{trans('routes.actions.listing')}}/{{trans('routes.campaignTypes.place')}}/{{$campaign->beneficiary->person->city}}"><i
                                            class="fa fa-map-marker"></i> {{$campaign->beneficiary->person->city}}
                                </a>
                            @endif
                            @if(isset($campaign->beneficiary->group->city))
                                <a href="/{{trans('routes.front.campaigns')}}/{{trans('routes.actions.listing')}}/{{trans('routes.campaignTypes.place')}}/{{$campaign->beneficiary->group->city
                        ?$campaign->beneficiary->group->city_id:''}}"><i
                                            class="fa fa-map-marker"></i> {{$campaign->beneficiary->group->city->name}}
                                </a>
                            @endif
                            <span class="separator">&nbsp;</span>
                            <i class="fa fa-folder-open"></i>
                            <a href="/{{trans('routes.front.campaigns')}}/{{trans('routes.actions.listing')}}/
                        {{trans('routes.campaignTypes.'.$campaign->category)}}">{{ucfirst(trans('routes.campaignTypes.'.$campaign->category))}}</a>
                            <span class="separator">&nbsp;</span>
                            <i class="fa fa-eye"></i>
                            {{$campaign->page_data->views}}
                            <span class="separator">&nbsp;</span>
                            <i class="fa fa-share-alt"></i>
                            {{$campaign->page_data->shares}}
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
                                <button class="btn-mod btn-circle bg-facebook fbShare"
                                        data-link="{{env('APP_URL')}}/{{trans('routes.front.campaigns')}}/{{trans('routes.actions.view')}}/{{$campaign->id}}"
                                        data-id="{{$campaign->id}}"
                                        data-type="campaign">
                                    <i class="fa fa-facebook">
                                    </i> Share
                                </button>
                                <a class="btn-mod btn-circle twitterShare"
                                   href="https://twitter.com/intent/tweet?text={{$campaign->name}} @ {{env('APP_URL')}}/{{trans('routes.front.campaigns')}}/{{trans('routes.actions.view')}}/{{$campaign->id}}"
                                   data-id="{{$campaign->id}}"
                                   data-type="campaign">
                                    <i class="fa fa-twitter"></i> Tweet</a>
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
                            <h5 class="text-center">Dozvola akcije</h5>
                            <div class="col-md-10 col-md-offset-1">
                                <a href="{{$campaign->registration_doc->getPath()}}" target="_blank"><i
                                            class="fa fa-file-text-o fa-3x"></i></a>
                            </div>
                        </div>

                        @if($campaign->status == 'finalized')
                            <div class="col-md-2">
                                <h5 class="text-center">Potvrda primljene donacije</h5>
                                <div class="col-md-10 col-md-offset-1"><a
                                            href="{{$campaign->beneficiary_receipt_doc->getPath()}}" target="_blank">
                                        <i class="fa fa-file-text-o fa-3x"></i></a></div>
                            </div>
                        @endif
                        <div class="col-md-6">
                            <h5 class="text-center">Iskorištena sredstva <br/>
                                ({{number_format($campaign->monetary_outputs->sum('amount')/100,2)}} {{env('CURRENCY')}}
                                od {{number_format($campaign->current_funds /100, 2)}} {{env('CURRENCY')}})</h5>
                            <hr>
                            <div class="col-md-10 col-md-offset-1">
                                @foreach($campaign->monetary_outputs as $o)
                                    <strong>{{number_format($o->amount /100, 2)}} {{env("CURRENCY")}}</strong>
                                    <small>{{date("d-m-Y",strtotime($o->action_time))}}</small>
                                    <br>
                                    <small>{{$o->description}}</small>
                                    <br/><br/>
                                    @if(isset($o->receiving_entity))
                                        Firmi:
                                        {{$o->receiving_entity->name}},  {{$o->receiving_entity->city->name}}
                                        (OIB: {{$o->receiving_entity->tax_id}})
                                    @else
                                        Osobi: {{$o->receiving_person->first_name.' '.$o->receiving_person->last_name}}
                                    @endif
                                <br>
                                    @foreach($o->getReceipts() as $r)
                                        <a href="{{$r->type == 'document'?$r->getPath():$r->getPath('large')}}" target="_blank"><i class="fa fa-file-text-o fa-3x"></i></a>
                                    &nbsp;
                                    @endforeach
                                    <hr>
                                @endforeach

                            </div>
                        </div>

                    </div>
                    <!-- End Content -->


                </div>
                @include('sections.campaign_sidebar')
            </div>

        </div>

    </section>

    <!-- End Section -->

@endsection

