@extends('layouts.admin')
@section('content')
    <div class="wrapper wrapper-content animated fadeInRight">

        <div class="row wrapper border-bottom white-bg page-heading">
            <div class="col-sm-4">
                <h2>Campaign details</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-9">
                <div class="wrapper wrapper-content animated fadeInUp">
                    <div class="ibox">
                        <div class="ibox-content">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="m-b-md">
                                        <h2>{{$campaign->name}}</h2>
                                    </div>
                                    <dl class="dl-horizontal">
                                        <dt>Status:</dt>
                                        <dd>
                                            @if($campaign->status == 'active')
                                                <span class="label label-primary">Active</span>
                                            @endif
                                            @if($campaign->status == 'inactive')
                                                <span class="label label-default">Inactive</span>
                                            @endif
                                            @if($campaign->status == 'blocked')
                                                <span class="label label-danger">Blocked</span>
                                            @endif
                                            @if($campaign->status == 'reached')
                                                <span class="label label-success">Active</span>
                                            @endif
                                            @if($campaign->status == 'failed')
                                                <span class="label label-info">Active</span>
                                            @endif

                                        </dd>
                                    </dl>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-5">
                                    <dl class="dl-horizontal">

                                        <dt>Created by:</dt>
                                        <dd><a href="/admin/view/admin/{{$campaign->creator->id}}"
                                               class="text-navy">{{$campaign->creator->person->first_name}} {{$campaign->creator->person->last_name}}</a></dd>
                                        <dt>Beneficiary:</dt>
                                        <dd><a href="/admin/view/beneficiary/{{$campaign->beneficiary->id}}"
                                               class="text-navy"> {{$campaign->beneficiary->name}}</a>
                                        </dd>
                                        <dt>Donors:</dt>
                                        <dd> {{count($campaign->beneficiary->getDonors())}}</dd>
                                        <dt>Views:</dt>
                                        <dd> {{count($campaign->beneficiary->getDonors())}}</dd>
                                        <dt>Shares:</dt>
                                        <dd> {{count($campaign->beneficiary->getDonors())}}</dd>
                                    </dl>
                                </div>
                                <div class="col-lg-7" id="cluster_info">
                                    <dl class="dl-horizontal">

                                        <dt>Start:</dt>
                                        <dd>{{$campaign->starts}}</dd>
                                        <dt>End:</dt>
                                        <dd>{{$campaign->ends}} </dd>
                                        @if($campaign->beneficiary->group)
                                            <dt>Beneficiary group members:</dt>
                                            <dd class="project-people">
                                                @if($campaign->beneficiary->group->beneficiaries)
                                                    @foreach($campaign->beneficiary->group->beneficiaries as $item)
                                                        <a href=""><img alt="image" class="img-circle"
                                                                        src="{{$item->profile_image->getPath('thumb')}}"></a>
                                                    @endforeach
                                                @endif

                                            </dd>
                                        @endif
                                    </dl>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <dl class="dl-horizontal">
                                        <dt>Goal progress:</dt>
                                        <dd>
                                            <div class="progress progress-striped active m-b-sm">
                                                <div style="width: {{$campaign->percent_done}}%;"
                                                     class="progress-bar"></div>
                                            </div>
                                            <strong>{{$campaign->current_funds}} {{env('CURRENCY')}}</strong>.

                                        </dd>
                                    </dl>
                                </div>
                            </div>
                            <div class="row m-t-sm">
                                <div class="col-lg-12">
                                    <div class="panel blank-panel">
                                        <div class="panel-heading">
                                            <div class="panel-options">
                                                <ul class="nav nav-tabs">
                                                    <li class="active"><a href="#tab-1" data-toggle="tab">Donations
                                                            overview</a></li>
                                                    <li class=""><a href="#tab-2" data-toggle="tab">Last activity</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>

                                        <div class="panel-body">

                                            <div class="tab-content">
                                                <div class="tab-pane active" id="tab-1">Put graphics and widgets here

                                                </div>
                                                <div class="tab-pane" id="tab-2">
                                                    <div class="feed-activity-list">
                                                        @foreach($campaign->getReceivedDonations() as $d)
                                                        <div class="feed-element">

                                                            <div class="media-body ">
                                                                <small class="pull-right">{{$d->created_at->diffForHumans()}}</small>
                                                                <a href="/admin/donor/view/{{$d->donor->id}}"><strong>{{$d->donor->user->username}}</strong></a> donated
                                                                <a href="/admin/donation/view/{{$d->id}}"> <strong> {{number_format($d->amount/100)}} {{env('CURRENCY')}}</strong></a>
                                                                <br>
                                                                <small class="text-muted">{{$d->created_at}}
                                                                </small>
                                                            </div>
                                                        </div>
                                                            @endforeach
                                                    </div>


                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="wrapper wrapper-content project-manager">
                    <h4>Campaign description</h4>
                    <img src="{{$campaign->cover->getPath('small')}}" class="img-responsive">
                    <p class="small">
                        {{$campaign->description_short}}
                    </p>
                    <p class="small font-bold">
                        <span><i class="fa fa-circle text-warning"></i> Priority {{$campaign->priority}}</span>
                    </p>
                    <div class="row">
                        <h5>Campaign tags</h5>
                        <ul class="tag-list" style="padding: 0">
                            <li><a href=""><i class="fa fa-tag"></i> Zender</a></li>
                            <li><a href=""><i class="fa fa-tag"></i> Lorem ipsum</a></li>
                            <li><a href=""><i class="fa fa-tag"></i> Passages</a></li>
                            <li><a href=""><i class="fa fa-tag"></i> Variations</a></li>
                        </ul>
                    </div>
                    <div class="row">
                        <h5>Campaign files</h5>
                        <ul class="list-unstyled project-files">
                            <li><a href=""><i class="fa fa-file"></i> Project_document.docx</a></li>
                            <li><a href=""><i class="fa fa-file-picture-o"></i> Logo_zender_company.jpg</a></li>
                            <li><a href=""><i class="fa fa-stack-exchange"></i> Email_from_Alex.mln</a></li>
                            <li><a href=""><i class="fa fa-file"></i> Contract_20_11_2014.docx</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

