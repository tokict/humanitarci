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
                                    </dl>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <dl class="dl-horizontal">
                                        <dt>Funds left:</dt>
                                        <dd>
                                            <div class="progress progress-striped active m-b-sm">
                                                <div style="width: {{$campaign->percent_done - ($campaign->getTakenFunds()/$campaign->current_funds*100)}}%;"
                                                     class="progress-bar progress-bar-success"></div>
                                            </div>
                                            <strong>{{number_format(($campaign->current_funds - $campaign->getTakenFunds())/100)}} {{env('CURRENCY')}}</strong>.

                                        </dd>
                                    </dl>
                                </div>
                            </div>
                            <div class="row m-t-sm">
                                <div class="col-lg-12">
                                    @if(is_array(\Illuminate\Support\Facades\Session::get('success')))
                                        <h4 class="text-success text-center">{{\Illuminate\Support\Facades\Session::get('success')[0]}}</h4>
                                    @else()
                                        <h4 class="text-success text-center">{{\Illuminate\Support\Facades\Session::get('success')}}</h4>
                                    @endif
                                    @if (count($errors) > 0)
                                        <div class="alert alert-danger">
                                            <ul>
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                        @if(session()->has('error'))
                                            <div class="alert alert-danger">
                                                <ul>
                                                    <li>{{session('error')}}</li>
                                                </ul>
                                            </div>
                                        @endif

                                    {!! Form::open(['url' => '/admin/campaign/take/'.$campaign->id, 'class' => 'form-horizontal']) !!}
                                    {{Form::token()}}
                                    {{Form::hidden('campaign_id', $campaign->id,['class' =>'form-control' ] )}}
                                    <div class="hr-line-dashed"></div>
                                    <div class="form-group">
                                        <div class="col-sm-2"><label class="control-label">Amount</label>
                                            {{Form::number('amount', null,['class' =>'form-control' ] )}}
                                        </div>
                                        <div class="col-sm-10"><label class="control-label">Description</label>
                                            {{Form::text('description', null,['class' =>'form-control' ] )}}
                                        </div>
                                    </div>
                                    <div class="hr-line-dashed"></div>
                                    <div class="form-group">
                                        <div class="col-sm-6">
                                            <label class="control-label">To legal entity</label>
                                            {{Form::select('receiving_entity_id', ["" => 'Select'], null, ['class' => 'form-control selectEntity'])}}
                                        </div>
                                        <div class="col-sm-4 pull-right">
                                            <label class="control-label"></label>
                                            <div class="i-checks"><label>
                                                    {{Form::checkbox('beneficiary_payment' )}}
                                                    <i></i> To beneficiary </label></div>
                                            <span class="help-block m-b-none">Is the money going directly to beneficiary?</span>
                                            <div class="i-checks"><label>
                                                    {{Form::checkbox('beneficiary_payment' )}}
                                                    <i></i> Expenses payment</label></div>
                                            <span class="help-block m-b-none">Is the money used to pay expenses?</span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-6">
                                            <label class="control-label">To person</label>
                                            {{Form::select('receiving_person_id', ["" => 'Select'], null, ['class' => 'form-control selectPerson'])}}
                                        </div>

                                    </div>
                                    <div class="hr-line-dashed"></div>
                                    <div class="form-group">
                                        <div class="col-sm-6">
                                            <label class="control-label">Action time</label>
                                            <div class="input-group date">
                                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                <input type="text" class="form-control datepicker"
                                                       name="action_date">
                                            </div>
                                            <div class="input-group clockpicker" data-autoclose="true">
                                                <input type="text" class="form-control" name="action_time">
                                                <span class="input-group-addon">
                                                    <span class="fa fa-clock-o"></span>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <label class="control-label">Receipts</label><br/>
                                            {{Form::hidden('receipt_ids')}}
                                            <button type="button" class=" btn btn-default fileSelect" data-toggle="modal" data-target="#fileModal">Select</button>
                                        </div>
                                    </div>
                                    {{Form::submit('Take', ['class' => 'btn btn-primary btn-lg'])}}
                                    {{Form::close()}}
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
                            <li><a href="{{$campaign->registration_request_doc->getPath('large')}}" target="_blank"><i
                                            class="fa fa-file"></i> Registration request</a></li>
                            <li><a href="{{$campaign->registration_doc->getPath('large')}}" target="_blank"><i
                                            class="fa fa-file"></i> Registration approval</a></li>
                            <li><a href="{{$campaign->action_plan_doc->getPath('large')}}" target="_blank"><i
                                            class="fa fa-file"></i> Action plan</a></li>
                            <li><a href="{{$campaign->distribution_plan_doc->getPath('large')}}" target="_blank"><i
                                            class="fa fa-file"></i> Distribution plan</a></li>
                            <li><a href="{{$campaign->beneficiary_request_doc->getPath('large')}}" target="_blank"><i
                                            class="fa fa-file"></i> Beneficiary request</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection