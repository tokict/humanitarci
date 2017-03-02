@extends('layouts.full')
@section('content')
    <section class="small-section pt-30">
        <div class="container relative">


            <div class="row m-b-lg m-t-lg">
                <div class="col-md-6">

                    <div class="profile-image">
                        <img src="{{$beneficiary->profile_image->getPath("thumb")}}"
                             class="img-circle circle-border m-b-md"
                             alt="profile">
                    </div>
                    <div class="profile-info">
                        <div class="">
                            <div>
                                <h3 class="section-title font-alt mb-70 mb-sm-40" style="text-align: left">
                                    {{$beneficiary->name}}
                                    <br/>
                                    <small>(
                                        {{isset($beneficiary->person)?"Osoba":''}}
                                        {{isset($beneficiary->group)?"Grupa":''}}
                                        {{isset($beneficiary->legalEntity)?"Pravna osoba":''}}
                                        )
                                    </small>

                                    <small>
                                        -
                                        @if(isset($beneficiary->person))
                                            {{$beneficiary->person->city}}
                                        @endif
                                        @if(isset($beneficiary->legalEntity))
                                            {{$beneficiary->legalEntity->city}}
                                            , {{$beneficiary->legalEntity->city->region->name}}
                                        @endif
                                        @if(isset($beneficiary->group))
                                            {{$beneficiary->group->city}}
                                            , {{$beneficiary->group->city->region->name}}
                                        @endif


                                    </small>
                                </h3>


                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <table class="table small m-b-xs">
                        <tbody>
                        <tr>
                            <td>
                                <strong>{{count($beneficiary->getSuccessfulCampaigns())}}</strong> uspješnih akcija
                            </td>
                            <td>
                                <strong>{{$beneficiary->donor_number}}</strong> donora
                            </td>

                        </tr>
                        <tr>
                            <td>
                                <strong>{{count($beneficiary->donations)}}</strong> donacija
                            </td>
                            <td>
                                <strong>{{$beneficiary->getAverageDonation()}} {{env('CURRENCY')}}</strong> prosječna
                                visina donacije
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>154</strong> dijeljenja
                            </td>
                            <td>
                                <strong>32</strong> pregleda profila
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-3">
                    <small>Prikupljeni iznos donacija</small>
                    <h2 class="no-margins">{{$beneficiary->funds_used}}</h2>
                    <div id="sparkline1"></div>
                </div>
                <div class="col-md-3">
                    @if($beneficiary->hasActiveCampaign())
                        <a href="/{{trans('routes.front.campaigns')}}/{{trans('routes.actions.view')}}/{{$beneficiary->getActiveCampaign()->id}}"><i
                                    class="fa fa-circle" style="color: green;"></i> Ima aktivnu akciju</a>
                    @else
                        <span><i class="fa fa-circle" style="color: darkred;"></i> Nema aktivnu akciju</span>
                    @endif
                    <div id="sparkline1"></div>
                </div>


            </div>
            <div class="row">

                <div class="col-lg-6 mb-100">

                    <h4 class="font-alt mb-20 mb-sm-40">O korisniku:</h4>
                    <p class="small">{!! $beneficiary->description !!}</p>

                    <h4 class="font-alt mb-20 mb-sm-40">Vodeći donori</h4>
                    <div class="user-friends">
                        @foreach($beneficiary->getDonors() as $donor)
                            <a href="/{{trans('routes.front.donors')}}/{{trans('routes.actions.view')}}/{{$donor->id}}" style="text-decoration: none">
                                @if(isset($donor->person))
                                    {{$donor->person->first_name}} {{$donor->person->last_name}}
                                @endif
                                @if(isset($donor->legalEntity))
                                    {{$donor->legalEntity->name}}
                                @endif
                            </a>
                            <br/>
                        @endforeach
                    </div>


                </div>

                <div class="col-lg-4 m-b-lg">
                    <h4 class="section-title font-alt mb-70 mb-sm-40">Povijest akcija</h4>
                    @foreach($beneficiary->campaigns as $c)
                        <div style="box-shadow: 1px 1px 1px gray; padding: 20px;">
                            <h2 class="inline">
                                <div style="color:
                                {{$c->status == 'active'?'green':''}}
                                {{$c->status == 'blocked'?'red':''}}
                                {{in_array($c->status, ['reached', 'failed'])?'orange':''}}
                                {{$c->status == 'inactive'?'gray':''}}">
                                    <i class="fa fa-dot-circle-o"></i>
                                    {{$c->name}}
                                    <small>

                                        {{$c->status == 'active'?'Aktivna':''}}
                                        {{$c->status == 'blocked'?'Blokirana':''}}
                                        {{$c->status == 'reached'?'Završena: Cilj postignut':''}}
                                        {{$c->status == 'failed'?'Završena: Cilj nije dostignut':''}}
                                        {{$c->status == 'inactive'?'Deaktivirana':''}}
                                    </small>
                                </div>
                                <small>{{$c->current_funds}} {{env("CURRENCY")}}
                                    / {{$c->target_amount}} {{env("CURRENCY")}}</small>
                            </h2>
                            <p>{{$c->description_short}}
                            </p>
                            <a href="/{{trans('routes.front.campaigns')}}/{{trans('routes.actions.view')}}/{{$c->id}}" class="btn btn-sm btn-primary"
                               style="text-decoration: none;"> Više..</a>
                            <br/>

                            <small>Od {{date("d.m.Y", strtotime($c->starts))}}
                                do {{date("d.m.Y", strtotime($c->ends))}}</small>
                        </div>
                    @endforeach


                </div>

            </div>
        </div>
    </section>
@endsection
