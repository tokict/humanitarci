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
                                               class="text-navy">{{$campaign->creator->person->first_name}} {{$campaign->creator->person->last_name}}</a>
                                        </dd>
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
                                        <dt>Classification:</dt>
                                        <dd>{{strtoupper($campaign->classification_code)}}</dd>
                                        <dt>Registration code:</dt>
                                        <dd>{{$campaign->registration_code}}</dd>
                                        <dt>Iban:</dt>
                                        <dd>{{$campaign->iban}}</dd>
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
                                            <strong>{{number_format($campaign->current_funds/100)}} {{env('CURRENCY')}}</strong>.

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
                                                    <li class=""><a href="#tab-3" data-toggle="tab">Actions</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>

                                        <div class="panel-body">

                                            <div class="tab-content">
                                                <div class="tab-pane" id="tab-1">
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <div class="ibox float-e-margins">
                                                                <div class="ibox-title">
                                                                    <h5>Breakdown of amounts donated</h5>
                                                                </div>
                                                                <div class="ibox-content">
                                                                    <div class="flot-chart">
                                                                        <div class="flot-chart-content"
                                                                             id="donations-amounts-chart"></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="ibox float-e-margins">
                                                                <div class="ibox-title">
                                                                    <h5>Donations in last 24hr</h5>
                                                                </div>
                                                                <div class="ibox-content">
                                                                    <div class="flot-chart">
                                                                        <div class="flot-chart-content"
                                                                             id="donations-today-chart"></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <div class="ibox float-e-margins">
                                                                <div class="ibox-title">
                                                                    <h5>Total donations </h5>
                                                                </div>
                                                                <div class="ibox-content">

                                                                    <div class="flot-chart">
                                                                        <div class="flot-chart-content"
                                                                             id="donations-total-chart"></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="tab-pane" id="tab-2">
                                                    <div class="feed-activity-list">
                                                        @foreach($campaign->getReceivedDonations() as $d)
                                                            <div class="feed-element">

                                                                <div class="media-body ">
                                                                    <small class="pull-right">{{$d->created_at->diffForHumans()}}</small>
                                                                    <a href="/admin/donor/view/{{$d->donor->id}}"><strong>{{$d->donor->user->username}}</strong></a>
                                                                    donated
                                                                    <a href="/admin/donation/view/{{$d->id}}">
                                                                        <strong> {{number_format($d->amount/100)}} {{env('CURRENCY')}}</strong></a>
                                                                    <br>
                                                                    <small class="text-muted">{{$d->created_at}}
                                                                    </small>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                                <div class="tab-pane active" id="tab-3">
                                                    <div class="feed-activity-list">
                                                        <div class="col-lg-3">
                                                            <label>Use collected funds</label>
                                                            <a href="/admin/campaign/take/{{$campaign->id}}" class="btn btn-primary btn-block">Take</a>
                                                        </div>
                                                        <div class="col-lg-3">
                                                            <label> Finalize campaign</label>
                                                            <a href="/admin/campaign/finalize/{{$campaign->id}}" class="btn btn-warning btn-block">Finalize
                                                            </a>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <label> Move available funds to next campaign</label>
                                                            <button class="btn btn-primary btn-block disabled">Move (3 days remaining)
                                                            </button>
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
            </div>
            <div class="col-lg-3">
                <div class="wrapper wrapper-content project-manager">
                    <h4>Campaign description</h4>
                    <img src="{{$campaign->cover->getPath('small')}}" class="img-responsive">
                    <p class="small">
                        {!!$campaign->description_short!!}
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
                            <li><a href="{{$campaign->registration_doc->getPath()}}" target="_blank"><i class="fa fa-file"></i> Registration approval</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <script type="text/javascript">
        $(document).ready(function () {
            var amountOptions = {
                series: {
                    bars: {
                        show: true,
                        barWidth: 0.6,
                        fill: true,
                        fillColor: {
                            colors: [{
                                opacity: 0.8
                            }, {
                                opacity: 0.8
                            }]
                        }
                    }
                },
                xaxis: {
                    tickDecimals: 1,
                    mode: "categories",
                },
                colors: ["#1ab394"],
                grid: {
                    color: "#999999",
                    hoverable: true,
                    clickable: true,
                    tickColor: "#D4D4D4",
                    borderWidth: 0
                },
                legend: {
                    show: false
                },
                tooltip: true,
                tooltipOpts: {
                    content: function (label, xval, yval) {
                        return xval + ' : ' + yval;

                    },
                }
            };
            var amountData = {
                label: "bar",
                data: {!!$campaign->getGraphAmountsData()!!}

            };
            $.plot($("#donations-amounts-chart"), [amountData], amountOptions);

            var donationsTodayOptions = {
                series: {
                    lines: {
                        show: true,
                        lineWidth: 2,
                        fill: true,
                        fillColor: {
                            colors: [{
                                opacity: 0.0
                            }, {
                                opacity: 0.0
                            }]
                        }
                    }
                },
                xaxis: {
                    tickDecimals: 0,
                    mode: "categories",
                },
                colors: ["#1ab394"],
                grid: {
                    color: "#999999",
                    hoverable: true,
                    clickable: true,
                    tickColor: "#D4D4D4",
                    borderWidth: 0
                },
                legend: {
                    show: false
                },
                tooltip: true,
                tooltipOpts: {
                    content: function (label, xval, yval) {
                        return xval + 'h : ' + yval;

                    },
                }
            };
            var donationsTodayData = {

                data: {!!$campaign->getGraphDonationsTodayData()!!}
            };
            $.plot($("#donations-today-chart"), [donationsTodayData], donationsTodayOptions);


            var donationsTotalOptions = {
                series: {
                    lines: {
                        show: true,
                        lineWidth: 2,
                        fill: true,
                        fillColor: {
                            colors: [{
                                opacity: 0.0
                            }, {
                                opacity: 0.0
                            }]
                        }
                    }
                },
                xaxis: {
                    tickDecimals: 0,
                    mode: "categories",
                },
                colors: ["#1ab394"],
                grid: {
                    color: "#999999",
                    hoverable: true,
                    clickable: true,
                    tickColor: "#D4D4D4",
                    borderWidth: 0
                },
                legend: {
                    show: false
                },
                tooltip: true,
                tooltipOpts: {
                    content: function (label, xval, yval) {
                        return xval + ' : ' + yval;

                    },
                }
            };
            var donationsTotalData = {

                data: {!!$campaign->getGraphDonationsTotalData()!!}
            };
            $.plot($("#donations-total-chart"), [donationsTotalData], donationsTotalOptions);
        })

    </script>

@endsection