@extends('layouts.full')
@section('content')
        <!-- Service Section -->
<section class="small-section pt-30">
    <div class="container relative">

        <div class="works-filter font-alt align-center">
            <a href="/{{trans('routes.front.donors')}}/{{trans('routes.actions.listing')}}?sort=n" class="filter {{$param == 'n'?'active':null}}" data-filter="*">Novi</a>
            <a href="/{{trans('routes.front.donors')}}/{{trans('routes.actions.listing')}}?sort=l" class="filter {{$param == 'l'?'active':null}}" data-filter=".management">Najveći</a>
            <a href="/{{trans('routes.front.donors')}}/{{trans('routes.actions.listing')}}" class="filter {{empty($param)?'active':null}}" data-filter=".design-buid">Najfrekventniji</a>
            <a href="/{{trans('routes.front.donors')}}/{{trans('routes.actions.listing')}}?sort=d" class="filter {{$param == 'd'?'active':null}}" data-filter=".design-buid">Najraznolikiji</a>
        </div>

        <div class="row multi-columns-row">
            @foreach($donors as $donor)
            <!-- Post Item -->
            <div class="col-sm-6 col-md-4 col-lg-4 mb-60 mb-xs-40">
                <div class="post-prev-info font-alt">
                    <a href="/{{trans('routes.front.donors')}}/{{trans('routes.actions.view')}}/{{$donor->id}}">{{$donor->user->username}} <span>/</span> {{$donor->person->city}}

                    </a>
                </div>

                <div class="post-prev-text line-clamp">
                    Doniranih akcija: {{!empty($donor->getCampaigns())?$donor->getCampaigns()->count():null}}<br/>
                    Ukupno donirano: {{number_format($donor->getTotalDonationsSum())}} {{env('CURRENCY')}}<br/>
                    Posljednja donacija: {{!empty($donor->getLastDonation())?$donor->getLastDonation()->created_at->format('m.d.Y'):null}}<br/>
                    Datum registracije: {{date('m.d.Y', strtotime($donor->created_at))}}<br/>
                </div>

                <div class="post-prev-more">
                    <a href="/{{trans('routes.front.donors')}}/{{trans('routes.actions.profile')}}/{{$donor->user->username}}" class="btn btn-mod btn-gray btn-round">Pročitaj više <i
                                class="fa fa-angle-right"></i></a>
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



