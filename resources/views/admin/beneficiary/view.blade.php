@extends('layouts.admin')
@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">


        <div class="row m-b-lg m-t-lg">
            <div class="col-md-6">

                <div class="profile-image">
                    <img src="{{$beneficiary->profile_image->getPath("thumb")}}" class="img-circle circle-border m-b-md"
                         alt="profile">
                </div>
                <div class="profile-info">
                    <div class="">
                        <div>
                            <h2 class="no-margins">
                                {{$beneficiary->name}}
                            </h2>
                            <h4>{{isset($beneficiary->person)?"Person":''}}</h4>
                            <h4>{{isset($beneficiary->group)?"Group":''}}</h4>
                            <h4>{{isset($beneficiary->legalEntity)?"Legal entity":''}}</h4>
                            <small>
                                @if(isset($beneficiary->person))
                                    {{$beneficiary->person->city}}, {{$beneficiary->person->city}}
                                @elseif(isset($beneficiary->legalEntity))
                                    {{$beneficiary->legalEntity->city}}
                                    , {{$beneficiary->legalEntity->city->region->name}}
                                @else
                                    @if(isset($beneficiary->person))
                                        {{$beneficiary->group->person->city}}
                                        , {{$beneficiary->group->person->city}}
                                    @else
                                        {{$beneficiary->group->legalEntity->city->name}}
                                        , {{$beneficiary->group->legalEntity->city->region->name}}
                                    @endif
                                @endif
                            </small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <table class="table small m-b-xs">
                    <tbody>
                    <tr>
                        <td>
                            <strong>{{count($beneficiary->getSuccessfulCampaigns())}}</strong> Successful campaigns
                        </td>
                        <td>
                            <strong>{{$beneficiary->donor_number}}</strong> Donors
                        </td>

                    </tr>
                    <tr>
                        <td>
                            <strong>{{count($beneficiary->donations)}}</strong> Donations
                        </td>
                        <td>
                            <strong>{{$beneficiary->getAverageDonation()}} {{env('CURRENCY')}}</strong> Donation average
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <strong>154</strong> Shares
                        </td>
                        <td>
                            <strong>32</strong> Page views
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-md-3">
                <small>Donations received so far</small>
                <h2 class="no-margins">{{$beneficiary->funds_used}}</h2>
                @if($beneficiary->hasActiveCampaign())
                    <span><i class="fa fa-circle text-navy"></i> Has active campaign</span>
                @else
                    <span><i class="fa fa-circle text-warning"></i> No active campaign</span>
                @endif
                <div id="sparkline1"></div>
            </div>


        </div>
        <div class="row">

            <div class="col-lg-4">

                <div class="ibox">
                    <div class="ibox-content">
                        <h3>About {{$beneficiary->name}}</h3>
                        {{$beneficiary->description}}


                    </div>
                </div>

                <div class="ibox">
                    <div class="ibox-content">
                        <h3>Top donors</h3>
                        <p class="small">
                            These are the donors that donated the biggest amounts overall
                        </p>
                        <div class="user-friends">
                            @foreach($beneficiary->getDonors() as $donor)
                                <a href="/{{trans('routes.front.donors')}}/{{trans('routes.actions.view')}}/{{$donor->id}}">{{$donor->person->first_name}} {{$donor->person->last_name}}</a>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="ibox">
                    <div class="ibox-content">
                        <h3>Private message</h3>

                        <p class="small">
                            Send private message to {{$donor->person->first_name}} {{$donor->person->last_name}}
                        </p>

                        <div class="form-group">
                            <label>Subject</label>
                            <input type="email" class="form-control" placeholder="Message subject">
                        </div>
                        <div class="form-group">
                            <label>Message</label>
                            <textarea class="form-control" placeholder="Your message" rows="3"></textarea>
                        </div>
                        <button class="btn btn-primary btn-block">Send</button>

                    </div>
                </div>

            </div>

            <div class="col-lg-4 m-b-lg">
                <h4 class="text-center">Campaign history</h4>
                <div id="vertical-timeline" class="vertical-container light-timeline no-margins">

                    @foreach($beneficiary->campaigns as $c)
                    <div class="vertical-timeline-block">
                        <div class="vertical-timeline-icon
                        {{$c->status == 'active'?'navy-bg':''}}
                        {{$c->status == 'blocked'?'red-bg':''}}
                        {{in_array($c->status, ['reached', 'failed'])?'bg-warning':''}}
                        {{$c->status == 'inactive'?'default-bg':''}}">
                            <i class="fa fa-dot-circle-o"></i>
                        </div>

                        <div class="vertical-timeline-content">
                            <h2>{{$c->name}} <small class="pull-right">{{$c->current_funds}} {{env("CURRENCY")}} / {{$c->target_amount}} {{env("CURRENCY")}}</small></h2>
                            <p>{{$c->description_short}}
                            </p>
                            <a href="/admin/campaign/view/{{$c->id}}" class="btn btn-sm btn-primary"> More info</a>
                                    <span class="vertical-date">
                                        {{$c->status == 'active'?'Active':''}}
                                        {{$c->status == 'blocked'?'Blocked':''}}
                                        {{$c->status == 'reached'?'Ended: Goal reached':''}}
                                        {{$c->status == 'failed'?'Ended: Goal failed':''}}
                                        {{$c->status == 'inactive'?'Deactivated':''}} <br>
                                        <small>{{date("Y-m-d", strtotime($c->starts))}} / {{date("Y-m-d", strtotime($c->endss))}}</small>

                                    </span>
                        </div>
                    </div>
                        @endforeach




                </div>

            </div>
            <div class="col-lg-4 m-b-lg">
                <div class="ibox">
                    <div class="ibox-content">
                        <h3>Related documents</h3>
                        <ul class="list-unstyled file-list">
                            <li><a href=""><i class="fa fa-file"></i> Project_document.docx</a></li>
                            <li><a href=""><i class="fa fa-file-picture-o"></i> Logo_zender_company.jpg</a></li>
                            <li><a href=""><i class="fa fa-stack-exchange"></i> Email_from_Alex.mln</a></li>
                            <li><a href=""><i class="fa fa-file"></i> Contract_20_11_2014.docx</a></li>
                            <li><a href=""><i class="fa fa-file-powerpoint-o"></i> Presentation.pptx</a></li>
                            <li><a href=""><i class="fa fa-file"></i> 10_08_2015.docx</a></li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
