@extends('layouts.full')

@section('content')
        <!-- Section -->
<section class="small-section">
    <div class="container relative">

        <div class="row">

            <!-- Content -->
            <div class="col-sm-12">

                <!-- Post -->
                <div class="blog-item">

                    <!-- Post Title -->
                    <h2 class="blog-item-title font-alt"><a
                                href="blog-single-sidebar-right.html">{{$campaign->beneficiary->name}}</a></h2>

                    <!-- Author, Categories, Comments -->
                    <div class="blog-item-data">
                        <a href="#"><i class="fa fa-clock-o"></i> {{date("d.m.Y", strtotime($campaign->created_at))}}
                            .</a>
                        <span class="separator">&nbsp;</span>
                        <a href="/{{trans('routes.front.campaigns')}}/{{trans('routes.actions.listing')}}/{{trans('routes.campaignTypes.place')}}/{{$campaign->beneficiary->person->city_id
                        ?$campaign->beneficiary->person->city_id:$campaign->beneficiary->entity->city_id}}"><i
                                    class="fa fa-map-marker"></i> {{$campaign->beneficiary->person->city->name}}
                            , {{$campaign->beneficiary->person->city->region->name}}</a>
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
                            <btn class="btn-mod btn-circle bg-facebook"><i class="fa fa-facebook"></i> Share</btn>
                            <btn class="btn-mod btn-circle"><i class="fa fa-twitter"></i> Tweet</btn>
                        </p>

                        {{$campaign->description_full}}
                    </div>
                    <!-- End Post -->

                </div>
                <!-- End Content -->

                @include('sections.campaign_sidebar')
            </div>

        </div>
    </div>
</section>
<!-- End Section -->

@endsection

